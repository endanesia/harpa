<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Jadwal_shift extends Member_Control
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url'));
		$this->load->model(array('jadwal_model'));
		$this->load->library('excel');
	}

	function index($s = 0)
	{
		return $this->show($s);
	}

	function show()
	{
		$satkerja = $this->session->userdata('filter_unit');
		$jabatan = $this->session->userdata('filter_jabatan');
		$bulan = $this->session->userdata('filter_bulan');
		$tahun = $this->session->userdata('filter_tahun');

		if (isset($_POST['skpd'])) {
			$satkerja = $this->input->post('skpd');
			$jabatan = $this->input->post('jabatan');
			$bulan = $this->input->post('bulan');
			$tahun = $this->input->post('tahun');
			$sess['filter_unit'] = $satkerja;
			$sess['filter_jabatan'] = $jabatan;
			$sess['filter_bulan'] = $bulan;
			$sess['filter_tahun'] = $tahun;
			$this->session->set_userdata($sess);
		}
		$data['bc'] = array('Dashboard' => site_url('dashboard'), 'Jadwal Shift' => site_url('shift'));
		$data['title'] = "Jadwal Shift $bulan/$tahun";
		$data['dt'] = $this->jadwal_model->get_pegawai($satkerja, $jabatan)->result();
		if ($this->session->userdata('akses') == 1) {
			$data['satkerja'] = $this->jadwal_model->unit_kerja()->result();
		} else {
			$data['satkerja'] = $this->jadwal_model->unit_kerja($this->session->userdata('unit'))->result();
		}
		$data['jabatan'] = $this->jadwal_model->jabatan()->result();
		$data['shift'] = $this->jadwal_model->get_shift()->result();
		$this->template->mainview('jadwal_shift/shift_index', $data);
	}


	function Simpan()
	{
		$id = $this->input->post('id');
		$data['nama_shift'] = $this->input->post('nama_shift');
		$data['tipe'] = $this->input->post('tipe');

		//jika $id = 0 maka lakukan operasi insert data
		if ($id == 0) {
			$this->jadwal_model->input($data);
		} else {
			//jika $id != 0 maka lakukan proses edit
			$this->jadwal_model->update($data, $id);
		}
		redirect(site_url('shift'));
	}


	function Hapus()
	{
		$id = $this->input->post('idhapus');
		$this->jadwal_model->delete($id);
		redirect(site_url('shift'));
	}


	function GetShift()
	{
		$id = $_POST['id'];
		$dt = $this->jadwal_model->get_by_id($id)->row();
		echo json_encode($dt);
	}

	function SetShift()
	{
		$id = $this->input->post('id');
		$kode = $this->input->post('kode');
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');
		$nip = $this->input->post('nip');
		$ar = explode("_", $id);
		$idel = $ar[0];
		$hari = $ar[1];

		$hasil = $this->apply_shift($idel, $hari, $kode, $bulan, $tahun, $nip);
		echo json_encode($hasil);
	}

	private function apply_shift($idel, $hari, $kode, $bulan, $tahun, $nip)
	{
		//cari data pegawai
		$pegawai = $this->db->get_where('tbPegawai', array("idelektronik" => $idel))->row();
		if (!isset($pegawai)) {
			return array('status' => false, 'kode' => '', 'msg' => 'Pegawai tidak ditemukan');
		}

		$hari = str_pad((string) intval($hari), 2, '0', STR_PAD_LEFT);
		$bulan = str_pad((string) intval($bulan), 2, '0', STR_PAD_LEFT);
		$tahun = (string) intval($tahun);

		//membuat varibale tgl dimana jika tgl 21 - 30 adalah tgl dibulan lalu
		//sedangkan tgl 1 -20 adalah tanggal bulan ini. 
		//variable tgl ini berfungsi untuk setup jam masuk dan jam keluar di tbRwKehadiran, mencari hari libur nasional

        if ($bulan == '01') {
			if (intval($hari) > 20) {
				$nTh = intval($tahun) -1;
				$tgl = strval($nTh) ."-12-".$hari; 
			} else {
				$tgl = $tahun . "-" . $bulan . "-" . $hari;
			}
		} else {
			
			if (intval($hari) > 20) {
				
				$nBln = intval($bulan) -1;
				if (strlen(trim(strval($nBln))) == 1) {
					$tgl = $tahun . "-0" . $nBln . "-" . $hari;
				} else {
					$tgl = $tahun . "-" . $nBln . "-" . $hari;
				}
			} else {
				$tgl = $tahun . "-" . $bulan . "-" . $hari;
			}
		}

		//mencari kode shift di database dari variable yg dikirim, variable $kode berisi kode shift
		//jika kode tidak terdaftar di database maka jadwal diset libur
		//jika ada di db diset sesuai kode
		$shift = $this->db->get_where('tbShift', array('id' => $kode))->row();
		$kodeShift = "lbr";
		$kodeRespon = 'LIBUR';
		if (isset($shift)) {
			$kodeShift = $shift->kode;
			$kodeRespon = $shift->kode;
		}

		//mencari data plot shift atau roaster di table tbPlotShift
		//jika sudah ada tinggal update
		$cPlot = $this->jadwal_model->get_plot($nip, $bulan, $tahun)->result();
		if (count($cPlot) > 0) {
			//sdh ada data
			$this->db->update('tbPlotShift', array('t' . $hari => $kodeShift), array('nip' => $nip, 'bulan' => $bulan, 'tahun' => $tahun));
		} else {
			//blm ada data
			$this->db->insert('tbPlotShift', array('nip' => $nip, 'bulan' => $bulan, 'tahun' => $tahun, 't' . $hari => $kodeShift));
		}

		//cari data hari libur nasional apakah hari ini libur nasional masukkan kedalan variable $hariLibur, jika nilainya 0
		//maka itu bukan hari libur, jika nilainya > 0 maka berarti hari libur
		$hariLibur = 0;
		$rsLibur = $this->db->get_where('tbRwLibur', array('tgl' => $tgl))->result();
		$hariLibur = count($rsLibur);

		//cari nilai premishiftnya orang ini, jika pas hari libur maka nilainya di kalikan 2
		$nilaiPremi = 0;
		
		//masukkan $nilaiPremi ke table tbRwPremishift sesuai bulan dan tahun
		

		//setup jadwal masuk dan jadwal keluar di table tbRwKehadiran
		//jika sudah ada data maka tinggal update jika tidak insert data baru
		$nomorHari = date('N', strtotime($tgl));

		$nip = $pegawai->nipBaru;
		//cari data jadwal
		$jadwal = $this->db->get_where('tbShiftDetail', array("id_shift" => $kode, "hari" => $nomorHari))->row();

		//cek data kehadiran
		$absen = $this->db->get_where('tbRwKehadiran', array("id_contact" => $idel, "tgl" => $tgl))->result();

		if (count($absen) > 0) {
			//sudah ada
			$idKehadiran = $absen[0]->id;

			$upd['id_shift'] = $kode;
			if ($kode == "") {
				$upd['jadwal_masuk'] = "";
				$upd['jadwal_keluar'] = "";
				$upd['status'] = "LIBUR";
				$upd['hadir'] = 2;
			} else {
				if (isset($jadwal)) {
					$upd['jadwal_masuk'] = $jadwal->jam_masuk;
					$upd['jadwal_keluar'] = $jadwal->jam_keluar;
				} else {
					$upd['jadwal_masuk'] = "08:00";
					$upd['jadwal_keluar'] = "16:00";
				}
			}
			$this->db->update('tbRwKehadiran', $upd, array('id' => $idKehadiran));
		} else {
			//blm ada
			$ins['id_contact'] = $idel;
			$ins['tgl'] = $tgl;
			$ins['id_shift'] = $kode;
			$ins['status'] = 'TK';
			$ins['hadir'] = '0';
			$ins['idtbPegawai'] = $pegawai->idtbPegawai;
			$ins['skpd'] = $pegawai->skpd;

			if ($kode == "") {
				$ins['jadwal_masuk'] = "";
				$ins['jadwal_keluar'] = "";
				$ins['status'] = "LIBUR";
				$ins['hadir'] = 2;
			} else {
				if (isset($jadwal)) {
					$ins['jadwal_masuk'] = $jadwal->jam_masuk;
					$ins['jadwal_keluar'] = $jadwal->jam_keluar;
				} else {
					$ins['jadwal_masuk'] = "08:00";
					$ins['jadwal_keluar'] = "16:00";
				}
			}
			$this->db->insert('tbRwKehadiran', $ins);
		}
		//---------------------------------------------------------------------------------------------------

		//update data total premishift yg dia dapat
		$total = 0;

		return array('status' => true, 'kode' => $kodeRespon, 'msg' => 'OK');
	}

	function import_excel()
	{
		$bulan = str_pad((string) intval($this->input->post('bulan')), 2, '0', STR_PAD_LEFT);
		$tahun = (string) intval($this->input->post('tahun'));

		if (!isset($_FILES['file']['name']) || $_FILES['file']['name'] == '') {
			$this->session->set_flashdata('errMsg2', 'File Excel belum dipilih');
			redirect(site_url('jadwal_shift'));
			return;
		}

		$ext = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
		if (!in_array($ext, array('xls', 'xlsx'))) {
			$this->session->set_flashdata('errMsg2', 'Format file tidak didukung. Gunakan xls atau xlsx');
			redirect(site_url('jadwal_shift'));
			return;
		}

		try {
			$object = PHPExcel_IOFactory::load($_FILES['file']['tmp_name']);
		} catch (Exception $e) {
			$this->session->set_flashdata('errMsg2', 'File Excel tidak dapat dibaca');
			redirect(site_url('jadwal_shift'));
			return;
		}

		$worksheet = $object->getSheet(0);
		$highestRow = $worksheet->getHighestRow();
		$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($worksheet->getHighestColumn());

		$mapKolomHari = array();
		for ($col = 0; $col < $highestColumnIndex; $col++) {
			$header = strtoupper(trim((string) $worksheet->getCellByColumnAndRow($col, 1)->getCalculatedValue()));
			if (preg_match('/^T?([0-9]{1,2})$/', $header, $m)) {
				$hari = intval($m[1]);
				if ($hari >= 1 && $hari <= 31) {
					$mapKolomHari[$col] = str_pad((string) $hari, 2, '0', STR_PAD_LEFT);
				}
			}
		}

		if (count($mapKolomHari) == 0) {
			$this->session->set_flashdata('errMsg2', 'Header tanggal tidak ditemukan. Isi baris 1 dengan angka tanggal 1-31 atau t01-t31');
			redirect(site_url('jadwal_shift'));
			return;
		}

		$rowsSukses = 0;
		$rowsSkip = 0;
		$shiftTidakDitemukan = 0;

		for ($row = 2; $row <= $highestRow; $row++) {
			$nip = trim((string) $worksheet->getCellByColumnAndRow(0, $row)->getFormattedValue());
			if ($nip == '') {
				continue;
			}

			$pegawai = $this->jadwal_model->pegawai_by_nip($nip)->row();
			if (!isset($pegawai)) {
				$rowsSkip++;
				continue;
			}

			$terproses = 0;
			foreach ($mapKolomHari as $col => $hari) {
				$kodeCell = strtoupper(trim((string) $worksheet->getCellByColumnAndRow($col, $row)->getFormattedValue()));
				if ($kodeCell == '') {
					continue;
				}

				$idShift = '';
				if ($kodeCell != 'LBR' && $kodeCell != 'LIBUR' && $kodeCell != 'OFF') {
					$shift = $this->jadwal_model->get_shift_by_kode($kodeCell)->row();
					if (!isset($shift)) {
						$shiftTidakDitemukan++;
						continue;
					}
					$idShift = $shift->id;
				}

				$hasil = $this->apply_shift($pegawai->idelektronik, $hari, $idShift, $bulan, $tahun, $nip);
				if ($hasil['status']) {
					$terproses++;
				}
			}

			if ($terproses > 0) {
				$rowsSukses++;
			}
		}

		$this->session->set_flashdata('errMsg', 'Import jadwal shift selesai. Baris sukses: ' . $rowsSukses . ', baris dilewati: ' . $rowsSkip . ', kode shift tidak dikenal: ' . $shiftTidakDitemukan);
		redirect(site_url('jadwal_shift'));
	}

	function template_excel()
	{
		$satkerja = $this->input->post('skpd');
		$jabatan = $this->input->post('jabatan');
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');

		if ($satkerja == '') {
			$satkerja = $this->session->userdata('filter_unit');
		}
		if ($jabatan == '') {
			$jabatan = $this->session->userdata('filter_jabatan');
		}
		if ($bulan == '') {
			$bulan = $this->session->userdata('filter_bulan');
		}
		if ($tahun == '') {
			$tahun = $this->session->userdata('filter_tahun');
		}

		$bulan = str_pad((string) intval($bulan), 2, '0', STR_PAD_LEFT);
		$tahun = (string) intval($tahun);

		$data['bulan'] = $bulan;
		$data['tahun'] = $tahun;
		$data['pegawai'] = $this->jadwal_model->get_pegawai($satkerja, $jabatan)->result();
		$data['unit'] = $this->db->get_where('tbSatKerja', array('id' => $satkerja))->row();
		$data['jabatan'] = $this->db->get_where('tbJabatan', array('idJabatan' => $jabatan))->row();
		$data['title'] = 'Template Jadwal Shift ' . $bulan . '-' . $tahun;

		$this->load->view('jadwal_shift/shift_template_excel', $data);
	}

	function urut($lakone,$pos,$arah,$korban) {
		if ($arah == 'up') {
			//geser keatas lakone pos dikurang 1, korban pos + 1
			$this->db->update('tbPegawai',array('noUrut'=>strval($pos-1)),array('nipBaru'=>$lakone));
			$this->db->update('tbPegawai',array('noUrut'=>strval($pos+1)),array('nipBaru'=>$korban));
		} else {
			//geser kebawah
			$this->db->update('tbPegawai',array('noUrut'=>strval($pos+1)),array('nipBaru'=>$lakone));
			$this->db->update('tbPegawai',array('noUrut'=>strval($pos-1)),array('nipBaru'=>$korban));
		}
		redirect(site_url('jadwal_shift'));
	}

	function excel()
	{
		$satkerja = $this->session->userdata('filter_unit');
		$jabatan = $this->session->userdata('filter_jabatan');
		$bulan = $this->session->userdata('filter_bulan');
		$tahun = $this->session->userdata('filter_tahun');

		if (isset($_POST['skpd'])) {
			$satkerja = $this->input->post('skpd');
			$jabatan = $this->input->post('jabatan');
			$bulan = $this->input->post('bulan');
			$tahun = $this->input->post('tahun');
			$sess['filter_unit'] = $satkerja;
			$sess['filter_jabatan'] = $jabatan;
			$sess['filter_bulan'] = $bulan;
			$sess['filter_tahun'] = $tahun;
			$this->session->set_userdata($sess);
		}
		$data['bc'] = array('Dashboard' => site_url('dashboard'), 'Jadwal Shift' => site_url('shift'));
		$data['title'] = "Jadwal Shift $bulan/$tahun";
		$data['dt'] = $this->jadwal_model->get_pegawai($satkerja, $jabatan)->result();
		if ($this->session->userdata('akses') == 1) {
			$data['satkerja'] = $this->jadwal_model->unit_kerja()->result();
		} else {
			$data['satkerja'] = $this->jadwal_model->unit_kerja($this->session->userdata('unit'))->result();
		}
		$data['jabatan'] = $this->jadwal_model->jabatan()->result();
		$data['shift'] = $this->jadwal_model->get_shift()->result();
		$this->load->view('jadwal_shift/shift_excel', $data);
	}
}