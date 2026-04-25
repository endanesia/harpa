<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Ump extends Member_Control
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('url'));
        $this->load->model(array('ump_model'));
    }

    function index($s = 0)
    {
        return $this->show($s);
    }

    function show()
    {
        $data['bc'] = array('Dashboard' => site_url('dashboard'), 'UMP' => site_url('ump'));
        $data['title'] = "UMP";
        $data['dt'] = $this->ump_model->show_data()->result();
        $this->template->mainview('ump/ump_index', $data);
    }

    function Simpan()
    {
        $id = $this->input->post('id');
        $data['tahun'] = $this->input->post('tahun');
        $data['nilai_ump'] = $this->input->post('nilai_ump');
        $this->ump_model->input($data);
        redirect(site_url('ump'));
    }

    function Hapus($id) {
        $this->ump_model->delete($id);
        redirect(site_url('ump'));
    }

    function GetUmp()
    {
        $id = $_POST['id'];
        $dt = $this->ump_model->get_by_id($id)->row();
        echo json_encode($dt);
    }

    function Update_ump($id)
    {
        $ump['tahun'] = $this->input->post('tahun');
        $ump['nilai_ump'] = $this->input->post('nilai_ump');
        $edit = $this->ump_model->update($ump,$id);
        redirect(site_url('ump'));
    }
}