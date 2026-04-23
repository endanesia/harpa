<?php
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Presensi_model extends CI_Model {

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

		function show_data($sat){
			$this->db->select('nipBaru,namaPegawai,idelektronik,idtbPegawai');
			$this->db->order_by('namaPegawai','ASC');
			$this->db->where('skpd',$sat);
			return $this->db->get('tbPegawai');
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

		function unit_kerja($id=0) {
			if ($id != 0) {
				$this->db->where('id',$id);
			}
			$this->db->order_by('nama');
			return $this->db->get('tbSatKerja');
		}

		function get_hadir($idel,$bln,$thn) {
			$this->db->select('sum(hadir) as jml');
			$this->db->from('tbRwKehadiran');
			$this->db->where('id_contact',$idel);
			$this->db->where('month(tgl)',$bln);
			$this->db->where('year(tgl)',$thn);
			return $this->db->get();
		}

		function get_tk($idel,$bln,$thn) {
			$this->db->select('count(status) as jml');
			$this->db->from('tbRwKehadiran');
			$this->db->where('id_contact',$idel);
			$this->db->where('status','TK');
			$this->db->where('month(tgl)',$bln);
			$this->db->where('year(tgl)',$thn);
			return $this->db->get();
		}

		function get_cuti($idpeg,$bln,$thn) {
			$this->db->select('sum(jmlHari) as jml');
			$this->db->from('tbCuti');
			$this->db->where('idPegawai',$idpeg);
			$this->db->where('status','TK');
			$this->db->where('month(tglMulai)',$bln);
			$this->db->where('year(tglMulai)',$thn);
			return $this->db->get();
		}
}