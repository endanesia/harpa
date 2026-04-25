<?php $bln = $this->session->userdata('filter_bulan');
$thn = $this->session->userdata('filter_tahun');

function cari_isi($jad, $t)
{
	$isi = "...";
	if (count($jad) > 0) {
		if ($jad[0]['t'.$t] == 'lbr') {
			$isi = "";
		} else {
			if ( $jad[0]['t'.$t] != "") {
				$isi = "<b>" . $jad[0]['t'.$t] . "</>";
			}
		}
	}
	return $isi;
}
header("Content-type: image");
header("Content-Disposition: attachment; filename=".$title.".xls");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
?>
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

<?php
$record_unit=$this->jadwal_model->unit_kerja($this->session->userdata('unit'))->row();
$kota=$this->jadwal_model->kota($record_unit->kota_id)->row();

?>
<!-------------------------------------------judul------------------------------------------------------>

		<?php
		switch ($this->session->userdata('filter_bulan')-1) {
			case "01":
				$b1 = "Januari";
				break;
			case "02":
				$b1 = "Febuari";
				break;
			case "03":
				$b1 = "Maret";
				break;
			case "04":
				$b1 = "April";
				break;
			case "05":
				$b1 = "Mei";
				break;
			case "06":
				$b1 = "Juni";
				break;
			case "07":
				$b1 = "Juli";
				break;
			case "08":
				$b1 = "Augustus";
				break;
			case "09":
				$b1 = "September";
				break;
			case "10":
				$b1 = "Oktober";
				break;
			case "11":
				$b1 = "November";
				break;
			case "12":
				$b1 = "Desember";
				break;
		}
		?>
		<?php
		switch ($this->session->userdata('filter_bulan')) {
			case "01":
				$b2 = "Januari";
				break;
			case "02":
				$b2 = "Febuari";
				break;
			case "03":
				$b2 = "Maret";
				break;
			case "04":
				$b2 = "April";
				break;
			case "05":
				$b2 = "Mei";
				break;
			case "06":
				$b2 = "Juni";
				break;
			case "07":
				$b2 = "Juli";
				break;
			case "08":
				$b2 = "Augutus";
				break;
			case "09":
				$b2 = "September";
				break;
			case "10":
				$b2 = "Oktober";
				break;
			case "11":
				$b2 = "November";
				break;
			case "12":
				$b2 = "Desember";
				break;
		}
		?>
	<!-------------------------------------------logo------------------------------------------------------>
<div class="row" style="margin-left:40px">
	<div class="col-md-1 col-xs-12">
		<image src="<?php echo base_url().'/assets/imgs/scm.jpg'?>" width="100" height="100"></image>
	</div>
	<div class="col-md-11 col-xs-12">
		<p style="margin-top:20px;"><b>PT SEBRA CIPTA MANDIRI</b><br>Jl. Ahmad Yani No.D48 Kepanjen - Malang</p>
	</div>
</div>
<!-------------------------------------------judul------------------------------------------------------>
<div class="row" style="margin-left:40px">
	<div class="col-md-12 col-xs-12">
		<h3 style="text-align:center;margin-left:-100px;">JADWAL MAINTENANCE KARYAWAN SHIFT <?=$record_unit->nama;?><br>
		BULAN <?=$b1.' '.$b2?>
		</h3>
	</div>
