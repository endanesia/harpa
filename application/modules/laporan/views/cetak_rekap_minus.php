<div class="row">
    <div class="col-md-4">

    </div>
    <div class="col-md-4">
        Proses rekap data gaji pegawai bulan <?=$bulan?> / <?= $tahun ?> telah selesai <br>
        Silahkan klik download untuk mendapatkan laporan dalam bentuk excel <br>
        <a href="<?= site_url('laporan/download_rekap_minus/' . $bulan . '/' . $tahun) ?>" class="btn btn-info btn-sm"><i class="fa fa-download"></i> Download</a>
    </div>
    <div class="col-md-4">

    </div>
</div>

