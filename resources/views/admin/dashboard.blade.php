@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<!-- Welcome Header -->
<div class="dashboard-header mb-4">
    <div class="row align-items-center">
        <div class="col-lg-8">
            <div class="welcome-section p-4 rounded-3 bg-gradient-primary text-white shadow">
                <h1 class="h3 mb-2">
                    <i class="fas fa-tachometer-alt me-2"></i>
                    Selamat Datang, {{ auth()->user()->name }}!
                </h1>
                <p class="mb-0 opacity-90">
                    <i class="fas fa-calendar me-2"></i>{{ \Carbon\Carbon::now()->format('l, d F Y') }}
                </p>
                <p class="mb-0 opacity-75">Kelola sistem beasiswa dengan mudah dan efisien</p>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="quick-actions text-center">
                <div class="floating-icon">
                    <i class="fas fa-user-tie fa-4x text-primary opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stats-card card border-0 shadow-lg h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="stats-content">
                        <div class="stats-label text-muted text-uppercase fw-bold mb-1">
                            Total Beasiswa
                        </div>
                        <div class="stats-number h2 mb-0 fw-bold text-primary">
                            <span class="counter" data-target="{{ $totalBeasiswa ?? 0 }}">0</span>
                        </div>
                        <div class="stats-trend mt-2">
                            <span class="badge bg-primary bg-opacity-10 text-primary">
                                <i class="fas fa-arrow-up me-1"></i>Program Aktif
                            </span>
                        </div>
                    </div>
                    <div class="stats-icon">
                        <div class="icon-wrapper bg-primary bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-graduation-cap fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 pt-0">
                <div class="progress progress-sm">
                    <div class="progress-bar bg-primary" style="width: 75%"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stats-card card border-0 shadow-lg h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="stats-content">
                        <div class="stats-label text-muted text-uppercase fw-bold mb-1">
                            Beasiswa Aktif
                        </div>
                        <div class="stats-number h2 mb-0 fw-bold text-success">
                            <span class="counter" data-target="{{ $beasiswaAktif ?? 0 }}">0</span>
                        </div>
                        <div class="stats-trend mt-2">
                            <span class="badge bg-success bg-opacity-10 text-success">
                                <i class="fas fa-check-circle me-1"></i>Tersedia
                            </span>
                        </div>
                    </div>
                    <div class="stats-icon">
                        <div class="icon-wrapper bg-success bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-check-circle fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 pt-0">
                <div class="progress progress-sm">
                    <div class="progress-bar bg-success" style="width: 85%"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stats-card card border-0 shadow-lg h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="stats-content">
                        <div class="stats-label text-muted text-uppercase fw-bold mb-1">
                            Total Pendaftar
                        </div>
                        <div class="stats-number h2 mb-0 fw-bold text-info">
                            <span class="counter" data-target="{{ $totalPendaftar ?? 0 }}">0</span>
                        </div>
                        <div class="stats-trend mt-2">
                            <span class="badge bg-info bg-opacity-10 text-info">
                                <i class="fas fa-users me-1"></i>Terdaftar
                            </span>
                        </div>
                    </div>
                    <div class="stats-icon">
                        <div class="icon-wrapper bg-info bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-users fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 pt-0">
                <div class="progress progress-sm">
                    <div class="progress-bar bg-info" style="width: 60%"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stats-card card border-0 shadow-lg h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="stats-content">
                        <div class="stats-label text-muted text-uppercase fw-bold mb-1">
                            Menunggu Review
                        </div>
                        <div class="stats-number h2 mb-0 fw-bold text-warning">
                            <span class="counter" data-target="{{ $pendaftarPending ?? 0 }}">0</span>
                        </div>
                        <div class="stats-trend mt-2">
                            <span class="badge bg-warning bg-opacity-10 text-warning">
                                <i class="fas fa-clock me-1"></i>Pending
                            </span>
                        </div>
                    </div>
                    <div class="stats-icon">
                        <div class="icon-wrapper bg-warning bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-clock fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 pt-0">
                <div class="progress progress-sm">
                    <div class="progress-bar bg-warning" style="width: 45%"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Row -->
