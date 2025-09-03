<?php

namespace App\Http\Controllers;

use App\Models\Beasiswa;
use Illuminate\Http\Request;
use App\Models\FileType;
use Illuminate\Support\Facades\DB;

class BeasiswaController extends Controller
{
    // Modify the create method
public function create()
{
    // Load active file types for the form
    $fileTypes = FileType::aktif()->ordered()->get();
    
    return view('admin.beasiswa.create', compact('fileTypes'));
}

// Modify the store method
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
        
        // File requirements validation
        'file_requirements' => 'nullable|array',
        'file_requirements.*' => 'exists:file_types,id',
        'file_required' => 'nullable|array',
        'file_notes' => 'nullable|array',
        'file_notes.*' => 'nullable|string|max:500'
    ]);

    try {
        DB::beginTransaction();

        // Create the beasiswa
        $beasiswa = Beasiswa::create([
            'nama_beasiswa' => $validated['nama_beasiswa'],
            'deskripsi' => $validated['deskripsi'],
            'jumlah_dana' => $validated['jumlah_dana'],
            'tanggal_buka' => $validated['tanggal_buka'],
            'tanggal_tutup' => $validated['tanggal_tutup'],
            'status' => $validated['status'],
            'persyaratan' => $validated['persyaratan'],
        ]);

        // Handle file requirements if any
        if (!empty($validated['file_requirements'])) {
            foreach ($validated['file_requirements'] as $fileTypeId) {
                $beasiswa->fileRequirements()->attach($fileTypeId, [
                    'wajib' => isset($validated['file_required'][$fileTypeId]),
                    'catatan' => $validated['file_notes'][$fileTypeId] ?? null,
                ]);
            }
        }

        DB::commit();

        return redirect()
            ->route('admin.beasiswa.index')
            ->with('success', 'Beasiswa berhasil ditambahkan dengan ' . count($validated['file_requirements'] ?? []) . ' file requirements.');

    } catch (\Exception $e) {
        DB::rollBack();
        
        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'Terjadi kesalahan saat menyimpan beasiswa: ' . $e->getMessage());
    }
}

// Modify the show method
public function show(Beasiswa $beasiswa)
{
    // Load file requirements with file types
    $beasiswa->load(['fileRequirements', 'pendaftars']);
    
    // Calculate statistics if needed
    $statistik = [
        'total_pendaftar' => $beasiswa->pendaftars->count(),
        'pending' => $beasiswa->pendaftars->where('status', 'pending')->count(),
        'diterima' => $beasiswa->pendaftars->where('status', 'diterima')->count(),
        'ditolak' => $beasiswa->pendaftars->where('status', 'ditolak')->count(),
    ];
    
    return view('admin.beasiswa.show', compact('beasiswa', 'statistik'));
}

// Modify the edit method
public function edit(Beasiswa $beasiswa)
{
    // Load file requirements and all available file types
    $beasiswa->load('fileRequirements');
    $fileTypes = FileType::aktif()->ordered()->get();
    
    return view('admin.beasiswa.edit', compact('beasiswa', 'fileTypes'));
}

// Modify the update method
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
        
        // File requirements validation
        'file_requirements' => 'nullable|array',
        'file_requirements.*' => 'exists:file_types,id',
        'file_required' => 'nullable|array',
        'file_notes' => 'nullable|array',
        'file_notes.*' => 'nullable|string|max:500'
    ]);

    try {
        DB::beginTransaction();

        // Update the beasiswa
        $beasiswa->update([
            'nama_beasiswa' => $validated['nama_beasiswa'],
            'deskripsi' => $validated['deskripsi'],
            'jumlah_dana' => $validated['jumlah_dana'],
            'tanggal_buka' => $validated['tanggal_buka'],
            'tanggal_tutup' => $validated['tanggal_tutup'],
            'status' => $validated['status'],
            'persyaratan' => $validated['persyaratan'],
        ]);

        // Update file requirements
        // First, detach all existing requirements
        $beasiswa->fileRequirements()->detach();
        
        // Then attach the new ones
        if (!empty($validated['file_requirements'])) {
            foreach ($validated['file_requirements'] as $fileTypeId) {
                $beasiswa->fileRequirements()->attach($fileTypeId, [
                    'wajib' => isset($validated['file_required'][$fileTypeId]),
                    'catatan' => $validated['file_notes'][$fileTypeId] ?? null,
                ]);
            }
        }

        DB::commit();

        return redirect()
            ->route('admin.beasiswa.index')
            ->with('success', 'Beasiswa berhasil diperbarui dengan ' . count($validated['file_requirements'] ?? []) . ' file requirements.');

    } catch (\Exception $e) {
        DB::rollBack();
        
        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'Terjadi kesalahan saat memperbarui beasiswa: ' . $e->getMessage());
    }
}

// Add new method for managing file requirements specifically
public function manageFileRequirements(Beasiswa $beasiswa)
{
    $beasiswa->load('fileRequirements');
    $availableFileTypes = FileType::aktif()->ordered()->get();
    
    return view('admin.beasiswa.file-requirements', compact('beasiswa', 'availableFileTypes'));
}

// Add method to update file requirements via AJAX
public function updateFileRequirements(Request $request, Beasiswa $beasiswa)
{
    $validated = $request->validate([
        'file_requirements' => 'nullable|array',
        'file_requirements.*.file_type_id' => 'required|exists:file_types,id',
        'file_requirements.*.wajib' => 'boolean',
        'file_requirements.*.catatan' => 'nullable|string|max:500'
    ]);

    try {
        DB::beginTransaction();

        // Clear existing requirements
        $beasiswa->fileRequirements()->detach();

        // Add new requirements
        if (!empty($validated['file_requirements'])) {
            foreach ($validated['file_requirements'] as $requirement) {
                $beasiswa->fileRequirements()->attach($requirement['file_type_id'], [
                    'wajib' => $requirement['wajib'] ?? false,
                    'catatan' => $requirement['catatan'] ?? null
                ]);
            }
        }

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'File requirements berhasil diperbarui',
            'data' => $beasiswa->fileRequirements()->with('fileType')->get()
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        
        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan: ' . $e->getMessage()
        ], 500);
    }
}

// Add method to get file requirements for a beasiswa (API)
public function getFileRequirements(Beasiswa $beasiswa)
{
    $requirements = $beasiswa->fileRequirements()
                            ->with('fileType')
                            ->orderBy('file_types.urutan')
                            ->get();

    return response()->json([
        'success' => true,
        'data' => $requirements->map(function($requirement) {
            return [
                'id' => $requirement->id,
                'nama' => $requirement->nama_file_type,
                'deskripsi' => $requirement->deskripsi,
                'ekstensi' => $requirement->ekstensi_array,
                'ukuran_max_mb' => $requirement->ukuran_mb,
                'wajib' => $requirement->pivot->wajib,
                'catatan' => $requirement->pivot->catatan,
                'urutan' => $requirement->urutan
            ];
        })
    ]);
}
}
