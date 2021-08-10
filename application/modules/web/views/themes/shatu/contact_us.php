<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php
$CI =& get_instance();
$CI->load->model('dashboard/Themes');
$theme = $CI->Themes->get_theme();

?>

<section class="contact_area">
    <div class="container">
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

        <div class="row text-center">
            <h2 class="m-0"><?php echo display('get_in_touch') ?></h2>
            <h5><?php echo display('your_email_address_will_not_be_published') ?></h5>
        </div>
        <div class="row contact_inner">
            <div class="col-sm-9">
                <?php echo form_open('submit_contact', array( 'class' => 'request_form')); ?> 

                    <div class="row comments_area">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="first_name" id="first_name"
                                       placeholder="<?php echo display('first_name') ?>" required>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="last_name" id="last_name"
                                       placeholder="<?php echo display('last_name') ?>" required>
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control" name="email" id="email"
                                       placeholder="<?php echo display('email') ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <textarea class="form-control msg_box" name="message"
                                          placeholder="<?php echo display('write_your_msg_here') ?> ..."></textarea>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <button href="#" class="btn-one pull-right"><?php echo display('submit') ?></button>
                        </div>
                    </div>
                <?php echo form_close(); ?>
            </div>
            <div class="col-sm-3">
                <div class="row m-0">
                    <div class="contact_info">
                        <h4><?php echo display('our_location') ?></h4>
                        <?php
                        if ($our_location_info) {
                            foreach ($our_location_info as $our_location) {
                                ?>
                                <div class="office_address">
                                    <h5><?php echo htmlspecialchars_decode($our_location['headline']) ?></h5>
                                    <?php echo htmlspecialchars_decode($our_location['details']) ?>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Contact Area -->

<!--========== Map Area ==========-->
<div class="container">
    <div class="map_area">
        <div id="map"></div>
    </div>
</div>
<!--======== End Map Area ==========-->


<?php
$CI =& get_instance();
$CI->load->model('dashboard/Companies');
$company_info = $CI->Companies->company_list();
?>

<!-- Google Map -->
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo html_escape($map_info[0]['map_api_key']) ?>"></script>
<input type="hidden" id="map_latitude" value="<?php echo html_escape($map_info[0]['map_latitude'])?>">
<input type="hidden" id="map_langitude" value="<?php echo html_escape($map_info[0]['map_langitude'])?>">
<input type="hidden" id="company_name" value="<?php echo html_escape($company_info[0]['company_name'])?>">
<script src="<?php echo THEME_URL.'shatu/assets/ajaxs/contact_us.js'; ?>"></script>

<?php 

d('contact_us'); ?>
