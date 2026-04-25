<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Tunj_cuti_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}

	function show_data($unit, $bln, $thn)
	{
		$this->db->where('id_unit', $unit);
		$this->db->where('bulan', $bln);
		$this->db->where('tahun', $thn);
		$this->db->order_by('nip', 'ASC');
		return $this->db->get('tbRwThr');
	}

	function unit_kerja()
	{
		$this->db->order_by('nama');
		return $this->db->get('tbSatKerja');
	}

	function unit_id($id)
	{
		$this->db->where('id', $id);
		$this->db->order_by('nama');
		return $this->db->get('tbSatKerja');
	}

	function pegawai_unit($id)
	{
		$this->db->where('skpd', $id);
		$this->db->where('flagStatus', 1);
		$this->db->order_by('namaPegawai');
		return $this->db->get('tbPegawai');
	}

	function pegawai_person($id)
	{
		$this->db->where('nipBaru', $id);
		$this->db->order_by('namaPegawai');
		return $this->db->get('tbPegawai');
	}

	function GetCuti($idContact, $tahun)
	{
		$this->db->select('sum(jmlHari) as jml');
		$this->db->from('tbCuti');
		$this->db->where('status', 1);
		$this->db->where('year(tglMulai)', $tahun);
		$this->db->where('ket', 'tahunan');
		$this->db->where('idPegawai', $idContact);
		return $this->db->get();
	}

	function GetUmk($satKerja, $tahun)
	{
		$this->db->select('nilaiUmk');
		$this->db->from('tbRwUmk');
		$this->db->join('tbSatKerja', 'tbRwUmk.idSatKerja = tbSatKerja.id');
		$this->db->join('tbKotaKab', 'tbSatKerja.kota_id = tbKotaKab.kota_id');
		$this->db->where('tbKotaKab.kota_id', 232);
		$this->db->where('tahun', $tahun);
		$this->db->limit(1);
		return $this->db->get();
	}

	function GetTunjPerUnit($satkerja, $tahun)
	{
		$this->db->select('sum(jml) as nilai, count(id) as jml');
		$this->db->from('tbRwTCuti');
		$this->db->where('tahun', $tahun);
		$this->db->where('id_unit', $satkerja);
		return $this->db->get();
	}

	function select($satkerja,$tahun) {
		$this->db->select('tbRwTCuti.*,tbPegawai.namaPegawai,tbPegawai.jabatan,tbPegawai.norek');
		$this->db->from('tbRwTCuti');
		$this->db->join('tbPegawai','tbRwTCuti.nip = tbPegawai.nipBaru');
		$this->db->where('tahun', $tahun);
		$this->db->where('id_unit', $satkerja);
		return $this->db->get();
	}

	function select_id($id) {
		$this->db->select('tbRwTCuti.*,tbPegawai.namaPegawai,tbPegawai.jabatan,tbPegawai.norek');
		$this->db->from('tbRwTCuti');
		$this->db->join('tbPegawai','tbRwTCuti.nip = tbPegawai.nipBaru');
		$this->db->where('tbRwTCuti.id', $id);
		return $this->db->get();
	}
}
