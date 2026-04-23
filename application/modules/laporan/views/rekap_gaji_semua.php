<?php
if (!empty($error)) {
?>
  <div class="alert alert-danger">
    Gagal Simpan ! Unit Kerja belum dipilih
  </div>
<?php
}


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
            <th><?= $dt[0]['nik'] ?></th>
            <th><?= $dt[0]['nama'] ?></th>
            <th><?= $dt[0]['unit_kerja'] ?></th>
            <th><?= $dt[0]['jabatan'] ?></th>
            <th><?= $dt[0]['gaji_pokok'] ?></th>
            <th><?= $dt[0]['tunj_tetap'] ?></th>
            <?php
            for ($x = 1; $x <= 30; $x++) {
              if ($dt[0]['f' . $x] != '') {
                echo "<th>" . $dt[0]['f' . $x] . "</th>";
                if ($dt[0]['f' . $x] == 'GAJI KOTOR') {
                  $batas_gaji = $x;
                }
                if ($dt[0]['f' . $x] == 'Total Potongan') {
                  $batas_pot = $x;
                }
              }
            }
            ?>
            <th>NOREK</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i = 1;
          foreach ($dt as $pegawai) {
            if ($pegawai['nik'] != 'NIK') {
          ?>
              <tr>
                <td><?= $i ?></td>
                <td><?= $pegawai['nik'] ?></td>
                <td><?= $pegawai['nama'] ?></td>
                <td><?= $pegawai['unit_kerja'] ?></td>
                <td><?= $pegawai['jabatan'] ?></td>
                <td><?= $pegawai['gaji_pokok'] ?></td>
                <td><?= $pegawai['tunj_tetap'] ?></td>
                <?php
                $gajiKotor = intval($pegawai['gaji_pokok']) + intval($pegawai['tunj_tetap']);
                $potongan = 0;
                for ($x = 1; $x <= 30; $x++) {
                  if ($pegawai['f' . $x] != '') {
                    if ($x == $batas_gaji) {
                      echo "<td>" . $gajiKotor . "</td>";
                    } elseif ($x == $batas_pot) {
                      echo "<td>" . $potongan . "</td>";
                    } elseif ($x == $batas_pot + 1) {
                      $total = $gajiKotor - $potongan;
                      echo "<td>" . $total . "</td>";
                    } else { 
                      echo "<td>" . $pegawai['f' . $x] . "</td>";
                    }

                    if ($x < $batas_gaji) {
                      $gajiKotor = $gajiKotor + intval($pegawai['f' . $x]);
                    }
                    if ($x > $batas_gaji && $x < $batas_pot) {
                      $potongan = $potongan + intval($pegawai['f' . $x]);
                    }
                  }
                }
                ?>
                <td><?= $pegawai['norek'] ?></td>
              </tr>
          <?php
              $i++;
            }
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>