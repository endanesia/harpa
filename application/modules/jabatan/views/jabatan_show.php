<div class="table-responsive">
	
		<table class="table table-sm table-hover table-bordered table-striped" id="tabel_jabatan">
			<thead class="thead-light">
				<tr>
					<td>
						
					</td>
					<td colspan="4">
						&nbsp;&nbsp;&nbsp;<strong><i>Menampilkan record ke <?php echo ($start + 1); ?> - <?php echo $end; ?> dari <?php echo $total_rows; ?> data ditemukan,</i></strong>
					</td>
				</tr>
				<tr>
					<th width="6%">No.</th>
					<th class="sort" data-field="a" onclick="sorted('a');">Nama Jabatan</th>
					<th class="sort" data-field="a" onclick="sorted('b');">Kategori</th>
					<th width="8%">Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
				(isset($start)) ? $no = $start : $no = 0;
				if (count($jabatan) > 0) {
					foreach ($jabatan as $dataview) {
						$no++;
				?>
						<tr>
							<td>
								<?php echo $no;?>
							</td>
							<td><?php echo $dataview->namaJabatan; ?></td>
							<td><?php echo $dataview->section; ?></td>
							<td>
								
								<div class="btn-group">
									<button type="button" class="btn btn-sm btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<i class="fa fa-gears"></i>
									</button>
									<div class="dropdown-menu" aria-labelledby="Dropdown Menu">
									<a href=""  title="edit data" data-toggle="modal" data-target="#modalEdit<?php echo $dataview->idJabatan; ?>"><button  class="dropdown-item edit" type="button"><i class="fa fa-edit"></i> Edit</button></a>
									<a href="<?php echo site_url() . '/jabatan/Delete/' . $dataview->idJabatan; ?>" title="hapus data"><button  class="dropdown-item delete" type="button"><i class="fa fa-trash"></i> Delete</button></a>	
									</div>
								</div>
								<!-- modal form untuk input data123-->
								<form action="<?= site_url('jabatan/Update') ?>" method="post">
								<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal label" aria-hidden="true" id="modalEdit<?php echo $dataview->idJabatan; ?>" data-backdrop="static">
									<div class="modal-dialog modal-lg">
										<div class="modal-content">
											<div class="modal-header">
														<h5 class="modal-title" id="modalTitle_shift">Ubah Jabatan</h5>
														<button type="button" class="close" data-dismiss="modal" aria-label="Close">
															<span aria-hidden="true">&times;</span>
														</button>
											</div>

											<div class="modal-body">
														<div class="form-group">
															<input type="hidden" value ="<?php echo $dataview->idJabatan;?>" name="idjabatan" class="form-control" id="idjabatan">	
														</div>
														<div class="form-group">
															<label>Nama Jabatan</label>
															<input type="text" value ="<?php echo $dataview->namaJabatan;?>" name="jabatan" class="form-control" id="jabatan">	
														</div>
														<div class="form-group">
															<label>Kategoriiii</label>
															<select  name="section" class="form-control" id="section">
																<option value="SHIFT" <?= $dataview->section == "SHIFT" ? ' selected ' : '' ?>>Shift</option>
																<option value="NON SHIFT" <?= $dataview->section == "NON SHIFT" ? ' selected ' : '' ?>>Non Shift</option>
															</select>	
														</div>
											</div>
											<div class="modal-footer">
														<button type="submit" class="btn btn-primary btn-sm"><span class="fa fa-check"></span> Ubah Data</button>
														<a class="btn btn-danger btn-sm" href="<?php echo site_url() . '/jabatan'; ?>" data-dismiss="modal"><span class="fa fa-times"></span> Batal</a>
											</div>
												
											
										</div>
									</div>
								</div>
								</form>
							</td>
						</tr>
				<?php
					}
				} else {
					echo '<tr><td colspan="5"><div class="alert alert-secondary text-center"><h5><i class="fa fa-grav"></i> Data tidak ditemukan</h5></div></td></tr>';
				}; ?>
			</tbody>
			<tfoot>
				<tr>
					<td>
						<div class="custom-control custom-checkbox">
							<input type="checkbox" name="checkAll2" id="checkAll2" class="cekAll custom-control-input" value="selectAll" onclick="cekAll();" />
							<label class="custom-control-label" for="checkAll2"> All</label>
						</div>
					</td>
					<td colspan="4">
						&nbsp;&nbsp;&nbsp;Menampilkan record ke <?php echo ($start + 1); ?> - <?php echo $end; ?> dari <?php echo $total_rows; ?> data ditemukan,
					</td>
				</tr>
			</tfoot>
		</table>
	
