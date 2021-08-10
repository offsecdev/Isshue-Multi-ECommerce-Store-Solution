<?php
$CI =& get_instance();
$CI->load->model('dashboard/Themes');
$theme = $CI->Themes->get_theme();
?>
<section class="section-about py-3">
    <div class="container">

        <nav aria-label="breadcrumb" class="my-1">
            <ol class="breadcrumb d-inline-flex mb-0">
                <li class="breadcrumb-item align-items-center"><a href="<?php echo base_url() ?>" class="d-flex align-items-center"><i data-feather="home" class="mr-2"></i><?php echo display('home') ?></a></li>
                <li class="breadcrumb-item align-items-center active"><a href="<?php echo base_url('forget_password_form') ?>" class="d-flex align-items-center"><?php echo display('forget_password') ?></a></li>
            </ol>
        </nav>

        
        <div class="row">
            <div class="col-md-10 offset-md-1 col-lg-6 offset-lg-3">
                <!-- Alert Message -->
                <?php
                $message = $this->session->userdata('message');
                if (isset($message)) {
                    ?>
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <?php echo $message ?>
                    </div>
                    <?php
                    $this->session->unset_userdata('message');
                }
                $error_message = $this->session->userdata('error_message');
                if (isset($error_message)) {
                    ?>
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <?php echo $error_message ?>
                    </div>
                    <?php
                    $this->session->unset_userdata('error_message');
                }
                ?>
        
            </div>
        </div>
        <div class="row justify-content-center mb-5">
            <div class="col-md-4">

                <div class="form-title_wrap mb-3">
                    <p class="form-title mb-0"><?php echo display('lost_your_password') ?></p>
                </div>
                <!--Login Form-->
                <?php echo form_open('#'); ?>
                    <div class="recover_msg" id="recover_message"></div>
                    <div class="form-group">
                        <input type="email" class="form-control" name="forget_email" id="forget_email" value="<?php echo set_value('forget_email') ?>" placeholder="<?php echo display('email') ?>">
                    </div>
                    <button type="submit" id="forget_password_btn" class="btn btn-primary btn-block color4"><?php echo display('reset_password') ?></button>
                <?php echo form_close(); ?>
                <div>
                    
                    <div id="loader">
                        <img class="loader_img img-fluid" src="<?php echo base_url('my-assets/image/loader.gif') ?>" alt="" width="100">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="<?php echo THEME_URL.$theme.'/assets/ajaxs/forget_password.js'; ?>"></script>