<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Edit Menu start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('role')?></h1>
            <small><?php echo display('manage_roles')?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('soft_settings') ?></a></li>
                <li class="active"><?php echo display('manage_roles')?></li>
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
                            <h4><?php echo display('manage_roles')?> </h4>
                        </div>
                    </div>
                    <div class="panel-body">                       
                        <table class="table table-bordered table-hover" id="dataTableExample4">
                            <thead>
                                <tr>
                                    <th><?php echo display('sl_no') ?></th>
                                    <th><?php echo display('role_name') ?></th>
                                    <th><?php echo display('description') ?></th>
                                    <th><?php echo display('action') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($role_list)) ?>
                                <?php $sl = 1; ?>
                                <?php foreach ($role_list as $value) { ?>
                                <tr>
                                    <td><?php echo $sl++; ?></td>
                                    <td><?php echo $value->role_name; ?></td>
                                    <td><?php echo $value->role_description; ?></td>
                                    <td>
                                        <?php if($this->permission->check_label('role')->update()->access()){ ?>
                                        <a href="<?php echo base_url("dashboard/role/role_edit/$value->role_id") ?>"  data-toggle="tooltip" data-placement="left" title="Update" class="btn btn-success btn-sm">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                        <?php }if($this->permission->check_label('role')->delete()->access()){?>
                                        <a href="<?php echo base_url("dashboard/role/delete_role/$value->role_id") ?>" onclick="return confirm('<?php echo display("are_you_sure") ?>')" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="right" title="Delete ">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </a>
                                        <?php }?>
                                    </td>
                                </tr>
                                <?php } ?>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Edit Menu end -->