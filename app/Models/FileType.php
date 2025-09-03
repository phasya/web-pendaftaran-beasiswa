<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileType extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_file_type',
        'deskripsi',
        'ekstensi_diizinkan',
        'ukuran_maksimal',
        'wajib',
        'aktif',
        'urutan'
    ];

    protected $casts = [
        'wajib' => 'boolean',
        'aktif' => 'boolean',
        'ukuran_maksimal' => 'integer',
        'urutan' => 'integer'
    ];

    // Accessor untuk mendapatkan array ekstensi
    public function getEkstensiArrayAttribute()
    {
        return explode(',', $this->ekstensi_diizinkan);
    }

    // Accessor untuk ukuran dalam MB
    public function getUkuranMbAttribute()
    {
        return round($this->ukuran_maksimal / 1024, 2);
    }

    // Relationship dengan beasiswa melalui pivot
    public function beasiswas()
    {
        return $this->belongsToMany(Beasiswa::class, 'beasiswa_file_requirements')
                    ->withPivot('wajib', 'catatan')
                    ->withTimestamps();
    }

    // Relationship dengan file uploads
    public function fileUploads()
    {
        return $this->hasMany(FileUpload::class);
    }

    // Scope untuk file aktif
    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }

    // Scope untuk ordering
    public function scopeOrdered($query)
    {
        return $query->orderBy('urutan')->orderBy('nama_file_type');
    }

    // Method untuk validasi ekstensi file
    public function isValidExtension($extension)
    {
        return in_array(strtolower($extension), $this->ekstensi_array);
    }

    // Method untuk validasi ukuran file
    public function isValidSize($sizeInBytes)
    {
        $sizeInKb = $sizeInBytes / 1024;
        return $sizeInKb <= $this->ukuran_maksimal;
    }
}