<div class="card card-body">
	<div class="row">
		<div class="col-sm-12 col-md-12 text-md-right">
			<a onClick="ClearForm()" id="add" title="Tambah Kelas Jabatan" class="btn btn-primary text-white btn-sm" data-toggle="modal" data-target="#modalView_input"><span class="fa fa-plus"></span> Tambah Data</a>
			<a id="refresh" title="Refresh" onclick="window.location.reload();" class="btn btn-info text-white btn-sm"><span class="fa fa-refresh"></span> Refresh</a>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-md-12">
			<?php 
				if ($this->session->flashdata('error')) {
					?>
					<div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
					<?php
				};
				
			?>
			<table class="table table-striped" id="example1">
				<thead>
					<tr>
						<th>Jabatan</th>
						<th>Kode Kelas</th>

						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($dt as $row) { ?>
						<tr>
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
				<h5 class="modal-title" id="modalTitle_kelasjabatan">Input Data Kelas Jabatan</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= site_url('kelasjabatan/Simpan') ?>" method="post">
				<input type="hidden" name="id" id="id">
				<div class="modal-body">
					<div class="form-group">
						<div class="row">
							<div class="col-md-3">Jabatan</div>
							<div class="col-md-7">
								<select name="idJabatan" class="form-control" id="idJabatan">
									<?php
									foreach ($jabatan as $jab) {
										echo "<option value='" . $jab->idJabatan . "' >" . $jab->namaJabatan . "</option>";
									}
									?>
								</select>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-md-3">Kelas Jabatan</div>
							<div class="col-md-4"><input type="text" name="kodeKelas" class="form-control" id="kodeKelas"></div>
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
				<h5 class="modal-title" id="modalTitle_kelasjabatan">Hapus Data Kelas Jabatan</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= site_url('kelasjabatan/Hapus') ?>" method="post">
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
			url: "<?= site_url('kelasjabatan/GetKelasjabatan') ?>",
			type: 'POST',
			dataType: 'json',
			data: {
				id: id
			},
			success: function(data) {
				//memasukkan data shift ke dalam form
				$('#kodeKelas').val(data.kodeKelas);
				//$('#idJabatan').val(data.idJabatan);
				$('#id').val(data.id);
				const dlJabatan = document.getElementById("idJabatan");
				// Loop melalui setiap opsi pada dropdownlist
				for (let i = 0; i < dlJabatan.options.length; i++) {
					const option = dlJabatan.options[i];

					// Membandingkan nilai value dari setiap opsi dengan nilai yang ingin ditetapkan
					if (option.value === data.idJabatan) {
						// Menetapkan opsi yang dipilih
						dlJabatan.selectedIndex = i;
						break; // Keluar dari loop setelah menemukan opsi yang cocok
					}
				}
			}
		});
	}

	function ClearForm() {
		$('#kodeKelas').val('');
		$('#idJabatan').val('');
		$('#nilaiTunjangan').val('');
		$('#id').val(0);
	}

	function SetHapus(id) {
		$('#idhapus').val(id);
	}
</script>