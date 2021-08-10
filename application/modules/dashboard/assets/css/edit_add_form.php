<!-- Dynamic css -->
<style type="text/css">
    <?php if ($adv_type == 1) { ?>
    .embed_code_ad{
        display: block;
    }
    .img_ad{
        display: none;
    }

    <?php }else{ ?>
    .embed_code_ad{
        display: none;
    }
    .img_ad{
        display: block;
    }
    <?php }?>

</style>