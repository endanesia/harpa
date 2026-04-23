<div class="card card-body">

	<div class="row">
                <div class="col-lg-12">
						<?php if ($errMsg != '') { ?>
							<div class="alert alert-danger" role="alert">
								<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
								<span class="sr-only">Peringatan:</span>
								<?php echo $errMsg; ?>
							</div>
						<?php } ?>
                        <form role="form" method='post' action='<?php echo site_url('users/editgroup/'. $id); ?>'>
							<div class="table-responsive table--no-card m-b-30orm-group">
								<table class="table table-striped">
									<thead>
										<tr>
											<th>Module</th>
											<th>Nama Form</th>
											<th >Akses</th>

										</tr>
									</thead>
									<?php $ng=''; foreach ($list_form as $rs) {  ?>
									<tr>
										<td><?php if ($ng != $rs->module) { echo $rs->module; $ng=$rs->module; } ?></td>
										<td><?php echo $rs->alias; ?></td>
										<td align="center">
											<input type="hidden" value="<?php echo $rs->id; ?>" name="id<?php echo $rs->id; ?>">
											<div class="checkbox" style="margin-top:-1px;">
												<input type="checkbox" value="1" name="c<?php echo $rs->idForm; ?>" <?php if ($rs->akses == 1) { echo ' checked ';} ?>>
											</div>
										</td>
									</tr>
									<?php } ?>
								</table>
							</div>
							<div style="height:10px;"></div>
							<a href="<?php echo site_url('users/group'); ?>" class="btn btn-default pull-right" >Batal</a>
                            
							<span class="pull-right">&nbsp; </span>
                            
							<button type="submit" class="btn btn-primary pull-right" name='submit'><i class="fa fa-check"></i> Simpan</button>
                        </form>
                </div>
                        <!-- /.panel-body -->
            </div>
</div>
