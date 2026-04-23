<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Data_PKWT_Berakhir.xls");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
?>
<h2 align="center">Data PKWT Yang Akan Berakhir</h2>
<div class="card card-body">
    <div class="row">
        <div class="col-md-12">
            <table border="1">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIP</th>
                        <th>Nama Pegawai</th>
                        <th>Unit Kerja</th>
                        <th>Jabatan</th>
                        <th>Kontrak</th>
                        <th>Berakhir</th>
                        <th>Durasi </th>
                        <th>Kompensasi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $dt = $this->Access_model->ex_pkwt()->result();
                    //print_r($dt);
                    // Uncomment the line below to see the data structure
                    $no = 1;
                    foreach($dt as $row) { 
                        $now = time();
                        $end = strtotime($row->akhir_kontrak);
                        $datediff = $end - $now;
                        $days = round($datediff / (60 * 60 * 24));
                        $unit = $this->Access_model->unit_id($row->skpd)->row();
                        // Calculate compensation
                        $start = strtotime($row->awal_kontrak);
                        $duration_months = round(($end - $start) / (60 * 60 * 24 * 30));
                        $umk = $this->Access_model->GetUmk($row->skpd, date('Y'))->row();
                        $kompensasi = isset($umk) ? ($umk->nilaiUmk/12) * $duration_months : 0;
                    ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $row->nipBaru ?></td>
                        <td><?= $row->namaPegawai ?></td>
                        <td><?= $unit->nama ?></td>
                        <td><?= $row->jabatan ?></td>
                        <td><?= date('d-m-Y', strtotime($row->awal_kontrak)) ?></td>
                        <td><?= date('d-m-Y', strtotime($row->akhir_kontrak)) ?></td>
                        <td><?= $duration_months ?> Bulan</td>
                        <td><?= number_format($kompensasi,0,',','.') ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>