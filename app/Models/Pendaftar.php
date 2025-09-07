<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftar extends Model
{
    use HasFactory;

    protected $table = 'pendaftar';

    protected $fillable = [
        'beasiswa_id',
        'nama_lengkap',
        'email',
        'no_telepon',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'pendidikan_terakhir',
        'nama_institusi',
        'jurusan',
        'ipk',
        'tahun_lulus',
        'pekerjaan',
        'penghasilan',
        'alasan_mendaftar',
        'dokumen_pendukung',
        'status',
        'tanggal_daftar',
        'keterangan'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_daftar' => 'datetime',
        'ipk' => 'decimal:2',
        'penghasilan' => 'decimal:2',
        'dokumen_pendukung' => 'array'
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
    public function getMemorPendaftaranAttribute()
    {
        return 'REG-' . $this->beasiswa_id . '-' . str_pad($this->id, 6, '0', STR_PAD_LEFT);
    }

    // Get formatted tanggal daftar
    public function getFormattedTanggalDaftarAttribute()
    {
        return $this->tanggal_daftar->format('d/m/Y H:i');
    }

    // Get jenis kelamin text
    public function getJenisKelaminTextAttribute()
    {
        return $this->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan';
    }

    // Get formatted IPK
    public function getFormattedIpkAttribute()
    {
        return number_format($this->ipk, 2, ',', '.');
    }

    // Get formatted penghasilan
    public function getFormattedPenghasilanAttribute()
    {
        return 'Rp ' . number_format($this->penghasilan, 0, ',', '.');
    }

    // Get age from tanggal_lahir
    public function getUmurAttribute()
    {
        return $this->tanggal_lahir->age ?? 0;
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