<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_profile extends CI_Controller {
	function __construct() {
		parent::__construct();
	}
	public function profile(){
		$data['parent'] = '';
		$data['child'] = '';
		$data['grand_child'] = '';
		$data['data_profil'] = $this->Main_model->getSelectedData('student a', 'a.*,b.address,b.photo', array('a.user_id'=>$this->session->userdata('id'),'a.deleted'=>'0'), "",'','','',array(
			'table' => 'user_profile b',
			'on' => 'a.user_id=b.user_id',
			'pos' => 'left',
		))->result();
		$this->load->view('student/template/header',$data);
		$this->load->view('student/user_profile/profile',$data);
		$this->load->view('student/template/footer');
	}
	public function update_profile(){
		$this->db->trans_start();
		$data1 = array(
			'fullname' => $this->input->post('fullname'),
			'number_phone' => $this->input->post('number_phone')
		);
		// print_r($data1);
		$this->Main_model->updateData('student',$data1,array('user_id'=>$this->session->userdata('id')));

		$data2 = array(
			'fullname' => $this->input->post('fullname'),
			'address' => $this->input->post('address')
		);
		// print_r($data2);
		$this->Main_model->updateData('user_profile',$data2,array('user_id'=>$this->session->userdata('id')));

		$this->Main_model->log_activity($this->session->userdata('id'),'Updating data',"Updating student data (".$this->input->post('fullname').")");
		$this->db->trans_complete();
		if($this->db->trans_status() === false){
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal diubah.<br /></div>' );
			echo "<script>window.location='".base_url()."student/profile/'</script>";
		}
		else{
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil diubah.<br /></div>' );
			echo "<script>window.location='".base_url()."student/profile/'</script>";
		}
	}
	public function update_profile_photo(){
		$nmfile = "file_".time(); //nama file saya beri nama langsung dan diikuti fungsi time
		$config['upload_path'] = dirname($_SERVER["SCRIPT_FILENAME"]).'/assets/photo_profile/'; //path folder
		$config['allowed_types'] = 'jpg|png|jpeg|bmp'; //type yang dapat diakses bisa anda sesuaikan
		$config['max_size'] = '3072'; //maksimum besar file 3M
		$config['max_width']  = '5000'; //lebar maksimum 5000 px
		$config['max_height']  = '5000'; //tinggi maksimu 5000 px
		$config['file_name'] = $nmfile; //nama yang terupload nantinya

		$this->upload->initialize($config);

		if(isset($_FILES['foto']['name']))
		{
			if(!$this->upload->do_upload('foto'))
			{
				$a = $this->upload->display_errors();
				echo "<script>alert('".$a."')</script>";
				echo "<script>window.location='".base_url('student/profile')."'</script>";
			}
			else
			{
				$this->db->trans_start();
				$gbr = $this->upload->data();

				$this->Main_model->updateData("user_profile",array('photo'=>$gbr['file_name']),array('user_id'=>$this->session->userdata('id'))); //akses model untuk menyimpan ke database

				$this->Main_model->log_activity($this->session->userdata('id'),'Updating data',"Updating profile photo");

				$this->db->trans_complete();
				if($this->db->trans_status() === false){
					$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal diubah.<br /></div>' );
					echo "<script>window.location='".base_url()."student/profile/'</script>";
				}
				else{
					$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil diubah.<br /></div>' );
					echo "<script>window.location='".base_url()."student/profile/'</script>";
				}
			}
		}
	}
	public function password_setting(){
		$data['parent'] = '';
		$data['child'] = '';
		$data['grand_child'] = '';
		$data['data_profil'] = $this->Main_model->getSelectedData('student a', 'a.*,b.address,b.photo', array('a.user_id'=>$this->session->userdata('id'),'a.deleted'=>'0'), "",'','','',array(
			'table' => 'user_profile b',
			'on' => 'a.user_id=b.user_id',
			'pos' => 'left',
		))->result();
		$this->load->view('student/template/header',$data);
		$this->load->view('student/user_profile/password_setting',$data);
		$this->load->view('student/template/footer');
	}
	public function update_password(){
		$cek = $this->Main_model->getSelectedData('user a', 'a.*', array('a.id'=>$this->session->userdata('id'),'pass'=>$this->input->post('password'),'a.deleted'=>'0'))->result();
		if($cek!=NULL){
			$this->db->trans_start();
			$where = array('id'=>$this->session->userdata('id'));
			$data = array('pass'=>$this->input->post('password_new'));
			$this->Main_model->updateData('user',$data,$where);

			$this->Main_model->log_activity($this->session->userdata('id'),'Updating data',"Updating password account");
			$this->db->trans_complete();
			if($this->db->trans_status() === false){
				$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal diubah.<br /></div>' );
				echo "<script>window.location='".base_url()."student/password_setting/'</script>";
			}
			else{
				$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil diubah.<br /></div>' );
				echo "<script>window.location='".base_url()."student/password_setting/'</script>";
			}
		}
		else{
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>Password yang Anda masukkan tidak valid.<br /></div>' );
			redirect('student/password_setting');
		}
	}
	public function email_setting(){
		$data['parent'] = '';
		$data['child'] = '';
		$data['grand_child'] = '';
		$data['data_profil'] = $this->Main_model->getSelectedData('student a', 'a.*,b.address,b.photo', array('a.user_id'=>$this->session->userdata('id'),'a.deleted'=>'0'), "",'','','',array(
			'table' => 'user_profile b',
			'on' => 'a.user_id=b.user_id',
			'pos' => 'left',
		))->result();
		$this->load->view('student/template/header',$data);
		$this->load->view('student/user_profile/email_setting',$data);
		$this->load->view('student/template/footer');
	}
	public function update_email(){
		$cek = $this->Main_model->getSelectedData('user a', 'a.*', array('a.id'=>$this->session->userdata('id'),'a.pass'=>$this->input->post('pass'),'a.deleted'=>'0'))->result();
		if($cek!=NULL){
			if($this->input->post('email')==$this->input->post('email_new')){
				$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Tidak ada perubahan!.<br /></div>' );
				redirect('student/email_setting');
			}else{
				$where = array('user_id'=>$this->session->userdata('id'));
				$data = array('email'=>$this->input->post('email_new'));
				$cek2 = $this->Main_model->getSelectedData('student a', 'a.*', array('a.email'=>$this->input->post('email_new')))->result();
				if(empty($cek2)){
					$this->Main_model->updateData('student',$data,$where);

					$this->Main_model->log_activity($this->session->userdata('id'),'Updating data',"Updating email user");

					$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>Email telah berhasil diubah.<br /></div>' );
					redirect('student/email_setting');
				}
				else{
					$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>Email yang Anda masukkan sudah digunakan.<br /></div>' );
					redirect('student/email_setting');
				}
			}
		}
		else{
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>Password yang Anda masukkan tidak valid.<br /></div>' );
			redirect('student/email_setting');
		}
	}
}