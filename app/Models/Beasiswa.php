<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beasiswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_beasiswa',
        'deskripsi',
        'jumlah_dana',
        'tanggal_buka',
        'tanggal_tutup',
        'status',
        'persyaratan'
    ];

    protected $dates = [
        'tanggal_buka',
        'tanggal_tutup'
    ];

    public function pendaftars()
    {
        return $this->hasMany(Pendaftar::class);
    }

    public function isActive()
    {
        return $this->status === 'aktif' && 
               now()->between($this->tanggal_buka, $this->tanggal_tutup);
    }

/**
 * Relationship dengan file types yang diperlukan untuk beasiswa ini
 */
public function fileRequirements()
{
    return $this->belongsToMany(FileType::class, 'beasiswa_file_requirements')
                ->withPivot('wajib', 'catatan')
                ->withTimestamps()
                ->orderBy('urutan');
}

/**
 * Relationship dengan file types aktif yang diperlukan
 */
public function activeFileRequirements()
{
    return $this->fileRequirements()->where('file_types.aktif', true);
}

/**
 * Relationship dengan file types wajib
 */
public function requiredFileRequirements()
{
    return $this->fileRequirements()
                ->wherePivot('wajib', true)
                ->where('file_types.aktif', true);
}

/**
 * Method untuk mendapatkan semua file uploads untuk beasiswa ini
 */
public function getAllFileUploads()
{
    return FileUpload::whereHas('pendaftar', function($query) {
        $query->where('beasiswa_id', $this->id);
    });
}

/**
 * Method untuk menambah file requirement ke beasiswa
 */
public function addFileRequirement($fileTypeId, $wajib = true, $catatan = null)
{
    return $this->fileRequirements()->attach($fileTypeId, [
        'wajib' => $wajib,
        'catatan' => $catatan
    ]);
}

/**
 * Method untuk update file requirement
 */
public function updateFileRequirement($fileTypeId, $wajib = null, $catatan = null)
{
    $data = [];
    if ($wajib !== null) $data['wajib'] = $wajib;
    if ($catatan !== null) $data['catatan'] = $catatan;
    
    return $this->fileRequirements()->updateExistingPivot($fileTypeId, $data);
}

/**
 * Method untuk remove file requirement
 */
public function removeFileRequirement($fileTypeId)
{
    return $this->fileRequirements()->detach($fileTypeId);
}

/**
 * Method untuk check apakah beasiswa ini memiliki file requirements
 */
public function hasFileRequirements()
{
    return $this->fileRequirements()->count() > 0;
}
}