@extends('layouts.app')@section('title', 'Daftar Beasiswa - ' . $beasiswa->nama_beasiswa)

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
                                        {!! nl2br(e($beasiswa->persyaratan)) !!}
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
                                                       pattern="[0-9]+"
                                                       title="NIM hanya boleh berisi angka"
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
                                                       pattern="[0-9]{10,15}"
                                                       title="Nomor HP hanya boleh berisi angka (10-15 digit)"
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
                                                      placeholder="Jelaskan alasan dan motivasi Anda mendaftar beasiswa ini... (minimal 50 karakter)"
                                                      minlength="50"
                                                      maxlength="1000"
                                                      required>{{ old('alasan_mendaftar') }}</textarea>
                                            <div class="form-text">
                                                <i class="fas fa-lightbulb text-warning me-1"></i>
                                                Jelaskan secara detail mengapa Anda layak mendapatkan beasiswa ini (minimal 50 karakter)
                                            </div>
                                            @error('alasan_mendaftar')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Document Requirements Info -->
                                @php
                                    $dokumenPendukung = [];
                                    if ($beasiswa->dokumen_pendukung) {
                                        if (is_array($beasiswa->dokumen_pendukung)) {
                                            $dokumenPendukung = $beasiswa->dokumen_pendukung;
                                        } else {
                                            $decoded = json_decode($beasiswa->dokumen_pendukung, true);
                                            $dokumenPendukung = is_array($decoded) ? $decoded : [];
                                        }
                                    }

                                    $dokumenLabels = [
                                        'ktp' => 'KTP',
                                        'kk' => 'Kartu Keluarga',
                                        'ijazah' => 'Ijazah Terakhir',
                                        'transkrip' => 'Transkrip Nilai',
                                        'surat_keterangan_tidak_mampu' => 'Surat Keterangan Tidak Mampu',
                                        'slip_gaji_ortu' => 'Slip Gaji Orang Tua',
                                        'surat_rekomendasi' => 'Surat Rekomendasi',
                                        'sertifikat_prestasi' => 'Sertifikat Prestasi'
                                    ];
                                @endphp

                                @if(count($dokumenPendukung) > 0)
                                    <div class="requirements-section mb-4">
                                        <label class="text-muted small fw-semibold">DOKUMEN PENDUKUNG YANG DIPERLUKAN</label>
                                        <div class="bg-light p-3 rounded-3 mt-2">
                                            <div class="row">
                                                @foreach($dokumenPendukung as $dokumen)
                                                    @if(isset($dokumenLabels[$dokumen]))
                                                        <div class="col-md-6 mb-2">
                                                            <div class="d-flex align-items-center">
                                                                <i class="fas fa-file-alt text-primary me-2"></i>
                                                                <span>{{ $dokumenLabels[$dokumen] }}</span>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- File Upload Section -->
                                <div class="form-group-section mb-4">
                                    <h6 class="form-group-title">
                                        <i class="fas fa-upload text-danger me-2"></i>Upload Dokumen
                                    </h6>
                                    <div class="form-group-content">
                                        <div class="row">
                                            <!-- Required Documents -->
                                            <div class="col-md-4 mb-3">
                                                <div class="file-upload-card">
                                                    <label for="file_transkrip" class="file-label">
                                                        <div class="file-icon">
                                                            <i class="fas fa-file-pdf text-danger"></i>
                                                        </div>
                                                        <div class="file-info">
                                                            <h6 class="file-title">Transkrip Nilai *</h6>
                                                            <small class="file-desc">PDF, Max: 5MB</small>
                                                        </div>
                                                    </label>
                                                    <input type="file" 
                                                           class="form-control file-input @error('file_transkrip') is-invalid @enderror" 
                                                           id="file_transkrip" 
                                                           name="file_transkrip" 
                                                           accept=".pdf" 
                                                           required>
                                                    @error('file_transkrip')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <div class="file-upload-card">
                                                    <label for="file_ktp" class="file-label">
                                                        <div class="file-icon">
                                                            <i class="fas fa-id-card text-primary"></i>
                                                        </div>
                                                        <div class="file-info">
                                                            <h6 class="file-title">KTP *</h6>
                                                            <small class="file-desc">PDF/JPG/PNG, Max: 2MB</small>
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
                                                            <small class="file-desc">PDF/JPG/PNG, Max: 2MB</small>
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
                                        </div>

                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle me-2"></i>
                                            <strong>Perhatian:</strong>
                                            <ul class="mb-0 mt-2">
                                                <li>Pastikan semua file dapat dibaca dengan jelas</li>
                                                <li>File PDF untuk transkrip, file gambar atau PDF untuk KTP dan KK</li>
                                                <li>Ukuran maksimal: Transkrip 5MB, KTP & KK 2MB</li>
                                            </ul>
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
                                        <small>Pastikan koneksi internet stabil saat mengupload</small>
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

    <style>
        :root {
            --gold-primary: #FBC02D;
            --gold-secondary: #FFA000;
            --gold-dark: #FF8F00;
            --gold-light: #FFF8E1;
        }

        .bg-success-custom {
            background: linear-gradient(45deg, var(--gold-primary), var(--gold-dark)) !important;
            color: white !important;
            font-weight: 600;
            font-size: 0.9rem;
        }

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

        .section-title {
            font-weight: 600;
            color: #495057;
            font-size: 1.1rem;
            margin-bottom: 1rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid var(--gold-primary);
            display: inline-block;
        }

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

        .form-group-section {
            background: var(--gold-light);
            border-radius: 12px;
            padding: 1.5rem;
            border-left: 4px solid var(--gold-primary);
            margin-bottom: 1.5rem;
        }

        .form-group-content {
            background: white;
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.05);
        }

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

        .file-upload-card {
            background: white;
            border: 2px dashed #e9ecef;
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
            height: 100%;
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
            opacity: 0;
            position: absolute;
            z-index: -1;
        }

        .file-label {
            cursor: pointer;
            margin-bottom: 0;
        }

        .file-icon {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .file-title {
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .file-desc {
            color: #6c757d;
            font-size: 0.75rem;
        }

        .btn-primary {
            background: linear-gradient(45deg, var(--gold-primary), var(--gold-dark));
            border: none;
            color: white;
        }

        .btn-primary:hover {
            background: linear-gradient(45deg, var(--gold-dark), #E65100);
            box-shadow: 0 6px 20px rgba(255, 160, 0, 0.3);
        }

        .tip-card {
            border-radius: 12px;
            transition: all 0.3s ease;
            border-width: 2px;
        }

        .tip-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }

        .alert-info {
            background: linear-gradient(45deg, #e3f2fd, #bbdefb);
            border: none;
            border-left: 4px solid #2196f3;
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
                    // Validate file size
                    const file = this.files[0];
                    const maxSizes = {
                        'file_transkrip': 5 * 1024 * 1024, // 5MB
                        'file_ktp': 2 * 1024 * 1024, // 2MB
                        'file_kk': 2 * 1024 * 1024 // 2MB
                    };

                    const maxSize = maxSizes[this.name];

                    if (file.size > maxSize) {
                        const maxSizeMB = Math.round(maxSize / (1024 * 1024));
                        alert(`Ukuran file terlalu besar. Maksimal ${maxSizeMB}MB`);
                        this.value = '';
                        card.classList.remove('has-file');
                        fileTitle.textContent = originalTitle;
                        return;
                    }

                    // Validate file type
                    const allowedTypes = {
                        'file_transkrip': ['application/pdf'],
                        'file_ktp': ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'],
                        'file_kk': ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png']
                    };

                    if (!allowedTypes[this.name].includes(file.type)) {
                        alert('Jenis file tidak diizinkan. Silakan pilih file yang sesuai.');
                        this.value = '';
                        card.classList.remove('has-file');
                        fileTitle.textContent = originalTitle;
                        return;
                    }

                    card.classList.add('has-file');
                    fileTitle.innerHTML = originalTitle + ' <i class="fas fa-check text-success ms-1"></i>';
                } else {
                    card.classList.remove('has-file');
                    fileTitle.textContent = originalTitle;
                }
            });
        });

        // Form validation
        form.addEventListener('submit', function(e) {
            const termsCheckbox = document.getElementById('terms');
            const requiredFiles = ['file_transkrip', 'file_ktp', 'file_kk'];
            let isValid = true;

            // Check terms agreement
            if (!termsCheckbox.checked) {
                e.preventDefault();
                alert('Anda harus menyetujui syarat dan ketentuan terlebih dahulu.');
                termsCheckbox.focus();
                return;
            }

            // Check required files
            requiredFiles.forEach(fieldName => {
                const fileInput = document.getElementById(fieldName);
                if (!fileInput.files || !fileInput.files[0]) {
                    isValid = false;
                    fileInput.closest('.file-upload-card').style.borderColor = '#dc3545';
                }
            });

            if (!isValid) {
                e.preventDefault();
                alert('Semua dokumen wajib diupload.');
                return;
            }

            // Check text length
            const alasanTextarea = document.getElementById('alasan_mendaftar');
            if (alasanTextarea.value.trim().length < 50) {
                e.preventDefault();
                alert('Alasan mendaftar minimal 50 karakter.');
                alasanTextarea.focus();
                return;
            }

            // Loading state
            submitBtn.classList.add('loading');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengirim...';

            // Show progress message
            const progressAlert = document.createElement('div');
            progressAlert.className = 'alert alert-info mt-3';
            progressAlert.innerHTML = `
                <div class="d-flex align-items-center">
                    <div class="spinner-border spinner-border-sm me-3" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <div>
                        <strong>Sedang memproses pendaftaran...</strong><br>
                        <small>Mohon tunggu, jangan tutup halaman ini.</small>
                    </div>
                </div>
            `;
            form.appendChild(progressAlert);
        });

        // Phone number formatting
        const phoneInput = document.getElementById('no_hp');
        phoneInput.addEventListener('input', function() {
            // Remove non-digits
            let value = this.value.replace(/\D/g, '');

            // Limit length
            if (value.length > 15) {
                value = value.substring(0, 15);
            }

            this.value = value;
        });

        // NIM validation
        const nimInput = document.getElementById('nim');
        nimInput.addEventListener('input', function() {
            // Remove non-digits
            let value = this.value.replace(/\D/g, '');
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
                const length = textareaElement.value.length;
                const remaining = maxLength - length;
                counterElement.textContent = `${length}/${maxLength} karakter`;

                if (length < 50) {
                    counterElement.className = 'form-text text-end mt-2 text-danger';
                    counterElement.innerHTML = `${length}/${maxLength} karakter <small>(minimal 50 karakter)</small>`;
                } else if (remaining < 100) {
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

        // Real-time form validation
        const inputs = form.querySelectorAll('input[required], textarea[required]');
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                validateField(this);
            });

            input.addEventListener('input', function() {
                // Remove error styling on input
                this.classList.remove('is-invalid');
                const feedback = this.parentNode.querySelector('.invalid-feedback');
                if (feedback && !feedback.textContent.includes('{{')) {
                    feedback.style.display = 'none';
                }
            });
        });

        function validateField(field) {
            let isValid = true;
            let message = '';

            if (field.type === 'email') {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(field.value)) {
                    isValid = false;
                    message = 'Format email tidak valid';
                }
            }

            if (field.name === 'nim') {
                if (field.value.length < 8) {
                    isValid = false;
                    message = 'NIM minimal 8 karakter';
                } else if (!/^[0-9]+$/.test(field.value)) {
                    isValid = false;
                    message = 'NIM hanya boleh berisi angka';
                }
            }

            if (field.name === 'no_hp') {
                if (field.value.length < 10) {
                    isValid = false;
                    message = 'Nomor HP minimal 10 digit';
                } else if (!/^[0-9]+$/.test(field.value)) {
                    isValid = false;
                    message = 'Nomor HP hanya boleh berisi angka';
                }
            }

            if (field.name === 'nama_lengkap') {
                if (field.value.length < 3) {
                    isValid = false;
                    message = 'Nama minimal 3 karakter';
                }
            }

            if (field.name === 'alasan_mendaftar') {
                if (field.value.length < 50) {
                    isValid = false;
                    message = 'Alasan mendaftar minimal 50 karakter';
                }
            }

            // Show/hide validation feedback
            if (!isValid && field.value.length > 0) {
                field.classList.add('is-invalid');
                let feedback = field.parentNode.querySelector('.custom-feedback');
                if (!feedback) {
                    feedback = document.createElement('div');
                    feedback.className = 'invalid-feedback custom-feedback';
                    field.parentNode.appendChild(feedback);
                }
                feedback.textContent = message;
                feedback.style.display = 'block';
            } else {
                field.classList.remove('is-invalid');
                const feedback = field.parentNode.querySelector('.custom-feedback');
                if (feedback) {
                    feedback.style.display = 'none';
                }
            }
        }

        // Progress indicator
        const progressBar = document.createElement('div');
        progressBar.className = 'progress mb-4';
        progressBar.style.height = '6px';
        progressBar.innerHTML = '<div class="progress-bar" style="width: 0%; background: linear-gradient(45deg, var(--gold-primary), var(--gold-dark));"></div>';

        const formSection = document.querySelector('.form-section');
        formSection.insertBefore(progressBar, formSection.firstChild);

        function updateProgress() {
            const totalFields = form.querySelectorAll('input[required], textarea[required]').length;
            const filledFields = Array.from(form.querySelectorAll('input[required], textarea[required]')).filter(field => {
                if (field.type === 'file') {
                    return field.files && field.files.length > 0;
                } else if (field.type === 'checkbox') {
                    return field.checked;
                } else {
                    return field.value.trim().length > 0;
                }
            }).length;

            const progress = (filledFields / totalFields) * 100;
            progressBar.querySelector('.progress-bar').style.width = progress + '%';
        }

        // Update progress on input
        inputs.forEach(input => {
            input.addEventListener('input', updateProgress);
            input.addEventListener('change', updateProgress);
        });

        fileInputs.forEach(input => {
            input.addEventListener('change', updateProgress);
        });

        document.getElementById('terms').addEventListener('change', updateProgress);

        // Initial progress update
        updateProgress();

        // Scroll to error fields if any
        const errorFields = document.querySelectorAll('.is-invalid');
        if (errorFields.length > 0) {
            errorFields[0].scrollIntoView({ 
                behavior: 'smooth', 
                block: 'center' 
            });
        }

        // Auto-save notification (visual feedback only)
        let autoSaveTimer;
        const autoSaveIndicator = document.createElement('small');
        autoSaveIndicator.className = 'text-muted ms-2';
        autoSaveIndicator.style.opacity = '0';
        autoSaveIndicator.innerHTML = '<i class="fas fa-check text-success"></i> Data tersimpan';

        const formTitle = document.querySelector('.section-title');
        formTitle.appendChild(autoSaveIndicator);

        function showAutoSave() {
            clearTimeout(autoSaveTimer);
            autoSaveIndicator.style.opacity = '1';
            autoSaveTimer = setTimeout(() => {
                autoSaveIndicator.style.opacity = '0';
            }, 2000);
        }

        // Show auto-save feedback on input
        inputs.forEach(input => {
            input.addEventListener('input', () => {
                setTimeout(showAutoSave, 1000);
            });
        });
    });
    </script>
@endsection