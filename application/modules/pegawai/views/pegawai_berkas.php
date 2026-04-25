<div class="card card-body">
	<div class="row">
		<div class="col-md-2" style="text-align:center;">
			<img id="gbr" src="<?= $dt->fotoPegawai != '' ? base_url('assets/profil/' . $dt->fotoPegawai) : base_url('assets/profil/blank.jpg') ?>" width="100%" style="border-width:1px; border-style:solid; display: block; margin-left: auto;  margin-right: auto;">
			<b><?= $dt->namaPegawai ?></b><br>
			<small><?= $dt->nipBaru ?></small><br>
			<?= $dt->jabatan ?><br>
			<?= $unit->nama ?><br>
			Bergabung <?= date_format(date_create($dt->tglBergabung), 'd M Y') ?>

		</div>
		<div class="col-md-10">

					<a href="" data-toggle="modal" data-target="#modalAdd" id="add" title="Tambah Berkas" class="btn btn-primary text-white btn-sm pull-right"><span class="fa fa-plus"></span> Tambah File</a>
					<table class="table">
						<thead>
							<tr>
								<th>No</th>
								<th>Nama File</th>
								<th>Link File</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
						<?php $no=1; foreach ($list as $dt) { ?>
								<tr>
									<td><?= $no ?></td>
									<td><?= $dt->namaFile ?></td>
									<td><a href="<?= base_url('files/' . $dt->linkFile)?>" target=_blank><?= $dt->linkFile ?></a></td>

									<td><a href="#" class="btn btn-danger btn-sm" title="Hapus" data-toggle="modal" data-target="#modalDel<?= $dt->id ?>"><i class="fa fa-trash"></i></a></td>
								</tr>
						<?php $no++; } ?>	
						</tbody>
					</table>
				
			
		</div>
	</div>

</div>

</div>

<!-- modal form untuk menambah tunjangan khusus -->
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal label" aria-hidden="true" id="modalAdd" data-backdrop="static">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalTitle_jabatan">Tambah Berkas Pegawai</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<form action="<?= site_url('pegawai/TambahBerkas/') . $cID . "/" . $cUnit . '/' . $cJabatan ?>" method="post" enctype='multipart/form-data'>

				<div class="modal-body">
					<div class="form-group">
						<label>Nama Berkas</label>
						<input type="text" name="namaFile" class="form-control" required>
					</div>
					<div class="form-group">
						<label>Upload File (maks. 2Mb)</label>
						<input type="file" name="linkFile" class="form-control" accept="image/*, application/pdf" required>
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

<?php foreach ($list as $dt) { ?>
		<!-- modal form untuk hapus file -->
		<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal label" aria-hidden="true" id="modalDel<?= $dt->id ?>" data-backdrop="static">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="modalTitle_jabatan">Hapus File</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<h4>Apakah anda yakin akan menhapus Berkas ini ?</h4>
				</div>
				<div class="modal-footer">
					<a href="<?= site_url('pegawai/DelBerkas/' . $cID . "/" . $cUnit . '/' . $cJabatan . "/" . $dt->id)?>" class="btn btn-danger btn-sm"><span class="fa fa-trash"></span> Hapus</a>
					<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><span class="fa fa-times"></span> Batal</button>
				</div>

			</div>
		</div>
	</div>
<?php } ?>