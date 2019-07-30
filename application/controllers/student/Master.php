<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master extends CI_Controller {
	function __construct() {
		parent::__construct();
	}
	public function start_free_trial(){
		$this->db->trans_start();

		$expired_date = date('Y-m-d', strtotime('+14 days', strtotime(date('Y-m-d'))));
		$data1 = array(
			'expired_date' => $expired_date
		);
		$this->Main_model->updateData('status',$data1,array('user_id'=>$this->session->userdata('id')));

		$this->Main_model->log_activity($this->session->userdata('id'),'Updating data',"User starting trial this programe");
		$this->db->trans_complete();
		if($this->db->trans_status() === false){
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong><br /></div>' );
			echo "<script>window.location='".base_url()."student/beranda'</script>";
		}
		else{
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Enjoy! </strong>have a nice your day ;)<br /></div>' );
			echo "<script>window.location='".base_url()."student/beranda'</script>";
		}
	}
}