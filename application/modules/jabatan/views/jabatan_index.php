<div class="card card-body">
	<div class="row">
		<div class="col-sm-12 col-md-12 text-md-right">
			<a id="add" title="Tambah Jabatan" class="btn btn-primary text-white" data-toggle="modal" data-target="#modalNew"><span class="fa fa-plus"></span> Tambah Jabatan</a>
			<a id="refresh" title="Refresh" onclick="window.location.reload();" class="btn btn-info text-white"><span class="fa fa-refresh"></span> Refresh</a>
		</div>
	</div>
	<div class="row mt-3">
		<div class="col-md-4 col-sm-12 mb-1">
			<div class="input-group mb-2">
				<div class="input-group-prepend">
					<div class="input-group-text">Tampil</div>
				</div>
				<select name="slct_row" id="slct_row" class="form-control custom-control-sm" onchange="reload_data_jabatan();">
					<option value="5">5 baris</option>
					<option value="10">10 baris</option>
					<option value="15">15 baris</option>
					<option value="25" selected>25 baris</option>
					<option value="50">50 baris</option>
					<option value="75">75 baris</option>
					<option value="100">100 baris</option>
				</select>
			</div>
		</div>

		<div class="col-md-4 col-sm-12 mb-1">
			<select name="slct_filter" id="slct_filter" class="custom-control custom-select">
				<option value="">Pilih Filter</option>
				<?php
				if (isset($op_search)) {
					foreach ($op_search as $opkey => $opval) {
						echo '<option value="' . $opkey . '">' . $opval . '</option>';
					}
				}
				?>
			</select>
		</div>
		<div class="col-sm-12 col-md-4 mb-1">
			<div class="input-group">
				<input type="text" name="tb_filter" id="tb_filter" class="form-control border-right-0 border" placeholder="Kata Kunci Pencarian" onkeyup="switch_icon();">
				<span class="input-group-append" id="icon_search">
					<div class="input-group-text bg-transparent"><i class="fa fa-search"></i></div>
				</span>
			</div>
		</div>
	</div>

	<div id="alert_info"></div>
	<div id="dataview"></div>

</div>
<!-- modal form untuk input data -->
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal label" aria-hidden="true" id="modalNew" data-backdrop="static">
		<div class="modal-dialog modal-lg">
			<form action="<?= site_url('jabatan/Simpan') ?>" method="post">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="modalTitle_shift">Input Jabatan</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>

					<div class="modal-body">
						<div class="form-group">
							<label>Nama Jabatan</label>
							<input type="text" name="jabatan" class="form-control" id="jabatan">	
						</div>
						<div class="form-group">
							<label>Kategori</label>
							<select name="section" class="form-control" id="section">
								<option value="SHIFT">Shift</option>
								<option value="NON SHIFT">Non Shift</option>
							</select>	
						</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary btn-sm"><span class="fa fa-check"></span> Simpan</button>
						<a class="btn btn-danger btn-sm" href="<?php echo site_url() . '/jabatan'; ?>" data-dismiss="modal"><span class="fa fa-times"></span> Batal</a>
					</div>
				</div>
			</form>
		</div>
	</div>




<?php
(isset($s)) ? $start = $s : $start = 0;
?>
<script type="text/javascript">
	setTimeout("reload_data_jabatan();", 1);

	var linkPage = "<?php echo site_url('jabatan/jabatan_show'); ?>/0";

	function updateLinkPage(nLink) {
		linkPage = nLink;
		reload_data_jabatan();
	}

	var sort_index = "ASC";
	var sort_field = "";

	function sorted(by) {
		sort_field = by;
		if (sort_index == "ASC") {
			sort_index = "DESC";
		} else {
			sort_index = "ASC";
		}
		reload_data_jabatan();
	}

	function iconsorter() {
		if (sort_index != "" && sort_index == 'ASC') {
			$("th.sort[data-field='" + sort_field + "']").append(' <i class="fa fa-sort-amount-asc"></i>');
		} else if (sort_index != "" && sort_index == 'DESC') {
			$("th.sort[data-field='" + sort_field + "']").append(' <i class="fa fa-sort-amount-desc"></i>');
		}
	}

	function switch_icon(cls) {
		if (cls === "TRUE") {
			$("#tb_filter").val("");
		};
		var i = $("#tb_filter").val();
		if (i == "") {
			$("#icon_search").html('<div class="input-group-text bg-transparent"><i class="fa fa-search"></i></div>');
		} else {
			$("#icon_search").html('<div style="cursor:pointer;" onclick="switch_icon(\'TRUE\');" class="input-group-text bg-transparent"><i class="fa fa-remove"></i></div>');
		}
		if (i.length >= 2 || i.length == 0) {
			reload_data_jabatan();
		}
	};

	function reload_data_jabatan(url) {
		var row = $("#slct_row").val();
		var cari = $("#tb_filter").val();
		var filter = $("#slct_filter").val();
		if (url == null || url == undefined) {
			seturl = linkPage;
		} else {
			seturl = url;
		};
		$.ajax({
			url: seturl,
			type: "POST",
			headers: {
				'X-Requested-With': 'XMLHttpRequest'
			},
			dataType: "html",
			data: "row=" + row + "&filter=" + filter + "&cari=" + cari + "&sortby=" + sort_field + "&sort=" + sort_index,
			beforeSend: function() {
				$("#ajax_loader").fadeIn(100);
			},
			success: function(data) {
				$("#ajax_loader").fadeOut(100);
				$("#dataview").html(data);
				iconsorter();
			}
		}); ///end of ajax
	}

	$("#add").click(function() {
		$.ajax({
			url: "<?php echo site_url('jabatan/jabatan_add'); ?>",
			dataType: "html",
			headers: {
				'X-Requested-With': 'XMLHttpRequest'
			},
			beforeSend: function() {
				$("#ajax_loader").fadeIn(100);
			},
			success: function(data) {
				$("#ajax_loader").fadeOut(100);
				$("#modalTitle_jabatan").html("<h4>Tambah Data jabatan</h4>");
				$("#dataview_modal_jabatan").html(data);
				$("#modalView_jabatan").modal("show");
			}
		}); /* End of Ajax */
	});
</script>