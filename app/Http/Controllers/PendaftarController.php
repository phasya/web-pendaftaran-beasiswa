<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Beasiswa;
use App\Models\Pendaftar;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Exception;

class PendaftarController extends Controller
{
    public function create(Beasiswa $beasiswa)
    {
        try {
            // Cek apakah beasiswa masih aktif dan belum expired
            if (!$beasiswa->isActive()) {
                return redirect()->route('home')
                               ->with('error', 'Pendaftaran beasiswa sudah ditutup atau tidak aktif.');
            }

            // Cek apakah tanggal pendaftaran sudah tutup
            if (now() > $beasiswa->tanggal_tutup) {
                return redirect()->route('home')
                               ->with('error', 'Pendaftaran beasiswa sudah ditutup pada tanggal ' . 
                                      \Carbon\Carbon::parse($beasiswa->tanggal_tutup)->format('d M Y'));
            }

            // Cek apakah pendaftaran sudah dibuka
            if (now() < $beasiswa->tanggal_buka) {
                return redirect()->route('home')
                               ->with('error', 'Pendaftaran beasiswa akan dibuka pada tanggal ' . 
                                      \Carbon\Carbon::parse($beasiswa->tanggal_buka)->format('d M Y'));
            }

            return view('pendaftaran.create', compact('beasiswa'));
        } catch (Exception $e) {
            return redirect()->route('home')
                           ->with('error', 'Gagal memuat form pendaftaran: ' . $e->getMessage());
        }
    }

