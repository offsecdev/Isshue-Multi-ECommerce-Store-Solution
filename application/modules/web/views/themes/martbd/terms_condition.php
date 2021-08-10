<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!--========== Page Header Area ==========-->
<div class="page-breadcrumbs">
    <div class="container">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url() ?>"><?php echo display('home') ?></a></li>
            <li><?php echo display('terms_condition') ?></li>
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

            </div>
        </div>
    </div>
</section>
<!--==== End welcome Area ====-->
