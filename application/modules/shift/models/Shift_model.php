<?php
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Shift_model extends CI_Model {

		function __construct()
		{
			parent::__construct();
		}

		function input($data_array){
			$input=$this->db->insert('tbShift', $data_array);
			return $input;
		}

		function update($data_array,$id){
			$this->db->where('id',$id);
			$update=$this->db->update('tbShift', $data_array);
			return $update;
		}

		function get_by_id($id){
			$this->db->select('*')->from('tbShift');
			$this->db->where('id',$id);
			return  $this->db->get();
		}

		function show_data(){
			$this->db->order_by('nama_shift','ASC');
			return $this->db->get('tbShift');

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

		function show_detail($id_shift){
			$this->db->select('*');
			$this->db->from('tbShiftDetail');
			$this->db->where('id_shift',$id_shift);
			return $this->db->get();
		}

		function simpan_detail_shift($data,$id) {
			$this->db->where('id',$id);
			$this->db->update('tbShiftDetail',$data);
		}
}