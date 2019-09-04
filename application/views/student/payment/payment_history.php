<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<ul class="page-breadcrumb breadcrumb">
	<li>
		<span>Purchasing</span>
		<i class="fa fa-circle"></i>
	</li>
	<li>
		<span>Payment History</span>
	</li>
</ul>
<?= $this->session->flashdata('sukses') ?>
<?= $this->session->flashdata('gagal') ?>
<div class="page-content-inner">
	<div class="m-heading-1 border-green m-bordered">
		<h3>Note</h3>
		<!-- <p> Ketika mengklik <b>Atur Ulang Sandi</b>, maka kata sandi otomatis menjadi "<b>1234</b>"</p> -->
	</div>
	<div class="row">
		<div class="col-md-12">
			<!-- BEGIN EXAMPLE TABLE PORTLET-->
			<div class="portlet light ">
				<div class="portlet-body">
					<table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
						<thead>
							<tr>
								<th width="3%">
									<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
										<input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" />
										<span></span>
									</label>
								</th>
								<th style="text-align: center;" width="4%"> # </th>
								<th style="text-align: center;"> Invoice Number </th>
								<th style="text-align: center;"> Transaction Date </th>
								<th style="text-align: center;"> Total Price </th>
								<!-- <th style="text-align: center;"> Payment Method </th> -->
								<th style="text-align: center;"> Status Transaction </th>
								<th style="text-align: center;" width="8%"> Action </th>
							</tr>
						</thead>
						<tbody>
							<?php
							$no = 1;
							foreach ($data_tabel as $key => $value) {
							?>
							<tr class="odd gradeX">
								<td style="text-align: center;">
									<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
										<input type="checkbox" class="checkboxes" name="selected_id[]" value="<?= $value->purchasing_id; ?>"/>
										<span></span>
									</label>
								</td>
								<td style="text-align: center;"><?= $no++.'.'; ?></td>
								<td style="text-align: center;"><?= $value->invoice_number; ?></td>
								<td style="text-align: center;"><?= $this->Main_model->convert_tanggal($value->date); ?></td>
								<td style="text-align: center;"><?= 'Rp '.number_format($value->bill,2); ?></td>
								<!-- <td style="text-align: center;"><?= $value->payment_type; ?></td> -->
								<td style="text-align: center;"><?php
								if($value->status=='1'){
									echo'<span class="label label-success"> Success </span>';
								}elseif($value->status=='0'){
									echo'<span class="label label-warning"> Pending </span>';
								}elseif($value->status=='2'){
									echo'<span class="label label-danger"> Failed </span>';
								}
								?></td>
								<td>
									<div class="btn-group" style="text-align: center;">
										<button class="btn btn-xs green" type="button" onclick="window.location.href='<?=base_url('student/detail_transaksi/'.md5($value->invoice_number));?>'"> Detail
											<i class="fa fa-angle-right"></i>
										</button>
										<!-- <ul class="dropdown-menu" role="menu">
											<li>
												<a href="<?php echo base_url()."student/detail_transaksi/".md5($value->invoice_number); ?>">
													Detail <i class="fa fa-share-square-o"></i></a>
											</li>
											<li>
												<a href="<?=site_url('student/add_to_cart/'.md5($value->packet_id));?>">
													<i class="fa fa-share-square-o"></i> Beli </a>
											</li>
										</ul> -->
									</div>
								</td>
							</tr>
							<?php
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
			<!-- END EXAMPLE TABLE PORTLET-->
		</div>
	</div>
</div>