@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<!-- Welcome Header -->
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <div>
        <h1 class="h2"><i class="fas fa-tachometer-alt"></i> Dashboard Admin</h1>
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
                        <h6 class="card-title mb-1 text-white-50">Total Beasiswa</h6>
                        <h3 class="mb-0 fw-bold">
                            <span class="counter" data-target="{{ $totalBeasiswa ?? 0 }}">0</span>
                        </h3>
                        <small class="text-white-50">
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
                        <h6 class="card-title mb-1 text-white-50">Beasiswa Aktif</h6>
                        <h3 class="mb-0 fw-bold">
                            <span class="counter" data-target="{{ $beasiswaAktif ?? 0 }}">0</span>
                        </h3>
                        <small class="text-white-50">
                            <i class="fas fa-check-circle me-1"></i>Bisa Dilamar
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
                        <h6 class="card-title mb-1 text-white-50">Total Pendaftar</h6>
                        <h3 class="mb-0 fw-bold">
                            <span class="counter" data-target="{{ $totalPendaftar ?? 0 }}">0</span>
                        </h3>
                        <small class="text-white-50">
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
                        <h6 class="card-title mb-1 text-white-50">Menunggu Review</h6>
                        <h3 class="mb-0 fw-bold">
                            <span class="counter" data-target="{{ $pendaftarPending ?? 0 }}">0</span>
                        </h3>
                        <small class="text-white-50">
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
            <div class="card-header bg-white py-3">
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-chart-pie text-primary me-2"></i>Status Pendaftar Overview
                        </h6>
                    </div>
                    <div class="col-auto">
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#"><i class="fas fa-download me-2"></i>Export Data</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-sync-alt me-2"></i>Refresh</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{ route('admin.pendaftar.index') }}"><i class="fas fa-eye me-2"></i>Lihat Semua</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-4 mb-3">
                        <div class="status-card bg-warning-soft p-4 rounded-3 h-100">
                            <div class="status-icon mb-3">
                                <div class="icon-circle bg-warning text-white rounded-circle mx-auto d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                    <i class="fas fa-clock fa-xl"></i>
                                </div>
                            </div>
                            <h3 class="fw-bold text-warning mb-1">
                                <span class="counter" data-target="{{ $pendaftarPending ?? 0 }}">0</span>
                            </h3>
                            <p class="text-muted mb-2">Menunggu Review</p>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-warning" style="width: {{ $totalPendaftar > 0 ? (($pendaftarPending ?? 0) / $totalPendaftar) * 100 : 0 }}%"></div>
                            </div>
                            <small class="text-muted">
                                {{ $totalPendaftar > 0 ? number_format((($pendaftarPending ?? 0) / $totalPendaftar) * 100, 1) : 0 }}% dari total
                            </small>
                        </div>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <div class="status-card bg-success-soft p-4 rounded-3 h-100">
                            <div class="status-icon mb-3">
                                <div class="icon-circle bg-success text-white rounded-circle mx-auto d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                    <i class="fas fa-check-circle fa-xl"></i>
                                </div>
                            </div>
                            <h3 class="fw-bold text-success mb-1">
                                <span class="counter" data-target="{{ $pendaftarDiterima ?? 0 }}">0</span>
                            </h3>
                            <p class="text-muted mb-2">Diterima</p>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-success" style="width: {{ $totalPendaftar > 0 ? (($pendaftarDiterima ?? 0) / $totalPendaftar) * 100 : 0 }}%"></div>
                            </div>
                            <small class="text-muted">
                                {{ $totalPendaftar > 0 ? number_format((($pendaftarDiterima ?? 0) / $totalPendaftar) * 100, 1) : 0 }}% dari total
                            </small>
                        </div>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <div class="status-card bg-danger-soft p-4 rounded-3 h-100">
                            <div class="status-icon mb-3">
                                <div class="icon-circle bg-danger text-white rounded-circle mx-auto d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                    <i class="fas fa-times-circle fa-xl"></i>
                                </div>
                            </div>
                            <h3 class="fw-bold text-danger mb-1">
                                <span class="counter" data-target="{{ $pendaftarDitolak ?? 0 }}">0</span>
                            </h3>
                            <p class="text-muted mb-2">Ditolak</p>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-danger" style="width: {{ $totalPendaftar > 0 ? (($pendaftarDitolak ?? 0) / $totalPendaftar) * 100 : 0 }}%"></div>
                            </div>
                            <small class="text-muted">
                                {{ $totalPendaftar > 0 ? number_format((($pendaftarDitolak ?? 0) / $totalPendaftar) * 100, 1) : 0 }}% dari total
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
            <div class="card-header bg-white py-3">
                <h6 class="card-title mb-0">
                    <i class="fas fa-bolt text-primary me-2"></i>Menu Cepat
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-3">
                    <a href="{{ route('admin.beasiswa.create') }}" class="btn btn-success btn-lg text-start text-decoration-none">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="fas fa-plus-circle fa-xl"></i>
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
                    
                    <a href="{{ route('admin.beasiswa.index') }}" class="btn btn-primary btn-lg text-start text-decoration-none">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="fas fa-graduation-cap fa-xl"></i>
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
                    
                    <a href="{{ route('admin.pendaftar.index') }}" class="btn btn-info btn-lg text-start text-decoration-none">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="fas fa-users fa-xl"></i>
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

