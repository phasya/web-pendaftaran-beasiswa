@extends('layouts.admin')

@section('title', 'Master File Types')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <div>
        <h1 class="h2"><i class="fas fa-file-alt"></i> Master File Types</h1>
        <p class="text-muted mb-0">
            <i class="fas fa-info-circle me-2"></i>Kelola jenis-jenis file yang bisa diupload untuk beasiswa
        </p>
    </div>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.file-types.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah File Type
        </a>
    </div>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card border-0 bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title mb-1">Total File Types</h6>
                        <h4 class="mb-0">{{ $fileTypes->total() ?? 0 }}</h4>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-file-alt fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title mb-1">File Types Aktif</h6>
                        <h4 class="mb-0">{{ $fileTypes->where('aktif', true)->count() }}</h4>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-check-circle fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title mb-1">File Types Wajib</h6>
                        <h4 class="mb-0">{{ $fileTypes->where('wajib', true)->count() }}</h4>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-exclamation-circle fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title mb-1">Rata-rata Size Limit</h6>
                        <h4 class="mb-0 small">{{ number_format($fileTypes->avg('ukuran_maksimal') / 1024, 1) }} MB</h4>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-hdd fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-white py-3">
        <div class="row align-items-center">
            <div class="col">
                <h6 class="card-title mb-0">
                    <i class="fas fa-list"></i> Daftar File Types
                    @if($fileTypes->total() > 0)
                        <span class="badge bg-primary ms-2">{{ $fileTypes->total() }} Total</span>
                    @endif
                </h6>
            </div>
            <div class="col-auto">
                <small class="text-muted">
                    Menampilkan {{ $fileTypes->firstItem() ?? 0 }} - {{ $fileTypes->lastItem() ?? 0 }} 
                    dari {{ $fileTypes->total() }} data
                </small>
            </div>
        </div>
    </div>
    
    <div class="card-body p-0">
        @if($fileTypes->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center" style="width: 50px;">No</th>
                            <th style="min-width: 200px;">
                                <i class="fas fa-file-alt"></i> File Type
                            </th>
                            <th class="text-center" style="width: 150px;">
                                <i class="fas fa-file-code"></i> Ekstensi
                            </th>
                            <th class="text-center" style="width: 120px;">
                                <i class="fas fa-weight"></i> Max Size
                            </th>
                            <th class="text-center" style="width: 80px;">
                                <i class="fas fa-sort-numeric-up"></i> Urutan
                            </th>
                            <th class="text-center" style="width: 100px;">
                                <i class="fas fa-info-circle"></i> Status
                            </th>
                            <th class="text-center" style="width: 100px;">
                                <i class="fas fa-exclamation-circle"></i> Wajib
                            </th>
                            <th class="text-center" style="width: 120px;">
                                <i class="fas fa-cogs"></i> Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($fileTypes as $index => $fileType)
                        <tr>
                            <td class="text-center fw-bold text-muted">
                                {{ $fileTypes->firstItem() + $index }}
                            </td>
                            <td>
                                <div class="d-flex align-items-start">
                                    <div class="file-icon rounded-circle bg-gradient-info text-white me-3 d-flex align-items-center justify-content-center" 
                                         style="width: 45px; height: 45px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                        <i class="fas fa-file-alt"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1 fw-semibold">{{ $fileType->nama_file_type }}</h6>
                                        @if($fileType->deskripsi)
                                            <small class="text-muted">{{ Str::limit($fileType->deskripsi, 60) }}</small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="ekstensi-wrapper">
                                    @foreach($fileType->ekstensi_array as $ext)
                                        <span class="badge bg-light text-dark me-1 mb-1">{{ strtoupper($ext) }}</span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="fw-bold text-info">{{ $fileType->ukuran_mb }} MB</span>
                                <br>
                                <small class="text-muted">({{ number_format($fileType->ukuran_maksimal) }} KB)</small>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-secondary-soft text-secondary px-3 py-2">
                                    {{ $fileType->urutan }}
                                </span>
                            </td>
                            <td class="text-center">
                                @if($fileType->aktif)
                                    <span class="badge bg-success-soft text-success px-3 py-2">
                                        <i class="fas fa-check-circle me-1"></i>Aktif
                                    </span>
                                @else
                                    <span class="badge bg-secondary-soft text-secondary px-3 py-2">
                                        <i class="fas fa-times-circle me-1"></i>Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($fileType->wajib)
                                    <span class="badge bg-warning-soft text-warning px-3 py-2">
                                        <i class="fas fa-exclamation-circle me-1"></i>Wajib
                                    </span>
                                @else
                                    <span class="badge bg-info-soft text-info px-3 py-2">
                                        <i class="fas fa-minus-circle me-1"></i>Opsional
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group-vertical btn-group-sm" role="group">
                                    <a href="{{ route('admin.file-types.show', $fileType) }}" 
                                       class="btn btn-outline-info btn-sm mb-1" 
                                       title="Lihat Detail"
                                       data-bs-toggle="tooltip">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.file-types.edit', $fileType) }}" 
                                       class="btn btn-outline-warning btn-sm mb-1" 
                                       title="Edit File Type"
                                       data-bs-toggle="tooltip">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.file-types.toggle-status', $fileType) }}" 
                                          method="POST" 
                                          class="d-inline mb-1">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" 
                                                class="btn btn-outline-{{ $fileType->aktif ? 'secondary' : 'success' }} btn-sm" 
                                                title="{{ $fileType->aktif ? 'Nonaktifkan' : 'Aktifkan' }}"
                                                data-bs-toggle="tooltip">
                                            <i class="fas fa-{{ $fileType->aktif ? 'toggle-off' : 'toggle-on' }}"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.file-types.destroy', $fileType) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus file type {{ $fileType->nama_file_type }}? Data yang sudah terkait akan terpengaruh!')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-outline-danger btn-sm" 
                                                title="Hapus File Type"
                                                data-bs-toggle="tooltip">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <div class="empty-state">
                    <div class="empty-state-icon bg-light rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                        <i class="fas fa-file-alt fa-3x text-muted"></i>
                    </div>
                    <h5 class="text-muted mb-2">Belum Ada File Type</h5>
                    <p class="text-muted mb-3">Silakan tambahkan file type baru untuk mengatur jenis file yang bisa diupload</p>
                    <a href="{{ route('admin.file-types.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah File Type Pertama
                    </a>
                </div>
            </div>
        @endif
    </div>
    
    @if($fileTypes->hasPages())
    <div class="card-footer bg-white">
        <div class="d-flex justify-content-between align-items-center">
            <small class="text-muted">
                Menampilkan {{ $fileTypes->firstItem() }} - {{ $fileTypes->lastItem() }} 
                dari {{ $fileTypes->total() }} data
            </small>
            {{ $fileTypes->links() }}
        </div>
    </div>
    @endif
