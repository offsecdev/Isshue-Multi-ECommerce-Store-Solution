<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
$CI =& get_instance();
$CI->load->model('Soft_settings');
$Soft_settings = $CI->Soft_settings->retrieve_setting_editdata();
?>
<script src="<?php echo MOD_URL.'dashboard/assets/js/print.js'; ?>"></script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('order_details') ?></h1>
            <small><?php echo display('order_details') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('order') ?></a></li>
                <li class="active"><?php echo display('order_details') ?></li>
            </ol>
        </div>
    </section>
    <!-- Main content -->
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
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd">
                    <div id="printableArea">
                        <link href="<?php echo MOD_URL.'dashboard/assets/css/print.css'; ?>" rel="stylesheet" type="text/css"/>
                        <div class="panel-body">
                            <div class="row">
                                {company_info}
                                <div class="col-sm-10 cominfo_div">
                                    <img src="<?php if (isset($Soft_settings[0]['invoice_logo'])) {
                                        echo base_url().$Soft_settings[0]['invoice_logo'];
                                    } ?>" class="img img-responsive inv_logo" alt="logo">
                                    <br>
                                    <span class="label label-success-outline m-r-15 p-10"><?php echo display('order_to') ?></span>
                                    <address class="mt_10">
                                        <strong>{company_name}</strong><br>
                                        {address}<br>
                                        <abbr><?php echo display('mobile') ?>:</abbr> {mobile}<br>
                                        <abbr><?php echo display('email') ?>:</abbr>
                                        {email}<br>
                                        <abbr><?php echo display('website') ?>:</abbr>
                                        {website}
                                    </address>
                                </div>
                                {/company_info}
                                <?php if (!strcmp($customer_mobile, $ship_customer_mobile)){ ?>
                                <div class="col-sm-2 text-left cus_div">
                                    <h2 class="m-t-0"><?php echo display('order') ?></h2>
                                    <div><?php echo display('order_no') ?>: {order_no}</div>
                                    <div><?php echo display('order_date') ?>: {final_date}</div>
                                    <?php if(!empty($payinfo)){ ?>
                                    <div><strong><?php echo display('payment_method') ?>: <?php echo (($payinfo['payment_id'] > 1)?ucfirst($payinfo['payment_method']):'Cash on Delivery') ?></strong></div>
                                    <?php } ?>
                                    <br>

                                    <span class="label label-success-outline m-r-15"><?php echo display('order_from') ?></span>

                                    <address class="mt_10">
                                        <strong>{customer_name} </strong><br>
                                        <abbr><?php echo display('address') ?>:</abbr>
                                        <?php  if ($customer_address) { ?>
                                            <c class="m_0 p_0"><?php echo html_escape($customer_address); ?></c>
                                        <?php } ?><br>
                                        <abbr><?php echo display('mobile') ?>
                                            :</abbr><?php if ($customer_mobile) { ?>{customer_mobile}<?php }
                                        if ($customer_email) { ?>
                                            <br>
                                            <abbr><?php echo display('email') ?>:</abbr>{customer_email}
                                        <?php } ?>
                                    </address>
                                </div>
                                <?php } else { ?>
                                    <div class="col-sm-2 text-left cus_div">
                                        <h2 class="m-t-0"><?php echo display('order') ?></h2>
                                        <div><?php echo display('order_no') ?>: {order_no}</div>
                                        <div class="m-b-15"><?php echo display('order_date') ?>: {final_date}</div>

                                        <span class="label label-success-outline m-r-15"><?php echo display('order_from') ?></span>

                                        <address class="mt_10">
                                            <strong>{ship_customer_name} </strong><br>
                                            <abbr><?php echo display('address') ?>:</abbr>
                                            <?php if ($ship_customer_short_address) { ?>
                                                <c class="m_0 p_0">
                                                    {ship_customer_short_address}
                                                </c>
                                            <?php } ?><br>
                                            <abbr><?php echo display('mobile') ?>
                                                :</abbr><?php if ($ship_customer_mobile) {
                                                ?>{ship_customer_mobile}<?php }
                                            if ($ship_customer_email) { ?>
                                                <br>
                                                <abbr><?php echo display('email') ?>:</abbr>{ship_customer_email}
                                            <?php } ?>
                                        </address>
                                    </div>
                                <?php } ?>
                            </div>
                            <hr>

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
                                        <?php if(!empty($order_all_data)){ foreach($order_all_data as $order){ ?>
                                    <tr>
                                        <td><?php echo html_escape($order['sl']); ?></td>
                                        <td><strong><?php echo html_escape($order['product_name']); ?> - (<?php echo html_escape($order['product_model']); ?>)</strong></td>
                                        <td><?php echo html_escape($order['variant_name']); 
                                        if(!empty($order['variant_color'])){
                                            $cvarinfo = $this->db->select('variant_name')->from('variant')->where('variant_id', $order['variant_color'])->get()->row();
                                            if(!empty($cvarinfo)){
                                                echo ', '.$cvarinfo->variant_name;
                                            }
                                        }

                                        ?>
                                        </td>
                                        <td><?php echo html_escape($order['unit_short_name']); ?></td>
                                        <td><?php echo html_escape($order['quantity']); ?></td>
                                        <td><?php echo(($position == 0) ? $currency." ".$order['rate'] : $order['rate']." ".$currency) ?></td>
                                        <td><?php echo(($position == 0) ? $currency." ".$order['discount'] : $order['discount']." ".$currency) ?></td>
                                        <td><?php echo(($position == 0) ? $currency." ".$order['total_price'] : $order['total_price']." ".$currency) ?></td>


                                    </tr>
                                    <?php } } ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="width_70p ft_left">
                                        <p><strong>{details}</strong></p>
                                    </div>

                                    <div class="ft_left width_30p">

                                        <table class="table">
                                            <?php if ($order_all_data[0]['discount'] != 0) { ?>
                                                <tr>
                                                    <th class="bt_bb_0"><?php echo display('total_discount') ?>
                                                        :
                                                    </th>
                                                    <td class="bt_bb_0"><?php echo(($position == 0) ? "$currency {order_discount}" : "{order_discount} $currency") ?> </td>
                                                </tr>
                                            <?php }
                                            $this->db->select('a.*,b.tax_name');
                                            $this->db->from('order_tax_col_summary a');
                                            $this->db->join('tax b', 'a.tax_id = b.tax_id');
                                            $this->db->where('a.order_id', $order_id);
                                            $this->db->where('a.tax_id', 'H5MQN4NXJBSDX4L');
                                            $tax_info = $this->db->get()->row();

                                            if ($tax_info) { ?>
                                                <tr>
                                                    <th class="total_cgst"><?php echo html_escape($tax_info->tax_name) ?> :</th>
                                                    <td class="total_cgst"><?php echo(($position == 0) ? $currency . $tax_info->tax_amount : $tax_info->tax_amount . $currency); ?>
                                                    </td>
                                                </tr>
                                            <?php }
                                            $this->db->select('a.*,b.tax_name');
                                            $this->db->from('order_tax_col_summary a');
                                            $this->db->join('tax b', 'a.tax_id = b.tax_id');
                                            $this->db->where('a.order_id', $order_id);
                                            $this->db->where('a.tax_id', '52C2SKCKGQY6Q9J');
                                            $tax_info = $this->db->get()->row();

                                            if ($tax_info) { ?>
                                                <tr>
                                                    <th class="total_sgst"><?php echo html_escape($tax_info->tax_name) ?> :</th>
                                                    <td class="total_sgst"><?php echo(($position == 0) ? $currency . $tax_info->tax_amount : $tax_info->tax_amount . $currency); ?>
                                                    </td>
                                                </tr>
                                            <?php }
                                            $this->db->select('a.*,b.tax_name');
                                            $this->db->from('order_tax_col_summary a');
                                            $this->db->join('tax b', 'a.tax_id = b.tax_id');
                                            $this->db->where('a.order_id', $order_id);
                                            $this->db->where('a.tax_id', '5SN9PRWPN131T4V');
                                            $tax_info = $this->db->get()->row();

                                            if ($tax_info) {
                                                ?>
                                                <tr>
                                                    <th class="total_igst"><?php echo html_escape($tax_info->tax_name) ?> :</th>
                                                    <td class="total_igst"><?php echo(($position == 0) ? $currency . $tax_info->tax_amount : $tax_info->tax_amount . $currency); ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                            <?php if ($order_all_data[0]['service_charge'] != 0) { ?>
                                                <tr>
                                                    <th class="service_charge"><?php echo display('service_charge') ?>
                                                        :
                                                    </th>
                                                    <td class="service_charge"><?php echo(($position == 0) ? "$currency {service_charge}" : "{service_charge} $currency") ?></td>
                                                </tr>
                                            <?php } ?>
                                            <tr>
                                                <th class="grand_total"><?php echo display('grand_total') ?> :</th>
                                                <td class="grand_total"><?php echo(($position == 0) ? "$currency {total_amount}" : "{total_amount} $currency") ?></td>
                                            </tr>
                                            <tr>
                                                <th class="bt_bb_0"><?php echo display('paid_ammount') ?>
                                                    :
                                                </th>
                                                <td  class="bt_bb_0"><?php echo(($position == 0) ? "$currency {paid_amount}" : "{paid_amount} $currency") ?></td>
                                            </tr>
                                            <?php if ($order_all_data[0]['due_amount'] != 0) { ?>
                                                <tr>
                                                    <th><?php echo display('due') ?> :</th>
                                                    <td><?php echo(($position == 0) ? "$currency {due_amount}" : "{due_amount} $currency") ?></td>
                                                </tr>
                                            <?php } ?>
                                        </table>
                                        <div class="auth_by"><?php echo display('authorised_by') ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel-footer text-left">
                        <a class="btn btn-danger"
                           href="<?php echo base_url('dashboard/Corder'); ?>"><?php echo display('cancel') ?></a>
                        <a class="btn btn-info" href="#" onclick="printDiv('printableArea')"><span class="fa fa-print"></span></a>
                    </div>
                </div>
            </div>
        </div>
    </section> <!-- /.content -->
</div> <!-- /.content-wrapper -->



