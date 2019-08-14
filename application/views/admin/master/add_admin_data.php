<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script src="<?=base_url('assets/pages/scripts/components-editors.min.js');?>" type="text/javascript"></script>
<ul class="page-breadcrumb breadcrumb">
	<li>
		<span>Master</span>
		<i class="fa fa-circle"></i>
	</li>
	<li>
		<span>Administrator Data</span>
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
		<h3>Note</h3>
		<p> Fields with (<font color='red'>*</font>) are required.</p>
	</div>
	<div class="row">
		<div class="col-md-12">
			<!-- BEGIN EXAMPLE TABLE PORTLET-->
			<div class="portlet light ">
				<div class="portlet-body">
					<form role="form" class="form-horizontal" action="<?=base_url('admin_side/simpan_data_admin');?>" method="post" enctype='multipart/form-data'>
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
							<hr>
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Username <span class="required"> * </span></label>
								<div class="col-md-10">
									<div class="input-icon">
										<input type="text" class="form-control" name="username" placeholder="Type something" required>
										<div class="form-control-focus"> </div>
										<span class="help-block">Some help goes here...</span>
										<i class="icon-user-following"></i>
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Password <span class="required"> * </span></label>
								<div class="col-md-10">
									<div class="input-icon">
										<input type="password" class="form-control" name="password" placeholder="Type something" required>
										<div class="form-control-focus"> </div>
										<span class="help-block">Some help goes here...</span>
										<i class="fa fa-lock"></i>
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