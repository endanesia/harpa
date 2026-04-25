<style>
 nav {
  margin-bottom:50px;
}
</style>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link navbar-danger">
        <img src="<?= base_url('assets/imgs/scm.jpg') ?>" alt="Sistem Kepegawaian" class="brand-image img-circle elevation-3" style="opacity: .9;">
        <span class="brand-text font-weight-light"><?php echo strtoupper($this->config->item('apps_title')); ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="<?php echo site_url('dashboard/'); ?>" class="nav-link <?= uri_string() == 'dashboard' ? ' active ' : '' ?>">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <?php if ($this->access->boleh(1)) { ?>
                <li class="nav-item">
                    <a href="<?= site_url('pegawai') ?>" class="nav-link">
                        <i class="nav-icon fas fa-user"></i>
                        <p>Data Pegawai</p>
                    </a>
                </li>
                <?php } 
                if ($this->access->boleh(2)) { ?>
                <li class="nav-item">
                    <a href="<?= site_url('jadwal_shift') ?>" class="nav-link">
                        <i class="nav-icon far fa-calendar-alt"></i>
                        <p>Jadwal Shift</p>
                    </a>
                </li>
                <?php } 
                    $k1 = $this->access->boleh(3) ? 1 : 0;
                    $k2 = $this->access->boleh(4) ? 1 : 0;
                    $k3 = $this->access->boleh(5) ? 1 : 0;
                    $k4 = $this->access->boleh(6) ? 1 : 0;
                    $k = $k1+$k2+$k3+$k4;
                    if ($k > 0) {
                ?>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon far fa-clock-o"></i>
                        <p>
                            Kehadiran
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <?php if ($k1 == 1) { ?>
                        <li class="nav-item">
                            <a href="<?= site_url('presensi') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Presensi</p>
                            </a>
                        </li>
                        <?php } if ($k2 == 1) { ?>
                        <li class="nav-item">
                            <a href="<?= site_url('cuti') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Cuti</p>
                            </a>
                        </li>
                        <?php } if ($k3 == 1) { ?>
                        <li class="nav-item">
                            <a href="<?= site_url('ganti_jaga') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Ganti Jaga</p>
                            </a>
                        </li>
                        <?php } if ($k4 == 1) { ?>
                        <li class="nav-item">
                            <a href="<?= site_url('lembur') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Lembur</p>
                            </a>
                        </li>
                        <?php } ?>
                    </ul>
                </li>
                <?php } 
                    $v1 = $this->access->boleh(7) ? 1 : 0;
                    $v2 = $this->access->boleh(8) ? 1 : 0;
                    $v3 = $this->access->boleh(9) ? 1 : 0;
                    $v = $v1+$v2+$v3;
                if ($v > 0) {
                ?>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-edit"></i>
                        <p>
                            Validasi
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <?php  if ($v1 == 1) { ?>
                        <li class="nav-item">
                            <a href="<?= site_url('cuti/Validasi') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Cuti</p>
                            </a>
                        </li>
                        <?php } if ($v2 == 1) { ?>
                        <li class="nav-item">
                            <a href="<?= site_url('ganti_jaga/Validasi') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>SPGJ</p>
                            </a>
                        </li>
                        <?php } if ($v3 == 1) { ?>
                        <li class="nav-item">
                            <a href="<?= site_url('lembur/Validasi') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Lembur</p>
                            </a>
                        </li>
                        <?php } ?>
                    </ul>
                </li>
                <?php } 
                if ($this->access->boleh(10)) {
                    ?>
                <li class="nav-item">
                    <a href="<?= site_url('kinerja') ?>" class="nav-link">
                        <i class="nav-icon fas fa-book"></i>
                        <p>Tunjangan Kinerja Karyawan</p>
                    </a>
                </li>
                <?php }
                    $p1 = $this->access->boleh(11) ? 1 : 0; 
                    $p2 = $this->access->boleh(12) ? 1 : 0;
                    $p3 = $this->access->boleh(13) ? 1 : 0;
                    $p4 = $this->access->boleh(14) ? 1 : 0;
                    $p5 = $this->access->boleh(15) ? 1 : 0;
                    $p6 = $this->access->boleh(16) ? 1 : 0;
                    $p7 = $this->access->boleh(28) ? 1 : 0;
                    $p8 = $this->access->boleh(29) ? 1 : 0; 
                    $p = $p1+$p2+$p3+$p4+$p5+$p6+$p7+$p8;
                    if ($p > 0) {
                        ?>
                <li class="nav-item  has-treeview">
                    <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-copy"></i>
                        <p> Penggajian 
                        <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <?php  if ($p1 == 1) { ?>
                        <li class="nav-item ">
                            <a href="<?= site_url('gaji/Hitung') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Hitung Gaji</p>
                            </a>
                        </li>
                        <?php } if ($p2 == 1) { ?>
                        <li class="nav-item ">
                            <a href="<?= site_url('gaji/hitung_thr') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Hitung THR</p>
                            </a>
                        </li>
                        <?php } if ($p7 == 1) { ?>
                        <li class="nav-item ">
                            <a href="<?= site_url('tunj_cuti/hitung') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Hitung Tunj Cuti</p>
                            </a>
                        </li>
                        <?php } if ($p3 == 1) { ?>
                        <li class="nav-item ">
                            <a href="<?= site_url('gaji/tunjangan') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tunjangan Gaji</p>
                            </a>
                        </li>
                        <?php } if ($p4 == 1) { ?>
                        <li class="nav-item ">
                            <a href="<?= site_url('gaji/potongan') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Potongan Gaji</p>
                            </a>
                        </li>
                        <?php } if ($p5 == 1) { ?>
                        <li class="nav-item">
                            <a href="<?= site_url('gaji') ?>" class="nav-link <?= uri_string() == 'gaji/show' ? ' active ' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Data Penggajian</p>
                            </a>
                        </li>
                        <?php } if ($p6 == 1) { ?>
                        <li class="nav-item">
                            <a href="<?= site_url('gaji/thr') ?>" class="nav-link <?= uri_string() == 'gaji/thr' ? ' active ' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Data THR</p>
                            </a>
                        </li>
                        <?php } if ($p8 == 1) { ?>
                        <li class="nav-item">
                            <a href="<?= site_url('tunj_cuti/') ?>" class="nav-link <?= uri_string() == 'tunj_cuti' ? ' active ' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Data Tunj Cuti</p>
                            </a>
                        </li>
                        <?php } ?>
                    </ul>
                </li>
                <?php } 
                    $k1 = $this->access->boleh(17) ? 1 : 0; 
                    $k2 = $this->access->boleh(18) ? 1 : 0; 
                    $k3 = $this->access->boleh(19) ? 1 : 0; 
                    $k4 = $this->access->boleh(20) ? 1 : 0; 
                    $k5 = $this->access->boleh(21) ? 1 : 0; 
                    $k6 = $this->access->boleh(22) ? 1 : 0; 
                    $k7 = $this->access->boleh(23) ? 1 : 0; 
                    $k8 = $this->access->boleh(24) ? 1 : 0; 
                    $k9 = $this->access->boleh(25) ? 1 : 0; 
                    $k10 = $this->access->boleh(26) ? 1 : 0; 
                    $k11 = $this->access->boleh(27) ? 1 : 0; 
                    $k12 = $this->access->boleh(31) ? 1 : 0;
                    $k=$k1+$k2+$k3+$k4+$k5+$k6+$k7+$k8+$k9+$k10+$k11+$k12;
