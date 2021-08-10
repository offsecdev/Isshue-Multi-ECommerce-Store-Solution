<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!--========== Page Header Area ==========-->
<section class="page_header">
    <div class="container">
        <div class="row m0 page_header_inner">
            <h2 class="page_title"><?php echo display('about_us') ?></h2>
            <ol class="breadcrumb m0 p0">
                <li class="breadcrumb-item"><a href="<?php echo base_url() ?>"><?php echo display('home') ?></a></li>
                <li class="breadcrumb-item active"><?php echo display('about_us') ?></li>
            </ol>
        </div>
    </div>
</section>
<!--========== End Page Header Area ==========-->

<!--==== welcome  Area ========-->
<section class="welcome_area">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="row m0 db img_area">
                    <img src="<?php echo html_escape($image) ?>" alt="Img">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="welcome_inner">
                    <?php echo html_escape($headlines) ?>
                    <?php echo html_escape($details) ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!--==== End welcome Area ====-->

<!--====== Start Choose Us Area ======-->
<?php if (!empty($about_content_info)) { ?>
<section class="choose_us_area bg-gray">
    <div class="container">
        <div class="row db choose_us_inner">
            <div class="row m0 section_title">
                <h2><?php echo display('why_choose_us') ?></h2>
            </div>
            <div class="choose_us_main">
                <?php 
                    foreach ($about_content_info as $about_content) {
                        ?>

                        <div class="media choose_us">
                            <div class="icon_part">
                                <?php echo htmlspecialchars_decode($about_content['icon']) ?>
                            </div>
                            <div class="media-body choose_info">
                                <?php echo htmlspecialchars_decode($about_content['headline']) ?>
                                <?php echo htmlspecialchars_decode($about_content['details']) ?>
                            </div>
                        </div>

                        <?php
                    }
                
                ?>
            </div>
        </div>
    </div>
</section>
<?php } ?>
<!--========== End Choose Us Area ==========-->

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