<section class="content">

    <div class="container-fluid">

        <div class="row">

            <div class="col-md-12">

                <?php if ($this->session->flashdata('errMsg')) { ?>

                    <div class="alert alert-danger">

                        <?= $this->session->flashdata('errMsg'); ?>

                    </div>

                <?php } ?>

            </div>

            <div class="col-lg-3 col-6">

                <div class="small-box bg-info">

                    <div class="inner">

                        <h3><?= $pegawai ?></h3>

                        <p>Jml Pegawai</p>

                    </div>

                    <div class="icon">

                        <i class="ion ion-bag"></i>

                    </div>

                    <?php if ($this->access->boleh(1)) { ?>

                        <a href="<?= site_url('pegawai') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>

                    <?php } ?>

                </div>

            </div>



            <div class="col-lg-3 col-6">

                <div class="small-box bg-success">

                    <div class="inner">

                        <h3><?= $satkerja ?><sup style="font-size: 20px"></sup></h3>

                        <p>Jml Unit kerja</p>

                    </div>

                    <div class="icon">

                        <i class="ion ion-stats-bars"></i>

                    </div>

                    <?php if ($this->access->boleh(20)) { ?>

                        <a href="<?= site_url('lokasi') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>

                    <?php } ?>

                </div>

            </div>

            <div class="col-lg-3 col-6">

                <div class="small-box bg-danger">

                    <div class="inner">

                        <h3><?php echo $this->Access_model->ex_lisensi()->num_rows(); ?></h3>

                        <p>Lisensi Pegawai yg Hampir habis</p>

                    </div>

                    <div class="icon">

                        <i class="ion ion-pie-graph"></i>

                    </div>

                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>

                </div>

            </div>

            <div class="col-lg-3 col-6">

                <div class="small-box bg-warning">

                    <div class="inner">

                        <h3><?= $user ?></h3>

                        <p>User yang terdaftar</p>

                    </div>

                    <div class="icon">

                        <i class="ion ion-person-add"></i>

                    </div>

                    <?php if ($this->access->boleh(26)) { ?>

                        <a href="<?= site_url('users') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>

                    <?php } ?>

                </div>

            </div>

            <div class="col-lg-3 col-6">

                <div class="small-box bg-primary">

                    <div class="inner">

                    <p>Peringatan Kehadiran Satu Minggu Kebelakang</p>

                    </div>

                    <div class="icon">

                        <i class="ion ion-clipboard"></i>

                    </div>

                    <a href="<?= site_url('dashboard/absen_mingguan') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>

                </div>

            </div>

        </div>

        <div class="row">

            <div class="col-md-6">

                <!-- TABLE: Lisensi Expired -->

                <div class="card">

                    <div class="card-header border-transparent">

                        <h3 class="card-title"><b>Lisensi Pegawai yg Hampir habis</b></h3>



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

                            <?php

                            echo $ex = strtotime(date("d m Y", strtotime(date("d m Y"))) . "+3 months");

                            ?>

                            <table class="table m-0">

                                <thead>

                                    <tr>

                                        <th>Nama</th>

                                        <th>Unit</th>

                                        <th>Status Lisensi</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    <?php

                                    foreach ($expire as $dt_ex) {

                                        $peg = $this->Access_model->pegawai_id($dt_ex->idPegawai)->row();

                                        $unit = $this->Access_model->unit_id($peg->skpd)->row();

                                        $datetime1 = date("d-m-Y");

                                        $datetime2 = date("d-m-Y", strtotime($dt_ex->sampai));

                                        $df = (strtotime($datetime2) - strtotime($datetime1));

                                        $selisih = $df / (60 * 60) / 24;

                                    ?>

                                        <tr>

                                            <td><?php echo $peg->namaPegawai; ?><br><small><a href="<?php echo site_url() . '/pegawai/Lisensi/' . $dt_ex->idPegawai . '/0/0'; ?>"><?php echo $peg->nipBaru; ?></a></small></td>

                                            <td><?php echo $unit->nama; ?></td>

                                            <td>

                                                <?php

                                                if ($selisih < 0) {

                                                ?>

                                                    <span class="badge badge-danger"><?php echo  "Expired"; ?></span>

                                                <?php

                                                } else {

                                                ?>

                                                    <span class="badge badge-warning"><?php echo  "Segera Diperbaharui"; ?></span>

                                                <?php

                                                }

                                                ?><br><small>

                                                    <?php echo date("d-m-Y", strtotime($dt_ex->sampai)); ?></small>

                                            </td>

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

            <div class="col-md-6">

                <!-- TABLE: PKWT Ending Soon -->

                <div class="card">

                    <div class="card-header border-transparent">

                        <h3 class="card-title"><b>Kontrak PKWT yang Akan Berakhir</b></h3>

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
                        <a href="<?php echo site_url('pegawai/export_pkwt'); ?>" class="btn btn-success btn-sm pull-right" style="margin-right: 20px;"><i class="fa fa-file-excel-o"></i> Export Excel</a>
                        <div style="height:50px;">.</div>
                        <div class="table-responsive">

                            <table class="table m-0">

                                <thead>

                                    <tr>

                                        <th>Nama</th>

                                        <th>Unit</th>

                                        <th>Tanggal Berakhir</th>

                                        <th>Durasi (Bulan)</th>

                                        <th>Kompensasi</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    <?php

                                    foreach ($expire_pkwt as $pkwt) {

                                        $unit = $this->Access_model->unit_id($pkwt->skpd)->row();

                                        $datetime1 = date("d-m-Y");

                                        $datetime2 = date("d-m-Y", strtotime($pkwt->akhir_kontrak));

                                        $df = (strtotime($datetime2) - strtotime($pkwt->awal_kontrak));

                                        $durasi = round($df / (60 * 60 * 24 * 30)); // Convert to months

                                        // Get UMK value

                                        $dtUmk = $this->Access_model->GetUmk($pkwt->skpd, date('Y'))->row();

                                        $umk = isset($dtUmk) ? $dtUmk->nilaiUmk : 0;

                                        $kompensasi = ($umk/12) * $durasi;

                                    ?>

                                        <tr>

                                            <td><?php echo $pkwt->namaPegawai; ?><br><small><?php echo $pkwt->nipBaru; ?></small></td>

                                            <td><?php echo $unit->nama; ?></td>

                                            <td>

                                                <?php

                                                if ($selisih < 0) {

                                                ?>

                                                    <span class="badge badge-danger"><?php echo "Kontrak Berakhir"; ?></span>

                                                <?php

                                                } else {

                                                ?>

                                                    <span class="badge badge-warning"><?php echo "Akan Berakhir"; ?></span>

                                                <?php

                                                }

                                                ?><br><small>

                                                    <?php echo date("d-m-Y", strtotime($pkwt->akhir_kontrak)); ?></small>

                                            </td>

                                            <td><?php echo $durasi; ?></td>

                                            <td>Rp. <?php echo number_format($kompensasi,0,',','.'); ?></td>

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

        </div>

</section>

