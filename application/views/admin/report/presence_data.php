<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<ul class="page-breadcrumb breadcrumb">
	<li>
		<span>Report</span>
		<i class="fa fa-circle"></i>
	</li>
	<li>
		<span>Attendance Data</span>
	</li>
</ul>
<?= $this->session->flashdata('sukses') ?>
<?= $this->session->flashdata('gagal') ?>
<div class="page-content-inner">
	<div class="m-heading-1 border-green m-bordered">
		<h3>Note</h3>
		<p> Jika melakukan import data, kemudian ditemukan duplikasi data kehadiran siswa di hari yang sama maka hanya 1 data yang masuk</p>
		<p> Ekstensi yang diijinkan : xlsx </p>
		<p> Ukuran maksimal file : 3MB </p>
	</div>
	<div class="row">
		<div class="col-md-12">
			<!-- BEGIN EXAMPLE TABLE PORTLET-->
			<div class="portlet light ">
				<div class="portlet-body">
					<!-- <form action="#" method="post" onsubmit="return deleteConfirm();"/> -->
					<div class="table-toolbar">
						<div class="row">
							<div class="col-md-8">
								<div class="btn-group">
									<button type='submit' id="sample_editable_1_new" class="btn sbold red"> Delete
										<i class="fa fa-trash"></i>
									</button>
								</div>
									<span class="separator">|</span>
									<a href="#" class="btn green uppercase" data-toggle="modal" data-target="#ft">Add Data <i class="fa fa-plus"></i> </a>
							</div>
							<div class="col-md-4" style='text-align: right;'>
								<a href="#" class="btn btn-info" data-toggle="modal" data-target="#fi">Import Data <i class="fa fa-cloud-upload"></i></a>
								<a href="<?=base_url()?>data_upload/format_data_kehadiran.xlsx" class="btn btn-warning">Import Data Template</a>
							</div>
						</div>
					</div>
					<hr>
					<div style='text-align:center;'>
						<form method='post' action='<?= site_url('admin_side/laporan_kehadiran'); ?>'>
							<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
							<div class="form-group">
								<div class="col-md-1"></div>
								<label class="control-label col-md-2">Select a time range</label>
								<div class="col-md-3">
									<input type="date" class="form-control" name="start" required>
								</div>
								<div class="col-md-3">
									<input type="date" class="form-control" name="end" required>
								</div>
								<div class="col-md-2">
									<button type="submit" class="btn blue">Process</button>
								</div>
								<div class="col-md-1"></div>
							</div>
						</form>
					</div>
					<br>
					<br>
					<br>
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
								<th style="text-align: center;"> Number Phone </th>
								<th style="text-align: center;"> Attendance </th>
								<th style="text-align: center;"> Remaining Quota </th>
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
								<td style="text-align: center;"><?= $value->fullname; ?></td>
								<td style="text-align: center;"><?= $value->number_phone; ?></td>
								<td style="text-align: center;"><?= number_format($value->jumlah_kehadiran).'x'; ?></td>
								<td style="text-align: center;"><?php
								if($value->quota==NULL){
									echo'-';
								}elseif($value->quota=='Unlimited'){echo $value->quota;}else{
									echo $value->quota.' Pertemuan';
								}
								?></td>
								<td>
									<div class="btn-group" style="text-align: center;">
										<button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Action
											<i class="fa fa-angle-down"></i>
										</button>
										<ul class="dropdown-menu" role="menu">
											<li>
												<a href="<?=site_url('admin_side/detail_data_kehadiran/'.md5($value->user_id));?>">
													<i class="icon-eye"></i> Detail Data </a>
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
					<!-- </form> -->
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
			<!-- <h4 class="modal-title" id="exampleModalLabel">Form Import</h4> -->
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<form role="form" action="<?php echo base_url()."admin_side/impor_data_kehadiran"; ?>" method='post' enctype="multipart/form-data">
		<div class="modal-body">
			<div class="form-body">
				<div class="form-group form-md-line-input has-danger">
					<label class="col-md-2 control-label" for="form_control_1">Date <span class="required"> * </span></label>
					<div class="col-md-10">
						<div class="input-icon">
							<input type="date" class="form-control" name="date" placeholder="Type something" required>
						</div>
					</div>
				</div>
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
<div class="modal fade" id="ft" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
		<div class="modal-header">
			<!-- <h4 class="modal-title" id="exampleModalLabel">Form Tambah Data</h4> -->
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<form role="form" action="<?php echo base_url()."admin_side/simpan_data_kehadiran"; ?>" method='post' enctype="multipart/form-data">
		<div class="modal-body">
			<div class="form-body">
				<div class="form-group form-md-line-input has-danger">
					<label class="col-md-2 control-label" for="form_control_1">Date <span class="required"> * </span></label>
					<div class="col-md-10">
						<div class="input-icon">
							<input type="date" class="form-control" name="date" placeholder="Type something" required>
						</div>
					</div>
				</div>
				<div class="form-group form-md-line-input has-danger">
					<label class="col-md-2 control-label" for="form_control_1">Student <span class="required"> * </span></label>
					<div class="col-md-10">
						<div class="input-icon">
							<select class="form-control" name="user_id" required>
								<option value=''>-- Choose --</option>
									<?php
									foreach ($siswa as $key => $value) {
										if($value->status=='Keluar'){
											echo'';
										}else{
											echo "<option value='".$value->user_id."'>".$value->fullname."</option>";
										}
									}
									?>
							</select>
						</div>
					</div>
				</div>
				<div class="form-group form-md-line-input has-danger">
					<label class="col-md-2 control-label" for="form_control_1">Note</label>
					<div class="col-md-10">
						<div class="input-icon">
							<!-- <input class="form-control" type="file" name='fmasuk' required> -->
							<textarea class="form-control" name='note'></textarea>
							<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			<button type="submit" class="btn btn-primary">Save</button>
		</div>
		</form>
		</div>
	</div>
</div>