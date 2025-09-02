@extends('layouts.admin')

@section('title', 'Detail Pendaftar')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <div>
            <h1 class="h2"><i class="fas fa-user-graduate text-primary"></i> Detail Pendaftar</h1>
            <p class="text-muted mb-0">
                <i class="fas fa-info-circle me-2"></i>Informasi lengkap data pendaftar beasiswa
            </p>
        </div>
        <div>
            <a href="{{ route('admin.pendaftar.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Main Detail Card -->
            <div class="card shadow-sm">
                <div class="card-header py-3">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="card-title mb-1 text-white">
                                <i class="fas fa-user me-2"></i>{{ $pendaftar->nama_lengkap }}
                            </h5>
                            <small class="text-white-50">
                                <i class="fas fa-id-card me-1"></i>NIM: {{ $pendaftar->nim }}
                            </small>
                        </div>
                        <div class="col-auto">
                            @php
                                $statusClass = match($pendaftar->status) {
                                    'diterima' => 'bg-success',
                                    'ditolak' => 'bg-danger', 
                                    'pending' => 'bg-warning',
                                    default => 'bg-secondary'
                                };
                                $statusText = match($pendaftar->status) {
                                    'diterima' => 'Diterima',
                                    'ditolak' => 'Ditolak',
                                    'pending' => 'Pending',
                                    default => ucfirst($pendaftar->status)
                                };
                            @endphp
                            <span class="badge {{ $statusClass }} px-3 py-2">
                                <i class="fas fa-circle me-1"></i>{{ $statusText }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <!-- Personal Info Section -->
                    <div class="detail-section mb-4">
                        <h6 class="section-title mb-3">
                            <i class="fas fa-user-circle text-primary me-2"></i>Informasi Personal
                        </h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="info-item">
                                    <label class="info-label">Nama Lengkap</label>
                                    <p class="info-text">{{ $pendaftar->nama_lengkap }}</p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="info-item">
                                    <label class="info-label">NIM</label>
                                    <p class="info-text">{{ $pendaftar->nim }}</p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="info-item">
                                    <label class="info-label">Email</label>
                                    <p class="info-text">
                                        <a href="mailto:{{ $pendaftar->email }}" class="text-decoration-none">
                                            {{ $pendaftar->email }}
                                        </a>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="info-item">
                                    <label class="info-label">No. HP</label>
                                    <p class="info-text">
                                        <a href="tel:{{ $pendaftar->no_hp }}" class="text-decoration-none">
                                            {{ $pendaftar->no_hp }}
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Beasiswa Info Section -->
                    <div class="detail-section mb-4">
                        <h6 class="section-title mb-3">
                            <i class="fas fa-trophy text-warning me-2"></i>Beasiswa yang Didaftar
                        </h6>
                        <div class="beasiswa-card">
                            <div class="d-flex align-items-center">
                                <div class="beasiswa-icon">
                                    <i class="fas fa-graduation-cap"></i>
                                </div>
                                <div class="beasiswa-info">
                                    <h6 class="beasiswa-name">{{ $pendaftar->beasiswa->nama_beasiswa }}</h6>
                                    <p class="beasiswa-amount">
                                        Rp {{ number_format($pendaftar->beasiswa->jumlah_dana, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Application Info Section -->
                    <div class="detail-section mb-4">
                        <h6 class="section-title mb-3">
                            <i class="fas fa-file-alt text-info me-2"></i>Informasi Pendaftaran
                        </h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="info-item">
                                    <label class="info-label">Tanggal Daftar</label>
                                    <p class="info-text">
                                        {{ $pendaftar->tanggal_daftar ? \Carbon\Carbon::parse($pendaftar->tanggal_daftar)->format('d M Y H:i') : 'N/A' }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="info-item">
                                    <label class="info-label">Status</label>
                                    <p class="info-text">
                                        <span class="badge {{ $statusClass }}">{{ $statusText }}</span>
                                    </p>
                                </div>
                            </div>
                            @if($pendaftar->tanggal_verifikasi)
                            <div class="col-md-6 mb-3">
                                <div class="info-item">
                                    <label class="info-label">Tanggal Verifikasi</label>
                                    <p class="info-text">
                                        {{ \Carbon\Carbon::parse($pendaftar->tanggal_verifikasi)->format('d M Y H:i') }}
                                    </p>
                                </div>
                            </div>
                            @endif
                            @if($pendaftar->verified_by)
                            <div class="col-md-6 mb-3">
                                <div class="info-item">
                                    <label class="info-label">Diverifikasi Oleh</label>
                                    <p class="info-text">{{ $pendaftar->verified_by }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Reason Section -->
                    <div class="detail-section mb-4">
                        <h6 class="section-title mb-3">
                            <i class="fas fa-comment-dots text-success me-2"></i>Alasan Mendaftar
                        </h6>
                        <div class="content-box">
                            <p class="mb-0">{{ $pendaftar->alasan_mendaftar }}</p>
                        </div>
                    </div>

                    <!-- Documents Section -->
                    <div class="detail-section mb-4">
                        <h6 class="section-title mb-3">
                            <i class="fas fa-folder-open text-primary me-2"></i>Dokumen Pendukung
                        </h6>
                        <div class="row">
                            @if($pendaftar->file_transkrip)
                            <div class="col-md-4 mb-3">
                                <div class="document-card">
                                    <div class="document-icon">
                                        <i class="fas fa-file-pdf text-danger"></i>
                                    </div>
                                    <div class="document-info">
                                        <h6>Transkrip Nilai</h6>
                                        {{-- <a href="{{ route('#', [$pendaftar, 'transkrip']) }}"  --}}
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-download me-1"></i>Download
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if($pendaftar->file_ktp)
                            <div class="col-md-4 mb-3">
                                <div class="document-card">
                                    <div class="document-icon">
                                        <i class="fas fa-id-card text-info"></i>
                                    </div>
                                    <div class="document-info">
                                        <h6>KTP</h6>
                                        {{-- <a href="{{ route('admin.pendaftar.download', [$pendaftar, 'ktp']) }}"  --}}
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-download me-1"></i>Download
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if($pendaftar->file_kk)
                            <div class="col-md-4 mb-3">
                                <div class="document-card">
                                    <div class="document-icon">
                                        <i class="fas fa-users text-success"></i>
                                    </div>
                                    <div class="document-info">
                                        <h6>Kartu Keluarga</h6>
                                        {{-- <a href="{{ route('admin.pendaftar.download', [$pendaftar, 'kk']) }}"  --}}
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-download me-1"></i>Download
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Keterangan Section -->
                    @if($pendaftar->keterangan)
                    <div class="detail-section mb-4">
                        <h6 class="section-title mb-3">
                            <i class="fas fa-sticky-note text-warning me-2"></i>Keterangan
                        </h6>
                        <div class="content-box">
                            <p class="mb-0">{{ $pendaftar->keterangan }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Status Update Card -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0 text-white">
                        <i class="fas fa-edit me-2"></i>Update Status
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.pendaftar.update-status', $pendaftar) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="pending" {{ $pendaftar->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="diterima" {{ $pendaftar->status == 'diterima' ? 'selected' : '' }}>Diterima</option>
                                <option value="ditolak" {{ $pendaftar->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="3" 
                                      placeholder="Tambahkan keterangan...">{{ $pendaftar->keterangan }}</textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-save me-2"></i>Update Status
                        </button>
                    </form>
                </div>
            </div>

            <!-- Quick Actions Card -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0 text-white">
                        <i class="fas fa-bolt me-2"></i>Aksi Cepat
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="mailto:{{ $pendaftar->email }}" class="btn btn-outline-primary">
                            <i class="fas fa-envelope me-2"></i>Kirim Email
                        </a>
                        <a href="tel:{{ $pendaftar->no_hp }}" class="btn btn-outline-success">
                            <i class="fas fa-phone me-2"></i>Telepon
                        </a>
                        @if($pendaftar->beasiswa)
                        <a href="{{ route('admin.beasiswa.show', $pendaftar->beasiswa) }}" class="btn btn-outline-warning">
                            <i class="fas fa-trophy me-2"></i>Lihat Beasiswa
                        </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Info Card -->
            <div class="card shadow-sm">
                <div class="card-header">
                    <h6 class="card-title mb-0 text-white">
                        <i class="fas fa-info-circle me-2"></i>Informasi Tambahan
                    </h6>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker bg-primary"></div>
                            <div class="timeline-content">
                                <h6>Pendaftaran</h6>
                                <p class="mb-0 text-muted">
                                    {{ $pendaftar->tanggal_daftar ? \Carbon\Carbon::parse($pendaftar->tanggal_daftar)->format('d M Y H:i') : 'N/A' }}
                                </p>
                            </div>
                        </div>
                        
                        @if($pendaftar->tanggal_verifikasi)
                        <div class="timeline-item">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <h6>Verifikasi</h6>
                                <p class="mb-0 text-muted">
                                    {{ \Carbon\Carbon::parse($pendaftar->tanggal_verifikasi)->format('d M Y H:i') }}
                                </p>
                                @if($pendaftar->verified_by)
                                <small class="text-muted">oleh {{ $pendaftar->verified_by }}</small>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom CSS -->
    <style>
        /* Orange/Yellow Theme */
        :root {
            --primary-orange: #FF9B00;
            --primary-yellow: #FFE100;
            --secondary-yellow: #FFC900;
            --light-yellow: #EBE389;
            --dark-orange: #e8890a;
            --gradient-warm: linear-gradient(135deg, #FF9B00, #FFE100, #FFC900);
        }

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

        .info-item {
            background: linear-gradient(45deg, #fefefe, var(--light-yellow));
            border: 1px solid var(--secondary-yellow);
            border-radius: 8px;
            padding: 1rem;
            height: 100%;
        }

        .info-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: #6c757d;
            margin-bottom: 0.5rem;
        }

        .info-text {
            font-size: 1rem;
            margin-bottom: 0;
            color: #495057;
        }

        .content-box {
            background: linear-gradient(45deg, #fefefe, var(--light-yellow));
            border: 1px solid var(--secondary-yellow);
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 2px 8px rgba(255, 155, 0, 0.1);
        }

        .beasiswa-card {
            background: linear-gradient(135deg, #ffffff, #fffcf0);
            border: 1px solid var(--light-yellow);
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0 2px 8px rgba(255, 155, 0, 0.15);
        }

        .beasiswa-icon {
            width: 60px;
            height: 60px;
            background: var(--gradient-warm);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            margin-right: 1rem;
        }

        .beasiswa-name {
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #495057;
        }

        .beasiswa-amount {
            font-weight: bold;
            color: var(--primary-orange);
            margin-bottom: 0;
        }

        .document-card {
            background: linear-gradient(135deg, #ffffff, #fffcf0);
            border: 1px solid var(--light-yellow);
            border-radius: 8px;
            padding: 1rem;
            text-align: center;
            transition: all 0.3s ease;
        }

        .document-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 155, 0, 0.2);
        }

        .document-icon {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .document-info h6 {
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
            color: #495057;
        }

        .card-header {
            background: var(--gradient-warm);
            color: white;
            border-bottom: 2px solid var(--light-yellow);
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(255, 155, 0, 0.1);
        }

        .btn-primary {
            background: var(--gradient-warm);
            border: none;
            color: white;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--dark-orange), #e6cb00, #e6b800);
            color: white;
            transform: translateY(-1px);
        }

        .text-primary {
            color: var(--primary-orange) !important;
        }

        /* Timeline styling */
        .timeline {
            position: relative;
            padding-left: 2rem;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 1rem;
            top: 0;
            bottom: 0;
            width: 2px;
            background: var(--light-yellow);
        }

        .timeline-item {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .timeline-marker {
            position: absolute;
            left: -2rem;
            top: 0.5rem;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            border: 2px solid white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .timeline-content h6 {
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
            color: #495057;
        }

        .timeline-content p {
            font-size: 0.875rem;
        }
    </style>
@endsection