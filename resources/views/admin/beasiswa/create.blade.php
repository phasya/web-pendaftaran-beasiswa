@extends('layouts.admin')

@section('title', 'Tambah Beasiswa')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <div>
        <h1 class="h2"><i class="fas fa-plus"></i> Tambah Beasiswa</h1>
        <p class="text-muted mb-0">
            <i class="fas fa-info-circle me-2"></i>Lengkapi form di bawah untuk menambahkan program beasiswa baru
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
                            <i class="fas fa-graduation-cap text-primary me-2"></i>Form Tambah Beasiswa
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
                <form action="{{ route('admin.beasiswa.store') }}" method="POST" id="beasiswaForm">
                    @csrf
                    
                    <!-- Form Section 1: Basic Information -->
                    <div class="form-section mb-4">
                        <h6 class="section-title mb-3">
                            <i class="fas fa-info-circle text-primary me-2"></i>Informasi Dasar
                        </h6>
                        
                        <div class="mb-3">
                            <label for="nama_beasiswa" class="form-label fw-semibold">
                                <i class="fas fa-trophy text-warning me-2"></i>Nama Beasiswa
                                <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-graduation-cap text-muted"></i>
                                </span>
                                <input type="text" 
                                       class="form-control border-start-0 @error('nama_beasiswa') is-invalid @enderror" 
                                       id="nama_beasiswa" 
                                       name="nama_beasiswa" 
                                       value="{{ old('nama_beasiswa') }}" 
                                       placeholder="Contoh: Beasiswa Prestasi Akademik 2025"
                                       required>
                                @error('nama_beasiswa')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label fw-semibold">
                                <i class="fas fa-align-left text-info me-2"></i>Deskripsi Beasiswa
                                <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                      id="deskripsi" 
                                      name="deskripsi" 
                                      rows="4"
                                      placeholder="Jelaskan tujuan, target penerima, dan manfaat beasiswa ini..."
                                      required>{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                <i class="fas fa-lightbulb me-1"></i>Berikan deskripsi yang jelas dan menarik untuk calon pendaftar
                            </small>
                        </div>
                    </div>

                    <!-- Form Section 2: Financial & Schedule -->
                    <div class="form-section mb-4">
                        <h6 class="section-title mb-3">
                            <i class="fas fa-calendar-dollar text-success me-2"></i>Dana & Jadwal
                        </h6>

                        <div class="mb-3">
                            <label for="jumlah_dana" class="form-label fw-semibold">
                                <i class="fas fa-money-bill-wave text-success me-2"></i>Jumlah Dana
                                <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">Rp</span>
                                <input type="number" 
                                       class="form-control border-start-0 @error('jumlah_dana') is-invalid @enderror" 
                                       id="jumlah_dana" 
                                       name="jumlah_dana" 
                                       value="{{ old('jumlah_dana') }}" 
                                       min="0"
                                       step="100000"
                                       placeholder="5000000"
                                       required>
                                @error('jumlah_dana')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle me-1"></i>Masukkan jumlah dana dalam Rupiah (contoh: 5000000 untuk 5 juta)
                            </small>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="tanggal_buka" class="form-label fw-semibold">
                                    <i class="fas fa-calendar-plus text-success me-2"></i>Tanggal Buka
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-calendar text-muted"></i>
                                    </span>
                                    <input type="date" 
                                           class="form-control border-start-0 @error('tanggal_buka') is-invalid @enderror" 
                                           id="tanggal_buka" 
                                           name="tanggal_buka" 
                                           value="{{ old('tanggal_buka') }}" 
                                           required>
                                    @error('tanggal_buka')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="tanggal_tutup" class="form-label fw-semibold">
                                    <i class="fas fa-calendar-times text-danger me-2"></i>Tanggal Tutup
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-calendar text-muted"></i>
                                    </span>
                                    <input type="date" 
                                           class="form-control border-start-0 @error('tanggal_tutup') is-invalid @enderror" 
                                           id="tanggal_tutup" 
                                           name="tanggal_tutup" 
                                           value="{{ old('tanggal_tutup') }}" 
                                           required>
                                    @error('tanggal_tutup')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div id="dateRangeInfo" class="alert alert-info-soft d-none">
                            <i class="fas fa-info-circle me-2"></i>
                            <span id="dateRangeText"></span>
                        </div>
                    </div>

                    <!-- Form Section 3: Status & Requirements -->
                    <div class="form-section mb-4">
                        <h6 class="section-title mb-3">
                            <i class="fas fa-cogs text-warning me-2"></i>Status & Persyaratan
                        </h6>

                        <div class="mb-3">
                            <label for="status" class="form-label fw-semibold">
                                <i class="fas fa-toggle-on text-primary me-2"></i>Status Beasiswa
                                <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('status') is-invalid @enderror" 
                                    id="status" 
                                    name="status" 
                                    required>
                                <option value="">-- Pilih Status --</option>
                                <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>
                                    <i class="fas fa-check-circle"></i> Aktif (Bisa dilamar)
                                </option>
                                <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>
                                    <i class="fas fa-times-circle"></i> Nonaktif (Tidak bisa dilamar)
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="persyaratan" class="form-label fw-semibold">
                                <i class="fas fa-list-check text-info me-2"></i>Persyaratan Pendaftaran
                                <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('persyaratan') is-invalid @enderror" 
                                      id="persyaratan" 
                                      name="persyaratan" 
                                      rows="8"
                                      placeholder="Contoh:&#10;1. Mahasiswa aktif semester 3 ke atas&#10;2. IPK minimal 3.0&#10;3. Tidak sedang menerima beasiswa lain&#10;4. Melampirkan transkrip nilai terbaru&#10;5. Surat rekomendasi dari dosen"
                                      required>{{ old('persyaratan') }}</textarea>
                            @error('persyaratan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                <i class="fas fa-lightbulb me-1"></i>Tuliskan persyaratan dengan jelas, gunakan numbering untuk kemudahan membaca
                            </small>
                        </div>
                    </div>

                    <!-- Add this section after the "Status & Persyaratan" section in create.blade.php -->

<!-- Form Section 4: File Requirements -->
<div class="form-section mb-4">
    <h6 class="section-title mb-3">
        <i class="fas fa-file-upload text-info me-2"></i>Persyaratan File Upload
    </h6>
    
    <div class="mb-3">
        <label class="form-label fw-semibold">
            <i class="fas fa-paperclip text-primary me-2"></i>File yang Diperlukan
        </label>
        <small class="text-muted d-block mb-3">
            <i class="fas fa-info-circle me-1"></i>Pilih jenis file yang harus atau bisa diupload oleh pendaftar
        </small>
        
        <div id="fileRequirementsContainer">
            @if(isset($fileTypes) && $fileTypes->count() > 0)
                <div class="row">
                    @foreach($fileTypes as $fileType)
                    <div class="col-md-6 mb-3">
                        <div class="file-requirement-item border rounded p-3 h-100">
                            <div class="form-check mb-2">
                                <input class="form-check-input file-requirement-check" 
                                       type="checkbox" 
                                       name="file_requirements[]" 
                                       value="{{ $fileType->id }}" 
                                       id="file_type_{{ $fileType->id }}"
                                       {{ old('file_requirements') && in_array($fileType->id, old('file_requirements')) ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="file_type_{{ $fileType->id }}">
                                    <i class="fas fa-file-alt text-info me-2"></i>{{ $fileType->nama_file_type }}
                                </label>
                            </div>
                            
                            @if($fileType->deskripsi)
                            <div class="file-description mb-2">
                                <small class="text-muted">{{ $fileType->deskripsi }}</small>
                            </div>
                            @endif
                            
                            <div class="file-specs">
                                <small class="text-muted d-block">
                                    <i class="fas fa-file-code me-1"></i>Format: 
                                    @foreach($fileType->ekstensi_array as $ext)
                                        <span class="badge bg-light text-dark me-1">{{ strtoupper($ext) }}</span>
                                    @endforeach
                                </small>
                                <small class="text-muted d-block mt-1">
                                    <i class="fas fa-weight me-1"></i>Max: {{ $fileType->ukuran_mb }} MB
                                </small>
                            </div>
                            
                            <!-- Requirement specific settings -->
                            <div class="requirement-settings mt-3" style="display: none;">
                                <div class="border-top pt-3">
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               name="file_required[{{ $fileType->id }}]" 
                                               id="required_{{ $fileType->id }}"
                                               {{ old('file_required.'.$fileType->id, $fileType->wajib) ? 'checked' : '' }}>
                                        <label class="form-check-label small fw-semibold" for="required_{{ $fileType->id }}">
                                            <i class="fas fa-exclamation-circle text-warning me-1"></i>Wajib
                                        </label>
                                    </div>
                                    
                                    <div class="mb-0">
                                        <input type="text" 
                                               class="form-control form-control-sm" 
                                               name="file_notes[{{ $fileType->id }}]" 
                                               placeholder="Catatan khusus (opsional)"
                                               value="{{ old('file_notes.'.$fileType->id) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <div class="mt-3">
                    <div class="alert alert-info-soft">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Info:</strong> Centang file yang diperlukan untuk beasiswa ini. 
                        Anda bisa mengatur apakah file tersebut wajib atau opsional untuk setiap beasiswa.
                    </div>
                </div>
            @else
                <div class="alert alert-warning-soft">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Belum ada file type yang tersedia.</strong><br>
                    <a href="{{ route('admin.file-types.create') }}" class="btn btn-sm btn-warning mt-2">
                        <i class="fas fa-plus me-1"></i>Tambah File Type Baru
                    </a>
                </div>
            @endif
        </div>
    </div>
    
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">
                    <i class="fas fa-lightbulb me-1"></i>
                    File requirements bisa diubah setelah beasiswa dibuat
                </small>
                <button type="button" class="btn btn-sm btn-outline-primary" onclick="selectAllFiles()">
                    <i class="fas fa-check-double me-1"></i>Pilih Semua
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Add this JavaScript to the existing script section

// Function to handle file requirement selection
document.addEventListener('DOMContentLoaded', function() {
    const fileRequirementChecks = document.querySelectorAll('.file-requirement-check');
    
    fileRequirementChecks.forEach(checkbox => {
        const requirementSettings = checkbox.closest('.file-requirement-item').querySelector('.requirement-settings');
        
        // Show/hide settings based on checkbox state
        function toggleSettings() {
            if (checkbox.checked) {
                requirementSettings.style.display = 'block';
                // Add visual feedback
                checkbox.closest('.file-requirement-item').classList.add('border-primary', 'bg-light');
            } else {
                requirementSettings.style.display = 'none';
                // Remove visual feedback
                checkbox.closest('.file-requirement-item').classList.remove('border-primary', 'bg-light');
            }
        }
        
        // Initial state
        toggleSettings();
        
        // Event listener
        checkbox.addEventListener('change', toggleSettings);
    });
});

// Function to select/deselect all files
function selectAllFiles() {
    const checkboxes = document.querySelectorAll('.file-requirement-check');
    const allChecked = Array.from(checkboxes).every(cb => cb.checked);
    
    checkboxes.forEach(checkbox => {
        checkbox.checked = !allChecked;
        checkbox.dispatchEvent(new Event('change'));
    });
    
    // Update button text
    const button = event.target;
    if (allChecked) {
        button.innerHTML = '<i class="fas fa-check-double me-1"></i>Pilih Semua';
    } else {
        button.innerHTML = '<i class="fas fa-minus-square me-1"></i>Hapus Semua';
    }
}
</script>

<style>
/* Additional CSS for file requirements */
.file-requirement-item {
    transition: all 0.3s ease;
    background-color: #ffffff;
}

.file-requirement-item:hover {
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    transform: translateY(-1px);
}

.file-requirement-item.border-primary {
    border-color: var(--mint-primary, #00c9a7) !important;
    border-width: 2px !important;
}

.file-requirement-item.bg-light {
    background-color: #f8f9fa !important;
}

.file-specs .badge {
    font-size: 0.65rem;
}

.requirement-settings {
    background-color: #f8f9fa;
    border-radius: 0.375rem;
    margin: -0.5rem;
    padding: 0.5rem;
}

.requirement-settings .border-top {
    border-color: #dee2e6 !important;
}

.alert-warning-soft {
    background-color: #fff3cd;
    border: 1px solid #ffeaa7;
    color: #856404;
    border-radius: 8px;
}

@media (max-width: 768px) {
    .file-requirement-item {
        margin-bottom: 1rem !important;
    }
}
</style>

                    <!-- Action Buttons -->
                    <div class="form-actions bg-light p-3 rounded-3 mt-4">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                            <div class="d-flex align-items-center text-muted">
                                <i class="fas fa-info-circle me-2"></i>
                                <small>Pastikan semua data sudah benar sebelum menyimpan</small>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.beasiswa.index') }}" 
                                   class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali
                                </a>
                                <button type="reset" class="btn btn-outline-warning">
                                    <i class="fas fa-undo me-2"></i>Reset
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Simpan Beasiswa
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
                    <i class="fas fa-lightbulb text-warning me-2"></i>Tips Membuat Beasiswa
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
                                    <h6 class="mb-1">Nama yang Jelas</h6>
                                    <small class="text-muted">Gunakan nama yang mudah dipahami dan mencerminkan jenis beasiswa</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="tip-item mb-3">
                            <div class="d-flex">
                                <div class="tip-icon me-3">
                                    <i class="fas fa-calendar-alt text-info"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Periode yang Wajar</h6>
                                    <small class="text-muted">Berikan waktu yang cukup untuk pendaftaran, minimal 2 minggu</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="tip-item mb-3">
                            <div class="d-flex">
                                <div class="tip-icon me-3">
                                    <i class="fas fa-list-ul text-warning"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Persyaratan Spesifik</h6>
                                    <small class="text-muted">Tuliskan persyaratan yang detail dan dapat diverifikasi</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="tip-item">
                            <div class="d-flex">
                                <div class="tip-icon me-3">
                                    <i class="fas fa-money-bill-wave text-success"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Dana yang Realistis</h6>
                                    <small class="text-muted">Sesuaikan jumlah dana dengan kemampuan dan target penerima</small>
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
/* Status Badge Colors - Same as dashboard */
.bg-success-soft { background-color: #d1edff !important; }
.bg-warning-soft { background-color: #fff3cd !important; }
.bg-danger-soft { background-color: #f8d7da !important; }
.bg-info-soft { background-color: #d1ecf1 !important; }
.bg-secondary-soft { background-color: #e2e3e5 !important; }

/* Alert styling */
.alert-info-soft {
    background-color: #d1ecf1;
    border: 1px solid #bee5eb;
    color: #0c5460;
    border-radius: 8px;
}

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

.btn-outline-secondary:hover,
.btn-outline-warning:hover {
    transform: translateY(-1px);
}

/* Form actions */
.form-actions {
    background: linear-gradient(45deg, #f8f9fa, #e9ecef);
    border: 1px solid #dee2e6;
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

/* Card consistency */
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
    font-size: 0.875rem;
    color: #495057;
}

/* Responsive */
@media (max-width: 768px) {
    .form-section {
        border-left: none;
        border-top: 3px solid var(--mint-primary, #00c9a7);
        padding-left: 0;
        padding-top: 1rem;
        margin-left: 0;
    }
    
    .form-actions {
        padding: 1.5rem;
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
    const tanggalBuka = document.getElementById('tanggal_buka');
    const tanggalTutup = document.getElementById('tanggal_tutup');
    const dateRangeInfo = document.getElementById('dateRangeInfo');
    const dateRangeText = document.getElementById('dateRangeText');
    const jumlahDanaInput = document.getElementById('jumlah_dana');
    
    // Date range calculator
    function calculateDateRange() {
        if (tanggalBuka.value && tanggalTutup.value) {
            const startDate = new Date(tanggalBuka.value);
            const endDate = new Date(tanggalTutup.value);
            const timeDiff = endDate - startDate;
            const daysDiff = Math.ceil(timeDiff / (1000 * 60 * 60 * 24));
            
            if (daysDiff > 0) {
                dateRangeInfo.classList.remove('d-none');
                dateRangeText.textContent = `Periode pendaftaran: ${daysDiff} hari (${startDate.toLocaleDateString('id-ID')} - ${endDate.toLocaleDateString('id-ID')})`;
                
                if (daysDiff < 7) {
                    dateRangeInfo.className = 'alert alert-warning';
                    dateRangeText.innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i>' + dateRangeText.textContent + ' - Periode terlalu singkat!';
                } else {
                    dateRangeInfo.className = 'alert alert-info-soft';
                    dateRangeText.innerHTML = '<i class="fas fa-info-circle me-2"></i>' + dateRangeText.textContent;
                }
            } else {
                dateRangeInfo.className = 'alert alert-danger';
                dateRangeInfo.classList.remove('d-none');
                dateRangeText.innerHTML = '<i class="fas fa-times-circle me-2"></i>Tanggal tutup harus setelah tanggal buka!';
            }
        } else {
            dateRangeInfo.classList.add('d-none');
        }
    }
    
    // Format currency input
    function formatCurrency(input) {
        let value = input.value.replace(/[^\d]/g, '');
        if (value) {
            input.value = parseInt(value).toLocaleString('id-ID');
        }
    }
    
    // Event listeners
    tanggalBuka.addEventListener('change', calculateDateRange);
    tanggalTutup.addEventListener('change', calculateDateRange);
    
    // Form validation
    document.getElementById('beasiswaForm').addEventListener('submit', function(e) {
        const startDate = new Date(tanggalBuka.value);
        const endDate = new Date(tanggalTutup.value);
        
        if (endDate <= startDate) {
            e.preventDefault();
            alert('Tanggal tutup harus setelah tanggal buka!');
            return false;
        }
        
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