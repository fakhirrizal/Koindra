<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<ul class="page-breadcrumb breadcrumb">
	<li>
		<span>Report</span>
		<i class="fa fa-circle"></i>
	</li>
	<li>
		<span>Attendance Data Details</span>
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
					<div class='row'>
						<div class="col-md-12">
							<div class="portlet light ">
								<div class="portlet-body">
									<table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
										<thead>
											<tr>
												<th style="text-align: center;" width="4%"> # </th>
												<th style="text-align: center;" width="15%"> Name </th>
												<th style="text-align: center;" width="15%"> Date </th>
												<!-- <th style="text-align: center;"> Jam Masuk </th>
												<th style="text-align: center;"> Jam Keluar </th> -->
												<th style="text-align: center;"> Note </th>
												<th style="text-align: center;" width="7%"> Action </th>
											</tr>
										</thead>
										<tbody>
											<?php
												$urutan = 1;
												foreach ($riwayat_kehadiran as $key => $value) {
													$return_on_click = "return confirm('Anda yakin?')";
													echo'
													<tr>
														<td style="text-align: center;">'.$urutan.'.</td>
														<td style="text-align: center;">'.$value['fullname'].'</td>
														<td style="text-align: center;">'.$this->Main_model->convert_tanggal($value['date']).'</td>
														<td style="text-align: center;"><span class="more">'.$value['note'].'</span></td>
														<td>
															<div class="btn-group" style="text-align: center;">
																<button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Action
																	<i class="fa fa-angle-down"></i>
																</button>
																<ul class="dropdown-menu" role="menu">
																	<li>
																		<a class="ubahdata" data-toggle="modal" data-target="#ubahdata" id="'.md5($value['presence_id']).'"><i class="icon-wrench"></i> Edit Data</a>
																	</li>
																	<li>
																		<a onclick="'.$return_on_click.'" href="'.site_url('admin_side/hapus_data_kehadiran/'.md5($value['presence_id'])).'">
																			<i class="icon-trash"></i> Delete Data </a>
																	</li>
																</ul>
															</div>
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
						<div class="col-md-12" >
						<hr><a href="<?php echo base_url()."admin_side/laporan_kehadiran"; ?>" class="btn btn-info" role="button"><i class="fa fa-angle-double-left"></i> Back</a></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="ubahdata" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Edit Attendance Data</h4>
			</div>
			<div class="modal-body">
				<div class="box box-primary" id='formubahdata' >
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$.ajaxSetup({
			type:"POST",
			url: "<?php echo site_url(); ?>admin/Report/ajax_function",
			cache: false,
		});
		$('.ubahdata').click(function(){
		var id = $(this).attr("id");
		var modul = 'modul_ubah_data_kehadiran';
		var nilai_token = '<?php echo $this->security->get_csrf_hash();?>';
		$.ajax({
			data: {id:id,modul:modul,<?php echo $this->security->get_csrf_token_name();?>:nilai_token},
			success:function(data){
			$('#formubahdata').html(data);
			$('#ubahdata').modal("show");
			}
		});
		});
	});
</script>
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
		var moretext = "[Show more]";
		var lesstext = "[Show less]";

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