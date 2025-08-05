@extends('layouts.admin')

@section('title', 'Detail Beasiswa')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">
        <i class="fas fa-graduation-cap"></i> Detail Beasiswa
    </h2>

    <div class="card shadow">
        <div class="card-header bg-info text-white">
            <h4 class="mb-0">{{ $beasiswa->nama_beasiswa }}</h4>
        </div>

        <div class="card-body">
            <p><strong>Deskripsi:</strong></p>
            <p>{{ $beasiswa->deskripsi }}</p>

            <hr>

            <p><strong>Jumlah Dana:</strong><br>
                Rp {{ number_format($beasiswa->jumlah_dana, 0, ',', '.') }}</p>

            <p><strong>Periode:</strong><br>
                {{ \Carbon\Carbon::parse($beasiswa->tanggal_buka)->format('d M Y') }} - 
                {{ \Carbon\Carbon::parse($beasiswa->tanggal_tutup)->format('d M Y') }}</p>

            <p><strong>Status:</strong><br>
                @if ($beasiswa->status == 'aktif')
                    <span class="badge bg-success">Aktif</span>
                @else
                    <span class="badge bg-secondary">Nonaktif</span>
                @endif
            </p>

            <p><strong>Persyaratan:</strong></p>
            <p>{{ $beasiswa->persyaratan }}</p>
        </div>

        <div class="card-footer text-end">
            <a href="{{ route('admin.beasiswa.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>
@endsection
