<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pendaftar extends Model
{
    use HasFactory, SoftDeletes;

    // Hapus protected $table karena Laravel akan otomatis gunakan 'pendaftars'
    // protected $table = 'pendaftars';

    protected $fillable = [
        'beasiswa_id',
        'nama_lengkap',
        'nim',
        'email',
        'no_hp',
        'alasan_mendaftar',
        'file_transkrip',
        'file_ktp',
        'file_kk',
        'status',
        'tanggal_daftar',
        'keterangan'
    ];

    protected $casts = [
        'tanggal_daftar' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Relasi dengan beasiswa
    public function beasiswa()
    {
        return $this->belongsTo(Beasiswa::class, 'beasiswa_id');
    }

    // Status options
    public function getStatusOptions()
    {
        return [
            'pending' => 'Pending',
            'diterima' => 'Diterima', 
            'ditolak' => 'Ditolak',
            'dibatalkan' => 'Dibatalkan'
        ];
    }

    // Get status badge class
    public function getStatusBadgeClassAttribute()
    {
        switch ($this->status) {
            case 'diterima':
                return 'bg-success';
            case 'ditolak':
                return 'bg-danger';
            case 'dibatalkan':
                return 'bg-secondary';
            case 'pending':
            default:
                return 'bg-warning';
        }
    }

    // Get status text
    public function getStatusTextAttribute()
    {
        switch ($this->status) {
            case 'diterima':
                return 'Diterima';
            case 'ditolak':
                return 'Ditolak';
            case 'dibatalkan':
                return 'Dibatalkan';
            case 'pending':
            default:
                return 'Pending';
        }
    }

    // Get formatted registration number
    public function getNomorPendaftaranAttribute()
    {
        return 'REG-' . $this->beasiswa_id . '-' . str_pad($this->id, 6, '0', STR_PAD_LEFT);
    }

    // Get formatted tanggal daftar
    public function getFormattedTanggalDaftarAttribute()
    {
        return $this->tanggal_daftar ? $this->tanggal_daftar->format('d/m/Y H:i') : $this->created_at->format('d/m/Y H:i');
    }

    // Check if can be deleted
    public function canBeDeleted()
    {
        return $this->status === 'pending';
    }

    // Scope untuk filter berdasarkan status
    public function scopeWithStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Scope untuk filter berdasarkan beasiswa
    public function scopeForBeasiswa($query, $beasiswaId)
    {
        return $query->where('beasiswa_id', $beasiswaId);
    }

    // Scope untuk pendaftar terbaru
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    // Scope untuk search
    public function scopeSearch($query, $keyword)
    {
        return $query->where(function($q) use ($keyword) {
            $q->where('nama_lengkap', 'like', "%{$keyword}%")
              ->orWhere('nim', 'like', "%{$keyword}%")
              ->orWhere('email', 'like', "%{$keyword}%")
              ->orWhere('no_hp', 'like', "%{$keyword}%");
        });
    }

    // Boot method untuk auto-set tanggal_daftar
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($pendaftar) {
            if (!$pendaftar->tanggal_daftar) {
                $pendaftar->tanggal_daftar = now();
            }
        });
    }
}