<!-- Recent Activities & System Status -->
<div class="row">
    <!-- Recent Applications -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow-sm">
            <div class="card-header bg-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-history text-primary me-2"></i>Pendaftar Terbaru
                    </h6>
                    <a href="{{ route('admin.pendaftar.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                </div>
            </div>
            <div class="card-body p-0">
                @if(isset($recentPendaftar) && $recentPendaftar->count() > 0)
                    @foreach($recentPendaftar->take(5) as $pendaftar)
                    <div class="d-flex align-items-center p-3 border-bottom">
                        <div class="avatar-initial rounded-circle bg-primary text-white me-3 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; font-size: 12px;">
                            {{ strtoupper(substr($pendaftar->nama_lengkap, 0, 2)) }}
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-0 fw-semibold">{{ $pendaftar->nama_lengkap }}</h6>
                            <small class="text-muted">{{ $pendaftar->beasiswa->nama_beasiswa ?? 'Beasiswa Tidak Diketahui' }}</small>
                        </div>
                        <div class="text-end">
                            @if($pendaftar->status == 'pending')
                                <span class="badge bg-warning-soft text-warning">Pending</span>
                            @elseif($pendaftar->status == 'diterima')
                                <span class="badge bg-success-soft text-success">Diterima</span>
                            @else
                                <span class="badge bg-danger-soft text-danger">Ditolak</span>
                            @endif
                            <br><small class="text-muted">{{ $pendaftar->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                        <p class="text-muted mb-0">Belum ada pendaftar baru</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

<!-- Welcome Message if no data -->
@if(($totalBeasiswa ?? 0) == 0)
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <div class="empty-state-icon bg-light rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                    <i class="fas fa-graduation-cap fa-3x text-muted"></i>
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
/* Status Badge Colors */
.bg-warning-soft { background-color: #fff3cd !important; }
.bg-success-soft { background-color: #d1edff !important; }
.bg-danger-soft { background-color: #f8d7da !important; }
.bg-info-soft { background-color: #d1ecf1 !important; }

/* Stats Cards */
.card.bg-primary, .card.bg-success, .card.bg-info, .card.bg-warning {
    background: var(--bs-primary) !important;
    transition: all 0.3s ease;
}

.card.bg-primary:hover, .card.bg-success:hover, .card.bg-info:hover, .card.bg-warning:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.card.bg-success {
    background: var(--bs-success) !important;
}

.card.bg-info {
    background: var(--bs-info) !important;
}

.card.bg-warning {
    background: var(--bs-warning) !important;
}

/* Status Cards */
.status-card {
    transition: all 0.3s ease;
    border: 1px solid #e9ecef;
}

.status-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Quick Action Buttons */
.btn-lg {
    transition: all 0.3s ease;
}

.btn-lg:hover {
    transform: translateX(5px);
}

/* Counter Animation */
.counter {
    display: inline-block;
    transition: all 0.3s ease;
}

/* Avatar Initial */
.avatar-initial {
    font-weight: 600;
}

/* Progress bars */
.progress {
    border-radius: 10px;
    overflow: hidden;
}

.progress-bar {
    border-radius: 10px;
}

/* Info Items */
.info-item {
    transition: background-color 0.2s ease;
}

.info-item:hover {
    background-color: #f8f9fa;
}

/* Empty State */
.empty-state-icon {
    transition: all 0.3s ease;
}

.empty-state-icon:hover {
    transform: scale(1.05);
}

/* Badge improvements */
.badge {
    font-size: 0.75rem;
    font-weight: 500;
    padding: 0.375rem 0.75rem;
}

/* Responsive */
@media (max-width: 768px) {
    .card {
        margin-bottom: 1rem;
    }
    
    .btn-lg {
        font-size: 1rem;
        padding: 0.75rem 1rem;
    }
    
    .status-card {
        margin-bottom: 1rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Counter animation
    function animateCounter(element, target) {
        let current = 0;
        const increment = target / 50;
        const duration = 1000;
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

    // Initialize counters with delay for better effect
    setTimeout(() => {
        document.querySelectorAll('.counter').forEach((counter, index) => {
            const target = parseInt(counter.getAttribute('data-target'));
            setTimeout(() => {
                animateCounter(counter, target);
            }, index * 200);
        });
    }, 300);

    // Add hover effects to stats cards
    document.querySelectorAll('.card.bg-primary, .card.bg-success, .card.bg-info, .card.bg-warning').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-3px)';
            this.style.boxShadow = '0 6px 20px rgba(0,0,0,0.15)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '';
        });
    });
    
    // Real-time clock update
    function updateClock() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('id-ID');
        const clockElements = document.querySelectorAll('.system-clock');
        clockElements.forEach(el => el.textContent = timeString);
    }
    
    setInterval(updateClock, 1000);
    updateClock();
});
</script>
@endsection