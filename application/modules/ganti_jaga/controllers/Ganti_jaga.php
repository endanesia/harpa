<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ganti_jaga extends Member_Control

{



	public function __construct()

	{

		parent::__construct();

		$this->load->helper(array('url'));

		$this->load->model('ganti_jaga_model');

		$this->load->library(array('session', 'form_validation', 'template'));

		$this->load->database();

	}



	function index($s = 0)

	{

		return $this->show($s);

	}



	function show()

	{

		$satkerja = $this->session->userdata('filter_unit');

		$bulan = $this->session->userdata('filter_bulan');

		$tahun = $this->session->userdata('filter_tahun');



		if (isset($_POST['skpd'])) {

			$skpd = $this->input->post('skpd');

			$bulan = $this->input->post('bulan');

			$tahun = $this->input->post('tahun');

			$sess['filter_unit'] = $skpd;

			$sess['filter_bulan'] = $bulan;

			$sess['filter_tahun'] = $tahun;

			$this->session->set_userdata($sess);

		}

		$data['error'] = "";

		$data['bc'] = array('Dashboard' => site_url('dashboard'), 'SPGJ' => site_url('ganti_jaga'));

		$data['title'] = "Surat Perintah Ganti Jaga";

		$data['dt'] = $this->ganti_jaga_model->show_data($this->session->filter_unit, $this->session->filter_bulan, $this->session->filter_tahun)->result();

		if ($this->session->userdata('akses') == 1) {

			$data['satkerja'] = $this->ganti_jaga_model->unit_kerja()->result();

		} else {

			$data['satkerja'] = $this->ganti_jaga_model->unit_kerja($this->session->userdata('unit'))->result();

		}

		$this->template->mainview('ganti_jaga/ganti_jaga_index', $data);

	}



	function validasi()

	{

		$satkerja = $this->session->userdata('filter_unit');

		$bulan = $this->session->userdata('filter_bulan');

		$tahun = $this->session->userdata('filter_tahun'); 



		if (isset($_POST['skpd'])) {

			$skpd = $this->input->post('skpd');

			$bulan = $this->input->post('bulan');

			$tahun = $this->input->post('tahun');

			$sess['filter_unit'] = $skpd;

			$sess['filter_bulan'] = $bulan;

			$sess['filter_tahun'] = $tahun;

			$this->session->set_userdata($sess);

		}



		$data['bc'] = array('Dashboard' => site_url('dashboard'), 'Validasi SPGJ' => site_url('ganti_jaga/validasi'));

		$data['title'] = "Validasi Surat Perintah Ganti Jaga";

		$data['dt'] = $this->ganti_jaga_model->show_data($this->session->filter_unit, $this->session->filter_bulan, $this->session->filter_tahun)->result();

		$data['satkerja'] = $this->ganti_jaga_model->unit_kerja()->result();

		$this->template->mainview('ganti_jaga/ganti_jaga_validasi', $data);

	}



	function Simpan()

	{

		if (empty($this->session->userdata('filter_unit'))) {

			redirect(site_url() . '/ganti_jaga/Error_input');

		} else {

			$pgid = $this->ganti_jaga_model->pegawai_id($this->input->post('pegawai'))->row();

			$lembur['noWo'] = $this->input->post('nomor');

			$lembur['skpd'] = $this->session->userdata('filter_unit');

			$lembur['uraian'] = $this->input->post('uraian_lembur');

			$lembur['kodeAktifitas'] = $this->input->post('aktivitas');

			$lembur['tglLembur'] = $this->input->post('tgl_wo');

			$lembur['mulai'] = $this->input->post('jam_awal_lembur') . ':' . $this->input->post('menit_awal_lembur');

			$lembur['sampai'] = $this->input->post('jam_akhir_lembur') . ':' . $this->input->post('menit_akhir_lembur');

			$lembur['statusHari'] = $this->input->post('hari');

			$lembur['alasan'] = $this->input->post('alasan');

			$lembur['idp_yg_diganti'] = $this->input->post('pegawai_diganti');

			$lembur['idp_yg_mengganti'] = $this->input->post('pegawai_mengganti');

			$lembur['bebanAnggaran'] = $this->input->post('beban_anggaran');

			$lembur['namaPemberiTugas'] = $this->input->post('nama_pt');

			$lembur['nidPemberiTugas'] = $this->input->post('nid_pt');

			$lembur['tglPemberiTugas'] = $this->input->post('tgl_pt');

			$lembur['namaPemeriksa'] = $this->input->post('nama_periksa');

			$lembur['nidPemeriksa'] = $this->input->post('nid_periksa');

			$lembur['tglPemeriksa'] = $this->input->post('tgl_periksa');

			$lembur['namaAsman'] = $this->input->post('asman');



			//cari premi shift

			$ps = $this->ganti_jaga_model->get_premi_shift($lembur['idp_yg_diganti'], $lembur['tglLembur'])->result();

			$lembur['premi_shift'] = 0;

			if (count($ps) > 0) {

				if ($ps[0]->premi_shift == "Pagi") {

					$lembur['premi_shift'] = $ps[0]->nPagi;

				}

				if ($ps[0]->premi_shift == "Sore") {

					$lembur['premi_shift'] = $ps[0]->nSiang;

				}

				if ($ps[0]->premi_shift == "Malam") {

					$lembur['premi_shift'] = $ps[0]->nMalam;

				}

			}



			$hasil = $this->ganti_jaga_model->input($lembur);

			redirect(site_url() . '/ganti_jaga');

		}

	}



	function Edit($linkback="")

	{

		$lembur['id'] = $this->input->post('id_jaga');

		$lembur['uraian'] = $this->input->post('uraian_lembur');

		$lembur['kodeAktifitas'] = $this->input->post('aktivitas');

		$lembur['tglLembur'] = $this->input->post('tgl_wo');

		$lembur['mulai'] = $this->input->post('jam_awal_lembur') . ':' . $this->input->post('menit_awal_lembur');

		$lembur['sampai'] = $this->input->post('jam_akhir_lembur') . ':' . $this->input->post('menit_akhir_lembur');

		$lembur['statusHari'] = $this->input->post('hari');

		$lembur['alasan'] = $this->input->post('alasan');

		$lembur['idp_yg_diganti'] = $this->input->post('pegawai_diganti');

		$lembur['idp_yg_mengganti'] = $this->input->post('pegawai_mengganti');

		$lembur['bebanAnggaran'] = $this->input->post('beban_anggaran');

		$lembur['namaPemberiTugas'] = $this->input->post('nama_pt');

		$lembur['nidPemberiTugas'] = $this->input->post('nid_pt');

		$lembur['tglPemberiTugas'] = $this->input->post('tgl_pt');

		$lembur['namaPemeriksa'] = $this->input->post('nama_periksa');

		$lembur['nidPemeriksa'] = $this->input->post('nid_periksa');

		$lembur['tglPemeriksa'] = $this->input->post('tgl_periksa');

		$lembur['namaAsman'] = $this->input->post('asman');



		//cari premi shift

		$ps = $this->ganti_jaga_model->get_premi_shift($lembur['idp_yg_diganti'], $lembur['tglLembur'])->result();

		$lembur['premi_shift'] = 0;

		if (count($ps) > 0) {

			if ($ps[0]->premi_shift == "Pagi") {

				$lembur['premi_shift'] = $ps[0]->nPagi;

			}

			if ($ps[0]->premi_shift == "Sore") {

				$lembur['premi_shift'] = $ps[0]->nSiang;

			}

			if ($ps[0]->premi_shift == "Malam") {

				$lembur['premi_shift'] = $ps[0]->nMalam;

			}

		}

		//

		$hasil = $this->ganti_jaga_model->update($lembur, $lembur['id'], $lembur['tglLembur']);

		if ($linkback == "v") {

			redirect(site_url() . '/ganti_jaga/Validasi');

		} else {

			redirect(site_url() . '/ganti_jaga');

		}

	}



	function Error_input()

	{

		$data['error'] = "Data Gagal disimpan Unit belum dipilih";

		$data['bc'] = array('Dashboard' => site_url('dashboard'), 'Pegawai Lembur' => site_url('Lembur'));

		$data['title'] = "Surat Perintah Kerja Lembur";

		$data['dt'] = $this->ganti_jaga_model->show_data($this->session->filter_unit, $this->session->filter_bulan, $this->session->filter_tahun)->result();

		$data['satkerja'] = $this->ganti_jaga_model->unit_kerja()->result();

		$this->template->mainview('ganti_jaga/ganti_jaga_index', $data);

	}



	function Delete($id)

	{

		$this->ganti_jaga_model->Delete($id);

		redirect(site_url('ganti_jaga'));

	}



	function EditValid($id)

	{



		$lembur['status'] = 1;

		$lembur['tgl_validasi'] = date('Y-m-d');

		$hasil = $this->ganti_jaga_model->update($lembur, $id);

		redirect(site_url() . '/ganti_jaga/Validasi');

	}



	function EditInvalid($id)

	{



		$lembur['status'] = 0;

		$hasil = $this->ganti_jaga_model->update($lembur, $id);

		redirect(site_url() . '/ganti_jaga/Validasi');

	}



	// Laporan=====================================================================================================================

	function Cetak_jaga($id)

	{

		//Logo

		$img = base_url() . '/assets/imgs/PLN-Nusantara-Power-5p.png';

		$pdf = new PDF();

		$pdf->SetPrintHeader(false);

		$pdf->SetPrintFooter(false);

		$pdf->AddPage('L', 'mm', 'A4');

		$lembur = $this->ganti_jaga_model->Jaga($id)->row();

		$unit = $this->ganti_jaga_model->unit_kerja_id($lembur->skpd)->row();

		//kop surat

		$pdf->SetFont('', 'B', 7);

		$pdf->image($img, 10, 11, 20, 5,);

		$pdf->Cell(20, 8, '', 0, 0, 'L');

		$pdf->Cell(60, 1, 'PT PLN NUSANTARA POWER', 0, 0, 'L');

		$pdf->Cell(120, 1, 'SURAT PERINTAH GANTI JAGA', 0, 0, 'C');

		$dpmg = $this->ganti_jaga_model->pegawai_id($lembur->idp_yg_mengganti)->row();

		$pangkat = $this->ganti_jaga_model->jabatan_id($dpmg->idJabatan)->row();

		//centang 1

		$pdf->Cell(2, 1, '', 1, 0, 'L');

		$pdf->Cell(20, 4, 'Security', 0, 1, 'L');

		//baris 2

		$pdf->Cell(20, 8, '', 0, 0, 'L');

		$pdf->Cell(60, 1, 'UNIT PEMBANGKITAN BRANTAS', 0, 0, 'L');

		$pdf->Cell(120, 1, '(SPGJ)', 0, 0, 'C');

		//centang 2

		$pdf->Cell(2, 1, '', 1, 0, 'L');

		$pdf->Cell(20, 4, 'Maintenannce Shift', 0, 1, 'L');

		//baris 3

		$pdf->Cell(20, 8, '', 0, 0, 'L');

		$pdf->Cell(60, 1, '', 0, 0, 'L');

		$pdf->Cell(120, 1, '', 0, 0, 'C');

		//centang 3

		$pdf->Cell(2, 1, '', 1, 0, 'L');

		$pdf->Cell(20, 1, 'PPS/KTH', 0, 1, 'L');

		//content panjang 190

		$pdf->SetFont('', 'B', 6);

		$pdf->Cell(1, 1, '', 0, 0, 'L');

		$pdf->Cell(185, 1, '*1-7 Harus di isi semua', 0, 1, 'L');

		$pdf->SetFont('', 'B', 8);

		//kotak 1

		$pdf->SetFillColor(215, 215, 215);

		$pdf->Cell(2, 1, '', 'LT', 0, 'L');

		$pdf->Cell(120, 1, '1. Deskripsi Dari Pekerjaan yang di Lemburkan :', 1, 0, 'L', true);

		$pdf->Cell(120, 1, '3. Nomor :', 1, 1, 'L', true);



		$pdf->Cell(2, 1, '', 'LR', 0, 'L');

		$pdf->Cell(42, 1, 'Nama Yang Digantikan', 0, 0, 'L');

		$dpdg = $this->ganti_jaga_model->pegawai_id($lembur->idp_yg_diganti)->row();

		$pdf->Cell(78, 1, ' : ' . $dpdg->namaPegawai, 'R', 0, 'L');

		$pdf->Cell(120, 1, $lembur->noWo, 'R', 1, 'L');



		$pdf->Cell(2, 1, '', 'LR', 0, 'L');

		$pdf->Cell(42, 1, 'Nama Yang Menggantikan', 0, 0, 'L');

		$dpmg = $this->ganti_jaga_model->pegawai_id($lembur->idp_yg_mengganti)->row();

		$pdf->Cell(78, 1, ' : ' . $dpmg->namaPegawai, 'R', 0, 'L');

		$pdf->Cell(120, 1, '', 'R', 1, 'L');



		$pdf->Cell(2, 1, '', 'LR', 0, 'L');

		$pdf->Cell(120, 1, '', 'LR', 0, 'L');

		$pdf->Cell(120, 1, '', 'LR', 1, 'L');



		$pdf->Cell(2, 1, '', 'LR', 0, 'L');

		$jab = $this->ganti_jaga_model->jabatan_id($dpmg->idJabatan)->row();

		$pdf->Cell(120, 1, 'JABATAN : ' . $jab->namaJabatan, 'LR', 0, 'L');

		$pdf->Cell(120, 1, '', 'LR', 1, 'L');



		$pdf->Cell(2, 1, '', 'LR', 0, 'L');

		$pdf->Cell(120, 1, '', 'LRB', 0, 'L');

		$pdf->Cell(120, 1, '', 'LRB', 1, 'L');

		//kotak 2

		$pdf->Cell(2, 1, '', 'LR', 0, 'L');

		$pdf->Cell(120, 1, '2. Uraian Pekerjaan yang dilemburkan, sasaran dan alasannya :', 1, 0, 'L', true);

		$pdf->Cell(120, 1, '4. Kode Aktifitas (*) :', 1, 1, 'L', true);

		//uraian baris 1

		$pdf->Cell(2, 1, '', 'LR', 0, 'L');

		$pdf->Cell(120, 1, substr($lembur->uraian, 0, 67), 'LR', 0, 'L');

		$pdf->Cell(120, 1, $lembur->kodeAktifitas, 'LR', 1, 'L');

		//uraian baris 2

		$pdf->Cell(2, 1, '', 'LR', 0, 'L');

		$pdf->Cell(120, 1, substr($lembur->uraian, 67, 67), 'LR', 0, 'L');

		$pdf->Cell(120, 1, '', 'LR', 1, 'L');

		//uraian baris 3

		$pdf->Cell(2, 1, '', 'LR', 0, 'L');

		$pdf->Cell(120, 1, substr($lembur->uraian, 134, 67), 'LR', 0, 'L');

		$pdf->Cell(120, 1, '', 'LR', 1, 'L');

		$pdf->Cell(2, 1, '', 'LR', 0, 'L');

		$pdf->Cell(120, 1, '', 'LR', 0, 'L');

		$pdf->Cell(120, 1, '', 'LR', 1, 'L');

		$pdf->Cell(2, 1, '', 'LR', 0, 'L');

		$pdf->Cell(120, 1, '', 'LRB', 0, 'L');

		$pdf->Cell(120, 1, '', 'LRB', 1, 'L');

		//kotak 3

		if ($lembur->statusHari == "Kerja") {

			$pdf->Cell(2, 1, '', 'LR', 0, 'L');

			//hari kerja

			$pdf->Cell(60, 1, 'Hari Masuk Tanggal :', 'LR', 0, 'L');

			$pdf->Cell(60, 1, 'Jam :', 'LR', 0, 'L');

			$pdf->Cell(120, 1, '5. Beban Anggaran :', 1, 1, 'L', true);

			$pdf->Cell(2, 1, '', 'LR', 0, 'L');

			$pdf->Cell(60, 1, date("d-m-Y", strtotime($lembur->tglLembur)), 'LR', 0, 'L');

			$pdf->Cell(60, 1, $lembur->mulai . ' - ' . $lembur->sampai, 'LR', 0, 'L');

			$pdf->Cell(120, 1, $lembur->bebanAnggaran, 'R', 1, 'L');

			$pdf->Cell(2, 1, '', 'LR', 0, 'L');

			$pdf->Cell(60, 1, '', 'LR', 0, 'L');

			$pdf->Cell(60, 1, '', 'LR', 0, 'L');

			$pdf->Cell(120, 1, '', 'R', 1, 'L');

			$pdf->Cell(2, 1, '', 'LR', 0, 'L');

			$pdf->Cell(60, 1, '', 'LRB', 0, 'L');

			$pdf->Cell(60, 1, '', 'LRB', 0, 'L');

			$pdf->Cell(120, 1, '', 'R', 1, 'L');

			//hari libur

			$pdf->Cell(2, 1, '', 'LR', 0, 'L');

			$pdf->Cell(60, 1, 'Hari Libur Tanggal :', 'LR', 0, 'L');

			$pdf->Cell(60, 1, 'Jam :', 'LR', 0, 'L');

			$pdf->Cell(120, 1, '', 'LR', 1, 'L');

			$pdf->Cell(2, 1, '', 'LR', 0, 'L');

			$pdf->Cell(60, 1, '', 'LR', 0, 'L');

			$pdf->Cell(60, 1, '', 'LR', 0, 'L');

			$pdf->Cell(120, 1, '', 'R', 1, 'L');

			$pdf->Cell(2, 1, '', 'LR', 0, 'L');

			$pdf->Cell(60, 1, '', 'LR', 0, 'L');

			$pdf->Cell(60, 1, '', 'LR', 0, 'L');

			$pdf->Cell(120, 1, '', 'R', 1, 'L');

			$pdf->Cell(2, 1, '', 'LR', 0, 'L');

			$pdf->Cell(60, 1, '', 'LRB', 0, 'L');

			$pdf->Cell(60, 1, '', 'LRB', 0, 'L');

			$pdf->Cell(120, 1, '', 'RB', 1, 'L');

		} else {

			$pdf->Cell(2, 1, '', 'LR', 0, 'L');

			//hari kerja

			$pdf->Cell(60, 1, 'Hari Masuk Tanggal :', 'LR', 0, 'L');

			$pdf->Cell(60, 1, 'Jam :', 'LR', 0, 'L');

			$pdf->Cell(120, 1, '5. Beban Anggaran :', 1, 1, 'L', true);

			$pdf->Cell(2, 1, '', 'LR', 0, 'L');

			$pdf->Cell(60, 1, '', 'LR', 0, 'L');

			$pdf->Cell(60, 1, '', 'LR', 0, 'L');

			$pdf->Cell(120, 1, $lembur->bebanAnggaran, 'R', 1, 'L');

			$pdf->Cell(2, 1, '', 'LR', 0, 'L');

			$pdf->Cell(60, 1, '', 'LR', 0, 'L');

			$pdf->Cell(60, 1, '', 'LR', 0, 'L');

			$pdf->Cell(120, 1, '', 'R', 1, 'L');

			$pdf->Cell(2, 1, '', 'LR', 0, 'L');

			$pdf->Cell(60, 1, '', 'LRB', 0, 'L');

			$pdf->Cell(60, 1, '', 'LRB', 0, 'L');

			$pdf->Cell(120, 1, '', 'R', 1, 'L');

			//hari libur

			$pdf->Cell(2, 1, '', 'LR', 0, 'L');

			$pdf->Cell(60, 1, 'Hari Libur Tanggal :', 'LR', 0, 'L');

			$pdf->Cell(60, 1, 'Jam :', 'LR', 0, 'L');

			$pdf->Cell(120, 1, '', 'LR', 1, 'L');

			$pdf->Cell(2, 1, '', 'LR', 0, 'L');

			$pdf->Cell(60, 1, date("d-m-Y", strtotime($lembur->tglLembur)), 'LR', 0, 'L');

			$pdf->Cell(60, 1, $lembur->mulai . ' - ' . $lembur->sampai, 'LR', 0, 'L');

			$pdf->Cell(120, 1, '', 'R', 1, 'L');

			$pdf->Cell(2, 1, '', 'LR', 0, 'L');

			$pdf->Cell(60, 1, '', 'LR', 0, 'L');

			$pdf->Cell(60, 1, '', 'LR', 0, 'L');

			$pdf->Cell(120, 1, '', 'R', 1, 'L');

			$pdf->Cell(2, 1, '', 'LR', 0, 'L');

			$pdf->Cell(60, 1, '', 'LRB', 0, 'L');

			$pdf->Cell(60, 1, '', 'LRB', 0, 'L');

			$pdf->Cell(120, 1, '', 'RB', 1, 'L');

		}

		//kotak 4

		$pdf->Cell(2, 1, '', 'LR', 0, 'L');

		$pdf->Cell(120, 1, '6. YANG MENUGASKAN', 1, 0, 'L', true);

		$pdf->Cell(60, 1, 'Mengetahui :', 1, 0, 'C', true);

		$pdf->SetFont('', 'BU', 4);

		$pdf->Cell(60, 1, 'Ket. Kode Aktifitas (*) :', 'LR', 1, 'L');

		$pdf->SetFont('', 'B', 8);
		$pdf->Cell(2, 1, '', 'LR', 0, 'L');

		$pdf->Cell(120, 1, '', 'R', 0, 'L');

		$pdf->Cell(60, 1, '', 'R', 0, 'C');

		$pdf->SetFont('', 'B', 5);

		$pdf->Cell(60, 1, '12   = Keamanan', 'LR', 1, 'L');

		$pdf->Cell(2, 1, '', 'LR', 0, 'L');

		$pdf->Cell(120, 1, '', 'R', 0, 'L');

		$pdf->Cell(60, 1, '', 'R', 0, 'C');

		$pdf->SetFont('', 'B', 5);

		$pdf->Cell(60, 1, '18   = K3', 'LR', 1, 'L');

		$pdf->SetFont('', 'B', 8);

		$pdf->Cell(2, 1, '', 'LR', 0, 'L');

		$pdf->Cell(120, 1, 'Nama          : ' . $lembur->namaPemberiTugas, 'R', 0, 'L');

		$pdf->SetFont('', 'B', 5);

		$pdf->Cell(20, 1, 'Pemeriksa', 'R', 0, 'C');

		$pdf->Cell(20, 1, 'ASMAN Bidang', 'R', 0, 'C');

		$pdf->Cell(20, 1, 'ASMAN', 'R', 0, 'C');

		$pdf->SetFont('', 'B', 5);

		$pdf->Cell(60, 1, '19   = Lingkungan', 'LR', 1, 'L');

		$pdf->SetFont('', 'B', 8);

		$pdf->Cell(2, 1, '', 'LR', 0, 'L');

		$pdf->Cell(120, 1, '', 'R', 0, 'L');

		$pdf->SetFont('', 'B', 5);

		$pdf->Cell(20, 1, 'Hasil', 'R', 0, 'C');

		$pdf->Cell(20, 1, '', 'R', 0, 'C');

		$pdf->Cell(20, 1, $unit->nama, 'R', 0, 'C');

		$pdf->SetFont('', 'B', 5);

		$pdf->Cell(60, 1, '20   = Preventive Maintenance', 'LR', 1, 'L');

		$pdf->SetFont('', 'B', 8);

		$pdf->Cell(2, 1, '', 'LR', 0, 'L');

		$pdf->Cell(120, 1, '', 'R', 0, 'L');

		$pdf->Cell(20, 1, '', 'R', 0, 'C');

		$pdf->Cell(20, 1, '', 'R', 0, 'C');

		$pdf->Cell(20, 1, '', 'R', 0, 'C');

		$pdf->SetFont('', 'B', 5);

		$pdf->Cell(60, 1, '21   = Predictive Maintenance', 'LR', 1, 'L');

		$pdf->SetFont('', 'B', 8);

		$pdf->Cell(2, 1, '', 'LR', 0, 'L');

		$pdf->Cell(120, 1, '', 'R', 0, 'L');

		$pdf->Cell(20, 1, '', 'R', 0, 'C');

		$pdf->Cell(20, 1, '', 'R', 0, 'C');

		$pdf->Cell(20, 1, '', 'R', 0, 'C');

		$pdf->SetFont('', 'B', 5);

		$pdf->Cell(60, 1, '22   = Corrective Maintenance', 'LR', 1, 'L');

		$pdf->SetFont('', 'B', 8);

		$pdf->Cell(2, 1, '', 'LR', 0, 'L');

		$pdf->Cell(120, 1, 'Tanggal      : ' . date("d-m-Y", strtotime($lembur->tglPemberiTugas)), 'R', 0, 'L');

		$pdf->Cell(20, 1, '', 'R', 0, 'C');

		$pdf->Cell(20, 1, '', 'R', 0, 'C');

		$pdf->Cell(20, 1, '', 'R', 0, 'C');

		$pdf->SetFont('', 'B', 5);

		$pdf->Cell(60, 1, '24   = Overhoul Maintenance', 'LR', 1, 'L');

		$pdf->SetFont('', 'B', 8);

		$pdf->Cell(2, 1, '', 'LR', 0, 'L');

		$pdf->Cell(120, 1, '', 'R', 0, 'L');

		$pdf->Cell(20, 1, '', 'R', 0, 'C');

		$pdf->Cell(20, 1, '', 'R', 0, 'C');

		$pdf->Cell(20, 1, '', 'R', 0, 'C');

		$pdf->SetFont('', 'B', 5);

		$pdf->Cell(60, 1, '26   = Engineering / Project / Modifikasi', 'LR', 1, 'L');

		$pdf->SetFont('', 'B', 8);

		$pdf->Cell(2, 1, '', 'LR', 0, 'L');

		$pdf->Cell(120, 1, '', 'R', 0, 'L');

		$pdf->Cell(20, 1, '', 'R', 0, 'C');

		$pdf->Cell(20, 1, '', 'R', 0, 'C');

		$pdf->Cell(20, 1, '', 'R', 0, 'C');

		$pdf->SetFont('', 'B', 5);

		$pdf->Cell(60, 1, '60   = Non Instalasi / Umum', 'LR', 1, 'L');

		$pdf->Cell(2, 1, '', 'LR', 0, 'L');

		$pdf->Cell(120, 1, '', 'R', 0, 'L');

		$pdf->Cell(20, 1, '', 'R', 0, 'C');

		$pdf->Cell(20, 1, '', 'R', 0, 'C');

		$pdf->Cell(20, 1, '', 'R', 0, 'C');

		$pdf->Cell(60, 1, '', 'LR', 1, 'L');

		//kotak 5

		$pdf->SetFont('', 'B', 8);

		$pdf->Cell(2, 1, '', 'LR', 0, 'L');

		$pdf->Cell(120, 1, '7. PEMERIKSA HASIL', 1, 0, 'L', true);

		$pdf->Cell(20, 1, '', 'R', 0, 'C');

		$pdf->Cell(20, 1, '', 'R', 0, 'C');

		$pdf->Cell(20, 1, '', 'R', 0, 'C');

		$pdf->SetFont('', 'BU', 4);

		$pdf->Cell(60, 1, '', 'LR', 1, 'L');

		$pdf->SetFont('', 'B', 8);

		$pdf->Cell(2, 1, '', 'LR', 0, 'L');

		$pdf->Cell(120, 1, '', 'R', 0, 'L');

		$pdf->Cell(20, 1, '', 'R', 0, 'C');

		$pdf->Cell(20, 1, '', 'R', 0, 'C');

		$pdf->Cell(20, 1, '', 'R', 0, 'C');

		$pdf->SetFont('', 'B', 5);

		$pdf->Cell(60, 1, '', 'LR', 1, 'L');

		$pdf->SetFont('', 'B', 8);

		$pdf->Cell(2, 1, '', 'LR', 0, 'L');

		$pdf->Cell(120, 1, 'Nama          : ' . $lembur->namaPemeriksa, 'R', 0, 'L');

		$pdf->Cell(20, 1, '', 'R', 0, 'C');

		$pdf->Cell(20, 1, '', 'R', 0, 'C');

		$pdf->Cell(20, 1, '', 'R', 0, 'C');

		$pdf->SetFont('', 'B', 5);

		$pdf->Cell(60, 1, '', 'LR', 1, 'L');

		$pdf->SetFont('', 'B', 8);

		$pdf->Cell(2, 1, '', 'LR', 0, 'L');

		$pdf->Cell(120, 1, '', 'R', 0, 'L');

		$pdf->Cell(20, 1, '', 'R', 0, 'C');

		$pdf->Cell(20, 1, '', 'R', 0, 'C');

		$pdf->Cell(20, 1, '', 'R', 0, 'C');

		$pdf->SetFont('', 'B', 5);

		$pdf->Cell(60, 1, '', 'LR', 1, 'L');

		$pdf->SetFont('', 'B', 8);

		$pdf->Cell(2, 1, '', 'LR', 0, 'L');

		$pdf->Cell(120, 1, 'N I D            : ' . $lembur->nidPemeriksa, 'R', 0, 'L');

		$pdf->Cell(20, 1, '', 'R', 0, 'C');

		$pdf->Cell(20, 1, '', 'R', 0, 'C');

		$pdf->Cell(20, 1, '', 'R', 0, 'C');

		$pdf->SetFont('', 'B', 5);

		$pdf->Cell(60, 1, '', 'LR', 1, 'L');

		$pdf->SetFont('', 'B', 8);

		$pdf->Cell(2, 1, '', 'LR', 0, 'L');

		$pdf->Cell(120, 1, '', 'R', 0, 'L');

		$pdf->Cell(20, 1, '', 'R', 0, 'C');

		$pdf->Cell(20, 1, '', 'R', 0, 'C');

		$pdf->Cell(20, 1, '', 'R', 0, 'C');

		$pdf->SetFont('', 'B', 8);

		$pdf->Cell(60, 1, '', 'LR', 1, 'L');

		$pdf->SetFont('', 'B', 8);

		$pdf->Cell(2, 1, '', 'LR', 0, 'L');

		$pdf->Cell(120, 1, '', 'R', 0, 'L');

		$pdf->Cell(20, 1, '', 'R', 0, 'C');

		$pdf->Cell(20, 1, '', 'R', 0, 'C');

		$pdf->Cell(20, 1, '', 'R', 0, 'C');

		$pdf->SetFont('', 'B', 5);

		$pdf->Cell(60, 1, '', 'LR', 1, 'L');

		$pdf->Cell(2, 1, '', 'LRB', 0, 'L');

		$pdf->Cell(120, 1, '', 'RB', 0, 'L');

		$pdf->Cell(20, 1, $lembur->namaPemeriksa, 'RB', 0, 'C');

		$pdf->Cell(20, 1, '', 'RB', 0, 'C');

		$pdf->Cell(20, 1, $lembur->namaAsman, 'RB', 0, 'C');

		$pdf->Cell(60, 1, '', 'LRB', 1, 'L');

		ob_end_clean();

		$pdf->Output('SPGJ ');

	}

	function download_excel() 
	{	
		$data['data'] = $this->ganti_jaga_model->show_validasi($this->session->filter_unit, $this->input->get('bulan'), $this->input->get('tahun'))->result();
		$data['bulan'] = $this->input->get('bulan');
		$data['tahun'] = $this->input->get('tahun');
		$this->load->view('ganti_jaga/ganti_jaga_excel', $data);
	}

}

