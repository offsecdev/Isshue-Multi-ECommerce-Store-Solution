<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Edit Product Start -->
<div class="content-wrapper">
<section class="content-header">
<div class="header-icon">
<i class="pe-7s-note2"></i>
</div>
<div class="header-title">
<h1><?php echo display('product_edit') ?></h1>
<small><?php echo display('edit_your_product') ?></small>
<ol class="breadcrumb">
    <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
    <li><a href="#"><?php echo display('product') ?></a></li>
    <li class="active"><?php echo display('product_edit') ?></li>
</ol>
</div>
</section>

<section class="content">
<!-- Alert Message -->
<?php
$message = $this->session->userdata('message');
if (isset($message)) {
?>
<div class="alert alert-info alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <?php echo $message ?>
</div>
<?php
$this->session->unset_userdata('message');
}
$error_message = $this->session->userdata('error_message');
if (isset($error_message)) {
?>
<div class="alert alert-danger alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <?php echo $error_message ?>
</div>
<?php
$this->session->unset_userdata('error_message');
}
?>

<!-- Product edit -->
<div class="row">
<div class="col-sm-12 col-md-12">
    <div class="panel panel-bd lobidrag">
        <div class="panel-heading">
            <div class="panel-title">
                <h4><?php echo display('product_edit') ?></h4>
            </div>
        </div>
        <?php echo form_open_multipart('dashboard/Cproduct/product_update',array('class' => 'form-vertical', 'id' => 'commentForm','name' => 'product_update'))?>
        <div class="panel-body">
            <div id="rootwizard">
                <div class="navbar">
                    <div class="navbar-inner form-wizard">
                        <ul class="nav nav-pills nav-justified steps">
                            <li>
                                <a href="#tab1" data-toggle="tab" class="step" aria-expanded="true">
                                    <span class="number"> <?php echo display('1')?> </span>
                                    <span class="desc"><?php echo display('item_information')?> </span>
                                </a>
                            </li>
                            <li>
                                <a href="#tab2" data-toggle="tab" class="step" aria-expanded="true">
                                    <span class="number"> <?php echo display('2')?> </span>
                                    <span class="desc"><?php echo display('web_store')?></span>
                                </a>
                            </li>
                            <li>
                                <a href="#tab3" data-toggle="tab" class="step" aria-expanded="true">
                                    <span class="number"> <?php echo display('3')?> </span>
                                    <span class="desc"><?php echo display('price')?></span>
                                </a>
                            </li>
                            <li>
                                <a href="#tab4" data-toggle="tab" class="step" aria-expanded="true">
                                    <span class="number"> <?php echo display('4')?> </span>
                                    <span class="desc"><?php echo display('image')?></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div id="bar" class="progress">
                    <div class="progress-bar progress-bar-success progress-bar-striped width_0p active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="tab-content">
                    <div class="tab-pane" id="tab1">

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="product_name" class="col-sm-3 col-form-label"><?php echo display('product_name') ?> <span class="color-red">*</span></label>
                                    <div class="col-sm-9">
                                        <input class="form-control" name="product_name" type="text" id="product_name" placeholder="<?php echo display('product_name') ?>" value="<?php echo html_escape($product_name); ?>" required>
                                        <input type="hidden" name="product_id" value="<?php echo html_escape($product_id); ?>"/>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="category_id" class="col-sm-3 col-form-label"><?php echo display('category') ?></label>
                                    <div class="col-sm-9">
                                        <select class="form-control select2 width_100p" id="category_id" name="category_id">
                                           <?php foreach($category_list as $category){ ?>
                                            <option value="<?php echo html_escape($category['category_id']) ?>" <?php if($category['category_id'] == $category_selected){ echo "selected";} ?>><?php echo html_escape($category['category_name']) ?></option>
                                           <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label for="details" class="col-sm-2 col-form-label"><?php echo display('details') ?></label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control summernote" name="details" id="details" rows="3" ><?php echo htmlspecialchars_decode($product_details) ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label for="invoice_details" class="col-sm-2 col-form-label"><?php echo display('invoice_details') ?></label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" name="invoice_details" id="invoice_details" rows="3" placeholder="<?php echo display('invoice_details') ?>"><?php echo htmlspecialchars_decode($invoice_details) ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab2">

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="unit" class="col-sm-3 col-form-label"><?php echo display('unit') ?></label>
                                    <div class="col-sm-9">
                                        <select class="form-control select2 width_100p" id="unit" name="unit">
                                            <option value=""><?php echo display('select_one') ?></option>
                                            <?php foreach($unit_list as $unit){ ?>
                                            
                                            <option value="<?php echo html_escape($unit['unit_id']) ?>" <?php if($unit['unit_id'] == $unit_selected){ echo 'selected';} ?>><?php echo html_escape($unit['unit_name']); ?></option>                           <?php } ?>                            
                                       

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="brand" class="col-sm-3 col-form-label"><?php echo display('brand') ?></label>
                                    <div class="col-sm-9">
                                        <select class="form-control select2 width_100p" id="brand" name="brand">
                                            <option value=""><?php echo display('select_one') ?></option>
                                           <?php foreach($brand_list as $brand){ ?>               
                                            <option value="<?php echo html_escape($brand['brand_id']); ?>" <?php if($brand['brand_id'] == $brand_selected){echo 'selected'; } ?>><?php echo html_escape($brand['brand_name']); ?></option>
                                        <?php } ?>

                                            
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="type" class="col-sm-3 col-form-label"><?php echo display('type') ?> </label>
                                    <div class="col-sm-9">
                                        <input type="text" name="type" class="form-control" id="type" value="<?php echo html_escape($type); ?>" placeholder="<?php echo display('type') ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="tag" class="col-sm-3 col-form-label"><?php echo display('tag') ?></label>
                                    <div class="col-md-9">
                                        <input type="text" value="<?php echo html_escape($tag); ?>" data-role="tagsinput" name="tag">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="best_sale" class="col-sm-3 col-form-label"><?php echo display('best_sale') ?></label>
                                    <div class="col-md-9">
                                        <select class="form-control select2 width_100p" id="best_sale" name="best_sale">
                                            <option value=""><?php echo display('select_one') ?></option>
                                            <option value="1" <?php if ($best_sale == 1) {
                                                echo "selected";}?>><?php echo display('yes') ?></option>
                                            <option value="0" <?php if ($best_sale == 0) {
                                                echo "selected";}?>><?php echo display('no') ?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">

                            </div>

                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="content1" class="col-sm-3 col-form-label"><?php echo display('review') ?></label>
                                    <div class="col-md-9">
                                        <textarea name="review" class="form-control summernote" placeholder="<?php echo display('review')?>" id="content1" required row="3"><?php echo htmlspecialchars_decode($review); ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="content2" class="col-sm-3 col-form-label"><?php echo display('description') ?></label>
                                    <div class="col-md-9">
                                        <textarea name="description" class="form-control summernote" placeholder="<?php echo display('description')?>" id="content2" required row="3"><?php echo htmlspecialchars_decode($description); ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <label for="specification" class="col-sm-2 col-form-label"><?php echo display('specification') ?></label>
                                    <div class="col-md-10">
                                        <textarea name="specification" class="form-control summernote" placeholder="<?php echo display('specification')?>" id="specification" required row="3"><?php echo $specification; ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>


                    <div class="tab-pane" id="tab3">

                        <div class="form-group row">
                            <label for="sell_price" class="col-sm-4 col-form-label"><?php echo display('sell_price') ?> <span class="color-red">*</span></label>
                            <div class="col-sm-4">
                                <input class="form-control text-right" name="price" type="number" value="<?php echo html_escape($price); ?>" required placeholder="<?php echo display('sell_price') ?>" tabindex="3" min="0">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="supplier_price" class="col-sm-4 col-form-label"><?php echo display('supplier_price') ?> <span class="color-red">*</span></label>
                            <div class="col-sm-4">
                                <input type="number" tabindex="4" class="form-control text-right" value="<?php echo html_escape($supplier_price); ?>" name="supplier_price" placeholder="<?php echo display('supplier_price') ?>"  required min="0"/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="onsale" class="col-sm-4 col-form-label"><?php echo display('onsale') ?></label>
                            <div class="col-md-4">
                                <select class="form-control select2 width_100p" id="onsale" name="onsale">
                                    <option value=""><?php echo display('select_one') ?></option>
                                    <option value="1" <?php if ($onsale == 1) {
                                        echo "selected";}?>><?php echo display('yes') ?></option>
                                    <option value="0" <?php if ($onsale == 0) {
                                        echo "selected";}?>><?php echo display('no') ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row onsale_price" style="<?php if ($onsale == 0) { echo "display: none"; }?>">
                            <label for="onsale_price" class="col-sm-4 col-form-label"><?php echo display('onsale_price')?> <i class="text-danger">*</i></label>
                            <div class="col-md-4">
                                <input class="form-control text-right" name="onsale_price" type="number" required="" placeholder="<?php echo display('onsale_price') ?>" min="0" id="onsale_price" value="<?php echo html_escape($onsale_price); ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="model" class="col-sm-4 col-form-label"><?php echo display('model') ?> <span class="color-red">*</span></label>
                            <div class="col-sm-4">
                                <input type="text" tabindex="5" class="form-control" value="<?php echo html_escape($product_model); ?>" name="model" placeholder="<?php echo display('model') ?>"  required />

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="supplier" class="col-sm-4 col-form-label"><?php echo display('supplier') ?> <span class="color-red">*</span></label>
                            <div class="col-sm-4">
                                <select name="supplier_id" class="form-control select2" required=""  id="supplier"  style="width:100%">
                                    <?php  if ($supplier_list){ 
                                        foreach($supplier_list as $supplier){
                                        ?>                                                   
                                        <option value="<?php echo html_escape($supplier['supplier_id']) ?>" <?php if($supplier['supplier_id'] == $supplier_selected){ echo 'selected';} ?>><?php echo html_escape($supplier['supplier_name']); ?></option>                                                   
                                    <?php } } ?>
                                </select>
                            </div>
                        </div>

                        <?php
                        $exploded = $vresult = [];
                        if ($variants) {
                            $exploded = explode(',', $variants);

                            $this->db->select('*');
                            $this->db->from('variant');
                            $this->db->where_in('variant_id',$exploded);
                            $this->db->order_by('variant_name','asc');
                            $vresult = $this->db->get()->result();
                        }

                        ?>
                        <div class="form-group row">
                            <label for="variant" class="col-sm-4 col-form-label"><?php echo display('variant') ?> <span class="color-red">*</span></label>
                            <div class="col-sm-4">
                                <select name="variant[]" class="form-control select2" multiple required=""  id="variant" style="width:100%">
                                    <option value="">Select</option>
                                    <?php if ($variant_list){
                                        foreach($variant_list as $variant){
                                            if($variant['variant_type'] == 'size'){
                                     ?>                                                   
                                        <option value="<?php echo html_escape($variant['variant_id']) ?>" <?php echo (in_array($variant['variant_id'], $exploded)?'selected':'') ?>><?php echo html_escape($variant['variant_name']); ?></option> 
                                    <?php } } } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="default_variant" class="col-sm-4 col-form-label"><?php echo display('default_variant') ?></label>
                            <div class="col-sm-4">
                                <select name="default_variant" class="form-control select2"   id="default_variant"  style="width:100%">
                                    <option value="">Select</option>
                                    <?php if ($vresult){
                                        foreach ($vresult as $v_item){ ?>
                                            <option value="<?php echo html_escape($v_item->variant_id)  ?>" <?php if($v_item->variant_id == $default_variant){echo "selected";}  ?>><?php echo html_escape($v_item->variant_name);  ?></option>
                                        <?php } }?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="variant_colors" class="col-sm-4 col-form-label"><?php echo display('color') ?></label>
                            <div class="col-sm-4">
                                <select name="variant_colors[]" class="form-control select2" multiple id="variant_colors" style="width:100%">
                                    <option value="">Select</option>
                                    <?php if ($variant_list){
                                        foreach($variant_list as $variant){
                                            if($variant['variant_type'] == 'color'){
                                     ?>                                                   
                                        <option value="<?php echo html_escape($variant['variant_id']) ?>" <?php echo (in_array($variant['variant_id'], $exploded)?'selected':'') ?>><?php echo html_escape($variant['variant_name']); ?></option> 
                                    <?php } } } ?>
                                </select>
                            </div>
                        </div>
                        <div  id="variant_price_area" style="<?php echo (($onsale == 0)?"display: block":"display: none");?>">
                            <div class="form-group row">
                                <div class="col-sm-4 col-sm-offset-4">
                                   <div class="checkbox checkbox-success">
                                        <input type="checkbox" name="variant_prices" value="1" id="variant_prices"  <?php echo (!empty($variant_price)?'checked':'') ?>>
                                        <label class="" for="variant_prices" ><?php echo display('set_variant_wise_price') ?></label>
                                    </div>
                                </div>
                            </div>

                            <div class="row  <?php echo (!empty($variant_price)?'':'none') ?>" id="set_variant_price">
                                <div class="col-sm-6 col-sm-offset-4">
                                  <div >
                                      
                                      <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th><?php echo display('size') ?><span class="color-red">*</span></th>
                                                <th><?php echo display('color') ?></th>
                                                <th><?php echo display('price') ?><span class="color-red">*</span></th>
                                                <th><?php echo display('action') ?></th>
                                            </tr>
                                        </thead>
                                        <tbody id="variant_area">
                                            <?php $ckey=(count($provar_prices)>0?count($provar_prices):0); ?>
                                            <tr>
                                                <td>
                                                    <select name="variant_1" id="size_var" class="form-control select2"   style="width:100%">
                                                        <option value=""></option>
                                                        <?php if ($variant_list){
                                                            foreach ($variant_list as $v_item){

                                                                if (($v_item['variant_type']=='size') && (in_array($v_item['variant_id'], $exploded))) { 

                                                             ?>
                                                                <option value="<?php echo html_escape($v_item['variant_id']) ?>"><?php echo html_escape($v_item['variant_name']);  ?></option>
                                                            <?php } } }?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="variant_2" id="color_var" class="form-control select2"   style="width:100%">
                                                        <option value=""></option>
                                                        <?php 
                                                        if ($variant_list){
                                                            foreach ($variant_list as $v_item){
                                                            if(($v_item['variant_type']=='color') && (in_array($v_item['variant_id'], $exploded))) {  ?>
                                                                <option value="<?php echo html_escape($v_item['variant_id']) ?>"><?php echo html_escape($v_item['variant_name']);  ?></option>
                                                            <?php  } } }?>
                                                    </select>

                                                </td>
                                                <td>
                                                    <input type="text" name="var_price_1"  id="var_price"  class="form-control" placeholder="0.00">
                                                </td>
                                                <td>
                                                     <input type="button" value="Add" class="btn btn-info" id="variant-row-add" data-key="<?php echo $ckey; ?>">

                                                </td>
                                            </tr>

                                            <?php
                                            if(count($provar_prices) > 0) {
                                             for($i=0;$i<count($provar_prices);$i++){ ?>

                                            <tr id="row_<?php echo $i; ?>">
                                                <td>
                                                    <select name="size_variant[<?php echo $i; ?>]" class="form-control select2"   style="width:100%">
                                                        <option value="">Select</option>
                                                        <?php if ($variant_list){
                                                            foreach ($variant_list as $v_item){
                                                            if($v_item['variant_type']=='size'){  ?>
                                                                <option value="<?php echo html_escape($v_item['variant_id']) ?>" <?php if(!empty($provar_prices[$i]->var_size_id) && ($provar_prices[$i]->var_size_id == $v_item['variant_id'])){
                                                                    echo 'selected';
                                                                } ?>><?php echo html_escape($v_item['variant_name']);  ?></option>
                                                            <?php } } }?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="color_variant[<?php echo $i; ?>]" class="form-control select2"   style="width:100%">
                                                        <option value="">Select</option>
                                                        <?php if ($variant_list){
                                                            foreach ($variant_list as $v_item){
                                                            if($v_item['variant_type']=='color'){  ?>
                                                                <option value="<?php echo html_escape($v_item['variant_id']) ?>"  <?php if(!empty($provar_prices[$i]->var_color_id) && ($provar_prices[$i]->var_color_id == $v_item['variant_id'])){
                                                                    echo 'selected';
                                                                } ?>><?php echo html_escape($v_item['variant_name']);  ?></option>
                                                            <?php } } }?>
                                                    </select>

                                                </td>
                                                <td>
                                                    <input type="text" name="variant_price_amt[<?php echo $i; ?>]"  class="form-control" placeholder="0.00" value="<?php if(isset($provar_prices[$i]->price) && !empty($provar_prices[$i]->price)){  echo $provar_prices[$i]->price; } ?>">
                                                </td>
                                                <td><input type="button" value="-" onclick="deleteVariantRow(<?php echo $i; ?>);" class="btn btn-danger" id="variant-row-remove"></td>
                                            </tr>
                                            <?php } } ?>


                                        </tbody>
                                          
                                      </table>
                                  </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="video" class="col-sm-4 col-form-label"><?php echo display('video_link') ?> </label>
                            <div class="col-sm-4">
                                <input type="text" name="video" class="form-control" value="<?php echo $video; ?>">
                                <p class="color4 color5 demo-notice">Demo Video Link : <b>https://www.youtube.com/watch?v=nQZvbmaO0ws</b></p>

                            </div>

                        </div>

                    </div>

                    <div class="tab-pane" id="tab4">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label for="image_thumb" class="col-sm-2 col-form-label"><?php echo display('default_image') ?></label>
                                <div class="col-sm-4">
                                    <input type="file" name="image_thumb" class="form-control">
                                    <img class="img img-responsive text-center p_5" src="<?php echo base_url().$image_thumb?>" height="80" width="80">
                                    <input type="hidden" value="{image_thumb}" name="old_thumb_image">
                                    <input type="hidden" value="{image_large_details}" name="old_img_lrg">
                                </div>
                            </div>


                        </div>

                        <div id="image_row">
                            <?php $gm=0; if($gallery_images) {
                            foreach($gallery_images as $gallery_image){
                            ?>
                            <div id="image_row_<?php echo $gm;?>">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="imageUpload"
                                                   class="col-sm-4 col-form-label"><?php echo display('image') ?>
                                                </label>

                                            <div class="col-sm-8">
                                                <input class="form-control" name="imageUpload[]"
                                                       type="file"
                                                       id="imageUpload" data-toggle="tooltip"
                                                       data-placement="top" title=""
                                                       aria-required="true"
                                                       data-original-title="<?php echo display('image_size_width_3000_height_3000') ?>"/>
                                                <img class="img img-responsive text-center p_5" src="<?php echo base_url().$gallery_image->image_url;?>" height="80" width="80" >
                                                <input type="hidden" value="<?php echo $gallery_image->image_url  ?>" name="old_gallery_image[]">
                                            </div>
                                        </div>
                                    </div>

                                    <input type="button" value="+" onClick="addImageRow(<?php  echo $gm; ?>);"
                                           class="btn btn-info"
                                           id="image-add">
                                    <input type="button" value="-" data-image_id="<?php echo $gallery_image->image_gallery_id;  ?>" onclick="deleteImageRow(this);"
                                           class="btn btn-danger"
                                           id="image-remove">
                                </div>
                            </div>
                            <?php $gm++; } } ?>
                        </div>

                    </div>

                    <ul class="pager wizard">
                        <li class="previous first none" ><a href="#"><?php echo display('first')?></a></li>
                        <li class="previous"><a href="#"><?php echo display('prev')?></a></li>
                        <li class="next last none" ><a href="#"><?php echo display('last')?></a></li>
                        <li class="next"><a href="#"><?php echo display('next')?></a></li>
                        <li class="finish pull-right"><button type="submit" href="javascript:;" name="add-product"><?php echo display('save_changes')?></button></li>
                    </ul>
                </div>
            </div>
        </div>
        <?php echo form_close()?>
    </div>
</div>
</div>
</section>
</div>



<!-- Edit Product End -->
<script src="<?php echo MOD_URL.'dashboard/assets/js/edit_product_form.js'; ?>"></script>