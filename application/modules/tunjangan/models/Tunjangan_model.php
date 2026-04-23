<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Tunjangan_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}

	function input($data_array)
	{
		$input = $this->db->insert('tbTunjangan', $data_array);
		return $input;
	}

	function update($data_array, $id)
	{
		$this->db->where('id', $id);
		$update = $this->db->update('tbTunjangan', $data_array);
		return $update;
	}

	function get_by_id($id)
	{
		$this->db->select('tbTunjangan.*,tbSatKerja.nama,tbJabatan.namaJabatan,tbKelasJabatan.kodeKelas');
		$this->db->from('tbTunjangan');
		$this->db->join('tbSatKerja','tbTunjangan.skpd = tbSatKerja.id','LEFT');
		$this->db->join('tbJabatan','tbTunjangan.idJabatan = tbJabatan.idJabatan','LEFT');
		$this->db->join('tbKelasJabatan','tbTunjangan.idKelasJabatan = tbKelasJabatan.id','LEFT');
		$this->db->where('tbTunjangan.id', $id);
		return  $this->db->get();
	}

	function show_data()
	{
		$this->db->select('tbTunjangan.*,tbSatKerja.nama,tbJabatan.namaJabatan,tbKelasJabatan.kodeKelas');
		$this->db->from('tbTunjangan');
		$this->db->join('tbSatKerja','tbTunjangan.skpd = tbSatKerja.id','LEFT');
		$this->db->join('tbJabatan','tbTunjangan.idJabatan = tbJabatan.idJabatan','LEFT');
		$this->db->join('tbKelasJabatan','tbTunjangan.idKelasJabatan = tbKelasJabatan.id','LEFT');
		$this->db->order_by('tbSatKerja.nama', 'ASC');
		$this->db->order_by('namaTunjangan', 'ASC');
		$this->db->order_by('namaJabatan', 'ASC');
		$this->db->order_by('kodeKelas', 'ASC');
		return $this->db->get();
	}


	function delete($id)
	{
		$tabelku = "tbTunjangan";
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
