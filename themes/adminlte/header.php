<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-danger navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- SEARCH FORM -->
    <?php if (isset($search)) { ?>
    <form class="form-inline ml-4" method="POST" action="<?= $search ?>">
        <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>
    <?php } ?>    
    <!-- Right navbar links -->
    <div class="btn-group ml-auto">
		<button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<i class="fa fa-user"><?php echo ' '.$this->session->userdata('nama');?></i>
		</button>
		<div class="dropdown-menu" aria-labelledby="Dropdown Menu">
            <li class="nav-item">
                <a class="nav-link" href="" role="button" data-toggle="modal" data-target="#modalGantiPassword" title='Ganti Password'>
                    <i class="fa fa-key"></i> Ganti Password
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= site_url('members/logout') ?>" role="button" title='Keluar / Logout'>
                    <i class="fas fa-door-open"></i> Keluar
                </a>
            </li>
		</div>
	</div>
</nav>
<!-- /.navbar -->
<!-- modal form untuk ganti password -->
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal label" aria-hidden="true" id="modalGantiPassword" data-backdrop="static">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="Password_title">Reset Password</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= site_url('Pegawai/upsandi/'.$this->session->userdata('userid')); ?>" method="post">
				<div class="modal-body">
					
					<div class="form-group">
						<div class="row">
							<div class="col-md-4">Password Lama</div>
							<div class="col-md-8"><input type="password" name="pl" class="form-control" id="pl" required></div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-md-4">Password baru</div>
							<div class="col-md-8"><input type="password" name="p1" class="form-control" id="p1" required></div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-md-4">Ulangi Password</div>
							<div class="col-md-8"><input type="password" name="p2" class="form-control" id="p2"></div>
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
<!-- end modal form untuk ganti password -->
