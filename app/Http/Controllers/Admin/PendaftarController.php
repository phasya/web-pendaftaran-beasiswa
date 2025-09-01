<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pendaftar;
use App\Models\Beasiswa;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Exception;

class PendaftarController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Pendaftar::with('beasiswa');

            // Search functionality
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('nama_lengkap', 'like', "%{$search}%")
                      ->orWhere('nim', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhereHas('beasiswa', function($subQuery) use ($search) {
                          $subQuery->where('nama_beasiswa', 'like', "%{$search}%");
                      });
                });
            }

            // Filter by status
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            // Filter by beasiswa
            if ($request->filled('beasiswa_id')) {
                $query->where('beasiswa_id', $request->beasiswa_id);
            }

            // Sort functionality
            $sortBy = $request->get('sort', 'created_at');
            $sortOrder = $request->get('order', 'desc');
            
            if (in_array($sortBy, ['nama_lengkap', 'nim', 'status', 'created_at'])) {
                $query->orderBy($sortBy, $sortOrder);
            }

            $pendaftars = $query->latest()->paginate(15);
            
            // Get beasiswa list for filter
            $beasiswas = Beasiswa::select('id', 'nama_beasiswa')->get();
            
            // Get statistics
            $stats = [
                'total' => Pendaftar::count(),
                'pending' => Pendaftar::where('status', 'pending')->count(),
                'diterima' => Pendaftar::where('status', 'diterima')->count(),
                'ditolak' => Pendaftar::where('status', 'ditolak')->count(),
            ];

            return view('admin.pendaftaran.index', compact('pendaftars', 'beasiswas', 'stats'));
        } catch (Exception $e) {
            return back()->with('error', 'Gagal memuat data pendaftar: ' . $e->getMessage());
        }
    }

    public function show(Pendaftar $pendaftar)
    {
        try {
            $pendaftar->load('beasiswa');
            return view('admin.pendaftaran.show', compact('pendaftar'));
        } catch (Exception $e) {
            return back()->with('error', 'Gagal memuat detail pendaftar: ' . $e->getMessage());
        }
    }

    public function updateStatus(Request $request, Pendaftar $pendaftar)
    {
        try {
            $validated = $request->validate([
                'status' => 'required|in:pending,diterima,ditolak',
                'keterangan' => 'nullable|string|max:500'
            ], [
                'status.required' => 'Status wajib dipilih',
                'status.in' => 'Status tidak valid',
                'keterangan.max' => 'Keterangan maksimal 500 karakter'
            ]);

            DB::beginTransaction();

            // Update status dan keterangan
            $pendaftar->update([
                'status' => $validated['status'],
                'keterangan' => $validated['keterangan'] ?? null,
                'tanggal_verifikasi' => now(),
                'verified_by' => auth()->user()->name ?? 'Admin', // Jika ada auth
            ]);

            DB::commit();

            $statusText = [
                'pending' => 'Pending',
                'diterima' => 'Diterima', 
                'ditolak' => 'Ditolak'
            ];

            return redirect()->back()
                            ->with('success', 'Status pendaftar "' . $pendaftar->nama_lengkap . 
                                            '" berhasil diubah menjadi ' . $statusText[$validated['status']] . '!');
        } catch (Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal mengupdate status: ' . $e->getMessage());
        }
    }

    public function destroy(Pendaftar $pendaftar)
    {
        try {
            DB::beginTransaction();

            $namaPendaftar = $pendaftar->nama_lengkap;

            // Hapus file dokumen
            $files = [
                'file_transkrip' => $pendaftar->file_transkrip,
                'file_ktp' => $pendaftar->file_ktp,
                'file_kk' => $pendaftar->file_kk,
            ];

            foreach ($files as $field => $fileName) {
                if ($fileName && Storage::exists('public/documents/' . $fileName)) {
                    try {
                        Storage::delete('public/documents/' . $fileName);
                    } catch (Exception $e) {
                        // Log error tapi jangan hentikan proses
                        \Log::warning("Gagal menghapus file {$fileName}: " . $e->getMessage());
                    }
                }
            }

            // Hapus data pendaftar
            $pendaftar->delete();

            DB::commit();

            return redirect()->route('admin.pendaftar.index')
                            ->with('success', 'Data pendaftar "' . $namaPendaftar . '" berhasil dihapus!');
        } catch (Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal menghapus data pendaftar: ' . $e->getMessage());
        }
    }

    /**
     * Download file dokumen pendaftar
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
                return back()->with('error', 'File ' . $fileType . ' tidak ditemukan.');
            }

            $filePath = 'public/documents/' . $fileName;

            if (!Storage::exists($filePath)) {
                return back()->with('error', 'File tidak ada di server.');
            }

            // Generate nama file yang user-friendly
            $originalName = $pendaftar->nama_lengkap . '_' . $pendaftar->nim . '_' . $fileType . '.' . 
                           pathinfo($fileName, PATHINFO_EXTENSION);

            return Storage::download($filePath, $originalName);
        } catch (Exception $e) {
            return back()->with('error', 'Gagal mengunduh file: ' . $e->getMessage());
        }
    }

    /**
     * Bulk update status
     */
    public function bulkUpdateStatus(Request $request)
    {
        try {
            $validated = $request->validate([
                'ids' => 'required|array',
                'ids.*' => 'exists:pendaftars,id',
                'status' => 'required|in:pending,diterima,ditolak',
                'keterangan' => 'nullable|string|max:500'
            ]);

            DB::beginTransaction();

            $updatedCount = Pendaftar::whereIn('id', $validated['ids'])->update([
                'status' => $validated['status'],
                'keterangan' => $validated['keterangan'] ?? null,
                'tanggal_verifikasi' => now(),
                'verified_by' => auth()->user()->name ?? 'Admin',
            ]);

            DB::commit();

            $statusText = [
                'pending' => 'Pending',
                'diterima' => 'Diterima',
                'ditolak' => 'Ditolak'
            ];

            return response()->json([
                'success' => true,
                'message' => $updatedCount . ' pendaftar berhasil diubah statusnya menjadi ' . $statusText[$validated['status']] . '!'
            ]);

        } catch (Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk delete pendaftars
     */
    public function bulkDelete(Request $request)
    {
        try {
            $validated = $request->validate([
                'ids' => 'required|array',
                'ids.*' => 'exists:pendaftars,id'
            ]);

            DB::beginTransaction();

            $pendaftars = Pendaftar::whereIn('id', $validated['ids'])->get();
            $deletedCount = 0;

            foreach ($pendaftars as $pendaftar) {
                // Hapus file dokumen
                $files = [
                    'file_transkrip' => $pendaftar->file_transkrip,
                    'file_ktp' => $pendaftar->file_ktp, 
                    'file_kk' => $pendaftar->file_kk,
                ];

                foreach ($files as $field => $fileName) {
                    if ($fileName && Storage::exists('public/documents/' . $fileName)) {
                        try {
                            Storage::delete('public/documents/' . $fileName);
                        } catch (Exception $e) {
                            \Log::warning("Gagal menghapus file {$fileName}: " . $e->getMessage());
                        }
                    }
                }

                $pendaftar->delete();
                $deletedCount++;
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => $deletedCount . ' pendaftar berhasil dihapus!'
            ]);

        } catch (Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export data pendaftar
     */
    public function export(Request $request)
    {
        try {
            $query = Pendaftar::with('beasiswa');

            // Apply filters
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            if ($request->filled('beasiswa_id')) {
                $query->where('beasiswa_id', $request->beasiswa_id);
            }

            $pendaftars = $query->orderBy('created_at', 'desc')->get();

            $filename = 'pendaftar_' . date('Y-m-d_H-i-s') . '.csv';
            
            $headers = [
                'Content-type' => 'text/csv',
                'Content-Disposition' => "attachment; filename={$filename}",
                'Pragma' => 'no-cache',
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Expires' => '0'
            ];

            $callback = function() use ($pendaftars) {
                $file = fopen('php://output', 'w');
                
                // Header CSV
                fputcsv($file, [
                    'No',
                    'Nama Lengkap',
                    'NIM', 
                    'Email',
                    'No HP',
                    'Beasiswa',
                    'Status',
                    'Tanggal Daftar',
                    'Tanggal Verifikasi',
                    'Keterangan'
                ]);

                // Data
                foreach ($pendaftars as $index => $pendaftar) {
                    fputcsv($file, [
                        $index + 1,
                        $pendaftar->nama_lengkap,
                        $pendaftar->nim,
                        $pendaftar->email,
                        $pendaftar->no_hp,
                        $pendaftar->beasiswa->nama_beasiswa ?? 'N/A',
                        ucfirst($pendaftar->status),
                        $pendaftar->created_at->format('d/m/Y H:i'),
                        $pendaftar->tanggal_verifikasi ? $pendaftar->tanggal_verifikasi->format('d/m/Y H:i') : 'N/A',
                        $pendaftar->keterangan ?? 'N/A'
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
     * Get statistics for dashboard
     */
    public function getStats()
    {
        try {
            $stats = [
                'total' => Pendaftar::count(),
                'pending' => Pendaftar::where('status', 'pending')->count(),
                'diterima' => Pendaftar::where('status', 'diterima')->count(),
                'ditolak' => Pendaftar::where('status', 'ditolak')->count(),
                'today' => Pendaftar::whereDate('created_at', today())->count(),
                'this_week' => Pendaftar::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
                'this_month' => Pendaftar::whereMonth('created_at', now()->month)->count(),
            ];

            return response()->json($stats);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Gagal mengambil statistik: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Preview file dokumen
     */
    public function previewFile(Pendaftar $pendaftar, $fileType)
    {
        try {
            $allowedTypes = ['transkrip', 'ktp', 'kk'];
            
            if (!in_array($fileType, $allowedTypes)) {
                return response()->json(['error' => 'Jenis file tidak valid'], 400);
            }

            $fieldName = 'file_' . $fileType;
            $fileName = $pendaftar->$fieldName;

            if (!$fileName) {
                return response()->json(['error' => 'File tidak ditemukan'], 404);
            }

            $filePath = 'public/documents/' . $fileName;

            if (!Storage::exists($filePath)) {
                return response()->json(['error' => 'File tidak ada di server'], 404);
            }

            $fileUrl = Storage::url('documents/' . $fileName);
            $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
            
            return response()->json([
                'success' => true,
                'file_url' => $fileUrl,
                'file_name' => $fileName,
                'file_type' => $fileExtension,
                'file_size' => Storage::size($filePath)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Gagal memuat file: ' . $e->getMessage()
            ], 500);
        }
    }
}