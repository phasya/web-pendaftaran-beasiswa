<?php

namespace App\Http\Controllers;

use App\Models\Beasiswa;
use App\Models\Pendaftar;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BeasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $beasiswas = Beasiswa::latest()->paginate(10);
        $totalPendaftar = Pendaftar::count();
        $aktifCount = Beasiswa::where('status', 'aktif')->count();

        return view('admin.beasiswa.index', [
            'beasiswas' => $beasiswas,
            'totalPendaftar' => $totalPendaftar,
            'aktifCount' => $aktifCount
        ]);
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
        $request->validate([
            'nama_beasiswa' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'jumlah_dana' => 'required|numeric|min:0',
            'tanggal_buka' => 'required|date|after_or_equal:today',
            'tanggal_tutup' => 'required|date|after:tanggal_buka',
            'status' => 'required|in:aktif,nonaktif',
            'persyaratan' => 'required|string',
            'dokumen' => 'array', // Array untuk dokumen pendukung
        ]);

        // Ambil dokumen yang dipilih
        $dokumenPendukung = $request->input('dokumen', []);

        Beasiswa::create([
            'nama_beasiswa' => $request->nama_beasiswa,
            'deskripsi' => $request->deskripsi,
            'jumlah_dana' => $request->jumlah_dana,
            'tanggal_buka' => $request->tanggal_buka,
            'tanggal_tutup' => $request->tanggal_tutup,
            'status' => $request->status,
            'persyaratan' => $request->persyaratan,
            'dokumen_pendukung' => json_encode($dokumenPendukung), // Simpan sebagai JSON
        ]);

        return redirect()->route('admin.beasiswa.index')
            ->with('success', 'Beasiswa berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Beasiswa $beasiswa)
    {
        // Load relasi pendaftar untuk menampilkan detail
        $beasiswa->load('pendaftar');
        
        return view('admin.beasiswa.show', compact('beasiswa'));
    }

   /**
 * Show the form for editing the specified resource.
 */
public function edit(Beasiswa $beasiswa)
{
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

    // Ambil dokumen yang sudah dipilih sebelumnya
// Perbaikan baris di method edit
$selectedDokumen = is_array($beasiswa->dokumen_pendukung)
    ? $beasiswa->dokumen_pendukung
    : (json_decode($beasiswa->dokumen_pendukung, true) ?? []);


    // Kirim semua variabel yang dibutuhkan ke view
    return view('admin.beasiswa.edit', compact('beasiswa', 'dokumenOptions', 'selectedDokumen'));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Beasiswa $beasiswa)
    {
        $request->validate([
            'nama_beasiswa' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'jumlah_dana' => 'required|numeric|min:0',
            'tanggal_buka' => 'required|date',
            'tanggal_tutup' => 'required|date|after:tanggal_buka',
            'status' => 'required|in:aktif,nonaktif',
            'persyaratan' => 'required|string',
            'dokumen' => 'array',
        ]);

        $dokumenPendukung = $request->input('dokumen', []);

        $beasiswa->update([
            'nama_beasiswa' => $request->nama_beasiswa,
            'deskripsi' => $request->deskripsi,
            'jumlah_dana' => $request->jumlah_dana,
            'tanggal_buka' => $request->tanggal_buka,
            'tanggal_tutup' => $request->tanggal_tutup,
            'status' => $request->status,
            'persyaratan' => $request->persyaratan,
            'dokumen_pendukung' => json_encode($dokumenPendukung),
        ]);

        return redirect()->route('admin.beasiswa.index')
            ->with('success', 'Beasiswa berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Beasiswa $beasiswa)
    {
        try {
            // Hapus semua pendaftar yang terkait dengan beasiswa ini
            $beasiswa->pendaftar()->delete();
            
            // Hapus beasiswa
            $beasiswa->delete();
            
            return redirect()->route('admin.beasiswa.index')
                ->with('success', 'Beasiswa dan semua data pendaftar terkait berhasil dihapus!');
                
        } catch (\Exception $e) {
            return redirect()->route('admin.beasiswa.index')
                ->with('error', 'Gagal menghapus beasiswa: ' . $e->getMessage());
        }
    }

    /**
     * Toggle status beasiswa (aktif/nonaktif)
     */
    public function toggleStatus(Beasiswa $beasiswa)
    {
        $beasiswa->update([
            'status' => $beasiswa->status === 'aktif' ? 'nonaktif' : 'aktif'
        ]);

        return redirect()->route('admin.beasiswa.index')
            ->with('success', 'Status beasiswa berhasil diubah menjadi ' . $beasiswa->status . '!');
    }
}