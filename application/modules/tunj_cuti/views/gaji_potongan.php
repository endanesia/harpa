<div class="card card-body">
	<div class="row">
		<div class="col-md-12">
            <?php 
				if ($this->session->flashdata('errMsg')) 
				{ 
					?>
                    <div class="alert alert-success">
						<button type="button" class="close" data-dismiss="alert">x</button>
                        <i class="fa fa-check-square" aria-hidden="true">&nbsp;</i>
<?= $this->session->flashdata('errMsg'); ?>
                    </div>
                <?php 
				}
				elseif($this->session->flashdata('errMsg2'))
				{
				?>
				 <div class="alert alert-danger">
				 	<button type="button" class="close" data-dismiss="alert">x</button>
					 <i class="fa fa-exclamation-triangle" aria-hidden="true">&nbsp;</i>
<?= $this->session->flashdata('errMsg2'); ?>
                </div>
				<?php
				}
			?>
        </div>	
		<div class="col-sm-12 col-md-12 text-md-right">
		<a href="" class="btn btn-primary pull-right" ><i class="fa fa-plus"></i> Tambah Data</a>
		<span class="pull-right"> &nbsp;&nbsp;</span> 
		<a href="" class="btn btn-success pull-right" data-toggle="modal" data-target="#UploadData"><i class="fa fa-file-excel-o"></i> Upload Potongan Gaji</a>
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
							<option>-- Pilih Potongan --</option>
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
						<th>Nama Potongan</th>
						<th>Nilai</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>1234567</td>
						<td>Nanang</td>
						<td>Koperasi</td>
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
<!-- modal form untuk upload data -->
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal label" aria-hidden="true" id="UploadData" data-backdrop="static">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalTitle_shift">Upload Rekap Potongan Gaji </h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= site_url('Gaji/excel_potongan') ?>" method="post" enctype="multipart/form-data">
				<div class="modal-body">
					<div class="row">
						<div class="col-6">
							<div class="form-group">
								<label for="ajukan_cuti">Bulan</label>
								<select name="bulan" class="form-control">
									<?php
									if ($bulan == "01") {
									?>
										<option value="01" selected="selected">Januari</option>
									<?php
									} else {
									?>
										<option value="01">Januari</option>
									<?php
									}
									?>
									<?php
									if ($bulan == "02") {
									?>
										<option value="02" selected="selected">Februari</option>
									<?php
									} else {
									?>
										<option value="02">Februari</option>
									<?php
									}
									?>
									<?php
									if ($bulan == "03") {
									?>
										<option value="03" selected="selected">Maret</option>
									<?php
									} else {
									?>
										<option value="03">Maret</option>
									<?php
									}
									?>
									<?php
									if ($bulan == "04") {
									?>
										<option value="04" selected="selected">April</option>
									<?php
									} else {
									?>
										<option value="04">April</option>
									<?php
									}
									?>
									<?php
									if ($bulan == "05") {
									?>
										<option value="05" selected="selected">Mei</option>
									<?php
									} else {
									?>
										<option value="05">Mei</option>
									<?php
									}
									?>
									<?php
									if ($bulan == "06") {
									?>
										<option value="06" selected="selected">Juni</option>
									<?php
									} else {
									?>
										<option value="06">Juni</option>
									<?php
									}
									?>
									<?php
									if ($bulan == "07") {
									?>
										<option value="07" selected="selected">Juli</option>
									<?php
									} else {
									?>
										<option value="07">Juli</option>
									<?php
									}
									?>
									<?php
									if ($bulan == "08") {
									?>
										<option value="08" selected="selected">Agustus</option>
									<?php
									} else {
									?>
										<option value="08">Agustus</option>
									<?php
									}
									?>
									<?php
									if ($bulan == "09") {
									?>
										<option value="09" selected="selected">September</option>
									<?php
									} else {
									?>
										<option value="09">September</option>
									<?php
									}
									?>
									<?php
									if ($bulan == "10") {
									?>
										<option value="10" selected="selected">Oktober</option>
									<?php
									} else {
									?>
										<option value="10">Oktober</option>
									<?php
									}
									?>
									<?php
									if ($bulan == "11") {
									?>
										<option value="11" selected="selected">November</option>
									<?php
									} else {
									?>
										<option value="11">November</option>
									<?php
									}
									?>
									<?php
									if ($bulan == "12") {
									?>
										<option value="12" selected="selected">Desember</option>
									<?php
									} else {
									?>
										<option value="12">Desember</option>
									<?php
									}
									?>
								</select>
							</div>
						</div>
						<div class="col-6">
							<div class="form-group">
								<label for="hari_cuti">Tahun</label>
								<select name="tahun" class="form-control">
								<?php
								$cth = date('Y');
								for ($x = $cth; $x >= 2023; $x--) {
									if ($tahun) {
								?>
										<option value="<?= $x ?>" selected="selected"><?= $x ?></option>
									<?php
									} else {
									?>
										<option value="<?= $x ?>"><?= $x ?></option>
								<?php
									}
								}
								?>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-12">
							<div class="form-group">
								<label for="jenis_potongan">Jenis Potongan</label>
								<input type="text" name="jenis_potongan" id="jenis_potongan" class="form-control">
							</div>
						</div>
					</div>
					<div class="row">
						<label for="file">File</label>
						<div class="col-md-12">
							<input type="file" name="file" class="form-control-file" required>
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
<!---------------Akhir Modal Upload data------------->
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