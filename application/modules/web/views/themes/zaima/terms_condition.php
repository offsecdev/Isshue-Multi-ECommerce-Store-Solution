<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="page-breadcrumbs">
    <div class="container">
        <nav aria-label="breadcrumb" class="my-4">
                <ol class="breadcrumb d-inline-flex mb-0">
                    <li class="breadcrumb-item align-items-center"><a href="<?php echo base_url() ?>" class="d-flex align-items-center"><i data-feather="home" class="mr-2"></i><?php echo display('home') ?></a></li>
                    <li class="breadcrumb-item align-items-center"><a href="" class="d-flex align-items-center"><?php echo display('terms_condition') ?></a></li>
                </ol>
            </nav>
    </div>
</div>
<section class="section-about py-5">
    <div class="container">
        <div class="row m-0 d-flex">
            <div class="col-md-12  align-self-center">
                <div class="welcome-inner">
                    <h1 class="text-center mb-4"><?php echo display('terms_condition') ?></h1>
                    <?php if(!empty($image)){ ?>
                        <div class="col-md-6">
                            <img src="<?php echo base_url().$image; ?>" class="img-thumbnail img-fluid float-left mr-4 mb-3" alt="Img">
                        </div>
                    <?php } ?>
                    <h2> <?php echo htmlspecialchars_decode($headlines); ?></h2>
                    <p class="text-justify">
                        <?php echo htmlspecialchars_decode($details); ?>
                    </p>
                </div>

            </div>
        </div>
    </div>
</section>

