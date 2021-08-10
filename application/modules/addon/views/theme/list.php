<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<link href="<?php echo base_url('application/modules/addon/assets/css/style.css'); ?>" rel="stylesheet" type="text/css"/>
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('themes') ?></h1>
            <small><?php echo display('manage_themes') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>

                <li class="active"><?php echo display('manage_themes') ?></li>

            </ol>
        </div>
    </section>

    <section class="content">

        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd">
                    <div class="panel-heading">
                        <div class="panel-title box-header">
                            <h4><?php echo display('manage_themes') ?></h4>
                            <div>
                                <a href="<?php echo base_url('addon/theme/download_theme')?>" class="btn btn-success"><i class="ti-download"> </i> <?php echo display('download')?></a>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">

                       <?php $this->load->view('template/includes/messages'); ?>

                        <div class="row">
                            <?php echo form_open_multipart('addon/theme/upload_new_theme'); ?>
                            <div class="col-sm-3">
                                <label><?php echo display('purchase_key') ?> <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="bottom" title="Enter Envato purchase key or Bdtask purchase key"></span></label>
                                <input type="text" name="purchase_key"   placeholder="<?php echo display('purchase_key') ?>" class="form-control" required/>
                            </div>
                            <div class="col-sm-3">
                                <label><?php echo display('theme_name') ?></label>
                                <input type="text" name="theme_name"   placeholder="<?php echo display('theme_name') ?>" class="form-control" required/>
                            </div>
                            <div class="col-sm-3">
                                <label><?php echo display('upload') ?></label>
                                <input type="file" name="new_theme" required/>
                            </div>
                            <div class="col-sm-3">
                                <input type="submit" value="<?php echo display('upload') ?>" name="upload_theme" class="btn btn-primary themeupload">
                            </div>
                        <?php echo form_close(); ?>
                        </div>
                        <hr/>
                        <div class="row themediv">
                            <!-- New Themes -->
                            <?php
                                $i=0;
                            if(!empty($new_items)){
                                foreach ($new_items as $theme) {

                                    if(!in_array($theme->identity, $installed)){
                                        $i++;

                                $theme_img = (!empty($theme->thumb)?$theme->thumb:NO_IMAGE);
                                ?>
                                <div class="col-md-4 themebox theme_<?php echo $theme->identity ?>">
                                    <div class="card_item">
                                        <div class="img_part">

                                            <img class="img-fluid img-thumbnail" src="<?php echo (!empty($theme_img)?$theme_img:NO_IMAGE) ?>"  alt="<?php echo html_escape($theme->theme_name) ?>">
                                            <a href="<?php echo $theme->payment_url; ?>" target="_blank" role="button"  class="btn btn-dtls" ><?php echo display('buy_now') ?></a>

                                        </div>
                                    
                                        <div class="caption_part" >
                                            <h4><?php echo html_escape($theme->theme_name);
                                        ?></h4>
                                            
                                            <div class="caption_btn activated">
                                                <p class="price">$<?php echo number_format($theme->price,2); ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } } }  ?>

                              <!-- Downloaded Themes -->
                              <?php foreach ($themes as $single_theme) {
                              $i++; ?>
                                <div class="col-md-4 themebox  theme_<?php echo $single_theme->name ?>">
                                    <div class="card_item">
                                        <div class="img_part">

                                            <img class="img-fluid img-thumbnail" src="<?php echo base_url() . 'application/modules/web/views/themes/' . html_escape($single_theme->name) . '/preview.png'; ?>"  alt="<?php echo html_escape($single_theme->name); ?>">
                                            <?php if (@$active_theme == $single_theme->name) { ?>
                                                <a href="<?php echo base_url()?>" target='__blank' class="btn btn-dtls">Theme Details</a>
                                            <?php } else{ ?>
                                                <a href="<?php echo base_url('addon/theme/active_theme/' . html_escape($single_theme->name))?>" target='__blank' class="btn btn-dtls"><?php echo display('active')?></a>
                                            <?php } ?>

                                        </div>
                                    
                                        <div class="caption_part" >
                                            <h4><?php echo ucwords(str_replace('_', ' ', $single_theme->name));
                                        ?></h4>
                                            
                                            
                                            <div class="caption_btn <?php echo ((@$active_theme == $single_theme->name)?'activated':''); ?>">
                                                <?php if (@$active_theme !== $single_theme->name) { ?>
                                                <a href="<?php echo base_url('addon/theme/active_theme/' . html_escape($single_theme->name))?>" class="btn btn-success"><?php echo display('active')?></a>
                                                <button data_id="<?php echo $single_theme->name; ?>"  class="btn btn-danger delete_item"><?php echo display("delete") ?></button>

                                                <?php } else{ ?>
                                                <a href="<?php echo base_url()?>" target='__blank' class="btn btn-success">Activated</a>
                                            <?php } ?>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>

                              <?php if($i==0){ ?>
                                    <div class="col-md-12">
                                       <h3> <?php echo display('no_theme_available') ?></h3>
                                    </div>
                                <?php } ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script src="<?php echo base_url().'application/modules/addon/assets/ajaxs/addons/theme.js' ?>"></script>
