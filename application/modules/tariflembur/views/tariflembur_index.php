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
			<a href="" class="btn btn-primary pull-right" data-toggle="modal" data-target="#modalNew"><i class="fa fa-plus"></i> Tambah Tarif Lembur </a>
			<form action="<?php echo site_url() . '/tariflembur' ?>" method="post">
				<table>
					<tr>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Unit : </td>
						<td>
							<select name="skpd" class="form-control" onchange="SetUnit(this.value)">
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
			<table class="table table-sm table-striped table-bordered" id="example1">
				<thead>
					<tr>
						<th class="border border-grey" rowspan="2" align="center" valign="middle">
							<p>Jabatan</p>
						</th>
						<th class="border border-grey" rowspan="2" align="center" valign="middle">
							<p>Kelas Jabatan</p>
						</th>
						<th class="border border-grey" rowspan="2" align="center" valign="middle">
							<p>Tarif (n x gaji)</p>
						</th>
						<th class="border border-grey" colspan="4" align="center" valign="middle">
							<p align="center">Hari Kerja</p>
						</th>
						<th class="border border-grey" colspan="3" align="center" valign="middle">
							<p align="center">Hari Libur Nasional</p>
						</th>
						<th class="border border-grey" rowspan="2" align="center" valign="middle">
							<p>Uang Makan</p>
						</th>
						<th class="border border-grey" rowspan="2" align="center" valign="middle">
							<p>Aksi</p>
						</th>
					</tr>
					<tr>
						<th class="border border-grey" align="center" valign="middle">
							<p>1 Jam</p>
						</th>
						<th class="border border-grey" align="center" valign="middle">
							<p>2-8 Jam</p>
						</th>
						<th class="border border-grey" align="center" valign="middle">
							<p>9 Jam</p>
						</th>
						<th class="border border-grey" align="center" valign="middle">
							<p>>10 Jam</p>
						</th>
						<th class="border border-grey" align="center" valign="middle">
							<p>1-8 Jam</p>
						</th>
						<th class="border border-grey" align="center" valign="middle">
							<p>9 Jam</p>
						</th>
						<th class="border border-grey" align="center" valign="middle">
							<p> > 10 Jam</p>
						</th>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach ($dt as $tlembur) {
					?>
						<tr>
							<td>
								<?php
								$jab = $this->Tariflembur_model->jabatan_id($tlembur->idJabatan)->row();
								echo $jab->namaJabatan;
								?>
							</td>
							<td>
								<?php
								$hitungkajab = $this->Tariflembur_model->kelasjabatan_nama($tlembur->idKelasJabatan)->num_rows();
								if ($hitungkajab > 0) {
									$kajab = $this->Tariflembur_model->kelasjabatan_nama($tlembur->idKelasJabatan)->row();
									echo $kajab->kodeKelas;
								} else {
									echo '-';
								}
								?>
							</td>
							<td><?php echo $tlembur->tarif; ?></td>
							<td><?php echo $tlembur->satujam; ?></td>
							<td><?php echo $tlembur->duajam; ?></td>
							<td><?php echo $tlembur->delapanjam_lebih; ?></td>
							<td><?php echo $tlembur->sepuluhjam_lebih; ?></td>
							<td><?php echo $tlembur->satujam_libur; ?></td>
							<td><?php echo $tlembur->sembilanjam_libur; ?></td>
							<td><?php echo $tlembur->sepuluhjam_libur; ?></td>
							<td><?php echo $tlembur->uang_makan; ?></td>
							<td>
								<a href="" class="btn btn-xs btn-warning" title="edit data" data-toggle="modal" data-target="#modalEdit<?php echo $tlembur->id; ?>"><i class="fa fa-pencil"></i></a>
								<a href="<?php echo site_url() . '/tariflembur/Hapus/' . $tlembur->id; ?>" class="btn btn-xs btn-danger" title="hapus data"><i class="fa fa-trash"></i></a>
								<!-- modal form untuk edit data -->
								<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal label" aria-hidden="true" id="modalEdit<?php echo $tlembur->id; ?>" data-backdrop="static">
									<div class="modal-dialog modal-lg">
										<form action="<?= site_url('tariflembur/Update') ?>" method="post">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="modalTitle_shift">Edit Tarif Lembur</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
													<div class="form-group">
														<input type="hidden" name="idt" class="form-control" id="idt" value="<?php echo $tlembur->id; ?>">
													</div>
													<div class="form-group">
														<input type="hidden" name="unit" class="form-control" id="unit<?= $tlembur->id ?>" value="<?php echo $this->session->filter_unit; ?>">
													</div>
													<div class="row">
														<div class="form-group col-md-7">
															<label>Jabatan</label>
															<select class="form-control" style="width: 100%;" name="jabatan" id="idJabatan<?php echo $tlembur->id; ?>" onchange="LoadKelas(this.value,'<?php echo $tlembur->id; ?>')">
																<?php
																foreach ($jabatan as $dtjab) {
																	if ($dtjab->idJabatan == $tlembur->idJabatan) {
																?>
																		<option value="<?php echo $dtjab->idJabatan; ?>" selected="selected"><?php echo $dtjab->namaJabatan; ?></option>
																	<?php
																	} else {
																	?>
																		<option value="<?php echo $dtjab->idJabatan; ?>"><?php echo $dtjab->namaJabatan; ?></option>
																<?php
																	}
																}
																?>
															</select>
														</div>
														<div class="form-group col-md-5">
															<label>Kelas Jabatan</label>
															<select name="kelasJabatan" class="form-control" id="kelasJabatan<?php echo $tlembur->id; ?>">
																<option value="0">-- Pilih Kelas --</option>
																<?php
																$hitungdata = $this->Tariflembur_model->Kelas_jabatan($tlembur->idJabatan)->num_rows();
																if ($hitungdata > 0) {
																	$gol = $this->Tariflembur_model->Kelas_jabatan($tlembur->idJabatan)->result();
																	foreach ($gol as $g) {
																		if ($g->id == $tlembur->idKelasJabatan) {
																?>
																			<option value="<?php echo $g->id ?>" selected="selected"><?php echo $g->kodeKelas; ?></option>
																		<?php
																		} else {
																		?>
																			<option value="<?php echo $g->id ?>"><?php echo $g->kodeKelas; ?></option>
																<?php
																		}
																	}
																}
																?>
															</select>
														</div>
													</div>
													<div class="row">
														<div class="form-group col-md-6">
															<label>Tarif</label>
															<input type="text" name="tarif_lembur" value="<?php echo $tlembur->tarif; ?>" class="form-control" id="tarif_lembur">
														</div>
														<div class="form-group col-md-6">
															<label> Uang Makan</label>
															<input type="text" name="uang_makan" value="<?php echo $tlembur->uang_makan; ?>" class="form-control" id="uang_makan">
														</div>
													</div>

													<hr>
													<label>Tarif Hari Kerja</label>
													<div class="row">
														<div class="col-3">
															<div class="form-group">
																<label>1 Jam</label>
																<input type="text" name="tarif_1" value="<?php echo $tlembur->satujam; ?>" class="form-control" id="tarif_1">
															</div>
														</div>
														<div class="col-3">
															<div class="form-group">
																<label>2-8 Jam</label>
																<input type="text" name="tarif_2-8" value="<?php echo $tlembur->duajam; ?>" class="form-control" id="tarif_2-8">
															</div>
														</div>
														<div class="col-3">
															<div class="form-group">
																<label>9 Jam</label>
																<input type="text" name="tarif_8" value="<?php echo $tlembur->delapanjam_lebih; ?>" class="form-control" id="tarif_8">
															</div>
														</div>
														<div class="col-3">
															<div class="form-group">
																<label>>10 Jam</label>
																<input type="text" name="tarif_10" value="<?php echo $tlembur->sepuluhjam_lebih; ?>" class="form-control" id="tarif_8">
															</div>
														</div>
													</div>
													<hr>
													<label>Tarif Hari Libur</label>
													<div class="row">
														<div class="col-3">
															<div class="form-group">
																<label>1-8 Jam</label>
																<input type="text" name="tarif_1-8l" value="<?php echo $tlembur->satujam_libur; ?>" class="form-control" id="tarif_1-8l">
															</div>
														</div>
														<div class="col-3">
															<div class="form-group">
																<label>9 Jam</label>
																<input type="text" name="tarif_9-10l" value="<?php echo $tlembur->sembilanjam_libur; ?>" class="form-control" id="tarif_9-10l">
															</div>
														</div>
														<div class="col-3">
															<div class="form-group">
																<label> > 10 Jam</label>
																<input type="text" name="tarif_10l" value="<?php echo $tlembur->sepuluhjam_libur; ?>" class="form-control" id="lebih10">
															</div>
														</div>
													</div>


													<div class="modal-footer">
														<button type="submit" class="btn btn-primary btn-sm"><span class="fa fa-check"></span> Ubah</button>
														<a class="btn btn-danger btn-sm" href="<?php echo site_url() . '/tariflembur'; ?>" data-dismiss="modal"><span class="fa fa-times"></span> Batal</a>
													</div>
												</div>
										</form>
									</div>
								</div>
								<!--------------------------------------------------Akhir Modal----------------------------------------------->
							</td>
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		</div>
		<?php
		echo "<b>Catatan : 1/173=0.0057803468208092</b>";
		?>
	</div>
	<!-- modal form untuk input data -->
	<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal label" aria-hidden="true" id="modalNew" data-backdrop="static">
		<div class="modal-dialog modal-lg">
			<form action="<?= site_url('tariflembur/Simpan') ?>" method="post">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="modalTitle_shift">Input Tarif Lembur</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<input type="hidden" name="unit" class="form-control" id="unit" value="<?php echo $this->session->filter_unit; ?>">
						</div>
						<div class="row">
							<div class="form-group col-md-7">
								<label>Jabatan</label>
								<select class="form-control" style="width: 100%;" name="jabatan" id="idJabatan" onchange="LoadKota(this.value,0)">
									<?php
									foreach ($jabatan as $dtjab) {
									?>
										<option value="<?php echo $dtjab->idJabatan; ?>"><?php echo $dtjab->namaJabatan; ?></option>
									<?php
									}
									?>
								</select>
							</div>
							<div class="form-group col-md-5">
								<label>Kelas Jabatan</label>
								<select name="kelasJabatan" class="form-control" id="kelasJabatan">
									<option value="0">-- Pilih Kelas --</option>
									<?php foreach ($gol as $g) {
										if ($cID == 0) { ?>
											<option value="<?= $g->id ?>"><?= $g->kodeKelas ?></option>
										<?php } else { ?>
											<option value="<?= $g->id ?>" <?= $g->id == $dt->kelasJabatan ? ' selected ' : '' ?>><?= $g->kodeKelas ?></option>
									<?php }
									} ?>
								</select>
							</div>
						</div>
						<div class="row">

							<div class="form-group col-md-6">
								<label>Tarif Lembur (n x gaji)</label>
								<input type="text" name="tarif_lembur" class="form-control" id="tarif_lembur">
							</div>

							<div class="form-group col-md-6">
								<label> Uang Makan (Rp)</label>
								<input type="text" name="uang_makan" class="form-control" id="uang_makan">
							</div>
						</div>
						<hr>
						<label>Tarif Hari Kerja</label>
						<div class="row">

							<div class="col-3">
								<div class="form-group">
									<label>1 Jam (n x tarif lembur)</label>
									<input type="text" name="tarif_1" class="form-control" id="tarif_1">
								</div>
							</div>
							<div class="col-3">
								<div class="form-group">
									<label>2-8 Jam (n x tarif lembur)</label>
									<input type="text" name="tarif_2-8" class="form-control" id="tarif_2-8">
								</div>
							</div>
							<div class="col-3">
								<div class="form-group">
									<label> 9 Jam (n x tarif lembur)</label>
									<input type="text" name="tarif_8" class="form-control" id="tarif_8">
								</div>
							</div>
							<div class="col-3">
								<div class="form-group">
									<label> >10 Jam (n x tarif lembur)</label>
									<input type="text" name="tarif_10" class="form-control" id="tarif_8">
								</div>
							</div>
						</div>
						<hr>
						<label>Tarif Hari Libur</label>
						<div class="row">
							<div class="col-4">
								<div class="form-group">
									<label>1-8 Jam (n x tarif lembur)</label>
									<input type="text" name="tarif_1-8l" class="form-control" id="tarif_1-8l">
								</div>
							</div>
							<div class="col-4">
								<div class="form-group">
									<label>9 Jam (n x tarif lembur)</label>
									<input type="text" name="tarif_9-10l" class="form-control" id="tarif_9-10l">
								</div>
							</div>
							<div class="col-4">
								<div class="form-group">
									<label> > 10 Jam (n x tarif lembur)</label>
									<input type="text" name="tarif_10l" class="form-control" id="lebih10">
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
	<!--------------------------------------------------Akhir Modal----------------------------------------------->
	<script>
		$(document).ready(function() {
			$('#idJabatan').change(function() {
				var jabatan_id = $(this).val();
				$.ajax({
					type: 'GET',
					url: '<?= site_url('pegawai/GetGol') ?>',
					data: {
						id: jabatan_id
					},
					dataType: 'json',
					success: function(data) {
						$('#kelasJabatan').empty();
						$('#kelasJabatan').append($('<option>', {
							value: 0,
							text: '-- Pilih Kelas --'
						}));
						$.each(data, function(index, element) {
							$('#kelasJabatan').append($('<option>', {
								value: element.id,
								text: element.kodeKelas
							}));
						});
					}
				});
			});
		});
	</script>

	<script>
		function LoadKelas(idjabatan, idobj) {
			$.ajax({
				url: "<?= site_url('pegawai/GetGol') ?>",
				type: 'GET',
				dataType: 'json',
				data: {
					id: idjabatan
				},
				success: function(data) {
					$('#kelasJabatan' + idobj).empty();
					$('#kelasJabatan' + idobj).append($('<option>', {
						value: 0,
						text: '-- Pilih Kelas --'
					}));
					$.each(data, function(index, element) {
						$('#kelasJabatan' + idobj).append($('<option>', {
							value: element.id,
							text: element.kodeKelas
						}));
					});
				}
			});
		}


		function SetHapus(id) {
			$('#idhapus').val(id);
		}

		function SetUnit(id) {
			console.log(id);
			$('#unit').val(id);
		}

		window.setTimeout(function() {
			$(".alert").fadeTo(500, 0).slideUp(500, function() {
				$(this).remove();
			});
		}, 2000);
	</script>