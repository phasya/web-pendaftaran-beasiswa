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

                            <!-- Document Upload Section -->
                            <div class="form-group-section mb-4">
                                <h6 class="form-group-title">
                                    <i class="fas fa-folder-upload text-success me-2"></i>Dokumen Pendukung
                                </h6>
                                <div class="form-group-content">
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <div class="file-upload-card">
                                                <label for="file_transkrip" class="file-label">
                                                    <div class="file-icon">
                                                        <i class="fas fa-file-pdf text-danger"></i>
                                                    </div>
                                                    <div class="file-info">
                                                        <h6 class="file-title">Transkrip Nilai *</h6>
                                                        <small class="file-desc">Format: PDF, Max: 2MB</small>
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
/* Main color scheme */
:root {
    --mint-primary: #00c9a7;
    --mint-secondary: #00bcd4;
    --mint-dark: #00a693;
    --mint-light: #4dd0e1;
    --mint-blue: #0891b2;
}

/* Status Badge Colors */
.bg-success-custom { 
    background: linear-gradient(45deg, #28a745, #20c997) !important; 
    color: white !important;
    font-weight: 600;
    font-size: 0.9rem;
}

/* Card styling */
.card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.card-header {
    background: linear-gradient(135deg, var(--mint-primary), var(--mint-blue));
    color: white;
    border-bottom: none;
    border-radius: 15px 15px 0 0 !important;
    padding: 1.5rem 2rem;
}

.card-title {
    font-weight: 600;
    margin-bottom: 0;
}

.scholarship-amount .badge {
    font-size: 1rem;
    padding: 0.75rem 1.25rem;
    border-radius: 25px;
}

/* Section styling */
.section-title {
    font-weight: 600;
    color: #495057;
    font-size: 1.1rem;
    margin-bottom: 1rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid var(--mint-primary);
    display: inline-block;
}

.info-section {
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    border-radius: 12px;
    padding: 2rem;
    border-left: 4px solid var(--mint-primary);
}

.info-box {
    background: white;
    border-radius: 10px;
    padding: 1.5rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

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
    font-size: 1.1rem;
    color: #495057;
    margin-bottom: 0;
    font-weight: 500;
}

.requirements-content {
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    padding: 1rem;
    font-size: 0.95rem;
    line-height: 1.6;
    color: #495057;
}

/* Form styling */
.form-section {
    background: white;
}

.form-group-section {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 1.5rem;
    border-left: 4px solid var(--mint-primary);
    margin-bottom: 1.5rem;
}

.form-group-title {
    font-weight: 600;
    color: #495057;
    margin-bottom: 1rem;
    font-size: 1rem;
}

.form-group-content {
    background: white;
    border-radius: 8px;
    padding: 1.5rem;
    box-shadow: 0 1px 5px rgba(0,0,0,0.05);
}

/* Modern input styling */
.modern-input, .modern-textarea {
    border: 2px solid #e9ecef;
    border-radius: 10px;
    padding: 0.75rem 1rem;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: white;
}

.modern-input:focus, .modern-textarea:focus {
    border-color: var(--mint-primary);
    box-shadow: 0 0 0 0.25rem rgba(0, 201, 167, 0.1);
    background: #fafbfc;
}

.modern-input::placeholder, .modern-textarea::placeholder {
    color: #adb5bd;
    font-style: italic;
}

/* File upload cards */
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
    border-color: var(--mint-primary);
    background: #f8fffe;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0, 201, 167, 0.1);
}

.file-label {
    cursor: pointer;
    margin-bottom: 1rem;
    display: block;
}

.file-icon {
    font-size: 2.5rem;
    margin-bottom: 1rem;
}

.file-title {
    font-size: 1rem;
    font-weight: 600;
    color: #495057;
    margin-bottom: 0.5rem;
}

.file-desc {
    color: #6c757d;
    font-size: 0.875rem;
}

.file-input {
    border: none;
    background: transparent;
    font-size: 0.875rem;
}

.file-input:focus {
    box-shadow: none;
    border-color: transparent;
}

/* Form labels */
.form-label {
    font-weight: 600;
    color: #495057;
    margin-bottom: 0.5rem;
}

.form-text {
    font-size: 0.875rem;
    margin-top: 0.5rem;
}

/* Terms section */
.terms-section {
    background: #fff3cd;
    border: 1px solid #ffeaa7;
    border-radius: 8px;
    padding: 1rem;
}

.form-check-input:checked {
    background-color: var(--mint-primary);
    border-color: var(--mint-primary);
}

.form-check-label {
    font-size: 0.95rem;
    line-height: 1.5;
    color: #495057;
}

/* Button styling */
.btn {
    border-radius: 25px;
    font-weight: 600;
    padding: 0.75rem 2rem;
    transition: all 0.3s ease;
    font-size: 1rem;
}

.btn-primary {
    background: linear-gradient(45deg, var(--mint-primary), var(--mint-blue));
    border: none;
    color: white;
}

.btn-primary:hover {
    background: linear-gradient(45deg, var(--mint-dark), #0671a6);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 201, 167, 0.4);
}

.btn-outline-secondary {
    border: 2px solid #6c757d;
    color: #6c757d;
}

.btn-outline-secondary:hover {
    background: #6c757d;
    transform: translateY(-1px);
    box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3);
}

.btn-submit {
    min-width: 180px;
}

/* Tip cards */
.tip-card {
    border-radius: 12px;
    transition: all 0.3s ease;
    border-width: 2px;
    margin-bottom: 1rem;
}

.tip-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.1);
}

/* Responsive */
@media (max-width: 768px) {
    .card-header {
        padding: 1rem 1.5rem;
    }
    
    .card-body {
        padding: 1.5rem !important;
    }
    
    .info-section, .form-group-section {
        padding: 1rem;
    }
    
    .form-group-content {
        padding: 1rem;
    }
    
    .file-upload-card {
        margin-bottom: 1rem;
    }
    
    .scholarship-amount {
        margin-top: 1rem;
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

/* Loading state */
.btn-submit.loading {
    opacity: 0.7;
    cursor: not-allowed;
}

.btn-submit.loading::after {
    content: '';
    width: 16px;
    height: 16px;
    margin-left: 0.5rem;
    border: 2px solid transparent;
    border-top-color: #ffffff;
    border-radius: 50%;
    display: inline-block;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Invalid feedback styling */
.invalid-feedback {
    font-size: 0.875rem;
    font-weight: 500;
}

/* File upload feedback */
.file-upload-card.has-file {
    border-color: var(--mint-primary);
    background: #f8fffe;
}

.file-upload-card.has-file .file-icon {
    color: var(--mint-primary) !important;
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
            const maxSize = 2 * 1024 * 1024; // 2MB in bytes
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