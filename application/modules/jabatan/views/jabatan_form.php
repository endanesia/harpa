<?php
$is_edit = (isset($jabatan));
?>
<div class="card p-3 mb-3">
	<form class="form-horizontal" role="form" name="formjabatan" id="jabatan" action="<?php echo (!$is_edit) ? site_url("jabatan/jabatan_add") : site_url("jabatan/jabatan_upd") . '/' . $jabatan->idJabatan; ?>" method="post">
		<input type="hidden" class="form-control" value="<?php echo (!$is_edit) ? '' : $jabatan->idJabatan; ?>" name="dc_id" id="dc_id" placeholder="Id Jabatan" />
		<div class="form-group row">
			<label class="col-sm-12 col-md-4 col-lg-3" for="dc_namaJab">Nama Jabatan</label>
			<div class="col-sm-12 col-md-8 col-lg-9">
				<input type="text" class="form-control" value="<?php echo (!$is_edit) ? '' : $jabatan->namaJabatan; ?>" name="dc_namaJab" id="dc_namaJab" placeholder="Nama Jabatan" />
			</div>
		</div>
		<div class="form-group row">
			<label class="col-sm-12 col-md-4 col-lg-3" for="dc_namaJab">Kategori</label>
			<div class="col-sm-12 col-md-8 col-lg-9">
				<select class="form-control"  name="dc_section" id="dc_section" >
					<option value="SHIFT" <?= $jabatan->section == "SHIFT" ? ' selected ' : '' ?>>Shift</option>
					<option value="NON SHIFT" <?= $jabatan->section == "NON SHIFT" ? ' selected ' : '' ?>>Non Shift</option>
				</select>
			</div>
		</div>
		<hr />
		<div class="form-group row">
			<div class="col-sm-12 col-md-12">
				<div class="row justify-content-md-center">
					<div class="col-md-4 col-lg-4 col-sm-12 m-1">
						<button type="submit" class="btn btn-primary btn-lg col-12"><span class="fa fa-save"></span> Simpan</button>
					</div>
					<div class="col-md-4 col-lg-4 col-sm-12 m-1">
						<button type="reset" class="btn btn-warning btn-lg col-12" onclick="$('#modalView_jabatan').modal('hide');"><span class="fa fa-refresh"></span> Batal</button>
					</div>
				</div>
			</div>
		</div>

	</form>
</div>

<script src="<?php echo base_url(); ?>assets/js/jquery.validate.min.js" type="text/javascript"></script>
<script type="text/javascript">
	$("#jabatan").validate({
		errorClass: "is-invalid",
		validClass: "is-valid",
		wrapper: "span",

		submitHandler: function() {
			var frm = $("#jabatan");
			$.ajax({
				url: frm.attr("action"),
				type: frm.attr("method"),
				headers: {
					'X-Requested-With': 'XMLHttpRequest'
				},
				dataType: "html",
				data: frm.serialize(),
				beforeSend: function() {
					///Event sebelum proses data dikirim
					$("#ajax_loader").fadeIn(100);
				},
				success: function(data) {
					///Event Jika data Berhasil diterima
					obj = JSON.parse(data);
					if (obj.status == "OK") {
						$("#alert_info").html(obj.msg);
						reload_data_jabatan();
					} else
					if (obj.status == "ERROR") {
						$("#alert_info").html(obj.msg);
					}
					$("#modalView_jabatan").modal("hide");
					$("#ajax_loader").fadeOut(100);
				}
			}); ///end Of Ajax
		}
	});
</script>