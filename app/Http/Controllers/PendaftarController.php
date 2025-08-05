<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Beasiswa;
use App\Models\Pendaftar;
use Illuminate\Support\Facades\Storage;

class PendaftarController extends Controller
{
    public function create(Beasiswa $beasiswa)
    {
        if (!$beasiswa->isActive()) {
            return redirect()->route('home')
                           ->with('error', 'Pendaftaran beasiswa sudah ditutup atau tidak aktif.');
        }

        return view('pendaftaran.create', compact('beasiswa'));
    }

    public function store(Request $request, Beasiswa $beasiswa)
    {
        if (!$beasiswa->isActive()) {
            return redirect()->route('home')
                           ->with('error', 'Pendaftaran beasiswa sudah ditutup atau tidak aktif.');
        }

        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nim' => 'required|string|max:20|unique:pendaftars,nim',
            'email' => 'required|email|max:255',
            'no_hp' => 'required|string|max:15',
            'fakultas' => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
            'semester' => 'required|integer|min:1|max:14',
            'ipk' => 'required|numeric|min:0|max:4',
            'alasan_mendaftar' => 'required|string',
            'file_transkrip' => 'required|file|mimes:pdf|max:2048',
            'file_ktp' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_kk' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // Upload files
        $transkripName = time() . '_transkrip_' . $request->file('file_transkrip')->getClientOriginalName();
        $ktpName = time() . '_ktp_' . $request->file('file_ktp')->getClientOriginalName();
        $kkName = time() . '_kk_' . $request->file('file_kk')->getClientOriginalName();

        $request->file('file_transkrip')->storeAs('public/documents', $transkripName);
        $request->file('file_ktp')->storeAs('public/documents', $ktpName);
        $request->file('file_kk')->storeAs('public/documents', $kkName);

        $validated['beasiswa_id'] = $beasiswa->id;
        $validated['file_transkrip'] = $transkripName;
        $validated['file_ktp'] = $ktpName;
        $validated['file_kk'] = $kkName;

        Pendaftar::create($validated);

        return redirect()->route('home')
                        ->with('success', 'Pendaftaran beasiswa berhasil! Silakan tunggu konfirmasi dari admin.');
    }
}