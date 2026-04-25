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
						<th bgcolor="#999999">Unit</th>
						<th bgcolor="#999999">Jumlah Pegawai</th>
						<?php
						foreach($kolom as $kol)
						{
						?>
						<th bgcolor="#999999"><?=$kol->kodeKelas; ?></th>
						<?php
						}
						?>
						<th bgcolor="#999999">Jumlah diterima</th>
						<th bgcolor="#999999">Ket</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i=1;
					$kls='';
					$pegawai=0;
					$tunj=0;
					$tj=0;
					foreach($dt as $tkk)
					{
					?>
					<tr>
						<td><?=$i;?></td>
						<td><?=$tkk->nama;?></td>
						<td><?=$tkk->JumlahPegawai.' Orang';?></td>
						<?php
						$koltotal=0;
						foreach($kolom as $kol)
						{
							$isikol=$this->Laporan_model->tunjangan_tkk_kelas($bln, $thn,$tkk->nama,$kol->kodeKelas)->row();
							if(isset($isikol))
							{
						?>
								<td><?=$isikol->Tunjangan;?></td>
						<?php
								$tunj=$tunj+$isikol->Tunjangan;
								$tj=$tj+$isikol->Tunjangan;
								$totalTunj=$isikol->Tunjangan;
							}
							else
							{
							?>	
								<td></td>
							<?php
								$tunj=$tunj;	
							}
						}
						$ktotal=$koltotal
						?>
						<td bgcolor="#999999"><?=$tunj?></td>
						<td>Transfer</td>
					</tr>
					<?php
					$tunj=0;
					$i++;
					$pegawai=$pegawai+$tkk->JumlahPegawai;
					}
					?>
					<tr>
						<td colspan="2">Total TKK</td>
						<td><?=$pegawai.' Orang'?></td>
						<?php
						foreach($kolom as $kol)
						{
						$totalk=$this->Laporan_model->total_kolom_tkkunit($bln, $thn,$kol->kodeKelas)->row();
						?>
						<td><?= $totalk->Tunjangan;?></td>
						<?php
						}
						?>
						<td bgcolor="#999999"><?=$tj?></td>
						<td></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>