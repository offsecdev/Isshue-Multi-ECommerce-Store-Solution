<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Manage Purchase Start -->
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	        <i class="pe-7s-note2"></i>
	    </div>
	    <div class="header-title">
	        <h1><?php echo display('manage_purchase') ?></h1>
	        <small><?php echo display('manage_your_purchase') ?></small>
	        <ol class="breadcrumb">
	            <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="#"><?php echo display('purchase') ?></a></li>
	            <li class="active"><?php echo display('manage_purchase') ?></li>
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
                	<?php if($this->permission->check_label('add_purchase')->create()->access()){ ?>
                  	<a href="<?php echo base_url('dashboard/Cpurchase')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-plus"> </i> <?php echo display('add_purchase')?></a>  
                  	<?php } ?>
                </div>
            </div>
        </div>


		<!-- Manage Purchase report -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('manage_purchase') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample4" class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th><?php echo display('sl') ?></th>
										<th><?php echo display('invoice_no') ?></th>
										<th><?php echo display('supplier_name') ?></th>
										<th><?php echo display('store_or_wearhouse') ?></th>
										<th><?php echo display('purchase_date') ?></th>
										<th><?php echo display('total_ammount') ?></th>
										<th><?php echo display('action') ?></th>
									</tr>
								</thead>
								<tbody>
								<?php 
								if ($purchases_list) {
									foreach ($purchases_list as $purchase) {
								?>
									<tr>
										<td><?php echo $purchase['sl']?></td>
										<td>
											<a href="<?php echo base_url().'dashboard/Cpurchase/purchase_details_data/'.$purchase['purchase_id']; ?>">
                                                <?php echo html_escape($purchase['invoice_no'])?><i class="fa fa-tasks pull-right" aria-hidden="true"></i>
                                            </a>
										</td>
										<td>
											<a href="<?php echo base_url().'dashboard/Csupplier/supplier_details/'.$purchase['supplier_id']; ?>">
                                                <?php echo html_escape($purchase['supplier_name'])?> <i class="fa fa-user pull-right" aria-hidden="true"></i>
                                            </a>
										</td>
										<td>
										<?php
										 if (!empty($purchase['store_id'])) {
										 	$store = $this->db->select('*')
											 			->from('store_set')
											 			->where('store_id',$purchase['store_id'])
											 			->get()
											 			->row();
											echo html_escape($store->store_name.' ('.display('store').')') ;
										 }else{
										 	$wearhouse = $this->db->select('*')
											 			->from('wearhouse_set')
											 			->where('wearhouse_id',$purchase['wearhouse_id'])
											 			->get()
											 			->row();
											echo html_escape($wearhouse->wearhouse_name).' ('.display('wearhouse').')' ;
										 }
										?>
										 </td>
										<td><?php echo html_escape($purchase['final_date'])?></td>
										<td class="text-right"><?php echo html_escape(($position==0)?$currency.' '.$purchase['grand_total_amount']:$purchase['grand_total_amount'].' '.$currency) ?></td>
										<td>
											<center>
											<?php echo form_open()?>
											<?php if($this->permission->check_label('manage_purchase')->update()->access()){ ?>
												<a href="<?php echo base_url().'dashboard/Cpurchase/purchase_update_form/'.$purchase['purchase_id']; ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('update') ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
											<?php } ?>
											<?php if($this->permission->check_label('manage_purchase')->delete()->access()){ ?>
												<a href="<?php echo base_url('dashboard/Cpurchase/purchase_delete/'.$purchase['purchase_id'])?>" class="btn btn-danger btn-sm" onclick="return confirm('<?php echo display('are_you_sure_want_to_delete')?>');" data-toggle="tooltip" data-placement="right" title="" data-original-title="<?php echo display('delete') ?> "><i class="fa fa-trash-o" aria-hidden="true"></i></a>
											<?php } ?>
											</center>
											<?php echo form_close()?>
										</td>
									</tr>
								<?php 
									}
								} 
								?>
								</tbody>
		                    </table>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>
	</section>
</div>
<!-- Manage Purchase End -->