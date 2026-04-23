<div class="card card-body">
	<div class="row">
		<div class="col-sm-12 col-md-12 text-md-right">
			<form method="post">
			<table>
				<tr>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tahun :</td>
					<td>
						<select name="tahun" class="form-control">
							<?php
							$cth = date('Y');
							if (date('m')==12) {
								$cth = date('Y')+1;									
							}
							for ($x = $cth; $x >= 2023; $x--) {
if ($tahun == $x) {
    ?>
								<option value="<?= $x ?>" selected><?= $x ?></option>
							<?php } else { ?>
								<option value="<?= $x ?>" ><?= $x ?></option>
							<?php } } ?>
						</select>
					</td>
					<td>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button class="btn btn-primary" type="submit"><i class="fa fa-search"></i> Filter</button>
					</td>
				</tr>
			</table>
			</form>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-md-12">
			
			<table class="table table-striped" id="example1">
				<thead>
					<tr>
						<th>Unit</th>
						<th>Periode</th>
						<th>Hitung</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				<?php
				foreach($satkerja as $unit)
				{
				?>
				<tr>
						<td><?php echo $unit->nama;?></td>
						<?php
						if(isset($this->session->filter_tahun))
						{
						?>
						<td><?php echo date('m').'/'.$this->session->filter_tahun;?></td>
						<?php
						}
						else
						{
						?>
						<td><?php echo date('m').'/'.date('Y');?></td>
						<?php	
						}
						?>
						<td>
							<a href="<?php echo site_url() . '/tunj_cuti/hitung_tunj/'.$unit->id.'/'.$tahun;?>" title="Detail" class="btn btn-xs btn-primary"><i class="fa fa-gear "></i> Hitung Sekarang</a>
						</td>
						<td>
							<?php $dt = $this->tunj_cuti_model->GetTunjPerUnit($unit->id,$tahun)->row();
								if (isset($dt)) {
									echo "Rp. " . number_format($dt->nilai,0,',','.');
									echo "<a href='". site_url("tunj_cuti/?skpd=$unit->id&tahun=$tahun") ."'>( " . $dt->jml . " personel)</a>";
								}
							?>
						</td>
					</tr>
				<?php
				}
				?>
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