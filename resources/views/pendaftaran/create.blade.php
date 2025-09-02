@extends('layouts.app')

@section('title', 'Daftar Beasiswa - ' . $beasiswa->nama_beasiswa)

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <!-- Header Section -->
                <div class="text-center mb-4">
                    <h2 class="display-6 text-primary fw-bold">
                        <i class="fas fa-graduation-cap me-2"></i>Pendaftaran Beasiswa
                    </h2>
                    <p class="text-muted lead">Lengkapi formulir di bawah untuk mendaftar beasiswa</p>
                </div>

                <!-- Main Registration Card -->
                <div class="card shadow-lg border-0">
                    <div class="card-header py-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h4 class="card-title mb-1">
                                    <i class="fas fa-trophy text-warning me-2"></i>{{ $beasiswa->nama_beasiswa }}
                                </h4>
                                <small class="text-muted">
                                    <i class="fas fa-calendar-alt me-1"></i>Batas pendaftaran: {{ \Carbon\Carbon::parse($beasiswa->tanggal_tutup)->format('d M Y') }}
                                </small>
                            </div>
                            <div class="scholarship-amount">
                                <span class="badge bg-success-custom px-3 py-2">
                                    <i class="fas fa-money-bill-wave me-1"></i>Rp {{ number_format($beasiswa->jumlah_dana, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-5">
                        <!-- Scholarship Info Section -->
                        <div class="info-section mb-5">
                            <h5 class="section-title mb-3">
                                <i class="fas fa-info-circle text-info me-2"></i>Informasi Beasiswa
                            </h5>
                            <div class="info-box">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="info-item">
                                            <label class="info-label">Dana Beasiswa</label>
                                            <p class="info-value text-success fw-bold">
                                                Rp {{ number_format($beasiswa->jumlah_dana, 0, ',', '.') }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="info-item">
                                            <label class="info-label">Batas Waktu Pendaftaran</label>
                                            <p class="info-value text-danger fw-bold">
                                                {{ \Carbon\Carbon::parse($beasiswa->tanggal_tutup)->format('d M Y') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="requirements-section">
                                    <label class="info-label">Persyaratan</label>
                                    <div class="requirements-content">
                                        {{ $beasiswa->persyaratan }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Registration Form -->
                        <div class="form-section">
                            <h5 class="section-title mb-4">
                                <i class="fas fa-edit text-primary me-2"></i>Formulir Pendaftaran
                            </h5>

                            <form method="POST" action="{{ route('pendaftar.store', $beasiswa) }}" enctype="multipart/form-data" id="registrationForm">
                                @csrf

                                <!-- Personal Information -->
                                <div class="form-group-section mb-4">
                                    <h6 class="form-group-title">
                                        <i class="fas fa-user-circle text-info me-2"></i>Data Personal
                                    </h6>
                                    <div class="form-group-content">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="nama_lengkap" class="form-label">
                                                    <i class="fas fa-user me-1"></i>Nama Lengkap *
                                                </label>
                                                <input type="text" 
                                                       class="form-control modern-input @error('nama_lengkap') is-invalid @enderror" 
                                                       id="nama_lengkap" 
                                                       name="nama_lengkap" 
                                                       value="{{ old('nama_lengkap') }}" 
                                                       placeholder="Masukkan nama lengkap"
                                                       required>
                                                @error('nama_lengkap')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="nim" class="form-label">
                                                    <i class="fas fa-id-badge me-1"></i>NIM *
                                                </label>
                                                <input type="text" 
                                                       class="form-control modern-input @error('nim') is-invalid @enderror" 
                                                       id="nim" 
                                                       name="nim" 
                                                       value="{{ old('nim') }}" 
                                                       placeholder="Masukkan NIM"
                                                       required>
                                                @error('nim')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="email" class="form-label">
                                                    <i class="fas fa-envelope me-1"></i>Email *
                                                </label>
                                                <input type="email" 
                                                       class="form-control modern-input @error('email') is-invalid @enderror" 
                                                       id="email" 
                                                       name="email" 
                                                       value="{{ old('email') }}" 
                                                       placeholder="contoh@email.com"
                                                       required>
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="no_hp" class="form-label">
                                                    <i class="fas fa-phone me-1"></i>No. HP *
                                                </label>
                                                <input type="text" 
                                                       class="form-control modern-input @error('no_hp') is-invalid @enderror" 
                                                       id="no_hp" 
                                                       name="no_hp" 
                                                       value="{{ old('no_hp') }}" 
                                                       placeholder="08xxxxxxxxxx"
                                                       required>
                                                @error('no_hp')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Reason Section -->
                                <div class="form-group-section mb-4">
                                    <h6 class="form-group-title">
                                        <i class="fas fa-comment-alt text-warning me-2"></i>Motivasi
                                    </h6>
                                    <div class="form-group-content">
                                        <div class="mb-3">
                                            <label for="alasan_mendaftar" class="form-label">
                                                <i class="fas fa-quote-left me-1"></i>Alasan Mendaftar *
                                            </label>
                                            <textarea class="form-control modern-textarea @error('alasan_mendaftar') is-invalid @enderror" 
                                                      id="alasan_mendaftar" 
                                                      name="alasan_mendaftar" 
                                                      rows="5" 
                                                      placeholder="Jelaskan alasan dan motivasi Anda mendaftar beasiswa ini..."
                                                      required>{{ old('alasan_mendaftar') }}</textarea>
                                            <div class="form-text">
                                                <i class="fas fa-lightbulb text-warning me-1"></i>
                                                Jelaskan secara detail mengapa Anda layak mendapatkan beasiswa ini
                                            </div>
                                            @error('alasan_mendaftar')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Document Requirements Section -->
                                <div class="requirements-section mb-4">
                                    <label class="text-muted small fw-semibold">DOKUMEN PENDUKUNG YANG DIPERLUKAN</label>
                                    <div class="bg-light p-3 rounded-3 mt-2">
                                        @if(method_exists($beasiswa, 'getDokumenPendukungLabelAttribute') && $beasiswa->dokumen_pendukung_label && count($beasiswa->dokumen_pendukung_label) > 0)
                                            <div class="row">
                                                @foreach($beasiswa->dokumen_pendukung_label as $dokumen)
                                                    <div class="col-md-6 mb-2">
                                                        <div class="d-flex align-items-center">
                                                            <i class="fas fa-file-alt text-primary me-2"></i>
                                                            <span>{{ $dokumen }}</span>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="row">
                                                <div class="col-md-4 mb-2">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-id-card text-primary me-2"></i>
                                                        <span>KTP</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-2">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-users text-primary me-2"></i>
                                                        <span>Kartu Keluarga</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-2">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-file-alt text-primary me-2"></i>
                                                        <span>Transkrip Nilai</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- File Upload Section -->
                                <div class="form-group-section mb-4">
                                    <h6 class="form-group-title">
                                        <i class="fas fa-upload text-success me-2"></i>Upload Dokumen
                                    </h6>
                                    <div class="form-group-content">
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <div class="file-upload-card">
                                                    <label for="file_ktp" class="file-label">
                                                        <div class="file-icon">
                                                            <i class="fas fa-id-card text-info"></i>
                                                        </div>
                                                        <div class="file-info">
                                                            <h6 class="file-title">KTP *</h6>
                                                            <small class="file-desc">PDF/JPG/PNG, Max: 5MB</small>
                                                        </div>
                                                    </label>
                                                    <input type="file" 
                                                           class="form-control file-input @error('file_ktp') is-invalid @enderror" 
                                                           id="file_ktp" 
                                                           name="file_ktp" 
                                                           accept=".pdf,.jpg,.jpeg,.png" 
                                                           required>
                                                    @error('file_ktp')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <div class="file-upload-card">
                                                    <label for="file_kk" class="file-label">
                                                        <div class="file-icon">
                                                            <i class="fas fa-users text-success"></i>
                                                        </div>
                                                        <div class="file-info">
                                                            <h6 class="file-title">Kartu Keluarga *</h6>
                                                            <small class="file-desc">PDF/JPG/PNG, Max: 5MB</small>
                                                        </div>
                                                    </label>
                                                    <input type="file" 
                                                           class="form-control file-input @error('file_kk') is-invalid @enderror" 
                                                           id="file_kk" 
                                                           name="file_kk" 
                                                           accept=".pdf,.jpg,.jpeg,.png" 
                                                           required>
                                                    @error('file_kk')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <div class="file-upload-card">
                                                    <label for="file_transkrip" class="file-label">
                                                        <div class="file-icon">
                                                            <i class="fas fa-file-alt text-warning"></i>
                                                        </div>
                                                        <div class="file-info">
                                                            <h6 class="file-title">Transkrip Nilai *</h6>
                                                            <small class="file-desc">PDF/JPG/PNG, Max: 5MB</small>
                                                        </div>
                                                    </label>
                                                    <input type="file" 
                                                           class="form-control file-input @error('file_transkrip') is-invalid @enderror" 
                                                           id="file_transkrip" 
                                                           name="file_transkrip" 
                                                           accept=".pdf,.jpg,.jpeg,.png" 
                                                           required>
                                                    @error('file_transkrip')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Terms and Submit -->
                                <div class="form-group-section">
                                    <div class="terms-section mb-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="terms" required>
                                            <label class="form-check-label" for="terms">
                                                Saya menyatakan bahwa data yang saya berikan adalah <strong>benar dan valid</strong>. 
                                                Saya bersedia menerima konsekuensi jika terbukti memberikan data palsu.
                                            </label>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-column flex-md-row gap-3 justify-content-between align-items-center">
                                        <div class="form-info">
                                            <small class="text-muted">
                                                <i class="fas fa-shield-alt me-1"></i>
                                                Data Anda akan dijaga kerahasiaannya
                                            </small>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                                                <i class="fas fa-arrow-left me-2"></i>Kembali
                                            </a>
                                            <button type="submit" class="btn btn-primary btn-submit">
                                                <i class="fas fa-paper-plane me-2"></i>Daftar Sekarang
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Tips Section -->
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card tip-card border-primary">
                            <div class="card-body">
                                <h6 class="card-title text-primary">
                                    <i class="fas fa-lightbulb me-2"></i>Tips Sukses
                                </h6>
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-2">
                                        <i class="fas fa-check text-success me-2"></i>
                                        <small>Pastikan dokumen berkualitas baik dan jelas</small>
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-check text-success me-2"></i>
                                        <small>Tulis alasan mendaftar dengan jujur dan meyakinkan</small>
                                    </li>
                                    <li>
                                        <i class="fas fa-check text-success me-2"></i>
                                        <small>Periksa kembali semua data sebelum mengirim</small>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card tip-card border-warning">
                            <div class="card-body">
                                <h6 class="card-title text-warning">
                                    <i class="fas fa-exclamation-triangle me-2"></i>Perhatian
                                </h6>
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-2">
                                        <i class="fas fa-info text-info me-2"></i>
                                        <small>Ukuran maksimal file adalah 5MB per dokumen</small>
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-info text-info me-2"></i>
                                        <small>Proses seleksi membutuhkan waktu 1-2 minggu</small>
                                    </li>
                                    <li>
                                        <i class="fas fa-info text-info me-2"></i>
                                        <small>Anda akan dihubungi melalui email atau telepon</small>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom CSS -->
    <style>
        :root {
            --gold-primary: #FBC02D;
            --gold-secondary: #FFA000;
            --gold-dark: #FF8F00;
            --gold-light: #FFF8E1;
        }

        /* Badge */
        .bg-success-custom {
            background: linear-gradient(45deg, var(--gold-primary), var(--gold-dark)) !important;
            color: white !important;
            font-weight: 600;
            font-size: 0.9rem;
        }

        /* Card */
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .card-header {
            background: linear-gradient(135deg, var(--gold-primary), var(--gold-dark));
            color: white;
            border-bottom: none;
            border-radius: 15px 15px 0 0 !important;
            padding: 1.5rem 2rem;
        }

        .card-title {
            font-weight: 600;
            margin-bottom: 0;
        }

        /* Section Title */
        .section-title {
            font-weight: 600;
            color: #495057;
            font-size: 1.1rem;
            margin-bottom: 1rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid var(--gold-primary);
            display: inline-block;
        }

        /* Info Section */
        .info-section {
            background: var(--gold-light);
            border-radius: 12px;
            padding: 2rem;
            border-left: 4px solid var(--gold-primary);
        }

        .info-box {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .info-label {
            font-size: 0.9rem;
            font-weight: 600;
            color: #6c757d;
            margin-bottom: 0.5rem;
        }

        .info-value {
            font-size: 1.1rem;
            margin-bottom: 0;
        }

        /* Form group */
        .form-group-section {
            background: var(--gold-light);
            border-radius: 12px;
            padding: 1.5rem;
            border-left: 4px solid var(--gold-primary);
        }

        .form-group-title {
            font-weight: 600;
            color: #495057;
            margin-bottom: 1rem;
        }

        .form-group-content {
            background: white;
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.05);
        }

        /* Inputs */
        .modern-input,
        .modern-textarea {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .modern-input:focus,
        .modern-textarea:focus {
            border-color: var(--gold-primary);
            box-shadow: 0 0 0 0.25rem rgba(251, 192, 45, 0.2);
        }

        /* File upload */
        .file-upload-card {
            background: white;
            border: 2px dashed #e9ecef;
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .file-upload-card:hover {
            border-color: var(--gold-primary);
            background: #fffdf5;
            box-shadow: 0 4px 15px rgba(251, 192, 45, 0.1);
        }

        .file-upload-card.has-file {
            border-color: #28a745;
            background: #f8fff9;
        }

        .file-input {
            display: none;
        }

        .file-label {
            cursor: pointer;
            width: 100%;
            margin: 0;
        }

        .file-icon {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .file-info {
            text-align: center;
        }

        .file-title {
            font-size: 0.9rem;
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.25rem;
        }

        .file-desc {
            color: #6c757d;
            font-size: 0.75rem;
        }

        /* Buttons */
        .btn-primary {
            background: linear-gradient(45deg, var(--gold-primary), var(--gold-dark));
            border: none;
            color: white;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            border-radius: 10px;
        }

        .btn-primary:hover {
            background: linear-gradient(45deg, var(--gold-dark), #E65100);
            box-shadow: 0 6px 20px rgba(255, 160, 0, 0.3);
            transform: translateY(-1px);
        }

        .btn-outline-secondary {
            border: 2px solid #6c757d;
            color: #6c757d;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            border-radius: 10px;
        }

        .btn-outline-secondary:hover {
            background: #6c757d;
            color: white;
            transform: translateY(-1px);
        }

        /* Form Check */
        .form-check-input:checked {
            background-color: var(--gold-primary);
            border-color: var(--gold-primary);
        }

        /* Progress Bar */
        .progress {
            background-color: #e9ecef;
            border-radius: 10px;
        }

        .progress-bar {
            background: linear-gradient(45deg, var(--gold-primary), var(--gold-dark));
            border-radius: 10px;
            transition: width 0.3s ease;
        }

        /* Requirements Section */
        .requirements-section {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1.5rem;
        }

        .requirements-content {
            background: white;
            padding: 1rem;
            border-radius: 8px;
            margin-top: 0.5rem;
            border-left: 3px solid var(--gold-primary);
        }

        /* Terms Section */
        .terms-section {
            background: #fff3cd;
            border-radius: 10px;
            padding: 1.5rem;
            border-left: 4px solid #ffc107;
        }

        /* Tip Cards */
        .tip-card {
            border-radius: 12px;
            transition: all 0.3s ease;
            border-width: 2px;
        }

        .tip-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }

        /* Loading animation */
        .btn-submit.loading {
            opacity: 0.7;
            pointer-events: none;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .file-upload-card {
                margin-bottom: 1rem;
                height: auto;
                min-height: 120px;
            }

            .card-body {
                padding: 2rem 1rem;
            }

            .form-group-section {
                padding: 1rem;
            }

            .form-group-content {
                padding: 1rem;
            }

            .info-section {
                padding: 1rem;
            }

            .d-flex.gap-2 {
                flex-direction: column;
                gap: 0.5rem;
            }

            .btn {
                width: 100%;
            }
        }

        /* Focus states */
        .focused .modern-input,
        .focused .modern-textarea {
            border-color: var(--gold-primary);
            box-shadow: 0 0 0 0.25rem rgba(251, 192, 45, 0.2);
        }

        /* Animation for file upload */
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .file-upload-card.has-file {
            animation: pulse 0.3s ease-in-out;
        }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('registrationForm');
        const submitBtn = document.querySelector('.btn-submit');

        // File upload handling
        const fileInputs = document.querySelectorAll('.file-input');
        fileInputs.forEach(input => {
            input.addEventListener('change', function() {
                const card = this.closest('.file-upload-card');
                const fileTitle = card.querySelector('.file-title');
                const originalTitle = fileTitle.textContent.replace(' ✓', '');

                if (this.files && this.files[0]) {
                    card.classList.add('has-file');
                    fileTitle.textContent = originalTitle + ' ✓';
                    fileTitle.style.color = '#28a745';
                } else {
                    card.classList.remove('has-file');
                    fileTitle.textContent = originalTitle;
                    fileTitle.style.color = '#495057';
                }
            });
        });

        // Form validation
        form.addEventListener('submit', function(e) {
            const termsCheckbox = document.getElementById('terms');

            if (!termsCheckbox.checked) {
                e.preventDefault();
                alert('Anda harus menyetujui syarat dan ketentuan terlebih dahulu.');
                termsCheckbox.focus();
                return;
            }

            // Loading state
            submitBtn.classList.add('loading');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengirim...';

            // Re-enable after 30 seconds as fallback
            setTimeout(() => {
                submitBtn.classList.remove('loading');
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-paper-plane me-2"></i>Daftar Sekarang';
            }, 30000);
        });

        // Phone number formatting
        const phoneInput = document.getElementById('no_hp');
        phoneInput.addEventListener('input', function() {
            let value = this.value.replace(/\D/g, '');
            if (value.length > 13) {
                value = value.substring(0, 13);
            }
            this.value = value;
        });

        // Character counter for textarea
        const textareaElement = document.getElementById('alasan_mendaftar');
        if (textareaElement) {
            const maxLength = 1000;
            const counterElement = document.createElement('div');
            counterElement.className = 'form-text text-end mt-2';
            textareaElement.parentNode.appendChild(counterElement);

            function updateCounter() {
                const remaining = maxLength - textareaElement.value.length;
                counterElement.textContent = `${textareaElement.value.length}/${maxLength} karakter`;

                if (remaining < 100) {
                    counterElement.className = 'form-text text-end mt-2 text-warning';
                } else if (remaining < 0) {
                    counterElement.className = 'form-text text-end mt-2 text-danger';
                } else {
                    counterElement.className = 'form-text text-end mt-2 text-muted';
                }
            }

            textareaElement.addEventListener('input', updateCounter);
            updateCounter();
        }

        // Smooth scroll to error fields
        const errorFields = document.querySelectorAll('.is-invalid');
        if (errorFields.length > 0) {
            errorFields[0].scrollIntoView({ 
                behavior: 'smooth', 
                block: 'center' 
            });
        }

        // File size and type validation
        fileInputs.forEach(input => {
            input.addEventListener('change', function() {
                const file = this.files[0];
                const maxSize = 5 * 1024 * 1024; // 5MB in bytes
                const allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
                const card = this.closest('.file-upload-card');
                const fileTitle = card.querySelector('.file-title');
                const originalTitle = fileTitle.textContent.replace(' ✓', '');

                if (file) {
                    // Check file size
                    if (file.size > maxSize) {
                        alert('Ukuran file terlalu besar. Maksimal 5MB.');
                        this.value = '';
                        card.classList.remove('has-file');
                        fileTitle.textContent = originalTitle;
                        fileTitle.style.color = '#495057';
                        return;
                    }

                    // Check file type
                    if (!allowedTypes.includes(file.type)) {
                        alert('Tipe file tidak didukung. Hanya PDF, JPG, JPEG, dan PNG yang diperbolehkan.');
                        this.value = '';
                        card.classList.remove('has-file');
                        fileTitle.textContent = originalTitle;
                        fileTitle.style.color = '#495057';
                        return;
                    }
                }
            });
        });

        // Progress indicator
        const progressBar = document.createElement('div');
        progressBar.className = 'progress mb-4';
        progressBar.style.height = '6px';
        progressBar.innerHTML = '<div class="progress-bar" style="width: 0%"></div>';

        const formSection = document.querySelector('.form-section');
        const firstChild = formSection.querySelector('.section-title').nextElementSibling;
        formSection.insertBefore(progressBar, firstChild);

        function updateProgress() {
            const requiredFields = form.querySelectorAll('input[required], textarea[required]');
            const filledFields = Array.from(requiredFields).filter(field => {
                if (field.type === 'file') {
                    return field.files && field.files.length > 0;
                }
                return field.value.trim() !== '';
            });
            
            const progress = (filledFields.length / requiredFields.length) * 100;
            progressBar.querySelector('.progress-bar').style.width = progress + '%';
        }

        // Update progress on input
        const allInputs = form.querySelectorAll('input, textarea');
        allInputs.forEach(element => {
            element.addEventListener('input', updateProgress);
            element.addEventListener('change', updateProgress);
        });

        // Initial progress update
        updateProgress();

        // NIM validation
        const nimInput = document.getElementById('nim');
        nimInput.addEventListener('input', function() {
            let value = this.value.replace(/[^a-zA-Z0-9]/g, '');
            if (value.length > 15) {
                value = value.substring(0, 15);
            }
            this.value = value;
        });

        // Email validation enhancement
        const emailInput = document.getElementById('email');
        emailInput.addEventListener('blur', function() {
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (this.value && !emailPattern.test(this.value)) {
                this.classList.add('is-invalid');
                let feedback = this.parentNode.querySelector('.invalid-feedback');
                if (!feedback || !feedback.textContent.includes('Format email')) {
                    if (!feedback) {
                        feedback = document.createElement('div');
                        feedback.className = 'invalid-feedback';
                        this.parentNode.appendChild(feedback);
                    }
                    feedback.textContent = 'Format email tidak valid';
                }
            } else if (this.value) {
                this.classList.remove('is-invalid');
                const feedback = this.parentNode.querySelector('.invalid-feedback');
                if (feedback && feedback.textContent.includes('Format email')) {
                    feedback.remove();
                }
            }
        });

        // Auto-resize textarea
        if (textareaElement) {
            textareaElement.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = Math.min(this.scrollHeight, 200) + 'px';
            });
        }

        // Prevent form double submission
        let isSubmitting = false;
        form.addEventListener('submit', function(e) {
            if (isSubmitting) {
                e.preventDefault();
                return false;
            }
            isSubmitting = true;
        });

        // Real-time validation feedback
        const requiredInputs = document.querySelectorAll('input[required], textarea[required]');
        requiredInputs.forEach(input => {
            input.addEventListener('blur', function() {
                if (this.type === 'file') {
                    if (!this.files || this.files.length === 0) {
                        this.classList.add('is-invalid');
                    } else {
                        this.classList.remove('is-invalid');
                    }
                } else {
                    if (this.value.trim() === '') {
                        this.classList.add('is-invalid');
                    } else {
                        this.classList.remove('is-invalid');
                    }
                }
            });

            input.addEventListener('input', function() {
                if (this.classList.contains('is-invalid')) {
                    if (this.type === 'file') {
                        if (this.files && this.files.length > 0) {
                            this.classList.remove('is-invalid');
                        }
                    } else {
                        if (this.value.trim() !== '') {
                            this.classList.remove('is-invalid');
                        }
                    }
                }
            });
        });
    });
    </script>
@endsection