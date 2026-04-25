<section class="content">

<div class="col-md-12">
    <!-- TABLE: Lisensi Expired -->
    <div class="card">
        <div class="card-header border-transparent">
            <h3 class="card-title"><b>Peringatan Kehadiran Satu Minggu Kebelakang</b></h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table m-0">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Unit</th>
                            <th>JML TK</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            foreach ($absen as $a) {
                                ?>
                                <tr>
                                    <td><?= $a->namaPegawai ?><br><small><?= $a->nipBaru ?></small></td>
                                    <td><?= $a->nama ?></td>
                                    <td><?= $a->jml ?></td>
                                </tr>
                                <?php
                            }
                        ?>
                    </tbody>
                </table>
            </div>
            <!-- /.table-responsive -->
        </div>
    </div>
</div>

</section>