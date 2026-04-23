<div class="card card-body">
	<div class="row align-items-end">
		<div class="col-sm-12 col-md-6">
			<form method="get" class="form-inline mb-2" id="formFilterTahun">
				<label for="filter_tahun" class="mr-2">Filter Tahun</label>
				<select name="filter_tahun" id="filter_tahun" class="form-control form-control-sm mr-2" onchange="document.getElementById('formFilterTahun').submit();">
					<option value="">-- Semua --</option>
					<?php if(isset($list_tahun)){ foreach($list_tahun as $th){ ?>
						<option value="<?= $th->tahun ?>" <?= (isset($filter_tahun) && $filter_tahun==$th->tahun)?'selected':''; ?>><?= $th->tahun ?></option>
					<?php } } ?>
				</select>
			</form>
		</div>
		<div class="col-sm-12 col-md-6 text-md-right">
			<a onClick="ClearForm()" id="add" title="Tambah Data" class="btn btn-primary text-white btn-sm" data-toggle="modal" data-target="#modalView_input"><span class="fa fa-plus" ></span> Tambah Data</a>
			<a id="refresh" title="Refresh" onclick="window.location.href='<?= site_url('umk'); ?>';" class="btn btn-info text-white btn-sm"><span class="fa fa-refresh"></span> Reset</a>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-md-12">
			<table class="table table-striped" id="example1">
				<thead>
					<tr>
						<th>Tahun</th>
						<th>Unit</th>
						<th>Nilai UMK</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($dt as $row) { ?>
						<tr>
							<td><?= $row->tahun ?></td>
							<?php 
							$unite=$this->umk_model->tunjangan_unit_id($row->idSatKerja)->row();
							?>
							<td><?= $unite->nama ?></td>
							<td><?= number_format($row->gajiPokok,0,',','.') ?></td>
							<td>
								<!-- modal form untuk edit data -->
									<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal label" aria-hidden="true" id="modalEdit<?php echo $row->id;?>" data-backdrop="static">
										<div class="modal-dialog modal-lg">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="modalTitle_umk">Edit Data UMK</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<form action="<?= site_url('umk/Update_umk/'.$row->id) ?>" method="post">
													<input type="hidden" name="id" id="id">
													<div class="modal-body">
														<div class="form-group">
															<div class="row">
																<div class="col-md-3">Tahun</div>
																<div class="col-md-4"><input type="text" name="tahun" class="form-control" id="tahun" value="<?=$row->tahun;?>"></div>
															</div>
														</div>
														<div class="form-group">
															<div class="row">
																<div class="col-md-3">Unit</div>
																<?php 
																$unit=$this->umk_model->tunjangan_unit()->result();
																?>
																<div class="col-md-4">
																	<select name="unit_umk" class="form-control" id="unit_umk">
																	<?php
																	foreach($unit as $unit_umk)
																	{
																		if($unit_umk->id==$row->idSatKerja)
																		{
																	?>
																			<option value="<?php echo $unit_umk->id?>" selected="selected"><?php echo $unit_umk->nama?></option>
																	<?php
																		}
																		else
																		{
																	?>
																			<option value="<?php echo $unit_umk->id?>"><?php echo $unit_umk->nama?></option>
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
																<div class="col-md-3">Nilai UMK</div>
																<div class="col-md-4"><input type="text" name="gaji_pokok" class="form-control" value="<?=$row->gajiPokok;?>"></div>
															</div>
														</div>
													</div>
													<div class="modal-footer">
														<button type="submit" class="btn btn-primary btn-sm"><span class="fa fa-check"></span> Ubah Data</button>
														<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><span class="fa fa-times"></span> Close</button>
													</div>
												</form>
											</div>
										</div>
									</div>
								<!------------------------------------edit form----------------------------------------------------------------------------------------------------------------->
								<div class="btn-group">
									<button type="button" class="btn btn-sm btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<i class="fa fa-gears"></i>
									</button>
									<div class="dropdown-menu" aria-labelledby="Dropdown Menu">
										<a href="" class="dropdown-item edit" title="edit data" data-toggle="modal" data-target="#modalEdit<?php echo $row->id; ?>"><i class="fa fa-pencil"></i> Edit</a>
										<a href="<?= site_url('umk/Hapus/'.$row->id) ?>" class="dropdown-item hapus" title="hapus data" ><i class="fa fa-trash" aria-hidden="true"></i> Hapus</a>
										<a href="<?= site_url('umk/Update_gaji/'.$row->idSatKerja.'/'.$row->gajiPokok.'/'.$row->tunjanganTetap) ?>" class="dropdown-item hapus" title="copy data" ><i class="fa fa-database" aria-hidden="true"></i> Copy ke gaji Pegawai</a>								
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
				<h5 class="modal-title" id="modalTitle_umk">Tambah Data UMK</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= site_url('umk/Simpan') ?>" method="post">
				<input type="hidden" name="id" id="id">
				<div class="modal-body">
					<div class="form-group">
						<div class="row">
							<div class="col-md-3">Tahun</div>
							<div class="col-md-4"><input type="text" name="tahun" class="form-control" id="tahun"></div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-md-3">Unit</div>
							<?php 
							$unit=$this->umk_model->tunjangan_unit()->result();
							?>
							<div class="col-md-4">
								<select name="unit_umk" class="form-control" id="unit_umk">
								<?php
								foreach($unit as $unit_umk)
								{
								?>
									<option value="<?php echo $unit_umk->id?>"><?php echo $unit_umk->nama?></option>
								<?php
								}
								?>
								</select>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-md-3">Nilai UMK</div>
							<div class="col-md-4"><input type="text" name="gaji_pokok" class="form-control" id="gaji_pokok"></div>
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

<script>
	function GetData(id) {
		$.ajax({
				url: "<?= site_url('umk/GetUmk') ?>",
				type: 'POST',
				dataType: 'json',
				data: {id: id},
				success: function(data) {
					//memasukkan data umk ke dalam form
					$('#tahun').val(data.tahun);
					const dlJabatan = document.getElementById("unit_umk");
					// Loop melalui setiap opsi pada dropdownlist
					for (let i = 0; i < dlJabatan.options.length; i++) {
						const option = dlJabatan.options[i];

						// Membandingkan nilai value dari setiap opsi dengan nilai yang ingin ditetapkan
						if (option.value === data.idSatKerja) {
							// Menetapkan opsi yang dipilih
							dlJabatan.selectedIndex = i;
							break; // Keluar dari loop setelah menemukan opsi yang cocok
						}
					}
					$('#id').val(data.id);
				}
			});
	}
	function ClearForm() {
		$('#tahun').val('');
		$('#kota_id').val('');
		$('#id').val(0);
		$('#nilai_umk').val('');
	}
	function SetHapus(id) {
		$('#idhapus').val(id);
	}
</script>