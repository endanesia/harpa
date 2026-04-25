<div class="card card-body">

	<div class="row">
		<div class="col-md-6">
			<div class="row">
				<div class="col-md-4">NIP</div>
				<div class="col-md-8">: <?= $pegawai->nipBaru ?></div>
			</div>
			<div class="row">
				<div class="col-md-4">Nama</div>
				<div class="col-md-8">: <b><?= $pegawai->namaPegawai ?></b></div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="row">
				<div class="col-md-4">Unit Kerja</div>
				<div class="col-md-8">: <?= $unitKerja->nama ?></div>
			</div>
			<div class="row">
				<div class="col-md-4">Jabatan</div>
				<div class="col-md-8">: <?= $jabatan->namaJabatan ?> (<?= isset($kelas) ? $kelas->kodeKelas : '' ?>)</div>
			</div>
		</div>
	</div>
	<hr>
	<form method="post" action="<?= site_url('Gaji/Simpan_edit/' . $id) ?>">
		<div class="row">
			<div class="col-md-2">
				Gaji Pokok :
			</div>
			<div class="col-md-4">
				<input type="text" name="gaji_pokok" class="form-control" value="<?= $gaji->gaji_pokok ?>">
			</div>
			<div class="col-md-6">
				<a  href="<?= site_url('Gaji') ?>" type="button" class="btn btn-secondary pull-right"><i class="fa fa-arrow-left"></i> Kembali</a>
				<div class="pull-right">&nbsp;&nbsp;&nbsp;&nbsp;</div>
				<button type="submit" class="btn btn-primary pull-right"><i class="fa fa-check-square-o"></i> Simpan</button>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-md-6">
				<a href="#" data-toggle="modal" data-target="#tunj0" class="btn btn-sm btn-warning pull-right"><i class="fa fa-plus"></i> Tunjangan</a>
				<h3>Tunjangan</h3>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>Item</th>
							<th>Nilai</th>
							<th>Ket</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($tunjangan as $tunj) { ?>
							<tr>
								<td><?= $tunj->nama_tunjangan ?></td>
								<td style="text-align:right"><?= number_format($tunj->jml, 2, ",", ".") ?></td>
								<td><?= $tunj->ket ?></td>
								<td style="text-align:center"><a href="#" data-toggle="modal" data-target="#tunj<?= $tunj->id ?>"><i class="fa fa-pencil"></i></a> | <a href="" data-toggle="modal" data-target="#hapustunj<?= $tunj->id?>"><i class="fa fa-trash"></i></a></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
			<div class="col-md-6">
				<a href="#" data-toggle="modal" data-target="#pot0" class="btn btn-sm btn-warning pull-right"><i class="fa fa-plus"></i> Potongan</a>
				<h3>Potongan</h3>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>Item</th>
							<th>Nilai</th>
							<th>Ket</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($potongan as $pot) { ?>
							<tr>
								<td><?= $pot->nama_potongan ?></td>
								<td style="text-align:right"><?= number_format($pot->jml, 2, ",", ".") ?></td>
								<td><?= $pot->ket ?></td>
								<td style="text-align:center"><a href="#" data-toggle="modal" data-target="#pot<?= $pot->id ?>"><i class="fa fa-pencil"></i></a> | <a href="#" data-toggle="modal" data-target="#hapuspot<?= $pot->id?>"><i class="fa fa-trash"></i></a></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</form>
</div>

</div>

<!-- modal form untuk input data tunjangan-->
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal label" aria-hidden="true" id="tunj0" data-backdrop="static">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalTitle_shift">Tambah Tunjangan</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= site_url('gaji/Simpan_tunjangan/0/' . $id) ?>" method="post">
				<div class="modal-body">
					<div class="form-group">
						<div class="row">
							<div class="col-md-4">Nama Tunjangan</div>
							<div class="col-md-8">
								<input type="hidden" name="nip" value="<?= $gaji->nip ?>">
								<input type="hidden" name="bulan" value="<?= $gaji->bulan ?>">
								<input type="hidden" name="tahun" value="<?= $gaji->tahun ?>">
								<input type="hidden" name="id_unit" value="<?= $gaji->id_unit ?>">
								<input type="text" name="nama_tunjangan" class="form-control" required>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">Jumlah (Rp)</div>
							<div class="col-md-8">
								<input type="text" name="jml" class="form-control" required>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">Keterangan</div>
							<div class="col-md-8">
								<input type="text" name="ket" class="form-control">
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary btn-sm" ><span class="fa fa-check"></span> Simpan</button>
					<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><span class="fa fa-times"></span> Close</button>
				</div>
			</form>
		</div>
	</div>
</div>


<!-- modal form untuk input data potongan-->
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal label" aria-hidden="true" id="pot0" data-backdrop="static">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalTitle_shift">Tambah Potongan</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= site_url('gaji/Simpan_potongan/0/' . $id) ?>" method="post">
				<div class="modal-body">
					<div class="form-group">
						<div class="row">
							<div class="col-md-4">Nama Potongan</div>
							<div class="col-md-8">
								<input type="hidden" name="nip" value="<?= $gaji->nip ?>">
								<input type="hidden" name="bulan" value="<?= $gaji->bulan ?>">
								<input type="hidden" name="tahun" value="<?= $gaji->tahun ?>">
								<input type="hidden" name="id_unit" value="<?= $gaji->id_unit ?>">
								<input type="text" name="nama_potongan" class="form-control" required>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">Jumlah (Rp)</div>
							<div class="col-md-8">
								<input type="text" name="jml" class="form-control" required>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">Keterangan</div>
							<div class="col-md-8">
								<input type="text" name="ket" class="form-control">
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary btn-sm" ><span class="fa fa-check"></span> Simpan</button>
					<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><span class="fa fa-times"></span> Close</button>
				</div>
			</form>
		</div>
	</div>
</div>


<?php foreach ($tunjangan as $tunj) { ?>
	<!-- modal form untuk input data -->
	<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal label" aria-hidden="true" id="tunj<?= $tunj->id ?>" data-backdrop="static">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="modalTitle_shift">Edit Tunjangan</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form action="<?= site_url('gaji/Simpan_tunjangan/' . $tunj->id . "/" . $id) ?>" method="post">
					<div class="modal-body">
						<div class="form-group">
							<div class="row">
								<div class="col-md-4">Nama Tunjangan</div>
								<div class="col-md-8">
									<input type="text" name="nama_tunjangan" value="<?= $tunj->nama_tunjangan ?>" class="form-control" required>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">Jumlah (Rp)</div>
								<div class="col-md-8">
									<input type="text" name="jml" class="form-control" value="<?= $tunj->jml ?>" required>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">Keterangan</div>
								<div class="col-md-8">
									<input type="text" name="ket" class="form-control" value="<?= $tunj->ket ?>">
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary btn-sm" ><span class="fa fa-check"></span> Simpan</button>
						<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><span class="fa fa-times"></span> Close</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal label" aria-hidden="true" id="hapustunj<?= $tunj->id ?>" data-backdrop="static">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="modalTitle_shift">Konfirmasi</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
					<div class="modal-body">
						Apakah anda yakin akan menghapus item <b><?= $tunj->nama_tunjangan ?> ?</b>
					</div>
					<div class="modal-footer">
						<a href="<?= site_url('Gaji/Del_tunjangan/'.$tunj->id."/".$id)?>" class="btn btn-danger btn-sm" ><span class="fa fa-trash"></span> Hapus</a>
						<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><span class="fa fa-times"></span> Batal</button>
					</div>
			</div>
		</div>
	</div>
<?php } ?>

<?php foreach ($potongan as $pot) { ?>
	<!-- modal form untuk input data -->
	<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal label" aria-hidden="true" id="pot<?= $pot->id ?>" data-backdrop="static">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="modalTitle_shift">Edit Potongan</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form action="<?= site_url('gaji/Simpan_potongan/' . $pot->id . "/" . $id) ?>" method="post">
					<div class="modal-body">
						<div class="form-group">
							<div class="row">
								<div class="col-md-4">Nama Potongan</div>
								<div class="col-md-8">
									<input type="text" name="nama_potongan" value="<?= $pot->nama_potongan ?>" class="form-control" required>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">Jumlah (Rp)</div>
								<div class="col-md-8">
									<input type="text" name="jml" class="form-control" value="<?= $pot->jml ?>" required>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">Keterangan</div>
								<div class="col-md-8">
									<input type="text" name="ket" class="form-control" value="<?= $pot->ket ?>">
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary btn-sm" ><span class="fa fa-check"></span> Simpan</button>
						<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><span class="fa fa-times"></span> Close</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal label" aria-hidden="true" id="hapuspot<?= $pot->id ?>" data-backdrop="static">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="modalTitle_shift">Konfirmasi</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
					<div class="modal-body">
						Apakah anda yakin akan menghapus item <b><?= $pot->nama_potongan ?> ?</b>
					</div>
					<div class="modal-footer">
						<a href="<?= site_url('Gaji/Del_potongan/'.$pot->id."/".$id)?>" class="btn btn-danger btn-sm" ><span class="fa fa-trash"></span> Hapus</a>
						<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><span class="fa fa-times"></span> Batal</button>
					</div>
			</div>
		</div>
	</div>
<?php } ?>

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