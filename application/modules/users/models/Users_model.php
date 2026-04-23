<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Users_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}

	function input($data_array)
	{
		$input = $this->db->insert('tbUser', $data_array);
		return $input;
	}

	function update($data_array, $id)
	{
		$this->db->where('idtbUser', $id);
		$update = $this->db->update('tbUser', $data_array);
		return $update;
	}

	function get_by_id($id)
	{
		$this->db->select('*')->from('tbUser');
		$this->db->where('idtbUser', $id);
		return  $this->db->get();
	}

	function show_data()
	{
		$this->db->select('tbUser.*,groupAlias');
		$this->db->from('tbUser');
		$this->db->join('tbGroupUser', 'tbGroupUser.id = tbUser.userLevel');
		$this->db->order_by('userName', 'ASC');
		return $this->db->get();
	}

	function delete($id)
	{
		$tabelku = "tbUser";
		if (is_array($id)) {
			$this->db->where_in('idtbUser', $id);
		} else {
			$this->db->where('idtbUser', $id);
		}
		return $this->db->delete($tabelku);
	}

	function select_group()
	{
		$this->db->select("*");
		$this->db->from('tbGroupUser');
		$this->db->order_by('groupAlias');
		return $this->db->get();
	}

	function Insert_group($data)
	{
		$this->db->insert('tbGroupUser', $data);
		return $this->db->insert_id();
	}

	function select_form()
	{
		$this->db->select("*");
		$this->db->from('tbPages');
		$this->db->order_by('module');
		return $this->db->get();
	}

	function Insert_group_item($data)
	{
		$this->db->insert('tbGroupItem', $data);
	}

	function update_group($data, $id)
	{
		$this->db->where('id', $id);
		$this->db->update('tbGroupUser', $data);
	}

	function Update_group_item($data, $id)
	{
		$this->db->where('id', $id);
		$this->db->update('tbGroupItem', $data);
	}

	function select_user_bygroup($id)
	{
		$this->db->select("idtbUser");
		$this->db->from('tbUser');
		$this->db->where('userLevel', $id);
		return $this->db->get();
	}

	function Select_group_item($id)
	{
		$this->db->select("tbGroupItem.id,tbGroupItem.idForm,tbPages.module,tbPages.alias,tbGroupItem.akses");
		$this->db->from('tbGroupItem');
		$this->db->join('tbPages', 'tbPages.id=tbGroupItem.idForm');
		$this->db->where('idGroup', $id);
		$this->db->order_by('tbPages.module');
		return $this->db->get();
	}

	function select_satkerja() {
		$this->db->order_by('nama');
		return $this->db->get('tbSatKerja');
	}

}
