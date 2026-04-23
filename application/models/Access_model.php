<?php if (!defined('BASEPATH')) {
    exit('No direct script acces allowed');
}

class Access_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_login_info($username)
    {
        $this->db->where('username', $username);
        $get = $this->db->get('tbUser');
        return ($get->num_rows() > 0) ? $get->row() : FALSE;
    }

    public function get_akses_list($id)
    {
        $this->db->where('idGroup', $id);
        $get = $this->db->get('tbGroupItem');
        return $get->result();
    }

    public function get_page_id($uri)
    {
        return $this->db->get_where('tbPages', array('uri' => $uri))->row();
    }

    public function pegawai()
    {
        if ($this->session->userdata('akses') != 1) {
            $this->db->where('skpd', $this->session->userdata('unit'));
        }
        $this->db->order_by('idtbPegawai', 'DESC');
        return $this->db->get('tbPegawai');
    }

    public function pegawai_id($id)
    {

        $this->db->where('idtbPegawai', $id);
        $this->db->order_by('idtbPegawai', 'DESC');
        return $this->db->get('tbPegawai');
    }

    public function unit()
    {
        if ($this->session->userdata('akses') != 1) {
            $this->db->where('id', $this->session->userdata('unit'));
        }
        $this->db->order_by('id', 'DESC');
        return $this->db->get('tbSatKerja');
    }

    public function unit_id($id)
    {
        $this->db->where('id', $id);
        $this->db->order_by('id', 'DESC');
        return $this->db->get('tbSatKerja');
    }


    public function user_pegawai()
    {
        if ($this->session->userdata('akses') != 1) {
            $this->db->where('skpd', $this->session->userdata('unit'));
        }
        $this->db->where('status', 1);
        $this->db->order_by('idtbUser', 'DESC');
        return $this->db->get('tbUser');
    }

    public function ex_lisensi()
    {
        $this->db->select('tbSertifikatKeahlian.*');
        $this->db->join('tbPegawai', 'tbPegawai.idtbPegawai = tbSertifikatKeahlian.idPegawai');
        if ($this->session->userdata('akses') != 1) {
            $this->db->where('skpd', $this->session->userdata('unit'));
            
        }
        $this->db->where('tbPegawai.flagStatus', 1);
        $ex = date("Y-m-d", strtotime("+3 month"));
        
        $this->db->where('sampai <=', $ex);
        $this->db->order_by('id', 'DESC');
        return $this->db->get('tbSertifikatKeahlian');
    }

    function get_kehadiran()
    {
        $tgl2 = date('Y-m-d');
        $date = $tgl2;
        $date = strtotime($date);
        $date = strtotime("-7 day", $date);
        $tgl =  date('Y-m-d', $date);
        if ($this->session->userdata('akses') == 1) {
            return $this->db->query("select tbPegawai.`nipBaru`, tbPegawai.`namaPegawai`,tbSatKerja.`nama`,count(tbRwKehadiran.`status`) as jml  
            from tbPegawai inner join tbSatKerja on tbPegawai.`skpd` = tbSatKerja.`id`
            inner join tbRwKehadiran on tbPegawai.`idelektronik` = tbRwKehadiran.`id_contact`
            where tbPegawai.flagStatus=1 and tbRwKehadiran.status = 'TK' AND tbRwKehadiran.tgl >= '". $tgl . "' AND  tbRwKehadiran.tgl < '" . $tgl2 . "'
            group by tbPegawai.`nipBaru`, tbPegawai.`namaPegawai`,tbSatKerja.`nama`
            having count(tbRwKehadiran.`status`) >= 3
            order by tbSatKerja.`nama`,COUNT(tbRwKehadiran.`status`) desc");
        } else {
            return $this->db->query("select tbPegawai.`nipBaru`, tbPegawai.`namaPegawai`,tbSatKerja.`nama`,count(tbRwKehadiran.`status`) as jml  
            from tbPegawai inner join tbSatKerja on tbPegawai.`skpd` = tbSatKerja.`id`
            inner join tbRwKehadiran on tbPegawai.`idelektronik` = tbRwKehadiran.`id_contact`
            where tbPegawai.flagStatus=1 and tbRwKehadiran.status = 'TK' AND tbRwKehadiran.tgl >= '". $tgl . "' AND  tbRwKehadiran.tgl < '" . $tgl2 . "' and tbPegawai.skpd = " . $this->session->userdata('unit') . " 
            group by tbPegawai.`nipBaru`, tbPegawai.`namaPegawai`,tbSatKerja.`nama`
            having count(tbRwKehadiran.`status`) >= 3
            order by tbSatKerja.`nama`,COUNT(tbRwKehadiran.`status`) desc");
        }
    }

    public function ex_pkwt()
    {
        if ($this->session->userdata('akses') != 1) {
            $this->db->where('skpd', $this->session->userdata('unit'));
        }
        $current_month = date('m');
        $current_year = date('Y');
        $this->db->where('MONTH(akhir_kontrak)', $current_month);
        $this->db->where('YEAR(akhir_kontrak)', $current_year);
        $this->db->where('jenisPegawai', 'PKWT');
        $this->db->where('flagStatus', 1);
        $this->db->order_by('akhir_kontrak', 'ASC');
        return $this->db->get('tbPegawai');
    }

    public function GetUmk($satKerja, $tahun)
    {
        $this->db->select('nilaiUmk');
        $this->db->from('tbRwUmk');
        $this->db->where('idSatKerja', $satKerja);
        $this->db->where('tahun', $tahun);
        return $this->db->get();
    }
}
