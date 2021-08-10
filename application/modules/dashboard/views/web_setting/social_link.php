<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Update social link start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('social_link') ?></h1>
            <small><?php echo display('update_your_social_link') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('web_settings') ?></a></li>
                <li class="active"><?php echo display('social_link') ?></li>
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

        <!--Update social link -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('social_link') ?> </h4>
                        </div>
                    </div>
                    <?php echo form_open_multipart('dashboard/Cweb_setting/update_social_link', array('class' => 'form-vertical','id' => 'validate'))?>
                        <div class="panel-body">
                            
                            <div class="form-group row">
                                <label for="facebook" class="col-sm-3 col-form-label"><?php echo display('facebook') ?> <i class="text-danger">*</i></label>
                                <div class="col-sm-6">
                                    <input class="form-control" name ="facebook" id="facebook" type="text" placeholder="<?php echo display('facebook') ?>" value="{facebook}" required>
                                </div>
                            </div> 

                            <div class="form-group row">
                                <label for="instagram" class="col-sm-3 col-form-label"><?php echo display('instagram') ?> <i class="text-danger">*</i></label>
                                <div class="col-sm-6">
                                    <input class="form-control" name ="instagram" id="instagram" type="text" placeholder="<?php echo display('instagram') ?>" value="{instagram}" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="linkedin" class="col-sm-3 col-form-label"><?php echo display('linkedin') ?> <i class="text-danger">*</i></label>
                                <div class="col-sm-6">
                                    <input class="form-control" name ="linkedin" id="linkedin" type="text" placeholder="<?php echo display('linkedin') ?>" value="{linkedin}" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="twitter" class="col-sm-3 col-form-label"><?php echo display('twitter') ?> <i class="text-danger">*</i></label>
                                <div class="col-sm-6">
                                    <input class="form-control" name ="twitter" id="twitter" type="text" placeholder="<?php echo display('twitter') ?>" value="{twitter}" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="youtube" class="col-sm-3 col-form-label"><?php echo display('youtube') ?> <i class="text-danger">*</i></label>
                                <div class="col-sm-6">
                                    <input class="form-control" name ="youtube" id="youtube" type="text" placeholder="<?php echo display('youtube') ?>" value="{youtube}" required>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                                <div class="col-sm-6">
                                    <input type="submit" id="add-customer" class="btn btn-success btn-large" name="add-customer" value="<?php echo display('save_changes') ?>" required />
                                </div>
                            </div>
                        </div>
                    <?php echo form_close()?>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Update social link end -->



