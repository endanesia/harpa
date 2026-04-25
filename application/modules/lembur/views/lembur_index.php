<?php

if (!empty($error)) {

?>

	<div class="alert alert-danger">

		Gagal Simpan ! Unit Kerja belum dipilih

	</div>

<?php

}

?>

<?php

if ($this->session->flashdata('cetak')) {

?>

	<div class="alert alert-danger" role="alert">

		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>

		<strong>Gagal Cetak</strong> Pegawai belum dipilih Lembur belum di isi

	</div>

<?php

}

?>

<div class="card card-body">

	<div class="row">

		<div class="col-sm-12 col-md-12 text-md-right">

			<a href="" class="btn btn-primary pull-right" data-toggle="modal" data-target="#modalNew"><i class="fa fa-plus"></i> Tambah SPKL</a>

			<form action="<?php echo site_url() . '/lembur' ?>" method="post">

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

			<table class="table table-sm table-striped" id="example1">

				<thead>

					<tr>

						<th>No WO</th>

						<th>Uraian</th>

						<th>Tanggal</th>

						<th>Waktu</th>

						<th>Hari</th>

						<th>Beban Anggaran</th>

						<th>Pemberi Tugas</th>

						<th>Pemeriksa</th>

						<th>Asman</th>

						<th></th>

					</tr>

				</thead>

				<tbody>

					<?php

					foreach ($dt as $lembur) {



					?>

						<tr>

							<td><?php echo $lembur->noWo; ?>

								<!-- modal form untuk INFO data -->

								<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal label" aria-hidden="true" id="modalPerson<?php echo $lembur->id; ?>" data-backdrop="static">

									<div class="modal-dialog modal-lg">

										<div class="modal-content">

											<div class="modal-header">

												<h5 class="modal-title" id="modalTitle_shift">Input Personil SPKL</h5>

												<button type="button" class="close" data-dismiss="modal" aria-label="Close">

													<span aria-hidden="true">&times;</span>

												</button>

											</div>

											<div class="modal-body">

												<form action="<?= site_url('lembur/Simpan_pegawai_lembur') ?>" method="post">

													<div class="form-group">

														<input type="hidden" name="id_lembur" class="form-control" id="id_lembur" value="<?php echo $lembur->id; ?>">

													</div>

													<div class="form-group">

														<label>Nama Pegawai</label>

														<select class="form-control" style="width: 100%;" name="pegawai">

															<?php

															if (isset($this->session->filter_unit)) {

																$pegawai = $this->Lembur_model->pegawai_unit($this->session->filter_unit)->result();

															} else {

																$pegawai = array();

															}

															foreach ($pegawai as $dtp) {

															?>

																<option value="<?php echo $dtp->idtbPegawai; ?>"><?php echo $dtp->namaPegawai . ' (' . $dtp->jabatan . ')'; ?></option>

															<?php

															}

															?>

														</select>

													</div>

													<hr>

													<table class="table table-primary table-striped">

														<thead>

															<tr>

																<th>NIP</th>

																<th>Nama Pegawai</th>

																<th>Aksi</th>

															</tr>

														</thead>

														<tbody>

															<?php

															$list_lembur = $this->Lembur_model->detail_lembur_id($lembur->id)->result();

															foreach ($list_lembur as $personil) {

																$plembur = $this->Lembur_model->pegawai_id($personil->idtbPegawai)->row();

															?>

																<tr>

																	<td><?php echo $plembur->nipBaru; ?></td>

																	<td><?php echo $plembur->namaPegawai; ?></td>

																	<td>

																		<a href="<?= site_url('lembur/Hapus_pegawai_lembur/' . $personil->id) ?>" class="btn btn-xs btn-danger" title="hapus data"><i class="fa fa-trash"></i></a>

																	</td>

																</tr>

															<?php

															}

															?>

														</tbody>

													</table>

													<div class="modal-footer">

														<button type="submit" class="btn btn-primary btn-sm"><span class="fa fa-check"></span> Simpan</button>

														<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><span class="fa fa-times"></span> Close</button>

													</div>

												</form>

											</div>

										</div>

									</div>

									<!-----end modal INFO----------->

							</td>

							<td style="width:100px;"><?php echo $lembur->uraian; ?></td>

							<td><?php echo date("d-m-Y", strtotime($lembur->tglLembur)); ?>

								<?php

								if ($lembur->status == 1) {

									echo "<br><small>Valid " . date("d-m-Y", strtotime($lembur->tgl_validasi)) . "</small>";

								}

								?>

							</td>

							<td><?php echo $lembur->mulai . ' s/d ' . $lembur->sampai; ?></td>

							<td><?php echo $lembur->statusHari; ?></td>

							<td><?php echo $lembur->bebanAnggaran; ?></td>

							<td><?php echo $lembur->namaPemberiTugas; ?></td>

							<td><?php echo $lembur->namaPemeriksa; ?></td>

							<td><?php echo $lembur->namaAsman; ?></td>

							<td>

								<a href="<?php echo site_url() . '/lembur/Cetak_lembur/' . $lembur->id; ?>" target="_blank" class="btn btn-xs btn-info" title="cetak formulir"><i class="fa fa-print "></i></a>

								<?php if ($lembur->status != 1) { ?>

									<a href="" class="btn btn-xs btn-success" title="Personel yg Lembur" data-toggle="modal" data-target="#modalPerson<?php echo $lembur->id ?>"><i class="fa fa-user "></i></a>

									<a href="" class="btn btn-xs btn-warning" title="Edit Data" data-toggle="modal" data-target="#modalEdit<?php echo $lembur->id ?>"><i class="fa fa-pencil"></i></a> |

									<a href="<?php echo site_url() . '/lembur/Hapus/' . $lembur->id; ?>" class="btn btn-xs btn-danger" title="hapus data"><i class="fa fa-trash"></i></a>

								<?php } ?>

								<!-- modal form untuk edit data -->

								<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal label" aria-hidden="true" id="modalEdit<?php echo $lembur->id ?>" data-backdrop="static">

									<div class="modal-dialog modal-lg">

										<div class="modal-content">

											<div class="modal-header">

												<h5 class="modal-title" id="modalTitle_shift">Edit SPKL</h5>

												<button type="button" class="close" data-dismiss="modal" aria-label="Close">

													<span aria-hidden="true">&times;</span>

												</button>

											</div>

											<form action="<?= site_url('lembur/Update') ?>" method="post">

												<div class="modal-body">

													<input type="hidden" name="id" value="<?php echo $lembur->id; ?>" class="form-control" id="id">

													<div class="row">

														<div class="col-6">

															<div class="form-group">

																<label for="tgl_wo">Tanggal</label>

																<input type="date" value="<?php echo $lembur->tglLembur; ?>" name="tgl_wo" class="form-control" id="tgl_wo" required>

															</div>

														</div>

														<div class="col-2">

															<div class="form-group">

																

																<label>Aktivitas</label>

																

																<select class="form-control" style="width: 100%;" name="aktivitas">

																	<option value="" <?= $lembur->kodeAktifitas == '' ? ' selected ' : '' ?>>Aktivitas</option>

																	<option value="18" <?= $lembur->kodeAktifitas == '18' ? ' selected ' : '' ?>>K3</option>

																	<option value="19" <?= $lembur->kodeAktifitas == '19' ? ' selected ' : '' ?>>Lingkungan</option>

																	<option value="20" <?= $lembur->kodeAktifitas == '20' ? ' selected ' : '' ?>>Preventive Maintenance</option>

																	<option value="21" <?= $lembur->kodeAktifitas == '21' ? ' selected ' : '' ?>>Predictive Maintenance</option>

																	<option value="22" <?= $lembur->kodeAktifitas == '22' ? ' selected ' : '' ?>>Corrective Maintenance</option>

																	<option value="24" <?= $lembur->kodeAktifitas == '24' ? ' selected ' : '' ?>>Overhoul / Inspection</option>

																	<option value="26" <?= $lembur->kodeAktifitas == '26' ? ' selected ' : '' ?>>Engineering / Project / Modifikasi</option>

																	<option value="60" <?= $lembur->kodeAktifitas == '60' ? ' selected ' : '' ?>>Non Instalasi / Umum</option>

																</select>

															</div>

														</div>

														<div class="col-3">

															<div class="form-group">

																<label>Keterangan Hari</label>

																<?php

																if ($lembur->statusHari == "Kerja") {

																?>

																	<select class="form-control" style="width: 100%;" name="hari">

																		<option value="Kerja" selected="selected">Kerja</option>

																		<option value="Libur">Libur</option>

																	</select>

																<?php

																} else {

																?>

																	<select class="form-control" style="width: 100%;" name="hari">

																		<option value="Kerja">Kerja</option>

																		<option value="Libur" selected="selected">Libur</option>

																	</select>

																<?php

																}

																?>

															</div>

														</div>

													</div>

													<label>Waktu Lembur</label>

													<div class="row">

														<div class="col-1">

															<div class="form-group">

																<label>Jam</label>

																<input type="text" value="<?php echo substr($lembur->mulai, 0, 2); ?>" name="jam_awal_lembur" class="form-control" id="jam_awal_lembur" required>

															</div>

														</div>

														<div class="col-1">

															<p style="text-align:center;margin-top:40px;">:</p>

														</div>

														<div class="col-1">

															<div class="form-group">

																<label>Menit</label>

																<input type="text" value="<?php echo substr($lembur->mulai, 3, 2); ?>" name="menit_awal_lembur" class="form-control" id="menit_awal_lembur" required>

															</div>

														</div>

														<div class="col-1">

															<p style="text-align:center;margin-top:40px;">s/d</p>

														</div>

														<div class="col-1">

															<div class="form-group">

																<label>Jam</label>

																<input type="text" value="<?php echo substr($lembur->sampai, 0, 2); ?>" name="jam_akhir_lembur" class="form-control" id="jam_akhir_lembur" required>

															</div>

														</div>

														<div class="col-1">

															<p style="text-align:center;margin-top:40px;">:</p>

														</div>

														<div class="col-1">

															<div class="form-group">

																<label>Menit</label>

																<input type="text" value="<?php echo substr($lembur->mulai, 3, 2); ?>" name="menit_akhir_lembur" class="form-control" id="menit_akhir_lembur" required>

															</div>

														</div>

														<div class="col-5">

															<div class="form-group">

																<!----------------------------

																<label>Beban Anggaran</label>

																------------------------------>

																<input type="hidden" value="<?php echo $lembur->bebanAnggaran; ?>" name="beban_anggaran" class="form-control" id="beban_anggaran">

															</div>

														</div>

													</div>

													<div class="row">

														<div class="col-12">

															<div class="form-group">

																<label for="uraian_lembur">Uraian</label>

																<textarea class="form-control" id="uraian_lembur" maxlength="200" name="uraian_lembur"><?php echo $lembur->uraian; ?></textarea>

															</div>

														</div>

													</div>

													<hr>

													<div class="row">

														<div class="col-4">

															<label>NID</label>

															<input type="text" value="<?php echo $lembur->nidPemberiTugas; ?>" name="nid_pt" class="form-control" id="nid_pt">

														</div>

														<div class="col-4">

															<label>Pemberi Tugas</label>

															<input type="text" value="<?php echo $lembur->namaPemberiTugas; ?>" name="nama_pt" class="form-control" id="nama_pt">

														</div>

														<div class="col-4">

															<label>Tanggal</label>

															<input type="date" value="<?php echo $lembur->tglPemberiTugas; ?>" name="tgl_pt" class="form-control" id="tgl_pt">

														</div>

													</div>

													<div class="row">

														<div class="col-4">

															<label>NID</label>

															<input type="text" value="<?php echo $lembur->nidPemeriksa; ?>" name="nid_periksa" class="form-control" id="nid_periksa">

														</div>

														<div class="col-4">

															<label>Pemeriksa</label>

															<input type="text" value="<?php echo $lembur->namaPemeriksa; ?>" name="nama_periksa" class="form-control" id="nama_periksa">

														</div>

														<div class="col-4">

															<label>Tanggal</label>

															<input type="date" value="<?php echo $lembur->tglPemeriksa; ?>" name="tgl_periksa" class="form-control" id="tgl_periksa">

														</div>

													</div>

													<hr>

													<div class="row">

														<div class="col-6">

															<label>Asman</label>

															<input type="text" value="<?php echo $lembur->namaAsman; ?>" name="asman" class="form-control" id="nama_periksa">

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

								<!-----end modal edit----------->

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

				<h5 class="modal-title" id="modalTitle_shift">Input SPKL</h5>

				<button type="button" class="close" data-dismiss="modal" aria-label="Close">

					<span aria-hidden="true">&times;</span>

				</button>

			</div>

			<form action="<?= site_url('lembur/Simpan') ?>" method="post">

				<div class="modal-body">

					<div class="row">

						<div class="col-12">

							<div class="form-group">

								<!------------------------------

								<label for="wo">Nomor Wo</label>

								-------------------------------->

								<input type="hidden" name="wo" class="form-control" id="wo" required>

							</div>

						</div>

					</div>

					<div class="row">

						<div class="col-6">

							<div class="form-group">

								<label for="tgl_wo">Tanggal Lembur</label>

								<input type="date" name="tgl_wo" class="form-control" id="tgl_wo" required>

							</div>

						</div>

						<div class="col-2">

							<div class="form-group">

								

								<label>Aktivitas</label>

								

								<select class="form-control" style="width: 100%;" name="aktivitas">

									<option value="">Aktivitas</option>

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

						<div class="col-3">

							<div class="form-group">

								<label>Keterangan Hari</label>

								<select class="form-control" style="width: 100%;" name="hari">

									<option value="Kerja">Kerja</option>

									<option value="Libur">Libur</option>

								</select>

							</div>

						</div>

					</div>

					<label>Waktu Lembur</label>

					<div class="row">

						<div class="col-1">

							<div class="form-group">

								<label>Jam</label>

								<input type="text" name="jam_awal_lembur" class="form-control" id="jam_awal_lembur" required>

							</div>

						</div>

						<div class="col-1">

							<p style="text-align:center;margin-top:40px;">:</p>

						</div>

						<div class="col-1">

							<div class="form-group">

								<label>Menit</label>

								<input type="text" name="menit_awal_lembur" class="form-control" id="menit_awal_lembur" required>

							</div>

						</div>

						<div class="col-1">

							<p style="text-align:center;margin-top:40px;">s/d</p>

						</div>

						<div class="col-1">

							<div class="form-group">

								<label>Jam</label>

								<input type="text" name="jam_akhir_lembur" class="form-control" id="jam_akhir_lembur" required>

							</div>

						</div>

						<div class="col-1">

							<p style="text-align:center;margin-top:40px;">:</p>

						</div>

						<div class="col-1">

							<div class="form-group">

								<label>Menit</label>

								<input type="text" name="menit_akhir_lembur" class="form-control" id="menit_akhir_lembur" required>

							</div>

						</div>

						<div class="col-5">

							<div class="form-group">

								<!---------------------------

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

					<div class="row">

						<div class="col-4">

							<label>NID</label>

							<input type="text" name="nid_pt" class="form-control" id="nid_pt">

						</div>

						<div class="col-4">

							<label>Pemberi Tugas</label>

							<input type="text" name="nama_pt" class="form-control" id="nama_pt">

						</div>

						<div class="col-4">

							<label>Tanggal</label>

							<input type="date" name="tgl_pt" class="form-control" id="tgl_pt">

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

						<div class="col-6">

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



	window.setTimeout(function() {

		$(".alert").fadeTo(500, 0).slideUp(500, function() {

			$(this).remove();

		});

	}, 2000);

</script>