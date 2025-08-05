@extends('layouts.admin')

@section('title', 'Kelola Beasiswa')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-graduation-cap"></i> Kelola Beasiswa</h1>
    <a href="{{ route('admin.beasiswa.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Beasiswa
    </a>
</div>

<div class="card shadow">
    <div class="card-body">
        @if($beasiswas->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Beasiswa</th>
                            <th>Dana</th>
                            <th>Periode</th>
                            <th>Status</th>
                            <th>Pendaftar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($beasiswas as $index => $beasiswa)
                        <tr>
                            <td>{{ $beasiswas->firstItem() + $index }}</td>
                            <td>
                                <strong>{{ $beasiswa->nama_beasiswa }}</strong><br>
                                <small class="text-muted">{{ Str::limit($beasiswa->deskripsi, 50) }}</small>
                            </td>
                            <td>
                                <span class="text-success fw-bold">
                                    Rp {{ number_format($beasiswa->jumlah_dana, 0, ',', '.') }}
                                </span>
                            </td>
                            <td>
                                <small>
                                    {{ \Carbon\Carbon::parse($beasiswa->tanggal_buka)->format('d/m/Y') }}<br>
                                    {{ \Carbon\Carbon::parse($beasiswa->tanggal_tutup)->format('d/m/Y') }}
                                </small>
                            </td>
                            <td>
                                @if($beasiswa->status == 'aktif')
                                    @if($beasiswa->isActive())
                                        <span class="badge bg-success">
                                            <i class="fas fa-circle"></i> Aktif
                                        </span>
                                    @else
                                        <span class="badge bg-warning">
                                            <i class="fas fa-clock"></i> Berakhir
                                        </span>
                                    @endif
                                @else
                                    <span class="badge bg-secondary">
                                        <i class="fas fa-times"></i> Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-info">
                                    {{ $beasiswa->pendaftars->count() }} orang
                                </span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.beasiswa.show', $beasiswa) }}" 
                                       class="btn btn-info btn-sm" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.beasiswa.edit', $beasiswa) }}" 
                                       class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.beasiswa.destroy', $beasiswa) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus beasiswa ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-center">
                {{ $beasiswas->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-graduation-cap fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Belum ada beasiswa</h5>
                <p class="text-muted">Silakan tambah beasiswa baru</p>
                <a href="{{ route('admin.beasiswa.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Beasiswa
                </a>
            </div>
        @endif
    </div>
</div>
@endsection