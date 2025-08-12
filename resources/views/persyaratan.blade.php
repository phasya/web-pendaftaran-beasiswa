@extends('layouts.app')

@section('title', 'Persyaratan')

@section('content')
    <div class="container">
        <div class="jumbotron bg-primary text-white p-5 rounded">
                <h1 class="display-4">
                    <i class="fas fa-graduation-cap"></i> Persyaratan Pendaftaran Beasiswa
                </h1>
                <p class="lead">Temukan dan daftarkan diri Anda untuk berbagai program beasiswa yang tersedia</p>
                <hr class="my-4">
                <p>Jangan lewatkan kesempatan emas untuk meraih pendidikan yang lebih baik!</p>
            </div>
            <br>
        <p><h2>Ketentuan Persyaratan Umum:</h2> <br>
        <ul>
            <li>Setiap pendaftar wajib mengisi formulir pendaftaran dengan lengkap.</li>
            <li>Masing-masing peserta hanya diperkenankan memilih 1 (satu) kategori beasiswa.</li>
            <li>Data yang diisikan pada formulir pendaftaran harus sesuai dengan data asli.</li>
            <li>Beasiswa diberikan kepada siswa SMK reguler, minimal duduk di kelas XI (sebelas) dan maksimal kelas XII (dua belas).</li>
            <li>Wajib terdaftar sebagai siswa aktif SMK dari semua jurusan/program keahlian.</li>
            <li>Tidak sedang menerima beasiswa pendidikan dari lembaga/instansi/yayasan lain, dibuktikan dengan surat pernyataan bermaterai dari calon penerima beasiswa.</li>
            <li>Tidak sedang dikenakan sanksi pelanggaran tata tertib sekolah, dibuktikan dengan surat pernyataan bermaterai.</li>
            <li>Tidak sedang dalahukum atau mterlibat pelanggaran hukum lainnya, dibuktikan dengan surat pernyataan bermaterai.</li>
            <li>Proses seleksi dilakukan berdasarkan peringkat dan kelengkapan persyaratan yang telah ditentukan.</li>
        </ul>
        <p><strong>Ketentuan Persyaratan Khusus:</strong></p>
        <ul>
            <li>
            <strong>Beasiswa Daerah Operasional</strong>
            <ul>
                <li>Diprioritaskan bagi siswa yang berdomisili di wilayah sekitar operasional PT Antam, Tbk, dibuktikan dengan Kartu Tanda Penduduk (KTP) dan/atau Kartu Keluarga (KK).</li>
                <li>Memiliki rata-rata nilai rapor minimal 75 (tujuh puluh lima) pada semester terakhir.</li>
            </ul>
            </li>
            <li>
            <strong>Beasiswa Prestasi Akademik</strong>
            <ul>
                <li>Memiliki rata-rata nilai rapor minimal 85 (delapan puluh lima) pada semester terakhir.</li>
            </ul>
            </li>
            <li>
            <strong>Beasiswa Prestasi Non-Akademik</strong>
            <ul>
                <li>Memiliki prestasi non-akademik, dibuktikan dengan sertifikat prestasi minimal tingkat provinsi di bidang seni, agama, budaya, olahraga, atau teknologi.</li>
                <li>Memiliki rata-rata nilai rapor minimal 80 (delapan puluh) pada semester terakhir.</li>
            </ul>
            </li>
            <li>
            <strong>Beasiswa Kurang Mampu</strong>
            <ul>
                <li>Berasal dari keluarga dengan kondisi ekonomi tidak mampu, dibuktikan dengan surat keterangan tidak mampu dari RT/RW atau sekolah.</li>
                <li>Memiliki rata-rata nilai rapor minimal 75 (tujuh puluh lima) pada semester terakhir.</li>
            </ul>
            </li>
        </ul>
        Masing-masing peserta hanya diperkenankan memilih 1 (satu) kategori beasiswa.
        Data yang diisikan pada formulir pendaftaran harus sesuai dengan data asli.
        Beasiswa diberikan kepada siswa SMK reguler, minimal duduk di kelas XI (sebelas) dan maksimal kelas XII (dua belas).
        Wajib terdaftar sebagai siswa aktif SMK dari semua jurusan/program keahlian.
        Tidak sedang menerima beasiswa pendidikan dari lembaga/instansi/yayasan lain, dibuktikan dengan surat pernyataan
        bermaterai dari calon penerima beasiswa.
        Tidak sedang dikenakan sanksi pelanggaran tata tertib sekolah, dibuktikan dengan surat pernyataan bermaterai.
        Tidak sedang dalam proses hukum atau terlibat pelanggaran hukum lainnya, dibuktikan dengan surat pernyataan bermaterai.
        Proses seleksi dilakukan berdasarkan peringkat dan kelengkapan persyaratan yang telah ditentukan.
        Ketentuan Persyaratan Khusus:
        Beasiswa Daerah Operasional
        Diprioritaskan bagi siswa yang berdomisili di wilayah sekitar operasional PT Antam, Tbk, dibuktikan dengan Kartu Tanda
        Penduduk (KTP) dan/atau Kartu Keluarga (KK).
        Memiliki rata-rata nilai rapor minimal 75 (tujuh puluh lima) pada semester terakhir.
        Beasiswa Prestasi Akademik
        Memiliki rata-rata nilai rapor minimal 85 (delapan puluh lima) pada semester terakhir.
        Beasiswa Prestasi Non-Akademik
        Memiliki prestasi non-akademik, dibuktikan dengan sertifikat prestasi minimal tingkat provinsi di bidang seni, agama,
        budaya, olahraga, atau teknologi.
        Memiliki rata-rata nilai rapor minimal 80 (delapan puluh) pada semester terakhir.
        Beasiswa Kurang Mampu
        Berasal dari keluarga dengan kondisi ekonomi tidak mampu, dibuktikan dengan surat keterangan tidak mampu dari RT/RW atau
        sekolah.
        Memiliki rata-rata nilai rapor minimal 75 (tujuh puluh lima) pada semester terakhir.</p>
    </div>

    <div class="d-flex justify-content-center mb-4">
        <a href="{{ url('/') }}" class="btn btn-dark">Pendaftaran Beasiswa</a>
    </div>
@endsection