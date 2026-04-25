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
			<?php if ($this->session->userdata('akses') == 1) { ?>
				<a href="" data-toggle="modal" data-target="#modalAdd_tunjangan" id="add" title="Tambah tunjangan" class="btn btn-primary text-white btn-sm pull-right"><span class="fa fa-plus"></span> Tambah Lisensi</a>
			<?php } ?>
			<table class="table">
				<thead>
					<tr>
						<th>No</th>
						<th>No Lisensi</th>
						<th>Nama Lisensi/Sertifikat</th>
						<th>Tanggal Terbit</th>
						<th>Berlaku Sampai</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php $no = 1;
					foreach ($list as $dt) { ?>
						<tr>
							<td><?= $no ?></td>
							<td><?= $dt->nomor ?></td>
							<td><?= $dt->namaSertifikat ?></td>
							<td><?= date_format(date_create($dt->berlaku), "d-m-Y") ?></td>
							<td><?= date_format(date_create($dt->sampai), "d-m-Y") ?></td>
							<td>
								<?php if ($this->session->userdata('akses') == 1) { ?>
									<a href="#" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalEdit<?= $dt->id ?>" title="edit"><i class="fa fa-pencil"></i></a> <a href="#" class="btn btn-danger btn-sm" title="Hapus" data-toggle="modal" data-target="#modalDel<?= $dt->id ?>"><i class="fa fa-trash"></i></a>
								<?php } ?>
							</td>
						</tr>
					<?php $no++;
					} ?>
				</tbody>
			</table>


		</div>
	</div>

</div>

</div>

<!-- modal form untuk menambah lisensi -->
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal label" aria-hidden="true" id="modalAdd_tunjangan" data-backdrop="static">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalTitle_jabatan">Tambah Lisesnsi Profesi</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<form action="<?= site_url('pegawai/TambahLisensi/') . $cID . "/" . $cUnit . '/' . $cJabatan ?>" method="post">

				<div class="modal-body">
					<div class="form-group">
						<label>No.Lisensi</label>
						<input type="text" name="nomor" class="form-control" required>
					</div>
					<div class="form-group">
						<label>Nama Lisensi</label>
						<input type="text" name="namaSertifikat" class="form-control" required>
					</div>
					<div class="form-group">
						<label>Tanggal Terbit</label>
						<input type="date" name="berlaku" class="form-control" required>
					</div>
					<div class="form-group">
						<label>Berlaku sampai dengan</label>
						<input type="date" name="sampai" class="form-control" required>
					</div>
					<div class="form-group">
						<label>Nomor Kartu Anggota</label>
						<input type="text" name="nomor_kta" class="form-control" required>
					</div>
					<div class="form-group">
						<label>Nomor Reg. Satpam Baru</label>
						<input type="text" name="no_reg_satpam_baru" class="form-control" required>
					</div>
					<div class="form-group">
						<label>Jabatan KTA</label>
						<input type="text" name="jabatan_kta" class="form-control" required>
					</div>
					<div class="form-group">
						<label>Tempat Terbit KTA</label>
						<input type="text" name="tempat_kta" class="form-control" required>
					</div>
					<div class="form-group">
						<label>Nama Pejabat TTD</label>
						<input type="text" name="pejabat_kta" class="form-control" required>
					</div>
					<div class="row">
						<div class="col-md-6">
							<label>Tinggi Badan (Cm)</label>
							<input type="text" name="tinggi_badan" class="form-control" >
						</div>
						<div class="col-md-6">
							<label>Berat Badan (Kg)</label>
							<input type="text" name="berat_badan" class="form-control" >
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<label>Sidik Jari 1 </label>
							<input type="text" name="sidik_jari1" class="form-control" required>
						</div>
						<div class="col-md-6">
							<label>Sidik Jari 2</label>
							<input type="text" name="sidik_jari2" class="form-control" required>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<label>Nama SMP </label>
							<input type="text" name="smp" class="form-control" >
						</div>
						<div class="col-md-6">
							<label>Tahun</label>
							<input type="text" name="th_smp" class="form-control" >
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<label>Nama SMA </label>
							<input type="text" name="sma" class="form-control" >
						</div>
						<div class="col-md-6">
							<label>Tahun</label>
							<input type="text" name="th_sma" class="form-control" >
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<label>Nama Perguruan Tinggi </label>
							<input type="text" name="pt" class="form-control" >
						</div>
						<div class="col-md-6">
							<label>Tahun</label>
							<input type="text" name="th_pt" class="form-control" >
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<label>No. Gada Pratama</label>
							<input type="text" name="nomor_gada_pratama" class="form-control">
						</div>
						<div class="col-md-4">
							<label>Blanko Gada Pratama</label>
							<input type="text" name="nomor_blanko_gada_pratama" class="form-control">
						</div>
						<div class="col-md-4">
							<label>Tahun</label>
							<input type="text" name="th_gada_pratama" class="form-control" >
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<label>No. Gada Madya</label>
							<input type="text" name="nomor_gada_madya" class="form-control" >
						</div>
						<div class="col-md-4">
							<label>Blanko Gada Madya</label>
							<input type="text" name="nomor_blanko_gada_madya" class="form-control" >
						</div>
						<div class="col-md-4">
							<label>Tahun</label>
							<input type="text" name="th_gada_madya" class="form-control">
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

