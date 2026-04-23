<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Jabatan extends Member_Control {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url'));
		$this->load->model(array('jabatan_model'));
	}

	function index($s=0){
		return $this->show($s);
	}

	function show($s=0){
		$data['bc'] = array('Dashboard' => site_url('dashboard'), 'Jabatan' => site_url('jabatan'));
		$data['title']="Jenis Jabatan";
		$data['s']=$s;
		$data['op_search']=array("A.namaJabatan"=>"Nama Jabatan");
		$this->template->mainview('jabatan/jabatan_index',$data);
	}
	
	function jabatan_show($st=NULL,$option=""){
		$in=$this->input->post(null,true);
		$row=10; $sort=""; $filt="";
		$start = ($st==NULL) ? 0 : $st;
		if(isset($in['row']) && ($in['row']!=NULL || $in['row']!="") ){
			$row=$in['row'];
		}
			if(isset($in['cari']) && ($in['cari']!=NULL || $in['cari']!="") ){
			if($in['filter']!=NULL || $in['filter']!=""){
				($option=="")? $option.=" WHERE " : $option.=" AND " ;
				$option.= $in['filter']." LIKE '%".$in['cari']."%' ";
			}else{
				($option=="")? $option.=" WHERE " : $option.=" AND " ;
				$option.=" ( A.namaJabatan LIKE '%".$in['cari']."%' ) ";
			}
		}

			/*** FILTER ORDER DATA ****/
			if(isset($in['sortby']) && $in['sortby']!=""){
				$sort_field=array("a"=>"A.namaJabatan" );
				$option.=" ORDER BY ".$sort_field[$in['sortby']]." ".$in['sort'];
			}

		/**** pengaturan pagination ***/
		$this->load->library('pagination');
		$config['base_url'] = site_url('jabatan/jabatan_show');
		$config['first_url'] = site_url('jabatan/jabatan_show/0');
		$config['uri_segment'] = 3;///Untuk menentukan jumlah record yang tampil
		$config['per_page'] = $row;
		$config['total_rows'] = $this->jabatan_model->show_data_jabatan($option)->num_rows();

		/*** inisialisasi config pagination ***/
		$this->pagination->initialize($config);
		$data['links'] = $this->pagination->create_links();
		$data['start']=$start;
		$data['end']=$start+$config['per_page'];
		$data['total_rows']=$config['total_rows'];
		$data['jabatan']=$this->jabatan_model->show_data_jabatan($option,$start,$config['per_page'])->result();
		$this->load->view('jabatan/jabatan_show',$data);
	}

	function jabatan_add(){
		$in=$this->input->post(null,true);
		if(!$in){
			$data['title']="Tambah jabatan"; 
			$this->load->view('jabatan/jabatan_form',$data);
		}else{
			$data_in=array(
					'idJabatan' => $in['dc_id'],
					'namaJabatan' => $in['dc_namaJab']
					);
			$input_data=$this->jabatan_model->input_jabatan($data_in);
			if($input_data){
				$notif='<div class="alert alert-success alert-dismissable" onclick="$(this).fadeOut(300);"><i class="fa fa-info-circle"></i> Data berhasil disimpan...
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
				echo json_encode(array('msg'=>$notif,'status'=>'OK'));
			}else{
				$notif='<div class="alert alert-danger alert-dismissable" onclick="$(this).fadeOut(300);"><i class="fa fa-exclamation-triangle"></i> <strong>MAAF!</strong> Data gagal disimpan...
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
				echo json_encode(array('msg'=>$notif,'status'=>'ERROR'));
			}
		}
	}

	function Simpan()
	{
		$jabatan['namaJabatan']=$this->input->post('jabatan');
		$jabatan['section']=$this->input->post('section');
		$hasil=$this->jabatan_model->input_jabatan($jabatan);
		redirect(site_url().'/jabatan');
	}

	function Update()
	{
		
		$jabatan['idJabatan']=$this->input->post('idjabatan');
		$jabatan['namaJabatan']=$this->input->post('jabatan');
		$jabatan['section']=$this->input->post('section');
		$hasil=$this->jabatan_model->update_jabatan($jabatan,$jabatan['idJabatan']);
		redirect(site_url().'/jabatan');
	}
	function Delete($id_r)
	{
		$hasil=$this->jabatan_model->Delete($id_r);
		redirect(site_url().'/jabatan');
	}

	function jabatan_upd($idJabatan=null){
		$in=$this->input->post(null,true);
		if(!$in){
			$data['title']="Update jabatan"; 
			$data['jabatan']=$this->jabatan_model->get_by_id_jabatan($idJabatan)->row();
			$this->load->view('jabatan/jabatan_form',$data);
		}else{
			$data_in=array(
					'namaJabatan' => $in['dc_namaJab']
					);
			$update_data=$this->jabatan_model->update_jabatan($data_in,$in['dc_id']);
			if($update_data){
				$notif='<div class="alert alert-success alert-dismissable" onclick="$(this).fadeOut(300);"><i class="fa fa-info-circle"></i> Data berhasil di-update...
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
				echo json_encode(array('msg'=>$notif,'status'=>'OK'));
			}else{
				$notif='<div class="alert alert-danger alert-dismissable" onclick="$(this).fadeOut(300);"><i class="fa fa-exclamation-triangle"></i> <strong>Maaf!</strong> Data gagal di-update...
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
				echo json_encode(array('msg'=>$notif,'status'=>'ERROR'));
			}
		}
	}

	function jabatan_dlt($id=''){
		$in=$this->input->post(null,true);
		if(!$in && $id!=''){
			$hapus=$this->jabatan_model->delete_jabatan($id);
			if($hapus){
				$notif='<div class="alert alert-success alert-dismissable" onclick="$(this).fadeOut(300);"><i class="fa fa-info-circle"></i> Data berhasil dihapus...
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
				echo json_encode(array('msg'=>$notif,'status'=>'OK'));
			}else{
				$notif='<div class="alert alert-danger alert-dismissable" onclick="$(this).fadeOut(300);"><i class="fa fa-exclamation-triangle"></i> <strong>Maaf!</strong> Data gagal dihapus...
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
				echo json_encode(array('msg'=>$notif,'status'=>'ERROR'));
			}
		}
	}

	function jabatan_actionAll($action=""){
		$cMsg=0;
		$in=$this->input->post(null,true);
		//change data sparated comma text to array
		$dataArray=explode(',',$in['dataArray']);
		//remove "no" dari array
		$idArray = array_diff($dataArray,array('on'));
		$cArray=count($idArray);
		$newIdArray=array();
		for($x=0;$x<$cArray;$x++){
			array_push($newIdArray,$idArray[$x]);
		}
		///jika action yang di klik adalah delete
		if($action=="delete"){
			$hapus=$this->jabatan_model->delete_jabatan($newIdArray);
			if($hapus) $cMsg++;
			$notif='<div class="alert alert-success alert-dismissable" onclick="$(this).fadeOut(300);"><i class="fa fa-info-circle"></i> Data berhasil dihapus...
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
			echo json_encode(array('msg'=>$notif,'status'=>'OK'));
		}else{
			return false;
		}
	}

}