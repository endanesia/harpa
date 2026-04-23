<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Umk extends Member_Control
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url'));
		$this->load->model(array('umk_model'));
	}

	function index($s = 0)
	{
		return $this->show($s);
	}

	function show()
	{
		$data['bc'] = array('Dashboard' => site_url('dashboard'), 'UMK' => site_url('umk'));
		$data['title'] = "UMK";
		// Ambil tahun dari GET atau POST
		$tahun_filter = $this->input->get_post('filter_tahun');
		$data['filter_tahun'] = $tahun_filter;
		$data['dt'] = $this->umk_model->show_data($tahun_filter)->result();
		$data['list_tahun'] = $this->umk_model->get_years()->result();
		$this->template->mainview('umk/umk_index', $data);
	}

	function Simpan()
	{
		$id = $this->input->post('id');
		$data['tahun'] = $this->input->post('tahun');
		$data['idSatKerja'] = $this->input->post('unit_umk');
		$data['gajiPokok']=$this->input->post('gaji_pokok');
		$data['tunjanganTetap']=$this->input->post('tunjangan_tetap');
		$data['nilaiUmk']=$data['gajiPokok']+$data['tunjanganTetap'];
		$this->umk_model->input($data);
		redirect(site_url('umk'));
	}

	function Hapus($id) {
		$this->umk_model->delete($id);
		redirect(site_url('umk'));
	}

	function GetUmk()
	{
		$id = $_POST['id'];
		$dt = $this->umk_model->get_by_id($id)->row();
		echo json_encode($dt);
	}

	function Update_umk($id)
	{
		
		$umk['idSatKerja']=$this->input->post('unit_umk');
		$umk['tahun']=$this->input->post('tahun');
		$umk['gajiPokok']=$this->input->post('gaji_pokok');
		$umk['tunjanganTetap']=$this->input->post('tunjangan_tetap');
		$umk['nilaiUmk']=$umk['gajiPokok']+$umk['tunjanganTetap'];
		$edit=$this->umk_model->update($umk,$id);
		redirect(site_url('umk'));
	}

	function Update_gaji($satker,$gaji,$tunjangan=0)
	{
		//jadikan total gaji 110% dari $gaji
		$gaji = $gaji * 1.1;
		$data['gaji']=$gaji;
		$edit=$this->umk_model->update_gaji_satker($data,$satker);
		redirect(site_url('umk'));
	}
}
