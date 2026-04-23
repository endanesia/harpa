<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Pegawai_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}

	function input($data_array)
	{
		$input = $this->db->insert('tbPegawai', $data_array);
		return $this->db->insert_id();
	}

	function update($data_array, $id)
	{
		$this->db->where('idtbPegawai', $id);
		$update = $this->db->update('tbPegawai', $data_array);
		return $update;
	}

	function get_by_id($id)
	{
		$this->db->select('*')->from('tbPegawai');
		$this->db->where('idtbPegawai', $id);
		return  $this->db->get();
	}

	function show_data($unit, $jabatan)
	{
		$this->db->select('tbPegawai.*,tbKelasJabatan.kodeKelas, tbSatKerja.nama as namaUnit');
		$this->db->from('tbPegawai');
		$this->db->join('tbSatKerja', 'tbPegawai.skpd = tbSatKerja.id');
		$this->db->join('tbKelasJabatan', 'tbPegawai.kelasJabatan=tbKelasJabatan.id', 'LEFT');
		if ($unit != 0) {
			$this->db->where('skpd', $unit);
		}
		if ($jabatan != 0) {
			$this->db->where('tbPegawai.idJabatan', $jabatan);
		}
		$this->db->order_by('flagStatus', 'DESC');
		$this->db->order_by('namaPegawai', 'ASC');
		return $this->db->get();
	}

	function export()
	{
		$this->db->select('tbPegawai.*,tbKelasJabatan.kodeKelas, tbSatKerja.nama as namaUnit');
		$this->db->from('tbPegawai');
		$this->db->join('tbSatKerja', 'tbPegawai.skpd = tbSatKerja.id');
		$this->db->join('tbKelasJabatan', 'tbPegawai.kelasJabatan=tbKelasJabatan.id', 'LEFT');
		$this->db->where('flagStatus', 1);
		$this->db->order_by('namaPegawai', 'ASC');
		return $this->db->get();
	}

	function sertifikat()
	{
		$this->db->select(
		'tbSertifikatKeahlian.idPegawai
		, tbPegawai.*
		, tbSatKerja.nama AS NamaUnit
		, tbSertifikatKeahlian.namaSertifikat
		, tbSertifikatKeahlian.nomor
		, tbSertifikatKeahlian.berlaku
		, tbSertifikatKeahlian.sampai');
		$this->db->from('tbPegawai');
		$this->db->join('tbSertifikatKeahlian', 'tbPegawai.idtbPegawai = tbSertifikatKeahlian.idPegawai');
		$this->db->join('tbSatKerja', 'tbPegawai.skpd = tbSatKerja.id');
		$this->db->order_by('namaPegawai', 'ASC');
		return $this->db->get();
	}


	function get_jabatan($id = "")
	{
		$this->db->order_by('namaJabatan');
		if ($id != "") {
			$this->db->where('idJabatan', $id);
		}
		return $this->db->get('tbJabatan');
	}

	function get_unit($id = "")
	{
		$this->db->order_by('nama');
		if ($id != "") {
			$this->db->where('id', $id);
		}
		return $this->db->get('tbSatKerja');
	}

	function get_gol($id)
	{
		$this->db->order_by('kodeKelas');
		$this->db->where('idJabatan', $id);
		return $this->db->get('tbKelasJabatan');
	}

	function get_tunjangan($unit, $jabatan, $kelas)
	{
		$this->db->where('idKelasJabatan', $kelas);
		$this->db->where('idJabatan', $jabatan);
		$this->db->where("skpd", $unit);
		return $this->db->get('tbTunjangan');
	}

	function get_potongan($unit, $jabatan, $kelas)
	{
		$this->db->where('idKelasJabatan', $kelas);
		$this->db->where('idJabatan', $jabatan);
		$this->db->where("skpd", $unit);
		return $this->db->get('tbPotongan');
	}

	function get_tunj_khusus($id)
	{
		$this->db->where('idtbPegawai', $id);
		return $this->db->get('tbTunjanganKhusus');
	}

	function dt_user($id)
	{
		$this->db->where('idtbUser', $id);
		return $this->db->get('tbUser');
	}
	function get_pot_khusus($id)
	{
		$this->db->where('idtbPegawai', $id);
		return $this->db->get('tbPotonganKhusus');
	}
}
