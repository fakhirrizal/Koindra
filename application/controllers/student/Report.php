<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {
	function __construct() {
		parent::__construct();
	}
	public function presence_data(){
		$data['parent'] = 'report';
		$data['child'] = 'presence';
		$data['grand_child'] = '';

		$data['riwayat_kehadiran'] = $this->Main_model->getSelectedData('presence a', 'a.*', array('a.user_id'=>$this->session->userdata('id')), "a.date DESC")->result_array();
		$this->load->view('student/template/header',$data);
		$this->load->view('student/report/presence_data',$data);
		$this->load->view('student/template/footer');
	}
}