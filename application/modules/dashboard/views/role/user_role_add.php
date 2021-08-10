<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- User access role start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('user_access_role')?></h1>
            <small><?php echo display('user_access_role')?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('soft_settings') ?></a></li>
                <li class="active"><?php echo display('user_access_role')?></li>
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
            $validatio_error = validation_errors();
            if (($error_message || $validatio_error)) {
        ?>
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?php echo $error_message ?>                    
            <?php echo $validatio_error ?>                    
        </div>
        <?php 
            $this->session->unset_userdata('error_message');
            }
        ?>

        <div class="row">
            <div class="col-sm-12 col-md-12">
                <?php if($this->permission->check_label('role')->create()->access()){ ?>
                <a href="<?php echo base_url('dashboard/role/user_access_role');?>" class="btn btn-success my-modal" onclick="add_access()" ><i class="ti-align-justify"></i> <?=display('manage_user_roles')?></a>
                <?php } ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('user_access_role')?> </h4>
                        </div>
                    </div>
                    <?php echo form_open("dashboard/role/role_add_to_user") ?>
                    <div class="panel-body">

                        <div class="form-group row">
                            <label for="user_id" class="col-sm-3 col-form-label"><?php echo display('user') ?> *</label>
                            <div class="col-sm-6">
                                <select class="form-control" name="user_id" id="user_id" required="">
                                    <option></option>
                                    <?php 
                                       foreach($user as $val){
                                        echo '<option value="'.$val->user_id.'">'.$val->first_name.' '.$val->last_name.'.</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="role_id" class="col-sm-3 col-form-label"><?php echo display('role') ?> *</label>
                            <div class="col-sm-6">
                            <?php foreach($role as $val){ ?>
                                <label class="radio-inline">
                                    <input type="checkbox" name="role[]" value="<?php echo $val->role_id;?>"> <?php echo $val->role_name;?>
                                </label> 
                            <?php } ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-9 col-sm-offset-3">
                                <button type="submit" class="btn btn-success w-md m-b-5"><?php echo display('save') ?></button>
                            </div>
                        </div>

                    </div>
                    <?php echo form_close();?>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- User access role end -->
 