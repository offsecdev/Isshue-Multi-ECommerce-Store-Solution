<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!--========== Page Header Area ==========-->
<section class="page_header">
    <div class="container">
        <div class="row m0 page_header_inner">
            <h2 class="page_title"><?php echo display('contact_us') ?></h2>
            <ol class="breadcrumb m0 p0">
                <li class="breadcrumb-item"><a href="<?php echo base_url() ?>"><?php echo display('home') ?></a></li>
                <li class="breadcrumb-item active"><?php echo display('contact_us') ?></li>
            </ol>
        </div>
    </div>
</section>
<!--========== End Page Header Area ==========-->

<!--========== Contact Area ==========-->
<section class="contact_area">
    <div class="container">
        <div class="row contact_inner">
            <div class="col-md-6">
                <?php
                $message = $this->session->userdata('message');
                if (isset($message)) {
                    ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
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
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <?php echo $error_message ?>
                    </div>
                    <?php
                    $this->session->unset_userdata('error_message');
                }
                ?>

                <div class="row m0 db comments_area">
                    <h2 class="contact_heading"><?php echo display('get_in_touch') ?></h2>
                    <?php echo form_open('submit_contact', array('class' => 'request_form'))?>

                        <input type="text" class="form-control" name="first_name" id="first_name"
                               placeholder="<?php echo display('first_name') ?>" required>
                        <input type="text" class="form-control" name="last_name" id="last_name"
                               placeholder="<?php echo display('last_name') ?>" required>
                        <input type="email" class="form-control" name="email" id="email"
                               placeholder="<?php echo display('email') ?>" required>
                        <textarea class="form-control" name="message"
                                  placeholder="<?php echo display('write_your_msg_here') ?> ..." required></textarea>
                        <button href="#" class=""><?php echo display('submit') ?></button>
                    <?php echo form_close(); ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row db m0 about_us_widget">
                    <h2 class="contact_heading"><?php echo display('our_location') ?></h2>

                    <?php
                    if ($our_location_info) {
                        foreach ($our_location_info as $our_location) {
                            ?>
                            <div class="office_address">
                                <?php echo htmlspecialchars_decode($our_location['headline']) ?>
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
</section>
<!--========== End Contact Area ==========-->

<!--========== Map Area ==========-->
<div class="map_area">
    <div id="map"></div>
</div>
<!--======== End Map Area ==========-->

<!--=========== Newsletter Area ===========-->
<section class="newsletter_area">
    <div class="container">
        <div class="row m0 newsletter_inner bg_gray">
            <div class="col-lg-6 col-xl-5">
                <div class="row m0 newsletter_left_area">
                    <h4><?php echo display('sign_up_for_news_and') ?> <span><?php echo display('offers') ?></span></h4>
                    <h6><?php echo display('you_may_unsubscribe_at_any_time') ?></h6>
                </div>
            </div>
            <div class="col-lg-6 col-xl-7">
                <div id="sub_msg"></div>
                <?php echo form_open('', array('class' => 'row m0 newsletter_form'))?>
                    <div class="input-group">
                        <input type="email" class="form-control" placeholder="<?php echo display('enter_your_email') ?>"
                               required="" id="sub_email">
                        <span class="input-group-btn">
                            <button class="btn btn-default subscribe" type="button" id="smt_btn"><i
                                        class="fa fa-search"></i></button>
                        </span>
                    </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</section>
<!--========= End Newsletter Area =========-->
<?php
$CI =& get_instance();
$CI->load->model('dashboard/Companies');
$company_info = $CI->Companies->company_list();
?>

<!-- Google Map -->
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $map_info[0]['map_api_key'] ?>"></script>
