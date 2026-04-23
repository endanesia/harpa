<?php
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Libur_model extends CI_Model {

		function __construct()
		{
			parent::__construct();
		}

		function input($data_array){
			$input=$this->db->insert('tbRwLibur', $data_array);
			return $input;
		}

		function update($data_array,$id){
			$this->db->where('id',$id);
			$update=$this->db->update('tbRwLibur', $data_array);
			return $update;
		}

		function get_by_id($id){
			$this->db->select('*')->from('tbRwLibur');
			$this->db->where('id',$id);
			return  $this->db->get();
		}

		function show_data(){
			$this->db->order_by('tgl','DESC');
			return $this->db->get('tbRwLibur');
		}


		function delete($id){
			$tabelku="tbRwLibur";
			 if(is_array($id)){
				 $this->db->where_in('id',$id);
			 }else{
				$this->db->where('id',$id);
			}
			return $this->db->delete($tabelku);
		}
}