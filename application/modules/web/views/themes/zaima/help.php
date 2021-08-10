<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<section class="section-about py-5">
    <div class="container">
        <div class="row m-0 d-flex">
            <?php if(!empty($image)){ ?>
            <div class="col-lg-6">
                <div class="row d-block img_area">
                    <img src="<?php echo $image; ?>" class="img-thumbnail img-fluid" alt="Img">
                </div>
            </div>
            <?php } ?>
            <div class="<?php echo (!empty($image)?'col-lg-5 col-lg-offset-1':'col-lg-12')?>  align-self-center">
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