<?php foreach ($list as $dt) { ?>
	<!-- modal form untuk edit lisensi -->
	<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal label" aria-hidden="true" id="modalEdit<?= $dt->id ?>" data-backdrop="static">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="modalTitle_jabatan">Edit Lisesnsi Profesi</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>

				<form action="<?= site_url('pegawai/EditLisensi/') . $cID . "/" . $cUnit . '/' . $cJabatan . '/' . $dt->id ?>" method="post">

					<div class="modal-body">
						<div class="form-group">
							<input type="hidden" name="id" value="<?= $dt->id ?>">
							<label>No.Lisensi</label>
							<input type="text" name="nomor" class="form-control" value="<?= $dt->nomor ?>" required>
						</div>
						<div class="form-group">
							<label>Nama Lisensi</label>
							<input type="text" name="namaSertifikat" class="form-control" value="<?= $dt->namaSertifikat ?>" required>
						</div>
						<div class="form-group">
							<label>Tanggal Terbit</label>
							<input type="date" name="berlaku" class="form-control" value="<?= $dt->berlaku ?>" required>
						</div>
						<div class="form-group">
							<label>Berlaku sampai dengan</label>
							<input type="date" name="sampai" class="form-control" value="<?= $dt->sampai ?>" required>
						</div>
						<div class="form-group">
							<label>Nomor Kartu Anggota</label>
							<input type="text" name="nomor_kta" class="form-control" value="<?= $dt->nomor_kta ?>" required>
						</div>
						<div class="form-group">
							<label>Nomor Reg. Satpam Baru</label>
							<input type="text" name="no_reg_satpam_baru" class="form-control" value="<?= $dt->no_reg_satpam_baru ?>" required>
						</div>
						<div class="form-group">
							<label>Jabatan KTA</label>
							<input type="text" name="jabatan_kta" class="form-control" value="<?= $dt->jabatan_kta ?>" required>
						</div>
						<div class="form-group">
							<label>Tempat Terbit KTA</label>
							<input type="text" name="tempat_kta" class="form-control" value="<?= $dt->tempat_kta ?>" required>
						</div>
						<div class="form-group">
							<label>Nama Pejabat TTD</label>
							<input type="text" name="pejabat_kta" class="form-control" value="<?= $dt->pejabat_kta ?>" required>
						</div>
						<div class="row">
						<div class="col-md-6">
							<label>Sidik Jari 1 </label>
							<input type="text" name="sidik_jari1" class="form-control" value="<?= $dt->sidik_jari1 ?>" required>
						</div>
						<div class="col-md-6">
							<label>Sidik Jari 2</label>
							<input type="text" name="sidik_jari2" class="form-control" value="<?= $dt->sidik_jari2 ?>" required>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<label>Tinggi Badan (Cm)</label>
							<input type="text" name="tinggi_badan" value="<?= $dt->tinggi_badan ?>"class="form-control" >
						</div>
						<div class="col-md-6">
							<label>Berat Badan (Kg)</label>
							<input type="text" name="berat_badan" value="<?= $dt->berat_badan ?>" class="form-control" >
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<label>Nama SMP </label>
							<input type="text" name="smp" class="form-control" value="<?= $dt->smp ?>" >
						</div>
						<div class="col-md-6">
							<label>Tahun</label>
							<input type="text" name="th_smp" class="form-control" value="<?= $dt->th_smp ?>" >
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-6">
							<label>Nama SMA </label>
							<input type="text" name="sma" class="form-control"  value="<?= $dt->sma ?>">
						</div>
						<div class="col-md-6">
							<label>Tahun</label>
							<input type="text" name="th_sma" class="form-control"  value="<?= $dt->th_sma ?>">
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<label>Nama Perguruan Tinggi </label>
							<input type="text" name="pt" class="form-control"  value="<?= $dt->pt?>">
						</div>
						<div class="col-md-6">
							<label>Tahun</label>
							<input type="text" name="th_pt" class="form-control" value="<?= $dt->th_pt ?>">
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<label>No. Gada Pratama</label>
							<input type="text" name="nomor_gada_pratama" class="form-control" value="<?= $dt->nomor_gada_pratama ?>">
						</div>
						<div class="col-md-4">
							<label>Blanko Gada Pratama</label>
							<input type="text" name="nomor_blanko_gada_pratama" class="form-control" value="<?= $dt->nomor_blanko_gada_pratama ?>">
						</div>
						<div class="col-md-4">
							<label>Tahun</label>
							<input type="text" name="th_gada_pratama" class="form-control" value="<?= $dt->th_gada_pratama ?>">
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<label>No. Gada Madya</label>
							<input type="text" name="nomor_gada_madya" class="form-control" value="<?= $dt->nomor_gada_madya ?>">
						</div>
						<div class="col-md-4">
							<label>Blanko Gada Madya</label>
							<input type="text" name="nomor_blanko_gada_madya" class="form-control" value="<?= $dt->nomor_blanko_gada_madya ?>">
						</div>
						<div class="col-md-4">
							<label>Tahun</label>
							<input type="text" name="th_gada_madya" class="form-control" value="<?= $dt->th_gada_madya ?>">
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

	<!-- modal form untuk hapus lisensi -->
	<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal label" aria-hidden="true" id="modalDel<?= $dt->id ?>" data-backdrop="static">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="modalTitle_jabatan">Hapus Lisesnsi Profesi</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>



				<div class="modal-body">
					<h4>Apakah anda yakin akan menghapus data ini ?</h4>
				</div>
				<div class="modal-footer">
					<a href="<?= site_url('pegawai/DelLisensi/' . $cID . "/" . $cUnit . '/' . $cJabatan . '/' . $dt->id) ?>" class="btn btn-danger btn-sm"><span class="fa fa-trash"></span> Hapus</a>
					<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><span class="fa fa-times"></span> Batal</button>
				</div>

			</div>
		</div>
	</div>
<?php } ?>