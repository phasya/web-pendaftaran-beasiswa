@extends('layouts.admin')

@section('title', 'Detail Pendaftar')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <div>
        <h1 class="h2"><i class="fas fa-user-graduate"></i> Detail Pendaftar</h1>
        <p class="text-muted mb-0">
            <i class="fas fa-info-circle me-2"></i>Informasi lengkap tentang pendaftar beasiswa
        </p>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <!-- Main Detail Card -->
        <div class="card shadow-sm">
            <div class="card-header bg-white py-3">
                <div class="row align-items-center">
                    <div class="col">
                        <h5 class="card-title mb-1">
                            <i class="fas fa-user text-primary me-2"></i>{{ $pendaftar->nama_lengkap }}
                        </h5>
                        <small class="text-muted">
                            <i class="fas fa-calendar me-1"></i>Mendaftar pada {{ $pendaftar->created_at->format('d M Y H:i') }}
                        </small>
                    </div>
                    <div class="col-auto">
                        @if($pendaftar->status == 'pending')
                            <span class="badge bg-warning-soft text-warning px-3 py-2">
                                <i class="fas fa-clock me-1"></i>Pending
                            </span>
                        @elseif($pendaftar->status == 'diterima')
                            <span class="badge bg-success-soft text-success px-3 py-2">
                                <i class="fas fa-check-circle me-1"></i>Diterima
                            </span>
                        @else
                            <span class="badge bg-danger-soft text-danger px-3 py-2">
                                <i class="fas fa-times-circle me-1"></i>Ditolak
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <!-- Personal Info Section -->
                <div class="detail-section mb-4">
                    <h6 class="section-title mb-3">
                        <i class="fas fa-user-circle text-info me-2"></i>Data Personal
                    </h6>
                    <div class="content-box">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="info-item">
                                    <label class="info-label">Nama Lengkap</label>
                                    <p class="info-value">{{ $pendaftar->nama_lengkap }}</p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="info-item">
                                    <label class="info-label">NIM</label>
                                    <p class="info-value">{{ $pendaftar->nim }}</p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="info-item">
                                    <label class="info-label">Email</label>
                                    <p class="info-value">{{ $pendaftar->email }}</p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="info-item">
                                    <label class="info-label">No. HP</label>
                                    <p class="info-value">{{ $pendaftar->no_hp }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Scholarship Info Section -->
                <div class="detail-section mb-4">
                    <h6 class="section-title mb-3">
                        <i class="fas fa-graduation-cap text-success me-2"></i>Beasiswa yang Dilamar
                    </h6>
                    <div class="scholarship-card">
                        <div class="scholarship-header">
                            <h6 class="scholarship-name">{{ $pendaftar->beasiswa->nama_beasiswa }}</h6>
                            <div class="scholarship-amount">
                                <i class="fas fa-money-bill-wave text-success me-2"></i>
                                Rp {{ number_format($pendaftar->beasiswa->jumlah_dana, 0, ',', '.') }}
                            </div>
                        </div>
                        <p class="scholarship-desc">{{ $pendaftar->beasiswa->deskripsi }}</p>
                    </div>
                </div>

                <!-- Reason Section -->
                <div class="detail-section mb-4">
                    <h6 class="section-title mb-3">
                        <i class="fas fa-comment-alt text-warning me-2"></i>Alasan Mendaftar
                    </h6>
                    <div class="content-box">
                        <div class="reason-text">
                            {{ $pendaftar->alasan_mendaftar }}
                        </div>
                    </div>
                </div>

                <!-- Documents Section -->
                <div class="detail-section mb-4">
                    <h6 class="section-title mb-3">
                        <i class="fas fa-folder-open text-info me-2"></i>Dokumen Pendukung
                    </h6>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="document-card">
                                <div class="document-icon">
                                    <i class="fas fa-file-pdf text-danger"></i>
                                </div>
                                <div class="document-info">
                                    <h6 class="document-title">Transkrip Nilai</h6>
                                    <a href="{{ asset('storage/documents/' . $pendaftar->file_transkrip) }}" 
                                       target="_blank" 
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye me-1"></i>Lihat
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="document-card">
                                <div class="document-icon">
                                    <i class="fas fa-id-card text-primary"></i>
                                </div>
                                <div class="document-info">
                                    <h6 class="document-title">KTP</h6>
                                    <a href="{{ asset('storage/documents/' . $pendaftar->file_ktp) }}" 
                                       target="_blank" 
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye me-1"></i>Lihat
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="document-card">
                                <div class="document-icon">
                                    <i class="fas fa-users text-success"></i>
                                </div>
                                <div class="document-info">
                                    <h6 class="document-title">Kartu Keluarga</h6>
                                    <a href="{{ asset('storage/documents/' . $pendaftar->file_kk) }}" 
                                       target="_blank" 
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye me-1"></i>Lihat
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Action Card -->
        <div class="card shadow-sm">
            <div class="card-header bg-white py-3">
                <h6 class="card-title mb-0">
                    <i class="fas fa-cogs text-warning me-2"></i>Aksi Pendaftar
                </h6>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.pendaftar.update-status', $pendaftar) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            <i class="fas fa-edit me-2"></i>Update Status
                        </label>
                        <select name="status" class="form-select modern-select" required>
                            <option value="pending" {{ $pendaftar->status == 'pending' ? 'selected' : '' }}>
                                <i class="fas fa-clock"></i> Pending
                            </option>
                            <option value="diterima" {{ $pendaftar->status == 'diterima' ? 'selected' : '' }}>
                                <i class="fas fa-check"></i> Diterima
                            </option>
                            <option value="ditolak" {{ $pendaftar->status == 'ditolak' ? 'selected' : '' }}>
                                <i class="fas fa-times"></i> Ditolak
                            </option>
                        </select>
                    </div>
                    
                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Update Status
                        </button>
                    </div>
                </form>

                <hr class="my-4">

                <div class="d-grid">
                    <form action="{{ route('admin.pendaftar.destroy', $pendaftar) }}" 
                          method="POST" 
                          onsubmit="return confirm('Yakin ingin menghapus data pendaftar ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-2"></i>Hapus Data
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Statistics Card -->
        <div class="card shadow-sm mt-4">
            <div class="card-header bg-white py-3">
                <h6 class="card-title mb-0">
                    <i class="fas fa-chart-bar text-info me-2"></i>Statistik
                </h6>
            </div>
            <div class="card-body p-4">
                <div class="stat-item">
                    <div class="stat-icon">
                        <i class="fas fa-users text-primary"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-number">{{ $pendaftar->beasiswa->pendaftars->count() }}</div>
                        <div class="stat-label">Total pendaftar untuk beasiswa ini</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons Card -->
        <div class="card shadow-sm mt-4">
            <div class="card-body">
                <div class="d-flex flex-column gap-2">
                    <a href="{{ route('admin.pendaftar.index') }}" 
                       class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
                    </a>
                    <a href="#" class="btn btn-info" onclick="printData()">
                        <i class="fas fa-print me-2"></i>Cetak Data
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Custom CSS -->
<style>
/* Status Badge Colors - Same as beasiswa detail */
.bg-success-soft { background-color: #d1edff !important; }
.bg-warning-soft { background-color: #fff3cd !important; }
.bg-danger-soft { background-color: #f8d7da !important; }
.bg-info-soft { background-color: #d1ecf1 !important; }
.bg-secondary-soft { background-color: #e2e3e5 !important; }

/* Detail sections - Same structure */
.detail-section {
    border-left: 4px solid var(--mint-primary, #00c9a7);
    padding-left: 1rem;
    margin-left: 0.5rem;
}

.section-title {
    font-weight: 600;
    color: #495057;
    font-size: 1rem;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 1px solid #e9ecef;
}

/* Content boxes */
.content-box {
    background: linear-gradient(45deg, #f8f9fa, #ffffff);
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: 1.5rem;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

/* Info items for personal data */
.info-item {
    margin-bottom: 1rem;
}

.info-label {
    font-size: 0.875rem;
    font-weight: 600;
    color: #6c757d;
    margin-bottom: 0.25rem;
    display: block;
}

.info-value {
    font-size: 1rem;
    color: #495057;
    margin-bottom: 0;
    font-weight: 500;
}

/* Scholarship card styling */
.scholarship-card {
    background: linear-gradient(135deg, #e3f2fd, #ffffff);
    border: 1px solid #bbdefb;
    border-radius: 10px;
    padding: 1.5rem;
    box-shadow: 0 2px 8px rgba(33, 150, 243, 0.1);
}

.scholarship-header {
    display: flex;
    justify-content: between;
    align-items: flex-start;
    margin-bottom: 1rem;
    flex-wrap: wrap;
    gap: 1rem;
}

.scholarship-name {
    font-size: 1.25rem;
    font-weight: 600;
    color: #1565c0;
    margin-bottom: 0;
    flex: 1;
}

.scholarship-amount {
    font-size: 1.1rem;
    font-weight: bold;
    color: #2e7d32;
    white-space: nowrap;
}

.scholarship-desc {
    color: #546e7a;
    margin-bottom: 0;
    line-height: 1.6;
}

/* Reason text styling */
.reason-text {
    font-size: 1rem;
    line-height: 1.6;
    color: #495057;
    font-style: italic;
}

/* Document cards */
.document-card {
    background: white;
    border: 1px solid #e9ecef;
    border-radius: 10px;
    padding: 1.5rem;
    text-align: center;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    height: 100%;
}

.document-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.15);
}

.document-icon {
    font-size: 2.5rem;
    margin-bottom: 1rem;
}

.document-title {
    font-size: 1rem;
    font-weight: 600;
    color: #495057;
    margin-bottom: 1rem;
}

/* Statistics styling */
.stat-item {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.stat-icon {
    font-size: 2rem;
    color: var(--mint-primary, #00c9a7);
    min-width: 60px;
    text-align: center;
}

.stat-number {
    font-size: 2rem;
    font-weight: bold;
    color: #495057;
    line-height: 1;
}

.stat-label {
    font-size: 0.875rem;
    color: #6c757d;
    font-weight: 500;
    margin-top: 0.25rem;
}

/* Form styling */
.modern-select {
    border-radius: 8px;
    border: 2px solid #e9ecef;
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
}

.modern-select:focus {
    border-color: var(--mint-primary, #00c9a7);
    box-shadow: 0 0 0 0.25rem rgba(0, 201, 167, 0.1);
}

/* Button enhancements - Same as beasiswa detail */
.btn {
    border-radius: 0.375rem;
    font-weight: 500;
    transition: all 0.3s ease;
    padding: 0.625rem 1.25rem;
}

.btn-primary {
    background: linear-gradient(45deg, var(--mint-primary, #00c9a7), var(--mint-blue, #0891b2));
    border: none;
}

.btn-primary:hover {
    background: linear-gradient(45deg, var(--mint-dark, #00a693), #0671a6);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 201, 167, 0.4);
}

.btn-danger:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(220, 53, 69, 0.4);
}

.btn-info {
    background: linear-gradient(45deg, #0dcaf0, #0891b2);
    border: none;
    color: white;
}

.btn-info:hover {
    background: linear-gradient(45deg, #0aa2c0, #0671a6);
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(13, 202, 240, 0.4);
}

.btn-outline-secondary:hover {
    transform: translateY(-1px);
}

.btn-outline-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(13, 110, 253, 0.3);
}

/* Card consistency - Same as beasiswa detail */
.card {
    border: none;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.card-header {
    border-bottom: 2px solid #dee2e6;
    background: linear-gradient(45deg, #f8f9fa, #e9ecef);
}

.card-title {
    font-weight: 600;
    color: #495057;
}

/* Responsive */
@media (max-width: 768px) {
    .detail-section {
        border-left: none;
        border-top: 3px solid var(--mint-primary, #00c9a7);
        padding-left: 0;
        padding-top: 1rem;
        margin-left: 0;
    }
    
    .scholarship-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
    
    .document-card {
        margin-bottom: 1rem;
    }
    
    .stat-item {
        flex-direction: column;
        text-align: center;
        gap: 0.5rem;
    }
}

/* Custom mint-blue variables */
:root {
    --mint-primary: #00c9a7;
    --mint-secondary: #00bcd4;
    --mint-dark: #00a693;
    --mint-light: #4dd0e1;
    --mint-blue: #0891b2;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Print functionality
    window.printData = function() {
        window.print();
    }
    
    // Enhanced form submission with loading state
    const statusForm = document.querySelector('form[method="POST"]');
    if (statusForm && !statusForm.querySelector('input[name="_method"][value="DELETE"]')) {
        statusForm.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memproses...';
            
            // Re-enable button after 3 seconds as fallback
            setTimeout(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }, 3000);
        });
    }
    
    // Tooltip initialization
    if (typeof bootstrap !== 'undefined') {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
    
    // Auto-resize reason text if too long
    const reasonText = document.querySelector('.reason-text');
    if (reasonText && reasonText.scrollHeight > 150) {
        reasonText.style.maxHeight = '150px';
        reasonText.style.overflowY = 'auto';
        reasonText.classList.add('scrollable-content');
    }
});
</script>

<style>
/* Print styles */
@media print {
    .card-body .btn,
    .card-header .btn,
    .d-grid form,
    hr {
        display: none !important;
    }
    
    .card {
        box-shadow: none !important;
        border: 1px solid #ddd !important;
    }
    
    .detail-section {
        break-inside: avoid;
    }
}

/* Scrollable content styling */
.scrollable-content {
    border: 1px solid #e9ecef;
    border-radius: 4px;
    padding: 0.5rem;
}

.scrollable-content::-webkit-scrollbar {
    width: 6px;
}

.scrollable-content::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

.scrollable-content::-webkit-scrollbar-thumb {
    background: var(--mint-primary, #00c9a7);
    border-radius: 3px;
}

.scrollable-content::-webkit-scrollbar-thumb:hover {
    background: var(--mint-dark, #00a693);
}
</style>
@endsection