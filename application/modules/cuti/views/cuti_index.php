<?php
if (!empty($error)) {
?>
	<div class="alert alert-danger">
		Gagal Simpan ! Unit Kerja belum dipilih
	</div>
<?php
}
?>
<div class="card card-body">
	<div class="row">
		<div class="col-sm-12 col-md-12 text-md-right">
			<button class="btn btn-primary pull-right" data-toggle="modal" data-target="#modalNew" <?= $this->session->filter_unit == "" ? "disabled" : "" ?>><i class="fa fa-plus"></i> Tambah Cuti</button>
			<form action="<?php echo site_url() . '/cuti' ?>" method="post">
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
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button class="btn btn-primary" ><i class="fa fa-search"></i> Filter</button>
						</td>
					</tr>
				</table>
			</form>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-md-12">
			<table class="table table-sm table-striped" id="example1">
				<thead>
					<tr>
						<th>NIP</th>
						<th>Nama Pegawai</th>
						<th>Tgl Pengajuan</th>
						<th>Nomor</th>
						<th>Jml Hari</th>
						<th>Tgl Cuti</th>
						<th>Alasan</th>
						<th>Sisa Cuti</th>
						<th>Status</th>
						<th style="width:10%"></th>
					</tr>
				</thead>
				<tbody>
					<?php
					if (count($dt) > 0) {
						foreach ($dt as $cuti) {
					?>
							<tr>
								<?php
								$dtpeg = $this->Cuti_model->pegawai_id($cuti->idPegawai)->row();
								?>
								<td><?php echo $dtpeg->nipBaru; ?></td>
								<td><?php echo $dtpeg->namaPegawai; ?></td>
								<td><?php echo date("d-m-Y", strtotime($cuti->tgl)); ?></td>
								<td><?php echo $cuti->nomor; ?></td>
								<td><?php echo $cuti->jmlHari; ?></td>
								<td><?php echo date("d-m-Y", strtotime($cuti->tglMulai)) . ' s/d ' . date("d-m-Y", strtotime($cuti->tglSampai)); ?></td>
								<td><?php echo $cuti->keperluan; ?></td>
								<td><?php echo $cuti->sisa_cuti; ?></td>
								<td>
									<?php
									if ($cuti->status == 1) {
										echo "<small>Valid " . date("d-m-Y", strtotime($cuti->tgl_validasi)) . "</small>";
									}
									?>
								</td>
								<td>
									<a href="<?php echo site_url() . '/cuti/Cetak_cuti/' . $cuti->id; ?>" target="_blank" class="btn btn-xs btn-info" title="cetak formulir"><i class="fa fa-print "></i></a>
									<?php if ($cuti->status != 1) { ?>
										<a href="" class="btn btn-xs btn-warning" title="edit data" data-toggle="modal" data-target="#modalEdit<?php echo $cuti->id; ?>"><i class="fa fa-pencil"></i></a>
										<a href="<?php echo site_url() . '/cuti/Hapus_cuti/' . $cuti->id; ?>" class="btn btn-xs btn-danger" title="hapus data"><i class="fa fa-trash"></i></a>
									<?php } ?>
								</td>
								<!-- modal form untuk edit data -->
								<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal label" aria-hidden="true" id="modalEdit<?php echo $cuti->id; ?>" data-backdrop="static">
									<div class="modal-dialog modal-lg">
										<form action="<?= site_url('cuti/Update_cuti/' . $cuti->id) ?>" method="post">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="modalTitle_shift">Edit Cuti</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>

												<div class="modal-body">
													<div class="form-group">
														<input type="hidden" name="id_cuti" class="form-control" id="id_cuti" value="<?php echo $cuti->id; ?>">
													</div>
													<div class="form-group">
														<input type="hidden" name="pegawai_cuti" class="form-control" id="id_pegawai" value="<?php echo $cuti->idPegawai; ?>">
													</div>
													<div class="row">
														<div class="col-9">
															<div class="form-group">
																<label for="ajukan_cuti">Tgl Pengajuan</label>
																<input type="date" name="ajukan_cuti" class="form-control" id="ajukan_cuti" value="<?php echo $cuti->tgl; ?>">
															</div>
														</div>
														<div class="col-3">
															<div class="form-group">
																<label for="ajukan_cuti">Jenis Cuti</label>
																	<select name="hari_cuti" class="form-control" required>
																		<?php
																		if($cuti->ket=="tahunan")
																		{
																		?>
																		<option value="tahunan" selected="selected">Cuti Tahunan</option>
																		<option value="dispensasi">Cuti Dispensasi</option>
																		<?php
																		}
																		else
																		{
																		?>
																		<option value="tahunan">Cuti Tahunan</option>
																		<option value="dispensasi" selected="selected">Cuti Dispensasi</option>
																		<?php
																		}
																		?>
																	</select>
															</div>
														</div>
													</div>
													<label>Tgl Pengajuan Cuti</label>
													<div class="row">
														<div class="col-5">
															<div class="form-group">
																<input type="date" name="awal_cuti" class="form-control" id="ajukan_cuti" value="<?php echo $cuti->tglMulai; ?>">
															</div>
														</div>
														<div class="col-1">
															<p style="text-align:center">s/d</p>
														</div>
														<div class="col-6">
															<div class="form-group">
																<input type="date" name="akhir_cuti" class="form-control" id="ajukan_cuti" value="<?php echo $cuti->tglSampai; ?>">
															</div>
														</div>
													</div>
													<div class="form-group">
														<label for="alasan_cuti">Alasan Cuti</label>
														<input type="text" name="alasan_cuti" class="form-control" id="alasan_cuti" value="<?php echo $cuti->keperluan; ?>">
													</div>
													<div class="row">
														<div class="col-8">
															<div class="form-group">
																<label for="alamat_cuti">Alamat Selama Cuti</label>
																<input type="text" name="alamat_cuti" class="form-control" id="alamat_cuti" value="<?php echo $cuti->alamatCuti; ?>">
															</div>
														</div>
														<div class="col-4">
															<div class="form-group">
																<label for="telepon_cuti">Telepon Selama Cuti</label>
																<input type="text" name="telepon_cuti" class="form-control" id="telepon_cuti" value="<?php echo $cuti->tlp; ?>">
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-6">
															<div class="form-group">
																<label for="atasan_cuti">Atasan</label>
																<input type="text" name="atasan_cuti" class="form-control" id="atasan_cuti" value="<?php echo $cuti->atasan; ?>">
															</div>
														</div>
														<div class="col-6">
															<div class="form-group">
																<label for="direktur_cuti">Direktur</label>
																<input type="text" name="direktur_cuti" class="form-control" id="direktur_cuti" value="<?php echo $cuti->direktur; ?>">
															</div>
														</div>
													</div>
												</div>
												<div class="modal-footer">
													<button type="submit" class="btn btn-primary btn-sm"><span class="fa fa-check"></span> Simpan</button>
													<a class="btn btn-danger btn-sm" href="<?php echo site_url() . '/cuti'; ?>" data-dismiss="modal"><span class="fa fa-times"></span> Batal</a>
												</div>
										</form>
									</div>
								</div>
							</tr>
					<?php
						}
					}
					?>
				</tbody>
			</table>
		</div>
	</div>

	<!-- modal form untuk input data -->
	<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal label" aria-hidden="true" id="modalNew" data-backdrop="static">
		<div class="modal-dialog modal-lg">
			<form action="<?= site_url('cuti/Simpan') ?>" method="post">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="modalTitle_shift">Input Cuti</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>

					<div class="modal-body">
						<div class="form-group">
							<label>Nama Pegawai</label>
							<select class="form-control" style="width: 100%;" name="pegawai">
								<?php
								if (!empty($this->session->filter_unit)) {
									$pegawai = $this->Cuti_model->pegawai_unit($this->session->filter_unit)->result();
								}
								foreach ($pegawai as $dtp) {
								?>
									<option value="<?php echo $dtp->idtbPegawai; ?>"><?php echo $dtp->namaPegawai; ?></option>
								<?php
								}
								?>
							</select>
						</div>
						<div class="row">
							<div class="col-9">
								<div class="form-group">
									<label for="ajukan_cuti">Tgl Pengajuan</label>
									<input type="date" name="ajukan_cuti" class="form-control" id="ajukan_cuti">
								</div>
							</div>
							<div class="col-3">
								<div class="form-group">
								<label for="ajukan_cuti">Jenis Cuti</label>
									<select name="hari_cuti" class="form-control" required>
										<option value="tahunan">Cuti Tahunan</option>
										<option value="dispensasi">Cuti Dispensasi</option>
									</select>
								</div>
							</div>
						</div>
						<label>Tgl Pengajuan Cuti</label>
						<div class="row">
							<div class="col-5">
								<div class="form-group">
									<input type="date" name="awal_cuti" class="form-control" id="ajukan_cuti">
								</div>
							</div>
							<div class="col-1">
								<p style="text-align:center">s/d</p>
							</div>
							<div class="col-6">
								<div class="form-group">
									<input type="date" name="akhir_cuti" class="form-control" id="ajukan_cuti">
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="alasan_cuti">Alasan Cuti</label>
							<input type="text" name="alasan_cuti" class="form-control" id="alasan_cuti">
						</div>
						<div class="row">
							<div class="col-8">
								<div class="form-group">
									<label for="alamat_cuti">Alamat Selama Cuti</label>
									<input type="text" name="alamat_cuti" class="form-control" id="alamat_cuti">
								</div>
							</div>
							<div class="col-4">
								<div class="form-group">
									<label for="telepon_cuti">Telepon Selama Cuti</label>
									<input type="text" name="telepon_cuti" class="form-control" id="telepon_cuti">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-6">
								<div class="form-group">
									<label for="atasan_cuti">Asman</label>
									<input type="text" name="atasan_cuti" class="form-control" id="atasan_cuti">
								</div>
							</div>
							<div class="col-6">
								<div class="form-group">
									<label for="direktur_cuti">Direktur</label>
									<input type="text" name="direktur_cuti" class="form-control" id="direktur_cuti">
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary btn-sm"><span class="fa fa-check"></span> Simpan</button>
						<a class="btn btn-danger btn-sm" href="<?php echo site_url() . '/cuti'; ?>" data-dismiss="modal"><span class="fa fa-times"></span> Batal</a>
					</div>
				</div>
			</form>
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

		window.setTimeout(function() {
			$(".alert").fadeTo(500, 0).slideUp(500, function() {
				$(this).remove();
			});
		}, 2000);
	</script>