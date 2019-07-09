<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<ul class="page-breadcrumb breadcrumb">
	<li>
		<span>Master</span>
		<i class="fa fa-circle"></i>
	</li>
	<li>
		<span>Data Siswa</span>
		<i class="fa fa-circle"></i>
	</li>
	<li>
		<span>Detail Data</span>
	</li>
</ul>
<?= $this->session->flashdata('sukses') ?>
<?= $this->session->flashdata('gagal') ?>
<div class="page-content-inner">
	<div class="m-heading-1 border-green m-bordered">
		<h3>Catatan</h3>
	</div>
	<div class="row">
		<div class="col-md-12">
			<!-- BEGIN EXAMPLE TABLE PORTLET-->
			<div class="portlet light ">
				<div class="portlet-body">
					<div class='row'>
						<?php
						if(isset($data_utama)){
							foreach($data_utama as $row)
							{
						?>
								<div class="col-md-6">
									<table class="table">
										<tbody>
											<tr>
												<td> Nama Lengkap </td>
												<td> : </td>
												<td><?php echo $row->fullname; ?></td>
											</tr>
											<tr>
												<td> Email </td>
												<td> : </td>
												<td><?php echo $row->email; ?></td>
											</tr>
											<tr>
												<td> No. HP </td>
												<td> : </td>
												<td><?php echo $row->number_phone; ?></td>
											</tr>
											<tr>
												<td> Asal Sekolah </td>
												<td> : </td>
												<td><?php echo $row->school; ?></td>
											</tr>
											<tr>
												<td> Kelas </td>
												<td> : </td>
												<td><?php echo $row->class; ?></td>
											</tr>
										</tbody>
									</table>
								</div>
								<div class="col-md-6">
									<table class="table">
										<tbody>
											<tr>
												<td> Ibu Kandung </td>
												<td> : </td>
												<td><?php echo $row->mother; ?></td>
											</tr>
											<tr>
												<td> No. HP Ibu </td>
												<td> : </td>
												<td><?php echo $row->mother_phone; ?></td>
											</tr>
										</tbody>
									</table>
								</div>
						<?php }} ?>
						<div class="col-md-12" >
							<div class="tabbable-line">
								<ul class="nav nav-tabs ">
									<li class="active">
										<a href="#tab_15_1" data-toggle="tab"> Riwayat Kehadiran </a>
									</li>
									<li>
										<a href="#tab_15_2" data-toggle="tab"> Riwayat Pembayaran </a>
									</li>
								</ul>
								<div class="tab-content">
									<div class="tab-pane active" id="tab_15_1">
										<table class="table table-striped table-bordered table-hover order-column" id="sample_1">
											<thead>
												<tr>
													<th style="text-align: center;" width="4%"> # </th>
													<th style="text-align: center;"> Tanggal </th>
													<th style="text-align: center;"> Jam Masuk </th>
													<th style="text-align: center;"> Jam Keluar </th>
													<th style="text-align: center;"> Catatan </th>
												</tr>
											</thead>
											<tbody>
												<?php
												$urutan = 1;
												foreach ($riwayat_kehadiran as $key => $value) {
													echo'
													<tr style="text-align: center;">
														<td>'.$urutan.'.</td>
														<td>'.$this->Main_model->convert_tanggal($value['date']).'</td>
														<td>'.$value['come_in'].'</td>
														<td>'.$value['come_out'].'</td>
														<td><span class="more">'.$value['note'].'</span></td>
													</tr>
													';
													$urutan++;
												}
												?>
											</tbody>
										</table>
									</div>
									<div class="tab-pane" id="tab_15_2">
										<table class="table table-striped table-bordered table-hover order-column" id="sample_2">
											<thead>
												<tr>
													<th style="text-align: center;" width="4%"> # </th>
													<th style="text-align: center;"> Invoice </th>
													<th style="text-align: center;"> Total Item </th>
													<th style="text-align: center;"> Nominal </th>
													<th style="text-align: center;"> Tanggal Pembayaran </th>
													<th style="text-align: center;"> Aksi </th>
												</tr>
											</thead>
											<tbody>
												<?php
												$urutan = 1;
												foreach ($riwayat_pembayaran as $key => $value) {
													echo'
													<tr style="text-align: center;">
														<td>'.$urutan.'.</td>
														<td>'.$value->invoice_number.'</td>
														<td>'.$value->total_items.' Item</td>
														<td>Rp '.number_format($value->grand_total,2).'</td>
														<td>'.$this->Main_model->convert_tanggal($value->date).'</td>
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
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-12" >
						<hr><a href="<?php echo base_url()."admin_side/siswa"; ?>" class="btn btn-info" role="button"><i class="fa fa-angle-double-left"></i> Kembali</a></div>
					</div>
				</div>
			</div>
			<!-- END EXAMPLE TABLE PORTLET-->
		</div>
	</div>
<style>
	.morecontent span {
	display: none;
	}
	.morelink {
		display: block;
	}
</style>
<script>
	$(document).ready(function() {
		// Configure/customize these variables.
		var showChar = 100;  // How many characters are shown by default
		var ellipsestext = "...";
		var moretext = "Show more >";
		var lesstext = "Show less";

		$('.more').each(function() {
			var content = $(this).html();
			if(content.length > showChar) {
				var c = content.substr(0, showChar);
				var h = content.substr(showChar, content.length - showChar);
				var html = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';
				$(this).html(html);
			}
		});

		$(".morelink").click(function(){
			if($(this).hasClass("less")) {
				$(this).removeClass("less");
				$(this).html(moretext);
			} else {
				$(this).addClass("less");
				$(this).html(lesstext);
			}
			$(this).parent().prev().toggle();
			$(this).prev().toggle();
			return false;
		});
	});
</script>
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