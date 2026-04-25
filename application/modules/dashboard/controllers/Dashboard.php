<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends Member_Control

{



	public function __construct()

	{

		parent::__construct();

		$this->load->helper(array('url'));

	}





	public function index()

	{	

		$data['title'] = 'Dashboard';

		$data['search'] = site_url('Dashboard');

		$data['bc'] = array('Dashboard' => site_url('dashboard/index'));

		//-----data pegawai

		$data['pegawai'] = $this->Access_model->pegawai()->num_rows();



		//-----data unit kerja

		$data['satkerja'] = $this->Access_model->unit()->num_rows();



		//----data lisensi



		//---data user

		$data['user'] = $this->Access_model->user_pegawai()->num_rows();

		//data expired

		$data['expire']= $this->Access_model->ex_lisensi()->result();

		//data pkwt yang akan berakhir
		$data['expire_pkwt'] = $this->Access_model->ex_pkwt()->result();



		$this->template->mainview('dashboard/dashboard_view', $data);

	}



	public function test() {

		if ($this->access->boleh(2)) {

			echo 'ok';

		} else {

			echo 'blok';

		}

	}



	public function upsandi($id) {;

		$p1 = $this->input->post('p1'); 

		$p2 = $this->input->post('p2'); 

		if ($p1 == $p2) {

			$data['userPassword'] = md5($p1);

		} else {

			$this->session->set_flashdata('errMsg', 'Peringatan...! Password dan konfirmasi password tidak sama, silahkan ulangi');			

		}

		$sql="UPDATE tbUser SET userPassword = '".$data['userPassword']."'". " WHERE idtbUser=".$id;

		$this->db->query($sql);

		redirect(site_url('dashboard'));

	}



	public function absen_mingguan() {

		$data['title'] = 'Dashboard';

		$data['search'] = site_url('Dashboard');

		$data['bc'] = array('Dashboard' => site_url('dashboard'), 'Absensi Mingguan' => site_url('dashboard_absen_mingguan'));

		//data warning kehadiran

		$data['absen'] = $this->Access_model->get_kehadiran()->result();

		$this->template->mainview('dashboard/absen_mingguan_view',$data);

	}

}

