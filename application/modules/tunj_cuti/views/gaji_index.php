<div class="card card-body">
	<div class="row">
		<div class="col-sm-12 col-md-12 text-md-right">
			<a href="<?php echo site_url() . '/tunj_cuti/Cetak_Gaji_Semua/' . $this->session->filter_unit . '/' . $tahun; ?>" target="_blank" class="btn btn-primary pull-right"><i class="fa fa-print"></i> Cetak Slip</a>
			<form method="get">
				<table>
					<tr>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Unit : </td>
						<td>
							<select name="skpd" class="form-control">
								<option value="">-- Pilih Unit Kerja --</option>
								<?php
								foreach ($satkerja as $sat) { ?>
									<option value="<?= $sat->id ?>" <?= $this->session->filter_unit == $sat->id ? 'selected' : '' ?>><?= $sat->nama ?></option>
								<?php }
								?>
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
									if ($tahun == $x) {
								?>
										<option value="<?= $x ?>" selected><?= $x ?></option>
									<?php
									} else {
									?>
										<option value="<?= $x ?>"><?= $x ?></option>
								<?php }
								} ?>
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
						<th>UMK MLG (50%)</th>
						<th>Cuti diambil</th>
						<th>Total Tunjangan</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php
					$total = 0;
					foreach ($dt as $rs) { ?>
						<tr>
							<td><?= $rs->nip ?></td>
							<td><?= $rs->namaPegawai ?></td>
							<td><?= $rs->jabatan ?></td>
							<td>Rp.<?= number_format($rs->umk, 2, ",", ".") ?></td>
							<td><?= number_format($rs->jml_cuti, 0, ",", ".") ?> hari</td>
							<td>Rp.<?php //hitung total 
									$total = $total + $rs->jml;
									echo number_format($rs->jml, 2, ",", ".");
									?></td>
							<td>
								<a href="#" data-toggle="modal" data-target="#modalEdit<?= $rs->id ?>" class="btn btn-xs btn-warning" title="Edit Gaji"><i class="fa fa-pencil "></i></a> |
								<a href="<?php echo site_url() . '/tunj_cuti/Cetak_Gaji_Satuan/' . $rs->id; ?>" target="_blank" class="btn btn-xs btn-info" title="cetak slipgaji"><i class="fa fa-print "></i></a> |
								<a href="<?= site_url('tunj_cuti/hitung_ulang/' . $rs->nip . "/$tahun") ?>" class="btn btn-xs btn-success" title="Hitung Ulang"><i class="fa fa-gear "></i> hitung Ulang</a>
							</td>
						</tr>
					<?php } ?>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td>Total</td>
						<td>Rp.<?php //hitung total 
								echo number_format($total, 2, ",", ".");
								?></td>
						<td></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

</div>

<?php
foreach ($dt as $rs) {
?>
	<!-- modal form untuk input data -->
	<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal label" aria-hidden="true" id="modalEdit<?= $rs->id ?>" data-backdrop="static">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="modalTitle_shift">Edit Tunjangan Cuti</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form action="<?= site_url('tunj_cuti/Simpan') ?>" method="post">
					<input type="hidden" name="id" value="<?= $rs->id ?>">
					<div class="modal-body">
						<div class="form-group row">
							<div class="col-md-4">
								Nama
							</div>
							<div class="col-md-8">
								<?= $rs->namaPegawai ?>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-4">
								Jabatan
							</div>
							<div class="col-md-8">
								<?= $rs->jabatan ?>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-4">
								UMK (Rp.)
							</div>
							<div class="col-md-8">
								<input type="number" name="umk" class="form-control" value="<?= $rs->umk ?>">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-4">
								Jml Cuti (Hari)
							</div>
							<div class="col-md-8">
								<input type="number" name="jml_cuti" class="form-control" value="<?= $rs->jml_cuti ?>">
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
<?php
}
?>