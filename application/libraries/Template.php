<?php
class Template
{
    protected $_ci;
    protected $themes;

    public function __construct()
    {
        $this->_ci =&get_instance();
        $this->_ci->config->load('apps_settings');

        $this->themes=$this->_ci->config->item('theme');
    }

    public function mainview($template, $content=null)
    {
        $themes=$this->themes;
        $data['content']=$this->_ci->load->view($template, $content, true);
        $data['header']=$this->_ci->load->view('../../themes/'.$themes.'/header.php', $content, true);
        $data['menu']=$this->_ci->load->view('../../themes/'.$themes.'/menu.php', $content, true);
        $data['footer']=$this->_ci->load->view('../../themes/'.$themes.'/footer.php', $content, true);
        $this->_ci->load->view('../../themes/'.$themes.'/main.php', $data);
    }



}
