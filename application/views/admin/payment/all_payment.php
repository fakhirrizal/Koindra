<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<ul class="page-breadcrumb breadcrumb">
	<li>
		<span>Transaction Data</span>
	</li>
</ul>
<?= $this->session->flashdata('sukses') ?>
<?= $this->session->flashdata('gagal') ?>
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
								<!-- <th style="text-align: center;"> ID Pesanan </th> -->
								<th style="text-align: center;"> User </th>
								<th style="text-align: center;"> Price </th>
								<th style="text-align: center;"> Transaction Date </th>
								<!-- <th style="text-align: center;">Payment Type</th> -->
								<!-- <th>Virtual Account</th> -->
								<th style="text-align: center;"> Payment Status </th>
								<th style="text-align: center;" width="7%"> Action </th>
							</tr>
						</thead>
						<tbody>
							<?php
							$urutan = 1;
							foreach ($riwayat_pembayaran as $key => $value) {
								// Veritrans_Config::$serverKey = "Mid-server-pj-mcbw3fEk36nTwvZr10lDn";
								// Veritrans_Config::$isProduction = true;

								// $order          = Veritrans_Transaction::status($value->invoice_number);

								// $status         = $order->transaction_status;
								// if ($status == "settlement") {
								// 	$stat = "Success";
								// } elseif ($status == "pending") {
								// 	$stat = "Pending";
								// } else {
								// 	$stat = "Failed";
								// }
								if($value->status=='1'){
									$stat = '<span class="label label-success"> Success </span>';
								}elseif($value->status=='0'){
									$stat = '<span class="label label-warning"> Pending </span>';
								}elseif($value->status=='2'){
									$stat = '<span class="label label-danger"> Failed </span>';
								}
								$returning = "return confirm('Anda yakin?')";

								echo'
								<tr>
									<td style="text-align: center;">'.$urutan.'.</td>
									<td style="text-align: center;">'.$value->invoice_number.'</td>
									<td style="text-align: center;">'.$value->fullname.'</td>
									<td style="text-align: center;">Rp '.number_format($value->bill,2).'</td>
									<td style="text-align: center;">'.$this->Main_model->convert_tanggal($value->date).'</td>
									<td style="text-align: center;">'.$stat.'</td>
									<td>
										<button class="btn btn-xs green detaildata" type="button" data-toggle="modal" data-target="#detaildata" id="'.md5($value->purchasing_id).'"> Detail
											<i class="fa fa-share-square-o"></i>
										</button>
									</td>
								</tr>
								';
								$urutan++;
							}
							?>
						</tbody>
					</table>
					</form>
					<script type="text/javascript">
					function deleteConfirm(){
						var result = confirm("Yakin akan menghapus data ini?");
						if(result){
							return true;
						}else{
							return false;
						}
					}
					</script>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="fi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
		<div class="modal-header">
			<!-- <h4 class="modal-title" id="exampleModalLabel">Form Import</h4> -->
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<form role="form" action="<?php echo base_url()."admin_side/impor_data_pembayaran"; ?>" method='post' enctype="multipart/form-data">
		<div class="modal-body">
			<div class="form-body">
				<div class="form-group form-md-line-input has-danger">
					<label class="col-md-2 control-label" for="form_control_1">File Import <span class="required"> * </span></label>
					<div class="col-md-10">
						<div class="input-icon">
							<input class="form-control" type="file" name='fmasuk' required>
							<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			<button type="submit" class="btn btn-primary">Submit</button>
		</div>
		</form>
		</div>
	</div>
</div>
<div class="modal fade" id="detaildata" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<a class="btn btn-circle btn-icon-only btn-default" href="javascript:;" data-dismiss="modal"><i class="icon-size-fullscreen"></i></a>
			</div>
			<div class="modal-body">
				<div class="box box-primary" id='formdetaildata' >
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$.ajaxSetup({
			type:"POST",
			url: "<?php echo site_url(); ?>admin/Master/ajax_function",
			cache: false,
		});
		$('.detaildata').click(function(){
		var id = $(this).attr("id");
		var modul = 'modul_detail_riwayat_pembayaran';
		var nilai_token = '<?php echo $this->security->get_csrf_hash();?>';
		$.ajax({
			data: {id:id,modul:modul,<?php echo $this->security->get_csrf_token_name();?>:nilai_token},
			success:function(data){
			$('#formdetaildata').html(data);
			$('#detaildata').modal("show");
			}
		});
		});
	});
</script>