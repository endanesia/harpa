<div class="card card-body">
<div class="row">
		<div class="col-sm-12 col-md-12 text-md-right">
		&nbsp;&nbsp;<a href="" class="btn btn-primary pull-right" data-toggle="modal" data-target="#modalNew"><i class="fa fa-plus"></i> Tambah SPGJ</a>&nbsp;&nbsp;
		&nbsp;&nbsp;<a href="#" class="btn btn-success pull-right mr-2" data-toggle="modal" data-target="#modalDownloadExcel"><i class="fa fa-file-excel-o"></i> Download Excel</a>&nbsp;&nbsp;
			
			<form action="<?php echo site_url() . '/ganti_jaga/validasi' ?>" method="post">
				<table>
					<tr>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Unit : </td>
						<td>
							<select name="skpd" class="form-control">
								<option value="">-- Semua Unit Kerja --</option>
								<?php
								foreach ($satkerja as $sat) { ?>
									<?php
									if ($this->session->filter_unit == $sat->id) {
									?>
										<option value="<?= $sat->id ?>" selected="selected"><?= $sat->nama ?></option>
									<?php
									} else {
									?>
										<option value="<?= $sat->id ?>"><?= $sat->nama ?></option>
								<?php
									}
								}
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
						<th>No WO</th>
						<th>Uraian</th>
						<th>Tanggal</th>
						<th>Waktu</th>
						<th>Ket</th>
						<th>Pegawai Digantikan</th>
						<th>Pegawai Menggantikan</th>
						<th>Nilai Insentif</th>
						<th>Status</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				<?php	
					foreach($dt as $jaga)
					{
					?>
					<tr>
						<td><?php echo $jaga->noWo;?></td>
						<td><?php echo $jaga->uraian;?></td>
						<td><?php echo date("d-m-Y", strtotime($jaga->tglLembur));?></td>
						<td><?php echo $jaga->mulai.' s/d '.$jaga->sampai;?></td>
						<td><?php echo $jaga->alasan;?></td>
						<?php
						$peg_gantikan=$this->ganti_jaga_model->pegawai_id($jaga->idp_yg_diganti)->row();
						?>
						<td style="width:50px;"><?php echo $peg_gantikan->namaPegawai;?></td>
						<?php
						$peg_menggantikan=$this->ganti_jaga_model->pegawai_id($jaga->idp_yg_mengganti)->row();
						?>
						<td style="width:50px;"><?php echo $peg_menggantikan->namaPegawai;?></td>
							<td><?php echo number_format($jaga->tunjangan,0,',','.');?></td>
						<td>
						<?php

							if($jaga->status==1)
							{
								echo "Valid";
								echo "<br><small>" . date("d-m-Y", strtotime($jaga->tgl_validasi)) . "</small>";
							}
							else
							{
								echo "Tidak Valid";
							}
						?>			
						</td>
						<td>
							<a href="" data-toggle="modal" data-target="#modalDetail<?php echo $jaga->id; ?>" class="btn btn-xs btn-info" title="Detail"><i class="fa fa-search "></i></a> | 
							<a href="" class="btn btn-xs btn-warning" title="Edit Data" data-toggle="modal" data-target="#modalEdit<?php echo $jaga->id ?>"><i class="fa fa-pencil"></i></a> |
							<a href="<?php echo site_url() . '/ganti_jaga/EditValid/' . $jaga->id; ?>" class="btn btn-xs btn-warning" title="Valid" ><i class="fa fa-check "></i> Valid</a> 
							<a href="<?php echo site_url() . '/ganti_jaga/EditInvalid/' . $jaga->id; ?>" class="btn btn-xs btn-danger" title="Belum Valid" ><i class="fa fa-times"></i> Belum Valid</a>
							<!-- modal form untuk Detail Cuti -->
						<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal label" aria-hidden="true" id="modalDetail<?php echo $jaga->id; ?>" data-backdrop="static">
							<div class="modal-dialog modal-lg">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="modalTitle_shift">Detail Ganti Jaga</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<form>							
										<h4 style="margin-left: 20px;margin-bottom:20px;">Detail SPGJ</h4>
										<div class="row">
											<div class="col-md-4 ms-12">
												<div style="margin-left: 20px;margin-bottom:5px;">Nomor WO </div>
											</div>
											<div class="col-md-8 ms-12">
												<div>:<?php echo' '.$jaga->noWo;?> </div>
											</div>
										</div>    
										<div class="row">
											<div class="col-md-4 ms-12">
												<div style="margin-left: 20px;margin-bottom:5px;">Tanggal Jaga </div>
											</div>
											<div class="col-md-8 ms-12">
												<div>:<?php echo' '.date("d F Y", strtotime($jaga->tglLembur));?> </div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-4 ms-12">
												<div style="margin-left: 20px;margin-bottom:5px;">Waktu Jaga</div>
											</div>
											<div class="col-md-8 ms-12">
												<div>: <?php echo $jaga->mulai.' s/d '.$jaga->sampai;?></div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-4 ms-12">
												<div style="margin-left: 20px;margin-bottom:5px;">Status Hari Jaga  </div>
											</div>
											<div class="col-md-8 ms-12">
												<div>:<?php echo $jaga->statusHari;?> </div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-4 ms-12">
												<div style="margin-left: 20px;margin-bottom:5px;">Beban Anggaran </div>
											</div>
											<div class="col-md-8 ms-12">
												<div>:<?php echo' '.$jaga->bebanAnggaran;?> </div>
											</div>
										</div>
										<hr>
										<h4 style="margin-left: 20px;margin-bottom:20px;">Detail Personil Ganti Jaga</h4>
										<?php
											$peg_gantikan=$this->ganti_jaga_model->pegawai_id($jaga->idp_yg_diganti)->row();
										?>
										<div class="row">
											<div class="col-md-4 ms-12">
												<div style="margin-left: 20px;margin-bottom:5px;">NIP</div>
											</div>
											<div class="col-md-8 ms-12">
												<div>:<?php echo' '.$peg_gantikan->nipBaru;?> </div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-4 ms-12">
												<div style="margin-left: 20px;margin-bottom:5px;">Nama Pegawai</div>
											</div>
											<div class="col-md-8 ms-12">
												<div>:<?php echo' '.$peg_gantikan->namaPegawai;?> </div>
											</div>
										</div>
										<h5 style="margin-left: 20px;margin-bottom:20px;">Digantikan Oleh</h5>
										<?php
											$peg_menggantikan=$this->ganti_jaga_model->pegawai_id($jaga->idp_yg_mengganti)->row();
										?>
										<div class="row">
											<div class="col-md-4 ms-12">
												<div style="margin-left: 20px;margin-bottom:5px;">NIP</div>
											</div>
											<div class="col-md-8 ms-12">
												<div>:<?php echo' '.$peg_menggantikan->nipBaru;?> </div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-4 ms-12">
												<div style="margin-left: 20px;margin-bottom:5px;">Nama Pegawai</div>
											</div>
											<div class="col-md-8 ms-12">
												<div>:<?php echo' '.$peg_menggantikan->namaPegawai;?> </div>
											</div>
										</div>
										<hr>
										<h4 style="margin-left: 20px;margin-bottom:20px;">Detail Pemberi Tugas dan Pemeriksa</h4>
										<h5 style="margin-left: 20px;margin-bottom:20px;">Detail Pemberi Tugas</h5>
										<div class="row">
											<div class="col-md-4 ms-12">
												<div style="margin-left: 20px;margin-bottom:5px;">Tanggal Pemberi Tugas </div>
											</div>
											<div class="col-md-8 ms-12">
												<div>:<?php echo' '.date("d F Y", strtotime($jaga->tglPemberiTugas));?> </div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-4 ms-12">
												<div style="margin-left: 20px;margin-bottom:5px;">NID Pemberi Tugas </div>
											</div>
											<div class="col-md-8 ms-12">
												<div>:<?php echo $jaga->nidPemberiTugas;?> </div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-4 ms-12">
												<div style="margin-left: 20px;margin-bottom:5px;">Nama Pemberi Tugas </div>
											</div>
											<div class="col-md-8 ms-12">
												<div>:<?php echo $jaga->namaPemberiTugas;?> </div>
											</div>
										</div>
										<h5 style="margin-left: 20px;margin-bottom:20px;">Detail Pemeriksa Tugas</h5>
										<div class="row">
											<div class="col-md-4 ms-12">
												<div style="margin-left: 20px;margin-bottom:5px;">Tanggal Ppemeriksa Tugas </div>
											</div>
											<div class="col-md-8 ms-12">
												<div>:<?php echo' '.date("d F Y", strtotime($jaga->tglPemeriksa));?> </div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-4 ms-12">
												<div style="margin-left: 20px;margin-bottom:5px;">NID Pemeriksa Tugas </div>
											</div>
											<div class="col-md-8 ms-12">
												<div>:<?php echo $jaga->nidPemeriksa;?> </div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-4 ms-12">
												<div style="margin-left: 20px;margin-bottom:5px;">Nama Pemeriksa Tugas </div>
											</div>
											<div class="col-md-8 ms-12">
												<div>:<?php echo $jaga->namaPemeriksa;?> </div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-4 ms-12">
												<div style="margin-left: 20px;margin-bottom:5px;">Asman </div>
											</div>
											<div class="col-md-8 ms-12">
												<div>:<?php echo $jaga->namaAsman;?> </div>
											</div>
										</div>
										<div class="modal-footer">
										<a class="btn btn-danger btn-sm" href="<?php echo site_url() . '/validasi'; ?>" data-dismiss="modal"><span class="fa fa-times"></span> Tutup</a>
										</div>
									</form>
								</div>
							</div>
						</div>
						<!-- modal form untuk edit data -->
						<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal label" aria-hidden="true" id="modalEdit<?php echo $jaga->id ?>" data-backdrop="static">
							<div class="modal-dialog modal-lg">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="modalTitle_shift">Ubah SPGJ</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<form action="<?= site_url('ganti_jaga/Edit/v') ?>" method="post">
										<div class="modal-body">
											<div class="row">
												<div class="col-12">
													<div class="form-group">
														<input type="hidden" name="id_jaga" value="<?php echo $jaga->id; ?>" class="form-control" id="id_jaga">
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-5">
													<div class="form-group">
														<label for="tgl_wo">Tanggal</label>
														<input type="date" name="tgl_wo" value="<?php echo $jaga->tglLembur; ?>" class="form-control" id="tgl_wo">
													</div>
												</div>
												<div class="col-3">
													<div class="form-group">
														<label>Aktivitas</label>
														<select class="form-control" style="width: 100%;" name="aktivitas">
															<option value="" >Aktifitas</option>
															<option value="12" <?= $jaga->kodeAktifitas == '12' ? ' selected ' : '' ?>>Keamanan</option>
															<option value="18" <?= $jaga->kodeAktifitas == '18' ? ' selected ' : '' ?>>K3</option>
															<option value="19" <?= $jaga->kodeAktifitas == '19' ? ' selected ' : '' ?>>Lingkungan</option>
															<option value="20" <?= $jaga->kodeAktifitas == '20' ? ' selected ' : '' ?>>Preventive Maintenance</option>
															<option value="21"<?= $jaga->kodeAktifitas == '21' ? ' selected ' : '' ?>>Predictive Maintenance</option>
															<option value="22" <?= $jaga->kodeAktifitas == '22' ? ' selected ' : '' ?>>Corrective Maintenance</option>
															<option value="24" <?= $jaga->kodeAktifitas == '24' ? ' selected ' : '' ?>>Overhoul / Inspection</option>
															<option value="26" <?= $jaga->kodeAktifitas == '26' ? ' selected ' : '' ?>>Engineering / Project / Modifikasi</option>
															<option value="60" <?= $jaga->kodeAktifitas == '60' ? ' selected ' : '' ?>>Non Instalasi / Umum</option>
														</select>
													</div>
												</div>
												<div class="col-2">
													<div class="form-group">
														<label>Keterangan Hari</label>
														<select class="form-control" style="width: 100%;" name="hari">
															<?php if ($jaga->statusHari == "Kerja") { ?>
																<option value="Kerja" selected="selected">Kerja</option>
																<option value="Libur">Libur</option>
															<?php } else { ?>
																<option value="Kerja">Kerja</option>
																<option value="Libur" selected="selected">Libur</option>
															<?php } ?>
														</select>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-1">
													<div class="form-group">
														<label>Jam</label>
														<input type="text" name="jam_awal_lembur" value="<?php echo substr($jaga->mulai, 0, 2); ?>" class="form-control" id="jam_awal_lembur">
													</div>
												</div>
												<div class="col-1">
													<p style="text-align:center;margin-top:40px;">:</p>
												</div>
												<div class="col-1">
													<div class="form-group">
														<label>Menit</label>
														<input type="text" name="menit_awal_lembur" value="<?php echo substr($jaga->mulai, 3, 2); ?>" class="form-control" id="menit_awal_lembur">
													</div>
												</div>
												<div class="col-1">
													<p style="text-align:center;margin-top:40px;">s/d</p>
												</div>
												<div class="col-1">
													<div class="form-group">
														<label>Jam</label>
														<input type="text" name="jam_akhir_lembur" value="<?php echo substr($jaga->sampai, 0, 2); ?>" class="form-control" id="jam_akhir_lembur">
													</div>
												</div>
												<div class="col-1">
													<p style="text-align:center;margin-top:40px;">:</p>
												</div>
												<div class="col-1">
													<div class="form-group">
														<label>Menit</label>
														<input type="text" name="menit_akhir_lembur" value="<?php echo substr($jaga->sampai, 3, 2); ?>" class="form-control" id="menit_akhir_lembur">
													</div>
												</div>
												<div class="col-5">
													<div class="form-group">
														<label>Menggantikan Karena</label>
														<select class="form-control" style="width: 100%;" name="alasan">
															<option value="">-- Pilih Alasan --</option>
															<option value="Cuti" <?= $jaga->alasan == 'Cuti' ? ' selected ' : '' ?>>Cuti</option>
															<option value="Dispensasi" <?= $jaga->alasan == 'Sakit' ? ' selected ' : '' ?>>Sakit/Dispensasi</option>
															<option value="Kegiatan" <?= $jaga->alasan == 'Kegiatan' ? ' selected ' : '' ?>>Kegiatan PLN</option>
														</select>
													</div>
													<div class="form-group">
														<input type="hidden" name="beban_anggaran" value="<?php echo $jaga->bebanAnggaran; ?>" class="form-control" id="beban_anggaran">
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-12">
													<div class="form-group">
														<label for="uraian_lembur">Uraian</label>
														<textarea class="form-control" id="uraian_lembur" maxlength="200" name="uraian_lembur"><?php echo $jaga->uraian; ?></textarea>
													</div>
												</div>
											</div>
											<hr>
											<h5>Personal Pengganti</h5>
											<div class="row">
												<div class="col-6">
													<div class="form-group">
														<label>Nama Pegawai yang Digantikan</label>
														<select class="form-control" style="width: 100%;" name="pegawai_diganti">
															<?php
															if (!empty($this->session->filter_unit)) {
																$pegawai = $this->ganti_jaga_model->pegawai_unit($this->session->filter_unit)->result();
															}
															foreach ($pegawai as $dtp) {
																if ($dtp->idtbPegawai == $jaga->idp_yg_diganti) {
															?>
																	<option value="<?php echo $dtp->idtbPegawai; ?>" selected="selected"><?php echo $dtp->namaPegawai; ?></option>
																<?php } else { ?>
																	<option value="<?php echo $dtp->idtbPegawai; ?>"><?php echo $dtp->namaPegawai; ?></option>
															<?php }
															} ?>
														</select>
													</div>
												</div>
												<div class="col-6">
													<div class="form-group">
														<label>Nama Pegawai yang Menggantikan</label>
														<select class="form-control" style="width: 100%;" name="pegawai_mengganti">
															<?php
															if (!empty($this->session->filter_unit)) {
																$pegawai = $this->ganti_jaga_model->pegawai_unit($this->session->filter_unit)->result();
															}
															foreach ($pegawai as $dtp) {
																if ($dtp->idtbPegawai == $jaga->idp_yg_mengganti) {
															?>
																	<option value="<?php echo $dtp->idtbPegawai; ?>" selected="selected"><?php echo $dtp->namaPegawai; ?></option>
																<?php } else { ?>
																	<option value="<?php echo $dtp->idtbPegawai; ?>"><?php echo $dtp->namaPegawai; ?></option>
															<?php }
															} ?>
														</select>
													</div>
												</div>
											</div>
											<hr>
											<h5>Pemeriksa / Pemberi Tugas</h5>
											<div class="row">
												<div class="col-6">
													<label>Pemberi Tugas</label>
													<input type="text" name="nama_pt" value="<?php echo $jaga->namaPemberiTugas; ?>" class="form-control" id="nama_pt">
												</div>
												<div class="col-5">
													<label>Tanggal</label>
													<input type="date" name="tgl_pt" value="<?php echo $jaga->tglPemberiTugas; ?>" class="form-control" id="tgl_pt">
												</div>
												<div class="col-1">
													<input type="hidden" name="nid_pt" value="<?php echo $jaga->nidPemberiTugas; ?>" class="form-control" id="nid_pt">
												</div>
											</div>
											<div class="row">
												<div class="col-4">
													<label>NID</label>
													<input type="text" name="nid_periksa" value="<?php echo $jaga->nidPemeriksa; ?>" class="form-control" id="nid_periksa">
												</div>
												<div class="col-4">
													<label>Pemeriksa</label>
													<input type="text" name="nama_periksa" value="<?php echo $jaga->namaPemeriksa; ?>" class="form-control" id="nama_periksa">
												</div>
												<div class="col-4">
													<label>Tanggal</label>
													<input type="date" name="tgl_periksa" value="<?php echo $jaga->tglPemeriksa; ?>" class="form-control" id="tgl_periksa">
												</div>
											</div>
											<hr>
											<div class="row">
												<div class="col-6">
													<label>Asman</label>
													<input type="text" name="asman" value="<?php echo $jaga->namaAsman; ?>" class="form-control" id="nama_periksa">
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
						</td>
					<?php
					}
					?>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

