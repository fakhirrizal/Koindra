<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<ul class="page-breadcrumb breadcrumb">
	<li>
		<span>Master</span>
		<i class="fa fa-circle"></i>
	</li>
	<li>
		<span>Student Data</span>
		<i class="fa fa-circle"></i>
	</li>
	<li>
		<span>Add Data</span>
	</li>
</ul>
<?= $this->session->flashdata('sukses') ?>
<?= $this->session->flashdata('gagal') ?>
<div class="page-content-inner">
	<div class="m-heading-1 border-green m-bordered">
		<h3>Catatan</h3>
		<p> 1. Kolom isian dengan tanda bintang (<font color='red'>*</font>) adalah wajib untuk di isi.</p>
		<p> 2. Untuk <b>username</b> dan <b>password</b> diambil dari isian <b>Nama Lengkap</b> dan <b>Nama Ibu</b>.</p>
	</div>
	<div class="row">
		<div class="col-md-12">
			<!-- BEGIN EXAMPLE TABLE PORTLET-->
			<div class="portlet light ">
				<div class="portlet-body">
					<form role="form" class="form-horizontal" action="<?=base_url('admin_side/simpan_data_siswa');?>" method="post" enctype='multipart/form-data'>
						<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
						<div class="form-body">
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Fullname <span class="required"> * </span></label>
								<div class="col-md-10">
									<div class="input-icon">
										<input type="text" class="form-control" name="fullname" placeholder="Type something" required>
										<div class="form-control-focus"> </div>
										<span class="help-block">Some help goes here...</span>
										<i class="fa fa-user"></i>
									</div>
								</div>
							</div>
							<!-- <div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Student ID <span class="required"> * </span></label>
								<div class="col-md-10">
									<div class="input-icon">
										<input type="text" class="form-control" name="student_id" placeholder="Type something" required>
										<div class="form-control-focus"> </div>
										<span class="help-block">Some help goes here...</span>
										<i class="icon-credit-card"></i>
									</div>
								</div>
							</div> -->
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Mother's Name <span class="required"> * </span></label>
								<div class="col-md-10">
									<div class="input-icon">
										<input type="text" class="form-control" name="mother" placeholder="Type something" required>
										<div class="form-control-focus"> </div>
										<span class="help-block">Some help goes here...</span>
										<i class="fa fa-user"></i>
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Email</label>
								<div class="col-md-10">
									<div class="input-icon">
										<input type="email" class="form-control" name="email" placeholder="Type something" maxlength='100'>
										<div class="form-control-focus"> </div>
										<span class="help-block">Some help goes here...</span>
										<i class="fa fa-envelope"></i>
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Number Phone</label>
								<div class="col-md-10">
									<div class="input-icon">
										<input type="text" class="form-control" name="number_phone" placeholder="Type something" maxlength='14'>
										<div class="form-control-focus"> </div>
										<span class="help-block">Some help goes here...</span>
										<i class="fa fa-phone"></i>
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Mother's Number Phone</label>
								<div class="col-md-10">
									<div class="input-icon">
										<input type="text" class="form-control" name="mother_phone" placeholder="Type something" maxlength='14'>
										<div class="form-control-focus"> </div>
										<span class="help-block">Some help goes here...</span>
										<i class="fa fa-phone"></i>
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">School <span class="required"> * </span></label>
								<div class="col-md-10">
									<select class='form-control' name='school' required>
										<option value=''>-- Pilih --</option>
										<?php
										foreach ($data_sekolah as $key => $value) {
											echo '<option value="'.$value->school_code.'">'.$value->school_name.'</option>';
										}
										?>
									</select>
								</div>
							</div>
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Class <span class="required"> * </span></label>
								<div class="col-md-10">
									<select class='form-control' name='class' required>
										<option value=''>-- Pilih --</option>
										<?php
										for ($i=1; $i <13 ; $i++) {
											echo '<option value="'.$i.'">'.$i.'</option>';
										}
										?>
									</select>
								</div>
							</div>
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Passcode</label>
								<div class="col-md-10">
									<div class="input-icon">
										<input type="text" class="form-control" name="passcode" placeholder="Type something">
										<div class="form-control-focus"> </div>
										<span class="help-block">Some help goes here...</span>
										<i class="fa fa-lock"></i>
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Status</label>
								<div class="col-md-10">
									<div class="md-radio-inline">
										<div class="md-radio has-success">
											<input type="radio" id="radio14" name="status" class="md-radiobtn" value='Aktif' checked>
											<label for="radio14">
												<span></span>
												<span class="check"></span>
												<span class="box"></span> Active </label>
										</div>
										<div class="md-radio has-warning">
											<input type="radio" id="radio16" name="status" class="md-radiobtn" value='Free Trial'>
											<label for="radio16">
												<span></span>
												<span class="check"></span>
												<span class="box"></span> Free Trial </label>
										</div>
										<div class="md-radio has-error">
											<input type="radio" id="radio15" name="status" class="md-radiobtn" value='Keluar'>
											<label for="radio15">
												<span></span>
												<span class="check"></span>
												<span class="box"></span> Non Active </label>
										</div>
									</div>
								</div>
							</div>
						</div>
						<br>
						<div class="form-actions margin-top-10">
							<div class="row">
								<div class="col-md-offset-2 col-md-10">
									<button type="reset" class="btn default">Clear</button>
									<button type="submit" class="btn blue">Save</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
			<!-- END EXAMPLE TABLE PORTLET-->
		</div>
	</div>
</div>