<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pegawai extends Member_Control

{



	public function __construct()

	{

		parent::__construct();

		$this->load->helper(array('url'));

		$this->load->model(array('pegawai_model'));

	}



	function index($unit = 0, $jabatan = 0)

	{

		return $this->show($unit, $jabatan);

	}



	function show($unit, $jabatan)

	{

		$data['bc'] = array('Dashboard' => site_url('dashboard'), 'Data Pegawai' => site_url('pegawai'));

		$data['title'] = "Data Pegawai";

		$data['cJabatan'] = $jabatan;

		$data['cUnit'] = $unit;

		$data['dt'] = $this->pegawai_model->show_data($unit, $jabatan)->result();

		$data['jabatan'] = $this->pegawai_model->get_jabatan()->result();

		$data['unit'] = $this->pegawai_model->get_unit()->result();

		$this->template->mainview('pegawai/pegawai_index', $data);

	}



	function export_excel()

	{

		/* $data['bc'] = array('Dashboard' => site_url('dashboard'), 'Data Pegawai' => site_url('pegawai'));

		$data['title'] = "Data Pegawai";

		$data['dt'] = $this->pegawai_model->export()->result();

		$this->load->view('pegawai/pegawai_export', $data);	 */

		// create file name

		$fileName = 'Data Pegawai'.'.xlsx';  

		// load excel library

			//$this->load->library('excel');

			$listInfo = $this->pegawai_model->export()->result();

			$this->load->library('excel'); //Load library excelnya

			$this->excel->setActiveSheetIndex(0);

			//Judul

			$this->excel->getActiveSheet()->mergeCells('A1:Y1');

			//Judul Ditengah

			$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			

			$this->excel->getActiveSheet()->setCellValue('A1', "DATA PEGAWAI");

			// set Header

			$this->excel->getActiveSheet()->SetCellValue('A3', 'NIP');

			$this->excel->getActiveSheet()->SetCellValue('B3', 'NIK');

			$this->excel->getActiveSheet()->SetCellValue('C3', 'NAMA PEGAWAI');

			$this->excel->getActiveSheet()->SetCellValue('D3', 'JENIS KELAMIN');

			$this->excel->getActiveSheet()->SetCellValue('E3', 'AGAMA');

			$this->excel->getActiveSheet()->SetCellValue('F3', 'PENDIDIKAN TERAKHIR');

			$this->excel->getActiveSheet()->SetCellValue('G3', 'GOL. DARAH');

			$this->excel->getActiveSheet()->SetCellValue('H3', 'TEMPAT LAHIR');

			$this->excel->getActiveSheet()->SetCellValue('I3', 'TGL LAHIR');

			$this->excel->getActiveSheet()->SetCellValue('J3', 'ALAMAT');

			$this->excel->getActiveSheet()->SetCellValue('K3', 'TELEPON');

			$this->excel->getActiveSheet()->SetCellValue('L3', 'EMAIL');

			$this->excel->getActiveSheet()->SetCellValue('M3', 'STATUS PERNIKAHAN');

			$this->excel->getActiveSheet()->SetCellValue('N3', 'JABATAN');

			$this->excel->getActiveSheet()->SetCellValue('O3', 'KELAS JABATAN');

			$this->excel->getActiveSheet()->SetCellValue('P3', 'UNIT');

			$this->excel->getActiveSheet()->SetCellValue('Q3', 'JENIS PEGAWAI');

			$this->excel->getActiveSheet()->SetCellValue('R3', 'NAMA BANK');

			$this->excel->getActiveSheet()->SetCellValue('S3', 'NOMOR REK');

			$this->excel->getActiveSheet()->SetCellValue('T3', 'AN REK');

			$this->excel->getActiveSheet()->SetCellValue('U3', 'NOMOR NPWP');

			$this->excel->getActiveSheet()->SetCellValue('V3', 'NO BPJS KESEHATAN');

			$this->excel->getActiveSheet()->SetCellValue('W3', 'NO BPJS TENAGA KERJA');

			$this->excel->getActiveSheet()->SetCellValue('X3', 'STATUS PEGAWAI');

			$this->excel->getActiveSheet()->SetCellValue('Y3', 'GAJI POKOK');

			$this->excel->getActiveSheet()->SetCellValue('Z3', 'TUNJANGAN TETAP');

			$this->excel->getActiveSheet()->SetCellValue('AA3', 'TANGGAL BERGABUNG');             

			// set Row

			$rowCount = 4;

			foreach ($listInfo as $pegawai) {

				$this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true) ;

				$this->excel->getActiveSheet()->SetCellValue('A' . $rowCount, $pegawai->nipBaru);

				$this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true) ;

				$this->excel->getActiveSheet()

            				->getCell('B' . $rowCount)

            				->setValueExplicit($pegawai->NIK, PHPExcel_Cell_DataType::TYPE_STRING);

				$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true) ;

				$this->excel->getActiveSheet()->SetCellValue('C' . $rowCount, $pegawai->namaPegawai);

				$this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true) ;

				$this->excel->getActiveSheet()->SetCellValue('D' . $rowCount, $pegawai->jenisKelamin);

				$this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true) ;

				$this->excel->getActiveSheet()->SetCellValue('E' . $rowCount, $pegawai->agama);

				$this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true) ;

				$this->excel->getActiveSheet()->SetCellValue('F' . $rowCount, $pegawai->pendidikan);

				$this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true) ;

				$this->excel->getActiveSheet()->SetCellValue('G' . $rowCount, $pegawai->golongan_darah);

				$this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true) ;

				$this->excel->getActiveSheet()->SetCellValue('H' . $rowCount, $pegawai->tempatLahir);

				$this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true) ;

				$this->excel->getActiveSheet()->SetCellValue('I' . $rowCount, date_format(date_create($pegawai->tanggalLahir), 'd-m-Y'));

				$this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true) ;

				$this->excel->getActiveSheet()->SetCellValue('J' . $rowCount, $pegawai->alamat);

				$this->excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true) ;

				$this->excel->getActiveSheet()

            				->getCell('K' . $rowCount)

            				->setValueExplicit($pegawai->telepon, PHPExcel_Cell_DataType::TYPE_STRING);

				$this->excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true) ;

				$this->excel->getActiveSheet()->SetCellValue('L' . $rowCount, $pegawai->email);

				$this->excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true) ;

				$this->excel->getActiveSheet()->SetCellValue('M' . $rowCount, $pegawai->statusPernikahan);

				$this->excel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true) ;

				$this->excel->getActiveSheet()->SetCellValue('N' . $rowCount, $pegawai->jabatan);

				$this->excel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true) ;

				$this->excel->getActiveSheet()->SetCellValue('O' . $rowCount, $pegawai->kodeKelas);

				$this->excel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true) ;

				$this->excel->getActiveSheet()->SetCellValue('P' . $rowCount, $pegawai->namaUnit);

				$this->excel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true) ;

				$this->excel->getActiveSheet()->SetCellValue('Q' . $rowCount, $pegawai->jenisPegawai);

				$this->excel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true) ;

				$this->excel->getActiveSheet()->SetCellValue('R' . $rowCount, $pegawai->nama_bank);

				$this->excel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true) ;

				$this->excel->getActiveSheet()->SetCellValue('S' . $rowCount, $pegawai->norek);

				$this->excel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true) ;

				$this->excel->getActiveSheet()->SetCellValue('T' . $rowCount, $pegawai->an_rek);

				$this->excel->getActiveSheet()->getColumnDimension('U')->setAutoSize(true) ;

				$this->excel->getActiveSheet()->SetCellValue('U' . $rowCount, $pegawai->nomorNPWP);

				$this->excel->getActiveSheet()->getColumnDimension('V')->setAutoSize(true) ;

				$this->excel->getActiveSheet()->SetCellValue('V' . $rowCount, $pegawai->bpjs_kesehatan);

				$this->excel->getActiveSheet()->getColumnDimension('W')->setAutoSize(true) ;

				$this->excel->getActiveSheet()->SetCellValue('W' . $rowCount, $pegawai->bpjs_tenagakerja);

				$this->excel->getActiveSheet()->getColumnDimension('X')->setAutoSize(true) ;

				$this->excel->getActiveSheet()->SetCellValue('X' . $rowCount, $pegawai->status_pegawai);

				$this->excel->getActiveSheet()->getColumnDimension('Y')->setAutoSize(true) ;

				$this->excel->getActiveSheet()->SetCellValue('Y' . $rowCount, $pegawai->gaji);

				$this->excel->getActiveSheet()->getColumnDimension('Z')->setAutoSize(true) ;

				$this->excel->getActiveSheet()->SetCellValue('Z' . $rowCount, $pegawai->tunjanganTetap);

				$this->excel->getActiveSheet()->getColumnDimension('AA')->setAutoSize(true) ;

				$this->excel->getActiveSheet()->SetCellValue('AA' . $rowCount, date_format(date_create($pegawai->tglBergabung), 'd-m-Y'));

				$rowCount++;

			}



			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

			header('Content-Disposition: attachment;filename="datapegawai.xlsx"');

			header('Cache-Control: max-age=0'); 

			$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');

			ob_end_clean();

			$objWriter->save('php://output');

	}



	function sertifikat_excel()

	{

			//data

			$sertifikat = $this->pegawai_model->sertifikat()->result();

			$this->load->library('excel'); //Load library excelnya

			//EXCEL

			$this->excel->setActiveSheetIndex(0);

			//Judul

			//merger cell

			$this->excel->getActiveSheet()->mergeCells('A1:I1');

			//Judul Ditengah

			$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$this->excel->getActiveSheet()->setCellValue('A1', "DATA SERTIFIKAT");

			// set Header

			$this->excel->getActiveSheet()->SetCellValue('A3', 'NIP');



			$this->excel->getActiveSheet()->SetCellValue('B3', 'NAMA PEGAWAI');

			$this->excel->getActiveSheet()->SetCellValue('C3', 'JABATAN');

			$this->excel->getActiveSheet()->SetCellValue('D3', 'UNIT');

			$this->excel->getActiveSheet()->SetCellValue('E3', 'TANGGAL BERGABUNG');

			$this->excel->getActiveSheet()->SetCellValue('F3', 'NAMA LISENSI/SERTIFIKAT');

			$this->excel->getActiveSheet()->SetCellValue('G3', 'NO. LISENSI/SERTIFIKAT');

			$this->excel->getActiveSheet()->SetCellValue('H3', 'BERLAKU MULAI');

			$this->excel->getActiveSheet()->SetCellValue('I3', 'BERAKHIR PADA');       

			// set Row

			$rowCount = 4;

			foreach ($sertifikat as $pegawai) {

				$this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true) ;

				$this->excel->getActiveSheet()->SetCellValue('A' . $rowCount, $pegawai->nipBaru);

				$this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true) ;

				$this->excel->getActiveSheet()->SetCellValue('B' . $rowCount, $pegawai->namaPegawai);

				$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true) ;

				$this->excel->getActiveSheet()->SetCellValue('C' . $rowCount, $pegawai->jabatan);

				$this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true) ;

				$this->excel->getActiveSheet()->SetCellValue('D' . $rowCount, $pegawai->NamaUnit);

				$this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true) ;

				$this->excel->getActiveSheet()->SetCellValue('E' . $rowCount, date_format(date_create($pegawai->tglBergabung), 'd-m-Y'));

				$this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true) ;

				$this->excel->getActiveSheet()->SetCellValue('F' . $rowCount, $pegawai->namaSertifikat);

				$this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true) ;

				$this->excel->getActiveSheet()->SetCellValue('G' . $rowCount, $pegawai->nomor);

				$this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true) ;

				$this->excel->getActiveSheet()->SetCellValue('H' . $rowCount, date_format(date_create($pegawai->berlaku), 'd-m-Y'));

				$this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true) ;

				$this->excel->getActiveSheet()->SetCellValue('I' . $rowCount, date_format(date_create($pegawai->sampai), 'd-m-Y'));

				$rowCount++;

			}



			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

			header('Content-Disposition: attachment;filename="datasertifikat.xlsx"');

			header('Cache-Control: max-age=0'); 

			$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');

			ob_end_clean();

			$objWriter->save('php://output');

			

	}





	function Input($id, $unit, $jabatan)

	{

		$data['bc'] = array('Dashboard' => site_url('dashboard'), 'Data Pegawai' => site_url('pegawai'), 'Input Data Pegawai' => site_url('pegawai/Input/') . $id . '/' . $unit . '/' . $jabatan);

		$data['title'] = "Form Input Data Pegawai";

		$data['cJabatan'] = $jabatan;

		$data['cUnit'] = $unit;

		$data['cID'] = $id;

		$data['dt'] = $this->pegawai_model->get_by_id($id)->row();

		$dt = $data['dt'];

		$data['jabatan'] = $this->pegawai_model->get_jabatan()->result();

		$data['unit'] = $this->pegawai_model->get_unit()->result();

		if ($id != 0) {

			$data['gol'] = $this->pegawai_model->get_gol($dt->idJabatan)->result();

		} else {

			$data['gol'] = $this->pegawai_model->get_gol(0)->result();

		}

		$this->template->mainview('pegawai/pegawai_input', $data);

	}



	function Simpan($unit, $jabatan)

	{

		$error = '';

		//ambil data form pindah ke variable $data

		$data = $_POST;



		//upload file image dulu



		$config['upload_path'] = 'assets/profil'; // direktori tempat menyimpan file yang di-upload

		$config['allowed_types'] = 'gif|jpg|png|jpeg'; // jenis file yang diperbolehkan untuk di-upload

		$config['max_size'] = 500; // ukuran maksimum file dalam kilobytes

		$config['max_width'] = 1024; // lebar maksimum gambar dalam piksel

		$config['max_height'] = 768; // tinggi maksimum gambar dalam piksel

		$config['encrypt_name'] = true;



		$this->load->library('upload', $config);

		$this->upload->initialize($config);



		if (!$this->upload->do_upload('fotoPegawai')) {

			$error = $this->upload->display_errors();

		} else {

			$data['fotoPegawai'] = $this->upload->data('file_name');

		}



		$id = $data['idtbPegawai'];

		unset($data['idtbPegawai']);



		//cek jabatan

		$jab = $this->pegawai_model->get_jabatan($data['idJabatan'])->row();

		if (isset($jab)) {

			$data['jabatan'] = $jab->namaJabatan;

		}



		//simpan data

		if ($id == 0) {

			//insert data

			$this->pegawai_model->input($data);

		} else {

			//update data

			$this->pegawai_model->update($data, $id);

		}

		if ($error != '') {

			$this->session->set_flashdata('error', $error);

		}

		redirect(site_url('pegawai/show/' . $unit . '/' . $jabatan));

	}





	function NonAktif($unit, $jabatan)

	{

		$id = $this->input->post('idnon');

		$data['kedudukanHukum'] = 'Non Aktif';

		$data['flagStatus'] = 0;

		$this->pegawai_model->update($data, $id);

		redirect(site_url('pegawai/index/') . $unit . '/' . $jabatan);

	}



	function Aktif($unit, $jabatan)

	{

		$id = $this->input->post('idaktif');

		$data['kedudukanHukum'] = 'Aktif';

		$data['flagStatus'] = 1;

		$this->pegawai_model->update($data, $id);

		redirect(site_url('pegawai/index/') . $unit . '/' . $jabatan);

	}



	function GetGol()

	{

		$id = $_GET['id'];

		$dt = $this->pegawai_model->get_gol($id)->result_array();

		echo json_encode($dt);

	}



	function Detail($id, $unit, $jabatan, $tab = "0")

	{

		$data['bc'] = array('Dashboard' => site_url('dashboard'), 'Data Pegawai' => site_url('pegawai'), 'Tunjangan & Potongan' => site_url('pegawai/Detail/') . $id . '/' . $unit . '/' . $jabatan);

		$data['title'] = "Detail Tunjangan & Potongan";

		$data['cJabatan'] = $jabatan;

		$data['cUnit'] = $unit;

		$data['cID'] = $id;

		$data['cTab'] = $tab;

		$data['dt'] = $this->pegawai_model->get_by_id($id)->row();

		$dt = $data['dt'];

		$data['jabatan'] = $this->pegawai_model->get_jabatan($dt->idJabatan)->row();

		$data['unit'] = $this->pegawai_model->get_unit($dt->skpd)->row();

		$data['tunjangan'] = $this->pegawai_model->get_tunjangan($dt->skpd, $dt->idJabatan, $dt->kelasJabatan)->result();

		$data['potongan'] = $this->pegawai_model->get_potongan($dt->skpd, $dt->idJabatan, $dt->kelasJabatan)->result();

		$data['tunjKhusus'] = $this->pegawai_model->get_tunj_khusus($dt->idtbPegawai)->result();

		$data['potKhusus'] = $this->pegawai_model->get_pot_khusus($dt->idtbPegawai)->result();

		if ($id != 0) {

			$data['gol'] = $this->pegawai_model->get_gol($dt->idJabatan)->result();

		} else {

			$data['gol'] = $this->pegawai_model->get_gol(0)->result();

		}

		$this->template->mainview('pegawai/pegawai_detail', $data);

	}



	function TunjanganKhusus($id, $unit, $jabatan)

	{

		$data['namaTunjangan'] = $this->input->post('namaTunjangan');

		$data['nilai'] = $this->input->post('nilai');

		$data['idtbPegawai'] = $id;

		$data['satuan'] = $this->input->post('satuan');

		$data['tunjKontribusi'] = $this->input->post('tunjKontribusi') ? 1 : 0;

		$this->db->insert('tbTunjanganKhusus', $data);

		redirect(site_url('pegawai/Detail/' . $id . '/' . $unit . '/' . $jabatan . '/1'));

	}



	function EditTunjanganKhusus($id, $unit, $jabatan)

	{

		$data['namaTunjangan'] = $this->input->post('namaTunjangan');

		$data['nilai'] = $this->input->post('nilai');

		$data['idtbPegawai'] = $id;

		$data['satuan'] = $this->input->post('satuan');

		$data['tunjKontribusi'] = $this->input->post('tunjKontribusi') ? 1 : 0;

		$this->db->update('tbTunjanganKhusus', $data, array('id' => $this->input->post('id')));

		redirect(site_url('pegawai/Detail/' . $id . '/' . $unit . '/' . $jabatan . '/1'));

	}



	function DelTunjanganKhusus($id, $unit, $jabatan, $key)

	{

		$this->db->delete('tbTunjanganKhusus', array('id' => $key));

		redirect(site_url('pegawai/Detail/' . $id . '/' . $unit . '/' . $jabatan . '/1'));

	}



	function PotonganKhusus($id, $unit, $jabatan)

	{

		$data['namaPotongan'] = $this->input->post('namaPotongan');

		$data['nilai'] = $this->input->post('nilai');

		$data['idtbPegawai'] = $id;

		$data['satuan'] = $this->input->post('satuan');

		$this->db->insert('tbPotonganKhusus', $data);

		redirect(site_url('pegawai/Detail/' . $id . '/' . $unit . '/' . $jabatan . '/3'));

	}



	function EditPotonganKhusus($id, $unit, $jabatan)

	{

		$data['namaPotongan'] = $this->input->post('namaPotongan');

		$data['nilai'] = $this->input->post('nilai');

		$data['idtbPegawai'] = $id;

		$data['satuan'] = $this->input->post('satuan');

		$this->db->update('tbPotonganKhusus', $data, array('id' => $this->input->post('id')));

		redirect(site_url('pegawai/Detail/' . $id . '/' . $unit . '/' . $jabatan . '/3'));

	}



	function DelPotonganKhusus($id, $unit, $jabatan, $key)

	{

		$this->db->delete('tbPotonganKhusus', array('id' => $key));

		redirect(site_url('pegawai/Detail/' . $id . '/' . $unit . '/' . $jabatan . '/3'));

	}



	function Berkas($id, $unit, $jabatan)

	{

		$data['bc'] = array('Dashboard' => site_url('dashboard'), 'Data Pegawai' => site_url('pegawai'), 'Kelengkapan File' => site_url('pegawai/Berkas/') . $id . '/' . $unit . '/' . $jabatan);

		$data['title'] = "Data Kelengkapan File";

		$data['cJabatan'] = $jabatan;

		$data['cUnit'] = $unit;

		$data['cID'] = $id;

		$data['dt'] = $this->pegawai_model->get_by_id($id)->row();

		$dt = $data['dt'];

		$data['jabatan'] = $this->pegawai_model->get_jabatan($dt->idJabatan)->row();

		$data['unit'] = $this->pegawai_model->get_unit($dt->skpd)->row();

		$data['list'] = $this->db->get_where('tbFilePegawai', array('idtbPegawai' => $id))->result();

		if ($id != 0) {

			$data['gol'] = $this->pegawai_model->get_gol($dt->idJabatan)->result();

		} else {

			$data['gol'] = $this->pegawai_model->get_gol(0)->result();

		}

		$this->template->mainview('pegawai/pegawai_berkas', $data);

	}



	function TambahBerkas($id, $unit, $jabatan)

	{



		$config['upload_path'] = 'files'; // Folder tujuan untuk menyimpan file yang diunggah

		$config['allowed_types'] = 'gif|jpg|png|pdf'; // Jenis file yang diizinkan untuk diunggah

		$config['max_size'] = 2048; // Ukuran file maksimum dalam kilobita

		$config['encrypt_name'] = TRUE; // Mengenkripsi nama file yang diunggah



		// Memuat library upload dan mengkonfigurasinya

		$this->load->library('upload', $config);

		$this->upload->initialize($config);

		// Melakukan proses upload

		if ($this->upload->do_upload('linkFile')) {

			// Jika upload berhasil, ambil informasi file yang diunggah

			$data = $this->upload->data();

			//echo "File berhasil diunggah: " . $data['file_name'];

			$ins['linkFile'] =  $data['file_name'];

			$ins['namaFile'] = $this->input->post('namaFile');

			$ins['idtbPegawai'] = $id;

			$this->db->insert('tbFilePegawai', $ins);

			redirect(site_url('pegawai/Berkas/' . $id . '/' . $unit . '/' . $jabatan));

		} else {

			// Jika upload gagal, tampilkan pesan error

			echo "Upload gagal: " . $this->upload->display_errors();

			echo "<br><br>";

			echo "<a href='" . site_url('pegawai/Berkas/' . $id . '/' . $unit . '/' . $jabatan) . "' >[ kembali ]</a>";

		}

	}



	function DelBerkas($id, $unit, $jabatan, $key)

	{

		$rs = $this->db->get_where('tbFilePegawai',array('id'=>$key))->row();



		$file_path = 'files/' . $rs->linkFile; // Tentukan path file yang ingin dihapus

		if (file_exists($file_path)) {

			unlink($file_path);

		} 

		$this->db->delete('tbFilePegawai',array('id'=>$key));

		redirect(site_url('pegawai/Berkas/' . $id . '/' . $unit . '/' . $jabatan));

	}



	function Lisensi($id, $unit, $jabatan)

	{

		$data['bc'] = array('Dashboard' => site_url('dashboard'), 'Data Pegawai' => site_url('pegawai'), 'Lisensi/Setifikat keahlian' => site_url('pegawai/Lisensi/') . $id . '/' . $unit . '/' . $jabatan);

		$data['title'] = "Lisensi dan Sertifikat Keahlian";

		$data['cJabatan'] = $jabatan;

		$data['cUnit'] = $unit;

		$data['cID'] = $id;

		$data['dt'] = $this->pegawai_model->get_by_id($id)->row();

		$dt = $data['dt'];

		$data['jabatan'] = $this->pegawai_model->get_jabatan($dt->idJabatan)->row();

		$data['unit'] = $this->pegawai_model->get_unit($dt->skpd)->row();

		$data['list'] = $this->db->get_where('tbSertifikatKeahlian',array('idPegawai'=>$id))->result();

		if ($id != 0) {

			$data['gol'] = $this->pegawai_model->get_gol($dt->idJabatan)->result();

		} else {

			$data['gol'] = $this->pegawai_model->get_gol(0)->result();

		}

		$this->template->mainview('pegawai/pegawai_lisensi', $data);

	}



	function TambahLisensi($id, $unit, $jabatan)

	{

		$data = $_POST;

		$data['idPegawai'] = $id;

		$this->db->insert('tbSertifikatKeahlian',$data);

		redirect(site_url('pegawai/Lisensi/' . $id . '/' . $unit . '/' . $jabatan));

	}



	function EditLisensi($id, $unit, $jabatan,$key)

	{

		$data = $_POST;

		$this->db->update('tbSertifikatKeahlian',$data,array('id'=>$key));

		redirect(site_url('pegawai/Lisensi/' . $id . '/' . $unit . '/' . $jabatan));

	}



	function DelLisensi($id, $unit, $jabatan,$key) {

		$this->db->delete('tbSertifikatKeahlian',array('id'=>$key));

		redirect(site_url('pegawai/Lisensi/' . $id . '/' . $unit . '/' . $jabatan));

	}



	public function upsandi($id) {;

		$pl = $this->input->post('pl');

		$p1 = $this->input->post('p1'); 

		$p2 = $this->input->post('p2'); 

		$datauserlama=$this->pegawai_model->dt_user($id)->row();

		//convert password lama

		$plama=md5($pl);

		// bandingkan dengan db

		if($datauserlama->userPassword==$plama)

		{		

			if ($p1 == $p2) {

				$data['userPassword'] = md5($p1);

				$sql="UPDATE tbUser SET userPassword = '".$data['userPassword']."'". " WHERE idtbUser=".$id;

				$this->db->query($sql);

			} else {

				$this->session->set_flashdata('errMsg', 'Peringatan...! Password dan konfirmasi password tidak sama, silahkan ulangi');			

			}

		}

		else

		{

			$this->session->set_flashdata('errMsg', 'Peringatan...! Password lama salah');

		}

		redirect(site_url('dashboard'));

	}

    public function export_pkwt()
    {
        $data['bc'] = array('Dashboard' => site_url('dashboard'), 'Data PKWT' => site_url('pegawai/pkwt'));
        $data['title'] = "Data PKWT Yang Akan Berakhir";
        $data['dt'] = $this->Access_model->ex_pkwt()->result();
        $this->load->view('pegawai/pkwt_export', $data);
    }
}

