<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Manage Invoice Start -->
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	        <i class="pe-7s-note2"></i>
	    </div>
	    <div class="header-title">
	        <h1><?php echo display('manage_invoice') ?></h1>
	        <small><?php echo display('manage_your_invoice') ?></small>
	        <ol class="breadcrumb">
	            <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="#"><?php echo display('invoice') ?></a></li>
	            <li class="active"><?php echo display('manage_invoice') ?></li>
	        </ol>
	    </div>
	</section>

	<section class="content">
		<!-- Alert Message -->
	    <?php
	        $message = $this->session->userdata('message');
	        if (isset($message)) {
	    ?>
	    <div class="alert alert-info alert-dismissable">
	        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	        <?php echo $message ?>                    
	    </div>
	    <?php 
	        $this->session->unset_userdata('message');
	        }
	        $error_message = $this->session->userdata('error_message');
	        if (isset($error_message)) {
	    ?>
	    <div class="alert alert-danger alert-dismissable">
	        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	        <?php echo $error_message ?>                    
	    </div>
	    <?php 
	        $this->session->unset_userdata('error_message');
	        }
	    ?>

        <div class="row">
            <div class="col-sm-12">
                <div class="column">
                	<?php if($this->permission->check_label('new_sale')->create()->access()){ ?>
                  	<a href="<?php echo base_url('dashboard/Store_invoice/new_invoice')?>" class="btn btn-primary m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('new_invoice')?></a>
                  	<?php }if($this->permission->check_label('pos_sale')->read()->access()){ ?>
                  	<a href="<?php echo base_url('dashboard/Store_invoice/pos_invoice')?>" class="btn btn-primary m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('pos_invoice')?></a>
                  	<?php }?>
                </div>
            </div>
        </div>


		<!-- Manage Invoice report -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('manage_invoice') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
		                    	<thead>
									<tr>
										<th><?php echo display('sl') ?></th>
										<th><?php echo display('invoice_no') ?></th>
										<th><?php echo display('customer_name') ?></th>
										<th><?php echo display('date') ?></th>
										<th><?php echo display('total_amount') ?></th>
										<th class="width_25p"><?php echo display('status') ?></th>
										<th><?php echo display('action') ?></th>
									</tr>
								</thead>
								<tbody>
								<?php if ($store_invoices_list) { 
									$i=1;
									foreach ($store_invoices_list as $invoice) {
								?>
									<tr>
										<td><?php echo $invoice['sl']?></td>
										<td>
											<a href="<?php echo base_url().'dashboard/Store_invoice/invoice_inserted_data/'.html_escape($invoice['invoice_id']); ?>">
											<?php echo html_escape($invoice['invoice'])?>
											</a>
										</td>
										<td>
											<a href="<?php echo base_url().'dashboard/Ccustomer/customerledger/'.$invoice['customer_id']; ?>"><?php echo html_escape($invoice['customer_name'])?></a>
										</td>
										<td><?php echo html_escape($invoice['final_date'])?></td>
										<td class="text-right"><?php echo (($position==0)?$currency.' '.$invoice['total_amount']:$invoice['total_amount'].' '.$currency) ?></td>
										<td>
											<?php echo form_open('dashboard/Store_invoice/update_status/'.$invoice['invoice_id']); ?>

												<select class="form-control" id="invoice_status" name="invoice_status">
			                                       	<option value=""></option>
			                                        <option value="1" <?php if ($invoice['invoice_status'] == '1'){echo "selected";}?>>Shipped</option>
			                                        <option value="2" <?php if ($invoice['invoice_status'] == '2'){echo "selected";}?>>Cancel</option>
			                                        <option value="3" <?php if ($invoice['invoice_status'] == '3'){echo "selected";}?>>Pending</option>
			                                        <option value="4" <?php if ($invoice['invoice_status'] == '4'){echo "selected";}?>>Complete</option>
			                                        <option value="5" <?php if ($invoice['invoice_status'] == '5'){echo "selected";}?>>Processing</option>
			                                        <option value="6" <?php if ($invoice['invoice_status'] == '6'){echo "selected";}?>>Return</option>
			                                    </select>

			                                       <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal_<?php echo $i?>" title="<?php echo display('add_note')?>" /><i class="fa fa-plus" aria-hidden="true"></i></button>

			                                    <input type="hidden" value="<?php echo html_escape($invoice['customer_email']) ?>" name="customer_email"/>

			                                    <div class="modal fade" id="myModal_<?php echo $i?>"  role="dialog">
							                        <div class="modal-dialog" role="document">
							                            <div class="modal-content">
							                                <div class="modal-header">
							                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							                                    <h1 class="modal-title"><?php echo display('add_note')?></h1>
							                                </div>
							                                <div class="modal-body">
								                                <div class="form-group row">
								                                    <label for="" class="col-sm-4 col-form-label"><?php echo display('add_note') ?> </label>
								                                    <div class="col-sm-8">
								                                       <input type="text" name="add_note" class="form-control" id="add_note" placeholder="<?php echo display('add_note') ?>" required>
								                                    </div>
								                                </div> 
							                                </div>
							                                <div class="modal-footer">
							                                    <button type="button" class="btn btn-success" data-dismiss="modal"><?php echo display('submit')?></button>
							                                </div>
							                            </div><!-- /.modal-content -->
							                        </div><!-- /.modal-dialog -->
							                    </div><!-- /.modal -->

							                    <input type="submit" class="btn btn-primary inv_updatebtn" value="<?php echo display('update') ?>" onclick="noteCheck();"/>


											<?php echo form_close(); ?>
										</td>
										<td>
											<center>
												<?php echo form_open()?>
												<?php if($this->permission->check_label('new_sale')->access()){?>
													<a href="<?php echo base_url().'dashboard/Store_invoice/invoice_inserted_data/'.$invoice['invoice_id']; ?>" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('invoice') ?>"><i class="fa fa-window-restore" aria-hidden="true"></i></a>
												<?php }if($this->permission->check_label('pos_sale')->read()->access()){ ?>
													<a href="<?php echo base_url().'dashboard/Store_invoice/pos_invoice_inserted_data/'.$invoice['invoice_id']; ?>" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('pos_invoice') ?>"><i class="fa fa-fax" aria-hidden="true"></i></a>
												<?php }if($this->permission->check_label('manage_sale')->update()->access()){?>
													<a href="<?php echo base_url().'dashboard/Store_invoice/invoice_update_form/'.$invoice['invoice_id']; ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('update') ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
												<?php }if($this->permission->check_label('manage_sale')->delete()->access()){ ?>
													<a href="<?php echo base_url('dashboard/Store_invoice/invoice_delete/'.$invoice['invoice_id'])?>" class="btn btn-danger btn-sm" onclick="return confirm('<?php echo display('are_you_sure_want_to_delete')?>');" data-toggle="tooltip" data-placement="right" title="" data-original-title="<?php echo display('delete') ?> "><i class="fa fa-trash-o" aria-hidden="true"></i></a>
												<?php } ?>
												<?php echo form_close()?>
											</center>
										</td>
									</tr>
								<?php } }?>
								</tbody>
		                    </table>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>
	</section>
</div>
<!-- Manage Invoice End -->
<script src="<?php echo MOD_URL.'dashboard/assets/js/invoice.js'; ?>"></script>