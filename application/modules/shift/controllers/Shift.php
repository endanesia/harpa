<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Shift extends Member_Control
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url'));
		$this->load->model(array('shift_model'));
	}

	function index($s = 0)
	{
		return $this->show($s);
	}

	function show()
	{
		$data['bc'] = array('Dashboard' => site_url('dashboard'), 'Shift' => site_url('shift'));
		$data['title'] = "Shift";
		$data['dt'] = $this->shift_model->show_data()->result();
		$this->template->mainview('shift/shift_index', $data);
	}



	function Simpan()
	{
		$id = $this->input->post('id');
		$data['nama_shift'] = $this->input->post('nama_shift');
		$data['kode'] = $this->input->post('kode');
		$data['premi_shift'] = $this->input->post('premi_shift');


		//jika $id = 0 maka lakukan operasi insert data
		if ($id == 0) {
			$this->shift_model->input($data);
		} else {
			//jika $id != 0 maka lakukan proses edit
			$this->shift_model->update($data, $id);
		}
		redirect(site_url('shift'));
	}


	function Hapus() {
		$id = $this->input->post('idhapus');
		$this->shift_model->delete($id);
		redirect(site_url('shift'));
	}


	function GetShift()
	{
		$id = $_POST['id'];
		$dt = $this->shift_model->get_by_id($id)->row();
		echo json_encode($dt);
	}

	function Detail($id)
	{
		$shift = $this->shift_model->get_by_id($id)->row();
		$data['bc'] = array('Dashboard' => site_url('dashboard'), 'Data Shift' => site_url('shift'), 'Detail Shift' => site_url('shift/Detail/') . $id);
		$data['title'] = "Detail Shift (" . $shift->nama_shift . ")";
		$data['datanya'] = $this->shift_model->show_detail($id)->result(); 
		$data['id'] = $id;

		//echo "halaman detail " . $id;
		$this->template->mainview('shift/shift_detail', $data);
	}

	function simpan_detail($id) {
		$datanya = $this->shift_model->show_detail($id)->result(); 
		foreach ($datanya as $dt) {
			$iddetail = $dt->id;
			$data['jam_masuk'] = $this->input->post('masuk'.$dt->id);
			$data['jam_keluar'] = $this->input->post('keluar'.$dt->id);
			$this->shift_model->simpan_detail_shift($data,$iddetail);
		}
		redirect(site_url('shift'));
	}
}
