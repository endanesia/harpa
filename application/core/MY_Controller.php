<?php if (!defined('BASEPATH')) {
    exit('No direct script acces allowed');
}

class Member_Control extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->access->is_login()) {
            redirect('members/login');
        } else {

            $u1 = $this->router->fetch_class();
            $u2 = $this->router->fetch_method();
            if ($u1 != 'dashboard') {
                if ($u2 == 'show') {
                    $u2 = "";
                }
                if ($u2 == 'index') {
                    $u2 = "";
                }
                if ($u2 == $u1 . "_show") {
                    $u2="";
                }
                $u = $u1 . '/' . $u2;
                $pageID = $this->access->getPageID($u);
                if ( $pageID > 0) {
                    if ($this->access->boleh($pageID)) {
                        //
                    } else {
                        $this->session->set_flashdata('errMsg', 'Uppss..! anda tidak memiliki akses, silahkan hubungi administrator anda. <br> Akses ditolak ' . $u1 . "/" . $u2);
                        redirect('dashboard');                        
                    }
                }
            }
        }
    }

    public function is_login()
    {
        return $this->access->is_login();
    }

    public function lokasi()
    {
        $u1 = $this->router->fetch_class();
        $u2 = $this->router->fetch_method();
        $u = $u1 . '/' . $u2;
        $this->access->getPageID($u);
    }
}

class MY_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
}
