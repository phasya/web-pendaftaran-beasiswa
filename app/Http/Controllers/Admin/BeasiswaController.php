<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Beasiswa;
use App\Models\Pendaftar;

class BeasiswaController extends Controller
{
    public function index()
    {
        $beasiswas = Beasiswa::paginate(10);
        $aktifCount = Beasiswa::where('status', 'aktif')->count();
        $totalPendaftar = Beasiswa::withCount('pendaftar')->get()->sum('pendaftar_count');

        return view('admin.beasiswa.index', compact('beasiswas', 'aktifCount', 'totalPendaftar'));
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
        $validated = $request->validate([
            'nama_beasiswa' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'jumlah_dana' => 'required|numeric|min:0',
            'tanggal_buka' => 'required|date',
            'tanggal_tutup' => 'required|date|after:tanggal_buka',
            'status' => 'required|in:aktif,nonaktif',
            'persyaratan' => 'required|string',
            'dokumen' => 'nullable|array',
        ]);

        // Simpan data
        Beasiswa::create([
            'nama_beasiswa' => $validated['nama_beasiswa'],
            'deskripsi' => $validated['deskripsi'],
            'jumlah_dana' => $validated['jumlah_dana'],
            'tanggal_buka' => $validated['tanggal_buka'],
            'tanggal_tutup' => $validated['tanggal_tutup'],
            'status' => $validated['status'],
            'persyaratan' => $validated['persyaratan'],
            'dokumen_pendukung' => json_encode($request->input('dokumen', [])),
        ]);

        return redirect()->route('admin.beasiswa.index')
                         ->with('success', 'Beasiswa berhasil ditambahkan!');
    }

    public function show(Beasiswa $beasiswa)
    {
        return view('admin.beasiswa.show', compact('beasiswa'));
    }

    public function edit(Beasiswa $beasiswa)
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

$selectedDokumen = is_array($beasiswa->dokumen_pendukung)
    ? $beasiswa->dokumen_pendukung
    : json_decode($beasiswa->dokumen_pendukung, true) ?? [];

        return view('admin.beasiswa.edit', compact('beasiswa', 'dokumenOptions', 'selectedDokumen'));
    }

    public function update(Request $request, Beasiswa $beasiswa)
    {
        $validated = $request->validate([
            'nama_beasiswa' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'jumlah_dana' => 'required|numeric|min:0',
            'tanggal_buka' => 'required|date',
            'tanggal_tutup' => 'required|date|after:tanggal_buka',
            'status' => 'required|in:aktif,nonaktif',
            'persyaratan' => 'required|string',
            'dokumen' => 'nullable|array',
        ]);

        $beasiswa->update([
            'nama_beasiswa' => $validated['nama_beasiswa'],
            'deskripsi' => $validated['deskripsi'],
            'jumlah_dana' => $validated['jumlah_dana'],
            'tanggal_buka' => $validated['tanggal_buka'],
            'tanggal_tutup' => $validated['tanggal_tutup'],
            'status' => $validated['status'],
            'persyaratan' => $validated['persyaratan'],
            'dokumen_pendukung' => json_encode($request->input('dokumen', [])),
        ]);

        return redirect()->route('admin.beasiswa.index')
                         ->with('success', 'Beasiswa berhasil diupdate!');
    }

    public function destroy(Beasiswa $beasiswa)
    {
        $beasiswa->delete();

        return redirect()->route('admin.beasiswa.index')
                         ->with('success', 'Beasiswa berhasil dihapus!');
    }
}
