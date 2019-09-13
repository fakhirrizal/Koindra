<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
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
		<span>Detail Data</span>
	</li>
</ul>
<?= $this->session->flashdata('sukses') ?>
<?= $this->session->flashdata('gagal') ?>
<div class="page-content-inner">
	<div class="m-heading-1 border-green m-bordered">
		<h3>Note</h3>
		<!-- <p>Pesan pemberitahuan kepada siswa akan dikirimkan via email.</p> -->
	</div>
	<div class="row">
		<div class="col-md-12">
			<!-- BEGIN EXAMPLE TABLE PORTLET-->
			<div class="portlet light ">
				<div class="portlet-body">
					<div class='row'>
						<?php
						$status = '';
						if(isset($data_utama)){
							foreach($data_utama as $row)
							{
						?>
								<div class="col-md-12">
									<table class="table">
										<tbody>
											<tr>
												<td> School Name </td>
												<td> : </td>
												<td><?php echo $row->school_name; ?></td>
											</tr>
											<tr>
												<td> Code of School </td>
												<td> : </td>
												<td><?php echo $row->school_code; ?></td>
											</tr>
											<tr>
												<td> Address </td>
												<td> : </td>
												<td><?php echo $row->address; ?></td>
											</tr>
											<tr>
												<td> Number Phone </td>
												<td> : </td>
												<td><?php echo $row->number_phone; ?></td>
											</tr>
										</tbody>
									</table>
								</div>
						<?php }}if($status=='0'){echo'';}else{ ?>
						<div class="col-md-12" >
							<div class="tabbable-line">
								<ul class="nav nav-tabs ">
									<li class="active">
										<a href="#tab_15_1" data-toggle="tab"> Student Data </a>
									</li>
								</ul>
								<div class="tab-content">
									<div class="tab-pane active" id="tab_15_1">
										<table class="table table-striped table-bordered table-hover order-column" id="sample_1">
											<thead>
												<tr>
													<th width="3%">
														<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
															<input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" />
															<span></span>
														</label>
													</th>
													<th style="text-align: center;" width="4%"> # </th>
													<th style="text-align: center;"> Student Name </th>
													<th style="text-align: center;"> Remaining Quota </th>
													<th style="text-align: center;"> Expired Date </th>
													<th style="text-align: center;"> Action </th>
												</tr>
											</thead>
											<tbody>
												<?php
												$no = 1;
												foreach ($data_siswa as $key => $value) {
												?>
												<tr class="odd gradeX">
													<td style="text-align: center;">
														<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
															<input type="checkbox" class="checkboxes" name="selected_id[]" value="<?= $value->user_id; ?>"/>
															<span></span>
														</label>
													</td>
													<td style="text-align: center;"><?= $no++.'.'; ?></td>
													<td style="text-align: center;"><?= $value->fullname; ?></td>
													<td style="text-align: center;"><?php
													if($value->quota==NULL){
														echo'-';
													}else{ echo $value->quota.'x Attendance';} ?></td>
													<td style="text-align: center;"><?php
													if($value->expired_date==NULL){
														echo'-';
													}else{
														echo $this->Main_model->convert_tanggal($value->expired_date);} ?></td>
													<td width='5%'>
														<div class="btn-group" style="text-align: center;">
															<button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Action
																<i class="fa fa-angle-down"></i>
															</button>
															<ul class="dropdown-menu" role="menu">
																<li>
																	<a href="<?=site_url('admin_side/kirim_pemberitahuan/'.md5($value->last_packet).'/'.md5($value->user_id));?>">
																		<i class="icon-paper-plane"></i> Send Notification </a>
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
									</div>
								</div>
							</div>
						</div><?php } ?>
						<div class="col-md-12" >
						<hr><a href="<?php echo base_url()."admin_side/sekolah"; ?>" class="btn btn-info" role="button"><i class="fa fa-angle-double-left"></i> Back</a></div>
					</div>
				</div>
			</div>
			<!-- END EXAMPLE TABLE PORTLET-->
		</div>
	</div>
</div>