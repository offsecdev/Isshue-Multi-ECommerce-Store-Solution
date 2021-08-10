<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- Add Phrase Start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1>Phrase Edit</h1>
            <small>phrase Edit</small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> Home</a></li>
                <li><a href="#">Language</a></li>
                <li class="active">Phrase Edit</li>
            </ol>
        </div>
    </section>
    <section class="content">
        <!-- Phrase Edit -->
        <?php
        $message = $this->session->userdata('message');
        if (isset($message)) {
        ?>
            <div class="alert alert-info alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $message ?>
            </div>
        <?php
        }
        ?>

        <div class="row">
            <div class="col-sm-12">
                <?php if($this->permission->check_label('language')->read()->access()){ ?>
                    <a href="<?php echo  base_url('dashboard/Language') ?>" class="btn btn-info">Language Home</a>
                <?php } ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4>Phrase Edit</h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <?php echo form_open('language/addlebel') ?>
                            <table id="" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th><i class="fa fa-th-list"></i></th>
                                        <th>Phrase</th>
                                        <th>Label</th>
                                    </tr>
                                </thead>

                                <tbody>
                                <?php echo form_hidden('language', $language) ?>
                                <?php if (!empty($phrases)) { ?>
                                    <?php $sl = 1 ?>
                                    <?php foreach ($phrases as $value) { ?>
                                        <tr class="<?php echo(empty($value->$language) ? "bg-danger" : null) ?>">

                                            <td><?php echo $sl++ ?></td>
                                            <td><input type="text" name="phrase[]" value="<?php echo html_escape($value->phrase) ?>"
                                                       class="form-control" readonly></td>
                                            <td><input type="text"
                                                       onblur="editLang('<?php echo html_escape($value->id); ?>','<?php echo $this->uri->segment(4) ?>')"
                                                       id="<?php echo html_escape($value->id); ?>" name="lang[]"
                                                       value="<?php echo html_escape($value->$language) ?>" class="form-control">
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                                </tbody>
                            </table>
                            <?php echo form_close() ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>



