<?php
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Jabatan_model extends CI_Model {

		function __construct()
		{
			parent::__construct();
		}

		function input_jabatan($data_array){
			$input=$this->db->insert('tbJabatan', $data_array);
			return $input;
		}

		function update_jabatan($data_array,$id){
			$this->db->where('idJabatan',$id);
			$update=$this->db->update('tbJabatan', $data_array);
			return $update;
		}

		function get_by_id_jabatan($id){
			$this->db->select('*')->from('tbJabatan');
			$this->db->where('idJabatan',$id);
			return  $this->db->get();
		}

		function show_data_jabatan($option=NULL,$start=NULL,$limit=NULL){
			$sql="SELECT A.* FROM tbJabatan A  ";
			if($option!=NULL){
				 $sql.=$option;
			 }
			 if($start!=NULL && $limit!=NULL){
				 $sql.=" LIMIT ".$start.",".$limit ;
			 }
			return $this->db->query($sql);
		}

		function Delete($id_r) 
		{
			$this->db->where('idJabatan', $id_r);
			$this->db->Delete('tbJabatan'); 
		}
}