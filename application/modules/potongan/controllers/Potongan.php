<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Potongan extends Member_Control
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url'));
		$this->load->model(array('potongan_model'));
	}

	function index()
	{
		return $this->show();
	}

	function show()
	{
		$data['bc'] = array('Dashboard' => site_url('dashboard'), 'Potongan' => site_url('potongan'));
		$data['title'] = "Potongan Gaji";
		$data['dt'] = $this->potongan_model->show_data()->result();
		$data['unit_kerja'] = $this->potongan_model->unit_kerja()->result(); 
		$data['list_jabatan'] = $this->potongan_model->get_jabatan()->result();
		$this->template->mainview('potongan/potongan_index', $data);
	}

	function Simpan()
	{
		$id = $this->input->post('id');
		$data['namaPotongan'] = $this->input->post('namaPotongan');
		$data['nilai'] = $this->input->post('nilai');
		$data['satuan'] = $this->input->post('satuan');
		$data['idKelasJabatan'] = $this->input->post('idKelasJabatan');
		$data['idJabatan'] = $this->input->post('jabatan');
		$data['skpd'] = $this->input->post('skpd');

		//jika $id = 0 maka lakukan operasi insert data
		if ($id == 0) {
			$this->potongan_model->input($data);
		} else {
			//jika $id != 0 maka lakukan proses edit
			$this->potongan_model->update($data, $id);
		}
		redirect(site_url('potongan'));
	}

	function Hapus() {
		$id = $this->input->post('idhapus');
		$this->potongan_model->delete($id);
		redirect(site_url('potongan'));
	}

	function GetPotongan()
	{
		$id = $_POST['id'];
		$dt = $this->potongan_model->get_by_id($id)->row();
		echo json_encode($dt);
	}

	function GetKelasJabatan() {
		$id = $_POST['id'];
		$dt = $this->potongan_model->kelas_jabatan($id)->result();
		echo json_encode($dt);
	}
}
