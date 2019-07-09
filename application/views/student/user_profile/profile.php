<link href="<?=base_url('assets/pages/css/profile.min.css');?>" rel="stylesheet" type="text/css" />
<link href="<?=base_url('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css');?>" rel="stylesheet" type="text/css" />
<?php foreach ($data_profil as $key => $value) {?>
<ul class="page-breadcrumb breadcrumb">
	<li>
		<span>Profil Pengguna</span>
	</li>
</ul>
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN PROFILE SIDEBAR -->
		<div class="profile-sidebar">
			<!-- PORTLET MAIN -->
			<div class="portlet light profile-sidebar-portlet ">
				<!-- SIDEBAR USERPIC -->
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
				<!-- END SIDEBAR USERPIC -->
				<!-- SIDEBAR USER TITLE -->
				<div class="profile-usertitle">
					<div class="profile-usertitle-name"> <?php echo $value->fullname; ?> </div>
				</div>
				<!-- END SIDEBAR USER TITLE -->
				<!-- SIDEBAR MENU -->
				<div class="profile-usermenu">
					<ul class="nav">
						<li class="active">
							<a href="#">
								<i class="icon-user"></i> Pengaturan Profil </a>
						</li>
						<li>
							<a href="<?php echo site_url('student/password_setting'); ?>">
								<i class="icon-lock"></i> Pengaturan Kata Sandi </a>
						</li>
						<li>
							<a href="<?php echo site_url('student/email_setting'); ?>">
								<i class="icon-envelope"></i> Pengaturan Email </a>
						</li>
					</ul>
				</div>
				<!-- END MENU -->
			</div>
			<!-- END PORTLET MAIN -->
		</div>
		<!-- END BEGIN PROFILE SIDEBAR -->
		<!-- BEGIN PROFILE CONTENT -->
		<div class="profile-content">
			<div class="row">
				<div class="col-md-12">
					<div class="portlet light ">
						<div class="portlet-title tabbable-line">
							<h4><?= $this->session->flashdata('sukses') ?></h4>
							<h4><?= $this->session->flashdata('gagal') ?></h4>
							<div class="caption caption-md">
								<i class="icon-globe theme-font hide"></i>
								<span class="caption-subject font-blue-madison bold uppercase">Pengaturan Profil</span>
							</div>
							<ul class="nav nav-tabs">
								<li class="active">
									<a href="#tab_1_1" data-toggle="tab">Personal Info</a>
								</li>
								<li>
									<a href="#tab_1_2" data-toggle="tab">Ganti Foto Profil</a>
								</li>
							</ul>
						</div>
						<div class="portlet-body">
							<div class="tab-content">
								<!-- PERSONAL INFO TAB -->
								<div class="tab-pane active" id="tab_1_1">
									<form role="form" action="<?php echo site_url('student/update_profile'); ?>" method="post">
										<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
										<div class="form-group">
											<label class="control-label">Nama</label>
											<div class="input-icon">
											<i class="fa fa-user"></i>
											<input type="text" name="fullname" class="form-control" value="<?php echo $value->fullname; ?>" required/> </div>
										</div>
										<div class="form-group">
											<label class="control-label">Nomor Telpon</label>
											<div class="input-icon">
											<i class="fa fa-phone"></i>
											<input type="text" placeholder="+1 646 580" name="number_phone" class="form-control" value="<?php echo $value->number_phone; ?>" maxlength="14" required/> </div>
										</div>
										<div class="form-group">
											<label class="control-label">Alamat Rumah</label>
											<div class="input-icon">
											<i class="fa fa-road"></i>
											<input type="text" placeholder="Isi alamat sesuai KTP Anda" name="address" class="form-control" value="<?php echo $value->address; ?>" required/> </div>
										</div>
										<div class="form-actions">
											<button type="submit" class="btn green"> Simpan </button>
											<button type="reset" class="btn default"> Hapus </button>
										</div>
									</form>
								</div>
								<!-- END PERSONAL INFO TAB -->
								<!-- CHANGE AVATAR TAB -->
								<div class="tab-pane" id="tab_1_2">
									<div class="m-heading-1 border-green m-bordered">
										<h3>Catatan</h3>
										<p> Ekstensi yang diijinkan : jpg, png, jpeg, dan bmp </p>
										<p> Ukuran maksimal file : 3MB </p>
									</div>
									<form action="<?php echo site_url('student/update_profile_photo'); ?>" role="form" enctype='multipart/form-data' method="post">
										<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
										<div class="form-group">
											<div class="fileinput fileinput-new" data-provides="fileinput">
												<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
													<img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" /> </div>
												<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
												<div>
													<span class="btn default btn-file">
														<span class="fileinput-new"> Pilih gambar </span>
														<span class="fileinput-exists"> Ubah </span>
														<input type="file" name="foto"> </span>
													<a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput"> Hapus </a>
												</div>
											</div>
										</div>
										<div class="form-actions">
											<button type="submit" class="btn green"> Simpan </button>
											<button type="reset" class="btn default"> Hapus </button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- END PROFILE CONTENT -->
	</div>
</div>
<?php } ?>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<!-- memulai untuk konten dinamis -->
				<div class="modal-body" id="data_pend" style="text-align: left;">
				</div>
				<!-- selesai konten dinamis -->
			</div>
		</div>
</div>
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<!-- memulai untuk konten dinamis -->
				<div class="modal-body" id="data_peker" style="text-align: left;">
				</div>
				<!-- selesai konten dinamis -->
			</div>
		</div>
</div>