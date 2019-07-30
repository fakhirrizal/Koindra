<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<ul class="page-breadcrumb breadcrumb">
	<li>
		<span>Laporan</span>
		<i class="fa fa-circle"></i>
	</li>
	<li>
		<span>Detail Data Kehadiran</span>
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
			<div class="portlet light ">
				<div class="portlet-body">
					<table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
						<thead>
							<tr>
								<th style="text-align: center;" width="4%"> # </th>
								<th style="text-align: center;" width="15%"> Nama </th>
								<th style="text-align: center;" width="15%"> Tanggal </th>
								<!-- <th style="text-align: center;"> Jam Masuk </th>
								<th style="text-align: center;"> Jam Keluar </th> -->
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
										<td>'.$value['fullname'].'</td>
										<td>'.$this->Main_model->convert_tanggal($value['date']).'</td>
										<td><span class="more">'.$value['note'].'</span></td>
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