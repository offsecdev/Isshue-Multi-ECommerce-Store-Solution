<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Manage Customer Start -->
<div class="content-wrapper">
<section class="content-header">
<div class="header-icon">
    <i class="pe-7s-note2"></i>
</div>
<div class="header-title">
    <h1><?php echo display('manage_customer') ?></h1>
    <small><?php echo display('manage_your_customer') ?></small>
    <ol class="breadcrumb">
        <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
        <li><a href="#"><?php echo display('customer') ?></a></li>
        <li class="active"><?php echo display('manage_customer') ?></li>
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
        <?php if($this->permission->check_label('add_customer')->create()->access()){ ?>
          <a href="<?php echo base_url('dashboard/Ccustomer')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-plus"> </i> <?php echo display('add_customer')?></a>
        <?php }if($this->permission->check_label('customer_ledger')->read()->access()){ ?>
          <a href="<?php echo base_url('dashboard/Ccustomer/customer_ledger_report')?>" class="btn btn-warning m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('customer_ledger')?></a>
        <?php } ?>
        </div>
    </div>
</div>

<!-- Manage Customer -->
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h4><?php echo display('manage_customer') ?></h4>
                </div>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
						<thead>
							<tr>
								<th><?php echo display('sl') ?></th>
								<th><?php echo display('customer_name') ?></th>
								<th><?php echo display('address') ?></th>
								<th><?php echo display('mobile') ?></th>
								<th><?php echo display('email') ?></th>
								<th class="text-center"><?php echo display('action') ?></th>
							</tr>
						</thead>
						<tbody>
						<?php  if ($customers_list) { ?>
							<?php foreach($customers_list as $single_list):
								?>
							<tr>
								<td><?php echo html_escape($single_list['sl'])?></td>
								<td>
									<?php if ($this->session->userdata('user_type') == '4') { ?>
										<?php echo html_escape($single_list['customer_name'])?>
									<?php }else{ ?>		
									<a href="<?php echo base_url().'dashboard/Ccustomer/customerledger/'.$single_list['customer_id']; ?>"> <?php echo html_escape($single_list['customer_name']);?> <i class="fa fa-user pull-right" aria-hidden="true"></i></a>
									<?php } ?>	
								</td>
                                <?php if(!empty($single_list['customer_short_address'])){?>
								<td><?php echo html_escape($single_list['customer_short_address'])?></td>
                                <?php }else{?>
                                    <td><?php echo html_escape($single_list['customer_address_1'])?></td>
                                <?php }?>
								<td><?php echo html_escape($single_list['customer_mobile']);?></td>
								<td><?php echo html_escape($single_list['customer_email']);?></td>
								<td>
									<center>
									<?php echo form_open()?>
                                    <?php if($this->permission->check_label('manage_customer')->update()->access()){ ?>
										<a href="<?php echo base_url().'dashboard/Ccustomer/customer_update_form/'.$single_list['customer_id']; ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('update') ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                    <?php }if($this->permission->check_label('manage_customer')->delete()->access()){  ?>
										<a href="<?php echo base_url('dashboard/Ccustomer/customer_delete/').$single_list['customer_id'];?>" class="btn btn-danger btn-sm" onclick="return confirm('<?php echo display('are_you_sure_want_to_delete')?>');" data-toggle="tooltip" data-placement="right" title="" data-original-title="<?php echo display('delete') ?> "><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                    <?php } ?>
									<?php echo form_close()?>
									</center>
								</td>
							</tr>
						
						<?php endforeach; ?>
						<?php } ?>
						</tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
</div>
<!-- Manage Customer End -->
<script src="<?php echo MOD_URL.'dashboard/assets/js/customer.js'; ?>"></script>
