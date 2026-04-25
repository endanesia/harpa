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
						<th>Unit Kerja</th>
						<th>Jabatan</th>
						<th>Kelas Jabatan</th>
						<th>Tunjangan Premi Pagi</th>
						<th>Tunjangan Premi Siang</th>
						<th>Tunjangan Premi Malam</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($dt as $row) { ?>
						<?php
							$unit=$this->premi_shift_model->unit_kerja_id($row->skpd)->row();
							$jabatan=$this->premi_shift_model->get_jabatan_id($row->idJabatan)->row();
							$kelas=$this->premi_shift_model->kelas($row->idKelasJabatan)->row();
							$lk=$this->premi_shift_model->kelas_jabatan($row->idJabatan)->result();
						?>
						<tr>
							<td><?= $unit->nama; ?></td>
							<td><?= $jabatan->namaJabatan; ?></td>
							<?php
							if(!empty($kelas))
							{
							?>
							<td><?= $kelas->kodeKelas; ?></td>
							<?php
							}
							else
							{
							?>
							<td><?= '-'; ?></td>
							<?php	
							}
							?>
							<td><?= number_format($row->nPagi,0,",",".") ?></td>
							<td><?= number_format($row->nSiang,0,",",".") ?></td>
							<td><?= number_format($row->nMalam,0,",",".") ?></td>
							<td>
								<div class="btn-group">
									<button type="button" class="btn btn-sm btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<i class="fa fa-gears"></i>
									</button>
									<div class="dropdown-menu" aria-labelledby="Dropdown Menu">
										<a href="" class="btn btn-ms" title="edit data" data-toggle="modal" data-target="#modalEdit<?php echo $row->id; ?>"><i class="fa fa-pencil"></i> Edit</a><br>
										<a href="<?php echo site_url() . '/premi_shift/Hapus/' .$row->id; ?>" class="btn btn-ms" title="hapus data"><i class="fa fa-trash"></i> Hapus</a>
									</div>
								</div>
							</td>
							<!----Edit Data--------------->
							<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal label" aria-hidden="true" id="modalEdit<?=$row->id;?>" data-backdrop="static">
								<div class="modal-dialog modal-lg">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="modalTitle_tunjangan">Edit Data Premi Shift</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>
										<form action="<?= site_url('premi_shift/Ubah/'.$row->id) ?>" method="post">
											<input type="hidden" name="id" id="id">
											<div class="modal-body">
												<div class="form-group">
													<div class="row">
														<div class="col-md-4">Unit Kerja</div>
														<div class="col-md-4">
															<select name="skpd" class="form-control" id="skpd">
																<option>- Pilih Unit Kerja -</option>
																<?php foreach ($unit_kerja as $uk) 
																{ 
																	if($uk->id==$row->id)
																	{
																?>
																	<option value="<?= $uk->id ?>" selected="selected"><?= $uk->nama ?></option>
																<?php 
																	}
																	else
																	{
																?>
																	<option value="<?= $uk->id ?>"><?= $uk->nama ?></option>
																<?php
																	}
																} 
																?>
															</select>
														</div>
													</div>
												</div>
												<div class="form-group">
													<div class="row">
														<div class="col-md-4">Jabatan</div>
														<div class="col-md-4">
															<select name="jabatan" class="form-control" onchange="GetKelasJabatan(this.value,<?=$row->id?>)">
																<option>- Pilih Jabatan -</option>
																<?php foreach ($list_jabatan as $jab) { 
																	if($jab->idJabatan==$row->idJabatan)
																	{
																?>
																	<option value="<?= $jab->idJabatan ?>" selected="selected"><?= $jab->namaJabatan ?></option>
																<?php 
																	}
																	else
																	{
																?>
																	<option value="<?= $jab->idJabatan ?>"><?= $jab->namaJabatan ?></option>
																<?php
																	}
																} 
																?>
															</select>
														</div>
													</div>
												</div>
												<div class="form-group">
													<div class="row">
														<div class="col-md-4">Kelas Jabatan</div>
														<div class="col-md-4">
															<select name="idKelasJabatan" class="form-control" id="editkj<?= $row->id?>">
																<option>- Pilih Kelas Jabatan -</option>
																<?php foreach ($lk as $kjab) { 
																	if($kjab->id==$row->idKelasJabatan)
																	{
																?>
																	<option value="<?= $kjab->id ?>" selected="selected"><?= $kjab->kodeKelas ?></option>
																<?php
																	}
																	else
																	{
																?>
																	<option value="<?= $kjab->id ?>"><?= $kjab->kodeKelas ?></option>
																<?php		
																	}
																}
																?>
															</select>
														</div>
													</div>
												</div>
												<div class="form-group">
													<div class="row">
														<div class="col-md-4">Nilai Tunjangan Pagi (Rp)</div>
														<div class="col-md-4"><input type="number" name="nilaipagi" class="form-control" id="nilai" value="<?= $row->nPagi;?>"></div>
													</div>
												</div>
												<div class="form-group">
													<div class="row">
														<div class="col-md-4">Nilai Tunjangan Siang (Rp)</div>
														<div class="col-md-4"><input type="number" name="nilaisiang" class="form-control" id="nilai" value="<?= $row->nSiang;?>"></div>
													</div>
												</div>
												<div class="form-group">
													<div class="row">
														<div class="col-md-4">Nilai Tunjangan Malam (Rp)</div>
														<div class="col-md-4"><input type="number" name="nilaimalam" class="form-control" id="nilai" value="<?= $row->nMalam;?>"></div>
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
							<!----End Edit------->
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
				<h5 class="modal-title" id="modalTitle_tunjangan">Input Data Premi Shift</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= site_url('premi_shift/Simpan') ?>" method="post">
				<input type="hidden" name="id" id="id">
				<div class="modal-body">
					<div class="form-group">
						<div class="row">
							<div class="col-md-4">Unit Kerja</div>
							<div class="col-md-4">
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
							<div class="col-md-4">Jabatan</div>
							<div class="col-md-4">
								<select name="jabatan" class="form-control" id="jabatan" onchange="GetKelasJabatan(this.value,'')">
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
							<div class="col-md-4">Kelas Jabatan</div>
							<div class="col-md-4">
								<select name="idKelasJabatan" class="form-control" id="editkj">
									<option>- Pilih Kelas Jabatan -</option>
								</select>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-md-4">Nilai Tunjangan Pagi (Rp)</div>
							<div class="col-md-4"><input type="number" name="nilaipagi" class="form-control" id="nilai"></div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-md-4">Nilai Tunjangan Siang (Rp)</div>
							<div class="col-md-4"><input type="number" name="nilaisiang" class="form-control" id="nilai"></div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-md-4">Nilai Tunjangan Malam (Rp)</div>
							<div class="col-md-4"><input type="number" name="nilaimalam" class="form-control" id="nilai"></div>
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
				<h5 class="modal-title" id="modalTitle_tunjangan">Hapus Data</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= site_url('tunjangan/Hapus') ?>" method="post">
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

	function ClearForm() {
		$('#namaTunjangan').val('');
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

	function GetKelasJabatan(idjabatan,id_data) {
		$.ajax({
			url: "<?= site_url('tunjangan/GetKelasJabatan') ?>",
			type: 'POST',
			dataType: 'json',
			data: {
				id: idjabatan
			},
			success: function(hasil) {
				
				const kombojabatan = document.getElementById("editkj"+id_data);
				//console.log(kombojabatan);
				kombojabatan.innerHTML = "";
				var option = document.createElement("option");
				option.text = '- Pilih Kelas Jabatan -';
				kombojabatan.appendChild(option);
				for (var i = 0; i < hasil.length; i++) {
					var option = document.createElement("option");
					option.value = hasil[i].id;
					option.text = hasil[i].kodeKelas;
					kombojabatan.appendChild(option);
				}
			}
		});
	}
</script>