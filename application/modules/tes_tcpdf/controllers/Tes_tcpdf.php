<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Tes_tcpdf extends Member_Control
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url'));
		$this->load->model(array('Laporan_t_model'));
		$this->load->library('Pdf');
	}

	function index()
	{
		
		$pdf = new PDF();
        $pdf->AddPage('L', 'mm', 'A4');
        $pdf->SetFont('', 'B', 14);
        $pdf->Cell(277, 10, "DAFTAR PEGAWAI AYONGODING.COM", 0, 1, 'C');
        $pdf->SetAutoPageBreak(true, 0);
        // Add Header
        $pdf->SetFont('', 'B', 12);
        $pdf->Cell(20, 8, "No", 1, 0, 'C');
        $pdf->Cell(100, 8, "Nama Pegawai", 1, 0, 'C');
        $pdf->Cell(120, 8, "Alamat", 1, 0, 'C');
        $pdf->Cell(37, 8, "Telp", 1, 1, 'C');
        $pdf->SetFont('', '', 12);
        $no=0;
            /* $no++;
            $pdf->Cell(20,8,$no,1,0, 'C');
            $pdf->Cell(100,8,$data->nama,1,0);
            $pdf->Cell(120,8,$data->alamat,1,0);
            $pdf->Cell(37,8,$data->telp,1,1); */
            $pdf->Cell(20,8,"No",1,0, 'C');
            $pdf->Cell(100,8,"1",1,0);
            $pdf->Cell(120,8,"2",1,0);
            $pdf->Cell(37,8,"3",1,1);
        $pdf->SetFont('', 'B', 10);
        $pdf->Cell(277, 10, "Laporan Pdf Menggunakan Tcpdf, Instalasi Tcpdf Via Composer", 0, 1, 'L');
		ob_end_clean();
        $pdf->Output('Laporan-Tcpdf-CodeIgniter.pdf'); 
	}
}