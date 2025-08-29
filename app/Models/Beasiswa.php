<?php

// Update untuk Model Beasiswa
// File: app/Models/Beasiswa.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Beasiswa extends Model
{
    use HasFactory;

    protected $table = 'beasiswa';
    
    protected $fillable = [
        'nama_beasiswa',
        'deskripsi',
        'jumlah_dana',
        'tanggal_buka',
        'tanggal_tutup',
        'status',
        'persyaratan',
        'dokumen_pendukung'
    ];

    protected $casts = [
        'tanggal_buka' => 'date',
        'tanggal_tutup' => 'date',
        'dokumen_pendukung' => 'array', // Cast ke array otomatis
    ];

    // Accessor untuk mendapatkan dokumen pendukung dengan label yang readable
    public function getDokumenPendukungLabelAttribute()
    {
        $dokumenMap = [
            'surat-aktif' => 'Surat Keterangan Aktif Kuliah',
            'transkrip' => 'Transkrip Nilai', 
            'rekomendasi' => 'Surat Rekomendasi',
            'ktp' => 'KTP/Identitas',
            'kk' => 'Kartu Keluarga',
            'surat-keterangan-tidak-mampu' => 'Surat Keterangan Tidak Mampu',
            'sertifikat-prestasi' => 'Sertifikat Prestasi',
        ];

        if (!$this->dokumen_pendukung) {
            return [];
        }

        $labels = [];
        foreach ($this->dokumen_pendukung as $dokumen) {
            $labels[] = $dokumenMap[$dokumen] ?? ucwords(str_replace('-', ' ', $dokumen));
        }

        return $labels;
    }

    // Method untuk cek apakah beasiswa masih aktif untuk pendaftaran
    public function isOpenForRegistration()
    {
        return $this->status === 'aktif' && 
               Carbon::now()->between($this->tanggal_buka, $this->tanggal_tutup);
    }

    // Method untuk menghitung sisa hari pendaftaran
    public function getDaysRemaining()
    {
        if (!$this->isOpenForRegistration()) {
            return 0;
        }
        
        return Carbon::now()->diffInDays($this->tanggal_tutup, false);
    }

    // Relationship dengan pendaftar
    public function pendaftar()
    {
        return $this->hasMany(Pendaftar::class);
    }
}