if ($k > 0) {
    ?>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-wrench"></i>
                        <p>
                            Konfigurasi
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <?php  if ($k1 == 1) { ?>
                        <li class="nav-item ">
                            <a href="<?= site_url('kelasjabatan') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Kelas Jabatan</p>
                            </a>
                        </li>
                        <?php } if ($k2 == 1) { ?>
                        <li class="nav-item">
                            <a href="<?= site_url('jabatan/show') ?>" class="nav-link <?= uri_string() == 'jabatan/show' ? ' active ' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Jabatan</p>
                            </a>
                        </li>
                        <?php } if ($k3 == 1) { ?>
                        <li class="nav-item">
                            <a href="<?= site_url('shift') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Jenis Shift</p>
                            </a>
                        </li>
                        <?php } if ($k4 == 1) { ?>
                        <li class="nav-item">
                            <a href="<?= site_url('lokasi') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Unit Kerja</p>
                            </a>
                        </li>
                        <?php } if ($k5 == 1) { ?>
                        <li class="nav-item">
                            <a href="<?= site_url('umk') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>UMK</p>
                            </a>
                        </li>
                        <?php } if ($k12 == 1) { ?>
                        <li class="nav-item">
                            <a href="<?= site_url('ump') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>UMP</p>
                            </a>
                        </li>
                        <?php } if ($k6 == 1) { ?>
                        <li class="nav-item">
                            <a href="<?= site_url('tunjangan') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tunjangan gaji</p>
                            </a>
                        </li>
                        
                        <?php } if ($k7 == 1) { ?>
                        <li class="nav-item">
                            <a href="<?= site_url('potongan') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Potongan gaji</p>
                            </a>
                        </li>
                        <?php } if ($k8 == 1) { ?>
                        <li class="nav-item">
                            <a href="<?= site_url('tariflembur') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tarif Lembur</p>
                            </a>
                        </li>
                        <?php } if ($k9 == 1) { ?>
                        <li class="nav-item">
                            <a href="<?= site_url('libur') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Hari Libur Nasional</p>
                            </a>
                        </li>
                        <?php } if ($k10 == 1) { ?>
                        <li class="nav-item">
                            <a href="<?= site_url('users/show') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>User Management</p>
                            </a>
                        </li>
                        <?php } if ($k11 == 1) { ?>
                        <li class="nav-item">
                            <a href="<?= site_url('users/group') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Akses User</p>
                            </a>
                        </li>
                        <?php } ?>
                    </ul>
                </li>
                <?php if ($this->access->boleh(25) == 1) { ?>
                <li class="nav-item">
                    <a href="<?php echo site_url('laporan/'); ?>" class="nav-link <?= uri_string() == 'dashboard' ? ' active ' : '' ?>">
                        <i class="nav-icon fas fa-file-invoice"></i>
                        <p>
                            Laporan
                        </p>
                    </a>
                </li>
                <?php }
                }
                ?>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>