<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Potongan_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}

	function input($data_array)
	{
		$input = $this->db->insert('tbPotongan', $data_array);
		return $input;
	}

	function update($data_array, $id)
	{
		$this->db->where('id', $id);
		$update = $this->db->update('tbPotongan', $data_array);
		return $update;
	}

	function get_by_id($id)
	{
		$this->db->select('*')->from('tbPotongan');
		$this->db->where('id', $id);	
		return  $this->db->get();
	}

	function show_data()
	{
		$this->db->select('tbPotongan.*,tbSatKerja.nama,tbJabatan.namaJabatan,tbKelasJabatan.kodeKelas');
		$this->db->from('tbPotongan');
		$this->db->join('tbSatKerja','tbPotongan.skpd = tbSatKerja.id','LEFT');
		$this->db->join('tbJabatan','tbPotongan.idJabatan = tbJabatan.idJabatan','LEFT');
		$this->db->join('tbKelasJabatan','tbPotongan.idKelasJabatan = tbKelasJabatan.id','LEFT');
		$this->db->order_by('tbPotongan.skpd');
		$this->db->order_by('namaPotongan', 'ASC');
		$this->db->order_by('namaJabatan');
		$this->db->order_by('kodeKelas');	
		return $this->db->get();
	}


	function delete($id)
	{
		$tabelku = "tbPotongan";
		if (is_array($id)) {
			$this->db->where_in('id', $id);
		} else {
			$this->db->where('id', $id);
		}
		return $this->db->delete($tabelku);
	}

	function unit_kerja() {
		$this->db->select('id,nama');
		$this->db->from('tbSatKerja');
		$this->db->order_by('nama');
		return $this->db->get();
	}

	function get_jabatan() {
		$this->db->from('tbJabatan');
		$this->db->order_by('namaJabatan');
		return $this->db->get();
	}

	function kelas_jabatan($id) {
		$this->db->select('id,kodeKelas');
		$this->db->from('tbKelasJabatan');
		$this->db->where('idJabatan',$id);
		$this->db->order_by('kodeKelas');
		return $this->db->get();
	}
}
