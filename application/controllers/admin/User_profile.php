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
		$data['data_profil'] = $this->Main_model->getSelectedData('user_profile a', 'a.*', array('a.user_id'=>$this->session->userdata('id')))->result();
		$this->load->view('admin/template/header',$data);
		$this->load->view('admin/user_profile/profile',$data);
		$this->load->view('admin/template/footer');
	}
	public function update_profile(){
		$this->db->trans_start();
		$data2 = array(
			'fullname' => $this->input->post('fullname'),
			'passcode' => $this->input->post('passcode')
		);
		// print_r($data2);
		$this->Main_model->updateData('user_profile',$data2,array('user_id'=>$this->session->userdata('id')));

		$this->Main_model->log_activity($this->session->userdata('id'),'Updating profile data',"Updating admin data (".$this->input->post('fullname').")");
		$this->db->trans_complete();
		if($this->db->trans_status() === false){
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data failed to change.<br /></div>' );
			echo "<script>window.location='".base_url()."admin_side/profile/'</script>";
		}
		else{
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data has been successfully changed.<br /></div>' );
			echo "<script>window.location='".base_url()."admin_side/profile/'</script>";
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
				echo "<script>window.location='".base_url('admin_side/profile')."'</script>";
			}
			else
			{
				$this->db->trans_start();
				$gbr = $this->upload->data();

				$this->Main_model->updateData("user_profile",array('photo'=>$gbr['file_name']),array('user_id'=>$this->session->userdata('id'))); //akses model untuk menyimpan ke database

				$this->Main_model->log_activity($this->session->userdata('id'),'Updating data',"Updating profile photo");

				$this->db->trans_complete();
				if($this->db->trans_status() === false){
					$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data failed to change.<br /></div>' );
					echo "<script>window.location='".base_url()."admin_side/profile/'</script>";
				}
				else{
					$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data has been successfully changed.<br /></div>' );
					echo "<script>window.location='".base_url()."admin_side/profile/'</script>";
				}
			}
		}
	}
	public function password_setting(){
		$data['parent'] = '';
		$data['child'] = '';
		$data['grand_child'] = '';
		$data['data_profil'] = $this->Main_model->getSelectedData('user_profile a', 'a.*', array('a.user_id'=>$this->session->userdata('id')))->result();
		$this->load->view('admin/template/header',$data);
		$this->load->view('admin/user_profile/password_setting',$data);
		$this->load->view('admin/template/footer');
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
				$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data failed to change.<br /></div>' );
				echo "<script>window.location='".base_url()."admin_side/password_setting/'</script>";
			}
			else{
				$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data has been successfully changed.<br /></div>' );
				echo "<script>window.location='".base_url()."admin_side/password_setting/'</script>";
			}
		}
		else{
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>Password yang Anda masukkan tidak valid.<br /></div>' );
			redirect('admin_side/password_setting');
		}
	}
}