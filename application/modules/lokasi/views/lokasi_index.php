<div class="card card-body">
	<div class="row">
		<div class="col-sm-12 col-md-12 text-md-right">
			<a onClick="ClearForm()" id="add" title="Tambah Unit Kerja" class="btn btn-primary text-white btn-sm" data-toggle="modal" data-target="#modalView_input"><span class="fa fa-plus" ></span> Tambah Data</a>
			<a id="refresh" title="Refresh" onclick="window.location.reload();" class="btn btn-info text-white btn-sm"><span class="fa fa-refresh"></span> Refresh</a>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-md-12">
			<table class="table table-striped" id="example1">
				<thead>
					<tr>
						<th>Nama Unit Kerja</th>
						<th>Provinsi</th>
						<th>Kota/Kab</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($dt as $row) { ?>
						<tr>
							<td><?= $row->nama ?></td>
							<td><?= $row->namaProv ?></td>
							<td><?= $row->namaKota ?></td>
							<td>
								<div class="btn-group">
									<button type="button" class="btn btn-sm btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<i class="fa fa-gears"></i>
									</button>
									<div class="dropdown-menu" aria-labelledby="Dropdown Menu">
										<button  onClick="GetData(<?= $row->id ?>)" class="dropdown-item edit" type="button" rel="1" data-toggle="modal" data-target="#modalView_input" ><i class="fa fa-edit"></i> Edit</button>
										<button onClick="SetHapus(<?= $row->id ?>)" class="dropdown-item delete" type="button" rel="1" data-toggle="modal" data-target="#modalView_hapus"><i class="fa fa-trash"></i> Delete</button>
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
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalTitle_lokasi">Input Data Lokasi</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= site_url('lokasi/Simpan') ?>" method="post">
				<input type="hidden" name="id" id="id">
				<div class="modal-body">
					<div class="form-group">
						<div class="row">
							<div class="col-md-3">Nama Unit Kerja</div>
							<div class="col-md-4"><input type="text" name="nama_lokasi" class="form-control" id="nama_lokasi"></div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-md-3">Provinsi</div>
							<div class="col-md-4">
								<select name="prov_id" class="form-control" id="prov_id" onchange="LoadKota(this.value,0)">
									<?php foreach ($prov as $p) { ?>
										<option value="<?= $p->prov_id ?>"><?= $p->namaProv ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-md-3">Kota/Kab</div>
							<div class="col-md-4">
								<select name="kota_id" class="form-control" id="kota_id">
									<option>- Pilih Kota/Kab -</option>
								</select>
							</div>
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
				<h5 class="modal-title" id="modalTitle_jabatan">Hapus Data Unit Kerja</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= site_url('lokasi/Hapus') ?>" method="post">
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
				url: "<?= site_url('lokasi/GetLokasi') ?>",
				type: 'POST',
				dataType: 'json',
				data: {id: id},
				success: function(data) {
					//memasukkan data lokasi ke dalam form
					$('#nama_lokasi').val(data.nama);
					$('#kota_id').val(data.kota_id);
					$('#id').val(data.id);
					const prov = document.getElementById("prov_id");
					// Loop melalui setiap opsi pada dropdownlist
					for (let i = 0; i < prov.options.length; i++) {
						const option = prov.options[i];
						// Membandingkan nilai value dari setiap opsi dengan nilai yang ingin ditetapkan
						if (option.value === data.prov_id) {
							// Menetapkan opsi yang dipilih
							prov.selectedIndex = i;
							break; // Keluar dari loop setelah menemukan opsi yang cocok
						}
					}

					LoadKota(data.prov_id,data.kota_id);


				}
			});
	}

	function ClearForm() {
		$('#nama').val('');
		$('#id').val(0);
		$('#prov_id').val('');
		$('#kota_id').val('');
	}
	function SetHapus(id) {
		$('#idhapus').val(id);
	}

	function LoadKota(id,idkota) {
		$.ajax({
				url: "<?= site_url('lokasi/GetKota') ?>",
				type: 'POST',
				dataType: 'json',
				data: {id: id},
				success: function(data) {
					const kota = document.getElementById('kota_id');
					var len = data.length;
					kota.options.length = 0;
					var option = document.createElement("option");
					option.text = "- PIlih Kota/Kab -";
					kota.add(option);

							for (var i = 0; i < len; i++) {
								var option = document.createElement("option");
								var id = data[i]['kota_id'];
								var name = data[i]['namaKota'];
								option.text = name;
								option.value = id;
								kota.add(option);
							}

					// Loop melalui setiap opsi pada dropdownlist
					for (let i = 0; i < kota.options.length; i++) {
						const option = kota.options[i];
						// Membandingkan nilai value dari setiap opsi dengan nilai yang ingin ditetapkan
						if (option.value === idkota) {
							// Menetapkan opsi yang dipilih
							kota.selectedIndex = i;
							break; // Keluar dari loop setelah menemukan opsi yang cocok
						}
					}
				}
			});
	}
</script>