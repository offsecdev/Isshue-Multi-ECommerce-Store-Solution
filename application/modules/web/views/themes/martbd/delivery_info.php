<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!--========== Page Header Area ==========-->
<div class="page-breadcrumbs">
    <div class="container">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url() ?>"><?php echo display('home') ?></a></li>
            <li><?php echo display('delivery_info') ?></li>
        </ol>
    </div>
</div>
<!--========== End Page Header Area ==========-->

<!--==== welcome  Area ========-->
<section class="welcome-area sec-pad">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="row d-block img_area">
                    <img src="<?php echo $image; ?>" class="img img-responsive" alt="Img">
                </div>
            </div>
            <div class="col-md-6 align-self-center">
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
