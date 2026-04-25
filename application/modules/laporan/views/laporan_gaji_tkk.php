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
						<th>Jabatan</th>
						<th>Jumlah</th>
						<th>Nilai</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$tj=0;
					$terima=0;
					foreach($dt as $tkk)
					{
					?>
					<tr>
						<td><?=$tkk->jabatan;?></td>
						<td align="right"><?=$tkk->jumlah_jabatan;?></td>
						<td align="right"><?=$tkk->Tunjangan;?></td>
					</tr>
					<?php
						$tj=$tj+$tkk->jumlah_jabatan;
						$terima=$terima+$tkk->Tunjangan;
					} 
					?>
					<tr>
						<td align="center">TOTAL</td>
						<td><?=$tj;?></td>
						<td><?=$terima;?></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>