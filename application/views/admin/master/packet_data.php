<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<ul class="page-breadcrumb breadcrumb">
	<li>
		<span>Master</span>
		<i class="fa fa-circle"></i>
	</li>
	<li>
		<span>Packet Data</span>
	</li>
</ul>
<?= $this->session->flashdata('sukses') ?>
<?= $this->session->flashdata('gagal') ?>
<div class="page-content-inner">
	<div class="m-heading-1 border-green m-bordered">
		<h3>Note</h3>
		<!-- <p> Hanya status <b>aktif</b> yang akan tampil di shop display pengguna</p> -->
	</div>
	<div class="row">
		<div class="col-md-12">
			<!-- BEGIN EXAMPLE TABLE PORTLET-->
			<div class="portlet light ">
				<div class="portlet-body">
					<!-- <div class="form-group select2-bootstrap-prepend" >
						<label class="control-label col-md-2">Opsi pencarian berdasarkan <b>Status</b></label>
						<div class="col-md-5">
							<select id='pilihan' class="form-control select2-allow-clear">
								<option value=""></option>
								<option value="2">Pendaftaran</option>
								<option value="0">Sedang Berlangsung</option>
								<option value="19">Tutup</option>
							</select>
						</div>
					</div>
					<br>
					<hr> -->
					<form action="#" method="post" onsubmit="return deleteConfirm();"/>
					<div class="table-toolbar">
						<div class="row">
							<div class="col-md-6">
								<div class="btn-group">
									<button type='submit' id="sample_editable_1_new" class="btn sbold red"> Delete
										<i class="fa fa-trash"></i>
									</button>
								</div>
									<span class="separator">|</span>
									<a href="<?=base_url('admin_side/tambah_data_paket');?>" class="btn green uppercase">Add Data <i class="fa fa-plus"></i> </a>
								<!-- <button id="sample_editable_1_new" onclick="window.location.href='<?=base_url('Master/admin');?>'" class="btn sbold green"> Tambah Data Baru
									<i class="fa fa-plus"></i>
								</button> -->
							</div>
						</div>
					</div>
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
								<th style="text-align: center;"> Packet Name </th>
								<th style="text-align: center;"> Quota </th>
								<th style="text-align: center;"> Duration </th>
								<th style="text-align: center;"> Price </th>
								<th style="text-align: center;" width="7%"> Action </th>
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
										<input type="checkbox" class="checkboxes" name="selected_id[]" value="<?= $value->packet_id; ?>"/>
										<span></span>
									</label>
								</td>
								<td style="text-align: center;"><?= $no++.'.'; ?></td>
								<td style="text-align: center;"><?= $value->packet_name; ?></td>
								<td style="text-align: center;"><?php
												if($value->quota>0){
												echo $value->quota.'x Attendance';}
												else{
													echo $value->quota;
												} ?></td>
								<td style="text-align: center;"><?= $value->duration.' Month'; ?></td>
								<td style="text-align: center;"><?= 'Rp '.number_format($value->price,0); ?></td>
								<!-- <td style="text-align: center;"><?= $this->Main_model->convert_tanggal($value->expired_date); ?></td> -->
								<td>
									<div class="btn-group" style="text-align: center;">
										<button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Action
											<i class="fa fa-angle-down"></i>
										</button>
										<ul class="dropdown-menu" role="menu">
											<li>
												<a href="<?=site_url('admin_side/detail_data_paket/'.md5($value->packet_id));?>">
													<i class="icon-eye"></i> Detail Data </a>
											</li>
											<li>
												<a href="<?=site_url('admin_side/ubah_data_paket/'.md5($value->packet_id));?>">
													<i class="icon-wrench"></i> Edit Data </a>
											</li>
											<li>
												<a onclick="return confirm('Anda yakin?')" href="<?=site_url('admin_side/hapus_data_paket/'.md5($value->packet_id));?>">
													<i class="icon-trash"></i> Delete Data </a>
											</li>
										</ul>
									</div>
								</td>
							</tr>
							<?php
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
			<!-- END EXAMPLE TABLE PORTLET-->
		</div>
	</div>
</div>