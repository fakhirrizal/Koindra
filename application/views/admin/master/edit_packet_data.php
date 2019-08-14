<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script src="<?=base_url('assets/pages/scripts/components-editors.min.js');?>" type="text/javascript"></script>
<ul class="page-breadcrumb breadcrumb">
	<li>
		<span>Master</span>
		<i class="fa fa-circle"></i>
	</li>
	<li>
		<span>Packet Data</span>
		<i class="fa fa-circle"></i>
	</li>
	<li>
		<span>Edit Data</span>
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
					<form role="form" class="form-horizontal" action="<?=base_url('admin_side/perbarui_data_paket');?>" method="post"  enctype='multipart/form-data'>
						<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
						<input type="hidden" name="packet_id" value='<?= md5($data_utama['packet_id']); ?>'>
						<div class="form-body">
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Packet Name <span class="required"> * </span></label>
								<div class="col-md-10">
									<div class="input-icon">
										<input type="text" class="form-control" name="packet_name" placeholder="Type something" required value='<?= $data_utama['packet_name']; ?>'>
										<div class="form-control-focus"> </div>
										<span class="help-block">Some help goes here...</span>
										<i class="fa fa-bookmark"></i>
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Quota <span class="required"> * </span></label>
								<div class="col-md-10">
									<div class="input-icon">
										<input type="number" class="form-control" name="quota" placeholder="Type something" required max='999' value='<?= $data_utama['quota']; ?>'>
										<div class="form-control-focus"> </div>
										<span class="help-block">Some help goes here...</span>
										<i class="fa fa-archive"></i>
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Duration (Month) <span class="required"> * </span></label>
								<div class="col-md-10">
									<div class="input-icon">
										<input type="number" class="form-control" name="duration" placeholder="Type something" required max="9999" value='<?= $data_utama['duration']; ?>'>
										<div class="form-control-focus"> </div>
										<span class="help-block">Some help goes here...</span>
										<i class="fa fa-hourglass-3"></i>
									</div>
								</div>
							</div>
							<!-- <div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Tanggal Kadaluarsa <span class="required"> * </span></label>
								<div class="col-md-10">
									<div class="input-icon">
										<input type="date" class="form-control" name="expired_date" placeholder="Type something" required value='<?= $data_utama['expired_date']; ?>'>
										<div class="form-control-focus"> </div>
										<span class="help-block">Some help goes here...</span>
										<i class="fa fa-calendar-times-o"></i>
									</div>
								</div>
							</div> -->
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Additional Information</label>
								<div class="col-md-10">
									<div class="input-icon">
										<textarea class="wysihtml5 form-control" rows="6" name='additional_info'><?= $data_utama['additional_info']; ?></textarea>
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Term and Condition</label>
								<div class="col-md-10">
									<div class="input-icon">
										<textarea class="wysihtml5 form-control" rows="6" name='term_and_condition'><?= $data_utama['term_and_condition']; ?></textarea>
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Price <span class="required"> * </span></label>
								<div class="col-md-10">
									<div class="input-icon">
										<input type="number" class="form-control" name="price" placeholder="Type something" required maxlength='10' max="2147483647" value='<?= $data_utama['price']; ?>'>
										<div class="form-control-focus"> </div>
										<span class="help-block">Some help goes here...</span>
										<i class="fa fa-tags"></i>
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