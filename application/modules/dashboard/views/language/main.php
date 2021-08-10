<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1>Manage Language</h1>
            <small>Manage your language</small>
            <ol class="breadcrumb">
                <li><i class="pe-7s-home"></i> Home</li>
                <li>Language</li>
                <li class="active">Manage Language</li>
            </ol>
        </div>
    </section>

    <section class="content">
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
                <a href="<?php echo base_url('dashboard/Language/phrase') ?>" class="btn btn-info color4 color5">Add
                    Phrase</a>
                <?php } ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4>Manage Language</h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
                                <thead>
                                <tr>
                                    <td colspan="3">
                                        <?php echo form_open('dashboard/language/addlanguage', ' class="form-inline" ') ?>
                                        <div class="form-group">
                                            <label class="sr-only" for="addLanguage"> Language Name</label>
                                            <input name="language" type="text" class="form-control" id="addLanguage"
                                                   placeholder="Language Name">
                                        </div>

                                        <button type="submit" class="btn btn-primary">Save</button>
                                        <?php echo form_close(); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><i class="fa fa-th-list"></i></th>
                                    <th>Language</th>
                                    <th><i class="fa fa-cogs"></i></th>
                                </tr>
                                </thead>


                                <tbody>
                                <?php if (!empty($languages)) { ?>
                                    <?php $sl = 1 ?>
                                    <?php foreach ($languages as $key => $language) { ?>
                                        <tr>
                                            <td><?php echo $sl++ ?></td>
                                            <td><?php echo html_escape($language) ?></td>
                                            <td>
                                                <?php if($this->permission->check_label('language')->update()->access()){ ?>
                                                <a href="<?php echo base_url("dashboard/Language/editPhrase/$key") ?>"
                                                   class="btn btn-xs btn-info">
                                                   <i class="fa fa-edit"></i>
                                               </a>
                                                <?php } ?>
                                                <?php if($this->permission->check_label('language')->delete()->access()){
                                                if (strtolower($language) != 'english') { ?>
                                                    <a href="<?php echo base_url("dashboard/Language/deletePhrase/$key") ?>" class="btn btn-xs btn-danger" onclick="return confirm('<?php echo display('are_you_sure_want_to_delete') ?>');">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                <?php } } ?>

                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>




