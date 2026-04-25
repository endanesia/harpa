<?php
if (!empty($error)) {
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
						<th>Jabatan</th>
						<th>Gaji Pokok</th>
						<?php foreach ($kolom as $kol) { ?>
							<th><?= $kol['nama_tunjangan']; ?></th>
						<?php } ?>
						<th>Jumlah</th>
					</tr>
				</thead>
				<tbody>
					<?php
					
					$i = 1;
					$to=0;
					$current_jabatan = "";
					foreach ($dt as $rs) {
						$to=0;
						if ($rs['jabatan'] != $current_jabatan) {
							$current_jabatan = $rs['jabatan'];
							$gj=$this->Laporan_model->gaji($rs['jabatan'])->row();
							echo "<tr>	<td>" . $i . "</td>
							<td> " . $rs['jabatan'] . " </td>
							<td>". $gj->gaji ."</td>";
							$to=$to+$gj->gaji;
							foreach ($kolom as $kol) {
								echo "<td>";
								foreach ($dt as $row) {
									if ($row['nama_tunjangan'] == $kol['nama_tunjangan'] && $row['jabatan'] == $rs['jabatan']) {
										echo $row['jumlah'];
										$to=$to+$row['jumlah'];
									}
								}
								echo "</td>";
							}
							?>
							<td><?=$to;?></td>
							<?php
							echo "</tr>";			
							$i++;
						}
					}
					?>
					
				</tbody>
			</table>
		</div>
	</div>
	<?php
	?>