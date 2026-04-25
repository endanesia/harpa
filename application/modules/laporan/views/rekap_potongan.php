<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card card-body">
            <form action="<?= site_url('laporan/potongan') ?>" method="post">
                <div class="form-group">
                    <label>Rekap Periode <?= $bln ?> / <?= $thn ?></label>
                    <label for="nama_tunjangan">Nama Potongan</label>
                    <input type="hidden" name="bulan" value="<?= $bln ?>">
                    <input type="hidden" name="tahun" value="<?= $thn ?>">
                    <select name="nama_tunjangan" class="form-control">
                        <?php
                        // Assuming you have a way to get the list of tunjangan names
                        // Replace this with your actual logic to fetch tunjangan names

                        foreach ($dt as $name) {
                            echo '<option value="' . $name->nama_potongan . '">' . $name->nama_potongan . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Download Excel</button>
            </form>
        </div>
    </div>
</div>

<script>
</script>
