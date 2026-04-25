<?php $bln = $this->session->userdata('filter_bulan');
$thn = $this->session->userdata('filter_tahun');

function cari_isi($jad, $t)
{
	$isi = "...";
	if (count($jad) > 0) {
		if ($jad[0]['t'.$t] == 'lbr') {
			$isi = "<i class='fa fa-soccer-ball-o' style='color:red'></i>";
		} else {
			if ( $jad[0]['t'.$t] != "") {
				$isi = "<b>" . $jad[0]['t'.$t] . "</>";
			}
		}
	}
	return $isi;
}
?>
<div class="card card-body">
	<div class="row">
		<div class="col-md-12">
			<?php if ($this->session->flashdata('errMsg')) { ?>
				<div class="alert alert-success">
					<button type="button" class="close" data-dismiss="alert">x</button>
					<i class="fa fa-check-square" aria-hidden="true">&nbsp;</i>
					<?= $this->session->flashdata('errMsg'); ?>
				</div>
			<?php } elseif ($this->session->flashdata('errMsg2')) { ?>
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<button type="button" class="close" data-dismiss="alert">x</button>
					<i class="fa fa-exclamation-triangle" aria-hidden="true">&nbsp;</i>
					<?= $this->session->flashdata('errMsg2'); ?>
				</div>
			<?php } ?>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12 col-md-12 text-md-right">
			<form action="<?= site_url('jadwal_shift') ?>" method="post">
				<table>
					<tr>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Unit : </td>
						<td>
							<select name="skpd" class="form-control">
								<option value="0" <?= $this->session->filter_unit == 0 ? 'selected' : '' ?>>-- Pilih Unit Kerja --</option>
								<?php
								foreach ($satkerja as $sat) { ?>
									<option value="<?= $sat->id ?>" <?= $this->session->filter_unit == $sat->id ? 'selected' : '' ?>><?= $sat->nama ?></option>
								<?php }
								?>
							</select>
						</td>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Jabatan : </td>
						<td>
							<select name="jabatan" class="form-control">
								<option value="0" <?= $this->session->filter_jabatan == 0 ? 'selected' : '' ?>>-- Pilih Unit jabatan --</option>
								<?php
								foreach ($jabatan as $j) { ?>
									<option value="<?= $j->idJabatan ?>" <?= $this->session->filter_jabatan == $j->idJabatan ? 'selected' : '' ?>><?= $j->namaJabatan ?></option>
								<?php }
								?>
							</select>
						</td>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bulan :</td>
						<td>
							<select name="bulan" class="form-control" id="bulan">
								<option value="01" <?= $this->session->userdata('filter_bulan') == '01' ? ' selected ' : '' ?>>Januari</option>
								<option value="02" <?= $this->session->userdata('filter_bulan') == '02' ? ' selected ' : '' ?>>Februari</option>
								<option value="03" <?= $this->session->userdata('filter_bulan') == '03' ? ' selected ' : '' ?>>Maret</option>
								<option value="04" <?= $this->session->userdata('filter_bulan') == '04' ? ' selected ' : '' ?>>April</option>
								<option value="05" <?= $this->session->userdata('filter_bulan') == '05' ? ' selected ' : '' ?>>Mei</option>
								<option value="06" <?= $this->session->userdata('filter_bulan') == '06' ? ' selected ' : '' ?>>Juni</option>
								<option value="07" <?= $this->session->userdata('filter_bulan') == '07' ? ' selected ' : '' ?>>Juli</option>
								<option value="08" <?= $this->session->userdata('filter_bulan') == '08' ? ' selected ' : '' ?>>Agustus</option>
								<option value="09" <?= $this->session->userdata('filter_bulan') == '09' ? ' selected ' : '' ?>>September</option>
								<option value="10" <?= $this->session->userdata('filter_bulan') == '10' ? ' selected ' : '' ?>>Oktober</option>
								<option value="11" <?= $this->session->userdata('filter_bulan') == '11' ? ' selected ' : '' ?>>November</option>
								<option value="12" <?= $this->session->userdata('filter_bulan') == '12' ? ' selected ' : '' ?>>Desember</option>
							</select>
						</td>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tahun :</td>
						<td>
							<select name="tahun" class="form-control" id="tahun">
								<?php
								$cth = date('Y');
								if (date('m')==12) {
									$cth = date('Y')+1;									
								}
								for ($x = $cth; $x >= 2023; $x--) {
								?>
									<option value="<?= $x ?>" <?= $this->session->userdata('filter_tahun') == $x ? ' selected ' : '' ?>><?= $x ?></option>
								<?php } ?>
							</select>
						</td>
						<td>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button class="btn btn-primary" type="submit" nama="ok"><i class="fa fa-search"></i> Filter</button>
						</td>
						<td>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" class="btn btn-success" data-toggle="modal" data-target="#modalImportShift"><i class="fa fa-file-excel-o"></i> Import Excel</a>
						</td>
					</tr>
				</table>
			</form>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-md-12">
			<table class="table table-xs table-striped table-responsive" id="example1">
				<thead>
					<tr>
						<th rowspan="2"></th>
						<th rowspan="2">Nama Pegawai<br><br></th>
						<th colspan="31" style="text-align:center">Tanggal</th>
					</tr>
					<tr>
						<th>21</th>
						<th>22</th>
						<th>23</th>
						<th>24</th>
						<th>25</th>
						<th>26</th>
						<th>27</th>
						<th>28</th>
						<?php if ($bln == '03' && ($thn % 4 == 0)) { ?>
							<th>29</th>
						<?php }
						if ($bln != '03') { ?>
							<th>29</th>
							<th>30</th>
							<?php if ($bln == '01' || $bln == '02' || $bln == '02' || $bln == '04' || $bln == '06' || $bln == '08' || $bln == '09' || $bln == '11' ) { ?>
								<th>31</th>
						<?php }
						} ?>
						<th>1</th>
						<th>2</th>
						<th>3</th>
						<th>4</th>
						<th>5</th>
						<th>6</th>
						<th>7</th>
						<th>8</th>
						<th>9</th>
						<th>10</th>
						<th>11</th>
						<th>12</th>
						<th>13</th>
						<th>14</th>
						<th>15</th>
						<th>16</th>
						<th>17</th>
						<th>18</th>
						<th>19</th>
						<th>20</th>		
					</tr>
				</thead>
				<tbody>
					<?php 
						$no=1;
						$total = count($dt);
						foreach ($dt as $rs) { ?>
						<tr>
							<td>
								<?php if ($no != 1) { ?><a href="<?= site_url('jadwal_shift/urut/') . $rs->nipBaru . "/" . $no . "/up/" . $dt[$no-2]->nipBaru  ?>" ><i class="fa fa-arrow-up"></i></a><?php } ?> 
								<?php if ($no != $total) { ?><a href="<?= site_url('jadwal_shift/urut/') . $rs->nipBaru . "/" . $no . "/down/" . $dt[$no]->nipBaru ?>"><i class="fa fa-arrow-down"></i></a> <?php } ?> 
							</td>
							<td><?= $rs->namaPegawai ?>
								<?php
								//$jadwal = $this->jadwal_model->get_kehadiran($rs->idelektronik, $bln, $thn)->result();
								$jadwal = $this->jadwal_model->get_plot($rs->nipBaru,$bln,$thn)->result_array();
								?>
							</td>
							
							<td><a href="#" class="btn btn-default btn-xs" data-toggle="modal" data-target="#pilihshift" onclick="SetObj('<?= $rs->idelektronik . '_21' ?>','<?= $rs->nipBaru ?>')">
									<div id="<?= $rs->idelektronik . '_21' ?>"><?= cari_isi($jadwal, '21') ?></div>
								</a></td>
							<td><a href="#" class="btn btn-default btn-xs" data-toggle="modal" data-target="#pilihshift" onclick="SetObj('<?= $rs->idelektronik . '_22' ?>','<?= $rs->nipBaru ?>')">
									<div id="<?= $rs->idelektronik . '_22' ?>"><?= cari_isi($jadwal, '22') ?></div>
								</a></td>
							<td><a href="#" class="btn btn-default btn-xs" data-toggle="modal" data-target="#pilihshift" onclick="SetObj('<?= $rs->idelektronik . '_23' ?>','<?= $rs->nipBaru ?>')">
									<div id="<?= $rs->idelektronik . '_23' ?>"><?= cari_isi($jadwal, '23') ?></div>
								</a></td>
							<td><a href="#" class="btn btn-default btn-xs" data-toggle="modal" data-target="#pilihshift" onclick="SetObj('<?= $rs->idelektronik . '_24' ?>','<?= $rs->nipBaru ?>')">
									<div id="<?= $rs->idelektronik . '_24' ?>"><?= cari_isi($jadwal, '24') ?></div>
								</a></td>
							<td><a href="#" class="btn btn-default btn-xs" data-toggle="modal" data-target="#pilihshift" onclick="SetObj('<?= $rs->idelektronik . '_25' ?>','<?= $rs->nipBaru ?>')">
									<div id="<?= $rs->idelektronik . '_25' ?>"><?= cari_isi($jadwal, '25') ?></div>
								</a></td>
							<td><a href="#" class="btn btn-default btn-xs" data-toggle="modal" data-target="#pilihshift" onclick="SetObj('<?= $rs->idelektronik . '_26' ?>','<?= $rs->nipBaru ?>')">
									<div id="<?= $rs->idelektronik . '_26' ?>"><?= cari_isi($jadwal, '26') ?></div>
								</a></td>
							<td><a href="#" class="btn btn-default btn-xs" data-toggle="modal" data-target="#pilihshift" onclick="SetObj('<?= $rs->idelektronik . '_27' ?>','<?= $rs->nipBaru ?>')">
									<div id="<?= $rs->idelektronik . '_27' ?>"><?= cari_isi($jadwal, '27') ?></div>
								</a></td>
							<td><a href="#" class="btn btn-default btn-xs" data-toggle="modal" data-target="#pilihshift" onclick="SetObj('<?= $rs->idelektronik . '_28' ?>','<?= $rs->nipBaru ?>')">
									<div id="<?= $rs->idelektronik . '_28' ?>"><?= cari_isi($jadwal, '28') ?></div>
								</a></td>
							<?php if ($bln == '03' && ($thn % 4 == 0)) { ?>
								<td><a href="#" class="btn btn-default btn-xs" data-toggle="modal" data-target="#pilihshift" onclick="SetObj('<?= $rs->idelektronik . '_29' ?>','<?= $rs->nipBaru ?>')">
										<div id="<?= $rs->idelektronik . '_29' ?>"><?= cari_isi($jadwal, '29') ?></div>
									</a></td>
							<?php }
							if ($bln != '03') { ?>
								<td><a href="#" class="btn btn-default btn-xs" data-toggle="modal" data-target="#pilihshift" onclick="SetObj('<?= $rs->idelektronik . '_29' ?>','<?= $rs->nipBaru ?>')">
										<div id="<?= $rs->idelektronik . '_29' ?>"><?= cari_isi($jadwal, '29') ?></div>
									</a></td>
								<td><a href="#" class="btn btn-default btn-xs" data-toggle="modal" data-target="#pilihshift" onclick="SetObj('<?= $rs->idelektronik . '_30' ?>','<?= $rs->nipBaru ?>')">
										<div id="<?= $rs->idelektronik . '_30' ?>"><?= cari_isi($jadwal, '30') ?></div>
									</a></td>
								<?php if ($bln == '01' || $bln == '02' || $bln == '04' || $bln == '06' || $bln == '08' || $bln == '09' || $bln == '11') { ?>
									<td><a href="#" class="btn btn-default btn-xs" data-toggle="modal" data-target="#pilihshift" onclick="SetObj('<?= $rs->idelektronik . '_31' ?>','<?= $rs->nipBaru ?>')">
											<div id="<?= $rs->idelektronik . '_31' ?>"><?= cari_isi($jadwal, '31') ?></div>
										</a></td>
							<?php }
							} ?>
							<td>
								<a href="#" class="btn btn-default btn-xs" data-toggle="modal" data-target="#pilihshift" onclick="SetObj('<?= $rs->idelektronik . '_01' ?>','<?= $rs->nipBaru ?>')">
									<div id="<?= $rs->idelektronik . '_01' ?>"><?= cari_isi($jadwal, '01') ?></div>
								</a>
							</td>
							<td>
								<a href="#" class="btn btn-default btn-xs" data-toggle="modal" data-target="#pilihshift" onclick="SetObj('<?= $rs->idelektronik . '_02' ?>','<?= $rs->nipBaru ?>')">
									<div id="<?= $rs->idelektronik . '_02' ?>"><?= cari_isi($jadwal, '02') ?></div>
								</a>
							</td>
							<td><a href="#" class="btn btn-default btn-xs" data-toggle="modal" data-target="#pilihshift" onclick="SetObj('<?= $rs->idelektronik . '_03' ?>','<?= $rs->nipBaru ?>')">
									<div id="<?= $rs->idelektronik . '_03' ?>"><?= cari_isi($jadwal, '03') ?></div>
								</a></td>
							<td><a href="#" class="btn btn-default btn-xs" data-toggle="modal" data-target="#pilihshift" onclick="SetObj('<?= $rs->idelektronik . '_04' ?>','<?= $rs->nipBaru ?>')">
									<div id="<?= $rs->idelektronik . '_04' ?>"><?= cari_isi($jadwal, '04') ?></div>
								</a></td>
							<td><a href="#" class="btn btn-default btn-xs" data-toggle="modal" data-target="#pilihshift" onclick="SetObj('<?= $rs->idelektronik . '_05' ?>','<?= $rs->nipBaru ?>')">
									<div id="<?= $rs->idelektronik . '_05' ?>"><?= cari_isi($jadwal, '05') ?></div>
								</a></td>
							<td><a href="#" class="btn btn-default btn-xs" data-toggle="modal" data-target="#pilihshift" onclick="SetObj('<?= $rs->idelektronik . '_06' ?>','<?= $rs->nipBaru ?>')">
									<div id="<?= $rs->idelektronik . '_06' ?>"><?= cari_isi($jadwal, '06') ?></div>
								</a></td>
							<td><a href="#" class="btn btn-default btn-xs" data-toggle="modal" data-target="#pilihshift" onclick="SetObj('<?= $rs->idelektronik . '_07' ?>','<?= $rs->nipBaru ?>')">
									<div id="<?= $rs->idelektronik . '_07' ?>"><?= cari_isi($jadwal, '07') ?></div>
								</a></td>
							<td><a href="#" class="btn btn-default btn-xs" data-toggle="modal" data-target="#pilihshift" onclick="SetObj('<?= $rs->idelektronik . '_08' ?>','<?= $rs->nipBaru ?>')">
									<div id="<?= $rs->idelektronik . '_08' ?>"><?= cari_isi($jadwal, '08') ?></div>
								</a></td>
							<td><a href="#" class="btn btn-default btn-xs" data-toggle="modal" data-target="#pilihshift" onclick="SetObj('<?= $rs->idelektronik . '_09' ?>','<?= $rs->nipBaru ?>')">
									<div id="<?= $rs->idelektronik . '_09' ?>"><?= cari_isi($jadwal, '09') ?></div>
								</a></td>
							<td><a href="#" class="btn btn-default btn-xs" data-toggle="modal" data-target="#pilihshift" onclick="SetObj('<?= $rs->idelektronik . '_10' ?>','<?= $rs->nipBaru ?>')">
									<div id="<?= $rs->idelektronik . '_10' ?>"><?= cari_isi($jadwal, '10') ?></div>
								</a></td>
							<td><a href="#" class="btn btn-default btn-xs" data-toggle="modal" data-target="#pilihshift" onclick="SetObj('<?= $rs->idelektronik . '_11' ?>','<?= $rs->nipBaru ?>')">
									<div id="<?= $rs->idelektronik . '_11' ?>"><?= cari_isi($jadwal, '11') ?></div>
								</a></td>
							<td><a href="#" class="btn btn-default btn-xs" data-toggle="modal" data-target="#pilihshift" onclick="SetObj('<?= $rs->idelektronik . '_12' ?>','<?= $rs->nipBaru ?>')">
									<div id="<?= $rs->idelektronik . '_12' ?>"><?= cari_isi($jadwal, '12') ?></div>
								</a></td>
							<td><a href="#" class="btn btn-default btn-xs" data-toggle="modal" data-target="#pilihshift" onclick="SetObj('<?= $rs->idelektronik . '_13' ?>','<?= $rs->nipBaru ?>')">
									<div id="<?= $rs->idelektronik . '_13' ?>"><?= cari_isi($jadwal, '13') ?></div>
								</a></td>
							<td><a href="#" class="btn btn-default btn-xs" data-toggle="modal" data-target="#pilihshift" onclick="SetObj('<?= $rs->idelektronik . '_14' ?>','<?= $rs->nipBaru ?>')">
									<div id="<?= $rs->idelektronik . '_14' ?>"><?= cari_isi($jadwal, '14') ?></div>
								</a></td>
							<td><a href="#" class="btn btn-default btn-xs" data-toggle="modal" data-target="#pilihshift" onclick="SetObj('<?= $rs->idelektronik . '_15' ?>','<?= $rs->nipBaru ?>')">
									<div id="<?= $rs->idelektronik . '_15' ?>"><?= cari_isi($jadwal, '15') ?></div>
								</a></td>
							<td><a href="#" class="btn btn-default btn-xs" data-toggle="modal" data-target="#pilihshift" onclick="SetObj('<?= $rs->idelektronik . '_16' ?>','<?= $rs->nipBaru ?>')">
									<div id="<?= $rs->idelektronik . '_16' ?>"><?= cari_isi($jadwal, '16') ?></div>
								</a></td>
							<td><a href="#" class="btn btn-default btn-xs" data-toggle="modal" data-target="#pilihshift" onclick="SetObj('<?= $rs->idelektronik . '_17' ?>','<?= $rs->nipBaru ?>')">
									<div id="<?= $rs->idelektronik . '_17' ?>"><?= cari_isi($jadwal, '17') ?></div>
								</a></td>
							<td><a href="#" class="btn btn-default btn-xs" data-toggle="modal" data-target="#pilihshift" onclick="SetObj('<?= $rs->idelektronik . '_18' ?>','<?= $rs->nipBaru ?>')">
									<div id="<?= $rs->idelektronik . '_18' ?>"><?= cari_isi($jadwal, '18') ?></div>
								</a></td>
							<td><a href="#" class="btn btn-default btn-xs" data-toggle="modal" data-target="#pilihshift" onclick="SetObj('<?= $rs->idelektronik . '_19' ?>','<?= $rs->nipBaru ?>')">
									<div id="<?= $rs->idelektronik . '_19' ?>"><?= cari_isi($jadwal, '19') ?></div>
								</a></td>
							<td><a href="#" class="btn btn-default btn-xs" data-toggle="modal" data-target="#pilihshift" onclick="SetObj('<?= $rs->idelektronik . '_20' ?>','<?= $rs->nipBaru ?>')">
									<div id="<?= $rs->idelektronik . '_20' ?>"><?= cari_isi($jadwal, '20') ?></div>
								</a></td>
						</tr>
					<?php  $no++; } ?>
				</tbody>
			</table>
		</div>
	</div>

