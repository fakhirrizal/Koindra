<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {
	function __construct() {
		parent::__construct();
	}
	/* Presence */
	public function presence_data(){
		$data['parent'] = 'report';
		$data['child'] = 'presence';
		$data['grand_child'] = '';

		$data['data_tabel'] = $this->Main_model->getSelectedData('student a', 'a.*,(SELECT COUNT(b.presence_id) FROM presence b WHERE b.user_id=a.user_id) AS jumlah_kehadiran', array('a.deleted'=>'0'), "a.fullname ASC")->result();
		$this->load->view('admin/template/header',$data);
		$this->load->view('admin/report/presence_data',$data);
		$this->load->view('admin/template/footer');
	}
	public function presence_data_detail(){
		$data['parent'] = 'report';
		$data['child'] = 'presence';
		$data['grand_child'] = '';

		$data['riwayat_kehadiran'] = $this->Main_model->getSelectedData('presence a', 'a.*,b.fullname', array('md5(a.user_id)'=>$this->uri->segment(3)), "a.date DESC",'','','',array(
			'table' => 'user_profile b',
			'on' => 'a.user_id=b.user_id',
			'pos' => 'left',
		))->result_array();
		$this->load->view('admin/template/header',$data);
		$this->load->view('admin/report/presence_data_detail',$data);
		$this->load->view('admin/template/footer');
	}
	public function import_presence_data(){
		include APPPATH.'third_party/PHPExcel/PHPExcel.php';
		$namafile = date('YmdHis').'.xlsx';
		$config['upload_path'] = 'data_upload/';
		$config['allowed_types'] = 'xlsx';
		$config['max_size']	= '3048';
		$config['overwrite'] = true;
		$config['file_name'] = $namafile;

		$this->upload->initialize($config);
		if($this->upload->do_upload('fmasuk')){
			$excelreader = new PHPExcel_Reader_Excel2007();
			$loadexcel = $excelreader->load('data_upload/'.$namafile);
			$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
			$numrow = 1;
			foreach($sheet as $row){
				if($numrow > 1){
					$get_student_id = $this->Main_model->getSelectedData('student a', '*', array("a.student_id" => $row['A']))->row();
					$cek = $this->Main_model->getSelectedData('presence a', '*', array("a.user_id" => $get_student_id->user_id, "a.date" => $this->input->post('date')))->result();
					if($cek==NULL){
						if($row['C']=='1'){
							$datasimpan = array(
								'user_id'=>$get_student_id->user_id,
								'date'=>$this->input->post('date'),
								// 'come_in'=>$row['C'],
								// 'come_out'=>$row['D'],
								'note'=>$row['B']
							);
							$this->Main_model->insertData('presence',$datasimpan);
							$getquota = $this->Main_model->getSelectedData('status a', '*', array("a.user_id" => $get_student_id->user_id))->row();
							if($getquota->quota==NULL){
								echo $getquota->user_id;
							}else{
								$this->Main_model->updateData('status',array('quota'=>($getquota->quota)-1),array('user_id'=>$get_student_id->user_id));}
						}else{
							echo'';
						}
					}
				}
				$numrow++;
			}
			// $this->Main_model->log_activity($this->session->userdata('id'),'Importing data',"Import student attendance data");
			// $this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil diupload.<br /></div>' );
			// echo "<script>window.location='".base_url()."admin_side/laporan_kehadiran/'</script>";
		}else{
			// $this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal diupload.<br /></div>' );
			// echo "<script>window.location='".base_url()."admin_side/laporan_kehadiran/'</script>";
		}
	}
}