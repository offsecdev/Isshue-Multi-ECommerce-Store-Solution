<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!--========== Page Header Area ==========-->
<section class="page_header">
    <div class="container">
        <div class="row m0 page_header_inner">
            <h2 class="page_title"><?php echo display('terms_condition') ?></h2>
            <ol class="breadcrumb m0 p0">
                <li class="breadcrumb-item"><a href="<?php echo base_url() ?>"><?php echo display('home') ?></a></li>
                <li class="breadcrumb-item active"><?php echo display('terms_condition') ?></li>
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
                    <img src="<?php echo $image ?>" alt="Img">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="welcome_inner">
                    <?php echo htmlspecialchars_decode($headlines) ?>
                    <?php echo htmlspecialchars_decode($details) ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!--==== End welcome Area ====-->
