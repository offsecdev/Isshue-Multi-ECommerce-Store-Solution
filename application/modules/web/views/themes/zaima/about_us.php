<div class="container py-5">
    <div class="row align-items-center pb-3">
        <?php if(!empty($image)){ ?>
        <div class="col-md-5">
            <img class="img-fluid d-block w-250 m-auto" src="<?php echo $image; ?>" alt="About us">
        </div>
        <?php } ?>
        <div class="col-md-7 text-md-left text-center mt-3 mt-md-0">
            <h2 class="fs-28 font-weight-normal mb-3"><?php echo htmlspecialchars_decode($headlines); ?></h2>
            <p class="fs-16 text-black-50"><?php echo htmlspecialchars_decode($details); ?></p>
            <a class="btn btn-primary btn-pill mt-3  color4 color46" href="<?php echo base_url('contact_us') ?>"><?php echo display('contact_us') ?></a>
        </div>
    </div>
</div>
<!--====== Start Choose Us Area ======-->
<?php if (!empty($about_content_info)) { ?>
<div class="container py-5">
    <div class="row align-items-center pb-3">
        <div class="col-md-12 text-center">
        <div class="choose_us_inner">
            <div class="text-center">
                <h2 class="sec_title"><?php echo display('why_choose_us') ?></h2>
                <hr>
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
                        <?php
                    }
                
                ?>
            </div>
        </div>

        </div>
    </div>
</div>
<?php } ?>
<!--========== End Choose Us Area ==========-->