<div class="row mb-4">
    <!-- Status Chart -->
    <div class="col-lg-8 mb-4">
        <div class="card border-0 shadow-lg h-100">
            <div class="card-header bg-white border-0 py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="m-0 fw-bold text-dark">
                        <i class="fas fa-chart-pie text-primary me-2"></i>Status Pendaftar
                    </h6>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-download me-2"></i>Export Data</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-refresh me-2"></i>Refresh</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-4 mb-4">
                        <div class="status-item p-4 rounded-3 bg-warning bg-opacity-10 h-100">
                            <div class="status-icon mb-3">
                                <i class="fas fa-clock fa-3x text-warning"></i>
                            </div>
                            <div class="status-info">
                                <h3 class="fw-bold text-warning mb-1">
                                    <span class="counter" data-target="{{ $pendaftarPending ?? 0 }}">0</span>
                                </h3>
                                <p class="text-muted mb-0">Menunggu Review</p>
                                <div class="progress progress-sm mt-2">
                                    <div class="progress-bar bg-warning" style="width: {{ $totalPendaftar > 0 ? (($pendaftarPending ?? 0) / $totalPendaftar) * 100 : 0 }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="status-item p-4 rounded-3 bg-success bg-opacity-10 h-100">
                            <div class="status-icon mb-3">
                                <i class="fas fa-check-circle fa-3x text-success"></i>
                            </div>
                            <div class="status-info">
                                <h3 class="fw-bold text-success mb-1">
                                    <span class="counter" data-target="{{ $pendaftarDiterima ?? 0 }}">0</span>
                                </h3>
                                <p class="text-muted mb-0">Diterima</p>
                                <div class="progress progress-sm mt-2">
                                    <div class="progress-bar bg-success" style="width: {{ $totalPendaftar > 0 ? (($pendaftarDiterima ?? 0) / $totalPendaftar) * 100 : 0 }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="status-item p-4 rounded-3 bg-danger bg-opacity-10 h-100">
                            <div class="status-icon mb-3">
                                <i class="fas fa-times-circle fa-3x text-danger"></i>
                            </div>
                            <div class="status-info">
                                <h3 class="fw-bold text-danger mb-1">
                                    <span class="counter" data-target="{{ $pendaftarDitolak ?? 0 }}">0</span>
                                </h3>
                                <p class="text-muted mb-0">Ditolak</p>
                                <div class="progress progress-sm mt-2">
                                    <div class="progress-bar bg-danger" style="width: {{ $totalPendaftar > 0 ? (($pendaftarDitolak ?? 0) / $totalPendaftar) * 100 : 0 }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="col-lg-4 mb-4">
        <div class="card border-0 shadow-lg h-100">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="m-0 fw-bold text-dark">
                    <i class="fas fa-bolt text-primary me-2"></i>Menu Cepat
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-3">
                    <a href="{{ route('admin.beasiswa.create') }}" class="quick-action-btn btn btn-success btn-lg rounded-3 text-start">
                        <div class="d-flex align-items-center">
                            <div class="btn-icon me-3">
                                <i class="fas fa-plus-circle fa-lg"></i>
                            </div>
                            <div class="btn-content">
                                <div class="btn-title fw-bold">Tambah Beasiswa</div>
                                <div class="btn-subtitle small opacity-75">Buat program beasiswa baru</div>
                            </div>
                            <div class="btn-arrow ms-auto">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </div>
                    </a>
                    
                    <a href="{{ route('admin.beasiswa.index') }}" class="quick-action-btn btn btn-primary btn-lg rounded-3 text-start">
                        <div class="d-flex align-items-center">
                            <div class="btn-icon me-3">
                                <i class="fas fa-graduation-cap fa-lg"></i>
                            </div>
                            <div class="btn-content">
                                <div class="btn-title fw-bold">Kelola Beasiswa</div>
                                <div class="btn-subtitle small opacity-75">Edit dan monitor beasiswa</div>
                            </div>
                            <div class="btn-arrow ms-auto">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </div>
                    </a>
                    
                    <a href="{{ route('admin.pendaftar.index') }}" class="quick-action-btn btn btn-info btn-lg rounded-3 text-start">
                        <div class="d-flex align-items-center">
                            <div class="btn-icon me-3">
                                <i class="fas fa-users fa-lg"></i>
                            </div>
                            <div class="btn-content">
                                <div class="btn-title fw-bold">Kelola Pendaftar</div>
                                <div class="btn-subtitle small opacity-75">Review aplikasi beasiswa</div>
                            </div>
                            <div class="btn-arrow ms-auto">
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
@if($totalBeasiswa == 0)
<div class="row">
    <div class="col-12">
        <div class="empty-state text-center py-5">
            <div class="empty-state-icon mb-4">
                <i class="fas fa-graduation-cap fa-4x text-muted opacity-50"></i>
            </div>
            <h3 class="empty-state-title mb-3">Selamat Datang di Admin Panel!</h3>
            <p class="empty-state-text text-muted mb-4">
                Belum ada data beasiswa. Mari mulai dengan menambahkan program beasiswa pertama Anda.
            </p>
            <a href="{{ route('admin.beasiswa.create') }}" class="btn btn-primary btn-lg rounded-3">
                <i class="fas fa-plus me-2"></i>Tambah Beasiswa Pertama
            </a>
        </div>
    </div>
