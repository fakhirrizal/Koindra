<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cronjob extends CI_Controller {
	function __construct() {
		parent::__construct();
	}
	/* Packet */
	

	public function index(){
		$datrans = $this->Main_model->getSelectedData('purchasing a', 'a.*')->result();

		foreach ($datrans as $dt) {

			Veritrans_Config::$serverKey = "Mid-server-pj-mcbw3fEk36nTwvZr10lDn";
			// Uncomment for production environment
			Veritrans_Config::$isProduction = true;
			$order          = Veritrans_Transaction::status($dt->invoice_number);

			$status         = $order->transaction_status;
			
			if ($status == "settlement") {
				$stat = "1";
			} elseif ($status == "pending") {
				$stat = "0";
			} else {
				$stat = "2";
			}
			
			//$this->db->trans_start();
			$data = array(
						'status' => $stat
					);
			$ceks = $this->Main_model->updateData('purchasing',$data,array('purchasing_id'=>$dt->purchasing_id));
		//	print_r($ceks);
		}
	}

}