</div>

<!-- modal form untuk import data -->
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal label" aria-hidden="true" id="modalImportShift" data-backdrop="static">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Import Jadwal Shift Excel</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= site_url('jadwal_shift/import_excel') ?>" method="post" enctype="multipart/form-data">
				<div class="modal-body">
					<div class="alert alert-info">
						Format file: kolom A = NIP, kolom B = Nama Pegawai, lalu kolom tanggal. Isi sel tanggal dengan kode shift (sesuai master shift), atau LIBUR/LBR/OFF.
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label">Unit Kerja</label>
						<div class="col-md-9">
							<select name="skpd" class="form-control" required>
								<option value="0">-- Pilih Unit Kerja --</option>
								<?php foreach ($satkerja as $sat) { ?>
									<option value="<?= $sat->id ?>" <?= $this->session->filter_unit == $sat->id ? 'selected' : '' ?>><?= $sat->nama ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label">Jabatan</label>
						<div class="col-md-9">
							<select name="jabatan" class="form-control" required>
								<option value="0">-- Pilih Jabatan --</option>
								<?php foreach ($jabatan as $j) { ?>
									<option value="<?= $j->idJabatan ?>" <?= $this->session->filter_jabatan == $j->idJabatan ? 'selected' : '' ?>><?= $j->namaJabatan ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label">Bulan</label>
						<div class="col-md-4">
							<select name="bulan" class="form-control" required>
								<option value="01" <?= $this->session->userdata('filter_bulan') == '01' ? ' selected ' : '' ?>>Januari</option>
								<option value="02" <?= $this->session->userdata('filter_bulan') == '02' ? ' selected ' : '' ?>>Februari</option>
								<option value="03" <?= $this->session->userdata('filter_bulan') == '03' ? ' selected ' : '' ?>>Maret</option>
								<option value="04" <?= $this->session->userdata('filter_bulan') == '04' ? ' selected ' : '' ?>>April</option>
								<option value="05" <?= $this->session->userdata('filter_bulan') == '05' ? ' selected ' : '' ?>>Mei</option>
								<option value="06" <?= $this->session->userdata('filter_bulan') == '06' ? ' selected ' : '' ?>>Juni</option>
								<option value="07" <?= $this->session->userdata('filter_bulan') == '07' ? ' selected ' : '' ?>>Juli</option>
								<option value="08" <?= $this->session->userdata('filter_bulan') == '08' ? ' selected ' : '' ?>>Agustus</option>
								<option value="09" <?= $this->session->userdata('filter_bulan') == '09' ? ' selected ' : '' ?>>September</option>
								<option value="10" <?= $this->session->userdata('filter_bulan') == '10' ? ' selected ' : '' ?>>Oktober</option>
								<option value="11" <?= $this->session->userdata('filter_bulan') == '11' ? ' selected ' : '' ?>>November</option>
								<option value="12" <?= $this->session->userdata('filter_bulan') == '12' ? ' selected ' : '' ?>>Desember</option>
							</select>
						</div>
						<div class="col-md-3">
							<select name="tahun" class="form-control" required>
								<?php
								$cth = date('Y');
								if (date('m') == 12) {
									$cth = date('Y') + 1;
								}
								for ($x = $cth; $x >= 2023; $x--) {
								?>
									<option value="<?= $x ?>" <?= $this->session->userdata('filter_tahun') == $x ? ' selected ' : '' ?>><?= $x ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label">File Excel</label>
						<div class="col-md-9">
							<input type="file" name="file" class="form-control" accept=".xls,.xlsx">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success btn-sm" formaction="<?= site_url('jadwal_shift/template_excel') ?>" formtarget="_blank" formnovalidate><span class="fa fa-download"></span> Download Template</button>
					<button type="submit" class="btn btn-primary btn-sm" formaction="<?= site_url('jadwal_shift/import_excel') ?>"><span class="fa fa-upload"></span> Upload</button>
					<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><span class="fa fa-times"></span> Close</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- modal form untuk input data -->
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal label" aria-hidden="true" id="pilihshift" data-backdrop="static">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalTitle_shift">Pilih Shift</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="" method="post">
				<input type="hidden" name="id" id="id">
				<div class="modal-body">
					<div class="form-group">
						<div class="row">
							<div class="col-md-3">Nama Shift</div>
							<div class="col-md-4">
								<input type="hidden" name="idobj" id="idobj">
								<input type="hidden" name="idnip" id="idnip">
								<select class="form-control" name="shift" id="shift">
									<option value="">Libur</option>
									<?php foreach ($shift  as $s) { ?>
										<option value="<?= $s->id ?>"><?= $s->nama_shift ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary btn-sm" data-dismiss="modal" onclick="SetValue()"><span class="fa fa-check"></span> Simpan</button>
					<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><span class="fa fa-times"></span> Close</button>
				</div>
			</form>
		</div>
	</div>
</div>



<script>
	function SetObj(id,nip) {
		$('#idobj').val(id);
		$('#idnip').val(nip);
	}

	function SetValue() {

		const nama = document.getElementById('idobj').value;
		const nip = document.getElementById('idnip').value;
		const x = document.getElementById(nama);
		x.innerHTML = "<img src='../loading.gif' width='12px'>";
		const shift = document.getElementById('shift').value;
		const bulan = document.getElementById('bulan').value;
		const tahun = document.getElementById('tahun').value;
		$.ajax({
			url: "<?= site_url('jadwal_shift/SetShift') ?>",
			type: 'POST',
			dataType: 'json',
			data: {
				id: nama,
				kode: shift,
				bulan: bulan,
				tahun: tahun,
				nip : nip,
			},
			success: function(res) {
				//memasukkan data shift ke dalam form
				if (res.kode == 'LIBUR') {
					x.innerHTML = "<i class='fa fa-soccer-ball-o' style='color:red;'></>";
				} else {
					x.innerHTML = "<b>" + res.kode + "</b>"
				};
			}
		});

	}
</script>