</div>
@endif
@endsection

@section('scripts')
<style>
/* Dashboard Styles */
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.stats-card {
    transition: all 0.3s ease;
    overflow: hidden;
}

.stats-card:hover {
    transform: translateY(-5px);
}

.icon-wrapper {
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.progress-sm {
    height: 4px;
}

.floating-icon {
    animation: float 6s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

.quick-action-btn {
    transition: all 0.3s ease;
    border: none;
    position: relative;
    overflow: hidden;
}

.quick-action-btn:hover {
    transform: translateX(5px);
}

.quick-action-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.quick-action-btn:hover::before {
    left: 100%;
}

.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e9ecef;
}

.timeline-item {
    position: relative;
    margin-bottom: 30px;
}

.timeline-marker {
    position: absolute;
    left: -23px;
    top: 5px;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    border: 3px solid #fff;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.timeline-content {
    background: #f8f9fa;
    padding: 15px 20px;
    border-radius: 8px;
    border-left: 3px solid #007bff;
}

.status-item {
    transition: all 0.3s ease;
}

.status-item:hover {
    transform: scale(1.02);
}

.empty-state {
    padding: 60px 20px;
}

/* Counter Animation */
@keyframes countUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.counter {
    animation: countUp 1s ease;
}

/* Responsive */
@media (max-width: 768px) {
    .stats-card {
        margin-bottom: 1rem;
    }
    
    .quick-action-btn .btn-content {
        font-size: 0.9rem;
    }
    
    .timeline {
        padding-left: 20px;
    }
    
    .timeline-marker {
        left: -18px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Counter animation
    function animateCounter(element, target) {
        let current = 0;
        const increment = target / 50;
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                element.textContent = target;
                clearInterval(timer);
            } else {
                element.textContent = Math.floor(current);
            }
        }, 30);
    }

    // Initialize counters
    document.querySelectorAll('.counter').forEach(counter => {
        const target = parseInt(counter.getAttribute('data-target'));
        animateCounter(counter, target);
    });

    // Add hover effects to cards
    document.querySelectorAll('.stats-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.boxShadow = '0 10px 25px rgba(0,0,0,0.15)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.boxShadow = '';
        });
    });
});
</script>
@endsection