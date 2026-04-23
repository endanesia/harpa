<?php

	if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Ganti_jaga_model extends CI_Model {



		function __construct()

		{

			parent::__construct();

		}



		function input($data_array){

			$this->db->insert('tbSpgj', $data_array);

		}



		function get_by_id($id){

			$this->db->select('*')->from('tbSpgj');

			$this->db->where('id',$id);

			return  $this->db->get();

		}



		function show_data($unit, $bulan, $tahun) {
			$this->db->select('tbSpgj.*,namaPegawai,tbSatKerja.nama');
			$this->db->from('tbSpgj');
			$this->db->join('tbPegawai','tbPegawai.idtbPegawai = tbSpgj.idp_yg_diganti');
			$this->db->join('tbSatKerja','tbSatKerja.id = tbSpgj.skpd');
			if(!empty($unit)) {
				$this->db->where('tbSpgj.skpd', $unit);
			}
			if(!empty($bulan)) {
				$this->db->where('MONTH(tglLembur)', $bulan);
			}
			if(!empty($tahun)) {
				$this->db->where('YEAR(tglLembur)', $tahun);
			}
			$this->db->order_by('tglLembur', 'DESC');
			return $this->db->get();
		}

		function show_validasi($unit, $bulan, $tahun) {
			$this->db->select('tbSpgj.*,namaPegawai,tbSatKerja.nama,tbPegawai.nipBaru,tbPegawai.norek, tbPegawai.skpd, tbPegawai.idJabatan');
			$this->db->from('tbSpgj');
			$this->db->join('tbPegawai','tbPegawai.idtbPegawai = tbSpgj.idp_yg_mengganti');
			$this->db->join('tbSatKerja','tbSatKerja.id = tbSpgj.skpd');
			if(!empty($unit) && $unit != '') {
				$this->db->where('tbSpgj.skpd', $unit);
			}
			if(!empty($bulan)) {
				$this->db->where('MONTH(tgl_validasi)', $bulan);
			}
			if(!empty($tahun)) {
				$this->db->where('YEAR(tgl_validasi)', $tahun);
			}
			$this->db->order_by('tglLembur', 'ASC');
			$res =  $this->db->get();
			//tampilkan query sql yang terbentuk
			// echo $this->db->last_query();
			// die;
			return $res;
		}



		function show_data_all($bulan,$tahun)

		{	

			$this->db->where('month(tglLembur)',$bulan);

			$this->db->where('year(tglLembur)',$tahun);

			$this->db->order_by('id','DESC');

			return $this->db->get('tbSpgj');

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



		function unit_kerja($id=0) {

			if ($id != 0) {

				$this->db->where('id', $id);

			}

			$this->db->order_by('nama');

			return $this->db->get('tbSatKerja');

		}



		function update($data_array,$id){

			$this->db->where('id',$id);

			$this->db->update('tbSpgj', $data_array);



		}



		function Delete($id_r) 

		{

			$this->db->where('id', $id_r);

			$this->db->Delete('tbSpgj'); 

		}



		function Jaga($id){

			$this->db->where('id',$id);

			$this->db->order_by('id','DESC');

			return $this->db->get('tbSpgj');

		}



		function unit_kerja_id($id) {

			$this->db->where('id',$id);

			$this->db->order_by('nama');

			return $this->db->get('tbSatKerja');

		}



		function jabatan_id($id){

			$this->db->where('idJabatan',$id);

			$this->db->order_by('idJabatan','ASC');

			return $this->db->get('tbJabatan');

		}



		function get_premi_shift($idpeg,$tgl) {

			$this->db->select('tbShift.`premi_shift`, tbPremishift.`nPagi`, tbPremishift.`nSiang`, tbPremishift.`nMalam`');

			$this->db->from('tbSpgj');

			$this->db->join('tbPegawai','tbPegawai.`idtbPegawai` = tbSpgj.`idp_yg_diganti`');

			$this->db->join('tbPremishift','tbPegawai.`idJabatan` = tbPremishift.`idJabatan` AND tbPegawai.`kelasJabatan` = tbPremishift.`idKelasJabatan`');

			$this->db->join('tbRwKehadiran','tbRwKehadiran.tgl = tbSpgj.`tglLembur` AND tbRwKehadiran.`idtbPegawai` = tbSpgj.`idp_yg_diganti`');

			$this->db->join('tbShift','tbShift.id = tbRwKehadiran.id_shift');

			$this->db->where('tbPegawai.idtbPegawai',$idpeg);

			$this->db->where('tbSpgj.tglLembur',$tgl);

			return $this->db->get();

		}



}