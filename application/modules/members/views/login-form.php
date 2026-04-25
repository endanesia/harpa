<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Login SCM</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?= base_url('themes/adminlte/') ?>plugins/fontawesome-free/css/all.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<!-- icheck bootstrap -->
	<link rel="stylesheet" href="<?= base_url('themes/adminlte/') ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?= base_url('themes/adminlte/') ?>dist/css/adminlte.min.css">
	<!-- Google Font: Source Sans Pro -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition login-page" style="background-image:url(<?= base_url('assets/imgs') ?>/bg.jpg); background-size:cover;">
	<div class="login-box">
		<?php if (validation_errors()) { ?>
			<div id="alert" class="alert alert-danger text-center pb-0"><?php echo validation_errors(); ?></div>
		<?php } ?>
		<div class="login-logo">
			<img src="<?= base_url('assets/imgs/logo.png') ?>" width="200px" alt="">
			
		</div>
		<!-- /.login-logo -->
		<div class="card">
			<div class="card-body login-card-body">
				<p class="login-box-msg">LOGIN SISTEM KEPEGAWAIAN</p>
				<form action="<?= site_url('members/login') ?>" method="post">
					<div class="input-group mb-3">
						<input type="text" class="form-control" placeholder="Username" name="username" value="<?php echo set_value('username'); ?>">
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-envelope"></span>
							</div>
						</div>
					</div>
					<div class="input-group mb-3">
						<input type="password" class="form-control" placeholder="Password" name="password" value="<?php echo set_value('password'); ?>">
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-lock"></span>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-8">

						</div>
						<!-- /.col -->
						<div class="col-4">
							<button type="submit" class="btn btn-danger btn-block"> Login </button>
						</div>
						<!-- /.col -->
					</div>
				</form>
			</div>
			<!-- /.login-card-body -->
		</div>
	</div>
	<!-- /.login-box -->
	<?php
	if ($this->session->flashdata('error')) {
		echo "<div class='alert alert-danger fade show' role='alert' >" . $this->session->flashdata('error') . " </div>";
	}
	?>
	<!-- jQuery -->
	<script src="<?= base_url('themes/adminlte/') ?>plugins/jquery/jquery.min.js"></script>
	<!-- Bootstrap 4 -->
	<script src="<?= base_url('themes/adminlte/') ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- AdminLTE App -->
	<script src="<?= base_url('themes/adminlte/') ?>dist/js/adminlte.min.js"></script>

</body>

</html>