</div>
<!--End of Table Responsive-->
<div class="row justify-content-center text-center">
	<div class="card card-body p-1 pt-3 mx-4">
		<div class="col-sm-12 col-md-12" id="link_pagination"><?php echo $links ?></div>
	</div>
</div>

<script type="text/javascript">
	var item_global = new Array();

	$("#link_pagination ul a").click(function() {
		var link = $(this).attr("href");
		updateLinkPage(link);
		return false;
	})

	function selectCb(no) {
		if ($('#cb_' + no).is(':checked')) {
			$('#cb_' + no).prop("checked", false);
			$('#tr_' + no).removeClass("select_warna");
			removeItem(no);
		} else {
			$('#cb_' + no).prop("checked", true);
			$('#tr_' + no).addClass("select_warna");
			addItem(no);
		}
	}

	function addItem(item) {
		if (item_global.indexOf(item) == -1)
			item_global.push(item);
		countItem();
	}

	function removeItem(item) {
		var index = item_global.indexOf(item);
		if (index > -1) {
			item_global.splice(index, 1);
		}
		countItem();
	}

	function countItem() {
		if (item_global.indexOf('selectAll') > -1) {
			var index = item_global.indexOf('selectAll');
			if (index > -1) {
				item_global.splice(index, 1);
			}
		}
		var citem = item_global.length;
		$(".c_hapus").html('<i class="uk-icon-remove"></i> Delete (' + citem + ')');
	}

	$(".cekAll").click(function(event) {
		if (this.checked) {
			$(":checkbox").each(function() {
				this.checked = true;
				$("#tabel_jabatan tbody tr").addClass("select_warna");
				addItem(this.value);
			});
		} else {
			$(":checkbox").each(function() {
				this.checked = false;
				$("#tabel_jabatan tbody tr").removeClass("select_warna");
				removeItem(this.value);
			});
		}
	});

	function actionAll(act) {
		if (item_global.length > 0) { ///untuk cek apakah ada record dipilih atau tidak
			if (act == "delete") {
				if (!confirm("Apakah anda yakin akan menghapus data ?")) return false;
			}
			$.ajax({
				url: "<?php echo site_url('jabatan/jabatan_actionAll'); ?>/" + act,
				type: "POST",
				dataType: "html",
				data: "dataArray=" + item_global.sort(),
				beforeSend: function() {
					$("#ajax_loader").fadeIn(100);
				},
				success: function(data) {
					obj = JSON.parse(data);
					if (obj.status == "OK") {
						$("#alert_info").html(obj.msg);
						reload_data_jabatan();
					} else
					if (obj.status == "ERROR") {
						$("#alert_info").html(obj.msg);
					}
					$("#ajax_loader").fadeOut(100);
				}
			}); //end Of Ajax
		} else {
			alert("Maaf anda belum memilih Record...");
		}
	}

	$(document).ready(function() {
		$(".edit").click(function() {
			var id = $(this).attr("rel");
			$.ajax({
				url: "<?php echo site_url('jabatan/jabatan_upd'); ?>/" + id,
				dataType: "html",
				beforeSend: function() {
					$("#ajax_loader").fadeIn(100);
				},
				success: function(data) {
					$("#ajax_loader").fadeOut(100);
					$("#dataview_modal_jabatan").html(data);
					$("#modalTitle_jabatan").html("Edit Data jabatan");
					$("#modalView_jabatan").modal("show")
				}
			}); //end Of Ajax

		});

		const swalWithBootstrapButtons = Swal.mixin({
			customClass: {
				confirmButton: 'btn btn-success m-2',
				cancelButton: 'btn btn-danger m-2'
			},
			buttonsStyling: false
		})
	});
</script>