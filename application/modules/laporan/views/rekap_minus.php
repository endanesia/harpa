<div class="row">
    <div class="col-md-4">

    </div>
    <div class="col-md-4">
        <?php 
            $proses = $halaman * 10;
            $next = $halaman + 1;
        ?>
        <img src="<?= base_url() ?>loading.gif" height="32px"> <?= $proses ?> data telah diproses <br>
        <small><i><b>Perhatian !</b> jangan tutup halaman ini sampai proses selesai</i></small>
    </div>
    <div class="col-md-4">

    </div>
</div>

<script>
    $(document).ready(function() {
        console.log("ready!");
        setTimeout(function() {
            window.location.href = "<?= site_url('laporan/hitung_minus/') . $bln . "/" . $thn . "/" . $next ?>";
        }, 2000);
    });
</script>