<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<ul class="page-breadcrumb breadcrumb">
	<li>
		<span>Transaction Data</span>
	</li>
</ul>
<div class="page-content-inner">
	<div class="m-heading-1 border-green m-bordered">
		<h3>Note</h3>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="portlet light ">
				<div class="portlet-body">
					<div class="form-group select2-bootstrap-prepend" >
						<label class="control-label col-md-2">Searching by <b>Status</b></label>
						<div class="col-md-5">
							<select id='pilihan' class="form-control select2-allow-clear">
								<option value=""></option>
								<option value="2">Success</option>
								<option value="0">Pending</option>
								<option value="19">Failed</option>
							</select>
						</div>
					</div>
					<br>
					<hr>
					<form action="#" method="post" onsubmit="return deleteConfirm();"/>
					<div class="table-toolbar">
						<div class="row">
							<div class="col-md-6">
								<div class="btn-group">
									<a href="#" class="btn btn-info" data-toggle="modal" data-target="#fi">Import Data <i class="fa fa-cloud-upload"></i></a>
								</div>
									<span class="separator">|</span>
									<a href="<?=base_url()?>data_upload/format_data_pembayaran.xlsx" class="btn btn-warning">Import Data Template</a>
							</div>
						</div>
					</div>
					<table class="table table-striped table-bordered table-hover order-column" id="sample_2">
						<thead>
							<tr>
								<th style="text-align: center;" width="4%"> # </th>
								<th style="text-align: center;"> Invoice </th>
								<th style="text-align: center;"> User </th>
								<th style="text-align: center;"> Price </th>
								<th style="text-align: center;"> Transaction Date </th>
								<th style="text-align: center;"> Payment Status </th>
								<th style="text-align: center;" width="7%"> Action </th>
							</tr>
						</thead>
						<tbody>
							<?php
							$urutan = 1;
							foreach ($riwayat_pembayaran as $key => $value) {
								if($value->status=='1'){
									$stat = '<span class="label label-success"> Success </span>';
								}elseif($value->status=='0'){
									$stat = '<span class="label label-warning"> Pending </span>';
								}elseif($value->status=='2'){
									$stat = '<span class="label label-danger"> Failed </span>';
								}
								echo'
								<tr>
									<td style="text-align: center;">'.$urutan.'.</td>
									<td style="text-align: center;">'.$value->invoice_number.'</td>
									<td style="text-align: center;">'.$value->fullname.'</td>
									<td style="text-align: center;">Rp '.number_format($value->bill,0).'</td>
									<td style="text-align: center;">'.$this->Main_model->convert_tanggal($value->date).'</td>
									<td style="text-align: center;">'.$stat.'</td>
									<td>
									</td>
								</tr>
								';
								$urutan++;
							}
							?>
						</tbody>
					</table>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade bs-modal-lg in" id="fi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: block; padding-right: 17px; background-color: rgba(0,0,0,.3);">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel">Data Import</h4>
			</div>
			<div class="modal-body">
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th style="text-align: center;" width="4%"> # </th>
							<th style="text-align: center;"> Student </th>
							<th style="text-align: center;"> Quota </th>
							<th style="text-align: center;"> Expired Date </th>
							<th style="text-align: center;"> Sender </th>
							<th style="text-align: center;"> Payment Date </th>
						</tr>
					</thead>
					<tbody>
						<?php
						$urutan = 1;
						foreach ($konfirmasi_pembayaran as $key => $value) {
							$quota = '';
							if($value->quota=='Unlimited'){
								$quota = $value->quota;
							}else{
								$quota = $value->quota.'x';
							}
							echo'
							<tr>
								<td style="text-align: center;">'.$urutan++.'.</td>
								<td style="text-align: center;">'.$value->fullname.'</td>
								<td style="text-align: center;">'.$quota.'</td>
								<td style="text-align: center;">'.$this->Main_model->convert_tanggal($value->expired_date).'</td>
								<td style="text-align: center;">'.$value->sender.'</td>
								<td style="text-align: center;">'.$this->Main_model->convert_tanggal($value->payment_date).'</td>
							</tr>
							';
						}
						foreach ($transaksi_gagal as $key => $f) {
							echo '
								<tr style="background: red">
									<td style="text-align: center;">'.$urutan++.'.</td>
									<td style="text-align: center;">-</td>
									<td style="text-align: center;">-</td>
									<td style="text-align: center;">-</td>
									<td style="text-align: center;">'.$f->sender.'</td>
									<td style="text-align: center;">'.$this->Main_model->convert_tanggal($f->payment_date).'</td>
								</tr>
							';
						}
						?>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<a onclick="return confirm('Anda yakin?')" href="<?=site_url('admin/Payment/cancel_payment');?>" class="btn btn-secondary">Cancel</a>
				<a onclick="return confirm('Anda yakin?')" href="<?=site_url('admin/Payment/payment_confirmed');?>" class="btn btn-primary">Submit</a>
			</div>
		</div>
	</div>
</div>