<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Tariflembur extends Member_Control
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url'));
		$this->load->model(array('Tariflembur_model'));
	}

	function index()
	{
		$satkerja = $this->session->userdata('filter_unit');
		$bulan = $this->session->userdata('filter_bulan');
		$tahun = $this->session->userdata('filter_tahun');
		
		if (isset($_POST['skpd'])) {
			$skpd = $this->input->post('skpd');
			$sess['filter_unit'] = $skpd;
			$this->session->set_userdata( $sess );
		}
		$data['bc'] = array('Dashboard' => site_url('dashboard'), 'Tarif Lembur' => site_url('tariflembur'));
		$data['title'] = "Tarif Lembur";
		$data['satkerja'] = $this->Tariflembur_model->unit_kerja()->result();
		$data['jabatan'] = $this->Tariflembur_model->jabatan()->result();
		if(isset($this->session->filter_unit))
		{
			$data['dt'] =$this->Tariflembur_model->show_data($this->session->filter_unit)->result(); 
		}
		else
		{
			$data['dt'] =$this->Tariflembur_model->show_data(0)->result(); 

		}
		$this->template->mainview('tariflembur/tariflembur_index', $data);
	}

	function Simpan()
	{
		if($this->input->post('unit') == 0 || $this->input->post('unit') == '')
		{
			redirect(site_url().'/tariflembur/Error_input');
		}
		else
		{
			$sess['filter_unit'] = $this->input->post('unit');
			$this->session->set_userdata( $sess );

			$tl['idSatKerja']=$this->input->post('unit');
			$tl['idJabatan']=$this->input->post('jabatan');
			$tl['idKelasJabatan']=$this->input->post('kelasJabatan');
			$tl['tarif']=$this->input->post('tarif_lembur');
			$tl['satujam']=$this->input->post('tarif_1');
			$tl['duajam']=$this->input->post('tarif_2-8');
			$tl['satujam_libur']=$this->input->post('tarif_1-8l');
			$tl['sembilanjam_libur']=$this->input->post('tarif_9-10l');
			$tl['sepuluhjam_libur']=$this->input->post('tarif_10l');
			$tl['sepuluhjam_lebih']=$this->input->post('tarif_10');
			$tl['delapanjam_lebih']=$this->input->post('tarif_8');
			$tl['uang_makan']=$this->input->post('uang_makan');
			$hasil=$this->Tariflembur_model->simpan($tl);
			redirect(site_url().'/tariflembur');
		}
	}

	function Update()
	{
		if(empty($this->session->userdata('filter_unit')))
		{
			redirect(site_url().'/tariflembur/Error_input');
		}
		else
		{
			$id=$this->input->post('idt');
			$tl['idJabatan']=$this->input->post('jabatan');
			$tl['idKelasJabatan']=$this->input->post('kelasJabatan');
			$tl['tarif']=$this->input->post('tarif_lembur');
			$tl['satujam']=$this->input->post('tarif_1');
			$tl['duajam']=$this->input->post('tarif_2-8');
			$tl['satujam_libur']=$this->input->post('tarif_1-8l');
			$tl['sembilanjam_libur']=$this->input->post('tarif_9-10l');
			$tl['sepuluhjam_lebih']=$this->input->post('tarif_10');
			$tl['sepuluhjam_libur']=$this->input->post('tarif_10l');
			$tl['delapanjam_lebih']=$this->input->post('tarif_8');
			$tl['uang_makan']=$this->input->post('uang_makan');
			$hasil=$this->Tariflembur_model->ubah($id,$tl);
			redirect(site_url().'/tariflembur');
		}
	}

	function Error_input()
	{
		$data['error']="Data Gagal disimpan Unit belum dipilih";
		$data['bc'] = array('Dashboard' => site_url('dashboard'), 'Tarif Lembur' => site_url('tariflembur'));
		$data['title'] = "Tarif Lembur";
		$data['satkerja'] = $this->Tariflembur_model->unit_kerja()->result();
		$data['jabatan'] = $this->Tariflembur_model->jabatan()->result();
		if(isset($this->session->filter_unit))
		{
			$data['dt'] =$this->Tariflembur_model->show_data($this->session->filter_unit)->result(); 
		}
		else
		{
			$data['dt'] =$this->Tariflembur_model->show_data(0)->result(); 
		}
		$this->template->mainview('tariflembur/tariflembur_index', $data);
		
	}

	function Hapus($id)
	{
		$this->Tariflembur_model->Hapus_tarif($id);
		redirect(site_url().'/tariflembur');
	}
	
}
