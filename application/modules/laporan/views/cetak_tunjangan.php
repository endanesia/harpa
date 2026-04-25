<?php

if (!empty($error)) {
?>
  <div class="alert alert-danger">
    Gagal Simpan ! Unit Kerja belum dipilih
  </div>
<?php
}

//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//header('Content-Disposition: attachment; filename="' . $title . '.xlsx"');

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=" . $title . ".xls");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
$gajiKotor = 0;
$potongan = 0;
$batas_gaji = 0;
$batas_pot = 0;
?>
<h2 align="center"><?= $title; ?></h2>
<div class="card card-body">
  <div class="row">
    <div class="col-md-12">
      <table border="1">
        <thead>
          <tr>
            <th>NO</th>
            <th>NIP</th>
            <th>NAMA</th>
            <th>UNIT KERJA</th>
            <th>JABATAN</th>
            <th>TGL BERGABUNG</th>
            <th>MASA KERJA</th>
            <th>NILAI TUNJANGAN</th>
            <th>NOREK</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i = 1;
          $total = 0;
          foreach ($dt as $pegawai) {
          ?>
              <tr>
                <td><?= $i ?></td>
                <td><?= $pegawai->nip ?></td>
                <td><?= $pegawai->namaPegawai ?></td>
                <td><?= $pegawai->nama_unit ?></td>
                <td><?= $pegawai->jabatan ?></td>
                <td><?= $pegawai->tglBergabung ?></td>
                <?php
                    $gabung = $pegawai->tglBergabung;
                    $sekarang = date('Y-m-d');

                    $diff = abs(strtotime($sekarang)-strtotime($gabung));

                    $days = $diff/(60*60*24);

                    $masa_kerja_thn = intdiv($days,365);
                    $sisa = $days%356;
                    $masa_kerja_bulan = intdiv($sisa, 30);
                    if ($masa_kerja_thn == 0) {
                        echo '<td>' . $masa_kerja_bulan . ' bulan</td>';
                    } else {
                        echo '<td>' . $masa_kerja_thn . ' tahun ' . $masa_kerja_bulan . ' bulan</td>';
                    }
                ?>
                <td><?= round($pegawai->jml) ?></td>
                <td><?= $pegawai->norek ?></td>
              </tr>
          <?php
              $i++;
              $total += round($pegawai->jml);
          }
          ?>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="7" align="right"><strong>TOTAL</strong></td>
            <td><strong><?= round($total) ?></strong></td>
            <td></td>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>