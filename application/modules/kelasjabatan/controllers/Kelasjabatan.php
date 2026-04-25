<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Kelasjabatan extends Member_Control
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url'));
		$this->load->model(array('kelasjabatan_model'));
	}

	function index($s = 0)
	{
		return $this->show($s);
	}

	function show()
	{
		$data['bc'] = array('Dashboard' => site_url('dashboard'), 'KelasJabatan' => site_url('kelasjabatan'));
		$data['title'] = "Kelas Jabatan";
		$data['dt'] = $this->kelasjabatan_model->show_data()->result();
		$data['jabatan'] = $this->kelasjabatan_model->getJabatan()->result();
		$this->template->mainview('kelasjabatan/kelasjabatan_index', $data);
	}



	function Simpan()
	{
		$id = $this->input->post('id');
		$data['kodeKelas'] = $this->input->post('kodeKelas');
		$data['idJabatan'] = $this->input->post('idJabatan');
		$data['nilaiTunjangan'] = $this->input->post('NilaiTunjangan');

		//jika $id = 0 maka lakukan operasi insert data
		$cekData = $this->kelasjabatan_model->cekData($data['idJabatan'], $data['kodeKelas']);
		if ($id == 0) {
			if (count($cekData) > 0) {
				$this->session->set_flashdata('error', 'Gagal disimpan, Data yang anda masukkan sudah ada !!!');
			} else {
				$this->kelasjabatan_model->input($data);
			}
		} else {
			//jika $id != 0 maka lakukan proses edit
			if (count($cekData) > 0) {
				//cek apakah ada data yg sama
				if ($cekData[0]->id == $id) {
					$this->kelasjabatan_model->update($data, $id);
				} else {
					$this->session->set_flashdata('error', 'Gagal disimpan, Data yang anda masukkan sudah ada !!!');
				}
			} else {
				$this->kelasjabatan_model->update($data, $id);
			}
		}
		redirect(site_url('kelasjabatan'));
	}


	function Hapus()
	{
		$id = $this->input->post('idhapus');
		$this->kelasjabatan_model->delete($id);
		redirect(site_url('kelasjabatan'));
	}


	function GetKelasjabatan()
	{
		$id = $_POST['id'];
		$dt = $this->kelasjabatan_model->get_by_id($id)->row();
		echo json_encode($dt);
	}
}
