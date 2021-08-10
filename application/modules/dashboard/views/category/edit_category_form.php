<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!--Edit customer start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('category_edit') ?></h1>
            <small><?php echo display('category_edit') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('category') ?></a></li>
                <li class="active"><?php echo display('category_edit') ?></li>
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

        <!-- New customer -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('category_edit') ?> </h4>
                        </div>
                    </div>
                  <?php echo form_open_multipart('dashboard/Ccategory/category_update',array('class' => 'form-vertical', 'id' => 'insert_customer'))?>
                    <div class="panel-body">

                    	<div class="form-group row">
                            <label for="category_name" class="col-sm-3 col-form-label"><?php echo display('category_name') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="category_name" id="category_name" type="text" placeholder="<?php echo display('category_name') ?>"  required="" value="{category_name}">
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="parent_category" class="col-sm-3 col-form-label"><?php echo display('parent_category')?> </label>
                            <div class="col-sm-6">
                                <select class="form-control" name="parent_category" id="parent_category">
                                    <option value=""><?php echo display('select_one')?></option>
                                    <?php
                                        foreach ($category_list as $category) {
                                    ?>
                                    <option value="<?php echo html_escape($category['category_id'])?>" <?php if ($category['category_id'] == $parent_category_id) {echo "selected"; }?>><?php echo html_escape($category['category_name'])?></option>
                                    <?php
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="top_menu" class="col-sm-3 col-form-label"><?php echo display('top_menu')?> </label>
                            <div class="col-sm-6">
                                <select class="form-control" name="top_menu" id="top_menu">
                                    <option value=""></option>
                                    <option value="1" <?php if ($top_menu == 1) {echo "selected";}?>><?php echo display('yes')?></option>
                                    <option value="0" <?php if ($top_menu == 0) {echo "selected";}?>><?php echo display('no')?></option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="menu_position" class="col-sm-3 col-form-label"><?php echo display('menu_position')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="menu_position" id="menu_position" type="text" placeholder="<?php echo display('menu_position') ?>"  required="" value="{menu_pos}">
                            </div>
                        </div>

                       
                        <div class="form-group row">
                            <label for="status" class="col-sm-3 col-form-label"><?php echo display('status') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <select class="form-control" name="status" id="status">
                                    <option value="1" <?php if ($status == 1) {echo "selected";}?>><?php echo display('active') ?></option>
                                    <option value="0" <?php if ($status == 0) {echo "selected";}?>><?php echo display('inactive') ?></option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="cat_favicon" class="col-sm-3 col-form-label"><?php echo display('cat_icon')?></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="cat_favicon" id="cat_favicon" type="file">
                                <img src="<?php echo base_url();?>{cat_favicon}" height="80" width="80" class="img img-responsive">
                                <input name ="old_cat_icon" type="hidden" value="{cat_favicon}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="cat_image" class="col-sm-3 col-form-label"><?php echo display('cat_image')?> </label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="cat_image" id="cat_image" type="file">
                                <input name ="old_image" type="hidden" value="{cat_image}">
                                <span class="help-block small"><?php echo display('optional') ?></span>
                                <img src="<?php echo base_url();?>{cat_image}" height="80" width="80" class="img img-responsive">
                            </div>
                        </div>

                        <input type="hidden" value="{category_id}" name="category_id">

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
                                <input type="submit" id="add-Customer" class="btn btn-success btn-large" name="add-Customer" value="<?php echo display('save_changes') ?>" />
                            </div>
                        </div>
                    </div>
                    <?php echo form_close()?>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Edit customer end -->



