<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Manage Product Start -->
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	        <i class="pe-7s-note2"></i>
	    </div>
	    <div class="header-title">
	        <h1><?php echo display('manage_product') ?></h1>
	        <small><?php echo display('manage_your_product') ?></small>
	        <ol class="breadcrumb">
	            <li><a href="<?php echo base_url()?>"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="<?php echo base_url('dashboard/Cproduct')?>"><?php echo display('product') ?></a></li>
	            <li class="active"><?php echo display('manage_product') ?></li>
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
                	<?php if($this->permission->check_label('add_product')->create()->access()){ ?>
	                <a href="<?php echo base_url('dashboard/Cproduct')?>" class="btn -btn-info color4 color5 m-b-5 m-r-2">
	                	<i class="ti-plus"> </i><?php echo display('add_product')?>
	                </a>
	            	<?php }if($this->permission->check_label('import_product_csv')->create()->access()){ ?>
	                <a href="<?php echo base_url('dashboard/Cproduct/add_product_csv')?>" class="btn btn-success m-b-5 m-r-2">
	                	<i class="ti-plus"> </i><?php echo display('import_product_csv')?>
	                </a>
	            	<?php }if($this->permission->check_label('manage_product')->read()->access()){ ?>
	                <a href="<?php echo base_url('dashboard/Cproduct/product_details_single')?>" class="btn btn-warning m-b-5 m-r-2">
	                	<i class="ti-align-justify"> </i><?php echo display('product_ledger')?>
	              	</a>
	              	<?php } ?>
                </div>
            </div>
        </div>

        <div class="row">
			<div class="col-sm-12">
		        <div class="panel panel-default">
		            <div class="panel-body"> 
		            	<?php echo form_open("dashboard/Cproduct/manage_product", array('method' => 'GET')); ?>
		            		<div class="row form-group">
		                        <div class="col-sm-2">
			                        <div class="form-group">
			                            <label class="control-label"><?php echo display('product_name')?>:</label>
			                            <input type="text" class="form-control" name="product_name" value="" placeholder='<?php echo display('product_name') ?>'>
			                        </div>
			                    </div>
			                    <div class="col-sm-2">
			                        <div class="form-group">
			                            <label class="control-label"><?php echo display('supplier')?>:</label>
			                            <select class="form-control" name="supplier_id">
			                                <option value=""></option>
											<?php if ($all_supplier_list) { foreach($all_supplier_list as $supplier_list){ ?>
				                           	<option value="<?php echo html_escape($supplier_list['supplier_id']); ?>"><?php echo html_escape($supplier_list['supplier_name']) ?></option>
											<?php } } ?>
			                            </select>
			                        </div>
			                    </div>
		                        <div class="col-sm-2">
			                        <div class="form-group">
			                            <label class="control-label"><?php echo display('category')?>:</label>
			                            <select class="form-control" name="category_id">
			                                <option value=""></option>
											<?php if ($all_category_list) { foreach($all_category_list as $category_list){ ?>
				                           	<option value="<?php echo html_escape($category_list['category_id']); ?>"><?php echo html_escape($category_list['category_name']) ?></option>
											<?php } } ?>
			                            </select>
			                        </div>
			                    </div>
		                        <div class="col-sm-2">
			                        <div class="form-group">
			                            <label class="control-label"><?php echo display('unit')?>:</label>
			                            <select class="form-control" name="unit_id">
			                                <option value=""></option>
											<?php if ($all_unit_list) { foreach($all_unit_list as $unit_list){ ?>
				                           	<option value="<?php echo html_escape($unit_list['unit_id']); ?>"><?php echo html_escape($unit_list['unit_name']) ?></option>
											<?php } } ?>
			                            </select>
			                        </div>
			                    </div>
			                    <div class="col-sm-2">
			                        <div class="form-group">
			                            <label class="control-label"><?php echo display('model')?>:</label>
			                            <input type="text" class="form-control" name="model_no" value="" placeholder='<?php echo display('model_no') ?>'>
			                        </div>
			                    </div>
			                    <div class="col-sm-2">
			                        <div class="form-group">
			                            <label class="control-label"></label>
			                            <button type="submit" class="btn btn-primary filter_btn"><?php echo display('search')?></button>
			                        </div>
			                    </div>
							</div>
			            <?php echo form_close(); ?>		            
			        </div>
		        </div>
		    </div>
	    </div>


		<!-- Manage Product report -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('manage_product') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample3" class="table table-bordered table-striped table-hover">
		                        <thead>
									<tr>
										<th><?php echo display('sl') ?></th>
										<th><?php echo display('product_name') ?></th>
										<th><?php echo display('supplier') ?></th>
										<th><?php echo display('category') ?></th>
										<th><?php echo display('unit') ?></th>
										<th><?php echo display('sell_price') ?></th>
										<th><?php echo display('supplier_price') ?></th>
										<th><?php echo display('onsale_price') ?></th>
										<th><?php echo display('image') ?>s</th>
										<th class="width_130"><?php echo display('action') ?></th>
									</tr>
								</thead>
								<tbody>
								<?php
								if ($products_list) {

								foreach ($products_list as $v_product_list):

                                    ?>
                                    <tr>
                                        <td><?php echo $v_product_list['sl'] ?></td>
                                        <td>
                                            <a href="<?php echo base_url() . 'dashboard/Cproduct/product_details/'.$v_product_list['product_id']; ?>">
                                                 <?php echo html_escape($v_product_list['product_name'])?>-(<?php echo html_escape($v_product_list['product_model']) ?>) <i class="fa fa-shopping-bag pull-right" aria-hidden="true"></i></a>
                                        </td>
                                        <td><?php echo html_escape($v_product_list['supplier_name']) ?></td>
                                        <td><?php echo html_escape($v_product_list['category_name'])?></td>
                                        <td><?php echo html_escape($v_product_list['unit_short_name'])?></td>
                                        <td class="text-right">
                                            <?php echo(($position == 0) ? ($currency.' '.$v_product_list["price"]) : ($v_product_list["price"].' '.$currency)) ?>
                                        </td>
                                        <td class="text-right">
                                            <?php echo(($position == 0) ? ($currency.' '.$v_product_list["supplier_price"]) : ($v_product_list["supplier_price"].' '.$currency)) ?>
                                        </td>
                                        <td class="text-right">
                                            <?php
                                            	if(!empty($v_product_list["onsale_price"])){
                                             echo(($position == 0) ? ($currency.' '.$v_product_list["onsale_price"]) : ($v_product_list["onsale_price"].' '.$currency));  } ?>
                                        </td>
                                        <td class="text-center">
                                            <img src="<?php echo base_url() . $v_product_list['image_thumb']; ?>"
                                                 class="img img-responsive center-block" height="50" width="50">
                                        </td>
                                        <td>
                                            <center>
                                                <?php echo form_open() ?>
                                                <?php if($this->permission->check_label('manage_product')->read()->access()){ ?>
                                                <a href="<?php echo base_url() . 'dashboard/Cqrcode/qrgenerator/'.$v_product_list['product_id']; ?>"
                                                   class="btn btn-success btn-sm" data-toggle="tooltip"
                                                   data-placement="left" title="<?php echo display('qr_code') ?>"><i
                                                            class="fa fa-qrcode" aria-hidden="true"></i></a>
                                                <?php } ?>
                                                <a href="<?php echo base_url() . 'dashboard/Cbarcode/barcode_print/'.$v_product_list['product_id']; ?>"
                                                   class="btn btn-warning btn-sm" data-toggle="tooltip"
                                                   data-placement="left" title="<?php echo display('barcode') ?>"><i
                                                            class="fa fa-barcode" aria-hidden="true"></i></a>
                                                <a href="<?php echo base_url() . 'product/'.remove_space($v_product_list['product_name']).'/'.$v_product_list['product_id']; ?>" class="btn btn-info btn-sm" data-toggle="tooltip"
                                                   data-placement="left" title="<?php echo display('details') ?>" target="_blank" ><i
                                                            class="fa fa-eye" aria-hidden="true"></i></a>
                                                <?php if($this->permission->check_label('manage_product')->update()->access()){ ?>
                                                <a href="<?php echo base_url() . 'dashboard/Cproduct/product_update_form/'.$v_product_list['product_id']; ?>"
                                                   class="btn btn-info btn-sm" data-toggle="tooltip"
                                                   data-placement="left" title="<?php echo display('update') ?>"><i
                                                            class="fa fa-pencil" aria-hidden="true"></i></a>
                                                <?php }if($this->permission->check_label('manage_product')->delete()->access()){?>
                                                <a href="<?php echo base_url('dashboard/Cproduct/product_delete/').$v_product_list['product_id']; ?>"
                                                   class="btn btn-danger btn-sm"
                                                   onclick="return confirm('<?php echo display('are_you_sure_want_to_delete') ?>');"
                                                   data-toggle="tooltip" data-placement="right" title=""
                                                   data-original-title="<?php echo display('delete') ?> "><i
                                                            class="fa fa-trash-o" aria-hidden="true"></i></a>
                                                <?php } ?>
                                                <?php echo form_close() ?>
                                            </center>
                                        </td>
                                    </tr>

                                    <?php
                                endforeach;
								}
								?>
								</tbody>
		                    </table>
		                    <div class="text-right">
		                    <?php echo htmlspecialchars_decode(@$links); ?>
		                    </div>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>
	</section>
</div>
<!-- Manage Product End -->