<?php

	if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Cuti_model extends CI_Model {



		function __construct()

		{

			parent::__construct();

		}



		function show_data($unit,$bulan_ak,$tahun_ak){

			$this->db->where('skpd',$unit);

			$this->db->where('month(tgl)',$bulan_ak);

			$this->db->where('year(tgl)',$tahun_ak);

			$this->db->order_by('id','DESC');

			return $this->db->get('tbCuti');

		}



		function show_data_cuti(){

			$bulan_ak=date("m");

			$tahun_ak=date("Y");

			$this->db->where('month(tgl)',$bulan_ak);

			$this->db->where('year(tgl)',$tahun_ak);

			$this->db->order_by('id','DESC');

			return $this->db->get('tbCuti');

		}

	

		function banyak_cuti($id,$tgl){

			$tahun_ak=date("Y");

			$this->db->select("tgl, sum(jmlHari) as banyak_cuti");

			$this->db->where('idPegawai',$id);

			$this->db->where('year(tgl)',$tahun_ak);

			$this->db->where('tgl<=',$tgl);

			$this->db->order_by('id','DESC');

			return $this->db->get('tbCuti');

		}

		

		function pegawai(){

			$this->db->order_by('namaPegawai','ASC');

			return $this->db->get('tbPegawai');

		}



		function pegawai_id($id){

			$this->db->where('idtbPegawai',$id);

			$this->db->order_by('namaPegawai','ASC');

			return $this->db->get('tbPegawai');

		}



		function pegawai_unit($unit){

			$this->db->where('skpd',$unit);

			$this->db->where('flagStatus',1);

			$this->db->order_by('namaPegawai','ASC');

			return $this->db->get('tbPegawai');

		}



		function input($data_array){

			$input=$this->db->insert('tbCuti', $data_array);

		}



		function update($data_array,$id){

			$this->db->where('id',$id);

			$update=$this->db->update('tbCuti', $data_array);

			return $update;

		}



		function get_by_id($id){

			$this->db->select('*')->from('tbShift');

			$this->db->where('id',$id);

			return  $this->db->get();

		}



		function Delete_cuti($id_r) 

		{

			$this->db->where('id', $id_r);

			$this->db->Delete('tbCuti'); 

		}



		function unit_kerja($id=0) {

			if ($id != 0) {

				$this->db->where('id', $id);

			}

			$this->db->order_by('nama');

			return $this->db->get('tbSatKerja');

		}



		function cuti_id($id){

			$this->db->where('id',$id);

			$this->db->order_by('id','DESC');

			return $this->db->get('tbCuti');

		}



		function jabatan_id($id){

			$this->db->where('idJabatan',$id);

			$this->db->order_by('idJabatan','ASC');

			return $this->db->get('tbJabatan');

		}



		function unit_kerja_id($id) {

			$this->db->where('id',$id);

			$this->db->order_by('nama');

			return $this->db->get('tbSatKerja');

		}

}
