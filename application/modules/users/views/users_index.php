<div class="card card-body">
	<div class="row">
		<?php if ($this->session->flashdata('errMsg')) { ?>
			<div class="col-md-6">
				<div class="alert alert-warning"><?= $this->session->flashdata('errMsg') ?></div>
			</div>
		<?php } ?>

		<div class="col-sm-12 col-md-12 text-md-right">
			<a onClick="ClearForm()" id="add" title="Tambah User" class="btn btn-primary text-white btn-sm" data-toggle="modal" data-target="#modalView_input"><span class="fa fa-plus"></span> Tambah Data</a>
			<a id="refresh" title="Refresh" onclick="window.location.reload();" class="btn btn-info text-white btn-sm"><span class="fa fa-refresh"></span> Refresh</a>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-md-12">
			<table class="table table-striped" id="example1">
				<thead>
					<tr>
						<th>ID User</th>
						<th>Username</th>
						<th>Email</th>
						<th>Akses User</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($dt as $row) { ?>
						<tr>
							<td><?= $row->idtbUser ?></td>
							<td><?= $row->userName ?></td>
							<td><?= $row->email ?></td>
							<td><?= $row->groupAlias ?></td>
							<td>
								<?php $status = $row->status;
								if ($status == 1) {
									echo '<div id="badge_status' . $row->idtbUser . '" class="badge badge-btn badge-success">ACTIVE</div>';
								} else {
									echo '<div id="badge_status' . $row->idtbUser . '"class="badge badge-btn badge-secondary">INACTIVE</div>';
								};
								?>
								<select onchange="update_status(this.value,'<?php echo $row->idtbUser; ?>');" style="display:none;" name="update_status_<?php echo $row->idtbUser; ?>" id="update_status_<?php echo $row->idtbUser; ?>" class="custom-select mt-2">
									<option value="" disabled>Pilih salah satu</option>
									<option value="1" <?php echo $status == "1" ? "selected" : ""; ?>>AKTIF</option>
									<option value="0" <?php echo $status != "1" ? "selected" : ""; ?>>TIDAK AKTIF</option>
								</select>
							</td>
							<td>
								<div class="btn-group">
									<button type="button" class="btn btn-sm btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<i class="fa fa-gears"></i>
									</button>
									<div class="dropdown-menu" aria-labelledby="Dropdown Menu">
										<button onClick="GetData(<?= $row->idtbUser ?>)" class="dropdown-item edit" type="button" rel="1" data-toggle="modal" data-target="#modalView_input"><i class="fa fa-edit"></i> Edit</button>
										<button onClick="SetID(<?= $row->idtbUser ?>)" class="dropdown-item edit" type="button" rel="1" data-toggle="modal" data-target="#modalView_password"><i class="fa fa-key"></i> Set/Reset Password</button>
										<button onClick="SetHapus(<?= $row->idtbUser ?>)" class="dropdown-item delete" type="button" rel="1" data-toggle="modal" data-target="#modalView_hapus"><i class="fa fa-trash"></i> Hapus</button>
									</div>
								</div>
							</td>
						</tr>

					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<!-- modal form untuk ganti password -->
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal label" aria-hidden="true" id="modalView_password" data-backdrop="static">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="Password_title">Reset Password</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= site_url('users/password') ?>" method="post">
				<input type="hidden" name="idUser" id="idUser">
				<div class="modal-body">
					<div class="form-group">
						<div class="row">
							<div class="col-md-4">Password baru</div>
							<div class="col-md-8"><input type="password" name="p1" class="form-control" id="p1" required></div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-md-4">Ulangi Password</div>
							<div class="col-md-8"><input type="password" name="p2" class="form-control" id="p2"></div>
						</div>
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

<!-- modal form untuk hapus data -->
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal label" aria-hidden="true" id="modalView_hapus" data-backdrop="static">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalTitle_user">Hapus Data User</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= site_url('users/Hapus') ?>" method="post">
				<input type="hidden" name="idhapus" id="idhapus">
				<div class="modal-body">
					<h4>Apakah anda yakin akan menghapus ?</h4>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-warning btn-sm"><span class="fa fa-trash"></span> Hapus</button>
					<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><span class="fa fa-times"></span> Batal</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- modal form untuk input data -->
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal label" aria-hidden="true" id="modalView_input" data-backdrop="static">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalTitle_user">Input Data User</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= site_url('users/Simpan') ?>" method="post">
				<input type="hidden" name="id" id="id">
				<div class="modal-body">
					<div class="form-group">
						<div class="row">
							<div class="col-md-3">Username</div>
							<div class="col-md-4"><input type="text" name="userName" class="form-control" id="userName" required></div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-md-3">Email</div>
							<div class="col-md-4"><input type="text" name="email" class="form-control" id="email"></div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-md-3">Unit Kerja</div>
							<div class="col-md-9">
								<select type="text" name="skpd" class="form-control" id="skpd" required>
									<option value="0"> - Akses ke semua unit kerja - </option>
									<?php foreach ($satkerja as $u) { ?>
										<option value="<?= $u->id ?>"><?= $u->nama ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-md-3">Akses User</div>
							<div class="col-md-4">
								<select name="userLevel" class="form-control" id="userLevel" required>
									<?php foreach ($akses as $g) { ?>
										<option value="<?= $g->id ?>"><?= $g->groupAlias ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-md-3">Status</div>
							<div class="col-md-4"><select name="status" class="form-control" id="status" required>
									<option value="1">Aktif</option>
									<option value="0">Tidak Aktif</option>
								</select></div>
						</div>
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
			url: "<?= site_url('users/GetUsers') ?>",
			type: 'POST',
			dataType: 'json',
			data: {
				id: id
			},
			success: function(data) {
				//memasukkan data user ke dalam form

				$('#userName').val(data.userName);
				$('#email').val(data.email);
				$('#id').val(data.idtbUser);

				const skpd = document.getElementById("skpd");
				const userLevel = document.getElementById("userLevel");
				const status = document.getElementById("status");
				// Loop melalui setiap opsi pada dropdownlist
				for (let i = 0; i < skpd.options.length; i++) {
					const option = skpd.options[i];

					// Membandingkan nilai value dari setiap opsi dengan nilai yang ingin ditetapkan
					if (option.value === data.skpd) {
						// Menetapkan opsi yang dipilih
						skpd.selectedIndex = i;
						break; // Keluar dari loop setelah menemukan opsi yang cocok
					}
				}

				// set nilai di dropdownlist akses user
				for (let i = 0; i < userLevel.options.length; i++) {
					const option = userLevel.options[i];
					if (option.value === data.userLevel) {
						userLevel.selectedIndex = i;
						break; 
					}
				}

				//set value di dropdown status
				if (status.option[0] == data.status) {
					status.selectedIndex = 0
				} else {
					status.selectedIndex = 1
				}
			}
		});
	}

	function ClearForm() {
		$('#skpd').val('');
		$('#userName').val('');
		$('#userLevel').val('');
		$('#status').val('');
		$('#email').val('');
		$('#id').val(0);
	}

	function SetHapus(id) {
		$('#idhapus').val(id);
	}

	function SetID(id) {
		$('#idUser').val(id);
	}
</script>