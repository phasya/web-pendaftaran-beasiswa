<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Beasiswa;
use App\Models\Pendaftar;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Exception;

class BeasiswaController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Beasiswa::query();

            // Search functionality
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('nama_beasiswa', 'like', "%{$search}%")
                      ->orWhere('deskripsi', 'like', "%{$search}%");
                });
            }

            // Filter by status
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            // Sort functionality
            $sortBy = $request->get('sort', 'created_at');
            $sortOrder = $request->get('order', 'desc');
            
            if (in_array($sortBy, ['nama_beasiswa', 'jumlah_dana', 'tanggal_buka', 'tanggal_tutup', 'status', 'created_at'])) {
                $query->orderBy($sortBy, $sortOrder);
            }

            $beasiswas = $query->withCount('pendaftar')->paginate(10);
            $aktifCount = Beasiswa::where('status', 'aktif')->count();
            $totalPendaftar = Pendaftar::count();

            return view('admin.beasiswa.index', compact('beasiswas', 'aktifCount', 'totalPendaftar'));
        } catch (Exception $e) {
            return back()->with('error', 'Gagal memuat data beasiswa: ' . $e->getMessage());
        }
    }

    public function create()
    {
        $dokumenOptions = [
            'ktp' => 'KTP',
            'kk' => 'Kartu Keluarga', 
            'ijazah' => 'Ijazah Terakhir',
            'transkrip' => 'Transkrip Nilai',
            'surat_keterangan_tidak_mampu' => 'Surat Keterangan Tidak Mampu',
            'slip_gaji_ortu' => 'Slip Gaji Orang Tua',
            'surat_rekomendasi' => 'Surat Rekomendasi',
            'sertifikat_prestasi' => 'Sertifikat Prestasi'
        ];

        return view('admin.beasiswa.create', compact('dokumenOptions'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nama_beasiswa' => 'required|string|max:255|unique:beasiswas,nama_beasiswa',
                'deskripsi' => 'required|string|min:10',
                'jumlah_dana' => 'required|numeric|min:100000|max:999999999',
                'tanggal_buka' => 'required|date|after_or_equal:today',
                'tanggal_tutup' => 'required|date|after:tanggal_buka',
                'status' => 'required|in:aktif,nonaktif',
                'persyaratan' => 'required|string|min:10',
                'dokumen_pendukung' => 'nullable|array|max:8',
                'dokumen_pendukung.*' => 'string|in:ktp,kk,ijazah,transkrip,surat_keterangan_tidak_mampu,slip_gaji_ortu,surat_rekomendasi,sertifikat_prestasi',
            ], [
                'nama_beasiswa.required' => 'Nama beasiswa wajib diisi',
                'nama_beasiswa.unique' => 'Nama beasiswa sudah ada, gunakan nama lain',
                'deskripsi.required' => 'Deskripsi beasiswa wajib diisi',
                'deskripsi.min' => 'Deskripsi minimal 10 karakter',
                'jumlah_dana.required' => 'Jumlah dana wajib diisi',
                'jumlah_dana.min' => 'Jumlah dana minimal Rp 100.000',
                'jumlah_dana.max' => 'Jumlah dana terlalu besar',
                'tanggal_buka.required' => 'Tanggal buka pendaftaran wajib diisi',
                'tanggal_buka.after_or_equal' => 'Tanggal buka tidak boleh kurang dari hari ini',
                'tanggal_tutup.required' => 'Tanggal tutup pendaftaran wajib diisi',
                'tanggal_tutup.after' => 'Tanggal tutup harus setelah tanggal buka',
                'persyaratan.required' => 'Persyaratan beasiswa wajib diisi',
                'persyaratan.min' => 'Persyaratan minimal 10 karakter',
            ]);

            DB::beginTransaction();

            // Simpan data
            Beasiswa::create([
                'nama_beasiswa' => $validated['nama_beasiswa'],
                'deskripsi' => $validated['deskripsi'],
                'jumlah_dana' => $validated['jumlah_dana'],
                'tanggal_buka' => $validated['tanggal_buka'],
                'tanggal_tutup' => $validated['tanggal_tutup'],
                'status' => $validated['status'],
                'persyaratan' => $validated['persyaratan'],
                'dokumen_pendukung' => json_encode($request->input('dokumen_pendukung', [])),
            ]);

            DB::commit();

            return redirect()->route('admin.beasiswa.index')
                             ->with('success', 'Beasiswa "' . $validated['nama_beasiswa'] . '" berhasil ditambahkan!');
        } catch (Exception $e) {
            DB::rollback();
            return back()->withInput()
                         ->with('error', 'Gagal menambahkan beasiswa: ' . $e->getMessage());
        }
    }

    public function show(Beasiswa $beasiswa)
    {
        try {
            // Load pendaftar dengan paginasi
            $pendaftars = $beasiswa->pendaftar()
                                   ->latest()
                                   ->paginate(10);

            // Hitung statistik
            $stats = [
                'total_pendaftar' => $beasiswa->pendaftar()->count(),
                'pending' => $beasiswa->pendaftar()->where('status', 'pending')->count(),
                'diterima' => $beasiswa->pendaftar()->where('status', 'diterima')->count(),
                'ditolak' => $beasiswa->pendaftar()->where('status', 'ditolak')->count(),
            ];

            return view('admin.beasiswa.show', compact('beasiswa', 'pendaftars', 'stats'));
        } catch (Exception $e) {
            return back()->with('error', 'Gagal memuat detail beasiswa: ' . $e->getMessage());
        }
    }

    public function edit(Beasiswa $beasiswa)
    {
        try {
            $dokumenOptions = [
                'ktp' => 'KTP',
                'kk' => 'Kartu Keluarga',
                'ijazah' => 'Ijazah Terakhir',
                'transkrip' => 'Transkrip Nilai',
                'surat_keterangan_tidak_mampu' => 'Surat Keterangan Tidak Mampu',
                'slip_gaji_ortu' => 'Slip Gaji Orang Tua',
                'surat_rekomendasi' => 'Surat Rekomendasi',
                'sertifikat_prestasi' => 'Sertifikat Prestasi'
            ];

            // Handle dokumen_pendukung dengan error handling yang baik
            $selectedDokumen = $this->parseJsonDokumen($beasiswa->dokumen_pendukung);

            return view('admin.beasiswa.edit', compact('beasiswa', 'dokumenOptions', 'selectedDokumen'));
        } catch (Exception $e) {
            return back()->with('error', 'Gagal memuat form edit: ' . $e->getMessage());
        }
    }

    public function update(Request $request, Beasiswa $beasiswa)
    {
        try {
            $validated = $request->validate([
                'nama_beasiswa' => 'required|string|max:255|unique:beasiswas,nama_beasiswa,' . $beasiswa->id,
                'deskripsi' => 'required|string|min:10',
                'jumlah_dana' => 'required|numeric|min:100000|max:999999999',
                'tanggal_buka' => 'required|date',
                'tanggal_tutup' => 'required|date|after:tanggal_buka',
                'status' => 'required|in:aktif,nonaktif',
                'persyaratan' => 'required|string|min:10',
                'dokumen_pendukung' => 'nullable|array|max:8',
                'dokumen_pendukung.*' => 'string|in:ktp,kk,ijazah,transkrip,surat_keterangan_tidak_mampu,slip_gaji_ortu,surat_rekomendasi,sertifikat_prestasi',
            ], [
                'nama_beasiswa.required' => 'Nama beasiswa wajib diisi',
                'nama_beasiswa.unique' => 'Nama beasiswa sudah ada, gunakan nama lain',
                'deskripsi.required' => 'Deskripsi beasiswa wajib diisi',
                'deskripsi.min' => 'Deskripsi minimal 10 karakter',
                'jumlah_dana.required' => 'Jumlah dana wajib diisi',
                'jumlah_dana.min' => 'Jumlah dana minimal Rp 100.000',
                'jumlah_dana.max' => 'Jumlah dana terlalu besar',
                'tanggal_buka.required' => 'Tanggal buka pendaftaran wajib diisi',
                'tanggal_tutup.required' => 'Tanggal tutup pendaftaran wajib diisi',
                'tanggal_tutup.after' => 'Tanggal tutup harus setelah tanggal buka',
                'persyaratan.required' => 'Persyaratan beasiswa wajib diisi',
                'persyaratan.min' => 'Persyaratan minimal 10 karakter',
            ]);

            DB::beginTransaction();

            $beasiswa->update([
                'nama_beasiswa' => $validated['nama_beasiswa'],
                'deskripsi' => $validated['deskripsi'],
                'jumlah_dana' => $validated['jumlah_dana'],
                'tanggal_buka' => $validated['tanggal_buka'],
                'tanggal_tutup' => $validated['tanggal_tutup'],
                'status' => $validated['status'],
                'persyaratan' => $validated['persyaratan'],
                'dokumen_pendukung' => json_encode($request->input('dokumen_pendukung', [])),
            ]);

            DB::commit();

            return redirect()->route('admin.beasiswa.index')
                             ->with('success', 'Beasiswa "' . $validated['nama_beasiswa'] . '" berhasil diupdate!');
        } catch (Exception $e) {
            DB::rollback();
            return back()->withInput()
                         ->with('error', 'Gagal mengupdate beasiswa: ' . $e->getMessage());
        }
    }

    public function destroy(Beasiswa $beasiswa)
    {
        try {
            DB::beginTransaction();

            // Cek jumlah pendaftar
            $pendaftarCount = $beasiswa->pendaftar()->count();
            $namaBeasiswa = $beasiswa->nama_beasiswa;

            // Hapus semua file dokumen pendaftar terlebih dahulu
            $pendaftars = $beasiswa->pendaftar;
            foreach ($pendaftars as $pendaftar) {
                $this->deleteDocumentFiles($pendaftar);
            }

            // Hapus pendaftar
            $beasiswa->pendaftar()->delete();
            
            // Hapus beasiswa
            $beasiswa->delete();

            DB::commit();

            $message = 'Beasiswa "' . $namaBeasiswa . '" berhasil dihapus!';
            if ($pendaftarCount > 0) {
                $message .= ' (' . $pendaftarCount . ' data pendaftar juga dihapus)';
            }

            return redirect()->route('admin.beasiswa.index')
                             ->with('success', $message);
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->route('admin.beasiswa.index')
                             ->with('error', 'Gagal menghapus beasiswa: ' . $e->getMessage());
        }
    }

    /**
     * Toggle status beasiswa
     */
    public function toggleStatus(Beasiswa $beasiswa)
    {
        try {
            $newStatus = $beasiswa->status === 'aktif' ? 'nonaktif' : 'aktif';
            
            // Validasi jika akan mengaktifkan beasiswa yang sudah expired
            if ($newStatus === 'aktif' && Carbon::parse($beasiswa->tanggal_tutup)->isPast()) {
                return back()->with('error', 'Tidak dapat mengaktifkan beasiswa yang tanggal tutupnya sudah terlewat!');
            }
            
            $beasiswa->update(['status' => $newStatus]);

            return back()->with('success', 'Status beasiswa "' . $beasiswa->nama_beasiswa . '" berhasil diubah menjadi ' . $newStatus . '!');
        } catch (Exception $e) {
            return back()->with('error', 'Gagal mengubah status: ' . $e->getMessage());
        }
    }

    /**
     * Export beasiswa data
     */
    public function export(Request $request)
    {
        try {
            $query = Beasiswa::with('pendaftar');

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            $beasiswas = $query->get();

            $filename = 'beasiswa_' . date('Y-m-d_H-i-s') . '.csv';
            
            $headers = [
                'Content-type' => 'text/csv',
                'Content-Disposition' => "attachment; filename={$filename}",
                'Pragma' => 'no-cache',
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Expires' => '0'
            ];

            $callback = function() use ($beasiswas) {
                $file = fopen('php://output', 'w');
                
                // Header CSV
                fputcsv($file, [
                    'No',
                    'Nama Beasiswa', 
                    'Deskripsi',
                    'Jumlah Dana',
                    'Tanggal Buka',
                    'Tanggal Tutup',
                    'Status',
                    'Total Pendaftar',
                    'Dibuat'
                ]);

                // Data
                foreach ($beasiswas as $index => $beasiswa) {
                    fputcsv($file, [
                        $index + 1,
                        $beasiswa->nama_beasiswa,
                        strip_tags($beasiswa->deskripsi),
                        'Rp ' . number_format($beasiswa->jumlah_dana, 0, ',', '.'),
                        $beasiswa->tanggal_buka,
                        $beasiswa->tanggal_tutup,
                        ucfirst($beasiswa->status),
                        $beasiswa->pendaftar->count(),
                        $beasiswa->created_at->format('d/m/Y H:i')
                    ]);
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        } catch (Exception $e) {
            return back()->with('error', 'Gagal mengexport data: ' . $e->getMessage());
        }
    }

    /**
     * Helper method untuk parsing JSON dokumen
     */
    private function parseJsonDokumen($dokumenPendukung)
    {
        $selectedDokumen = [];
        
        if (!empty($dokumenPendukung)) {
            if (is_array($dokumenPendukung)) {
                $selectedDokumen = $dokumenPendukung;
            } else {
                try {
                    $decoded = json_decode($dokumenPendukung, true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                        $selectedDokumen = $decoded;
                    }
                } catch (Exception $e) {
                    // Log error if needed
                    \Log::warning('Error parsing dokumen_pendukung JSON: ' . $e->getMessage());
                }
            }
        }
        
        return $selectedDokumen;
    }

    /**
     * Helper method untuk menghapus file dokumen
     */
    private function deleteDocumentFiles($pendaftar)
    {
        $files = [
            'file_transkrip' => $pendaftar->file_transkrip,
            'file_ktp' => $pendaftar->file_ktp,
            'file_kk' => $pendaftar->file_kk,
        ];

        foreach ($files as $field => $fileName) {
            if (!empty($fileName) && \Storage::exists('public/documents/' . $fileName)) {
                try {
                    \Storage::delete('public/documents/' . $fileName);
                } catch (Exception $e) {
                    \Log::warning("Gagal menghapus file {$fileName}: " . $e->getMessage());
                }
            }
        }
    }
}