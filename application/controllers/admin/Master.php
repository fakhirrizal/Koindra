<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master extends CI_Controller {
	function __construct() {
		parent::__construct();
	}
	/* Administrator */
	/* Student */
	public function student_data()
	{
		$data['parent'] = 'master';
		$data['child'] = 'student';
		$data['grand_child'] = '';
		$data['data_tabel'] = $this->Main_model->getSelectedData('student a', 'a.*', array('a.deleted'=>'0'), "a.fullname ASC")->result();
		$this->load->view('admin/template/header',$data);
		$this->load->view('admin/master/student_data',$data);
		$this->load->view('admin/template/footer');
	}
	public function add_student_data()
	{
		$data['parent'] = 'master';
		$data['child'] = 'student';
		$data['grand_child'] = '';
		$this->load->view('admin/template/header',$data);
		$this->load->view('admin/master/add_student_data',$data);
		$this->load->view('admin/template/footer');
	}
	public function save_student_data(){
		$this->db->trans_start();
		$user_id = $this->Main_model->getLastID('user','id');

		$data1 = array(
					'id' => $user_id['id']+1,
					'username' => $this->input->post('fullname'),
					'pass' => $this->input->post('mother'),
					'is_active' => '1',
					'created_at' => date('Y-m-d H:i:s'),
					'created_by' => $this->session->userdata('id')
				);
		// print_r($data1);
		$this->Main_model->insertData('user',$data1);

		$data2 = array(
			'user_id' => $user_id['id']+1,
			'fullname' => $this->input->post('fullname'),
		);
		// print_r($data2);
		$this->Main_model->insertData('user_profile',$data2);

		$data3 = array(
			'user_id' => $user_id['id']+1,
			'role_id' => '2',
		);
		// print_r($data3);
		$this->Main_model->insertData('user_to_role',$data3);

		$data4 = array(
			'user_id' => $user_id['id']+1,
			'fullname' => $this->input->post('fullname'),
			'mother' => $this->input->post('mother'),
			'number_phone' => $this->input->post('number_phone'),
			'mother_phone' => $this->input->post('mother_phone'),
			'email' => $this->input->post('email'),
			'school' => $this->input->post('school'),
			'class' => $this->input->post('class')
		);
		// print_r($data4);
		$this->Main_model->insertData('student',$data4);

		$this->Main_model->log_activity($this->session->userdata('id'),'Creating data',"Creating student data (".$this->input->post('fullname').")");
		$this->db->trans_complete();
		if($this->db->trans_status() === false){
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal ditambahkan.<br /></div>' );
			echo "<script>window.location='".base_url()."admin_side/tambah_data_siswa/'</script>";
		}
		else{
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil ditambahkan.<br /></div>' );
			echo "<script>window.location='".base_url()."admin_side/siswa/'</script>";
		}
	}
	public function detail_student_data()
	{
		$data['parent'] = 'master';
		$data['child'] = 'student';
		$data['grand_child'] = '';
		$data['data_utama'] =  $this->Main_model->getSelectedData('student a', 'a.*', array('md5(a.user_id)'=>$this->uri->segment(3),'a.deleted'=>'0'))->result();
		$data['riwayat_pembayaran'] = $this->Main_model->getSelectedData('purchasing a', 'a.*', array('md5(a.user_id)'=>$this->uri->segment(3),'a.deleted'=>'0'))->result();
		$data['riwayat_kehadiran'] = $this->Main_model->getSelectedData('presence a', 'a.*', array('md5(a.user_id)'=>$this->uri->segment(3)))->result_array();
		$this->load->view('admin/template/header',$data);
		$this->load->view('admin/master/detail_student_data',$data);
		$this->load->view('admin/template/footer');
	}
	public function edit_student_data()
	{
		$data['parent'] = 'master';
		$data['child'] = 'student';
		$data['grand_child'] = '';
		$data['data_utama'] = $this->Main_model->getSelectedData('student a', 'a.*', array('md5(a.user_id)'=>$this->uri->segment(3),'a.deleted'=>'0'))->result();
		$this->load->view('admin/template/header',$data);
		$this->load->view('admin/master/edit_student_data',$data);
		$this->load->view('admin/template/footer');
	}
	public function update_student_data(){
		$this->db->trans_start();

		$data1 = array(
			'fullname' => $this->input->post('fullname'),
			'mother' => $this->input->post('mother'),
			'number_phone' => $this->input->post('number_phone'),
			'mother_phone' => $this->input->post('mother_phone'),
			'email' => $this->input->post('email'),
			'school' => $this->input->post('school'),
			'class' => $this->input->post('class')
		);
		// print_r($data1);
		$this->Main_model->updateData('student',$data1,array('md5(user_id)'=>$this->input->post('user_id')));

		$this->Main_model->log_activity($this->session->userdata('id'),'Updating data',"Updating student data (".$this->input->post('fullname').")");
		$this->db->trans_complete();
		if($this->db->trans_status() === false){
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal diubah.<br /></div>' );
			echo "<script>window.location='".base_url()."admin_side/ubah_data_siswa/".$this->input->post('user_id')."'</script>";
		}
		else{
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil diubah.<br /></div>' );
			echo "<script>window.location='".base_url()."admin_side/siswa/'</script>";
		}
	}
	public function reset_password_student_account(){
		$this->db->trans_start();
		$data = array(
					'pass' => '1234',
					'updated_by' => $this->session->userdata('id'),
					'updated_at' => date('Y-m-d H:i:s')
				);
		$this->Main_model->updateData('user',$data,array('md5(id)'=>$this->uri->segment(3)));

		$this->Main_model->log_activity($this->session->userdata('id'),'Updating data',"Reset password student account");
		$this->db->trans_complete();
		if($this->db->trans_status() === false){
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal diubah.<br /></div>' );
            echo "<script>window.location='".base_url()."admin_side/siswa/'</script>";
		}
		else{
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil diubah.<br /></div>' );
            echo "<script>window.location='".base_url()."admin_side/siswa/'</script>";
		}
	}
	public function delete_student_data(){
		$this->db->trans_start();
		$data_delete = array(
			'is_active' => '0',
			'deleted_by' => $this->session->userdata('id'),
			'deleted_at' => date('Y-m-d H:i:s'),
			'deleted' => '1'
		);
		$this->Main_model->updateData('user',$data_delete,array('md5(id)'=>$this->uri->segment(3)));
		$this->Main_model->updateData('student',array('deleted' => '1'),array('md5(user_id)'=>$this->uri->segment(3)));

		$this->Main_model->log_activity($this->session->userdata('id'),'Deleting data',"Deleting student data");
		$this->db->trans_complete();
		if($this->db->trans_status() === false){
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal dihapus.<br /></div>' );
            echo "<script>window.location='".base_url()."admin_side/siswa/'</script>";
		}
		else{
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil dihapus.<br /></div>' );
            echo "<script>window.location='".base_url()."admin_side/siswa/'</script>";
		}
	}
	/* Packet */
	public function packet_data()
	{
		$data['parent'] = 'master';
		$data['child'] = 'packet';
		$data['grand_child'] = '';
		$data['data_tabel'] = $this->Main_model->getSelectedData('packet a', 'a.*', array('a.deleted'=>'0'))->result();
		$this->load->view('admin/template/header',$data);
		$this->load->view('admin/master/packet_data',$data);
		$this->load->view('admin/template/footer');
	}
	public function add_packet_data()
	{
		$data['parent'] = 'master';
		$data['child'] = 'packet';
		$data['grand_child'] = '';
		$this->load->view('admin/template/header',$data);
		$this->load->view('admin/master/add_packet_data',$data);
		$this->load->view('admin/template/footer');
	}
	public function save_packet_data(){
		$this->db->trans_start();
		$data1 = array(
			'packet_name' => $this->input->post('packet_name'),
			'quota' => $this->input->post('quota'),
			'duration' => $this->input->post('duration'),
			'expired_date' => $this->input->post('expired_date'),
			'additional_info' => $this->input->post('additional_info'),
			'term_and_condition' => $this->input->post('term_and_condition'),
			'price' => $this->input->post('price')
		);
		// print_r($data1);
		$this->Main_model->insertData('packet',$data1);

		$this->Main_model->log_activity($this->session->userdata('id'),'Creating data',"Creating packet data (".$this->input->post('packet_name').")");
		$this->db->trans_complete();
		if($this->db->trans_status() === false){
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal ditambahkan.<br /></div>' );
			echo "<script>window.location='".base_url()."admin_side/tambah_data_paket/'</script>";
		}
		else{
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil ditambahkan.<br /></div>' );
			echo "<script>window.location='".base_url()."admin_side/paket/'</script>";
		}
	}
	public function detail_packet_data()
	{
		$data['parent'] = 'master';
		$data['child'] = 'packet';
		$data['grand_child'] = '';
		$data['data_utama'] = $this->Main_model->getSelectedData('packet a', 'a.*', array('md5(a.packet_id)'=>$this->uri->segment(3),'a.deleted'=>'0'))->result();
		$this->load->view('admin/template/header',$data);
		$this->load->view('admin/master/detail_packet_data',$data);
		$this->load->view('admin/template/footer');
	}
	public function edit_packet_data(){
		$data['parent'] = 'master';
		$data['child'] = 'packet';
		$data['grand_child'] = '';
		$data['data_utama'] = $this->Main_model->getSelectedData('packet a', 'a.*', array('md5(a.packet_id)'=>$this->uri->segment(3),'a.deleted'=>'0'))->row_array();
		$this->load->view('admin/template/header',$data);
		$this->load->view('admin/master/edit_packet_data',$data);
		$this->load->view('admin/template/footer');
	}
	public function update_packet_data(){
		$this->db->trans_start();
		$data1 = array(
			'packet_name' => $this->input->post('packet_name'),
			'quota' => $this->input->post('quota'),
			'duration' => $this->input->post('duration'),
			'expired_date' => $this->input->post('expired_date'),
			'additional_info' => $this->input->post('additional_info'),
			'term_and_condition' => $this->input->post('term_and_condition'),
			'price' => $this->input->post('price')
		);
		// print_r($data1);
		$this->Main_model->updateData('packet',$data1,array('md5(packet_id)'=>$this->input->post('packet_id')));

		$this->Main_model->log_activity($this->session->userdata('id'),'Updating data',"Updating packet data (".$this->input->post('packet_name').")");
		$this->db->trans_complete();
		if($this->db->trans_status() === false){
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal diubah.<br /></div>' );
			echo "<script>window.location='".base_url()."admin_side/ubah_data_paket/".$this->input->post('packet_id')."'</script>";
		}
		else{
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil diubah.<br /></div>' );
			echo "<script>window.location='".base_url()."admin_side/paket/'</script>";
		}
	}
	public function delete_packet_data(){
		$this->db->trans_start();
		$data_delete = array(
			'is_active' => '0',
			'deleted' => '1'
		);
		$this->Main_model->updateData('packet',$data_delete,array('md5(packet_id)'=>$this->uri->segment(3)));

		$this->Main_model->log_activity($this->session->userdata('id'),'Deleting data',"Deleting packet data");
		$this->db->trans_complete();
		if($this->db->trans_status() === false){
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal dihapus.<br /></div>' );
			echo "<script>window.location='".base_url()."admin_side/paket/'</script>";
		}
		else{
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil dihapus.<br /></div>' );
			echo "<script>window.location='".base_url()."admin_side/paket/'</script>";
		}
	}
	public function ajax_function(){
		if($this->input->post('modul')=='modul_detail_riwayat_pembayaran'){
			$data['data_detail'] = $this->Main_model->getSelectedData('purchasing_detail a', 'a.*,b.packet_name,b.price', array('md5(a.purchasing_id)'=>$this->input->post('id')), "",'','','',array(
				'table' => 'packet b',
				'on' => 'a.product_id=b.packet_id',
				'pos' => 'left'
			))->result();
			$data['data_utama'] = $this->Main_model->getSelectedData('purchasing a', 'a.*', array('md5(a.purchasing_id)'=>$this->input->post('id'),'a.deleted'=>'0'))->row_array();
			$this->load->view('admin/master/ajax_detail_purchasing',$data);
		}
	}
}