<?php

namespace App\Http\Controllers;

use App\Models\Beasiswa;
use Illuminate\Http\Request;

class BeasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Beasiswa $beasiswa)
    {
        //
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
}
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Beasiswa $beasiswa)
    {
        //
    }

    


