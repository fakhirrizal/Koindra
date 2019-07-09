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
		$data['parent'] = 'payment';
		$data['child'] = 'cart';
		$data['grand_child'] = '';
		$this->load->view('student/template/header',$data);
		$this->load->view('student/payment/cart',$data);
		$this->load->view('student/template/footer');
	}
	public function transaction_completed(){
		$this->db->trans_start();
		$datacart = $this->cart->contents();
		$purchasing_id = $this->Main_model->getLastID('purchasing','purchasing_id');
		$data_of_purchasing = array(
			'purchasing_id' => $purchasing_id['purchasing_id']+1,
			'invoice_number' => 'ICK#001/04-2019',
			'user_id' => $this->session->userdata('id'),
			'date' => date('Y-m-d'),
			'total_items' => $this->cart->total_items(),
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
	public function payment_history()
	{
		$data['parent'] = 'payment';
		$data['child'] = 'payment_history';
		$data['grand_child'] = '';
		$data['data_tabel'] = $this->Main_model->getSelectedData('purchasing a', 'a.*', array('a.user_id'=>$this->session->userdata('id'),'a.deleted'=>'0'))->result();
		$this->load->view('student/template/header',$data);
		$this->load->view('student/payment/payment_history',$data);
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