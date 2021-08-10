<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<link href="<?php echo base_url('application/modules/addon/assets/css/style.css'); ?>" rel="stylesheet" type="text/css"/>
<!-- Add new link page start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('themes') ?></h1>
            <small><?php echo display('add') ?></small>
             <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('themes') ?></a></li>
                <li class="active"><?php echo display('add') ?></li>
            </ol>
        </div>
    </section>

    <section class="content">

         <?php $this->load->view('template/includes/messages'); ?>

        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd">
                    <div class="panel-heading">
                        <div class="panel-title box-header">
                            <h4><?php echo html_escape(!empty($title) ? $title : null) ?></h4>
                            <div>
                                <a href="<?php echo base_url('addon/theme')?>" class="btn btn-success"><i class="ti-align-justify"> </i> <?php echo display('themes')?></a> 
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6 col-md-offset-2">
                                <?php echo form_open('#', array('id' => 'purchase')); ?>
                                <div id="purchase_key_box" class="form-group has-success">
                                    <label class="form-control-label" for="purchase_key">Purchase Key</label>
                                    <input type="text" class="form-control form-control-success" id="purchase_key" placeholder="Enter your purchase key">
                                    <div class="form-feedback">Success! Almost done it.</div>
                                    <small class="text-muted">You got a purchase key after purchasing this item</small>
                                    <br>
                                    <input type="hidden" name="itemtype" id="itemtype" value="theme">
                                </div>
                                <div class="form-group">
                                    <a href="<?php echo base_url('addon/theme'); ?>" class="btn btn-danger" data-dismiss="modal">Cancel</a>
                                    <button type="submit" class="btn btn-success" id="download_now">Download Now</button>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                        <div id="loading" class="text-center none">
                            <img id="loading-image" src="<?php echo base_url('application/modules/addon/assets/img/load.gif')?>" alt="Loading..." width="100"  />
                        </div>
                        <div class="row waitmsg none">
                            <div class="col-md-12">
                                <h3 class="text-center">Downloading... Please wait for <span id="wait"> 20</span> Seconds.</h3>
                            </div> 
                        </div>
            
                    </div>
                </div>
            </div>

            


        </div>
    </section>
</div>

<script src="<?php echo base_url().'application/modules/addon/assets/ajaxs/addons/download_theme.js' ?>"></script>
