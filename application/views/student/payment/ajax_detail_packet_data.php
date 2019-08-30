<div class="page-content-inner">
	<div class="row">
		<div class="col-md-12">
			<!-- BEGIN EXAMPLE TABLE PORTLET-->
			<div class="portlet light ">
				<div class="portlet-body">
					<div class='row'>
						<?php
						if(isset($data_utama)){
							foreach($data_utama as $row)
							{
						?>
								<div class="col-md-12">
									<table class="table">
										<tbody>
											<tr>
												<td> Packet Name </td>
												<td> : </td>
												<td><?php echo $row->packet_name; ?></td>
											</tr>
											<tr>
												<td> Quota </td>
												<td> : </td>
												<td><?php
												if($row->quota>0){
												echo $row->quota.'x Attendance';}
												else{
													echo $row->quota;
												} ?></td>
											</tr>
											<tr>
												<td> Duration </td>
												<td> : </td>
												<td><?php echo $row->duration.' Month'; ?></td>
											</tr>
											<!-- <tr>
												<td> Tanggal Kadaluarsa </td>
												<td> : </td>
												<td><?php echo $this->Main_model->convert_tanggal($row->expired_date); ?></td>
											</tr> -->
											<tr>
												<td> Additional Information </td>
												<td> : </td>
												<td><?php echo $row->additional_info; ?></td>
											</tr>
											<tr>
												<td> Term and Condition </td>
												<td> : </td>
												<td><?php echo $row->term_and_condition; ?></td>
											</tr>
											<tr>
												<td> Price </td>
												<td> : </td>
												<td><?php echo 'Rp '.number_format($row->price,2); ?></td>
											</tr>
										</tbody>
									</table>
									<button class="btn blue btn-block btn-lg m-icon-big" onclick="window.location.href='<?= site_url('student/add_to_cart/'.md5($row->packet_id)); ?>'">Buy
										<i class="m-icon-big-swapright m-icon-white"></i>
									</button>
								</div>
						<?php }} ?>
					</div>
				</div>
			</div>
			<!-- END EXAMPLE TABLE PORTLET-->
		</div>
	</div>
</div>