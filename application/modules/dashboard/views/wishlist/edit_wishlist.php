<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!--Update wishlist start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('wishlist_update') ?></h1>
            <small><?php echo display('wishlist_update') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('web_settings') ?></a></li>
                <li class="active"><?php echo display('wishlist_update') ?></li>
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

        <!--Update wishlist -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('wishlist_update') ?> </h4>
                        </div>
                    </div>
                    <?php echo form_open_multipart('dashboard/Cwishlist/wishlist_update/{wishlist_id}',array('class' => 'form-vertical', 'id' => 'validate'))?>
                        <div class="panel-body">
                            
                            <div class="form-group row">
                                <label for="product_name" class="col-sm-3 col-form-label"><?php echo display('product_name')?> <i class="text-danger">*</i></label>
                                <div class="col-sm-6">
                                    <select class="form-control" id="product_name" name="product_id">
                                        <option></option>
                                        {product_list}
                                        <option value="{product_id}">{product_name} - ({product_model})</option>
                                        {/product_list}
                                        {selected_product}
                                        <option value="{product_id}" selected="">{product_name} - ({product_model})</option>
                                        {/selected_product}
                                    </select>
                                </div>
                            </div>
                    
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                                <div class="col-sm-6">
                                    <input type="submit" id="add-wishlist" class="btn btn-success btn-large" name="add-wishlist" value="<?php echo display('save_changes') ?>" />
                                </div>
                            </div>
                        </div>
                    <?php echo form_close()?>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Update wishlist end -->



