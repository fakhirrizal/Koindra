

<link href="<?= site_url() ?>assets/pages/css/invoice.min.css" rel="stylesheet" type="text/css" />
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<ul class="page-breadcrumb breadcrumb">
	<li>
		<span>Pembelian</span>
		<i class="fa fa-circle"></i>
	</li>
	<li>
		<span>Cart</span>
	</li>
</ul>
<?= $this->session->flashdata('sukses') ?>
<?= $this->session->flashdata('gagal') ?>
<div class="page-content-inner">
	<div class="invoice">
		<!-- <div class="row invoice-logo">
			<div class="col-xs-6 invoice-logo-space">
				<img src="<?= site_url().'assets/walmart.png'; ?>" class="img-responsive" alt="" /> </div>
			<div class="col-xs-6">
				<p> Transaksi Tanggal <?= $this->Main_model->convert_tanggal(date('Y-m-d')); ?>
				</p>
			</div>
		</div>
		<hr/> -->
		<div class="row">
			<div class="col-xs-12">
				<pre>
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th> # </th>
							<th> Item </th>
							<th class="hidden-xs"> Description </th>
							<th class="hidden-xs"> Quantity </th>
							<th class="hidden-xs"> Unit Cost </th>
							<th> Total </th>
						</tr>
					</thead>
					<tbody>
						<?php
						$no = 1;
						$datacart = $this->cart->contents();
						// echo'<pre>';
						// print_r($datacart);
						// echo'</pre>';
						$price = 0;
						foreach ($datacart as $key => $value) {
						?>
						<tr>
							<td> <?= $no++.'.'; ?> </td>
							<td> <?= $value['name']; ?> </td>
							<td class="hidden-xs"> <?= 'Kuota: '.$value['option']['quota'].'x Pertemuan<br>Durasi: '.$value['option']['duration'].' Hari'; ?> </td>
							<td class="hidden-xs"> <?= $value['qty']; ?> </td>
							<td class="hidden-xs"> <?= 'Rp '.number_format($value['price'],2); ?> </td>
							<td> <?= 'Rp '.number_format($value['subtotal']); ?> </td>
						</tr>
						<?php $price += $value['price']; } ?>
					</tbody>
				</table>
				</pre>
			</div>
		</div>
		<?php
		$getdata = $this->Main_model->getSelectedData('user_profile a', 'a.*,b.email,b.number_phone', array("a.user_id" => $this->session->userdata('id')),'','','','',array(
			'table' => 'student b',
			'on' => 'a.user_id=b.user_id',
			'pos' => 'LEFT',
		))->row_array();

		// echo $getdata['email'];

		// Set Your server key
		Veritrans_Config::$serverKey = "Mid-server-pj-mcbw3fEk36nTwvZr10lDn";
		// Uncomment for production environment
		Veritrans_Config::$isProduction = true;
		Veritrans_Config::$isSanitized = Veritrans_Config::$is3ds = true;

		// Required
		$transaction_details = array(
		'order_id' => date('YmdHi').'-'.$this->session->userdata('id'),// rand(),
		'gross_amount' => 94000, // no decimal allowed for creditcard
		);
		// $price = $biaya_pendaftaran['nilai_pdh'];

		// Optional
		$item_details = array (
			array(
			'id' => rand(0,9),
			// 'price' => $price,
			'price' => $this->cart->total(),
			'quantity' => 1,
			'name' => "Transaksi di Koindra"
			),
		);


		// Optional
		$billing_address = array(
		'first_name'    => "Andri",
		'last_name'     => "Litani",
		'address'       => "Mangga 20",
		'city'          => "Jakarta",
		'postal_code'   => "16602",
		'phone'         => "081122334455",
		'country_code'  => 'IDN'
		);


		// Optional
		$shipping_address = array(
		'first_name'    => "Obet",
		'last_name'     => "Supriadi",
		'address'       => "Manggis 90",
		'city'          => "Jakarta",
		'postal_code'   => "16601",
		'phone'         => "08113366345",
		'country_code'  => 'IDN'
		);

		// Optional
		$customer_details = array(
		'first_name'    => $getdata['fullname'],
		// 'address'       => $getdata['address'],
		// 'last_name'     => "Litani",
		'email'         => $getdata['email'],
		'phone'         => $getdata['number_phone']
		// 'billing_address'  => $billing_address,
		// 'shipping_address' => $shipping_address
		);
		// Fill transaction details
		$transaction = array(
		'transaction_details' => $transaction_details,
		'customer_details' => $customer_details,
		'item_details' => $item_details,
		);

		$snapToken = Veritrans_Snap::getSnapToken($transaction);
		// echo "snapToken = ".$snapToken;
		?>
		<div class="row">
			<div class="col-xs-4">
				<!-- <div class="well">
					<address>
						<strong>Loop, Inc.</strong>
						<br/> 795 Park Ave, Suite 120
						<br/> San Francisco, CA 94107
						<br/>
						<abbr title="Phone">P:</abbr> (234) 145-1810 </address>
					<address>
						<strong>Full Name</strong>
						<br/>
						<a href="mailto:#"> first.last@email.com </a>
					</address>
				</div> -->
			</div>
			<div class="col-xs-8 invoice-block">
				<ul class="list-unstyled amounts">
					<li>
						<h4><strong>Grand Total:</strong> <?= 'Rp '.number_format($this->cart->total(),2); ?></h4> </li>
				</ul>
				<br/>
				<a onclick="return confirm('Anda yakin?')" href='<?= site_url('student/destroy_cart') ?>' class='btn red hidden-print margin-bottom-5'>Hapus Keranjang <i class="fa fa-trash"></i></a>
				<button id="pay-button" class="btn green hidden-print margin-bottom-5">Bayar Sekarang <i class="fa fa-check"></i></button>
			</div>
		</div>
	</div>
</div>

	<!-- TODO: Remove ".sandbox" from script src URL for production environment. Also input your client key in "data-client-key" -->
	<script src="https://app.midtrans.com/snap/snap.js" data-client-key="Mid-client-TOD6tYn8UrG_1F6C"></script>
	<script type="text/javascript">
		document.getElementById('pay-button').onclick = function(){
		// SnapToken acquired from previous step
		snap.pay('<?=$snapToken?>');
		};
	</script>