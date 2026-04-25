<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Presensi extends Member_Control
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url'));
		$this->load->model(array('presensi_model'));
	}


	function index()
	{
		if ($this->session->userdata('akses') == 1) {
			$satkerja = $this->session->userdata('filter_unit');
			$data['satkerja'] = $this->presensi_model->unit_kerja()->result();
		} else {
			$satkerja = $this->session->userdata('unit');
			$data['satkerja'] = $this->presensi_model->unit_kerja($this->session->userdata('unit'))->result();
		}
		
		$bulan = $this->session->userdata('filter_bulan');
		$tahun = $this->session->userdata('filter_tahun');
		if (isset($_POST['skpd'])) {
			$satkerja = $this->input->post('skpd');
			$bulan = $this->input->post('bulan');
			$tahun = $this->input->post('tahun'); 
			$sess['filter_unit'] = $satkerja;
			$sess['filter_bulan'] = $bulan;
			$sess['filter_tahun'] = $tahun;
			$this->session->set_userdata( $sess );
		}
		$data['bc'] = array('Dashboard' => site_url('dashboard'), 'Rekap Presensi' => site_url('shift'));
		$data['title'] = "Rekap Presensi $bulan / $tahun";
		$data['dt'] = $this->presensi_model->show_data($satkerja)->result();

		
		$this->template->mainview('presensi/presensi_index', $data);
	}

	function Simpan()
	{
		$id = $this->input->post('id');
		$data['nama_shift'] = $this->input->post('nama_shift');
		$data['tipe'] = $this->input->post('tipe');

		//jika $id = 0 maka lakukan operasi insert data
		if ($id == 0) {
			$this->presensi_model->input($data);
		} else {
			//jika $id != 0 maka lakukan proses edit
			$this->presensi_model->update($data, $id);
		}
		redirect(site_url('Shift'));
	}


	function Hapus() {
		$id = $this->input->post('idhapus');
		$this->presensi_model->delete($id);
		redirect(site_url('Shift'));
	}


	function GetShift()
	{
		$id = $_POST['id'];
		$dt = $this->presensi_model->get_by_id($id)->row();
		echo json_encode($dt);
	}
}