</div>
<!-------------------------------------------content------------------------------------------------------>
	<table border="1" width="80%" style="margin-left:40px">
					<thead>
						<tr>
							<th rowspan="2">Nama Pegawai<br><br></th>
							<th rowspan="2">NIK<br><br></th>
							<th colspan="31" style="text-align:center">Tanggal</th>
						</tr>
						<tr>
							<th>21</th>
							<th>22</th>
							<th>23</th>
							<th>24</th>
							<th>25</th>
							<th>26</th>
							<th>27</th>
							<th>28</th>
							<?php if ($bln == '03' && ($thn % 4 == 0)) { ?>
								<th>29</th>
							<?php }
							if ($bln != '03') { ?>
								<th>29</th>
								<th>30</th>
								<?php if ($bln == '01' || $bln == '02' || $bln == '02' || $bln == '04' || $bln == '06' || $bln == '08' || $bln == '09' || $bln == '11' ) { ?>
									<th>31</th>
							<?php }
							} ?>
							<th>1</th>
							<th>2</th>
							<th>3</th>
							<th>4</th>
							<th>5</th>
							<th>6</th>
							<th>7</th>
							<th>8</th>
							<th>9</th>
							<th>10</th>
							<th>11</th>
							<th>12</th>
							<th>13</th>
							<th>14</th>
							<th>15</th>
							<th>16</th>
							<th>17</th>
							<th>18</th>
							<th>19</th>
							<th>20</th>		
						</tr>
					</thead>
					<tbody>
						<?php 
							$no=1;
							$total = count($dt);
							foreach ($dt as $rs) { ?>
							<tr>
								<td><?= $rs->namaPegawai ?>
								<td><?= $rs->nipBaru ?>
									<?php
									//$jadwal = $this->jadwal_model->get_kehadiran($rs->idelektronik, $bln, $thn)->result();
									$jadwal = $this->jadwal_model->get_plot($rs->nipBaru,$bln,$thn)->result_array();
									?>
								</td>
								<?php
								//cari_isi($jadwal, '21')
								if(cari_isi($jadwal, '21')=="")
								{
								?>
								<td bgcolor="#FF0000">
									<div id="<?= $rs->idelektronik . '_21' ?>"><?= cari_isi($jadwal, '21') ?></div>
								</td>
								<?php
								}
								else
								{
								?>
								<td>
									<div id="<?= $rs->idelektronik . '_21' ?>"><?= cari_isi($jadwal, '21') ?></div>
								</td>
								<?php
								}
								?>
								<?php
								//cari_isi($jadwal, '22')
								if(cari_isi($jadwal, '22')=="")
								{
								?>
								<td bgcolor="#FF0000">
								<div id="<?= $rs->idelektronik . '_22' ?>"><?= cari_isi($jadwal, '22') ?></div>
								</td>
								<?php
								}
								else
								{
								?>
								<td>
								<div id="<?= $rs->idelektronik . '_22' ?>"><?= cari_isi($jadwal, '22') ?></div>
								</td>
								<?php
								}
								?>						
								<?php
								//cari_isi($jadwal, '23')
								if(cari_isi($jadwal, '23')=="")
								{
								?>
								<td bgcolor="#FF0000">
								<div id="<?= $rs->idelektronik . '_23' ?>"><?= cari_isi($jadwal, '23') ?></div>
								</td>
								<?php
								}
								else
								{
								?>
								<td>
								<div id="<?= $rs->idelektronik . '_23' ?>"><?= cari_isi($jadwal, '23') ?></div>
								</td>
								<?php
								}
								?>	
								<?php
								//cari_isi($jadwal, '24')
								if(cari_isi($jadwal, '24')=="")
								{
								?>
								<td bgcolor="#FF0000">
								<div id="<?= $rs->idelektronik . '_24' ?>"><?= cari_isi($jadwal, '24') ?></div>
								</td>
								<?php
								}
								else
								{
								?>
								<td>
								<div id="<?= $rs->idelektronik . '_24' ?>"><?= cari_isi($jadwal, '24') ?></div>
								</td>
								<?php
								}
								?>
								<?php
								//cari_isi($jadwal, '25')
								if(cari_isi($jadwal, '25')=="")
								{
								?>
								<td bgcolor="#FF0000">
								<div id="<?= $rs->idelektronik . '_25' ?>"><?= cari_isi($jadwal, '25') ?></div>
								</td>
								<?php
								}
								else
								{
								?>
								<td>
								<div id="<?= $rs->idelektronik . '_25' ?>"><?= cari_isi($jadwal, '25') ?></div>
								</td>
								<?php
								}
								?>
								<?php
								//cari_isi($jadwal, '26')
								if(cari_isi($jadwal, '26')=="")
								{
								?>
								<td bgcolor="#FF0000">
								<div id="<?= $rs->idelektronik . '_26' ?>"><?= cari_isi($jadwal, '26') ?></div>
								</td>
								<?php
								}
								else
								{
								?>
								<td>
								<div id="<?= $rs->idelektronik . '_26' ?>"><?= cari_isi($jadwal, '26') ?></div>
								</td>
								<?php
								}
								?>
								<?php
								//cari_isi($jadwal, '27')
								if(cari_isi($jadwal, '27')=="")
								{
								?>
								<td bgcolor="#FF0000">
								<div id="<?= $rs->idelektronik . '_27' ?>"><?= cari_isi($jadwal, '27') ?></div>
								</td>
								<?php
								}
								else
								{
								?>
								<td>
								<div id="<?= $rs->idelektronik . '_27' ?>"><?= cari_isi($jadwal, '27') ?></div>
								</td>
								<?php
								}
								?>	
								<?php
								//cari_isi($jadwal, '28')
								if(cari_isi($jadwal, '28')=="")
								{
								?>
								<td bgcolor="#FF0000">
								<div id="<?= $rs->idelektronik . '_28' ?>"><?= cari_isi($jadwal, '28') ?></div>
								</td>
								<?php
								}
								else
								{
								?>
								<td>
								<div id="<?= $rs->idelektronik . '_28' ?>"><?= cari_isi($jadwal, '28') ?></div>
								</td>
								<?php
								}
								?>
								<?php if ($bln == '03' && ($thn % 4 == 0)) { ?>
									<?php
									//cari_isi($jadwal, '29')
									if(cari_isi($jadwal, '29')=="")
									{
									?>
										<td bgcolor="#FF0000">
										<div id="<?= $rs->idelektronik . '_29' ?>"><?= cari_isi($jadwal, '29') ?></div>
										</td>
										<?php
									}
									else
									{
									?>
										<td>
										<div id="<?= $rs->idelektronik . '_29' ?>"><?= cari_isi($jadwal, '29') ?></div>
										</td>
									<?php
									}
									?>
								<?php }
								if ($bln != '03') { ?>
								<?php
								//cari_isi($jadwal, '29')
								if(cari_isi($jadwal, '29')=="")
								{
								?>
								<td bgcolor="#FF0000">
								<div id="<?= $rs->idelektronik . '_29' ?>"><?= cari_isi($jadwal, '29') ?></div>
								</td>
								<?php
								}
								else
								{
								?>
								<td>
								<div id="<?= $rs->idelektronik . '_29' ?>"><?= cari_isi($jadwal, '29') ?></div>
								</td>
								<?php
								}
								?>
								<?php
								//cari_isi($jadwal, '30')
								if(cari_isi($jadwal, '30')=="")
								{
								?>
								<td bgcolor="#FF0000">
								<div id="<?= $rs->idelektronik . '_30' ?>"><?= cari_isi($jadwal, '30') ?></div>
								</td>
								<?php
								}
								else
								{
								?>
								<td>
								<div id="<?= $rs->idelektronik . '_30' ?>"><?= cari_isi($jadwal, '30') ?></div>
								</td>
								<?php
								}
								?>
									<?php if ($bln == '01' || $bln == '02' || $bln == '04' || $bln == '06' || $bln == '08' || $bln == '09' || $bln == '11') { ?>
								<?php
								//cari_isi($jadwal, '31')
								if(cari_isi($jadwal, '31')=="")
								{
								?>
								<td bgcolor="#FF0000">
								<div id="<?= $rs->idelektronik . '_31' ?>"><?= cari_isi($jadwal, '31') ?></div>
								</td>
								<?php
								}
								else
								{
								?>
								<td>
								<div id="<?= $rs->idelektronik . '_31' ?>"><?= cari_isi($jadwal, '31') ?></div>
								</td>
								<?php
								}
								?>
								<?php }
								} ?>
								<?php
								//cari_isi($jadwal, '01')
								if(cari_isi($jadwal, '01')=="")
								{
								?>
								<td bgcolor="#FF0000">
								<div id="<?= $rs->idelektronik . '_01' ?>"><?= cari_isi($jadwal, '01') ?></div>
								</td>
								<?php
								}
								else
								{
								?>
								<td>
								<div id="<?= $rs->idelektronik . '_01' ?>"><?= cari_isi($jadwal, '01') ?></div>
								</td>
								<?php
								}
								?>
								<?php
								//cari_isi($jadwal, '2802')
								if(cari_isi($jadwal, '02')=="")
								{
								?>
								<td bgcolor="#FF0000">
								<div id="<?= $rs->idelektronik . '_02' ?>"><?= cari_isi($jadwal, '02') ?></div>
								</td>
								<?php
								}
								else
								{
								?>
								<td>
								<div id="<?= $rs->idelektronik . '_02' ?>"><?= cari_isi($jadwal, '02') ?></div>
								</td>
								<?php
								}
								?>
								<?php
								//cari_isi($jadwal, '03')
								if(cari_isi($jadwal, '03')=="")
								{
								?>
								<td bgcolor="#FF0000">
								<div id="<?= $rs->idelektronik . '_03' ?>"><?= cari_isi($jadwal, '03') ?></div>
								</td>
								<?php
								}
								else
								{
								?>
								<td>
								<div id="<?= $rs->idelektronik . '_03' ?>"><?= cari_isi($jadwal, '03') ?></div>
								</td>
								<?php
								}
								?>
								<?php
								//cari_isi($jadwal, '04')
								if(cari_isi($jadwal, '04')=="")
								{
								?>
								<td bgcolor="#FF0000">
								<div id="<?= $rs->idelektronik . '_04' ?>"><?= cari_isi($jadwal, '04') ?></div>
								</td>
								<?php
								}
								else
								{
								?>
								<td>
								<div id="<?= $rs->idelektronik . '_04' ?>"><?= cari_isi($jadwal, '04') ?></div>
								</td>
								<?php
								}
								?>
								<?php
								//cari_isi($jadwal, '05')
								if(cari_isi($jadwal, '05')=="")
								{
								?>
								<td bgcolor="#FF0000">
								<div id="<?= $rs->idelektronik . '_05' ?>"><?= cari_isi($jadwal, '05') ?></div>
								</td>
								<?php
								}
								else
								{
								?>
								<td>
								<div id="<?= $rs->idelektronik . '_05' ?>"><?= cari_isi($jadwal, '05') ?></div>
								</td>
								<?php
								}
								?>
								<?php
								//cari_isi($jadwal, '06')
								if(cari_isi($jadwal, '06')=="")
								{
								?>
								<td bgcolor="#FF0000">
								<div id="<?= $rs->idelektronik . '_06' ?>"><?= cari_isi($jadwal, '06') ?></div>
								</td>
								<?php
								}
								else
								{
								?>
								<td>
								<div id="<?= $rs->idelektronik . '_06' ?>"><?= cari_isi($jadwal, '06') ?></div>
								</td>
								<?php
								}
								?>
								<?php
								//cari_isi($jadwal, '07')
								if(cari_isi($jadwal, '07')=="")
								{
								?>
								<td bgcolor="#FF0000">
								<div id="<?= $rs->idelektronik . '_07' ?>"><?= cari_isi($jadwal, '07') ?></div>
								</td>
								<?php
								}
								else
								{
								?>
								<td>
								<div id="<?= $rs->idelektronik . '_07' ?>"><?= cari_isi($jadwal, '07') ?></div>
								</td>
								<?php
								}
								?>
								<?php
								//cari_isi($jadwal, '08')
								if(cari_isi($jadwal, '08')=="")
								{
								?>
								<td bgcolor="#FF0000">
								<div id="<?= $rs->idelektronik . '_08' ?>"><?= cari_isi($jadwal, '08') ?></div>
								</td>
								<?php
								}
								else
								{
								?>
								<td>
								<div id="<?= $rs->idelektronik . '_08' ?>"><?= cari_isi($jadwal, '08') ?></div>
								</td>
								<?php
								}
								?>
								<?php
								//cari_isi($jadwal, '09')
								if(cari_isi($jadwal, '09')=="")
								{
								?>
								<td bgcolor="#FF0000">
								<div id="<?= $rs->idelektronik . '_09' ?>"><?= cari_isi($jadwal, '09') ?></div>
								</td>
								<?php
								}
								else
								{
								?>
								<td>
								<div id="<?= $rs->idelektronik . '_09' ?>"><?= cari_isi($jadwal, '09') ?></div>
								</td>
								<?php
								}
								?>
								<?php
								//cari_isi($jadwal, '10')
								if(cari_isi($jadwal, '10')=="")
								{
								?>
								<td bgcolor="#FF0000">
								<div id="<?= $rs->idelektronik . '_10' ?>"><?= cari_isi($jadwal, '10') ?></div>
								</td>
								<?php
								}
								else
								{
								?>
								<td>
								<div id="<?= $rs->idelektronik . '_10' ?>"><?= cari_isi($jadwal, '10') ?></div>
								</td>
								<?php
								}
								?>
								<?php
								//cari_isi($jadwal, '11')
								if(cari_isi($jadwal, '11')=="")
								{
								?>
								<td bgcolor="#FF0000">
								<div id="<?= $rs->idelektronik . '_11' ?>"><?= cari_isi($jadwal, '11') ?></div>
								</td>
								<?php
								}
								else
								{
								?>
								<td>
								<div id="<?= $rs->idelektronik . '_11' ?>"><?= cari_isi($jadwal, '11') ?></div>
								</td>
								<?php
								}
								?>
								<?php
								//cari_isi($jadwal, '12')
								if(cari_isi($jadwal, '12')=="")
								{
								?>
								<td bgcolor="#FF0000">
								<div id="<?= $rs->idelektronik . '_12' ?>"><?= cari_isi($jadwal, '12') ?></div>
								</td>
								<?php
								}
								else
								{
								?>
								<td>
								<div id="<?= $rs->idelektronik . '_12' ?>"><?= cari_isi($jadwal, '12') ?></div>
								</td>
								<?php
								}
								?>
								<?php
								//cari_isi($jadwal, '13')
								if(cari_isi($jadwal, '13')=="")
								{
								?>
								<td bgcolor="#FF0000">
								<div id="<?= $rs->idelektronik . '_13' ?>"><?= cari_isi($jadwal, '13') ?></div>
								</td>
								<?php
								}
								else
								{
								?>
								<td>
								<div id="<?= $rs->idelektronik . '_13' ?>"><?= cari_isi($jadwal, '13') ?></div>
								</td>
								<?php
								}
								?>
								<?php
								//cari_isi($jadwal, '14')
								if(cari_isi($jadwal, '14')=="")
								{
								?>
								<td bgcolor="#FF0000">
								<div id="<?= $rs->idelektronik . '_14' ?>"><?= cari_isi($jadwal, '14') ?></div>
								</td>
								<?php
								}
								else
								{
								?>
								<td>
								<div id="<?= $rs->idelektronik . '_14' ?>"><?= cari_isi($jadwal, '14') ?></div>
								</td>
								<?php
								}
								?>
								<?php
								//cari_isi($jadwal, '15')
								if(cari_isi($jadwal, '15')=="")
								{
								?>
								<td bgcolor="#FF0000">
								<div id="<?= $rs->idelektronik . '_15' ?>"><?= cari_isi($jadwal, '15') ?></div>
								</td>
								<?php
								}
								else
								{
								?>
								<td>
								<div id="<?= $rs->idelektronik . '_15' ?>"><?= cari_isi($jadwal, '15') ?></div>
								</td>
								<?php
								}
								?>
								<?php
								//cari_isi($jadwal, '16')
								if(cari_isi($jadwal, '16')=="")
								{
								?>
								<td bgcolor="#FF0000">
								<div id="<?= $rs->idelektronik . '_16' ?>"><?= cari_isi($jadwal, '16') ?></div>
								</td>
								<?php
								}
								else
								{
								?>
								<td>
								<div id="<?= $rs->idelektronik . '_16' ?>"><?= cari_isi($jadwal, '16') ?></div>
								</td>
								<?php
								}
								?>
								<?php
								//cari_isi($jadwal, '17')
								if(cari_isi($jadwal, '17')=="")
								{
								?>
								<td bgcolor="#FF0000">
								<div id="<?= $rs->idelektronik . '_17' ?>"><?= cari_isi($jadwal, '17') ?></div>
								</td>
								<?php
								}
								else
								{
								?>
								<td>
								<div id="<?= $rs->idelektronik . '_17' ?>"><?= cari_isi($jadwal, '17') ?></div>
								</td>
								<?php
								}
								?>
								<?php
								//cari_isi($jadwal, '18')
								if(cari_isi($jadwal, '18')=="")
								{
								?>
								<td bgcolor="#FF0000">
								<div id="<?= $rs->idelektronik . '_18' ?>"><?= cari_isi($jadwal, '18') ?></div>
								</td>
								<?php
								}
								else
								{
								?>
								<td>
								<div id="<?= $rs->idelektronik . '_18' ?>"><?= cari_isi($jadwal, '18') ?></div>
								</td>
								<?php
								}
								?>
								<?php
								//cari_isi($jadwal, '19')
								if(cari_isi($jadwal, '19')=="")
								{
								?>
								<td bgcolor="#FF0000">
								<div id="<?= $rs->idelektronik . '_19' ?>"><?= cari_isi($jadwal, '19') ?></div>
								</td>
								<?php
								}
								else
								{
								?>
								<td>
								<div id="<?= $rs->idelektronik . '_19' ?>"><?= cari_isi($jadwal, '19') ?></div>
								</td>
								<?php
								}
								?>
								<?php
								//cari_isi($jadwal, '20')
								if(cari_isi($jadwal, '20')=="")
								{
								?>
								<td bgcolor="#FF0000">
								<div id="<?= $rs->idelektronik . '_20' ?>"><?= cari_isi($jadwal, '20') ?></div>
								</td>
								<?php
								}
								else
								{
								?>
								<td>
								<div id="<?= $rs->idelektronik . '_20' ?>"><?= cari_isi($jadwal, '20') ?></div>
								</td>
								<?php
								}
								?>

							</tr>
						<?php  $no++; } ?>
					</tbody>
				</table>
				<!-----------------------------TTD----------------------------------->
				<table>
					<tr></tr>
					<tr>
						<td colspan="10">
							<p>Mengetahui<br>ASMAN <?=$record_unit->nama; ?></p>
						</td>
						<td colspan="13">

						</td>
						<td colspan="10">
						<p><?=$kota->namaKota.','?><br>OFF ADMINISTRASI</p>
						</td>			
					</tr>
				</table>
<script>
	function SetObj(id,nip) {
		$('#idobj').val(id);
		$('#idnip').val(nip);
	}

	function SetValue() {

		const nama = document.getElementById('idobj').value;
		const nip = document.getElementById('idnip').value;
		const x = document.getElementById(nama);
		x.innerHTML = "<img src='../loading.gif' width='12px'>";
		const shift = document.getElementById('shift').value;
		const bulan = document.getElementById('bulan').value;
		const tahun = document.getElementById('tahun').value;
		$.ajax({
			url: "<?= site_url('jadwal_shift/SetShift') ?>",
			type: 'POST',
			dataType: 'json',
			data: {
				id: nama,
				kode: shift,
				bulan: bulan,
				tahun: tahun,
				nip : nip,
			},
			success: function(res) {
				//memasukkan data shift ke dalam form
				if (res.kode == 'LIBUR') {
					x.innerHTML = "<i class='fa fa-soccer-ball-o' style='color:red;'></>";
				} else {
					x.innerHTML = "<b>" + res.kode + "</b>"
				};
			}
		});

	}
</script>