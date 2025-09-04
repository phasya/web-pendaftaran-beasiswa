<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class FileUpload extends Model
{
    use HasFactory;

    protected $fillable = [
        'pendaftar_id',
        'file_type_id',
        'nama_file_asli',
        'nama_file_sistem',
        'path_file',
        'ekstensi',
        'ukuran',
        'status_verifikasi',
        'catatan_verifikasi',
        'verified_at',
        'verified_by'
    ];

    protected $casts = [
        'ukuran' => 'integer',
        'verified_at' => 'datetime'
    ];

    // Relationship dengan pendaftar
    public function pendaftar()
    {
        return $this->belongsTo(Pendaftar::class);
    }

    // Relationship dengan file type
    public function fileType()
    {
        return $this->belongsTo(FileType::class);
    }

    // Relationship dengan user yang memverifikasi
    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    // Accessor untuk URL file
    public function getFileUrlAttribute()
    {
        return Storage::url($this->path_file);
    }

    // Accessor untuk ukuran dalam format human readable
    public function getUkuranFormattedAttribute()
    {
        $bytes = $this->ukuran;
        
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }

    // Accessor untuk status badge class
    public function getStatusBadgeClassAttribute()
    {
        return match($this->status_verifikasi) {
            'approved' => 'bg-success',
            'rejected' => 'bg-danger',
            default => 'bg-warning'
        };
    }

    // Accessor untuk status text
    public function getStatusTextAttribute()
    {
        return match($this->status_verifikasi) {
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            default => 'Menunggu Verifikasi'
        };
    }

    // Method untuk approval
    public function approve($userId, $catatan = null)
    {
        $this->update([
            'status_verifikasi' => 'approved',
            'verified_by' => $userId,
            'verified_at' => now(),
            'catatan_verifikasi' => $catatan
        ]);
    }

    // Method untuk rejection
    public function reject($userId, $catatan = null)
    {
        $this->update([
            'status_verifikasi' => 'rejected',
            'verified_by' => $userId,
            'verified_at' => now(),
            'catatan_verifikasi' => $catatan
        ]);
    }

    // Method untuk delete file dari storage
    public function deleteFile()
    {
        if (Storage::exists($this->path_file)) {
            Storage::delete($this->path_file);
        }
    }

    // Event ketika model dihapus
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($fileUpload) {
            $fileUpload->deleteFile();
        });
    }
}