<div class="card card-body">
	<div class="row">
		<div class="col-sm-12 col-md-12 text-md-right">
			<div class="col-sm-12 col-md-12 text-md-right">
				 <a href="<?php echo site_url() . '/lembur/Cetak_lembur_semua'; ?>" target="_blank" class="btn btn-info">
					<i class="fa fa-print"> Cetak Slip Lembur</i>
				</a>
				<!-- download excel -->
				<div class="btn-group">
					<button type="button" class="btn btn-success"><i class="fa fa-file-excel-o"></i> Download Excel</button>
					<button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
						<span class="sr-only">Toggle Dropdown</span>
					</button>
					<div class="dropdown-menu" role="menu">
						<a class="dropdown-item" href="#" data-toggle="modal" data-target="#DownloadExcelRincian">Rincian</a>
						<a class="dropdown-item" href="#" data-toggle="modal" data-target="#DownloadExcelTerima">Tanda Terima</a>
					</div>
				</div>
			</div>
			<form action="<?php echo site_url() . '/lembur/Validasi' ?>" method="post">
				<table>
					<tr>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Unit : </td>
						<td>
							<select name="skpd" class="form-control">
								<option>-- Pilih Unit Kerja --</option>
								<option value="0">-- Semua Unit Kerja --</option>
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
							<th>No WO</th>
							<th>Uraian</th>
							<th>Tanggal</th>
							<th>Waktu</th>
							<th>Hari</th>
							<th>Beban Anggaran</th>
							<th>Pemberi Tugas</th>
							<th>Pemeriksa</th>
							<th>Asman</th>
							<th>Status</th>
							<td width="150px"></td>
						</tr>
					</thead>
					<tbody>
						<?php
							foreach($dt as $lembur)
							{	
						?>
						<tr>
							<td><?php echo $lembur->noWo;?></td>
							<td><?php echo $lembur->uraian;?></td>
							<td><?php echo date("d-m-Y", strtotime($lembur->tglLembur));?></td>
							<td><?php echo $lembur->mulai.' s/d '.$lembur->sampai;?></td>
							<td><?php echo $lembur->statusHari;?></td>
							<td><?php echo $lembur->bebanAnggaran;?></td>
							<td><?php echo $lembur->namaPemberiTugas;?></td>
							<td><?php echo $lembur->namaPemeriksa;?></td>
							<td><?php echo $lembur->namaAsman;?></td>
							<td>
							<?php
								if($lembur->status==1)
								{
									echo "Valid<br><small>".date_format(date_create($lembur->tgl_validasi), 'd-m-Y')."</small>";
								}
								else
								{
									echo "Tidak Valid";
								}
								?>	
							</td>
							<td>
								<a href="" data-toggle="modal" data-target="#modalDetail<?php echo $lembur->id; ?>" class="btn btn-xs btn-info" title="Detail"><i class="fa fa-search "></i></a> | 
								<a href="<?php echo site_url().'/lembur/Update_valid/'.$lembur->id;?>" class="btn btn-xs btn-warning" title="Valid" ><i class="fa fa-check "></i> Valid</a> 
								<a href="<?php echo site_url().'/lembur/Update_invalid/'.$lembur->id;?>" class="btn btn-xs btn-danger" title="Tdk Valid" ><i class="fa fa-times"></i> Tdk Valid</a>
								<!-- modal form untuk Detail Cuti -->
								<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal label" aria-hidden="true" id="modalDetail<?php echo $lembur->id; ?>" data-backdrop="static">
									<div class="modal-dialog modal-lg">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="modalTitle_shift">Detail Lembur</h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<form>
												<h4 style="margin-left: 20px;margin-bottom:20px;">BIODATA KARYAWAN LEMBUR</h4>
												<table class="table table-primary table-striped" style="width:90%;margin-left:20px;">
													<thead>
														<tr>
															<th>No</th>
															<th>NIP</th>
															<th>Nama Pegawai</th>
															<th>Nilai</th>
															<th>Uang Makan</th>
															<th></th>
														</tr>
													</thead>
													<tbody>
														<?php
															$list_lembur=$this->Lembur_model->detail_lembur_id($lembur->id)->result();
															$no=1;
															foreach($list_lembur as $personil){
															$plembur=$this->Lembur_model->pegawai_id($personil->idtbPegawai)->row();
														?>
															<tr>
																<td><?php echo $no++;?></td>
																<td><?php echo $plembur->nipBaru;?></td>
																<td><?php echo $plembur->namaPegawai;?></td>
																<td style="text-align:right;"><span id="nilai-<?= $personil->id ?>"><?= number_format($personil->nilai, 0, ",", "."); ?></span></td>
																<td style="text-align:right;"><span id="uangmakan-<?= $personil->id ?>"><?= number_format($personil->uangMakan, 0, ",", "."); ?></span></td>
																<td>
																	<button type="button" class="btn btn-xs btn-secondary btn-refresh-lembur" data-id="<?= $personil->id ?>" title="Refresh">
																		<i class="fa fa-refresh"></i> Refresh
																	</button>
																</td>
															</tr>
														<?php
															}
														?>
													</tbody>
												</table>
												<div class="modal-footer">
												</div>
											</form>
										</div>
									</div>
								</div>
							</td>
						</tr>
						<?php
						}
						?>
					</tbody>
				</table>
			</form>
		</div>
	</div>
</div>

<!-- Modal Download Excel Rincian -->
<div class="modal fade" id="DownloadExcelRincian" tabindex="-1" role="dialog" aria-labelledby="modalDownloadExcelLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalDownloadExcelLabel">Download Excel Rincian Lembur</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?php echo site_url('lembur/download_excel_rincian') ?>" method="get" target="_blank">
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

<!-- Modal Download Excel Terima -->
<div class="modal fade" id="DownloadExcelTerima" tabindex="-1" role="dialog" aria-labelledby="modalDownloadExcelLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalDownloadExcelLabel">Download Excel Tanda Terima Lembur</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?php echo site_url('lembur/download_excel_terima') ?>" method="get" target="_blank">
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
	$(document).on('click', '.btn-refresh-lembur', function (e) {
		e.preventDefault();
		var id = $(this).data('id');
		var $btn = $(this);
		$btn.prop('disabled', true);
		$.ajax({
			url: "<?= site_url('lembur/Refresh_pegawai_lembur_ajax') ?>",
			type: 'POST',
			dataType: 'json',
			data: { id: id },
			success: function (res) {
				if (res && res.success) {
					$('#nilai-' + id).text(res.nilai_formatted);
					$('#uangmakan-' + id).text(res.uangMakan_formatted);
				} else {
					alert(res && res.message ? res.message : 'Gagal menghitung ulang');
				}
			},
			error: function () {
				alert('Terjadi kesalahan pada server');
			},
			complete: function () {
				$btn.prop('disabled', false);
			}
		});
	});
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
