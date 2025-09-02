<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftar extends Model
{
    use HasFactory;

    // Hapus baris ini atau ubah ke 'pendaftars'
    // protected $table = 'pendaftar';
    protected $table = 'pendaftars'; // Gunakan nama tabel yang konsisten

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
        'keterangan',
        'tanggal_verifikasi',
        'verified_by',
        'verified_by_id'
    ];

    protected $casts = [
        'tanggal_daftar' => 'datetime',
        'tanggal_verifikasi' => 'datetime',
    ];

    // Relasi dengan beasiswa
    public function beasiswa()
    {
        return $this->belongsTo(Beasiswa::class);
    }

    // Status options
    public function getStatusOptions()
    {
        return [
            'pending' => 'Pending',
            'diterima' => 'Diterima', 
            'ditolak' => 'Ditolak'
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
        return $this->tanggal_daftar ? $this->tanggal_daftar->format('d/m/Y H:i') : '';
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
}   