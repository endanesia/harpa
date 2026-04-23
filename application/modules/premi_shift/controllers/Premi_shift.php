<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Premi_shift extends Member_Control
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url'));
		$this->load->model(array('premi_shift_model'));
	}

	function index($s = 0)
	{
		return $this->show($s);
	}

	function show()
	{
		$data['bc'] = array('Dashboard' => site_url('dashboard'), 'Tunjangan' => site_url('tunjangan'));
		$data['title'] = "Tunjangan Premi Shift";
		$data['dt'] = $this->premi_shift_model->show_data()->result();
		$data['unit_kerja'] = $this->premi_shift_model->unit_kerja()->result(); 
		$data['list_jabatan'] = $this->premi_shift_model->get_jabatan()->result();  
		$this->template->mainview('premi_shift/premi_shift_index', $data);
	}

	function Simpan()
	{
		$data['idKelasJabatan'] = $this->input->post('idKelasJabatan');
		$data['idJabatan'] = $this->input->post('jabatan');
		$data['skpd'] = $this->input->post('skpd');
		$data['nPagi'] = $this->input->post('nilaipagi');
		$data['nSiang'] = $this->input->post('nilaisiang');
		$data['nMalam'] = $this->input->post('nilaimalam');
		$this->premi_shift_model->input($data);
		redirect(site_url('premi_shift'));
	}

	function Ubah($id)
	{
		$data['idKelasJabatan'] = $this->input->post('idKelasJabatan');
		$data['idJabatan'] = $this->input->post('jabatan');
		$data['skpd'] = $this->input->post('skpd');
		$data['nPagi'] = $this->input->post('nilaipagi');
		$data['nSiang'] = $this->input->post('nilaisiang');
		$data['nMalam'] = $this->input->post('nilaimalam');
		$this->premi_shift_model->update($data, $id);
		redirect(site_url('premi_shift'));
	}

	function Hapus($id) {
		$this->premi_shift_model->delete($id);
		redirect(site_url('premi_shift'));
	}

	function GetTunjangan()
	{
		$id = $_POST['id'];
		$dt = $this->tunjangan_model->get_by_id($id)->row();
		echo json_encode($dt);
	}

	function GetKelasJabatan() {
		$id = $_POST['id'];
		$dt = $this->tunjangan_model->kelas_jabatan($id)->result();
		echo json_encode($dt);
	}
}
