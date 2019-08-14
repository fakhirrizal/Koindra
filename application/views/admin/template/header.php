<?php
if(($this->session->userdata('id'))==NULL){
            echo "<script>alert('Harap login terlebih dahulu')</script>";
            echo "<script>window.location='".base_url()."'</script>";
        }
else{
?>
<!DOCTYPE html>
<!--
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.6
Version: 4.5.6
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
Renew Support: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

	<head>
		<meta charset="utf-8" />
		<title>Apps</title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta content="width=device-width, initial-scale=1" name="viewport" />
		<meta content="" name="description" />
		<meta content="" name="author" />
		<!-- BEGIN GLOBAL MANDATORY STYLES -->
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
		<link href="<?=base_url('assets/global/plugins/font-awesome/css/font-awesome.min.css');?>" rel="stylesheet" type="text/css" />
		<link href="<?=base_url('assets/global/plugins/simple-line-icons/simple-line-icons.min.css');?>" rel="stylesheet" type="text/css" />
		<link href="<?=base_url('assets/global/plugins/bootstrap/css/bootstrap.min.css');?>" rel="stylesheet" type="text/css" />
		<link href="<?=base_url('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css');?>" rel="stylesheet" type="text/css" />
		<!-- END GLOBAL MANDATORY STYLES -->
		<!-- BEGIN THEME GLOBAL STYLES -->
		<link href="<?=base_url('assets/global/plugins/datatables/datatables.min.css');?>" rel="stylesheet" type="text/css" />
		<link href="<?=base_url('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css');?>" rel="stylesheet" type="text/css" />
		<link href="<?=base_url('assets/global/plugins/select2/css/select2.min.css');?>" rel="stylesheet" type="text/css" />
		<link href="<?=base_url('assets/global/plugins/select2/css/select2-bootstrap.min.css');?>" rel="stylesheet" type="text/css" />
		<link href="<?=base_url('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css');?>" rel="stylesheet" type="text/css" />
		<link href="<?=base_url('assets/global/plugins/cubeportfolio/css/cubeportfolio.css');?>" rel="stylesheet" type="text/css" />
		<link href="<?=base_url('assets/global/plugins/ladda/ladda-themeless.min.css');?>" rel="stylesheet" type="text/css" />
		<link href="<?=base_url('assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css');?>" rel="stylesheet" type="text/css" />
		<link href="<?=base_url('assets/global/css/components-md.min.css');?>" rel="stylesheet" id="style_components" type="text/css" />
		<link href="<?=base_url('assets/global/css/plugins-md.min.css');?>" rel="stylesheet" type="text/css" />
		<link href="<?=base_url('assets/pages/css/blog.min.css');?>" rel="stylesheet" type="text/css" />
		<!-- END THEME GLOBAL STYLES -->
		<!-- BEGIN THEME LAYOUT STYLES -->
		<link href="<?=base_url('assets/layouts/layout3/css/layout.min.css');?>" rel="stylesheet" type="text/css" />
		<link href="<?=base_url('assets/layouts/layout3/css/themes/default.min.css');?>" rel="stylesheet" type="text/css" id="style_color" />
		<link href="<?=base_url('assets/layouts/layout3/css/custom.min.css');?>" rel="stylesheet" type="text/css" />
		<!-- END THEME LAYOUT STYLES -->
		<!-- <link href="https://iconverticons.com/img/logo.png" rel="icon" type="image/x-icon"> -->
		<link href="<?=site_url('assets/1.ico');?>" rel="icon" type="image/x-icon">
	</head>
    <!-- END HEAD -->

		<body class="page-container-bg-solid page-md">
		<!-- BEGIN HEADER -->
		<div class="page-header">
			<!-- BEGIN HEADER TOP -->
			<div class="page-header-top">
				<div class="container">
					<!-- BEGIN LOGO -->
					<div class="page-logo">
						<a href="javascript:;">
							<!-- <img src="https://www.debanensite.nl/files/thumb/d/e/logo_D_300_300_demaco.jpg" alt="logo" class="logo-default"> -->
							<img src="<?= base_url('assets/4.PNG'); ?>" alt="logo" class="logo-default" width='112px' height='32px'>
						</a>
					</div>
					<!-- END LOGO -->
					<!-- BEGIN RESPONSIVE MENU TOGGLER -->
					<a href="javascript:;" class="menu-toggler"></a>
					<!-- END RESPONSIVE MENU TOGGLER -->
					<!-- BEGIN TOP NAVIGATION MENU -->
					<div class="top-menu">
						<ul class="nav navbar-nav pull-right">
							<!-- <li class="dropdown dropdown-extended dropdown-notification dropdown-dark" id="header_notification_bar">
								<a href="<?= base_url().'admin_side/launcher'; ?>" class="dropdown-toggle" title="Go To Launcher">
									<i class="icon-grid"></i>
									<span class="badge badge-default"></span>
								</a>
							</i> -->
							<li class="dropdown dropdown-extended dropdown-notification dropdown-dark" id="header_notification_bar">
								<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
									<i class="icon-bell"></i>
									<?php
									$get_notif = $this->Main_model->getSelectedData('purchasing a', 'a.*,b.fullname', array('a.status'=>'Pending','a.deleted'=>'0'), "",'','','',array(
										'table' => 'user_profile b',
										'on' => 'a.user_id=b.user_id',
										'pos' => 'left',
									))->result();
									if($get_notif==NULL){
										echo'';
									}else{
										echo '<span class="badge badge-default">'.count($get_notif).'</span>';
									}
									?>
								</a>
								<ul class="dropdown-menu">
									<?php
									if($get_notif!=NULL){
									?>
									<li class="external">
										<h3>Total:
											<strong><?= count($get_notif); ?> Transaksi</strong></h3>
										<?= '<a href="'.site_url('admin_side/pembayaran').'">Lihat Semua</a>' ?>
									</li>
									<li>
										<ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">
											<?php
											foreach ($get_notif as $key => $value) {
												echo'
												<li>
													<a href="javascript:;">
														<span class="details">
															<span class="label label-sm label-icon label-warning">
																<i class="fa fa-exchange"></i>
															</span> '.$value->fullname.' sebesar Rp '.number_format($value->grand_total,2).'</span>
													</a>
												</li>
												';
											}
											?>
										</ul>
									</li>
									<?php
									}else{
										echo'<li class="external"><h3><strong>Tidak ada transaksi</strong></h3></li>';
									}
									?>
								</ul>
							</li>
							<li class="droddown dropdown-separator">
								<span class="separator"></span>
							</li>
							<!-- BEGIN USER LOGIN DROPDOWN -->
							<li class="dropdown dropdown-user dropdown-dark">
								<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
									<!-- <img alt="" class="img-circle" src="https://cdn1.iconfinder.com/data/icons/rcons-user-action/512/user-512.png"> -->
									<?php
										$get_profile = $this->Main_model->getSelectedData('user_profile a', 'a.*', array('a.user_id'=>$this->session->userdata('id')))->row();
										if($get_profile->photo==NULL){
											echo '<img alt="" class="img-circle" src="https://cdn1.iconfinder.com/data/icons/rcons-user-action/512/user-512.png">';
										}else{
											echo '<img alt="" class="img-circle" src="'.base_url('assets/photo_profile/').$get_profile->photo.'">';
										}
									?>
									<span class="username username-hide-mobile"><?php if($get_profile->fullname==''){echo'Administrator';}else{echo $get_profile->fullname;} ?></span>
								</a>
								<ul class="dropdown-menu dropdown-menu-default">
									<li>
										<a href="<?php echo site_url('admin_side/profile'); ?>">
											<i class="icon-user"></i> Profil </a>
									</li>
									<li>
										<a href="<?php echo site_url('admin_side/bantuan'); ?>">
											<i class="icon-rocket"></i> Bantuan
											<!-- <span class="badge badge-success"> 7 </span> -->
										</a>
									</li>
									<li class="divider"> </li>
									<!-- <li>
										<a href="page_user_lock_1.html">
											<i class="icon-lock"></i> Lock Screen </a>
									</li> -->
									<li>
										<a href="<?php echo site_url('Auth/logout'); ?>">
											<i class="icon-key"></i> Keluar </a>
									</li>
								</ul>
							</li>
							<!-- END USER LOGIN DROPDOWN -->
						</ul>
					</div>
					<!-- END TOP NAVIGATION MENU -->
				</div>
			</div>
			<!-- END HEADER TOP -->
			<!-- BEGIN HEADER MENU -->
			<div class="page-header-menu">
				<div class="container">
					<!-- BEGIN HEADER SEARCH BOX -->
					<form class="search-form" action="javascript:;" method="GET">
						<div class="input-group">
							<input type="text" class="form-control" placeholder="Search" name="query">
							<span class="input-group-btn">
								<a href="javascript:;" class="btn submit">
									<i class="icon-magnifier"></i>
								</a>
							</span>
						</div>
					</form>
					<!-- END HEADER SEARCH BOX -->
					<!-- BEGIN MEGA MENU -->
					<!-- DOC: Apply "hor-menu-light" class after the "hor-menu" class below to have a horizontal menu with white background -->
					<!-- DOC: Remove data-hover="dropdown" and data-close-others="true" attributes below to disable the dropdown opening on mouse hover -->
					<div class="hor-menu  ">
						<ul class="nav navbar-nav">
							<li class="menu-dropdown classic-menu-dropdown <?php if($parent=='home'){echo 'active';}else{echo '';} ?>">
								<a href="<?php echo site_url('admin_side/beranda'); ?>"><i class="icon-home"></i> Home
								</a>
							</li>
							<li class="menu-dropdown classic-menu-dropdown <?php if($parent=='master'){echo 'active';}else{echo '';} ?>">
								<a href="javascript:;"><i class="icon-drawer"></i> Master
									<span class="arrow <?php if($parent=='master'){echo 'open';}else{echo '';} ?>"></span>
								</a>
								<ul class="dropdown-menu pull-left">
									<li class=" <?php if($child=='administrator'){echo 'active';}else{echo '';} ?>">
										<a href="<?php echo site_url('admin_side/administrator'); ?>" class="nav-link nav-toggle ">
											<i class="icon-user-following"></i> Administrator Data
										</a>
									</li>
									<li class=" <?php if($child=='student'){echo 'active';}else{echo '';} ?>">
										<a href="<?php echo site_url('admin_side/siswa'); ?>" class="nav-link nav-toggle ">
											<i class="icon-users"></i> Student Data
										</a>
									</li>
									<li class=" <?php if($child=='school'){echo 'active';}else{echo '';} ?>">
										<a href="<?php echo site_url('admin_side/sekolah'); ?>" class="nav-link nav-toggle ">
											<i class="icon-graduation"></i> School Data
										</a>
									</li>
									<li class=" <?php if($child=='packet'){echo 'active';}else{echo '';} ?>">
										<a href="<?php echo site_url('admin_side/paket'); ?>" class="nav-link nav-toggle ">
											<i class="icon-layers"></i> Packet Data
										</a>
									</li>
								</ul>
							</li>
							<li class="menu-dropdown classic-menu-dropdown <?php if($parent=='payment'){echo 'active';}else{echo '';} ?>">
								<a href="<?php echo site_url('admin_side/pembayaran'); ?>"><i class="icon-wallet"></i> Payment
								</a>
							</li>
							<li class="menu-dropdown classic-menu-dropdown <?php if($parent=='report'){echo 'active';}else{echo '';} ?>">
								<a href="javascript:;"><i class="icon-notebook"></i> Report
									<span class="arrow <?php if($parent=='report'){echo 'open';}else{echo '';} ?>"></span>
								</a>
								<ul class="dropdown-menu pull-left">
									<li class=" <?php if($child=='presence'){echo 'active';}else{echo '';} ?>">
										<a href="<?php echo site_url('admin_side/laporan_kehadiran'); ?>" class="nav-link nav-toggle ">
											<i class="fa fa-check"></i> Attendance Data
										</a>
									</li>
								</ul>
							</li>
							<li class="menu-dropdown classic-menu-dropdown <?php if($parent=='log_activity'){echo 'active';}else{echo '';} ?>">
								<a href="<?php echo site_url('admin_side/log_activity'); ?>"><i class="fa fa-rss"></i> Log Activity
								</a>
							</li>
							<!-- <li class="menu-dropdown classic-menu-dropdown <?php if($parent=='about'){echo 'active';}else{echo '';} ?>">
								<a href="<?php echo site_url('admin_side/tentang_aplikasi'); ?>"><i class="icon-bulb"></i> About Application
								</a>
							</li> -->
						</ul>
					</div>
					<!-- END MEGA MENU -->
				</div>
			</div>
			<!-- END HEADER MENU -->
		</div>
		<!-- END HEADER -->
		<!-- BEGIN CONTAINER -->
		<div class="page-container">
			<!-- BEGIN CONTENT -->
			<div class="page-content-wrapper">
				<!-- BEGIN CONTENT BODY -->
				<!-- BEGIN PAGE HEAD-->
				<div class="page-head">
					<div class="container">
						<!-- BEGIN PAGE TITLE -->
						<div class="page-title">
							<h1>Dashboard
								<small>Sistem Informasi</small>
							</h1>
						</div>
						<!-- END PAGE TITLE -->
						<!-- BEGIN PAGE TOOLBAR -->
						<div class="page-toolbar">
							<!-- BEGIN THEME PANEL -->
							<div class="btn-group btn-theme-panel">
								<a href="#" title="Setting Informasi Aplikasi" class="btn dropdown-toggle" >
									<i class="icon-settings"></i>
								</a>
							</div>
						</div>
						<!-- END PAGE TOOLBAR -->
					</div>
				</div>
				<!-- END PAGE HEAD-->
				<!-- BEGIN PAGE CONTENT BODY -->
				<div class="page-content">
					<div class="container">
						<!-- BEGIN PAGE BREADCRUMBS -->
<?php } ?>