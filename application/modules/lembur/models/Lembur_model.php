<?php

	if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Lembur_model extends CI_Model {



		function __construct()

		{

			parent::__construct();

		}



		function show_data($unit,$bulan_ak,$tahun_ak){

			

			$satkerja = $this->session->userdata('filter_unit');

			$bulan = $this->session->userdata('filter_bulan');

			$tahun = $this->session->userdata('filter_tahun');

		

		if (isset($_POST['skpd'])) {

			$skpd = $this->input->post('skpd');

			$bulan = $this->input->post('bulan');

			$tahun = $this->input->post('tahun'); 

			if ($skpd != "0") {
				$sess['filter_unit'] = $skpd;
			}	
			

			$sess['filter_bulan'] = $bulan;

			$sess['filter_tahun'] = $tahun;

			$this->session->set_userdata( $sess );

		}
			if ($unit != 0) {
				$this->db->where('skpd',$unit);
			}
			$this->db->where('month(tglLembur)',$bulan_ak);

			$this->db->where('year(tglLembur)',$tahun_ak);

			$this->db->order_by('id','DESC');

			return $this->db->get('tbLembur');

		}

		

		function show_data_all($bulan,$tahun)

		{	

			$this->db->where('month(tglLembur)',$bulan);

			$this->db->where('year(tglLembur)',$tahun);

			$this->db->order_by('id','DESC');

			$this->db->limit(1);

			return $this->db->get('tbLembur');

		}



		function pegawai_lembur($id)

		{	

			$this->db->where('idLembur',$id);

			$this->db->order_by('id','DESC');

			return $this->db->get('tbLemburDetail');

		}



		function lembur($id)

		{	

			$this->db->where('id',$id);

			$this->db->order_by('id','DESC');

			return $this->db->get('tbLembur');

		}

		

		function update($data_array,$id){

			$this->db->where('id',$id);

			$this->db->update('tbLembur', $data_array);



		}



		function Delete_lembur($id_r) 

		{

			$this->db->where('id', $id_r);

			$this->db->Delete('tbLembur'); 

		}



		function Delete_lembur_detail($id_r) 

		{

			$this->db->where('idLembur', $id_r);

			$this->db->Delete('tbLemburDetail'); 

		}



		function get_by_id($id){

			$this->db->select('*')->from('tbShift');

			$this->db->where('id',$id);

			return  $this->db->get();

		}



		function unit_kerja($id=0) {

			if ($id != 0) {

				$this->db->where('id', $id);

			}

			$this->db->order_by('nama');

			return $this->db->get('tbSatKerja');

		}



		function input_lembur($data_array){

			$this->db->insert('tbLembur', $data_array);

		}



		function input_lembur_detail($data_array){

			$this->db->insert('tbLemburDetail', $data_array);

		}



		function Hapus_lembur_detail($id_r) 

		{

			$this->db->where('id', $id_r);

			$this->db->Delete('tbLemburDetail'); 

		}



		function lembur_wo($id){

			$this->db->where('noWo',$id);

			$this->db->order_by('id','ASC');

			return $this->db->get('tbLembur');

		}



		function detail_lembur_id($id){

			$this->db->where('idLembur',$id);

			$this->db->order_by('id','DESC');

			return $this->db->get('tbLemburDetail');

		}





		function pegawai(){

			$this->db->order_by('namaPegawai','ASC');

			return $this->db->get('tbPegawai');

		}



		function pegawai_id($id){
			$this->db->select('tbPegawai.*,tbRwUmk.nilaiUmk')->from('tbPegawai');
			$this->db->join('tbRwUmk','tbRwUmk.idSatKerja=tbPegawai.skpd','left');
			$this->db->where('tbRwUmk.tahun',date('Y'));
			$this->db->where('idtbPegawai',$id);
			return $this->db->get();

		}



		function pegawai_unit($unit){

			$this->db->where('skpd',$unit);

			$this->db->where('flagStatus',1);

			$this->db->order_by('namaPegawai','ASC');

			return $this->db->get('tbPegawai');

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
		function show_rincian($unit, $bulan, $tahun) 
		{
			$this->db->select(' tbLembur.id, tbLemburDetail.idtbPegawai, tbPegawai.nipBaru, tbPegawai.gelarDepan, tbPegawai.namaPegawai, tbPegawai.gelarBelakang, tbPegawai.jabatan, tbPegawai.norek, tbSatKerja.nama, tbLembur.tglLembur, tbLembur.statusHari, tbLembur.jmlJam, tbLemburDetail.nilai, tbLemburDetail.uangMakan, tbLembur.tgl_validasi, tbLembur.status');
			$this->db->from('tbLembur');
			$this->db->join('tbLemburDetail','tbLembur.id = tbLemburDetail.idLembur');
			$this->db->join('tbPegawai','tbPegawai.idtbPegawai = tbLemburDetail.idtbPegawai');
			$this->db->join('tbSatKerja','tbSatKerja.id = tbPegawai.skpd');
			if(!empty($unit) && $unit != '') {
				//$this->db->where('tbLembur.skpd', $unit);
			}
			if(!empty($bulan)) {
				$this->db->where('MONTH(tbLembur.tgl_validasi)', $bulan);
			}
			if(!empty($tahun)) {
				$this->db->where('YEAR(tbLembur.tgl_validasi)', $tahun);
			}
			$this->db->where('tbLembur.status', 1);
			$this->db->order_by('tglLembur', 'ASC');
			$res =  $this->db->get();
			//tampilkan query sql yang terbentuk
			// echo $this->db->last_query();
			// die;
			return $res;
		}

		function show_terima($unit, $bulan, $tahun) 
		{
			$this->db->select('tbLembur.id, tbPegawai.idtbPegawai, tbPegawai.nipBaru, tbPegawai.namaPegawai, tbPegawai.jabatan, tbPegawai.norek, tbSatKerja.nama, SUM(tbLemburDetail.nilai) AS nilai, SUM(tbLemburDetail.uangMakan) AS uangMakan, tbLembur.statusHari, tbLembur.tglLembur, tbLembur.status, tbLembur.tgl_validasi, SUM(tbLemburDetail.nilai)+SUM(tbLemburDetail.uangMakan) AS Total, tbLembur.tglLembur');
			$this->db->from('tbLembur');
			$this->db->join('tbLemburDetail','tbLembur.id = tbLemburDetail.idLembur');
			$this->db->join('tbPegawai','tbPegawai.idtbPegawai = tbLemburDetail.idtbPegawai');
			$this->db->join('tbSatKerja','tbSatKerja.id = tbPegawai.skpd');
			$this->db->group_by('tbPegawai.idtbPegawai');
			if(!empty($unit) && $unit != '') {
				//$this->db->where('tbLembur.skpd', $unit);
			}
			if(!empty($bulan)) {
				$this->db->where('MONTH(tbLembur.tgl_validasi)', $bulan);
			}
			if(!empty($tahun)) {
				$this->db->where('YEAR(tbLembur.tgl_validasi)', $tahun);
			}
			//$this->db->where('tbLembur.status', 1);
			$this->db->order_by('tglLembur', 'ASC');
			$res =  $this->db->get();
			//tampilkan query sql yang terbentuk
			// echo $this->db->last_query();
			// die;
			return $res;
		}

		function slip_lembur($unit, $bulan, $tahun) 
		{
			$this->db->select(' tbLembur.id, tbLemburDetail.idtbPegawai, tbPegawai.nipBaru, tbPegawai.gelarDepan, tbPegawai.namaPegawai, tbPegawai.gelarBelakang, tbPegawai.jabatan, tbPegawai.norek, tbSatKerja.nama, tbLembur.tglLembur, tbLembur.statusHari, tbLembur.jmlJam, tbLemburDetail.nilai, tbLemburDetail.uangMakan, tbLembur.tgl_validasi, tbLembur.status');
			$this->db->from('tbLembur');
			$this->db->join('tbLemburDetail','tbLembur.id = tbLemburDetail.idLembur');
			$this->db->join('tbPegawai','tbPegawai.idtbPegawai = tbLemburDetail.idtbPegawai');
			$this->db->join('tbSatKerja','tbSatKerja.id = tbPegawai.skpd');
			if(!empty($unit) && $unit != '') {
				$this->db->where('tbLembur.skpd', $unit);
			}
			if(!empty($bulan)) {
				$this->db->where('MONTH(tbLembur.tgl_validasi)', $bulan);
			}
			if(!empty($tahun)) {
				$this->db->where('YEAR(tbLembur.tgl_validasi)', $tahun);
			}
			$this->db->where('tbLembur.status', 1);
			$this->db->order_by('tglLembur', 'ASC');
			$this->db->group_by('nipBaru', 'ASC');

			$res =  $this->db->get();
			//tampilkan query sql yang terbentuk
			// echo $this->db->last_query();
			// die;
			return $res;
		}

		function detail_lembur($unit, $bulan, $tahun, $nip) 
		{
			$this->db->select(' tbLembur.id, tbLemburDetail.idtbPegawai, tbPegawai.nipBaru, tbPegawai.gelarDepan, tbPegawai.namaPegawai, tbPegawai.gelarBelakang, tbPegawai.jabatan, tbSatKerja.nama, tbLembur.tglLembur, tbLembur.statusHari, tbLembur.jmlJam, tbLemburDetail.nilai, tbLemburDetail.uangMakan, tbLembur.tgl_validasi, tbLembur.status');
			$this->db->from('tbLembur');
			$this->db->join('tbLemburDetail','tbLembur.id = tbLemburDetail.idLembur');
			$this->db->join('tbPegawai','tbPegawai.idtbPegawai = tbLemburDetail.idtbPegawai');
			$this->db->join('tbSatKerja','tbSatKerja.id = tbPegawai.skpd');
			if(!empty($unit) && $unit != '') {
				$this->db->where('tbLembur.skpd', $unit);
			}
			if(!empty($bulan)) {
				$this->db->where('MONTH(tbLembur.tgl_validasi)', $bulan);
			}
			if(!empty($tahun)) {
				$this->db->where('YEAR(tbLembur.tgl_validasi)', $tahun);
			}
			$this->db->where('tbLembur.status', 1);
			$this->db->where('tbPegawai.nipBaru', $nip);
			$res =  $this->db->get();
			//tampilkan query sql yang terbentuk
			// echo $this->db->last_query();
			// die;
			return $res;
		}
}
