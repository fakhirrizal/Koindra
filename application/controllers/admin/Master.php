<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master extends CI_Controller {
	function __construct() {
		parent::__construct();
	}
	/* Administrator */
	public function admin_data()
	{
		$data['parent'] = 'master';
		$data['child'] = 'administrator';
		$data['grand_child'] = '';
		$data['data_tabel'] = $this->Main_model->getSelectedData('user_to_role a', 'a.user_id,b.fullname,c.username,c.last_login', array('a.role_id'=>'1','c.is_active'=>'1','c.deleted'=>'0'), "b.fullname ASC",'','','',array(
		array(
			'table' => 'user_profile b',
			'on' => 'a.user_id=b.user_id',
			'pos' => 'left',
		),
		array(
			'table' => 'user c',
			'on' => 'a.user_id=c.id',
			'pos' => 'left',
		)))->result();
		$this->load->view('admin/template/header',$data);
		$this->load->view('admin/master/admin_data',$data);
		$this->load->view('admin/template/footer');
	}
	public function add_admin_data()
	{
		$data['parent'] = 'master';
		$data['child'] = 'administrator';
		$data['grand_child'] = '';
		$this->load->view('admin/template/header',$data);
		$this->load->view('admin/master/add_admin_data',$data);
		$this->load->view('admin/template/footer');
	}
	public function save_admin_data(){
		$check = $this->Main_model->getSelectedData('user a', 'a.*', array('a.username'=>$this->input->post('username')))->result();
		if($check==NULL){
			$this->db->trans_start();
			$user_id = $this->Main_model->getLastID('user','id');

			$data1 = array(
						'id' => $user_id['id']+1,
						'username' => $this->input->post('username'),
						'pass' => $this->input->post('password'),
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
				'role_id' => '1',
			);
			// print_r($data3);
			$this->Main_model->insertData('user_to_role',$data3);

			$this->Main_model->log_activity($this->session->userdata('id'),'Creating data',"Creating administrator data (".$this->input->post('fullname').")");
			$this->db->trans_complete();
			if($this->db->trans_status() === false){
				$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal ditambahkan.<br /></div>' );
				echo "<script>window.location='".base_url()."admin_side/tambah_data_admin/'</script>";
			}
			else{
				$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil ditambahkan.<br /></div>' );
				echo "<script>window.location='".base_url()."admin_side/administrator/'</script>";
			}
		}
		else{
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>Username ini tidak tersedia.<br /></div>' );
			echo "<script>window.location='".base_url()."admin_side/tambah_data_admin/'</script>";
		}
	}
	public function detail_admin_data()
	{
		$data['parent'] = 'master';
		$data['child'] = 'administrator';
		$data['grand_child'] = '';

		$data['data_utama'] =  $this->Main_model->getSelectedData('user_profile a', 'a.*,b.username', array('md5(a.user_id)'=>$this->uri->segment(3),'b.is_active'=>'1','b.deleted'=>'0'),'','','','',array(
			'table' => 'user b',
			'on' => 'a.user_id=b.id',
			'pos' => 'left',
		))->result();
		$data['log_activity'] = $this->Main_model->getSelectedData('activity_logs a', 'a.*', array('md5(a.user_id)'=>$this->uri->segment(3)),'a.activity_time DESC')->result();
		$this->load->view('admin/template/header',$data);
		$this->load->view('admin/master/detail_admin_data',$data);
		$this->load->view('admin/template/footer');
	}
	public function reset_password_admin_account(){
		$this->db->trans_start();
		$data = array(
					'pass' => '1234',
					'updated_by' => $this->session->userdata('id'),
					'updated_at' => date('Y-m-d H:i:s')
				);
		$this->Main_model->updateData('user',$data,array('md5(id)'=>$this->uri->segment(3)));

		$this->Main_model->log_activity($this->session->userdata('id'),'Updating data',"Reset password admin account");
		$this->db->trans_complete();
		if($this->db->trans_status() === false){
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal diubah.<br /></div>' );
			echo "<script>window.location='".base_url()."admin_side/administrator/'</script>";
		}
		else{
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil diubah.<br /></div>' );
			echo "<script>window.location='".base_url()."admin_side/administrator/'</script>";
		}
	}
	public function delete_admin_data(){
		$this->db->trans_start();
		$data_delete = array(
			'is_active' => '0',
			'deleted_by' => $this->session->userdata('id'),
			'deleted_at' => date('Y-m-d H:i:s'),
			'deleted' => '1'
		);
		$this->Main_model->updateData('user',$data_delete,array('md5(id)'=>$this->uri->segment(3)));

		$this->Main_model->log_activity($this->session->userdata('id'),'Deleting data',"Deleting admin data");
		$this->db->trans_complete();
		if($this->db->trans_status() === false){
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal dihapus.<br /></div>' );
			echo "<script>window.location='".base_url()."admin_side/administrator/'</script>";
		}
		else{
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil dihapus.<br /></div>' );
			echo "<script>window.location='".base_url()."admin_side/administrator/'</script>";
		}
	}
	/* School */
	public function school_data()
	{
		$data['parent'] = 'master';
		$data['child'] = 'school';
		$data['grand_child'] = '';
		$data['data_tabel'] = $this->Main_model->getSelectedData('school a', 'a.*,(SELECT COUNT(b.user_id) FROM student b WHERE b.school=a.school_code) AS total_student')->result();
		$this->load->view('admin/template/header',$data);
		$this->load->view('admin/master/school_data',$data);
		$this->load->view('admin/template/footer');
	}
	public function detail_school_data()
	{
		$data['parent'] = 'master';
		$data['child'] = 'school';
		$data['grand_child'] = '';

		$data['data_utama'] =  $this->Main_model->getSelectedData('student a', 'a.*,b.quota,b.expired_date', array('md5(a.user_id)'=>$this->uri->segment(3),'a.deleted'=>'0'), "",'','','',array(
			'table' => 'status b',
			'on' => 'a.user_id=b.user_id',
			'pos' => 'LEFT',
		))->result();
		$data['data_utama'] = $this->Main_model->getSelectedData('school a', 'a.*', array('md5(a.school_code)'=>$this->uri->segment(3)))->result();
		$data['data_siswa'] = $this->Main_model->getSelectedData('status a', 'a.*,b.fullname', array('md5(b.school)'=>$this->uri->segment(3),'b.deleted'=>'0'),'','','','',array(
			'table' => 'student b',
			'on' => 'a.user_id=b.user_id',
			'pos' => 'RIGHT',
		))->result();
		$this->load->view('admin/template/header',$data);
		$this->load->view('admin/master/detail_school_data',$data);
		$this->load->view('admin/template/footer');
	}
	public function save_school_data(){
		$this->db->trans_start();
		$check_1 = $this->Main_model->getSelectedData('school a', 'a.*',array('a.school_code'=>$this->input->post('school_code')))->result();
		if($check_1==NULL){
			$check_2 = $this->Main_model->getSelectedData('school a', 'a.*',array('a.school_name'=>$this->input->post('school_name')))->result();
			if($check_2==NULL){
				$data1 = array(
					'school_code' => $this->input->post('school_code'),
					'school_name' => $this->input->post('school_name'),
					'address' => $this->input->post('address'),
					'number_phone' => $this->input->post('number_phone'),
				);
				// print_r($data1);
				$this->Main_model->insertData('school',$data1);
				$this->Main_model->log_activity($this->session->userdata('id'),'Creating data',"Creating school data (".$this->input->post('school_name').")");
				$this->db->trans_complete();
				if($this->db->trans_status() === false){
					$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal ditambahkan.<br /></div>' );
					echo "<script>window.location='".base_url()."admin_side/sekolah/'</script>";
				}
				else{
					$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil ditambahkan.<br /></div>' );
					echo "<script>window.location='".base_url()."admin_side/sekolah/'</script>";
				}
			}else{
				$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>nama sekolah tidak boleh sama.<br /></div>' );
				echo "<script>window.location='".base_url()."admin_side/sekolah/'</script>";
			}
		}else{
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>kode sekolah telah digunakan.<br /></div>' );
			echo "<script>window.location='".base_url()."admin_side/sekolah/'</script>";
		}
	}
	public function update_school_data(){
		$this->db->trans_start();
		$data1 = array(
			'school_code' => $this->input->post('school_code'),
			'school_name' => $this->input->post('school_name'),
			'address' => $this->input->post('address'),
			'number_phone' => $this->input->post('number_phone'),
		);
		// print_r($data1);
		$this->Main_model->updateData('school',$data1,array('school_id'=>$this->input->post('school_id')));
		$this->Main_model->log_activity($this->session->userdata('id'),'Updating data',"Updating school data (".$this->input->post('school_name').")");
		$this->db->trans_complete();
		if($this->db->trans_status() === false){
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal diubah.<br /></div>' );
			echo "<script>window.location='".base_url()."admin_side/sekolah/'</script>";
		}
		else{
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil diubah.<br /></div>' );
			echo "<script>window.location='".base_url()."admin_side/sekolah/'</script>";
		}
	}
	public function delete_school_data(){
		$this->db->trans_start();

		$this->Main_model->deleteData('school',array('md5(school_code)'=>$this->uri->segment(3)));

		$this->Main_model->log_activity($this->session->userdata('id'),'Deleting data',"Deleting school data");
		$this->db->trans_complete();
		if($this->db->trans_status() === false){
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal dihapus.<br /></div>' );
			echo "<script>window.location='".base_url()."admin_side/sekolah/'</script>";
		}
		else{
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil dihapus.<br /></div>' );
			echo "<script>window.location='".base_url()."admin_side/sekolah/'</script>";
		}
	}
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
		$data['data_sekolah'] = $this->Main_model->getSelectedData('school a', 'a.*')->result();
		$this->load->view('admin/template/header',$data);
		$this->load->view('admin/master/add_student_data',$data);
		$this->load->view('admin/template/footer');
	}
	public function save_student_data(){
		$this->db->trans_start();
		// $check = $this->Main_model->getSelectedData('student a', 'a.*',array('student_id'=>$this->input->post('student_id')))->result();
		$check = $this->Main_model->getSelectedData('user_to_role a', 'a.*', array("a.role_id" => '1','b.passcode' => $this->input->post('passcode')),'','','','',array(
			'table' => 'user_profile b',
			'on' => 'a.user_id=b.user_id',
			'pos' => 'left',
		))->result();
		if($check!=NULL){
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

			$get_student_id = $this->Main_model->getSelectedData('student a', 'a.*', '', 'a.student_id DESC','1')->row();
			$student_id = (substr($get_student_id->student_id,-3))+1;
			$jumlah_karakter = strlen($student_id);
			$tampil_student_id = '';
			if($jumlah_karakter=='1'){
				$tampil_student_id = '00'.$student_id;
			}elseif($jumlah_karakter=='2'){
				$tampil_student_id = '0'.$student_id;
			}elseif($jumlah_karakter=='3'){
				$tampil_student_id = $student_id;
			}else{
				echo'';
			}

			$data4 = array(
				// 'student_id' => $this->input->post('student_id'),
				'student_id' => $tampil_student_id,
				'user_id' => $user_id['id']+1,
				'fullname' => $this->input->post('fullname'),
				'mother' => $this->input->post('mother'),
				'number_phone' => $this->input->post('number_phone'),
				'mother_phone' => $this->input->post('mother_phone'),
				'email' => $this->input->post('email'),
				'school' => $this->input->post('school'),
				'class' => $this->input->post('class'),
				'passcode' => $this->input->post('passcode'),
				'status' => $this->input->post('status')
			);
			// print_r($data4);
			$this->Main_model->insertData('student',$data4);

			$data5 = array(
				'user_id' => $user_id['id']+1
			);
			// print_r($data5);
			$this->Main_model->insertData('status',$data5);

			$data6 = array(
				'user_id' => $user_id['id']+1
			);
			// print_r($data6);
			$this->Main_model->insertData('cache',$data6);

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
		}else{
			// $this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>No. Induk ini telah digunakan.<br /></div>' );
			// echo "<script>window.location='".base_url()."admin_side/tambah_data_siswa/'</script>";
			$this->session->set_flashdata('gagal','<div class="alert alert-danger alert-dismissible" role="alert" style="text-align: justify;">
											<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											<strong>Ups! </strong>Passcode yang Anda masukkan tidak valid.
										</div>' );
			echo "<script>window.location='".base_url()."admin_side/tambah_data_siswa/'</script>";
		}
	}
	public function import_student_data(){
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
					$check = $this->Main_model->getSelectedData('student a', 'a.*',array('student_id'=>$row['A']))->result();
					if($check==NULL){
						$user_id = $this->Main_model->getLastID('user','id');

						$data1 = array(
									'id' => $user_id['id']+1,
									'username' => $row['A'],
									'pass' => $row['A'],
									'total_login' => '1',
									'last_login' => date('Y-m-d H-i-s'),
									'last_activity' => date('Y-m-d H-i-s'),
									'login_attempts' => '1',
									'last_login_attempt' => date('Y-m-d H-i-s'),
									'is_active' => '1',
									'created_at' => date('Y-m-d H:i:s'),
									'created_by' => $this->session->userdata('id')
								);
						// print_r($data1);
						$this->Main_model->insertData('user',$data1);

						$data2 = array(
							'user_id' => $user_id['id']+1,
							'fullname' => $row['B'],
							'address' => $row['C']
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
							'student_id' => $row['A'],
							'user_id' => $user_id['id']+1,
							'fullname' => $row['B'],
							'mother' => $row['D'],
							'number_phone' => $row['E'],
							'mother_phone' => $row['F'],
							'email' => $row['G'],
							'school' => $row['H'],
							'class' => $row['I'],
							'passcode' => $row['J']
						);
						// print_r($data4);
						$this->Main_model->insertData('student',$data4);

						$data5 = array(
							'user_id' => $user_id['id']+1
						);
						// print_r($data5);
						$this->Main_model->insertData('status',$data5);
					}else{
						echo'';
					}
				}
				$numrow++;
			}
			$this->Main_model->log_activity($this->session->userdata('id'),'Importing data',"Import student data");
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil diupload.<br /></div>' );
			echo "<script>window.location='".base_url()."admin_side/siswa/'</script>";
		}else{
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal diupload.<br /></div>' );
			echo "<script>window.location='".base_url()."admin_side/siswa/'</script>";
		}
	}
	public function detail_student_data()
	{
		$data['parent'] = 'master';
		$data['child'] = 'student';
		$data['grand_child'] = '';

		$data['data_utama'] =  $this->Main_model->getSelectedData('student a', 'a.*,b.quota,b.expired_date,bb.school_name', array('md5(a.user_id)'=>$this->uri->segment(3),'a.deleted'=>'0'), "",'','','',array(
			array(
				'table' => 'status b',
				'on' => 'a.user_id=b.user_id',
				'pos' => 'LEFT'
			),
			array(
				'table' => 'school bb',
				'on' => 'a.school=bb.school_code',
				'pos' => 'LEFT'
			)
		))->result();
		$data['riwayat_pembayaran'] = $this->Main_model->getSelectedData('purchasing a', 'a.*', array('md5(a.user_id)'=>$this->uri->segment(3),'a.deleted'=>'0'))->result();
		$data['riwayat_kehadiran'] = $this->Main_model->getSelectedData('presence a', 'a.*', array('md5(a.user_id)'=>$this->uri->segment(3)), "a.date DESC")->result_array();
		$this->load->view('admin/template/header',$data);
		$this->load->view('admin/master/detail_student_data',$data);
		$this->load->view('admin/template/footer');
	}
	public function edit_student_data()
	{
		$data['parent'] = 'master';
		$data['child'] = 'student';
		$data['grand_child'] = '';
		$data['data_sekolah'] = $this->Main_model->getSelectedData('school a', 'a.*')->result();
		$data['data_utama'] = $this->Main_model->getSelectedData('student a', 'a.*', array('md5(a.user_id)'=>$this->uri->segment(3),'a.deleted'=>'0'))->result();
		$this->load->view('admin/template/header',$data);
		$this->load->view('admin/master/edit_student_data',$data);
		$this->load->view('admin/template/footer');
	}
	public function update_student_data(){
		$check = $this->Main_model->getSelectedData('student a', 'a.*','a.student_id="'.$this->input->post('student_id').'" AND md5(a.user_id) NOT IN ("'.$this->input->post('user_id').'")')->result();
		if($check==NULL){
			$this->db->trans_start();

			$data1 = array(
				'student_id' => $this->input->post('student_id'),
				'fullname' => $this->input->post('fullname'),
				'mother' => $this->input->post('mother'),
				'number_phone' => $this->input->post('number_phone'),
				'mother_phone' => $this->input->post('mother_phone'),
				'email' => $this->input->post('email'),
				'school' => $this->input->post('school'),
				'class' => $this->input->post('class'),
				'passcode' => $this->input->post('passcode'),
				'status' => $this->input->post('status')
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
		}else{
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>dupilcate Student ID.<br /></div>' );
			echo "<script>window.location='".base_url()."admin_side/ubah_data_siswa/".$this->input->post('user_id')."'</script>";
		}
	}
	public function update_status(){
		$this->db->trans_start();

		$data1 = array(
			'quota' => $this->input->post('quota'),
			'expired_date' => $this->input->post('expired_date')
		);
		$this->Main_model->updateData('status',$data1,array('user_id'=>$this->input->post('user_id')));

		$this->Main_model->log_activity($this->session->userdata('id'),'Updating data',"Updating status student (quota and expired date packet)");
		$this->db->trans_complete();
		if($this->db->trans_status() === false){
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal diubah.<br /></div>' );
			echo "<script>window.location='".base_url()."admin_side/detail_data_siswa/".md5($this->input->post('id'))."'</script>";
		}
		else{
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil diubah.<br /></div>' );
			echo "<script>window.location='".base_url()."admin_side/detail_data_siswa/".md5($this->input->post('id'))."'</script>";
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
	public function deleta(){
		$data1 = array(
			'invoice_number' => '317712818'
		);
		$this->Main_model->updateData('purchasing',$data1,array('invoice_number'=>'1448542463'));
	}
	public function send_notification(){
		$packet_id = $this->uri->segment(3);
		$user_id = $this->uri->segment(4);
		$data = $this->Main_model->getSelectedData('student a', 'a.*', array('md5(a.user_id)'=>$user_id))->row();

		$to = $data->email;
		$dari = "support@koindra.co.id";
		$pesan = '<p>Mengingatkan untuk memperbarui packet Anda karena akan memasuki masa tenggang.</p>';

		ini_set( 'display_errors', 1 );
		error_reporting( E_ALL );
		$headers = "From:" . $dari;
		$subjek = 'Pemberitahuan';
		mail($to,$subjek,$pesan, $headers);

		$this->Main_model->log_activity($this->session->userdata('id'),'Send notification',"Send notification to ".$data->fullname);
		$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>silahkan cek inbox ataupun spam email.<br /></div>' );
		echo "<script>window.location='".base_url()."admin_side/detail_data_paket/".$packet_id."'</script>";
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
			// 'expired_date' => $this->input->post('expired_date'),
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
		// SELECT a.*,b.fullname FROM status a LEFT JOIN student b ON a.user_id=b.user_id WHERE a.last_packet='1' AND a.expired_date>='2019-07-25'
		$data['data_pengguna_aktif'] = $this->Main_model->getSelectedData('status a', 'a.*,b.fullname', array('md5(a.last_packet)'=>$this->uri->segment(3),'a.expired_date>='=>date('Y-m-d'),'b.deleted'=>'0'),'','','','',array(
			'table' => 'student b',
			'on' => 'a.user_id=b.user_id',
			'pos' => 'left',
		))->result();
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
			// 'expired_date' => $this->input->post('expired_date'),
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
			$data['data_detail'] = $this->Main_model->getSelectedData('purchasing_detail a', 'a.*,b.packet_name', array('md5(a.purchasing_id)'=>$this->input->post('id')), "",'','','',array(
				'table' => 'packet b',
				'on' => 'a.product_id=b.packet_id',
				'pos' => 'left'
			))->result();
			$data['data_utama'] = $this->Main_model->getSelectedData('purchasing a', 'a.*', array('md5(a.purchasing_id)'=>$this->input->post('id'),'a.deleted'=>'0'))->row_array();
			$this->load->view('admin/master/ajax_detail_purchasing',$data);
		}elseif($this->input->post('modul')=='modul_ubah_data_quota_dan_masa_aktif'){
			$data['data_utama'] = $this->Main_model->getSelectedData('status a', 'a.*', array('a.user_id'=>$this->input->post('id')))->row();
			$this->load->view('admin/master/ajax_ubah_data_quota_dan_masa_aktif',$data);
		}elseif($this->input->post('modul')=='modul_ubah_data_sekolah'){
			$data['data_utama'] = $this->Main_model->getSelectedData('school a', 'a.*', array('md5(a.school_code)'=>$this->input->post('id')))->result();
			$this->load->view('admin/master/ajax_ubah_data_sekolah',$data);
		}
	}
}