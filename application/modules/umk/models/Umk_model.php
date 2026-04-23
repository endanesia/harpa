<?php
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Umk_model extends CI_Model {

		function __construct()
		{
			parent::__construct();
		}

		function input($data_array){
			$input=$this->db->insert('tbRwUmk', $data_array);
			return $input;
		}

		function update($data_array,$id){
			$this->db->where('id',$id);
			$update=$this->db->update('tbRwUmk', $data_array);
			return $update;
		}

		function get_by_id($id){
			$this->db->select('*')->from('tbRwUmk');
			$this->db->where('id',$id);
			return  $this->db->get();
		}

		function show_data($tahun = null){
			if($tahun !== null && $tahun !== ''){
				$this->db->where('tahun', $tahun);
			}
			$this->db->order_by('tahun','ASC');
			return $this->db->get('tbRwUmk');
		}

		// Ambil daftar tahun distinct untuk dropdown filter
		function get_years(){
			return $this->db->select('DISTINCT(tahun) as tahun', false)
						->from('tbRwUmk')
						->order_by('tahun','DESC')
						->get();
		}


		function delete($id){
			$tabelku="tbRwUmk";
			 if(is_array($id)){
				 $this->db->where_in('id',$id);
			 }else{
				$this->db->where('id',$id);
			}
			return $this->db->delete($tabelku);
		}

		function tunjangan_unit(){
			$this->db->order_by('id','ASC');
			return $this->db->get('tbSatKerja');
		}

		function tunjangan_unit_id($id){
			$this->db->where('id',$id);
			$this->db->order_by('id','ASC');
			return $this->db->get('tbSatKerja');
		}

		function update_gaji_satker($data_array,$satker){
			$this->db->where('skpd',$satker);
			$update=$this->db->update('tbPegawai', $data_array);
			return $update;
		}
}