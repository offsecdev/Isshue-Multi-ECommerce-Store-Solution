<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Manage Image Start -->
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	        <i class="pe-7s-note2"></i>
	    </div>
	    <div class="header-title">
	        <h1><?php echo display('manage_image') ?></h1>
	        <small><?php echo display('manage_gallery_image') ?></small>
	        <ol class="breadcrumb">
	            <li><a href=""><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="#"><?php echo display('image') ?></a></li>
	            <li class="active"><?php echo display('manage_image') ?></li>
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
                <?php if($this->permission->check_label('add_product_image')->create()->access()){ ?>
                  	<a href="<?php echo base_url('dashboard/Cgallery')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-plus"> </i> <?php echo display('add_image')?></a>
                <?php } ?>
                </div>
            </div>
        </div>

		<!-- Manage Image -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('manage_image') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th class="text-center"><?php echo display('sl') ?></th>
										<th class="text-center"><?php echo display('product_name') ?></th>
										<th class="text-center"><?php echo display('image') ?></th>
										<th class="text-center"><?php echo display('action') ?></th>
									</tr>
								</thead>
								<tbody>
								<?php if (!empty($image_list)) { 
									$i=1;
									foreach ($image_list as $imgitem) {
									?>
									<tr>
										<td class="text-center"><?php echo $i++; ?></td>
										<td class="text-center"><a href="<?php echo base_url('dashboard/Cproduct/product_details/'.$imgitem['product_id']);?>">
                                                <?php echo $imgitem['product_name'].'-('.$imgitem['product_model'].')'; ?><i class="fa fa-shopping-bag pull-right" aria-hidden="true"></i></a></td>
										<td class="text-center"><img src="<?php echo base_url().$imgitem['image_url'];?>" class="img img-responsive center-block" height="50" width="50"><?php $imgname = explode('/', $imgitem['image_url']); echo end($imgname); ?></td>
										<td>
											<center>
											<?php echo form_open()?>
											<?php if($this->permission->check_label('manage_product_image')->update()->access()){ ?>
												<a href="<?php echo base_url().'dashboard/Cgallery/image_update_form/'.$imgitem['image_gallery_id']; ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('update') ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
											<?php }if($this->permission->check_label('manage_product_image')->delete()->access()){?>
												<a href="<?php echo base_url('dashboard/Cgallery/image_delete/'.$imgitem['image_gallery_id'])?>" class="btn btn-danger btn-sm" onclick="return confirm('<?php echo display('are_you_sure_want_to_delete')?>');" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo display('delete') ?> "><i class="fa fa-trash-o" aria-hidden="true"></i></a>
											<?php } ?>
											<?php echo form_close()?>
											</center>
										</td>
									</tr>
								<?php } } ?>
								</tbody>
		                    </table>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>
	</section>
</div>
<!-- Manage Image End -->



