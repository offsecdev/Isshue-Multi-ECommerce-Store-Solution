<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

<link rel="stylesheet" type="text/css" href="<?php echo MOD_URL.'dashboard/assets/css/role/role_add.css'; ?>">

<!-- Add Role start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('add_role')?></h1>
            <small><?php echo display('add_role')?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('soft_settings')?></a></li>
                <li class="active"><?php echo display('add_role')?></li>
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
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('add_role')?></h4>
                        </div>
                    </div>
                    <?php echo form_open("dashboard/role/role_add") ?>
                    <div class="panel-body">
                        <div class="form-group row">
                            <label for="role_name" class="col-xs-3 col-form-label"><?php echo display('role_name') ?> <i class="text-danger">*</i></label>
                            <div class="col-xs-9">
                                <input name="role_name" type="text" class="form-control" id="role_name" placeholder="<?php echo display('role_name') ?>"  >
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="role_description" class="col-xs-3 col-form-label"><?php echo display('description') ?> <i class="text-danger">*</i></label>
                            <div class="col-xs-9">
                                <textarea class="form-control" rows="2" name="role_description" id="role_description" placeholder="<?php echo display('description') ?>"></textarea>
                            </div>
                        </div>
                        <?php $m = 0;?>                  
                        <?php foreach ($modules as $value) { 
                        $menu_item = $this->db->select('*')->from('sec_menu_item')->where('module',$value->module)->get()->result();
                        ?>
                        <input type="hidden" name="module[]" value="<?php echo $value->module;?>">
                        <table class="table table-bordered table-hover" id="RoleTbl">
                            <h2><?php echo display($value->module)?></h2>
                            <thead>
                                <tr>
                                    <th class="text-center"><?php echo display('sl') ?></th>
                                    <th class="text-center"><?php echo display('menu_title')?></th>
                                    <th class="text-center"><?php echo display('create')?></th>
                                    <th class="text-center"><?php echo display('read')?></th>
                                    <th class="text-center"><?php echo display('update')?></th>
                                    <th class="text-center"><?php echo display('delete')?></th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php if (!empty($menu_item)) ?>
                                <?php $sl = 0; ?>

                                <?php foreach ($menu_item as $value) {
                                    $actions = str_split($value->actions);
                                 ?>
                                <tr>
                                    <td><?php echo $sl+1; ?></td>
                                    <td class="text-<?php echo ($value->parent_menu?'right':'')?>"><?php echo display($value->menu_title); ?></td>
                                    <td>
                                        <?php if(!empty($actions[0])){ ?>
                                        <div class="checkbox checkbox-success text-center">
                                            <input type="checkbox" name="create[<?php echo $m?>][<?php echo $sl ?>][]" value="1" id="create[<?php echo $m?>]<?php echo $sl?>">
                                            <label for="create[<?php echo $m?>]<?php echo $sl ?>"></label>
                                        </div>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php if(!empty($actions[1])){ ?>
                                        <div class="checkbox checkbox-success text-center">
                                            <input type="checkbox" name="read[<?php echo $m?>][<?php echo $sl ?>][]" value="1" id="read[<?php echo $m?>]<?php echo $sl?>">
                                            <label for="read[<?php echo $m?>]<?php echo $sl ?>"></label>
                                        </div>
                                        <?php } ?>
                                    </td> 
                                    <td>
                                        <?php if(!empty($actions[2])){ ?>
                                        <div class="checkbox checkbox-success text-center">
                                           <input type="checkbox" name="edit[<?php echo $m?>][<?php echo $sl ?>][]" value="1" id="edit[<?php echo $m?>]<?php echo $sl?>">
                                            <label for="edit[<?php echo $m?>]<?php echo $sl ?>"></label>
                                        </div>
                                        <?php } ?>
                                    </td> 
                                    <td>
                                        <?php if(!empty($actions[3])){ ?>
                                        <div class="checkbox checkbox-success text-center">
                                            <input type="checkbox" name="delete[<?php echo $m?>][<?php echo $sl ?>][]" value="1" id="delete[<?php echo $m?>]<?php echo $sl?>">
                                            <label for="delete[<?php echo $m?>]<?php echo $sl ?>"></label>
                                        </div>
                                        <?php } ?>
                                    </td>
                                    <input type="hidden" name="menu_id[<?php echo $m?>][<?php echo $sl ?>][]" value="<?php echo $value->menu_id?>">
                                </tr>
                                <?php $sl++ ?>
                                <?php } ?>
                                
                            </tbody>
                        </table>
                        <?php $m++ ?>
                        <?php } ?>
                        <div class="form-group text-right">
                           <button type="submit" class="btn btn-success w-md m-b-5"><?php echo display('save') ?></button>
                        </div>
                    </div>
                    <?php echo form_close();?>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Add Role end -->