<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script src="<?=base_url('assets/pages/scripts/components-editors.min.js');?>" type="text/javascript"></script>
<ul class="page-breadcrumb breadcrumb">
	<li>
		<span>Transaction</span>
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
			<div class="portlet light ">
				<div class="portlet-body">
					<form role="form" class="form-horizontal" action="<?=base_url('admin_side/transaction_check');?>" method="post" enctype='multipart/form-data'>
						<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
						<div class="form-body">
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-1 control-label" for="form_control_1">Student <span class="required"> * </span></label>
								<div class="col-md-4">
									<select class='form-control select2-allow-clear' name='id' required>
										<option value=''>-- Pilih --</option>
										<?php
										foreach ($student as $key => $value) {
											echo '<option value="'.$value->user_id.'">'.$value->fullname.'</option>';
										}
										?>
									</select>
								</div>
                                <label class="col-md-1 control-label" for="form_control_1">Packet <span class="required"> * </span></label>
								<div class="col-md-4">
									<select class='form-control select2-allow-clear' name='packet_id' required>
										<option value=''>-- Pilih --</option>
										<?php
										foreach ($packet as $key => $value) {
											echo '<option value="'.$value->packet_id.'">'.$value->packet_name.'</option>';
										}
										?>
									</select>
								</div>
                                <div class="col-md-2">
									<button type="submit" class="btn blue">Add</button>
								</div>
							</div>
						</div>
					</form>
                    <hr>
                    <table class="table table-striped table-bordered" >
                        <thead>
                            <tr>
                                <th style="text-align: center;" width="4%"> # </th>
                                <th style="text-align: center;"> Student </th>
                                <th style="text-align: center;"> Packet </th>
                                <th style="text-align: center;" width="7%"> Action </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $return_onclick = "confirm('Anda yakin?')";
                            $urutan = 1;
                            foreach ($transaction as $key => $value) {
                                echo'
                                <tr>
                                    <td style="text-align: center;">'.$urutan.'.</td>
                                    <td style="text-align: center;">'.$value->fullname.'</td>
                                    <td style="text-align: center;">'.$value->packet_name.'</td>
                                    <td style="text-align: center;">
                                        <a class="btn btn-circle btn-icon-only btn-danger" onclick="return '.$return_onclick.'" href="'.site_url('admin_side/delete_transaction/'.md5($value->id_cache_transaction)).'">
                                            <i class="icon-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                ';
                                $urutan++;
                            }
                            ?>
                        </tbody>
                    </table>
                    <a onclick="return confirm('Anda yakin?')" href='<?= site_url('admin_side/destroy_cart') ?>' class='btn red hidden-print margin-bottom-5'>Empty The Cart <i class="fa fa-trash"></i></a>
                    <a onclick="return confirm('Anda yakin?')" href='<?= site_url('admin_side/save_transaction') ?>' class='btn green hidden-print margin-bottom-5'>Save Transaction <i class="fa fa-check"></i></a>
				</div>
			</div>
		</div>
	</div>
</div>