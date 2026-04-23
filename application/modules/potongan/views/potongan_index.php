<div class="card card-body">
	<div class="row">
		<div class="col-sm-12 col-md-12 text-md-right">
			<a onClick="ClearForm()" id="add" title="Tambah Data" class="btn btn-primary text-white btn-sm" data-toggle="modal" data-target="#modalView_input"><span class="fa fa-plus"></span> Tambah Data</a>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-md-12">
			<table class="table table-striped" id="example1">
				<thead>
					<tr>
						<th>Nama Potongan</th>
						<th>Nilai</th>
						<th>Satuan</th>
						<th>Unit Kerja</th>
						<th>Jabatan</th>
						<th>Kelas Jabatan</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($dt as $row) { ?>
						<tr>
							<td><?= $row->namaPotongan ?></td>
							<td><?= number_format($row->nilai,0,",",".") ?></td>
							<td><?= $row->satuan ?></td>
							<td><?= $row->nama ?></td>
							<td><?= $row->namaJabatan ?></td>
							<td><?= $row->kodeKelas ?></td>
							<td>
								<div class="btn-group">
									<button type="button" class="btn btn-sm btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<i class="fa fa-gears"></i>
									</button>
									<div class="dropdown-menu" aria-labelledby="Dropdown Menu">
										<button onClick="GetData(<?= $row->id ?>)" class="dropdown-item edit" type="button" rel="1" data-toggle="modal" data-target="#modalView_input"><i class="fa fa-edit"></i> Edit</button>
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
				<h5 class="modal-title" id="modalTitle_potongan">Input Data Potongan</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= site_url('potongan/Simpan') ?>" method="post">
				<input type="hidden" name="id" id="id">
				<div class="modal-body">
					<div class="form-group">
						<div class="row">
							<div class="col-md-3">Nama Potongan</div>
							<div class="col-md-6"><input type="text" name="namaPotongan" class="form-control" id="namaPotongan"></div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-md-3">Nilai Potongan (Rp)</div>
							<div class="col-md-3"><input type="number" name="nilai" class="form-control" id="nilai"></div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-md-3">Satuan</div>
							<div class="col-md-3">
								<select name="satuan" class="form-control" id="satuan">
									<option value="Bulan">Per Bulan</option>
									<option value="Hari">Per Hari</option>
									<option value="Jam">Per Jam</option>
								</select>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-md-3">Unit Kerja</div>
							<div class="col-md-5">
								<select name="skpd" class="form-control" id="skpd">
									<option>- Pilih Unit Kerja -</option>
									<?php foreach ($unit_kerja as $uk) { ?>
										<option value="<?= $uk->id ?>"><?= $uk->nama ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-md-3">Jabatan</div>
							<div class="col-md-5">
								<select name="jabatan" class="form-control" id="jabatan" onchange="GetKelasJabatan(this.value)">
									<option>- Pilih Jabatan -</option>
									<?php foreach ($list_jabatan as $jab) { ?>
										<option value="<?= $jab->idJabatan ?>"><?= $jab->namaJabatan ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-md-3">Kelas Jabatan</div>
							<div class="col-md-3">
								<select name="idKelasJabatan" class="form-control" id="idKelasJabatan">
									<option>- Pilih Kelas Jabatan -</option>
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
				<h5 class="modal-title" id="modalTitle_potongan">Hapus Data</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= site_url('potongan/Hapus') ?>" method="post">
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
			url: "<?= site_url('potongan/GetPotongan') ?>",
			type: 'POST',
			dataType: 'json',
			data: {
				id: id
			},
			success: function(data) {
				//memasukkan data Potongan ke dalam form
				$('#namaPotongan').val(data.namaPotongan);
				$('#nilai').val(data.nilai);
				$('#satuan').val(data.satuan);
				$('#idKelasJabatan').val(data.idKelasJabatan);
				$('#jabatan').val(data.idJabatan);
				$('#skpd').val(data.skpd);
				$('#id').val(id);
				$.ajax({
					url: "<?= site_url('potongan/GetKelasJabatan') ?>",
					type: 'POST',
					dataType: 'json',
					data: {
						id: data.idJabatan
					},
					success: function(dataKelas) {
						const jabatan = document.getElementById("idKelasJabatan");
						jabatan.innerHTML = "";
						var option = document.createElement("option");
						option.text = '- Pilih Kelas Jabatan -';
						jabatan.appendChild(option);
						var valKelasJabatan = 0;
						for (var i = 0; i < dataKelas.length; i++) {
							var option = document.createElement("option");
							option.value = dataKelas[i].id;
							option.text = dataKelas[i].kodeKelas;
							if (dataKelas[i].id == data.idKelasJabatan) {
								valKelasJabatan = i +1;
							}
							jabatan.appendChild(option);
						}
						jabatan.selectedIndex = valKelasJabatan;
					}
				});
			}
		});
	}

	function ClearForm() {
		$('#namaPotongan').val('');
		$('#nilai').val('');
		$('#satuan').val('');
		$('#idKelasJabatan').val('');
		$('#idJabatan').val('');
		$('#skpd').val('');
		$('#id').val(0);
	}

	function SetHapus(id) {
		$('#idhapus').val(id);
	}

	function GetKelasJabatan(id) {
		$.ajax({
			url: "<?= site_url('potongan/GetKelasJabatan') ?>",
			type: 'POST',
			dataType: 'json',
			data: {
				id: id
			},
			success: function(data) {
				const jabatan = document.getElementById("idKelasJabatan");
				jabatan.innerHTML = "";
				var option = document.createElement("option");
				option.text = '- Pilih Kelas Jabatan -';
				jabatan.appendChild(option);
				for (var i = 0; i < data.length; i++) {
					var option = document.createElement("option");
					option.value = data[i].id;
					option.text = data[i].kodeKelas;
					jabatan.appendChild(option);
				}
			}
		});
	}
</script>