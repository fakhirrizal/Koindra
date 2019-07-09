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
		<div class="row invoice-logo">
			<div class="col-xs-6 invoice-logo-space">
				<img src="<?= site_url().'assets/walmart.png'; ?>" class="img-responsive" alt="" /> </div>
			<div class="col-xs-6">
				<p> #5652256 / <?= $this->Main_model->convert_tanggal(date('Y-m-d')); ?>
					<span class="muted"> Consectetuer adipiscing elit </span>
				</p>
			</div>
		</div>
		<hr/>
		<!-- <div class="row">
			<div class="col-xs-4">
				<h3>Client:</h3>
				<ul class="list-unstyled">
					<li> John Doe </li>
					<li> Mr Nilson Otto </li>
					<li> FoodMaster Ltd </li>
					<li> Madrid </li>
					<li> Spain </li>
					<li> 1982 OOP </li>
				</ul>
			</div>
			<div class="col-xs-4">
				<h3>About:</h3>
				<ul class="list-unstyled">
					<li> Drem psum dolor sit amet </li>
					<li> Laoreet dolore magna </li>
					<li> Consectetuer adipiscing elit </li>
					<li> Magna aliquam tincidunt erat volutpat </li>
					<li> Olor sit amet adipiscing eli </li>
					<li> Laoreet dolore magna </li>
				</ul>
			</div>
			<div class="col-xs-4 invoice-payment">
				<h3>Payment Details:</h3>
				<ul class="list-unstyled">
					<li>
						<strong>V.A.T Reg #:</strong> 542554(DEMO)78 </li>
					<li>
						<strong>Account Name:</strong> FoodMaster Ltd </li>
					<li>
						<strong>SWIFT code:</strong> 45454DEMO545DEMO </li>
					<li>
						<strong>Account Name:</strong> FoodMaster Ltd </li>
					<li>
						<strong>SWIFT code:</strong> 45454DEMO545DEMO </li>
				</ul>
			</div>
		</div> -->
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
						<?php } ?>
					</tbody>
				</table>
				</pre>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-4">
				<div class="well">
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
				</div>
			</div>
			<div class="col-xs-8 invoice-block">
				<ul class="list-unstyled amounts">
					<!-- <li>
						<strong>Sub - Total amount:</strong> $9265 </li>
					<li>
						<strong>Discount:</strong> 12.9% </li>
					<li>
						<strong>VAT:</strong> ----- </li> -->
					<li>
						<h3><strong>Grand Total:</strong> <?= 'Rp '.number_format($this->cart->total(),2); ?></h3> </li>
				</ul>
				<br/>
				<a class="btn btn-lg blue hidden-print margin-bottom-5" onclick="javascript:window.print();"> Print
					<i class="fa fa-print"></i>
				</a>
				<a class="btn btn-lg green hidden-print margin-bottom-5" href='<?= site_url('student/transaction_completed'); ?>'> Submit Your Invoice
					<i class="fa fa-check"></i>
				</a>
			</div>
		</div>
	</div>
</div>