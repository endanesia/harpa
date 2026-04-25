<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Lokasi extends Member_Control
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url'));
		$this->load->model(array('lokasi_model'));
	}

	function index($s = 0)
	{
		return $this->show($s);
	}

	function show()
	{
		$data['bc'] = array('Dashboard' => site_url('dashboard'), 'Lokasi' => site_url('lokasi'));
		$data['title'] = "Lokasi";
		$data['dt'] = $this->lokasi_model->show_data()->result();
		$data['prov'] = $this->lokasi_model->get_propinsi()->result(); 
		$this->template->mainview('lokasi/lokasi_index', $data);
	}



	function Simpan()
	{
		$id = $this->input->post('id');
		$data['nama'] = $this->input->post('nama_lokasi');
		$data['prov_id'] = $this->input->post('prov_id');
		$data['kota_id'] = $this->input->post('kota_id');
		//jika $id = 0 maka lakukan operasi insert data
		if ($id == 0) {
			$this->lokasi_model->input($data);
		} else {
			//jika $id != 0 maka lakukan proses edit
			$this->lokasi_model->update($data, $id);
		}
		redirect(site_url('lokasi'));
	}


	function Hapus() {
		$id = $this->input->post('idhapus');
		$this->lokasi_model->delete($id);
		redirect(site_url('lokasi'));
	}


	function GetLokasi()
	{
		$id = $_POST['id'];
		$dt = $this->lokasi_model->get_by_id($id)->row();
		echo json_encode($dt);
	}

	function GetKota() {
		$id = $_POST['id'];
		$dt = $this->lokasi_model->get_kota($id)->result();
		echo json_encode($dt);		
	}
}
