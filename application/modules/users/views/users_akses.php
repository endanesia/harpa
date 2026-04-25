<div class="card card-body">
	<div class="row">
		<div class="col-sm-12 col-md-12 text-md-right">
			<a onClick="ClearForm()" id="add" title="Tambah User" class="btn btn-primary text-white btn-sm" data-toggle="modal" data-target="#modalView_input"><span class="fa fa-plus" ></span> Tambah Data</a>
			<a id="refresh" title="Refresh" onclick="window.location.reload();" class="btn btn-info text-white btn-sm"><span class="fa fa-refresh"></span> Refresh</a>
		</div>
	</div>
	<hr>
	<div class="row">
					<div class="col-lg-12">
                       
                        <!-- /.panel-heading -->
                        <div class="table-responsive table--no-card m-b-30">
                            <table width="100%" class="table table-striped" id="example1">
                                <thead>
                                    <tr>
										<th>#</th>
										<th>Nama Group</th>
										<th></th>
                                    </tr>
                                </thead>
                                <tbody>
								<?php $x = 1; foreach ($list_group as $rs) { ?>
                                    <tr>
										<td><?= $x ?></td>
                                        <td><?php echo $rs->groupAlias; ?></td>
                                        <td>
											<a class="btn btn-primary btn-sm" href="<?= site_url('users/edit_group/' . $rs->id) ?>" ><i class="fa fa-search"></i> Detail Akses</a> 
											<a class="btn btn-warning btn-sm"  onclick="GetData('<?= $rs->id ?>','<?= $rs->groupAlias ?>');" data-toggle="modal" data-target="#modalView_input"><i class="fa fa-pencil"></i> </a> | 
											<?php  
												$dt = $this->users_model->Select_user_bygroup($rs->id)->result();
												if (count($dt) >= 1) { ?>
													<a class="btn btn-secondary btn-sm" onclick="alert('Akses ini tidak dapat dihapus karena masih ada user yang terkait')" title="Hapus Group"><i class="fa fa-trash"></i> </a>
												<?php } else {
											?>
											<a class="btn btn-danger btn-sm" href="<?php echo site_url('users/delgroup/' . $rs->id); ?>" title="Hapus Group"><i class="fa fa-trash"></i> </a>
												<?php } ?>
										</td>
                                    </tr>
								<?php $x++; } ?>
                                </tbody>
                            </table>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
					</div>
                    <!-- /.col-lg-12 -->
                </div>
</div>

<!-- modal form untuk input data -->
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal label" aria-hidden="true" id="modalView_input" data-backdrop="static">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalTitle_user">Input Data Akses User</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= site_url('users/simpanGroup') ?>" method="post">
				<input type="hidden" name="idtbUser" id="idtbUser">
				<div class="modal-body">
					<div class="form-group">
						<div class="row">
							<div class="col-md-3">Nama Group Akses</div>
							<div class="col-md-9"><input type="hidden" name="id" id="id"><input type="text" name="nama" class="form-control" id="nama" required></div>
						</div>
					</div>
					
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary btn-sm"><span class="fa fa-check"></span> Simpan</button>
					<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><span class="fa fa-times"></span> Close</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- modal form untuk hapus data -->
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal label" aria-hidden="true" id="modalView_hapus" data-backdrop="static">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalTitle_user">Hapus Data User</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= site_url('users/Hapus') ?>" method="post">
				<input type="hidden" name="idhapus" id="idhapus">
				<div class="modal-body">
					<h4>Apakah anda yakin akan menghapus ?</h4>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-warning btn-sm"><span class="fa fa-trash"></span> Hapus</button>
					<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><span class="fa fa-times"></span> Batal</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
	function GetData(id,nama) {
		$('#nama').val(nama);
		$('#id').val(id);
	}
	function ClearForm() {
		$('#nama').val('');
		$('#id').val(0);
	}
	function SetHapus(id) {
		$('#idhapus').val(id);
	}
</script>