<div class="card card-body">
	<?php if ($this->session->flashdata('error')) { ?>
		<div class="alert alert-warning alert-dismissible fade show" role="alert">
			<strong>Informasi !</strong> <?= $this->session->flashdata('error')	 ?>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	<?php } ?>
	<div class="row">
		<div class="col-md-3">
			<select class="form-control" id="unit" onchange="FilterData()">
				<option value="0">-- Semua Unit --</option>
				<?php foreach ($unit as $u) { ?>
					<option value="<?= $u->id ?>" <?= $cUnit == $u->id ? ' selected ' : '' ?>><?= $u->nama ?></option>
				<?php } ?>
			</select>
		</div>
		<div class="col-md-3">
			<select class="form-control" id="jabatan" onchange="FilterData()">
				<option value="0">-- Semua Jabatan --</option>
				<?php foreach ($jabatan as $j) { ?>
					<option value="<?= $j->idJabatan ?>" <?= $cJabatan == $j->idJabatan ? ' selected ' : '' ?>><?= $j->namaJabatan ?></option>
				<?php } ?>
			</select>
		</div>
		<div class="col-sm-6 col-md-6 text-md-right">
			<a href="<?= site_url('pegawai/Input/0/') . $cUnit . '/' . $cJabatan ?>" id="add" title="Tambah Pegawai" class="btn btn-primary text-white btn-sm"><span class="fa fa-plus"></span> Tambah Pegawai</a>
			<a id="refresh" title="Refresh" onclick="window.location.reload();" class="btn btn-info text-white btn-sm"><span class="fa fa-refresh"></span> Refresh</a>
			<a href="<?= site_url('pegawai/export_excel')  ?>" title="Excel" class="btn btn-success text-white btn-sm"><span class="fa fa-file-excel-o"></span> Excel Pegawai</a>
			<a href="<?= site_url('pegawai/sertifikat_excel')  ?>" title="Sertifikat" class="btn btn-warning text-white btn-sm"><span class="fa fa-file-excel-o"></span> Excel Sertifikat</a>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-md-12">
			<table class="table table-striped" id="example2">
				<thead>
					<tr>
						<th>NIP</th>
						<th>NIK</th>
						<th>Nama</th>
						<th>Alamat</th>
						<th>Agama</th>
						<th>Kontak</th>
						<th>Jabatan</th>
						<th width="50px"></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($dt as $row) { ?>
						<tr style="<?= $row->flagStatus == 0 ? 'color:silver;' : '' ?>">
							<td><?= $row->nipBaru?><br><small><?=' / '.date_format(date_create($row->tglBergabung), 'd-m-Y') ?></small></td>
							<td><?= $row->NIK ?></td>
							<td><?= $row->namaPegawai ?></td>
							<td><?= $row->alamat ?></td>
							<td><?= $row->agama?><br><small><?= ' / '.$row->jenisKelamin ?></small></td>
							<td><?= $row->telepon ?><br><small><?= ' / '.$row->email ?></small></td>
							<td><?= $row->jabatan ?> (<?= $row->kodeKelas ?>)<br><small><?= ' / '.$row->namaUnit ?></small></td>
							<td>
								<div class="btn-group">
									<button type="button" class="btn btn-sm btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<i class="fa fa-gears"></i>
									</button>
									<div class="dropdown-menu dropdown-menu-right" aria-labelledby="Dropdown Menu">
										<button onClick="SetEdit(<?= $row->idtbPegawai ?>)" class="dropdown-item edit" type="button" rel="1"><i class="fa fa-edit"></i> Edit</button>
										<button onClick="SetDetail(<?= $row->idtbPegawai ?>)" class="dropdown-item delete" type="button" rel="1"><i class="fa fa-search"></i> Tunjangan & Potongan</button>
										<button onClick="SetFile(<?= $row->idtbPegawai ?>)" class="dropdown-item delete" type="button" rel="1"><i class="fa fa-file-o"></i> Kelengkapan File</button>
										<button onClick="SetLisensi(<?= $row->idtbPegawai ?>)" class="dropdown-item delete" type="button" rel="1"><i class="fa fa-book"></i> Lisensi Profesi</button>
										<button onClick="SetStatus(<?= $row->idtbPegawai ?>)" class="dropdown-item delete" type="button" rel="1" data-toggle="modal" data-target="<?= $row->flagStatus == 1 ? '#modalView_nonaktif' : '#modalView_aktif' ?>"><i class="fa fa-clock-o"></i> <?= $row->flagStatus == 1 ? 'Non aktifkan' : 'Aktifkan' ?></button>
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

<!-- modal form untuk meng aktifkan / me-nonaktifkan -->
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal label" aria-hidden="true" id="modalView_nonaktif" data-backdrop="static">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalTitle_jabatan">Non-Aktifkan Status Pegawai</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= site_url('pegawai/NonAktif/') . $cUnit . '/' . $cJabatan ?>" method="post">
				<input type="hidden" name="idnon" id="idnon">
				<div class="modal-body">
					<h4>Apakah anda yakin akan me-non aktifkan pegawai ini ?</h4>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-warning btn-sm"><span class="fa fa-trash"></span> Non Aktifkan</button>
					<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><span class="fa fa-times"></span> Batal</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal label" aria-hidden="true" id="modalView_aktif" data-backdrop="static">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalTitle_jabatan">Aktifkan Status Pegawai</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= site_url('pegawai/Aktif/') . $cUnit . '/' . $cJabatan ?>" method="post">
				<input type="hidden" name="idaktif" id="idaktif">
				<div class="modal-body">
					<h4>Apakah anda yakin akan meng-aktifkan pegawai ini ?</h4>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-warning btn-sm"><span class="fa fa-edit"></span>Aktifkan</button>
					<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><span class="fa fa-times"></span> Batal</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
	function SetStatus(id) {
		$('#idnon').val(id);
		$('#idaktif').val(id);
	}

	function FilterData() {

		var jabatan = document.getElementById("jabatan");
		var selectedJabatan = jabatan.value;
		var unit = document.getElementById("unit");
		var selectedUnit = unit.value;
		window.location.replace("<?= site_url('pegawai/index/') ?>" + selectedUnit + '/' + selectedJabatan);
	}

	function SetDetail(id) {
		window.location.replace("<?= site_url('pegawai/Detail/') ?>" + id + '/' + "<?= $cUnit ?>" + '/' + "<?= $cJabatan ?>");
	}

	function SetFile(id) {
		window.location.replace("<?= site_url('pegawai/Berkas/') ?>" + id + '/' + "<?= $cUnit ?>" + '/' + "<?= $cJabatan ?>");
	}
	
	function SetLisensi(id) {
		window.location.replace("<?= site_url('pegawai/Lisensi/') ?>" + id + '/' + "<?= $cUnit ?>" + '/' + "<?= $cJabatan ?>");
	}
	function SetEdit(id) {
		window.location.replace("<?= site_url('pegawai/Input/') ?>" + id + '/' + "<?= $cUnit ?>" + '/' + "<?= $cJabatan ?>");
	}
</script>