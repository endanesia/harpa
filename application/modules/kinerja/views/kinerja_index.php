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
				 <div class="alert alert-danger alert-dismissible fade show" role="alert">
				 		<button type="button" class="close" data-dismiss="alert">x</button>
						 <i class="fa fa-exclamation-triangle" aria-hidden="true">&nbsp;</i>
<?= $this->session->flashdata('errMsg2'); ?>
                </div>
				<?php
				}
			?>
        </div>
		<div class="col-sm-12 col-md-12 text-md-right">
			<a href="" class="btn btn-primary pull-right" data-toggle="modal" data-target="#modalNew"><i class="fa fa-file-excel-o"></i> Upload rekap Kinerja</a>
			<form method="post">
				<table>
					<tr>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Unit : </td>
						<td>
							<select name="skpd" class="form-control">
								<option>-- Pilih Unit Kerja --</option>
								<?php
								foreach ($satkerja as $sat) { ?>
									<option value="<?= $sat->id ?>" <?= $this->session->filter_unit == $sat->id ? 'selected' : '' ?>><?= $sat->nama ?></option>
								<?php }
								?>
							</select>
						</td>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bulan :</td>
						<td>
							<select name="bulan" class="form-control">
								<option value="1" <?= $bulan == '1' ? ' selected ' : '' ?>>Januari</option>
								<option value="2" <?= $bulan == '2' ? ' selected ' : '' ?>>Februari</option>
								<option value="3" <?= $bulan == '3' ? ' selected ' : '' ?>>Maret</option>
								<option value="4" <?= $bulan == '4' ? ' selected ' : '' ?>>April</option>
								<option value="5" <?= $bulan == '5' ? ' selected ' : '' ?>>Mei</option>
								<option value="6" <?= $bulan == '6' ? ' selected ' : '' ?>>Juni</option>
								<option value="7" <?= $bulan == '7' ? ' selected ' : '' ?>>Juli</option>
								<option value="8" <?= $bulan == '8' ? ' selected ' : '' ?>>Agustus</option>
								<option value="9" <?= $bulan == '9' ? ' selected ' : '' ?>>September</option>
								<option value="10" <?= $bulan == '10' ? ' selected ' : '' ?>>Oktober</option>
								<option value="11" <?= $bulan == '11' ? ' selected ' : '' ?>>November</option>
								<option value="12" <?= $bulan == '12' ? ' selected ' : '' ?>>Desember</option>
							</select>
						</td>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tahun :</td>
						<td>
							<select name="tahun" class="form-control">
								<?php
								$cth = date('Y');
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
			</form>
		</div>

	</div>
	<hr>
	<div class="row">
		<div class="col-md-12">

			<table class="table table-sm table-striped" id="example1">
				<thead>
					<tr>
						<th>NIP</th>
						<th>Pegawai</th>
						<th>Skor Kinerja</th>
						<th>Skor Kehadiran</th>
						<th>Maks Apresiasi</th>
						<th>Nilai Apresiasi</th>
						<td></td>
					</tr>
				</thead>
				<tbody>
					<?php $totalBayar = 0;
					foreach ($dt as $rs) {
						$ds = $this->kinerja_model->select($bulan, $tahun, $rs->nipBaru)->row();
						if (isset($ds->id)) {
							$id = $ds->id;
							$totalBayar = $totalBayar + $ds->jmlTunjangan;
						} else {
							$id = 0;
						}

					?>
						<tr>
							<td><?= $rs->nipBaru ?></td>
							<td><?= $rs->namaPegawai ?></td>
							<td><?= isset($ds->skorKinerja) ? $ds->skorKinerja : '' ?></td>
							<td><?= isset($ds->skorKehadiran) ? $ds->skorKehadiran : '' ?></td>
							<td><?= isset($ds->tarifMax) ? number_format($ds->tarifMax) : '' ?></td>
							<td><?= isset($ds->jmlTunjangan) ? number_format($ds->jmlTunjangan) : '' ?></td>
							<td>
								<a href="" class="btn btn-xs btn-warning" title="Edit" data-toggle="modal" data-target="#modalEdit" onclick="GetData('<?= $id ?>','<?= $bulan ?>','<?= $tahun ?>','<?= $rs->nipBaru ?>')"><i class="fa fa-pencil "></i></a>
								<?php
								if($id==0)
								{
								?>
									<a href="#" class="btn btn-xs btn-secondary"  role="button" aria-disabled="true" title="Cetak"><i class="fa fa-print "></i></a>
								<?php
								}
								else
								{
								?>
									<a href="<?php echo site_url(). '/Kinerja/Cetak_Satuan/' . $id; ?>" target="_blank" class="btn btn-xs btn-info" title="Cetak"><i class="fa fa-print "></i></a>
								<?php
								}
								?>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
			<h3>Total : Rp. <?= number_format($totalBayar) ?></h3>
		</div>
	</div>

</div>

<!-- modal form untuk upload data -->
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal label" aria-hidden="true" id="modalNew" data-backdrop="static">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalTitle_shift">Upload Rekap Excel Periode </h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= site_url('kinerja/Excel') ?>" method="post" enctype="multipart/form-data">
				<div class="modal-body">
					<div class="form-group">
						<div class="row form-grpup">
							<div class="col-md-3 " align="right">Bulan</div>
							<div class="col-md-3">
								<select name="bulan" class="form-control">
									<option value="1" <?= $bulan == '1' ? ' selected ' : '' ?>>Januari</option>
									<option value="2" <?= $bulan == '2' ? ' selected ' : '' ?>>Februari</option>
									<option value="3" <?= $bulan == '3' ? ' selected ' : '' ?>>Maret</option>
									<option value="4" <?= $bulan == '4' ? ' selected ' : '' ?>>April</option>
									<option value="5" <?= $bulan == '5' ? ' selected ' : '' ?>>Mei</option>
									<option value="6" <?= $bulan == '6' ? ' selected ' : '' ?>>Juni</option>
									<option value="7" <?= $bulan == '7' ? ' selected ' : '' ?>>Juli</option>
									<option value="8" <?= $bulan == '8' ? ' selected ' : '' ?>>Agustus</option>
									<option value="9" <?= $bulan == '9' ? ' selected ' : '' ?>>September</option>
									<option value="10" <?= $bulan == '10' ? ' selected ' : '' ?>>Oktober</option>
									<option value="11" <?= $bulan == '11' ? ' selected ' : '' ?>>November</option>
									<option value="12" <?= $bulan == '12' ? ' selected ' : '' ?>>Desember</option>
								</select>
							</div>
							<div class="col-md-3" align="right">
								Tahun
							</div>
							<div class="col-md-3">
								<select name="tahun" class="form-control">
									<?php
									$cth = date('Y');
									for ($x = $cth; $x >= 2023; $x--) {
									?>
										<option value="<?= $x ?>"><?= $x ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 form-group">
								<input type="hidden" name="uploadBulan">
								<input type="hidden" name="uploadTahun">
								<input type="hidden" name="id" id="idUpload">
							</div>
							<div class="col-md-3" align="right">Browse File : </div>
							<div class="col-md-3">
								<input type="file" name="file" accept=".xls,.xlsx" required>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6" align="right">
				
							</div>
							<div class="col-md-6" align="right">
								<a href="<?= base_url('template_kinerja_karyawan.xlsx') ?>"><small>(Download sample template excel)</small></a>
							</div>
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
<!-- modal form untuk input data -->
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal label" aria-hidden="true" id="modalEdit" data-backdrop="static">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalTitle_shift">Input Kinerja Pegawai </h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= site_url('kinerja/Simpan') ?>" method="post">
				<div class="modal-body">
					<div class="form-group">
						<div class="row">
							<div class="col-md-12 form-group">
								<input type="hidden" name="id" id="id">
								<input type="hidden" name="nip" id="nip">
								<input type="hidden" name="bulan" id="bulan">
								<input type="hidden" name="tahun" id="tahun">
							</div>
							<b><u>Kinerja Pegawai</u></b>
						</div>
						<div class="row form-group">
							<div class="col-md-6">Mutu & Volume Karya</div>
							<div class="col-md-6">
								<input type="number" name="kat1" id="kat1" class="form-control">
							</div>
						</div>
						<div class="row form-group">
							<div class="col-md-6">Prakarsa & Penguasaan Tugas</div>
							<div class="col-md-6">
								<input type="number" name="kat2" id="kat2" class="form-control">
							</div>
						</div>
						<div class="row form-group">
							<div class="col-md-6">Sikap,Perilaku & Hub antar rekan</div>
							<div class="col-md-6">
								<input type="number" name="kat3" id="kat3" class="form-control">
							</div>
						</div>
						<div class="row form-group">
							<div class="col-md-6">Disiplin waktu</div>
							<div class="col-md-6">
								<input type="number" name="kat4" id="kat4" class="form-control">
							</div>
						</div>
						<div class="row form-group">
							<div class="col-md-6">Loyalitas</div>
							<div class="col-md-6">
								<input type="number" name="kat5" id="kat5" class="form-control">
							</div>
						</div>
						<div class="row">
							<b><u>Kehadiran Pegawai</u></b>
						</div>
						<div class="row form-group">
							<div class="col-md-6">Jml Hari Kerja</div>
							<div class="col-md-6">
								<input type="number" name="jmlHari" id="jmlHari" class="form-control">
							</div>
						</div>
						<div class="row form-group">
							<div class="col-md-6">Jml Kehadiran</div>
							<div class="col-md-6">
								<input type="number" name="jmlKehadiran" id="jmlKehadiran" class="form-control">
							</div>
						</div>
						<div class="row">
							<b><u>Prosentase</u></b>
						</div>
						<div class="row form-group">
							<div class="col-md-6">Prosentase Jumlah Hari Kerja</div>
							<div class="col-md-6">
								<input type="number" name="skorKehadiran" id="skorKehadiran" class="form-control">
							</div>
						</div>
						<div class="row form-group">
							<div class="col-md-6">Prosentase Penilaian Kinerja</div>
							<div class="col-md-6">
								<input type="number" name="skorKinerja" id="skorKinerja" class="form-control">
							</div>
						</div>
						<div class="row">
							<b><u>Nilai Apresiasi Kontribusi</u></b>
						</div>
						<div class="row form-group">
							<div class="col-md-6">Jml Maksimal (Rp)</div>
							<div class="col-md-6">
								<input type="number" name="tarifMax" id="tarifMax" class="form-control">
							</div>
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
	function GetData(id, bulan, tahun, nip) {
		if (id != 0) {
			$.ajax({
				url: "<?= site_url('kinerja/GetData') ?>",
				type: 'POST',
				dataType: 'json',
				data: {
					id: id
				},
				success: function(data) {
					//memasukkan data shift ke dalam form
					$('#id').val(data.id);
					$('#nip').val(data.nip);
					$('#bulan').val(data.bulan);
					$('#tahun').val(data.tahun);
					$('#jmlKehadiran').val(data.jmlKehadiran);
					$('#jmlHari').val(data.jmlHari);
					$('#tarifMax').val(data.tarifMax);
					$('#kat1').val(data.kat1);
					$('#kat2').val(data.kat2);
					$('#kat3').val(data.kat3);
					$('#kat4').val(data.kat4);
					$('#kat5').val(data.kat5);
					$('#skorKinerja').val(data.skorKinerja);
					$('#skorKehadiran').val(data.skorKehadiran);
				}
			});
		} else {
			$('#id').val(0);
			$('#nip').val(nip);
			$('#bulan').val(bulan);
			$('#tahun').val(tahun);
			$('#jmlKehadiran').val('0');
			$('#jmlHari').val('0');
			$('#tarifMax').val('0');
			$('#kat1').val('0');
			$('#kat2').val('0');
			$('#kat3').val('0');
			$('#kat4').val('0');
			$('#kat5').val('0');
			$('#skorKinerja').val('0');
			$('#skorKehadiran').val('0');
		}
	}
</script>
<script>
  window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
      $(this).remove(); 
    });
  }, 3000);
</script>