<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- Add new customer start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('module_list') ?></h1>
            <small><?php echo display('module_list') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li class="active"><?php echo display('module_list') ?></li>
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
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo html_escape(!empty($title) ? $title : null) ?></h4>
                        </div>
                    </div>
                    <div class="panel-body">


                        <table class="datatable table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th><?php echo display('sl_no') ?></th>
                                <th><?php echo display('image') ?></th>
                                <th><?php echo display('module_name') ?></th>
                                <th><?php echo display('description') ?></th>
                                <th><?php echo display('directory') ?></th>
                                <th><?php echo display('status') ?></th>
                                <th><?php echo display('action') ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($moduleData)) ?>
                            <?php $sl = 1; ?>
                            <?php foreach ($moduleData as $value) { ?>
                                <tr>
                                    <td><?php echo $sl++; ?></td>
                                    <td>
                                        <img src="<?php echo base_url(!empty($value->image) ? $value->image : 'assets/img/icons/default.jpg'); ?>"
                                             alt="Image" height="50"></td>
                                    <td><?php echo html_escape($value->name); ?></td>
                                    <td><?php echo html_escape($value->description); ?></td>
                                    <td><?php echo html_escape($value->directory); ?></td>
                                    <td>
                                        <?php echo(($value->status == 1) ? display('active') : display('inactive')); ?>
                                    </td>
                                    <td>
                                        <?php if ($value->status == 1) { ?>
                                            <a href="<?php echo base_url("dashboard/module/status/$value->id/inactive") ?>"
                                               onclick="return confirm('<?php echo display("are_you_sure") ?>')"
                                               class="btn btn-warning btn-sm" data-toggle="tooltip"
                                               data-placement="right" title="Inactive"><i class="fa fa-times" aria-hidden="true"></i></a>
                                        <?php } else { ?>
                                            <a href="<?php echo base_url("dashboard/module/status/$value->id/active") ?>"
                                               onclick="return confirm('<?php echo display("are_you_sure") ?>')"
                                               class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="right"
                                               title="Active"><i class="fa fa-check" aria-hidden="true"></i></a>
                                        <?php } ?>
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