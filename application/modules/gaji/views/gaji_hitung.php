<div class="card card-body">
	<div class="row">
		<div class="col-sm-12 col-md-12 text-md-right">
			<form method="post">
			<table>
				<tr>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bulan :</td>
					<td>
						<select name="bulan" class="form-control">
							<option value="01" <?= $bulan == "01" ? ' selected ' : '' ?>>Januari</option>
							<option value="02" <?= $bulan == "02" ? ' selected ' : '' ?>>Februari</option>
							<option value="03" <?= $bulan == "03" ? ' selected ' : '' ?>>Maret</option>
							<option value="04" <?= $bulan == "04" ? ' selected ' : '' ?>>April</option>
							<option value="05" <?= $bulan == "05" ? ' selected ' : '' ?>>Mei</option>
							<option value="06" <?= $bulan == "06" ? ' selected ' : '' ?>>Juni</option>
							<option value="07" <?= $bulan == "07" ? ' selected ' : '' ?>>Juli</option>
							<option value="08" <?= $bulan == "08" ? ' selected ' : '' ?>>Agustus</option>
							<option value="09" <?= $bulan == "09" ? ' selected ' : '' ?>>September</option>
							<option value="10" <?= $bulan == "10" ? ' selected ' : '' ?>>Oktober</option>
							<option value="11" <?= $bulan == "11" ? ' selected ' : '' ?>>November</option>
							<option value="12" <?= $bulan == "12" ? ' selected ' : '' ?>>Desember</option>
						</select>
					</td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tahun :</td>
					<td>
						<select name="tahun" class="form-control">
							<?php
							$cth = date('Y');
							if (date('m')==12) {
								$cth = date('Y')+1;									
							}
							for ($x = $cth; $x >= 2023; $x--) {
if ($tahun == $x) {
    ?>
								<option value="<?= $x ?>" selected><?= $x ?></option>
							<?php } else { ?>
								<option value="<?= $x ?>" ><?= $x ?></option>
							<?php } } ?>
						</select>
					</td>
					<td>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button class="btn btn-primary" type="submit"><i class="fa fa-search"></i> Filter</button>
					</td>
				</tr>
			</table>
			</form>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-md-12">
			
			<table class="table table-striped" id="example1">
				<thead>
					<tr>
						<th>Unit</th>
						<th>Periode Gaji</th>
						<th>Hitung</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				<?php
				foreach($satkerja as $unit)
				{
				?>
				<tr>
						<td><?php echo $unit->nama;?></td>
						<?php
						if(isset($this->session->filter_bulan) OR isset($this->session->filter_tahun))
						{
						?>
						<td><?php echo $this->session->filter_bulan.'/'.$this->session->filter_tahun;?></td>
						<?php
						}
						else
						{
						?>
						<td><?php echo date('m').'/'.date('Y');?></td>
						<?php	
						}
						?>
						<td>
							<a href="" title="hitung gaji" data-toggle="modal" data-target="#modalProses" class="btn btn-xs btn-primary" onclick="SetLink1(<?= $unit->id ?>)"><i class="fa fa-gear "></i> Hitung Tunjangan & potongan</a>
						</td>
						<td>
							<?php
							$dt = $this->gaji_model->cek_riwayat_gaji($bulan,$tahun,$unit->id)->result();
							if (count($dt) >0 && $dt[0]->jml > 0) {
								echo $dt[0]->jml . " orang telah diproses";
							} else {
								echo "-";
							}
							?>
						</td>
					</tr>
				<?php
				}
				?>
				</tbody>
			</table>
		</div>
	</div>

</div>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal label" aria-hidden="true" id="modalProses" data-backdrop="static">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalTitle_kelasjabatan">Proses Hitung Gaji</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= site_url('kelasjabatan/Hapus') ?>" method="post">
				<input type="hidden" name="idhapus" id="idhapus">
				<div class="modal-body">
					<b>Silahkan Klik tombol proses, dan jangan tutup halaman ini sampai proses selesai</b>
					<a href="" id="link1" title="hitung gaji" class="btn btn-xs btn-primary" onclick="LoadIcon()"><i class="fa fa-gear "></i> Proses Sekarang !</a>
					<img src="<?= base_url() ?>loading.gif" height="24px" style="display:none" id="icon1">
				</div>
				<div class="modal-footer">
					
					<button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><span class="fa fa-times"></span> Batal</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
	function SetLink1(id) {
		const l = document.getElementById('link1');
		l.setAttribute('href',"<?php echo site_url() . '/gaji/hitung_gaji/';?>"+id)
	}
	function SetLink2(id) {
		const l = document.getElementById('link2');
		l.setAttribute('href',"<?php echo site_url() . '/gaji/hitung_premishift/';?>"+id)
	}
	function LoadIcon() {
		const icon1 = document.getElementById("icon1")
		const icon2 = document.getElementById("icon2")
		icon1.style.display="inline";
		icon2.style.display="inline";
	}
</script>