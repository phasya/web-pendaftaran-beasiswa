@extends('layouts.admin')

@section('title', 'Tambah Beasiswa Baru')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <div>
            <h1 class="h2"><i class="fas fa-plus-circle"></i> Tambah Beasiswa Baru</h1>
            <p class="text-muted mb-0">
                <i class="fas fa-info-circle me-2"></i>Buat beasiswa baru untuk mahasiswa
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
                            <span class="badge bg-primary-soft text-primary">
                                <i class="fas fa-plus me-1" style="font-size: 8px;"></i>Create Mode
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
                                        id="nama_beasiswa" name="nama_beasiswa" value="{{ old('nama_beasiswa') }}"
                                        placeholder="Contoh: Beasiswa Prestasi Akademik 2025" required>
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
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi"
                                    name="deskripsi" rows="4"
                                    placeholder="Jelaskan tujuan, target penerima, dan manfaat beasiswa ini..."
                                    required>{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    <i class="fas fa-lightbulb me-1"></i>Berikan deskripsi yang jelas dan menarik untuk
                                    calon pendaftar
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
                                        id="jumlah_dana" name="jumlah_dana" value="{{ old('jumlah_dana') }}" min="100000"
                                        step="100000" placeholder="5000000" required>
                                    @error('jumlah_dana')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="form-text text-muted">
                                    <i class="fas fa-info-circle me-1"></i>Masukkan jumlah dana dalam Rupiah (minimal Rp
                                    100.000)
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
                                            id="tanggal_buka" name="tanggal_buka" value="{{ old('tanggal_buka') }}"
                                            min="{{ date('Y-m-d') }}" required>
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
                                            id="tanggal_tutup" name="tanggal_tutup" value="{{ old('tanggal_tutup') }}"
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
                                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status"
                                    required>
                                    <option value="">Pilih Status</option>
                                    <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>
                                        Aktif (Bisa dilamar)
                                    </option>
                                    <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>
                                        Nonaktif (Tidak bisa dilamar)
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    <i class="fas fa-info-circle me-1"></i>Status aktif berarti beasiswa dapat dilamar oleh
                                    mahasiswa
                                </small>
                            </div>

                            <!-- Dokumen Pendukung Section -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-file-alt text-info me-2"></i>Dokumen Pendukung
                                </label>
                                <div class="row">
                                    @foreach($dokumenOptions as $value => $label)
                                        <div class="col-md-6 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="dokumen_pendukung[]"
                                                    value="{{ $value }}" id="dokumen_{{ $value }}" {{ (is_array(old('dokumen_pendukung')) && in_array($value, old('dokumen_pendukung'))) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="dokumen_{{ $value }}">
                                                    <i class="fas fa-file-alt me-1 text-muted"></i>{{ $label }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <small class="form-text text-muted">
                                    <i class="fas fa-info-circle me-1"></i>Pilih dokumen yang wajib dilampirkan oleh
                                    pendaftar
                                </small>
                            </div>

                            <div class="mb-3">
                                <label for="persyaratan" class="form-label fw-semibold">
                                    <i class="fas fa-list-check text-info me-2"></i>Persyaratan Pendaftaran
                                    <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control @error('persyaratan') is-invalid @enderror" id="persyaratan"
                                    name="persyaratan" rows="8"
                                    placeholder="Contoh:&#10;1. Mahasiswa aktif semester 3 ke atas&#10;2. IPK minimal 3.0&#10;3. Tidak sedang menerima beasiswa lain&#10;4. Melampirkan transkrip nilai terbaru&#10;5. Surat rekomendasi dari dosen"
                                    required>{{ old('persyaratan') }}</textarea>
                                @error('persyaratan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    <i class="fas fa-lightbulb me-1"></i>Tuliskan persyaratan dengan jelas, gunakan
                                    numbering untuk kemudahan membaca
                                </small>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="form-actions bg-light p-3 rounded-3 mt-4">
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                                <div class="d-flex align-items-center text-muted">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <small>Pastikan semua data sudah benar sebelum menyimpan</small>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.beasiswa.index') }}" class="btn btn-outline-secondary">
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
                                        <i class="fas fa-target text-primary"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Target yang Jelas</h6>
                                        <small class="text-muted">Tentukan target penerima dan tujuan beasiswa dengan
                                            spesifik</small>
                                    </div>
                                </div>
                            </div>

                            <div class="tip-item mb-3">
                                <div class="d-flex">
                                    <div class="tip-icon me-3">
                                        <i class="fas fa-calendar-check text-success"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Jadwal yang Realistis</h6>
                                        <small class="text-muted">Berikan waktu yang cukup untuk pendaftaran dan
                                            seleksi</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="tip-item mb-3">
                                <div class="d-flex">
                                    <div class="tip-icon me-3">
                                        <i class="fas fa-list-ul text-info"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Persyaratan yang Mudah Dipahami</h6>
                                        <small class="text-muted">Gunakan bahasa yang jelas dan mudah dimengerti</small>
                                    </div>
                                </div>
                            </div>

                            <div class="tip-item">
                                <div class="d-flex">
                                    <div class="tip-icon me-3">
                                        <i class="fas fa-money-bill text-warning"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Nominal yang Sesuai</h6>
                                        <small class="text-muted">Sesuaikan jumlah dana dengan kebutuhan mahasiswa</small>
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
        /* Status Badge Colors */
        .bg-primary-soft {
            background-color: #cce7ff !important;
            color: #0066cc !important;
        }

        .bg-success-soft {
            background-color: #d1edff !important;
        }

        .bg-warning-soft {
            background-color: #fff3cd !important;
        }

        .bg-danger-soft {
            background-color: #f8d7da !important;
        }

        .bg-info-soft {
            background-color: #d1ecf1 !important;
        }

        .bg-secondary-soft {
            background-color: #e2e3e5 !important;
        }

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

        .form-control,
        .form-select {
            border-radius: 0.375rem;
            transition: all 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
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

        .btn-warning {
            background: linear-gradient(45deg, #ffc107, #ff9800);
            border: none;
            color: white;
        }

        .btn-warning:hover {
            background: linear-gradient(45deg, #e0a800, #f57c00);
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(255, 193, 7, 0.4);
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
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
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

        /* Form check styling */
        .form-check {
            padding: 0.5rem 1rem;
            margin-bottom: 0.5rem;
            border-radius: 6px;
            transition: all 0.2s ease;
        }

        .form-check:hover {
            background-color: #f8f9fa;
        }

        .form-check-input:checked {
            background-color: var(--mint-primary, #00c9a7);
            border-color: var(--mint-primary, #00c9a7);
        }

        .form-check-label {
            font-size: 0.9rem;
            cursor: pointer;
        }

        /* Progress bar for form completion */
        .form-progress {
            height: 6px;
            background-color: #e9ecef;
            border-radius: 3px;
            overflow: hidden;
            margin-bottom: 1rem;
        }

        .form-progress-bar {
            height: 100%;
            background: linear-gradient(45deg, var(--mint-primary, #00c9a7), var(--mint-blue, #0891b2));
            transition: width 0.3s ease;
            border-radius: 3px;
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

        /* Field validation styling */
        .is-valid {
            border-color: #28a745;
        }

        .is-valid:focus {
            border-color: #28a745;
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
        }

        .was-validated .form-control:valid,
        .was-validated .form-select:valid {
            border-color: #28a745;
        }

        .was-validated .form-control:valid:focus,
        .was-validated .form-select:valid:focus {
            border-color: #28a745;
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('beasiswaForm');
            const tanggalBuka = document.getElementById('tanggal_buka');
            const tanggalTutup = document.getElementById('tanggal_tutup');
            const dateRangeInfo = document.getElementById('dateRangeInfo');
            const dateRangeText = document.getElementById('dateRangeText');
            const jumlahDanaInput = document.getElementById('jumlah_dana');

            // Create progress bar
            const progressBar = document.createElement('div');
            progressBar.className = 'form-progress mb-3';
            progressBar.innerHTML = '<div class="form-progress-bar" style="width: 0%"></div>';
            form.insertBefore(progressBar, form.firstChild);

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
                        } else if (daysDiff > 90) {
                            dateRangeInfo.className = 'alert alert-info';
                            dateRangeText.innerHTML = '<i class="fas fa-info-circle me-2"></i>' + dateRangeText.textContent + ' - Periode cukup panjang.';
                        } else {
                            dateRangeInfo.className = 'alert alert-info-soft';
                            dateRangeText.innerHTML = '<i class="fas fa-check-circle me-2"></i>' + dateRangeText.textContent + ' - Periode ideal.';
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

            // Set minimum date for tanggal_tutup when tanggal_buka changes
            tanggalBuka.addEventListener('change', function () {
                if (this.value) {
                    const nextDay = new Date(this.value);
                    nextDay.setDate(nextDay.getDate() + 1);
                    tanggalTutup.min = nextDay.toISOString().split('T')[0];

                    // Clear tanggal_tutup if it's before the new minimum
                    if (tanggalTutup.value && new Date(tanggalTutup.value) <= new Date(this.value)) {
                        tanggalTutup.value = '';
                    }
                }
                calculateDateRange();
            });

            tanggalTutup.addEventListener('change', calculateDateRange);

            // Format currency input
            if (jumlahDanaInput) {
                jumlahDanaInput.addEventListener('input', function () {
                    // Remove non-numeric characters
                    let value = this.value.replace(/[^\d]/g, '');
                    this.value = value;
                });

                jumlahDanaInput.addEventListener('blur', function () {
                    if (this.value) {
                        const value = parseInt(this.value);
                        if (value < 100000) {
                            this.setCustomValidity('Jumlah dana minimal Rp 100.000');
                            this.classList.add('is-invalid');
                        } else {
                            this.setCustomValidity('');
                            this.classList.remove('is-invalid');
                            this.classList.add('is-valid');
                        }
                    }
                });
            }

            // Form progress tracking
            function updateProgress() {
                const requiredFields = form.querySelectorAll('input[required], select[required], textarea[required]');
                const filledFields = Array.from(requiredFields).filter(field => {
                    if (field.type === 'checkbox') {
                        return form.querySelectorAll('input[name="' + field.name + '"]:checked').length > 0;
                    }
                    return field.value.trim() !== '';
                });

                const progress = (filledFields.length / requiredFields.length) * 100;
                const progressBarElement = progressBar.querySelector('.form-progress-bar');
                progressBarElement.style.width = progress + '%';

                // Change color based on progress
                if (progress < 30) {
                    progressBarElement.style.background = 'linear-gradient(45deg, #dc3545, #c82333)';
                } else if (progress < 70) {
                    progressBarElement.style.background = 'linear-gradient(45deg, #ffc107, #e0a800)';
                } else {
                    progressBarElement.style.background = 'linear-gradient(45deg, var(--mint-primary, #00c9a7), var(--mint-blue, #0891b2))';
                }
            }

            // Add progress tracking to all form fields
            form.querySelectorAll('input, select, textarea').forEach(field => {
                field.addEventListener('input', updateProgress);
                field.addEventListener('change', updateProgress);
            });

            // Initial progress update
            updateProgress();

            // Form validation
            form.addEventListener('submit', function (e) {
                const startDate = new Date(tanggalBuka.value);
                const endDate = new Date(tanggalTutup.value);

                // Validate dates
                if (endDate <= startDate) {
                    e.preventDefault();
                    alert('Tanggal tutup harus setelah tanggal buka!');
                    tanggalTutup.focus();
                    return false;
                }

                // Validate dana amount
                const danaValue = parseInt(jumlahDanaInput.value);
                if (danaValue < 100000) {
                    e.preventDefault();
                    alert('Jumlah dana minimal Rp 100.000!');
                    jumlahDanaInput.focus();
                    return false;
                }

                // Validate required fields
                const requiredFields = form.querySelectorAll('input[required], select[required], textarea[required]');
                let hasEmptyField = false;

                requiredFields.forEach(field => {
                    if (field.type === 'checkbox') {
                        const checkboxGroup = form.querySelectorAll('input[name="' + field.name + '"]:checked');
                        if (checkboxGroup.length === 0 && field.hasAttribute('data-required-group')) {
                            hasEmptyField = true;
                        }
                    } else if (!field.value.trim()) {
                        hasEmptyField = true;
                        field.classList.add('is-invalid');
                    } else {
                        field.classList.remove('is-invalid');
                        field.classList.add('is-valid');
                    }
                });

                if (hasEmptyField) {
                    e.preventDefault();
                    alert('Mohon lengkapi semua field yang wajib diisi!');
                    return false;
                }

                // Show loading state
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
                submitBtn.disabled = true;

                // Show progress message
                const progressAlert = document.createElement('div');
                progressAlert.className = 'alert alert-info mt-3';
                progressAlert.innerHTML = `
                <div class="d-flex align-items-center">
                    <div class="spinner-border spinner-border-sm me-3" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <div>
                        <strong>Sedang menyimpan beasiswa...</strong><br>
                        <small>Mohon tunggu, jangan tutup halaman ini.</small>
                    </div>
                </div>
            `;
                form.appendChild(progressAlert);

                // Re-enable after 5 seconds (in case of server error)
                setTimeout(() => {
                    if (submitBtn.disabled) {
                        submitBtn.innerHTML = originalText;
                        submitBtn.disabled = false;
                        progressAlert.remove();
                    }
                }, 5000);
            });

            // Auto-resize textarea
            document.querySelectorAll('textarea').forEach(textarea => {
                function autoResize() {
                    textarea.style.height = 'auto';
                    textarea.style.height = (textarea.scrollHeight) + 'px';
                }

                textarea.addEventListener('input', autoResize);
                autoResize(); // Initial resize
            });

            // Real-time validation
            form.querySelectorAll('input, select, textarea').forEach(field => {
                field.addEventListener('blur', function () {
                    validateField(this);
                });

                field.addEventListener('input', function () {
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

                if (field.hasAttribute('required') && !field.value.trim()) {
                    isValid = false;
                    message = 'Field ini wajib diisi';
                } else if (field.type === 'email' && field.value) {
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(field.value)) {
                        isValid = false;
                        message = 'Format email tidak valid';
                    }
                } else if (field.name === 'jumlah_dana' && field.value) {
                    const value = parseInt(field.value);
                    if (value < 100000) {
                        isValid = false;
                        message = 'Jumlah dana minimal Rp 100.000';
                    }
                }

                if (!isValid) {
                    field.classList.add('is-invalid');
                    field.classList.remove('is-valid');

                    let feedback = field.parentNode.querySelector('.custom-invalid-feedback');
                    if (!feedback) {
                        feedback = document.createElement('div');
                        feedback.className = 'invalid-feedback custom-invalid-feedback';
                        field.parentNode.appendChild(feedback);
                    }
                    feedback.textContent = message;
                    feedback.style.display = 'block';
                } else if (field.value.trim()) {
                    field.classList.remove('is-invalid');
                    field.classList.add('is-valid');

                    const feedback = field.parentNode.querySelector('.custom-invalid-feedback');
                    if (feedback) {
                        feedback.style.display = 'none';
                    }
                }
            }

            // Character counter for textarea
            const persyaratanTextarea = document.getElementById('persyaratan');
            if (persyaratanTextarea) {
                const counterDiv = document.createElement('div');
                counterDiv.className = 'form-text text-end mt-1';
                persyaratanTextarea.parentNode.appendChild(counterDiv);

                function updateCounter() {
                    const length = persyaratanTextarea.value.length;
                    counterDiv.textContent = `${length} karakter`;

                    if (length < 10) {
                        counterDiv.className = 'form-text text-end mt-1 text-danger';
                        counterDiv.innerHTML = `${length} karakter <small>(minimal 10 karakter)</small>`;
                    } else if (length > 1000) {
                        counterDiv.className = 'form-text text-end mt-1 text-warning';
                    } else {
                        counterDiv.className = 'form-text text-end mt-1 text-muted';
                    }
                }

                persyaratanTextarea.addEventListener('input', updateCounter);
                updateCounter(); // Initial count
            }

            // Checkbox counter
            const checkboxes = document.querySelectorAll('input[name="dokumen_pendukung[]"]');
            const checkboxContainer = checkboxes[0]?.closest('.mb-3');

            if (checkboxContainer) {
                const counterDiv = document.createElement('div');
                counterDiv.className = 'form-text mt-2';
                checkboxContainer.appendChild(counterDiv);

                function updateCheckboxCounter() {
                    const checkedCount = document.querySelectorAll('input[name="dokumen_pendukung[]"]:checked').length;
                    if (checkedCount === 0) {
                        counterDiv.innerHTML = '<i class="fas fa-info-circle me-1 text-muted"></i>Tidak ada dokumen pendukung dipilih (opsional)';
                        counterDiv.className = 'form-text mt-2 text-muted';
                    } else {
                        counterDiv.innerHTML = `<i class="fas fa-check-circle me-1 text-success"></i>${checkedCount} dokumen pendukung dipilih`;
                        counterDiv.className = 'form-text mt-2 text-success';
                    }
                }

                checkboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', updateCheckboxCounter);
                });

                updateCheckboxCounter(); // Initial count
            }

            // Reset form functionality
            document.querySelector('button[type="reset"]').addEventListener('click', function (e) {
                if (confirm('Yakin ingin mereset semua data?')) {
                    // Clear all validation states
                    form.classList.remove('was-validated');
                    form.querySelectorAll('.is-valid, .is-invalid').forEach(field => {
                        field.classList.remove('is-valid', 'is-invalid');
                    });

                    // Reset progress bar
                    setTimeout(updateProgress, 100);

                    // Reset date range info
                    setTimeout(calculateDateRange, 100);
                } else {
                    e.preventDefault();
                }
            });

            // Auto-save to localStorage (for draft functionality)
            const STORAGE_KEY = 'beasiswa_draft_' + Date.now();
            let draftTimer;

            function saveDraft() {
                const formData = new FormData(form);
                const draftData = {};

                for (let [key, value] of formData.entries()) {
                    if (draftData[key]) {
                        if (Array.isArray(draftData[key])) {
                            draftData[key].push(value);
                        } else {
                            draftData[key] = [draftData[key], value];
                        }
                    } else {
                        draftData[key] = value;
                    }
                }

                localStorage.setItem(STORAGE_KEY, JSON.stringify(draftData));
            }

            form.querySelectorAll('input, select, textarea').forEach(field => {
                field.addEventListener('input', function () {
                    clearTimeout(draftTimer);
                    draftTimer = setTimeout(saveDraft, 2000); // Save draft after 2 seconds of inactivity
                });
            });

            // Clear draft on successful submit
            form.addEventListener('submit', function () {
                localStorage.removeItem(STORAGE_KEY);
            });

            // Show auto-save indicator
            let saveIndicatorTimer;
            const saveIndicator = document.createElement('small');
            saveIndicator.className = 'text-muted ms-2';
            saveIndicator.style.opacity = '0';
            saveIndicator.innerHTML = '<i class="fas fa-save text-success"></i> Draft tersimpan otomatis';

            const firstSectionTitle = document.querySelector('.section-title');
            if (firstSectionTitle) {
                firstSectionTitle.appendChild(saveIndicator);
            }

            function showSaveIndicator() {
                clearTimeout(saveIndicatorTimer);
                saveIndicator.style.opacity = '1';
                saveIndicatorTimer = setTimeout(() => {
                    saveIndicator.style.opacity = '0';
                }, 2000);
            }

            // Show save indicator when draft is saved
            const originalSaveDraft = saveDraft;
            saveDraft = function () {
                originalSaveDraft();
                showSaveIndicator();
            };
        });
    </script>
@endsection