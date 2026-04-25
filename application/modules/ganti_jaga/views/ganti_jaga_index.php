<div class="card card-body">

	<div class="row">

		<div class="col-sm-12 col-md-12 text-md-right">

			<a href="" class="btn btn-primary pull-right" data-toggle="modal" data-target="#modalNew"><i class="fa fa-plus"></i> Tambah SPGJ</a>

			<form action="<?php echo site_url() . '/ganti_jaga' ?>" method="post">

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



			<table class="table table-sm table-striped" id="example1">

				<thead>

					<tr>

						<th>No WO</th>

						<th>Uraian</th>

						<th>Tanggal</th>

						<th>Waktu</th>

						<th>Keterangan</th>

						<th>Pemberi Tugas</th>

						<th>Pemeriksa</th>

						<th>Pegawai Digantikan</th>

						<th>Pegawai Menggantikan</th>

						<td></td>

					</tr>

				</thead>

				<tbody>

					<?php

					foreach ($dt as $ganti) {



					?>

						<tr>

							<td>

								<?php echo $ganti->noWo; ?></td>

							<td style="width:100px;"><?php echo $ganti->uraian; ?></td>

							<td><?php echo date("d-m-Y", strtotime($ganti->tglLembur)); ?>

								<?php

								if ($ganti->status == 1) {

									echo "<br><small>Valid " . date("d-m-Y", strtotime($ganti->tgl_validasi)) . "</small>";

								}

								?>

							</td>

							<td><?php echo $ganti->mulai . ' s/d ' . $ganti->sampai; ?></td>

							<td><?php echo $ganti->alasan; ?></td>

							<td><?php echo $ganti->namaPemberiTugas; ?></td>

							<td><?php echo $ganti->namaPemeriksa; ?></td>

							<?php

							$peg_gantikan = $this->ganti_jaga_model->pegawai_id($ganti->idp_yg_diganti)->row();

							?>

							<td style="width:50px;"><?php echo $peg_gantikan->namaPegawai; ?></td>

							<?php

							$peg_menggantikan = $this->ganti_jaga_model->pegawai_id($ganti->idp_yg_mengganti)->row();

							?>

							<td style="width:50px;"><?php echo $peg_menggantikan->namaPegawai; ?></td>

							<td>

								<a href="<?php echo site_url() . '/ganti_jaga/Cetak_jaga/' . $ganti->id; ?>" target="_blank" class="btn btn-xs btn-info" title="cetak formulir"><i class="fa fa-print "></i></a>

								<?php if ($ganti->status != 1) { ?>

									<a href="" class="btn btn-xs btn-warning" title="Edit Data" data-toggle="modal" data-target="#modalEdit<?php echo $ganti->id ?>"><i class="fa fa-pencil"></i></a>

									<a href="<?php echo site_url() . '/ganti_jaga/Delete/' . $ganti->id; ?>" class="btn btn-xs btn-danger" title="hapus data"><i class="fa fa-trash"></i></a>

								<?php } ?>

								<!-- modal form untuk edit data -->

								<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal label" aria-hidden="true" id="modalEdit<?php echo $ganti->id ?>" data-backdrop="static">

									<div class="modal-dialog modal-lg">

										<div class="modal-content">

											<div class="modal-header">

												<h5 class="modal-title" id="modalTitle_shift">Ubah SPGJ</h5>

												<button type="button" class="close" data-dismiss="modal" aria-label="Close">

													<span aria-hidden="true">&times;</span>

												</button>

											</div>

											<form action="<?= site_url('ganti_jaga/Edit') ?>" method="post">

												<div class="modal-body">

													<div class="row">

														<div class="col-12">

															<div class="form-group">

																<input type="hidden" name="id_jaga" value="<?php echo $ganti->id; ?>" class="form-control" id="id_jaga">

															</div>

														</div>

													</div>

													<div class="row">

														<div class="col-5">

															<div class="form-group">

																<label for="tgl_wo">Tanggal</label>

																<input type="date" name="tgl_wo" value="<?php echo $ganti->tglLembur; ?>" class="form-control" id="tgl_wo">

															</div>

														</div>

														<div class="col-3">

															<div class="form-group">

																

																<label>Aktivitas</label>

																

																<select class="form-control" style="width: 100%;" name="aktivitas">
  																	<option value="" >Aktifitas</option>
																	<option value="12" <?= $ganti->kodeAktifitas == '12' ? ' selected ' : '' ?>>Keamanan</option>
																	<option value="18" <?= $ganti->kodeAktifitas == '18' ? ' selected ' : '' ?>>K3</option>

																	<option value="19" <?= $ganti->kodeAktifitas == '19' ? ' selected ' : '' ?>>Lingkungan</option>

																	<option value="20" <?= $ganti->kodeAktifitas == '20' ? ' selected ' : '' ?>>Preventive Maintenance</option>

																	<option value="21"<?= $ganti->kodeAktifitas == '21' ? ' selected ' : '' ?>>Predictive Maintenance</option>

																	<option value="22" <?= $ganti->kodeAktifitas == '22' ? ' selected ' : '' ?>>Corrective Maintenance</option>

																	<option value="24" <?= $ganti->kodeAktifitas == '24' ? ' selected ' : '' ?>>Overhoul / Inspection</option>

																	<option value="26" <?= $ganti->kodeAktifitas == '26' ? ' selected ' : '' ?>>Engineering / Project / Modifikasi</option>

																	<option value="60" <?= $ganti->kodeAktifitas == '60' ? ' selected ' : '' ?>>Non Instalasi / Umum</option>

																</select>

															</div>

														</div>

														<div class="col-2">

															<div class="form-group">

																<label>Keterangan Hari</label>

																<select class="form-control" style="width: 100%;" name="hari">

																	<?php

																	if ($ganti->statusHari == "Kerja") {

																	?>

																		<option value="Kerja" selected="selected">Kerja</option>

																		<option value="Libur">Libur</option>

																	<?php

																	} else {

																	?>

																		<option value="Kerja">Kerja</option>

																		<option value="Libur" selected="selected">Libur</option>

																	<?php

																	}

																	?>

																</select>

															</div>

														</div>

													</div>

													<div class="row">

														<div class="col-1">

															<div class="form-group">

																<label>Jam</label>

																<input type="text" name="jam_awal_lembur" value="<?php echo substr($ganti->mulai, 0, 2); ?>" name="jam_awal_lembur" class="form-control" id="jam_awal_lembur">

															</div>

														</div>

														<div class="col-1">

															<p style="text-align:center;margin-top:40px;">:</p>

														</div>

														<div class="col-1">

															<div class="form-group">

																<label>Menit</label>

																<input type="text" name="menit_awal_lembur" value="<?php echo substr($ganti->mulai, 3, 2); ?>" class="form-control" id="menit_awal_lembur">

															</div>

														</div>

														<div class="col-1">

															<p style="text-align:center;margin-top:40px;">s/d</p>

														</div>

														<div class="col-1">

															<div class="form-group">

																<label>Jam</label>

																<input type="text" name="jam_akhir_lembur" value="<?php echo substr($ganti->sampai, 0, 2); ?>" class="form-control" id="jam_akhir_lembur">

															</div>

														</div>

														<div class="col-1">

															<p style="text-align:center;margin-top:40px;">:</p>

														</div>

														<div class="col-1">

															<div class="form-group">

																<label>Menit</label>

																<input type="text" name="menit_akhir_lembur" value="<?php echo substr($ganti->sampai, 3, 2); ?>" class="form-control" id="menit_akhir_lembur">

															</div>

														</div>

														<div class="col-5">
														
															<div class="form-group">
																<label>Menggantikan Karena</label>
																<select class="form-control" style="width: 100%;" name="alasan">
																	<option value="">-- Pilih Alasan --</option>
																	<option value="Cuti" <?= $ganti->alasan == 'Cuti' ? ' selected ' : '' ?>>Cuti</option>
																	<option value="Dispensasi" <?= $ganti->alasan == 'Dispensasi' ? ' selected ' : '' ?>>Sakit/Dispensasi</option>
																	<option value="Kegiatan" <?= $ganti->alasan == 'Kegiatan' ? ' selected ' : '' ?>>Kegiatan PLN</option>
																</select>
															</div>
														
															<div class="form-group">

																<!---------------------------

																<label>Beban Anggaran</label>

																------------------------------>

																<input type="hidden" name="beban_anggaran" value="<?php echo $ganti->bebanAnggaran; ?>" class="form-control" id="beban_anggaran">

															</div>

														</div>

													</div>

													<div class="row">
														
														<div class="col-12">
															<div class="form-group">
																<label for="uraian_lembur">Uraian</label>
																<textarea class="form-control" id="uraian_lembur" maxlength="200" name="uraian_lembur"><?php echo $ganti->uraian; ?></textarea>
															</div>
														</div>
													</div>

													<hr>

													<h5>Personal Pengganti</h5>

													<div class="row">

														<div class="col-6">

															<div class="form-group">

																<label>Nama Pegawai yang Digantikan</label>

																<select class="form-control" style="width: 100%;" name="pegawai_diganti">

																	<?php

																	if (!empty($this->session->filter_unit)) {

																		$pegawai = $this->ganti_jaga_model->pegawai_unit($this->session->filter_unit)->result();

																	}

																	foreach ($pegawai as $dtp) {

																		if ($dtp->idtbPegawai == $ganti->idp_yg_diganti) {

																	?>

																			<option value="<?php echo $dtp->idtbPegawai; ?>" selected="selected"><?php echo $dtp->namaPegawai; ?></option>

																		<?php

																		} else {

																		?>

																			<option value="<?php echo $dtp->idtbPegawai; ?>"><?php echo $dtp->namaPegawai; ?></option>

																	<?php

																		}

																	}

																	?>

																</select>

															</div>

														</div>

														<div class="col-6">

															<div class="form-group">

																<label>Nama Pegawai yang Menggantikan</label>

																<select class="form-control" style="width: 100%;" name="pegawai_mengganti">

																	<?php

																	if (!empty($this->session->filter_unit)) {

																		$pegawai = $this->ganti_jaga_model->pegawai_unit($this->session->filter_unit)->result();

																	}

																	foreach ($pegawai as $dtp) {

																		if ($dtp->idtbPegawai == $ganti->idp_yg_mengganti) {

																	?>

																			<option value="<?php echo $dtp->idtbPegawai; ?>" selected="selected"><?php echo $dtp->namaPegawai; ?></option>

																		<?php

																		} else {

																		?>

																			<option value="<?php echo $dtp->idtbPegawai; ?>"><?php echo $dtp->namaPegawai; ?></option>

																	<?php

																		}

																	}

																	?>

																</select>

															</div>

														</div>

													</div>

													<hr>

													<h5>Pemeriksa / Pemberi Tugas</h5>

													<div class="row">

														

														<div class="col-6">

															<label>Pemberi Tugas</label>

															<input type="text" name="nama_pt" value="<?php echo $ganti->namaPemberiTugas; ?>" class="form-control" id="nama_pt">

														</div>

														<div class="col-5">

														<label>Tanggal</label>

															<input type="date" name="tgl_pt" value="<?php echo $ganti->tglPemberiTugas; ?>" class="form-control" id="tgl_pt">

														</div>

														<div class="col-1">

															<!-------------------------------

															<label>NID</label>

															----------------------------------->

															<input type="hidden" name="nid_pt" value="<?php echo $ganti->nidPemberiTugas; ?>" class="form-control" id="nid_pt">

														</div>

													</div>

													<div class="row">

														<div class="col-4">

															<label>NID</label>

															<input type="text" name="nid_periksa" value="<?php echo $ganti->nidPemeriksa; ?>" class="form-control" id="nid_periksa">

														</div>

														<div class="col-4">

															<label>Pemeriksa</label>

															<input type="text" name="nama_periksa" value="<?php echo $ganti->namaPemeriksa; ?>" class="form-control" id="nama_periksa">

														</div>

														<div class="col-4">

															<label>Tanggal</label>

															<input type="date" name="tgl_periksa" value="<?php echo $ganti->tglPemeriksa; ?>" class="form-control" id="tgl_periksa">

														</div>

													</div>

													<hr>

													<div class="row">

														<div class="col-6">

															<label>Asman</label>

															<input type="text" name="asman" value="<?php echo $ganti->namaAsman; ?>" class="form-control" id="nama_periksa">

														</div>

													</div>

													<div class="modal-footer">

														<button type="submit" class="btn btn-primary btn-sm"><span class="fa fa-check"></span> Ubah Data</button>

														<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><span class="fa fa-times"></span> Close</button>

													</div>

											</form>

										</div>

									</div>

								</div>

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

<!-- modal form untuk input data -->

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal label" aria-hidden="true" id="modalNew" data-backdrop="static">

	<div class="modal-dialog modal-lg">

		<div class="modal-content">

			<div class="modal-header">

				<h5 class="modal-title" id="modalTitle_shift">Input SPGJ</h5>

				<button type="button" class="close" data-dismiss="modal" aria-label="Close">

					<span aria-hidden="true">&times;</span>

				</button>

			</div>

			<form action="<?= site_url('ganti_jaga/Simpan') ?>" method="post">

				<div class="modal-body">

					

					<div class="row">

						<div class="col-12">

							<div class="form-group">

								<!---------------------

								<label for="nomor">Nomor</label>

								------------------->

								<input type="hidden" name="nomor" class="form-control" id="nomor">

							</div>

						</div>

					</div>

					

					<div class="row">

						<div class="col-5">

							<div class="form-group">

								<label for="tgl_wo">Tanggal Ganti Jaga</label>

								<input type="date" name="tgl_wo" class="form-control" id="tgl_wo">

							</div>

						</div>

						<div class="col-3">

							<div class="form-group">



								<label>Aktivitas</label>

								

								<select class="form-control" style="width: 100%;" name="aktivitas">

									<option value="">Aktifitas</option>
									<option value="12">Keamanan</option>								
									<option value="18">K3</option>

									<option value="19">Lingkungan</option>

									<option value="20">Preventive Maintenance</option>

									<option value="21">Predictive Maintenance</option>

									<option value="22">Corrective Maintenance</option>

									<option value="24">Overhoul / Inspection</option>

									<option value="26">Engineering / Project / Modifikasi</option>

									<option value="60">Non Instalasi / Umum</option>

								</select>

							</div>

						</div>

						<div class="col-2">

							<div class="form-group">

								<label>Keterangan Hari</label>

								<select class="form-control" style="width: 100%;" name="hari">

									<option value="Kerja">Kerja</option>

									<option value="Libur">Libur</option>

								</select>

							</div>

						</div>

					</div>

					

					<div class="row">

						<div class="col-1">

							<div class="form-group">

								<label>Jam</label>

								<input type="text" name="jam_awal_lembur" class="form-control" id="jam_awal_lembur">

							</div>

						</div>

						<div class="col-1">

							<p style="text-align:center;margin-top:40px;">:</p>

						</div>

						<div class="col-1">

							<div class="form-group">

								<label>Menit</label>

								<input type="text" name="menit_awal_lembur" class="form-control" id="menit_awal_lembur">

							</div>

						</div>

						<div class="col-1">

							<p style="text-align:center;margin-top:40px;">s/d</p>

						</div>

						<div class="col-1">

							<div class="form-group">

								<label>Jam</label>

								<input type="text" name="jam_akhir_lembur" class="form-control" id="jam_akhir_lembur">

							</div>

						</div>

						<div class="col-1">

							<p style="text-align:center;margin-top:40px;">:</p>

						</div>

						<div class="col-1">

							<div class="form-group">

								<label>Menit</label>

								<input type="text" name="menit_akhir_lembur" class="form-control" id="menit_akhir_lembur">

							</div>

						</div>

						<div class="col-5">
							<div class="form-group">
								<label>Menggantikan Karena</label>
								<select class="form-control" style="width: 100%;" name="alasan">
									<option value="">-- Pilih Alasan --</option>
									<option value="Cuti">Cuti</option>
									<option value="Dispensasi">Sakit/Dispensasi</option>
									<option value="Kegiatan">Kegiatan PLN</option>
								</select>
							</div>
							<div class="form-group">

								<!----------------------------

								<label>Beban Anggaran</label>

								----------------------------->

								<input type="hidden" name="beban_anggaran" class="form-control" id="beban_anggaran">

							</div>

						</div>

					</div>

					<div class="row">
						<div class="col-12">
							<div class="form-group">
								<label for="uraian_lembur">Uraian</label>
								<textarea class="form-control" id="uraian_lembur" maxlength="200" name="uraian_lembur"></textarea>
							</div>
						</div>
					</div>

					<hr>

					<h5>Personal Pengganti</h5>

					<div class="row">

						<div class="col-6">

							<div class="form-group">

								<label>Nama Pegawai yang Digantikan</label>

								<select class="form-control" style="width: 100%;" name="pegawai_diganti">

									<?php

									if (!empty($this->session->filter_unit)) {

										$pegawai = $this->ganti_jaga_model->pegawai_unit($this->session->filter_unit)->result();

									}

									foreach ($pegawai as $dtp) {

									?>

										<option value="<?php echo $dtp->idtbPegawai; ?>"><?php echo $dtp->namaPegawai; ?></option>

									<?php

									}

									?>

								</select>

							</div>

						</div>

						<div class="col-6">

							<div class="form-group">

								<label>Nama Pegawai yang Menggantikan</label>

								<select class="form-control" style="width: 100%;" name="pegawai_mengganti">

									<?php

									if (!empty($this->session->filter_unit)) {

										$pegawai = $this->ganti_jaga_model->pegawai_unit($this->session->filter_unit)->result();

									}

									foreach ($pegawai as $dtp) {

									?>

										<option value="<?php echo $dtp->idtbPegawai; ?>"><?php echo $dtp->namaPegawai; ?></option>

									<?php

									}

									?>

								</select>

							</div>

						</div>

					</div>

					<hr>

					<h5>Pemeriksa / Pemberi Tugas</h5>

					<div class="row">

						<div class="col-6">

							<label>Pemberi Tugas</label>

							<input type="text" name="nama_pt" class="form-control" id="nama_pt">

						</div>

						<div class="col-5">

							<label>Tanggal</label>

							<input type="date" name="tgl_pt" class="form-control" id="tgl_pt">

						</div>

						<div class="col-1">

							<!------------------------------------

							<label>NID</label>

							-------------------------------------->

							<input type="hidden" name="nid_pt" class="form-control" id="nid_pt">

						</div>

					</div>

					<div class="row">

						<div class="col-4">

							<label>NID</label>

							<input type="text" name="nid_periksa" class="form-control" id="nid_periksa">

						</div>

						<div class="col-4">

							<label>Pemeriksa</label>

							<input type="text" name="nama_periksa" class="form-control" id="nama_periksa">

						</div>

						<div class="col-4">

							<label>Tanggal</label>

							<input type="date" name="tgl_periksa" class="form-control" id="tgl_periksa">

						</div>

					</div>

					<hr>

					<div class="row">

						<div class="col-4">

							<label>Asman</label>

							<input type="text" name="asman" class="form-control" id="nama_periksa">

						</div>

					</div>

					<div class="modal-footer">

						<button type="submit" class="btn btn-primary btn-sm"><span class="fa fa-check"></span> Simpan</button>

						<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><span class="fa fa-times"></span> Close</button>

					</div>

			</form>

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