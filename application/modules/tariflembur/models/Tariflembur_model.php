<?php
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Tariflembur_model extends CI_Model {

		function __construct()
		{
			parent::__construct();
		}

		function show_data($unit){
			$this->db->where('idSatKerja',$unit);
			$this->db->order_by('id','DESC');
			return $this->db->get('tbMasterLembur');
		}

		function unit_kerja() {
			$this->db->order_by('nama');
			return $this->db->get('tbSatKerja');
		}

		function jabatan() {
			$this->db->order_by('namaJabatan');
			return $this->db->get('tbJabatan');
		}

		function kelasjabatan_id($kode) {
			$this->db->where('kodeKelas',$kode);
			$this->db->order_by('id');
			return $this->db->get('tbKelasJabatan');
		}

		function simpan($data) {
			$this->db->insert('tbMasterLembur', $data);
		}

		function ubah($id,$data) {
			$this->db->where('id',$id);
			$this->db->update('tbMasterLembur', $data);
		}

		function jabatan_id($id) {
			$this->db->where('idJabatan',$id);
			$this->db->order_by('idJabatan');
			return $this->db->get('tbJabatan');
		}

		function kelasjabatan_nama($kode) {
			$this->db->where('id',$kode);
			$this->db->order_by('id');
			return $this->db->get('tbKelasJabatan');
		}

		function Hapus_tarif($id_r) 
		{
			$this->db->where('id', $id_r);
			$this->db->Delete('tbMasterLembur'); 
		}

		function Kelas_jabatan($id) 
		{
			$this->db->where('idJabatan', $id);
			$this->db->order_by('id');
			return $this->db->get('tbKelasJabatan');
		}

		function get_gol($id)
		{
			$this->db->order_by('kodeKelas');
			$this->db->where('idJabatan', $id);
			return $this->db->get('tbKelasJabatan');
		}
	}