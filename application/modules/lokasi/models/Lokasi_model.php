<?php
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Lokasi_model extends CI_Model {

		function __construct()
		{
			parent::__construct();
		}

		function input($data_array){
			$input=$this->db->insert('tbSatKerja', $data_array);
			return $input;
		}

		function update($data_array,$id){
			$this->db->where('id',$id);
			$update=$this->db->update('tbSatKerja', $data_array);
			return $update;
		}

		function get_by_id($id){
			$this->db->select('*')->from('tbSatKerja');
			$this->db->where('id',$id);
			return  $this->db->get();
		}

		function show_data(){
			$this->db->select('tbSatKerja.*,tbPropinsi.namaProv,tbKotaKab.namaKota');
			$this->db->join('tbPropinsi','tbSatKerja.prov_id = tbPropinsi.prov_id','LEFT');
			$this->db->join('tbKotaKab','tbSatKerja.kota_id = tbKotaKab.kota_id','LEFT');
			$this->db->order_by('nama','ASC');
			return $this->db->get('tbSatKerja');
		}


		function delete($id){
			$tabelku="tbSatKerja";
			 if(is_array($id)){
				 $this->db->where_in('id',$id);
			 }else{
				$this->db->where('id',$id);
			}
			return $this->db->delete($tabelku);
		}

		function get_propinsi() {
			$this->db->select('prov_id,namaProv');
			$this->db->order_by('namaProv');
			return $this->db->get('tbPropinsi');
		}

		function get_kota($prov) {
			$this->db->select('kota_id,namaKota');
			$this->db->order_by('namaKota');
			$this->db->where('prov_id',$prov);
			return $this->db->get('tbKotaKab');
		}
}