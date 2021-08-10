<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Manage Category Start -->
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	        <i class="pe-7s-note2"></i>
	    </div>
	    <div class="header-title">
	        <h1><?php echo display('manage_category') ?></h1>
	        <small><?php echo display('manage_your_category') ?></small>
	        <ol class="breadcrumb">
	            <li><a href=""><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="#"><?php echo display('category') ?></a></li>
	            <li class="active"><?php echo display('manage_category') ?></li>
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
                <?php if($this->permission->check_label('add_category')->create()->access()){ ?>
                  <a href="<?php echo base_url('dashboard/Ccategory')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-plus"> </i> <?php echo display('add_category')?></a>
                <?php } ?>
                </div>
            </div>
        </div>

		<!-- Manage Category -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('manage_category') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th class="text-center"><?php echo display('category_id') ?></th>
										<th class="text-center"><?php echo display('category_name') ?></th>
										<th class="text-center"><?php echo display('parent_category') ?></th>
										<th class="text-center"><?php echo display('cat_icon') ?></th>
										<th class="text-center"><?php echo display('cat_image') ?></th>
										<th class="text-center"><?php echo display('status') ?></th>
										<th class="text-center"><?php echo display('action') ?></th>
									</tr>
								</thead>
								<tbody>
								<?php
								if ($category_list) {
									foreach ($category_list as $category) {
								?>
									<tr>
										<td class="text-center"><?php echo html_escape($category['category_id'])?></td>
										<td class="text-center"><?php echo html_escape($category['category_name'])?></td>
										<td class="text-center">
										<?php
										if ($category['parent_category_id']) {
											$result = $this->db->select('*')
														->from('product_category')
														->where('category_id',$category['parent_category_id'])
														->get()
														->row();

											echo (@$result->category_name);
										}
										?>	
										</td>
										<td class=""><img src="<?php echo base_url().$category['cat_favicon']?>" class="img img-responsive center-block" height="20" width="50"></td>
										<td class="text-center"><img src="<?php echo base_url().$category['cat_image']?>" class="img img-responsive center-block" height="50" width="50"></td>
										<td class="text-center"><?php echo (($category['status']=='1')?"<label class='label label-success'>".display('active')."</label>":"<label class='label label-danger'>".display('inactive')."</label>")?></td>
										<td>
											<center>
											<?php echo form_open()?>
												<?php if($this->permission->check_label('manage_category')->update()->access()){ ?>
													<a href="<?php echo base_url().'dashboard/Ccategory/category_update_form/'.$category['category_id']; ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('update') ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
												<?php }if($this->permission->check_label('manage_category')->delete()->access()){ ?>
													<a href="<?php echo base_url('dashboard/Ccategory/category_delete/'.$category['category_id'])?>" class="btn btn-danger btn-sm" onclick="return confirm('<?php echo display('are_you_sure_want_to_delete')?>');"  data-toggle="tooltip" data-placement="right" title="" data-original-title="<?php echo display('delete') ?> "><i class="fa fa-trash-o" aria-hidden="true"></i></a>
												<?php } ?>
											<?php echo form_close()?>
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
		            </div>
		        </div>
		    </div>
		</div>
	</section>
</div>
<!-- Manage Category End -->
<script src="<?php echo MOD_URL.'dashboard/assets/js/category.js'; ?>"></script>
