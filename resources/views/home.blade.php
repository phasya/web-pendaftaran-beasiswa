@extends('layouts.app')

@section('title', 'Pendaftaran Beasiswa')

@section('content')
    <div class="container">
        <div class="row mb-5">
            <div class="col-12">
                <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
                    <div class="carousel-indicators">
                        @if($beasiswas->count() > 0)
                            @foreach($beasiswas as $index => $beasiswa)
                                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $index }}" 
                                        @if($index == 0) class="active" aria-current="true" @endif 
                                        aria-label="Slide {{ $index + 1 }}"></button>
                            @endforeach
                        @else
                            <!-- Default indicators if no scholarships -->
                            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        @endif
                    </div>

                    <!-- Carousel Inner -->
                    <div class="carousel-inner rounded">
                        @if($beasiswas->count() > 0)
                            @foreach($beasiswas as $index => $beasiswa)
                                <div class="carousel-item @if($index == 0) active @endif">
                                    <div class="carousel-slide d-flex align-items-center scholarship-slide" 
                                         style="background: {{ $beasiswa->isActive() ? 'linear-gradient(135deg, #FFE100 0%, #FFC900 30%, #FF9B00 100%)' : 'linear-gradient(135deg, #FFB6C1 0%, #FFA07A 30%, #CD5C5C 100%)' }};"
                                         data-scholarship-id="{{ $beasiswa->id }}">
                                        <div class="container">
                                            <div class="row align-items-center">
                                                <div class="col-md-8">
                                                    <!-- Status Badge -->
                                                    <div class="mb-3">
                                                        @if($beasiswa->isActive())
                                                            <span class="badge bg-success fs-6 px-3 py-2">
                                                                <i class="fas fa-circle me-1"></i>Pendaftaran Dibuka
                                                            </span>
                                                        @else
                                                            <span class="badge bg-danger fs-6 px-3 py-2">
                                                                <i class="fas fa-circle me-1"></i>Pendaftaran Ditutup
                                                            </span>
                                                        @endif
                                                    </div>

                                                    <h1 class="display-4 fw-bold mb-3">
                                                        <i class="fas fa-graduation-cap"></i> {{ $beasiswa->nama_beasiswa }}
                                                    </h1>

                                                    <p class="lead mb-3">{{ Str::limit($beasiswa->deskripsi, 150) }}</p>

                                                    <!-- Quick Info -->
                                                    <div class="row mb-4">
                                                        <div class="col-md-6">
                                                            <p class="mb-2"><i class="fas fa-calendar me-2"></i><strong>Di Buka:</strong> {{ \Carbon\Carbon::parse($beasiswa->tanggal_buka)->format('d M Y') }}</p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p class="mb-2"><i class="fas fa-money-bill-wave me-2"></i><strong>Dana:</strong> Rp {{ number_format($beasiswa->jumlah_dana, 0, ',', '.') }}</p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p class="mb-2"><i class="fas fa-calendar me-2"></i><strong>Batas:</strong> {{ \Carbon\Carbon::parse($beasiswa->tanggal_tutup)->format('d M Y') }}</p>
                                                        </div>
                                                    </div>

                                                    @if($beasiswa->isActive())
                                                        <a href="{{ route('pendaftar.create', $beasiswa) }}" class="btn btn-light btn-lg carousel-cta-btn">
                                                            <i class="fas fa-paper-plane me-2"></i>Daftar Sekarang
                                                        </a>
                                                    @else
                                                        <button class="btn btn-outline-light btn-lg" disabled>
                                                            <i class="fas fa-lock me-2"></i>Pendaftaran Ditutup
                                                        </button>
                                                    @endif
                                                </div>
                                                <div class="col-md-4 text-center">
                                                    <div class="carousel-icon-container">
                                                        <i class="fas fa-trophy fa-5x opacity-75"></i>
                                                        <div class="icon-decoration"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <!-- Default slide if no scholarships -->
                            <div class="carousel-item active">
                                <div class="carousel-slide d-flex align-items-center" style="background: linear-gradient(135deg, #7FFFD4 0%, #40E0D0 30%, #4682B4 100%);">
                                    <div class="container">
                                        <div class="row align-items-center">
                                            <div class="col-md-8">
                                                <h1 class="display-4 fw-bold mb-3">
                                                    <i class="fas fa-graduation-cap"></i> Sistem Pendaftaran Beasiswa
                                                </h1>
                                                <p class="lead mb-4">Temukan dan daftarkan diri Anda untuk berbagai program beasiswa yang tersedia</p>
                                                <p class="mb-4">Saat ini belum ada beasiswa yang tersedia. Silakan cek kembali nanti!</p>

                                            </div>
                                            <div class="col-md-4 text-center">
                                                <i class="fas fa-graduation-cap fa-5x opacity-75"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Carousel Controls -->
                    @if($beasiswas->count() > 1)
                        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    @endif
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
                    --gold-primary: #FBC02D;
            /* warm golden yellow */
            --gold-secondary: #FFA000;
            /* amber */
            --gold-dark: #FF8F00;
            /* darker amber */
            --gold-light: #FFF8E1;
            /* soft cream */
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
        cursor: pointer;
    }

    .carousel-slide {
        min-height: 450px;
        height: 450px;
        padding: 3rem 1.5rem;
        color: white;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        position: relative;
        overflow: hidden;
    }

    /* Scholarship slide specific styling */
    .scholarship-slide::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.1);
        transition: background 0.3s ease;
    }

    .scholarship-slide:hover::before {
        background: rgba(0,0,0,0.05);
    }

    /* Carousel icon container */
    .carousel-icon-container {
        position: relative;
        display: inline-block;
    }

    .icon-decoration {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 120px;
        height: 120px;
        border: 3px solid rgba(255,255,255,0.3);
        border-radius: 50%;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { transform: translate(-50%, -50%) scale(1); opacity: 1; }
        50% { transform: translate(-50%, -50%) scale(1.1); opacity: 0.7; }
        100% { transform: translate(-50%, -50%) scale(1); opacity: 1; }
    }

    /* Carousel CTA button */
    .carousel-cta-btn {
        background: rgba(255,255,255,0.95) !important;
        color: #2c3e50 !important;
        border: none !important;
        padding: 15px 30px;
        font-weight: 600;
        border-radius: 50px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .carousel-cta-btn:hover {
        background: white !important;
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.3);
        color: var(--mint-primary) !important;
    }

    .carousel-indicators button {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        margin: 0 5px;
        background-color: rgba(255,255,255,0.5);
        border: 2px solid white;
    }

    .carousel-indicators .active {
        background-color: white;
    }

    .carousel-control-prev,
    .carousel-control-next {
        width: 5%;
    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        width: 30px;
        height: 30px;
        background-color: rgba(255,255,255,0.8);
        border-radius: 50%;
    }

    /* Click to register functionality */
    .scholarship-slide[data-scholarship-id] {
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .scholarship-slide[data-scholarship-id]:hover {
        transform: scale(1.02);
    }

    @media (max-width: 768px) {
        .carousel-slide {
            min-height: 350px;
            height: 350px;
            padding: 2rem 1rem;
        }

        .display-4 {
            font-size: 2rem !important;
        }

        .fa-5x {
            font-size: 3rem !important;
        }

        .icon-decoration {
            width: 80px;
            height: 80px;
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
        border-color: var(--gold-primary);
    }

    .scholarship-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--gold-primary), var(--gold-light));
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
        background: linear-gradient(45deg, var(--gold-primary), var(--gold-secondary));
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

        // Carousel click to register functionality
        document.querySelectorAll('.scholarship-slide[data-scholarship-id]').forEach(slide => {
            slide.addEventListener('click', function(e) {
                // Avoid triggering when clicking on the button itself
                if (!e.target.closest('.carousel-cta-btn') && !e.target.closest('.btn')) {
                    const scholarshipId = this.getAttribute('data-scholarship-id');

                    // Check if the slide is for an active scholarship
                    const ctaButton = this.querySelector('.carousel-cta-btn');
                    if (ctaButton) {
                        // Add visual feedback
                        this.style.transform = 'scale(0.98)';
                        setTimeout(() => {
                            this.style.transform = '';
                            window.location.href = ctaButton.href;
                        }, 150);
                    }
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

        // Add click analytics and visual feedback
        document.querySelectorAll('.btn-scholarship.active').forEach(btn => {
            btn.addEventListener('click', function(e) {
                // Add loading state
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memproses...';

                // Reset after a short delay (in case of slow navigation)
                setTimeout(() => {
                    if (this.innerHTML.includes('Memproses')) {
                        this.innerHTML = originalText;
                    }
                }, 3000);

                // Track scholarship application clicks
                console.log('Scholarship application clicked:', this.closest('.scholarship-card').querySelector('.scholarship-title').textContent);
            });
        });

        // Add visual feedback for carousel interactions
        document.querySelectorAll('.carousel-indicators button').forEach(indicator => {
            indicator.addEventListener('click', function() {
                // Add ripple effect
                this.style.transform = 'scale(0.8)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 200);
            });
        });

        // Auto-update carousel indicators when new scholarships are added
        const updateCarouselIndicators = () => {
            const indicators = document.querySelector('.carousel-indicators');
            const slides = document.querySelectorAll('.carousel-item');

            if (indicators && slides.length > 0) {
                indicators.innerHTML = '';
                slides.forEach((slide, index) => {
                    const button = document.createElement('button');
                    button.type = 'button';
                    button.setAttribute('data-bs-target', '#heroCarousel');
                    button.setAttribute('data-bs-slide-to', index);
                    button.setAttribute('aria-label', `Slide ${index + 1}`);

                    if (index === 0) {
                        button.className = 'active';
                        button.setAttribute('aria-current', 'true');
                    }

                    indicators.appendChild(button);
                });
            }
        };

        // Call update function on page load
        updateCarouselIndicators();
    });
    </script>
@endsection