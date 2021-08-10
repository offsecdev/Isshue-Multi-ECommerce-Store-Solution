<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php  $this->load->view('../../../dashboard/assets/css/edit_add_form'); ?>

<!-- Edit Add start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('update_advertise')?></h1>
            <small><?php echo display('update_advertise')?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home')?></a></li>
                <li><a href="#"><?php echo display('web_settings')?></a></li>
                <li class="active"><?php echo display('update_advertise')?></li>
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

        if (validation_errors()) {
            ?>
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo validation_errors(); ?>
            </div>
            <?php
        }
        ?>
        <div class="row">
            <div class="col-sm-12">
                <div class="column">
                    <?php if($this->permission->check_label('advertisement')->read()->redirect()){?>
                        <a href="<?php echo base_url('dashboard/Cweb_setting/manage_add') ?>" class="btn btn-success m-b-5 m-r-2">
                            <i class="ti-align-justify"> </i> <?php echo display('manage_advertise') ?>
                        </a>
                    <?php } ?>
                </div>
            </div>
        </div>

        <!-- New user -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('update_advertise')?> </h4>
                        </div>
                    </div>
                    <?php echo form_open_multipart('dashboard/Cweb_setting/update_add/'.$adv_id,array('class' => 'form-vertical','id' => 'validate'))?>
                    <div class="panel-body">

                        <div class="form-group row">
                            <label for="add_page" class="col-sm-3 col-form-label"><?php echo display('add_page')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <select class="form-control" id="add_page" name="add_page" required="">
                                    <option></option>
                                    <option value="home" <?php if ($add_page == 'home') {echo "selected";}?>><?php echo display('home')?></option>
                                    <option value="category" <?php if ($add_page == 'category') {echo "selected";}?>><?php echo display('category')?></option>
                                    <option value="details" <?php if ($add_page == 'details') {echo "selected";}?>><?php echo display('details')?></option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="ads_position" class="col-sm-3 col-form-label"><?php echo display('ads_position')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input name="ads_position" class="form-control" type="number" placeholder="<?php echo display('ads_position')?>" id="ads_position" required value="{adv_position}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="ad_type" class="col-sm-3 col-form-label"><?php echo display('add_type')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <select name="ad_type" class="form-control" id="ad_type" required="1" onchange="set_ad_type(this.value)">
                                    <option value=""><?php echo display('select_one')?></option>
                                    <option value="1" <?php if ($adv_type == '1')echo "selected"; ?>><?php echo display('embed_code')?></option>
                                    <option value="2" <?php if ($adv_type == '2')echo "selected"; ?>><?php echo display('image_ads')?></option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row embed_code_ad">
                            <label for="embed_code" class="col-sm-3 col-form-label"><?php echo display('embed_code')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <textarea name="add_code" class="form-control" placeholder="<?php echo display('embed_code')?>" id="embed_code" required><?php echo $adv_code?></textarea>
                            </div>
                        </div>

                        <div class="img_ad">
                            <div class="form-group row" >
                                <label for="image" class="col-sm-3 col-form-label"><?php echo display('image')?> <i class="text-danger">*</i></label>
                                <div class="col-sm-6">
                                    <input name="add_image" class="form-control" type="file" id="image">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="add_url" class="col-sm-3 col-form-label"><?php echo display('url')?> <i class="text-danger">*</i></label>
                                <div class="col-sm-6">
                                    <input name="add_url" class="form-control" type="url" value="<?php echo set_value('add_url', $advinfo['adv_url']) ?>" placeholder="<?php echo display('url')?>" id="add_url" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-2">
                                    <?php echo $adv_code?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
                                <button type="reset" class="btn btn-danger"><?php echo display('reset')?></button>
                                <button type="submit" class="btn btn-success"><?php echo display('submit')?></button>
                            </div>
                        </div>
                    </div>
                    <?php echo form_close()?>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Edit Add end -->
<script src="<?php echo MOD_URL.'dashboard/assets/js/edit_add_form.js'; ?>"></script>
