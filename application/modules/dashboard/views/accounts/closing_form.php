<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Closing Account start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('closing_account') ?></h1>
            <small><?php echo display('close_your_account') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('accounts') ?></a></li>
                <li class="active"><?php echo display('closing_account') ?></li>
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
                <?php if($this->permission->check_label('closing_report')->read()->redirect()){ ?>
                      <a href="<?php echo base_url('dashboard/Caccounts/closing_report')?>" class="btn btn-success color4 m-b-5 m-r-2"><i class="ti-align-justify"> </i><?php echo display('closing_report')?></a>
                <?php } ?>
                </div>
            </div>
        </div>
        <?php

        $cash_in = (int)str_replace(',', '', $closing['cash_in']) + (int)$paid_amount[0]['paid_amount'];
        $cash_out =  (int)str_replace(',', '', $closing['cash_out']);
        $cashInHand = $cash_in - $cash_out;

        ?>
        <!-- New supplier -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('closing_account') ?></h4>
                        </div>
                    </div>
                 	
                 	<div class="panel-body">
                        <?php echo form_open_multipart('dashboard/Caccounts/add_daily_closing',array('class' => 'form-vertical' ))?>
                    	<div class="form-group row">
                            <label for="last_day_closing" class="col-sm-3 col-form-label"><?php echo display('last_day_closing') ?></label>
                            <div class="col-sm-6">
                                <input type="text" name="last_day_closing" class="form-control" value="<?php echo html_escape($closing['last_day_closing']);  ?>"/>
                            </div>
                        </div>

                       	<div class="form-group row">
                            <label for="cash_in" class="col-sm-3 col-form-label"><?php echo display('cash_in') ?></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="cash_in" value="<?php echo html_escape($cash_in); ?>"/>
                            </div>
                        </div>
   
                        <div class="form-group row">
                            <label for="cash_out" class="col-sm-3 col-form-label"><?php echo display('cash_out') ?></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="cash_out" value="<?php echo html_escape($cash_out); ?>"/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="cash_in_hand" class="col-sm-3 col-form-label"><?php echo display('cash_in_hand') ?></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="amount" name="cash_in_hand" value="<?php echo html_escape($cashInHand);  ?>"/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="adjusment" class="col-sm-3 col-form-label"><?php echo display('adjustment') ?></label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control" id="adjusment" name="adjusment" placeholder="<?php echo display('adjustment') ?>" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
                                <input type="submit" id="add-deposit" class="btn btn-primary" name="add-deposit" value="<?php echo display('day_closing') ?>"/>
                            </div>
                        </div>
                        
                    <?php echo form_close()?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Closing Account end -->




