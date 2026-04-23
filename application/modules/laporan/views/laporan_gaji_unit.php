<?php 
if(!empty($error)){
?>
  <div class="alert alert-danger">      
    Gagal Simpan ! Unit Kerja belum dipilih
  </div>
<?php 
}
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=".$title.".xls");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
?>
<h2 align="center"><?=$title; ?></h2>
<div class="card card-body">
	<div class="row">
		<div class="col-md-12">
			<table border="1">
				<thead>
					<tr>
						<th>No</th>
						<th>Unit Kerja</th>
						<th>Upah Pokok</th>
						<?php foreach ($kolom as $kol) { ?>
							<th><?= $kol['nama_tunjangan']; ?></th>
						<?php } ?>
						<th>Total Potongan</th>
					</tr>
				</thead>
				<tbody>
				<?php
					$i = 1;
					$to=0;
					$tg=0;
					$tpot=0;
					$current_jabatan = "";
					foreach ($dt as $rs) {

						if ($rs['nama'] != $current_jabatan) {
							$current_jabatan = $rs['nama'];
							$gj=$this->Laporan_model->unit_gaji($rs['id'])->row();
							echo "<tr>	<td>" . $i . "</td>
							<td> " . $rs['nama'] . " </td>
							<td>". $gj->gaji ."</td>";
							foreach ($kolom as $kol) {
								echo "<td>";
								foreach ($dt as $row) {
									if ($row['nama_tunjangan'] == $kol['nama_tunjangan'] && $row['nama'] == $rs['nama']) {
										echo $row['jumlah'];
										$to=$to+$row['jumlah'];
									}
								}
								echo "</td>";
							}
							?>
							<td><?=$to;?></td>
							<?php
							$tpot=$tpot+$to;
							$to=0;
							$i++;
							?>
							<?php
							echo "</tr>";
						}
							
					}
					?>
					<tr>
						<td colspan="2" align="center">TOTAL</td>
						<td><?=$tg;?></td>
						<?php foreach ($kolom as $kol) { ?>
							<?php
							$total=$this->Laporan_model->lap_unit_total($bln, $thn, $kol['nama_tunjangan'])->row();
							?>
							<td><?= $total->jumlah; ?></td>
						<?php } ?>
						<td><?=$tpot;?></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>