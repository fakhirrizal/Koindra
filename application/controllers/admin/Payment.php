<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends CI_Controller {
	function __construct() {
		parent::__construct();
	}
	public function all_payment()
	{
		$data['parent'] = 'payment';
		$data['child'] = '';
		$data['grand_child'] = '';
		$data['riwayat_pembayaran'] = $this->Main_model->getSelectedData('purchasing a', 'a.*,b.fullname',array('a.deleted'=>'0'),'a.date DESC','','','',array(
			'table' => 'user_profile b',
			'on' => 'a.user_id=b.user_id',
			'pos' => 'LEFT',
		))->result();
		$this->load->view('admin/template/header',$data);
		$this->load->view('admin/payment/all_payment',$data);
		$this->load->view('admin/template/footer');
	}
	public function delete_payment(){
		$this->db->trans_start();
		$data_delete = array(
			'deleted' => '1'
		);
		$this->Main_model->updateData('purchasing',$data_delete,array('md5(purchasing_id)'=>$this->uri->segment(3)));

		$this->Main_model->log_activity($this->session->userdata('id'),'Deleting data',"Deleting transaction data");
		$this->db->trans_complete();
		if($this->db->trans_status() === false){
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal dihapus.<br /></div>' );
			echo "<script>window.location='".base_url()."admin_side/pembayaran/'</script>";
		}
		else{
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil dihapus.<br /></div>' );
			echo "<script>window.location='".base_url()."admin_side/pembayaran/'</script>";
		}
	}
}