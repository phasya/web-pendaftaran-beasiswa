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
            <div class="section-header text-center mb-5">
                <h2 class="section-title">
                    <i class="fas fa-graduation-cap text-primary me-3"></i>Beasiswa Tersedia
                </h2>
                <p class="section-subtitle">Jelajahi berbagai program beasiswa yang dapat membantu mewujudkan impian pendidikan Anda</p>
            </div>
            
            @if($beasiswas->count() > 0)
                <div class="row g-4">
                    @foreach($beasiswas as $beasiswa)
                        <div class="col-md-6 col-lg-4">
                            <div class="scholarship-card h-100">
                                <!-- Card Header -->
                                <div class="scholarship-header">
                                    <div class="scholarship-badge">
                                        @if($beasiswa->isActive())
                                            <span class="badge-active">
                                                <i class="fas fa-circle me-1"></i>Aktif
                                            </span>
                                        @else
                                            <span class="badge-inactive">
                                                <i class="fas fa-circle me-1"></i>Ditutup
                                            </span>
                                        @endif
                                    </div>
                                    <div class="scholarship-icon">
                                        <i class="fas fa-trophy"></i>
                                    </div>
                                </div>

                                <!-- Card Body -->
                                <div class="scholarship-body">
                                    <h5 class="scholarship-title">{{ $beasiswa->nama_beasiswa }}</h5>
                                    <p class="scholarship-description">{{ Str::limit($beasiswa->deskripsi, 120) }}</p>
                                    
                                    <!-- Scholarship Info Grid -->
                                    <div class="scholarship-info">
                                        <div class="info-item">
                                            <div class="info-icon">
                                                <i class="fas fa-money-bill-wave text-success"></i>
                                            </div>
                                            <div class="info-content">
                                                <label class="info-label">Dana Beasiswa</label>
                                                <p class="info-value text-success">Rp {{ number_format($beasiswa->jumlah_dana, 0, ',', '.') }}</p>
                                            </div>
                                        </div>
                                        
                                        <div class="info-item">
                                            <div class="info-icon">
                                                <i class="fas fa-calendar-alt text-primary"></i>
                                            </div>
                                            <div class="info-content">
                                                <label class="info-label">Periode Pendaftaran</label>
                                                <p class="info-value">
                                                    {{ \Carbon\Carbon::parse($beasiswa->tanggal_buka)->format('d M') }} - 
                                                    {{ \Carbon\Carbon::parse($beasiswa->tanggal_tutup)->format('d M Y') }}
                                                </p>
                                            </div>
                                        </div>
                                        
                                        <div class="info-item full-width">
                                            <div class="info-icon">
                                                <i class="fas fa-list-check text-warning"></i>
                                            </div>
                                            <div class="info-content">
                                                <label class="info-label">Persyaratan Utama</label>
                                                <p class="info-value requirements-text">{{ Str::limit($beasiswa->persyaratan, 100) }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Time Status -->
                                    @php
                                        $today = now();
                                        $openDate = \Carbon\Carbon::parse($beasiswa->tanggal_buka);
                                        $closeDate = \Carbon\Carbon::parse($beasiswa->tanggal_tutup);
                                    @endphp
                                    
                                    <div class="time-status">
                                        @if ($today < $openDate)
                                            <div class="status-upcoming">
                                                <i class="fas fa-clock me-2"></i>
                                                Dibuka dalam {{ $today->diffInDays($openDate) }} hari
                                            </div>
                                        @elseif ($today >= $openDate && $today <= $closeDate)
                                            <div class="status-active">
                                                <i class="fas fa-calendar-check me-2"></i>
                                                Tersisa {{ $today->diffInDays($closeDate) }} hari
                                            </div>
                                        @else
                                            <div class="status-closed">
                                                <i class="fas fa-calendar-times me-2"></i>
                                                Pendaftaran ditutup
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Card Footer -->
                                <div class="scholarship-footer">
                                    @if($beasiswa->isActive())
                                        <a href="{{ route('pendaftar.create', $beasiswa) }}" class="btn-scholarship active">
                                            <i class="fas fa-paper-plane me-2"></i>Daftar Sekarang
                                            <div class="btn-shine"></div>
                                        </a>
                                    @else
                                        <button class="btn-scholarship disabled" disabled>
                                            <i class="fas fa-lock me-2"></i>Pendaftaran Ditutup
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h4 class="empty-title">Belum Ada Beasiswa Tersedia</h4>
                    <p class="empty-description">
                        Saat ini belum ada program beasiswa yang dibuka. 
                        Silakan cek kembali nanti atau hubungi admin untuk informasi lebih lanjut.
                    </p>
                    <button class="btn btn-primary btn-lg mt-3">
                        <i class="fas fa-bell me-2"></i>Berlangganan Notifikasi
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Custom CSS -->
<style>
/* Color Variables */
:root {
    --mint-primary: #00c9a7;
    --mint-secondary: #00bcd4;
    --mint-dark: #00a693;
    --mint-light: #4dd0e1;
    --mint-blue: #0891b2;
    --success-color: #28a745;
    --warning-color: #ffc107;
    --danger-color: #dc3545;
}

/* Hero Carousel Enhancements */
.hero-carousel {
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0,0,0,0.15);
}

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
/* Section Header */
.section-header {
    margin-bottom: 3rem;
}