    public function store(Request $request, Beasiswa $beasiswa)
    {
        try {
            // Validasi beasiswa masih aktif
            if (!$beasiswa->isActive()) {
                return redirect()->route('home')
                               ->with('error', 'Pendaftaran beasiswa sudah ditutup atau tidak aktif.');
            }

            // Cek tanggal pendaftaran
            if (now() > $beasiswa->tanggal_tutup) {
                return redirect()->route('home')
                               ->with('error', 'Pendaftaran beasiswa sudah ditutup.');
            }

            if (now() < $beasiswa->tanggal_buka) {
                return redirect()->route('home')
                               ->with('error', 'Pendaftaran beasiswa belum dibuka.');
            }

            // Validasi input
            $validated = $request->validate([
                'nama_lengkap' => 'required|string|max:255|min:3',
                'nim' => 'required|string|max:20|min:8|unique:pendaftars,nim|regex:/^[0-9]+$/',
                'email' => 'required|email|max:255|unique:pendaftars,email',
                'no_hp' => 'required|string|max:15|min:10|regex:/^[0-9]+$/',
                'alasan_mendaftar' => 'required|string|min:50|max:1000',
                'file_transkrip' => 'required|file|mimes:pdf|max:5120', // 5MB
                'file_ktp' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048', // 2MB
                'file_kk' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048', // 2MB
            ], [
                'nama_lengkap.required' => 'Nama lengkap wajib diisi',
                'nama_lengkap.min' => 'Nama lengkap minimal 3 karakter',
                'nama_lengkap.max' => 'Nama lengkap maksimal 255 karakter',
                'nim.required' => 'NIM wajib diisi',
                'nim.min' => 'NIM minimal 8 karakter',
                'nim.unique' => 'NIM sudah terdaftar, gunakan NIM lain',
                'nim.regex' => 'NIM hanya boleh berisi angka',
                'email.required' => 'Email wajib diisi',
                'email.email' => 'Format email tidak valid',
                'email.unique' => 'Email sudah terdaftar, gunakan email lain',
                'no_hp.required' => 'Nomor HP wajib diisi',
                'no_hp.min' => 'Nomor HP minimal 10 karakter',
                'no_hp.max' => 'Nomor HP maksimal 15 karakter',
                'no_hp.regex' => 'Nomor HP hanya boleh berisi angka',
                'alasan_mendaftar.required' => 'Alasan mendaftar wajib diisi',
                'alasan_mendaftar.min' => 'Alasan mendaftar minimal 50 karakter',
                'alasan_mendaftar.max' => 'Alasan mendaftar maksimal 1000 karakter',
                'file_transkrip.required' => 'File transkrip wajib diupload',
                'file_transkrip.mimes' => 'File transkrip harus berformat PDF',
                'file_transkrip.max' => 'Ukuran file transkrip maksimal 5MB',
                'file_ktp.required' => 'File KTP wajib diupload',
                'file_ktp.mimes' => 'File KTP harus berformat PDF, JPG, JPEG, atau PNG',
                'file_ktp.max' => 'Ukuran file KTP maksimal 2MB',
                'file_kk.required' => 'File Kartu Keluarga wajib diupload',
                'file_kk.mimes' => 'File Kartu Keluarga harus berformat PDF, JPG, JPEG, atau PNG',
                'file_kk.max' => 'Ukuran file Kartu Keluarga maksimal 2MB',
            ]);

            DB::beginTransaction();

            // Buat direktori jika belum ada
            if (!Storage::exists('public/documents')) {
                Storage::makeDirectory('public/documents');
            }

            // Upload files dengan nama yang unik
            $timestamp = time();
            $nimSanitized = preg_replace('/[^a-zA-Z0-9]/', '', $validated['nim']);
            
            $transkripName = $timestamp . '_' . $nimSanitized . '_transkrip.' . $request->file('file_transkrip')->getClientOriginalExtension();
            $ktpName = $timestamp . '_' . $nimSanitized . '_ktp.' . $request->file('file_ktp')->getClientOriginalExtension();
            $kkName = $timestamp . '_' . $nimSanitized . '_kk.' . $request->file('file_kk')->getClientOriginalExtension();

            // Validasi ukuran file sebelum upload
            $maxSizes = [
                'file_transkrip' => 5120, // 5MB
                'file_ktp' => 2048, // 2MB  
                'file_kk' => 2048, // 2MB
            ];

            foreach ($maxSizes as $field => $maxSize) {
                if ($request->file($field)->getSize() > ($maxSize * 1024)) {
                    throw new Exception("Ukuran file {$field} terlalu besar. Maksimal " . ($maxSize/1024) . "MB");
                }
            }

            // Upload files
            try {
                $request->file('file_transkrip')->storeAs('public/documents', $transkripName);
                $request->file('file_ktp')->storeAs('public/documents', $ktpName);
                $request->file('file_kk')->storeAs('public/documents', $kkName);
            } catch (Exception $e) {
                throw new Exception('Gagal mengupload file: ' . $e->getMessage());
            }

            // Buat data pendaftar
            $pendaftar = Pendaftar::create([
                'beasiswa_id' => $beasiswa->id,
                'nama_lengkap' => $validated['nama_lengkap'],
                'nim' => $validated['nim'],
                'email' => $validated['email'],
                'no_hp' => $validated['no_hp'],
                'alasan_mendaftar' => $validated['alasan_mendaftar'],
                'file_transkrip' => $transkripName,
                'file_ktp' => $ktpName,
                'file_kk' => $kkName,
                'status' => 'pending',
                'tanggal_daftar' => now(),
            ]);

            DB::commit();

            return redirect()->route('home')
                            ->with('success', 'Pendaftaran beasiswa berhasil! Silakan tunggu konfirmasi dari admin. 
                                              Nomor pendaftaran Anda: ' . str_pad($pendaftar->id, 6, '0', STR_PAD_LEFT));

        } catch (Exception $e) {
            DB::rollback();
            
            // Hapus file yang sudah terupload jika ada error
            $filesToDelete = [
                isset($transkripName) ? 'public/documents/' . $transkripName : null,
                isset($ktpName) ? 'public/documents/' . $ktpName : null,
                isset($kkName) ? 'public/documents/' . $kkName : null,
            ];

            foreach ($filesToDelete as $file) {
                if ($file && Storage::exists($file)) {
                    Storage::delete($file);
                }
            }

            return back()->withInput()
                         ->with('error', 'Gagal mendaftar beasiswa: ' . $e->getMessage());
        }
    }

    /**
     * Cek status pendaftaran berdasarkan NIM
     */
    public function checkStatus(Request $request)
    {
        try {
            $request->validate([
                'nim' => 'required|string'
            ]);

            $pendaftar = Pendaftar::with('beasiswa')
                                 ->where('nim', $request->nim)
                                 ->latest()
                                 ->first();

            if (!$pendaftar) {
                return back()->with('error', 'Data pendaftar dengan NIM tersebut tidak ditemukan.');
            }

            return view('pendaftaran.status', compact('pendaftar'));
        } catch (Exception $e) {
            return back()->with('error', 'Gagal mengecek status: ' . $e->getMessage());
        }
    }

    /**
     * Download file dokumen pendaftar (untuk admin)
     */
    public function downloadFile(Pendaftar $pendaftar, $fileType)
    {
        try {
            $allowedTypes = ['transkrip', 'ktp', 'kk'];
            
            if (!in_array($fileType, $allowedTypes)) {
                return back()->with('error', 'Jenis file tidak valid.');
            }

            $fieldName = 'file_' . $fileType;
            $fileName = $pendaftar->$fieldName;

            if (!$fileName) {
                return back()->with('error', 'File tidak ditemukan.');
            }

            $filePath = 'public/documents/' . $fileName;

            if (!Storage::exists($filePath)) {
                return back()->with('error', 'File tidak ada di server.');
            }

            return Storage::download($filePath, $fileName);
        } catch (Exception $e) {
            return back()->with('error', 'Gagal mengunduh file: ' . $e->getMessage());
        }
    }

    /**
     * Batalkan pendaftaran (soft delete)
     */
    public function cancel(Request $request)
    {
        try {
            $validated = $request->validate([
                'nim' => 'required|string',
                'email' => 'required|email',
            ]);

            $pendaftar = Pendaftar::where('nim', $validated['nim'])
                                 ->where('email', $validated['email'])
                                 ->where('status', 'pending')
                                 ->first();

            if (!$pendaftar) {
                return back()->with('error', 'Data pendaftar tidak ditemukan atau sudah diproses.');
            }

            DB::beginTransaction();

            // Update status menjadi dibatalkan
            $pendaftar->update([
                'status' => 'dibatalkan',
                'keterangan' => 'Dibatalkan oleh pendaftar pada ' . now()->format('d M Y H:i')
            ]);

            DB::commit();

            return back()->with('success', 'Pendaftaran berhasil dibatalkan.');
        } catch (Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal membatalkan pendaftaran: ' . $e->getMessage());
        }
    }
}