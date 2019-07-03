<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master extends CI_Controller {
    function __construct() {
        parent::__construct();
	}
	/* Administrator */
    public function patient()
	{
		$data['parent'] = 'master';
		$data['child'] = 'patient';
		$data['grand_child'] = '';
		$q = "SELECT a.* FROM patient a WHERE a.deleted='0'";
		$data['data_tabel'] = $this->Main_model->manualQuery($q);
		$this->load->view('admin/template/header',$data);
		$this->load->view('admin/master/patient_data',$data);
		$this->load->view('admin/template/footer');
	}
	public function detail_patient_data()
	{
		$data['parent'] = 'master';
		$data['child'] = 'patient';
		$data['grand_child'] = '';
		$q0 = "SELECT a.* FROM patient a WHERE a.id='".$this->uri->segment(3)."'";
		$data['data_utama'] = $this->Main_model->manualQuery($q0);
		$q = "SELECT b.fullname,c.job_name,a.note,a.created_at FROM monitoring a LEFT JOIN user_profile b ON a.user_id=b.user_id LEFT JOIN job c ON a.job_id=c.id WHERE a.patient_id='".$this->uri->segment(3)."' AND a.deleted='0' ORDER BY `a`.`created_at` DESC";
		$data['data_tabel'] = $this->Main_model->manualQuery($q);
		$this->load->view('admin/template/header',$data);
		$this->load->view('admin/master/detail_patient_data',$data);
		$this->load->view('admin/template/footer');
	}
	public function delete_patient_data(){
		$this->db->trans_start();
		$where1['id'] = $this->uri->segment(3);
		$data = array(
					'deleted' => '1'
				);
		$this->Main_model->updateData('patient',$data,$where1);
		$this->db->trans_complete();
		if($this->db->trans_status() === false){
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal dihapus.<br /></div>' );
            echo "<script>window.location='".base_url()."admin_side/pasien/'</script>";
		}
		else{
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil dihapus.<br /></div>' );
            echo "<script>window.location='".base_url()."admin_side/pasien/'</script>";
		}
	}
	// public function add_patient_data()
	// {
	// 	$data['parent'] = 'master';
	// 	$data['child'] = 'member';
	// 	$this->load->view('admin/template/header',$data);
	// 	$this->load->view('admin/master/form_input_member_data',$data);
	// 	$this->load->view('admin/template/footer');
	// }
	public function save_patient_data(){
		$photo = '';
		$reference_id = '';
		$reference = $this->Main_model->getLastID('patient');
		if($reference==NULL){
			$reference_id = 1;
		}
		else{
			foreach ($reference as $key => $value) {
				$reference_id = ($value->id)+1;
			}
		}
		// $nmfile = "file_".time();
		// $config['upload_path'] = dirname($_SERVER["SCRIPT_FILENAME"]).'/assets/foto_profil/';
		// $config['allowed_types'] = 'jpg|png|jpeg|bmp';
		// $config['max_size'] = '3072';
		// $config['max_width']  = '5000';
		// $config['max_height']  = '5000';
		// $config['file_name'] = $nmfile;

		// $this->upload->initialize($config);

		// if(isset($_FILES['foto']['name']))
		// {
		// 	if(!$this->upload->do_upload('foto'))
		// 	{
		// 		echo '';
		// 	}
		// 	else
		// 	{
		// 		$gbr = $this->upload->data();
		// 		$photo = $gbr['file_name'];
		// 	}
		// }
		$q = "SELECT a.* FROM patient a WHERE a.id_number='".$this->input->post('nik')."'";
		$check = $this->Main_model->manualQuery($q);
		if($check==NULL){
			$this->db->trans_start();
			$data1 = array(
						'id' => $reference_id,
						'id_number' => $this->input->post('nik'),
						'name' => $this->input->post('fullname'),
						'address' => $this->input->post('address'),
						'number_phone' => $this->input->post('phone'),
						'created_by' => $this->session->userdata('id')
			);
			$this->Main_model->insertData('patient',$data1);
			$this->db->trans_complete();
			if($this->db->trans_status() === false){
				$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal ditambahkan.<br /></div>' );
				echo "<script>window.location='".base_url()."admin_side/pasien/'</script>";
			}
			else{
				$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil ditambahkan.<br /></div>' );
				echo "<script>window.location='".base_url()."admin_side/pasien/'</script>";
			}
		}else{
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal ditambahkan, NIK sudah terdaftar.<br /></div>' );
			echo "<script>window.location='".base_url()."admin_side/pasien/'</script>";
		}
	}
	public function update_patient_data(){
		$q = "SELECT a.* FROM patient a WHERE a.id_number='".$this->input->post('nik')."'";
		$check = $this->Main_model->manualQuery($q);
		if($check==NULL){
			$where['id'] = $this->input->post('id');
			$this->db->trans_start();
			$data = array(
				'id_number' => $this->input->post('nik'),
				'name' => $this->input->post('fullname'),
				'address' => $this->input->post('address'),
				'number_phone' => $this->input->post('phone'),
				'updated_by' => $this->session->userdata('id'),
				'updated_at' => date('Y-m-d H-i-s')
			);
			$this->Main_model->updateData('patient',$data,$where);
			$this->db->trans_complete();
			if($this->db->trans_status() === false){
				$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal diubah.<br /></div>' );
				echo "<script>window.location='".base_url()."admin_side/pasien/'</script>";
			}
			else{
				$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil diubah.<br /></div>' );
				echo "<script>window.location='".base_url()."admin_side/pasien/'</script>";
			}
		}else{
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal diubah, NIK sudah terdaftar.<br /></div>' );
			echo "<script>window.location='".base_url()."admin_side/pasien/'</script>";
		}
	}
	// public function update_patient_photo(){
	// 	$where['user_id'] = $this->input->post('id');
	// 	$photo = '';
	// 	$this->db->trans_start();
	// 	$nmfile = "file_".time();
	// 	$config['upload_path'] = dirname($_SERVER["SCRIPT_FILENAME"]).'/assets/foto_profil/';
	// 	$config['allowed_types'] = 'jpg|png|jpeg|bmp';
	// 	$config['max_size'] = '3072';
	// 	$config['max_width']  = '5000';
	// 	$config['max_height']  = '5000';
	// 	$config['file_name'] = $nmfile;

	// 	$this->upload->initialize($config);

	// 	if(isset($_FILES['foto']['name']))
	// 	{
	// 		if(!$this->upload->do_upload('foto'))
	// 		{
	// 			echo '';
	// 		}
	// 		else
	// 		{
	// 			$gbr = $this->upload->data();
	// 			$photo = $gbr['file_name'];
	// 		}
	// 	}
	// 	$data = array(
	// 		'photo' => $photo,
	// 		'updated_by' => $this->session->userdata('id'),
	// 		'updated_at' => date('Y-m-d H-i-s')
	// 	);
	// 	$this->Main_model->updateData('user_profile',$data,$where);
	// 	$this->db->trans_complete();
	// 	if($this->db->trans_status() === false){
	// 		$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal diubah.<br /></div>' );
	// 		echo "<script>window.location='".base_url()."admin_side/detail_data_radiografer/".$this->input->post('id')."'</script>";
	// 	}
	// 	else{
	// 		$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil diubah.<br /></div>' );
	// 		echo "<script>window.location='".base_url()."admin_side/detail_data_radiografer/".$this->input->post('id')."'</script>";
	// 	}
	// }
	public function ajax_patient(){
		$id = $this->input->post('id');
		$modul = $this->input->post('modul');
		if($modul=='modul_ubah_data'){
			$q = "SELECT a.* FROM patient a WHERE a.id='".$id."' AND a.deleted='0'";
			$data['data_ajax'] = $this->Main_model->manualQuery($q);
			$this->load->view('admin/master/ajax_ubah_data_pasien',$data);
		}
		// elseif($modul=='modul_ubah_foto'){
		// 	$q = "SELECT b.* FROM user a LEFT JOIN user_profile b ON a.id=b.user_id WHERE a.id='".$id."' AND a.role='radiografer' AND a.deleted='0'";
		// 	$data['data_ajax'] = $this->Main_model->manualQuery($q);
		// 	$this->load->view('admin/master/ajax_ubah_foto_radiografer',$data);
		// }
	}
	/* Employee aka Radiografer */
    public function employee()
	{
		$data['parent'] = 'master';
		$data['child'] = 'employee';
		$data['grand_child'] = '';
		$q = "SELECT b.* FROM user a LEFT JOIN user_profile b ON a.id=b.user_id WHERE a.role='radiografer' AND a.deleted='0'";
		$data['data_tabel'] = $this->Main_model->manualQuery($q);
		$this->load->view('admin/template/header',$data);
		$this->load->view('admin/master/employee_data',$data);
		$this->load->view('admin/template/footer');
	}
	public function detail_employee_data()
	{
		$data['parent'] = 'master';
		$data['child'] = 'employee';
		$data['grand_child'] = '';
		$q = "SELECT a.email,b.* FROM user a LEFT JOIN user_profile b ON a.id=b.user_id WHERE a.id='".$this->uri->segment(3)."' AND a.role='radiografer' AND a.deleted='0'";
		$data['data_tabel'] = $this->Main_model->manualQuery($q);
		$this->load->view('admin/template/header',$data);
		$this->load->view('admin/master/detail_employee_data',$data);
		$this->load->view('admin/template/footer');
	}
	public function delete_employee_data(){
		$this->db->trans_start();
		$where1['id'] = $this->uri->segment(3);
		$where2['user_id'] = $this->uri->segment(3);
		$data = array(
					'deleted' => '1'
				);
		$this->Main_model->updateData('user',$data,$where1);
		$this->Main_model->updateData('user_profile',$data,$where2);
		$this->db->trans_complete();
		if($this->db->trans_status() === false){
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal dihapus.<br /></div>' );
            echo "<script>window.location='".base_url()."admin_side/radiografer/'</script>";
		}
		else{
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil dihapus.<br /></div>' );
            echo "<script>window.location='".base_url()."admin_side/radiografer/'</script>";
		}
	}
	// public function add_employee_data()
	// {
	// 	$data['parent'] = 'master';
	// 	$data['child'] = 'member';
	// 	$this->load->view('admin/template/header',$data);
	// 	$this->load->view('admin/master/form_input_member_data',$data);
	// 	$this->load->view('admin/template/footer');
	// }
	public function save_employee_data(){
		$photo = '';
		$reference_id = '';
		$reference = $this->Main_model->getLastID('user');
		if($reference==NULL){
			$reference_id = 1;
		}
		else{
			foreach ($reference as $key => $value) {
				$reference_id = ($value->id)+1;
			}
		}
		$this->db->trans_start();
		$nmfile = "file_".time(); //nama file saya beri nama langsung dan diikuti fungsi time
		$config['upload_path'] = dirname($_SERVER["SCRIPT_FILENAME"]).'/assets/foto_profil/';
		$config['allowed_types'] = 'jpg|png|jpeg|bmp';
		$config['max_size'] = '3072';
		$config['max_width']  = '5000';
		$config['max_height']  = '5000';
		$config['file_name'] = $nmfile;

		$this->upload->initialize($config);

		if(isset($_FILES['foto']['name']))
		{
			if(!$this->upload->do_upload('foto'))
			{
				echo '';
			}
			else
			{
				$gbr = $this->upload->data();
				$photo = $gbr['file_name'];
			}
		}
		$data1 = array(
					'id' => $reference_id,
					'email' => $this->input->post('email'),
					'password' => $this->input->post('password'),
					'role' => 'radiografer',
					'created_by' => $this->session->userdata('id')
		);
		$data2 = array(
			'user_id' => $reference_id,
			'fullname' => $this->input->post('fullname'),
			'address' => $this->input->post('address'),
			'phone' => $this->input->post('phone'),
			'photo' => $photo,
			'created_by' => $this->session->userdata('id')
		);
		$this->Main_model->insertData('user',$data1);
		$this->Main_model->insertData('user_profile',$data2);
		$this->db->trans_complete();
		if($this->db->trans_status() === false){
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal ditambahkan.<br /></div>' );
			echo "<script>window.location='".base_url()."admin_side/radiografer/'</script>";
		}
		else{
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil ditambahkan.<br /></div>' );
			echo "<script>window.location='".base_url()."admin_side/radiografer/'</script>";
		}
	}
	public function reset_password_member_account(){
		$this->db->trans_start();
		$where['id'] = $this->uri->segment(3);
		$data = array(
					'password' => '1234',
					'updated_by' => $this->session->userdata('id'),
					'updated_at' => date('Y-m-d H-i-s')
				);
		$this->Main_model->updateData('user',$data,$where);
		$this->db->trans_complete();
		if($this->db->trans_status() === false){
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal diubah.<br /></div>' );
            echo "<script>window.location='".base_url()."admin_side/radiografer/'</script>";
		}
		else{
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil diubah.<br /></div>' );
            echo "<script>window.location='".base_url()."admin_side/radiografer/'</script>";
		}
	}
	public function update_employee_data(){
		$where1['user_id'] = $this->input->post('id');
		$where2['id'] = $this->input->post('id');
		$this->db->trans_start();
		$data1 = array(
			'fullname' => $this->input->post('fullname'),
			'address' => $this->input->post('address'),
			'phone' => $this->input->post('phone'),
			'updated_by' => $this->session->userdata('id'),
			'updated_at' => date('Y-m-d H-i-s')
		);
		$data2 = array(
			'email' => $this->input->post('email'),
			'updated_by' => $this->session->userdata('id'),
			'updated_at' => date('Y-m-d H-i-s')
		);
		$this->Main_model->updateData('user_profile',$data1,$where1);
		$this->Main_model->updateData('user',$data2,$where2);
		$this->db->trans_complete();
		if($this->db->trans_status() === false){
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal diubah.<br /></div>' );
			echo "<script>window.location='".base_url()."admin_side/radiografer/'</script>";
		}
		else{
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil diubah.<br /></div>' );
			echo "<script>window.location='".base_url()."admin_side/radiografer/'</script>";
		}
	}
	public function update_employee_photo(){
		$where['user_id'] = $this->input->post('id');
		$photo = '';
		$this->db->trans_start();
		$nmfile = "file_".time(); //nama file saya beri nama langsung dan diikuti fungsi time
		$config['upload_path'] = dirname($_SERVER["SCRIPT_FILENAME"]).'/assets/foto_profil/';
		$config['allowed_types'] = 'jpg|png|jpeg|bmp';
		$config['max_size'] = '3072';
		$config['max_width']  = '5000';
		$config['max_height']  = '5000';
		$config['file_name'] = $nmfile;

		$this->upload->initialize($config);

		if(isset($_FILES['foto']['name']))
		{
			if(!$this->upload->do_upload('foto'))
			{
				echo '';
			}
			else
			{
				$gbr = $this->upload->data();
				$photo = $gbr['file_name'];
			}
		}
		$data = array(
			'photo' => $photo,
			'updated_by' => $this->session->userdata('id'),
			'updated_at' => date('Y-m-d H-i-s')
		);
		$this->Main_model->updateData('user_profile',$data,$where);
		$this->db->trans_complete();
		if($this->db->trans_status() === false){
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal diubah.<br /></div>' );
			echo "<script>window.location='".base_url()."admin_side/detail_data_radiografer/".$this->input->post('id')."'</script>";
		}
		else{
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil diubah.<br /></div>' );
			echo "<script>window.location='".base_url()."admin_side/detail_data_radiografer/".$this->input->post('id')."'</script>";
		}
	}
	public function ajax_employee(){
		$id = $this->input->post('id');
		$modul = $this->input->post('modul');
		if($modul=='modul_ubah_data'){
			$q = "SELECT a.email,b.* FROM user a LEFT JOIN user_profile b ON a.id=b.user_id WHERE a.id='".$id."' AND a.role='radiografer' AND a.deleted='0'";
			$data['data_ajax'] = $this->Main_model->manualQuery($q);
			$this->load->view('admin/master/ajax_ubah_data_radiografer',$data);
		}
		elseif($modul=='modul_ubah_foto'){
			$q = "SELECT b.* FROM user a LEFT JOIN user_profile b ON a.id=b.user_id WHERE a.id='".$id."' AND a.role='radiografer' AND a.deleted='0'";
			$data['data_ajax'] = $this->Main_model->manualQuery($q);
			$this->load->view('admin/master/ajax_ubah_foto_radiografer',$data);
		}
	}
	/* Category aka Jenis Pemeriksaan */
	public function category()
	{
		$data['parent'] = 'master';
		$data['child'] = 'category';
		$data['grand_child'] = '';
		$q = "SELECT a.*,(SELECT COUNT(b.id) FROM job_type b WHERE b.category_id=a.id AND b.deleted='0') as job_type_total FROM category a WHERE a.deleted='0'";
		$data['data_tabel'] = $this->Main_model->manualQuery($q);
		$this->load->view('admin/template/header',$data);
		$this->load->view('admin/master/category',$data);
		$this->load->view('admin/template/footer');
	}
	public function save_category(){
		$reference_id = '';
		$reference = $this->Main_model->getLastID('category');
		if($reference==NULL){
			$reference_id = 1;
		}
		else{
			foreach ($reference as $key => $value) {
				$reference_id = ($value->id)+1;
			}
		}
		$this->db->trans_start();
		$data1 = array(
					'id' => $reference_id,
					'category' => $this->input->post('category'),
					'created_by' => $this->session->userdata('id')
		);
		$this->Main_model->insertData('category',$data1);
		$this->db->trans_complete();
		if($this->db->trans_status() === false){
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal ditambahkan.<br /></div>' );
			echo "<script>window.location='".base_url()."admin_side/jenis_pemeriksaan/'</script>";
		}
		else{
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil ditambahkan.<br /></div>' );
			echo "<script>window.location='".base_url()."admin_side/jenis_pemeriksaan/'</script>";
		}
	}
	public function update_category(){
		$where1['id'] = $this->input->post('id');
		$this->db->trans_start();
		$data1 = array(
			'category' => $this->input->post('category'),
			'updated_by' => $this->session->userdata('id'),
			'updated_at' => date('Y-m-d H-i-s')
		);
		$this->Main_model->updateData('category',$data1,$where1);
		$this->db->trans_complete();
		if($this->db->trans_status() === false){
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal diubah.<br /></div>' );
			echo "<script>window.location='".base_url()."admin_side/jenis_pemeriksaan/'</script>";
		}
		else{
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil diubah.<br /></div>' );
			echo "<script>window.location='".base_url()."admin_side/jenis_pemeriksaan/'</script>";
		}
	}
	public function ajax_category(){
		$id = $this->input->post('id');
		$modul = $this->input->post('modul');
		if($modul=='modul_ubah_data'){
			$q = "SELECT a.* FROM category a WHERE a.id='".$id."' AND a.deleted='0'";
			$data['data_ajax'] = $this->Main_model->manualQuery($q);
			$this->load->view('admin/master/ajax_ubah_jenis_pemeriksaan',$data);
		}
	}
	public function delete_category(){
		$this->db->trans_start();
		$where1['id'] = $this->uri->segment(3);
		$data = array(
					'deleted' => '1'
				);
		$this->Main_model->updateData('category',$data,$where1);
		$this->db->trans_complete();
		if($this->db->trans_status() === false){
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal dihapus.<br /></div>' );
            echo "<script>window.location='".base_url()."admin_side/jenis_pemeriksaan/'</script>";
		}
		else{
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil dihapus.<br /></div>' );
            echo "<script>window.location='".base_url()."admin_side/jenis_pemeriksaan/'</script>";
		}
	}
	/* Type of Job */
	public function type_of_job()
	{
		$data['parent'] = 'master';
		$data['child'] = 'job_type';
		$data['grand_child'] = '';
		$q = "SELECT a.*,b.category,(SELECT COUNT(c.id) FROM job c WHERE c.job_type_id=a.id AND c.deleted='0') as job_total FROM job_type a LEFT JOIN category b ON a.category_id=b.id WHERE a.deleted='0'";
		$data['data_tabel'] = $this->Main_model->manualQuery($q);
		$q2 = "SELECT a.* FROM category a WHERE a.deleted='0'";
		$data['category'] = $this->Main_model->manualQuery($q2);
		$this->load->view('admin/template/header',$data);
		$this->load->view('admin/master/type_of_job',$data);
		$this->load->view('admin/template/footer');
	}
	public function save_job_type(){
		$reference_id = '';
		$reference = $this->Main_model->getLastID('job_type');
		if($reference==NULL){
			$reference_id = 1;
		}
		else{
			foreach ($reference as $key => $value) {
				$reference_id = ($value->id)+1;
			}
		}
		$this->db->trans_start();
		$data1 = array(
					'id' => $reference_id,
					'category_id' => $this->input->post('category'),
					'job_type' => $this->input->post('job_type'),
					'created_by' => $this->session->userdata('id')
		);
		$this->Main_model->insertData('job_type',$data1);
		$this->db->trans_complete();
		if($this->db->trans_status() === false){
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal ditambahkan.<br /></div>' );
			echo "<script>window.location='".base_url()."admin_side/jenis_kegiatan/'</script>";
		}
		else{
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil ditambahkan.<br /></div>' );
			echo "<script>window.location='".base_url()."admin_side/jenis_kegiatan/'</script>";
		}
	}
	public function update_job_type(){
		$where1['id'] = $this->input->post('id');
		$this->db->trans_start();
		$data1 = array(
			'category_id' => $this->input->post('category'),
			'job_type' => $this->input->post('job_type'),
			'updated_by' => $this->session->userdata('id'),
			'updated_at' => date('Y-m-d H-i-s')
		);
		$this->Main_model->updateData('job_type',$data1,$where1);
		$this->db->trans_complete();
		if($this->db->trans_status() === false){
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal diubah.<br /></div>' );
			echo "<script>window.location='".base_url()."admin_side/jenis_kegiatan/'</script>";
		}
		else{
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil diubah.<br /></div>' );
			echo "<script>window.location='".base_url()."admin_side/jenis_kegiatan/'</script>";
		}
	}
	public function ajax_job_type(){
		$id = $this->input->post('id');
		$modul = $this->input->post('modul');
		if($modul=='modul_ubah_data'){
			$q = "SELECT a.* FROM job_type a WHERE a.id='".$id."' AND a.deleted='0'";
			$data['data_ajax'] = $this->Main_model->manualQuery($q);
			$q2 = "SELECT a.* FROM category a WHERE a.deleted='0'";
			$data['data_kategori'] = $this->Main_model->manualQuery($q2);
			$this->load->view('admin/master/ajax_ubah_jenis_kegiatan',$data);
		}
	}
	public function delete_type_of_job(){
		$this->db->trans_start();
		$where1['id'] = $this->uri->segment(3);
		$data = array(
					'deleted' => '1'
				);
		$this->Main_model->updateData('job_type',$data,$where1);
		$this->db->trans_complete();
		if($this->db->trans_status() === false){
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal dihapus.<br /></div>' );
            echo "<script>window.location='".base_url()."admin_side/jenis_kegiatan/'</script>";
		}
		else{
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil dihapus.<br /></div>' );
            echo "<script>window.location='".base_url()."admin_side/jenis_kegiatan/'</script>";
		}
	}
	/* Job */
	public function job()
	{
		$data['parent'] = 'master';
		$data['child'] = 'job';
		$data['grand_child'] = '';
		$q = "SELECT a.*,b.job_type FROM job a LEFT JOIN job_type b ON a.job_type_id=b.id WHERE b.deleted='0' AND a.deleted='0'";
		$data['data_tabel'] = $this->Main_model->manualQuery($q);
		$q2 = "SELECT a.* FROM job_type a WHERE a.deleted='0'";
		$data['data_jenis'] = $this->Main_model->manualQuery($q2);
		$this->load->view('admin/template/header',$data);
		$this->load->view('admin/master/job',$data);
		$this->load->view('admin/template/footer');
	}
	public function save_job_data(){
		$reference_id = '';
		$reference = $this->Main_model->getLastID('job');
		if($reference==NULL){
			$reference_id = 1;
		}
		else{
			foreach ($reference as $key => $value) {
				$reference_id = ($value->id)+1;
			}
		}
		$this->db->trans_start();
		$data1 = array(
					'id' => $reference_id,
					'job_type_id' => $this->input->post('job_type'),
					'job_name' => $this->input->post('job_name'),
					'created_by' => $this->session->userdata('id')
		);
		$this->Main_model->insertData('job',$data1);
		$this->db->trans_complete();
		if($this->db->trans_status() === false){
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal ditambahkan.<br /></div>' );
			echo "<script>window.location='".base_url()."admin_side/kegiatan/'</script>";
		}
		else{
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil ditambahkan.<br /></div>' );
			echo "<script>window.location='".base_url()."admin_side/kegiatan/'</script>";
		}
	}
	public function update_job_data(){
		$where1['id'] = $this->input->post('id');
		$this->db->trans_start();
		$data1 = array(
			'job_type_id' => $this->input->post('job_type'),
			'job_name' => $this->input->post('job_name'),
			'updated_by' => $this->session->userdata('id'),
			'updated_at' => date('Y-m-d H-i-s')
		);
		$this->Main_model->updateData('job',$data1,$where1);
		$this->db->trans_complete();
		if($this->db->trans_status() === false){
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal diubah.<br /></div>' );
			echo "<script>window.location='".base_url()."admin_side/kegiatan/'</script>";
		}
		else{
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil diubah.<br /></div>' );
			echo "<script>window.location='".base_url()."admin_side/kegiatan/'</script>";
		}
	}
	public function ajax_job(){
		$id = $this->input->post('id');
		$modul = $this->input->post('modul');
		if($modul=='modul_ubah_data'){
			$q = "SELECT a.*,b.job_type FROM job a LEFT JOIN job_type b ON a.job_type_id=b.id WHERE a.id='".$id."' AND a.deleted='0'";
			$data['data_ajax'] = $this->Main_model->manualQuery($q);
			$q2 = "SELECT a.* FROM job_type a WHERE a.deleted='0'";
			$data['data_jenis'] = $this->Main_model->manualQuery($q2);
			$this->load->view('admin/master/ajax_ubah_data_kegiatan',$data);
		}
	}
	public function delete_job_data(){
		$this->db->trans_start();
		$where1['id'] = $this->uri->segment(3);
		$data = array(
					'deleted' => '1'
				);
		$this->Main_model->updateData('job',$data,$where1);
		$this->db->trans_complete();
		if($this->db->trans_status() === false){
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal dihapus.<br /></div>' );
            echo "<script>window.location='".base_url()."admin_side/kegiatan/'</script>";
		}
		else{
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil dihapus.<br /></div>' );
            echo "<script>window.location='".base_url()."admin_side/kegiatan/'</script>";
		}
	}
}