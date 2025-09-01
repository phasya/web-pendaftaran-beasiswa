  <style>
        .card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: none;
            border-radius: 12px;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }
        
        .dokumen-checkbox {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 8px;
            transition: all 0.3s ease;
        }
        
        .dokumen-checkbox:hover {
            background: #e9ecef;
        }
        
        .dokumen-checkbox input:checked + label {
            color: #0d6efd;
            font-weight: 500;
        }
        
        .required-field::after {
            content: " *";
            color: #dc3545;
        }
        
        .alert {
            border-radius: 8px;
        }
        
        .btn {
            border-radius: 8px;
            padding: 8px 20px;
        }
        
        .section-title {
            color: #495057;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 8px;
            border-bottom: 2px solid #e9ecef;
        }
        
        .debug-info {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 10px;
            margin-top: 10px;
            font-size: 0.85em;
            color: #6c757d;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">
                            <i class="fas fa-graduation-cap me-2"></i>
                            {{ isset($beasiswa) ? 'Edit Beasiswa' : 'Tambah Beasiswa Baru' }}
                        </h4>
                    </div>
                    
                    <div class="card-body p-4">
                        @if($errors->any())
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Terjadi kesalahan:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        
                        @if(session('error'))
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            {{ session('error') }}
                        </div>
                        @endif
                        
                        <form method="POST" action="{{ isset($beasiswa) ? route('admin.beasiswa.update', $beasiswa->id) : route('admin.beasiswa.store') }}" id="beasiswaForm">
                            @csrf
                            @if(isset($beasiswa))
                                @method('PUT')
                            @endif
                            
                            <!-- Informasi Dasar -->
                            <div class="section-title">
                                <i class="fas fa-info-circle me-2"></i>
                                Informasi Dasar
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-8">
                                    <label for="nama_beasiswa" class="form-label required-field">Nama Beasiswa</label>
                                    <input type="text" 
                                           class="form-control @error('nama_beasiswa') is-invalid @enderror" 
                                           id="nama_beasiswa" 
                                           name="nama_beasiswa" 
                                           value="{{ old('nama_beasiswa', $beasiswa->nama_beasiswa ?? '') }}"
                                           placeholder="Masukkan nama beasiswa">
                                    @error('nama_beasiswa')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-4">
                                    <label for="status" class="form-label required-field">Status</label>
                                    <select class="form-select @error('status') is-invalid @enderror" 
                                            id="status" 
                                            name="status">
                                        <option value="">Pilih Status</option>
                                        <option value="aktif" {{ old('status', $beasiswa->status ?? '') == 'aktif' ? 'selected' : '' }}>
                                            Aktif
                                        </option>
                                        <option value="nonaktif" {{ old('status', $beasiswa->status ?? '') == 'nonaktif' ? 'selected' : '' }}>
                                            Non-aktif
                                        </option>
                                        <option value="draft" {{ old('status', $beasiswa->status ?? '') == 'draft' ? 'selected' : '' }}>
                                            Draft
                                        </option>
                                    </select>
                                    @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="deskripsi" class="form-label required-field">Deskripsi</label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                          id="deskripsi" 
                                          name="deskripsi" 
                                          rows="4" 
                                          placeholder="Masukkan deskripsi beasiswa">{{ old('deskripsi', $beasiswa->deskripsi ?? '') }}</textarea>
                                @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="jumlah_dana" class="form-label required-field">Jumlah Dana</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" 
                                               class="form-control @error('jumlah_dana') is-invalid @enderror" 
                                               id="jumlah_dana" 
                                               name="jumlah_dana" 
                                               value="{{ old('jumlah_dana', $beasiswa->jumlah_dana ?? '') }}"
                                               placeholder="0"
                                               min="0"
                                               step="1000">
                                    </div>
                                    @error('jumlah_dana')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-4">
                                    <label for="tanggal_buka" class="form-label required-field">Tanggal Buka</label>
                                    <input type="date" 
                                           class="form-control @error('tanggal_buka') is-invalid @enderror" 
                                           id="tanggal_buka" 
                                           name="tanggal_buka" 
                                           value="{{ old('tanggal_buka', isset($beasiswa) ? $beasiswa->tanggal_buka->format('Y-m-d') : '') }}">
                                    @error('tanggal_buka')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-4">
                                    <label for="tanggal_tutup" class="form-label required-field">Tanggal Tutup</label>
                                    <input type="date" 
                                           class="form-control @error('tanggal_tutup') is-invalid @enderror" 
                                           id="tanggal_tutup" 
                                           name="tanggal_tutup" 
                                           value="{{ old('tanggal_tutup', isset($beasiswa) ? $beasiswa->tanggal_tutup->format('Y-m-d') : '') }}">
                                    @error('tanggal_tutup')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Persyaratan -->
                            <div class="section-title mt-4">
                                <i class="fas fa-list-check me-2"></i>
                                Persyaratan
                            </div>
                            
                            <div class="mb-3">
                                <label for="persyaratan" class="form-label required-field">Persyaratan Beasiswa</label>
                                <textarea class="form-control @error('persyaratan') is-invalid @enderror" 
                                          id="persyaratan" 
                                          name="persyaratan" 
                                          rows="5" 
                                          placeholder="Masukkan persyaratan beasiswa (gunakan numbering untuk kemudahan membaca)">{{ old('persyaratan', $beasiswa->persyaratan ?? '') }}</textarea>
                                @error('persyaratan')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    <i class="fas fa-lightbulb me-1"></i>
                                    Tuliskan persyaratan dengan jelas, gunakan numbering untuk kemudahan membaca
                                </div>
                            </div>
                            
                            <!-- Dokumen Pendukung -->
                            <div class="section-title mt-4">
                                <i class="fas fa-file-upload me-2"></i>
                                Dokumen Pendukung yang Diperlukan
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label required-field">Pilih Dokumen Pendukung</label>
                                <div class="row">
                                    <?php 
                                    $dokumenOptions = [
                                        'surat-aktif' => 'Surat Keterangan Aktif Kuliah',
                                        'transkrip' => 'Transkrip Nilai',
                                        'rekomendasi' => 'Surat Rekomendasi',
                                        'ktp' => 'KTP/Identitas',
                                        'kk' => 'Kartu Keluarga',
                                        'surat-keterangan-tidak-mampu' => 'Surat Keterangan Tidak Mampu',
                                        'sertifikat-prestasi' => 'Sertifikat Prestasi'
                                    ];
                                    
                                    $selectedDokumen = old('dokumen_pendukung', isset($beasiswa) ? $beasiswa->dokumen_pendukung : []);
                                    ?>
                                    
                                    @foreach($dokumenOptions as $value => $label)
                                    <div class="col-md-6">
                                        <div class="dokumen-checkbox">
                                            <div class="form-check">
                                                <input class="form-check-input" 
                                                       type="checkbox" 
                                                       value="{{ $value }}" 
                                                       id="dokumen_{{ $value }}"
                                                       name="dokumen_pendukung[]"
                                                       {{ in_array($value, $selectedDokumen) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="dokumen_{{ $value }}">
                                                    <i class="fas fa-file-alt me-2"></i>
                                                    {{ $label }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                
                                @error('dokumen_pendukung')
                                <div class="text-danger small mt-2">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    {{ $message }}
                                </div>
                                @enderror
                                
                                <div class="form-text mt-2">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Pilih minimal 1 dokumen yang harus disiapkan oleh pendaftar
                                </div>
                            </div>
                            
                            <!-- Debug Information (hanya tampil jika ada data beasiswa) -->
                            @if(isset($beasiswa))
                            <div class="debug-info">
                                <strong>Debug - Data Dokumen Tersimpan:</strong><br>
                                Raw: {{ json_encode($beasiswa->dokumen_pendukung) }}<br>
                                Labels: {{ implode(', ', $beasiswa->dokumen_pendukung_label) }}
                            </div>
                            @endif
                            
                            <!-- Action Buttons -->
                            <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                                <a href="{{ route('admin.beasiswa.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>
                                    Kembali
                                </a>
                                
                                <div>
                                    <button type="button" class="btn btn-warning me-2" id="resetBtn">
                                        <i class="fas fa-undo me-2"></i>
                                        Reset
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>
                                        {{ isset($beasiswa) ? 'Update' : 'Simpan' }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Format input jumlah dana
            const jumlahDanaInput = document.getElementById('jumlah_dana');
            jumlahDanaInput.addEventListener('input', function() {
                // Remove non-numeric characters
                let value = this.value.replace(/\D/g, '');
                this.value = value;
            });
            
            // Reset form
            document.getElementById('resetBtn').addEventListener('click', function() {
                if (confirm('Apakah Anda yakin ingin mereset form? Semua data yang telah diisi akan hilang.')) {
                    document.getElementById('beasiswaForm').reset();
                }
            });
            
            // Validasi tanggal
            const tanggalBuka = document.getElementById('tanggal_buka');
            const tanggalTutup = document.getElementById('tanggal_tutup');
            
            function validateDates() {
                if (tanggalBuka.value && tanggalTutup.value) {
                    if (new Date(tanggalTutup.value) <= new Date(tanggalBuka.value)) {
                        tanggalTutup.setCustomValidity('Tanggal tutup harus setelah tanggal buka');
                    } else {
                        tanggalTutup.setCustomValidity('');
                    }
                }
            }
            
            tanggalBuka.addEventListener('change', validateDates);
            tanggalTutup.addEventListener('change', validateDates);
            
            // Validasi dokumen pendukung
            const dokumenCheckboxes = document.querySelectorAll('input[name="dokumen_pendukung[]"]');
            const form = document.getElementById('beasiswaForm');
            
            form.addEventListener('submit', function(e) {
                const checkedBoxes = document.querySelectorAll('input[name="dokumen_pendukung[]"]:checked');
                if (checkedBoxes.length === 0) {
                    e.preventDefault();
                    alert('Pilih minimal 1 dokumen pendukung yang diperlukan');
                    document.querySelector('input[name="dokumen_pendukung[]"]').focus();
                    return false;
                }
                
                // Log data yang akan dikirim
                console.log('Data dokumen pendukung yang akan dikirim:');
                checkedBoxes.forEach(function(checkbox) {
                    console.log('- ' + checkbox.value);
                });
            });
            
            // Highlight selected documents
            dokumenCheckboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    const parentDiv = this.closest('.dokumen-checkbox');
                    if (this.checked) {
                        parentDiv.style.background = '#e3f2fd';
                        parentDiv.style.borderColor = '#2196f3';
                    } else {
                        parentDiv.style.background = '#f8f9fa';
                        parentDiv.style.borderColor = '#dee2e6';
                    }
                });
                
                // Set initial state
                if (checkbox.checked) {
                    const parentDiv = checkbox.closest('.dokumen-checkbox');
                    parentDiv.style.background = '#e3f2fd';
                    parentDiv.style.borderColor = '#2196f3';
                }
            });
        });
    </script>