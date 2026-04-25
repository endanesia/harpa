<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Tunj_cuti extends Member_Control
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url'));
		$this->load->model(array('tunj_cuti_model'));
	}

	function index()
	{
		if (isset($_GET['skpd'])) {
			$data['tahun'] = $this->input->get('tahun');
			$data['unit'] = $this->input->get('skpd');
			$sess['filter_tahun'] = $data['tahun'];
			$sess['filter_unit'] = $data['unit'];
			$this->session->set_userdata($sess);
		} else {
			$data['tahun'] = $this->session->filter_tahun;
			$data['unit'] = $this->session->filter_unit;
			if ($data['tahun'] == "") {
				$data['tahun'] = date('Y');
			}
		}
		$data['bc'] = array('Dashboard' => site_url('dashboard'), 'Data Penggajian' => site_url('Tunj_cuti'));
		$data['title'] = "Data Tunjangan Cuti";
		$dt = $this->tunj_cuti_model->select($this->session->filter_unit, $this->session->filter_tahun)->result();
		$data['dt'] = $dt;
		$data['satkerja'] = $this->tunj_cuti_model->unit_kerja()->result();
		$this->template->mainview('tunj_cuti/gaji_index', $data);
	}

	function tunjangan()
	{
		$data['bc'] = array('Dashboard' => site_url('dashboard'), 'Tunjangan Gaji' => site_url('Gaji/tunjangan'));
		$data['title'] = "Data Tunjangan Gaji";
		$data['dt'] = $this->tunj_cuti_model->show_data($this->session->filter_unit, $this->session->filter_bulan, $this->session->filter_tahun)->result();
		$data['satkerja'] = $this->tunj_cuti_model->unit_kerja()->result();
		$this->template->mainview('gaji/gaji_tunjangan', $data);
	}

	function potongan()
	{
		$data['bc'] = array('Dashboard' => site_url('dashboard'), 'Potongan Gaji' => site_url('Gaji/potongan'));
		$data['title'] = "Data Potongan Gaji";
		$data['bulan'] = date("m");
		$data['tahun'] = date("Y");
		$data['dt'] = $this->tunj_cuti_model->show_data($this->session->filter_unit, $this->session->filter_bulan, $this->session->filter_tahun)->result();
		$data['satkerja'] = $this->tunj_cuti_model->unit_kerja()->result();
		$this->template->mainview('gaji/gaji_potongan', $data);
	}

	function hitung()
	{
		$tahun = $this->session->userdata('filter_tahun');
		if ($tahun == "") {
			$tahun = date('Y');
		}

		if (isset($_POST['tahun'])) {
			$tahun = $this->input->post('tahun');
			$sess['filter_tahun'] = $tahun;
			$this->session->set_userdata($sess);
		}
		$data['tahun'] = $tahun;
		$data['satkerja'] = $this->tunj_cuti_model->unit_kerja()->result();
		$data['bc'] = array('Dashboard' => site_url('dashboard'), 'Hitung Gaji' => site_url('Gaji/hitung'));
		$data['title'] = "Hitung Tunjangan Cuti Tahunan";
		$data['dt'] = $this->tunj_cuti_model->show_data($this->session->filter_unit, $this->session->filter_bulan, $this->session->filter_tahun)->result();
		$this->template->mainview('tunj_cuti/gaji_hitung', $data);
	}

	function thr()
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
		$data['satkerja'] = $this->tunj_cuti_model->unit_kerja()->result();
		$data['dt'] = $this->tunj_cuti_model->show_data($this->session->filter_unit, $this->session->filter_bulan, $this->session->filter_tahun)->result();
		$data['bc'] = array('Dashboard' => site_url('dashboard'), 'Hitung Gaji' => site_url('Gaji/thr'));
		$data['title'] = "Tunjangan Hari Raya";
		$this->template->mainview('gaji/gaji_thr', $data);
	}

	function hitung_tunj($satkerja, $tahun)
	{

		//1. cari nilai umk thn lalu
		$dtUmk = $this->tunj_cuti_model->GetUmk($satkerja, $tahun)->row();
		if (isset($dtUmk)) {
			$umk = ($dtUmk->nilaiUmk)/2;
		} else {
			$umk = 0;
		}

		$pegawai = $this->tunj_cuti_model->pegawai_unit($satkerja)->result();
		foreach ($pegawai as $peg) {
			$idPegawai = $peg->idtbPegawai;
			$nip = $peg->nipBaru;
			$tglGabung = $peg->tglBergabung;

			//1. cari jml cuti tahun ini

			$dtCuti = $this->tunj_cuti_model->GetCuti($idPegawai, $tahun)->row();
			if (isset($dtCuti)) {
				$jmlCuti = $dtCuti->jml * 100000;
			} else {
				$jmlCuti = 0;
			}

			//2. cari brp lama sudah bergabung
			$awal  = date_create($tglGabung);
			$akhir = date_create(); // waktu sekarang
			$diff  = date_diff($awal, $akhir);

			if ($diff->y >= 1) {
				$nilaiTunjangan = $umk - $jmlCuti;
			} else {
				$nilaiTunjangan = (($umk / 12) * $diff->m) - $jmlCuti;
			}
			if ($nilaiTunjangan < 0) {
				$nilaiTunjangan = 0;
			}	

			//3. simpan nilai tunjangan
			$dtTunj = $this->db->get_where('tbRwTCuti', array('nip' => $nip, 'tahun' => $tahun))->result();
			$data['nip'] = $nip;
			$data['bulan'] = date('m');
			$data['tahun'] = $tahun;
			$data['jml'] = $nilaiTunjangan;
			$data['id_unit'] = $satkerja;
			$data['jml_cuti'] = $jmlCuti / 100000;
			$data['umk'] = $umk;
			if (count($dtTunj) > 0) {
				$id = $dtTunj[0]->id;
				$this->db->where('id', $id);
				$this->db->update('tbRwTCuti', $data);
			} else {
				$this->db->insert('tbRwTCuti', $data);
			}
		}

		redirect(site_url('Tunj_cuti/hitung'));
	}

	function hitung_ulang($nip, $tahun)
	{
		$peg = $this->db->get_where('tbPegawai', array('nipBaru' => $nip))->row();
		$thnHitung = $tahun - 1;

		//1. cari nilai umk thn lalu
		$dtUmk = $this->tunj_cuti_model->GetUmk($peg->skpd, $thnHitung)->row();
		if (isset($dtUmk)) {
			$umk = $dtUmk->nilaiUmk;
		} else {
			$umk = 0;
		}

		$idPegawai = $peg->idtbPegawai;
		$idJabatan = $peg->idJabatan;
		$kelas = $peg->kelasJabatan;
		$gaji = $peg->gaji;
		$nip = $peg->nipBaru;
		$tglGabung = $peg->tglBergabung;

		//1. cari jml cuti tahun lalu

		$dtCuti = $this->tunj_cuti_model->GetCuti($idPegawai, $thnHitung)->row();
		if (isset($dtCuti)) {
			$jmlCuti = $dtCuti->jml * 100000;
		} else {
			$jmlCuti = 0;
		}

		//2. cari brp lama sudah bergabung
		$awal  = date_create($tglGabung);
		$akhir = date_create(); // waktu sekarang
		$diff  = date_diff($awal, $akhir);

		if ($diff->y >= 1) {
			$nilaiTunjangan = $umk - $jmlCuti;
		} else {
			$nilaiTunjangan = (($umk / 12) * $diff->m) - $jmlCuti;
		}

		//3. simpan nilai tunjangan
		$dtTunj = $this->db->get_where('tbRwTCuti', array('nip' => $nip, 'tahun' => $tahun))->result();
		$data['nip'] = $nip;
		$data['bulan'] = date('m');
		$data['tahun'] = $tahun;
		$data['jml'] = $nilaiTunjangan;
		$data['id_unit'] = $peg->skpd;
		$data['jml_cuti'] = $jmlCuti / 100000;
		$data['umk'] = $umk;
		if (count($dtTunj) > 0) {
			$id = $dtTunj[0]->id;
			$this->db->where('id', $id);
			$this->db->update('tbRwTCuti', $data);
		} else {
			$this->db->insert('tbRwTCuti', $data);
		}


		redirect(site_url('Tunj_cuti'));
	}

	function Simpan()
	{
		$id = $this->input->post('id');
		$data['umk'] = $this->input->post('umk');
		$data['jml_cuti'] = $this->input->post('jml_cuti');
		$data['jml'] = $data['umk'] - ($data['jml_cuti'] * 100000);
		$this->db->update('tbRwTCuti', $data, array('id' => $id));
		redirect(site_url('tunj_cuti'));
	}


	function thr_id($id)
	{
		$tgl_skr = date("Y-m-d");
		if (isset($this->session->filter_bulan) or isset($this->session->filter_tahun)) {
			$bln = $this->session->filter_bulan;
			$thn = $this->session->filter_tahun;
		} else {
			$bln = date('m');
			$thn = date('Y');
		}
		$pegawai = $this->tunj_cuti_model->pegawai_unit($id)->result();
		foreach ($pegawai as $pg) {
			$data['nip'] = $pg->nipBaru;
			$data['bulan'] = $bln;
			$data['tahun'] = $thn;
			//hitung jumlah
			$diff = date_diff(date_create($pg->tglBergabung), date_create($tgl_skr));
			$lama_kerja = $diff->format("%a");
			if ($lama_kerja >= 365) {
				$hitung = $pg->gaji * 1;
			} else {
				$hitung = $pg->gaji / 12;
			}
			$data['jml'] = $hitung;
			$data['id_unit'] = $id;
			$cekdata = $this->tunj_cuti_model->pegawai_id($pg->nipBaru, $bln, $thn)->num_rows();
			if ($cekdata < 1) {
				$this->tunj_cuti_model->input($data);
			} else {
				$this->tunj_cuti_model->update_nip($data, $pg->nipBaru);
			}
		}
		redirect(site_url() . '/gaji/hitung_thr');
	}

	function Update_thr()
	{
		$id = $this->input->post('id_thr');
		$thr['jml'] = $this->input->post('gaji_thr');
		$this->tunj_cuti_model->update($thr, $id);
		redirect(site_url() . '/gaji/thr');
	}

	function Cetak_all()
	{
		//data
		$unit = $this->tunj_cuti_model->unit_id($this->session->filter_unit)->row();
		$nama = $unit->nama;
		$dtthr = $this->tunj_cuti_model->show_data($this->session->filter_unit, $this->session->filter_bulan, $this->session->filter_tahun)->result();
		//file cetakan
		$pdf = new PDF();
		$pdf->SetPrintHeader(false);
		$pdf->SetPrintFooter(false);
		$pdf->AddPage('P', 'mm', 'A4');
		//content
		foreach ($dtthr as $thr) {
			$pegawai = $this->tunj_cuti_model->pegawai_person($thr->nip)->row();
			$jabatan = $this->tunj_cuti_model->jabatan($pegawai->idJabatan)->row();
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
			$pdf->Cell(50, 5, 'SHIFT', '', 1, 'L');
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
			$pdf->Cell(210, 5, '----------------------------------------------------------------------------------------------------------------------------------------------------', '', 1, 'L');
		}
		ob_end_clean();
		$pdf->Output('Slip Gaji THR ' . $nama);
	}

	function Cetak_Satuan($id)
	{
		//data
		$unit = $this->tunj_cuti_model->unit_id($this->session->filter_unit)->row();
		$nama = $unit->nama;
		$dtthr = $this->tunj_cuti_model->thr_id($id)->result();
		//file cetakan
		$pdf = new PDF();
		$pdf->SetPrintHeader(false);
		$pdf->SetPrintFooter(false);
		$pdf->AddPage('P', 'mm', 'A4');
		//content
		foreach ($dtthr as $thr) {
			$pegawai = $this->tunj_cuti_model->pegawai_person($thr->nip)->row();
			$jabatan = $this->tunj_cuti_model->jabatan($pegawai->idJabatan)->row();
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
			$pdf->Cell(50, 5, 'SHIFT', '', 1, 'L');
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
			$pdf->Cell(210, 4, '', '', 1, 'L');
			//total gaji
			$gaji_kotor = $thr->jml;
			$pdf->Cell(45, 5, 'THR Kotor', '', 0, 'L');
			$pdf->Cell(5, 5, ':', '', 0, 'L');
			$pdf->Cell(25, 5, number_format($gaji_kotor, "0", ",", "."), '', 0, 'R');
			$pdf->Cell(15, 5, '', '', 0, 'R');
			//Gaji Dibayarkan
			$pdf->Cell(25, 5, 'THR dibayar', '', 0, 'L');
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
			$pdf->Cell(210, 5, '----------------------------------------------------------------------------------------------------------------------------------------------------', '', 1, 'L');
		}
		ob_end_clean();
		$pdf->Output('Slip Gaji THR ' . $pegawai->namaPegawai);
	}

	function Cetak_Gaji_Satuan($id)
	{
		//data

		$dt  = $this->tunj_cuti_model->select_id($id)->row();

		//file cetakan
		$pdf = new PDF();
		$pdf->SetPrintHeader(false);
		$pdf->SetPrintFooter(false);
		$pdf->AddPage('P', 'mm', 'A4');
		//content
		$pdf->SetFont('', 'B', 10);
		$pdf->Cell(190, 13, 'TUNJANGAN CUTI ' . $dt->tahun, '', 1, 'C');
		$pdf->SetFont('', 'R', 10);
		//baris 1
		$pdf->Cell(15, 5, 'NID', '', 0, 'L');
		$pdf->Cell(5, 5, ':', '', 0, 'L');
		$pdf->Cell(70, 5, $dt->nip, '', 0, 'L');
		$pdf->Cell(40, 5, 'Nama', '', 0, 'L');
		$pdf->Cell(5, 5, ':', '', 0, 'L');
		$pdf->Cell(50, 5, $dt->namaPegawai, '', 1, 'L');

		//baris 3
		$pdf->Cell(90, 5, '', '', 0, 'L');
		$pdf->Cell(40, 5, 'Jabatan', '', 0, 'L');
		$pdf->Cell(5, 5, ':', '', 0, 'L');
		$pdf->Cell(50, 5, $dt->jabatan, '', 1, 'L');
		//baris kosong
		$pdf->Cell(210, 4, '', '', 1, 'L');
		//judul pendapatan potongan
		$pdf->SetFont('', 'B', 10);
		$pdf->Cell(30, 5, 'RINCIAN', '', 1, 'L');
		$pdf->SetFont('', 'R', 10);

		//baris 1
		$pdf->Cell(20, 5, 'UMK', '', 0, 'L');
		$pdf->Cell(5, 5, ':', '', 0, 'L');
		$pdf->Cell(65, 5, 'Rp.' . number_format($dt->umk, 0, ',', '.'), '', 0, 'L');
		$pdf->Cell(40, 5, 'Total Tunjangan', '', 0, 'L');
		$pdf->Cell(5, 5, ':', '', 0, 'L');
		$pdf->Cell(50, 5, 'Rp.' . number_format($dt->jml, 0, ',', '.'), '', 1, 'L');

		//baris 3
		$pdf->Cell(20, 5, 'Jml Cuti', '', 0, 'L');
		$pdf->Cell(5, 5, ':', '', 0, 'L');
		$pdf->Cell(50, 5, $dt->jml_cuti . ' hari', '', 1, 'L');


		//detail pendapatan


		$pdf->SetFont('', 'R', 10);



		//Kosong
		$pdf->Cell(210, 5, '', '', 1, 'L');
		//no Rek
		$pdf->Cell(20, 5, 'Rekening', '', 0, 'L');
		$pdf->Cell(5, 5, ':', '', 0, 'L');
		$pdf->Cell(40, 5, $dt->norek, '', 0, 'L');
		//kota tanggal
		$pdf->Cell(15, 5, 'Malang', '', 0, 'L');
		$pdf->Cell(5, 5, ',', '', 0, 'L');
		$pdf->Cell(40, 5, date("d/m/Y"), '', 0, 'L');
		$pdf->Cell(210, 5, '', '', 1, 'L');
		$pdf->Cell(210, 5, '----------------------------------------------------------------------------------------------------------------------------------------------------', '', 1, 'L');
		ob_end_clean();
		$pdf->Output('Slip Tunj Cuti ' . $dt->namaPegawai);
	}
	function Cetak_Gaji_Semua($satkerja,$tahun)
	{

		$tunj = $this->tunj_cuti_model->select($satkerja, $tahun)->result();
		//file cetakan
		$pdf = new PDF();
		$pdf->SetPrintHeader(false);
		$pdf->SetPrintFooter(false);
		$pdf->AddPage('P', 'mm', 'A4');
		foreach ($tunj as $dt) {
		//content
		$pdf->SetFont('', 'B', 10);
		$pdf->Cell(190, 13, 'TUNJANGAN CUTI ' . $dt->tahun, '', 1, 'C');
		$pdf->SetFont('', 'R', 10);
		//baris 1
		$pdf->Cell(15, 5, 'NID', '', 0, 'L');
		$pdf->Cell(5, 5, ':', '', 0, 'L');
		$pdf->Cell(70, 5, $dt->nip, '', 0, 'L');
		$pdf->Cell(40, 5, 'Nama', '', 0, 'L');
		$pdf->Cell(5, 5, ':', '', 0, 'L');
		$pdf->Cell(50, 5, $dt->namaPegawai, '', 1, 'L');

		//baris 3
		$pdf->Cell(90, 5, '', '', 0, 'L');
		$pdf->Cell(40, 5, 'Jabatan', '', 0, 'L');
		$pdf->Cell(5, 5, ':', '', 0, 'L');
		$pdf->Cell(50, 5, $dt->jabatan, '', 1, 'L');
		//baris kosong
		$pdf->Cell(210, 4, '', '', 1, 'L');
		//judul pendapatan potongan
		$pdf->SetFont('', 'B', 10);
		$pdf->Cell(30, 5, 'RINCIAN', '', 1, 'L');
		$pdf->SetFont('', 'R', 10);

		//baris 1
		$pdf->Cell(20, 5, 'UMK', '', 0, 'L');
		$pdf->Cell(5, 5, ':', '', 0, 'L');
		$pdf->Cell(65, 5, 'Rp.' . number_format($dt->umk, 0, ',', '.'), '', 0, 'L');
		$pdf->Cell(40, 5, 'Total Tunjangan', '', 0, 'L');
		$pdf->Cell(5, 5, ':', '', 0, 'L');
		$pdf->Cell(50, 5, 'Rp.' . number_format($dt->jml, 0, ',', '.'), '', 1, 'L');

		//baris 3
		$pdf->Cell(20, 5, 'Jml Cuti', '', 0, 'L');
		$pdf->Cell(5, 5, ':', '', 0, 'L');
		$pdf->Cell(50, 5, $dt->jml_cuti . ' hari', '', 1, 'L');


		//detail pendapatan


		$pdf->SetFont('', 'R', 10);



		//Kosong
		$pdf->Cell(210, 5, '', '', 1, 'L');
		//no Rek
		$pdf->Cell(20, 5, 'Rekening', '', 0, 'L');
		$pdf->Cell(5, 5, ':', '', 0, 'L');
		$pdf->Cell(40, 5, $dt->norek, '', 0, 'L');
		//kota tanggal
		$pdf->Cell(15, 5, 'Malang', '', 0, 'L');
		$pdf->Cell(5, 5, ',', '', 0, 'L');
		$pdf->Cell(40, 5, date("d/m/Y"), '', 0, 'L');
		$pdf->Cell(210, 5, '', '', 1, 'L');
		$pdf->Cell(210, 5, '----------------------------------------------------------------------------------------------------------------------------------------------------', '', 1, 'L');			
		}
		ob_end_clean();
		$pdf->Output('Slip Tunj Cuti ');
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
		$data['bc'] = array('Dashboard' => site_url('dashboard'), 'Data Penggajian' => site_url('Gaji'), 'Edit' => site_url("Gaji/Edit/$id"));
		$data['title'] = "Data Penggajian";
		$data['unitKerja'] = $this->db->get_where('tbSatKerja', array('id' => $pegawai->skpd))->row();
		$data['jabatan'] = $this->db->get_where('tbJabatan', array('idJabatan' => $pegawai->idJabatan))->row();
		$data['kelas'] = $this->db->get_where('tbKelasJabatan', array('id' => $pegawai->kelasJabatan))->row();
		$data['id'] = $id;
		$this->template->mainview('gaji/gaji_edit', $data);
	}


	function Simpan_edit($id)
	{
		$this->db->update('tbRwGaji', $_POST, array('id' => $id));
		redirect(site_url('Gaji'));
	}
}
