<div class="card card-body">
	<div class="row">
		<div class="col-sm-12 col-md-12 text-md-right">
			<form action="<?php echo site_url() . '/cuti/validasi' ?>" method="post">
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
									<?php
									if ($this->session->filter_bulan == "01") {
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
									if ($this->session->filter_bulan == "02") {
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
									if ($this->session->filter_bulan == "03") {
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
									if ($this->session->filter_bulan == "04") {
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
									if ($this->session->filter_bulan == "05") {
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
									if ($this->session->filter_bulan == "06") {
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
									if ($this->session->filter_bulan == "07") {
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
									if ($this->session->filter_bulan == "08") {
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
									if ($this->session->filter_bulan == "09") {
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
									if ($this->session->filter_bulan == "10") {
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
									if ($this->session->filter_bulan == "11") {
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
									if ($this->session->filter_bulan == "12") {
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
						</td>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tahun :</td>
						<td>
						<select name="tahun" class="form-control">
									<?php
									$cth = date('Y');
									for ($x = $cth; $x >= 2023; $x--) {
										if ($this->session->filter_tahun == $x) {
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
						<th>Nama Pegawai</th>
						<th>Tgl Pengajuan</th>
						<th>Nomor</th>
						<th>Jml Hari</th>
						<th>Tgl Cuti</th>
						<th>Alasan</th>
						<th>Status</th>
						<td></td>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach($dt as $validasi)
					{
					?>
						<?php
							$dtpeg = $this->Cuti_model->pegawai_id($validasi->idPegawai)->row();
							$dtjab = $this->Cuti_model->jabatan_id($dtpeg->idJabatan)->row();
							$dtunit = $this->Cuti_model->unit_kerja_id($dtpeg->skpd)->row();
						?>
						<tr>
							<td><?php echo $dtpeg->nipBaru;?></td>
							<td><?php echo $dtpeg->namaPegawai; ?></td>
							<td><?php echo date("d-m-Y", strtotime($validasi->tgl)); ?></td>
							<td><?php echo $validasi->nomor;?></td>
							<td><?php echo $validasi->jmlHari;?></td>
							<td><?php echo date("d-m-Y", strtotime($validasi->tglMulai)) . ' s/d ' . date("d-m-Y", strtotime($validasi->tglSampai)); ?></td>
							<td><?php echo $validasi->keperluan; ?></td>
							<td>
								<?php
								if($validasi->status==1)
								{
									echo "Valid";
									echo "<br><small>" . date("d-m-Y", strtotime($validasi->tgl_validasi)) . "</small>";
								}
								else
								{
									echo "Tidak Valid";
								}
								?>
							</td>
							<td>
								<a href="" data-toggle="modal" data-target="#modalDetail<?php echo $validasi->id; ?>" class="btn btn-xs btn-info" title="Detail Data"><i class="fa fa-search "></i></a> | 
								<a href="<?php echo site_url().'/cuti/Valid_cuti/'.$validasi->id;?>" class="btn btn-xs btn-warning" title="valid"><i class="fa fa-check"></i> Valid</a> 
								<a href="<?php echo site_url().'/cuti/Invalid_cuti/'.$validasi->id;?>" class="btn btn-xs btn-danger" title="tidak valid"><i class="fa fa-times"></i> Belum Valid</a>
							</td>
							<!-- modal form untuk Detail Cuti -->
						<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal label" aria-hidden="true" id="modalDetail<?php echo $validasi->id; ?>" data-backdrop="static">
							<div class="modal-dialog modal-lg">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="modalTitle_shift">Detail Cuti</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<form>
										<h4 style="margin-left: 20px;margin-bottom:20px;">BIODATA KARYAWAN</h4>
										<div class="row">
											<div class="col-md-2 ms-12">
												<div style="margin-left: 20px;margin-bottom:5px;">Nama </div>
											</div>
											<div class="col-md-4 ms-12">
												<div>:<?php echo' '.$dtpeg->namaPegawai;?> </div>
											</div>
											<div class="col-md-2 ms-12">
												<div style="margin-left: 20px;margin-bottom:5px;">Jabatan </div>
											</div>
											<div class="col-md-4 ms-12">
												<div>:<?php echo' '.$dtjab->namaJabatan;?> </div>
											</div>
										</div> 
										<div class="row">
											<div class="col-md-2 ms-12">
												<div style="margin-left: 20px;margin-bottom:5px;">NIP </div>
											</div>
											<div class="col-md-4 ms-12">
												<div>:<?php echo' '.$dtpeg->nipBaru;?> </div>
											</div>
											<div class="col-md-2 ms-12">
												<div style="margin-left: 20px;margin-bottom:5px;">Unit </div>
											</div>
											<div class="col-md-4 ms-12">
												<div>:<?php echo' '.$dtunit->nama;?> </div>
											</div>
										</div> 
										
										<hr style="border: 1px solid;" width="95%">
										
										<h4 style="margin-left: 20px;margin-bottom:20px;">DETAIL CUTI</h4>
										<div class="row">
											<div class="col-md-4 ms-12">
												<div style="margin-left: 20px;margin-bottom:5px;">Nomor Cuti </div>
											</div>
											<div class="col-md-8 ms-12">
												<div>:<?php echo' '.$validasi->nomor;?> </div>
											</div>
										</div>    
										<div class="row">
											<div class="col-md-4 ms-12">
												<div style="margin-left: 20px;margin-bottom:5px;">Tanggal Pengajuan </div>
											</div>
											<div class="col-md-8 ms-12">
												<div>:<?php echo' '.date("d F Y", strtotime($validasi->tgl));?> </div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-4 ms-12">
												<div style="margin-left: 20px;margin-bottom:5px;">Tanggal Cuti yang diajukan</div>
											</div>
											<div class="col-md-8 ms-12">
												<div>:<?php echo' '.date("d F Y", strtotime($validasi->tglMulai)).' s/d '.date("d F Y", strtotime($validasi->tglSampai));?> </div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-4 ms-12">
												<div style="margin-left: 20px;margin-bottom:5px;">Jumlah Hari Cuti </div>
											</div>
											<div class="col-md-8 ms-12">
												<div>:<?php echo' '.$validasi->jmlHari;?> </div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-4 ms-12">
												<div style="margin-left: 20px;margin-bottom:5px;">Alasan Cuti </div>
											</div>
											<div class="col-md-8 ms-12">
												<div>:<?php echo' '.$validasi->keperluan;?> </div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-4 ms-12">
												<div style="margin-left: 20px;margin-bottom:5px;">Telepon Cuti </div>
											</div>
											<div class="col-md-8 ms-12">
												<div>:<?php echo' '.$validasi->tlp;?> </div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-4 ms-12">
												<div style="margin-left: 20px;margin-bottom:5px;">Alamat Cuti </div>
											</div>
											<div class="col-md-8 ms-12">
												<div>:<?php echo' '.$validasi->alamatCuti;?> </div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-4 ms-12">
												<div style="margin-left: 20px;margin-bottom:5px;">Sisa Cuti </div>
											</div>
											<div class="col-md-8 ms-12">
												<div>:<?php echo' '.$validasi->sisa_cuti;?> </div>
											</div>
										</div>                   
										<div class="modal-footer">
										<a class="btn btn-danger btn-sm" href="<?php echo site_url() . '/validasi'; ?>" data-dismiss="modal"><span class="fa fa-times"></span> Tutup</a>
										</div>
									</form>
								</div>
							</div>
						</div>
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>

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