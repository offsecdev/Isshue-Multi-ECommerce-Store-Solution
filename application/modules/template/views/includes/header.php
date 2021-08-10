<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
$CI =& get_instance();
$CI->load->model('dashboard/Soft_settings');
$CI->load->model('dashboard/Reports');
$CI->load->model('dashboard/Users');
$Soft_settings = $CI->Soft_settings->retrieve_setting_editdata();
$users = $CI->Users->profile_edit_data();
$out_of_stock = $CI->Reports->out_of_stock_count();
$store_wise_products_count = 0;

if(!empty($this->session->userdata('language'))){
    $language_id= $this->session->userdata('language');
    
}else{

    $language_id= 'english';
}

?>

<input type ="hidden" name="base_url" id="base_url" value="<?php echo base_url(); ?>">
<input type ="hidden" name="CSRF_TOKEN" id="CSRF_TOKEN" value="<?php echo $this->security->get_csrf_hash(); ?>">
<input type ="hidden" name="language_id" id="language_id" value="<?php echo html_escape($language_id) ?>">
<script src="<?php echo base_url() ?>assets/js/global_js.js" defer type="text/javascript"></script>

<a href="<?php echo base_url('Admin_dashboard') ?>" class="logo"> <!-- Logo -->
    <span class="logo-mini">
        <img src="<?php if (isset($Soft_settings[0]['favicon'])) {
            echo base_url().$Soft_settings[0]['favicon'];
        } ?>" alt="">
     </span>
    <span class="logo-lg">
        <img src="<?php if (isset($Soft_settings[0]['logo'])) {
            echo base_url().$Soft_settings[0]['logo'];
        } ?>" alt="">
     </span>
</a>

<!-- Header Navbar -->
<nav class="navbar navbar-static-top color2">
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button"> <!-- Sidebar toggle button-->
            <span class="sr-only">Toggle navigation</span>
            <span class="pe-7s-keypad"></span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <?php
                if ($this->session->userdata('user_type') == 4) {
                    $individual_store_wise_products = $CI->Reports->individual_store_wise_product();
                    $individual_store_wise_products_count = 0;
                    if ($individual_store_wise_products):
                        foreach ($individual_store_wise_products as $individual_store_wise_product):
                            $store_product = $individual_store_wise_product['quantity'] - $individual_store_wise_product['sell'];

                            if ($store_product < 10) {
                                $individual_store_wise_products_count++;
                            }
                        endforeach;
                    endif;

                    ?>
                    <!-- ================================================= -->
                    <li class="dropdown notifications-menu">
                        <a href="<?php echo base_url('dashboard/Store_invoice/stock_report') ?>">
                            <i class="pe-7s-culture" title="<?php echo display('stock_report_store_wise') ?>"></i>
                            <span class="label label-danger"><?php echo html_escape($individual_store_wise_products_count) ?></span>
                        </a>
                    </li>

                    <!-- settings -->
                    <li class="dropdown dropdown-user">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="pe-7s-settings"></i></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo base_url('dashboard/Admin_dashboard/edit_profile') ?>"><i
                                            class="pe-7s-users"></i><?php echo display('user_profile') ?></a></li>
                            <li><a href="<?php echo base_url('dashboard/Admin_dashboard/change_password_form') ?>"><i
                                            class="pe-7s-settings"></i><?php echo display('change_password') ?></a></li>
                            <li><a href="<?php echo base_url('dashboard/Admin_dashboard/logout') ?>"><i
                                            class="pe-7s-key"></i><?php echo display('logout') ?></a></li>
                        </ul>
                    </li>

                    <!-- ================================================================================== -->

                <?php } else {
                    ?>

                    <li class="dropdown notifications-menu">
                        <a target="_blank" href="<?php echo base_url() ?>">
                            <i class="pe-7s-home" title="<?php echo display('go_to_website') ?>"></i>

                        </a>
                    </li>
                    <li class="dropdown notifications-menu">
                        <a href="<?php echo base_url('dashboard/Creport/out_of_stock') ?>">
                            <i class="pe-7s-attention" title="<?php echo display('out_of_stock') ?>"></i>
                            <span class="label label-danger"><?php echo html_escape($out_of_stock) ?></span>
                        </a>
                    </li>

                    <!-- settings -->
                    <li class="dropdown dropdown-user">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="pe-7s-settings"></i></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo base_url('dashboard/Admin_dashboard/edit_profile') ?>"><i
                                            class="pe-7s-users"></i><?php echo display('user_profile') ?></a></li>
                            <li><a href="<?php echo base_url('dashboard/Admin_dashboard/change_password_form') ?>"><i
                                            class="pe-7s-settings"></i><?php echo display('change_password') ?></a></li>
                            <li><a href="<?php echo base_url('dashboard/Admin_dashboard/logout') ?>"><i
                                            class="pe-7s-key"></i><?php echo display('logout') ?></a></li>
                        </ul>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </nav>