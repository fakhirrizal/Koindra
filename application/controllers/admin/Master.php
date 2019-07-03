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
		$data['data_tabel'] = $this->Main_model->getSelectedData('student a', 'a.*', array('a.deleted'=>'0'), "a.fullname ASC",'','','','')->result();
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

		$this->Main_model->log_activity($this->session->userdata('id'),'Creating data',"Creating student data");
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
		$data['data_utama'] = $data['data_tabel'] = $this->Main_model->getSelectedData('student a', 'a.*', array('md5(a.user_id)'=>$this->uri->segment(3),'a.deleted'=>'0'), "",'','','','')->result();
		$this->load->view('admin/template/header',$data);
		$this->load->view('admin/master/detail_student_data',$data);
		$this->load->view('admin/template/footer');
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
}