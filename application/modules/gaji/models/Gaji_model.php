<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Gaji_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}

	function input($data_array)
	{
		$input = $this->db->insert('tbRwThr', $data_array);
		return $input;
	}

	function update($data_array, $id)
	{
		$this->db->where('id', $id);
		$update = $this->db->update('tbRwThr', $data_array);
		return $update;
	}

	function update_nip($data_array, $id)
	{
		$this->db->where('nip', $id);
		$update = $this->db->update('tbRwThr', $data_array);
	}

	function get_by_id($id)
	{
		$this->db->select('*')->from('tbShift');
		$this->db->where('id', $id);
		return  $this->db->get();
	}

	function show_data($unit, $bln, $thn)
	{
		$this->db->where('id_unit', $unit);
		$this->db->where('bulan', $bln);
		$this->db->where('tahun', $thn);
		$this->db->order_by('nip', 'ASC');
		return $this->db->get('tbRwThr');
	}

	function select_gaji($unit, $bln, $thn)
	{
		$this->db->select('tbRwGaji.*,namaPegawai');
		if ($unit != 0) {
			$this->db->where('id_unit', $unit);
		}
		$this->db->where('bulan', $bln);
		$this->db->where('tahun', $thn);
		$this->db->from('tbRwGaji');
		$this->db->join('tbPegawai', 'tbPegawai.nipBaru = tbRwGaji.nip');
		$this->db->order_by('namaPegawai', 'ASC');
		return $this->db->get();
	}

	function unit_kerja($id=0)
	{
		if ($id != 0) {
			$this->db->where('id', $id);
		}
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
		$this->db->order_by('idJabatan,kelasJabatan,namaPegawai');
		return $this->db->get('tbPegawai');
	}

	function pegawai_unit_limit($id,$page=1)
	{
		$this->db->where('skpd', $id);
		$this->db->where('flagStatus', 1);
		$this->db->order_by('namaPegawai');
		
		$offset = (10*$page) - 10;
		$this->db->limit(10,$offset);

		return $this->db->get('tbPegawai');
	}

	function pegawai_person($id)
	{
		$this->db->where('nipBaru', $id);
		$this->db->order_by('namaPegawai');
		return $this->db->get('tbPegawai');
	}

	function pegawai_id($id, $bln, $thn)
	{
		$this->db->where('nip', $id);
		$this->db->where('tahun', $thn);
		$this->db->where('bulan', $bln);
		$this->db->order_by('id');
		return $this->db->get('tbRwThr');
	}
	function jabatan($id)
	{
		$this->db->where('idJabatan', $id);
		$this->db->order_by('idJabatan');
		return $this->db->get('tbJabatan');
	}

	function thr_id($id)
	{
		$this->db->where('id', $id);
		$this->db->order_by('id');
		return $this->db->get('tbRwThr');
	}

	function jenis_potongan()
	{
		$this->db->select('namaPotongan');
		$this->db->distinct();
		$this->db->order_by('namaPotongan');
		return $this->db->get('tbPotongan');
	}

	function GetKehadiran($idContact, $bulan, $tahun)
	{
		if ($bulan == 1) {
			$blnStart = 12;
			$thnStart = $tahun - 1;
		} else {	
			$blnStart = $bulan - 1;
			$thnStart = $tahun;
		}
		$dStart = $thnStart . "-" . $blnStart . "-21";
		$dEnd = $tahun . "-" . $bulan . "-20"; 

		$this->db->select('sum(hadir) as jml');
		$this->db->from('tbRwKehadiran');
		$this->db->where('hadir', 1);
		$this->db->where("tgl >=",$dStart);
		$this->db->where("tgl <=",$dEnd);
		$this->db->where('id_contact', $idContact);
		return $this->db->get();
	}

	function GetLemburan($idPegawai, $bulan, $tahun)
	{
		$this->db->select('nilai, uangMakan');
		$this->db->from('tbLemburDetail');
		$this->db->join('tbLembur', 'tbLembur.id = tbLemburDetail.idLembur');
		$this->db->where('idtbPegawai', $idPegawai);
		$this->db->where('month(tgl_validasi)', $bulan);
		$this->db->where('year(tgl_validasi)', $tahun);
		return $this->db->get();
	}

	function total_tunjangan($nip, $bulan, $tahun)
	{
		$this->db->select('sum(jml) as total');
		$this->db->from('tbRwTunjangan');
		$this->db->where('nip', $nip);
		$this->db->where('bulan', $bulan);
		$this->db->where('tahun', $tahun);
		$res = $this->db->get()->row();
		return $res->total;
	}

	function total_potongan($nip, $bulan, $tahun)
	{
		$this->db->select('sum(jml) as total');
		$this->db->from('tbRwPotongan');
		$this->db->where('nip', $nip);
		$this->db->where('bulan', $bulan);
		$this->db->where('tahun', $tahun);
		$res =  $this->db->get()->row();
		return $res->total;
	}

	function Data_Gaji_Person($id)
	{
		$this->db->where('id', $id);
		$this->db->order_by('id');
		return $this->db->get('tbRwGaji');
	}

	function Data_Tunjangan_Person($nip, $bulan, $tahun)
	{
		$this->db->select('tbRwTunjangan.*,tbTunjangan.tunjKontribusi');
		$this->db->from('tbRwTunjangan');
		$this->db->join('tbTunjangan', 'tbRwTunjangan.kode_tunjangan = tbTunjangan.id', 'left');
		$this->db->where('nip', $nip);
		$this->db->where('bulan', $bulan);
		$this->db->where('tahun', $tahun);
		$this->db->order_by('tunjKontribusi', 'DESC');
		$this->db->order_by('nama_tunjangan', 'ASC');
		return $this->db->get();
	}

	function Data_Potongan_Person($nip, $bulan, $tahun)
	{
		$this->db->where('nip', $nip);
		$this->db->where('bulan', $bulan);
		$this->db->where('tahun', $tahun);
		$this->db->order_by('nama_potongan,id');
		return $this->db->get('tbRwPotongan');
	}

	function get_premi_shift($idPeg, $bulan, $tahun)
	{
		if ($bulan == 1) {
			$blnStart = 12;
			$thnStart = $tahun - 1;
		} else {	
			$blnStart = $bulan - 1;
			$thnStart = $tahun;
		}
		$dStart = $thnStart . "-" . $blnStart . "-21";
		$dEnd = $tahun . "-" . $bulan . "-20"; 

		$this->db->select('sum(premi_shift) as jml, sum(tunjangan) as jml_tunjangan');
		$this->db->from('tbSpgj');
		$this->db->where('idp_yg_mengganti', $idPeg);
		$this->db->where('tgl_validasi >=', $dStart);
		$this->db->where('tgl_validasi <=', $dEnd);
		$this->db->where('status', 1);
		return $this->db->get();
	}

	function get_pot_premi_shift($idPeg, $bulan, $tahun)
	{
		if ($bulan == 1) {
			$blnStart = 12;
			$thnStart = $tahun - 1;
		} else {	
			$blnStart = $bulan - 1;
			$thnStart = $tahun;
		}
		$dStart = $thnStart . "-" . $blnStart . "-21";
		$dEnd = $tahun . "-" . $bulan . "-20"; 

		$this->db->select('sum(premi_shift) as jml');
		$this->db->from('tbSpgj');
		$this->db->where('idp_yg_diganti', $idPeg);
		$this->db->where('tgl_validasi >= ', $dStart);
		$this->db->where('tgl_validasi <=', $dEnd);
		$this->db->where('status', 1);
		return $this->db->get();
	}

	function pegawai_premishift($id)
	{
		$this->db->select('tbPegawai.idtbPegawai,tbPegawai.idelektronik,tbPegawai.nipBaru,tbPremishift.nPagi,tbPremishift.nSiang,tbPremishift.nMalam');
		$this->db->from('tbPegawai');
		$this->db->join('tbPremishift','tbPegawai.`idJabatan` = tbPremishift.`idJabatan` AND tbPegawai.skpd = tbPremishift.`skpd` AND tbPegawai.`kelasJabatan` = tbPremishift.idKelasJabatan');
		$this->db->where('tbPegawai.skpd', $id);
		$this->db->where('flagStatus', 1);
		return $this->db->get();
	}

	function pegawai_premishift_byid($id)
	{
		$this->db->select('tbPegawai.idtbPegawai,tbPegawai.idelektronik,tbPegawai.nipBaru,tbPremishift.nPagi,tbPremishift.nSiang,tbPremishift.nMalam');
		$this->db->from('tbPegawai');
		$this->db->join('tbPremishift','tbPegawai.`idJabatan` = tbPremishift.`idJabatan` AND tbPegawai.skpd = tbPremishift.`skpd` AND tbPegawai.`kelasJabatan` = tbPremishift.idKelasJabatan');
		$this->db->where('tbPegawai.idtbPegawai', $id);
		$this->db->where('flagStatus', 1);
		return $this->db->get();
	}

	function get_premishift($idcontact,$bulan,$tahun) {
		if ($bulan == 1) {
			$blnStart = 12;
			$thnStart = $tahun - 1;
		} else {	
			$blnStart = $bulan - 1;
			$thnStart = $tahun;
		}
		$tgl1 = $thnStart . "-" . $blnStart . "-21";
		$tgl2 = $tahun . "-" . $bulan . "-20"; 
		return $this->db->query("SELECT tbRwKehadiran.`id_shift`, tbShift.`premi_shift` FROM tbRwKehadiran 
		INNER JOIN tbShift ON tbRwKehadiran.`id_shift` = tbShift.`id`
		WHERE  id_contact=$idcontact AND tgl >= '$tgl1' AND tgl <= '$tgl2'");
	}

	function load_tunjangan($tunj,$unit,$bulan,$tahun) {
		$this->db->select('tbRwTunjangan.*,tbPegawai.namaPegawai,tbPegawai.jabatan');
		$this->db->from('tbPegawai');
		$this->db->join('tbRwTunjangan','tbPegawai.nipBaru = tbRwTunjangan.nip');
		$this->db->where('tbRwTunjangan.bulan',$bulan);
		$this->db->where('tbRwTunjangan.tahun',$tahun);
		if ($unit != "--" && $unit != "-- Pilih Unit Kerja --") {
			$this->db->where('tbRwTunjangan.id_unit',$unit);
		}
		$this->db->where('tbRwTunjangan.nama_tunjangan',$tunj);
		return $this->db->get();
	}

	function get_list_tunjangan($unit,$bulan,$tahun) {
		if ($unit != "--" && $unit != "-- Pilih Unit Kerja --") {
			$rs = $this->db->query("SELECT nama_tunjangan FROM tbRwTunjangan WHERE bulan=$bulan AND tahun=$tahun AND id_unit=$unit GROUP BY nama_tunjangan");
		} else {
			$rs = $this->db->query("SELECT nama_tunjangan FROM tbRwTunjangan WHERE bulan=$bulan AND tahun=$tahun GROUP BY nama_tunjangan");
		}
		return $rs;
	}

	function load_potongan($pot,$unit,$bulan,$tahun) {
		$this->db->select('tbRwPotongan.*,tbPegawai.namaPegawai,tbPegawai.jabatan');
		$this->db->from('tbPegawai');
		$this->db->join('tbRwPotongan','tbPegawai.nipBaru = tbRwPotongan.nip');
		$this->db->where('tbRwPotongan.bulan',$bulan);
		$this->db->where('tbRwPotongan.tahun',$tahun);
		$this->db->where('tbRwPotongan.id_unit',$unit);
		$this->db->where('tbRwPotongan.nama_potongan',$pot);
		return $this->db->get();
	}

	function get_list_potongan($unit,$bulan,$tahun) {
		$rs = $this->db->query("SELECT nama_potongan FROM tbRwPotongan WHERE bulan=$bulan AND tahun=$tahun AND id_unit=$unit GROUP BY nama_potongan");
		return $rs;
	}
	function unit_pegawai($nip)
	{
		$this->db->select('idtbPegawai,nipBaru,namaPegawai,skpd,nama');
		$this->db->where('nipBaru', $nip);
		$this->db->where('flagStatus',1);
		$this->db->from('tbPegawai');
		$this->db->join('tbSatKerja', 'tbPegawai.skpd = tbSatKerja.id');
		return $this->db->get();
	}
	function cek_riwayat_gaji($bln,$thn,$unit) {
		$this->db->select('count(id) as jml');
		$this->db->from('tbRwGaji');
		$this->db->where('bulan', $bln);
		$this->db->where('tahun', $thn);
		$this->db->where('id_unit', $unit);
		return $this->db->get();
	}
	function GetTunjanganCuti($tahun)
	{
		$this->db->select("nilaiUmk as jml");
		$this->db->from('tbRwUmk');
		$this->db->join('tbSatKerja', 'tbRwUmk.idSatKerja = tbSatKerja.id');
		$this->db->join('tbKotaKab', 'tbSatKerja.kota_id = tbKotaKab.kota_id');
		$this->db->where('tbKotaKab.kota_id', 232);
		$this->db->where('tahun', $tahun);
		$this->db->limit(1);
		return $this->db->get()->row()->jml / 2;
	}

	function get_tunjangan_kontribusi($idKelas, $idJabatan, $idSatKerja) {
		$this->db->select('sum(nilai) as jml');
		$this->db->from('tbTunjangan');
		$this->db->where('idKelasJabatan', $idKelas);
		$this->db->where('idJabatan', $idJabatan);
		$this->db->where('skpd', $idSatKerja);
		$this->db->where('tunjKontribusi', 1);
		return $this->db->get();
	}

	function get_tunjangan_khusus_kontribusi($id) {
		$this->db->select('sum(nilai) as jml');
		$this->db->from('tbTunjanganKhusus');
		$this->db->where('idtbPegawai', $id);
		$this->db->where('tunjKontribusi', 1);
		return $this->db->get();
	}
}
