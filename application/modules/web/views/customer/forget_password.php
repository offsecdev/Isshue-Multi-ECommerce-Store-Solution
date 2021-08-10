<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="page-breadcrumbs">
    <div class="container">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url() ?>"><?php echo display('home') ?></a></li>
            <li class="active"><?php echo display('forget_password') ?></li>
        </ol>
    </div>
</div>
<!--========== End Page Header Area ==========-->

<div class="lost-password bg_ff">
    <?php
    if ($this->session->userdata('message')) {
        $message = $this->session->userdata('message');
        if ($message) {
            ?>
            <div class="alert alert-success">
                <strong><?php echo display('success') ?></strong> <?php echo $message ?>
            </div>
            <?php
        }
        $this->session->unset_userdata('message');
    }
    ?>

    <div class="lost-password p_1e">
        <p><?php echo display('lost_your_password') ?></p>
        <?php echo form_open('#')?>
            <div class="form-group">
                <label class="control-label" for="user_email"><?php echo display('email') ?> <abbr class="required" title="required">*</abbr></label>
                <input type="text" name="forget_email" required id="forget_email" class="form-control">
            </div>
            <button type="button" id="forget_password_btn"
                    class="btn btn-primary color2"><?php echo display('reset_password') ?>

            </button>
        <?php echo form_close(); ?>
    </div>
    <div>
        <div class="recover_msg" id="recover_message"></div>
        <div id="loader">
            <img class="loader_img" src="<?php echo base_url('my-assets/image/loader.gif') ?>" alt="">
        </div>
    </div>
</div>
<script src="<?php echo MOD_URL.'web/assets/js/forget_password.js'; ?>"></script>
