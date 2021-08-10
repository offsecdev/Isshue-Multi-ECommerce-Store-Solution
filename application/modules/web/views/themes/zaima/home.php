<?php include_once(dirname(__FILE__).'/functions/functions.php'); ?>

 <?php 
$message = $this->session->userdata('message');
if (!empty($message)) {
?>
<div class="container py-2">
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-info alert-dismissable  mb-0">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $message ?>                    
            </div>
        </div>
    </div>
</div>
<?php 
$this->session->unset_userdata('message');
}
$error_message = $this->session->userdata('error_message');
$validation_errors = validation_errors();
if (!empty($error_message) || !empty($validation_errors)) {
?>
<div class="container py-2">
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-danger alert-dismissable  mb-0">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $error_message ?>                    
                <?php echo $validation_errors ?>                    
            </div>
        </div>
    </div>
</div>
<?php 
$this->session->unset_userdata('error_message');
 } ?>

<?php $this->load->view('include/slider');?>

<?php 
$total_block = 0;
if (!empty($block_list)) {

    foreach ($block_list as $block){

        $this->load->view('adv/home_adv1', array('block' => $block));

        $cat_pro = $this->db->select('a.*,b.category_name,b.category_id')
        ->from('product_information a')
        ->join('product_category b', 'a.category_id = b.category_id', 'left')
        ->where('a.category_id', $block['block_cat_id'])
        ->order_by('a.product_id', 'random')
        ->limit(12)
        ->get()
        ->result();

    if ($cat_pro) {

        if ($block['block_style'] == '1') {
            include(dirname(__FILE__).'/blocks/block_1.php');
        }else {
            include(dirname(__FILE__).'/blocks/block_2.php');
        }
    ?>

    <?php 
        }
    } 

    $total_block = count($block_list);
} ?>

<!-- Best Sale Products -->
<?php $this->load->view('adv/home_adv_last', array('blpos' => $total_block + 1)); ?>

<?php include_once(dirname(__FILE__).'/blocks/block_best_seller.php'); ?>

<?php $this->load->view('adv/home_adv_last', array('blpos' => $total_block + 2)); ?>

<!--Brand logo content-->
<?php if($brands){ ?>
<div class="container mt-1 mb-5">
    <div class="brand-logo owl-carousel owl-theme border-top border-bottom py-4 px-4">
        <?php foreach ($brands as $brand) { ?>
        <a href="<?php echo base_url() . "brand_product/list/" . $brand['brand_id']; ?>" class="brand-logo_item d-block">
            <img src="<?php echo $brand['brand_image']; ?>" alt="<?php echo $brand['brand_name'] ?>">
        </a>
        <?php } ?>
    </div>
</div>
<?php } ?>
