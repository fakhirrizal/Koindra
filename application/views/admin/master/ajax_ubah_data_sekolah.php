<?php
foreach ($data_utama as $key => $value) {
?>
<form role="form" class="form-horizontal" action="<?=base_url('admin_side/perbarui_data_sekolah');?>" method="post" enctype='multipart/form-data'>
	<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
	<input type='hidden' name='school_id' value='<?= $value->school_id; ?>'>
	<input type="hidden" name="school_code_old" value='<?= $value->school_code; ?>'>
	<div class="form-body">
		<div class="form-group form-md-line-input has-danger">
			<label class="col-md-2 control-label" for="form_control_1">Code of School <span class="required"> * </span></label>
			<div class="col-md-10">
				<div class="input-icon">
					<input type="text" class="form-control" name="school_code" placeholder="Type something" value='<?= $value->school_code; ?>' maxlength='2' required>
					<div class="form-control-focus"> </div>
					<span class="help-block">Some help goes here...</span>
					<i class="icon-direction"></i>
				</div>
			</div>
		</div>
		<div class="form-group form-md-line-input has-danger">
			<label class="col-md-2 control-label" for="form_control_1">School Name <span class="required"> * </span></label>
			<div class="col-md-10">
				<div class="input-icon">
					<input type="text" class="form-control" name="school_name" placeholder="Type something" value='<?= $value->school_name; ?>' required>
					<div class="form-control-focus"> </div>
					<span class="help-block">Some help goes here...</span>
					<i class="icon-graduation"></i>
				</div>
			</div>
		</div>
		<div class="form-group form-md-line-input has-danger">
			<label class="col-md-2 control-label" for="form_control_1">Address</label>
			<div class="col-md-10">
				<div class="input-icon">
					<input type="text" class="form-control" name="address" placeholder="Type something" value='<?= $value->address; ?>'>
					<div class="form-control-focus"> </div>
					<span class="help-block">Some help goes here...</span>
					<i class="fa fa-map"></i>
				</div>
			</div>
		</div>
		<div class="form-group form-md-line-input has-danger">
			<label class="col-md-2 control-label" for="form_control_1">Number Phone</label>
			<div class="col-md-10">
				<div class="input-icon">
					<input type="text" class="form-control" name="number_phone" placeholder="Type something" value='<?= $value->number_phone; ?>'>
					<div class="form-control-focus"> </div>
					<span class="help-block">Some help goes here...</span>
					<i class="fa fa-phone"></i>
				</div>
			</div>
		</div>
	</div>
	<br>
	<div class="form-actions margin-top-10">
		<div class="row">
			<div class="col-md-offset-2 col-md-10">
				<button type="reset" class="btn default">Clear</button>
				<button type="submit" class="btn blue">Update</button>
			</div>
		</div>
	</div>
</form>
<?php
}
?>