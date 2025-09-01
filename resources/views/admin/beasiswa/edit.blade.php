@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Beasiswa</h1>

        <form action="{{ route('beasiswas.update', $beasiswa->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nama_beasiswa" class="form-label">Nama Beasiswa</label>
                <input type="text" name="nama_beasiswa" id="nama_beasiswa" class="form-control"
                    value="{{ old('nama_beasiswa', $beasiswa->nama_beasiswa) }}" required>
            </div>

            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" rows="4" class="form-control"
                    required>{{ old('deskripsi', $beasiswa->deskripsi) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="jumlah_dana" class="form-label">Jumlah Dana</label>
                <input type="number" step="0.01" name="jumlah_dana" id="jumlah_dana" class="form-control"
                    value="{{ old('jumlah_dana', $beasiswa->jumlah_dana) }}" required>
            </div>

            @php
                $dokumenOptions = [
                    'surat-aktif' => 'Surat Keterangan Aktif Kuliah',
                    'transkrip' => 'Transkrip Nilai',
                    'rekomendasi' => 'Surat Rekomendasi',
                    'ktp' => 'KTP/Identitas',
                    'kk' => 'Kartu Keluarga',
                    'surat-keterangan-tidak-mampu' => 'Surat Keterangan Tidak Mampu',
                    'sertifikat-prestasi' => 'Sertifikat Prestasi'
                ];

                // Ambil data lama / dari DB
                $selectedDokumen = old('dokumen_pendukung', isset($beasiswa) ? $beasiswa->dokumen_pendukung : []);

                // Kalau dari DB berupa JSON string → decode
                if (is_string($selectedDokumen)) {
                    $decoded = json_decode($selectedDokumen, true);
                    $selectedDokumen = is_array($decoded) ? $decoded : [];
                }

                // Pastikan array
                if (!is_array($selectedDokumen)) {
                    $selectedDokumen = [];
                }
            @endphp

            <div class="mb-3">
                <label class="form-label">Dokumen Pendukung</label><br>
                @foreach($dokumenOptions as $value => $label)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="dokumen_pendukung[]" value="{{ $value }}"
                            id="dokumen_{{ $value }}" {{ in_array($value, $selectedDokumen) ? 'checked' : '' }}>
                        <label class="form-check-label" for="dokumen_{{ $value }}">
                            {{ $label }}
                        </label>
                    </div>
                @endforeach
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('beasiswas.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection