<div class="card card-body">
	<div class="row">
		<div class="col-md-12">
		<?php if ($this->session->flashdata('errMsg')) {
			echo "<div class='alert alert-warning'>". $this->session->flashdata('errMsg') ."</div>";
		} ?>	
		</div>	
	</div>
	<div class="row">
		<div class="col-sm-12 col-md-12 text-md-right">
			<a href="#" data-toggle="modal" data-target="#modalData" onclick="ClearForm()" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Tambah Data</a>
			<span class="pull-right"> &nbsp;&nbsp;</span>
			<a href="#" data-toggle="modal" data-target="#modalImport" class="btn btn-success pull-right"><i class="fa fa-file-excel-o"></i> Import Data</a>
			<form method="post">
				<table>
					<tr>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Unit : </td>
						<td>
							<select name="skpd" class="form-control" onchange="GetTunjangan()" id="skpd">
								<option>-- Pilih Unit Kerja --</option>
								<?php
								foreach ($satkerja as $sat) { ?>
									<option value="<?= $sat->id ?>" <?= $this->session->filter_unit == $sat->id ? 'selected' : '' ?>><?= $sat->nama ?></option>
								<?php }
								?>
							</select>
						</td>

						<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Periode :</td>
						<td>
							<select name="bulan" class="form-control" onchange="GetTunjangan()" id="bulan">
								<option value="1" <?= $this->session->filter_bulan == "1" ? ' selected ' : '' ?>>Januari</option>
								<option value="2" <?= $this->session->filter_bulan == "2" ? ' selected ' : '' ?>>Februari</option>
								<option value="3" <?= $this->session->filter_bulan == "3" ? ' selected ' : '' ?>>Maret</option>
								<option value="4" <?= $this->session->filter_bulan == "4" ? ' selected ' : '' ?>>April</option>
								<option value="5" <?= $this->session->filter_bulan == "5" ? ' selected ' : '' ?>>Mei</option>
								<option value="6" <?= $this->session->filter_bulan == "6" ? ' selected ' : '' ?>>Juni</option>
								<option value="7" <?= $this->session->filter_bulan == "7" ? ' selected ' : '' ?>>Juli</option>
								<option value="8" <?= $this->session->filter_bulan == "8" ? ' selected ' : '' ?>>Agustus</option>
								<option value="9" <?= $this->session->filter_bulan == "9" ? ' selected ' : '' ?>>September</option>
								<option value="10" <?= $this->session->filter_bulan == "10" ? ' selected ' : '' ?>>Oktober</option>
								<option value="11" <?= $this->session->filter_bulan == "11" ? ' selected ' : '' ?>>November</option>
								<option value="12" <?= $this->session->filter_bulan == "12" ? ' selected ' : '' ?>>Desember</option>
							</select>
						</td>

						<td>
							<select name="tahun" class="form-control" onchange="GetTunjangan()" id="tahun">
								<?php
								$cth = date('Y');
								if (date('m')==12) {
									$cth = date('Y')+1;									
								}
								for ($x = $cth; $x >= 2023; $x--) {
								?>
									<option value="<?= $x ?>" <?= $this->session->filter_tahun == $x ? ' selected ' : ''  ?>><?= $x ?></option>
								<?php } ?>
							</select>
						</td>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tunjangan :</td>
						<td>
							<select name="tunjangan" class="form-control" id="tunjangan">
								<option>-- Pilih Tunjangan --</option>
								<?php
								foreach ($tunj as $t) {
									if ($t->nama_tunjangan == $this->session->filter_tunjangan) {
										echo "<option value='" . $t->nama_tunjangan . "' selected >" . $t->nama_tunjangan . "</option>";
									} else {
										echo "<option value='" . $t->nama_tunjangan . "'>" . $t->nama_tunjangan . "</option>";
									}
								}
								?>
							</select>
						</td>
						<td>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button class="btn btn-primary"><i class="fa fa-search"></i> Filter</button>
						</td>
					</tr>
				</table>
			</form>
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
						<th>Jabatan</th>
						<th>Nama Tunjangan</th>
						<th>Nilai</th>
						<th>Keterangan</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php $total = 0;
					foreach ($dt as $rs) {
						$total = $total + $rs->jml; ?>
						<tr>
							<td><?= $rs->nip ?></td>
							<td><?= $rs->namaPegawai ?></td>
							<td><?= $rs->jabatan ?></td>
							<td><?= $rs->nama_tunjangan ?></td>
							<td align="right">Rp.<?= number_format($rs->jml, 0, ',', '.') ?> </td>
							<td><?= $rs->ket ?></td>
							<td>
								<a href="#" onclick="SetData('<?= $rs->id ?>','<?= $rs->bulan ?>','<?= $rs->tahun ?>','<?= $rs->nama_tunjangan ?>','<?= $rs->nip ?>','<?= $rs->jml ?>','<?= $rs->id_unit ?>','<?= $rs->ket ?>')" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#modalData" title="Edit data"><i class="fa fa-pencil "></i> Edit</a> |
								<a href="#" onclick="SetHapus('<?= $rs->id ?>','<?= $rs->nama_tunjangan . ' milik ' . $rs->namaPegawai ?>')" data-toggle="modal" data-target="#modalHapus" class="btn btn-xs btn-danger" title="Hapus"><i class="fa fa-trash "></i> Hapus</a>
							</td>

						</tr>
					<?php } ?>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td> Total : </td>
						<td align="right">Rp.<?= number_format($total, 0, ',', '.') ?> </td>
						<td></td>
						<td>
						<a href="#"  data-toggle="modal" data-target="#modalHapusAll" class="btn btn-xs btn-danger" title="Hapus Semua"><i class="fa fa-trash "></i> Hapus Semua</a>|
								
							
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

</div>

<!-- modal form untuk input data -->
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal label" aria-hidden="true" id="modalData" data-backdrop="static">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalTitle_shift">Input Data Tunjangan</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= site_url('gaji/simpan_item_tunjangan') ?>" method="post">
				<input type="hidden" name="id" id="id">
				<div class="modal-body">
					<div class="row form-group">
						<div class="col-md-3">Unit</div>
						<div class="col-md-7">
							<select name="id_unit" class="form-control" onchange="GetPegawai(this.value,myCb)" id="id_unit">
								<option>-- Pilih Unit Kerja --</option>
								<?php
								foreach ($satkerja as $sat) { ?>
									<option value="<?= $sat->id ?>" <?= $this->session->filter_unit == $sat->id ? 'selected' : '' ?>><?= $sat->nama ?></option>
								<?php }
								?>
							</select>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-3">Periode Gaji</div>
						<div class="col-md-4">
							<select name="bln" class="form-control"  id="bln">
								<option value="1" <?= $this->session->filter_bulan == "1" ? ' selected ' : '' ?>>Januari</option>
								<option value="2" <?= $this->session->filter_bulan == "2" ? ' selected ' : '' ?>>Februari</option>
								<option value="3" <?= $this->session->filter_bulan == "3" ? ' selected ' : '' ?>>Maret</option>
								<option value="4" <?= $this->session->filter_bulan == "4" ? ' selected ' : '' ?>>April</option>
								<option value="5" <?= $this->session->filter_bulan == "5" ? ' selected ' : '' ?>>Mei</option>
								<option value="6" <?= $this->session->filter_bulan == "6" ? ' selected ' : '' ?>>Juni</option>
								<option value="7" <?= $this->session->filter_bulan == "7" ? ' selected ' : '' ?>>Juli</option>
								<option value="8" <?= $this->session->filter_bulan == "8" ? ' selected ' : '' ?>>Agustus</option>
								<option value="9" <?= $this->session->filter_bulan == "9" ? ' selected ' : '' ?>>September</option>
								<option value="10" <?= $this->session->filter_bulan == "10" ? ' selected ' : '' ?>>Oktober</option>
								<option value="11" <?= $this->session->filter_bulan == "11" ? ' selected ' : '' ?>>November</option>
								<option value="12" <?= $this->session->filter_bulan == "12" ? ' selected ' : '' ?>>Desember</option>
							</select>
						</div>
						<div class="col-md-3">
							<select name="thn" class="form-control"  id="thn">
								<?php
								$cth = date('Y');
								for ($x = $cth; $x >= 2023; $x--) {
								?>
									<option value="<?= $x ?>" <?= $this->session->filter_tahun == $x ? ' selected ' : ''  ?>><?= $x ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-3">Pegawai</div>
						<div class="col-md-9">
							<select name="nip" class="form-control" id="nip">
								<option>-- PIlih Nama Pegawai --</option>
							</select>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-3">Nama Tunjangan</div>
						<div class="col-md-4">
						<input type="text" name="nama_tunjangan" class="form-control" id="nama_tunjangan" required>
						</div>
						<div class="col-md-2">Nominal (Rp)</div>
						<div class="col-md-3">
						<input type="number" name="jml" class="form-control" id="jml" required>
						</div>
					</div>

					<div class="row form-group">
						<div class="col-md-3">Keterangan</div>
						<div class="col-md-9">
							<input type="text" name="ket" class="form-control" id="ket">
						</div>
					</div>
					

				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary btn-sm" ><span class="fa fa-check"></span> Simpan</button>
					<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><span class="fa fa-times"></span> Close</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- modal form untuk hapus data -->
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal label" aria-hidden="true" id="modalHapus" data-backdrop="static">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalTitle_shift">Hapus Tunjangan <?= $this->session->filter_tunjangan  ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= site_url('gaji/del_item_tunjangan_all') ?>" method="post">
				<div class="modal-body">
					<div class="form-group">
						<div class="row">
							
							<div class="col-md-12" align="center">
								<p>Apakah anda yakin akan menghapus semua tunjangan <?= $this->session->filter_tunjangan ?> ?</p>
							</div>
						</div>

					</div>
				</div>
				<div class="modal-footer">
				<input type="hidden" name="unit" value="<?= $this->session->filter_unit ?>">
					<input type="hidden" name="bulan" value="<?= $this->session->filter_bulan ?>">
					<input type="hidden" name="tahun" value="<?= $this->session->filter_tahun ?>">
					<input type="hidden" name="tunjangan" value="<?= $this->session->filter_tunjangan ?>">
					<button type="submit" class="btn btn-danger btn-sm" ><span class="fa fa-trash"></span> Hapus Semua</button>
					<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><span class="fa fa-times"></span> Close</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- modal form untuk hapus semua data -->
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal label" aria-hidden="true" id="modalHapusAll" data-backdrop="static">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Hapus Semua Data Tunjangan</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<div class="row">
						<div class="col-md-12" align="center">
							<p>Apakah anda yakin akan menghapus semua data tunjangan <?= $this->session->filter_tunjangan ?>?</p>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<a href="<?= site_url('gaji/del_tunjangan_all/' . $this->session->filter_tunjangan . '/' . $this->session->filter_unit . '/' . $this->session->filter_bulan . '/' . $this->session->filter_tahun) ?>" class="btn btn-danger btn-sm"><span class="fa fa-trash"></span> Hapus Semua</a>
				<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><span class="fa fa-times"></span> Close</button>
			</div>
		</div>
	</div>
</div>

<!-- modal form untuk import data -->
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal label" aria-hidden="true" id="modalImport" data-backdrop="static">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalTitle_shift">Import Excel</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= site_url('gaji/import_tunjangan') ?>" method="post" enctype="multipart/form-data">
				<div class="modal-body">
				<div class="row form-group">
						<div class="col-md-3">Unit</div>
						<div class="col-md-7">
							<select name="id_unit" class="form-control">
								<option>-- Pilih Unit Kerja --</option>
								<?php
								foreach ($satkerja as $sat) { ?>
									<option value="<?= $sat->id ?>" <?= $this->session->filter_unit == $sat->id ? 'selected' : '' ?>><?= $sat->nama ?></option>
								<?php }
								?>
							</select>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-3">Periode Gaji</div>
						<div class="col-md-4">
							<select name="bln" class="form-control">
								<option value="1" <?= $this->session->filter_bulan == "1" ? ' selected ' : '' ?>>Januari</option>
								<option value="2" <?= $this->session->filter_bulan == "2" ? ' selected ' : '' ?>>Februari</option>
								<option value="3" <?= $this->session->filter_bulan == "3" ? ' selected ' : '' ?>>Maret</option>
								<option value="4" <?= $this->session->filter_bulan == "4" ? ' selected ' : '' ?>>April</option>
								<option value="5" <?= $this->session->filter_bulan == "5" ? ' selected ' : '' ?>>Mei</option>
								<option value="6" <?= $this->session->filter_bulan == "6" ? ' selected ' : '' ?>>Juni</option>
								<option value="7" <?= $this->session->filter_bulan == "7" ? ' selected ' : '' ?>>Juli</option>
								<option value="8" <?= $this->session->filter_bulan == "8" ? ' selected ' : '' ?>>Agustus</option>
								<option value="9" <?= $this->session->filter_bulan == "9" ? ' selected ' : '' ?>>September</option>
								<option value="10" <?= $this->session->filter_bulan == "10" ? ' selected ' : '' ?>>Oktober</option>
								<option value="11" <?= $this->session->filter_bulan == "11" ? ' selected ' : '' ?>>November</option>
								<option value="12" <?= $this->session->filter_bulan == "12" ? ' selected ' : '' ?>>Desember</option>
							</select>
						</div>
						<div class="col-md-3">
							<select name="thn" class="form-control" >
								<?php
								$cth = date('Y');
								for ($x = $cth; $x >= 2023; $x--) {
								?>
									<option value="<?= $x ?>" <?= $this->session->filter_tahun == $x ? ' selected ' : ''  ?>><?= $x ?></option>
								<?php } ?>
							</select>
						</div>
					</div>					
					<div class="form-group">
						<div class="row">
							<div class="col-md-3">
								Nama Tunjangan
							</div>
							<div class="col-md-9">
								<input type="text" name="nama_tunjangan" class="form-control" required>
							</div>		
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-md-3">
								File Excel
							</div>
							<div class="col-md-3">
								<input type="file" name="file" accept=".xls,.xlsx"  required>
							</div>		
							<div class="col-md-6" align="right">
								<a href="<?= base_url('template_tunjangan_gaji.xlsx') ?>"><small>(Download sample template excel)</small></a>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary btn-sm" ><span class="fa fa-check"></span> Import</button>
					<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><span class="fa fa-times"></span> Close</button>
				</div>
			</form>
		</div>
	</div>
</div>


<script>
	function GetTunjangan() {
		const unit = document.getElementById('skpd').value;
		const bulan = document.getElementById('bulan').value;
		const tahun = document.getElementById('tahun').value;
		$.ajax({
			url: "<?= site_url('gaji/GetListTunjangan') ?>",
			type: 'POST',
			dataType: 'json',
			data: {
				unit: unit,
				bulan: bulan,
				tahun: tahun,
			},
			success: function(data) {
				const combobox = document.getElementById("tunjangan");
				//console.log(kombojabatan);
				combobox.innerHTML = "";
				var option = document.createElement("option");
				option.text = '- Pilih Tunjangan -';
				combobox.appendChild(option);
				console.log(data);
				for (var i = 0; i < data.length; i++) {
					var option = document.createElement("option");
					option.value = data[i].nama_tunjangan;
					option.text = data[i].nama_tunjangan;
					combobox.appendChild(option);
				}
			}
		});
	}

	function GetPegawai(id,selected) {
		$.ajax({
			url: "<?= site_url('gaji/GetPegawaiUnit') ?>",
			type: 'POST',
			dataType: 'json',
			data: {
				unit: id,
			},
			success: function(data) {
				const combobox = document.getElementById("nip");
				//console.log(kombojabatan);
				combobox.innerHTML = "";
				var option = document.createElement("option");
				option.text = '-- Pilih Nama Pegawai --';
				combobox.appendChild(option);
				console.log(data);
				for (var i = 0; i < data.length; i++) {
					var option = document.createElement("option");
					option.value = data[i].nipBaru;
					option.text = data[i].namaPegawai + '               (' + data[i].jabatan + ')';
					if (data[i].nipBaru === selected) {
						option.selected = 'selected';
					}
					combobox.appendChild(option);
				}
			}
		});
	}

	function ClearForm() {
		GetPegawai(<?= $this->session->filter_unit ?>);
		$('#id_unit').val($('#id_unit').val());
		$('#bln').val($('#bulan').val());
		$('#id').val(0);
		$('#thn').val($('#tahun').val());
		$('#nip').val('');
		$('#nama_tunjangan').val('');
		$('#jml').val('');
		$('#ket').val('');
	}

	function SetHapus(id,txt) {
		$('#idHapus').val(id);
		console.log(txt);
		document.getElementById('msg').innerHTML = txt;
	}

	function SetData(id,bulan,tahun,nama_tunjangan,nip,jml,id_unit,ket) {
		$('#id').val(id);
		GetPegawai(id_unit, nip);
		$('#id_unit').val(id_unit);
		$('#bln').val(bulan);
		$('#thn').val(tahun);

		$('#nama_tunjangan').val(nama_tunjangan);
		$('#jml').val(jml);
		$('#ket').val(ket);		

	}

</script>