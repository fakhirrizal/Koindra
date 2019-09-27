<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {
	function __construct() {
		parent::__construct();
	}
	/* Presence */
	public function presence_data(){
		$data['parent'] = 'report';
		$data['child'] = 'presence';
		$data['grand_child'] = '';

		// if($this->input->post('start')=='' AND $this->input->post('end')==''){
		if($this->input->post('period')==''){
			// $data['data_tabel'] = $this->Main_model->getSelectedData('student a', 'a.*,(SELECT COUNT(b.presence_id) FROM presence b WHERE b.user_id=a.user_id) AS jumlah_kehadiran,q.quota', array('a.deleted'=>'0'), "a.fullname ASC",'','','',array(
			// 	'table' => 'status q',
			// 	'on' => 'a.user_id=q.user_id',
			// 	'pos' => 'left',
			// ))->result();
		}else{
			// $data['data_tabel'] = $this->Main_model->getSelectedData('student a', 'a.*,(SELECT COUNT(b.presence_id) FROM presence b WHERE b.user_id=a.user_id AND b.date between "'.$this->input->post('start').'" AND "'.$this->input->post('end').'") AS jumlah_kehadiran,q.quota', array('a.deleted'=>'0'), "a.fullname ASC",'','','',array(
			// 	'table' => 'status q',
			// 	'on' => 'a.user_id=q.user_id',
			// 	'pos' => 'left',
			// ))->result();
			$data['data_tabel'] = $this->Main_model->getSelectedData('student a', 'a.*', array('a.deleted'=>'0'), "a.fullname ASC")->result();
			$data['period'] = $this->input->post('period');
		}
		$data['siswa'] = $this->Main_model->getSelectedData('student a', 'a.*','','a.fullname ASC')->result();
		$this->load->view('admin/template/header',$data);
		$this->load->view('admin/report/presence_data',$data);
		$this->load->view('admin/template/footer');
	}
	public function presence_data_detail(){
		$data['parent'] = 'report';
		$data['child'] = 'presence';
		$data['grand_child'] = '';

		$data['riwayat_kehadiran'] = $this->Main_model->getSelectedData('presence a', 'a.*,b.fullname', array('md5(a.user_id)'=>$this->uri->segment(3)), "a.date DESC",'','','',array(
			'table' => 'user_profile b',
			'on' => 'a.user_id=b.user_id',
			'pos' => 'left',
		))->result_array();
		$this->load->view('admin/template/header',$data);
		$this->load->view('admin/report/presence_data_detail',$data);
		$this->load->view('admin/template/footer');
	}
	public function save_presence_data(){
		$this->db->trans_start();
		$datasimpan = array(
			'user_id'=>$this->input->post('user_id'),
			'date'=>$this->input->post('date'),
			'note'=>$this->input->post('note')
		);
		$this->Main_model->insertData('presence',$datasimpan);
		$this->Main_model->log_activity($this->session->userdata('id'),'Creating data',"Add attendance student data");
			$this->db->trans_complete();
			if($this->db->trans_status() === false){
				$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data failed to add.<br /></div>' );
				echo "<script>window.location='".base_url()."admin_side/laporan_kehadiran/'</script>";
			}
			else{
				$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data saved succesfully..<br /></div>' );
				echo "<script>window.location='".base_url()."admin_side/laporan_kehadiran/'</script>";
			}
	}
	public function import_presence_data(){
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
					$get_student_id = $this->Main_model->getSelectedData('student a', '*', array("a.student_id" => $row['A']))->row();
					$cek = $this->Main_model->getSelectedData('presence a', '*', array("a.user_id" => $get_student_id->user_id, "a.date" => $this->input->post('date')))->result();
					if($cek==NULL){
						if($row['C']=='1'){
							$datasimpan = array(
								'user_id'=>$get_student_id->user_id,
								'date'=>$this->input->post('date'),
								// 'come_in'=>$row['C'],
								// 'come_out'=>$row['D'],
								'note'=>$row['B']
							);
							$this->Main_model->insertData('presence',$datasimpan);
							$getquota = $this->Main_model->getSelectedData('status a', '*', array("a.user_id" => $get_student_id->user_id))->row();
							if($getquota->quota==NULL){
								// echo $getquota->user_id;
								echo'';
							}elseif($getquota->quota=='Unlimited'){
								echo'';
							}else{
								$this->Main_model->updateData('status',array('quota'=>($getquota->quota)-1),array('user_id'=>$get_student_id->user_id));}
						}else{
							echo'';
						}
					}
				}
				$numrow++;
			}
			$this->Main_model->log_activity($this->session->userdata('id'),'Importing data',"Import student attendance data");
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data has been uploaded successfully.<br /></div>' );
			echo "<script>window.location='".base_url()."admin_side/laporan_kehadiran/'</script>";
		}else{
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data failed to upload.<br /></div>' );
			echo "<script>window.location='".base_url()."admin_side/laporan_kehadiran/'</script>";
		}
	}
	public function update_presence_data(){
		$this->db->trans_start();
		$data1 = array(
			'date' => $this->input->post('date')
		);
		// print_r($data1);
		$this->Main_model->updateData('presence',$data1,array('md5(presence_id)'=>$this->input->post('presence_id')));
		$this->Main_model->log_activity($this->session->userdata('id'),'Updating data',"Updating attendance data",$this->session->userdata('location'));
		$this->db->trans_complete();
		if($this->db->trans_status() === false){
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data failed to change.<br /></div>' );
			echo "<script>window.location='".base_url()."admin_side/detail_data_kehadiran/".$this->input->post('user_id')."'</script>";
		}
		else{
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data has been successfully changed.<br /></div>' );
			echo "<script>window.location='".base_url()."admin_side/detail_data_kehadiran/".$this->input->post('user_id')."'</script>";
		}
	}
	public function delete_presence_data(){
		$this->db->trans_start();
		$id_siswa = '';
		$data = $this->Main_model->getSelectedData('presence a', 'a.*', array('md5(a.presence_id)'=>$this->uri->segment(3)))->row();
		$id_siswa = $data->user_id;
		$this->Main_model->deleteData('presence', array('md5(presence_id)'=>$this->uri->segment(3)));
		$this->db->trans_complete();
		if($this->db->trans_status() === false){
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>Data failed to delete.<br /></div>' );
			echo "<script>window.location='".base_url()."admin_side/detail_data_kehadiran/".md5($id_siswa)."'</script>";
		}
		else{
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>Data has been successfully deleted.<br /></div>' );
			echo "<script>window.location='".base_url()."admin_side/detail_data_kehadiran/".md5($id_siswa)."'</script>";
		}
	}
	public function ajax_function()
	{
		if($this->input->post('modul')=='modul_ubah_data_kehadiran'){
			$data = $this->Main_model->getSelectedData('presence a', 'a.*', array('md5(a.presence_id)'=>$this->input->post('id')))->row();
			echo'
				<form role="form" action="'.base_url()."admin_side/perbarui_data_kehadiran".'" method="post" enctype="multipart/form-data">
					<input type="hidden" name="user_id" value="'.md5($data->user_id).'">
					<input type="hidden" name="presence_id" value="'.md5($data->presence_id).'">
					<input type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'">
					<div class="modal-body">
						<div class="form-body">
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Date <span class="required"> * </span></label>
								<div class="col-md-10">
									<div class="input-icon">
										<input type="date" class="form-control" name="date" placeholder="Type something" value="'.$data->date.'" required>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Submit</button>
					</div>
				</form>
			';
		}
	}
}