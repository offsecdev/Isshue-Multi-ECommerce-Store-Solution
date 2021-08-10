<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!--Update store product start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('store_product_edit') ?></h1>
            <small><?php echo display('store_product_edit') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('store_set') ?></a></li>
                <li class="active"><?php echo display('store_product_edit') ?></li>
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

        <!--Edit store -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('store_product_edit') ?> </h4>
                        </div>
                    </div>
                    <?php echo form_open_multipart('dashboard/Cstore/store_product_update/{store_product_id}',array('class' => 'form-vertical', 'id' => 'validate'))?>
                    <div class="panel-body">

                        <div class="form-group row">
                            <label for="store_name" class="col-sm-3 col-form-label"><?php echo display('store_name')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <select class="form-control" id="store_name" name="store_name" required="">
                                    <option value=""></option>
                                    {store_list}
                                    <option value="{store_id}">{store_name}</option>
                                    {/store_list}
                                    {store_list_selected}
                                    <option value="{store_id}" selected="">{store_name}</option>
                                    {/store_list_selected}
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="product_name" class="col-sm-3 col-form-label"><?php echo display('product_name')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <select class="form-control" id="product_name" name="product_name" required="">
                                    <option value=""></option>
                                    {product_list}
                                    <option value="{product_id}">{product_name}</option>
                                    {/product_list}
                                    {product_list_selected}
                                    <option value="{product_id}" selected="">{product_name}</option>
                                    {/product_list_selected}
                                </select>
                            </div>
                        </div>  
                        <div class="form-group row">
                            <label for="variant" class="col-sm-3 col-form-label"><?php echo display('variant')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <select class="form-control" id="variant" name="variant">
                                    <option value=""></option>
                                    {variant_list}
                                    <option value="{variant_id}">{variant_name}</option>
                                    {/variant_list}  
                                    {variant_list_selected}
                                    <option value="{variant_id}" selected="">{variant_name}</option>
                                    {/variant_list_selected} 
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="quantity" class="col-sm-3 col-form-label"><?php echo display('quantity')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="quantity" id="quantity" type="number" placeholder="<?php echo display('quantity') ?>"  required="" value="{quantity}">
                            </div>
                        </div>
                
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
                                <input type="submit" id="add-store" class="btn btn-success btn-large" name="add-store" value="<?php echo display('update') ?>" />
                                
                            </div>
                        </div>
                    </div>
                    <?php echo form_close()?>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Update store product end -->



