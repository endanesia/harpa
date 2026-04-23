<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Premi_shift_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}

	function input($data_array)
	{
		$input = $this->db->insert('tbPremishift', $data_array);
		return $input;
	}

	function update($data_array, $id)
	{
		$this->db->where('id', $id);
		$update = $this->db->update('tbPremishift', $data_array);
		return $update;
	}

	function get_by_id($id)
	{
		$this->db->select('*')->from('tbPremishift');
		$this->db->where('id', $id);
		return  $this->db->get();
	}

	function show_data()
	{
		return $this->db->get('tbPremishift');
	}


	function delete($id)
	{
		$this->db->where('id', $id);
		return $this->db->delete('tbPremishift');
	}

	function unit_kerja() {
		$this->db->select('id,nama');
		$this->db->from('tbSatKerja');
		$this->db->order_by('nama');
		return $this->db->get();
	}

	function unit_kerja_id($id) {
		$this->db->select('id,nama');
		$this->db->from('tbSatKerja');
		$this->db->where('id',$id);
		$this->db->order_by('nama');
		return $this->db->get();
	}

	function get_jabatan() {
		$this->db->from('tbJabatan');
		$this->db->order_by('namaJabatan');
		return $this->db->get();
	}

	function get_jabatan_id($id) {
		$this->db->from('tbJabatan');
		$this->db->where('idJabatan',$id);
		return $this->db->get();
	}

	function kelas_jabatan($id) {
		$this->db->select('id,kodeKelas');
		$this->db->from('tbKelasJabatan');
		$this->db->where('idJabatan',$id);
		$this->db->order_by('kodeKelas');
		return $this->db->get();
	}

	function kelas($id) {
		$this->db->select('id,kodeKelas');
		$this->db->from('tbKelasJabatan');
		$this->db->where('id',$id);
		$this->db->order_by('kodeKelas');
		return $this->db->get();
	}
}
