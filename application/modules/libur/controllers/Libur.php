<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Libur extends Member_Control
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url'));
		$this->load->model(array('libur_model'));
	}

	function index($s = 0)
	{
		return $this->show($s);
	}

	function show()
	{
		$data['bc'] = array('Dashboard' => site_url('dashboard'), 'Libur Nasional' => site_url('libur'));
		$data['title'] = "Hari Libur Nasional";
		$data['dt'] = $this->libur_model->show_data()->result();
		$this->template->mainview('libur/libur_index', $data);
	}



	function Simpan()
	{
		$id = $this->input->post('id');
		$data['tgl'] = $this->input->post('tgl');
		$data['ket'] = $this->input->post('ket');

		//jika $id = 0 maka lakukan operasi insert data
		if ($id == 0) {
			$this->libur_model->input($data);
		} else {
			//jika $id != 0 maka lakukan proses edit
			$this->libur_model->update($data, $id);
		}
		redirect(site_url('libur'));
	}


	function Hapus() {
		$id = $this->input->post('idhapus');
		$this->libur_model->delete($id);
		redirect(site_url('libur'));
	}


	function GetLibur()
	{
		$id = $_POST['id'];
		$dt = $this->libur_model->get_by_id($id)->row();
		echo json_encode($dt);
	}
}
