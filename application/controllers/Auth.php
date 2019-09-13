<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function login()
	{
		if(($this->session->userdata('id'))==NULL){
			$this->load->view('auth/login');
		}else{
			$cek = $this->Main_model->getSelectedData('user_to_role a', 'b.route', array('a.user_id'=>$this->session->userdata('id'),'b.deleted'=>'0'), "",'','','',array(
				'table' => 'user_role b',
				'on' => 'a.role_id=b.id',
				'pos' => 'left',
			))->result();
			if($cek!=NULL){
				foreach ($cek as $key => $value) {
					redirect($value->route);
				}
			}
			else{
				$this->load->view('auth/login');
			}
		}
	}
	public function login_process(){
		$cek = $this->Main_model->getSelectedData('user a', '*', array("a.username" => $this->input->post('username'), "a.is_active" => '1', 'a.deleted' => '0'), 'a.username ASC')->result();
		if($cek!=NULL){
			$cek2 = $this->Main_model->getSelectedData('user a', '*', array("a.username" => $this->input->post('username'),'a.pass' => $this->input->post('password'), "a.is_active" => '1', 'a.deleted' => '0'), 'a.username ASC','','','','')->result();
			if($cek2!=NULL){
				foreach ($cek as $key => $value) {
					$total_login = ($value->total_login)+1;
					$login_attempts = ($value->login_attempts)+1;
					$data_log = array(
						'total_login' => $total_login,
						'last_login' => date('Y-m-d H-i-s'),
						'last_activity' => date('Y-m-d H-i-s'),
						'login_attempts' => $login_attempts,
						'last_login_attempt' => date('Y-m-d H-i-s'),
						'ip_address' => $this->input->ip_address()
					);
					$this->Main_model->updateData('user',$data_log,array('id'=>$value->id));
					$this->Main_model->log_activity($value->id,'Login to system','Login via web browser',$this->input->post('location'));
					$role = $this->Main_model->getSelectedData('user_to_role a', 'b.route,a.user_id', array('a.user_id'=>$value->id,'b.deleted'=>'0'), "",'','','',array(
						'table' => 'user_role b',
						'on' => 'a.role_id=b.id',
						'pos' => 'left',
					))->result();
					if($role==NULL){
						$this->session->set_flashdata('error','<div class="alert alert-danger alert-dismissible" role="alert" style="text-align: justify;">
															<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
															<strong>Ups! </strong>Your account is not recognized by the system.
														</div>' );
						echo "<script>window.location='".base_url()."'</script>";
					}else{
						foreach ($role as $key => $value2) {
							$sess_data['id'] = $value2->user_id;
							$sess_data['location'] = $this->input->post('location');
							$this->session->set_userdata($sess_data);
							redirect($value2->route);
						}
					}
				}
			}else{
				foreach ($cek as $key => $value) {
					$login_attempts = ($value->login_attempts)+1;
					$data_log = array(
						'login_attempts' => $login_attempts,
						'last_login_attempt' => date('Y-m-d H-i-s')
					);
					$this->Main_model->updateData('user',$data_log,array('id'=>$value->id));
					$this->session->set_flashdata('error','<div class="alert alert-danger alert-dismissible" role="alert" style="text-align: justify;">
													<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
													<strong>Ups! </strong>Your password is invalid.
												</div>' );
					echo "<script>window.location='".base_url()."'</script>";
				}
			}
		}
		else{
			$this->session->set_flashdata('error','<div class="alert alert-danger alert-dismissible" role="alert" style="text-align: justify;">
											<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											<strong>Ups! </strong>The username/ email you entered is not registered.
										</div>' );
			echo "<script>window.location='".base_url()."'</script>";
		}
	}
	public function registration()
	{
		if(($this->session->userdata('id'))==NULL){
			$data['data_sekolah'] = $this->Main_model->getSelectedData('school a', 'a.*')->result();
			$this->load->view('auth/register',$data);
		}else{
			$cek = $this->Main_model->getSelectedData('user_to_role a', 'b.route', array('a.user_id'=>$this->session->userdata('id'),'b.deleted'=>'0'), "",'','','',array(
				'table' => 'user_role b',
				'on' => 'a.role_id=b.id',
				'pos' => 'left',
			))->result();
			if($cek!=NULL){
				foreach ($cek as $key => $value) {
					redirect($value->route);
				}
			}
			else{
				$data['data_sekolah'] = $this->Main_model->getSelectedData('school a', 'a.*')->result();
				$this->load->view('auth/register',$data);
			}
		}
	}
	public function register_process(){
		$cek_passcode = $this->Main_model->getSelectedData('user_to_role a', 'a.*', array("a.role_id" => '1','b.passcode' => $this->input->post('passcode')),'','','','',array(
			'table' => 'user_profile b',
			'on' => 'a.user_id=b.user_id',
			'pos' => 'left',
		))->result();
		if($cek_passcode==NULL){
			$this->session->set_flashdata('error','<div class="alert alert-danger alert-dismissible" role="alert" style="text-align: justify;">
											<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											<strong>Ups! </strong>The passcode you entered is invalid.
										</div>' );
			echo "<script>window.location='".base_url('registrasi')."'</script>";
		}else{
			$cek = $this->Main_model->getSelectedData('student a', 'a.*', array("a.fullname" => $this->input->post('fullname'),'a.mother' => $this->input->post('mother')))->result();
			if($cek!=NULL){
				$this->session->set_flashdata('error','
				<div class="alert alert-danger alert-dismissible" role="alert" style="text-align: justify;">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<strong>Ups! </strong>This account has already been used.
				</div>' );
				echo "<script>window.location='".base_url('registrasi')."'</script>";
			}
			else{
				$this->db->trans_start();
				$user_id = $this->Main_model->getLastID('user','id');

				$data1 = array(
							'id' => $user_id['id']+1,
							'username' => $this->input->post('fullname'),
							'pass' => $this->input->post('mother'),
							'total_login' => '1',
							'last_login' => date('Y-m-d H-i-s'),
							'last_activity' => date('Y-m-d H-i-s'),
							'login_attempts' => '1',
							'last_login_attempt' => date('Y-m-d H-i-s'),
							'ip_address' => $this->input->ip_address(),
							'is_active' => '1',
							'created_at' => date('Y-m-d H:i:s'),
							'created_by' => $user_id['id']+1
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

				// $get_student_id = $this->Main_model->getSelectedData('student a', 'a.*', array("a.school" => $this->input->post('school')),'a.student_id DESC','1')->row();
				// $student_id = '';
				// if($get_student_id==NULL){
				// 	$student_id = '1'.$this->input->post('school').'001';
				// }else{
				// 	$student_id = (substr($get_student_id->student_id,-3))+1;}

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
					'student_id' => $tampil_student_id,
					'user_id' => $user_id['id']+1,
					'fullname' => $this->input->post('fullname'),
					'mother' => $this->input->post('mother'),
					'number_phone' => $this->input->post('number_phone'),
					'mother_phone' => $this->input->post('mother_phone'),
					'email' => $this->input->post('email'),
					'school' => $this->input->post('school'),
					'class' => $this->input->post('class'),
					'passcode' => $this->input->post('passcode')
				);
				// print_r($data4);
				$this->Main_model->insertData('student',$data4);

				$expired_date = date('Y-m-d', strtotime('+14 days', strtotime(date('Y-m-d'))));
				$data5 = array(
					'user_id' => $user_id['id']+1,
					'quota' => 'Unlimited',
					'expired_date' => $expired_date
				);
				// print_r($data5);
				$this->Main_model->insertData('status',$data5);

				$data6 = array(
					'user_id' => $user_id['id']+1,
					'quota' => 'Unlimited',
					'expired_date' => $expired_date
				);
				// print_r($data6);
				$this->Main_model->insertData('cache',$data6);

				$this->Main_model->log_activity($user_id['id']+1,'Registration new account',"Creating student data (".$this->input->post('fullname').")");
				$this->db->trans_complete();
				if($this->db->trans_status() === false){
					$this->session->set_flashdata('error','<div class="alert alert-danger alert-dismissible" role="alert" style="text-align: justify;">
												<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
												<strong>Ups! </strong>Registration failed.
											</div>' );
					echo "<script>window.location='".base_url('registrasi')."'</script>";
				}
				else{
					// $this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>Selamat bergabung, dan nikmati <b>Free Trial</b> selama <b>14 Hari</b>.<br /></div>' );
					// echo "<script>window.location='".base_url()."student/beranda/'</script>";
					$role = $this->Main_model->getSelectedData('user_to_role a', 'b.route,a.user_id', array('a.user_id'=>$user_id['id']+1,'b.deleted'=>'0'), "",'','','',array(
						'table' => 'user_role b',
						'on' => 'a.role_id=b.id',
						'pos' => 'left',
					))->result();
					if($role==NULL){
						$this->session->set_flashdata('error','<div class="alert alert-danger alert-dismissible" role="alert" style="text-align: justify;">
															<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
															<strong>Ups! </strong>Your account is not recognized by the system.
														</div>' );
						echo "<script>window.location='".base_url()."'</script>";
					}else{
						foreach ($role as $key => $value2) {
							$sess_data['id'] = $value2->user_id;
							$this->session->set_userdata($sess_data);
							redirect($value2->route);
						}
					}
				}
			}
		}
	}
	public function logout(){
		$this->session->sess_destroy();
		echo "<script>window.location='".base_url()."'</script>";
	}
	public function forget_password() {
		$q1 = "SELECT a.*,b.fullname FROM user a LEFT JOIN user_profile b ON a.id=b.user_id WHERE a.email='".$this->input->post('email')."' AND a.deleted='0'";
		$cek = $this->Main_model->manualQuery($q1);
		if($cek==NULL){
			$this->session->set_flashdata('error','<div class="alert alert-danger alert-dismissible" role="alert" style="text-align: justify;">
													<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
													<strong>Ups! </strong>Email not registered.
												</div>' );
			echo "<script>window.location='".base_url()."'</script>";
		}
		else{
			foreach ($cek as $key => $value) {
			// PHPMailer
			// require_once(APPPATH.'libraries/PHPMailerAutoload.php');

			// $mail = new PHPMailer;

			// $mail->isSMTP();
			// $mail->Host = 'webmail.hostinger.co.id';
			// $mail->SMTPAuth = true;
			// $mail->Username = 'support.gbnku.co.id';
			// $mail->Password = 'Ms@xLoUV9T#J';

			// $mail->SMTPSecure = 'TLS';
			// $mail->Port = 25; //port tidak usah di ubah, biarkan 587
			// //$mail->SMTPDebug = 2;

			// $mail->setFrom('support@gbnku.co.id', 'PT. Gita Bhakti Negeri');
			// $mail->addAddress($value->email, $value->fullname);
			// //$mail->addReplyTo('indoguardsmg@gmail.com', 'apa');
			// $mail->isHTML(true);

			// $mail->Subject = 'Lupa Kata Sandi';
			// $mail->Body    = '<p>Berikut adalah data akun Anda</p>
			// 				<p>Username : '.$value->email.'<br>Password : '.$value->password.'</p><p>Silahkan login kembali di sistem.</p>';
			// $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

			// if(!$mail->send()) {
			// 	echo 'Pesan gagal dikirim.';
			// 	echo 'Kirim Pesan Error: ' . $mail->ErrorInfo;
			// } else {
			// 	echo "<script>alert('Pesan telah dikirim. Silahkan cek di Folder Kotak Masuk (Inbox) atau Spam')</script>";
			// 	echo "<script>window.location='".base_url()."'</script>";
			// }
			// Biasa
			$to = $value->email;
			$dari = "support@gbnku.co.id";
			$pesan = '<p>Berikut adalah data akun Anda</p>
			<p>Username : '.$value->email.'<br>Password : '.$value->password.'</p><p>Silahkan login kembali di sistem.</p>';

			ini_set( 'display_errors', 1 );
			error_reporting( E_ALL );
			$headers = "From:" . $dari;
			$subjek = 'Lupa Kata Sandi';
			mail($to,$subjek,$pesan, $headers);
			echo "<script>alert('Pesan telah dikirim. Silahkan cek di Folder Kotak Masuk (Inbox) atau Spam')</script>";
			echo "<script>window.location='".base_url()."'</script>";
		}}
	}
}