<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Tes_dompdf extends Member_Control
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url'));
		$this->load->library('dompdf_gen');
	}

	function index()
	{
		$this->load->view('laporan');
		$paper_size="A4";
		$orientation="potrait";
		$html= $this->output->get_output();
		$this->dompdf->set_paper($paper_size,$orientation);
		$this->dompdf->load_html($html);
		$this->dompdf->render();
		$this->dompdf->stream("Laporan PDF Pertama.pdf");
	}
}