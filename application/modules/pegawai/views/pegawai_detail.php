<div class="card card-body">
	<div class="row">
		<div class="col-md-2" style="text-align:center;">
			<img id="gbr" src="<?= $dt->fotoPegawai != '' ? base_url('assets/profil/' . $dt->fotoPegawai) : base_url('assets/profil/blank.jpg') ?>" width="100%" style="border-width:1px; border-style:solid; display: block; margin-left: auto;  margin-right: auto;">
			<b><?= $dt->namaPegawai ?></b><br>
			<small><?= $dt->nipBaru ?></small><br>
			<?= $dt->jabatan ?><br>
			<?= $unit->nama ?><br>
			Bergabung <?= date_format(date_create($dt->tglBergabung), 'd M Y') ?>
			<?= $cTab ?>
		</div>
		<div class="col-md-10">
			<nav>
				<div class="nav nav-tabs" id="nav-tab" role="tablist">
					<a class="nav-item nav-link <?= $cTab == 0 ? 'active' : '' ?>" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="<?= $cTab == 0 ? 'true' : 'false' ?>">Tunjangan</a>
					<a class="nav-item nav-link <?= $cTab == 1 ? 'active' : '' ?>" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="<?= $cTab == 1 ? 'true' : 'false' ?>">Tunjangan Khusus</a>
					<a class="nav-item nav-link <?= $cTab == 2 ? 'active' : '' ?>" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="<?= $cTab == 2 ? 'true' : 'false' ?>">Potongan</a>
					<a class="nav-item nav-link <?= $cTab == 3 ? 'active' : '' ?>" id="nav-contact-tab" data-toggle="tab" href="#nav-potongan" role="tab" aria-controls="nav-contact" aria-selected="<?= $cTab == 3 ? 'true' : 'false' ?>">Potongan Khusus</a>
				</div>
			</nav>
			<div class="tab-content" id="nav-tabContent">
				<div class="tab-pane fade <?= $cTab == 0 ? 'show active' : '' ?>" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
					<table class="table">
						<thead>
							<tr>
								<th>No</th>
								<th>Tunjangan</th>
								<th>Nilai</th>
								<th>Satuan</th>
								<th style="text-align:center;">T.Kontribusi</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$no = 1;
							foreach ($tunjangan as $t) {
							?>
								<tr>
									<td><?= $no ?></td>
									<td><?= $t->namaTunjangan ?></td>
									<td><?= number_format($t->nilai, 0, ",", ".") ?></td>
									<td><?= $t->satuan ?></td>
									<td style="text-align:center;"><?= $t->tunjKontribusi == 1 ? '<i class="fa fa-check"></i>' : '' ?></td>
								</tr>
							<?php $no++;
							} ?>
						</tbody>
					</table>
				</div>
				<div class="tab-pane fade <?= $cTab == 1 ? 'show active' : '' ?>" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
					<a href="" data-toggle="modal" data-target="#modalAdd_tunjangan" id="add" title="Tambah tunjangan" class="btn btn-primary text-white btn-sm pull-right"><span class="fa fa-plus"></span> Tambah Tunjangan</a>
					<table class="table">
						<thead>
							<tr>
								<th>No</th>
								<th>Tunjangan</th>
								<th>Nilai</th>
								<th>Satuan</th>
								 <th style="text-align:center;">T.Kontribusi</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php
							$no = 1;
							foreach ($tunjKhusus as $td) {
							?>
								<tr>
									<td><?= $no ?></td>
									<td><?= $td->namaTunjangan ?></td>
									<td><?= number_format($td->nilai, 0, ",", ".") ?></td>
									<td><?= $td->satuan ?></td>
									 <td><?= $td->tunjKontribusi == 1 ? '<i class="fa fa-check"></i>' : '' ?></td>
									<td style="text-align:center;"><a href="#" class="btn btn-warning btn-sm" title="edit" data-toggle="modal" data-target="#modalEdit_tunjangan<?= $td->id ?>"><i class="fa fa-pencil"></i></a> <a href="#" class="btn btn-danger btn-sm" title="Hapus" data-toggle="modal" data-target="#modalDel_tunjangan<?= $td->id ?>"><i class="fa fa-trash"></i></a></td>
								</tr>
							<?php $no++;
							} ?>
						</tbody>
					</table>
				</div>
				<!-- isi potongan  -->
				<div class="tab-pane fade <?= $cTab == 2 ? 'show active' : '' ?>" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">

					<table class="table">
						<thead>
							<tr>
								<th>No</th>
								<th>Potongan</th>
								<th>Nilai</th>
								<th>Satuan</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$no = 1;
							foreach ($potongan as $pk) {
							?>
								<tr>
									<td><?= $no ?></td>
									<td><?= $pk->namaPotongan ?></td>
									<td><?= number_format($pk->nilai, 0, ",", ".") ?></td>
									<td><?= $pk->satuan ?></td>

								</tr>
							<?php $no++;
							} ?>
						</tbody>
					</table>
				</div>
				<!-- isi potongan khusus -->
				<div class="tab-pane fade <?= $cTab == 3 ? 'show active' : '' ?>" id="nav-potongan" role="tabpanel" aria-labelledby="nav-contact-tab">
					<a href="" data-toggle="modal" data-target="#modalAdd_potongan" id="add" title="Tambah Potongan" class="btn btn-primary text-white btn-sm pull-right"><span class="fa fa-plus"></span> Tambah Potongan</a>
					<table class="table">
						<thead>
							<tr>
								<th>No</th>
								<th>Potongan</th>
								<th>Nilai</th>
								<th>Satuan</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php
							$no = 1;
							foreach ($potKhusus as $pk) {
							?>
								<tr>
									<td><?= $no ?></td>
									<td><?= $pk->namaPotongan ?></td>
									<td><?= number_format($pk->nilai, 0, ",", ".") ?></td>
									<td><?= $pk->satuan ?></td>
									<td><a href="#" class="btn btn-warning btn-sm" title="edit" data-toggle="modal" data-target="#modalEdit_potongan<?= $pk->id ?>"><i class="fa fa-pencil"></i></a> <a href="#" class="btn btn-danger btn-sm" title="Hapus" data-toggle="modal" data-target="#modalDel_potongan<?= $pk->id ?>"><i class="fa fa-trash"></i></a></td>
								</tr>
							<?php $no++;
							} ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12" align="center">
			<a href="<?= site_url('pegawai/index/' . $cUnit . '/' . $cJabatan ) ?>" class="btn btn-secondary btn-sm"><i class="fa fa-arrow-left"></i> Kembali</a>
		</div>
	</div>
