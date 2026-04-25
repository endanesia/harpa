<div class="card card-body">
	<div class="row">
		<div class="col-sm-12 col-md-12 text-md-right">
			<a onClick="ClearForm()" id="add" title="Tambah Shift" class="btn btn-primary text-white btn-sm" data-toggle="modal" data-target="#modalView_input"><span class="fa fa-plus" ></span> Tambah Data</a>
			<a id="refresh" title="Refresh" onclick="window.location.reload();" class="btn btn-info text-white btn-sm"><span class="fa fa-refresh"></span> Refresh</a>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-md-12">
			<table class="table table-striped" id="example1">
				<thead>
					<tr>
						<th>Nama Shift</th>
						<th>Kode</th>
						<th>Tunjangan</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($dt as $row) { ?>
						<tr>
							<td><?= $row->nama_shift ?></td>
							<td><?= $row->kode ?></td>
							<td><?= $row->premi_shift == '-' ? '' : 'Tunjangan shift ' ?><?= $row->premi_shift ?></td>
							<td>
								<div class="btn-group">
									<button type="button" class="btn btn-sm btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<i class="fa fa-gears"></i>
									</button>
									<div class="dropdown-menu" aria-labelledby="Dropdown Menu">
										<button  onClick="GetData(<?= $row->id ?>)" class="dropdown-item edit" type="button" rel="1" data-toggle="modal" data-target="#modalView_input" ><i class="fa fa-edit"></i> Edit</button>
										<button onClick="SetHapus(<?= $row->id ?>)" class="dropdown-item delete" type="button" rel="1" data-toggle="modal" data-target="#modalView_hapus"><i class="fa fa-trash"></i> Delete</button>
                                        <button onClick="GetDetail(<?= $row->id ?>)" class="dropdown-item details" type="button" rel="1" data-toggle="modal" data-target="#modalView_details"><i class="fa fa-calendar"></i> Detail</button>
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

<!-- modal form untuk input data -->
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal label" aria-hidden="true" id="modalView_input" data-backdrop="static">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalTitle_shift">Input Data Shift</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= site_url('shift/Simpan') ?>" method="post">
				<input type="hidden" name="id" id="id">
				<div class="modal-body">
					
					<div class="row form-group">
							<div class="col-md-4">Kode</div>
							<div class="col-md-8"><input type="text" name="kode" class="form-control" id="kode"></div>
						</div>
						<div class="row form-group">
							<div class="col-md-4">Nama Shift</div>
							<div class="col-md-8"><input type="text" name="nama_shift" class="form-control" id="nama_shift"></div>
						</div>
						<div class="row form-group">
							<div class="col-md-4">Jenis Premi Shift</div>
							<div class="col-md-8">
								<select name="premi_shift" class="form-control" id="premi_shift">
									<option value="-">-</option>
									<option value="Pagi">Tunjangan Shift Pagi</option>
									<option value="Sore">Tunjangan Shift Sore</option>
									<option value="Malam">Tunjangan Shift Malam</option>
								</select>
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
				<h5 class="modal-title" id="modalTitle_jabatan">Hapus Data Shift</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= site_url('shift/Hapus') ?>" method="post">
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

<script>
	function GetData(id) {
		$.ajax({
				url: "<?= site_url('shift/GetShift') ?>",
				type: 'POST',
				dataType: 'json',
				data: {id: id},
				success: function(data) {
					//memasukkan data shift ke dalam form
					$('#nama_shift').val(data.nama_shift);
					$('#kode').val(data.kode);
					$('#id').val(data.id);
					$('#premi_shift').val(data.premi_shift);
				}
			});
	}

	function ClearForm() {
		$('#nama_shift').val('');
		$('#premi_shift').val('-');
		$('#kode').val('');
		$('#id').val(0);
	}

	function SetHapus(id) {
		$('#idhapus').val(id);
	}

	function GetDetail(id) {
		location.replace("<?= site_url('shift/Detail/') ?>" + id);
	}

</script>