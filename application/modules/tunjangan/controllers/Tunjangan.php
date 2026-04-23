<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Tunjangan extends Member_Control
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url'));
		$this->load->library(array('template', 'form_validation', 'session'));
		$this->load->model('Tunjangan_model');
	}

	function index($s = 0)
	{
		return $this->show($s);
	}

	function show()
	{
		$data['bc'] = array('Dashboard' => site_url('dashboard'), 'Tunjangan' => site_url('tunjangan'));
		$data['title'] = "Tunjangan Gaji";
		$data['dt'] = $this->Tunjangan_model->show_data()->result();
		$data['unit_kerja'] = $this->Tunjangan_model->unit_kerja()->result(); 
		$data['list_jabatan'] = $this->Tunjangan_model->get_jabatan()->result();  
		$this->template->mainview('tunjangan/tunjangan_index', $data);
	}

	public function Simpan()
	{
		$id = $this->input->post('id');
		$data = array(
			'namaTunjangan' => $this->input->post('namaTunjangan'),
			'nilai' => $this->input->post('nilai'),
			'satuan' => $this->input->post('satuan'),
			'skpd' => $this->input->post('skpd'),
			'idJabatan' => $this->input->post('jabatan'),
			'idKelasJabatan' => $this->input->post('idKelasJabatan'),
			'tunjKontribusi' => $this->input->post('tunjKontribusi') ? 1 : 0
		);

		if ($id == 0) {
			$this->Tunjangan_model->input($data);
		} else {
			$this->Tunjangan_model->update($data, $id);
		}
		redirect('tunjangan');
	}

	public function GetTunjangan()
	{
		$id = $this->input->post('id');
		$dt = $this->Tunjangan_model->get_by_id($id)->row();
		$data = array(
			'namaTunjangan' => $dt->namaTunjangan,
			'nilai' => $dt->nilai,
			'satuan' => $dt->satuan,
			'skpd' => $dt->skpd,
			'idJabatan' => $dt->idJabatan,
			'idKelasJabatan' => $dt->idKelasJabatan,
			'tunjKontribusi' => $dt->tunjKontribusi
		);
		echo json_encode($data);
	}

	function Hapus() {
		$id = $this->input->post('idhapus');
		$this->Tunjangan_model->delete($id);
		redirect(site_url('tunjangan'));
	}

	function GetKelasJabatan() {
		$id = $_POST['id'];
		$dt = $this->Tunjangan_model->kelas_jabatan($id)->result();
		echo json_encode($dt);
	}
}