</div>

<!-- Custom CSS -->
<style>
/* Status Badge Colors - Same as dashboard */
.bg-success-soft { background-color: #d1edff !important; }
.bg-warning-soft { background-color: #fff3cd !important; }
.bg-danger-soft { background-color: #f8d7da !important; }
.bg-info-soft { background-color: #d1ecf1 !important; }
.bg-secondary-soft { background-color: #e2e3e5 !important; }

/* Table Styling */
.table th {
    font-weight: 600;
    font-size: 0.875rem;
    color: #495057;
    border-bottom: 2px solid #dee2e6;
}

.table td {
    vertical-align: middle;
    padding: 1rem 0.75rem;
}

.table-hover tbody tr:hover {
    background-color: #f8f9fa;
}

/* File Icon */
.file-icon {
    font-size: 1.2rem;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

/* Extension Wrapper */
.ekstensi-wrapper {
    line-height: 1.3;
}

/* Button Groups */
.btn-group-vertical .btn {
    border-radius: 0.375rem !important;
    margin-bottom: 0.25rem;
}

.btn-group-vertical .btn:last-child {
    margin-bottom: 0;
}

/* Badge Improvements */
.badge {
    font-size: 0.75rem;
    font-weight: 500;
}

.badge.fs-6 {
    font-size: 0.9rem !important;
}

/* Stats Cards */
.card.bg-primary, .card.bg-success, .card.bg-info, .card.bg-warning {
    background: linear-gradient(135deg, var(--bs-primary) 0%, var(--bs-primary) 100%);
    border: none;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s;
}

.card.bg-success {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;
}

.card.bg-info {
    background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%) !important;
}

.card.bg-warning {
    background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%) !important;
}

.card:hover {
    transform: translateY(-2px);
}

/* Empty State */
.empty-state-icon {
    transition: all 0.3s ease;
}

.empty-state:hover .empty-state-icon {
    transform: scale(1.05);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .btn-group-vertical {
        flex-direction: row;
    }
    
    .stats-card .card-body {
        padding: 1rem;
    }
    
    .file-icon {
        width: 35px !important;
        height: 35px !important;
        font-size: 1rem;
    }
}
</style>

<script>
// Tooltip initialization
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips if Bootstrap is available
    if (typeof bootstrap !== 'undefined') {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
    
    // Add smooth animations
    const cards = document.querySelectorAll('.card');
    cards.forEach(card => {
        card.style.transition = 'all 0.3s ease';
    });
});
</script>
@endsection