</div>

<!-- Modal Download Excel -->
<div class="modal fade" id="modalDownloadExcel" tabindex="-1" role="dialog" aria-labelledby="modalDownloadExcelLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalDownloadExcelLabel">Download Excel Ganti Jaga</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?php echo site_url('ganti_jaga/download_excel') ?>" method="get">
        <div class="modal-body">
			<label>Pilih Bulan dan Tahun Validasi</label>
          <div class="form-group">
            <label for="bulan_excel">Bulan</label>
            <select class="form-control" id="bulan_excel" name="bulan" required>
              <option value="1">Januari</option>
              <option value="2">Februari</option>
              <option value="3">Maret</option>
              <option value="4">April</option>
              <option value="5">Mei</option>
              <option value="6">Juni</option>
              <option value="7">Juli</option>
              <option value="8">Agustus</option>
              <option value="9">September</option>
              <option value="10">Oktober</option>
              <option value="11">November</option>
              <option value="12">Desember</option>
            </select>
          </div>
          <div class="form-group">
            <label for="tahun_excel">Tahun</label>
            <input type="text" class="form-control" id="tahun_excel" name="tahun" value="<?php echo date('Y'); ?>" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-success">Download</button>
        </div>
      </form>
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

	$(document).ready(function() {
  // Override Download Excel button to show modal
  $("#btnDownloadExcel").click(function(e) {
    e.preventDefault();
    $('#modalDownloadExcel').modal('show');
  });
});
</script>