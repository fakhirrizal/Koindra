<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends CI_Controller {
	function __construct() {
		parent::__construct();
	}
	/* Packet */
	public function packet_data()
	{
		$data['parent'] = 'payment';
		$data['child'] = 'packet';
		$data['grand_child'] = '';
		$data['data_tabel'] = $this->Main_model->getSelectedData('packet a', 'a.*', array('is_active'=>'1','a.deleted'=>'0'))->result();
		$this->load->view('student/template/header',$data);
		$this->load->view('student/payment/packet_data',$data);
		$this->load->view('student/template/footer');
	}
	/* Payment */
	public function add_to_cart(){
		$product = $this->Main_model->getSelectedData('packet a', 'a.*', array('md5(a.packet_id)'=>$this->uri->segment(3),'a.deleted'=>'0'))->row_array();
		$data = array(
			'id' => $product['packet_id'],
			'qty' => 1,
			'price' => $product['price'],
			'name' => $product['packet_name'],
			'option' => array('quota'=>$product['quota'],'duration'=>$product['duration'])
		);
		$this->cart->product_name_rules = '[:print:]';
		$insert = $this->cart->insert($data);
		$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>berhasil ditambahkan ke keranjang.<br /></div>' );
		echo "<script>window.location='".base_url()."student/paket/'</script>";
	}
	public function cart()
	{
		if($this->cart->total()==NULL){
			$this->load->view('student/payment/empty_cart');
		}else{
		$data['parent'] = 'payment';
		$data['child'] = 'cart';
		$data['grand_child'] = '';
		$this->load->view('student/template/header',$data);
		$this->load->view('student/payment/cart',$data);
		$this->load->view('student/template/footer');
		}
	}
	public function transaction_completed(){
		$get = $this->input->get();
		// Veritrans_Config::$serverKey = "Mid-server-pj-mcbw3fEk36nTwvZr10lDn";

		// Uncomment for production environment
		// Veritrans_Config::$isProduction = true;
		// Veritrans_Config::$isProduction = false;
		$this->db->trans_start();
		$datacart = $this->cart->contents();
		$purchasing_id = $this->Main_model->getLastID('purchasing','purchasing_id');
		$data_of_purchasing = array(
			'purchasing_id' => $purchasing_id['purchasing_id']+1,
			'invoice_number' => $get['order_id'],// 'ICK#001/04-2019',
			'user_id' => $this->session->userdata('id'),
			'date' => date('Y-m-d'),
			'total_items' => $this->cart->total_items(),/*
			'order_id' => Veritrans_Transaction::status($get['order_id']),*/
			'grand_total' => $this->cart->total()
		);
		$this->Main_model->insertData('purchasing',$data_of_purchasing);
		foreach ($datacart as $key => $value) {
			$purchasing_detail_data = array(
				'purchasing_id' => $purchasing_id['purchasing_id']+1,
				'product_id' => $value['id'],
				'qty' => $value['qty'],
				'sub_total' => $value['subtotal']
			);
			$this->Main_model->insertData('purchasing_detail',$purchasing_detail_data);
			$get_status_by_student_id = $this->Main_model->getSelectedData('status a', 'a.*,DATE_FORMAT(LAST_DAY(expired_date),"%d") AS end_of_month', array('a.user_id'=>$this->session->userdata('id')))->row();
			$result_of_date = '';
			if(substr($get_status_by_student_id->expired_date,-2)=='01'){
				$beginning_of_the_month = date('Y-m-d',strtotime('+3 months',strtotime($get_status_by_student_id->expired_date)));
				$result_of_date = date('Y-m-d', strtotime('-1 days', strtotime($beginning_of_the_month)));
			}else{
				$get_date = substr($get_status_by_student_id->expired_date,0,8).$get_status_by_student_id->end_of_month;
				$result_of_date = date('Y-m-d',strtotime('+3 months',strtotime($get_date)));
			}
			$get_quota = $this->Main_model->getSelectedData('packet a', 'a.*', array('a.packet_id'=>$value['id']))->row();
			$result_quota = '';
			if($get_quota->quota=='Unlimited'){
				$result_quota = 'Unlimited';
			}else{
				$result_quota = ($get_status_by_student_id->quota)+($get_quota->quota);
			}
			$update_status = array(
				'quota' => $result_quota,
				'expired_date' => $result_of_date
			);
			$this->Main_model->updateData('status',$update_status,array('user_id'=>$this->session->userdata('id')));
		}
		$this->cart->destroy();
		$this->db->trans_complete();
		if($this->db->trans_status() === false){
			$this->session->set_flashdata('sukses','<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Ups! </strong>transaksi gagal! Terjadi kesalahan.<br /></div>' );
			echo "<script>window.location='".base_url()."student/beranda/'</script>";
		}
		else{
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>transaksi Anda telah selesai.<br /></div>' );
			echo "<script>window.location='".base_url()."student/beranda/'</script>";
		}
	}
	public function destroy_cart(){
		$this->cart->destroy();
		redirect('student/cart');
	}
	public function payment_history()
	{
		$data['parent'] = 'payment';
		$data['child'] = 'payment_history';
		$data['grand_child'] = '';
		$data['data_tabel'] = $this->Main_model->getSelectedData('purchasing a', 'a.*', array('a.user_id'=>$this->session->userdata('id'),'a.deleted'=>'0'),'a.date DESC')->result();
		$this->load->view('student/template/header',$data);
		$this->load->view('student/payment/payment_history',$data);
		$this->load->view('student/template/footer');
	}
	public function payment_detail()
	{
		$data['parent'] = 'payment';
		$data['child'] = 'payment_history';
		$data['grand_child'] = '';
		$data['value'] = $this->Main_model->getSelectedData('purchasing a', 'a.*', array('md5(a.invoice_number)'=>$this->uri->segment(3),'a.deleted'=>'0'))->row();
		$data['detail'] = $this->Main_model->getSelectedData('purchasing a', 'c.*,b.packet_name', array('md5(a.invoice_number)'=>$this->uri->segment(3),'a.deleted'=>'0'),'','','','',array(
			array(
				'table' => 'purchasing_detail c',
				'on' => 'a.purchasing_id=c.purchasing_id',
				'pos' => 'left',
			),
			array(
				'table' => 'packet b',
				'on' => 'c.product_id=b.packet_id',
				'pos' => 'left',
			)
		))->result();
		$this->load->view('student/template/header',$data);
		$this->load->view('student/payment/payment_detail',$data);
		$this->load->view('student/template/footer');
	}
	public function ajax_function()
	{
		if($this->input->post('modul')=='modul_detail_data_paket'){
			$data['data_utama'] = $this->Main_model->getSelectedData('packet a', 'a.*', array('md5(a.packet_id)'=>$this->input->post('id'),'is_active'=>'1','a.deleted'=>'0'))->result();
			$this->load->view('student/payment/ajax_detail_packet_data',$data);
		}
	}
}