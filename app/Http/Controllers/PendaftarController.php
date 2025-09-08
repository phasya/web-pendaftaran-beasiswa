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

            // Dynamic validation rules based on beasiswa requirements
            $rules = [
                'nama_lengkap' => 'required|string|max:255|min:3',
                'nim' => 'required|string|max:20|min:8|unique:pendaftars,nim|regex:/^[0-9]+$/',
                'email' => 'required|email|max:255|unique:pendaftars,email',
                'no_hp' => 'required|string|max:15|min:10|regex:/^[0-9]+$/',
                'alasan_mendaftar' => 'required|string|min:50|max:1000',
            ];

            // Custom messages
            $messages = [
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
            ];

            // Add dynamic file validation based on beasiswa requirements
            $fileFields = [];
            if ($beasiswa->dokumen_pendukung && is_array($beasiswa->dokumen_pendukung)) {
                foreach ($beasiswa->dokumen_pendukung as $dokumen) {
                    $fieldName = "dokumen_{$dokumen}";
                    $rules[$fieldName] = 'required|file|mimes:pdf,jpg,jpeg,png|max:5120'; // 5MB
                    $fileFields[] = $fieldName;
                    
                    // Add custom messages for each document type
                    $documentLabel = $this->getDocumentLabel($dokumen);
                    $messages[$fieldName . '.required'] = "File {$documentLabel} wajib diupload";
                    $messages[$fieldName . '.mimes'] = "File {$documentLabel} harus berformat PDF, JPG, JPEG, atau PNG";
                    $messages[$fieldName . '.max'] = "Ukuran file {$documentLabel} maksimal 5MB";
                }
            } else {
                // Fallback: if no specific documents required, require KK only (as per current form)
                $rules['file_kk'] = 'required|file|mimes:pdf,jpg,jpeg,png|max:5120';
                $fileFields[] = 'file_kk';
                $messages['file_kk.required'] = 'File Kartu Keluarga wajib diupload';
                $messages['file_kk.mimes'] = 'File Kartu Keluarga harus berformat PDF, JPG, JPEG, atau PNG';
                $messages['file_kk.max'] = 'Ukuran file Kartu Keluarga maksimal 5MB';
            }

            // Validate the request
            $validated = $request->validate($rules, $messages);

            DB::beginTransaction();

            // Buat direktori jika belum ada
            if (!Storage::exists('public/documents')) {
                Storage::makeDirectory('public/documents');
            }

            // Upload files dengan nama yang unik
            $timestamp = time();
            $nimSanitized = preg_replace('/[^a-zA-Z0-9]/', '', $validated['nim']);
            $uploadedFiles = [];

            foreach ($fileFields as $fieldName) {
                if ($request->hasFile($fieldName)) {
                    $file = $request->file($fieldName);
                    
                    // Validasi ukuran file
                    if ($file->getSize() > (5120 * 1024)) { // 5MB in bytes
                        throw new Exception("Ukuran file {$fieldName} terlalu besar. Maksimal 5MB");
                    }

                    // Generate unique filename
                    $extension = $file->getClientOriginalExtension();
                    $fileName = $timestamp . '_' . $nimSanitized . '_' . $fieldName . '.' . $extension;
                    
                    // Upload file
                    try {
                        $file->storeAs('public/documents', $fileName);
                        $uploadedFiles[$fieldName] = $fileName;
                    } catch (Exception $e) {
                        throw new Exception("Gagal mengupload file {$fieldName}: " . $e->getMessage());
                    }
                }
            }

            // Prepare data for database
            $pendaftarData = [
                'beasiswa_id' => $beasiswa->id,
                'nama_lengkap' => $validated['nama_lengkap'],
                'nim' => $validated['nim'],
                'email' => $validated['email'],
                'no_hp' => $validated['no_hp'],
                'alasan_mendaftar' => $validated['alasan_mendaftar'],
                'status' => 'pending',
                'tanggal_daftar' => now(),
            ];

            // Add uploaded files to data
            foreach ($uploadedFiles as $fieldName => $fileName) {
                $pendaftarData[$fieldName] = $fileName;
            }

            // Create pendaftar record
            $pendaftar = Pendaftar::create($pendaftarData);

            DB::commit();

            return redirect()->route('home')
                            ->with('success', 'Pendaftaran beasiswa berhasil! Silakan tunggu konfirmasi dari admin. 
                                              Nomor pendaftaran Anda: ' . str_pad($pendaftar->id, 6, '0', STR_PAD_LEFT));

        } catch (Exception $e) {
            DB::rollback();
            
            // Hapus file yang sudah terupload jika ada error
            if (isset($uploadedFiles)) {
                foreach ($uploadedFiles as $fileName) {
                    $filePath = 'public/documents/' . $fileName;
                    if (Storage::exists($filePath)) {
                        Storage::delete($filePath);
                    }
                }
            }

            return back()->withInput()
                         ->with('error', 'Gagal mendaftar beasiswa: ' . $e->getMessage());
        }
    }

    /**
     * Get human readable label for document type
     */
    private function getDocumentLabel($dokumen)
    {
        $labels = [
            'ktp' => 'KTP',
            'kk' => 'Kartu Keluarga', 
            'ijazah' => 'Ijazah Terakhir',
            'transkrip' => 'Transkrip Nilai',
            'surat_keterangan_tidak_mampu' => 'Surat Keterangan Tidak Mampu',
            'slip_gaji_ortu' => 'Slip Gaji Orang Tua',
            'surat_rekomendasi' => 'Surat Rekomendasi',
            'sertifikat_prestasi' => 'Sertifikat Prestasi',
        ];

        return $labels[$dokumen] ?? ucfirst(str_replace('_', ' ', $dokumen));
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
            // Allow dynamic file types based on what was uploaded
            $fieldName = str_starts_with($fileType, 'dokumen_') ? $fileType : 'file_' . $fileType;
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