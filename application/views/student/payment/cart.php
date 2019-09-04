<link href="<?= site_url() ?>assets/pages/css/invoice.min.css" rel="stylesheet" type="text/css" />
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<ul class="page-breadcrumb breadcrumb">
	<li>
		<span>Purchasing</span>
		<i class="fa fa-circle"></i>
	</li>
	<li>
		<span>Cart</span>
	</li>
</ul>
<?= $this->session->flashdata('sukses') ?>
<?= $this->session->flashdata('gagal') ?>
<?php
$grand_total = 0;
?>
<div class="page-content-inner">
	<div class="invoice">
		<div class="m-heading-1 border-green m-bordered">
			<h3>Note</h3>
			<p> 1. Jika ada memiliki hutang pertemuan, akan ditambahkan biaya senilai hutang pertemuan dikali Rp 250.000,00</p>
			<p> 2. Total tagihan akan ditambahkan dengan 3 kode unik di belakang angka</p>
		</div>
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
						$price = 0;
						foreach ($datacart as $key => $value) {
						?>
						<tr>
							<td> <?= $no++.'.'; ?> </td>
							<td> <?= $value['name']; ?> </td>
							<td class="hidden-xs"> <?= 'Kuota: '.$value['option']['quota'].'x Attendance<br>Durasi: '.$value['option']['duration'].' Hari'; ?> </td>
							<td class="hidden-xs"> <?= $value['qty']; ?> </td>
							<td class="hidden-xs"> <?= 'Rp '.number_format($value['price'],0); ?> </td>
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

		// Veritrans_Config::$serverKey = "Mid-server-pj-mcbw3fEk36nTwvZr10lDn";
		// Veritrans_Config::$isProduction = true;
		// Veritrans_Config::$isSanitized = Veritrans_Config::$is3ds = true;

		$transaction_details = array(
			'order_id' => date('YmdHi').'-'.$this->session->userdata('id'),
			'gross_amount' => 94000,
		);
		$get_hutang = $this->Main_model->getSelectedData('status a', 'a.*',array('a.user_id'=>$this->session->userdata('id')))->row();
		$hutang = 0;
		if($get_hutang->quota>=0){
			echo '';
		}else{
			$hutang = -($get_hutang->quota)*250000;
		}
		$item_details = array (
			array(
				'id' => rand(0,9),
				'price' => $this->cart->total()+$hutang,
				'quantity' => 1,
				'name' => "Transaksi di Koindra"
			),
		);


		$billing_address = array(
			'first_name'    => "Andri",
			'last_name'     => "Litani",
			'address'       => "Mangga 20",
			'city'          => "Jakarta",
			'postal_code'   => "16602",
			'phone'         => "081122334455",
			'country_code'  => 'IDN'
		);

		$shipping_address = array(
			'first_name'    => "Obet",
			'last_name'     => "Supriadi",
			'address'       => "Manggis 90",
			'city'          => "Jakarta",
			'postal_code'   => "16601",
			'phone'         => "08113366345",
			'country_code'  => 'IDN'
		);

		$customer_details = array(
			'first_name'    => $getdata['fullname'],
			'email'         => $getdata['email'],
			'phone'         => $getdata['number_phone']
		);
		$transaction = array(
			'transaction_details' => $transaction_details,
			'customer_details' => $customer_details,
			'item_details' => $item_details,
		);

		// $snapToken = Veritrans_Snap::getSnapToken($transaction);
		?>
		<div class="row">
			<div class="col-xs-4">
			</div>
			<div class="col-xs-8 invoice-block">
				<ul class="list-unstyled amounts">
					<li>
					<?php
					$grand_total = $this->cart->total()+$data_profil->student_id;
					?>
						<h4><strong>Grand Total:</strong> <?= 'Rp '.number_format($this->cart->total(),0); ?></h4> </li>
				</ul>
				<br/>
				<a onclick="return confirm('Anda yakin?')" href='<?= site_url('student/destroy_cart') ?>' class='btn red hidden-print margin-bottom-5'>Empty The Cart <i class="fa fa-trash"></i></a>
				<!-- <button id="pay-button" class="btn green hidden-print margin-bottom-5">Buy Now <i class="fa fa-check"></i></button> -->
				<button class="btn green margin-bottom-5" data-toggle="modal" data-target="#last_step">Buy Now <i class="fa fa-check"></i></button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="last_step" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Last Step of Transaction</h4>
			</div>
			<div class="modal-body">
				<div class="box box-primary">
					<ol>
						<li>Silahkan pilih menu transfer pada ATM atau Mobile Banking anda</li>
						<li>Pilih bank BCA</li>
						<li>Masukkan rekening tujuan <b>6300839086</b> atas nama <b>Indra Setiawan</b></li>
						<li>Masukkan jumlah tagihan yang anda bayarkan sebesar <b><?= 'Rp '.number_format($grand_total,0); ?></b> pastikan 3 digit terakhir anda sesuai dengan yang tertera pada layar</li>
					</ol>
					<button class="btn blue btn-block m-icon" onclick="window.location.href='<?= site_url('student/transaction_completed'); ?>'">Finished
						<i class="fa fa-check"></i>
					</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- <script src="https://app.midtrans.com/snap/snap.js" data-client-key="Mid-client-TOD6tYn8UrG_1F6C"></script>
<script type="text/javascript">
	document.getElementById('pay-button').onclick = function(){
	snap.pay('<?=$snapToken?>');
	};
</script> -->