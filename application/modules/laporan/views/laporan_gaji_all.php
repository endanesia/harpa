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
						<th bgcolor="#999999">No</th>
						<th bgcolor="#999999">Keterangan</th>
						<th bgcolor="#999999">Dana</th>
						<th bgcolor="#999999">Fee Potongan</th>
						<th bgcolor="#999999">Total</th>
						<th bgcolor="#999999">Total</th>
						<th bgcolor="#999999">Bank</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i=1;
					$total=0;
						foreach ($dt as $dana) {
						$total=$total+$dana->jumlah;
					?>
						<tr>
							<td><?=$i;?></td>
							<td><?=$dana->nama_potongan;?></td>
							<td><?=$dana->jumlah;?></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>	
						</tr>
					<?php
						$i++;
						}
					?>
						<tr>
							<td colspan="2" align="center">TOTAL</td>
							<td><?=$total;?></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
				</tbody>
			</table>
		</div>
	</div>