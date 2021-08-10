<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!--========== Page Header Area ==========-->
<div class="page-breadcrumbs">
    <div class="container">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url() ?>"><?php echo display('home') ?></a></li>
            <li><?php echo display('track_my_order') ?></li>
        </ol>
    </div>
</div>
<!--========== End Page Header Area ==========-->

<!--==== welcome  Area ========-->
<section class="welcome-area sec-pad">
    <div class="container">
        <div class="row m-0 d-flex">
            <div class="col-md-12">
                
                <h1 class="text-center mb-4"><?php echo display('track_my_order') ?></h1>

                    <div class="tracking_form">
                        <div class="row">
                            <div class="col-md-4 col-md-offset-4 col-xs-12">
                                <?php echo form_open('track_my_order'); ?>
                                <div class="form-group">
                                    <input type="email" class="form-control" name="order_email" placeholder="<?php echo display('email') ?>" required>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="order_number" placeholder="<?php echo display('order_no') ?>" required>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block"><?php echo display('track_my_order') ?></button>
                                <?php echo form_close(); ?>

                            </div>
                        </div>
                    </div>
                    <div class="tracking_info mt-3">
                      <?php if(!empty($is_valid_request)) { ?>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="panel panel-bd">
                                    <div id="printableArea">
                                        <link href="<?php echo MOD_URL.'dashboard/assets/css/print.css'; ?>" rel="stylesheet" type="text/css"/>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-sm-6 text-left">
                                                    <h2 class="m-t-0"><?php echo display('order_details') ?></h2>

                                                    <div><?php echo display('order_no') ?>: {order_no}</div>
                                                    <div class="m-b-15"><?php echo display('order_date') ?>: {final_date}</div>
                                                    <div class="m-b-15"><?php echo display('payment_method') ?>: <?php echo (($payinfo['payment_id'] > 1)?ucfirst($payinfo['payment_method']):display('cash_on_delivery')) ?></div>
                                                    <div class="m-b-15"><?php echo display('payment_status') ?>: 
                                                         <strong>
                                                            <?php if ($total_amount == $paid_amount) { ?>
                                                                <span class="label label-success "><?php echo display('paid') ?></span>
                                                            <?php }elseif(($paid_amount > 0) && ($paid_amount < $total_amount)){ ?>
                                                                <span class="label label-warning"><?php echo display('partial_paid') ?></span>
                                                            <?php }elseif ($paid_amount == 0) {
                                                            ?>
                                                                <span class="label label-danger"><?php echo display('unpaid') ?></span>

                                                            <?php } ?>
                                                        </strong>
                                                    </div>
                                                    <div class="m-b-15"><?php echo display('order_status') ?>: 

                                                        <strong>
                                                            <?php
                                                                if($order_status=='1'){
                                                                    echo display('shipped');
                                                                }else if($order_status=='2'){
                                                                    echo display('cancel');
                                                                }else if($order_status=='3'){
                                                                    echo display('pending');
                                                                }else if($order_status=='4'){
                                                                    echo display('complete');
                                                                }else if($order_status=='5'){
                                                                    echo display('processing');
                                                                }else if($order_status=='6'){
                                                                    echo display('return');
                                                                }else{
                                                                    echo display('pending');
                                                                }
                                                             ?>
                                                        </strong>
                                                    </div>

                                                </div>

                                                <div class="col-sm-6 text-left">
                                                    <h2 class="m-t-0"><?php echo display('customer_information') ?></h2>

                                                      <address class="mt_10">  
                                                        <strong>{customer_name} </strong><br>
                                                        <?php
                                                        $customer_address = 0;
                                                        if ($customer_address) {
                                                        ?>
                                                        <abbr><?php echo display('address') ?>:</abbr>
                                                        
                                                        <p class="ctext">
                                                        {customer_address}
                                                        </p>
                                                        <?php } ?>
                                                        <?php
                                                        if ($customer_mobile) {
                                                        ?>
                                                        <abbr><?php echo display('mobile') ?>:</abbr>
                                                        {customer_mobile}
                                                        <?php
                                                        } if ($customer_email) {
                                                        ?>
                                                        <br>
                                                        <abbr><?php echo display('email') ?>:</abbr> 
                                                        {customer_email}
                                                        <?php } ?>
                                                    </address>
                                                </div>
                                            </div> <hr>

                                            <div class="table-responsive m-b-20">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th><?php echo display('sl') ?></th>
                                                            <th><?php echo display('product_name') ?></th>
                                                            <th><?php echo display('variant') ?></th>
                                                            <th><?php echo display('unit') ?></th>
                                                            <th><?php echo display('quantity') ?></th>
                                                            <th><?php echo display('rate') ?></th>
                                                            <th><?php echo display('discount') ?></th>
                                                            <th><?php echo display('ammount') ?></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if(!empty($order_all_data)){
                                                            $i=1;
                                                            foreach ($order_all_data as $orderitem) {
                                                        ?>
                                                         <tr>
                                                            <td><?php echo $i++; ?></td>
                                                            <td><strong><?php echo $orderitem['product_name'] ?> - (<?php echo $orderitem['product_model'] ?>)</strong></td>
                                                            <td><?php echo $orderitem['variant_name'].(!empty($orderitem['variant_color_name'])?', '.$orderitem['variant_color_name']:'') ?></td>
                                                            <td><?php echo $orderitem['unit_short_name'] ?></td>
                                                            <td><?php echo $orderitem['quantity'] ?></td>
                                                            <td><?php echo (($position==0)?"$currency ".$orderitem['rate']:$orderitem['rate']." $currency") ?></td>
                                                            <td><?php echo (($position==0)?"$currency ".$orderitem['discount']:$orderitem['discount']." $currency") ?></td>
                                                            <td><?php echo (($position==0)?"$currency ".$orderitem['total_price']:$orderitem['total_price']." $currency") ?></td>
                                                            </tr>
                                                        <?php } } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="col-sm-8 details_div4">
                                                        <p><strong>{details}</strong></p>
                                                    </div>

                                                    <div class="col-sm-4 display_inblock">

                                                        <table class="table">
                                                            <?php
                                                                if ($order_all_data[0]['discount'] != 0) {
                                                            ?>
                                                            <tr>
                                                                <th class="bt_bb_0"><?php echo display('total_discount') ?> : </th>
                                                                <td class="bt_bb_0"><?php echo (($position==0)?"$currency {order_discount}":"{order_discount} $currency") ?> </td>
                                                            </tr>
                                                            <?php }
                                                            $this->db->select('a.*,b.tax_name');
                                                            $this->db->from('order_tax_col_summary a');
                                                            $this->db->join('tax b','a.tax_id = b.tax_id');
                                                            $this->db->where('a.order_id',$order_id);
                                                            $this->db->where('a.tax_id','H5MQN4NXJBSDX4L');
                                                            $tax_info = $this->db->get()->row();

                                                            if ($tax_info) { ?>
                                                            <tr>
                                                                <th class="total_cgst"><?php echo html_escape($tax_info->tax_name) ?> :</th>
                                                                <td class="total_cgst"><?php echo html_escape(($position==0)?$currency.$tax_info->tax_amount:$tax_info->tax_amount.$currency); ?>
                                                                </td>
                                                            </tr>
                                                            <?php } 
                                                            $this->db->select('a.*,b.tax_name');
                                                            $this->db->from('order_tax_col_summary a');
                                                            $this->db->join('tax b','a.tax_id = b.tax_id');
                                                            $this->db->where('a.order_id',$order_id);
                                                            $this->db->where('a.tax_id','52C2SKCKGQY6Q9J');
                                                            $tax_info = $this->db->get()->row();

                                                            if ($tax_info) { ?>
                                                            <tr>
                                                                <th class="total_sgst"><?php echo html_escape($tax_info->tax_name) ?> :</th>
                                                                <td class="total_sgst"><?php echo (($position==0)?$currency.$tax_info->tax_amount:$tax_info->tax_amount.$currency);?>
                                                                </td>
                                                            </tr>
                                                            <?php } 
                                                            $this->db->select('a.*,b.tax_name');
                                                            $this->db->from('order_tax_col_summary a');
                                                            $this->db->join('tax b','a.tax_id = b.tax_id');
                                                            $this->db->where('a.order_id',$order_id);
                                                            $this->db->where('a.tax_id','5SN9PRWPN131T4V');
                                                            $tax_info = $this->db->get()->row();

                                                            if ($tax_info) {
                                                            ?>
                                                            <tr>
                                                                <th class="total_igst"><?php echo html_escape($tax_info->tax_name) ?> :</th>
                                                                <td class="total_igst"><?php echo (($position==0)?$currency.$tax_info->tax_amount:$tax_info->tax_amount.$currency); ?>
                                                                </td>
                                                            </tr>
                                                            <?php } ?>
                                                                <tr>
                                                                    <th class="service_charge"><?php echo display('service_charge') ?> :</th>
                                                                    <?php (($service_charge == 0|| empty($service_charge))?$service_charge = 0 : $service_charge) ?>
                                                                    <td class="service_charge"><?php echo (($position==0)?"$currency {service_charge}":"{service_charge} $currency") ?></td>
                                                                </tr>  
                                                                <tr>
                                                                    <th class="grand_total"><?php echo display('grand_total') ?> :</th>
                                                                    <td class="grand_total"><?php echo (($position==0)?"$currency {total_amount}":"{total_amount} $currency") ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="bt_bb_0"><?php echo display('paid_ammount') ?> : </th>
                                                                    <td class="bt_bb_0"><?php echo (($position==0)?"$currency {paid_amount}":"{paid_amount} $currency") ?></td>
                                                                </tr>  

                                                                <?php
                                                                    if ($order_all_data[0]['due_amount'] != 0) {
                                                                ?>
                                                                <tr>
                                                                    <th><?php echo display('due') ?> : </th>
                                                                    <td><?php echo (($position==0)?"$currency {due_amount}":"{due_amount} $currency") ?></td>
                                                                </tr>
                                                                <?php
                                                                    }
                                                                ?>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                      <?php }  ?>
                    </div>

            </div>
        </div>
    </div>
</section>
<!--==== End welcome Area ====-->
