<?php error_reporting(0); ?>
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<ul class="page-breadcrumb breadcrumb">
	<li>
		<span>Pembelian</span>
		<i class="fa fa-circle"></i>
	</li>
	<li>
		<span>Detail Transaksi</span>
	</li>
</ul>
<?= $this->session->flashdata('sukses') ?>
<?= $this->session->flashdata('gagal') ?>
<div class="page-content-inner">
	<div class="m-heading-1 border-green m-bordered">
		<p>
			<?php
			Veritrans_Config::$serverKey = "Mid-server-pj-mcbw3fEk36nTwvZr10lDn";
			// Uncomment for production environment
			Veritrans_Config::$isProduction = true;
			$order          = Veritrans_Transaction::status($value->invoice_number);
			$status         = $order->transaction_status;
			$stat = '';
			if ($status == "settlement") {
				$stat = "Telah Dibayarkan";
			} elseif ($status == "pending") {
				$stat = "Menunggu Pembayaran";
			} else {
				$stat = "Gagal";
			}
			?>
			<b>Nomor Invoice</b>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<?= $value->invoice_number; ?><br>
			<b>Tanggal Transaksi</b>&nbsp; &nbsp; &nbsp; &nbsp;<?= $this->Main_model->convert_tanggal($value->date); ?><br>
			<b>Total Items</b>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<?= $value->total_items.' items'; ?><br>
			<b>Total Harga</b>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<?= 'Rp '.number_format($value->grand_total,2); ?><br>
			<b>Status</b>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<?= $stat; ?>
			<?php if ($order->transaction_status == "pending") { ?>
			<br><br>
			<div class="panel-group accordion" id="accordion1">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapse_1"> Cara Pembayaran </a>
						</h4>
					</div>
					<div id="collapse_1" class="panel-collapse in">
						<div class="panel-body">
							<?php if ($order->payment_type == "echannel") { ?>
								<p>
									<ol> Transfer
										<li>Pilih Menu Pembayaran/Pembelian</li>
										<li>Pilih menu Transaksi Lainnya.</li>
										<li>Pilih Multi Payment.</li>
										<li>Masukan Kode 70012 (Midtrans company code) lalu tekan Correct.</li>
										<li>Masukan Payment code Anda (<?= $order->bill_key ?>) dan tekan Correct.</li>
										<li>Akan muncul detai pembayaran anda, jika data tersebut benar, maka tekan Ya/yes </li>

									</ol>
									<ol> Internet Banking
										<li>Login ke Mandiri Internet Banking </li>
										<li>Pilih choose Payment, kemudian pilih Multi Payment</li>
										<li>pilih akun anda dari akun itu, lalu pada kolom billing name, pilih Midtrans.</li>
										<li>Masukan  Payment code Anda (<?= $order->bill_key ?>), lalu akan muncul detail pembayaran anda.</li>
										<li>Ikuti Langkah selanjutnya.</li>
									</ol>
								</p>
							<?php } elseif ($order->payment_type == "bank_transfer") {
								if ($order->va_numbers[0]->bank == "" OR $order->va_numbers[0]->bank == NULL) { ?>
								<P>
									<ol>Permata Bank
										<li>On the main menu, choose Other Transaction.</li>
										<li>Choose Payment.</li>
										<li>Choose Other Payment.</li>
										<li>Choose Virtual Account.</li>
										<li>Enter 16 digits Account No. and press Correct. (<?= $order->permata_va_number ?>)
										<li>Amount to be paid, account number, and merchant name will appear on the payment confirmation page. If the information is right, press Correct.</li>
										<li>Choose your payment account and press Correct.</li>
										</p>
									</ol>
								</P>
							<?php } else { ?>
								<p>
									<ol>Transfer BNI
										<li>On the main menu, choose Others. </li>
										<li>Choose Transfer</li>
										<li>Choose Savings Account</li>
										<li>Choose To BNI Account.</li>
										<li>Enter the payment account number (<?= $order->va_numbers[0]->va_number ?>) and press Yes.
										<li>Enter the full amount to be paid. If the amount entered is not the same as the invoiced amount, the transaction will be declined.</li>
										<li>Amount to be paid, account number, and merchant name will appear on the payment confirmation page. If the information is correct, press Yes.</li>
									</ol>
									<ol>Internet Banking BNI
										<li>Go to https://ibank.bni.co.id and then click Login.</li>
										<li>Continue login with your User ID and Password.</li>
										<li>Click Transfer and then Add Favorite Account and choose Antar Rekening BNI.</li>
										<li>Enter account name, account number, and email and then click Continue.</li>
										<li>Input the Authentification Code from your token and then click Continue.
										<li>Back to main menu and select Transfer and then Transfer Antar Rekening BNI</li>
										<li>Pick the account that you just created in the previous step as Rekening Tujuan and fill in the rest before clicking Continue.</li>
										<li>Check whether the details are correct, if they are, please input the Authentification Code (<?= $order->va_numbers[0]->va_number ?>) and click Continue and you are done.
										</li>
									</ol>
									<ol>Mobile Banking
										<li>Open the BNI Mobile Banking app and login</li>
										<li>Choose menu Transfer</li>
										<li>Choose menu Virtual Account Billing</li>
										<li>Choose the bank account you want to use</li>
										<li>Enter the 16 digits virtual account number (<?= $order->va_numbers[0]->va_number ?>)</li>
										<li>The billing information will appear on the payment validation page</li>
										<li>If the information is correct, enter your password to proceed the payment</li>
										<li>Your transaction will be processed</li>
									</ol>
								</p>
								<p>
									<ol>Prima
										<li>On the main menu, choose Other Transaction.</li>
										<li>Choose Transfer.</li>
										<li>Choose Other Bank Account.</li>
										<li>Enter 009 (Bank BNI code) and choose Correct.</li>
										<li>Enter the full amount to be paid. If the amount entered is not the same as the invoiced amount, the transaction will be declined.</li>
										<li>Enter 16 digits payment Account No. and press Correct.</li>
										<li>Amount to be paid, account number, and merchant name will appear on the payment confirmation page. If the information is right, press Correct.
										</li>
									</ol>
									<ol>Atm Bersama
										<li>On the main menu, choose Others.</li>
										<li>Choose Transfer.</li>
										<li>Choose Online Transfer.</li>
										<li>Enter 009 (Bank BNI code) and 16 digits Account (<?= $order->va_numbers[0]->va_number ?>) No. and press Correct.</li>
										<li>Enter the full amount to be paid. If the amount entered is not the same as the invoiced amount, the transaction will be declined.</li>
										<li>Empty the transfer reference number and press Correct.</li>
										<li>Amount to be paid, account number, and merchant name will appear on the payment confirmation page. If the information is right, press Correct.
										</li>
									</ol>
									<ol>Alto
										<li>On the main menu, choose Other Transaction.</li>
										<li>Choose Transfer.</li>
										<li>Choose Other Bank Account.</li>
										<li>Enter 009 (Bank BNI code) and choose Correct.</li>
										<li>Enter the full amount to be paid. If the amount entered is not the same as the invoiced amount, the transaction will be declined.</li>
										<li>Enter 16 digits payment Account (<?= $order->va_numbers[0]->va_number ?>) and press Correct.</li>
										<li>Amount to be paid, account number, and merchant name will appear on the payment confirmation page. If the information is right, press Correct.
										</li>
									</ol>
								</p>
							<?php } } ?>
						</div>
					</div>
				</div>
			</div><?php } ?>
		</p>
	</div>
	<div class="row">
		<div class="col-md-12">
			<!-- BEGIN EXAMPLE TABLE PORTLET-->
			<div class="portlet light ">
				<div class="portlet-body">
					<table class="table table-striped table-bordered table-hover table-checkable order-column">
						<thead>
							<tr>
								<th width="3%">
									<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
										<input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" />
										<span></span>
									</label>
								</th>
								<th style="text-align: center;" width="4%"> # </th>
								<th style="text-align: center;"> Nama Paket </th>
								<th style="text-align: center;"> Harga </th>
								<th style="text-align: center;"> Qty </th>
								<th style="text-align: center;"> Sub Total </th>
							</tr>
						</thead>
						<tbody>
							<?php
							$n = 1;
							foreach ($detail as $key => $value) {
							?>
							<tr class="odd gradeX">
								<td style="text-align: center;">
									<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
										<input type="checkbox" class="checkboxes" name="selected_id[]" value="<?= $value->purchasing_detail_id; ?>"/>
										<span></span>
									</label>
								</td>
								<td style="text-align: center;"><?= $n++.'.'; ?></td>
								<td style="text-align: center;"><?= $value->packet_name; ?></td>
								<td style="text-align: center;"><?= 'Rp '.number_format($value->price,2); ?></td>
								<td style="text-align: center;"><?= $value->qty; ?></td>
								<td style="text-align: center;"><?= 'Rp '.number_format($value->sub_total,2); ?></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>