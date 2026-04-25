<div class="card card-body">



	<form enctype='multipart/form-data' method="post" action="<?= site_url('pegawai/Simpan/' . $cUnit . '/' . $cJabatan) ?>">

		<input type="hidden" name="idtbPegawai" value="<?= $cID ?>">

		<div class="row">

			<div class="col-md-2">

				<?php if ($cID == 0) { ?>

					<img id="gbr" src="<?= base_url('assets/profil/blank.jpg') ?>" width="160px" style="border-width:1px; border-style:solid; display: block; margin-left: auto;  margin-right: auto;">

				<?php } else { ?>

					<img id="gbr" src="<?= $dt->fotoPegawai != '' ? base_url('assets/profil/' . $dt->fotoPegawai) : base_url('assets/profil/blank.jpg') ?>" width="160px" style="border-width:1px; border-style:solid; display: block; margin-left: auto;  margin-right: auto;">

				<?php } ?>

				<div class="input-group mb-3" style="padding: 10px 10px 10px 10px">

					<div class="custom-file">

						<input type="file" class="custom-file-input" id="inputGroupFile01" name="fotoPegawai" accept=".jpg,.png,.jpeg,.gif" onchange="showPreview(event);">

						<label class="custom-file-label" for="inputGroupFile01">Pilih foto</label>

					</div>

					<p style="font-size:10pt;font-style: italic;">*Ukuran Foto maksimal 500kb Ukuran Maksimal 1024 x 768  </p>

				</div>

				<div class="form-group" style="padding: 10px 10px 10px 10px">

					Bergabung Sejak :

					<input type="date" name="tglBergabung" class="form-control" value="<?= $cID == 0 ? '' : $dt->tglBergabung ?>">

				</div>
				<div class="form-group" style="padding: 10px 10px 10px 10px">
					Awal Kontrak:
					<input type="date" name="awal_kontrak" class="form-control" value="<?= $cID == 0 ? '' : $dt->awal_kontrak ?>">
				</div>
				<div class="form-group" style="padding: 10px 10px 10px 10px">
					Akhir Kontrak:
					<input type="date" name="akhir_kontrak" class="form-control" value="<?= $cID == 0 ? '' : $dt->akhir_kontrak ?>">
				</div>
			</div>

			<div class="col-md-6">

				<div class="row form-group">

					<div class="col-md-3">NIP</div>

					<div class="col-md-3"><input type="text" name="nipBaru" class="form-control" value="<?= $cID == 0 ? '' : $dt->nipBaru ?>" required></div>

					<div class="col-md-1" align="right">NIK</div>

					<div class="col-md-4"><input type="text" name="NIK" class="form-control" value="<?= $cID == 0 ? '' : $dt->NIK ?>" required></div>

				</div>

				<div class="row form-group">

					<div class="col-md-3">Nama</div>

					<div class="col-md-8"><input type="text" name="namaPegawai" class="form-control" value="<?= $cID == 0 ? '' : $dt->namaPegawai ?>" required></div>

				</div>

				<div class="row form-group">

					<div class="col-md-3">Tmp, Tgl lahir</div>

					<div class="col-md-8">

						<div class="input-group mb-6">

							<input type="text" class="form-control" name="tempatLahir" aria-describedby="basic-addon2" value="<?= $cID == 0 ? '' : $dt->tempatLahir ?>">

							<input type="date" name="tanggalLahir" class="form-control" value="<?= $cID == 0 ? '' : $dt->tanggalLahir ?>">

						</div>

					</div>

				</div>

				<div class="row form-group">

					<div class="col-md-3">Jenis Kelamin</div>

					<div class="col-md-3">

						<select name="jenisKelamin" class="form-control" required>

							<?php

							switch ($dt->jenisKelamin) {

								case "Laki-laki":

							?>

									<option value="Laki-laki" selected="selected">Laki-laki</option>

									<option value="Perempuan">Perempuan</option>

								<?php

									break;

								case "Perempuan":

								?>

									<option value="Laki-laki">Laki-laki</option>

									<option value="Perempuan" selected="selected">Perempuan</option>

								<?php

									break;

								default:

								?>

									<option value="Laki-laki">Laki-laki</option>

									<option value="Perempuan">Perempuan</option>

							<?php

							}

							?>

						</select>

					</div>

					<div class="col-md-2 " align="right">Agama</div>

					<div class="col-md-3">

						<select name="agama" class="form-control" required>

							<?php

							switch ($dt->agama) {

								case "Islam":

							?>



									<option value="Islam" selected="selected">Islam</option>

									<option value="Kristen Protestan">Kristen Protestan</option>

									<option value="Kristen Katolik">Kristen Katolik</option>

									<option value="Hindu">Hindu</option>

									<option value="Budha">Budha</option>

									<option value="Lain-lain">Lainnya</option>

								<?php

									break;

								case "Kristen Protestan":

								?>

									<option value="Islam">Islam</option>

									<option value="Kristen Protestan" selected="selected">Kristen Protestan</option>

									<option value="Kristen Katolik">Kristen Katolik</option>

									<option value="Hindu">Hindu</option>

									<option value="Budha">Budha</option>

									<option value="Lain-lain">Lainnya</option>

								<?php

									break;

								case "Kristen Katolik":

								?>

									<option value="Islam">Islam</option>

									<option value="Kristen Protestan">Kristen Protestan</option>

									<option value="Kristen Katolik" selected="selected">Kristen Katolik</option>

									<option value="Hindu">Hindu</option>

									<option value="Budha">Budha</option>

									<option value="Lain-lain">Lainnya</option>

								<?php

									break;

								case "Hindu":

								?>

								<option value="Islam">Islam</option>

								<option value="Kristen Protestan">Kristen Protestan</option>

								<option value="Kristen Katolik">Kristen Katolik</option>

								<option value="Hindu" selected="selected">Hindu</option>

								<option value="Budha">Budha</option>

								<option value="Lain-lain">Lainnya</option>

							<?php

									break;

								case "Budha":

							?>

							<option value="Islam">Islam</option>

							<option value="Kristen Protestan">Kristen Protestan</option>

							<option value="Kristen Katolik">Kristen Katolik</option>

							<option value="Hindu">Hindu</option>

							<option value="Budha" selected="selected">Budha</option>

							<option value="Lain-lain">Lainnya</option>

						<?php

									break;

								case "Lain-lain":

						?>

						<option value="Islam">Islam</option>

						<option value="Kristen Protestan">Kristen Protestan</option>

						<option value="Kristen Katolik">Kristen Katolik</option>

						<option value="Hindu">Hindu</option>

						<option value="Budha">Budha</option>

						<option value="Lain-lain" selected="selected">Lainnya</option>

					<?php

								default:

					?>

						<option value="Islam">Islam</option>

						<option value="Kristen Protestan">Kristen Protestan</option>

						<option value="Kristen Katolik">Kristen Katolik</option>

						<option value="Hindu">Hindu</option>

						<option value="Budha">Budha</option>

						<option value="Lain-lain">Lainnya</option>

				<?php

							}

				?>

						</select>

					</div>

				</div>

				<div class="row form-group">

					<div class="col-md-3">Pendidikan Terakhir</div>

					<div class="col-md-3">

						<select name="pendidikan" class="form-control" required>

							<?php

							switch ($dt->pendidikan) {

								case "SD":

							?>

									<option value="SD" selected="selected">SD</option>

									<option value="SMP">SMP</option>

									<option value="SMA">SMA</option>

									<option value="DIPLOMA">DIPLOMA</option>

									<option value="S1">S1</option>

								<?php

									break;

								case "SMP":

								?>

									<option value="SD">SD</option>

									<option value="SMP" selected="selected">SMP</option>

									<option value="SMA">SMA</option>

									<option value="DIPLOMA">DIPLOMA</option>

									<option value="S1">S1</option>

								<?php

									break;

									case "SMA":

								?>

									<option value="SD">SD</option>

									<option value="SMP">SMP</option>

									<option value="SMA" selected="selected">SMA</option>

									<option value="DIPLOMA">DIPLOMA</option>

									<option value="S1">S1</option>

								<?php

									break;

									case "DIPLOMA":

								?>

									<option value="SD">SD</option>

									<option value="SMP">SMP</option>

									<option value="SMA">SMA</option>

									<option value="DIPLOMA" selected="selected">DIPLOMA</option>

									<option value="S1">S1</option>

								<?php

									break;

									case "S1":

								?>

									<option value="SD">SD</option>

									<option value="SMP">SMP</option>

									<option value="SMA">SMA</option>

									<option value="DIPLOMA">DIPLOMA</option>

									<option value="S1" selected="selected">S1</option>

								<?php

									break;

								default:

								?>

									<option value="SD">SD</option>

									<option value="SMP">SMP</option>

									<option value="SMA">SMA</option>

									<option value="DIPLOMA">DIPLOMA</option>

									<option value="S1">S1</option>

							<?php

							}

							?>

						</select>

					</div>

					<div class="col-md-2 " align="right">Gol. Darah</div>

					<div class="col-md-3">

						<select name="golongan_darah" class="form-control" required>

							<?php

							switch ($dt->golongan_darah) {

								case "A":

							?>



									<option value="A" selected="selected">A</option>

									<option value="B">B</option>

									<option value="AB">AB</option>

									<option value="O">O</option>

									<option value="Tidak Tahu">Tidak Tahu</option>

								<?php

									break;

								case "B":

								?>

									<option value="A">A</option>

									<option value="B" selected="selected">B</option>

									<option value="AB">AB</option>

									<option value="O">O</option>

									<option value="Tidak Tahu">Tidak Tahu</option>

								<?php

									break;

								case "AB":

								?>

									<option value="A">A</option>

									<option value="B">B</option>

									<option value="AB" selected="selected">AB</option>

									<option value="O">O</option>

									<option value="Tidak Tahu">Tidak Tahu</option>

								<?php

									break;

								case "O":

								?>

								<option value="A">A</option>

								<option value="B">B</option>

								<option value="AB">AB</option>

								<option value="O" selected="selected">O</option>

								<option value="Tidak Tahu">Tidak Tahu</option>

							<?php

									break;

								case "Tidak Tahu":

							?>

							<option value="A">A</option>

							<option value="B">B</option>

							<option value="AB">AB</option>

							<option value="O">O</option>

							<option value="Tidak Tahu" selected="selected">Tidak Tahu</option>

						<?php

									break;

						

								default:

					?>

						<option value="A">A</option>

						<option value="B">B</option>

						<option value="AB">AB</option>

						<option value="O">O</option>

						<option value="Tidak Tahu">Tidak Tahu</option>

				<?php

							}

				?>

						</select>

					</div>

				</div>

				<div class="row form-group">

					<div class="col-md-3">Status Pernikahan</div>

					<div class="col-md-8">

						<select name="statusPernikahan" class="form-control" required>

							<?php

							switch ($dt->statusPernikahan) {

								case "Belum Menikah":

							?>

									<option value="Belum Menikah" selected="">Belum Menikah</option>

									<option value="Menikah">Menikah</option>

									<option value="Duda/Janda">Duda/Janda</option>

								<?php

									break;

								case "Menikah":

								?>

								<option value="Belum Menikah">Belum Menikah</option>

								<option value="Menikah" selected="selected">Menikah</option>

								<option value="Duda/Janda">Duda/Janda</option>

							<?php

									break;

								case "Duda/Janda":

							?>

								<option value="Belum Menikah">Belum Menikah</option>

								<option value="Menikah">Menikah</option>

								<option value="Duda/Janda" selected="selected">Duda/Janda</option>

							<?php

									break;

								default:

							?>

								<option value="Belum Menikah">Belum Menikah</option>

								<option value="Menikah">Menikah</option>

								<option value="Duda/Janda">Duda/Janda</option>

						<?php

							}

						?>

						</select>

					</div>

				</div>

				<div class="row form-group">

					<div class="col-md-3">Telepon</div>

					<div class="col-md-8"><input type="text" name="telepon" class="form-control" value="<?= $cID == 0 ? '' : $dt->telepon ?>"></div>

				</div>

				<div class="row form-group">

					<div class="col-md-3">Alamat</div>

					<div class="col-md-8"><textarea name="alamat" class="form-control" rows="3"><?= $cID == 0 ? '' : $dt->alamat ?></textarea></div>

				</div>

				<div class="row form-group">

					<div class="col-md-3">Alamat Email</div>

					<div class="col-md-8"><input type="text" name="email" class="form-control" value="<?= $cID == 0 ? '' : $dt->email ?>"></div>

				</div>

				<div class="row form-group">

					<div class="col-md-3">Nomor NPWP</div>

					<div class="col-md-8"><input type="text" name="nomorNPWP" class="form-control" value="<?= $cID == 0 ? '' : $dt->nomorNPWP ?>"></div>

				</div>

				<div class="row form-group">

					<div class="col-md-4">Nomor BPJS Ketenagakerjaan</div>

					<div class="col-md-7"><input type="text" name="bpjs_tenagakerja" class="form-control" value="<?= $cID == 0 ? '' : $dt->bpjs_tenagakerja ?>"></div>

				</div>

				<div class="row form-group">

					<div class="col-md-4">Nomor BPJS Kesehatan</div>

					<div class="col-md-7"><input type="text" name="bpjs_kesehatan" class="form-control" value="<?= $cID == 0 ? '' : $dt->bpjs_kesehatan ?>"></div>

				</div>

				<div class="row form-group">

					<div class="col-md-4">Status Tunjangan</div>

					<div class="col-md-3"><select class="form-control" name="status_pegawai">

						<option value="TK" <?= isset($dt) && $dt->status_pegawai == 'TK' ? ' selected ' : '' ?>>TK</option>

						<option value="K0" <?= isset($dt) && $dt->status_pegawai == 'K0' ? ' selected ' : '' ?>>K0</option>

						<option value="K1" <?= isset($dt) && $dt->status_pegawai == 'K1' ? ' selected ' : '' ?>>K1</option>

						<option value="K2" <?= isset($dt) && $dt->status_pegawai == 'K2' ? ' selected ' : '' ?>>K2</option>

						<option value="K3" <?= isset($dt) && $dt->status_pegawai == 'K3' ? ' selected ' : '' ?>>K3</option>

					</select></div>

				</div>

			</div>

			<!--------------------kolom 2----------------------->

			<div class="col-md-4">

				<div class="row form-group">

					<div class="col-md-4">Jabatan</div>

					<div class="col-md-8">

						<select name="idJabatan" class="form-control" id="idJabatan">

							<option value="0">-- Pilih Jabatan --</option>

							<?php foreach ($jabatan as $j) {

								if ($cID == 0) { ?>

									<option value="<?= $j->idJabatan ?>"><?= $j->namaJabatan ?></option>

								<?php } else { ?>

									<option value="<?= $j->idJabatan ?>" <?= $j->idJabatan == $dt->idJabatan ? ' selected ' : '' ?>><?= $j->namaJabatan ?></option>

							<?php }

							} ?>

						</select>

					</div>



				</div>

				<div class="row form-group">

					<div class="col-md-4">Golongan</div>

					<div class="col-md-5">

						<select name="kelasJabatan" class="form-control" id="kelasJabatan">

							<option value="0">-- Pilih Golongan --</option>

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

				<div class="row form-group">

					<div class="col-md-4">Unit</div>

					<div class="col-md-8">

						<select name="skpd" class="form-control">

							<option value="0">-- Pilih Unit --</option>

							<?php foreach ($unit as $u) {

								if ($cID == 0) { ?>

									<option value="<?= $u->id ?>"><?= $u->nama ?></option>

								<?php } else { ?>

									<option value="<?= $u->id ?>" <?= $u->id == $dt->skpd ? ' selected ' : '' ?>><?= $u->nama ?></option>

							<?php }

							} ?>

						</select>

					</div>

				</div>

				<div class="row form-group">

					<div class="col-md-4">Jenis Kepegawaian</div>

					<div class="col-md-6">

						<select name="jenisPegawai" class="form-control">

							<option value="0">-- Jenis Kepegawaian --</option>

							<?php

							switch ($dt->jenisPegawai) {

								case "PKWT":

							?>

									<option value="PKWT" selected="selected">PKWT</option>

									<option value="PKWTT">PKWTT</option>

								<?php

									break;

								case "PKWTT":

								?>

									<option value="PKWT">PKWT</option>

									<option value="PKWTT" selected="selected">PKWTT</option>

								<?php

									break;

								default:

								?>

									<option value="PKWT">PKWT</option>

									<option value="PKWTT">PKWTT</option>

							<?php

							}

							?>

						</select>

					</div>

				</div>

				<div class="row form-group">

					<div class="col-md-4">Gaji Pokok</div>

					<div class="col-md-6"><input type="number" name="gaji" class="form-control" value="<?= $cID == 0 ? '' : $dt->gaji ?>"></div>

				</div>

				<div class="row form-group">

					<div class="col-md-4">Nomor Rekening</div>

					<div class="col-md-8">

						<div class="input-group mb-6">

							<input type="text" class="form-control" name="norek" aria-describedby="basic-addon2" value="<?= $cID == 0 ? '' : $dt->norek ?>" required>

						</div>

					</div>

				</div>

				<div class="row form-group">

					<div class="col-md-4">Nama Bank</div>

					<div class="col-md-8">

						<div class="input-group mb-6">

							<input type="text" class="form-control" name="nama_bank" aria-describedby="basic-addon2" value="<?= $cID == 0 ? '' : $dt->nama_bank ?>" required>

						</div>

					</div>

				</div>

				<div class="row form-group">

					<div class="col-md-4">Atas Nama</div>

					<div class="col-md-8">

						<div class="input-group mb-6">

							<input type="text" class="form-control" name="an_rek" aria-describedby="basic-addon2" value="<?= $cID == 0 ? '' : $dt->an_rek ?>" required>

						</div>

					</div>

				</div>

				<div class="row form-group">

					<div class="col-md-4">Status</div>

					<div class="col-md-6">

						<select name="flagStatus" class="form-control">

							<option value="1">Aktif</option>

							<option value="0">Tidak Aktif</option>

						</select>

					</div>

				</div>

			</div>

			<div class="col-md-12">

				<a href="<?= site_url('pegawai/show/' . $cUnit . '/' . $cJabatan) ?>" class="btn btn-warning pull-right"><i class="fa fa-cancel"></i> Batal</a>

				<button type="submit" class="btn btn-primary pull-right" style="margin-right:10px"><i class="fa fa-check"></i> Simpan</button>

			</div>

		</div>

	</form>

</div>



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



	function showPreview(event) {

		if (event.target.files.length > 0) {

			var src = URL.createObjectURL(event.target.files[0]);

			var preview = document.getElementById("gbr");

			preview.src = src;

			preview.style.display = "block";

		}

	}

</script>