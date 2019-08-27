<link href="<?=base_url('assets/pages/css/profile.min.css');?>" rel="stylesheet" type="text/css" />
<link href="<?=base_url('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css');?>" rel="stylesheet" type="text/css" />
<script src="<?=base_url('assets/global/plugins/jquery-validation/js/jquery.validate.min.js');?>" type="text/javascript"></script>
<?php foreach ($data_profil as $key => $value) {?>
<ul class="page-breadcrumb breadcrumb">
	<li>
		<span>Profile</span>
		<i class="fa fa-circle"></i>
	</li>
	<li>
		<span>Email</span>
	</li>
</ul>
<div class="row">
	<div class="col-md-12">
		<div class="profile-sidebar">
			<div class="portlet light profile-sidebar-portlet ">
				<div class="profile-userpic">
				<?php
					if(empty($value->photo)){
						echo '<img src="https://cdn1.iconfinder.com/data/icons/rcons-user-action/512/user-512.png" class="img-responsive" alt="">';
					}
					else{
						echo '<img src="'.base_url('assets/photo_profile/').$value->photo.'" class="img-responsive" alt="">';
					}
				?>
				</div>
				<div class="profile-usertitle">
					<div class="profile-usertitle-name"> <?php echo $value->fullname; ?> </div>
				</div>
				<div class="profile-usermenu">
					<ul class="nav">
						<li >
							<a href="<?php echo site_url('student/profile'); ?>">
								<i class="icon-user"></i> Profile Setting </a>
						</li>
						<li>
							<a href="<?php echo site_url('student/password_setting'); ?>">
								<i class="icon-lock"></i> Password Setting </a>
						</li>
						<li class="active">
							<a href="#">
								<i class="icon-envelope"></i> Email Setting </a>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="profile-content">
			<div class="row">
				<div class="col-md-12">
					<div class="portlet light ">
						<div class="portlet-title tabbable-line">
							<h4><?= $this->session->flashdata('sukses') ?></h4>
							<h4><?= $this->session->flashdata('gagal') ?></h4>
							<div class="caption caption-md">
								<i class="icon-globe theme-font hide"></i>
								<span class="caption-subject font-blue-madison bold uppercase">Email Setting</span>
							</div>
							<ul class="nav nav-tabs">
								<li class="active">
									<a href="#tab_1_1" data-toggle="tab">Update Email</a>
								</li>
							</ul>
						</div>
						<div class="portlet-body">
							<div class="tab-content">
								<div class="tab-pane active" id="tab_1_1">
									<form class="login-form" action="<?php echo site_url('student/update_email'); ?>" method="post">
										<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
										<div class="form-group">
											<label class="control-label">Current Email</label>
											<div class="input-icon">
												<i class="fa fa-envelope"></i>
												<input value="<?php echo $value->email; ?>" class="form-control placeholder-no-fix" name="email" readonly/> </div>
										</div>
										<div class="form-group">
											<label class="control-label">Current Password</label>
											<div class="input-icon">
												<i class="fa fa-lock"></i>
												<input class="form-control placeholder-no-fix" type="password" name="pass" placeholder="Password" maxlength="20" /> </div>
										</div>
										<div class="form-group">
											<label class="control-label">New Email</label>
											<div class="input-icon">
												<i class="fa fa-envelope"></i>
												<input class="form-control placeholder-no-fix" type="email" autocomplete="off" placeholder="Email" name="email_new" maxlength="50" /> </div>
										</div>
										<div class="form-actions">
											<button type="submit" class="btn green"> Change Email </button>
											<button type="reset" class="btn default"> Reset </button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } ?>
