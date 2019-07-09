<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<ul class="page-breadcrumb breadcrumb">
	<li>
		<span>Master</span>
		<i class="fa fa-circle"></i>
	</li>
	<li>
		<span>Data Paket</span>
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
						$status = '';
						if(isset($data_utama)){
							foreach($data_utama as $row)
							{
								$status = $row->is_active;
						?>
								<div class="col-md-12">
									<table class="table">
										<tbody>
											<tr>
												<td> Nama Paket </td>
												<td> : </td>
												<td><?php echo $row->packet_name; ?></td>
											</tr>
											<tr>
												<td> Kuota </td>
												<td> : </td>
												<td><?php echo $row->quota.'x Pertemuan'; ?></td>
											</tr>
											<tr>
												<td> Durasi </td>
												<td> : </td>
												<td><?php echo $row->duration.' Hari'; ?></td>
											</tr>
											<tr>
												<td> Tanggal Kadaluarsa </td>
												<td> : </td>
												<td><?php echo $this->Main_model->convert_tanggal($row->expired_date); ?></td>
											</tr>
											<tr>
												<td> Informasi Tambahan </td>
												<td> : </td>
												<td><?php echo $row->additional_info; ?></td>
											</tr>
											<tr>
												<td> Syarat dan Ketentuan </td>
												<td> : </td>
												<td><?php echo $row->term_and_condition; ?></td>
											</tr>
											<tr>
												<td> Harga </td>
												<td> : </td>
												<td><?php echo 'Rp '.number_format($row->price,2); ?></td>
											</tr>
											<tr>
												<td> Status </td>
												<td> : </td>
												<td><?php if($status=='1'){echo'<span class="label label-sm label-success"> Aktif </span>';}else{echo'<span class="label label-sm label-danger"> Tidak Aktif </span>';} ?></td>
											</tr>
										</tbody>
									</table>
								</div>
						<?php }}if($status=='0'){echo'';}else{ ?>
						<div class="col-md-12" >
							<div class="tabbable-line">
								<ul class="nav nav-tabs ">
									<li class="active">
										<a href="#tab_15_1" data-toggle="tab"> Pengguna Aktif </a>
									</li>
								</ul>
								<div class="tab-content">
									<div class="tab-pane active" id="tab_15_1">
										<table class="table table-striped table-bordered table-hover order-column" id="sample_1">
											<thead>
												<tr>
													<th style="text-align: center;" width="4%"> # </th>
													<th style="text-align: center;"> Nama Siswa </th>
													<th style="text-align: center;"> Sisa Kuota </th>
													<th style="text-align: center;"> Jatuh Tempo </th>
													<th style="text-align: center;"> Aksi </th>
												</tr>
											</thead>
											<tbody>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div><?php } ?>
						<div class="col-md-12" >
						<hr><a href="<?php echo base_url()."admin_side/paket"; ?>" class="btn btn-info" role="button"><i class="fa fa-angle-double-left"></i> Kembali</a></div>
					</div>
				</div>
			</div>
			<!-- END EXAMPLE TABLE PORTLET-->
		</div>
	</div>
</div>