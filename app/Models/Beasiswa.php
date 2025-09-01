<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Beasiswa extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'nama_beasiswa',
        'deskripsi',
        'jumlah_dana',
        'tanggal_buka',
        'tanggal_tutup',
        'status',
        'persyaratan',
        'dokumen_pendukung',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'tanggal_buka' => 'date',
        'tanggal_tutup' => 'date',
        'jumlah_dana' => 'decimal:2',
        'dokumen_pendukung' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        // Auto-update status berdasarkan tanggal
        static::saving(function ($beasiswa) {
            // Jika tanggal tutup sudah lewat, set status ke nonaktif
            if ($beasiswa->tanggal_tutup && Carbon::parse($beasiswa->tanggal_tutup)->isPast()) {
                if ($beasiswa->status === 'aktif') {
                    $beasiswa->status = 'nonaktif';
                }
            }
        });
    }

    /**
     * Relationship dengan Pendaftar
     */
    public function pendaftar()
    {
        return $this->hasMany(Pendaftar::class);
    }

    /**
     * Scope untuk beasiswa aktif
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'aktif')
                    ->where('tanggal_buka', '<=', now())
                    ->where('tanggal_tutup', '>=', now());
    }

    /**
     * Scope untuk beasiswa yang akan datang
     */
    public function scopeUpcoming($query)
    {
        return $query->where('status', 'aktif')
                    ->where('tanggal_buka', '>', now());
    }

    /**
     * Scope untuk beasiswa yang sudah expired
     */
    public function scopeExpired($query)
    {
        return $query->where('tanggal_tutup', '<', now());
    }

    /**
     * Cek apakah beasiswa masih aktif dan dapat didaftar
     */
    public function isActive()
    {
        return $this->status === 'aktif' 
            && Carbon::parse($this->tanggal_buka)->isPast() 
            && Carbon::parse($this->tanggal_tutup)->isFuture();
    }

    /**
     * Cek apakah beasiswa akan segera dibuka
     */
    public function isUpcoming()
    {
        return $this->status === 'aktif' 
            && Carbon::parse($this->tanggal_buka)->isFuture();
    }

    /**
     * Cek apakah beasiswa sudah expired
     */
    public function isExpired()
    {
        return Carbon::parse($this->tanggal_tutup)->isPast();
    }

    /**
     * Get status badge class untuk UI
     */
    public function getStatusBadgeClassAttribute()
    {
        if ($this->isExpired()) {
            return 'badge-secondary';
        }
        
        switch ($this->status) {
            case 'aktif':
                return $this->isActive() ? 'badge-success' : 'badge-warning';
            case 'nonaktif':
                return 'badge-danger';
            default:
                return 'badge-secondary';
        }
    }

    /**
     * Get status text untuk UI
     */
    public function getStatusTextAttribute()
    {
        if ($this->isExpired()) {
            return 'Expired';
        }
        
        if ($this->status === 'aktif') {
            if ($this->isUpcoming()) {
                return 'Akan Dibuka';
            }
            return $this->isActive() ? 'Aktif' : 'Tidak Aktif';
        }
        
        return ucfirst($this->status);
    }

    /**
     * Get formatted jumlah dana
     */
    public function getFormattedJumlahDanaAttribute()
    {
        return 'Rp ' . number_format($this->jumlah_dana, 0, ',', '.');
    }

    /**
     * Get dokumen pendukung dengan label
     */
    public function getDokumenPendukungLabelAttribute()
    {
        if (!$this->dokumen_pendukung) {
            return [];
        }

        $labels = [
            'ktp' => 'KTP',
            'kk' => 'Kartu Keluarga',
            'ijazah' => 'Ijazah Terakhir',
            'transkrip' => 'Transkrip Nilai',
            'surat_keterangan_tidak_mampu' => 'Surat Keterangan Tidak Mampu',
            'slip_gaji_ortu' => 'Slip Gaji Orang Tua',
            'surat_rekomendasi' => 'Surat Rekomendasi',
            'sertifikat_prestasi' => 'Sertifikat Prestasi'
        ];

        $result = [];
        foreach ($this->dokumen_pendukung as $dokumen) {
            if (isset($labels[$dokumen])) {
                $result[] = $labels[$dokumen];
            }
        }

        return $result;
    }

    /**
     * Get sisa hari pendaftaran
     */
    public function getSisaHariAttribute()
    {
        if ($this->isExpired()) {
            return 0;
        }

        if ($this->isUpcoming()) {
            return Carbon::parse($this->tanggal_buka)->diffInDays(now());
        }

        return Carbon::parse($this->tanggal_tutup)->diffInDays(now());
    }

    /**
     * Get total pendaftar
     */
    public function getTotalPendaftarAttribute()
    {
        return $this->pendaftar()->count();
    }

    /**
     * Get pendaftar diterima
     */
    public function getPendaftarDiterimaAttribute()
    {
        return $this->pendaftar()->where('status', 'diterima')->count();
    }

    /**
     * Get pendaftar ditolak
     */
    public function getPendaftarDitolakAttribute()
    {
        return $this->pendaftar()->where('status', 'ditolak')->count();
    }

    /**
     * Get pendaftar pending
     */
    public function getPendaftarPendingAttribute()
    {
        return $this->pendaftar()->where('status', 'pending')->count();
    }

    /**
     * Get persentase keberhasilan
     */
    public function getPersentaseKeberhasilanAttribute()
    {
        $total = $this->total_pendaftar;
        if ($total == 0) {
            return 0;
        }

        $diterima = $this->pendaftar_diterima;
        return round(($diterima / $total) * 100, 1);
    }

    /**
     * Search scope
     */
    public function scopeSearch($query, $keyword)
    {
        return $query->where(function($q) use ($keyword) {
            $q->where('nama_beasiswa', 'like', "%{$keyword}%")
              ->orWhere('deskripsi', 'like', "%{$keyword}%")
              ->orWhere('persyaratan', 'like', "%{$keyword}%");
        });
    }

    /**
     * Filter by status scope
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Filter by date range scope
     */
    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    /**
     * Order by latest
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Order by nama
     */
    public function scopeOrderByNama($query, $direction = 'asc')
    {
        return $query->orderBy('nama_beasiswa', $direction);
    }

    /**
     * Order by jumlah dana
     */
    public function scopeOrderByDana($query, $direction = 'desc')
    {
        return $query->orderBy('jumlah_dana', $direction);
    }

    /**
     * Validasi sebelum delete
     */
    public function canBeDeleted()
    {
        // Tidak bisa dihapus jika ada pendaftar dengan status diterima
        return !$this->pendaftar()->where('status', 'diterima')->exists();
    }

    /**
     * Get warning message for deletion
     */
    public function getDeletionWarning()
    {
        $pendaftarCount = $this->pendaftar()->count();
        $diterimaCount = $this->pendaftar()->where('status', 'diterima')->count();

        if ($diterimaCount > 0) {
            return "Beasiswa ini memiliki {$diterimaCount} pendaftar yang sudah diterima dan tidak dapat dihapus.";
        }

        if ($pendaftarCount > 0) {
            return "Menghapus beasiswa ini akan menghapus {$pendaftarCount} data pendaftar. Apakah Anda yakin?";
        }

        return null;
    }

    /**
     * Format tanggal untuk display
     */
    public function getFormattedTanggalBukaAttribute()
    {
        return Carbon::parse($this->tanggal_buka)->format('d M Y');
    }

    /**
     * Format tanggal tutup untuk display
     */
    public function getFormattedTanggalTutupAttribute()
    {
        return Carbon::parse($this->tanggal_tutup)->format('d M Y');
    }

    /**
     * Get periode pendaftaran
     */
    public function getPeriodePendaftaranAttribute()
    {
        return $this->formatted_tanggal_buka . ' - ' . $this->formatted_tanggal_tutup;
    }

    /**
     * Auto-generate slug dari nama beasiswa
     */
    public function getSlugAttribute()
    {
        return \Str::slug($this->nama_beasiswa);
    }

    /**
     * Cek apakah beasiswa baru (dibuat dalam 7 hari terakhir)
     */
    public function isNew()
    {
        return $this->created_at->diffInDays(now()) <= 7;
    }

    /**
     * Cek apakah beasiswa populer (memiliki banyak pendaftar)
     */
    public function isPopular()
    {
        return $this->total_pendaftar >= 10; // Threshold bisa disesuaikan
    }

    /**
     * Get dokumen wajib yang belum diupload oleh pendaftar
     */
    public function getMissingDocuments($pendaftar)
    {
        $requiredDocs = $this->dokumen_pendukung ?? [];
        $uploadedDocs = [];

        // Check which documents are uploaded
        foreach (['ktp', 'kk', 'transkrip'] as $doc) {
            $fieldName = 'file_' . $doc;
            if ($pendaftar->$fieldName) {
                $uploadedDocs[] = $doc;
            }
        }

        return array_diff($requiredDocs, $uploadedDocs);
    }
}