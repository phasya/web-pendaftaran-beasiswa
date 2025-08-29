@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
        <!-- Welcome Header -->
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <div>
                <h1 class="h2"><i class="fas fa-tachometer-alt text-primary"></i> Dashboard Admin</h1>
                <p class="text-muted mb-0">
                    <i class="fas fa-user me-2"></i>Selamat datang, <strong>{{ auth()->user()->name }}</strong>
                    <span class="mx-2">•</span>
                    <i class="fas fa-calendar me-1"></i>{{ \Carbon\Carbon::now()->format('l, d F Y') }}
                </p>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card border-0 bg-primary text-white shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title mb-1">Total Beasiswa</h6>
                                <h4 class="mb-0 fw-bold">
                                    <span class="counter" data-target="{{ $totalBeasiswa ?? 0 }}">0</span>
                                </h4>
                                <small class="opacity-75">
                                    <i class="fas fa-arrow-up me-1"></i>Program Tersedia
                                </small>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-graduation-cap fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card border-0 bg-success text-white shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title mb-1">Beasiswa Aktif</h6>
                                <h4 class="mb-0 fw-bold">
                                    <span class="counter" data-target="{{ $beasiswaAktif ?? 0 }}">0</span>
                                </h4>
                                <small class="opacity-75">
                                    <i class="fas fa-check-circle me-1"></i>Aktif Saat Ini
                                </small>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-check-circle fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card border-0 bg-info text-white shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title mb-1">Total Pendaftar</h6>
                                <h4 class="mb-0 fw-bold">
                                    <span class="counter" data-target="{{ $totalPendaftar ?? 0 }}">0</span>
                                </h4>
                                <small class="opacity-75">
                                    <i class="fas fa-users me-1"></i>Mahasiswa Terdaftar
                                </small>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-users fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card border-0 bg-warning text-white shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title mb-1">Menunggu Review</h6>
                                <h4 class="mb-0 fw-bold">
                                    <span class="counter" data-target="{{ $pendaftarPending ?? 0 }}">0</span>
                                </h4>
                                <small class="opacity-75">
                                    <i class="fas fa-clock me-1"></i>Perlu Ditinjau
                                </small>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-clock fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Cards -->
        <div class="row">
            <!-- Status Overview -->
            <div class="col-lg-8 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header py-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="card-title mb-0">
                                    <i class="fas fa-chart-pie text-primary me-2"></i>Status Pendaftar Overview
                                </h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-4 mb-3">
                                <div class="status-card bg-warning-soft p-4 rounded-3 h-100 border">
                                    <div class="status-icon mb-3">
                                        <div class="icon-circle bg-warning text-white rounded-circle mx-auto d-flex align-items-center justify-content-center shadow-sm"
                                            style="width: 60px; height: 60px;">
                                            <i class="fas fa-clock fa-xl"></i>
                                        </div>
                                    </div>
                                    <h3 class="fw-bold text-warning mb-1">
                                        <span class="counter" data-target="{{ $pendaftarPending ?? 0 }}">0</span>
                                    </h3>
                                    <p class="text-muted mb-2 fw-semibold">Menunggu Review</p>
                                    <div class="progress mb-2" style="height: 8px;">
                                        <div class="progress-bar bg-warning"
                                            style="width: {{ $totalPendaftar > 0 ? (($pendaftarPending ?? 0) / $totalPendaftar) * 100 : 0 }}%">
                                        </div>
                                    </div>
                                    <small class="text-muted fw-medium">
                                        {{ $totalPendaftar > 0 ? number_format((($pendaftarPending ?? 0) / $totalPendaftar) * 100, 1) : 0 }}%
                                        dari total
                                    </small>
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <div class="status-card bg-success-soft p-4 rounded-3 h-100 border">
                                    <div class="status-icon mb-3">
                                        <div class="icon-circle bg-success text-white rounded-circle mx-auto d-flex align-items-center justify-content-center shadow-sm"
                                            style="width: 60px; height: 60px;">
                                            <i class="fas fa-check-circle fa-xl"></i>
                                        </div>
                                    </div>
                                    <h3 class="fw-bold text-success mb-1">
                                        <span class="counter" data-target="{{ $pendaftarDiterima ?? 0 }}">0</span>
                                    </h3>
                                    <p class="text-muted mb-2 fw-semibold">Diterima</p>
                                    <div class="progress mb-2" style="height: 8px;">
                                        <div class="progress-bar bg-success"
                                            style="width: {{ $totalPendaftar > 0 ? (($pendaftarDiterima ?? 0) / $totalPendaftar) * 100 : 0 }}%">
                                        </div>
                                    </div>
                                    <small class="text-muted fw-medium">
                                        {{ $totalPendaftar > 0 ? number_format((($pendaftarDiterima ?? 0) / $totalPendaftar) * 100, 1) : 0 }}%
                                        dari total
                                    </small>
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <div class="status-card bg-danger-soft p-4 rounded-3 h-100 border">
                                    <div class="status-icon mb-3">
                                        <div class="icon-circle bg-danger text-white rounded-circle mx-auto d-flex align-items-center justify-content-center shadow-sm"
                                            style="width: 60px; height: 60px;">
                                            <i class="fas fa-times-circle fa-xl"></i>
                                        </div>
                                    </div>
                                    <h3 class="fw-bold text-danger mb-1">
                                        <span class="counter" data-target="{{ $pendaftarDitolak ?? 0 }}">0</span>
                                    </h3>
                                    <p class="text-muted mb-2 fw-semibold">Ditolak</p>
                                    <div class="progress mb-2" style="height: 8px;">
                                        <div class="progress-bar bg-danger"
                                            style="width: {{ $totalPendaftar > 0 ? (($pendaftarDitolak ?? 0) / $totalPendaftar) * 100 : 0 }}%">
                                        </div>
                                    </div>
                                    <small class="text-muted fw-medium">
                                        {{ $totalPendaftar > 0 ? number_format((($pendaftarDitolak ?? 0) / $totalPendaftar) * 100, 1) : 0 }}%
                                        dari total
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="col-lg-4 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header py-3">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-bolt text-primary me-2"></i>Menu Cepat
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-3">
                            <a href="{{ route('admin.beasiswa.create') }}"
                                class="btn btn-success btn-lg text-start text-decoration-none">
                                <div class="d-flex align-items-center">
                                    <div class="me-3">
                                        <div class="quick-action-icon bg-white text-success rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 40px; height: 40px;">
                                            <i class="fas fa-plus-circle"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="fw-bold">Tambah Beasiswa</div>
                                        <small class="opacity-75">Buat program beasiswa baru</small>
                                    </div>
                                    <div>
                                        <i class="fas fa-arrow-right"></i>
                                    </div>
                                </div>
                            </a>

                            <a href="{{ route('admin.beasiswa.index') }}"
                                class="btn btn-primary btn-lg text-start text-decoration-none">
                                <div class="d-flex align-items-center">
                                    <div class="me-3">
                                        <div class="quick-action-icon bg-white text-primary rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 40px; height: 40px;">
                                            <i class="fas fa-graduation-cap"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="fw-bold">Kelola Beasiswa</div>
                                        <small class="opacity-75">Edit dan monitor beasiswa</small>
                                    </div>
                                    <div>
                                        <i class="fas fa-arrow-right"></i>
                                    </div>
                                </div>
                            </a>

                            <a href="{{ route('admin.pendaftar.index') }}"
                                class="btn btn-warning btn-lg text-start text-decoration-none">
                                <div class="d-flex align-items-center">
                                    <div class="me-3">
                                        <div class="quick-action-icon bg-white text-warning rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 40px; height: 40px;">
                                            <i class="fas fa-users"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="fw-bold">Kelola Pendaftar</div>
                                        <small class="opacity-75">Review aplikasi beasiswa</small>
                                    </div>
                                    <div>
                                        <i class="fas fa-arrow-right"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Welcome Message if no data -->
        @if(($totalBeasiswa ?? 0) == 0)
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center py-5">
                            <div class="empty-state-icon bg-light rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center"
                                style="width: 120px; height: 120px;">
                                <i class="fas fa-graduation-cap fa-4x text-muted"></i>
                            </div>
                            <h4 class="text-muted mb-3">Selamat Datang di Sistem Beasiswa!</h4>
                            <p class="text-muted mb-4">
                                Belum ada data beasiswa dalam sistem. Mari mulai dengan menambahkan program beasiswa pertama Anda.
                            </p>
                            <a href="{{ route('admin.beasiswa.create') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-plus me-2"></i>Tambah Beasiswa Pertama
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Custom CSS -->
    <style>
        :root {
            --primary-yellow: #FBC02D;
            /* Warm golden yellow */
            --secondary-yellow: #FFA000;
            /* Amber */
            --light-yellow: #FFF8E1;
            /* Creamy soft background */
            --dark-yellow: #FF8F00;
            /* Deep amber */
            --gradient-yellow: linear-gradient(135deg, #FBC02D, #FFA000, #FF8F00);
            --gradient-yellow-hover: linear-gradient(135deg, #FFA000, #F57F17, #FF6F00);
        }

        /* Smooth transition for all */
        .card,
        .btn,
        .status-card,
        .icon-circle {
            transition: all 0.3s ease-in-out;
        }

        /* Text colors */
        .text-primary {
            color: var(--primary-yellow) !important;
        }

        .text-warning {
            color: var(--dark-yellow) !important;
        }

        /* Stats Cards - darker yellow tones */
        .card.bg-primary {
            background: var(--gradient-yellow) !important;
            color: #fff;
        }

        .card.bg-success {
            background: linear-gradient(135deg, #FFD54F, #FFA000) !important;
            color: #fff;
        }

        .card.bg-info {
            background: linear-gradient(135deg, #FFE082, #FFB300) !important;
            color: #4e342e;
        }

        .card.bg-warning {
            background: var(--gradient-yellow) !important;
            color: #fff;
        }

        /* Softer backgrounds for status cards */
        .bg-success-soft {
            background: linear-gradient(45deg, #afffb3, #36ff51) !important;
            color: #00ff08 !important;
        }

        .bg-warning-soft {
            background: linear-gradient(45deg, #FFF8E1, #FFD54F) !important;
            color: #6d4c41 !important;
        }

        .bg-danger-soft {
            background: linear-gradient(45deg, #FDECEA, #F8BBD0) !important;
            color: #721c24 !important;
        }

        /* Hover effect for cards */
        .card:hover,
        .status-card:hover {
            transform: translateY(-5px) scale(1.01);
            box-shadow: 0 6px 20px rgba(251, 192, 45, 0.3);
        }

        /* Buttons */
        .btn-primary {
            background: var(--gradient-yellow);
            border: none;
            color: #fff;
            font-weight: 600;
        }

        .btn-primary:hover {
            background: var(--gradient-yellow-hover);
            transform: scale(1.03);
            box-shadow: 0 4px 12px rgba(255, 160, 0, 0.4);
        }

        .btn-success {
            background: linear-gradient(45deg, #FFD54F, #FFA000);
            border: none;
            color: #fff;
            font-weight: 600;
        }

        .btn-success:hover {
            background: linear-gradient(45deg, #FFB300, #FF8F00);
            transform: scale(1.03);
            box-shadow: 0 4px 12px rgba(255, 160, 0, 0.4);
        }

        .btn-warning {
            background: var(--gradient-yellow);
            border: none;
            color: #fff;
            font-weight: 600;
        }

        .btn-warning:hover {
            background: var(--gradient-yellow-hover);
            transform: scale(1.03);
            box-shadow: 0 4px 12px rgba(255, 160, 0, 0.4);
        }

        /* Icon circle hover glow */
        .icon-circle:hover {
            transform: rotate(5deg) scale(1.05);
            box-shadow: 0 6px 15px rgba(251, 192, 45, 0.35);
        }
    </style>


        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Counter animation
                function animateCounter(element, target) {
                    let current = 0;
                    const increment = Math.max(1, target / 50);
                    const duration = 1500;
                    const stepTime = duration / 50;
                    const timer = setInterval(() => {
                        current += increment;
                        if (current >= target) {
                            element.textContent = target;
                            clearInterval(timer);
                        } else {
                            element.textContent = Math.floor(current);
                        }
                    }, stepTime);
                }
                setTimeout(() => {
                    document.querySelectorAll('.counter').forEach((counter, index) => {
                        const target = parseInt(counter.getAttribute('data-target'));
                        setTimeout(() => animateCounter(counter, target), index * 150);
                    });
                }, 300);
            });
        </script>
@endsection
