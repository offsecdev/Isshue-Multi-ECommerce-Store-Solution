<?php 
if (!empty($select_home_adds)) {
    if($blpos <= count($select_home_adds)){
        foreach ($select_home_adds as $ads){
        if ($blpos == $ads->adv_position && !empty($ads->adv_code) && empty($ads->adv_code2) && empty($ads->adv_code3)) {
        ?>
        <div class="promo-list py-4 d-none d-lg-block adv_area">
            <div class="container">
                <div class="row ">
                    <div class="col-md-12">
                        <?php echo $ads->adv_code; ?>
                    </div>
                </div>
            </div>
        </div>

        <?php } else if ($blpos == $ads->adv_position && !empty($ads->adv_code) && !empty($ads->adv_code2) && empty($ads->adv_code3)) { ?>

        <div class="promo-list py-4 d-none d-lg-block adv_area">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <?php echo $ads->adv_code; ?>
                    </div>
                    <div class="col-md-6">
                        <?php echo $ads->adv_code2; ?>
                    </div>
                </div>
            </div>
        </div>

        <?php } else if ($blpos == $ads->adv_position && !empty($ads->adv_code) && !empty($ads->adv_code2) && !empty($ads->adv_code3)) { ?>

        <div class="promo-list py-4 d-none d-lg-block adv_area">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <?php echo $ads->adv_code; ?>
                    </div>
                    <div class="col-md-4">
                        <?php echo $ads->adv_code2; ?>
                    </div>
                    <div class="col-md-4">
                        <?php echo $ads->adv_code3; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
<?php } } } ?>

