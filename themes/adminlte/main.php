<!DOCTYPE html>
<html>

<head>
    <title><?php echo isset($title) ? $title : $this->config->item('apps_name'); ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="<?php echo $this->config->item('apps_description'); ?>">
    <meta name="author" content="<?php echo $this->config->item('apps_author'); ?>">
    <meta name="google" content="notranslate">

    <meta property="og:type" content="Application" />
    <meta property="og:site_name" content="<?php echo $this->config->item('apps_name'); ?>" />
    <meta property="og:title" content="<?php echo $this->config->item('apps_title'); ?>" />
    <meta property="og:image" itemprop="image" content="<?php echo base_url() . $this->config->item('apps_icon'); ?>">
    <meta property="og:description" content="<?php echo $this->config->item('apps_description'); ?>" />
    <meta property="og:url" content="<?php echo base_url(); ?>">
    <meta property="og:image:width" content="300">
    
    <link rel="icon" type="image/png" sizes="192x192" href="<?php echo base_url(); ?>assets/favicon/favicon.jpg">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url(); ?>assets/favicon/favicon.jpg">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url(); ?>assets/favicon/favicon.jpg">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url(); ?>assets/favicon/favicon.jpg">
    <link rel="manifest" href="<?php echo base_url(); ?>assets/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?php echo base_url(); ?>assets/favicon/favicon.jpg">
    <meta name="theme-color" content="#ffffff">


    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>themes/<?php echo $this->config->item('theme'); ?>/dist/css/adminlte.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>themes/<?php echo $this->config->item('theme'); ?>/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Font Awesome -->
    <link type="text/css" href="<?php echo base_url(); ?>themes/<?php echo $this->config->item('theme'); ?>/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>themes/<?php echo $this->config->item('theme'); ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>themes/<?php echo $this->config->item('theme'); ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <!-- select2 -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>themes/<?php echo $this->config->item('theme'); ?>/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>themes/<?php echo $this->config->item('theme'); ?>/plugins/select2/css/select2.min.css">
    <!-- Custom CSS  -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/addon/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Fancybox CSS  -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/addon/fancybox/jquery.fancybox.css">

    <link rel="stylesheet" href="<?php echo base_url(); ?>themes/<?php echo $this->config->item('theme'); ?>/css/style.css">
    <!-- jQuery -->
    <script src="<?php echo base_url(); ?>themes/<?php echo $this->config->item('theme'); ?>/plugins/jquery/jquery.min.js"></script>
    <style>
        .loader_anim {
            display: none;
            z-index: 9999999;
            position: fixed;
            top: 40%;
            left: 45%;
            border: 10px solid #c6c6c6;
            border-radius: 60%;
            border-top: 10px solid #3498db;
            width: 60px;
            height: 60px;
            -webkit-animation: spin 0.7s linear infinite;
            /* Safari */
            animation: spin 0.7s linear infinite;
        }

        /* Safari */
        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body class="hold-transition sidebar-mini sidebar-collapse layout-navbar-fixed">
    <div class="wrapper">
        <?php
        echo isset($header) ? $header : "";
        echo isset($menu) ? $menu : "";
        ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="background-image:url(<?= base_url('assets/imgs/bg.jpg') ?>);background-size:cover;">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1><?= isset($title) ? $title : 'SIMPEG' ?></h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <?php foreach ($bc as $key => $val) { ?>
                                    <li class="breadcrumb-item"><a href="<?= $val ?>" style="color:white;"><?= $key ?></a></li>
                                <?php } ?>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <?php echo isset($content) ? $content : ""; ?>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <?php echo isset($footer) ? $footer : ""; ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <div id="ajax_loader" class="loader_anim"></div>

    <!-- Bootstrap 4 -->
    <script src="<?php echo base_url(); ?>themes/<?php echo $this->config->item('theme'); ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url(); ?>themes/<?php echo $this->config->item('theme'); ?>/dist/js/adminlte.min.js"></script>

    <!-- DataTables -->
    <script src="<?php echo base_url(); ?>themes/<?php echo $this->config->item('theme'); ?>/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>themes/<?php echo $this->config->item('theme'); ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>themes/<?php echo $this->config->item('theme'); ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?php echo base_url(); ?>themes/<?php echo $this->config->item('theme'); ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>

    <!-- Select2 -->
    <script src="<?php echo base_url(); ?>themes/<?php echo $this->config->item('theme'); ?>/plugins/select2/js/select2.full.min.js"></script>
    <!-- Sweetalert2 -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="//cdn.jsdelivr.net/npm/@sweetalert2/theme-bulma/bulma.css" rel="stylesheet">
    <!-- Fancybox JS -->
    <script src="<?php echo base_url(); ?>assets/addon/fancybox/jquery.fancybox.js"></script>
    <!-- page script -->
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "autoWidth": false,
                "sort" : false,
                "dom": 'Bfrtip',
                "buttons": [
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
                    ],
                pageLength: 50
            });
        });
        $(function() {
            $("#example2").DataTable({
                "responsive": true,
                "autoWidth": false,
                "sort" : false,
                "dom": 'frtip',
                pageLength: 50
            });
        });
    </script>

    <script>
        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        })

        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>

</body>

</html>