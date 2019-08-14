<?php error_reporting(0); ?>
<div class="page-content-inner">
	<div class="row">
		<div class="col-md-12">
			<!-- BEGIN EXAMPLE TABLE PORTLET-->
			<div class="portlet light ">
				<div class="portlet-body">
					<div class='row'>
						<h4><b> Invoice Number </b><?php echo $data_utama['invoice_number']; ?><br>
						<b> Transaction Date </b><?php echo $this->Main_model->convert_tanggal($data_utama['date']); ?></h4><hr>
						<?php
						Veritrans_Config::$serverKey = "Mid-server-pj-mcbw3fEk36nTwvZr10lDn";
						// Uncomment for production environment
						Veritrans_Config::$isProduction = true;
						$order          = Veritrans_Transaction::status($data_utama['invoice_number']);
						$status         = $order->transaction_status;
						if ($status == "settlement") {
							$stat = "Telah Dibayarkan";
						} elseif ($status == "pending") {
							$stat = "Menunggu Pembayaran";
						} else {
							$stat = "Gagal";
						}
						/*$data['status'] = $status;
						$data['metode'] = $order->payment_type;
						$data['biaya']  = $order->gross_amount;
						if ($order->payment_type == "bank_transfer") {
							$data['va_number']['bank'] = $order->va_numbers[0]->bank;
							$data['va_number']['number'] = $order->va_numbers[0]->va_number;
						}elseif ($order->payment_type == "cstore") {
							$data['store'] = $order->store;
							$data['payment_code'] = $order->payment_code;
						}*/
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
									</tbody>
								</table>
							</div>

							<div class="panel panel-info">
								<div class="panel-heading">
									<h3 class="panel-title">Billing Info</h3>
								</div>
								<div class="panel-body">
									<b>Payment Type</b> <?= $order->payment_type.'<br>' ?>
									<?php
									if($order->payment_type=='echannel'){
										echo '<b>Nomor VA</b> '.$order->bill_key.'<br>';
									}else{
										echo'';
									}
									?>
									<b>Status</b> <?php
									if($stat=="Telah Dibayarkan"){
										echo $stat.'<br>';
										$gettanggal = explode(' ',$order->settlement_time);
										echo '<b>Waktu Pembayaran</b> '.$this->Main_model->convert_tanggal($gettanggal[0]).' '.$gettanggal[1];
									}else{
										echo $stat;
									}
									?>
								</div>
							</div>

							<!-- <div class="col-md-12">
								<table class="table">
									<thead>
										<tr>
											<th>Payment Type</th>
											<th>Virtual Account</th>
											<th>Tanggal & Waktu</th>
											<th>ID Pesanan</th>
											<th>Jumlah</th>
											<th>Status</th>
										</tr>
									</thead>
									<tbody>
										<tr>

											<td> <?= $order->payment_type ?> </td>
											<td> <?= $order->bill_key ?> </td>
											<td> <?= $order->settlement_time ?> </td>
											<td> <?= $data_utama['invoice_number']; ?> </td>
											<td> <?= $order->gross_amount; ?> </td>
											<td> <?= $stat; ?> </td>
										</tr>
									</tbody>
								</table>
							</div> -->
					</div>
				</div>
			</div>
			<!-- END EXAMPLE TABLE PORTLET-->
		</div>
	</div>
</div>