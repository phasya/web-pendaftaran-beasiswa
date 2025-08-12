@extends('layouts.app')

@section('title', 'Sistem Pendaftaran Beasiswa')

@section('content')
<div class="container">
    <!-- Hero Carousel Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
                <!-- Carousel Indicators -->
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>

                <!-- Carousel Inner -->
                <div class="carousel-inner rounded">
                    <!-- Slide 1 -->
                    <div class="carousel-item active">
                        <div class="carousel-slide d-flex align-items-center" style="background: linear-gradient(135deg, #7FFFD4 0%, #40E0D0 30%, #4682B4 100%);">
                            <div class="container">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <h1 class="display-4 fw-bold mb-3">
                                            <i class="fas fa-graduation-cap"></i> Sistem Pendaftaran Beasiswa
                                        </h1>
                                        <p class="lead mb-4">Temukan dan daftarkan diri Anda untuk berbagai program beasiswa yang tersedia</p>
                                        <p class="mb-4">Jangan lewatkan kesempatan emas untuk meraih pendidikan yang lebih baik!</p>
                                        <a href="#beasiswa-list" class="btn btn-light btn-lg">
                                            <i class="fas fa-search"></i> Lihat Beasiswa
                                        </a>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <i class="fas fa-graduation-cap fa-5x opacity-75"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 2 -->
                    <div class="carousel-item">
                        <div class="carousel-slide d-flex align-items-center" style="background: linear-gradient(135deg, #98FB98 0%, #20B2AA 50%, #5F9EA0 100%);">
                            <div class="container">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <h1 class="display-4 fw-bold mb-3">
                                            <i class="fas fa-trophy"></i> Raih Beasiswa Impianmu
                                        </h1>
                                        <p class="lead mb-4">Berbagai program beasiswa dengan dana jutaan rupiah menanti Anda</p>
                                        <p class="mb-4">Mulai dari beasiswa akademik hingga beasiswa prestasi khusus</p>
                                        <a href="#beasiswa-list" class="btn btn-light btn-lg">
                                            <i class="fas fa-paper-plane"></i> Daftar Sekarang
                                        </a>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <i class="fas fa-trophy fa-5x opacity-75"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 3 -->
                    <div class="carousel-item">
                        <div class="carousel-slide d-flex align-items-center" style="background: linear-gradient(135deg, #AFEEEE 0%, #48CAE4 40%, #0077B6 100%);">
                            <div class="container">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <h1 class="display-4 fw-bold mb-3">
                                            <i class="fas fa-star"></i> Wujudkan Masa Depan Cerah
                                        </h1>
                                        <p class="lead mb-4">Dengan beasiswa, pendidikan berkualitas bukan lagi impian</p>
                                        <p class="mb-4">Bergabunglah dengan ribuan mahasiswa yang telah merasakan manfaatnya</p>
                                        <a href="#beasiswa-list" class="btn btn-light btn-lg">
                                            <i class="fas fa-rocket"></i> Mulai Perjalanan
                                        </a>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <i class="fas fa-star fa-5x opacity-75"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Carousel Controls -->
                <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Beasiswa List -->
    <div class="row" id="beasiswa-list">
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

<style>
    .carousel-item {
        transition: transform 0.6s ease-in-out;
    }
    
    .carousel-slide {
        min-height: 400px;
        height: 400px;
        padding: 3rem 1.5rem;
        color: white;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    }
    
    .carousel-indicators button {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        margin: 0 5px;
    }
    
    .carousel-control-prev,
    .carousel-control-next {
        width: 5%;
    }
    
    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        width: 30px;
        height: 30px;
    }
    
    @media (max-width: 768px) {
        .carousel-slide {
            min-height: 300px;
            height: 300px;
            padding: 2rem 1rem;
        }
        
        .display-4 {
            font-size: 2rem !important;
        }
        
        .fa-5x {
            font-size: 3rem !important;
        }
    }
</style>
@endsection