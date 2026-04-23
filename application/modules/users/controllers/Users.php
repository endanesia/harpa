<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Users extends Member_Control
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url'));
		$this->load->model(array('users_model'));
	}

	function index($s = 0)
	{
		return $this->show($s);
	}

	function show()
	{
		$data['bc'] = array('Dashboard' => site_url('dashboard'), 'User' => site_url('user'));
		$data['title'] = "User";
		$data['satkerja'] = $this->users_model->select_satkerja()->result();
		$data['akses'] = $this->users_model->select_group()->result();
		$data['dt'] = $this->users_model->show_data()->result();
		$this->template->mainview('users/users_index', $data);
	}

	function group()
	{
		$data['bc'] = array('Dashboard' => site_url('dashboard'), 'Akses User' => site_url('users/group'));
		$data['title'] = "Akses User";
		$data['list_group'] = $this->users_model->select_group()->result();
		$this->template->mainview('users/users_akses', $data);
	}

	function edit_group($id)
	{
		$data['bc'] = array('Dashboard' => site_url('dashboard'), 'Akses User' => site_url('users/group'), 'Detail ' => site_url('user/group/edit_group/' . $id));
		$dt = $this->db->get_where('tbGroupUser', array('id' => $id))->row();
		$data['title'] = "Detail Akses " . $dt->groupAlias;
		$data['list_form'] = $this->users_model->Select_group_item($id)->result();
		$data['errMsg'] = '';
		$data['id'] = $id;

		$this->template->mainview('users/users_akses_detail', $data);
	}

	public function editgroup($id)
	{
		$data['errMsg'] = '';

		$list_form = $this->users_model->select_group_item($id)->result();
		foreach ($list_form as $rs) {
			$data2['akses'] = $this->input->post('c' . $rs->idForm);
			$this->users_model->Update_group_item($data2, $rs->id);
		}
		redirect('users/group');
	}

	function simpanGroup()
	{
		$nama = $this->input->post('nama');
		$id = $this->input->post('id');
		if ($this->input->post('id') > 0) {
			//edit

			$data['groupAlias'] = $nama;
			$idg = $this->users_model->update_group($data, $id);
		} else {
			//baru
			$data['groupAlias'] = $nama;
			$idg = $this->users_model->insert_group($data);
			$list_form = $this->users_model->select_form()->result();
			foreach ($list_form as $rs) {
				$data2['idGroup'] = $idg;
				$data2['idForm'] = $rs->id;
				$data2['akses'] = "1";
				$this->users_model->Insert_group_item($data2);
			}
		}
		redirect(site_url('users/group'));
	}

	function Simpan()
	{
		$id = $this->input->post('id');
		$data['skpd'] = $this->input->post('skpd');
		$data['userName'] = $this->input->post('userName');
		$data['userLevel'] = $this->input->post('userLevel');
		$data['status'] = $this->input->post('status');
		$data['email'] = $this->input->post('email');

		//jika $id = 0 maka lakukan operasi insert data
		if ($id == 0) {
			if ($this->db->get_where('tbUser', array('userName' => $data['userName']))->num_rows() > 0) {
				$this->session->set_flashdata('errMsg','Upss...! Nama user sudah terpakai, silahkan gunakan nama lain!!!');
			} else {
				$this->users_model->input($data);
			}
		} else {
			//jika $id != 0 maka lakukan proses edit
			$this->users_model->update($data, $id);
		}
		redirect(site_url('users'));
	}

	function Hapus()
	{
		$id = $this->input->post('idhapus');
		$this->users_model->delete($id);
		redirect(site_url('Users'));
	}

	function GetUsers()
	{
		$id = $_POST['id'];
		$dt = $this->users_model->get_by_id($id)->row();
		echo json_encode($dt);
	}

	function delgroup($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('tbGroupUser');
		redirect(site_url('users/group'));
	}

	function password() {
		$id = $this->input->post('idUser');
		$p1 = $this->input->post('p1'); 
		$p2 = $this->input->post('p2'); 
		if ($p1 == $p2) {
			$data['userPassword'] = md5($p1);
			$this->db->where('idtbUser',$id);
			$this->db->update('tbUser',$data);
		} else {
			$this->session->set_flashdata('errMsg', 'Peringatan...! Password dan konfirmasi password tidak sama, silahkan ulangi');			
		}

		redirect(site_url('users'));
	}
}
