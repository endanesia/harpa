<div class="card card-body">
	<div class="col-md-8 mx-auto">
		<form action="<?= site_url('laporan/pilih') ?>" method="post" target="_blank">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="modalTitle_shift">Pilih Laporan</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="bulan">Bulan</label>
							<select name="bulan" class="form-control">
							<?php
							$bulan_arr = array(
								'01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
								'05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
								'09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
							);
							foreach ($bulan_arr as $key => $value) {
								$selected = ($this->session->filter_bulan == $key) ? 'selected="selected"' : '';
								echo '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
							}
							?>
							</select>
					</div>
					<div class="form-group">
						<label for="ajukan_cuti">Tahun</label>
							<select name="tahun" class="form-control">
								<?php
								$cth = date('Y');
								if (date('m')==12) {
									$cth = date('Y')+1;									
								}
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
					</div>
					<div class="form-group">
						<label for="laporan">Laporan</label>
							<select name="laporan" class="form-control">
								<option value="A">Laporan Penggajian Per Jabatan</option>
								<option value="B">Laporan Penggajian Per Unit</option>
								<option value="C">Laporan Pengajuan Gaji</option>
								<option value="D">Laporan Pembayaran TKK Per Jabatan</option>
								<option value="E">Laporan Rekap TKK Per Unit</option>
								<option value="F">Laporan Rekapitulasi Gaji Keseluruhan</option>
								<option value="G">Laporan Gaji Minus</option>
								<option value="H">Laporan Rekap Tunjangan</option>
								<option value="I">Laporan Rekap Potongan</option>
							</select>	
					</div>
					<div class="modal-footer">
						<div class="mx-auto">
							<button type="submit" class="btn btn-primary btn-sm"><span class="fa fa-check"></span> Pilih</button>
							<a class="btn btn-danger btn-sm" href="<?php echo site_url(); ?>" data-dismiss="modal"><span class="fa fa-times"></span> Batal</a>
						</div>
					</div>		
				</div>
			</div>
		</form>		
	</class=>
</div>