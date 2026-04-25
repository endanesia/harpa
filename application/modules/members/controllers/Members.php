<?php if (!defined('BASEPATH')) {
    exit('No direct script acces allowed');
}

class Members extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('access');
        $this->load->model(array('access_model'));
        $this->load->helper('form');
    }

    public function index()
    {
        $this->login();
    }

    public function login()
    {

        if ($this->session->has_userdata('userid')) {
            redirect('dashboard/');
        }
        
        $this->form_validation->set_rules('token', 'token', 'callback_authlogin');///memanggil fungsi check_login

        if ($this->form_validation->run() == false) {
            $data['title']=$this->config->item('apps_name');
            $this->load->view('members/login-form', $data); ///diarahkan pada template halaman login
        } else {
            redirect('dashboard/');
        }
    }


    public function logout()
    {
        $this->access->logout();
        redirect('members/login');
    }


    public function authlogin()
    {

        $username = $this->input->post('username',TRUE);
		$password = $this->input->post('password',TRUE);

		$login= $this->Access->login($username,$password);

        if($username=="" || $password==""){
            $this->form_validation->set_message("authlogin","Username atau Password tidak boleh kosong");
            return FALSE;
        }else{
            if ($login==200) {
                $this->form_validation->set_message("authlogin","Selamat Datang ".$this->session->userdata('nama'));
                $akses = json_encode($this->access->get_akses_list($this->session->akses));
                $sess['akses_list'] = $akses;
                $this->session->set_userdata($sess);
                return TRUE;
            } elseif ($login==403) {
                $this->form_validation->set_message("authlogin","Mohon maaf, akun anda non-aktif.");
                return FALSE;
            } elseif ($login==401) {
                $this->form_validation->set_message("authlogin","Password anda salah!");
                return FALSE;
            } elseif ($login==404) {
                $this->form_validation->set_message("authlogin","Akun anda tidak ditemukan!");
                return FALSE;
            } else {
                $this->form_validation->set_message("authlogin","Username atau Password tidak boleh kosong");
                return FALSE;
            }
        }
    }
}
