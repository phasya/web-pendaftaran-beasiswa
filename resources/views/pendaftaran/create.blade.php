@extends('layouts.app')

@section('title', 'Daftar Beasiswa - ' . $beasiswa->nama_beasiswa)

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-paper-plane"></i> Pendaftaran Beasiswa
                    </h4>
                    <p class="mb-0 mt-2">{{ $beasiswa->nama_beasiswa }}</p>
                </div>
                
                <div class="card-body">
                    <!-- Info Beasiswa -->
                    <div class="alert alert-info mb-4">
                        <h5><i class="fas fa-info-circle"></i> Informasi Beasiswa</h5>
                        <p><strong>Dana:</strong> Rp {{ number_format($beasiswa->jumlah_dana, 0, ',', '.') }}</p>
                        <p><strong>Batas Waktu:</strong> {{ \Carbon\Carbon::parse($beasiswa->tanggal_tutup)->format('d M Y') }}</p>
                        <p class="mb-0"><strong>Persyaratan:</strong></p>
                        <div class="mt-2">{{ $beasiswa->persyaratan }}</div>
                    </div>

                    <form method="POST" action="{{ route('pendaftar.store', $beasiswa) }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nama_lengkap" class="form-label">
                                    <i class="fas fa-user"></i> Nama Lengkap *
                                </label>
                                <input type="text" 
                                       class="form-control @error('nama_lengkap') is-invalid @enderror" 
                                       id="nama_lengkap" 
                                       name="nama_lengkap" 
                                       value="{{ old('nama_lengkap') }}" 
                                       required>
                                @error('nama_lengkap')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="nim" class="form-label">
                                    <i class="fas fa-id-card"></i> NIM *
                                </label>
                                <input type="text" 
                                       class="form-control @error('nim') is-invalid @enderror" 
                                       id="nim" 
                                       name="nim" 
                                       value="{{ old('nim') }}" 
                                       required>
                                @error('nim')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope"></i> Email *
                                </label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="no_hp" class="form-label">
                                    <i class="fas fa-phone"></i> No. HP *
                                </label>
                                <input type="text" 
                                       class="form-control @error('no_hp') is-invalid @enderror" 
                                       id="no_hp" 
                                       name="no_hp" 
                                       value="{{ old('no_hp') }}" 
                                       required>
                                @error('no_hp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="alasan_mendaftar" class="form-label">
                                <i class="fas fa-comment"></i> Alasan Mendaftar *
                            </label>
                            <textarea class="form-control @error('alasan_mendaftar') is-invalid @enderror" 
                                      id="alasan_mendaftar" 
                                      name="alasan_mendaftar" 
                                      rows="4" 
                                      required>{{ old('alasan_mendaftar') }}</textarea>
                            @error('alasan_mendaftar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="file_transkrip" class="form-label">
                                    <i class="fas fa-file-pdf"></i> Transkrip Nilai (PDF) *
                                </label>
                                <input type="file" 
                                       class="form-control @error('file_transkrip') is-invalid @enderror" 
                                       id="file_transkrip" 
                                       name="file_transkrip" 
                                       accept=".pdf" 
                                       required>
                                <small class="text-muted">Maksimal 2MB</small>
                                @error('file_transkrip')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="file_ktp" class="form-label">
                                    <i class="fas fa-id-card"></i> KTP *
                                </label>
                                <input type="file" 
                                       class="form-control @error('file_ktp') is-invalid @enderror" 
                                       id="file_ktp" 
                                       name="file_ktp" 
                                       accept=".pdf,.jpg,.jpeg,.png" 
                                       required>
                                <small class="text-muted">PDF/JPG/PNG, Maksimal 2MB</small>
                                @error('file_ktp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="file_kk" class="form-label">
                                    <i class="fas fa-users"></i> Kartu Keluarga *
                                </label>
                                <input type="file" 
                                       class="form-control @error('file_kk') is-invalid @enderror" 
                                       id="file_kk" 
                                       name="file_kk" 
                                       accept=".pdf,.jpg,.jpeg,.png" 
                                       required>
                                <small class="text-muted">PDF/JPG/PNG, Maksimal 2MB</small>
                                @error('file_kk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('home') }}" class="btn btn-secondary me-md-2">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane"></i> Daftar Beasiswa
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection