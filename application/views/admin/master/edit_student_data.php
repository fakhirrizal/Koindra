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
		<span>Ubah Data</span>
	</li>
</ul>
<?= $this->session->flashdata('sukses') ?>
<?= $this->session->flashdata('gagal') ?>
<div class="page-content-inner">
	<div class="m-heading-1 border-green m-bordered">
		<h3>Catatan</h3>
		<!-- <p> 1. Ekstensi foto yang diizinkan <b>jpg</b>, <b>png</b>, <b>jpeg</b>, dan <b>bmp</b>.</p>
		<p> 2. Ukuran maksimal file yang akan diupload sebesar <b>3Mb</b>.</p>
		<p> 3. Untuk <b>username</b> dan <b>password</b> diambil dari isian <b>Nama Lengkap</b> dan <b>Nama Ibu</b>.</p> -->
	</div>
	<div class="row">
		<div class="col-md-12">
			<!-- BEGIN EXAMPLE TABLE PORTLET-->
			<div class="portlet light ">
				<div class="portlet-body">
					<form role="form" class="form-horizontal" action="<?=base_url('admin_side/perbarui_data_siswa');?>" method="post"  enctype='multipart/form-data'>
						<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
						<?php
						foreach ($data_utama as $key => $value) {
						?>
						<input type="hidden" name="user_id" value='<?= md5($value->user_id); ?>'>
						<div class="form-body">
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Nama Lengkap <span class="required"> * </span></label>
								<div class="col-md-10">
									<div class="input-icon">
										<input type="text" class="form-control" name="fullname" placeholder="Type something" value='<?= $value->fullname; ?>' required>
										<div class="form-control-focus"> </div>
										<span class="help-block">Some help goes here...</span>
										<i class="fa fa-user"></i>
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">No. Induk <span class="required"> * </span></label>
								<div class="col-md-10">
									<div class="input-icon">
										<input type="text" class="form-control" name="student_id" placeholder="Type something" value='<?= $value->student_id; ?>' required>
										<div class="form-control-focus"> </div>
										<span class="help-block">Some help goes here...</span>
										<i class="icon-credit-card"></i>
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Nama Ibu Kandung <span class="required"> * </span></label>
								<div class="col-md-10">
									<div class="input-icon">
										<input type="text" class="form-control" name="mother" placeholder="Type something" value='<?= $value->mother; ?>' required>
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
										<input type="email" class="form-control" name="email" placeholder="Type something" value='<?= $value->email; ?>' maxlength='100'>
										<div class="form-control-focus"> </div>
										<span class="help-block">Some help goes here...</span>
										<i class="fa fa-envelope"></i>
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Nomor HP</label>
								<div class="col-md-10">
									<div class="input-icon">
										<input type="text" class="form-control" name="number_phone" placeholder="Type something" value='<?= $value->number_phone; ?>' maxlength='14'>
										<div class="form-control-focus"> </div>
										<span class="help-block">Some help goes here...</span>
										<i class="fa fa-phone"></i>
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Nomor HP Ibu</label>
								<div class="col-md-10">
									<div class="input-icon">
										<input type="text" class="form-control" name="mother_phone" placeholder="Type something" value='<?= $value->mother_phone; ?>' maxlength='14'>
										<div class="form-control-focus"> </div>
										<span class="help-block">Some help goes here...</span>
										<i class="fa fa-phone"></i>
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Asal Sekolah</label>
								<div class="col-md-10">
									<select class='form-control' name='school' required>
										<option value=''>-- Pilih --</option>
										<?php
										foreach ($data_sekolah as $key => $value2) {
											if($value2->school_code=$value->school){
												echo '<option value="'.$value2->school_code.'" selected>'.$value2->school_name.'</option>';
											}else{
												echo '<option value="'.$value2->school_code.'">'.$value2->school_name.'</option>';
											}
										}
										?>
									</select>
								</div>
							</div>
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Kelas</label>
								<div class="col-md-10">
									<!-- <div class="input-icon">
										<input type="text" class="form-control" name="class" placeholder="Type something" value='<?= $value->class; ?>'>
										<div class="form-control-focus"> </div>
										<span class="help-block">Some help goes here...</span>
										<i class="fa fa-level-up"></i>
									</div> -->
									<select class='form-control' name='class' required>
										<option value=''>-- Pilih --</option>
										<?php
										for ($i=1; $i <13 ; $i++) {
											if($i==$value->class){
												echo '<option value="'.$i.'" selected>'.$i.'</option>';
											}else{
												echo '<option value="'.$i.'">'.$i.'</option>';}
										}
										?>
									</select>
								</div>
							</div>
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Passcode</label>
								<div class="col-md-10">
									<div class="input-icon">
										<input type="text" class="form-control" name="passcode" placeholder="Type something" value='<?= $value->passcode; ?>'>
										<div class="form-control-focus"> </div>
										<span class="help-block">Some help goes here...</span>
										<i class="icon-lock"></i>
									</div>
								</div>
							</div>
						</div>
						<?php } ?>
						<br>
						<div class="form-actions margin-top-10">
							<div class="row">
								<div class="col-md-offset-2 col-md-10">
									<button type="reset" class="btn default">Batal</button>
									<button type="submit" class="btn blue">Simpan</button>
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