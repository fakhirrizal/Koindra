<?php error_reporting(0); ?>
<div class="page-content-inner">
	<div class="row">
		<div class="col-md-12">
			<div class="portlet light ">
				<div class="portlet-body">
					<div class='row'>
						<h4><b> Invoice Number </b>&nbsp; &nbsp; &nbsp;<?php echo $data_utama['invoice_number']; ?><br>
						<b> Transaction Date </b>&nbsp; &nbsp;<?php echo $this->Main_model->convert_tanggal($data_utama['date']); ?><br>
						<?php
						if($data_utama['status']=='1'){
							echo'<b> Payment Date </b>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;'.$this->Main_model->convert_tanggal($data_utama['payment_date']);
						}else{
							echo'';
						}
						?>
						</h4><hr>
						<?php
						// Veritrans_Config::$serverKey = "Mid-server-pj-mcbw3fEk36nTwvZr10lDn";
						// Veritrans_Config::$isProduction = true;
						// $order          = Veritrans_Transaction::status($data_utama['invoice_number']);
						// $status         = $order->transaction_status;
						// if ($status == "settlement") {
						// 	$stat = "Telah Dibayarkan";
						// } elseif ($status == "pending") {
						// 	$stat = "Menunggu Pembayaran";
						// } else {
						// 	$stat = "Gagal";
						// }
						?>
						<div class="col-md-12">
							<table class="table">
								<thead>
									<tr>
										<th>#</th>
										<th>Packet</th>
										<th>Price</th>
										<th>Qty</th>
										<th>Sub Total</th>
									</tr>
								</thead>
								<tbody>
								<?php
								$no = 1;
								if(isset($data_detail)){
									foreach($data_detail as $row)
									{
								?>
									<tr>
										<td> <?= $no++.'.'; ?> </td>
										<td> <?= $row->packet_name; ?> </td>
										<td> <?= 'Rp '.number_format($row->price,2); ?> </td>
										<td> <?= $row->qty; ?> </td>
										<td> <?= 'Rp '.number_format($row->sub_total,2); ?> </td>
									</tr>
								<?php }} ?>
									<tr>
										<td colspan='4' style='text-align: center'>Grand Total</td>
										<td><?= 'Rp '.number_format($data_utama['grand_total'],2); ?></td>
									</tr>
									<tr>
										<td colspan='4' style='text-align: center'>Bill</td>
										<td><?= 'Rp '.number_format($data_utama['bill'],2); ?></td>
									</tr>
								</tbody>
							</table>
						</div>

						<div class="panel panel-info">
							<div class="panel-heading">
								<h3 class="panel-title">Billing Info</h3>
							</div>
							<div class="panel-body">
								<!-- <b>Payment Type</b> <?= $order->payment_type.'<br>' ?> -->
								<?php
								// if($order->payment_type=='echannel'){
								// 	echo '<b>Nomor VA</b> '.$order->bill_key.'<br>';
								// }else{
								// 	echo'';
								// }
								?>
								<b>Status</b> <?php
								// if($stat=="Telah Dibayarkan"){
								// 	echo $stat.'<br>';
								// 	$gettanggal = explode(' ',$order->settlement_time);
								// 	echo '<b>Waktu Pembayaran</b> '.$this->Main_model->convert_tanggal($gettanggal[0]).' '.$gettanggal[1];
								// }else{
								// 	echo $stat;
								// }
								if($data_utama['status']=='1'){
									echo'<span class="label label-success"> Success </span>';
								}elseif($data_utama['status']=='0'){
									echo'<span class="label label-warning"> Pending </span>';
								}elseif($data_utama['status']=='2'){
									echo'<span class="label label-danger"> Failed </span>';
								}
								?>
								<br><br>* Bill akan ditambahkan dengan kode unik
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>