</div>

</div>

<!-- modal form untuk menambah tunjangan khusus -->
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal label" aria-hidden="true" id="modalAdd_tunjangan" data-backdrop="static">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalTitle_jabatan">Tambah Tunjangan Khusus</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<form action="<?= site_url('pegawai/TunjanganKhusus/') . $cID . "/" . $cUnit . '/' . $cJabatan ?>" method="post">

				<div class="modal-body">
					<div class="form-group">
						<label>Nama Tunjangan</label>
						<input type="text" name="namaTunjangan" class="form-control" required>
					</div>
					<div class="form-group">
						<label>Nilai Tunjangan (Rp)</label>
						<input type="number" name="nilai" class="form-control" required>
					</div>
					<div class="form-group">
						<label>Satuan Hitung</label>
						<select name="satuan" class="form-control">
							<option value="Bulan">Per Bulan</option>
							<option value="Hari">Per Hari</option>
							<option value="Jam">Per Jam</option>
						</select>
					</div>
					<div class="form-group">
						<div class="custom-control custom-checkbox">
							<input type="checkbox" class="custom-control-input" id="tunjKontribusi" name="tunjKontribusi" value="1">
							<label class="custom-control-label" for="tunjKontribusi">Tunjangan Kontribusi</label>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-warning btn-sm"><span class="fa fa-check"></span> Simpan</button>
					<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><span class="fa fa-times"></span> Batal</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- modal form untuk menambah potongan khusus -->
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal label" aria-hidden="true" id="modalAdd_potongan" data-backdrop="static">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalTitle_jabatan">Tambah Potongan Khusus</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<form action="<?= site_url('pegawai/PotonganKhusus/') . $cID . "/" . $cUnit . '/' . $cJabatan ?>" method="post">

				<div class="modal-body">
					<div class="form-group">
						<label>Nama Potongan</label>
						<input type="text" name="namaPotongan" class="form-control" required>
					</div>
					<div class="form-group">
						<label>Nilai Potongan</label>
						<input type="number" name="nilai" class="form-control" required>
					</div>
					<div class="form-group">
						<label>Satuan </label>
						<select name="satuan" class="form-control">
							<option value="Bulan">Rupiah Per Bulan</option>
							<option value="%Gaji">% Gaji</option>
						</select>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-warning btn-sm"><span class="fa fa-check"></span> Simpan</button>
					<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><span class="fa fa-times"></span> Batal</button>
				</div>
			</form>
		</div>
	</div>
</div>

