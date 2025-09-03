@extends('layouts.admin')

@section('title', 'Tambah File Type')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <div>
        <h1 class="h2"><i class="fas fa-plus"></i> Tambah File Type</h1>
        <p class="text-muted mb-0">
            <i class="fas fa-info-circle me-2"></i>Tambah jenis file baru yang dapat diupload untuk beasiswa
        </p>
    </div>
</div>

<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card shadow-sm">
            <div class="card-header bg-white py-3">
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-file-alt text-primary me-2"></i>Form Tambah File Type
                        </h6>
                    </div>
                    <div class="col-auto">
                        <span class="badge bg-info-soft text-info">
                            <i class="fas fa-asterisk me-1" style="font-size: 8px;"></i>Required Fields
                        </span>
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.file-types.index') }}" method="POST" id="fileTypeForm">
                    @csrf
                    
                    <!-- Form Section 1: Basic Information -->
                    <div class="form-section mb-4">
                        <h6 class="section-title mb-3">
                            <i class="fas fa-info-circle text-primary me-2"></i>Informasi Dasar
                        </h6>
                        
                        <div class="mb-3">
                            <label for="nama_file_type" class="form-label fw-semibold">
                                <i class="fas fa-file-alt text-warning me-2"></i>Nama File Type
                                <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-file-alt text-muted"></i>
                                </span>
                                <input type="text" 
                                       class="form-control border-start-0 @error('nama_file_type') is-invalid @enderror" 
                                       id="nama_file_type" 
                                       name="nama_file_type" 
                                       value="{{ old('nama_file_type') }}" 
                                       placeholder="Contoh: KTP, Transkrip Nilai, Surat Keterangan Tidak Mampu"
                                       required>
                                @error('nama_file_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label fw-semibold">
                                <i class="fas fa-align-left text-info me-2"></i>Deskripsi
                            </label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                      id="deskripsi" 
                                      name="deskripsi" 
                                      rows="3"
                                      placeholder="Jelaskan jenis dokumen ini dan fungsinya...">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                <i class="fas fa-lightbulb me-1"></i>Opsional - berikan penjelasan untuk membantu admin dan pengguna
                            </small>
                        </div>
                    </div>

                    <!-- Form Section 2: File Configuration -->
                    <div class="form-section mb-4">
                        <h6 class="section-title mb-3">
                            <i class="fas fa-cogs text-success me-2"></i>Konfigurasi File
                        </h6>

                        <div class="mb-3">
                            <label for="ekstensi_diizinkan" class="form-label fw-semibold">
                                <i class="fas fa-file-code text-primary me-2"></i>Ekstensi yang Diizinkan
                                <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-file-code text-muted"></i>
                                </span>
                                <input type="text" 
                                       class="form-control border-start-0 @error('ekstensi_diizinkan') is-invalid @enderror" 
                                       id="ekstensi_diizinkan" 
                                       name="ekstensi_diizinkan" 
                                       value="{{ old('ekstensi_diizinkan', 'pdf,jpg,jpeg,png') }}" 
                                       placeholder="pdf,jpg,jpeg,png"
                                       required>
                                @error('ekstensi_diizinkan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle me-1"></i>Pisahkan dengan koma (,) tanpa spasi. Contoh: pdf,jpg,png
                            </small>
                            <div class="mt-2" id="extensionPreview"></div>
                        </div>

                        <div class="mb-3">
                            <label for="ukuran_maksimal" class="form-label fw-semibold">
                                <i class="fas fa-weight text-warning me-2"></i>Ukuran Maksimal
                                <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="number" 
                                       class="form-control @error('ukuran_maksimal') is-invalid @enderror" 
                                       id="ukuran_maksimal" 
                                       name="ukuran_maksimal" 
                                       value="{{ old('ukuran_maksimal', 2048) }}" 
                                       min="100"
                                       max="10240"
                                       step="100"
                                       required>
                                <span class="input-group-text bg-light border-start-0">KB</span>
                                @error('ukuran_maksimal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle me-1"></i>Dalam kilobytes (KB). Minimal 100 KB, maksimal 10 MB (10240 KB)
                            </small>
                            <div class="mt-2">
                                <span id="sizeInMB" class="badge bg-info-soft text-info"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Form Section 3: Settings -->
                    <div class="form-section mb-4">
                        <h6 class="section-title mb-3">
                            <i class="fas fa-sliders-h text-warning me-2"></i>Pengaturan
                        </h6>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-sort-numeric-up text-info me-2"></i>Urutan Tampilan
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-sort text-muted"></i>
                                        </span>
                                        <input type="number" 
                                               class="form-control border-start-0 @error('urutan') is-invalid @enderror" 
                                               id="urutan" 
                                               name="urutan" 
                                               value="{{ old('urutan', 0) }}" 
                                               min="0">
                                        @error('urutan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <small class="form-text text-muted">Angka yang lebih kecil akan ditampilkan lebih dulu</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" 
                                           type="checkbox" 
                                           id="wajib" 
                                           name="wajib"
                                           {{ old('wajib', true) ? 'checked' : '' }}>
                                    <label class="form-check-label fw-semibold" for="wajib">
                                        <i class="fas fa-exclamation-circle text-warning me-2"></i>File Wajib (Default)
                                    </label>
                                    <small class="form-text text-muted d-block">
                                        Setting default, bisa diubah per beasiswa
                                    </small>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" 
                                           type="checkbox" 
                                           id="aktif" 
                                           name="aktif"
                                           {{ old('aktif', true) ? 'checked' : '' }}>
                                    <label class="form-check-label fw-semibold" for="aktif">
                                        <i class="fas fa-toggle-on text-success me-2"></i>Status Aktif
                                    </label>
                                    <small class="form-text text-muted d-block">
                                        Hanya file type aktif yang bisa dipilih
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="form-actions bg-light p-3 rounded-3 mt-4">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                            <div class="d-flex align-items-center text-muted">
                                <i class="fas fa-info-circle me-2"></i>
                                <small>Pastikan konfigurasi sudah benar sebelum menyimpan</small>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.file-types.index') }}" 
                                   class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali
                                </a>
                                <button type="reset" class="btn btn-outline-warning">
                                    <i class="fas fa-undo me-2"></i>Reset
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Simpan File Type
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Tips Card -->
        <div class="card shadow-sm mt-4">
            <div class="card-header bg-white py-3">
                <h6 class="card-title mb-0">
                    <i class="fas fa-lightbulb text-warning me-2"></i>Tips Membuat File Type
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="tip-item mb-3">
                            <div class="d-flex">
                                <div class="tip-icon me-3">
                                    <i class="fas fa-check-circle text-success"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Nama yang Spesifik</h6>
                                    <small class="text-muted">Gunakan nama yang jelas dan mudah dipahami</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="tip-item mb-3">
                            <div class="d-flex">
                                <div class="tip-icon me-3">
                                    <i class="fas fa-file-code text-info"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Ekstensi yang Aman</h6>
                                    <small class="text-muted">Batasi hanya ekstensi yang diperlukan untuk keamanan</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="tip-item mb-3">
                            <div class="d-flex">
                                <div class="tip-icon me-3">
                                    <i class="fas fa-weight text-warning"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Ukuran yang Wajar</h6>
                                    <small class="text-muted">Sesuaikan ukuran dengan jenis dokumen (PDF lebih besar dari gambar)</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="tip-item">
                            <div class="d-flex">
                                <div class="tip-icon me-3">
                                    <i class="fas fa-sort text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Urutan Logis</h6>
                                    <small class="text-muted">Atur urutan berdasarkan prioritas atau proses pengumpulan</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Custom CSS -->
<style>
/* Status Badge Colors - Same as other forms */
.bg-success-soft { background-color: #d1edff !important; }
.bg-warning-soft { background-color: #fff3cd !important; }
.bg-danger-soft { background-color: #f8d7da !important; }
.bg-info-soft { background-color: #d1ecf1 !important; }
.bg-secondary-soft { background-color: #e2e3e5 !important; }

/* Form sections */
.form-section {
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

/* Input group styling */
.input-group-text {
    background-color: #f8f9fa;
    border-color: #ced4da;
    color: #6c757d;
}

.form-control {
    border-radius: 0.375rem;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: var(--mint-primary, #00c9a7);
    box-shadow: 0 0 0 0.2rem rgba(0, 201, 167, 0.25);
}

/* Form labels */
.form-label {
    color: #495057;
    margin-bottom: 0.5rem;
}

/* Form switches */
.form-check-input:checked {
    background-color: var(--mint-primary, #00c9a7);
    border-color: var(--mint-primary, #00c9a7);
}

.form-check-input:focus {
    border-color: var(--mint-primary, #00c9a7);
    box-shadow: 0 0 0 0.25rem rgba(0, 201, 167, 0.25);
}

/* Button enhancements */
.btn {
    border-radius: 0.375rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-primary {
    background: linear-gradient(45deg, var(--mint-primary, #00c9a7), var(--mint-blue, #0891b2));
    border: none;
}

.btn-primary:hover {
    background: linear-gradient(45deg, var(--mint-dark, #00a693), var(--mint-secondary, #00bcd4));
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 201, 167, 0.4);
}

/* Extension preview */
#extensionPreview .badge {
    margin-right: 0.5rem;
    margin-bottom: 0.25rem;
}

/* Tips section */
.tip-item {
    transition: all 0.3s ease;
    padding: 0.75rem;
    border-radius: 8px;
}

.tip-item:hover {
    background-color: #f8f9fa;
    transform: translateX(5px);
}

.tip-icon {
    width: 20px;
    text-align: center;
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
    const extensionInput = document.getElementById('ekstensi_diizinkan');
    const sizeInput = document.getElementById('ukuran_maksimal');
    const extensionPreview = document.getElementById('extensionPreview');
    const sizeInMB = document.getElementById('sizeInMB');
    
    // Function to update extension preview
    function updateExtensionPreview() {
        const extensions = extensionInput.value.split(',').map(ext => ext.trim().toLowerCase()).filter(ext => ext);
        extensionPreview.innerHTML = '';
        
        extensions.forEach(ext => {
            const badge = document.createElement('span');
            badge.className = 'badge bg-primary me-1';
            badge.textContent = ext.toUpperCase();
            extensionPreview.appendChild(badge);
        });
    }
    
    // Function to update size in MB
    function updateSizeInMB() {
        const sizeKB = parseInt(sizeInput.value) || 0;
        const sizeMB = (sizeKB / 1024).toFixed(2);
        sizeInMB.textContent = `${sizeMB} MB`;
    }
    
    // Event listeners
    extensionInput.addEventListener('input', updateExtensionPreview);
    sizeInput.addEventListener('input', updateSizeInMB);
    
    // Initial updates
    updateExtensionPreview();
    updateSizeInMB();
    
    // Form validation
    document.getElementById('fileTypeForm').addEventListener('submit', function(e) {
        const extensions = extensionInput.value.split(',').map(ext => ext.trim()).filter(ext => ext);
        
        if (extensions.length === 0) {
            e.preventDefault();
            alert('Harap masukkan minimal satu ekstensi file yang diizinkan!');
            extensionInput.focus();
            return false;
        }
        
        // Clean up extensions before submit
        extensionInput.value = extensions.join(',');
        
        // Show loading state
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
        submitBtn.disabled = true;
        
        // Re-enable after 3 seconds (in case of validation errors)
        setTimeout(() => {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }, 3000);
    });
    
    // Auto-resize textarea
    document.querySelectorAll('textarea').forEach(textarea => {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
    });
    
    // Tooltip initialization
    if (typeof bootstrap !== 'undefined') {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
});
</script>
@endsection