<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Manage Link Page Start -->
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	        <i class="pe-7s-note2"></i>
	    </div>
	    <div class="header-title">
	        <h1><?php echo display('manage_link_page') ?></h1>
	        <small><?php echo display('manage_your_link_page') ?></small>
	        <ol class="breadcrumb">
	            <li><a href=""><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="#"><?php echo display('web_settings') ?></a></li>
	            <li class="active"><?php echo display('manage_link_page') ?></li>
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
                <?php if($this->permission->check_label('link_page')->create()->access()){ ?>
                	<a href="<?php echo base_url('dashboard/Clink_page')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-plus"> </i> <?php echo display('add_link_page')?></a>
                <?php } ?>
                </div>
            </div>
        </div>
		<!-- Manage Link Page -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('manage_link_page') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th class="text-center"><?php echo display('sl') ?></th>
										<th class="text-center"><?php echo display('page') ?></th>
										<th class="text-center"><?php echo display('link') ?></th>
										<th class="text-center"><?php echo display('language') ?></th>
										<th class="text-center"><?php echo display('headlines') ?></th>
										<th class="text-center"><?php echo display('details') ?></th>
										<th class="text-center" ><?php echo display('image') ?></th>
										<th class="text-center"><?php echo display('action') ?></th>
									</tr>
								</thead>
								<tbody>
								<?php
								if ($link_page_list) {
									foreach ($link_page_list as $link_page) {
								?>
									<tr>
										<td class="text-center"><?php echo $link_page['sl']?></td>
										<td class="text-center">
										<?php
											$page_id = $link_page['page_id'];
											if ($page_id == 1) {
											 	echo display('about_us');
											 	$link = 'about_us';
											}elseif ($page_id == 2) {
												echo display('contact_us');
												$link = 'contact_us';
											}elseif ($page_id == 3) {
												echo display('delivery_info');
												$link = 'delivery_info';
											}elseif ($page_id == 4) {
												echo display('privacy_policy');
												$link = 'privacy_policy';
											}elseif ($page_id == 5) {
												echo display('terms_and_condition');
												$link = 'terms_condition';
											}elseif ($page_id == 6) {
												echo display('help');
												$link = 'help';
											}
										?>
										</td>
										<td class="text-center"><?php echo html_escape($link)?></td>
										<td class="text-center"><?php echo html_escape($link_page['language_id'])?></td>
										<td class="text-center" width="150"><?php echo $link_page['headlines']?></td>
										<td class="text-center" width="150"><?php echo character_limiter($link_page['details'], 50);?></td>
										<td class="text-center">
											<img src="<?php echo base_url().$link_page['image']?>" class="img img-responsive" height="80" width="80">
										</td>
										<td>
											<center>
											<?php
		                                    $status=$link_page['status'];
		                                    if ($status==1) {
		                                    ?>
                                                <a href="<?php echo  base_url();?>dashboard/Clink_page/inactive/<?php echo  $link_page['page_id']?>" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="left" data-original-title="<?php echo display('inactive')?>"><i class="fa fa-times" aria-hidden="true"></i>
                                                </a>
                                                <?php
                                            }else{
                                                ?>
                                                <a href="<?php echo  base_url();?>dashboard/Clink_page/active/<?php echo  $link_page['page_id']?>" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="left" title="" data-original-title="<?php echo display('active')?>"><i class="fa fa-check" aria-hidden="true"></i>
                                                </a>
	                                        <?php
	                                        }
	                                        ?>
												<a href="<?php echo base_url().'dashboard/Clink_page/link_page_update_form/'.$link_page['page_id']; ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('update') ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>

												<a href="<?php echo base_url('dashboard/Clink_page/link_page_delete/'.$link_page['link_page_id'])?>" class="btn btn-danger btn-sm" onclick="return confirm('<?php echo display('are_you_sure_want_to_delete')?>');" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo display('delete') ?> "><i class="fa fa-trash-o" aria-hidden="true"></i></a>
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
<!-- Manage Link Page End -->