.section-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 1rem;
}

.section-subtitle {
    font-size: 1.2rem;
    color: #6c757d;
    max-width: 600px;
    margin: 0 auto;
}

/* Scholarship Cards */
.scholarship-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 5px 25px rgba(0,0,0,0.08);
    overflow: hidden;
    transition: all 0.4s ease;
    border: 1px solid #f0f0f0;
    position: relative;
}

.scholarship-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.15);
    border-color: var(--mint-primary);
}

.scholarship-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--mint-primary), var(--mint-blue));
    transform: scaleX(0);
    transition: transform 0.3s ease;
    transform-origin: left;
}

.scholarship-card:hover::before {
    transform: scaleX(1);
}

/* Card Header */
.scholarship-header {
    padding: 2rem 2rem 1rem;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
}

.scholarship-badge .badge-active {
    background: linear-gradient(45deg, var(--success-color), #20c997);
    color: white;
    padding: 8px 16px;
    border-radius: 25px;
    font-size: 0.85rem;
    font-weight: 600;
    box-shadow: 0 2px 10px rgba(40, 167, 69, 0.3);
}

.scholarship-badge .badge-inactive {
    background: linear-gradient(45deg, var(--danger-color), #e74c3c);
    color: white;
    padding: 8px 16px;
    border-radius: 25px;
    font-size: 0.85rem;
    font-weight: 600;
    box-shadow: 0 2px 10px rgba(220, 53, 69, 0.3);
}

.scholarship-icon {
    font-size: 3rem;
    color: var(--mint-primary);
    opacity: 0.8;
}

/* Card Body */
.scholarship-body {
    padding: 0 2rem 1rem;
}

.scholarship-title {
    font-size: 1.4rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 1rem;
    line-height: 1.3;
}

.scholarship-description {
    color: #6c757d;
    font-size: 0.95rem;
    line-height: 1.6;
    margin-bottom: 1.5rem;
}

/* Info Grid */
.scholarship-info {
    display: grid;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.info-item {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.info-item:hover {
    background: #e3f2fd;
    transform: translateX(5px);
}

.info-item.full-width {
    grid-column: 1 / -1;
}

.info-icon {
    font-size: 1.5rem;
    min-width: 30px;
    text-align: center;
}

.info-content {
    flex: 1;
}

.info-label {
    font-size: 0.8rem;
    font-weight: 600;
    color: #6c757d;
    margin-bottom: 0.25rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.info-value {
    font-size: 0.95rem;
    color: #2c3e50;
    font-weight: 500;
    margin: 0;
    line-height: 1.4;
}

.requirements-text {
    font-size: 0.9rem;
    color: #495057;
}

/* Time Status */
.time-status {
    margin-bottom: 1.5rem;
}

.status-upcoming, .status-active, .status-closed {
    padding: 10px 15px;
    border-radius: 8px;
    font-size: 0.9rem;
    font-weight: 600;
    text-align: center;
}

.status-upcoming {
    background: linear-gradient(45deg, #fff3cd, #ffeaa7);
    color: #856404;
    border: 1px solid #ffeaa7;
}

.status-active {
    background: linear-gradient(45deg, #d4edda, #c3e6cb);
    color: #155724;
    border: 1px solid #c3e6cb;
}

.status-closed {
    background: linear-gradient(45deg, #f8d7da, #f5c6cb);
    color: #721c24;
    border: 1px solid #f5c6cb;
}

/* Card Footer */
.scholarship-footer {
    padding: 1.5rem 2rem 2rem;
}

.btn-scholarship {
    width: 100%;
    padding: 15px 25px;
    border-radius: 12px;
    font-weight: 600;
    font-size: 1rem;
    text-decoration: none;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    border: none;
}

.btn-scholarship.active {
    background: linear-gradient(45deg, var(--mint-primary), var(--mint-blue));
    color: white;
    box-shadow: 0 4px 15px rgba(0, 201, 167, 0.4);
}

.btn-scholarship.active:hover {
    background: linear-gradient(45deg, var(--mint-dark), #0671a6);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 201, 167, 0.5);
}

.btn-scholarship.disabled {
    background: #e9ecef;
    color: #6c757d;
    cursor: not-allowed;
}

.btn-shine {
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    transition: left 0.5s ease;
}

.btn-scholarship.active:hover .btn-shine {
    left: 100%;
}

/* CTA Section */
.cta-section {
    margin-top: 4rem;
}

.cta-card {
    background: linear-gradient(135deg, var(--mint-primary), var(--mint-blue));
    color: white;
    padding: 3rem;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 201, 167, 0.3);
}

.cta-title {
    font-size: 1.8rem;
    font-weight: 700;
    margin-bottom: 1rem;
}

.cta-description {
    font-size: 1.1rem;
    opacity: 0.9;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    color: #6c757d;
}

.empty-icon {
    font-size: 5rem;
    margin-bottom: 2rem;
    opacity: 0.5;
}

.empty-title {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 1rem;
    color: #495057;
}

.empty-description {
    font-size: 1.1rem;
    max-width: 500px;
    margin: 0 auto;
    line-height: 1.6;
}

/* Responsive Design */
@media (max-width: 768px) {
    .carousel-slide {
        min-height: 350px;
        height: 350px;
        padding: 2rem 1rem;
    }
    
    .slide-title {
        font-size: 2.5rem;
    }
    
    .hero-icon {
        font-size: 5rem;
    }
    
    .section-title {
        font-size: 2rem;
    }
    
    .scholarship-header,
    .scholarship-body,
    .scholarship-footer {
        padding-left: 1.5rem;
        padding-right: 1.5rem;
    }
    
    .scholarship-info {
        grid-template-columns: 1fr;
    }
    
    .cta-card {
        padding: 2rem;
        text-align: center;
    }
    
    .cta-title {
        font-size: 1.5rem;
    }
}

@media (max-width: 576px) {
    .scholarship-header,
    .scholarship-body,
    .scholarship-footer {
        padding-left: 1rem;
        padding-right: 1rem;
    }
    
    .scholarship-header {
        flex-direction: column;
        align-items: center;
        text-align: center;
        gap: 1rem;
    }
    
    .info-item {
        flex-direction: column;
        text-align: center;
        gap: 0.5rem;
    }
}

/* Animation Classes */
.scholarship-card {
    animation: fadeInUp 0.6s ease forwards;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Staggered Animation */
.scholarship-card:nth-child(1) { animation-delay: 0.1s; }
.scholarship-card:nth-child(2) { animation-delay: 0.2s; }
.scholarship-card:nth-child(3) { animation-delay: 0.3s; }
.scholarship-card:nth-child(4) { animation-delay: 0.4s; }
.scholarship-card:nth-child(5) { animation-delay: 0.5s; }
.scholarship-card:nth-child(6) { animation-delay: 0.6s; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Add loading animation to scholarship cards
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animationPlayState = 'running';
            }
        });
    }, observerOptions);

    document.querySelectorAll('.scholarship-card').forEach(card => {
        card.style.animationPlayState = 'paused';
        observer.observe(card);
    });

    // Enhanced carousel auto-play pause on hover
    const carousel = document.getElementById('heroCarousel');
    if (carousel) {
        carousel.addEventListener('mouseenter', () => {
            carousel.setAttribute('data-bs-interval', 'false');
        });
        
        carousel.addEventListener('mouseleave', () => {
            carousel.setAttribute('data-bs-interval', '5000');
        });
    }

    // Add click analytics (optional)
    document.querySelectorAll('.btn-scholarship.active').forEach(btn => {
        btn.addEventListener('click', function(e) {
            // Track scholarship application clicks
            console.log('Scholarship application clicked:', this.closest('.scholarship-card').querySelector('.scholarship-title').textContent);
        });
    });
});
</script>
@endsection