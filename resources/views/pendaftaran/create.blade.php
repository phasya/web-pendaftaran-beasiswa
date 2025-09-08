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

                            <form method="POST" action="{{ route('pendaftar.store', $beasiswa->id) }}" enctype="multipart/form-data"
                                id="registrationForm">
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

                                <div class="requirements-section mb-4">
                                    <label class="text-muted small fw-semibold">DOKUMEN PENDUKUNG YANG DIPERLUKAN</label>
                                    <div class="bg-light p-3 rounded-3 mt-2">
    @if (is_array($beasiswa->dokumen_pendukung) || is_countable($beasiswa->dokumen_pendukung)) {
    $count = count($beasiswa->dokumen_pendukung);
} else {
    $count = 0;
}                                            <div class="row">
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
                                            <p class="text-muted mb-0 fst-italic">
                                                <i class="fas fa-info-circle me-2"></i>
                                                Tidak ada dokumen pendukung khusus yang diperlukan
                                            </p>
                                        @endif
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
                                        </div>
                                    </div>
                                </div>


                                <br><br>

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
                                        <small>Ukuran maksimal file adalah 2MB per dokumen</small>
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
            /* warm golden yellow */
            --gold-secondary: #FFA000;
            /* amber */
            --gold-dark: #FF8F00;
            /* darker amber */
            --gold-light: #FFF8E1;
            /* soft cream */
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

        /* Form group */
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
        }

        .file-upload-card:hover {
            border-color: var(--gold-primary);
            background: #fffdf5;
            box-shadow: 0 4px 15px rgba(251, 192, 45, 0.1);
        }

        /* Buttons */
        .btn-primary {
            background: linear-gradient(45deg, var(--gold-primary), var(--gold-dark));
            border: none;
            color: white;
        }

        .btn-primary:hover {
            background: linear-gradient(45deg, var(--gold-dark), #E65100);
            box-shadow: 0 6px 20px rgba(255, 160, 0, 0.3);
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
                } else {
                    card.classList.remove('has-file');
                    fileTitle.textContent = originalTitle;
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
            // Remove non-digits
            let value = this.value.replace(/\D/g, '');

            // Limit length
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

        // Auto-save form data (in memory only - no localStorage)
        const formElements = form.querySelectorAll('input[type="text"], input[type="email"], textarea');
        const formData = {};

        // Save form data in memory
        formElements.forEach(element => {
            element.addEventListener('input', function() {
                formData[this.name] = this.value;
            });
        });

        // Smooth scroll to error fields
        const errorFields = document.querySelectorAll('.is-invalid');
        if (errorFields.length > 0) {
            errorFields[0].scrollIntoView({ 
                behavior: 'smooth', 
                block: 'center' 
            });
        }

        // File size validation
        fileInputs.forEach(input => {
            input.addEventListener('change', function() {
                const file = this.files[0];
                const maxSize = 5 * 1024 * 1024; // 5MB in bytes
                const card = this.closest('.file-upload-card');

                if (file && file.size > maxSize) {
                    alert('Ukuran file terlalu besar. Maksimal 2MB.');
                    this.value = '';
                    card.classList.remove('has-file');
                    return;
                }
            });
        });

        // Progress indicator
        const sections = document.querySelectorAll('.form-group-section');
        const progressBar = document.createElement('div');
        progressBar.className = 'progress mb-4';
        progressBar.style.height = '6px';
        progressBar.innerHTML = '<div class="progress-bar bg-success" style="width: 0%"></div>';

        const formSection = document.querySelector('.form-section');
        formSection.insertBefore(progressBar, formSection.firstChild);

        function updateProgress() {
            const totalFields = form.querySelectorAll('input[required], textarea[required]').length;
            const filledFields = form.querySelectorAll('input[required]:valid, textarea[required]:valid').length;
            const progress = (filledFields / totalFields) * 100;

            progressBar.querySelector('.progress-bar').style.width = progress + '%';
        }

        // Update progress on input
        formElements.forEach(element => {
            element.addEventListener('input', updateProgress);
            element.addEventListener('change', updateProgress);
        });

        fileInputs.forEach(input => {
            input.addEventListener('change', updateProgress);
        });

        // Initial progress update
        updateProgress();
    });
    </script>
@endsection