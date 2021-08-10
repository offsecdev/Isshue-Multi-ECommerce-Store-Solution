<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!--========== Page Header Area ==========-->
<div class="page-breadcrumbs">
    <div class="container">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url() ?>"><?php echo display('home') ?></a></li>
            <li><?php echo display('about_us') ?></li>
        </ol>
    </div>
</div>
<!--========== End Page Header Area ==========-->

<!--==== welcome  Area ========-->
<section class="welcome-area sec-pad">
    <div class="container">
        <div class="row m-0 d-flex">
            <div class="col-lg-6">
                <div class="row d-block img_area">
                    <img src="<?php echo $image; ?>" alt="Img">
                </div>
            </div>
            <div class="col-lg-5 col-lg-offset-1 align-self-center">
                <div class="welcome-inner">
                    <h2> <?php echo htmlspecialchars_decode($headlines); ?></h2>
                    <p class="text-justify">
                        <?php echo htmlspecialchars_decode($details); ?>
                    </p>
                </div>
                <div class="welcome-btn">
                    <a href="<?php echo base_url('contact_us') ?>"><?php echo display('contact_us') ?></a>
                </div>
            </div>
        </div>
    </div>
</section>
<!--==== End welcome Area ====-->

<!--====== Start Choose Us Area ======-->
<?php if (!empty($about_content_info)) { ?>
<section class="choose_us_area">
    <div class="container">
        <div class="choose_us_inner">
            <div class="text-center">
                <h2 class="sec_title"><?php echo display('why_choose_us') ?></h2>
            </div>
            <div class="row choose_us_main">
                <?php 
                    foreach ($about_content_info as $about_content) {
                        ?>
                        <div class="choose_us">
                            <div class="icon_part">
                                <?php echo htmlspecialchars_decode($about_content['icon']) ?>
                            </div>
                            <div class="choose_info">
                                <h4><?php echo htmlspecialchars_decode($about_content['headline']) ?></h4>
                                <p> <?php echo htmlspecialchars_decode($about_content['details']) ?></p>
                            </div>
                        </div>
                        <?php } ?>
            </div>
        </div>
    </div>
</section>
<?php } ?>
<!--========== End Choose Us Area ==========-->
