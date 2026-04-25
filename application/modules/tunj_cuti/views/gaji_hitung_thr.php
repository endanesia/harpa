<div class="card card-body">
	<div class="row">
		<div class="col-sm-12 col-md-12 text-md-right">
		<form action="<?php echo site_url() . '/gaji/hitung_thr' ?>" method="post">
				<table>
					<tr>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bulan :</td>
						<td>
							<select name="bulan" class="form-control">
								<?php
								if ($bulan == "01") {
								?>
									<option value="01" selected="selected">Januari</option>
								<?php
								} else {
								?>
									<option value="01">Januari</option>
								<?php
								}
								?>
								<?php
								if ($bulan == "02") {
								?>
									<option value="02" selected="selected">Februari</option>
								<?php
								} else {
								?>
									<option value="02">Februari</option>
								<?php
								}
								?>
								<?php
								if ($bulan == "03") {
								?>
									<option value="03" selected="selected">Maret</option>
								<?php
								} else {
								?>
									<option value="03">Maret</option>
								<?php
								}
								?>
								<?php
								if ($bulan == "04") {
								?>
									<option value="04" selected="selected">April</option>
								<?php
								} else {
								?>
									<option value="04">April</option>
								<?php
								}
								?>
								<?php
								if ($bulan == "05") {
								?>
									<option value="05" selected="selected">Mei</option>
								<?php
								} else {
								?>
									<option value="05">Mei</option>
								<?php
								}
								?>
								<?php
								if ($bulan == "06") {
								?>
									<option value="06" selected="selected">Juni</option>
								<?php
								} else {
								?>
									<option value="06">Juni</option>
								<?php
								}
								?>
								<?php
								if ($bulan == "07") {
								?>
									<option value="07" selected="selected">Juli</option>
								<?php
								} else {
								?>
									<option value="07">Juli</option>
								<?php
								}
								?>
								<?php
								if ($bulan == "08") {
								?>
									<option value="08" selected="selected">Agustus</option>
								<?php
								} else {
								?>
									<option value="08">Agustus</option>
								<?php
								}
								?>
								<?php
								if ($bulan == "09") {
								?>
									<option value="09" selected="selected">September</option>
								<?php
								} else {
								?>
									<option value="09">September</option>
								<?php
								}
								?>
								<?php
								if ($bulan == "10") {
								?>
									<option value="10" selected="selected">Oktober</option>
								<?php
								} else {
								?>
									<option value="10">Oktober</option>
								<?php
								}
								?>
								<?php
								if ($bulan == "11") {
								?>
									<option value="11" selected="selected">November</option>
								<?php
								} else {
								?>
									<option value="11">November</option>
								<?php
								}
								?>
								<?php
								if ($bulan == "12") {
								?>
									<option value="12" selected="selected">Desember</option>
								<?php
								} else {
								?>
									<option value="12">Desember</option>
								<?php
								}
								?>
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
									if ($this->session->filter_tahun == $x) {
								?>
										<option value="<?= $x ?>" selected="selected"><?= $x ?></option>
									<?php
									} else {
									?>
										<option value="<?= $x ?>"><?= $x ?></option>
								<?php
									}
								}
								?>
							</select>
						</td>
						<td>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button class="btn btn-primary"><i class="fa fa-search"></i> Filter</button>
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
						<th>Periode</th>
						<th>Hitung</th>
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
							<a href="<?php echo site_url() . '/gaji/thr_id/'.$unit->id;?>" title="Detail" class="btn btn-xs btn-primary"><i class="fa fa-gear "></i> Hitung Sekarang</a>
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
<script>
	function GetData(id) {
		$.ajax({
			url: "<?= site_url('shift/GetShift') ?>",
			type: 'POST',
			dataType: 'json',
			data: {
				id: id
			},
			success: function(data) {
				//memasukkan data shift ke dalam form
				$('#nama_shift').val(data.nama_shift);
				$('#tipe').val(data.ket);
				$('#id').val(data.id);
			}
		});
	}

	function ClearForm() {
		$('#nama_shift').val('');
		$('#tipe').val('');
		$('#id').val(0);
	}

	function SetHapus(id) {
		$('#idhapus').val(id);
	}
</script>