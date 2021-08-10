<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1>Add Phrase</h1>
            <small>Add phrase</small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> Home</a></li>
                <li><a href="#">Language</a></li>
                <li class="active">Add Phrase</li>
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
            $this->session->unset_userdata('message');
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
                            <h4>Add Phrase</h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
                                <thead>
                                <tr>
                                    <td colspan="2">
                                        <?php echo  form_open('language/addPhrase', ' class="form-inline" ') ?>
                                        <div class="form-group">
                                            <label class="sr-only" for="addphrase"> Phrase Name</label>
                                            <input name="phrase[]" type="text" class="form-control" id="addphrase"
                                                   placeholder="Phrase Name">
                                        </div>

                                        <button type="submit" class="btn btn-primary">Save</button>
                                        <?php echo  form_close(); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><i class="fa fa-th-list"></i></th>
                                    <th>Phrase</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($phrases)) { ?>
                                    <?php $sl = 1 ?>
                                    <?php foreach ($phrases as $value) { ?>
                                        <tr>
                                            <td><?php echo  $sl++ ?></td>
                                            <td><?php echo  html_escape($value->phrase) ?></td>
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




