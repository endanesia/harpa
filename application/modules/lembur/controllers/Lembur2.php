<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Lembur extends Member_Control

{



	public function __construct()

	{

		parent::__construct();

		$this->load->helper(array('url'));

		$this->load->model(array('Lembur_model'));

	}



	function index()

	{

		return $this->show();

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

		$data['bc'] = array('Dashboard' => site_url('dashboard'), 'Pegawai Lembur' => site_url('lembur'));

		$data['title'] = "Surat Perintah Kerja Lembur";

		$data['dt'] = $this->Lembur_model->show_data($this->session->filter_unit, $this->session->filter_bulan, $this->session->filter_tahun)->result();

		if ($this->session->userdata('akses') == 1) {

			$data['satkerja'] = $this->Lembur_model->unit_kerja()->result();

		} else {

			$data['satkerja'] = $this->Lembur_model->unit_kerja($this->session->userdata('unit'))->result();

		}

		$this->template->mainview('lembur/lembur_index', $data);

	}



	function Pegawai_lembur($wo)

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

		$data['bc'] = array('Dashboard' => site_url('dashboard'), 'Pegawai Lembur' => site_url('lembur'));

		$data['title'] = "Surat Perintah Kerja Lembur";

		$data['dt'] = $this->Lembur_model->show_data($this->session->filter_unit, $this->session->filter_bulan, $this->session->filter_tahun)->result();

		$data['satkerja'] = $this->Lembur_model->unit_kerja()->result();

		$this->template->mainview('lembur/personel_lembur_index', $data);

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

		$data['bc'] = array('Dashboard' => site_url('dashboard'), 'Validasi SPKL' => site_url('lembur/validasi'));

		$data['title'] = "Validasi Surat Perintah Kerja Lembur";

		$data['dt'] = $this->Lembur_model->show_data($this->session->filter_unit, $this->session->filter_bulan, $this->session->filter_tahun)->result();

		$data['satkerja'] = $this->Lembur_model->unit_kerja()->result();

		$this->template->mainview('lembur/lembur_validasi', $data);

	}



	function Simpan()

	{

		if (empty($this->session->userdata('filter_unit'))) {

			redirect(site_url() . '/lembur/Error_input');

		} else {

			/* $nomerwo = $this->Lembur_model->show_data_all(date('m'), date('Y'))->row();

			if (empty($nomerwo)) {

				$wo = date('y') . date('m') . '01';

			} else {

				$urutan = substr($nomerwo->noWo, 4);

				$urut = $urutan + 1;

				$angka = strlen($urut);

				$nol = '';

				for ($i = $angka; $i < 2; $i++) {

					$nol = $nol . '0';

				}

				$wo = date('y') . date('m') . $nol . $urut;

			}

			$pgid = $this->Lembur_model->pegawai_id($this->input->post('pegawai'))->row(); */



			//cari jml Jam lembur

			$jam_awal = intval($this->input->post('jam_awal_lembur'));

			$mnt_awal = intval($this->input->post('menit_awal_lembur'));

			$jam_akhir = intval($this->input->post('jam_akhir_lembur'));

			$mnt_akhir = intval($this->input->post('menit_akhir_lembur'));

			$jmlJam = 0;

			$jmlMnt = 0;

			if ($jam_akhir > $jam_awal) {

				//masih dalam satu hari

				$jmlMnt = $mnt_akhir - $mnt_awal;

				$jmlJam = $jam_akhir - $jam_awal;

				if ($jmlMnt < 0) {

					$jmlJam = $jmlJam - 1;

				}

			} else {

				//lembur lewat hari

				$jmlJam = 24 - $jam_awal;

				$jmlJam = $jmlJam + $jam_akhir;

			}



			$lembur['jmlJam'] = $jmlJam;

			$lembur['noWo'] = $this->input->post('wo');;

			$lembur['skpd'] = $this->session->userdata('filter_unit');

			$lembur['uraian'] = $this->input->post('uraian_lembur');

			$lembur['kodeAktifitas'] = $this->input->post('aktivitas');

			$lembur['tglLembur'] = $this->input->post('tgl_wo');

			$lembur['mulai'] = $this->input->post('jam_awal_lembur') . ':' . $this->input->post('menit_awal_lembur');

			$lembur['sampai'] = $this->input->post('jam_akhir_lembur') . ':' . $this->input->post('menit_akhir_lembur');

			$lembur['statusHari'] = $this->input->post('hari');

			$lembur['bebanAnggaran'] = $this->input->post('beban_anggaran');

			$lembur['namaPemberiTugas'] = $this->input->post('nama_pt');

			$lembur['nidPemberiTugas'] = $this->input->post('nid_pt');

			$lembur['tglPemberiTugas'] = $this->input->post('tgl_pt');

			$lembur['namaPemeriksa'] = $this->input->post('nama_periksa');

			$lembur['nidPemeriksa'] = $this->input->post('nid_periksa');

			$lembur['tglPemeriksa'] = $this->input->post('tgl_periksa');

			$lembur['namaAsman'] = $this->input->post('asman');

			$hasil = $this->Lembur_model->input_lembur($lembur);

			redirect(site_url() . '/lembur');

		}

	}



	function Error_input()

	{

		$data['error'] = "Data Gagal disimpan Unit belum dipilih";

		$data['bc'] = array('Dashboard' => site_url('dashboard'), 'Pegawai Lembur' => site_url('lembur'));

		$data['title'] = "Surat Perintah Kerja Lembur";

		$data['dt'] = $this->Lembur_model->show_data($this->session->filter_unit, $this->session->filter_bulan, $this->session->filter_tahun)->result();

		$data['satkerja'] = $this->Lembur_model->unit_kerja()->result();

		$this->template->mainview('lembur/lembur_index', $data);

	}



	function Simpan_pegawai_lembur()

	{

		//cari data lembur untuk mendapatkan jumlah jam dan hari kerja

		$dt = $this->Lembur_model->lembur($this->input->post('id_lembur'))->row();

		$jmlJam = $dt->jmlJam;

		$hari = $dt->statusHari;



		//cari data pegawai untuk mendapatkan apakah dia punya tunjangan lembur atau tidak

		$peg = $this->Lembur_model->pegawai_id($this->input->post('pegawai'))->row();

		$gaji = $peg->gaji + $peg->tunjanganTetap;





		// print_r($peg);

		// die;

		//cari tarif lembur sesuai data pegawai yg bersangkutan

		$tarif = $this->db->get_where('tbMasterLembur', array('idSatKerja' => $peg->skpd, 'idJabatan' => $peg->idJabatan, 'idKelasJabatan' => $peg->kelasJabatan))->result();





		if (count($tarif) > 0) {

			$nilaiLembur = $gaji * $tarif[0]->tarif;

			$nominal = 0;

			$uangMakan = 0;

			if ($hari == 'Libur') {

				//hari libur

				//uang makan

				if ($jmlJam >= 8) {

					$uangMakan = $tarif[0]->uang_makan;

				}

				//uang lembur

				if ($jmlJam > 10) {

					$nominal1 = ($nilaiLembur * $tarif[0]->satujam_libur) * 8;

					$nominal910 = ($nilaiLembur * $tarif[0]->sembilanjam_libur) * 2;

					$sisaJam = $jmlJam - 10;

					$nominal11 =  ($nilaiLembur * $tarif[0]->sepuluhjam_lebih) * $sisaJam;

					$nominal = $nominal1 + $nominal910 + $nominal11;

				} elseif ($jmlJam >= 9 && $jmlJam <= 10) {

					$nominal1 = ($nilaiLembur * $tarif[0]->satujam_libur) * 8;

					$sisaJam = $jmlJam - 8;

					$nominal910 = ($nilaiLembur * $tarif[0]->sembilanjam_libur) * $sisaJam;

					$nominal = $nominal1 + $nominal910;

				} elseif ($jmlJam >= 1 && $jmlJam <= 8) {

					$nominal = ($nilaiLembur * $tarif[0]->satujam_libur) * $jmlJam;

				}

			} else {

				//hari kerja

				//uang makan

				if ($jmlJam >= 8) {

					$uangMakan = $tarif[0]->uang_makan;

				}



				if ($jmlJam > 8) {

					$nominal1 = ($nilaiLembur * $tarif[0]->satujam);

					$nominal28 = ($nilaiLembur * $tarif[0]->duajam) * 7;

					$sisaJam = $jmlJam - 8;

					$nominal9 = ($nilaiLembur * $tarif[0]->delapanjam_lebih) * $sisaJam;

					$nominal = $nominal1 + $nominal28 + $nominal9;

				} elseif ($jmlJam >= 2 && $jmlJam <= 8) {

					$nominal1 = ($nilaiLembur * $tarif[0]->satujam);

					$sisaJam = $jmlJam - 1;

					$nominal28 = ($nilaiLembur * $tarif[0]->duajam) * $sisaJam;

					$nominal = $nominal1 + $nominal28;

				} elseif ($jmlJam == 1) {

					$nominal = ($nilaiLembur * $tarif[0]->satujam) * $jmlJam;

				}

			}

			$pl['nilai'] = $nominal;

			$pl['uangMakan'] = $uangMakan;

		} else {

			$pl['nilai'] = 0;

			$pl['uangMakan'] = 0;

		}



		$pl['idLembur'] = $this->input->post('id_lembur');

		$pl['idtbPegawai'] = $this->input->post('pegawai');

		$hasil = $this->Lembur_model->input_lembur_detail($pl);

		redirect(site_url() . '/lembur');

	}



	function Hapus_pegawai_lembur($id)

	{

		$hasil = $this->Lembur_model->Hapus_lembur_detail($id);

		redirect(site_url() . '/lembur');

	}



	function Update()

	{

		//cari jml Jam lembur

		$jam_awal = intval($this->input->post('jam_awal_lembur'));

		$mnt_awal = intval($this->input->post('menit_awal_lembur'));

		$jam_akhir = intval($this->input->post('jam_akhir_lembur'));

		$mnt_akhir = intval($this->input->post('menit_akhir_lembur'));

		$jmlJam = 0;

		$jmlMnt = 0;

		if ($jam_akhir > $jam_awal) {

			//masih dalam satu hari

			$jmlMnt = $mnt_akhir - $mnt_awal;

			$jmlJam = $jam_akhir - $jam_awal;

			if ($jmlMnt < 0) {

				$jmlJam = $jmlJam - 1;

			}

		} else {

			//lembur lewat hari

			$jmlJam = 24 - $jam_awal;

			$jmlJam = $jmlJam + $jam_akhir;

		}



		$lembur['jmlJam'] = $jmlJam;

		$lembur['uraian'] = $this->input->post('uraian_lembur');

		$lembur['kodeAktifitas'] = $this->input->post('aktivitas');

		$lembur['tglLembur'] = $this->input->post('tgl_wo');

		$lembur['mulai'] = $this->input->post('jam_awal_lembur') . ':' . $this->input->post('menit_awal_lembur');

		$lembur['sampai'] = $this->input->post('jam_akhir_lembur') . ':' . $this->input->post('menit_akhir_lembur');

		$lembur['statusHari'] = $this->input->post('hari');

		$lembur['bebanAnggaran'] = $this->input->post('beban_anggaran');

		$lembur['namaPemberiTugas'] = $this->input->post('nama_pt');

		$lembur['nidPemberiTugas'] = $this->input->post('nid_pt');

		$lembur['tglPemberiTugas'] = $this->input->post('tgl_pt');

		$lembur['namaPemeriksa'] = $this->input->post('nama_periksa');

		$lembur['nidPemeriksa'] = $this->input->post('nid_periksa');

		$lembur['tglPemeriksa'] = $this->input->post('tgl_periksa');

		$lembur['namaAsman'] = $this->input->post('asman');

		$hasil = $this->Lembur_model->update($lembur, $this->input->post('id'));

		redirect(site_url() . '/lembur');

	}



	function Update_valid($id)

	{



		$lembur['status'] = 1;

		$lembur['tgl_validasi'] = date('Y-m-d');

		$hasil = $this->Lembur_model->update($lembur, $id);

		redirect(site_url() . '/lembur/Validasi');

	}



	function Update_invalid($id)

	{



		$lembur['status'] = 0;

		$hasil = $this->Lembur_model->update($lembur, $id);

		redirect(site_url() . '/lembur/Validasi');

	}





	function Hapus($id)

	{

		$this->Lembur_model->Delete_lembur_detail($id);

		$this->Lembur_model->Delete_lembur($id);

		redirect(site_url() . '/lembur');

	}



	function GetShift()

	{

		$id = $_POST['id'];

		$dt = $this->lembur_model->get_by_id($id)->row();

		echo json_encode($dt);

	}



	// Laporan=====================================================================================================================



	function Cetak_lembur($id)

	{

		$dlembur = $this->Lembur_model->pegawai_lembur($id)->row();

		if (!isset($dlembur)) {

			$this->session->set_flashdata('cetak', 'isi pesan');

			redirect(site_url() . '/lembur');

		} else {

			//Logo

			$img = base_url() . '/assets/imgs/PLN-Nusantara-Power-5p.png';

			$pdf = new pdf();

			$pdf->SetPrintHeader(false);

			$pdf->SetPrintFooter(false);

			$pdf->AddPage('P', 'mm', array(105, 165));

			$lembur = $this->Lembur_model->lembur($id)->row();

			$unit = $this->Lembur_model->unit_kerja_id($lembur->skpd)->row();

			//kop surat

			$pdf->SetFont('', 'B', 7);

			$pdf->image($img, 10, 11, 20, 5,);

			$pdf->Cell(20, 8, '', 0, 0, 'L');

			$pdf->Cell(30, 1, 'PT PLN NUSANTARA POWER', 0, 0, 'L');

			$pdf->Cell(120, 1, 'SURAT PERINTAH KERJA LEMBUR', 0, 0, 'C');

			$dlembur = $this->Lembur_model->pegawai_lembur($id)->row();

			$pegl = $this->Lembur_model->pegawai_id($dlembur->idtbPegawai)->row();

			if (($pegl->jabatan == "SATUAN PENGAMANAN") || ($pegl->jabatan == "CP KTH") || ($pegl->jabatan == "CP KTH") || ($pegl->jabatan == "TENAGA HELPER CCR") || ($pegl->jabatan == "TENAGA BANTU TEKNISI MESIN PPS")) {

				$pdf->Cell(20, 1, 'SHIFT', 1, 1, 'L');

			} else {

				$pdf->Cell(20, 1, 'NON SHIFT', 1, 1, 'L');

			}

			$pdf->Cell(20, 8, '', 0, 0, 'L');

			$pdf->Cell(30, 1, 'UNIT PEMBANGKITAN BRANTAS', 0, 0, 'L');

			$pdf->Cell(120, 1, '(SPKL)', 0, 0, 'C');

			$pdf->Cell(30, 10, '', 0, 1, 'L');

			//content panjang 190

			$pdf->SetFont('', 'B', 6);

			$pdf->Cell(1, 1, '', 0, 0, 'L');

			$pdf->Cell(185, 1, '*1-7 Harus di isi semua', 0, 1, 'L');

			$pdf->SetFont('', 'B', 8);

			//kotak 1

			$pdf->SetFillColor(215, 215, 215);

			$pdf->Cell(2, 1, '', 'LT', 0, 'L');

			$pdf->Cell(94, 1, '1. Deskripsi Dari Pekerjaan yang di Lemburkan :', 1, 0, 'L', true);

			$pdf->Cell(94, 1, '3. Nomor :', 1, 1, 'L', true);

			$no = 0;

			$dlembur = $this->Lembur_model->pegawai_lembur($id)->result();

			foreach ($dlembur as $spkl) {

				$pegl = $this->Lembur_model->pegawai_id($spkl->idtbPegawai)->row();

				$no++;

				if ($no == 1) {

					$pdf->Cell(2, 1, '', 'LR', 0, 'L');

					$pdf->Cell(42, 1, 'Nama Pegawai yang Lembur :', 0, 0, 'L');

					$pdf->Cell(52, 1, $no.'. '.$pegl->namaPegawai, 'R', 0, 'L');

					//kolom 2

					$pdf->Cell(94, 1, $lembur->noWo, 'R', 1, 'L');

				} else {

					$pdf->Cell(2, 1, '', 'LR', 0, 'L');

					$pdf->Cell(42, 1, '', 0, 0, 'L');

					$pdf->Cell(52, 1, $no.'. '.$pegl->namaPegawai, 'R', 0, 'L');

					//kolom 2

					$pdf->Cell(94, 1, '', 'R', 1, 'L');

				}

				//$jabatan = $pegl->jabatan;

			}
					
					$pdf->Cell(2, 1, '', 'LR', 0, 'L');

					$pdf->Cell(42, 1, '', 0, 0, 'L');

					$pdf->Cell(52, 1, '', 'R', 0, 'L');

					$pdf->Cell(94, 1, '', 'R', 1, 'L');
			
			//jabatan
			
			$nojab = 0;

			$dlembur = $this->Lembur_model->pegawai_lembur($id)->result();
		
				foreach ($dlembur as $spkl) {
		
						$pegl = $this->Lembur_model->pegawai_id($spkl->idtbPegawai)->row();
		
						$nojab++;
						
						if($nojab==1)
						{	
							$pdf->Cell(2, 1, '', 'LR', 0, 'L');

							$pdf->Cell(38, 1, 'JABATAN', '', 0, 'L');
							
							$pdf->Cell(3, 1, ' : ', '', 0, 'L');

							$pdf->Cell(53, 1, ' '.$nojab.'. '.$pegl->jabatan, '', 0, 'L');

							//kolom 2

							$pdf->Cell(94, 1, '', 'LR', 1, 'L');	
						
						}
						else
						{
							$pdf->Cell(2, 1, '', 'LR', 0, 'L');

							$pdf->Cell(38, 1, '', '', 0, 'L');
							
							$pdf->Cell(3, 1, '', '', 0, 'L');

							$pdf->Cell(53, 1, ' '.$nojab.'. '.$pegl->jabatan, '', 0, 'L');

							//kolom 2

							$pdf->Cell(94, 1, '', 'LR', 1, 'L');	
						
						}
					}

			$pdf->Cell(2, 1, '', 'LR', 0, 'L');

			$pdf->Cell(94, 1, '', 'LRB', 0, 'L');

			$pdf->Cell(94, 1, '', 'LRB', 1, 'L');

			//kotak 2

			$pdf->Cell(2, 1, '', 'LR', 0, 'L');

			$pdf->Cell(94, 1, '2. Uraian Pekerjaan yang dilemburkan, sasaran dan alasannya :', 1, 0, 'L', true);

			$pdf->Cell(94, 1, '4. Kode Aktifitas (*) :', 1, 1, 'L', true);

			//uraian baris 1

			$pdf->Cell(2, 1, '', 'LR', 0, 'L');

			$pdf->Cell(94, 1, substr($lembur->uraian, 0, 67), 'LR', 0, 'L');

			$pdf->Cell(94, 1, $lembur->kodeAktifitas, 'LR', 1, 'L');

			//uraian baris 2

			$pdf->Cell(2, 1, '', 'LR', 0, 'L');

			$pdf->Cell(94, 1, substr($lembur->uraian, 67, 67), 'LR', 0, 'L');

			$pdf->Cell(94, 1, '', 'LR', 1, 'L');

			//uraian baris 3

			$pdf->Cell(2, 1, '', 'LR', 0, 'L');

			$pdf->Cell(94, 1, substr($lembur->uraian, 134, 67), 'LR', 0, 'L');

			$pdf->Cell(94, 1, '', 'LR', 1, 'L');

			$pdf->Cell(2, 1, '', 'LR', 0, 'L');

			$pdf->Cell(94, 1, '', 'LR', 0, 'L');

			$pdf->Cell(94, 1, '', 'LR', 1, 'L');

			$pdf->Cell(2, 1, '', 'LR', 0, 'L');

			$pdf->Cell(94, 1, '', 'LRB', 0, 'L');

			$pdf->Cell(94, 1, '', 'LRB', 1, 'L');

			//kotak 3

			if ($lembur->statusHari == "Kerja") {

				$pdf->Cell(2, 1, '', 'LR', 0, 'L');

				//hari kerja

				$pdf->Cell(60, 1, 'Hari Masuk Tanggal :', 'LR', 0, 'L');

				$pdf->Cell(34, 1, 'Jam :', 'LR', 0, 'L');

				$pdf->Cell(94, 1, '5. Beban Anggaran :', 1, 1, 'L', true);

				$pdf->Cell(2, 1, '', 'LR', 0, 'L');

				$pdf->Cell(60, 1, date("d-m-Y", strtotime($lembur->tglLembur)), 'LR', 0, 'L');

				$pdf->Cell(34, 1, $lembur->mulai . ' - ' . $lembur->sampai, 'LR', 0, 'L');

				$pdf->Cell(94, 1, $lembur->bebanAnggaran, 'R', 1, 'L');

				$pdf->Cell(2, 1, '', 'LR', 0, 'L');

				$pdf->Cell(60, 1, '', 'LR', 0, 'L');

				$pdf->Cell(34, 1, '', 'LR', 0, 'L');

				$pdf->Cell(94, 1, '', 'R', 1, 'L');

				$pdf->Cell(2, 1, '', 'LR', 0, 'L');

				$pdf->Cell(60, 1, '', 'LRB', 0, 'L');

				$pdf->Cell(34, 1, '', 'LRB', 0, 'L');

				$pdf->Cell(94, 1, '', 'R', 1, 'L');

				//hari libur

				$pdf->Cell(2, 1, '', 'LR', 0, 'L');

				$pdf->Cell(60, 1, 'Hari Libur Tanggal :', 'LR', 0, 'L');

				$pdf->Cell(34, 1, 'Jam :', 'LR', 0, 'L');

				$pdf->Cell(94, 1, '', 'LR', 1, 'L');

				$pdf->Cell(2, 1, '', 'LR', 0, 'L');

				$pdf->Cell(60, 1, '', 'LR', 0, 'L');

				$pdf->Cell(34, 1, '', 'LR', 0, 'L');

				$pdf->Cell(94, 1, '', 'R', 1, 'L');

				$pdf->Cell(2, 1, '', 'LR', 0, 'L');

				$pdf->Cell(60, 1, '', 'LR', 0, 'L');

				$pdf->Cell(34, 1, '', 'LR', 0, 'L');

				$pdf->Cell(94, 1, '', 'R', 1, 'L');

				$pdf->Cell(2, 1, '', 'LR', 0, 'L');

				$pdf->Cell(60, 1, '', 'LRB', 0, 'L');

				$pdf->Cell(34, 1, '', 'LRB', 0, 'L');

				$pdf->Cell(94, 1, '', 'RB', 1, 'L');

			} else {

				$pdf->Cell(2, 1, '', 'LR', 0, 'L');

				//hari kerja

				$pdf->Cell(60, 1, 'Hari Masuk Tanggal :', 'LR', 0, 'L');

				$pdf->Cell(34, 1, 'Jam :', 'LR', 0, 'L');

				$pdf->Cell(94, 1, '5. Beban Anggaran :', 1, 1, 'L', true);

				$pdf->Cell(2, 1, '', 'LR', 0, 'L');

				$pdf->Cell(60, 1, '', 'LR', 0, 'L');

				$pdf->Cell(34, 1, '', 'LR', 0, 'L');

				$pdf->Cell(94, 1, $lembur->bebanAnggaran, 'R', 1, 'L');

				$pdf->Cell(2, 1, '', 'LR', 0, 'L');

				$pdf->Cell(60, 1, '', 'LR', 0, 'L');

				$pdf->Cell(34, 1, '', 'LR', 0, 'L');

				$pdf->Cell(94, 1, '', 'R', 1, 'L');

				$pdf->Cell(2, 1, '', 'LR', 0, 'L');

				$pdf->Cell(60, 1, '', 'LRB', 0, 'L');

				$pdf->Cell(34, 1, '', 'LRB', 0, 'L');

				$pdf->Cell(94, 1, '', 'R', 1, 'L');

				//hari libur

				$pdf->Cell(2, 1, '', 'LR', 0, 'L');

				$pdf->Cell(60, 1, 'Hari Libur Tanggal :', 'LR', 0, 'L');

				$pdf->Cell(34, 1, 'Jam :', 'LR', 0, 'L');

				$pdf->Cell(94, 1, '', 'LR', 1, 'L');

				$pdf->Cell(2, 1, '', 'LR', 0, 'L');

				$pdf->Cell(60, 1, date("d-m-Y", strtotime($lembur->tglLembur)), 'LR', 0, 'L');

				$pdf->Cell(34, 1, $lembur->mulai . ' - ' . $lembur->sampai, 'LR', 0, 'L');

				$pdf->Cell(94, 1, '', 'R', 1, 'L');

				$pdf->Cell(2, 1, '', 'LR', 0, 'L');

				$pdf->Cell(60, 1, '', 'LR', 0, 'L');

				$pdf->Cell(34, 1, '', 'LR', 0, 'L');

				$pdf->Cell(94, 1, '', 'R', 1, 'L');

				$pdf->Cell(2, 1, '', 'LR', 0, 'L');

				$pdf->Cell(60, 1, '', 'LRB', 0, 'L');

				$pdf->Cell(34, 1, '', 'LRB', 0, 'L');

				$pdf->Cell(94, 1, '', 'RB', 1, 'L');

			}

			//kotak 4

			$pdf->Cell(2, 1, '', 'LR', 0, 'L');

			$pdf->Cell(94, 1, '6. YANG MENUGASKAN', 1, 0, 'L', true);

			$pdf->Cell(60, 1, 'Mengetahui :', 1, 0, 'C', true);

			$pdf->SetFont('', 'BU', 4);

			$pdf->Cell(34, 1, 'Ket. Kode Aktifitas (*) :', 'LR', 1, 'L');

			$pdf->SetFont('', 'B', 8);

			$pdf->Cell(2, 1, '', 'LR', 0, 'L');

			$pdf->Cell(94, 1, '', 'R', 0, 'L');

			$pdf->Cell(60, 1, '', 'R', 0, 'C');

			$pdf->SetFont('', 'B', 5);

			$pdf->Cell(34, 1, '18   = K3', 'LR', 1, 'L');

			$pdf->SetFont('', 'B', 8);

			$pdf->Cell(2, 1, '', 'LR', 0, 'L');

			$pdf->Cell(94, 1, 'Nama          : ' . $lembur->namaPemberiTugas, 'R', 0, 'L');

			$pdf->SetFont('', 'B', 5);

			$pdf->Cell(20, 1, 'Pemeriksa', 'R', 0, 'C');

			$pdf->Cell(20, 1, 'ASMAN Bidang', 'R', 0, 'C');

			$pdf->Cell(20, 1, 'ASMAN', 'R', 0, 'C');

			$pdf->SetFont('', 'B', 5);

			$pdf->Cell(34, 1, '19   = Lingkungan', 'LR', 1, 'L');

			$pdf->SetFont('', 'B', 5);

			$pdf->Cell(2, 1, '', 'LR', 0, 'L');

			$pdf->Cell(94, 1, '', 'R', 0, 'L');

			$pdf->Cell(20, 1, 'Hasil', 'R', 0, 'C');

			$pdf->Cell(20, 1, '', 'R', 0, 'C');

			$pdf->Cell(20, 1, $unit->nama, 'R', 0, 'C');

			$pdf->SetFont('', 'B', 5);

			$pdf->Cell(34, 1, '20   = Preventive Maintenance', 'LR', 1, 'L');

			$pdf->SetFont('', 'B', 8);

			$pdf->Cell(2, 1, '', 'LR', 0, 'L');

			$pdf->Cell(94, 1, 'N I D            : ' . $lembur->nidPemberiTugas, 'R', 0, 'L');

			$pdf->Cell(20, 1, '', 'R', 0, 'C');

			$pdf->Cell(20, 1, '', 'R', 0, 'C');

			$pdf->Cell(20, 1, '', 'R', 0, 'C');

			$pdf->SetFont('', 'B', 5);

			$pdf->Cell(34, 1, '21   = Predictive Maintenance', 'LR', 1, 'L');

			$pdf->SetFont('', 'B', 8);

			$pdf->Cell(2, 1, '', 'LR', 0, 'L');

			$pdf->Cell(94, 1, '', 'R', 0, 'L');

			$pdf->Cell(20, 1, '', 'R', 0, 'C');

			$pdf->Cell(20, 1, '', 'R', 0, 'C');

			$pdf->Cell(20, 1, '', 'R', 0, 'C');

			$pdf->SetFont('', 'B', 5);

			$pdf->Cell(34, 1, '22   = Corrective Maintenance', 'LR', 1, 'L');

			$pdf->SetFont('', 'B', 8);

			$pdf->Cell(2, 1, '', 'LR', 0, 'L');

			$pdf->Cell(94, 1, 'Tanggal      : ' . date("d-m-Y", strtotime($lembur->tglPemberiTugas)), 'R', 0, 'L');

			$pdf->Cell(20, 1, '', 'R', 0, 'C');

			$pdf->Cell(20, 1, '', 'R', 0, 'C');

			$pdf->Cell(20, 1, '', 'R', 0, 'C');

			$pdf->SetFont('', 'B', 5);

			$pdf->Cell(34, 1, '24   = Overhoul Maintenance', 'LR', 1, 'L');

			$pdf->SetFont('', 'B', 8);

			$pdf->Cell(2, 1, '', 'LR', 0, 'L');

			$pdf->Cell(94, 1, '', 'R', 0, 'L');

			$pdf->Cell(20, 1, '', 'R', 0, 'C');

			$pdf->Cell(20, 1, '', 'R', 0, 'C');

			$pdf->Cell(20, 1, '', 'R', 0, 'C');

			$pdf->SetFont('', 'B', 5);

			$pdf->Cell(34, 1, '26   = Engineering / Project / Modifikasi', 'LR', 1, 'L');

			$pdf->SetFont('', 'B', 8);

			$pdf->Cell(2, 1, '', 'LR', 0, 'L');

			$pdf->Cell(94, 1, '', 'R', 0, 'L');

			$pdf->Cell(20, 1, '', 'R', 0, 'C');

			$pdf->Cell(20, 1, '', 'R', 0, 'C');

			$pdf->Cell(20, 1, '', 'R', 0, 'C');

			$pdf->SetFont('', 'B', 5);

			$pdf->Cell(34, 1, '60   = Non Instalasi / Umum', 'LR', 1, 'L');

			$pdf->Cell(2, 1, '', 'LR', 0, 'L');

			$pdf->Cell(94, 1, '', 'R', 0, 'L');

			$pdf->Cell(20, 1, '', 'R', 0, 'C');

			$pdf->Cell(20, 1, '', 'R', 0, 'C');

			$pdf->Cell(20, 1, '', 'R', 0, 'C');

			$pdf->Cell(34, 1, '', 'LR', 1, 'L');

			//kotak 5

			$pdf->SetFont('', 'B', 8);

			$pdf->Cell(2, 1, '', 'LR', 0, 'L');

			$pdf->Cell(94, 1, '7. PEMERIKSA HASIL', 1, 0, 'L', true);

			$pdf->Cell(20, 1, '', 'R', 0, 'C');

			$pdf->Cell(20, 1, '', 'R', 0, 'C');

			$pdf->Cell(20, 1, '', 'R', 0, 'C');

			$pdf->SetFont('', 'BU', 4);

			$pdf->Cell(34, 1, '', 'LR', 1, 'L');

			$pdf->SetFont('', 'B', 8);

			$pdf->Cell(2, 1, '', 'LR', 0, 'L');

			$pdf->Cell(94, 1, '', 'R', 0, 'L');

			$pdf->Cell(20, 1, '', 'R', 0, 'C');

			$pdf->Cell(20, 1, '', 'R', 0, 'C');

			$pdf->Cell(20, 1, '', 'R', 0, 'C');

			$pdf->SetFont('', 'B', 5);

			$pdf->Cell(34, 1, '', 'LR', 1, 'L');

			$pdf->SetFont('', 'B', 8);

			$pdf->Cell(2, 1, '', 'LR', 0, 'L');

			$pdf->Cell(94, 1, 'Nama          : ' . $lembur->namaPemeriksa, 'R', 0, 'L');

			$pdf->Cell(20, 1, '', 'R', 0, 'C');

			$pdf->Cell(20, 1, '', 'R', 0, 'C');

			$pdf->Cell(20, 1, '', 'R', 0, 'C');

			$pdf->SetFont('', 'B', 5);

			$pdf->Cell(34, 1, '', 'LR', 1, 'L');

			$pdf->SetFont('', 'B', 8);

			$pdf->Cell(2, 1, '', 'LR', 0, 'L');

			$pdf->Cell(94, 1, '', 'R', 0, 'L');

			$pdf->Cell(20, 1, '', 'R', 0, 'C');

			$pdf->Cell(20, 1, '', 'R', 0, 'C');

			$pdf->Cell(20, 1, '', 'R', 0, 'C');

			$pdf->SetFont('', 'B', 5);

			$pdf->Cell(34, 1, '', 'LR', 1, 'L');

			$pdf->SetFont('', 'B', 8);

			$pdf->Cell(2, 1, '', 'LR', 0, 'L');

			$pdf->Cell(94, 1, 'N I D            : ' . $lembur->nidPemeriksa, 'R', 0, 'L');

			$pdf->Cell(20, 1, '', 'R', 0, 'C');

			$pdf->Cell(20, 1, '', 'R', 0, 'C');

			$pdf->Cell(20, 1, '', 'R', 0, 'C');

			$pdf->SetFont('', 'B', 5);

			$pdf->Cell(34, 1, '', 'LR', 1, 'L');

			$pdf->SetFont('', 'B', 8);

			$pdf->Cell(2, 1, '', 'LR', 0, 'L');

			$pdf->Cell(94, 1, '', 'R', 0, 'L');

			$pdf->Cell(20, 1, '', 'R', 0, 'C');

			$pdf->Cell(20, 1, '', 'R', 0, 'C');

			$pdf->Cell(20, 1, '', 'R', 0, 'C');

			$pdf->SetFont('', 'B', 5);

			$pdf->Cell(34, 1, '', 'LR', 1, 'L');

			$pdf->SetFont('', 'B', 8);

			$pdf->Cell(2, 1, '', 'LR', 0, 'L');

			$pdf->Cell(94, 1, 'Tanggal      : ' . date("d-m-Y", strtotime($lembur->tglPemeriksa)), 'R', 0, 'L');

			$pdf->Cell(20, 1, '', 'R', 0, 'C');

			$pdf->Cell(20, 1, '', 'R', 0, 'C');

			$pdf->Cell(20, 1, '', 'R', 0, 'C');

			$pdf->SetFont('', 'B', 5);

			$pdf->Cell(34, 1, '', 'LR', 1, 'L');

			$pdf->SetFont('', 'B', 8);

			$pdf->Cell(2, 1, '', 'LR', 0, 'L');

			$pdf->Cell(94, 1, '', 'R', 0, 'L');

			$pdf->Cell(20, 1, '', 'R', 0, 'C');

			$pdf->Cell(20, 1, '', 'R', 0, 'C');

			$pdf->Cell(20, 1, '', 'R', 0, 'C');

			$pdf->SetFont('', 'B', 5);

			$pdf->Cell(34, 1, '', 'LR', 1, 'L');

			$pdf->SetFont('', 'B', 8);

			$pdf->Cell(2, 1, '', 'LR', 0, 'L');

			$pdf->Cell(94, 1, '', 'R', 0, 'L');

			$pdf->Cell(20, 1, '', 'R', 0, 'C');

			$pdf->Cell(20, 1, '', 'R', 0, 'C');

			$pdf->Cell(20, 1, '', 'R', 0, 'C');

			$pdf->SetFont('', 'B', 5);

			$pdf->Cell(34, 1, '', 'LR', 1, 'L');

			$pdf->Cell(2, 1, '', 'LRB', 0, 'L');

			$pdf->Cell(94, 1, '', 'RB', 0, 'L');

			$pdf->Cell(20, 1, $lembur->namaPemeriksa, 'RB', 0, 'C');

			$pdf->Cell(20, 1, '', 'RB', 0, 'C');

			$pdf->Cell(20, 1, $lembur->namaAsman, 'RB', 0, 'C');

			$pdf->Cell(34, 1, '', 'LRB', 1, 'L');

			ob_end_clean();

			$pdf->Output('SPKL ');

		}

	}

	function Cetak_lembur_backup($id)
	{
		$dlembur = $this->Lembur_model->pegawai_lembur($id)->row();
		if (!isset($dlembur)) {
			$this->session->set_flashdata('cetak', 'isi pesan');
			redirect(site_url() . '/lembur');
		} else {
			//Logo
			$img = base_url() . '/assets/imgs/PLN-Nusantara-Power-5p.png';
			$pdf = new pdf();
			$pdf->SetPrintHeader(false);
			$pdf->SetPrintFooter(false);
			$pdf->AddPage('P', 'mm', array(105, 165));
			$lembur = $this->Lembur_model->lembur($id)->row();
			$unit = $this->Lembur_model->unit_kerja_id($lembur->skpd)->row();
			//kop surat
			$pdf->SetFont('', 'B', 7);
			$pdf->image($img, 10, 11, 20, 5,);
			$pdf->Cell(20, 8, '', 0, 0, 'L');
			$pdf->Cell(30, 1, 'PT PLN NUSANTARA POWER', 0, 0, 'L');
			$pdf->Cell(120, 1, 'SURAT PERINTAH KERJA LEMBUR', 0, 0, 'C');
			$dlembur = $this->Lembur_model->pegawai_lembur($id)->row();
			$pegl = $this->Lembur_model->pegawai_id($dlembur->idtbPegawai)->row();
			if (($pegl->jabatan == "SATUAN PENGAMANAN") || ($pegl->jabatan == "CP KTH") || ($pegl->jabatan == "CP KTH") || ($pegl->jabatan == "TENAGA HELPER CCR") || ($pegl->jabatan == "TENAGA BANTU TEKNISI MESIN PPS")) {
				$pdf->Cell(20, 1, 'SHIFT', 1, 1, 'L');
			} else {
				$pdf->Cell(20, 1, 'NON SHIFT', 1, 1, 'L');
			}
			$pdf->Cell(20, 8, '', 0, 0, 'L');
			$pdf->Cell(30, 1, 'UNIT PEMBANGKITAN BRANTAS', 0, 0, 'L');
			$pdf->Cell(120, 1, '(SPKL)', 0, 0, 'C');
			$pdf->Cell(30, 10, '', 0, 1, 'L');
			//content panjang 190
			$pdf->SetFont('', 'B', 6);
			$pdf->Cell(1, 1, '', 0, 0, 'L');
			$pdf->Cell(185, 1, '*1-7 Harus di isi semua', 0, 1, 'L');
			$pdf->SetFont('', 'B', 8);
			//kotak 1
			$pdf->SetFillColor(215, 215, 215);
			$pdf->Cell(2, 1, '', 'LT', 0, 'L');
			$pdf->Cell(94, 1, '1. Deskripsi Dari Pekerjaan yang di Lemburkan :', 1, 0, 'L', true);
			$pdf->Cell(94, 1, '3. Nomor :', 1, 1, 'L', true);
			$no = 0;
			$dlembur = $this->Lembur_model->pegawai_lembur($id)->result();
			foreach ($dlembur as $spkl) {
				$pegl = $this->Lembur_model->pegawai_id($spkl->idtbPegawai)->row();
				$no++;
				if ($no == 1) {
					$pdf->Cell(2, 1, '', 'LR', 0, 'L');
					$pdf->Cell(42, 1, 'Nama Pegawai yang Lembur :', 0, 0, 'L');
					$pdf->Cell(52, 1, $pegl->namaPegawai, 'R', 0, 'L');
					$pdf->Cell(94, 1, $lembur->noWo, 'R', 1, 'L');
				} else {
					$pdf->Cell(2, 1, '', 'LR', 0, 'L');
					$pdf->Cell(42, 1, '', 0, 0, 'L');
					$pdf->Cell(52, 1, $pegl->namaPegawai, 'R', 0, 'L');
					$pdf->Cell(94, 1, '', 'R', 1, 'L');
				}
				$jabatan = $pegl->jabatan;
			}

			$pdf->Cell(2, 1, '', 'LR', 0, 'L');
			$pdf->Cell(42, 1, '', 0, 0, 'L');
			$pdf->Cell(52, 1, '', 'R', 0, 'L');
			$pdf->Cell(94, 1, '', 'R', 1, 'L');

			$pdf->Cell(2, 1, '', 'LR', 0, 'L');
			$pdf->Cell(94, 1, 'JABATAN : ' . $jabatan, 'LR', 0, 'L');
			$pdf->Cell(94, 1, '', 'LR', 1, 'L');
			$pdf->Cell(2, 1, '', 'LR', 0, 'L');
			$pdf->Cell(94, 1, '', 'LRB', 0, 'L');
			$pdf->Cell(94, 1, '', 'LRB', 1, 'L');
			//kotak 2
			$pdf->Cell(2, 1, '', 'LR', 0, 'L');
			$pdf->Cell(94, 1, '2. Uraian Pekerjaan yang dilemburkan, sasaran dan alasannya :', 1, 0, 'L', true);
			$pdf->Cell(94, 1, '4. Kode Aktifitas (*) :', 1, 1, 'L', true);
			//uraian baris 1
			$pdf->Cell(2, 1, '', 'LR', 0, 'L');
			$pdf->Cell(94, 1, substr($lembur->uraian, 0, 67), 'LR', 0, 'L');
			$pdf->Cell(94, 1, $lembur->kodeAktifitas, 'LR', 1, 'L');
			//uraian baris 2
			$pdf->Cell(2, 1, '', 'LR', 0, 'L');
			$pdf->Cell(94, 1, substr($lembur->uraian, 67, 67), 'LR', 0, 'L');
			$pdf->Cell(94, 1, '', 'LR', 1, 'L');
			//uraian baris 3
			$pdf->Cell(2, 1, '', 'LR', 0, 'L');
			$pdf->Cell(94, 1, substr($lembur->uraian, 134, 67), 'LR', 0, 'L');
			$pdf->Cell(94, 1, '', 'LR', 1, 'L');
			$pdf->Cell(2, 1, '', 'LR', 0, 'L');
			$pdf->Cell(94, 1, '', 'LR', 0, 'L');
			$pdf->Cell(94, 1, '', 'LR', 1, 'L');
			$pdf->Cell(2, 1, '', 'LR', 0, 'L');
			$pdf->Cell(94, 1, '', 'LRB', 0, 'L');
			$pdf->Cell(94, 1, '', 'LRB', 1, 'L');
			//kotak 3
			if ($lembur->statusHari == "Kerja") {
				$pdf->Cell(2, 1, '', 'LR', 0, 'L');
				//hari kerja
				$pdf->Cell(60, 1, 'Hari Masuk Tanggal :', 'LR', 0, 'L');
				$pdf->Cell(34, 1, 'Jam :', 'LR', 0, 'L');
				$pdf->Cell(94, 1, '5. Beban Anggaran :', 1, 1, 'L', true);
				$pdf->Cell(2, 1, '', 'LR', 0, 'L');
				$pdf->Cell(60, 1, date("d-m-Y", strtotime($lembur->tglLembur)), 'LR', 0, 'L');
				$pdf->Cell(34, 1, $lembur->mulai . ' - ' . $lembur->sampai, 'LR', 0, 'L');
				$pdf->Cell(94, 1, $lembur->bebanAnggaran, 'R', 1, 'L');
				$pdf->Cell(2, 1, '', 'LR', 0, 'L');
				$pdf->Cell(60, 1, '', 'LR', 0, 'L');
				$pdf->Cell(34, 1, '', 'LR', 0, 'L');
				$pdf->Cell(94, 1, '', 'R', 1, 'L');
				$pdf->Cell(2, 1, '', 'LR', 0, 'L');
				$pdf->Cell(60, 1, '', 'LRB', 0, 'L');
				$pdf->Cell(34, 1, '', 'LRB', 0, 'L');
				$pdf->Cell(94, 1, '', 'R', 1, 'L');
				//hari libur
				$pdf->Cell(2, 1, '', 'LR', 0, 'L');
				$pdf->Cell(60, 1, 'Hari Libur Tanggal :', 'LR', 0, 'L');
				$pdf->Cell(34, 1, 'Jam :', 'LR', 0, 'L');
				$pdf->Cell(94, 1, '', 'LR', 1, 'L');
				$pdf->Cell(2, 1, '', 'LR', 0, 'L');
				$pdf->Cell(60, 1, '', 'LR', 0, 'L');
				$pdf->Cell(34, 1, '', 'LR', 0, 'L');
				$pdf->Cell(94, 1, '', 'R', 1, 'L');
				$pdf->Cell(2, 1, '', 'LR', 0, 'L');
				$pdf->Cell(60, 1, '', 'LR', 0, 'L');
				$pdf->Cell(34, 1, '', 'LR', 0, 'L');
				$pdf->Cell(94, 1, '', 'R', 1, 'L');
				$pdf->Cell(2, 1, '', 'LR', 0, 'L');
				$pdf->Cell(60, 1, '', 'LRB', 0, 'L');
				$pdf->Cell(34, 1, '', 'LRB', 0, 'L');
				$pdf->Cell(94, 1, '', 'RB', 1, 'L');
			} else {
				$pdf->Cell(2, 1, '', 'LR', 0, 'L');
				//hari kerja
				$pdf->Cell(60, 1, 'Hari Masuk Tanggal :', 'LR', 0, 'L');
				$pdf->Cell(34, 1, 'Jam :', 'LR', 0, 'L');
				$pdf->Cell(94, 1, '5. Beban Anggaran :', 1, 1, 'L', true);
				$pdf->Cell(2, 1, '', 'LR', 0, 'L');
				$pdf->Cell(60, 1, '', 'LR', 0, 'L');
				$pdf->Cell(34, 1, '', 'LR', 0, 'L');
				$pdf->Cell(94, 1, $lembur->bebanAnggaran, 'R', 1, 'L');
				$pdf->Cell(2, 1, '', 'LR', 0, 'L');
				$pdf->Cell(60, 1, '', 'LR', 0, 'L');
				$pdf->Cell(34, 1, '', 'LR', 0, 'L');
				$pdf->Cell(94, 1, '', 'R', 1, 'L');
				$pdf->Cell(2, 1, '', 'LR', 0, 'L');
				$pdf->Cell(60, 1, '', 'LRB', 0, 'L');
				$pdf->Cell(34, 1, '', 'LRB', 0, 'L');
				$pdf->Cell(94, 1, '', 'R', 1, 'L');
				//hari libur
				$pdf->Cell(2, 1, '', 'LR', 0, 'L');
				$pdf->Cell(60, 1, 'Hari Libur Tanggal :', 'LR', 0, 'L');
				$pdf->Cell(34, 1, 'Jam :', 'LR', 0, 'L');
				$pdf->Cell(94, 1, '', 'LR', 1, 'L');
				$pdf->Cell(2, 1, '', 'LR', 0, 'L');
				$pdf->Cell(60, 1, date("d-m-Y", strtotime($lembur->tglLembur)), 'LR', 0, 'L');
				$pdf->Cell(34, 1, $lembur->mulai . ' - ' . $lembur->sampai, 'LR', 0, 'L');
				$pdf->Cell(94, 1, '', 'R', 1, 'L');
				$pdf->Cell(2, 1, '', 'LR', 0, 'L');
				$pdf->Cell(60, 1, '', 'LR', 0, 'L');
				$pdf->Cell(34, 1, '', 'LR', 0, 'L');
				$pdf->Cell(94, 1, '', 'R', 1, 'L');
				$pdf->Cell(2, 1, '', 'LR', 0, 'L');
				$pdf->Cell(60, 1, '', 'LRB', 0, 'L');
				$pdf->Cell(34, 1, '', 'LRB', 0, 'L');
				$pdf->Cell(94, 1, '', 'RB', 1, 'L');
			}
			//kotak 4
			$pdf->Cell(2, 1, '', 'LR', 0, 'L');
			$pdf->Cell(94, 1, '6. YANG MENUGASKAN', 1, 0, 'L', true);
			$pdf->Cell(60, 1, 'Mengetahui :', 1, 0, 'C', true);
			$pdf->SetFont('', 'BU', 4);
			$pdf->Cell(34, 1, 'Ket. Kode Aktifitas (*) :', 'LR', 1, 'L');
			$pdf->SetFont('', 'B', 8);
			$pdf->Cell(2, 1, '', 'LR', 0, 'L');
			$pdf->Cell(94, 1, '', 'R', 0, 'L');
			$pdf->Cell(60, 1, '', 'R', 0, 'C');
			$pdf->SetFont('', 'B', 5);
			$pdf->Cell(34, 1, '18   = K3', 'LR', 1, 'L');
			$pdf->SetFont('', 'B', 8);
			$pdf->Cell(2, 1, '', 'LR', 0, 'L');
			$pdf->Cell(94, 1, 'Nama          : ' . $lembur->namaPemberiTugas, 'R', 0, 'L');
			$pdf->SetFont('', 'B', 5);
			$pdf->Cell(20, 1, 'Pemeriksa', 'R', 0, 'C');
			$pdf->Cell(20, 1, 'ASMAN Bidang', 'R', 0, 'C');
			$pdf->Cell(20, 1, 'ASMAN', 'R', 0, 'C');
			$pdf->SetFont('', 'B', 5);
			$pdf->Cell(34, 1, '19   = Lingkungan', 'LR', 1, 'L');
			$pdf->SetFont('', 'B', 5);
			$pdf->Cell(2, 1, '', 'LR', 0, 'L');
			$pdf->Cell(94, 1, '', 'R', 0, 'L');
			$pdf->Cell(20, 1, 'Hasil', 'R', 0, 'C');
			$pdf->Cell(20, 1, '', 'R', 0, 'C');
			$pdf->Cell(20, 1, $unit->nama, 'R', 0, 'C');
			$pdf->SetFont('', 'B', 5);
			$pdf->Cell(34, 1, '20   = Preventive Maintenance', 'LR', 1, 'L');
			$pdf->SetFont('', 'B', 8);
			$pdf->Cell(2, 1, '', 'LR', 0, 'L');
			$pdf->Cell(94, 1, 'N I D            : ' . $lembur->nidPemberiTugas, 'R', 0, 'L');
			$pdf->Cell(20, 1, '', 'R', 0, 'C');
			$pdf->Cell(20, 1, '', 'R', 0, 'C');
			$pdf->Cell(20, 1, '', 'R', 0, 'C');
			$pdf->SetFont('', 'B', 5);
			$pdf->Cell(34, 1, '21   = Predictive Maintenance', 'LR', 1, 'L');
			$pdf->SetFont('', 'B', 8);
			$pdf->Cell(2, 1, '', 'LR', 0, 'L');
			$pdf->Cell(94, 1, '', 'R', 0, 'L');
			$pdf->Cell(20, 1, '', 'R', 0, 'C');
			$pdf->Cell(20, 1, '', 'R', 0, 'C');
			$pdf->Cell(20, 1, '', 'R', 0, 'C');
			$pdf->SetFont('', 'B', 5);
			$pdf->Cell(34, 1, '22   = Corrective Maintenance', 'LR', 1, 'L');
			$pdf->SetFont('', 'B', 8);
			$pdf->Cell(2, 1, '', 'LR', 0, 'L');
			$pdf->Cell(94, 1, 'Tanggal      : ' . date("d-m-Y", strtotime($lembur->tglPemberiTugas)), 'R', 0, 'L');
			$pdf->Cell(20, 1, '', 'R', 0, 'C');
			$pdf->Cell(20, 1, '', 'R', 0, 'C');
			$pdf->Cell(20, 1, '', 'R', 0, 'C');
			$pdf->SetFont('', 'B', 5);
			$pdf->Cell(34, 1, '24   = Overhoul Maintenance', 'LR', 1, 'L');
			$pdf->SetFont('', 'B', 8);
			$pdf->Cell(2, 1, '', 'LR', 0, 'L');
			$pdf->Cell(94, 1, '', 'R', 0, 'L');
			$pdf->Cell(20, 1, '', 'R', 0, 'C');
			$pdf->Cell(20, 1, '', 'R', 0, 'C');
			$pdf->Cell(20, 1, '', 'R', 0, 'C');
			$pdf->SetFont('', 'B', 5);
			$pdf->Cell(34, 1, '26   = Engineering / Project / Modifikasi', 'LR', 1, 'L');
			$pdf->SetFont('', 'B', 8);
			$pdf->Cell(2, 1, '', 'LR', 0, 'L');
			$pdf->Cell(94, 1, '', 'R', 0, 'L');
			$pdf->Cell(20, 1, '', 'R', 0, 'C');
			$pdf->Cell(20, 1, '', 'R', 0, 'C');
			$pdf->Cell(20, 1, '', 'R', 0, 'C');
			$pdf->SetFont('', 'B', 5);
			$pdf->Cell(34, 1, '60   = Non Instalasi / Umum', 'LR', 1, 'L');
			$pdf->Cell(2, 1, '', 'LR', 0, 'L');
			$pdf->Cell(94, 1, '', 'R', 0, 'L');
			$pdf->Cell(20, 1, '', 'R', 0, 'C');
			$pdf->Cell(20, 1, '', 'R', 0, 'C');
			$pdf->Cell(20, 1, '', 'R', 0, 'C');
			$pdf->Cell(34, 1, '', 'LR', 1, 'L');
			//kotak 5
			$pdf->SetFont('', 'B', 8);
			$pdf->Cell(2, 1, '', 'LR', 0, 'L');
			$pdf->Cell(94, 1, '7. PEMERIKSA HASIL', 1, 0, 'L', true);
			$pdf->Cell(20, 1, '', 'R', 0, 'C');
			$pdf->Cell(20, 1, '', 'R', 0, 'C');
			$pdf->Cell(20, 1, '', 'R', 0, 'C');
			$pdf->SetFont('', 'BU', 4);
			$pdf->Cell(34, 1, '', 'LR', 1, 'L');
			$pdf->SetFont('', 'B', 8);
			$pdf->Cell(2, 1, '', 'LR', 0, 'L');
			$pdf->Cell(94, 1, '', 'R', 0, 'L');
			$pdf->Cell(20, 1, '', 'R', 0, 'C');
			$pdf->Cell(20, 1, '', 'R', 0, 'C');
			$pdf->Cell(20, 1, '', 'R', 0, 'C');
			$pdf->SetFont('', 'B', 5);
			$pdf->Cell(34, 1, '', 'LR', 1, 'L');
			$pdf->SetFont('', 'B', 8);
			$pdf->Cell(2, 1, '', 'LR', 0, 'L');
			$pdf->Cell(94, 1, 'Nama          : ' . $lembur->namaPemeriksa, 'R', 0, 'L');
			$pdf->Cell(20, 1, '', 'R', 0, 'C');
			$pdf->Cell(20, 1, '', 'R', 0, 'C');
			$pdf->Cell(20, 1, '', 'R', 0, 'C');
			$pdf->SetFont('', 'B', 5);
			$pdf->Cell(34, 1, '', 'LR', 1, 'L');
			$pdf->SetFont('', 'B', 8);
			$pdf->Cell(2, 1, '', 'LR', 0, 'L');
			$pdf->Cell(94, 1, '', 'R', 0, 'L');
			$pdf->Cell(20, 1, '', 'R', 0, 'C');
			$pdf->Cell(20, 1, '', 'R', 0, 'C');
			$pdf->Cell(20, 1, '', 'R', 0, 'C');
			$pdf->SetFont('', 'B', 5);
			$pdf->Cell(34, 1, '', 'LR', 1, 'L');
			$pdf->SetFont('', 'B', 8);
			$pdf->Cell(2, 1, '', 'LR', 0, 'L');
			$pdf->Cell(94, 1, 'N I D            : ' . $lembur->nidPemeriksa, 'R', 0, 'L');
			$pdf->Cell(20, 1, '', 'R', 0, 'C');
			$pdf->Cell(20, 1, '', 'R', 0, 'C');
			$pdf->Cell(20, 1, '', 'R', 0, 'C');
			$pdf->SetFont('', 'B', 5);
			$pdf->Cell(34, 1, '', 'LR', 1, 'L');
			$pdf->SetFont('', 'B', 8);
			$pdf->Cell(2, 1, '', 'LR', 0, 'L');
			$pdf->Cell(94, 1, '', 'R', 0, 'L');
			$pdf->Cell(20, 1, '', 'R', 0, 'C');
			$pdf->Cell(20, 1, '', 'R', 0, 'C');
			$pdf->Cell(20, 1, '', 'R', 0, 'C');
			$pdf->SetFont('', 'B', 5);
			$pdf->Cell(34, 1, '', 'LR', 1, 'L');
			$pdf->SetFont('', 'B', 8);
			$pdf->Cell(2, 1, '', 'LR', 0, 'L');
			$pdf->Cell(94, 1, 'Tanggal      : ' . date("d-m-Y", strtotime($lembur->tglPemeriksa)), 'R', 0, 'L');
			$pdf->Cell(20, 1, '', 'R', 0, 'C');
			$pdf->Cell(20, 1, '', 'R', 0, 'C');
			$pdf->Cell(20, 1, '', 'R', 0, 'C');
			$pdf->SetFont('', 'B', 5);
			$pdf->Cell(34, 1, '', 'LR', 1, 'L');
			$pdf->SetFont('', 'B', 8);
			$pdf->Cell(2, 1, '', 'LR', 0, 'L');
			$pdf->Cell(94, 1, '', 'R', 0, 'L');
			$pdf->Cell(20, 1, '', 'R', 0, 'C');
			$pdf->Cell(20, 1, '', 'R', 0, 'C');
			$pdf->Cell(20, 1, '', 'R', 0, 'C');
			$pdf->SetFont('', 'B', 5);
			$pdf->Cell(34, 1, '', 'LR', 1, 'L');
			$pdf->SetFont('', 'B', 8);
			$pdf->Cell(2, 1, '', 'LR', 0, 'L');
			$pdf->Cell(94, 1, '', 'R', 0, 'L');
			$pdf->Cell(20, 1, '', 'R', 0, 'C');
			$pdf->Cell(20, 1, '', 'R', 0, 'C');
			$pdf->Cell(20, 1, '', 'R', 0, 'C');
			$pdf->SetFont('', 'B', 5);
			$pdf->Cell(34, 1, '', 'LR', 1, 'L');
			$pdf->Cell(2, 1, '', 'LRB', 0, 'L');
			$pdf->Cell(94, 1, '', 'RB', 0, 'L');
			$pdf->Cell(20, 1, $lembur->namaPemeriksa, 'RB', 0, 'C');
			$pdf->Cell(20, 1, '', 'RB', 0, 'C');
			$pdf->Cell(20, 1, $lembur->namaAsman, 'RB', 0, 'C');
			$pdf->Cell(34, 1, '', 'LRB', 1, 'L');
			ob_end_clean();
			$pdf->Output('SPKL ');
		}
	}

}

