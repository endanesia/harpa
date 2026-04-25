<?php
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="datapegawai.xlsx"');
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
?>


<div class="card card-body">
	<div class="row">
		<div class="col-md-12">
			<table border="1">
				<thead>
					<tr>
						<th>NIP</th>
						<th>NIK</th>
						<th>NAMA PEGAWAI</th>
						<th>JENIS KELAMIN</th>
						<th>AGAMA</th>
						<th>TEMPAT LAHIR</th>
						<th>TGL LAHIR</th>
						<th>ALAMAT</th>
						<th>TELEPON</th>
						<th>EMAIL</th>
						<th>STATUS PERNIKAHAN</th>
						<th>JABATAN</th>
						<th>KELAS JABATAN</th>
						<th>UNIT</th>
						<th>JENIS PEGAWAI</th>
						<th>NAMA BANK</th>
						<th>NOMOR REK</th>
						<th>AN REK</th>
						<th>NOMOR NPWP</th>
						<th>NO BPJS KESEHATAN</th>
						<th>NO BPJS TENAGA KERJA</th>
						<th>STATUS TUNJANGAN</th>
						<th>GAJI POKOK</th>
						<th>TUNJANGAN TETAP</th>
						<th>TANGGAL BERGABUNG</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($dt as $pegawai) { ?>
						<tr>
							<td><?= $pegawai->nipBaru ?></td>
							<td><?= "'" . $pegawai->NIK ?></td>
							<td><?= $pegawai->namaPegawai ?></td>
							<td><?= $pegawai->jenisKelamin ?></td>
							<td><?= $pegawai->agama ?></td>
							<td><?= $pegawai->tempatLahir ?></td>
							<td><?= $pegawai->tanggalLahir ?></td>
							<td><?= $pegawai->alamat ?></td>
							<td><?= "'" . $pegawai->telepon ?></td>
							<td><?= $pegawai->email ?></td>
							<td><?= $pegawai->statusPernikahan ?></td>
							<td><?= $pegawai->jabatan ?></td>
							<td><?= $pegawai->kelasJabatan ?></td>
							<td><?= $pegawai->namaUnit ?></td>
							<td><?= $pegawai->status_pegawai ?></td>
							<td><?= $pegawai->nama_bank ?></td>
							<td><?= $pegawai->norek ?></td>
							<td><?= $pegawai->an_rek ?></td>
							<td><?= $pegawai->nomorNPWP ?></td>
							<td><?= "'" . $pegawai->bpjs_kesehatan ?></td>
							<td><?= "'" . $pegawai->bpjs_tenagakerja ?></td>
							<td><?= $pegawai->status_pegawai ?></td>
							<td><?= $pegawai->gaji ?></td>
							<td><?= $pegawai->tunjanganTetap ?></td>
							<td><?= $pegawai->tglBergabung ?></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>