<!-- Manage store Start -->
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	        <i class="pe-7s-note2"></i>
	    </div>
	    <div class="header-title">
	        <h1><?php echo display('manage_assigned_delivery') ?></h1>
	        <small><?php echo display('manage_assigned_delivery') ?></small>
	        <ol class="breadcrumb">
	            <li><a href=""><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="#"><?php echo display('manage_assigned_delivery') ?></a></li>
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
                <?php if($this->permission->check_label('assign_delivery')->create()->access()){ ?>
                  	<a href="<?php echo base_url('dashboard/Cdelivery_system/assign_delivery')?>" class="btn -btn-info color4 color5 m-b-5 m-r-2"><i class="ti-plus"></i><?php echo display('assign_delivery'); ?></a>
                 <?php } ?>
                </div>
            </div>
        </div>
		<!-- Manage store -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('manage_assigned_delivery') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample3" class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th class="text-center"><?php echo display('sl') ?></th>
										<th class="text-center"><?php echo display('delivery_boy')?></th>
										<th class="text-center"><?php echo display('delivery_zone')?></th>
										<th class="text-center"><?php echo display('time_slot')?></th>
										<th class="text-center"><?php echo display('orders')?></th>
										<th class="text-center"><?php echo display('status') ?></th>
										<th class="text-center"><?php echo display('action') ?></th>
									</tr>
								</thead>
								<tbody>
								<?php
								if ($assigned_deliveries) {
									$i=$page+1;
									foreach ($assigned_deliveries as $assigned_delivery) {
								?>
									<tr>
										<td class="text-center"><?php echo $i++; ?></td>
										<td class="text-center"><?php echo html_escape($assigned_delivery['name'])?></td>
										<td class="text-center"><?php echo html_escape($assigned_delivery['delivery_zone'])?></td>
										<td class="text-center"><?php echo html_escape($assigned_delivery['title'])?></td>
										
										<td class="text-center">
										<?php
											$this->db->select('a.order_no,b.order_id');
											$this->db->from('delivery_orders a');
											$this->db->join('order b','a.order_no = b.order');
											$this->db->where('delivery_id',$assigned_delivery['delivery_id']);
											$query = $this->db->get()->result();
										 
											$result="";
											foreach($query as $item) :
											$result.='<a href="'.base_url().'dashboard/Corder/order_details_data/'.$item->order_id.'">'.$item->order_no.'</a>'.', '; 
											endforeach;
											$trimmed=rtrim($result, ', ');
											echo $trimmed;
										?>
										</td>
										<td class="text-center">
											<?php if ($assigned_delivery['status'] == '1') { ?>
											<span class="label label-success"><?php echo display('active'); ?></span>
											<?php }else{ ?> 
											<span class="label label-danger"><?php echo display('inactive'); ?></span>
											<?php } ?>
										</td>
										<td>
											<center>
												<?php if($this->permission->check_label('manage_assigned_delivery')->update()->access()){ ?>
												<a href="<?php echo base_url().'dashboard/Cdelivery_system/edit_assigned_delivery/'.$assigned_delivery['delivery_id']; ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('update') ?>">
													<i class="fa fa-pencil" aria-hidden="true"></i>
												</a>
												<?php }if($this->permission->check_label('manage_assigned_delivery')->delete()->access()){?>
												<a href="<?php echo base_url('dashboard/Cdelivery_system/assigned_delivery_delete/'.$assigned_delivery['delivery_id'])?>" class="delete_store_product btn btn-danger btn-sm" onclick="return confirm('<?php echo display('are_you_sure_want_to_delete')?>');" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo display('delete') ?> ">
													<i class="fa fa-trash-o" aria-hidden="true"></i>
												</a>
												<?php } ?>
											</center>
										</td>
									</tr>
								<?php
									}
								}
								?>
								</tbody>
		                    </table>
		                </div>
		                <div class="text-right">
		                	<?php echo htmlspecialchars_decode($links); ?>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>
	</section>
</div>
<!-- Manage store End -->