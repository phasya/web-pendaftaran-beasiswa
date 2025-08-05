@extends('layouts.admin')

@section('title', 'Tambah Beasiswa')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-plus"></i> Tambah Beasiswa</h1>
</div>

<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-graduation-cap"></i> Form Tambah Beasiswa</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.beasiswa.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="nama_beasiswa" class="form-label">
                            <i class="fas fa-trophy"></i> Nama Beasiswa *
                        </label>
                        <input type="text" 
                               class="form-control @error('nama_beasiswa') is-invalid @enderror" 
                               id="nama_beasiswa" 
                               name="nama_beasiswa" 
                               value="{{ old('nama_beasiswa') }}" 
                               required>
                        @error('nama_beasiswa')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">
                            <i class="fas fa-align-left"></i> Deskripsi *
                        </label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                  id="deskripsi" 
                                  name="deskripsi" 
                                  rows="4" 
                                  required>{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="jumlah_dana" class="form-label">
                            <i class="fas fa-money-bill-wave"></i> Jumlah Dana (Rp) *
                        </label>
                        <input type="number" 
                               class="form-control @error('jumlah_dana') is-invalid @enderror" 
                               id="jumlah_dana" 
                               name="jumlah_dana" 
                               value="{{ old('jumlah_dana') }}" 
                               min="0" 
                               required>
                        @error('jumlah_dana')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_buka" class="form-label">
                                <i class="fas fa-calendar-plus"></i> Tanggal Buka *
                            </label>
                            <input type="date" 
                                   class="form-control @error('tanggal_buka') is-invalid @enderror" 
                                   id="tanggal_buka" 
                                   name="tanggal_buka" 
                                   value="{{ old('tanggal_buka') }}" 
                                   required>
                            @error('tanggal_buka')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="tanggal_tutup" class="form-label">
                                <i class="fas fa-calendar-times"></i> Tanggal Tutup *
                            </label>
                            <input type="date" 
                                   class="form-control @error('tanggal_tutup') is-invalid @enderror" 
                                   id="tanggal_tutup" 
                                   name="tanggal_tutup" 
                                   value="{{ old('tanggal_tutup') }}" 
                                   required>
                            @error('tanggal_tutup')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">
                            <i class="fas fa-toggle-on"></i> Status *
                        </label>
                        <select class="form-select @error('status') is-invalid @enderror" 
                                id="status" 
                                name="status" 
                                required>
                            <option value="">Pilih Status</option>
                            <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="persyaratan" class="form-label">
                            <i class="fas fa-list-check"></i> Persyaratan *
                        </label>
                        <textarea class="form-control @error('persyaratan') is-invalid @enderror" 
                                  id="persyaratan" 
                                  name="persyaratan" 
                                  rows="6" 
                                  required>{{ old('persyaratan') }}</textarea>
                        @error('persyaratan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('admin.beasiswa.index') }}" class="btn btn-secondary me-md-2">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection