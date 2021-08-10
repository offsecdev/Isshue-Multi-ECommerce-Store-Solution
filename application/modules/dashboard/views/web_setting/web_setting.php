<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Update web setting start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('web_settings') ?></h1>
            <small><?php echo display('update_your_web_settings') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('web_settings') ?></a></li>
                <li class="active"><?php echo display('web_settings') ?></li>
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

        <!--Update web setting -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-bd lobidrag">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h4><?php echo display('web_settings') ?> </h4>
                            </div>
                        </div>
                        <?php echo form_open_multipart('dashboard/Cweb_setting/update_web_settings/{setting_id}', array('class' => 'form-vertical', 'id' => 'validate')) ?>
                        <div class="panel-body">

                            <div class="form-group row">
                                <label for="logo" class="col-sm-3 col-form-label"><?php echo display('logo') ?> </label>
                                <div class="col-sm-6">
                                    <input class="form-control" name="logo" id="logo" type="file">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="logo" class="col-sm-3 col-form-label"></label>
                                <div class="col-sm-6">
                                    <img src="<?php echo base_url() ?>{logo}" class="img img-responsive" height="100"
                                         width="100">
                                    <input name="old_logo" type="hidden" value="{logo}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="footer_logo"
                                       class="col-sm-3 col-form-label"><?php echo display('footer_logo') ?></label>
                                <div class="col-sm-6">
                                    <input class="form-control" name="footer_logo" id="footer_logo" type="file">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="footer_logo" class="col-sm-3 col-form-label"></label>
                                <div class="col-sm-6">
                                    <img src="<?php echo base_url() ?>{footer_logo}" class="img img-responsive"
                                         height="100" width="100">
                                    <input name="old_footer_logo" type="hidden" value="{footer_logo}">
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="favicon"
                                       class="col-sm-3 col-form-label"><?php echo display('favicon') ?></label>
                                <div class="col-sm-6">
                                    <input class="form-control" name="favicon" id="favicon" type="file">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="favicon" class="col-sm-3 col-form-label"></label>
                                <div class="col-sm-6">
                                    <img src="<?php echo base_url() ?>{favicon}" class="img img-responsive" height="50"
                                         width="50">
                                    <input name="old_favicon" type="hidden" value="{favicon}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="footer_details" class="col-sm-3 col-form-label"><?php echo display('footer_details')?></label>
                                <div class="col-sm-6">
                                    <textarea class="form-control" name="footer_details" id="footer_details" cols="30" rows="10">{footer_details}</textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="google_analytics" class="col-sm-3 col-form-label"><?php echo display('google_analytics')?></label>
                                <div class="col-sm-6">
                                    <textarea class="form-control" name="google_analytics" id="google_analytics" cols="30" rows="10">{google_analytics}</textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="facebook_messenger" class="col-sm-3 col-form-label"><?php echo display('facebook_messenger')?></label>
                                <div class="col-sm-6">
                                    <textarea class="form-control" name="facebook_messenger" id="facebook_messenger" cols="30" rows="10">{facebook_messenger}</textarea>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="facebook_messenger" class="col-sm-3 col-form-label"><?php echo display('meta_keyword')?></label>
                                <div class="col-sm-6">
                                    <input type="text" name="meta_keyword" value="{meta_keyword}" id="meta_keyword" class="form-control">
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="facebook_messenger" class="col-sm-3 col-form-label"><?php echo display('meta_description')?></label>
                                <div class="col-sm-6">
                                    <input type="text" name="meta_description" value="{meta_description}" id="meta_description" class="form-control">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="lrt"
                                       class="col-sm-3 col-form-label"><?php echo display('app_link_status') ?></label>
                                <div class="col-sm-6">
                                    <select class="form-control" name="app_link_status" id="app_link_status">
                                        <option value=""><?php echo display('select_one') ?></option>
                                        <option value="0" <?php if ($app_link_status == 0) {
                                            echo "selected";
                                        } ?>><?php echo display('inactive') ?></option>
                                        <option value="1" <?php if ($app_link_status == 1) {
                                            echo "selected";
                                        } ?>><?php echo display('active') ?></option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="lrt"
                                       class="col-sm-3 col-form-label"><?php echo display('pay_with') ?></label>
                                <div class="col-sm-6">
                                    <select class="form-control" name="pay_with" id="qr_status">
                                        <option value=""><?php echo display('select_one') ?></option>
                                        <option value="0" <?php if ($pay_with == 0) {
                                            echo "selected";
                                        } ?>><?php echo display('inactive') ?></option>
                                        <option value="1" <?php if ($pay_with == 1) {
                                            echo "selected";
                                        } ?>><?php echo display('active') ?></option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="footer_text"
                                       class="col-sm-3 col-form-label"><?php echo display('footer_text') ?></label>
                                <div class="col-sm-6">
                                    <input class="form-control valid" name="footer_text" id="footer_text" type="text"
                                           placeholder="<?php echo display('footer_text') ?>"
                                           value="<?php echo htmlentities($footer_text) ?>" aria-invalid="false">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="map_api_key"
                                       class="col-sm-3 col-form-label"><?php echo display('map_api_key') ?> <i
                                            class="text-danger">*</i></label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="map_api_key" id="map_api_key "
                                           placeholder="<?php echo display('map_api_key') ?>" required
                                           value="{map_api_key}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="map_latitude"
                                       class="col-sm-3 col-form-label"><?php echo display('map_latitude') ?> <i
                                            class="text-danger">*</i></label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="map_latitude" id="map_latitude "
                                           placeholder="<?php echo display('map_latitude') ?>" required
                                           value="{map_latitude}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="map_langitude"
                                       class="col-sm-3 col-form-label"><?php echo display('map_longitude') ?> <i
                                            class="text-danger">*</i></label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="map_langitude" id="map_langitude "
                                           placeholder="<?php echo display('map_langitude') ?>" required
                                           value="{map_langitude}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="social_share" class="col-sm-3 col-form-label"><?php echo display('social_share') ?></label>
                                <div class="col-sm-6">
                                    <select class="form-control" name="social_share" id="social_share">
                                        <option value="1" <?php if (@$social_share == '1') {
                                            echo "selected";
                                        } ?>><?php echo display('active') ?></option>
                                        <option value="0" <?php if (@$social_share == '0') {
                                            echo "selected";
                                        } ?>><?php echo display('inactive') ?></option>
                                        
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-11 col-md-offset-1">
                                    <h3><?php echo display('mobile_settings') ?></h3>
                                </div>
                            </div>
                            <?php
                            $blockitems = [1,0,0,1];
                            if(!empty($mob_footer_block)){
                                $blockitems = json_decode($mob_footer_block);
                            }

                             ?>
                            <div class="form-group row">
                                <label for="map_langitude"
                                       class="col-sm-3 col-form-label"><?php echo display('footer_block_1') ?> <i class="text-danger">*</i></label>
                                <div class="col-sm-6">
                                    <label class="radio-inline">
                                      <input type="radio" name="footer_block_1" value="1" <?php echo ($blockitems[0]=='1'?'checked':'') ?>><?php echo display('show'); ?>
                                    </label>
                                    <label class="radio-inline">
                                      <input type="radio" name="footer_block_1" value="0" <?php echo ($blockitems[0]=='0'?'checked':'') ?>> <?php echo display('hide'); ?>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="map_langitude"
                                       class="col-sm-3 col-form-label"><?php echo display('footer_block_2') ?> <i class="text-danger">*</i></label>
                                <div class="col-sm-6">
                                    <label class="radio-inline">
                                      <input type="radio" name="footer_block_2" value="1" <?php echo ($blockitems[1]=='1'?'checked':'') ?>> <?php echo display('show'); ?>
                                    </label>
                                    <label class="radio-inline">
                                      <input type="radio" name="footer_block_2" value="0" <?php echo ($blockitems[1]=='0'?'checked':'') ?>> <?php echo display('hide'); ?>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="map_langitude"
                                       class="col-sm-3 col-form-label"><?php echo display('footer_block_3') ?> <i class="text-danger">*</i></label>
                                <div class="col-sm-6">
                                    <label class="radio-inline">
                                      <input type="radio" name="footer_block_3" value="1" <?php echo ($blockitems[2]=='1'?'checked':'') ?>> <?php echo display('show'); ?>
                                    </label>
                                    <label class="radio-inline">
                                      <input type="radio" name="footer_block_3" value="0" <?php echo ($blockitems[2]=='0'?'checked':'') ?>> <?php echo display('hide'); ?>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="map_langitude"
                                       class="col-sm-3 col-form-label"><?php echo display('footer_block_4') ?> <i class="text-danger">*</i></label>
                                <div class="col-sm-6">
                                    <label class="radio-inline">
                                      <input type="radio" name="footer_block_4" value="1" <?php echo ($blockitems[3]=='1'?'checked':'') ?>> <?php echo display('show'); ?>
                                    </label>
                                    <label class="radio-inline">
                                      <input type="radio" name="footer_block_4" value="0" <?php echo ($blockitems[3]=='0'?'checked':'') ?>> <?php echo display('hide'); ?>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                                <div class="col-sm-6">
                                    <input type="submit" id="add-customer" class="btn btn-success btn-large" name="add-customer" value="<?php echo display('save_changes') ?>" required/>
                                </div>
                            </div>
                        </div>
                        <?php echo form_close() ?>
                    </div>
                </div>
            </div>
    </section>
</div>
<!-- Update web setting end -->



