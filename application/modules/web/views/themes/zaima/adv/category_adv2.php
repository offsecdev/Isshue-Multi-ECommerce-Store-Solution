
<?php 
if (!empty($select_category_adds)) {
foreach ($select_category_adds as $ads){
if ($adv_position == $ads->adv_position && !empty($ads->adv_code) && empty($ads->adv_code2) && empty($ads->adv_code3)) {
?>
<div class="promo-list py-3 d-none d-lg-block adv_area">
    <div>
        <div class="row ">
            <div class="col-md-12">
                <?php echo $ads->adv_code; ?>
            </div>
        </div>
    </div>
</div>

<?php } else if ($adv_position == $ads->adv_position && !empty($ads->adv_code) && !empty($ads->adv_code2) && empty($ads->adv_code3)) { ?>

<div class="promo-list py-3 d-none d-lg-block adv_area">
    <div>
        <div class="row">
            <div class="col-md-12 mb-4">
                <?php echo $ads->adv_code; ?>
            </div>
            <div class="col-md-12">
                <?php echo $ads->adv_code2; ?>
            </div>
        </div>
    </div>
</div>

<?php } else if ($adv_position == $ads->adv_position && !empty($ads->adv_code) && !empty($ads->adv_code2) && !empty($ads->adv_code3)) { ?>

<div class="promo-list py-3 d-none d-lg-block adv_area">
    <div>
        <div class="row">
            <div class="col-md-12 mb-4">
                <?php echo $ads->adv_code; ?>
            </div>
            <div class="col-md-12 mb-4">
                <?php echo $ads->adv_code2; ?>
            </div>
            <div class="col-md-12">
                <?php echo $ads->adv_code3; ?>
            </div>
        </div>
    </div>
</div>
<?php } ?>
<?php } } ?>
