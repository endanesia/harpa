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

		$gaji = $peg->nilaiUmk;

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

				if ($jmlJam > 9) {

					$nominal1 = ($nilaiLembur * $tarif[0]->satujam_libur) * 8;

					$nominal9 = ($nilaiLembur * $tarif[0]->sembilanjam_libur);

					$sisaJam = $jmlJam - 9;

					$nominal10 =  ($nilaiLembur * $tarif[0]->sepuluhjam_libur) * $sisaJam;

					$nominal = $nominal1 + $nominal9 + $nominal10;

				} elseif ($jmlJam == 9) {

					$nominal1 = ($nilaiLembur * $tarif[0]->satujam_libur) * 8;

					$nominal9 = ($nilaiLembur * $tarif[0]->sembilanjam_libur);

					$nominal = $nominal1 + $nominal9;

				} elseif ($jmlJam >= 1 && $jmlJam <= 8) {

					$nominal = ($nilaiLembur * $tarif[0]->satujam_libur) * $jmlJam;

				}

			} else {

				//hari kerja

				//uang makan

				if ($jmlJam >= 8) {

					$uangMakan = $tarif[0]->uang_makan;

				}



				if ($jmlJam > 9) {

					$nominal1 = ($nilaiLembur * $tarif[0]->satujam);

					$nominal28 = ($nilaiLembur * $tarif[0]->duajam) * 7;

					$nominal9 = ($nilaiLembur * $tarif[0]->delapanjam_lebih);

					$sisaJam = $jmlJam - 9;
					$nominal10 = ($nilaiLembur * $tarif[0]->sepuluhjam_lebih) * $sisaJam;

					$nominal = $nominal1 + $nominal28 + $nominal9 + $nominal10;
				} elseif ($jmlJam == 9) {

					$nominal1 = ($nilaiLembur * $tarif[0]->satujam);

					$nominal28 = ($nilaiLembur * $tarif[0]->duajam) * 7;

					$nominal9 = ($nilaiLembur * $tarif[0]->delapanjam_lebih);

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

			$pl['nilai'] = round($nominal);

			$pl['uangMakan'] = round($uangMakan);

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


	public function Refresh_pegawai_lembur($detailId)
	{
		// Recalculate nilai and uangMakan for a detail row based on current rules
		$detail = $this->db->get_where('tbLemburDetail', ['id' => $detailId])->row();
		if (!$detail) {
			redirect(site_url('lembur/validasi'));
			return;
		}

		// Fetch related lembur and pegawai data
		$dt = $this->Lembur_model->lembur($detail->idLembur)->row();
		if (!$dt) {
			redirect(site_url('lembur/validasi'));
			return;
		}
		$jmlJam = (int)$dt->jmlJam;
		$hari = $dt->statusHari;

		$peg = $this->Lembur_model->pegawai_id($detail->idtbPegawai)->row();
		if (!$peg) {
			redirect(site_url('lembur/validasi'));
			return;
		}
		$gaji = (float)$peg->nilaiUmk;

		// Tarif lookup
		$tarif = $this->db->get_where('tbMasterLembur', [
			'idSatKerja' => $peg->skpd,
			'idJabatan' => $peg->idJabatan,
			'idKelasJabatan' => $peg->kelasJabatan,
		])->result();

		$nominal = 0;
		$uangMakan = 0;
		if (count($tarif) > 0) {
			$nilaiLembur = $gaji * $tarif[0]->tarif;
			if ($hari == 'Libur') {
				// Uang makan
				if ($jmlJam >= 8) {
					$uangMakan = (float)$tarif[0]->uang_makan;
				}
				// Uang lembur hari libur
				if ($jmlJam > 9) {
					$nominal1 = ($nilaiLembur * $tarif[0]->satujam_libur) * 8;
					$nominal9 = ($nilaiLembur * $tarif[0]->sembilanjam_libur);
					$sisaJam = $jmlJam - 9;
					$nominal10 = ($nilaiLembur * $tarif[0]->sepuluhjam_libur) * $sisaJam;
					$nominal = $nominal1 + $nominal9 + $nominal10;
				} elseif ($jmlJam == 9) {
					$nominal1 = ($nilaiLembur * $tarif[0]->satujam_libur) * 8;
					$nominal9 = ($nilaiLembur * $tarif[0]->sembilanjam_libur);
					$nominal = $nominal1 + $nominal9;
				} elseif ($jmlJam >= 1 && $jmlJam <= 8) {
					$nominal = ($nilaiLembur * $tarif[0]->satujam_libur) * $jmlJam;
				}
			} else {
				// Hari kerja
				if ($jmlJam >= 8) {
					$uangMakan = (float)$tarif[0]->uang_makan;
				}
				if ($jmlJam > 9) {
					$nominal1 = ($nilaiLembur * $tarif[0]->satujam);
					$nominal28 = ($nilaiLembur * $tarif[0]->duajam) * 7;
					$nominal9 = ($nilaiLembur * $tarif[0]->delapanjam_lebih);
					$sisaJam = $jmlJam - 9;
					$nominal10 = ($nilaiLembur * $tarif[0]->sepuluhjam_lebih) * $sisaJam;
					$nominal = $nominal1 + $nominal28 + $nominal9 + $nominal10;
				} elseif ($jmlJam == 9) {
					$nominal1 = ($nilaiLembur * $tarif[0]->satujam);
					$nominal28 = ($nilaiLembur * $tarif[0]->duajam) * 7;
					$nominal9 = ($nilaiLembur * $tarif[0]->delapanjam_lebih);
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
		}

		$this->db->update('tbLemburDetail', [
			'nilai' => $nominal,
			'uangMakan' => $uangMakan,
		], ['id' => $detailId]);

		redirect(site_url('lembur/validasi'));
	}

	public function Refresh_pegawai_lembur_ajax()
	{
		$this->output->set_content_type('application/json');
		$detailId = $this->input->post('id');
		if (!$detailId) {
			echo json_encode(['success' => false, 'message' => 'ID tidak ditemukan']);
			return;
		}
		$detail = $this->db->get_where('tbLemburDetail', ['id' => $detailId])->row();
		if (!$detail) {
			echo json_encode(['success' => false, 'message' => 'Detail tidak ditemukan']);
			return;
		}
		$dt = $this->Lembur_model->lembur($detail->idLembur)->row();
		if (!$dt) {
			echo json_encode(['success' => false, 'message' => 'Data lembur tidak ditemukan']);
			return;
		}
		$jmlJam = (int)$dt->jmlJam;
		$hari = $dt->statusHari;
		$peg = $this->Lembur_model->pegawai_id($detail->idtbPegawai)->row();
		if (!$peg) {
			echo json_encode(['success' => false, 'message' => 'Pegawai tidak ditemukan']);
			return;
		}
		$gaji = (float)$peg->nilaiUmk;
		$tarif = $this->db->get_where('tbMasterLembur', [
			'idSatKerja' => $peg->skpd,
			'idJabatan' => $peg->idJabatan,
			'idKelasJabatan' => $peg->kelasJabatan,
		])->result();
		$nominal = 0;
		$uangMakan = 0;
		if (count($tarif) > 0) {
			$nilaiLembur = $gaji * $tarif[0]->tarif;
			if ($hari == 'Libur') {
				if ($jmlJam >= 8) {
					$uangMakan = (float)$tarif[0]->uang_makan;
				}
				if ($jmlJam > 9) {
					$nominal1 = ($nilaiLembur * $tarif[0]->satujam_libur) * 8;
					$nominal9 = ($nilaiLembur * $tarif[0]->sembilanjam_libur);
					$sisaJam = $jmlJam - 9;
					$nominal10 = ($nilaiLembur * $tarif[0]->sepuluhjam_libur) * $sisaJam;
					$nominal = $nominal1 + $nominal9 + $nominal10;
				} elseif ($jmlJam == 9) {
					$nominal1 = ($nilaiLembur * $tarif[0]->satujam_libur) * 8;
					$nominal9 = ($nilaiLembur * $tarif[0]->sembilanjam_libur);
					$nominal = $nominal1 + $nominal9;
				} elseif ($jmlJam >= 1 && $jmlJam <= 8) {
					$nominal = ($nilaiLembur * $tarif[0]->satujam_libur) * $jmlJam;
				}
			} else {
				if ($jmlJam >= 8) {
					$uangMakan = (float)$tarif[0]->uang_makan;
				}
				if ($jmlJam > 9) {
					$nominal1 = ($nilaiLembur * $tarif[0]->satujam);
					$nominal28 = ($nilaiLembur * $tarif[0]->duajam) * 7;
					$nominal9 = ($nilaiLembur * $tarif[0]->delapanjam_lebih);
					$sisaJam = $jmlJam - 9;
					$nominal10 = ($nilaiLembur * $tarif[0]->sepuluhjam_lebih) * $sisaJam;
					$nominal = $nominal1 + $nominal28 + $nominal9 + $nominal10;
				} elseif ($jmlJam == 9) {
					$nominal1 = ($nilaiLembur * $tarif[0]->satujam);
					$nominal28 = ($nilaiLembur * $tarif[0]->duajam) * 7;
					$nominal9 = ($nilaiLembur * $tarif[0]->delapanjam_lebih);
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
		}

		$this->db->update('tbLemburDetail', [
			'nilai' => $nominal,
			'uangMakan' => $uangMakan,
		], ['id' => $detailId]);

		echo json_encode([
			'success' => true,
			'nilai' => $nominal,
			'uangMakan' => $uangMakan,
			'nilai_formatted' => number_format($nominal, 0, ',', '.'),
			'uangMakan_formatted' => number_format($uangMakan, 0, ',', '.'),
		]);
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

			//$pdf->AddPage('P', 'mm', array(105, 165));

			$pdf->AddPage('L', 'mm', 'A4');

			$lembur = $this->Lembur_model->lembur($id)->row();

			$unit = $this->Lembur_model->unit_kerja_id($lembur->skpd)->row();

			//kop surat

			$pdf->SetFont('', 'B', 7);

			$pdf->image($img, 10, 11, 20, 5,);

			$pdf->Cell(20, 8, '', 0, 0, 'L');

			$pdf->Cell(60, 1, 'PT PLN NUSANTARA POWER', 0, 0, 'L');

			$pdf->Cell(120, 1, 'SURAT PERINTAH KERJA LEMBUR', 0, 0, 'C');

			$dlembur = $this->Lembur_model->pegawai_lembur($id)->row();

			$pegl = $this->Lembur_model->pegawai_id($dlembur->idtbPegawai)->row();

			if (($pegl->jabatan == "SATUAN PENGAMANAN") || ($pegl->jabatan == "CP KTH") || ($pegl->jabatan == "CP KTH") || ($pegl->jabatan == "TENAGA HELPER CCR") || ($pegl->jabatan == "TENAGA BANTU TEKNISI MESIN PPS")) {

				$pdf->Cell(20, 1, 'SHIFT', 1, 1, 'L');

			} else {

				$pdf->Cell(20, 1, 'NON SHIFT', 1, 1, 'L');

			}

			$pdf->Cell(20, 8, '', 0, 0, 'L');

			$pdf->Cell(60, 1, 'UNIT PEMBANGKITAN BRANTAS', 0, 0, 'L');

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

			$pdf->Cell(120, 1, '1. Deskripsi Dari Pekerjaan yang di Lemburkan :', 1, 0, 'L', true);

			$pdf->Cell(120, 1, '3. Nomor :', 1, 1, 'L', true);

			$no = 0;

			$dlembur = $this->Lembur_model->pegawai_lembur($id)->result();

			foreach ($dlembur as $spkl) {

				$pegl = $this->Lembur_model->pegawai_id($spkl->idtbPegawai)->row();

				$no++;

				if ($no == 1) {

					$pdf->Cell(2, 1, '', 'LR', 0, 'L');

					$pdf->Cell(42, 1, 'Nama Pegawai yang Lembur :', 0, 0, 'L');

					$pdf->Cell(78, 1, $no.'. '.$pegl->namaPegawai, 'R', 0, 'L');

					//kolom 2

					$pdf->Cell(120, 1, $lembur->noWo, 'R', 1, 'L');

				} else {

					$pdf->Cell(2, 1, '', 'LR', 0, 'L');

					$pdf->Cell(42, 1, '', 0, 0, 'L');

					$pdf->Cell(78, 1, $no.'. '.$pegl->namaPegawai, 'R', 0, 'L');

					//kolom 2

					$pdf->Cell(120, 1, '', 'R', 1, 'L');

				}

				//$jabatan = $pegl->jabatan;

			}
					
					$pdf->Cell(2, 1, '', 'LR', 0, 'L');

					$pdf->Cell(42, 1, '', 0, 0, 'L');

					$pdf->Cell(78, 1, '', 'R', 0, 'L');

					$pdf->Cell(120, 1, '', 'R', 1, 'L');
			
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

							$pdf->Cell(79, 1, ' '.$nojab.'. '.$pegl->jabatan, '', 0, 'L');

							//kolom 2

							$pdf->Cell(120, 1, '', 'LR', 1, 'L');	
						
						}
						else
						{
							$pdf->Cell(2, 1, '', 'LR', 0, 'L');

							$pdf->Cell(38, 1, '', '', 0, 'L');
							
							$pdf->Cell(3, 1, '', '', 0, 'L');

							$pdf->Cell(79, 1, ' '.$nojab.'. '.$pegl->jabatan, '', 0, 'L');

							//kolom 2

							$pdf->Cell(120, 1, '', 'LR', 1, 'L');	
						
						}
					}

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

			$pdf->SetFont('', 'B', 5);

			$pdf->Cell(2, 1, '', 'LR', 0, 'L');

			$pdf->Cell(120, 1, '', 'R', 0, 'L');

			$pdf->Cell(20, 1, 'Hasil', 'R', 0, 'C');

			$pdf->Cell(20, 1, '', 'R', 0, 'C');

			$pdf->Cell(20, 1, $unit->nama, 'R', 0, 'C');

			$pdf->SetFont('', 'B', 5);

			$pdf->Cell(60, 1, '20   = Preventive Maintenance', 'LR', 1, 'L');

			$pdf->SetFont('', 'B', 8);

			$pdf->Cell(2, 1, '', 'LR', 0, 'L');

			$pdf->Cell(120, 1, 'N I D            : ' . $lembur->nidPemberiTugas, 'R', 0, 'L');

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

			$pdf->SetFont('', 'B', 5);

			$pdf->Cell(60, 1, '', 'LR', 1, 'L');

			$pdf->SetFont('', 'B', 8);

			$pdf->Cell(2, 1, '', 'LR', 0, 'L');

			$pdf->Cell(120, 1, 'Tanggal      : ' . date("d-m-Y", strtotime($lembur->tglPemeriksa)), 'R', 0, 'L');

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

			$pdf->Output('SPKL ');

		}

	}

	function download_excel_rincian() 
	{	
		$data['data'] =  $this->Lembur_model->show_rincian($this->session->filter_unit, $this->input->get('bulan'), $this->input->get('tahun'))->result();
		$data['bulan'] = $this->input->get('bulan');
		$data['tahun'] = $this->input->get('tahun');
		$this->load->view('lembur/lembur_excel', $data);
		//echo "Fitur Rincian belum tersedia";
	}

	function download_excel_terima() 
	{	
		$data['data'] = $this->Lembur_model->show_terima($this->session->filter_unit, $this->input->get('bulan'), $this->input->get('tahun'))->result();
		$data['unit'] = $this->input->get('unit');
		$data['bulan'] = $this->input->get('bulan');
		$data['tahun'] = $this->input->get('tahun');
		$this->load->view('lembur/lembur_excel_terima', $data);
		//echo "Fitur Tanda Terima belum tersedia";
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

	function Cetak_lembur_semua()
	{	
		//data
		$data= $this->Lembur_model->slip_lembur($this->session->filter_unit, $this->session->filter_bulan, $this->session->filter_tahun)->result();
		//var_dump($data);
		//file cetakan
		$pdf = new PDF();
		$pdf->SetPrintHeader(false);
		$pdf->SetPrintFooter(false);
		$pdf->AddPage('P', 'LETTER');
		//ukuran kertas 215.9 x 279.4 mm
		$counter = 0; // Counter untuk menghitung slip dalam satu halaman
		$pageHeight = 279.4; // Tinggi Letter dalam mm
		$slipHeight = $pageHeight/2; // Tinggi untuk satu slip
		
		// angka terjemahan bulan
		if(substr($this->session->filter_bulan,0,1) == '0') 
		{
			$bulan=substr($this->session->filter_bulan,1,1);
		
		}
		else 
		{
			$bulan=$this->session->filter_bulan;
		}
		
		foreach ($data as $slembur)
		{
			$terima=0;
			if (substr($bulan,0,1)==0)
			{
				$bulan=substr($bulan,1,1);
			}
			else
			{
				$bulan=$bulan;
			}
			// judul slip
			$pdf->SetFont('', 'B', 10);
			$pdf->Cell(210, 10,'SLIP KERJA LEBIH PT.SEBRA CIPTA MANDIRI ' . $this->nama_bulan($bulan) . ' ' . $this->session->filter_tahun, 0, 1, 'C');
			// Data Diri
			//NIK, Nama, Departemen
			$pdf->SetFont('','R', 10);
			$pdf->Cell(15, 5,'NIK', 0, 0, 'L');
			$pdf->Cell(5, 5,':', 0, 0, 'L');
			$pdf->Cell(40, 5, $slembur->nipBaru, 0, 0, 'L');
			$pdf->Cell(45, 5, '', 0, 0, 'L');
			$pdf->Cell(35, 5,'Departemen', 0, 0, 'L');
			$pdf->Cell(5, 5,':', 0, 0, 'L');
			$pdf->Cell(40, 5, $slembur->nama, 0, 1, 'L');
			//Nama, Jabatan
			$pdf->SetFont('','R', 10);
			$pdf->Cell(15, 5,'NAMA', 0, 0, 'L');
			$pdf->Cell(5, 5,':', 0, 0, 'L');
			$pdf->Cell(40, 5, $slembur->namaPegawai, 0, 0, 'L');
			$pdf->Cell(45, 5, '', 0, 0, 'L');
			$pdf->Cell(35, 5,'Jabatan', 0, 0, 'L');
			$pdf->Cell(5, 5,':', 0, 0, 'L');
			$pdf->Cell(40, 5, $slembur->jabatan, 0, 1, 'L');
			$pdf->Cell(210, 5, '', 0, 1, 'L');
			// Detail Lembur
			$detailLembur = $this->Lembur_model->detail_lembur($this->session->filter_unit, $this->session->filter_bulan, $this->session->filter_tahun,$slembur->nipBaru)->result();
			//Tabel
			// Header Tabel
			$pdf->SetFont('', 'B', 10);
			//header baris 1
			$pdf->Cell(20, 5, 'Tgl', 1, 0,  'C');
			$pdf->Cell(40, 5, 'Jenis Kerja Lebih', 1, 0, 'C');
			$pdf->Cell(20, 5, 'Jmlh Hari', 1, 0, 'C');
			$pdf->Cell(40, 5, 'Uang Kerja Lebih', 1, 0, 'C');
			$pdf->Cell(40, 5, 'Uang Makan', 1, 0, 'C');
			$pdf->Cell(40, 5, 'Total Terima', 1, 1, 'C');
			// Isi Tabel
			foreach($detailLembur as $dlembur) 
			{
				if($dlembur->statusHari=="Kerja")
				{
					$hari="Hari Biasa";
				}
				else
				{
					$hari="Hari Libur / Off";
				}

				$pdf->SetFont('', 'R', 10);
				$pdf->Cell(20, 5, date("d/m/Y", strtotime($dlembur->tglLembur)), 'LR', 0, 'C');
				$pdf->Cell(40, 5, $hari, 'LR', 0, 'L');
				$pdf->Cell(20, 5, $dlembur->jmlJam, 'LR', 0, 'C');
				$pdf->Cell(40, 5, number_format($dlembur->nilai, "0", ",", "."), 'LR', 0, 'R');
				$pdf->Cell(40, 5, $dlembur->uangMakan, 'LR', 0, 'R');
				$total= $dlembur->nilai + $dlembur->uangMakan;
				$pdf->Cell(40, 5, number_format($total, "0", ",", "."), 'LR', 1, 'R');
				$terima += $total;

			}
				//TUTUP
				$pdf->Cell(20, 5, '', 'LRB', 0, 'C');
				$pdf->Cell(40, 5, '', 'LRB', 0, 'L');
				$pdf->Cell(20, 5, '', 'LRB', 0, 'C');
				$pdf->Cell(40, 5, '', 'LRB', 0, 'R');
				$pdf->Cell(40, 5, '', 'LRB', 0, 'R');
				$pdf->Cell(40, 5, '', 'LRB', 1, 'R');
				//KOTAK TOTAL
				$pdf->Cell(20, 5, '', 0, 0, 'C');
				$pdf->Cell(40, 5, '', 0, 0, 'L');
				$pdf->Cell(20, 5, '', 0, 0, 'C');
				$pdf->Cell(40, 5, '', 0, 0, 'R');
				$pdf->Cell(40, 5, '', 0, 0, 'R');
				$pdf->Cell(40, 5, number_format($terima, "0", ",", "."), 'LRB', 1, 'R');
				//hitung slip lembur
				$counter++;
				if($counter==1)
				{
					// Set Y ke tengah halaman
					$pdf->SetXY(0, 139.7);
					$pdf->SetLineWidth(0.2);
					$pdf->Line(10, 139.7, 205, 139.7);
				}
				if($counter == 2) { // After printing 2 slips
				$counter = 0; // Reset counter
					if ($slembur !== end($data)) { // If not the last slip
					$pdf->AddPage('P', 'LETTER'); // Add new page
				}
			}
		}
		
		ob_end_clean();
		$pdf->Output('Slip Lembur '. $this->nama_bulan($bulan) . ' ' . $this->session->filter_tahun);
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

	public function hitung_lembur_semua() {
		$this->output->set_content_type('application/json');
		$bulan = intval($this->input->get('bulan'));
		$tahun = intval($this->input->get('tahun'));
		if (!$bulan || !$tahun) {
			echo json_encode(['success'=>false,'message'=>'Parameter bulan & tahun wajib']);
			return;
		}

		// Ambil semua lembur tervalidasi pada bulan/tahun validasi
		$this->db->where('status',1);
		$this->db->where('MONTH(tgl_validasi)',$bulan);
		$this->db->where('YEAR(tgl_validasi)',$tahun);
		$lemburList = $this->db->get('tbLembur')->result();

		$cntLembur = 0; $cntDetail = 0; $cntUpdated = 0; $totalNilai = 0; $totalUangMakan = 0; $detailResults = [];

		foreach($lemburList as $l){
			$cntLembur++;
			$jmlJam = (int)$l->jmlJam;
			$hari = $l->statusHari; // 'Kerja' atau 'Libur'
			$details = $this->db->get_where('tbLemburDetail',['idLembur'=>$l->id])->result();
			foreach($details as $d){
				$cntDetail++;
				$peg = $this->Lembur_model->pegawai_id($d->idtbPegawai)->row();
				if(!$peg){ continue; }
				$gaji = (float)$peg->nilaiUmk;
				$tarif = $this->db->get_where('tbMasterLembur', [
					'idSatKerja'=>$peg->skpd,
					'idJabatan'=>$peg->idJabatan,
					'idKelasJabatan'=>$peg->kelasJabatan
				])->result();
				$nominal = 0; $uangMakan = 0;
				if(count($tarif)>0){
					$tr = $tarif[0];
					$nilaiLembur = $gaji * $tr->tarif;
					if($hari=='Libur'){
						if($jmlJam >= 8){ $uangMakan = (float)$tr->uang_makan; }
						if($jmlJam > 9){
							$nominal1 = ($nilaiLembur * $tr->satujam_libur) * 8;
							$nominal9 = ($nilaiLembur * $tr->sembilanjam_libur);
							$sisaJam = $jmlJam - 9;
							$nominal10 = ($nilaiLembur * $tr->sepuluhjam_libur) * $sisaJam;
							$nominal = $nominal1 + $nominal9 + $nominal10;
						} elseif($jmlJam == 9){
							$nominal1 = ($nilaiLembur * $tr->satujam_libur) * 8;
							$nominal9 = ($nilaiLembur * $tr->sembilanjam_libur);
							$nominal = $nominal1 + $nominal9;
						} elseif($jmlJam >=1 && $jmlJam <=8){
							$nominal = ($nilaiLembur * $tr->satujam_libur) * $jmlJam;
						}
					}else{ // Hari Kerja
						if($jmlJam >= 8){ $uangMakan = (float)$tr->uang_makan; }
						if($jmlJam > 9){
							$nominal1 = ($nilaiLembur * $tr->satujam);
							$nominal28 = ($nilaiLembur * $tr->duajam) * 7;
							$nominal9 = ($nilaiLembur * $tr->delapanjam_lebih);
							$sisaJam = $jmlJam - 9;
							$nominal10 = ($nilaiLembur * $tr->sepuluhjam_lebih) * $sisaJam;
							$nominal = $nominal1 + $nominal28 + $nominal9 + $nominal10;
						} elseif($jmlJam == 9){
							$nominal1 = ($nilaiLembur * $tr->satujam);
							$nominal28 = ($nilaiLembur * $tr->duajam) * 7;
							$nominal9 = ($nilaiLembur * $tr->delapanjam_lebih);
							$nominal = $nominal1 + $nominal28 + $nominal9;
						} elseif($jmlJam >=2 && $jmlJam <=8){
							$nominal1 = ($nilaiLembur * $tr->satujam);
							$sisaJam = $jmlJam - 1;
							$nominal28 = ($nilaiLembur * $tr->duajam) * $sisaJam;
							$nominal = $nominal1 + $nominal28;
						} elseif($jmlJam == 1){
							$nominal = ($nilaiLembur * $tr->satujam) * $jmlJam;
						}
					}
				}
				$updateData = [];
				$nilai_pembulatan = $this->pembulatan_otomatis($nominal);
				if((float)$d->nilai !== (float)$nilai_pembulatan){ $updateData['nilai'] = $nilai_pembulatan; }
				if((float)$d->uangMakan !== (float)$uangMakan){ $updateData['uangMakan'] = $uangMakan; }
				if(!empty($updateData)){
					$this->db->update('tbLemburDetail',$updateData,['id'=>$d->id]);
					$cntUpdated++;
				}

				$totalNilai += $nilai_pembulatan;
				$totalUangMakan += $uangMakan;
				// Pembulatan kebawah (floor) sesuai permintaan
				//$nominal = floor($nominal);
				$detailResults[] = [
					'idDetail'=>$d->id,
					'idLembur'=>$l->id,
					'nip'=>$peg->nipBaru,
					'nilai'=>$nilai_pembulatan,
					'uangMakan'=>$uangMakan
				];
			}
		}

		echo json_encode([
			'success'=>true,
			'bulan'=>$bulan,
			'tahun'=>$tahun,
			'lembur_processed'=>$cntLembur,
			'detail_processed'=>$cntDetail,
			'detail_updated'=>$cntUpdated,
			'total_nilai'=>$totalNilai,
			'total_uang_makan'=>$totalUangMakan,
			'details'=>$detailResults
		]);
	}

	// Fungsi pembulatan otomatis: pecahan > 0.5 dibulatkan ke atas, 0.5 atau kurang dibulatkan ke bawah
	private function pembulatan_otomatis($angka){
		$dasar = floor($angka);
		$pecahan = $angka - $dasar;
		if($pecahan >= 0.5){
			return $dasar + 1;
		}
		return $dasar;
	}
	

}

