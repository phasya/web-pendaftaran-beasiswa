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
                    <h6 class="card-title mb-0">
                        <i class="fas fa-graduation-cap text-primary me-2"></i>Form Tambah Beasiswa
                    </h6>
                </div>
                <div class="card-body p-4">
                    
                    {{-- Error Message --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.beasiswa.store') }}" method="POST" id="beasiswaForm">
                        @csrf

                        {{-- Nama Beasiswa --}}
                        <div class="mb-3">
                            <label for="nama_beasiswa" class="form-label fw-semibold">Nama Beasiswa <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_beasiswa') is-invalid @enderror"
                                id="nama_beasiswa" name="nama_beasiswa" value="{{ old('nama_beasiswa') }}" required>
                            @error('nama_beasiswa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Deskripsi --}}
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label fw-semibold">Deskripsi Beasiswa <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror"
                                id="deskripsi" name="deskripsi" rows="4" required>{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Jumlah Dana --}}
                        <div class="mb-3">
                            <label for="jumlah_dana" class="form-label fw-semibold">Jumlah Dana <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('jumlah_dana') is-invalid @enderror"
                                id="jumlah_dana" name="jumlah_dana" value="{{ old('jumlah_dana') }}" min="0" required>
                            @error('jumlah_dana')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tanggal Buka & Tutup --}}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="tanggal_buka" class="form-label fw-semibold">Tanggal Buka <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('tanggal_buka') is-invalid @enderror"
                                    id="tanggal_buka" name="tanggal_buka" value="{{ old('tanggal_buka') }}" required>
                                @error('tanggal_buka')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="tanggal_tutup" class="form-label fw-semibold">Tanggal Tutup <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('tanggal_tutup') is-invalid @enderror"
                                    id="tanggal_tutup" name="tanggal_tutup" value="{{ old('tanggal_tutup') }}" required>
                                @error('tanggal_tutup')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Status --}}
                        <div class="mb-3">
                            <label for="status" class="form-label fw-semibold">Status Beasiswa <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" name="status" id="status" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Dokumen Pendukung --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Dokumen Pendukung</label>
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    Pilih Dokumen
                                </button>
                                <ul class="dropdown-menu p-2" style="min-width: 250px;">
                                    @foreach ($dokumenOptions as $key => $label)
                                        <li>
                                            <label class="dropdown-item d-flex align-items-center">
                                                <input type="checkbox" name="dokumen[]" value="{{ $key }}" class="me-2"
                                                    {{ is_array(old('dokumen')) && in_array($key, old('dokumen')) ? 'checked' : '' }}>
                                                {{ $label }}
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        {{-- Persyaratan --}}
                        <div class="mb-3">
                            <label for="persyaratan" class="form-label fw-semibold">Persyaratan <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('persyaratan') is-invalid @enderror"
                                id="persyaratan" name="persyaratan" rows="6" required>{{ old('persyaratan') }}</textarea>
                            @error('persyaratan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tombol --}}
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.beasiswa.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Simpan
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>



        <!-- Custom CSS -->
        <style>

            .dropdown-menu {
            padding: 0.5rem;
            min-width: 250px;
        }
        .dropdown-item-checkbox {
            padding: 0.375rem 0.75rem;
            display: flex;
            align-items: center;
            cursor: pointer;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
        }
        .dropdown-item-checkbox:hover {
            background-color: var(--bs-dropdown-link-hover-bg);
        }
        .dropdown-item-checkbox input[type="checkbox"] {
            margin-right: 0.5rem;
        }
        .dropdown-menu .dropdown-item-checkbox:focus {
            outline: 2px solid var(--bs-primary);
            outline-offset: -2px;
        }
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
            border-left: 4px solid var(--mint-primary, #FFE100);
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
              // Prevent dropdown from closing when clicking on checkboxes
        document.querySelectorAll('.dropdown-item-checkbox').forEach(item => {
            item.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        });

        // Update selected documents display
        function updateSelectedDocuments() {
            const checkboxes = document.querySelectorAll('input[name="dokumen"]:checked');
            const selectedDiv = document.getElementById('selectedDocuments');

            if (checkboxes.length === 0) {
                selectedDiv.innerHTML = '<em>Belum ada dokumen yang dipilih</em>';
            } else {
                const selectedItems = Array.from(checkboxes).map(checkbox => {
                    return checkbox.nextSibling.textContent.trim();
                });
                selectedDiv.innerHTML = selectedItems.map(item => 
                    `<span class="badge bg-primary me-1">${item}</span>`
                ).join('');
            }
        }

        // Add event listeners to all checkboxes
        document.querySelectorAll('input[name="dokumen"]').forEach(checkbox => {
            checkbox.addEventListener('change', updateSelectedDocuments);
        });

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

        function updateSelectedDocuments() {
    const checkboxes = document.querySelectorAll('input[name="dokumen[]"]:checked');
    const selectedDiv = document.getElementById('selectedDocuments');

    if (checkboxes.length === 0) {
        selectedDiv.innerHTML = '<em>Belum ada dokumen yang dipilih</em>';
    } else {
        const selectedItems = Array.from(checkboxes).map(checkbox => {
            return checkbox.parentElement.textContent.trim();
        });
        selectedDiv.innerHTML = selectedItems.map(item =>
            `<span class="badge bg-primary me-1">${item}</span>`
        ).join('');
    }
}

// Event listeners
document.querySelectorAll('input[name="dokumen[]"]').forEach(checkbox => {
    checkbox.addEventListener('change', updateSelectedDocuments);
});

        </script>
@endsection