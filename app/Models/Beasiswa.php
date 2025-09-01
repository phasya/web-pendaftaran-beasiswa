<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\Pendaftar;

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
        'jumlah_dana' => 'decimal:0'
    ];

    // Mutator untuk memastikan dokumen_pendukung selalu berupa array
    public function setDokumenPendukungAttribute($value)
    {
        // Jika sudah array, langsung assign
        if (is_array($value)) {
            $this->attributes['dokumen_pendukung'] = json_encode(array_values($value));
        } 
        // Jika string JSON, decode dulu lalu encode ulang untuk memastikan format
        elseif (is_string($value) && $this->isJson($value)) {
            $decoded = json_decode($value, true);
            $this->attributes['dokumen_pendukung'] = json_encode(array_values($decoded));
        } 
        // Jika string biasa, buat array
        elseif (is_string($value)) {
            $this->attributes['dokumen_pendukung'] = json_encode([$value]);
        }
        // Default ke empty array
        else {
            $this->attributes['dokumen_pendukung'] = json_encode([]);
        }
    }

    // Helper function untuk cek apakah string adalah valid JSON
    private function isJson($string)
    {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }

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

        if (!$this->dokumen_pendukung || !is_array($this->dokumen_pendukung)) {
            return [];
        }

        $labels = [];
        foreach ($this->dokumen_pendukung as $dokumen) {
            $labels[] = $dokumenMap[$dokumen] ?? ucwords(str_replace('-', ' ', $dokumen));
        }

        return $labels;
    }

    // Method untuk mendapatkan dokumen map (untuk controller)
    public static function getDokumenMap()
    {
        return [
            'surat-aktif' => 'Surat Keterangan Aktif Kuliah',
            'transkrip' => 'Transkrip Nilai',
            'rekomendasi' => 'Surat Rekomendasi',
            'ktp' => 'KTP/Identitas',
            'kk' => 'Kartu Keluarga',
            'surat-keterangan-tidak-mampu' => 'Surat Keterangan Tidak Mampu',
            'sertifikat-prestasi' => 'Sertifikat Prestasi'
        ];
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

    // Method untuk mendapatkan status label dengan warna
    public function getStatusLabelAttribute()
    {
        $statusMap = [
            'aktif' => ['label' => 'Aktif', 'class' => 'badge bg-success'],
            'nonaktif' => ['label' => 'Non-aktif', 'class' => 'badge bg-danger'],
            'draft' => ['label' => 'Draft', 'class' => 'badge bg-warning text-dark']
        ];

        return $statusMap[$this->status] ?? ['label' => 'Unknown', 'class' => 'badge bg-secondary'];
    }

    // Method untuk format jumlah dana
    public function getJumlahDanaFormattedAttribute()
    {
        return 'Rp ' . number_format($this->jumlah_dana, 0, ',', '.');
    }

    // Method untuk mendapatkan periode pendaftaran
    public function getPeriodePendaftaranAttribute()
    {
        return $this->tanggal_buka->format('d/m/Y') . ' - ' . $this->tanggal_tutup->format('d/m/Y');
    }

    // Relationship dengan pendaftar
    public function pendaftar()
    {
        return $this->hasMany(Pendaftar::class);
    }

    // Method untuk cek status aktif
    public function isActive()
    {
        return $this->status === 'aktif';
    }

    // Scope untuk filter berdasarkan status
    public function scopeActive($query)
    {
        return $query->where('status', 'aktif');
    }

    public function scopeOpen($query)
    {
        return $query->where('status', 'aktif')
                    ->where('tanggal_buka', '<=', Carbon::now())
                    ->where('tanggal_tutup', '>=', Carbon::now());
    }

    // Boot method untuk logging perubahan
    protected static function boot()
    {
        parent::boot();
        
        static::saving(function ($model) {
            \Log::info('Saving beasiswa with dokumen_pendukung: ', [
                'id' => $model->id,
                'dokumen_pendukung_raw' => $model->attributes['dokumen_pendukung'] ?? null,
                'dokumen_pendukung_array' => $model->dokumen_pendukung
            ]);
        });

        static::saved(function ($model) {
            \Log::info('Saved beasiswa with dokumen_pendukung: ', [
                'id' => $model->id,
                'dokumen_pendukung_raw' => $model->attributes['dokumen_pendukung'] ?? null,
                'dokumen_pendukung_array' => $model->dokumen_pendukung
            ]);
        });
    }}