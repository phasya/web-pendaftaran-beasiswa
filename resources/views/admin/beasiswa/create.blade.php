@extends('layouts.app')

@section('title', 'Pendaftaran Beasiswa - ')

@extends('layouts.app')

@section('title', 'Tambah Beasiswa - Admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <!-- Header Section -->
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h2 class="display-6 text-primary fw-bold mb-0">
                        <i class="fas fa-plus-circle me-2"></i>Tambah Beasiswa
                    </h2>
                    <p class="text-muted">Buat program beasiswa baru</p>
                </div>
                <a href="{{ route('admin.beasiswa.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>

            <!-- Main Form Card -->
            <div class="card shadow-lg border-0">
                <div class="card-header py-4">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-graduation-cap text-warning me-2"></i>Form Tambah Beasiswa
                    </h4>
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('admin.beasiswa.store') }}" enctype="multipart/form-data"
                        id="beasiswaForm">
                        @csrf

                        <!-- Basic Information -->
                        <div class="form-section mb-5">
                            <h5 class="section-title mb-4">
                                <i class="fas fa-info-circle text-primary me-2"></i>Informasi Dasar
                            </h5>

                            <div class="row">
                                <div class="col-md-8 mb-3">
                                    <label for="nama_beasiswa" class="form-label fw-semibold">
                                        <i class="fas fa-award me-1"></i>Nama Beasiswa *
                                    </label>
                                    <input type="text"
                                        class="form-control modern-input @error('nama_beasiswa') is-invalid @enderror"
                                        id="nama_beasiswa" name="nama_beasiswa" value="{{ old('nama_beasiswa') }}"
                                        placeholder="Masukkan nama beasiswa" required>
                                    @error('nama_beasiswa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="status" class="form-label fw-semibold">
                                        <i class="fas fa-toggle-on me-1"></i>Status *
                                    </label>
                                    <select class="form-select modern-input @error('status') is-invalid @enderror"
                                        id="status" name="status" required>
                                        <option value="">Pilih Status</option>
                                        <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft
                                        </option>
                                        <option value="aktif" {{ old('status') === 'aktif' ? 'selected' : '' }}>Aktif
                                        </option>
                                        <option value="tutup" {{ old('status') === 'tutup' ? 'selected' : '' }}>Tutup
                                        </option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="deskripsi" class="form-label fw-semibold">
                                    <i class="fas fa-align-left me-1"></i>Deskripsi *
                                </label>
                                <textarea class="form-control modern-textarea @error('deskripsi') is-invalid @enderror"
                                    id="deskripsi" name="deskripsi" rows="4"
                                    placeholder="Deskripsikan program beasiswa ini..."
                                    required>{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="jumlah_dana" class="form-label fw-semibold">
                                        <i class="fas fa-money-bill-wave me-1"></i>Jumlah Dana (Rp) *
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number"
                                            class="form-control modern-input @error('jumlah_dana') is-invalid @enderror"
                                            id="jumlah_dana" name="jumlah_dana" value="{{ old('jumlah_dana') }}"
                                            placeholder="5000000" min="0" step="10000" required>
                                    </div>
                                    @error('jumlah_dana')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="jumlah_penerima" class="form-label fw-semibold">
                                        <i class="fas fa-users me-1"></i>Jumlah Penerima *
                                    </label>
                                    <input type="number"
                                        class="form-control modern-input @error('jumlah_penerima') is-invalid @enderror"
                                        id="jumlah_penerima" name="jumlah_penerima"
                                        value="{{ old('jumlah_penerima', 1) }}" min="1" required>
                                    @error('jumlah_penerima')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Schedule Information -->
                        <div class="form-section mb-5">
                            <h5 class="section-title mb-4">
                                <i class="fas fa-calendar-alt text-success me-2"></i>Jadwal Pendaftaran
                            </h5>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="tanggal_buka" class="form-label fw-semibold">
                                        <i class="fas fa-calendar-plus me-1"></i>Tanggal Buka *
                                    </label>
                                    <input type="date"
                                        class="form-control modern-input @error('tanggal_buka') is-invalid @enderror"
                                        id="tanggal_buka" name="tanggal_buka" value="{{ old('tanggal_buka') }}"
                                        required>
                                    @error('tanggal_buka')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="tanggal_tutup" class="form-label fw-semibold">
                                        <i class="fas fa-calendar-times me-1"></i>Tanggal Tutup *
                                    </label>
                                    <input type="date"
                                        class="form-control modern-input @error('tanggal_tutup') is-invalid @enderror"
                                        id="tanggal_tutup" name="tanggal_tutup" value="{{ old('tanggal_tutup') }}"
                                        required>
                                    @error('tanggal_tutup')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Info:</strong> Tanggal tutup harus lebih besar dari tanggal buka
                            </div>
                        </div>

                        <!-- Requirements Section -->
                        <div class="form-section mb-5">
                            <h5 class="section-title mb-4">
                                <i class="fas fa-list-check text-warning me-2"></i>Persyaratan & Dokumen
                            </h5>

                            <div class="mb-4">
                                <label for="persyaratan" class="form-label fw-semibold">
                                    <i class="fas fa-file-text me-1"></i>Persyaratan Umum
                                </label>
                                <textarea
                                    class="form-control modern-textarea @error('persyaratan') is-invalid @enderror"
                                    id="persyaratan" name="persyaratan" rows="5"
                                    placeholder="Tuliskan persyaratan untuk mendaftar beasiswa ini...">{{ old('persyaratan') }}</textarea>
                                @error('persyaratan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-upload me-1"></i>Dokumen Pendukung yang Diperlukan
                                </label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" value="ktp" id="doc_ktp"
                                                name="dokumen_pendukung[]" {{ in_array('ktp', old('dokumen_pendukung', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="doc_ktp">
                                                <i class="fas fa-id-card text-primary me-1"></i>KTP
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" value="kk" id="doc_kk"
                                                name="dokumen_pendukung[]" {{ in_array('kk', old('dokumen_pendukung', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="doc_kk">
                                                <i class="fas fa-users text-success me-1"></i>Kartu Keluarga
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" value="ijazah"
                                                id="doc_ijazah" name="dokumen_pendukung[]" {{ in_array('ijazah', old('dokumen_pendukung', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="doc_ijazah">
                                                <i class="fas fa-certificate text-warning me-1"></i>Ijazah Terakhir
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" value="transkrip"
                                                id="doc_transkrip" name="dokumen_pendukung[]" {{ in_array('transkrip', old('dokumen_pendukung', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="doc_transkrip">
                                                <i class="fas fa-file-alt text-info me-1"></i>Transkrip Nilai
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox"
                                                value="surat_keterangan_tidak_mampu" id="doc_sktm"
                                                name="dokumen_pendukung[]" {{ in_array('surat_keterangan_tidak_mampu', old('dokumen_pendukung', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="doc_sktm">
                                                <i class="fas fa-file-medical text-danger me-1"></i>Surat Keterangan
                                                Tidak Mampu
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" value="slip_gaji_ortu"
                                                id="doc_slip" name="dokumen_pendukung[]" {{ in_array('slip_gaji_ortu', old('dokumen_pendukung', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="doc_slip">
                                                <i class="fas fa-money-check text-secondary me-1"></i>Slip Gaji Orang
                                                Tua
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" value="surat_rekomendasi"
                                                id="doc_rekomendasi" name="dokumen_pendukung[]" {{ in_array('surat_rekomendasi', old('dokumen_pendukung', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="doc_rekomendasi">
                                                <i class="fas fa-thumbs-up text-primary me-1"></i>Surat Rekomendasi
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" value="sertifikat_prestasi"
                                                id="doc_prestasi" name="dokumen_pendukung[]" {{ in_array('sertifikat_prestasi', old('dokumen_pendukung', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="doc_prestasi">
                                                <i class="fas fa-trophy text-warning me-1"></i>Sertifikat Prestasi
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <small class="text-muted">Pilih dokumen yang wajib diupload oleh pendaftar</small>
                            </div>
                        </div>

                        <!-- Image Upload -->
                        <div class="form-section mb-5">
                            <h5 class="section-title mb-4">
                                <i class="fas fa-image text-info me-2"></i>Gambar Beasiswa
                            </h5>

                            <div class="upload-area">
                                <label for="gambar" class="upload-label">
                                    <div class="upload-content">
                                        <i class="fas fa-cloud-upload-alt upload-icon"></i>
                                        <h6 class="upload-title">Upload Gambar Beasiswa</h6>
                                        <p class="upload-desc">Klik untuk memilih file atau drag & drop</p>
                                        <small class="text-muted">Format: JPG, PNG, JPEG • Max: 2MB</small>
                                    </div>
                                </label>
                                <input type="file" class="form-control file-input @error('gambar') is-invalid @enderror"
                                    id="gambar" name="gambar" accept="image/*">
                                @error('gambar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div id="image-preview" class="image-preview mt-3" style="display: none;"></div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex gap-3 justify-content-end pt-4 border-top">
                            <a href="{{ route('admin.beasiswa.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                            <button type="reset" class="btn btn-outline-warning">
                                <i class="fas fa-undo me-2"></i>Reset
                            </button>
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <i class="fas fa-save me-2"></i>Simpan Beasiswa
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    :root {
        --primary-color: #4f46e5;
        --secondary-color: #f8fafc;
        --success-color: #10b981;
        --warning-color: #f59e0b;
        --danger-color: #ef4444;
        --info-color: #06b6d4;
    }

    .card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 25px rgba(0, 0, 0, 0.08);
    }

    .card-header {
        background: linear-gradient(135deg, var(--primary-color), #6366f1);
        color: white;
        border-radius: 15px 15px 0 0 !important;
        padding: 1.5rem 2rem;
    }

    .form-section {
        background: #f8fafc;
        border-radius: 12px;
        padding: 2rem;
        border-left: 4px solid var(--primary-color);
    }

    .section-title {
        font-weight: 600;
        color: #374151;
        font-size: 1.2rem;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #e5e7eb;
    }

    .modern-input,
    .modern-textarea {
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: white;
    }

    .modern-input:focus,
    .modern-textarea:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.1);
        background: white;
    }

    .upload-area {
        border: 2px dashed #d1d5db;
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        transition: all 0.3s ease;
        background: white;
        cursor: pointer;
    }

    .upload-area:hover {
        border-color: var(--primary-color);
        background: #f0f9ff;
    }

    .upload-area.dragover {
        border
    }

    .upload-label {
        
    }
@section('content')
