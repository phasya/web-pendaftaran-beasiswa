<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftar extends Model
{
    use HasFactory;

    protected $table = 'pendaftar'; // pastikan sama dengan nama tabel di DB

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
        'status'
    ];

    // Relasi ke Beasiswa
    public function beasiswa()
    {
        return $this->belongsTo(Beasiswa::class);
    }
}
