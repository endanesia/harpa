<div class="card card-body">
	<div class="row">
		<div class="col-md-12">
			<?php if ($this->session->flashdata('errMsg')) {
				echo "<div class='alert alert-warning'>" . $this->session->flashdata('errMsg') . "</div>";
			} ?>
		</div>
	</div>
	<h3>HASIL IMPORT DATA</h3>
	<p style="color:red"><b>Data dibawah ini adalah hasil pembacaan file excel</b></p>
	<hr>
	<div class="row">
		<div class="col-md-12">
			<div class="text-right mb-3">
		<?php
			switch ($kembali) 
			{
				case "potongan":
		?>
				<a href="<?= site_url('gaji/potongan') ?>" class="btn btn-secondary">Kembali</a>
		<?php
				break;
				case "tunjangan":
		?>
				<a href="<?= site_url('gaji/tunjangan') ?>" class="btn btn-secondary">Kembali</a>
		<?php
				break;
				default:
		}
  		?>
			</div>
			<table class="table  table-striped" >
				<thead>
					<tr>
						<th>NIP</th>
						<th>Nama Pegawai</th>
						<th>Unit</th>
						<th>Jml</th>
						<th>Keterangan</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
					<?php $total = 0;
					foreach ($dt as $rs) {
						if (is_numeric($rs['jml'])) {
							$total = $total + $rs['jml'];
						} ?>
						<tr <?= $rs['status'] == 'Gagal' ? "style='background-color:orange;'" : "" ?> >
							<td><?= $rs['nip'] ?></td>
							<td><?= $rs['nama'] ?></td>
							<td><?= $rs['unit'] ?></td> <!-- Asumsi bahwa ada field unit pada data $rs -->
							<td align="right">Rp.<?= is_numeric($rs['jml']) ? number_format($rs['jml'], 0, ',', '.') : $rs['jml'] ?> </td>
							<td><?= $rs['ket'] ?></td>
							<td><?= $rs['status'] ?></td> <!-- Asumsi bahwa ada field status pada data $rs -->
						</tr>
					<?php } ?>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td> Total : </td>
						<td align="right">Rp.<?= number_format($total, 0, ',', '.') ?> </td>
						<td></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

</div>
