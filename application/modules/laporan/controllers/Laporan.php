<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Laporan extends Member_Control
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url'));
		$this->load->model(array('Laporan_model'));
	}

	function index()
	{
		return $this->show();
	}

	function show()
	{
		$bulan = $this->session->userdata('filter_bulan');
		$tahun = $this->session->userdata('filter_tahun');
		$sess['filter_bulan'] = $bulan;
		$sess['filter_tahun'] = $tahun;
		$this->session->set_userdata($sess);
		$data['bc'] = array('Laporan' => site_url('laporan'), 'Laporan Pilih' => site_url('Laporan'));
		$data['title'] = "Pilih Laporan";
		$this->template->mainview('laporan/laporan_pilih', $data);
	}

	function pilih()
	{
		$bulan = $this->input->post('bulan');
		$tahun =  $this->input->post('tahun');
		$laporan = $this->input->post('laporan');
		$sess['filter_bulan'] = $bulan;
		$sess['filter_tahun'] = $tahun;
		$this->session->set_userdata($sess);
		switch ($bulan) {
			case "01":
				$b = "January";
				break;
			case "02":
				$b = "Febuary";
				break;
			case "03":
				$b = "March";
				break;
			case "04":
				$b = "April";
				break;
			case "05":
				$b = "May";
				break;
			case "06":
				$b = "June";
				break;
			case "07":
				$b = "July";
				break;
			case "08":
				$b = "August";
				break;
			case "09":
				$b = "September";
				break;
			case "10":
				$b = "October";
				break;
			case "11":
				$b = "November";
				break;
			case "12":
				$b = "December";
				break;
		}
		switch ($laporan) {
			case "A":
				$data['bln'] = $bulan;
				$data['thn'] = $tahun;
				//$data['bc']		= array('Laporan' => site_url('laporan'), 'Laporan Rekap Gaji Per Jabatan' => site_url('Laporan'));
				$data['title'] 	= "Laporan Rekap Gaji Per Jabatan Bulan " . $b . ' ' . $tahun;
				$data['kolom'] = $this->Laporan_model->kolom_a($sess['filter_bulan'], $sess['filter_tahun'])->result_array();
				$data['dt'] 	= $this->Laporan_model->lap_jabatan($this->session->filter_bulan, $this->session->filter_tahun)->result_array();
				$data['unit']	= $this->Laporan_model->jabatan()->result();
				$this->load->view('laporan/laporan_gaji_jabatan', $data);
				break;
			case "B":
				$data['bln'] = $bulan;
				$data['thn'] = $tahun;
				$data['bc'] = array('Laporan' => site_url('laporan'), 'Laporan Rekap Gaji Per Unit' => site_url('Laporan'));
				$data['title'] = "Laporan Rekap Gaji Per Unit Bulan " . $b . ' ' . $tahun;
				$data['kolom'] = $this->Laporan_model->kolom_a($sess['filter_bulan'], $sess['filter_tahun'])->result_array();
				$data['dt'] 	= $this->Laporan_model->lap_unit($this->session->filter_bulan, $this->session->filter_tahun)->result_array();
				$data['unit']	= $this->Laporan_model->unit_kerja()->result();
				$this->load->view('laporan/laporan_gaji_unit', $data);
				break;
			case "C":
				$data['bln'] = $bulan;
				$data['thn'] = $tahun;
				$data['bc'] = array('Laporan' => site_url('laporan'), 'Laporan Rekap Gaji' => site_url('Laporan'));
				$data['title'] = "Laporan Rekap Gaji Bulan " . $b . ' ' . $tahun;
				$data['dt'] = $this->Laporan_model->dana($bulan, $tahun)->result();
				$this->load->view('laporan/laporan_gaji_all', $data);
				break;
			case "D":
				$data['bln'] = $bulan;
				$data['thn'] = $tahun;
				$data['bc'] = array('Laporan' => site_url('laporan'), 'Laporan Rekap Gaji Per TKK' => site_url('Laporan'));
				$data['title'] = "Laporan Rekap Gaji TKK Bulan " . $b . ' ' . $tahun;
				$data['dt'] = $this->Laporan_model->tkk_jabatan($bulan, $tahun)->result();
				$this->load->view('laporan/laporan_gaji_tkk', $data);
				break;
			case "E":
				$data['bln'] = $bulan;
				$data['thn'] = $tahun;
				$data['bc'] = array('Laporan' => site_url('laporan'), 'Laporan Rekap Gaji Per Jabatan' => site_url('Laporan'));
				$data['title'] = "Laporan Rekap Gaji TKK Per Unit<br>Bulan " . $b . ' ' . $tahun;
				$data['kolom'] = $this->Laporan_model->kolom_tkk($bulan, $tahun)->result();
				$data['dt'] = $this->Laporan_model->tkk_unit($bulan, $tahun)->result();
				$this->load->view('laporan/laporan_gaji_tkk_unit', $data);
				break;
			case "F":
				$data['bln'] = $bulan;
				$data['thn'] = $tahun;
				$data['title'] 	= "Laporan Rekap Gaji Keseluruhan " . $b . ' ' . $tahun;
				$data['dt'] 	= $this->Laporan_model->pegawai()->result();
				//bersihkan table temporary dulu
				$this->db->delete('tbRekapGaji', array('nik<>' => ''));

				//cari tunjangan dan potongan di bulan tsb untuk menentukan nama/header kolom jenis2 tunjangan dan potongan
				$dtTunjangan = $this->Laporan_model->get_tunjangan($bulan, $tahun)->result();
				$dtPotongan = $this->Laporan_model->get_potongan($bulan, $tahun)->result();

				//insert data sebagai judul kolom
				$dt['nik'] = 'NIK';
				$dt['nama'] = 'NAMA';
				$dt['jabatan'] = 'JABATAN';
				$dt['gaji_pokok'] = 'GAJI POKOK';
				$dt['unit_kerja'] = 'UNIT';
				$dt['tunj_tetap'] = 'Tunjangan Tetap';
				$f = 1;
				foreach ($dtTunjangan as $tunj) {
					if ($tunj->nama_tunjangan != 'Tunjangan Tetap') {
						$dt['f' . $f] = $tunj->nama_tunjangan;
						$f++;
					}
				}
				$dt['f' . $f] = 'GAJI KOTOR';
				$f++;
				foreach ($dtPotongan as $pot) {
					$dt['f' . $f] = $pot->nama_potongan;
					$f++;
				}
				$dt['f' . $f] = 'Total Potongan';
				$f++;
				$dt['f' . $f] = 'GAJI TOTAL';
				$this->db->insert('tbRekapGaji', $dt);
				redirect(site_url('laporan/hitung_rekap/' . $bulan . '/' . $tahun . '/1'));
				//$this->load->view('laporan/rekap_gaji_semua', $data);
				break;
			case "G":
					$data['bln'] = $bulan;
					$data['thn'] = $tahun;
					$data['title'] 	= "Laporan Rekap Gaji Keseluruhan " . $b . ' ' . $tahun;
					$data['dt'] 	= $this->Laporan_model->pegawai()->result();
					//bersihkan table temporary dulu
					$this->db->delete('tbRekapGaji', array('nik<>' => ''));
	
					//cari tunjangan dan potongan di bulan tsb untuk menentukan nama/header kolom jenis2 tunjangan dan potongan
					$dtTunjangan = $this->Laporan_model->get_tunjangan($bulan, $tahun)->result();
					$dtPotongan = $this->Laporan_model->get_potongan($bulan, $tahun)->result();
	
					//insert data sebagai judul kolom
					$dt['nik'] = 'NIK';
					$dt['nama'] = 'NAMA';
					$dt['jabatan'] = 'JABATAN';
					$dt['gaji_pokok'] = 'GAJI POKOK';
					$dt['unit_kerja'] = 'UNIT';
					$dt['tunj_tetap'] = 'Tunjangan Tetap';
					$f = 1;
					foreach ($dtTunjangan as $tunj) {
						if ($tunj->nama_tunjangan != 'Tunjangan Tetap') {
							$dt['f' . $f] = $tunj->nama_tunjangan;
							$f++;
						}
					}
					$dt['f' . $f] = 'GAJI KOTOR';
					$f++;
					foreach ($dtPotongan as $pot) {
						$dt['f' . $f] = $pot->nama_potongan;
						$f++;
					}
					$dt['f' . $f] = 'Total Potongan';
					$f++;
					$dt['f' . $f] = 'GAJI TOTAL';
					$this->db->insert('tbRekapGaji', $dt);
					redirect(site_url('laporan/hitung_minus/' . $bulan . '/' . $tahun . '/1'));
					//$this->load->view('laporan/rekap_gaji_semua', $data);
					break;
			case "H":
				$data['bln'] = $bulan;
				$data['thn'] = $tahun;
				$data['bc'] = array('Laporan' => site_url('laporan'), 'Laporan Rekap Tunjangan' => site_url('Laporan/tunjangan'));	
				
				$data['dt'] = $this->db->select('nama_tunjangan')->from('tbRwTunjangan')
				->where('bulan', $bulan)
				->where('tahun', $tahun)
				->group_by('nama_tunjangan')
				->get()->result();
				$this->template->mainview('laporan/rekap_tunjangan', $data);
				break;
			case "I":
				$data['bln'] = $bulan;
				$data['thn'] = $tahun;
				$data['bc'] = array('Laporan' => site_url('laporan'), 'Laporan Rekap Potongan' => site_url('Laporan/laporan'));
				$data['dt'] = $this->db->select('nama_potongan')->from('tbRwPotongan')
								->where('bulan', $bulan)
								->where('tahun', $tahun)
								->group_by('nama_potongan')
								->get()->result();
				$this->template->mainview('laporan/rekap_potongan', $data);
				break;
		}
	}

	function hitung_rekap($bulan, $tahun, $halaman)
	{
		//get data kolom di tabel tbRekapGaji;
		$kolom = $this->db->get_where('tbRekapGaji', array('nik' => 'NIK'))->row_array();

		$data['halaman'] = $halaman;
		$data['bln'] = $bulan;
		$data['thn'] = $tahun;
		$data['bc'] = array('Dashboard' => site_url('dashboard'), 'Laporan' => site_url('laporan'));
		$offset = ($halaman - 1) * 10;
		$data['pegawai'] = $this->Laporan_model->get_gaji_pegawai($bulan, $tahun, $offset)->result();
		if (count($data['pegawai']) > 0) {
			foreach ($data['pegawai'] as $peg) {
				$dt['nik'] = $peg->nip;
				$dt['nama'] = $peg->namaPegawai;
				$dt['unit_kerja'] = $peg->nama;
				$dt['jabatan'] = $peg->jabatan;
				$dt['gaji_pokok'] = round(floatval($peg->gaji_pokok));
				$dt['norek'] = $peg->norek;
				//$gabung = $peg->tglBergabung;
				//$sekarang = $tahun . '-' . $bulan . '-01';

				//$diff = abs(strtotime($sekarang)-strtotime($gabung));

				//$days = $diff/(60*60*24);

				//$masa_kerja_thn = intdiv($days,365);
				//$sisa = $days%356;
				//$masa_kerja_bulan = intdiv($sisa, 30);
				//if ($masa_kerja_thn == 0) {
					//$dt['masa_kerja'] = $masa_kerja_bulan . ' bulan';
				//} else {
					//$dt['masa_kerja'] = $masa_kerja_thn . ' tahun ' . $masa_kerja_bulan . ' bulan';
				//}

				//cari data tunjangan tetap
				// $t = $this->db->get_where('tbRwTunjangan', array('bulan' => $bulan, 'tahun' => $tahun, 'nip' => $peg->nip, 'nama_tunjangan' => 'Tunjangan Tetap'))->result();
				// if (count($t) > 0) {
				// 	$dt['tunj_tetap'] = floatval($t[0]->jml);
				// } else {
				// 	$dt['tunj_tetap'] = 0;
				// }
				$dt['tunj_tetap'] = 0;
				$isTunjangan = true;
				//cari data tunjangan & potongan lain
				$x = 1;
				for ($x = 1; $x <= 30; $x++) {
					$namatumpot = $kolom['f' . $x];
					if ($namatumpot == 'GAJI KOTOR') {
						$isTunjangan = false;
					}
					if ($namatumpot != '') {
						if ($isTunjangan) {
							$tp = $this->db->get_where('tbRwTunjangan', array('bulan' => $bulan, 'tahun' => $tahun, 'nip' => $peg->nip, 'nama_tunjangan' => $namatumpot))->result();
							if (count($tp) > 0) {
								$dt['f' . $x] =round(floatval($tp[0]->jml));
							} else {
								$dt['f' . $x] = 0;
							}
						} else {
							$tp = $this->db->get_where('tbRwPotongan', array('bulan' => $bulan, 'tahun' => $tahun, 'nip' => $peg->nip, 'nama_potongan' => $namatumpot))->result();
							if (count($tp) > 0) {
								$dt['f' . $x] = round(floatval($tp[0]->jml));
							} else {
								$dt['f' . $x] = 0;
							}
						}
					}
				}
				$this->db->insert('tbRekapGaji', $dt);				
			}
			$this->template->mainview('laporan/rekap_hitung', $data);
		} else {
			redirect(site_url('laporan/cetak_rekap_gaji/').$bulan.'/'.$tahun);
		}
	}

	function hitung_minus($bulan, $tahun, $halaman)
	{
		//get data kolom di tabel tbRekapGaji;
		$kolom = $this->db->get_where('tbRekapGaji', array('nik' => 'NIK'))->row_array();

		$data['halaman'] = $halaman;
		$data['bln'] = $bulan;
		$data['thn'] = $tahun;
		$data['bc'] = array('Dashboard' => site_url('dashboard'), 'Laporan' => site_url('laporan'));
		$offset = ($halaman - 1) * 10;
		$data['pegawai'] = $this->Laporan_model->get_gaji_pegawai($bulan, $tahun, $offset)->result();

		if (count($data['pegawai']) > 0) {
			foreach ($data['pegawai'] as $peg) {
				$dt['nik'] = $peg->nip;
				$dt['nama'] = $peg->namaPegawai;
				$dt['unit_kerja'] = $peg->nama;
				$dt['jabatan'] = $peg->jabatan;
				$dt['gaji_pokok'] = floatval($peg->gaji_pokok);
				$dt['norek'] = $peg->norek;
				//$gabung = $peg->tglBergabung;
				//$sekarang = $tahun . '-' . $bulan . '-01';

				//$diff = abs(strtotime($sekarang)-strtotime($gabung));

				//$days = $diff/(60*60*24);

				//$masa_kerja_thn = intdiv($days,365);
				//$sisa = $days%356;
				//$masa_kerja_bulan = intdiv($sisa, 30);
				//if ($masa_kerja_thn == 0) {
					//$dt['masa_kerja'] = $masa_kerja_bulan . ' bulan';
				//} else {
					//$dt['masa_kerja'] = $masa_kerja_thn . ' tahun ' . $masa_kerja_bulan . ' bulan';
				//}
				$totalTunjangan = 0;
				$totalPotongan = 0;
				//cari data tunjangan tetap
				$t = $this->db->get_where('tbRwTunjangan', array('bulan' => $bulan, 'tahun' => $tahun, 'nip' => $peg->nip, 'nama_tunjangan' => 'Tunjangan Tetap'))->result();
				if (count($t) > 0) {
					$dt['tunj_tetap'] = floatval($t[0]->jml);
					$totalTunjangan = $totalTunjangan + floatval($t[0]->jml);
				} else {
					$dt['tunj_tetap'] = 0;
				}
				$isTunjangan = true;
				//cari data tunjangan & potongan lain
				$x = 1;
				for ($x = 1; $x <= 30; $x++) {
					$namatumpot = $kolom['f' . $x];
					if ($namatumpot == 'GAJI KOTOR') {
						$isTunjangan = false;
					}
					if ($namatumpot != '') {
						if ($isTunjangan) {
							$tp = $this->db->get_where('tbRwTunjangan', array('bulan' => $bulan, 'tahun' => $tahun, 'nip' => $peg->nip, 'nama_tunjangan' => $namatumpot))->result();
							if (count($tp) > 0) {
								$dt['f' . $x] =floatval($tp[0]->jml);
								$totalTunjangan = $totalTunjangan + floatval($tp[0]->jml);
							} else {
								$dt['f' . $x] = 0;
							}
						} else {
							$tp = $this->db->get_where('tbRwPotongan', array('bulan' => $bulan, 'tahun' => $tahun, 'nip' => $peg->nip, 'nama_potongan' => $namatumpot))->result();
							if (count($tp) > 0) {
								$dt['f' . $x] = floatval($tp[0]->jml);
								$totalPotongan = $totalPotongan + floatval($tp[0]->jml);
							} else {
								$dt['f' . $x] = 0;
							}
						}
					}
				}
				$thp = (floatval($peg->gaji_pokok) + $totalTunjangan) - $totalPotongan;
				// if ($peg->nip == '9221661.K') {
				// 	echo $totalTunjangan . " : tunnjangan <br>";
				// 	echo $totalPotongan . " : potongan <br>";
				// 	echo $peg->gaji_pokok . " : gapok <br>";
				// 	echo $thp;
				// 	die;
				// }
				if ($thp < 0) {
				$this->db->insert('tbRekapGaji', $dt);
				}				
			}
			$this->template->mainview('laporan/rekap_minus', $data);
		} else {
			redirect(site_url('laporan/cetak_rekap_minus/').$bulan.'/'.$tahun);
		}
	}

	function cetak_rekap_gaji($bulan,$tahun) {
		$data['bulan'] = $bulan;
		$data['tahun'] = $tahun;
		$data['bc'] = array('Dashboard' => site_url('dashboard'), 'Laporan' => site_url('laporan'));
		$data['title'] = "Laporan Rekap Gaji Pegawai Periode " . $bulan . "/" . $tahun;
		$this->template->mainview('laporan/cetak_rekap_gaji', $data);
	}

	function download_rekap_gaji($bulan,$tahun) {
		$data['dt'] = $this->db->get('tbRekapGaji')->result_array();
		$data['title'] = "Laporan Rekap Gaji Pegawai Periode " . $bulan . "/" . $tahun;
		$this->load->view('laporan/rekap_gaji_semua', $data);
	}

	function cetak_rekap_minus($bulan,$tahun) {
		$data['bulan'] = $bulan;
		$data['tahun'] = $tahun;
		$data['bc'] = array('Dashboard' => site_url('dashboard'), 'Laporan' => site_url('laporan'));
		$data['title'] = "Laporan Rekap Gaji Minus Periode " . $bulan . "/" . $tahun;
		$this->template->mainview('laporan/cetak_rekap_minus', $data);
	}

	function download_rekap_minus($bulan,$tahun) {
		$data['dt'] = $this->db->get('tbRekapGaji')->result_array();
		$data['title'] = "Laporan Rekap Gaji Minus Periode " . $bulan . "/" . $tahun;
		$this->load->view('laporan/rekap_gaji_semua', $data);
	}

	function tunjangan() {
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');
		$nama_tunjangan = $this->input->post('nama_tunjangan');
		$this->db->select('tbRwTunjangan.*,tbPegawai.namaPegawai,tbPegawai.jabatan,tbPegawai.tglBergabung,tbPegawai.norek,tbSatKerja.nama as nama_unit')
			->from('tbRwTunjangan');
		$this->db->join('tbPegawai','tbPegawai.nipBaru = tbRwTunjangan.nip');
		$this->db->join('tbSatKerja','tbSatKerja.id = tbPegawai.skpd');
		$this->db->where('tbRwTunjangan.bulan',$bulan);
		$this->db->where('tbRwTunjangan.tahun',$tahun);
		$this->db->where('tbRwTunjangan.nama_tunjangan',$nama_tunjangan);
		$data['dt'] = $this->db->get()->result();
		$data['bln']= $bulan;
		$data['thn']= $tahun;
		$data['title'] = "REKAP TUNJANGAN ". $nama_tunjangan . " PERIODE " . $bulan."-".$tahun;
		$this->load->view('laporan/cetak_tunjangan', $data);
	}

	function potongan() {
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');
		$nama_potongan = $this->input->post('nama_potongan');
		$this->db->select('tbRwPotongan.*,tbPegawai.namaPegawai,tbPegawai.jabatan,tbSatKerja.nama as nama_unit')
			->from('tbRwPotongan');
		$this->db->from('tbPegawai');
		$this->db->join('tbRwPotongan','tbPegawai.nipBaru = tbPotongan.nip');
		$this->db->join('tbSatKerja','tbSatKerja.id = tbPegawai.skpd');
		$this->db->where('tbRwPotongan.bulan',$bulan);
		$this->db->where('tbRwPotongan.tahun',$tahun);
		$this->db->where('tbRwPotongan.nama_potongan',$nama_potongan);
		$data['dt'] = $this->db->get()->result();
		$data['bln']= $bulan;
		$data['thn']= $tahun;
		$this->load->view('laporan/cetak_potongan', $data);
	}
}
