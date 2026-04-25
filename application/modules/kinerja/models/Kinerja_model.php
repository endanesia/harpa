<?php
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Kinerja_model extends CI_Model {

		function __construct()
		{
			parent::__construct();
		}

		function input($data_array){
			$input=$this->db->insert('tbKinerja', $data_array);
			return $input;
		}

		function update($data_array,$id){
			$this->db->where('id',$id);
			$update=$this->db->update('tbKinerja', $data_array);
			return $update;
		}

		function get_by_id($id){
			$this->db->select('*')->from('tbKinerja');
			$this->db->where('id',$id);
			return  $this->db->get();
		}

		function show_data($unit){
			$this->db->order_by('namaPegawai','ASC');
			$this->db->where('skpd',$unit);
			$this->db->where('flagStatus',1);
			return $this->db->get('tbPegawai');
		}

		function select($bulan,$tahun,$nip){
			$this->db->where('bulan',$bulan);
			$this->db->where('tahun',$tahun);
			$this->db->where('nip',$nip);
			return $this->db->get('tbKinerja');
		}

		

		function delete($id){
			$tabelku="tbShift";
			 if(is_array($id)){
				 $this->db->where_in('id',$id);
			 }else{
				$this->db->where('id',$id);
			}
			return $this->db->delete($tabelku);
		}

		function unit_kerja() {
			$this->db->order_by('nama');
			return $this->db->get('tbSatKerja');
		}

		function pegawai_id($id) {
			$this->db->where_in('nipBaru',$id);
			return $this->db->get('tbPegawai');
		}

		function unit_id($id) {
			$this->db->where('id',$id);
			$this->db->order_by('nama');
			return $this->db->get('tbSatKerja');
		}

		function skorkinerja($id) {
			$this->db->where('id',$id);
			$this->db->order_by('id');
			return $this->db->get('tbKinerja');
		}
}