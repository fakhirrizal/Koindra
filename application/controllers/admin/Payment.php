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
	public function import_payment_data(){
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
					$string_bill = preg_replace("/[^0-9]/", "", substr($row['B'],0,-3));
					$dt = $this->Main_model->getSelectedData('purchasing a', '*', array("a.bill" => $string_bill,'a.status'=>'0','a.deleted'=>'0'))->row();
					if($dt==NULL){
						$transaction_failed_data = array(
							'nominal' => $row['B'],
							'sender' => $row['C'],
							'payment_date' => date('Y-m-d', strtotime($row['A']))
						);
						$this->Main_model->insertData('cache_transaction_failed',$transaction_failed_data);
					}else{
						$get_purchasing_detail = $this->Main_model->getSelectedData('purchasing_detail a', 'a.*',array('purchasing_id'=>$dt->purchasing_id))->result();
						foreach ($get_purchasing_detail as $key => $value) {
							$get_quota = $this->Main_model->getSelectedData('packet a', 'a.*', array('a.packet_id'=>$value->product_id))->row();
							$plus_month = "+".$get_quota->duration." months";
							$get_status_by_student_id = $this->Main_model->getSelectedData('status a', 'a.*,DATE_FORMAT(LAST_DAY(expired_date),"%d") AS end_of_month', array('a.user_id'=>$dt->user_id))->row();
							$result_of_date = '';
							if(substr($get_status_by_student_id->expired_date,-2)=='01'){
								$beginning_of_the_month = date('Y-m-d',strtotime($plus_month,strtotime($get_status_by_student_id->expired_date)));
								$result_of_date = date('Y-m-d', strtotime('-1 days', strtotime($beginning_of_the_month)));
							}else{
								$get_date = substr($get_status_by_student_id->expired_date,0,8).$get_status_by_student_id->end_of_month;
								$result_of_date = date('Y-m-d',strtotime($plus_month,strtotime($get_date)));
							}
							$result_quota = '';
							if($get_quota->quota=='Unlimited'){
								$result_quota = 'Unlimited';
							}else{
								$result_quota = ($get_status_by_student_id->quota)+($get_quota->quota);
							}
							$update_status = array(
								'last_packet' => $value->product_id,
								'quota' => $result_quota,
								'expired_date' => $result_of_date,
								'sender' => $row['C'],
								'payment_date' => date('Y-m-d', strtotime($row['A'])),
								'status' => '1'
							);
							$this->Main_model->updateData('cache',$update_status,array('user_id'=>$dt->user_id));
							// print_r($update_status);
						}
					}
				}
				$numrow++;
			}
			$this->Main_model->log_activity($this->session->userdata('id'),'Importing data',"Import payment data");
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-warning"></i></button><strong></i>Warning! </strong>silahkan cek data.<br /></div>' );
			echo "<script>window.location='".base_url()."admin_side/konfirmasi_pembayaran/'</script>";
		}else{
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal diupload.<br /></div>' );
			echo "<script>window.location='".base_url()."admin_side/pembayaran/'</script>";
		}
	}
	public function payment_confirmation(){
		$data['parent'] = 'payment';
		$data['child'] = '';
		$data['grand_child'] = '';
		$data['riwayat_pembayaran'] = $this->Main_model->getSelectedData('purchasing a', 'a.*,b.fullname',array('a.deleted'=>'0'),'a.date DESC','','','',array(
			'table' => 'user_profile b',
			'on' => 'a.user_id=b.user_id',
			'pos' => 'LEFT',
		))->result();
		$data['konfirmasi_pembayaran'] = $this->Main_model->getSelectedData('cache a', 'a.*,b.fullname',array('a.status'=>'1'),'a.status DESC','','','',array(
			'table' => 'user_profile b',
			'on' => 'a.user_id=b.user_id',
			'pos' => 'LEFT',
		))->result();
		$data['transaksi_gagal'] = $this->Main_model->getSelectedData('cache_transaction_failed a', 'a.*',array('a.status'=>'0'),'a.status DESC')->result();
		$this->load->view('admin/template/header',$data);
		$this->load->view('admin/payment/payment_confirmation',$data);
		$this->load->view('admin/template/footer');
	}
	public function payment_confirmed(){
		$this->db->trans_start();
		$data = $this->Main_model->getSelectedData('cache a', 'a.*,b.fullname,c.purchasing_id,c.invoice_number',array('a.status'=>'1','c.status'=>'0','c.deleted'=>'0'),'a.status DESC','','','',array(
			array(
				'table' => 'user_profile b',
				'on' => 'a.user_id=b.user_id',
				'pos' => 'LEFT'
			),
			array(
				'table' => 'purchasing c',
				'on' => 'a.user_id=c.user_id',
				'pos' => 'LEFT'
			)
		))->result();
		foreach ($data as $key => $value) {
			$update1 = array(
				'status' => '0'
			);
			$this->Main_model->updateData('cache',$update1,array('user_id'=>$value->user_id));
			$update2 = array(
				'last_packet' => $value->last_packet,
				'quota' => $value->quota,
				'expired_date' => $value->expired_date
			);
			$this->Main_model->updateData('status',$update2,array('user_id'=>$value->user_id));
			$update3 = array(
				'payment_date' => $value->payment_date,
				'status' => '1',
				'sender' => $value->sender
			);
			$this->Main_model->updateData('purchasing',$update3,array('user_id'=>$value->user_id));
			$this->Main_model->updateData('student',array('status'=>'Aktif'),array('user_id'=>$value->user_id));
			$this->Main_model->log_activity($this->session->userdata('id'),'Payment Confirmed',"Payment Confirmed (Invoice number: ".$value->invoice_number.")");
		}
		$this->Main_model->updateData('cache_transaction_failed',array('status'=>'1'),array('status'=>'0'));
		$this->db->trans_complete();
		if($this->db->trans_status() === false){
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal disimpan.<br /></div>' );
			echo "<script>window.location='".base_url()."admin_side/pembayaran/'</script>";
		}
		else{
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data saved succesfully.<br /></div>' );
			echo "<script>window.location='".base_url()."admin_side/pembayaran/'</script>";
		}
	}
	public function cancel_payment(){
		$this->db->trans_start();
		$data = $this->Main_model->getSelectedData('cache a', 'a.*,b.fullname,c.purchasing_id,c.invoice_number',array('a.status'=>'1','c.status'=>'0','c.deleted'=>'0'),'a.status DESC','','','',array(
			array(
				'table' => 'user_profile b',
				'on' => 'a.user_id=b.user_id',
				'pos' => 'LEFT'
			),
			array(
				'table' => 'purchasing c',
				'on' => 'a.user_id=c.user_id',
				'pos' => 'LEFT'
			)
		))->result();
		foreach ($data as $key => $value) {
			$update1 = array(
				'status' => '0'
			);
			$this->Main_model->updateData('cache',$update1,array('user_id'=>$value->user_id));
		}
		$this->Main_model->updateData('cache_transaction_failed',array('status'=>'1'),array('status'=>'0'));
		$this->db->trans_complete();
		if($this->db->trans_status() === false){
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal disimpan.<br /></div>' );
			echo "<script>window.location='".base_url()."admin_side/pembayaran/'</script>";
		}
		else{
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data saved succesfully.<br /></div>' );
			echo "<script>window.location='".base_url()."admin_side/pembayaran/'</script>";
		}
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