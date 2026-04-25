<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Ump_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function input($data_array){
        $input = $this->db->insert('tbUmp', $data_array);
        return $input;
    }

    function update($data_array,$id){
        $this->db->where('id',$id);
        $update = $this->db->update('tbUmp', $data_array);
        return $update;
    }

    function get_by_id($id){
        $this->db->select('*')->from('tbUmp');
        $this->db->where('id',$id);
        return $this->db->get();
    }

    function show_data(){
        $this->db->order_by('tahun','ASC');
        return $this->db->get('tbUmp');
    }

    function delete($id){
        $tabelku = "tbUmp";
        if(is_array($id)){
            $this->db->where_in('id',$id);
        }else{
            $this->db->where('id',$id);
        }
        return $this->db->delete($tabelku);
    }
}