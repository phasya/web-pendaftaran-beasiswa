@extends('layouts.admin')

@section('title', 'Detail Pendaftar')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-user"></i> Detail Pendaftar</h1>
    <a href="{{ route('admin.pendaftar.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-user"></i> Data Pendaftar</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Nama Lengkap:</strong></td>
                                <td>{{ $pendaftar->nama_lengkap }}</td>
                            </tr>
                            <tr>
                                <td><strong>NIM:</strong></td>
                                <td>{{ $pendaftar->nim }}</td>
                            </tr>
                            <tr>
                                <td><strong>Email:</strong></td>
                                <td>{{ $pendaftar->email }}</td>
                            </tr>
                            <tr>
                                <td><strong>No. HP:</strong></td>
                                <td>{{ $pendaftar->no_hp }}</td>
                            </tr>
                            <tr>
                                <td><strong>Fakultas:</strong></td>
                                <td>{{ $pendaftar->fakultas }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Jurusan:</strong></td>
                                <td>{{ $pendaftar->jurusan }}</td>
                            </tr>
                            <tr>
                                <td><strong>Semester:</strong></td>
                                <td>{{ $pendaftar->semester }}</td>
                            </tr>
                            <tr>
                                <td><strong>IPK:</strong></td>
                                <td><span class="badge bg-info">{{ $pendaftar->ipk }}</span></td>
                            </tr>
                            <tr>
                                <td><strong>Tanggal Daftar:</strong></td>
                                <td>{{ $pendaftar->created_at->format('d M Y H:i') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Status:</strong></td>
                                <td>
                                    @if($pendaftar->status == 'pending')
                                        <span class="badge bg-warning">
                                            <i class="fas fa-clock"></i> Pending
                                        </span>
                                    @elseif($pendaftar->status == 'diterima')
                                        <span class="badge bg-success">
                                            <i class="fas fa-check"></i> Diterima
                                        </span>
                                    @else
                                        <span class="badge bg-danger">
                                            <i class="fas fa-times"></i> Ditolak
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="mt-4">
                    <h6><strong>Beasiswa yang Dilamar:</strong></h6>
                    <div class="alert alert-light">
                        <h6>{{ $pendaftar->beasiswa->nama_beasiswa }}</h6>
                        <p class="mb-1">{{ $pendaftar->beasiswa->deskripsi }}</p>
                        <small class="text-muted">
                            Dana: Rp {{ number_format($pendaftar->beasiswa->jumlah_dana, 0, ',', '.') }}
                        </small>
                    </div>
                </div>

                <div class="mt-4">
                    <h6><strong>Alasan Mendaftar:</strong></h6>
                    <div class="bg-light p-3 rounded">
                        {{ $pendaftar->alasan_mendaftar }}
                    </div>
                </div>

                <div class="mt-4">
                    <h6><strong>Dokumen:</strong></h6>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    <i class="fas fa-file-pdf fa-2x text-danger mb-2"></i>
                                    <h6>Transkrip Nilai</h6>
                                    <a href="{{ asset('storage/documents/' . $pendaftar->file_transkrip) }}" 
                                       target="_blank" 
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-download"></i> Lihat
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    <i class="fas fa-id-card fa-2x text-primary mb-2"></i>
                                    <h6>KTP</h6>
                                    <a href="{{ asset('storage/documents/' . $pendaftar->file_ktp) }}" 
                                       target="_blank" 
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-download"></i> Lihat
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    <i class="fas fa-users fa-2x text-success mb-2"></i>
                                    <h6>Kartu Keluarga</h6>
                                    <a href="{{ asset('storage/documents/' . $pendaftar->file_kk) }}" 
                                       target="_blank" 
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-download"></i> Lihat
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow">
            <div class="card-header bg-warning text-white">
                <h5 class="mb-0"><i class="fas fa-cogs"></i> Aksi</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.pendaftar.update-status', $pendaftar) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    
                    <div class="mb-3">
                        <label class="form-label"><strong>Update Status:</strong></label>
                        <select name="status" class="form-select" required>
                            <option value="pending" {{ $pendaftar->status == 'pending' ? 'selected' : '' }}>
                                Pending
                            </option>
                            <option value="diterima" {{ $pendaftar->status == 'diterima' ? 'selected' : '' }}>
                                Diterima
                            </option>
                            <option value="ditolak" {{ $pendaftar->status == 'ditolak' ? 'selected' : '' }}>
                                Ditolak
                            </option>
                        </select>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Status
                        </button>
                    </div>
                </form>

                <hr>

                <div class="d-grid">
                    <form action="{{ route('admin.pendaftar.destroy', $pendaftar) }}" 
                          method="POST" 
                          onsubmit="return confirm('Yakin ingin menghapus data pendaftar ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i> Hapus Data
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="card shadow mt-3">
            <div class="card-header bg-info text-white">
                <h6 class="mb-0"><i class="fas fa-info-circle"></i> Statistik</h6>
            </div>
            <div class="card-body">
                <small class="text-muted">
                    <strong>Total Pendaftar untuk Beasiswa ini:</strong><br>
                    {{ $pendaftar->beasiswa->pendaftars->count() }} orang
                </small>
            </div>
        </div>
    </div>
</div>
@endsection