<div class="card card-body">
	<div class="row">
		<div class="col-sm-12 col-md-12 text-md-right">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="modalTitle_kelasjabatan">Proses Hitung Gaji</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					
						
						<div class="modal-body">
							
							<b style="text-align:left">Proses berlangsung, dan jangan tutup halaman ini sampai proses selesai</b>
							 <br>
							 <img src="<?= base_url() ?>loading.gif" height="24px" id="icon1">
						</div>
						<div class="modal-footer">

							<button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><span class="fa fa-times"></span> Batal</button>
						</div>
					
				</div>
			</div>
		</div>
	</div>
	<hr>
</div>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal label" aria-hidden="true" id="modalProses" data-backdrop="static">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalTitle_kelasjabatan">Proses Hitung Gaji</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= site_url('kelasjabatan/Hapus') ?>" method="post">
				<input type="hidden" name="idhapus" id="idhapus">
				<div class="modal-body">
					<b>Proses berlangsung, dan jangan tutup halaman ini sampai proses selesai</b>
					<img src="<?= base_url() ?>loading.gif" height="24px" id="icon1">
				</div>
				<div class="modal-footer">

					<button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><span class="fa fa-times"></span> Batal</button>
				</div>
			</form>
		</div>
	</div>
</div>


<script src="<?php echo base_url(); ?>themes/<?php echo $this->config->item('theme'); ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script>
	setTimeout(function() {
		window.location.href = "<?= site_url('gaji/hitung_gaji/') . $satkerja . "/" . $page ?>"; // URL tujuan pengalihan
	}, 10000); // 10 detik (dalam milidetik)
	$(document).ready(function() {
		$('#modalProses').modal('show');
	});
</script>