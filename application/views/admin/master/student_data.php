<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<ul class="page-breadcrumb breadcrumb">
	<li>
		<span>Master</span>
		<i class="fa fa-circle"></i>
	</li>
	<li>
		<span>Student Data</span>
	</li>
</ul>
<?= $this->session->flashdata('sukses') ?>
<?= $this->session->flashdata('gagal') ?>
<div class="page-content-inner">
	<div class="m-heading-1 border-green m-bordered">
		<h3>Catatan</h3>
		<p> Ekstensi yang diijinkan : xlsx </p>
		<p> Pada saat import data, isian dari <b>No. Anggota</b> akan dijadikan <b>username</b> dan <b>password</b> untuk masuk ke sistem. </p>
		<p> Ukuran maksimal file : 3MB </p>
		<p> Ketika mengklik <b>Atur Ulang Sandi</b>, maka kata sandi otomatis menjadi "<b>1234</b>"</p>
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
							<div class="col-md-8">
								<div class="btn-group">
									<button type='submit' id="sample_editable_1_new" class="btn sbold red"> Delete
										<i class="fa fa-trash"></i>
									</button>
								</div>
									<span class="separator">|</span>
									<a href="<?=base_url('admin_side/tambah_data_siswa');?>" class="btn green uppercase">Add Data <i class="fa fa-plus"></i> </a>
									<!-- <button id="sample_editable_1_new" onclick="window.location.href='<?=base_url('Master/admin');?>'" class="btn sbold green"> Tambah Data Baru
										<i class="fa fa-plus"></i>
									</button> -->
							</div>
							<div class="col-md-4" style='text-align: right;'>
								<a href="#" class="btn btn-info" data-toggle="modal" data-target="#fi">Import Data <i class="fa fa-cloud-upload"></i></a>
								<a href="<?=base_url()?>data_upload/format_data_siswa.xlsx" class="btn btn-warning">Import Data Template</a>
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
								<th style="text-align: center;"> Name </th>
								<th style="text-align: center;"> Student ID </th>
								<th style="text-align: center;"> Number Phone </th>
								<th style="text-align: center;"> Status </th>
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
										<input type="checkbox" class="checkboxes" name="selected_id[]" value="<?= $value->student_id; ?>"/>
										<span></span>
									</label>
								</td>
								<td style="text-align: center;"><?= $no++.'.'; ?></td>
								<td style="text-align: left;"><?= $value->fullname; ?></td>
								<td style="text-align: center;"><?= $value->student_id; ?></td>
								<td style="text-align: center;"><?= $value->number_phone; ?></td>
								<td style="text-align: center;"><?php
								if($value->status=='Aktif'){
									echo'<span class="label label-primary"> Active </span>';
								}elseif($value->status=='Free Trial'){
									echo'<span class="label label-warning"> Free Trial </span>';
								}else{
									echo'<span class="label label-danger"> Non Active </span>';
								}
								?></td>
								<td>
									<div class="btn-group" style="text-align: center;">
										<button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Action
											<i class="fa fa-angle-down"></i>
										</button>
										<ul class="dropdown-menu" role="menu">
											<li>
												<a href="<?=site_url('admin_side/detail_data_siswa/'.md5($value->user_id));?>">
													<i class="icon-eye"></i> Detail Data </a>
											</li>
											<li>
												<a href="<?=site_url('admin_side/ubah_data_siswa/'.md5($value->user_id));?>">
													<i class="icon-wrench"></i> Edit Data </a>
											</li>
											<li>
												<a onclick="return confirm('Anda yakin?')" href="<?=site_url('admin_side/hapus_data_siswa/'.md5($value->user_id));?>">
													<i class="icon-trash"></i> Delete Data </a>
											</li>
											<li class="divider"> </li>
											<li>
												<a href="<?=site_url('admin_side/atur_ulang_kata_sandi_siswa/'.md5($value->user_id));?>">
													<i class="fa fa-refresh"></i> Reset Password
												</a>
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
<div class="modal fade" id="fi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
		<div class="modal-header">
			<!-- <h5 class="modal-title" id="exampleModalLabel">Form Import</h5> -->
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<form role="form" action="<?php echo base_url()."admin_side/impor_data_siswa"; ?>" method='post' enctype="multipart/form-data">
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