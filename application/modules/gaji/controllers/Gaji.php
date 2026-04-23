<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gaji extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('gaji_model');
        $this->load->helper(array('url', 'form'));
        $this->load->library(array('session', 'form_validation', 'template'));
        $this->load->database();
    }

	function index($minus=0)
	{
		if (isset($_POST['skpd'])) {
			$data['bulan'] = $this->input->post('bulan');
			$data['tahun'] = $this->input->post('tahun');
			$data['unit'] = $this->input->post('skpd');
			$sess['filter_bulan'] = $data['bulan'];
			$sess['filter_tahun'] = $data['tahun'];
			$sess['filter_unit'] = $data['unit'];
			$this->session->set_userdata($sess);
		} else {
			$data['bulan'] = $this->session->filter_bulan;
			$data['tahun'] = $this->session->filter_tahun;
			$data['unit'] = $this->session->filter_unit;
			if ($data['bulan'] == "") {
				$data['bulan'] = date('m');
			}
			if ($data['tahun'] == "") {
				$data['tahun'] = date('Y');
			}
		}
		$data['bc'] = array('Dashboard' => site_url('dashboard'), 'Data Penggajian' => site_url('gaji'));
		$data['title'] = "Data Penggajian";
		$dt = $this->gaji_model->select_gaji($this->session->filter_unit, $this->session->filter_bulan, $this->session->filter_tahun)->result();
		$i = 0;
		foreach ($dt as $rs) {
			$dt[$i]->total_tunjangan = $this->gaji_model->total_tunjangan($rs->nip, $rs->bulan, $rs->tahun);
			$dt[$i]->total_potongan = $this->gaji_model->total_potongan($rs->nip, $rs->bulan, $rs->tahun);
			$i++;
		}
		$data['dt'] = $dt;
		$data['minus'] = $minus;
		$data['satkerja'] = $this->gaji_model->unit_kerja()->result();
		$this->template->mainview('gaji/gaji_index', $data);
	}

	function tunjangan()
	{
		$data['bc'] = array('Dashboard' => site_url('dashboard'), 'Tunjangan Gaji' => site_url('gaji/tunjangan'));
		$data['title'] = "Data Tunjangan Gaji";
		if (isset($_POST['tunjangan'])) {
			$sess['filter_unit'] = $this->input->post('skpd');
			$sess['filter_bulan'] = $this->input->post('bulan');
			$sess['filter_tahun'] = $this->input->post('tahun');
			$sess['filter_tunjangan'] = $this->input->post('tunjangan');
			$this->session->set_userdata($sess);
		}
		$data['dt'] = $this->gaji_model->load_tunjangan($this->session->filter_tunjangan, $this->session->filter_unit, $this->session->filter_bulan, $this->session->filter_tahun)->result();
		$data['satkerja'] = $this->gaji_model->unit_kerja()->result();
		if ($this->session->has_userdata('filter_tunjangan')) {
			$data['tunj'] = $this->gaji_model->get_list_tunjangan($this->session->filter_unit, $this->session->filter_bulan, $this->session->filter_tahun)->result();
		} else {
			$data['tunj'] = array();
		}
		$this->template->mainview('gaji/gaji_tunjangan', $data);
	}

	function potongan()
	{
		$data['bc'] = array('Dashboard' => site_url('dashboard'), 'Potongan Gaji' => site_url('gaji/potongan'));
		$data['title'] = "Data Potongan Gaji";
		if (isset($_POST['potongan'])) {
			$sess['filter_unit'] = $this->input->post('skpd');
			$sess['filter_bulan'] = $this->input->post('bulan');
			$sess['filter_tahun'] = $this->input->post('tahun');
			$sess['filter_potongan'] = $this->input->post('potongan');
			$this->session->set_userdata($sess);
		}
		$data['dt'] = $this->gaji_model->load_potongan($this->session->filter_potongan, $this->session->filter_unit, $this->session->filter_bulan, $this->session->filter_tahun)->result();
		if ($this->session->userdata('akses') == 1) {
			$data['satkerja'] = $this->gaji_model->unit_kerja()->result();
		} else {
			$data['satkerja'] = $this->gaji_model->unit_kerja($this->session->userdata('unit'))->result();
		}
		if ($this->session->has_userdata('filter_potongan')) {
			$data['pot'] = $this->gaji_model->get_list_potongan($this->session->filter_unit, $this->session->filter_bulan, $this->session->filter_tahun)->result();
		} else {
			$data['pot'] = array();
		}
		$this->template->mainview('gaji/gaji_potongan', $data);
	}

	function hitung()
	{
		$bulan = $this->session->userdata('filter_bulan');
		$tahun = $this->session->userdata('filter_tahun');
		if ($bulan == "") {
			$bulan = date('m');
		}
		if ($tahun == "") {
			$tahun = date('Y');
		}

		if (isset($_POST['bulan'])) {
			$bulan = $this->input->post('bulan');
			$tahun = $this->input->post('tahun');
			$sess['filter_bulan'] = $bulan;
			$sess['filter_tahun'] = $tahun;
			$this->session->set_userdata($sess);
		}
		$data['bulan'] = $bulan;
		$data['tahun'] = $tahun;
		$data['satkerja'] = $this->gaji_model->unit_kerja()->result();
		$data['bc'] = array('Dashboard' => site_url('dashboard'), 'Hitung Gaji' => site_url('gaji/hitung'));
		$data['title'] = "Hitung Gaji";
		$data['dt'] = $this->gaji_model->show_data($this->session->filter_unit, $this->session->filter_bulan, $this->session->filter_tahun)->result();
		$this->template->mainview('gaji/gaji_hitung', $data);
	}

	function thr()
	{
		$satkerja = $this->session->userdata('filter_unit');
		$bulan = $this->session->userdata('filter_bulan');
		$tahun = $this->session->userdata('filter_tahun');
		if (isset($_GET['skpd'])) {
			$skpd = $this->input->get('skpd');
			$bulan = $this->input->get('bulan');
			$tahun = $this->input->get('tahun');
			$sess['filter_unit'] = $skpd;
			$sess['filter_bulan'] = $bulan;
			$sess['filter_tahun'] = $tahun;
			$this->session->set_userdata($sess);
		}
		$data['satkerja'] = $this->gaji_model->unit_kerja()->result();
		$data['dt'] = $this->gaji_model->show_data($this->session->filter_unit, $this->session->filter_bulan, $this->session->filter_tahun)->result();
		$data['bc'] = array('Dashboard' => site_url('dashboard'), 'Hitung Gaji' => site_url('gaji/thr'));
		$data['title'] = "Tunjangan Hari Raya";

		$this->template->mainview('gaji/gaji_thr', $data);
	}

	function hitung_gaji($satkerja,$page=1)
	{
		$this->db->close();
		$this->db->initialize();
		$bulan = $this->session->userdata('filter_bulan');
		$tahun = $this->session->userdata('filter_tahun');
		$nilaiUmp = $this->db->get_where('tbUmp', array('tahun' => date('Y')))->row()->nilai_ump;

		// if ($bulan == '01') {
		// 	$hitBulan = 12;
		// 	$hitTahun = $tahun - 1;
		// } else {
		// 	$hitBulan = $bulan - 1;
		// 	$hitTahun = $tahun;
		// }

		$hitBulan = intval($bulan);
		$hitTahun = intval($tahun);

		$pegawai = $this->gaji_model->pegawai_unit_limit($satkerja,$page)->result();
		if (count($pegawai) > 0) {
			foreach ($pegawai as $peg) {
				$idPegawai = $peg->idtbPegawai;
				$jenisPegawai = $peg->jenisPegawai;
				$nip = $peg->tunjanganTetap;
				$idJabatan = $peg->idJabatan;
				$kelas = $peg->kelasJabatan;
				$gaji = $peg->gaji;
				$nip = $peg->nipBaru;
				$totTunj = 0;
				$totPot = 0;
				$idContact = $peg->idelektronik;
				//1. hapus semua tunjangan dan potongan yang ada di bulan ini
				$this->db->query("DELETE FROM tbRwTunjangan WHERE nip = '$nip' AND bulan = '$bulan' AND tahun = '$tahun' and kode_tunjangan > 0");
				$this->db->query("DELETE FROM tbRwPotongan WHERE nip = '$nip' AND bulan = '$bulan' AND tahun = '$tahun' AND jenis_potongan > 0");
				//1. cari hari kerja
				$dtKehadiran = $this->gaji_model->GetKehadiran($idContact, $hitBulan, $hitTahun)->row();
				if (isset($dtKehadiran)) {
					$jmlHadir = $dtKehadiran->jml;
				} else {
					$jmlHadir = 0;
				}
				//cari tunjangan pengganti jaga
				$dtGJ = $this->db->select('alasan,sum(tunjangan) as jml')->from('tbSpgj')->
						where('idp_yg_mengganti',$idPegawai)->
						where('month(tgl_validasi)', $hitBulan)->
						where('year(tgl_validasi)', $hitTahun)->
						group_by('alasan')->get()->result();
				
				if (count($dtGJ) > 0) {
					$gj = 0;
					foreach ($dtGJ as $gjRow) {
						$dTunj['nip'] = $nip;
						$dTunj['bulan'] = $bulan;
						$dTunj['tahun'] = $tahun;
						$dTunj['id_unit'] = $satkerja;
						$dTunj['kode_tunjangan'] = 0;
						$dTunj['nama_tunjangan'] = "T.Ganti Jaga ($gjRow->alasan)";
						$dTunj['ket'] = $gjRow->alasan;
						$dTunj['khusus'] = 0;
						$dTunj['jml'] = $gjRow->jml;
						$this->db->delete('tbRwTunjangan', array('nip' => $nip, 'bulan' => $bulan, 'tahun' => $tahun, 'nama_tunjangan' => "T.Ganti Jaga ($gjRow->alasan)"));
						$this->db->insert('tbRwTunjangan', $dTunj);
						$gj = $gj + $gjRow->jml;
					}
					 
				} else {
					$gj = 0;
				}		

				//buat perhitungan tunjangan masa kerja khusus karyawan PKWTT
				if ($jenisPegawai == 'PKWTT') {
					$masaKerja = date_diff(date_create($peg->tglBergabung), date_create(date('Y-m-d')));
					$lamaKerja = floor($masaKerja->format("%a") / 365); // Convert days to years
					if ($lamaKerja >= 2 && $lamaKerja < 5) {
						$tmk = $nilaiUmp * 0.01;
					} else if ($lamaKerja >= 5 && $lamaKerja < 8) {
						$tmk = $nilaiUmp * 0.02;
					} else if ($lamaKerja >= 8 && $lamaKerja < 11) {
						$tmk = $nilaiUmp * 0.03;
					} else if ($lamaKerja >= 11) {
						$tmk = $nilaiUmp * 0.05;
					} else {
						$tmk = 0;
					}
					if ($tmk > 0) {
						$dTunj['nip'] = $nip;
						$dTunj['bulan'] = $bulan;
						$dTunj['tahun'] = $tahun;
						$dTunj['id_unit'] = $satkerja;
						$dTunj['kode_tunjangan'] = 0;
						$dTunj['nama_tunjangan'] = "T.Masa Kerja";
						$dTunj['ket'] = "";
						$dTunj['khusus'] = 1;
						$dTunj['jml'] = $tmk;
						$this->db->delete('tbRwTunjangan', array('nip' => $nip, 'bulan' => $bulan, 'tahun' => $tahun, 'nama_tunjangan' => 'T.Masa Kerja', 'khusus' => 1));
						$this->db->insert('tbRwTunjangan', $dTunj);
					}
					
				}
				//2. Cari total tunjangan
				$dtTunjangan = $this->db->get_where('tbTunjangan', array('skpd' => $satkerja, 'idKelasJabatan' => $kelas, 'idJabatan' => $idJabatan))->result();
				foreach ($dtTunjangan as $tunj) {
					$dTunj['nip'] = $nip;
					$dTunj['bulan'] = $bulan;
					$dTunj['tahun'] = $tahun;
					$dTunj['id_unit'] = $satkerja;
					$dTunj['kode_tunjangan'] = $tunj->id;
					$dTunj['nama_tunjangan'] = $tunj->namaTunjangan;
					$dTunj['ket'] = "";
					if ($tunj->satuan == "Hari") {
						$dTunj['jml'] = $tunj->nilai * $jmlHadir;
						$dTunj['ket'] = $jmlHadir . " hari";
					} elseif ($tunj->satuan == "Bulan") {
						$dTunj['jml'] = $tunj->nilai;
					} else {
						$dTunj['jml'] = 0;
						$dTunj['ket'] = "tdk dapat dihitung";
					}
					$dTunj['khusus'] = 0;
					$this->db->delete('tbRwTunjangan', array('nip' => $nip, 'bulan' => $bulan, 'tahun' => $tahun, 'nama_tunjangan' => $tunj->namaTunjangan));
					$this->db->insert('tbRwTunjangan', $dTunj);
				}

				//3. cari tunjangan khusus
				$dtTunjKhusus = $this->db->get_where('tbTunjanganKhusus', array('idtbPegawai' => $idPegawai))->result();
				foreach ($dtTunjKhusus as $tunjK) {
					$dTunj['nip'] = $nip;
					$dTunj['bulan'] = $bulan;
					$dTunj['tahun'] = $tahun;
					$dTunj['id_unit'] = $satkerja;
					$dTunj['kode_tunjangan'] = $tunjK->id;
					$dTunj['nama_tunjangan'] = $tunjK->namaTunjangan;
					$dTunj['ket'] = "";
					if ($tunjK->satuan == "Hari") {
						$dTunj['jml'] = $tunjK->nilai * $jmlHadir;
						$dTunj['ket'] = $jmlHadir . " hari";
					} elseif ($tunjK->satuan == "Bulan") {
						$dTunj['jml'] = $tunjK->nilai;
					} else {
						$dTunj['jml'] = 0;
						$dTunj['ket'] = "tdk dapat dihitung";
					}
					$dTunj['khusus'] = 1;
					$this->db->delete('tbRwTunjangan', array('nip' => $nip, 'bulan' => $bulan, 'tahun' => $tahun, 'nama_tunjangan' => $tunjK->namaTunjangan));
					$this->db->insert('tbRwTunjangan', $dTunj);

				}
				
				//4. cari total lemburan
				$dtLembur = $this->gaji_model->GetLemburan($idPegawai, $bulan, $tahun)->result();
				$totalLembur = 0;
				$totalUangMakan = 0;
				foreach ($dtLembur as $lembur) {
					$totalLembur = $totalLembur + $lembur->nilai;
					$totalUangMakan = $totalUangMakan + $lembur->uangMakan;
				}
				if ($totalLembur > 0) {
					$dTunj['nip'] = $nip;
					$dTunj['bulan'] = $bulan;
					$dTunj['tahun'] = $tahun;
					$dTunj['id_unit'] = $satkerja;
					$dTunj['kode_tunjangan'] = '0';
					$dTunj['nama_tunjangan'] = 'Kerja Lebih';
					$dTunj['jml'] = $totalLembur;
					$dTunj['khusus'] = 1;
					$this->db->delete('tbRwTunjangan', array('nip' => $nip, 'bulan' => $bulan, 'tahun' => $tahun, 'nama_tunjangan' => 'Kerja Lebih', 'khusus' => 1));
					$this->db->delete('tbRwTunjangan', array('nip' => $nip, 'bulan' => $bulan, 'tahun' => $tahun, 'nama_tunjangan' => 'Uang Makan Kerja Lebih', 'khusus' => 1));
					$this->db->insert('tbRwTunjangan', $dTunj);
					$dTunj['nip'] = $nip;
					$dTunj['bulan'] = $bulan;
					$dTunj['tahun'] = $tahun;
					$dTunj['id_unit'] = $satkerja;
					$dTunj['kode_tunjangan'] = '0';
					$dTunj['nama_tunjangan'] = 'Uang Makan Kerja Lebih';
					$dTunj['jml'] = $totalUangMakan;
					$dTunj['khusus'] = 1;
					if ($totalUangMakan > 0) {
						$this->db->insert('tbRwTunjangan', $dTunj);
					}
				}

				
				//7. cari total potongan
				$dtPotongan = $this->db->get_where('tbPotongan', array('skpd' => $satkerja, 'idKelasJabatan' => $kelas, 'idJabatan' => $idJabatan))->result();
				foreach ($dtPotongan as $pot) {
					$dPot['nip'] = $nip;
					$dPot['bulan'] = $bulan;
					$dPot['tahun'] = $tahun;
					$dPot['id_unit'] = $satkerja;
					$dPot['jenis_potongan'] = $pot->id;
					$dPot['nama_potongan'] = $pot->namaPotongan;
					$dPot['ket'] = "";
					if ($pot->satuan == "Bulan") {
						$dPot['jml'] = $pot->nilai;
					} elseif ($pot->satuan == "%Gaji") {
						$dPot['jml'] = $pot->nilai * $gaji / 100;
					} else {
						$dPot['jml'] = 0;
						$dPot['ket'] = "tdk dapat dihitung";
					}
					$dPot['khusus'] = 0;
					$this->db->delete('tbRwPotongan', array('nip' => $nip, 'bulan' => $bulan, 'tahun' => $tahun, 'nama_potongan' => $pot->namaPotongan));
					$this->db->insert('tbRwPotongan', $dPot);
				}

				//8. cari potongan khusus
				$dtPotKhusus = $this->db->get_where('tbPotonganKhusus', array('idtbPegawai' => $idPegawai))->result();
				foreach ($dtPotKhusus as $potK) {
					$dPot['nip'] = $nip;
					$dPot['bulan'] = $bulan;
					$dPot['tahun'] = $tahun;
					$dPot['id_unit'] = $satkerja;
					$dPot['jenis_potongan'] = $potK->id;
					$dPot['nama_potongan'] = $potK->namaPotongan;
					$dPot['ket'] = "";
					if ($potK->satuan == "%Gaji") {
						$dPot['jml'] = $potK->nilai * $gaji / 100;
						$dPot['ket'] = $potK->nilai . "dari gaji";
					} elseif ($potK->satuan == "Bulan") {
						$dPot['jml'] = $potK->nilai;
					} else {
						$dPot['jml'] = 0;
						$dPot['ket'] = "tdk dapat dihitung";
					}
					$dPot['khusus'] = 1;
					$this->db->delete('tbRwPotongan', array('nip' => $nip, 'bulan' => $bulan, 'tahun' => $tahun, 'nama_potongan' => $potK->namaPotongan));
					$this->db->insert('tbRwPotongan', $dPot);
				}

				//9. proses ke table penggajian
				//9.1. cek di table tbRwGaji apakah sudah ada datanya
				$cekGaji = $this->db->get_where('tbRwGaji', array('nip' => $nip, 'bulan' => $bulan, 'tahun' => $tahun))->result();
				if (count($cekGaji) > 0) {
					//sdh ada data
					$this->db->update('tbRwGaji', array('gaji_pokok' => $gaji, 'id_unit' => $satkerja), array('id' => $cekGaji[0]->id));
				} else {
					//blm ada data
					$dtGaji['nip'] = $nip;
					$dtGaji['bulan'] = $bulan;
					$dtGaji['tahun'] = $tahun;
					$dtGaji['gaji_pokok'] = $gaji;
					$dtGaji['id_unit'] = $satkerja;
					$this->db->insert('tbRwGaji', $dtGaji);
				}
			}
			$data['satkerja'] = $satkerja;
			$data['page'] = $page + 1;
			$data['bc'] = array('Dashboard' => site_url('dashboard'), 'Hitung Gaji' => site_url('gaji/hitung'));
			$data['title'] = "Hitung Gaji";
			$data['peg'] = $pegawai;
			$this->template->mainview('gaji/loading_gaji', $data);
		} else {	
			redirect(site_url('gaji/hitung'));
		}
	}

	function hitung_t_masakerja()
	{
		$this->db->close();
		$this->db->initialize();
		$bulan = $this->session->userdata('filter_bulan');
		$tahun = $this->session->userdata('filter_tahun');
		$nilaiUmp = $this->db->get_where('tbUmp', array('tahun' => date('Y')))->row()->nilai_ump;

		$this->db->where('flagStatus', 1);
		$this->db->where('jenisPegawai', 'PKWTT');
		$this->db->order_by('idJabatan,kelasJabatan,namaPegawai');
		$pegawai= $this->db->get('tbPegawai')->result();
		
	
		foreach ($pegawai as $peg) {
			$nip = $peg->tunjanganTetap;
			$nip = $peg->nipBaru;

			//buat perhitungan tunjangan masa kerja khusus karyawan PKWTT
			
			$masaKerja = date_diff(date_create($peg->tglBergabung), date_create(date('Y-m-d')));
			$lamaKerja = floor($masaKerja->format("%a") / 365); // Convert days to years
			if ($lamaKerja >= 2 && $lamaKerja < 5) {
				$tmk = $nilaiUmp * 0.01;
			} else if ($lamaKerja >= 5 && $lamaKerja < 8) {
				$tmk = $nilaiUmp * 0.02;
			} else if ($lamaKerja >= 8 && $lamaKerja < 11) {
				$tmk = $nilaiUmp * 0.03;
			} else if ($lamaKerja >= 11) {
				$tmk = $nilaiUmp * 0.05;
			} else {
				$tmk = 0;
			}
				
			$dTunj['nip'] = $nip;
			$dTunj['bulan'] = $bulan;
			$dTunj['tahun'] = $tahun;
			$dTunj['id_unit'] = $peg->skpd;
			$dTunj['kode_tunjangan'] = 0;
			$dTunj['nama_tunjangan'] = "T.Masa Kerja";
			$dTunj['ket'] = "";
			$dTunj['khusus'] = 1;
			$dTunj['jml'] = $tmk;
			$this->db->delete('tbRwTunjangan', array('nip' => $nip, 'bulan' => $bulan, 'tahun' => $tahun, 'nama_tunjangan' => 'T.Masa Kerja', 'khusus' => 1));
			$this->db->insert('tbRwTunjangan', $dTunj);
				
		}
		redirect(site_url('gaji/hitung'));

	}

	function hitung_thr()
	{
		$satkerja = $this->session->userdata('filter_unit');
		$bulan = $this->session->userdata('filter_bulan');
		$tahun = $this->session->userdata('filter_tahun');
		if ($bulan == "") {
			$bulan = date('m');
		}
		if ($tahun == "") {
			$bulan = date('Y');
		}

		if (isset($_POST['bulan'])) {
			$bulan = $this->input->post('bulan');
			$tahun = $this->input->post('tahun');
			$sess['filter_bulan'] = $bulan;
			$sess['filter_tahun'] = $tahun;
			$this->session->set_userdata($sess);
		}
		$data['bulan'] = $bulan;
		$data['tahun'] = $tahun;
		$data['satkerja'] = $this->gaji_model->unit_kerja()->result();
		$data['bc'] = array('Dashboard' => site_url('dashboard'), 'Hitung THR' => site_url('gaji/hitung_thr'));
		$data['title'] = "Hitung Tunjangan Hari Raya";
		$data['dt'] = $this->gaji_model->unit_kerja()->result();
		$this->template->mainview('gaji/gaji_hitung_thr', $data);
	}

	function Simpan()
	{
		$id = $this->input->post('id');
		$data['nama_shift'] = $this->input->post('nama_shift');
		$data['tipe'] = $this->input->post('tipe');

		//jika $id = 0 maka lakukan operasi insert data
		if ($id == 0) {
			$this->gaji_model->input($data);
		} else {
			//jika $id != 0 maka lakukan proses edit
			$this->gaji_model->update($data, $id);
		}
		redirect(site_url('shift'));
	}


	function Hapus()
	{
		$id = $this->input->post('idhapus');
		$this->gaji_model->delete($id);
		redirect(site_url('shift'));
	}

	function del_tunjangan_all($tunjangan, $unit, $bulan, $tahun)
	{
		$this->db->delete('tbRwTunjangan', array(
			'nama_tunjangan' => urldecode($tunjangan),
			'id_unit' => $unit,
			'bulan' => $bulan,
			'tahun' => $tahun
		));
		redirect(site_url('gaji/tunjangan'));
	}

	function GetShift()
	{
		$id = $_POST['id'];
		$dt = $this->gaji_model->get_by_id($id)->row();
		echo json_encode($dt);
	}

	function thr_id($id)
	{
		if (isset($this->session->filter_bulan) or isset($this->session->filter_tahun)) {
			$bln = $this->session->filter_bulan;
			$thn = $this->session->filter_tahun;
		} else {
			$bln = date('m');
			$thn = date('Y');
		}
		$pegawai = $this->gaji_model->pegawai_unit($id)->result();
		$idJabatan = 0;
		$idKelas = 0;
		$kontribusi1 = 0;
		$kontribusi2 = 0;
		$tCuti = 0;
		$tCuti = $this->gaji_model->GetTunjanganCuti(date('Y'));
		foreach ($pegawai as $pg) {
			$data['nip'] = $pg->nipBaru;
			$data['bulan'] = $bln;
			$data['tahun'] = $thn;

			//hitung tunjangan masa kerja
			$tmk = 0;
			$tgl_skr = date('Y-m-d');
			$masaKerja = date_diff(date_create($pg->tglBergabung), date_create($tgl_skr));
			$lamaKerja = floor($masaKerja->format("%a") / 365); // Convert days to years
			$nilaiUmp = $this->db->get_where('tbUmp', array('tahun' => date('Y')))->row()->nilai_ump;

			if ($lamaKerja >= 2 && $lamaKerja < 5) {
				$tmk = $nilaiUmp * 0.01;
			} else if ($lamaKerja >= 5 && $lamaKerja < 8) {
				$tmk = $nilaiUmp * 0.02;
			} else if ($lamaKerja >= 8 && $lamaKerja < 11) {
				$tmk = $nilaiUmp * 0.03;
			} else if ($lamaKerja >= 11) {
				$tmk = $nilaiUmp * 0.05;
			} else {
				$tmk = 0;
			}

			// cari tunjangan kontribusi
			if ($idJabatan != $pg->idJabatan || $idKelas != $pg->kelasJabatan) {
				$idJabatan = $pg->idJabatan;
				$idKelas = $pg->kelasJabatan;
				$tKontribusi = $this->gaji_model->get_tunjangan_kontribusi($idKelas, $idJabatan, $id)->row();
				if (isset($tKontribusi)) {
					$kontribusi1 = $tKontribusi->jml;
				} else {
					$kontribusi1 = 0;
				}
			}

			//cari tunjangan khusus kontribusi
			$tKontribusi = $this->gaji_model->get_tunjangan_khusus_kontribusi($pg->idtbPegawai)->row();
			if (isset($tKontribusi)) {
				$kontribusi2 = $tKontribusi->jml;
			} else {
				$kontribusi2 = 0;
			}
			
			//hitung jumlah
			$hitung = ($pg->gaji + $tmk + $tCuti + $kontribusi1 + $kontribusi2) /12;
			//hitung potongan
			$data['jml'] = $hitung;
			$data['id_unit'] = $id;
			$cekdata = $this->gaji_model->pegawai_id($pg->nipBaru, $bln, $thn)->num_rows();
			if ($cekdata < 1) {
				$this->gaji_model->input($data);
			} else {
				$this->gaji_model->update_nip($data, $pg->nipBaru);
			}
		}
		redirect(site_url() . '/gaji/hitung_thr');
	}

	function Update_thr()
	{
		$id = $this->input->post('id_thr');
		$thr['jml'] = $this->input->post('gaji_thr');
		$this->gaji_model->update($thr, $id);
		redirect(site_url() . '/gaji/thr');
	}

	function Cetak_all()
	{
		//data
		$unit = $this->gaji_model->unit_id($this->session->filter_unit)->row();
		$nama = $unit->nama;
		$dtthr = $this->gaji_model->show_data($this->session->filter_unit, $this->session->filter_bulan, $this->session->filter_tahun)->result();
		//file cetakan
		$pdf = new PDF();
		$pdf->SetPrintHeader(false);
		$pdf->SetPrintFooter(false);
		$pdf->AddPage('P', 'mm', 'A4');
		//content
		foreach ($dtthr as $thr) {
			$pegawai = $this->gaji_model->pegawai_person($thr->nip)->row();
			$jabatan = $this->gaji_model->jabatan($pegawai->idJabatan)->row();
			$pdf->SetFont('', 'B', 10);
			$pdf->Cell(210, 13, 'SLIP TUNJANGAN HARI RAYA ' . date('F', mktime(0, 0, 0, $this->session->filter_bulan, 10)) . ' ' . date("Y", strtotime($this->session->filter_tahun)), '', 1, 'C');
			$pdf->SetFont('', 'R', 10);
			//baris 1
			$pdf->Cell(15, 5, 'NIK', '', 0, 'L');
			$pdf->Cell(5, 5, ':', '', 0, 'L');
			$pdf->Cell(70, 5, $thr->nip, '', 0, 'L');
			$pdf->Cell(40, 5, 'Departemen', '', 0, 'L');
			$pdf->Cell(5, 5, ':', '', 0, 'L');
			$pdf->Cell(50, 5, $nama, '', 1, 'L');
			//baris 2
			$pdf->Cell(15, 5, 'Nama', '', 0, 'L');
			$pdf->Cell(5, 5, ':', '', 0, 'L');
			$pdf->Cell(70, 5, $pegawai->namaPegawai, '', 0, 'L');
			$pdf->Cell(40, 5, 'Section', '', 0, 'L');
			$pdf->Cell(5, 5, ':', '', 0, 'L');
			if (($pegawai->jabatan == "SATUAN PENGAMANAN") || ($pegawai->jabatan == "CP KTH") || ($pegawai->jabatan == "CP KTH") || ($pegawai->jabatan == "TENAGA HELPER CCR") || ($pegawai->jabatan == "TENAGA BANTU TEKNISI MESIN PPS")) {
				$pdf->Cell(50, 5, 'SHIFT', '', 1, 'L');
			} else {
				$pdf->Cell(50, 5, 'NON SHIFT', '', 1, 'L');
			}
			//baris 3
			$pdf->Cell(90, 5, '', '', 0, 'L');
			$pdf->Cell(40, 5, 'Jabatan', '', 0, 'L');
			$pdf->Cell(5, 5, ':', '', 0, 'L');
			$pdf->Cell(50, 5, $jabatan->namaJabatan, '', 1, 'L');
			//baris kosong
			$pdf->Cell(210, 4, '', '', 1, 'L');
			//judul pendapatan potongan
			$pdf->SetFont('', 'B', 10);
			$pdf->Cell(30, 5, 'PENDAPATAN', '', 0, 'L');
			$pdf->Cell(60, 5, ':', '', 0, 'L');
			$pdf->Cell(25, 5, 'POTONGAN', '', 0, 'L');
			$pdf->Cell(55, 5, ':', '', 1, 'L');
			//detail pendapatan
			//THR
			$pdf->SetFont('', 'R', 10);
			$pdf->Cell(45, 5, 'Tunjangan Hari Raya', '', 0, 'L');
			$pdf->Cell(5, 5, ':', '', 0, 'L');
			$pdf->Cell(25, 5, number_format($thr->jml, "0", ",", "."), '', 1, 'R');
			//baris kosong
			//$pdf->Cell(210, 4, '', '', 1, 'L');
			//total gaji
			$gaji_kotor = $thr->jml;
			$pdf->Cell(45, 5, 'THR Kotor', '', 0, 'L');
			$pdf->Cell(5, 5, ':', '', 0, 'L');
			$pdf->Cell(25, 5, number_format($gaji_kotor, "0", ",", "."), '', 0, 'R');
			$pdf->Cell(15, 5, '', '', 0, 'R');
			//Gaji Dibayarkan
			$pdf->Cell(25, 5, 'THR di bayar ', '', 0, 'L');
			$pdf->Cell(5, 5, ':', '', 0, 'L');
			$pdf->Cell(25, 5, number_format($gaji_kotor, "0", ",", "."), '', 1, 'R');
			//baris kosong
			$pdf->Cell(210, 4, '', '', 1, 'L');
			//no Rek
			$pdf->Cell(45, 5, 'Rekening', '', 0, 'L');
			$pdf->Cell(5, 5, ':', '', 0, 'L');
			$pdf->Cell(40, 5, $pegawai->norek, '', 0, 'L');
			//kota tanggal
			$pdf->Cell(15, 5, 'Malang', '', 0, 'L');
			$pdf->Cell(5, 5, ',', '', 0, 'L');
			$pdf->Cell(40, 5, date("d/m/Y"), '', 0, 'L');
			$pdf->Cell(210, 5, '', '', 1, 'L');
			$pdf->Cell(210, 5, '--- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ', '', 1, 'L');
		}
		ob_end_clean();
		$pdf->Output('Slip Gaji THR ' . $nama);
	}

	function Cetak_Satuan($id)
	{
		//data
		$unit = $this->gaji_model->unit_id($this->session->filter_unit)->row();
		$nama = $unit->nama;
		$dtthr = $this->gaji_model->thr_id($id)->result();
		//file cetakan
		$pdf = new PDF();
		$pdf->SetPrintHeader(false);
		$pdf->SetPrintFooter(false);
		$pdf->AddPage('P', 'mm', 'A4');
		//content
		foreach ($dtthr as $thr) {
			$pegawai = $this->gaji_model->pegawai_person($thr->nip)->row();
			$jabatan = $this->gaji_model->jabatan($pegawai->idJabatan)->row();
			$pdf->SetFont('', 'B', 10);
			$pdf->Cell(210, 13, 'SLIP TUNJANGAN HARI RAYA ' . date('F', mktime(0, 0, 0, $this->session->filter_bulan, 10)) . ' ' . date("Y", strtotime($this->session->filter_tahun)), '', 1, 'C');
			$pdf->SetFont('', 'R', 10);
			//baris 1
			$pdf->Cell(15, 5, 'NIK', '', 0, 'L');
			$pdf->Cell(5, 5, ':', '', 0, 'L');
			$pdf->Cell(70, 5, $thr->nip, '', 0, 'L');
			$pdf->Cell(40, 5, 'Departemen', '', 0, 'L');
			$pdf->Cell(5, 5, ':', '', 0, 'L');
			$pdf->Cell(50, 5, $nama, '', 1, 'L');
			//baris 2
			$pdf->Cell(15, 5, 'Nama', '', 0, 'L');
			$pdf->Cell(5, 5, ':', '', 0, 'L');
			$pdf->Cell(70, 5, $pegawai->namaPegawai, '', 0, 'L');
			$pdf->Cell(40, 5, 'Section', '', 0, 'L');
			$pdf->Cell(5, 5, ':', '', 0, 'L');
			if (($pegawai->jabatan == "SATUAN PENGAMANAN") || ($pegawai->jabatan == "CP KTH") || ($pegawai->jabatan == "CP KTH") || ($pegawai->jabatan == "TENAGA HELPER CCR") || ($pegawai->jabatan == "TENAGA BANTU TEKNISI MESIN PPS")) {
				$pdf->Cell(50, 5, 'SHIFT', '', 1, 'L');
			} else {
				$pdf->Cell(50, 5, 'NON SHIFT', '', 1, 'L');
			}
			//baris 3
			$pdf->Cell(90, 5, '', '', 0, 'L');
			$pdf->Cell(40, 5, 'Jabatan', '', 0, 'L');
			$pdf->Cell(5, 5, ':', '', 0, 'L');
			$pdf->Cell(50, 5, $jabatan->namaJabatan, '', 1, 'L');
			//baris kosong
			$pdf->Cell(210, 4, '', '', 1, 'L');
			//judul pendapatan potongan
			$pdf->SetFont('', 'B', 10);
			$pdf->Cell(30, 5, 'PENDAPATAN', '', 0, 'L');
			$pdf->Cell(60, 5, ':', '', 0, 'L');
			$pdf->Cell(25, 5, 'POTONGAN', '', 0, 'L');
			$pdf->Cell(55, 5, ':', '', 1, 'L');
			//detail pendapatan
			//THR
			$pdf->SetFont('', 'R', 10);
			$pdf->Cell(45, 5, 'Tunjangan Hari Raya', '', 0, 'L');
			$pdf->Cell(5, 5, ':', '', 0, 'L');
			$pdf->Cell(25, 5, number_format($thr->jml, "0", ",", "."), '', 1, 'R');
			//baris kosong
			//$pdf->Cell(210, 4, '', '', 1, 'L');
			//total gaji
			$gaji_kotor = $thr->jml;
			$pdf->Cell(45, 5, 'THR Kotor', '', 0, 'L');
			$pdf->Cell(5, 5, ':', '', 0, 'L');
			$pdf->Cell(25, 5, number_format($gaji_kotor, "0", ",", "."), '', 0, 'R');
			$pdf->Cell(15, 5, '', '', 0, 'R');
			//Gaji Dibayarkan
			$pdf->Cell(25, 5, 'THR di bayar ', '', 0, 'L');
			$pdf->Cell(5, 5, ':', '', 0, 'L');
			$pdf->Cell(25, 5, number_format($gaji_kotor, "0", ",", "."), '', 1, 'R');
			//baris kosong
			$pdf->Cell(210, 4, '', '', 1, 'L');
			//no Rek
			$pdf->Cell(45, 5, 'Rekening', '', 0, 'L');
			$pdf->Cell(5, 5, ':', '', 0, 'L');
			$pdf->Cell(40, 5, $pegawai->norek, '', 0, 'L');
			//kota tanggal
			$pdf->Cell(15, 5, 'Malang', '', 0, 'L');
			$pdf->Cell(5, 5, ',', '', 0, 'L');
			$pdf->Cell(40, 5, date("d/m/Y"), '', 0, 'L');
			$pdf->Cell(210, 5, '', '', 1, 'L');
			$pdf->Cell(210, 5, '--- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ', '', 1, 'L');
		}
		ob_end_clean();
		$pdf->Output('Slip Gaji THR ' . $pegawai->namaPegawai);
	}

	function Cetak_Gaji_Satuan($id)
	{
		//data
		$pendapatan_kotor = 0;
		$tpotongan_kotor = 0;
		$dtgaji  = $this->gaji_model->Data_Gaji_Person($id)->row();
		$bulan   = $dtgaji->bulan;
		$tahun   = $dtgaji->tahun;
		$pegawai = $this->gaji_model->pegawai_person($dtgaji->nip)->row();
		$unit    = $this->gaji_model->unit_id($pegawai->skpd)->row();
		$nama    = $unit->nama;
		$gaji    = $this->gaji_model->Data_Gaji_Person($id)->row();
		//file cetakan
		$pdf = new PDF();
		$pdf->SetPrintHeader(false);
		$pdf->SetPrintFooter(false);
		$pdf->AddPage('P', 'mm', 'A4');
		//content
		$pdf->SetFont('', 'B', 10);
		$pdf->Cell(190, 13, 'SLIP UPAH PT.SEBRA CIPTA MANDIRI ' . $this->nama_bulan($bulan) . ' ' . $tahun, '', 1, 'C');
		$pdf->SetFont('', 'R', 10);
		//baris 1
		$pdf->Cell(15, 5, 'NIK', '', 0, 'L');
		$pdf->Cell(5, 5, ':', '', 0, 'L');
		$pdf->Cell(70, 5, $dtgaji->nip, '', 0, 'L');
		$pdf->Cell(40, 5, 'Departemen', '', 0, 'L');
		$pdf->Cell(5, 5, ':', '', 0, 'L');
		$pdf->Cell(50, 5, $nama, '', 1, 'L');
		//baris 2
		$pdf->Cell(15, 5, 'Nama', '', 0, 'L');
		$pdf->Cell(5, 5, ':', '', 0, 'L');
		$pdf->Cell(70, 5, $pegawai->namaPegawai, '', 0, 'L');
		$pdf->Cell(40, 5, 'Section', '', 0, 'L');
		$pdf->Cell(5, 5, ':', '', 0, 'L');
		if (($pegawai->jabatan == "SATUAN PENGAMANAN") || ($pegawai->jabatan == "CP KTH") || ($pegawai->jabatan == "CP KTH") || ($pegawai->jabatan == "TENAGA HELPER CCR") || ($pegawai->jabatan == "TENAGA BANTU TEKNISI MESIN PPS")) {
			$pdf->Cell(50, 5, 'SHIFT', '', 1, 'L');
		} else {
			$pdf->Cell(50, 5, 'NON SHIFT', '', 1, 'L');
		}
		//baris 3
		$pdf->Cell(90, 5, '', '', 0, 'L');
		$pdf->Cell(40, 5, 'Jabatan', '', 0, 'L');
		$pdf->Cell(5, 5, ':', '', 0, 'L');
		$pdf->Cell(50, 5, $pegawai->jabatan, '', 1, 'L');
		//baris kosong
		$pdf->Cell(210, 4, '', '', 1, 'L');
		//judul pendapatan potongan
		$pdf->SetFont('', 'B', 10);
		$pdf->Cell(30, 5, 'PENDAPATAN', '', 0, 'L');
		$pdf->Cell(60, 5, ':', '', 0, 'L');
		$pdf->Cell(25, 5, 'POTONGAN', '', 0, 'L');
		$pdf->Cell(55, 5, ':', '', 1, 'L');

		//detail pendapatan

		//isi Parameter Gaji

		$pendapatan = $this->gaji_model->Data_Tunjangan_Person($dtgaji->nip, $bulan, $tahun)->result_array();
		$potongan = $this->gaji_model->Data_Potongan_Person($dtgaji->nip, $bulan, $tahun)->result_array();

		//hitung jumlah parameter
		$jpendapatan = count($pendapatan);
		$jpotongan = count($potongan);
		foreach ($pendapatan as $key => $value) {
			if ($value['nama_tunjangan'] == 'T.Masa Kerja') {
				$pendapatan[$key]['tunjKontribusi'] = 2;
			} else {
				if ($value['khusus'] == '1') {
					$cek = $this->db->select('tunjKontribusi')->from('tbTunjanganKhusus')->where('id', $value['kode_tunjangan'])->get()->result();
					if (count($cek) > 0) {
						$pendapatan[$key]['tunjKontribusi'] = $cek[0]->tunjKontribusi;
					} else {
						$pendapatan[$key]['tunjKontribusi'] = 0;
					}
				}
			}	
		}
			// ururtkan array pendapatan berdasarkan tunjKontribusi descending

		usort($pendapatan, function ($a, $b) {
			return $b['tunjKontribusi'] <=> $a['tunjKontribusi'];
		});
		$pdf->SetFont('', 'R', 10);

		if ($jpendapatan < $jpotongan) {

			//detail baris 1
			$pdf->Cell(45, 5, '  Upah Pokok', '', 0, 'L');
			$pdf->Cell(5, 5, ':', '', 0, 'L');
			$pdf->Cell(25, 5, number_format($gaji->gaji_pokok, "0", ",", "."), '', 0, 'R');
			$pdf->Cell(15, 5, '', '', 0, 'L');
			if (!empty($potongan[0]['nama_potongan'])) {
				$pdf->Cell(55, 5, '  '.substr($potongan[0]['nama_potongan'], 0, 20), '', 0, 'L');
				$pdf->Cell(5, 5, ':', '', 0, 'L');
				$pdf->Cell(25, 5, number_format($potongan[0]['jml'], "0", ",", "."), '', 1, 'R');
			} else {
				$pdf->Cell(25, 5, '', '', 0, 'L');
				$pdf->Cell(5, 5, '', '', 0, 'L');
				$pdf->Cell(25, 5, '', '', 1, 'R');
			}
			//Kosong
			//$pdf->Cell(210, 5, '', '', 1, 'L');
			//detail baris 2
			$isTk = 2; //var untuk menyimpan tunj kontribusi
			for ($i = 0; $i < $jpotongan; $i++) {
				if (!empty($pendapatan[$i]['nama_tunjangan'])) {

						if ($pendapatan[$i]['tunjKontribusi'] != $isTk) {
							$isTk = $pendapatan[$i]['tunjKontribusi'];
							if ($pendapatan[$i]['tunjKontribusi'] == 1) {
								$pdf->Cell(45, 5, "TUNJANGAN KONTRIBUSI", '', 0, 'L');
								$pdf->Cell(5, 5, ':', '', 0, 'L');
								$pdf->Cell(25, 5, '', '', 0, 'R');
								$pdf->Cell(15, 5, '', '', 1, 'L');
								$isTk = 1;
							} else {
								$pdf->Cell(45, 5, " ", '', 0, 'L');
								$pdf->Cell(5, 5, ':', '', 0, 'L');
								$pdf->Cell(25, 5, '', '', 0, 'R');
								$pdf->Cell(15, 5, '', '', 1, 'L');
								$isTk = 0;
							}
						} 
							$pdf->Cell(45, 5, '  '.substr($pendapatan[$i]['nama_tunjangan'], 0, 20), '', 0, 'L');
							$pdf->Cell(5, 5, ':', '', 0, 'L');
							$pdf->Cell(25, 5, number_format($pendapatan[$i]['jml'], "0", ",", "."), '', 0, 'R');
							$pdf->Cell(15, 5, '', '', 0, 'L');
						
					} else {
						$pdf->Cell(45, 5, '', '', 0, 'L');
						$pdf->Cell(5, 5, '', '', 0, 'L');
						$pdf->Cell(40, 5, '', '', 0, 'L');
					}
					$pdf->Cell(55, 5, '  '. substr($potongan[$i + 1]['nama_potongan'], 0, 20), '', 0, 'L');
					$pdf->Cell(5, 5, ':', '', 0, 'L');
					$pdf->Cell(25, 5, number_format($potongan[$i + 1]['jml'], "0", ",", "."), '', 1, 'R');
					//Kosong
					//$pdf->Cell(210, 5, '', '', 1, 'L');
					if (!isset($pendapatan[$i]['jml'])) {
						$pendapatan[$i]['jml'] = 0;
					}
					if (!isset($potongan[0]['jml'])) {
						$potongan[0]['jml'] = 0;
					}
					if (!isset($potongan[$i + 1]['jml'])) {
						$potongan[$i + 1]['jml'] = 0;
					}
					$pendapatan_kotor = $pendapatan_kotor + $pendapatan[$i]['jml'];
					$tpotongan_kotor = $tpotongan_kotor + $potongan[$i + 1]['jml'];
					$potongan_kotor = $potongan[0]['jml'] + $tpotongan_kotor;
					$gjt = $gaji->gaji_pokok + $pendapatan_kotor;
					$gj = $gaji->gaji_pokok + $pendapatan_kotor - $potongan_kotor;
				
			}
		} else {
			//detail baris 1
			$pdf->Cell(45, 5, '  Upah Pokok', '', 0, 'L');
			$pdf->Cell(5, 5, ':', '', 0, 'L');
			$pdf->Cell(25, 5, number_format($gaji->gaji_pokok, "0", ",", "."), '', 0, 'R');
			$pdf->Cell(15, 5, "", '', 0, 'L');
			if (!empty($potongan[0]['nama_potongan'])) {
				$pdf->Cell(55, 5, '  '.substr($potongan[0]['nama_potongan'], 0, 20) , '', 0, 'L');
				$pdf->Cell(5, 5, ':', '', 0, 'L');
				$pdf->Cell(25, 5, number_format($potongan[0]['jml'], "0", ",", "."), '', 1, 'R');
			} else {
				$pdf->Cell(25, 5, '', '', 0, 'L');
				$pdf->Cell(5, 5, '', '', 0, 'L');
				$pdf->Cell(25, 5, '', '', 1, 'R');
			}

			//Kosong
			//$pdf->Cell(210, 5, '', '', 1, 'L');
			//detail baris 2
			$isTk = 2; //var untuk menyimpan tunj kontribusi
			for ($i = 0; $i < $jpendapatan; $i++) {

				if ($pendapatan[$i]['tunjKontribusi'] != $isTk) {
					if ($pendapatan[$i]['tunjKontribusi'] == 1) {
						$pdf->SetFont('', 'B', 10);
						$pdf->Cell(45, 5, 'TUNJANGAN KONTRIBUSI', '', 0, 'L');
						$pdf->Cell(45, 5, '', '', 1, 'L');
						$pdf->SetFont('', 'R', 10);
						$isTk = 1;
					} else { 
						$pdf->SetFont('', 'B', 10);
						$pdf->Cell(45, 5, ' ', '', 0, 'L');
						$pdf->Cell(45, 5, '', '', 1, 'L');
						$pdf->SetFont('', 'R', 10);
						$isTk = 0;
					}
				}
					$pdf->Cell(45, 5, '  '.$pendapatan[$i]['nama_tunjangan'], '', 0, 'L');
					$pdf->Cell(5, 5, ':', '', 0, 'L');
					$pdf->Cell(25, 5, number_format($pendapatan[$i]['jml'], "0", ",", "."), '', 0, 'R');
					$pdf->Cell(15, 5, '', '', 0, 'R');
					if (!empty($potongan[$i + 1]['nama_potongan'])) {
						$pdf->Cell(55, 5, '  '.substr($potongan[$i + 1]['nama_potongan'], 0, 20), '', 0, 'L');
						$pdf->Cell(5, 5, ':', '', 0, 'L');
						$pdf->Cell(25, 5, number_format($potongan[$i + 1]['jml'], "0", ",", "."), '', 1, 'R');
					} else {
						$pdf->Cell(40, 5, '', '', 0, 'L');
						$pdf->Cell(5, 5, '', '', 0, 'L');
						$pdf->Cell(25, 5, '', '', 1, 'L');
					}
				
				
				
				//Kosong
				//$pdf->Cell(210, 5, '', '', 1, 'L');
				if (!isset($pendapatan[$i]['jml'])) {
					$pendapatan[$i]['jml'] = 0;
				}
				if (!isset($potongan[0]['jml'])) {
					$potongan[0]['jml'] = 0;
				}
				if (!isset($potongan[$i + 1]['jml'])) {
					$potongan[$i + 1]['jml'] = 0;
				}
				$pendapatan_kotor = $pendapatan_kotor + $pendapatan[$i]['jml'];
				$tpotongan_kotor = $tpotongan_kotor + $potongan[$i + 1]['jml'];
				$potongan_kotor = $potongan[0]['jml'] + $tpotongan_kotor;
				$gjt = $gaji->gaji_pokok + $pendapatan_kotor;
				$gj = $gaji->gaji_pokok + $pendapatan_kotor - $potongan_kotor;
			}
		}

		//total gaji
		$pdf->Cell(210, 5, '----------------------------------------------------------------------------------------------------------------------------------------------------', '', 1, 'L');
		$pdf->Cell(45, 5, 'Upah Kotor', '', 0, 'L');
		$pdf->Cell(5, 5, ':', '', 0, 'L');
		$pdf->Cell(25, 5, number_format($gaji->gaji_pokok + $pendapatan_kotor, "0", ",", "."), '', 0, 'R');
		$pdf->Cell(15, 5, "", '', 0, 'L');
		//Gaji Dibayarkan
		$pdf->Cell(25, 5, 'Upah dibayarkan', '', 0, 'L');
		$pdf->Cell(5, 5, ':', '', 0, 'L');
		$pdf->Cell(25, 5, number_format($gaji->gaji_pokok + $pendapatan_kotor - $potongan_kotor, "0", ",", "."), '', 1, 'R');
		//total gaji
		$pdf->Cell(45, 5, 'Potongan', '', 0, 'L');
		$pdf->Cell(5, 5, ':', '', 0, 'L');
		$pdf->Cell(25, 5, number_format($potongan_kotor, "0", ",", "."), '', 0, 'R');
		//Gaji Dibayarkan
		$pdf->Cell(40, 5, '', '', 0, 'L');
		$pdf->Cell(5, 5, '', '', 0, 'L');
		$pdf->Cell(25, 5, '', '', 1, 'L');
		//Kosong
		$pdf->Cell(210, 5, '', '', 1, 'L');
		//no Rek
		$pdf->Cell(45, 5, 'Rekening', '', 0, 'L');
		$pdf->Cell(5, 5, ':', '', 0, 'L');
		$pdf->Cell(40, 5, $pegawai->norek, '', 0, 'L');
		//kota tanggal
		$pdf->Cell(15, 5, 'Malang', '', 0, 'L');
		$pdf->Cell(5, 5, ',', '', 0, 'L');
		$pdf->Cell(40, 5, date("d/m/Y"), '', 0, 'L');
		$pdf->Cell(210, 5, '', '', 1, 'L');
		$pdf->Cell(210, 5, '--- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ', '', 1, 'L');
		ob_end_clean();
		$pdf->Output('Slip Gaji ' . $pegawai->namaPegawai);
	}
	function nama_bulan($bulan) {
		$namaBulan = [
			1 => 'JANUARI', 
			2 => 'FEBRUARI', 
			3 => 'MARET', 
			4 => 'APRIL', 
			5 => 'MEI', 
			6 => 'JUNI', 
			7 => 'JULI', 
			8 => 'AGUSTUS', 
			9 => 'SEPTEMBER', 
			10 => 'OKTOBER', 
			11 => 'NOVEMBER', 
			12 => 'DESEMBER'
		];
		return isset($namaBulan[$bulan]) ? $namaBulan[$bulan] : 'Bulan tidak valid';
	}
	function Cetak_Gaji_Semua()
	{
		$dt = $this->gaji_model->select_gaji($this->session->filter_unit, $this->session->filter_bulan, $this->session->filter_tahun)->result();
		//file cetakan
		$pdf = new PDF();
		$pdf->SetPrintHeader(false);
		$pdf->SetPrintFooter(false);
		$pdf->AddPage('P', 'LETTER');
		
		$counter = 0; // Counter untuk menghitung slip dalam satu halaman
		$pageHeight = 279.4; // Tinggi Letter dalam mm
		$slipHeight = $pageHeight/2; // Tinggi untuk satu slip
		
		foreach ($dt as $gaji) {
			//data 
			$tpotongan_kotor = 0;
			$pendapatan_kotor = 0;
			$dtgaji  = $this->gaji_model->Data_Gaji_Person($gaji->id)->row();
			$bulan   = $dtgaji->bulan;
			$tahun   = $dtgaji->tahun;
			
			// Set Y position based on counter
			if($counter == 0) {
				$pdf->SetY(10); // Start of page
			} else {
				$pdf->SetY($slipHeight + 1); // Middle of page
			}
			
			$pegawai = $this->gaji_model->pegawai_person($gaji->nip)->row();
			$unit    = $this->gaji_model->unit_id($pegawai->skpd)->row();
			$nama    = $unit->nama;
			$gaji    = $this->gaji_model->Data_Gaji_Person($gaji->id)->row();
			//content
			$pdf->SetFont('', 'B', 10);
			$pdf->Cell(190, 13, 'SLIP UPAH PT.SEBRA CIPTA MANDIRI ' . $this->nama_bulan($bulan) . ' ' . $tahun, '', 1, 'C');
			$pdf->SetFont('', 'R', 10);
			//baris 1
			$pdf->Cell(15, 5, 'NIK', '', 0, 'L');
			$pdf->Cell(5, 5, ':', '', 0, 'L');
			$pdf->Cell(70, 5, $dtgaji->nip, '', 0, 'L');
			$pdf->Cell(40, 5, 'Departemen', '', 0, 'L');
			$pdf->Cell(5, 5, ':', '', 0, 'L');
			$pdf->Cell(50, 5, $nama, '', 1, 'L');
			//baris 2
			$pdf->Cell(15, 5, 'Nama', '', 0, 'L');
			$pdf->Cell(5, 5, ':', '', 0, 'L');
			$pdf->Cell(70, 5, $pegawai->namaPegawai, '', 0, 'L');
			$pdf->Cell(40, 5, 'Section', '', 0, 'L');
			$pdf->Cell(5, 5, ':', '', 0, 'L');
			if (($pegawai->jabatan == "SATUAN PENGAMANAN") || ($pegawai->jabatan == "CP KTH") || ($pegawai->jabatan == "CP KTH") || ($pegawai->jabatan == "TENAGA HELPER CCR") || ($pegawai->jabatan == "TENAGA BANTU TEKNISI MESIN PPS")) {
				$pdf->Cell(50, 5, 'SHIFT', '', 1, 'L');
			} else {
				$pdf->Cell(50, 5, 'NON SHIFT', '', 1, 'L');
			}
			//baris 3
			$pdf->Cell(90, 5, '', '', 0, 'L');
			$pdf->Cell(40, 5, 'Jabatan', '', 0, 'L');
			$pdf->Cell(5, 5, ':', '', 0, 'L');
			$pdf->Cell(50, 5, $pegawai->jabatan, '', 1, 'L');
			//baris kosong
			$pdf->Cell(210, 4, '', '', 1, 'L');
			//judul pendapatan potongan
			$pdf->SetFont('', 'B', 10);
			$pdf->Cell(30, 5, 'PENDAPATAN', '', 0, 'L');
			$pdf->Cell(60, 5, ':', '', 0, 'L');
			$pdf->Cell(25, 5, 'POTONGAN', '', 0, 'L');
			$pdf->Cell(55, 5, ':', '', 1, 'L');

			//detail pendapatan
			//isi Parameter Gaji

			$pendapatan = $this->gaji_model->Data_Tunjangan_Person($gaji->nip, $bulan, $tahun)->result_array();
			$potongan = $this->gaji_model->Data_Potongan_Person($gaji->nip, $bulan, $tahun)->result_array();

			//hitung jumlah parameter
			$jpendapatan = count($pendapatan);
			$jpotongan = count($potongan);
			foreach ($pendapatan as $key => $value) {
				if ($value['nama_tunjangan'] == 'T.Masa Kerja') {
					$pendapatan[$key]['tunjKontribusi'] = 2;
				} else {
					if ($value['khusus'] == '1') {
						$cek = $this->db->select('tunjKontribusi')->from('tbTunjanganKhusus')->where('id', $value['kode_tunjangan'])->get()->result();
						if (count($cek) > 0) {
							$pendapatan[$key]['tunjKontribusi'] = $cek[0]->tunjKontribusi;
						} else {
							$pendapatan[$key]['tunjKontribusi'] = 0;
						}
					}
				}	
			}
			// ururtkan array pendapatan berdasarkan tunjKontribusi
			usort($pendapatan, function ($a, $b) {
				return $b['tunjKontribusi'] <=> $a['tunjKontribusi'];
			});

			$pdf->SetFont('', 'R', 10);
			$pendapatan_kotor = 0;
			$tpotongan_kotor = 0;
			$potongan_kotor = 0;
			$gjt = 0;
			$gj = 0;
			$isTk = 0; //var untuk menyimpan tunj kontribusi
			if ($jpendapatan < $jpotongan) {

				//detail baris 1
				$pdf->Cell(45, 5, '  Upah Pokok', '', 0, 'L');
				$pdf->Cell(5, 5, ':', '', 0, 'L');
				$pdf->Cell(25, 5, number_format($gaji->gaji_pokok, "0", ",", "."), '', 0, 'R');
				$pdf->Cell(15, 5, '', '', 0, 'L');
				$pdf->Cell(25, 5, '', '', 0, 'L');
				$pdf->Cell(5, 5, '', '', 0, 'L');
				$pdf->Cell(25, 5, '', '', 1, 'R');

				//Kosong
				//$pdf->Cell(210, 5, '', '', 1, 'L');
				//detail baris 2
				$isTk = 2; //var untuk menyimpan tunj kontribusi
				for ($i = 0; $i < $jpotongan; $i++) {
					if (!empty($pendapatan[$i]['nama_tunjangan'])) {
						if ($pendapatan[$i]['tunjKontribusi'] != $isTk) {
							$pdf->SetFont('', 'B', 10);
							$isTk = $pendapatan[$i]['tunjKontribusi'];
							if ($pendapatan[$i]['tunjKontribusi'] == 1) {
								$pdf->Cell(45, 5, 'TUNJANGAN KONTRIBUSI', '', 0, 'L');
								$pdf->Cell(45, 5, '', '', 1, 'L');
								$isTk = 1;
							} else {
								$pdf->Cell(45, 5, ' ', '', 0, 'L');
								$pdf->Cell(45, 5, '', '', 1, 'L');
								$isTk = 0;
							}
							$pdf->SetFont('', 'R', 10);
						}
						$pdf->Cell(45, 5, '  '.$pendapatan[$i]['nama_tunjangan'], '', 0, 'L');
						$pdf->Cell(5, 5, ':', '', 0, 'L');
						$pdf->Cell(25, 5, number_format($pendapatan[$i]['jml'], "0", ",", "."), '', 0, 'R');
						$pdf->Cell(15, 5, '', '', 0, 'L');
					} else {
						$pdf->Cell(45, 5, '', '', 0, 'L');
						$pdf->Cell(5, 5, '', '', 0, 'L');
						$pdf->Cell(40, 5, '', '', 0, 'L');
					}
					$pdf->Cell(55, 5, '  '.substr($potongan[$i]['nama_potongan'], 0, 20), '', 0, 'L');
					$pdf->Cell(5, 5, ':', '', 0, 'L');
					$pdf->Cell(25, 5, number_format($potongan[$i]['jml'], "0", ",", "."), '', 1, 'R');
					//Kosong
					//$pdf->Cell(210, 5, '', '', 1, 'L');
					if (!isset($pendapatan[$i]['jml'])) {
						$pendapatan[$i]['jml'] = 0;
					}
					if (!isset($potongan[0]['jml'])) {
						$potongan[0]['jml'] = 0;
					}
					if (!isset($potongan[$i + 1]['jml'])) {
						$potongan[$i + 1]['jml'] = 0;
					}
					$pendapatan_kotor = $pendapatan_kotor + $pendapatan[$i]['jml'];
					$tpotongan_kotor = $tpotongan_kotor + $potongan[$i]['jml'];
					$potongan_kotor = $tpotongan_kotor;
					$gjt = $gaji->gaji_pokok + $pendapatan_kotor;
					$gj = $gaji->gaji_pokok + $pendapatan_kotor - $potongan_kotor;
				}
			} else {
				//detail baris 1
				$pdf->Cell(45, 5, '  Upah Pokok', '', 0, 'L');
				$pdf->Cell(5, 5, ':', '', 0, 'L');
				$pdf->Cell(25, 5, number_format($gaji->gaji_pokok, "0", ",", "."), '', 0, 'R');
				$pdf->Cell(15, 5, "", '', 0, 'L');
				$pdf->Cell(25, 5, '', '', 0, 'L');
				$pdf->Cell(5, 5, '', '', 0, 'L');
				$pdf->Cell(25, 5, '', '', 1, 'R');

				//Kosong
				//$pdf->Cell(210, 5, '', '', 1, 'L');
				//detail baris 2
				$isTk = 2; //var untuk menyimpan tunj kontribusi
				for ($i = 0; $i < $jpendapatan; $i++) {
					if ($pendapatan[$i]['tunjKontribusi'] != $isTk) {
						$pdf->SetFont('', 'B', 10);
						if ($pendapatan[$i]['tunjKontribusi'] == 1) {
							$pdf->Cell(45, 5, 'TUNJANGAN KONTRIBUSI', '', 0, 'L');
							$pdf->Cell(45, 5, '', '', 1, 'L');
							$isTk = 1;
						} else {
							$pdf->Cell(45, 5, ' ', '', 0, 'L');
							$pdf->Cell(45, 5, '', '', 1, 'L');
							$isTk = 0;
						}
						$pdf->SetFont('', 'R', 10);
					}
					$pdf->Cell(45, 5, '  '.$pendapatan[$i]['nama_tunjangan'], '', 0, 'L');
					$pdf->Cell(5, 5, ':', '', 0, 'L');
					$pdf->Cell(25, 5, number_format($pendapatan[$i]['jml'], "0", ",", "."), '', 0, 'R');
					$pdf->Cell(15, 5, '', '', 0, 'R');
					if (!empty($potongan[$i]['nama_potongan'])) {
						$pdf->Cell(55, 5, '  '.substr($potongan[$i]['nama_potongan'], 0, 20), '', 0, 'L');
						$pdf->Cell(5, 5, ':', '', 0, 'L');
						$pdf->Cell(25, 5, number_format($potongan[$i]['jml'], "0", ",", "."), '', 1, 'R');
					} else {
						$pdf->Cell(40, 5, '', '', 0, 'L');
						$pdf->Cell(5, 5, '', '', 0, 'L');
						$pdf->Cell(25, 5, '', '', 1, 'L');
					}
					//Kosong
					//$pdf->Cell(210, 5, '', '', 1, 'L');
					if (!isset($pendapatan[$i]['jml'])) {
						$pendapatan[$i]['jml'] = 0;
					}
					if (!isset($potongan[0]['jml'])) {
						$potongan[0]['jml'] = 0;
					}
					if (!isset($potongan[$i]['jml'])) {
						$potongan[$i]['jml'] = 0;
					}
					$pendapatan_kotor = $pendapatan_kotor + $pendapatan[$i]['jml'];
					$tpotongan_kotor = $tpotongan_kotor + $potongan[$i]['jml'];
					$potongan_kotor = $tpotongan_kotor;
				}
			}
			$gjt = $gaji->gaji_pokok + $pendapatan_kotor;
			$gj = $gaji->gaji_pokok + $pendapatan_kotor - $potongan_kotor;
			//total gaji
			$pdf->Cell(210, 5, '----------------------------------------------------------------------------------------------------------------------------------------------------', '', 1, 'L');
			$pdf->Cell(45, 5, 'Upah Kotor', '', 0, 'L');
			$pdf->Cell(5, 5, ':', '', 0, 'L');
			$pdf->Cell(25, 5, number_format($gaji->gaji_pokok + $pendapatan_kotor, "0", ",", "."), '', 0, 'R');
			$pdf->Cell(15, 5, "", '', 0, 'L');
			//Gaji Dibayarkan
			$pdf->Cell(25, 5, 'Upah dibayar', '', 0, 'L');
			$pdf->Cell(5, 5, ':', '', 0, 'L');
			$pdf->Cell(25, 5, number_format($gj, "0", ",", "."), '', 1, 'R');
			//total gaji
			$pdf->Cell(45, 5, 'Potongan', '', 0, 'L');
			$pdf->Cell(5, 5, ':', '', 0, 'L');
			$pdf->Cell(25, 5, number_format($potongan_kotor, "0", ",", "."), '', 0, 'R');
			//Gaji Dibayarkan
			$pdf->Cell(40, 5, '', '', 0, 'L');
			$pdf->Cell(5, 5, '', '', 0, 'L');
			$pdf->Cell(25, 5, '', '', 1, 'L');
			//Kosong
			$pdf->Cell(210, 5, '', '', 1, 'L');
			//no Rek
			$pdf->Cell(45, 5, 'Rekening', '', 0, 'L');
			$pdf->Cell(5, 5, ':', '', 0, 'L');
			$pdf->Cell(40, 5, $pegawai->norek, '', 0, 'L');
			//kota tanggal
			$pdf->Cell(15, 5, 'Malang', '', 0, 'L');
			$pdf->Cell(5, 5, ',', '', 0, 'L');
			$pdf->Cell(40, 5, date("d/m/Y"), '', 0, 'L');
			$pdf->Cell(210, 5, '', '', 1, 'L');

			//akhir
			$pdf->Cell(210, 5, '--- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ', '', 1, 'L');
			$counter++;
			if($counter == 2) { // After printing 2 slips
				$counter = 0; // Reset counter
				if ($gaji !== end($dt)) { // If not the last slip
					$pdf->AddPage('P', 'LETTER'); // Add new page
				}
			}
		}
		ob_end_clean();
		$pdf->Output('Slip Gaji ');
	}

	public function excel_potongan()
	{
		if (isset($_FILES["file"]["name"]) && $_FILES["file"]["type"] == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
			// upload
			$file_tmp = $_FILES['file']['tmp_name'];
			$file_name = $_FILES['file']['name'];
			$file_size = $_FILES['file']['size'];
			$file_type = $_FILES['file']['type'];
			// move_uploaded_file($file_tmp,"uploads/".$file_name); // simpan filenya di folder uploads

			$object = PHPExcel_IOFactory::load($file_tmp);

			foreach ($object->getWorksheetIterator() as $worksheet) {

				$highestRow = $worksheet->getHighestRow();
				$highestColumn = $worksheet->getHighestColumn();
				for ($row = 2; $row <= $highestRow; $row++) {
					//set data excel ke variabel
					//getCellByColumnAndRow(1, $row)->getValue()=>ambil nilai dr baris x dan kolom y y dimulai dr 0 untuk kolom a di excel
					if (!empty($worksheet->getCellByColumnAndRow(1, $row)->getValue())) {
						$bulan = $this->input->post('bulan');
						$tahun = $this->input->post('tahun');
						$jenis = $this->input->post('jenis_potongan');
						$nid = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
						$dtpeg = $this->gaji_model->pegawai_person($nid)->row();
						$jml = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
						$keterangan = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
						$unit = $dtpeg->skpd;
						//set data ke array
						$data[] = array(
							'nip' => $nid,
							'bulan' => $bulan,
							'tahun' => $tahun,
							'jml' => $jml,
							'id_unit' => $unit,
							'nama_potongan' => $jenis,
							'ket' => $keterangan,
						);
					}
				}
			}
			$this->db->insert_batch('tbRwPotongan', $data);

			$this->session->set_flashdata('errMsg', 'Import Data Potongan Gaji Sukses');

			redirect('gaji/potongan');
		} else {
			$this->session->set_flashdata('errMsg2', 'Import Data Potongan Gaji Gagal');
			redirect('gaji/potongan');
		}
	}

	function Edit($id)
	{
		$gaji = $this->db->get_where('tbRwGaji', array('id' => $id))->row();
		$pegawai = $this->db->get_where('tbPegawai', array('nipBaru' => $gaji->nip))->row();
		$potongan = $this->db->get_where('tbRwPotongan', array('nip' => $gaji->nip, 'bulan' => $gaji->bulan, 'tahun' => $gaji->tahun))->result();
		$tunjangan = $this->db->get_where('tbRwTunjangan', array('nip' => $gaji->nip, 'bulan' => $gaji->bulan, 'tahun' => $gaji->tahun))->result();
		$data['gaji'] = $gaji;
		$data['pegawai'] = $pegawai;
		$data['potongan'] = $potongan;
		$data['tunjangan'] = $tunjangan;
		$data['bc'] = array('Dashboard' => site_url('dashboard'), 'Data Penggajian' => site_url('gaji'), 'Edit' => site_url("gaji/Edit/$id"));
		$data['title'] = "Data Penggajian";
		$data['unitKerja'] = $this->db->get_where('tbSatKerja', array('id' => $pegawai->skpd))->row();
		$data['jabatan'] = $this->db->get_where('tbJabatan', array('idJabatan' => $pegawai->idJabatan))->row();
		$data['kelas'] = $this->db->get_where('tbKelasJabatan', array('id' => $pegawai->kelasJabatan))->row();
		$data['id'] = $id;
		$this->template->mainview('gaji/gaji_edit', $data);
	}

	function Simpan_tunjangan($id, $idGaji)
	{
		$data = $_POST;
		if ($id == 0) {
			$this->db->insert('tbRwTunjangan', $data);
		} else {
			$this->db->update('tbRwTunjangan', $data, array('id' => $id));
		}
		redirect(site_url('gaji/Edit/' . $idGaji));
	}

	function Simpan_potongan($id, $idGaji)
	{
		$data = $_POST;
		if ($id == 0) {
			$this->db->insert('tbRwPotongan', $data);
		} else {
			$this->db->update('tbRwPotongan', $data, array('id' => $id));
		}
		redirect(site_url('gaji/Edit/' . $idGaji));
	}

	function Simpan_edit($id)
	{
		$this->db->update('tbRwGaji', $_POST, array('id' => $id));
		redirect(site_url('gaji'));
	}

	function Del_tunjangan($id, $idGaji)
	{
		$this->db->delete('tbRwTunjangan', array('id' => $id));
		redirect(site_url('gaji/Edit/' . $idGaji));
	}

	function Del_potongan($id, $idGaji)
	{
		$this->db->delete('tbRwPotongan', array('id' => $id));
		redirect(site_url('gaji/Edit/' . $idGaji));
	}

	function hitung_ulang($nip, $bulan, $tahun)
	{
		// if ($bulan == '01') {
		// 	$hitBulan = 12;
		// 	$hitTahun = $tahun - 1;
		// } else {
		// 	$hitBulan = $bulan - 1;
		// 	$hitTahun = $tahun;
		// }

		$hitBulan = intval($bulan);
		$hitTahun = intval($tahun);

		$peg = $this->db->get_where('tbPegawai', array('nipBaru' => $nip))->row();

		$idPegawai = $peg->idtbPegawai;
		$tunjanganTetap = $peg->tunjanganTetap;
		$idJabatan = $peg->idJabatan;
		$kelas = $peg->kelasJabatan;
		$gaji = $peg->gaji;
		$nip = $peg->nipBaru;
		$totTunj = 0;
		$totPot = 0;
		$idContact = $peg->idelektronik;
		$satkerja = $peg->skpd;
		//1. hapus semua tunjangan dan potongan
		$this->db->query("DELETE FROM tbRwTunjangan WHERE nip = '$nip' AND bulan = '$bulan' AND tahun = '$tahun' and kode_tunjangan > 0");
		//$this->db->delete('tbRwTunjangan', array('nip' => $nip, 'bulan' => $bulan, 'tahun' => $tahun,'kode_tunjangan'=> '> 0'));	
		$this->db->query("DELETE FROM tbRwPotongan WHERE nip = '$nip' AND bulan = '$bulan' AND tahun = '$tahun' AND jenis_potongan > 0");
		//$this->db->delete('tbRwPotongan', array('nip' => $nip, 'bulan' => $bulan, 'tahun' => $tahun,'jenis_potongan'=> '> 0'));
		//1. cari hari kerja
		$dtKehadiran = $this->gaji_model->GetKehadiran($idContact, $hitBulan, $hitTahun)->row();
		if (isset($dtKehadiran)) {
			$jmlHadir = $dtKehadiran->jml;
		} else {
			$jmlHadir = 0;
		}

		//buat perhitungan tunjangan masa kerja khusus karyawan PKWTT
		if ($peg->jenisPegawai == 'PKWTT') {
			$nilaiUmp = $this->db->get_where('tbUmp', array('tahun' => date('Y')))->row()->nilai_ump;
			$masaKerja = date_diff(date_create($peg->tglBergabung), date_create(date('Y-m-d')));
			$lamaKerja = floor($masaKerja->format("%a") / 365); // Convert days to years
			if ($lamaKerja >= 2 && $lamaKerja < 5) {
				$tmk = $nilaiUmp * 0.01;
			} else if ($lamaKerja >= 5 && $lamaKerja < 8) {
				$tmk = $nilaiUmp * 0.02;
			} else if ($lamaKerja >= 8 && $lamaKerja < 11) {
				$tmk = $nilaiUmp * 0.03;
			} else if ($lamaKerja >= 11) {
				$tmk = $nilaiUmp * 0.05;
			} else {
				$tmk = 0;
			}
			if ($tmk > 0) {
				$dTunj['nip'] = $nip;
				$dTunj['bulan'] = $bulan;
				$dTunj['tahun'] = $tahun;
				$dTunj['id_unit'] = $satkerja;
				$dTunj['kode_tunjangan'] = 0;
				$dTunj['nama_tunjangan'] = "T.Masa Kerja";
				$dTunj['ket'] = "";
				$dTunj['khusus'] = 1;
				$dTunj['jml'] = $tmk;
				$this->db->delete('tbRwTunjangan', array('nip' => $nip, 'bulan' => $bulan, 'tahun' => $tahun, 'nama_tunjangan' => 'T.Masa Kerja', 'khusus' => 1));
				$this->db->insert('tbRwTunjangan', $dTunj);
			}
			
		}

		//2. Cari total tunjangan
		$dtTunjangan = $this->db->get_where('tbTunjangan', array('skpd' => $satkerja, 'idKelasJabatan' => $kelas, 'idJabatan' => $idJabatan))->result();

		foreach ($dtTunjangan as $tunj) {
			$dTunj['nip'] = $nip;
			$dTunj['bulan'] = $bulan;
			$dTunj['tahun'] = $tahun;
			$dTunj['id_unit'] = $satkerja;
			$dTunj['kode_tunjangan'] = $tunj->id;
			$dTunj['nama_tunjangan'] = $tunj->namaTunjangan;
			$dTunj['ket'] = "";
			if ($tunj->satuan == "Hari") {
				$dTunj['jml'] = $tunj->nilai * $jmlHadir;
				$dTunj['ket'] = $jmlHadir . " hari";
			} elseif ($tunj->satuan == "Bulan") {
				$dTunj['jml'] = $tunj->nilai;
			} else {
				$dTunj['jml'] = 0;
				$dTunj['ket'] = "tdk dapat dihitung";
			}
			$dTunj['khusus'] = 0;
			$this->db->delete('tbRwTunjangan', array('nip' => $nip, 'bulan' => $bulan, 'tahun' => $tahun, 'nama_tunjangan' => $tunj->namaTunjangan));
			$this->db->insert('tbRwTunjangan', $dTunj);
		}

		//3. cari tunjangan khusus
		$dtTunjKhusus = $this->db->get_where('tbTunjanganKhusus', array('idtbPegawai' => $idPegawai))->result();

		foreach ($dtTunjKhusus as $tunjK) {
			$dTunj['nip'] = $nip;
			$dTunj['bulan'] = $bulan;
			$dTunj['tahun'] = $tahun;
			$dTunj['id_unit'] = $satkerja;
			$dTunj['kode_tunjangan'] = $tunjK->id;
			$dTunj['nama_tunjangan'] = $tunjK->namaTunjangan;
			$dTunj['ket'] = "";
			if ($tunjK->satuan == "Hari") {
				$dTunj['jml'] = $tunjK->nilai * $jmlHadir;
				$dTunj['ket'] = $jmlHadir . " hari";
			} elseif ($tunjK->satuan == "Bulan") {
				$dTunj['jml'] = $tunjK->nilai;
			} else {
				$dTunj['jml'] = 0;
				$dTunj['ket'] = "tdk dapat dihitung";
			}
			$dTunj['khusus'] = 1;
			$this->db->delete('tbRwTunjangan', array('nip' => $nip, 'bulan' => $bulan, 'tahun' => $tahun, 'nama_tunjangan' => $tunjK->namaTunjangan));
			$this->db->insert('tbRwTunjangan', $dTunj);
		}

		//4. cari total lemburan
		$dtLembur = $this->gaji_model->GetLemburan($idPegawai, $hitBulan, $hitTahun)->result();
		$totalLembur = 0;
		$totalUangMakan = 0;
		foreach ($dtLembur as $lembur) {
			$totalLembur = $totalLembur + $lembur->nilai;
			$totalUangMakan = $totalUangMakan + $lembur->uangMakan;
		}
		if ($totalLembur > 0) {
			$dTunj['nip'] = $nip;
			$dTunj['bulan'] = $bulan;
			$dTunj['tahun'] = $tahun;
			$dTunj['id_unit'] = $satkerja;
			$dTunj['kode_tunjangan'] = '0';
			$dTunj['nama_tunjangan'] = 'Kerja Lebih';
			$dTunj['jml'] = $totalLembur;
			$dTunj['khusus'] = 1;
			$this->db->delete('tbRwTunjangan', array('nip' => $nip, 'bulan' => $bulan, 'tahun' => $tahun, 'nama_tunjangan' => 'Kerja Lebih', 'khusus' => 1));
			$this->db->delete('tbRwTunjangan', array('nip' => $nip, 'bulan' => $bulan, 'tahun' => $tahun, 'nama_tunjangan' => 'Uang Makan Kerja Lebih', 'khusus' => 1));
			$this->db->insert('tbRwTunjangan', $dTunj);
			$dTunj['nip'] = $nip;
			$dTunj['bulan'] = $bulan;
			$dTunj['tahun'] = $tahun;
			$dTunj['id_unit'] = $satkerja;
			$dTunj['kode_tunjangan'] = '0';
			$dTunj['nama_tunjangan'] = 'Uang Makan Kerja Lebih';
			$dTunj['jml'] = $totalUangMakan;
			$dTunj['khusus'] = 1;
			if ($totalUangMakan > 0) {
				$this->db->insert('tbRwTunjangan', $dTunj);
			}
		}

		


		//7. cari total potongan
		$dtPotongan = $this->db->get_where('tbPotongan', array('skpd' => $satkerja, 'idKelasJabatan' => $kelas, 'idJabatan' => $idJabatan))->result();
		foreach ($dtPotongan as $pot) {
			$dPot['nip'] = $nip;
			$dPot['bulan'] = $bulan;
			$dPot['tahun'] = $tahun;
			$dPot['id_unit'] = $satkerja;
			$dPot['jenis_potongan'] = $pot->id;
			$dPot['nama_potongan'] = $pot->namaPotongan;
			$dPot['ket'] = "";
			if ($pot->satuan == "Bulan") {
				$dPot['jml'] = $pot->nilai;
			} elseif ($pot->satuan == "%Gaji") {
				$dPot['jml'] = $pot->nilai * $gaji / 100;
			} else {
				$dPot['jml'] = 0;
				$dPot['ket'] = "tdk dapat dihitung";
			}
			$dPot['khusus'] = 0;
			$this->db->delete('tbRwPotongan', array('nip' => $nip, 'bulan' => $bulan, 'tahun' => $tahun, 'nama_potongan' => $pot->namaPotongan));
			$this->db->insert('tbRwPotongan', $dPot);
		}

		//8. cari potongan khusus
		$dtPotKhusus = $this->db->get_where('tbPotonganKhusus', array('idtbPegawai' => $idPegawai))->result();
		foreach ($dtPotKhusus as $potK) {
			$dPot['nip'] = $nip;
			$dPot['bulan'] = $bulan;
			$dPot['tahun'] = $tahun;
			$dPot['id_unit'] = $satkerja;
			$dPot['jenis_potongan'] = $potK->id;
			$dPot['nama_potongan'] = $potK->namaPotongan;
			$dPot['ket'] = "";
			if ($potK->satuan == "%Gaji") {
				$dPot['jml'] = $potK->nilai * $gaji / 100;
				$dPot['ket'] = $potK->nilai . "dari gaji";
			} elseif ($potK->satuan == "Bulan") {
				$dPot['jml'] = $potK->nilai;
			} else {
				$dPot['jml'] = 0;
				$dPot['ket'] = "tdk dapat dihitung";
			}
			$dPot['khusus'] = 1;
			$this->db->delete('tbRwPotongan', array('nip' => $nip, 'bulan' => $bulan, 'tahun' => $tahun, 'nama_potongan' => $potK->namaPotongan));
			$this->db->insert('tbRwPotongan', $dPot);
		}

		
			

			
			
			
		//9. proses ke table penggajian
		//9.1. cek di table tbRwGaji apakah sudah ada datanya
		$cekGaji = $this->db->get_where('tbRwGaji', array('nip' => $nip, 'bulan' => $bulan, 'tahun' => $tahun))->result();
		if (count($cekGaji) > 0) {
			//sdh ada data
			$this->db->update('tbRwGaji', array('gaji_pokok' => $gaji, 'id_unit' => $satkerja), array('id' => $cekGaji[0]->id));
		} else {
			//blm ada data
			$dtGaji['nip'] = $nip;
			$dtGaji['bulan'] = $bulan;
			$dtGaji['tahun'] = $tahun;
			$dtGaji['gaji_pokok'] = $gaji;
			$dtGaji['id_unit'] = $satkerja;
			$this->db->insert('tbRwGaji', $dtGaji);
		}
		redirect(site_url('gaji'));
	}

	function hitung_premishift($satkerja)
	{
		$bulan = $this->session->userdata('filter_bulan');
		$tahun = $this->session->userdata('filter_tahun');

		// if ($bulan == '01') {
		// 	$hitBulan = 12;
		// 	$hitTahun = $tahun - 1;
		// } else {
		// 	$hitBulan = $bulan - 1;
		// 	$hitTahun = $tahun;
		// }

		$hitBulan = intval($bulan);
		$hitTahun = intval($tahun);
		$pegawai = $this->gaji_model->pegawai_premishift($satkerja)->result();

		//cari nilai premishift dari tabel tbRwPremishift
		foreach ($pegawai as $peg) {
			$total = 0;
			$nip = $peg->nipBaru;
			$idPegawai = $peg->idtbPegawai;
			//cari nilai premishft dari table plotshift
			$jadwal = $this->db->get_where('tbRwPremishift',array('nip'=>$nip,'bulan'=>$hitBulan,'tahun'=>$hitTahun))->row();

			if (isset($jadwal)) {
				$total = $jadwal->p01 + $jadwal->p02 + $jadwal->p03 + $jadwal->p04 + $jadwal->p05 + $jadwal->p06 + $jadwal->p07 + $jadwal->p08 + $jadwal->p09 + $jadwal->p10 + $jadwal->p11 + $jadwal->p12 + $jadwal->p13 + $jadwal->p14 + $jadwal->p15 + $jadwal->p16 + $jadwal->p17 + $jadwal->p18 + $jadwal->p19 + $jadwal->p20 + $jadwal->p21 + $jadwal->p22 + $jadwal->p23 + $jadwal->p24 + $jadwal->p25 + $jadwal->p26 + $jadwal->p27 + $jadwal->p28 + $jadwal->p29 + $jadwal->p30 + $jadwal->p31;
			} else {
				$total = 0;
			}
			
			//6. cari total premishift
			$premishift = $this->gaji_model->get_premi_shift($idPegawai, $hitBulan, $hitTahun)->result();
			$this->db->delete('tbRwTunjangan', array('nip' => $nip, 'bulan' => $bulan, 'tahun' => $tahun, 'nama_tunjangan' => 'Pengganti premi shift', 'khusus' => 1));
			if (count($premishift) > 0) {
				$dTunj['nip'] = $nip;
				$dTunj['bulan'] = $bulan;
				$dTunj['tahun'] = $tahun;
				$dTunj['id_unit'] = $satkerja;
				$dTunj['kode_tunjangan'] = '0';
				$dTunj['nama_tunjangan'] = 'Pengganti premi shift';
				$dTunj['jml'] = $premishift[0]->jml + $premishift[0]->jml_tunjangan;
				$dTunj['khusus'] = 1;
				if ($dTunj['jml'] > 0) {
					$this->db->insert('tbRwTunjangan', $dTunj);
				}
			}

			$potshift = $this->gaji_model->get_pot_premi_shift($idPegawai, $hitBulan, $hitTahun)->result();
			$this->db->delete('tbRwPotongan', array('nip' => $nip, 'bulan' => $bulan, 'tahun' => $tahun, 'nama_potongan' => 'Pot premi Shift', 'khusus' => 1));
			if (count($potshift) > 0) {	
				$dPot['nip'] = $nip;
				$dPot['bulan'] = $bulan;
				$dPot['tahun'] = $tahun;
				$dPot['id_unit'] = $satkerja;
				$dPot['jenis_potongan'] = '0';
				$dPot['nama_potongan'] = 'Pot premi Shift';
				$dPot['jml'] = $potshift[0]->jml;
				$dPot['khusus'] = 1;
				if ($dPot['jml'] > 0) {
					$this->db->insert('tbRwPotongan', $dPot);
				}
			}

			$this->db->delete('tbRwTunjangan', array('nip' => $nip, 'bulan' => $bulan, 'tahun' => $tahun, 'nama_tunjangan' => 'Premi shift', 'khusus' => 1));
			if ($total > 0) {
				$dTunj['nip'] = $nip;
				$dTunj['bulan'] = $bulan;
				$dTunj['tahun'] = $tahun;
				$dTunj['id_unit'] = $satkerja;
				$dTunj['kode_tunjangan'] = '0';
				$dTunj['nama_tunjangan'] = 'Premi shift';
				$dTunj['jml'] = $total;
				$dTunj['khusus'] = 1;
				$this->db->insert('tbRwTunjangan', $dTunj);
			}

		}

		redirect(site_url('gaji/hitung'));
	}

	function GetListTunjangan()
	{
		$unit = $_POST['unit'];
		$bulan = $_POST['bulan'];
		$tahun = $_POST['tahun'];
		$rs = $this->db->query("SELECT nama_tunjangan FROM tbRwTunjangan WHERE bulan=$bulan AND tahun=$tahun AND id_unit=$unit GROUP BY nama_tunjangan");
		echo json_encode($rs->result_array());
	}

	function GetPegawaiUnit()
	{
		$unit = $_POST['unit'];
		$rs = $this->gaji_model->pegawai_unit($unit);
		echo json_encode($rs->result_array());
	}

	function del_item_tunjangan()
	{
		$id = $this->input->post('idHapus');
		$this->db->delete('tbRwTunjangan', array('id' => $id));
		redirect(site_url('gaji/tunjangan'));
	}

	function del_item_tunjangan_all()
	{
		$data['bulan'] = $this->input->post('bulan');
		$data['tahun'] = $this->input->post('tahun');
		$data['id_unit'] = $this->input->post('unit');
		$data['nama_tunjangan'] = $this->input->post('tunjangan');
		$this->db->delete('tbRwTunjangan', $data);
		redirect(site_url('gaji/tunjangan'));
	}

	function simpan_item_tunjangan()
	{
		$id = $this->input->post('id');
		$data['bulan'] = $this->input->post('bln');
		$data['tahun'] = $this->input->post('thn');
		$data['nip'] = $this->input->post('nip');
		$data['nama_tunjangan'] = $this->input->post('nama_tunjangan');
		$data['jml'] = $this->input->post('jml');
		$data['id_unit'] = $this->input->post('id_unit');
		$data['ket'] = $this->input->post('ket');
		if ($id == 0) {
			//insert baru
			$data['kode_tunjangan'] = 0;
			$data['khusus'] = 1;
			$this->db->insert('tbRwTunjangan', $data);
		} else {
			//edit
			$this->db->update('tbRwTunjangan', $data, array('id' => $id));
		}
		redirect(site_url('gaji/tunjangan'));
	}

	public function import_tunjangan()
	{
		if ((isset($_FILES["file"]["name"])) && $_FILES["file"]["type"] == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
			// upload
			$file_tmp = $_FILES['file']['tmp_name'];
			$file_name = $_FILES['file']['name'];
			$file_size = $_FILES['file']['size'];
			$file_type = $_FILES['file']['type'];
			// move_uploaded_file($file_tmp,"uploads/".$file_name); // simpan filenya di folder uploads

			$object = PHPExcel_IOFactory::load($file_tmp);

			foreach ($object->getWorksheetIterator() as $worksheet) {

				$highestRow = $worksheet->getHighestRow();
				$highestColumn = $worksheet->getHighestColumn();
				$count=0;
				for ($row = 6; $row <= $highestRow; $row++) {
					$nid = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
					$jml = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
					$ket = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
					//set data ke array
					if (trim($nid)!= '') {
						$this->db->delete('tbRwTunjangan',array('tahun' => $this->input->post('thn'),'bulan'=>$this->input->post('bln'), 'nama_tunjangan' => $this->input->post('nama_tunjangan'),'nip'=>$nid));
						$peg = $this->gaji_model->unit_pegawai($nid)->result_array();

						//jika data pegawai ditemukan
						if (count($peg)>0)
						{
							$unit=$peg[0]['skpd']; 
							$data[] = array(
								'bulan' => $this->input->post('bln'),
								'tahun' => $this->input->post('thn'),
								'id_unit' => $unit,
								'nama_tunjangan' => $this->input->post('nama_tunjangan'),
								'kode_tunjangan' => 0,
								'khusus' => 1,
								'nip' => $nid,
								'jml' => $jml,
								'ket' => $ket,
							);
							$dt[] = array(
								'nip' => $peg[0]['nipBaru'],
								'nama' => $peg[0]['namaPegawai'],
								'unit' => $peg[0]['nama'],
								'jml' => $jml,
								'ket' => $ket,
								'status' => 'Sukses' 
							);
							$count=$count+1;
						}
						else 
						{
							$dt[] = array(
								'nip' => $nid,
								'nama' => 'NIP tidak dikenali atau pegawai sdh tidak aktif',
								'unit' => '',
								'jml' => $jml,
								'ket' => $ket,
								'status' => 'Gagal' 
							);
						}
					}
					else
					{
						$dt[] = array(
							'nip' => '',
							'nama' => 'kolom NIP kosong / baris kosong dalam excel',
							'unit' => '',
							'jml' => $jml,
							'ket' => $ket,
							'status' => 'Gagal' 
						);
					}
				}
			}
			if(count($data)>0)
			{
			$this->db->insert_batch('tbRwTunjangan', $data);
			$this->session->set_flashdata('errMsg', 'Data Tunjangan telah sukses di import'.$count.' Data');
			}
			else
			{
				$this->session->set_flashdata('errMsg', 'Import Data potongan Gagal');
			}
			$fData['dt'] = $dt;
			$fData['bc'] = array('Dashboard' => site_url('dashboard'), 'Data Penggajian' => site_url('gaji'), 'Potongan' => site_url('gaji/potongan'), 'Hasil Import'=>'#');
			$fData['title'] = "";
			$fData['kembali'] = "tunjangan";
			$this->template->mainview('gaji/gaji_hasil_import', $fData);
		} else {

			$this->session->set_flashdata('errMsg', 'Import Data tunjangan Gagal');
			redirect('gaji/tunjangan');
		}
	}

	function GetListPotongan()
	{
		$unit = $_POST['unit'];
		$bulan = $_POST['bulan'];
		$tahun = $_POST['tahun'];
		$rs = $this->db->query("SELECT nama_potongan FROM tbRwPotongan WHERE bulan=$bulan AND tahun=$tahun AND id_unit=$unit GROUP BY nama_potongan");
		echo json_encode($rs->result_array());
	}

	function simpan_item_potongan()
	{
		if ($this->input->post('nip') == "-- Pilih Nama Pegawai --") {
			$this->session->set_flashdata('nama pesan', 'isi pesan');
			redirect(site_url('gaji/potongan'));
		} else {
			$id = $this->input->post('id');
			$data['bulan'] = $this->input->post('bln');
			$data['tahun'] = $this->input->post('thn');
			$data['nip'] = $this->input->post('nip');
			$data['nama_potongan'] = $this->input->post('nama_potongan');
			$data['jml'] = $this->input->post('jml');
			$data['id_unit'] = $this->input->post('id_unit');
			$data['ket'] = $this->input->post('ket');
			if ($id == 0) {
				//insert baru
				$data['jenis_potongan'] = 0;
				$data['khusus'] = 1;
				$this->db->insert('tbRwPotongan', $data);
			} else {
				//edit
				$this->db->update('tbRwPotongan', $data, array('id' => $id));
			}
			redirect(site_url('gaji/potongan'));
		}
	}

	function del_item_potongan_all()
	{
			$data['bulan'] = $this->input->post('bulan');
			$data['tahun'] = $this->input->post('tahun');
			$data['id_unit'] = $this->input->post('unit');
			$data['nama_potongan'] = $this->input->post('potongan');
			$this->db->delete('tbRwPotongan', $data);
			redirect(site_url('gaji/potongan'));
	}


	function del_item_potongan()
	{
		$id = $this->input->post('idHapus');
		$this->db->delete('tbRwPotongan', array('id' => $id));
		redirect(site_url('gaji/potongan'));
	}

	public function import_potongan()
	{
		if ((isset($_FILES["file"]["name"])) && $_FILES["file"]["type"] == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
			// upload
			$file_tmp = $_FILES['file']['tmp_name'];
			$file_name = $_FILES['file']['name'];
			$file_size = $_FILES['file']['size'];
			$file_type = $_FILES['file']['type'];
			// move_uploaded_file($file_tmp,"uploads/".$file_name); // simpan filenya di folder uploads

			$object = PHPExcel_IOFactory::load($file_tmp);

			foreach ($object->getWorksheetIterator() as $worksheet) {

				$highestRow = $worksheet->getHighestRow();
				$highestColumn = $worksheet->getHighestColumn();
				$count=0;
				
				for ($row = 6; $row <= $highestRow; $row++) {
					$nid = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
					$jml = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
					$ket = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
					if (trim($nid) != "" ) {								
						$this->db->delete('tbRwPotongan',array('tahun' => $this->input->post('thn'),'bulan'=>$this->input->post('bln'), 'nama_potongan' => $this->input->post('nama_potongan'),'nip'=>$nid));
						$peg = $this->gaji_model->unit_pegawai($nid)->result_array();
						
						

						//jika data pegawai ditemukan
						if (count($peg)>0) {
							
							$unit = $peg[0]['skpd'];
							$data[] = array(
								'bulan' => $this->input->post('bln'),
								'tahun' => $this->input->post('thn'),
								'id_unit' => $unit,
								'nama_potongan' => $this->input->post('nama_potongan'),
								'jenis_potongan' => 0,
								'khusus' => 1,
								'nip' => $peg[0]['nipBaru'],
								'jml' => $jml,
								'ket' => $ket,
							);
							$dt[] = array(
								'nip' => $peg[0]['nipBaru'],
								'nama' => $peg[0]['namaPegawai'],
								'unit' => $peg[0]['nama'],
								'jml' => $jml,
								'ket' => $ket,
								'status' => 'Sukses' 
							);

						$count=$count+1;
						} else {
							$dt[] = array(
								'nip' => $nid,
								'nama' => 'NIP tidak dikenali atau pegawai sdh tidak aktif',
								'unit' => '',
								'jml' => $jml,
								'ket' => $ket,
								'status' => 'Gagal' 
							);
						}
					} else {
						$dt[] = array(
							'nip' => '',
							'nama' => 'kolom NIP kosong / baris kosong dalam excel',
							'unit' => '',
							'jml' => $jml,
							'ket' => $ket,
							'status' => 'Gagal' 
						);
					}
				}
				//echo "</table>";
			}
			if(count($data)>0)
			{
				$this->db->insert_batch('tbRwPotongan', $data);
				$this->session->set_flashdata('errMsg', 'Data Potongan gaji telah sukses di import '.$count.' Data');
			}
			else
			{
				$this->session->set_flashdata('errMsg', 'Import Data potongan Gagal');
			}
			$fData['dt'] = $dt;
			$fData['bc'] = array('Dashboard' => site_url('dashboard'), 'Data Penggajian' => site_url('gaji'), 'Potongan' => site_url('gaji/potongan'), 'Hasil Import'=>'#');
			$fData['title'] = "";
			$fData['kembali'] = "potongan";
			$this->template->mainview('gaji/gaji_hasil_import', $fData);
		} else {

			$this->session->set_flashdata('errMsg', 'Import Data potongan Gagal');
			redirect('gaji/potongan');
		}
	}

	function test()
	{
		$nid="8223673.K";
		$peg = $this->gaji_model->unit_pegawai($nid)->row();
		//echo var_dump($peg);
		//echo $peg[0]['nipBaru'];
		echo count($peg);
		
	}
}
