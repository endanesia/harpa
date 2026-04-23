<?php
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Kelasjabatan_model extends CI_Model {

		function __construct()
		{
			parent::__construct();
		}

		function input($data_array){
			$input=$this->db->insert('tbKelasJabatan', $data_array);
			return $input;
		}

		function update($data_array,$id){
			$this->db->where('id',$id);
			$update=$this->db->update('tbKelasJabatan', $data_array);
			return $update;
		}

		function get_by_id($id){
			$this->db->select('*')->from('tbKelasJabatan')
			->join('tbJabatan', 'tbJabatan.idJabatan=tbKelasJabatan.idJabatan');
			$this->db->where('id',$id);
			return  $this->db->get();
		}

		function show_data(){
			$this->db->select('tbKelasJabatan.id,kodeKelas,namaJabatan');
			$this->db->from('tbKelasJabatan');
			$this->db->join('tbJabatan','tbKelasJabatan.idJabatan = tbJabatan.idJabatan');
			$this->db->order_by('namaJabatan','ASC');
			$this->db->order_by('kodeKelas','ASC');
			return $this->db->get();
		}


		function delete($id){
			$tabelku="tbKelasJabatan";
			 if(is_array($id)){
				 $this->db->where_in('id',$id);
			 }else{
				$this->db->where('id',$id);
			}
			return $this->db->delete($tabelku);
		}

		function getJabatan() {
			$this->db->order_by('namaJabatan');
			return $this->db->get('tbJabatan');
		}

		function cekData($idJabatan,$kodeKelas) {
			$this->db->select('id');
			$this->db->where('idJabatan',$idJabatan);
			$this->db->where('kodeKelas',$kodeKelas);
			return $this->db->get('tbKelasJabatan')->result();
		}
}