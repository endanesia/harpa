<div class="card card-body">
	<div class="row">
		<div class="col-sm-12 col-md-12 text-md-right">
		<a href="" class="btn btn-primary pull-right" ><i class="fa fa-plus"></i> Tambah Data</a>
		<span class="pull-right"> &nbsp;&nbsp;</span> 
		<a href="" class="btn btn-success pull-right" ><i class="fa fa-file-excel-o"></i> Import Data</a>
			<table>
				<tr>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Unit : </td>
					<td>
						<select name="skpd" class="form-control">
							<option>-- Pilih Unit Kerja --</option>
							<?php 
								foreach ($satkerja as $sat) { ?>
								<option value="<?= $sat->id ?>" <?=  $this->session->filter_unit == $sat->id ? 'selected' : '' ?>><?= $sat->nama ?></option>
								<?php }
							?>
						</select>
					</td>
					<td>
						<select name="tunjangan" class="form-control">
							<option>-- Pilih Tunjangan --</option>
						</select>
					</td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bulan :</td>
					<td>
						<select name="bulan" class="form-control">
							<option value="01">Januari</option>
							<option value="02">Februari</option>
							<option value="03">Maret</option>
							<option value="04">April</option>
							<option value="05">Mei</option>
							<option value="06">Juni</option>
							<option value="07">Juli</option>
							<option value="08">Agustus</option>
							<option value="09">September</option>
							<option value="10">Oktober</option>
							<option value="11">November</option>
							<option value="12">Desember</option>
						</select>
					</td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tahun :</td>
					<td>
						<select name="tahun" class="form-control">
							<?php
							$cth = date('Y');
							if (date('m')==12) {
								$cth = date('Y')+1;									
							}
							for ($x = $cth; $x >= 2023; $x--) {
							?>
								<option value="<?= $x ?>"><?= $x ?></option>
							<?php } ?>
						</select>
					</td>
					<td>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button class="btn btn-primary"><i class="fa fa-search"></i> Filter</button>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-md-12">
			
			<table class="table  table-striped" id="example1">
				<thead>
					<tr>
						<th>NIP</th>
						<th>Pegawai</th>
						<th>Nama Tunjangan</th>
						<th>Nilai</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>1234567</td>
						<td>Nanang</td>
						<td>Transport</td>
						<td>Rp. 900.000</td>
						<td>
							<a href="" class="btn btn-xs btn-warning" title="Edit data"><i class="fa fa-pencil "></i> Edit</a> | 
							<a href="" class="btn btn-xs btn-danger" title="Hapus" ><i class="fa fa-trash "></i> Hapus</a> 
						</td>

					</tr>
				</tbody>
			</table>
		</div>
	</div>

</div>

<!-- modal form untuk input data -->
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal label" aria-hidden="true" id="modalNew" data-backdrop="static">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalTitle_shift">Input SPKL</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= site_url('gaji/Simpan') ?>" method="post">
				<input type="hidden" name="id" id="id">
				<div class="modal-body">
					<div class="form-group">
						<div class="row">
							<div class="col-md-3">No WO</div>
							<div class="col-md-3">
								<input type="text" class="form-control" required>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">Uraian</div>
							<div class="col-md-9">
								<textarea class="form-control" row2=2></textarea>
							</div>
						</div>

						<div class="row">
							<div class="col-md-3">Aktivitas</div>
							<div class="col-md-5">
								<select class="form-control">
									<option value="18">K3</option>
									<option value="19">Lingkungan</option>
									<option value="20">Preventive Maintenance</option>
									<option value="21">Predictive Maintenance</option>
									<option value="22">Corrective Maintenance</option>
									<option value="24">Overhoul / Inspection</option>
									<option value="26">Engineering / Project / Modifikasi</option>
									<option value="60">Non Instalasi / Umum</option>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">Tanggal</div>
							<div class="col-md-3">
								<input type="date" class="form-control">
							</div>
							<div class="col-md-1">Ket.Hari</div>
							<div class="col-md-3">
								<select class="form-control">
									<option value="Kerja">Kerja</option>
									<option value="Libur">Libur</option>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">Waktu</div>
							<div class="col-md-2">
								<input type="time" class="form-control">
							</div>
							<div class="col-md-1">s/d</div>
							<div class="col-md-2">
								<input type="time" class="form-control">
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">Beban Anggaran</div>
							<div class="col-md-9">
								<input type="text" class="form-control">
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-md-3">Pemberi Tugas</div>
							<div class="col-md-5">
								<input type="text" class="form-control">
							</div>
							<div class="col-md-1">NID</div>
							<div class="col-md-3">
								<input type="text" class="form-control">
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">Tanggal</div>
							<div class="col-md-5">
								<input type="date" class="form-control">
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-md-3">Pemeriksa</div>
							<div class="col-md-5">
								<input type="text" class="form-control">
							</div>
							<div class="col-md-1">NID</div>
							<div class="col-md-3">
								<input type="text" class="form-control">
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">Tanggal</div>
							<div class="col-md-5">
								<input type="date" class="form-control">
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-md-3">Asman</div>
							<div class="col-md-5">
								<input type="text" class="form-control">
							</div>
						</div>												
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary btn-sm" data-dismiss="modal"><span class="fa fa-check"></span> Simpan</button>
					<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><span class="fa fa-times"></span> Close</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- modal form untuk input data -->
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal label" aria-hidden="true" id="modalPerson" data-backdrop="static">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalTitle_shift">Input Pegawai Lembur</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= site_url('gaji/Simpan') ?>" method="post">
				<input type="hidden" name="id" id="id">
				<div class="modal-body">
					<div class="form-group">
						<div class="row">
							<div class="col-md-5">
								<label>Tambah Personel yang Lembur</label>
								<select class="form-control">
									<option></option>
								</select>
								<select class="form-control">
									<option></option>
								</select>
								<select class="form-control">
									<option></option>
								</select>
								<select class="form-control">
									<option></option>
								</select>
								<select class="form-control">
									<option></option>
								</select>
							</div>
							<div class="col-md-7">
								<table class="table table-sm">
									<thead>
										<tr>
											<td>NIP</td>
											<td>Nama</td>
											<td></td>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>
												9298321
											</td>
											<td>
												Wahyu Hidayat
											</td>
											<td><a href="" class="btn btn-xs btn-danger" title="hapus data"><i class="fa fa-trash"></i></a></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
												
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary btn-sm" data-dismiss="modal"><span class="fa fa-check"></span> Simpan</button>
					<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><span class="fa fa-times"></span> Close</button>
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