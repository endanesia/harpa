<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cuti extends Member_Control

{



	public function __construct()

	{

		parent::__construct();

		$this->load->helper(array('url'));

		$this->load->model(array('Cuti_model'));

	}



	function index()

	{

		return $this->show();

	}



	function show()

	{

		$satkerja = $this->session->userdata('filter_unit');

		$bulan = $this->session->userdata('filter_bulan');

		$tahun = $this->session->userdata('filter_tahun');

		

		if (isset($_POST['skpd'])) {

			$skpd = $this->input->post('skpd');

			$bulan = $this->input->post('bulan');

			$tahun = $this->input->post('tahun'); 

			$sess['filter_unit'] = $skpd;

			$sess['filter_bulan'] = $bulan;

			$sess['filter_tahun'] = $tahun;

			$this->session->set_userdata( $sess );

		}

		$data['error']="";

		$data['bc'] = array('Dashboard' => site_url('dashboard'), 'Cuti Pegawai' => site_url('cuti'));

		$data['title'] = "Cuti Pegawai";

		$data['dt'] = $this->Cuti_model->show_data($this->session->filter_unit,$this->session->filter_bulan,$this->session->filter_tahun)->result();

		if ($this->session->userdata('akses') == 1) {

			$data['satkerja'] = $this->Cuti_model->unit_kerja()->result();

		} else {

			$data['satkerja'] = $this->Cuti_model->unit_kerja($this->session->userdata('unit'))->result();

		}

		$data['pegawai'] = $this->Cuti_model->pegawai()->result();

		$this->template->mainview('cuti/cuti_index', $data);

	}



	function validasi()

	{

		$satkerja = $this->session->userdata('filter_unit');

		$bulan = $this->session->userdata('filter_bulan');

		$tahun = $this->session->userdata('filter_tahun');

		

		if (isset($_POST['skpd'])) {

			$skpd = $this->input->post('skpd');

			$bulan = $this->input->post('bulan');

			$tahun = $this->input->post('tahun'); 

			$sess['filter_unit'] = $skpd;

			$sess['filter_bulan'] = $bulan;

			$sess['filter_tahun'] = $tahun;

			$this->session->set_userdata( $sess );

		}

		$data['bc'] = array('Dashboard' => site_url('dashboard'), 'Validasi Cuti' => site_url('cuti/validasi'));

		$data['title'] = "Validasi Cuti Pegawai";

		$data['dt'] = $this->Cuti_model->show_data($this->session->filter_unit,$this->session->filter_bulan,$this->session->filter_tahun)->result();

		$data['satkerja'] = $this->Cuti_model->unit_kerja()->result();

		$this->template->mainview('cuti/cuti_validasi', $data);

	}

	

	function Simpan()

	{

		if(empty($this->session->filter_unit))

		{

			

			//$this->template->mainview('cuti/cuti_index', $data);

			redirect(site_url().'/cuti/Error_input');



		}

		else

		{

			$pgid=$this->Cuti_model->pegawai_id($this->input->post('pegawai'))->row();

			$jenis_cuti=$this->input->post('hari_cuti');

			//echo $jenis_cuti;

			if($jenis_cuti=="dispensasi")

			{

				$hari_cuti=0;

			}

			else

			{

				$hari_cuti=date_diff(date_create($this->input->post('awal_cuti')),date_create($this->input->post('akhir_cuti')));

				$lama_cuti= intval($hari_cuti->format("%a"))+1;

			}

			$cuti['idPegawai']=$this->input->post('pegawai');

			$cuti['skpd']=$pgid->skpd;

			$cuti['tgl']=$this->input->post('ajukan_cuti');

			$cuti['jmlHari']=$lama_cuti;

			$cuti['tglMulai']=$this->input->post('awal_cuti');

			$cuti['tglSampai']=$this->input->post('akhir_cuti');

			$cuti['keperluan']=$this->input->post('alasan_cuti');

			$cuti['alamatCuti']=$this->input->post('alamat_cuti');

			$cuti['tlp']=$this->input->post('telepon_cuti');

			$cuti['atasan']=$this->input->post('atasan_cuti');

			$cuti['direktur']=$this->input->post('direktur_cuti');

			$cuti['ket']=$jenis_cuti;

			$urut=$this->Cuti_model->show_data_cuti()->row();

			echo var_dump($urut);

			if(empty($urut))

			{

				$gabungurut="001".".CT/PT-SCM/".date("m")."/".date("Y");

			}

			else

			{

				// ambil kode n0omor

				$kode_no=$urut->nomor;

				// hitung panjang kode

				$panjang=strlen($kode_no);

				//cari posisi .CT

				$ct=strpos($kode_no,".CT");

				//panjang karakter no urut

				$panjangno=$panjang-$ct-1;

				//nomerbaru

				$nobaru=(int)substr($kode_no,0,$panjangno)+1;

				//panjang no baru

				$panjangnobaru=strlen($nobaru);

				$nol="";

				for($i=1;$i<(4-$panjangnobaru);$i++)

				{

					$nol=$nol."0";

				}

				$gabungurut=str_replace(" ","",$nol.$nobaru)."."."CT/PT-SCM/".date("m")."/".date("Y");

			}	

			$cuti['nomor']=$gabungurut;

			//sisa cuti

			$bcuti = $this->Cuti_model->banyak_cuti($cuti['idPegawai'],$cuti['tgl'])->row();

			$sisa_cuti = 12 - $bcuti->banyak_cuti-$cuti['jmlHari'];

			$cuti['sisa_cuti']=$sisa_cuti;

			$hasil=$this->Cuti_model->input($cuti);

			redirect(site_url().'/cuti');

		}

	}



	function Error_input()

	{

		$data['error']="error";

		$data['bc'] = array('Dashboard' => site_url('dashboard'), 'Cuti Pegawai' => site_url('cuti'));

		$data['title'] = "Cuti Pegawai";

		$data['dt'] = $this->Cuti_model->show_data($this->session->filter_unit,$this->session->filter_bulan,$this->session->filter_tahun)->result();

		$data['satkerja'] = $this->Cuti_model->unit_kerja()->result();

		$data['pegawai'] = $this->Cuti_model->pegawai()->result();

		$this->template->mainview('cuti/cuti_index', $data);

	}



	function Update_cuti($id)

	{

		$jenis_cuti=$this->input->post('hari_cuti');

			//echo $jenis_cuti;

			if($jenis_cuti=="dispensasi")

			{

				$lama_cuti=0;

			}

			else

			{

				$hari_cuti=date_diff(date_create($this->input->post('awal_cuti')),date_create($this->input->post('akhir_cuti')));

				$lama_cuti= intval($hari_cuti->format("%a"))+1;

			}

		$pegawai=$this->input->post('pegawai_cuti');

		$cuti['tgl']=$this->input->post('ajukan_cuti');

		$cuti['jmlHari']=$lama_cuti;

		$cuti['tglMulai']=$this->input->post('awal_cuti');

		$cuti['tglSampai']=$this->input->post('akhir_cuti');

		$cuti['keperluan']=$this->input->post('alasan_cuti');

		$cuti['alamatCuti']=$this->input->post('alamat_cuti');

		$cuti['tlp']=$this->input->post('telepon_cuti');

		$cuti['atasan']=$this->input->post('atasan_cuti');

		$cuti['ket']=$this->input->post('hari_cuti');

		$cuti['direktur']=$this->input->post('direktur_cuti');

		$this->Cuti_model->update($cuti,$id);

		$dcuti=$this->Cuti_model->cuti_id($id)->row();

		$dcuti_id=$dcuti->id;

		$bcuti = $this->Cuti_model->banyak_cuti($pegawai,$cuti['tgl'])->row();

		$sisa_cuti = 12 - $bcuti->banyak_cuti;

		$cuti['sisa_cuti']=$sisa_cuti;

		$this->Cuti_model->update($cuti,$dcuti_id);

		echo $bcuti->banyak_cuti;

		redirect(site_url().'/cuti');

	}

	

	function Hapus_cuti($id) {

		$this->Cuti_model->Delete_cuti($id);

		redirect(site_url().'/cuti');

	}



	function GetShift()

	{

		$id = $_POST['id'];

		$dt = $this->cuti_model->get_by_id($id)->row();

		echo json_encode($dt);

	}



	function Valid_cuti($id)

	{

		$cuti['status']=1;

		$cuti['tgl_validasi']=date('Y-m-d');	

		$this->Cuti_model->update($cuti,$id);

		redirect(site_url().'/cuti/validasi');

	}



	function Invalid_cuti($id)

	{

		$cuti['status']=0;

		$this->Cuti_model->update($cuti,$id);

		redirect(site_url().'/cuti/validasi');

	}

// Laporan=====================================================================================================================

	function Cetak_cuti($id)

	{

		//Logo

		$img=base_url().'/assets/imgs/logo.png';

		$laporan_cuti=$this->Cuti_model->cuti_id($id)->row();

		//data pegawai

		$dtpeg = $this->Cuti_model->pegawai_id($laporan_cuti->idPegawai)->row();

		// data jabatan pegawai

		$dtjab = $this->Cuti_model->jabatan_id($dtpeg->idJabatan)->row();

		// data unit pegawai

		$dtunit = $this->Cuti_model->unit_kerja_id($dtpeg->skpd)->row();

		//$bcuti = $this->Cuti_model->banyak_cuti($laporan_cuti->idPegawai)->row();

		//$sisacuti=12-$bcuti->banyak_cuti;

		$pdf = new pdf();

		$pdf->SetPrintHeader(false);

		$pdf->SetPrintFooter(false);

        $pdf->AddPage('P', 'mm', 'A4');

        $pdf->SetFont('', 'B', 12);

		//kop surat

		$pdf->Cell(190,1,'','LTR',1);

		$pdf->SetFont('', 'B', 20);

		$pdf->Cell(100,1,'','L',0);

		$pdf->Cell(90,5,'PERMOHONAN IZIN CUTI','R',1,'C');

		$pdf->Cell(100,15,'','L',0);

		$pdf->Cell(90,15,'TAHUN '.date("Y", strtotime($laporan_cuti->tgl)),'R',1,'C');

		$pdf->SetFont('', 'B', 12);

		$pdf->Cell(100,5,'','L',0);

		$pdf->Cell(90,5,'Nomor : '. $laporan_cuti->nomor,'R',1,'C');

		$pdf->image($img,14,15,50,30);

		$pdf->Cell(190,1,'','LBR',1);

		//isi laporan

		$pdf->SetFont('', '', 12);

		//data nama

		$pdf->Cell(15,10,'','L',0,'L');

		$pdf->Cell(80,10,'Nama','R',0,'L');

		$pdf->Cell(5,10,':','R',0,'L');

		$pdf->Cell(90,10,$dtpeg->namaPegawai,'R',1,'L');

		//data no induk

		$pdf->Cell(15,10,'','L',0,'L');

		$pdf->Cell(80,10,'Nomor Induk','R',0,'L');

		$pdf->Cell(5,10,':','R',0,'L');

		$pdf->Cell(90,10,$dtpeg->nipBaru,'R',1,'L');

		//data Jabatan

		$pdf->Cell(15,10,'','L',0,'L');

		$pdf->Cell(80,10,'Jabatan / Job','R',0,'L');

		$pdf->Cell(5,10,':','R',0,'L');

		$pdf->Cell(90,10,$dtjab->namaJabatan,'R',1,'L');

		//data unit kerja

		$pdf->Cell(15,10,'','L',0,'L');

		$pdf->Cell(80,10,'Unit Kerja','R',0,'L');

		$pdf->Cell(5,10,':','R',0,'L');

		$pdf->Cell(90,10,$dtunit->nama,'R',1,'L');

		//data tanggal pengajuan

		$pdf->Cell(15,10,'','L',0,'L');

		$pdf->Cell(80,10,'Tanggal Pengajuan','R',0,'L');

		$pdf->Cell(5,10,':','R',0,'L');

		$pdf->Cell(90,10,date("d F Y", strtotime($laporan_cuti->tgl)),'R',1,'L');

		//hari cuti

		$pdf->Cell(15,10,'','L',0,'L');

		$pdf->Cell(80,10,'Jml. Cuti yang diajukan','R',0,'L');

		$pdf->Cell(5,10,':','R',0,'L');

		$pdf->Cell(90,10,$laporan_cuti->jmlHari.' Hari','R',1,'L');

		$pdf->Cell(15,1,'','L',0,'L');

		$pdf->Cell(80,1,'','R',0,'L');

		$pdf->Cell(5,1,'','R',0,'L');

		$pdf->Cell(90,1,date("d F Y", strtotime($laporan_cuti->tglMulai)).' s/d '.date("d F Y", strtotime($laporan_cuti->tglSampai)),'R',1,'L');

		//data spasi

		$pdf->Cell(15,10,'','L',0,'L');

		$pdf->Cell(80,10,'','R',0,'L');

		$pdf->Cell(5,10,'','R',0,'L');

		$pdf->Cell(90,10,'','R',1,'L');

		//hari cuti yang disetujui

		$pdf->Cell(15,10,'','L',0,'L');

		$pdf->Cell(80,10,'Jml. Cuti yang disetujui','R',0,'L');

		$pdf->Cell(5,10,':','R',0,'L');

		$pdf->Cell(90,10,$laporan_cuti->jmlHari.' Hari','R',1,'L');

		$pdf->Cell(15,1,'','L',0,'L');

		$pdf->Cell(80,1,'','R',0,'L');

		$pdf->Cell(5,1,'','R',0,'L');

		$pdf->Cell(90,1,date("d F Y", strtotime($laporan_cuti->tglMulai)).' s/d '.date("d F Y", strtotime($laporan_cuti->tglSampai)),'R',1,'L');

		//data alasan cuti

		$pdf->Cell(15,10,'','L',0,'L');

		$pdf->Cell(80,10,'Alasan Cuti ','R',0,'L');

		$pdf->Cell(5,10,':','R',0,'L');

		$pdf->Cell(90,10,$laporan_cuti->keperluan,'R',1,'L');

		//alamat cuti tlp

		$pdf->Cell(15,10,'','L',0,'L');

		$pdf->Cell(80,10,'Alamat selama Cuti/Telp','R',0,'L');

		$pdf->Cell(5,10,':','R',0,'L');

		$pdf->MultiCell(90,10,$laporan_cuti->alamatCuti.' /','R','L');

		$pdf->Cell(15,1,'','L',0,'L');

		$pdf->Cell(80,1,'','R',0,'L');

		$pdf->Cell(5,1,'','R',0,'L');

		$pdf->Cell(90,1,$laporan_cuti->tlp,'R',1,'L');

		//data hak cuti

		$pdf->Cell(15,10,'','LB',0,'L');

		$pdf->Cell(80,10,'Hak Cuti Tahunan pada Tahun','BR',0,'L');

		$pdf->Cell(5,10,':','BR',0,'L');

		$pdf->Cell(90,10,date("Y", strtotime($laporan_cuti->tglMulai)) .', yang telah diambil : '. $laporan_cuti->jmlHari .' Hari  sisa cuti : '. $laporan_cuti->sisa_cuti ,'BR',1,'L');

		//FOOTER

		//pemohon

		$pdf->Cell(30,10,'Pemohon','LR',0,'L');

		$pdf->Cell(5,10,' : ','R',0,'L');

		$pdf->Cell(65,10,$dtpeg->namaPegawai,'R',0,'L');

		$pdf->Cell(30,10,'Tandatangan','R',0,'L');

		$pdf->Cell(5,10,' : ','R',0,'L');

		$pdf->Cell(55,10,'','R',1,'L');

		//kosong

		$pdf->Cell(30,5,'','LR',0,'L');

		$pdf->Cell(5,5,'  ','R',0,'L');

		$pdf->Cell(65,5,'','R',0,'L');

		$pdf->Cell(30,5,'','R',0,'L');

		$pdf->Cell(5,5,'  ','R',0,'L');

		$pdf->Cell(55,5,'','R',1,'L');

		$pdf->Cell(190,5,'Mengetahui Atasan',1,1,'C');

		//Atasan

		$pdf->Cell(30,10,'Nama','LR',0,'L');

		$pdf->Cell(5,10,' : ','R',0,'L');

		$pdf->Cell(65,10,$laporan_cuti->atasan,'R',0,'L');

		$pdf->Cell(30,10,'Tandatangan','R',0,'L');

		$pdf->Cell(5,10,' : ','R',0,'L');

		$pdf->Cell(55,10,'','R',1,'L');

		//kosong

		$pdf->Cell(30,5,'','LR',0,'L');

		$pdf->Cell(5,5,'  ','R',0,'L');

		$pdf->Cell(65,5,'','R',0,'L');

		$pdf->Cell(30,5,'','R',0,'L');

		$pdf->Cell(5,5,'  ','R',0,'L');

		$pdf->Cell(55,5,'','R',1,'L');

		$pdf->Cell(190,5,'Setuju / Tidak Setuju / Ditunda ',1,1,'C');

		//Atasan

		$pdf->Cell(30,13,'Nama','LBR',0,'L');

		$pdf->Cell(5,13,' : ','BR',0,'L');

		$pdf->Cell(65,13,$laporan_cuti->direktur,'BR',0,'L');

		$pdf->Cell(30,13,'Tandatangan','BR',0,'L');

		$pdf->Cell(5,13,' : ','BR',0,'L');

		$pdf->Cell(55,13,'','BR',1,'L');

		//Direktur

		$pdf->Cell(30,10,'Jabatan / Job','LBR',0,'L');

		$pdf->Cell(5,10,' : ','BR',0,'L');

		$pdf->Cell(65,10,'Direktur','BR',0,'L');

		$pdf->Cell(90,10,'','BR',1,'L');

		//TEMBUSAN

		$pdf->Cell(190,5,'','LTR',1,'L');

		$pdf->Cell(190,15,'Tembusan :','LR',1,'L');

		$pdf->Cell(190,1,'1. Karyawan yang bersangkutan','LR',1,'L');

		$pdf->Cell(190,1,'2. Administrasi PT SERBA CIPTA MANDIRI','LR',1,'L');

		$pdf->Cell(190,5,'','LBR',1,'L');

		ob_end_clean();

        $pdf->Output('Laporan Izin Cuti '.$dtpeg->namaPegawai); 



	}

}

