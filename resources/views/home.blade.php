@extends('layouts.app')

@section('title', 'Sistem Pendaftaran Beasiswa')

@section('content')
<div class="container">
    <!-- Hero Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="jumbotron bg-primary text-white p-5 rounded">
                <h1 class="display-4">
                    <i class="fas fa-graduation-cap"></i> Sistem Pendaftaran Beasiswa
                </h1>
                <p class="lead">Temukan dan daftarkan diri Anda untuk berbagai program beasiswa yang tersedia</p>
                <hr class="my-4">
                <p>Jangan lewatkan kesempatan emas untuk meraih pendidikan yang lebih baik!</p>
            </div>
        </div>
    </div>

    <!-- Beasiswa List -->
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4">
                <i class="fas fa-list"></i> Beasiswa Tersedia
            </h2>
            
            @if($beasiswas->count() > 0)
                <div class="row">
                    @foreach($beasiswas as $beasiswa)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card h-100 shadow-sm">
                                <div class="card-header bg-success text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-trophy"></i> {{ $beasiswa->nama_beasiswa }}
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">{{ Str::limit($beasiswa->deskripsi, 100) }}</p>
                                    
                                    <div class="mb-3">
                                        <strong><i class="fas fa-money-bill-wave"></i> Dana:</strong><br>
                                        <span class="text-success h5">Rp {{ number_format($beasiswa->jumlah_dana, 0, ',', '.') }}</span>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <strong><i class="fas fa-calendar"></i> Periode:</strong><br>
                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($beasiswa->tanggal_buka)->format('d/m/Y') }} - 
                                            {{ \Carbon\Carbon::parse($beasiswa->tanggal_tutup)->format('d/m/Y') }}
                                        </small>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <strong><i class="fas fa-list-check"></i> Persyaratan:</strong><br>
                                        <small class="text-muted">{{ Str::limit($beasiswa->persyaratan, 80) }}</small>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    @if($beasiswa->isActive())
                                        <a href="{{ route('pendaftar.create', $beasiswa) }}" 
                                           class="btn btn-primary btn-sm w-100">
                                            <i class="fas fa-paper-plane"></i> Daftar Sekarang
                                        </a>
                                        <small class="text-success mt-2 d-block">
                                            <i class="fas fa-circle"></i> Pendaftaran Dibuka
                                        </small>
                                    @else
                                        <button class="btn btn-secondary btn-sm w-100" disabled>
                                            <i class="fas fa-times-circle"></i> Pendaftaran Ditutup
                                        </button>
                                        <small class="text-danger mt-2 d-block">
                                            <i class="fas fa-circle"></i> Tidak Aktif
                                        </small>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-info text-center" role="alert">
                    <i class="fas fa-info-circle fa-2x mb-3"></i>
                    <h4>Belum Ada Beasiswa Tersedia</h4>
                    <p>Saat ini belum ada program beasiswa yang dibuka. Silakan cek kembali nanti.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection