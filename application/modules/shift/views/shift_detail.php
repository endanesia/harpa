
<form action="<?= site_url('shift/simpan_detail/'.$id) ?>" method="post">
    <?php foreach ($datanya as $dt) { ?>
        <div class="row form-group">
            
            <div class="col-md-2" align="right">
                <?php if ($dt->hari == 1) {
                    echo 'Senin';
                } elseif ($dt->hari == 2) { echo 'Selasa';}
                elseif ($dt->hari == 3) { echo 'Rabu';}
                elseif ($dt->hari == 4) { echo 'Kamis';}
                elseif ($dt->hari == 5) { echo 'Jumat';}
                elseif ($dt->hari == 6) { echo 'Sabtu';}
                elseif ($dt->hari == 7) { echo 'Minggu';}  ?>
            </div>
            <div class="col-md-2" align="right">
                Masuk
            </div>
            <div class="col-md-2">
                <input type="time" value="<?= $dt->jam_masuk ?>" class="form-control" name="masuk<?= $dt->id ?>">
            </div>
            <div class="col-md-2" align="right">
                Pulang
            </div>
            <div class="col-md-2">
                <input type="time" value="<?= $dt->jam_keluar ?>" class="form-control" name="keluar<?= $dt->id ?>">
            </div>
        </div>
    <?php } ?>
    <div class="row">
        <div class="col-md-12" align="center">
            <input type="submit" class="btn btn-primary" value="Simpan"> <a href="<?= site_url('shift') ?>" class="btn btn-warning"> Batal </a>
        </div>
    </div>
</form>