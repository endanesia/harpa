<?php
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Laporan_t_model extends CI_Model {

		function __construct()
		{
			parent::__construct();
		}

		function show_data(){
			$bulan_ak=date("m");
			$tahun_ak=date("Y");
			$this->db->where('month(tgl)',$bulan_ak);
			$this->db->where('year(tgl)',$tahun_ak);
			$this->db->order_by('id','DESC');
			return $this->db->get('tbCuti');
		}
}