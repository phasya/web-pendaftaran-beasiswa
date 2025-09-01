<?php

namespace App\Http\Controllers;

use App\Models\Beasiswa;
use App\Models\Pendaftar;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Exception;

class BeasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $beasiswas = Beasiswa::latest()->paginate(10);
            $totalPendaftar = Pendaftar::count();
            $aktifCount = Beasiswa::where('status', 'aktif')->count();

            return view('admin.beasiswa.index', [
                'beasiswas' => $beasiswas,
                'totalPendaftar' => $totalPendaftar,
                'aktifCount' => $aktifCount
            ]);
        } catch (Exception $e) {
            return back()->with('error', 'Gagal memuat data beasiswa: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Definisikan opsi dokumen untuk form create
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validasi input
            $validated = $request->validate([
                'nama_beasiswa' => 'required|string|max:255|unique:beasiswas,nama_beasiswa',
                'deskripsi' => 'required|string|min:10',
                'jumlah_dana' => 'required|numeric|min:100000|max:999999999',
                'tanggal_buka' => 'required|date|after_or_equal:today',
                'tanggal_tutup' => 'required|date|after:tanggal_buka',
                'status' => 'required|in:aktif,nonaktif',
                'persyaratan' => 'required|string|min:10',
                'dokumen' => 'nullable|array|max:8',
                'dokumen.*' => 'string|in:ktp,kk,ijazah,transkrip,surat_keterangan_tidak_mampu,slip_gaji_ortu,surat_rekomendasi,sertifikat_prestasi',
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

            // Ambil dokumen yang dipilih
            $dokumenPendukung = $request->input('dokumen', []);

            // Buat beasiswa baru
            DB::beginTransaction();

            $beasiswa = Beasiswa::create([
                'nama_beasiswa' => $validated['nama_beasiswa'],
                'deskripsi' => $validated['deskripsi'],
                'jumlah_dana' => $validated['jumlah_dana'],
                'tanggal_buka' => $validated['tanggal_buka'],
                'tanggal_tutup' => $validated['tanggal_tutup'],
                'status' => $validated['status'],
                'persyaratan' => $validated['persyaratan'],
                'dokumen_pendukung' => json_encode($dokumenPendukung),
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

    /**
     * Display the specified resource.
     */
    public function show(Beasiswa $beasiswa)
    {
        try {
            // Load relasi pendaftar untuk menampilkan detail
            $beasiswa->load(['pendaftar' => function($query) {
                $query->latest();
            }]);
            
            // Hitung statistik
            $stats = [
                'total_pendaftar' => $beasiswa->pendaftar->count(),
                'pending' => $beasiswa->pendaftar->where('status', 'pending')->count(),
                'diterima' => $beasiswa->pendaftar->where('status', 'diterima')->count(),
                'ditolak' => $beasiswa->pendaftar->where('status', 'ditolak')->count(),
            ];
            
            return view('admin.beasiswa.show', compact('beasiswa', 'stats'));
        } catch (Exception $e) {
            return back()->with('error', 'Gagal memuat detail beasiswa: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Beasiswa $beasiswa)
    {
        try {
            // Definisikan opsi dokumen untuk form edit
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

            // Ambil dokumen yang sudah dipilih sebelumnya dengan penanganan error yang baik
            $selectedDokumen = [];
            if ($beasiswa->dokumen_pendukung) {
                if (is_array($beasiswa->dokumen_pendukung)) {
                    $selectedDokumen = $beasiswa->dokumen_pendukung;
                } else {
                    try {
                        $decoded = json_decode($beasiswa->dokumen_pendukung, true);
                        $selectedDokumen = is_array($decoded) ? $decoded : [];
                    } catch (Exception $e) {
                        $selectedDokumen = [];
                    }
                }
            }

            return view('admin.beasiswa.edit', compact('beasiswa', 'dokumenOptions', 'selectedDokumen'));
        } catch (Exception $e) {
            return back()->with('error', 'Gagal memuat form edit: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Beasiswa $beasiswa)
    {
        try {
            // Validasi input
            $validated = $request->validate([
                'nama_beasiswa' => 'required|string|max:255|unique:beasiswas,nama_beasiswa,' . $beasiswa->id,
                'deskripsi' => 'required|string|min:10',
                'jumlah_dana' => 'required|numeric|min:100000|max:999999999',
                'tanggal_buka' => 'required|date',
                'tanggal_tutup' => 'required|date|after:tanggal_buka',
                'status' => 'required|in:aktif,nonaktif',
                'persyaratan' => 'required|string|min:10',
                'dokumen' => 'nullable|array|max:8',
                'dokumen.*' => 'string|in:ktp,kk,ijazah,transkrip,surat_keterangan_tidak_mampu,slip_gaji_ortu,surat_rekomendasi,sertifikat_prestasi',
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

            $dokumenPendukung = $request->input('dokumen', []);

            // Update data dalam transaksi
            DB::beginTransaction();

            $beasiswa->update([
                'nama_beasiswa' => $validated['nama_beasiswa'],
                'deskripsi' => $validated['deskripsi'],
                'jumlah_dana' => $validated['jumlah_dana'],
                'tanggal_buka' => $validated['tanggal_buka'],
                'tanggal_tutup' => $validated['tanggal_tutup'],
                'status' => $validated['status'],
                'persyaratan' => $validated['persyaratan'],
                'dokumen_pendukung' => json_encode($dokumenPendukung),
            ]);

            DB::commit();

            return redirect()->route('admin.beasiswa.index')
                ->with('success', 'Beasiswa "' . $validated['nama_beasiswa'] . '" berhasil diperbarui!');

        } catch (Exception $e) {
            DB::rollback();
            return back()->withInput()
                ->with('error', 'Gagal memperbarui beasiswa: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Beasiswa $beasiswa)
    {
        try {
            DB::beginTransaction();

            // Cek apakah ada pendaftar
            $pendaftarCount = $beasiswa->pendaftar()->count();
            
            if ($pendaftarCount > 0) {
                // Konfirmasi penghapusan jika ada pendaftar
                $beasiswa->pendaftar()->delete();
            }
            
            // Simpan nama beasiswa untuk pesan sukses
            $namaBeasiswa = $beasiswa->nama_beasiswa;
            
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
     * Toggle status beasiswa (aktif/nonaktif)
     */
    public function toggleStatus(Beasiswa $beasiswa)
    {
        try {
            $newStatus = $beasiswa->status === 'aktif' ? 'nonaktif' : 'aktif';
            
            // Validasi jika status akan diubah ke aktif
            if ($newStatus === 'aktif') {
                // Cek apakah tanggal masih valid
                if (Carbon::parse($beasiswa->tanggal_tutup)->isPast()) {
                    return back()->with('error', 'Tidak dapat mengaktifkan beasiswa yang tanggal tutupnya sudah terlewat!');
                }
            }
            
            $beasiswa->update(['status' => $newStatus]);

            return redirect()->route('admin.beasiswa.index')
                ->with('success', 'Status beasiswa "' . $beasiswa->nama_beasiswa . '" berhasil diubah menjadi ' . $newStatus . '!');
                
        } catch (Exception $e) {
            return back()->with('error', 'Gagal mengubah status: ' . $e->getMessage());
        }
    }

    /**
     * Bulk delete beasiswas
     */
    public function bulkDelete(Request $request)
    {
        try {
            $ids = $request->validate([
                'ids' => 'required|array',
                'ids.*' => 'exists:beasiswas,id'
            ])['ids'];

            DB::beginTransaction();

            $deletedCount = 0;
            foreach ($ids as $id) {
                $beasiswa = Beasiswa::find($id);
                if ($beasiswa) {
                    $beasiswa->pendaftar()->delete();
                    $beasiswa->delete();
                    $deletedCount++;
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => $deletedCount . ' beasiswa berhasil dihapus!'
            ]);

        } catch (Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus beasiswa: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get beasiswa statistics for dashboard
     */
    public function getStats()
    {
        try {
            $stats = [
                'total' => Beasiswa::count(),
                'aktif' => Beasiswa::where('status', 'aktif')->count(),
                'nonaktif' => Beasiswa::where('status', 'nonaktif')->count(),
                'total_dana' => Beasiswa::sum('jumlah_dana'),
                'expired' => Beasiswa::where('tanggal_tutup', '<', now())->count(),
            ];

            return response()->json($stats);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Gagal mengambil statistik: ' . $e->getMessage()
            ], 500);
        }
    }
}