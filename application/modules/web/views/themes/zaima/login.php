<?php
$CI =& get_instance();

$CI->load->model('dashboard/Themes');
$CI->load->model('dashboard/Companies');
$theme = $CI->Themes->get_theme();
$company_info = $CI->Companies->company_list();
?>
<section class="section-about py-5">
    <div class="container">
        
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
        
                <div class="section-title text-center mb-5">
                    <h2 class="fs-28 font-weight-normal"><?php echo display('welcome_back_to_login') ?></h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class=" border-0">
                    <div class="">
                        <div class="accordion" id="accordionExample">
                            <div id="collapseOne" class="collapse show" data-parent="#accordionExample">
                                <div class="form-title_wrap mb-3">
                                    <h4 class="form-title mb-0"><?php echo display('login') ?></h4>
                                </div>
                                <!--Login Form-->
                                <?php echo form_open(base_url() . 'do_login'); ?>
                                    <div class="form-group">
                                        <input type="email" class="form-control" name="email" id="user_login_email" value="<?php echo set_value('email') ?>" placeholder="<?php echo display('email') ?>">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control" name="password" id="user_login_password" placeholder="<?php echo display('password') ?>">
                                    </div>
                                    <div class="d-flex justify-content-between mb-3">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="remember">
                                            <label class="custom-control-label" for="remember"><?php echo display('remember_me') ?></label>
                                        </div>
                                        <a href="<?php echo base_url('forget_password_form') ?>" class="forgot d-block text-left"><?php echo display('i_have_forgotten_my_password') ?></a>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-block color4"><?php echo display('login') ?></button>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <div class="signup-section"><?php echo display('dont_have_an_account'); ?> <a href="<?php echo base_url('signup') ?>" class="text-primary color42"><?php echo display('sign_up'); ?></a></div>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-md-6 form-group">
                         <?php if(check_module_status('googlelogin') == 1){ 
                        ?>
                            <a class="btn btn-google btn-sm btn-block  search text-white" href="<?php echo base_url('googlelogin/googlelogin/login')?>"><i class="fab fa-google mr-5"></i> <?php echo display('google_login')?></a>
                        <?php }?>
                    </div>
                    <div class="col-md-6 form-group">
                        <?php if((check_module_status('facebooklogin') == 1)){
                        ?>
                            <a class="btn btn-facebook btn-sm btn-block  search text-white" href="<?php echo base_url('facebooklogin/facebooklogin/index/1')?>"><i class="fab fa-facebook mr-5"></i> <?php echo display('facebook_login')?></a>
                        <?php }?> 
                    </div>
                    <div class="col-md-6 form-group">
                        <?php if((check_module_status('linkedinlogin') == 1)){ ?>
                            <a class="btn btn-linkedin btn-sm btn-block  search text-white" href="<?php echo base_url('linkedinlogin/linkedinlogin/login/1')?>"><i class="fab fa-linkedin mr-5"></i> <?php echo display('linkedin_login')?></a>
                        <?php }?>
                    </div>
                </div>

            </div>
        </div>

    </div>
</section>
