<div class="card card-body">
	<div class="row">
		<div class="col-sm-12 col-md-12 text-md-right">
			<a href="<?php echo site_url() . '/gaji/cetak_all' ?>" target="_blank" class="btn btn-primary pull-right" ><i class="fa fa-print"></i> Cetak Slip </a>
			<form action="<?php echo site_url() . '/gaji/thr' ?>" method="post">
				<table>
					<tr>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Unit : </td>
						<td>
							<select name="skpd" class="form-control">
								<option value="">-- Pilih Unit Kerja --</option>
								<?php
								foreach ($satkerja as $sat) { ?>
									<?php
									if ($this->session->filter_unit == $sat->id) {
									?>
										<option value="<?= $sat->id ?>" selected="selected"><?= $sat->nama ?></option>
									<?php
									} else {
									?>
										<option value="<?= $sat->id ?>"><?= $sat->nama ?></option>
								<?php
									}
								}
								?>
							</select>
						</td>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bulan :</td>
						<td>
							<select name="bulan" class="form-control">
								<?php
								if ($this->session->filter_bulan == "01") {
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
								if ($this->session->filter_bulan == "02") {
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
								if ($this->session->filter_bulan == "03") {
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
								if ($this->session->filter_bulan == "04") {
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
								if ($this->session->filter_bulan == "05") {
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
								if ($this->session->filter_bulan == "06") {
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
								if ($this->session->filter_bulan == "07") {
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
								if ($this->session->filter_bulan == "08") {
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
								if ($this->session->filter_bulan == "09") {
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
								if ($this->session->filter_bulan == "10") {
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
								if ($this->session->filter_bulan == "11") {
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
								if ($this->session->filter_bulan == "12") {
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
			<table class="table  table-striped" id="example1">
				<thead>
					<tr>
						<th>NIP</th>
						<th>Pegawai</th>
						<th>Tgl Bergabung</th>
						<th>Agama</th>
						<th>Gaji Pokok</th>
						<th>THR</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach($dt as $data_thr)
					{
					$pegawai=$this->gaji_model->pegawai_person($data_thr->nip)->row();
					?>
					<tr>
						<td><?php echo $data_thr->nip;?></td>
						<td><?php echo $pegawai->namaPegawai;?></td>
						<td><?php echo date("d-m-Y",strtotime($pegawai->tglBergabung));?></td>
						<td><?php echo $pegawai->agama;?></td>
						<td align="right"><?php echo number_format($pegawai->gaji,"0",",",".");?></td>
						<td align="right"><?php echo number_format($data_thr->jml,"2",",",".");?></td>
						<td>
							<a href="<?php echo site_url(). '/Gaji/Cetak_Satuan/' . $data_thr->id; ?>" target="_blank" class="btn btn-xs btn-info" title="cetak slipgaji"><i class="fa fa-print "></i></a>
							<?php
							$tahun=date("Y");
							if($tahun==$this->session->filter_tahun)
							{
							?>
								<a href="" class="btn btn-xs btn-warning" title="edit data" data-toggle="modal" data-target="#modalPerson<?php echo $data_thr->id;?>"><i class="fa fa-pencil"></i></a> 
							<?php
							}
							else
							{
							?>
								<a href="javascript:void(0)" class="btn btn-xs btn-warning" title="edit data"><i class="fa fa-pencil"></i></a>
							<?php	
							}
							?>
							<!-- modal form untuk input data -->
							<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal label" aria-hidden="true" id="modalPerson<?php echo $data_thr->id;?>" data-backdrop="static">
								<div class="modal-dialog modal-lg">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="modalTitle_shift">Edit Tunjangan Hari Raya</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>
										<form action="<?= site_url('gaji/Update_thr') ?>" method="post">
											<div class="modal-body">
												<div class="form-group">
													<input type="hidden" name="id_thr" class="form-control" id="id_thr" value="<?php echo $data_thr->id; ?>">							
												</div>
												<div class="form-group">
													<label> THR </label>
													<input type="text" name="gaji_thr" class="form-control" id="gaji_thr" value="<?php echo $data_thr->jml; ?>">							
												</div>	
											</div>
											<div class="modal-footer">
												<button type="submit" class="btn btn-primary btn-sm"><span class="fa fa-check"></span> Ubah</button>
												<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><span class="fa fa-times"></span> Close</button>
											</div>
										</form>
									</div>
								</div>
							</div>
							<!-------------------------------------------------Akhir Modal------------------------------------------------------->
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