<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Kinerja extends Member_Control

{



	public function __construct()

	{

		parent::__construct();

		$this->load->helper(array('url'));

		$this->load->model(array('kinerja_model'));

	}

	function index()

	{

		$data['skpd'] = $this->session->has_userdata('filter_unit') ? $this->session->filter_unit : "-";

		$data['bulan'] = date('n');

		$data['tahun'] = date('Y'); 	

		if (isset($_POST['skpd'])) {
			$array = array(

				'filter_unit' => $this->input->post('skpd')

			);

			

			$this->session->set_userdata( $array );

			

			$data['skpd'] = $this->input->post('skpd');

			$data['bulan'] = $this->input->post('bulan');

			$data['tahun'] = $this->input->post('tahun'); 	

		} 

		$data['bc'] = array('Dashboard' => site_url('dashboard'), 'Kinerja Pegawai' => site_url('kinerja'));

		$data['title'] = "Tunjangan Kinerja Karyawan";

		$data['dt'] = $this->kinerja_model->show_data($data['skpd'])->result();

		$data['satkerja'] = $this->kinerja_model->unit_kerja()->result();

		$this->template->mainview('kinerja/kinerja_index', $data);

	}



	function Simpan()
	{
		$id = $this->input->post('id');
		$data['bulan'] = $this->input->post('bulan');
		$data['tahun'] = $this->input->post('tahun');
		$data['nip'] = $this->input->post('nip');
		$data['skalaKinerja'] = 4;
		$data['jmlKehadiran'] = $this->input->post('jmlKehadiran');
		$data['jmlHari'] = $this->input->post('jmlHari');
		$data['tarifMax'] = $this->input->post('tarifMax');
		$data['input_by'] = $this->session->id;
		$data['kat1'] = $this->input->post('kat1');
		$data['kat2'] = $this->input->post('kat2');
		$data['kat3'] = $this->input->post('kat3');
		$data['kat4'] = $this->input->post('kat4');
		$data['kat5'] = $this->input->post('kat5');

		$rata2 = ($data['kat1'] + $data['kat2'] +$data['kat3'] +$data['kat4'] +$data['kat5'] )/5;
		$skor = ($rata2/4)*100;
		$kinerja = $skor/2;
		$rata2_hadir = ($data['jmlKehadiran'] / $data['jmlHari'])*100;
		$kehadiran = $rata2_hadir/2;
		$total = (($kinerja + $kehadiran)/100) * $data['tarifMax'] ;

		$data['skorKinerja'] = $kinerja;
		$data['skorKehadiran'] = $kehadiran;
		$data['jmlTunjangan'] = $total;

		//jika $id = 0 maka lakukan operasi insert data

		if ($id == 0) {
			$this->kinerja_model->input($data);
		} else {
			//jika $id != 0 maka lakukan proses edit
			$this->kinerja_model->update($data, $id);
		}

		redirect(site_url('kinerja'));

	}





	function Hapus() {

		$id = $this->input->post('idhapus');

		$this->kinerja_model->delete($id);

		redirect(site_url('kinerja'));

	}



	function GetData()

	{

		$id = $_POST['id'];

		$dt = $this->kinerja_model->get_by_id($id)->row();

		echo json_encode($dt);

	}



	public function excel()
	{
		if((isset($_FILES["file"]["name"])) && $_FILES["file"]["type"]=='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' ){

			// upload

			$file_tmp = $_FILES['file']['tmp_name'];

			$file_name = $_FILES['file']['name'];

			$file_size =$_FILES['file']['size'];

			$file_type=$_FILES['file']['type'];

			// move_uploaded_file($file_tmp,"uploads/".$file_name); // simpan filenya di folder uploads

			

			$object = PHPExcel_IOFactory::load($file_tmp);

	

			foreach($object->getWorksheetIterator() as $worksheet){

	

				$highestRow = $worksheet->getHighestRow();

				$highestColumn = $worksheet->getHighestColumn();

	

				for($row=4; $row<=$highestRow; $row++){
					$nid = '';

					$k1 = 0;

					$k2 = 0;

					$k3 = 0;

					$k4 = 0;

					$k5 = 0;

					$skorkinerja = 0;

					$skalakinerja = 0;

					$jmlKehadiran = 0;

					$jmlHari = 0;

					$tarifMax = 0;

					$jmlTunjangan = 0;

					$skorKehadiran = 0;

					
					//set data excel ke variabel

					//getCellByColumnAndRow(1, $row)->getValue()=>ambil nilai dr baris x dan kolom y y dimulai dr 0 untuk kolom a di excel

					$bulan=$this->input->post('bulan');

					$tahun=$this->input->post('tahun');

					$nid = $worksheet->getCellByColumnAndRow(1, $row)->getValue();

					$k1 = $worksheet->getCellByColumnAndRow(2, $row)->getValue();

					$k2 = $worksheet->getCellByColumnAndRow(3, $row)->getValue();

					$k3 = $worksheet->getCellByColumnAndRow(4, $row)->getValue();

					$k4 = $worksheet->getCellByColumnAndRow(5, $row)->getValue();

					$k5 = $worksheet->getCellByColumnAndRow(6, $row)->getValue();

					$skorkinerja=$worksheet->getCellByColumnAndRow(12, $row)->getValue();

					$skalakinerja=$worksheet->getCellByColumnAndRow(14, $row)->getValue();

					$jmlKehadiran=$worksheet->getCellByColumnAndRow(9, $row)->getValue();

					$jmlHari=$worksheet->getCellByColumnAndRow(10, $row)->getValue();

					$tarifMax=$worksheet->getCellByColumnAndRow(13, $row)->getValue();

					$jmlTunjangan=$worksheet->getCellByColumnAndRow(15, $row)->getValue();

					$skorKehadiran=$worksheet->getCellByColumnAndRow(11, $row)->getValue();

					$rata2 = ($k1+$k2+$k3+$k4+$k5)/5;
					$skorkinerja = (($rata2/4)*100)/2;
					$skalakinerja = 4;
					$rata2_hadir = (($jmlKehadiran / $jmlHari)*100)/2;
					
					$total = (($skorkinerja + $rata2_hadir)/100) * $tarifMax ;
					$jmlTunjangan = $total;
					$skorKehadiran = $rata2_hadir;

					$data[] = array(

						'bulan'=> $bulan,

						'tahun'=> $tahun,

						'nip'=>$nid,

						'kat1'=>$k1,

						'kat2'=>$k2,

						'kat3'=>$k3,

						'kat4'=>$k4,

						'kat5'=>$k5,

						'skorKinerja'=>$skorkinerja,

						'skalaKinerja'=>$skalakinerja,

						'jmlKehadiran'=>$jmlKehadiran,

						'jmlHari'=>$jmlHari,

						'tarifMax'=>$tarifMax,

						'jmlTunjangan'=>$jmlTunjangan,

						'skorKehadiran'=>$skorKehadiran,

					);
				} 

	

			}

	

			$this->db->insert_batch('tbKinerja', $data);

	

			$this->session->set_flashdata('errMsg', 'Import Data Kinerja Sukses');

			

			redirect('kinerja');

		}

		else

		{

			

			$this->session->set_flashdata('errMsg2', 'Import Data Kinerja Gagal');

			redirect('kinerja');

		}

	}

	

	function Cetak_Satuan($id)

	{

		//data

		$dtkinerja = $this->kinerja_model->skorkinerja($id)->row();

		$pegawai=$this->kinerja_model->pegawai_id($dtkinerja->nip)->row();

		$unit = $this->kinerja_model->unit_id($pegawai->skpd)->row();

		$nama = $unit->nama;

		//file cetakan

		$pdf = new PDF();

		$pdf->SetPrintHeader(false);

		$pdf->SetPrintFooter(false);

		$pdf->AddPage('P', 'mm', 'A4');

		//content

			$pdf->SetFont('', 'B', 10);

			$pdf->Cell(210, 13, 'SLIP TUNJANGAN KINERJA ' . date('F', mktime(0, 0, 0, $dtkinerja->bulan, 10)) . ' ' . date("Y", strtotime($dtkinerja->tahun)), '', 1, 'C');

			$pdf->SetFont('', 'R', 10);

			//baris 1

			$pdf->Cell(15, 5, 'NIK', '', 0, 'L');

			$pdf->Cell(5, 5, ':', '', 0, 'L');

			$pdf->Cell(70, 5, $pegawai->nipBaru, '', 0, 'L');

			$pdf->Cell(40, 5, 'Departemen', '', 0, 'L');

			$pdf->Cell(5, 5, ':', '', 0, 'L');

			$pdf->Cell(50, 5, $nama, '', 1, 'L');

			//baris 2

			$pdf->Cell(15, 5, 'Nama', '', 0, 'L');

			$pdf->Cell(5, 5, ':', '', 0, 'L');

			$pdf->Cell(70, 5, $pegawai->namaPegawai, '', 0, 'L');

			$pdf->Cell(40, 5, 'Section', '', 0, 'L');

			$pdf->Cell(5, 5, ':', '', 0, 'L');

			$pdf->Cell(50, 5, 'SHIFT', '', 1, 'L');

			//baris 3

			$pdf->Cell(90, 5, '', '', 0, 'L');

			$pdf->Cell(40, 5, 'Jabatan', '', 0, 'L');

			$pdf->Cell(5, 5, ':', '', 0, 'L');

			$pdf->Cell(50, 5, $pegawai->jabatan, '', 1, 'L');

			//baris kosong

			$pdf->Cell(210, 4, '', '', 1, 'L');

			//judul pendapatan potongan

			$pdf->SetFont('', 'B', 10);

			$pdf->Cell(30, 5, 'KETERANGAN', '', 0, 'L');

			$pdf->Cell(60, 5, ':', '', 0, 'L');

			$pdf->Cell(40, 5, 'JUMLAH APRESIASI', '', 0, 'L');

			$pdf->Cell(20, 5, ':', '', 1, 'L');

			//detail pendapatan

			//Skor Kinerja

			$pdf->SetFont('', 'R', 10);

			$pdf->Cell(45, 5, 'Skor Kinerja', '', 0, 'L');

			$pdf->Cell(5, 5, ':', '', 0, 'L');

			$pdf->Cell(40, 5, $dtkinerja->skorKinerja, '', 0, 'L');

			$pdf->Cell(40, 5, 'Tunjangan Kinerja', '', 0, 'L');

			$pdf->Cell(5, 5, ':', '', 0, 'L');

			$pdf->Cell(25, 5, number_format($dtkinerja->jmlTunjangan, "0", ",", "."), '', 1, 'R');

			//Kosong

			//$pdf->Cell(210, 5, '', '', 1, 'L');

			//Skala Kinerja

			$pdf->Cell(45, 5, 'Skala Kinerja', '', 0, 'L');

			$pdf->Cell(5, 5, ':', '', 0, 'L');

			$pdf->Cell(40, 5, $dtkinerja->skalaKinerja, '', 0, 'L');

			$pdf->Cell(40, 5, '', '', 0, 'L');

			$pdf->Cell(5, 5, '', '', 0, 'L');

			$pdf->Cell(25, 5, '', '', 1, 'L');

			//Kosong

			//$pdf->Cell(210, 5, '', '', 1, 'L');

			//Jumlah Kehadiran

			$pdf->Cell(45, 5, 'Jumlah Kehadiran', '', 0, 'L');

			$pdf->Cell(5, 5, ':', '', 0, 'L');

			$pdf->Cell(40, 5, $dtkinerja->jmlKehadiran, '', 0, 'L');

			$pdf->Cell(40, 5, '', '', 0, 'L');

			$pdf->Cell(5, 5, '', '', 0, 'L');

			$pdf->Cell(25, 5, '', '', 1, 'L');

			//Kosong

			//$pdf->Cell(210, 5, '', '', 1, 'L');

			//Jumlah Hari

			$pdf->Cell(45, 5, 'Jumlah Hari', '', 0, 'L');

			$pdf->Cell(5, 5, ':', '', 0, 'L');

			$pdf->Cell(40, 5, $dtkinerja->jmlHari, '', 0, 'L');

			$pdf->Cell(40, 5, '', '', 0, 'L');

			$pdf->Cell(5, 5, '', '', 0, 'L');

			$pdf->Cell(25, 5, '', '', 1, 'L');

			//Kosong

			//$pdf->Cell(210, 5, '', '', 1, 'L');

			//Jumlah Hari

			$pdf->Cell(45, 5, '', '', 0, 'L');

			$pdf->Cell(5, 5, '', '', 0, 'L');

			$pdf->Cell(40, 5, '', '', 0, 'L');

			$pdf->Cell(40, 5, 'Tunjangan Dibayar', '', 0, 'L');

			$pdf->Cell(5, 5, ':', '', 0, 'L');

			$pdf->Cell(25, 5, number_format($dtkinerja->jmlTunjangan, "0", ",", "."), '', 1, 'R');

			//Kosong

			//$pdf->Cell(210, 5, '', '', 1, 'L');

			//no Rek

			$pdf->Cell(45, 5, 'Rekening', '', 0, 'L');

			$pdf->Cell(5, 5, ':', '', 0, 'L');

			$pdf->Cell(40, 5, $pegawai->norek, '', 0, 'L');

			//kota tanggal

			$pdf->Cell(15, 5, 'Malang', '', 0, 'L');

			$pdf->Cell(5, 5, ',', '', 0, 'L');

			$pdf->Cell(40, 5, date("d/m/Y"), '', 0, 'L');

			$pdf->Cell(210, 5, '', '', 1, 'L');

			$pdf->Cell(210, 5, '----------------------------------------------------------------------------------------------------------------------------------------------------', '', 1, 'L');

		ob_end_clean();

		$pdf->Output('Slip Tunjangan Kinerja ' . $pegawai->namaPegawai);

	}		

}