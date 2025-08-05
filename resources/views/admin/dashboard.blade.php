@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-tachometer-alt"></i> Dashboard</h1>
</div>

<!-- Cards Row -->
<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Beasiswa
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalBeasiswa ?? 0 }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-graduation-cap fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Beasiswa Aktif
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $beasiswaAktif ?? 0 }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Total Pendaftar
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPendaftar ?? 0 }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Menunggu Review
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pendaftarPending ?? 0 }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clock fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Status dan Menu Row -->
<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-chart-pie"></i> Status Pendaftar
                </h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-4">
                        <div class="text-warning">
                            <i class="fas fa-clock fa-2x mb-2"></i>
                            <div>
                                <strong class="h4">{{ $pendaftarPending ?? 0 }}</strong><br>
                                <small>Pending</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="text-success">
                            <i class="fas fa-check-circle fa-2x mb-2"></i>
                            <div>
                                <strong class="h4">{{ $pendaftarDiterima ?? 0 }}</strong><br>
                                <small>Diterima</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="text-danger">
                            <i class="fas fa-times-circle fa-2x mb-2"></i>
                            <div>
                                <strong class="h4">{{ $pendaftarDitolak ?? 0 }}</strong><br>
                                <small>Ditolak</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-bolt"></i> Menu Cepat
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.beasiswa.create') }}" class="btn btn-success">
                        <i class="fas fa-plus-circle"></i> Tambah Beasiswa Baru
                    </a>
                    <a href="{{ route('admin.beasiswa.index') }}" class="btn btn-primary">
                        <i class="fas fa-graduation-cap"></i> Kelola Beasiswa
                    </a>
                    <a href="{{ route('admin.pendaftar.index') }}" class="btn btn-info">
                        <i class="fas fa-users"></i> Kelola Pendaftar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Welcome Message jika tidak ada data -->
@if($totalBeasiswa == 0)
<div class="row">
    <div class="col-12">
        <div class="alert alert-info text-center" role="alert">
            <i class="fas fa-info-circle fa-2x mb-3"></i>
            <h4>Selamat Datang di Admin Panel!</h4>
            <p>Belum ada data beasiswa. Silakan tambah beasiswa pertama Anda.</p>
            <a href="{{ route('admin.beasiswa.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Beasiswa Pertama
            </a>
        </div>
    </div>
</div>
@endif
@endsection

@section('scripts')
<style>
.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}
.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}
.border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
}
.border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
}
.text-gray-300 {
    color: #dddfeb !important;
}
.text-gray-800 {
    color: #5a5c69 !important;
}
</style>
@endsection