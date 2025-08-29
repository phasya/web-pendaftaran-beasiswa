@extends('layouts.admin')

@section('title', 'Detail Beasiswa')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <div>
            <h1 class="h2"><i class="fas fa-graduation-cap text-primary"></i> Detail Beasiswa</h1>
            <p class="text-muted mb-0">
                <i class="fas fa-info-circle me-2"></i>Informasi lengkap tentang program beasiswa
            </p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <!-- Main Detail Card -->
            <div class="card shadow-sm">
                <div class="card-header py-3">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="card-title mb-1 text-white">
                                <i class="fas fa-trophy me-2"></i>{{ $beasiswa->nama_beasiswa }}
                            </h5>
                            <small class="text-white-50">
                                <i class="fas fa-calendar me-1"></i>Dibuat pada
                                {{ \Carbon\Carbon::parse($beasiswa->created_at)->format('d M Y') }}
                            </small>
                        </div>
                        <div class="col-auto">
                            @if ($beasiswa->status == 'aktif')
                                <span class="badge bg-success-soft text-success px-3 py-2">
                                    <i class="fas fa-check-circle me-1"></i>Aktif
                                </span>
                            @else
                                <span class="badge bg-secondary-soft text-secondary px-3 py-2">
                                    <i class="fas fa-times-circle me-1"></i>Nonaktif
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <!-- Deskripsi Section -->
                    <div class="detail-section mb-4">
                        <h6 class="section-title mb-3">
                            <i class="fas fa-align-left text-primary me-2"></i>Deskripsi Beasiswa
                        </h6>
                        <div class="content-box">
                            <p class="mb-0">{{ $beasiswa->deskripsi }}</p>
                        </div>
                    </div>

                    <!-- Financial & Schedule Section -->
                    <div class="detail-section mb-4">
                        <h6 class="section-title mb-3">
                            <i class="fas fa-calendar-dollar text-success me-2"></i>Dana & Jadwal
                        </h6>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="info-card h-100">
                                    <div class="info-icon">
                                        <i class="fas fa-money-bill-wave text-success"></i>
                                    </div>
                                    <div class="info-content">
                                        <h6 class="info-title">Jumlah Dana</h6>
                                        <p class="info-value text-success fw-bold">
                                            Rp {{ number_format($beasiswa->jumlah_dana, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="info-card h-100">
                                    <div class="info-icon">
                                        <i class="fas fa-calendar-plus text-primary"></i>
                                    </div>
                                    <div class="info-content">
                                        <h6 class="info-title">Tanggal Buka</h6>
                                        <p class="info-value text-primary fw-bold">
                                            {{ \Carbon\Carbon::parse($beasiswa->tanggal_buka)->format('d M Y') }}
                                        </p>
                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($beasiswa->tanggal_buka)->diffForHumans() }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="info-card h-100">
                                    <div class="info-icon">
                                        <i class="fas fa-calendar-times text-danger"></i>
                                    </div>
                                    <div class="info-content">
                                        <h6 class="info-title">Tanggal Tutup</h6>
                                        <p class="info-value text-danger fw-bold">
                                            {{ \Carbon\Carbon::parse($beasiswa->tanggal_tutup)->format('d M Y') }}
                                        </p>
                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($beasiswa->tanggal_tutup)->diffForHumans() }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Period Status -->
                        <div class="period-status mt-3">
                            @php
                                $today = now();
                                $openDate = \Carbon\Carbon::parse($beasiswa->tanggal_buka);
                                $closeDate = \Carbon\Carbon::parse($beasiswa->tanggal_tutup);
                                $totalDays = $openDate->diffInDays($closeDate);
                            @endphp

                            @if ($today < $openDate)
                                <div class="alert alert-info-soft">
                                    <i class="fas fa-clock me-2"></i>
                                    Pendaftaran akan dibuka dalam <strong>{{ $today->diffInDays($openDate) }} hari</strong>
                                    (Durasi: {{ $totalDays }} hari)
                                </div>
                            @elseif ($today >= $openDate && $today <= $closeDate)
                                <div class="alert alert-success-soft">
                                    <i class="fas fa-calendar-check me-2"></i>
                                    Pendaftaran <strong>sedang berlangsung</strong> -
                                    Tersisa <strong>{{ $today->diffInDays($closeDate) }} hari</strong>
                                </div>
                            @else
                                <div class="alert alert-danger-soft">
                                    <i class="fas fa-calendar-times me-2"></i>
                                    Pendaftaran telah <strong>berakhir</strong> sejak {{ $today->diffInDays($closeDate) }} hari
                                    yang lalu
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Requirements Section -->
                    <div class="detail-section mb-4">
                        <h6 class="section-title mb-3">
                            <i class="fas fa-list-check text-warning me-2"></i>Persyaratan Pendaftaran
                        </h6>
                        <div class="content-box">
                            <div class="requirements-text">
                                {!! nl2br(e($beasiswa->persyaratan)) !!}
                            </div>
                        </div>
                    </div>

                    <!-- Statistics Section (if data available) -->
                    @if(isset($statistik))
                        <div class="detail-section mb-4">
                            <h6 class="section-title mb-3">
                                <i class="fas fa-chart-bar text-primary me-2"></i>Statistik Pendaftaran
                            </h6>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="stat-card">
                                        <div class="stat-number text-primary">{{ $statistik['total_pendaftar'] ?? 0 }}</div>
                                        <div class="stat-label">Total Pendaftar</div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="stat-card">
                                        <div class="stat-number text-warning">{{ $statistik['pending'] ?? 0 }}</div>
                                        <div class="stat-label">Menunggu Review</div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="stat-card">
                                        <div class="stat-number text-success">{{ $statistik['diterima'] ?? 0 }}</div>
                                        <div class="stat-label">Diterima</div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="stat-card">
                                        <div class="stat-number text-danger">{{ $statistik['ditolak'] ?? 0 }}</div>
                                        <div class="stat-label">Ditolak</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Action Buttons Card -->
            <div class="card shadow-sm mt-4">
                <div class="card-body">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                        <div class="d-flex align-items-center text-muted">
                            <i class="fas fa-info-circle me-2"></i>
                            <small>Detail beasiswa dapat diubah melalui menu edit</small>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.beasiswa.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                            <a href="{{ route('admin.beasiswa.edit', $beasiswa) }}" class="btn btn-warning">
                                <i class="fas fa-edit me-2"></i>Edit Beasiswa
                            </a>
                            @if($beasiswa->status == 'aktif')
                                <a href="#" class="btn btn-primary" onclick="copyLink()">
                                    <i class="fas fa-share me-2"></i>Bagikan Link
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Info Cards -->
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card shadow-sm border-start border-primary border-4">
                        <div class="card-body">
                            <h6 class="card-title text-primary">
                                <i class="fas fa-lightbulb me-2"></i>Tips untuk Admin
                            </h6>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2">
                                    <i class="fas fa-check text-success me-2"></i>
                                    <small>Monitor pendaftaran secara berkala</small>
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check text-success me-2"></i>
                                    <small>Pastikan informasi selalu up-to-date</small>
                                </li>
                                <li>
                                    <i class="fas fa-check text-success me-2"></i>
                                    <small>Berikan feedback cepat kepada pendaftar</small>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card shadow-sm border-start border-warning border-4">
                        <div class="card-body">
                            <h6 class="card-title text-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>Perhatian
                            </h6>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2">
                                    <i class="fas fa-info text-info me-2"></i>
                                    <small>Perubahan status akan mempengaruhi visibilitas</small>
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-info text-info me-2"></i>
                                    <small>Backup data sebelum melakukan perubahan besar</small>
                                </li>
                                <li>
                                    <i class="fas fa-info text-info me-2"></i>
                                    <small>Koordinasi dengan tim terkait perubahan jadwal</small>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom CSS -->
    <style>
        /* Updated Color Palette - Orange/Yellow Theme */
        :root {
            --primary-orange: #FF9B00;
            --primary-yellow: #FFE100;
            --secondary-yellow: #FFC900;
            --light-yellow: #EBE389;
            --dark-orange: #e8890a;
            --gradient-warm: linear-gradient(135deg, #FF9B00, #FFE100, #FFC900);
            --gradient-warm-hover: linear-gradient(135deg, #e8890a, #e6cb00, #e6b800);
        }

        /* Status Badge Colors with warm theme */
        .bg-success-soft {
            background-color: #d4edda !important;
            color: #155724 !important;
        }

        .bg-warning-soft {
            background-color: #fff3cd !important;
            color: #856404 !important;
        }

        .bg-danger-soft {
            background-color: #f8d7da !important;
            color: #721c24 !important;
        }

        .bg-info-soft {
            background-color: #d1ecf1 !important;
            color: #0c5460 !important;
        }

        .bg-secondary-soft {
            background-color: #e2e3e5 !important;
            color: #383d41 !important;
        }

        /* Alert styling with warm colors */
        .alert-info-soft {
            background: linear-gradient(45deg, #d1ecf1, var(--light-yellow));
            border: 1px solid #bee5eb;
            color: #0c5460;
            border-radius: 8px;
            border-left: 4px solid var(--primary-orange) !important;
        }

        .alert-success-soft {
            background: linear-gradient(45deg, #d1f2eb, var(--light-yellow));
            border: 1px solid #a7e5d0;
            color: #0f5132;
            border-radius: 8px;
            border-left: 4px solid #28a745 !important;
        }

        .alert-danger-soft {
            background: linear-gradient(45deg, #f8d7da, #ffe6e6);
            border: 1px solid #f1aeb5;
            color: #842029;
            border-radius: 8px;
            border-left: 4px solid #dc3545 !important;
        }

        /* Detail sections with warm accent */
        .detail-section {
            border-left: 4px solid var(--primary-orange);
            padding-left: 1rem;
            margin-left: 0.5rem;
        }

        .section-title {
            font-weight: 600;
            color: #495057;
            font-size: 1rem;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--light-yellow);
        }

        /* Content boxes with warm gradient */
        .content-box {
            background: linear-gradient(45deg, #fefefe, var(--light-yellow));
            border: 1px solid var(--secondary-yellow);
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 2px 8px rgba(255, 155, 0, 0.1);
        }

        /* Info cards with warm theme */
        .info-card {
            background: linear-gradient(135deg, #ffffff, #fffcf0);
            border: 1px solid var(--light-yellow);
            border-radius: 10px;
            padding: 1.5rem;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(255, 155, 0, 0.15);
        }

        .info-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(255, 155, 0, 0.25);
            border-color: var(--primary-orange);
        }

        .info-icon {
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        .info-title {
            font-size: 0.875rem;
            font-weight: 600;
            color: #6c757d;
            margin-bottom: 0.5rem;
        }

        .info-value {
            font-size: 1.25rem;
            margin-bottom: 0;
        }

        /* Statistics cards with warm colors */
        .stat-card {
            background: linear-gradient(135deg, #ffffff, #fffcf0);
            border: 1px solid var(--light-yellow);
            border-radius: 8px;
            padding: 1rem;
            text-align: center;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 155, 0, 0.2);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 0.875rem;
            color: #6c757d;
            font-weight: 500;
        }

        /* Requirements styling */
        .requirements-text {
            font-size: 1rem;
            line-height: 1.6;
            color: #495057;
        }

        /* Button enhancements with warm colors */
        .btn {
            border-radius: 0.375rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: var(--gradient-warm);
            border: none;
            color: white;
        }

        .btn-primary:hover {
            background: var(--gradient-warm-hover);
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(255, 155, 0, 0.4);
        }

        .btn-warning {
            background: linear-gradient(45deg, var(--secondary-yellow), var(--primary-orange));
            border: none;
            color: white;
        }

        .btn-warning:hover {
            background: linear-gradient(45deg, var(--dark-orange), #e6b800);
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(255, 201, 0, 0.4);
        }

        .btn-outline-secondary:hover {
            transform: translateY(-1px);
            background: var(--light-yellow);
            border-color: var(--primary-orange);
            color: #495057;
        }

        /* Card consistency with warm theme */
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(255, 155, 0, 0.1);
        }

        .card-header {
            border-bottom: 2px solid var(--light-yellow);
            background: var(--gradient-warm);
            color: white;
        }

        .card-title {
            font-weight: 600;
            color: inherit;
        }

        /* Text colors with warm theme */
        .text-primary {
            color: var(--primary-orange) !important;
        }

        .text-warning {
            color: var(--dark-orange) !important;
        }

        /* Border colors */
        .border-primary {
            border-color: var(--primary-orange) !important;
        }

        .border-warning {
            border-color: var(--secondary-yellow) !important;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .detail-section {
                border-left: none;
                border-top: 3px solid var(--primary-orange);
                padding-left: 0;
                padding-top: 1rem;
                margin-left: 0;
            }

            .info-card {
                margin-bottom: 1rem;
            }

            .d-flex.gap-2 {
                flex-direction: column;
                width: 100%;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }

        /* Scrollable content styling with warm theme */
        .scrollable-content {
            border: 2px solid var(--light-yellow);
        }

        .scrollable-content::-webkit-scrollbar {
            width: 6px;
        }

        .scrollable-content::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }

        .scrollable-content::-webkit-scrollbar-thumb {
            background: var(--primary-orange);
            border-radius: 3px;
        }

        .scrollable-content::-webkit-scrollbar-thumb:hover {
            background: var(--dark-orange);
        }

        /* Enhanced hover effects */
        .card:hover {
            box-shadow: 0 4px 15px rgba(255, 155, 0, 0.15);
        }

        /* Badge enhancements */
        .badge {
            border-radius: 20px;
            font-weight: 500;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Copy link functionality
            window.copyLink = function () {
                const url = window.location.href.replace('/admin/', '/');
                navigator.clipboard.writeText(url).then(function () {
                    // Show success message
                    const btn = event.target.closest('.btn');
                    const originalText = btn.innerHTML;
                    btn.innerHTML = '<i class="fas fa-check me-2"></i>Tersalin!';
                    btn.classList.remove('btn-primary');
                    btn.classList.add('btn-success');

                    setTimeout(() => {
                        btn.innerHTML = originalText;
                        btn.classList.remove('btn-success');
                        btn.classList.add('btn-primary');
                    }, 2000);
                }).catch(function () {
                    alert('Gagal menyalin link. Silakan copy manual: ' + url);
                });
            }

            // Smooth scroll for long content
            document.querySelectorAll('.content-box').forEach(box => {
                if (box.scrollHeight > 300) {
                    box.style.maxHeight = '300px';
                    box.style.overflowY = 'auto';
                    box.classList.add('scrollable-content');
                }
            });

            // Auto-refresh status if needed
            setInterval(function () {
                const periodStatus = document.querySelector('.period-status');
                if (periodStatus) {
                    // This could be enhanced to auto-update the status
                    // without full page reload if needed
                }
            }, 60000); // Check every minute

            // Tooltip initialization
            if (typeof bootstrap !== 'undefined') {
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            }

            // Add subtle animations to cards
            const cards = document.querySelectorAll('.card');
            const observer = new IntersectionObserver(
                (entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.style.opacity = '1';
                            entry.target.style.transform = 'translateY(0)';
                        }
                    });
                },
                { threshold: 0.1 }
            );

            cards.forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'all 0.6s ease';
                observer.observe(card);
            });
        });
    </script>
@endsection