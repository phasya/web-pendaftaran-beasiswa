<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FileType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FileTypeController extends Controller
{
    public function index()
    {
        $fileTypes = FileType::ordered()->paginate(10);
        
        return view('admin.file.index', compact('fileTypes'));
    }

    public function create()
    {
        return view('admin.file.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_file_type' => 'required|string|max:255|unique:file_types',
            'deskripsi' => 'nullable|string',
            'ekstensi_diizinkan' => 'required|string',
            'ukuran_maksimal' => 'required|integer|min:100|max:10240', // 100KB - 10MB
            'wajib' => 'boolean',
            'aktif' => 'boolean',
            'urutan' => 'integer|min:0'
        ]);

        // Validate and clean extensions
        $ekstensi = collect(explode(',', $validated['ekstensi_diizinkan']))
                   ->map(fn($ext) => strtolower(trim($ext)))
                   ->filter()
                   ->unique()
                   ->implode(',');
        
        $validated['ekstensi_diizinkan'] = $ekstensi;
        $validated['wajib'] = $request->has('wajib');
        $validated['aktif'] = $request->has('aktif');

        FileType::create($validated);

        return redirect()
            ->route('admin.file-types.index')
            ->with('success', 'File type berhasil ditambahkan.');
    }

    public function show(FileType $fileType)
    {
        $fileType->load(['beasiswas', 'fileUploads']);
        
        return view('admin.file-types.show', compact('fileType'));
    }

    public function edit(FileType $fileType)
    {
        return view('admin.file-types.edit', compact('fileType'));
    }

    public function update(Request $request, FileType $fileType)
    {
        $validated = $request->validate([
            'nama_file_type' => [
                'required',
                'string',
                'max:255',
                Rule::unique('file_types')->ignore($fileType->id)
            ],
            'deskripsi' => 'nullable|string',
            'ekstensi_diizinkan' => 'required|string',
            'ukuran_maksimal' => 'required|integer|min:100|max:10240',
            'wajib' => 'boolean',
            'aktif' => 'boolean',
            'urutan' => 'integer|min:0'
        ]);

        // Validate and clean extensions
        $ekstensi = collect(explode(',', $validated['ekstensi_diizinkan']))
                   ->map(fn($ext) => strtolower(trim($ext)))
                   ->filter()
                   ->unique()
                   ->implode(',');
        
        $validated['ekstensi_diizinkan'] = $ekstensi;
        $validated['wajib'] = $request->has('wajib');
        $validated['aktif'] = $request->has('aktif');

        $fileType->update($validated);

        return redirect()
            ->route('admin.file-types.index')
            ->with('success', 'File type berhasil diperbarui.');
    }

    public function destroy(FileType $fileType)
    {
        // Check if file type is being used
        if ($fileType->beasiswas()->count() > 0) {
            return redirect()
                ->route('admin.file-types.index')
                ->with('error', 'File type tidak dapat dihapus karena sedang digunakan oleh beasiswa.');
        }

        if ($fileType->fileUploads()->count() > 0) {
            return redirect()
                ->route('admin.file-types.index')
                ->with('error', 'File type tidak dapat dihapus karena ada file yang sudah diupload.');
        }

        $fileType->delete();

        return redirect()
            ->route('admin.file-types.index')
            ->with('success', 'File type berhasil dihapus.');
    }

    public function toggleStatus(FileType $fileType)
    {
        $fileType->update(['aktif' => !$fileType->aktif]);

        $status = $fileType->aktif ? 'diaktifkan' : 'dinonaktifkan';
        
        return redirect()
            ->route('admin.file-types.index')
            ->with('success', "File type berhasil {$status}.");
    }

    // API endpoint untuk mendapatkan file types (untuk AJAX)
    public function getFileTypes(Request $request)
    {
        $query = FileType::aktif()->ordered();

        if ($request->has('search')) {
            $query->where('nama_file_type', 'like', '%' . $request->search . '%');
        }

        return response()->json($query->get());
    }
}