<?php
foreach ($tunjKhusus as $tk) { ?>
	<!-- modal form untuk menambah tunjangan khusus -->
	<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal label" aria-hidden="true" id="modalEdit_tunjangan<?= $tk->id ?>" data-backdrop="static">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="modalTitle_jabatan">Edit Tunjangan Khusus</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>

				<form action="<?= site_url('pegawai/EditTunjanganKhusus/') . $cID . "/" . $cUnit . '/' . $cJabatan ?>" method="post">

					<div class="modal-body">
						<div class="form-group">
							<input type="hidden" name="id" value="<?= $tk->id ?>">
							<label>Nama Tunjangan</label>
							<input type="text" name="namaTunjangan" value="<?= $tk->namaTunjangan ?>" class="form-control" required>
						</div>
						<div class="form-group">
							<label>Nilai Tunjangan (Rp)</label>
							<input type="number" name="nilai" value="<?= $tk->nilai ?>" class="form-control" required>
						</div>
						<div class="form-group">
							<label>Satuan Hitung</label>
							<select name="satuan" class="form-control">
								<option value="Bulan" <?= $tk->satuan == 'Bulan' ? ' selected ' : '' ?>>Per Bulan</option>
								<option value="Hari" <?= $tk->satuan == 'Hari' ? ' selected ' : '' ?>>Per Hari</option>
								<option value="Jam" <?= $tk->satuan == 'Jam' ? ' selected ' : '' ?>>Per Jam</option>
							</select>
						</div>
						<div class="form-group">
							<div class="custom-control custom-checkbox">
								<input type="checkbox" class="custom-control-input" id="tunjKontribusi<?= $tk->id ?>" name="tunjKontribusi" value="1" <?= $tk->tunjKontribusi == 1 ? 'checked' : '' ?>>
								<label class="custom-control-label" for="tunjKontribusi<?= $tk->id ?>">Tunjangan Kontribusi</label>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-warning btn-sm"><span class="fa fa-check"></span> Simpan</button>
						<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><span class="fa fa-times"></span> Batal</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- modal form untuk hapus tunjangan -->
	<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal label" aria-hidden="true" id="modalDel_tunjangan<?= $tk->id ?>" data-backdrop="static">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="modalTitle_jabatan">Hapus Tunjangan Khusus</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<h4>Apakah anda yakin akan menhapus tunjangan ini ?</h4>
				</div>
				<div class="modal-footer">
					<a href="<?= site_url('pegawai/DelTunjanganKhusus/' . $cID . "/" . $cUnit . '/' . $cJabatan . "/" . $tk->id)?>" class="btn btn-danger btn-sm"><span class="fa fa-trash"></span> Hapus</a>
					<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><span class="fa fa-times"></span> Batal</button>
				</div>

			</div>
		</div>
	</div>
<?php }
foreach ($potKhusus as $pk) { ?>
	<!-- modal form untuk menambah potongan khusus -->
	<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal label" aria-hidden="true" id="modalEdit_potongan<?= $pk->id ?>" data-backdrop="static">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="modalTitle_jabatan">Tambah Potongan Khusus</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>

				<form action="<?= site_url('pegawai/EditPotonganKhusus/') . $cID . "/" . $cUnit . '/' . $cJabatan ?>" method="post">

					<div class="modal-body">
						<div class="form-group">
							<input type="hidden" name="id" value="<?= $pk->id ?>">
							<label>Nama Potongan</label>
							<input type="text" name="namaPotongan" value="<?= $pk->namaPotongan ?>" class="form-control" required>
						</div>
						<div class="form-group">
							<label>Nilai Potongan</label>
							<input type="number" name="nilai" class="form-control" value="<?= $pk->nilai ?>" required>
						</div>
						<div class="form-group">
							<label>Satuan </label>
							<select name="satuan" class="form-control">
								<option value="Bulan" <?= $pk->satuan == 'Rp' ? ' selected' : '' ?>>Rupiah Per Bulan</option>
								<option value="%Gaji" <?= $pk->satuan == 'Persen' ? ' selected' : '' ?>>% Gaji</option>
							</select>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-warning btn-sm"><span class="fa fa-check"></span> Simpan</button>
						<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><span class="fa fa-times"></span> Batal</button>
					</div>
				</form>
			</div>
		</div>
	</div>

		<!-- modal form untuk hapus potongan -->
		<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal label" aria-hidden="true" id="modalDel_potongan<?= $pk->id ?>" data-backdrop="static">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="modalTitle_jabatan">Hapus Potongan Khusus</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<h4>Apakah anda yakin akan menghapus potongan ini ?</h4>
				</div>
				<div class="modal-footer">
					<a href="<?= site_url('pegawai/DelPotonganKhusus/' . $cID . "/" . $cUnit . '/' . $cJabatan . "/" . $pk->id)?>" class="btn btn-danger btn-sm"><span class="fa fa-trash"></span> Hapus</a>
					<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><span class="fa fa-times"></span> Batal</button>
				</div>

			</div>
		</div>
	</div>
<?php	}
?>