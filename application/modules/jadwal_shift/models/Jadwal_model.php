<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Jadwal_model extends CI_Model

{



	function __construct()

	{

		parent::__construct();

	}



	function input($data_array)

	{

		$input = $this->db->insert('tbShift', $data_array);

		return $input;

	}



	function update($data_array, $id)

	{

		$this->db->where('id', $id);

		$update = $this->db->update('tbShift', $data_array);

		return $update;

	}



	function get_by_id($id)

	{

		$this->db->select('*')->from('tbShift');

		$this->db->where('id', $id);

		return  $this->db->get();

	}



	function show_data()

	{

		$this->db->order_by('nama_shift', 'ASC');

		return $this->db->get('tbShift');

	}





	function delete($id)

	{

		$tabelku = "tbShiftx";

		if (is_array($id)) {

			$this->db->where_in('id', $id);

		} else {

			$this->db->where('id', $id);

		}

		return $this->db->delete($tabelku);

	}



	function unit_kerja($id=0)

	{

		$this->db->order_by('nama');

		if ($id != 0) {

			$this->db->where('id', $id);

		}

		return $this->db->get('tbSatKerja');

	}



	function jabatan()

	{

		$this->db->where('section', 'SHIFT');

		

		$this->db->order_by('namaJabatan');

		return $this->db->get('tbJabatan');

	}

	function get_pegawai($unit,$jabatan) {

		if ($unit == '') {$unit = "0";}

		if ($jabatan == '') {$jabatan = "0";}

		$this->db->select('idtbPegawai,nipBaru,namaPegawai,idelektronik');

		$this->db->where('skpd',$unit);

		$this->db->where('idJabatan',$jabatan);

		$this->db->where('flagStatus',1);

		$this->db->order_by('noUrut,namaPegawai');

		return $this->db->get('tbPegawai');

	}



	function get_shift() {

		return $this->db->get('tbShift');

	}

	function get_shift_by_kode($kode)
	{
		$this->db->where('UPPER(kode)', strtoupper($kode));
		return $this->db->get('tbShift');
	}

	function pegawai_by_nip($nip)
	{
		$this->db->where('nipBaru', $nip);
		return $this->db->get('tbPegawai');
	}



	function get_kehadiran($id,$bln,$thn) {

		$bln1 = $bln - 1;

		$thn1 = $thn;

		if ($bln1 == 0) {

			$bln1=12;

			$thn1 = $thn -1;

		}

		$tgl1 = $thn1 . "-" . $bln1 . "-21"; 

		$tgl2 = $thn . "-" . $bln . "-20";

		$this->db->select("tbShift.kode,DATE_FORMAT(tgl,'%d') as tgl,tbRwKehadiran.status");

		$this->db->from('tbRwKehadiran');

		$this->db->join('tbShift','tbShift.id = tbRwKehadiran.id_shift','left');

		$this->db->where('id_contact',$id);

		$this->db->where('tgl >=',$tgl1);

		$this->db->where('tgl <= ',$tgl2);

		$this->db->order_by('tgl');

		return $this->db->get();



	}



	function get_premi_shift($idcontact,$bulan,$tahun) {

		$tgl2 = $tahun . "-" . $bulan . "-20";

		$bulan = $bulan - 1;

		if ($bulan == 0) {

			$bulan = 12;

			$tahun = $tahun - 1;

		}

		$tgl1 = $tahun . "-" . $bulan . "-21";

		$this->db->select('tbRwKehadiran.tgl,tbPegawai.`namaPegawai`,tbRwKehadiran.id_shift,tbShift.`nama_shift`, tbShift.`premi_shift`,tbPegawai.`idJabatan`, tbPegawai.`kelasJabatan`, tbPremishift.nPagi,tbPremishift.nSiang,tbPremishift.nMalam');

		$this->db->from('tbRwKehadiran');

		$this->db->join('tbPegawai','tbRwKehadiran.idtbPegawai = tbPegawai.idtbPegawai');

		$this->db->join('tbShift','tbRwKehadiran.`id_shift` = tbShift.`id`');

		$this->db->join('tbPremishift','tbPegawai.`idJabatan` = tbPremishift.`idJabatan` AND tbPegawai.`kelasJabatan` = tbPremishift.`idKelasJabatan`');

		$this->db->where('tbRwKehadiran.id_contact',$idcontact);

		$this->db->where('tgl >=',$tgl1);

		$this->db->where('tgl <=',$tgl2);

		$this->db->group_by('tbRwKehadiran.tgl,tbPegawai.`namaPegawai`,tbRwKehadiran.id_shift,tbShift.`nama_shift`, tbShift.`premi_shift`,tbPegawai.`idJabatan`, tbPegawai.`kelasJabatan`, tbPremishift.nPagi,tbPremishift.nSiang,tbPremishift.nMalam');

		

		return $this->db->get();

	}



	function hitung_premi_plot($nip,$bulan,$tahun) {

		$this->db->select('*');

		$this->db->from('tbRwPremishift');

		$this->db->where('nip', $nip);

		$this->db->where('bulan', $bulan);

		$this->db->where('tahun', $tahun);

		return $this->db->get();

	}



	function get_plot($nip,$bln,$thn) {

		$this->db->select('*');

		$this->db->from('tbPlotShift');

		$this->db->where('bulan',$bln);

		$this->db->where('tahun', $thn);

		$this->db->where('nip', $nip);

		return $this->db->get();

	}



	function kota($id)

	{

		$this->db->where('kota_id', $id);

		return $this->db->get('tbKotaKab');

	}

}

