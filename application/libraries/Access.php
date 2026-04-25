<?php if (!defined('BASEPATH')) {
    exit('No direct script acces allowed');
}

#[AllowDynamicProperties]
class Access
{
    public $user;
    protected $CI;
    // COnstruktor

    public function __construct()
    {
        $this->CI =& get_instance();
        //$auth = $this->CI->config->item('auth');

        $this->CI->load->helper('cookie', 'global_function');
        $this->CI->load->model('Access_model');
        $this->Access_model =& $this->CI->Access_model;
    }

    /*cek Login User*/
    public function login($username, $password)
    {

        $result=$this->Access_model->get_login_info($username);
        if ($result) {
            //cek status akun
            if ($result->status == 0) {
                return 403; // status tdk aktif
            } elseif (md5($password) == $result->userPassword) {
                    $this->CI->session->set_userdata('userid', $result->idtbUser);
                    $this->CI->session->set_userdata('nama', stripslashes($result->userName));
                    $this->CI->session->set_userdata('akses', stripslashes($result->userLevel));
                    $this->CI->session->set_userdata('unit', stripslashes($result->skpd));
                    return 200; //sukses login
            } else {
                return 401; // 401 Unauthorized / password salah
            }
        } else {
            return 404; // user tidak ada
        }
    }

    /* cek Apakah sudah login atau belum*/
    public function is_login()
    {
        return (($this->CI->session->userdata('userid')) ? true : false);
    }

    /** Logout */
    public function logout()
    {
        $this->CI->session->unset_userdata('userid');
        $this->CI->session->unset_userdata('nama');
        $this->CI->session->sess_destroy();
    }

    function get_akses_list($id) {
        return $this->Access_model->get_akses_list($id);
    }

    function boleh($idform) {
        $arr = json_decode($this->CI->session->userdata('akses_list'));
        $ok = false;
        foreach ($arr as $a) {
            if ($a->idForm == $idform) {
                if ($a->akses == 1) {
                    $ok = true;
                }
            }
        }
        return $ok;
    }

    function getPageID($uri) {
        $dt = $this->Access_model->get_page_id($uri);
        if (isset($dt->id)) {
            return $dt->id;
        } else {
            return 0;
        }
    }
}