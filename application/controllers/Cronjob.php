<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cronjob extends CI_Controller {
	function __construct() {
		parent::__construct();
	}
	public function index(){
		$datrans = $this->Main_model->getSelectedData('purchasing a', 'a.*,b.fullname',array('a.status'=>'0'),'','','','',array(
			'table' => 'student b',
			'on' => 'a.user_id=b.user_id',
			'pos' => 'left',
		))->result();

		foreach ($datrans as $dt) {

			Veritrans_Config::$serverKey = "Mid-server-pj-mcbw3fEk36nTwvZr10lDn";
			// Uncomment for production environment
			Veritrans_Config::$isProduction = true;
			$order          = Veritrans_Transaction::status($dt->invoice_number);

			$status         = $order->transaction_status;

			if ($status == "settlement") {
				$stat = "1";
				$this->Main_model->log_activity($dt->user_id,'Transaction data',$dt->fullname." has been finish transaction with the Invoice Number <b>".$dt->invoice_number."</b>");
			} elseif ($status == "pending") {
				$stat = "0";
			} else {
				$stat = "2";
				$this->Main_model->log_activity($dt->user_id,'Transaction data',$dt->fullname." failed to complete the transaction with the Invoice Number <b>".$dt->invoice_number."</b>");
			}

			$data = array(
						'payment_type' => $order->payment_type,
						'status' => $stat
					);
			$ceks = $this->Main_model->updateData('purchasing',$data,array('purchasing_id'=>$dt->purchasing_id));
			// print_r($ceks);
			if($stat=='1'){
				$get_purchasing_detail = $this->Main_model->getSelectedData('purchasing_detail a', 'a.*',array('purchasing_id'=>$dt->purchasing_id))->result();
				foreach ($get_purchasing_detail as $key => $value) {
					$get_quota = $this->Main_model->getSelectedData('packet a', 'a.*', array('a.packet_id'=>$value->product_id))->row();
					$plus_month = "+".$get_quota->duration." months";
					$get_status_by_student_id = $this->Main_model->getSelectedData('status a', 'a.*,DATE_FORMAT(LAST_DAY(expired_date),"%d") AS end_of_month', array('a.user_id'=>$dt->user_id))->row();
					$result_of_date = '';
					if(substr($get_status_by_student_id->expired_date,-2)=='01'){
						$beginning_of_the_month = date('Y-m-d',strtotime($plus_month,strtotime($get_status_by_student_id->expired_date)));
						$result_of_date = date('Y-m-d', strtotime('-1 days', strtotime($beginning_of_the_month)));
					}else{
						$get_date = substr($get_status_by_student_id->expired_date,0,8).$get_status_by_student_id->end_of_month;
						$result_of_date = date('Y-m-d',strtotime($plus_month,strtotime($get_date)));
					}
					$result_quota = '';
					if($get_quota->quota=='Unlimited'){
						$result_quota = 'Unlimited';
					}else{
						$result_quota = ($get_status_by_student_id->quota)+($get_quota->quota);
					}
					$update_status = array(
						'last_packet' => $value->product_id,
						'quota' => $result_quota,
						'expired_date' => $result_of_date
					);
					$this->Main_model->updateData('status',$update_status,array('user_id'=>$dt->user_id));
				}
				$this->Main_model->updateData('student',array('status'=>'Aktif'),array('user_id'=>$dt->user_id));
			}else{
				echo'';
			}
		}
	}
	public function cek_masa_aktif(){
		$check = $this->db->query("SELECT a.* FROM status a WHERE a.expired_date < '".date('Y-m-d')."'")->result();
		foreach ($check as $key => $value) {
			if($value->quota=='Unlimited'){
				$this->Main_model->updateData('status',array('quota'=>'0'),array('user_id'=>$value->user_id));
			}elseif($value->quota>=0){
				$this->Main_model->updateData('status',array('quota'=>'0'),array('user_id'=>$value->user_id));
			}else{
				echo'';
			}
		}
	}
}