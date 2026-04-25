<?php
	$bulan = $this->session->filter_bulan;
	$tahun = $this->session->filter_tahun;
?>
<div class="card card-body">
	<div class="row">
		<div class="col-sm-12 col-md-12 text-md-right">
			<form action="<?= site_url('presensi') ?>" method="post">
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
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bulan :</td>
					<td>
						<select name="bulan" class="form-control">
							<option value="01" <?= $bulan == '01' ? ' selected ' : '' ?>>Januari</option>
							<option value="02" <?= $bulan == '02' ? ' selected ' : '' ?>>Februari</option>
							<option value="03" <?= $bulan == '03' ? ' selected ' : '' ?>>Maret</option>
							<option value="04" <?= $bulan == '04' ? ' selected ' : '' ?>>April</option>
							<option value="05" <?= $bulan == '05' ? ' selected ' : '' ?>>Mei</option>
							<option value="06" <?= $bulan == '06' ? ' selected ' : '' ?>>Juni</option>
							<option value="07" <?= $bulan == '07' ? ' selected ' : '' ?>>Juli</option>
							<option value="08" <?= $bulan == '08' ? ' selected ' : '' ?>>Agustus</option>
							<option value="09" <?= $bulan == '09' ? ' selected ' : '' ?>>September</option>
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
								<option value="<?= $x ?>" <?= $x == $tahun ? ' selected ' : '' ?>><?= $x ?></option>
							<?php } ?>
						</select>
					</td>
					<td>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Filter</button>
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
						<th>Nama Pegawai</th>
						<th>Hadir</th>
						<td>TK</td>
						<td>CUTI</td>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($dt as $rs) { ?>
					<tr>
						<td><?= $rs->nipBaru ?></td>
						<td><?= $rs->namaPegawai ?></td>
						<td><?php $hadir = $this->presensi_model->get_hadir($rs->idelektronik,$bulan,$tahun)->row(); echo $hadir->jml; ?></td>
						<td><?php $tk = $this->presensi_model->get_tk($rs->idelektronik,$bulan,$tahun)->row(); echo $tk->jml; ?></td>
						<td><?php $cuti = $this->presensi_model->get_cuti($rs->idtbPegawai,$bulan,$tahun)->row(); echo $cuti->jml; ?></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>

</div>




