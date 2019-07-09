<div class="page-content-inner">
	<div class="row">
		<div class="col-md-12">
			<!-- BEGIN EXAMPLE TABLE PORTLET-->
			<div class="portlet light ">
				<div class="portlet-body">
					<div class='row'>
						<h4><b> No. Invoice </b><?php echo $data_utama['invoice_number']; ?><br>
						<b> Tanggal Transaksi </b><?php echo $this->Main_model->convert_tanggal($data_utama['date']); ?></h4><hr>
							<div class="col-md-12">
								<table class="table">
									<thead>
										<tr>
											<th>#</th>
											<th>Paket</th>
											<th>Harga</th>
											<th>Qty</th>
											<th>Sub Total</th>
										</tr>
									</thead>
									<tbody>
									<?php
									$no = 1;
									if(isset($data_detail)){
										foreach($data_detail as $row)
										{
									?>
										<tr>
											<td> <?= $no++.'.'; ?> </td>
											<td> <?= $row->packet_name; ?> </td>
											<td> <?= 'Rp '.number_format($row->price,2); ?> </td>
											<td> <?= $row->qty; ?> </td>
											<td> <?= 'Rp '.number_format($row->sub_total,2); ?> </td>
										</tr>
									<?php }} ?>
										<tr>
											<td colspan='4' style='text-align: center'>Grand Total</td>
											<td><?= 'Rp '.number_format($data_utama['grand_total'],2); ?></td>
										</tr>
									</tbody>
								</table>
							</div>
					</div>
				</div>
			</div>
			<!-- END EXAMPLE TABLE PORTLET-->
		</div>
	</div>
</div>