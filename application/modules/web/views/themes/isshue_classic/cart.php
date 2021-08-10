<?php
defined('BASEPATH') or exit('No direct script access allowed');

$CI =& get_instance();
if ($this->cart->contents()) {
    ?>
    <!--========== Page Header Area ==========-->
    <section class="page_header">
        <div class="container">
            <div class="row m0 page_header_inner">
                <h2 class="page_title"><?php echo display('cart') ?></h2>
                <ol class="breadcrumb m0 p0">
                    <li class="breadcrumb-item"><a href="<?php echo base_url() ?>"><?php echo display('home') ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo display('cart') ?></li>
                </ol>
            </div>
        </div>
    </section>
    <!--========== End Page Header Area ==========-->
    <?php
    if ($this->session->userdata('error_msg')) {
        ?>
        <!--======== Message alert ========-->
        <section class="coupon_area">
            <div class="container">
                <div class="row db coupon_inner color_red">
                    <?php
                    $error_msg = $this->session->userdata('error_msg');
                    if ($error_msg) {
                        echo $error_msg;
                    }
                    ?>
                </div>
            </div>
        </section>
        <!--======= Message alert ======-->

        <?php
        $this->session->unset_userdata('error_msg');
    }
    if ($this->session->userdata('message')) {
        ?>

        <!--======== Message alert ========-->
        <section class="coupon_area">
            <div class="container">
                <div class="row db coupon_inner color_green">
                    <?php
                    $message = $this->session->userdata('message');
                    if ($message) {
                        echo $message;
                    }
                    ?>
                </div>
            </div>
        </section>
        <!--======= Message alert ======-->
        <?php
        $this->session->unset_userdata('message');
    }
    ?>

    <!--==========Shopping cart area==========-->
    <div class="shopping_cart_area">
        <div class="container">
            <?php echo form_open('home/update_cart'); ?>
            <div class="shopping_cart_inner">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th><?php echo display('image') ?></th>
                            <th><?php echo display('product_name') ?></th>
                            <th><?php echo display('model') ?></th>
                            <th><?php echo display('variant') ?></th>
                            <th><?php echo display('quantity') ?></th>
                            <th><?php echo display('price') ?></th>
                            <th><?php echo display('total') ?></th>
                            <th><?php echo display('delete') ?></th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php $i = 1;
                        $cgst = 0;
                        $sgst = 0;
                        $igst = 0;
                        $discount = 0; ?>
                        <?php foreach ($this->cart->contents() as $items): ?>
                            <?php echo form_hidden($i . '[rowid]', $items['rowid']);

                            if (!empty($items['options']['cgst'])) {
                                $cgst = $cgst + ($items['options']['cgst'] * $items['qty']);
                            }

                            if (!empty($items['options']['sgst'])) {
                                $sgst = $sgst + ($items['options']['sgst'] * $items['qty']);
                            }

                            if (!empty($items['options']['igst'])) {
                                $igst = $igst + ($items['options']['igst'] * $items['qty']);
                            }

                            //Calculation for discount
                            if (!empty($items['discount'])) {
                                $discount = $discount + ($items['discount'] * $items['qty']) + $this->session->userdata('coupon_amnt');
                                $this->session->set_userdata('total_discount', $discount);
                            }
                            ?>

                            <tr>
                                <td><img src="<?php echo html_escape($items['options']['image']); ?>" alt=""></td>
                                <td><?php echo html_escape($items['name']); ?></td>
                                <td><?php echo html_escape($items['options']['model']); ?></td>
                                <td>
                                    <?php
                                    if (!empty($items['variant'])) {
                                        $this->db->select('variant_name');
                                        $this->db->from('variant');
                                        $this->db->where('variant_id', $items['variant']);
                                        $query = $this->db->get();
                                        $var = $query->row();
                                        echo html_escape($var->variant_name);
                                    }
                                    if (!empty($items['variant_color'])) {
                                        $this->db->select('variant_name');
                                        $this->db->from('variant');
                                        $this->db->where('variant_id', $items['variant_color']);
                                        $cquery = $this->db->get();
                                        $cvar = $cquery->row();
                                        echo "<br>".html_escape($cvar->variant_name);
                                    }
                                    ?>
                                </td>
                                <td><?php echo form_input(array('class' => 'text-center', 'name' => $i . '[qty]', 'value' => $items['qty'], 'maxlength' => '3', 'size' => '5')); ?>
                                    <button type="submit"><i class="fa fa-refresh qnty_refresh"></i></button>
                                </td>
                                <td><?php echo(($position == 0) ? $currency . $this->cart->format_number($items['price']) : $this->cart->format_number($items['price']) . $currency) ?></td>
                                <td><?php echo(($position == 0) ? $currency . $this->cart->format_number($items['subtotal']) : $this->cart->format_number($items['subtotal']) . $currency) ?></td>
                                <td>
                                    <a href="<?php echo base_url('web/home/delete_cart_by_click/' . $items['rowid']) ?>"
                                       onclick='return confirm("<?php echo display('are_you_sure_want_to_delete') ?>")'>
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </a>
                                </td>
                            </tr>

                            <?php $i++; ?>
                        <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>
            </div>
            <?php echo form_close() ?>
            <br>
            <div class="row">
                <div class="col-md-12 text-left">

                    <a href="<?php echo base_url(); ?>" class="btn btn-success"><?php echo display('continue_shopping') ?></a>
                    <a href="<?php echo base_url('web/home/clear_cart'); ?>" class="btn btn-danger"><?php echo display('clear_cart') ?></a>
                </div>
            </div>
        </div>
    </div>
    <!--==========End Shopping cart area==========-->

    <!--======== Price area ======-->
    <div class="price_area">
        <div class="container">
            <div class="row db m0 price_inner">
                <table class="pricing_list">
                    <tbody>
                    <tr>
                        <td class="price_title">
                            <?php echo display('sub_total') ?>
                        </td>
                        <td class="price_Currency">
                            <?php echo(($position == 0) ? $currency . number_format($this->cart->total(), 2, '.', ',') : number_format($this->cart->total(), 2, '.', ',') . $currency) ?>
                        </td>
                    </tr>
                    <?php
                    $coupon_amnt = $this->session->userdata('coupon_amnt');
                    if ($coupon_amnt > 0) {
                        ?>
                        <tr>
                            <td class="price_title">
                                <?php echo display('coupon_discount') ?>
                            </td>
                            <td class="price_Currency">
                                <?php
                                if ($coupon_amnt > 0) {
                                    echo(($position == 0) ? $currency . " " . number_format($coupon_amnt, 2, '.', ',') : number_format($coupon_amnt, 2, '.', ',') . " " . $currency);
                                }
                                ?>
                            </td>
                        </tr>
                        <?php
                    }
                    $total_tax = $cgst + $sgst + $igst;
                    if ($total_tax > 0) {
                        ?>
                        <tr>
                            <td class="price_title">
                                <?php echo display('total_tax') ?>
                            </td>
                            <td class="price_Currency">
                                <?php
                                $total_tax = $cgst + $sgst + $igst;
                                if ($total_tax > 0) {
                                    $total_tax = $cgst + $sgst + $igst;
                                    $CI->_cart_contents['total_tax'] = $total_tax;
                                    echo(($position == 0) ? $currency . " " . number_format($total_tax, 2, '.', ',') : number_format($total_tax, 2, '.', ',') . " " . $currency);
                                }
                                ?>
                            </td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td class="price_title">
                            <?php echo display('grand_total') ?>
                        </td>

                        <td class="price_Currency">
                            <?php
                            $cart_total = $this->cart->total() + $total_tax - $this->session->userdata('coupon_amnt');
                            $this->session->set_userdata('cart_total', $cart_total);
                            $total_amnt = $CI->_cart_contents['cart_total'] = $cart_total;
                            echo(($position == 0) ? $currency . " " . number_format($total_amnt, 2, '.', ',') : number_format($total_amnt, 2, '.', ',') . " " . $currency);
                            ?>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="text-right mt-4">
                <a class="btn btn-default color2 text-white"
                   href="<?php echo base_url('checkout') ?>"><?php echo display('checkout') ?></a>
            </div>
        </div>
    </div>
    <!--======= End Price area======-->
    <?php
} else {
    ?>
    <!--========== Page Header Area ==========-->
    <section class="page_header">
        <div class="container">
            <div class="row m0 page_header_inner">
                <h2 class="page_title"><?php echo display('cart') ?></h2>
                <ol class="breadcrumb m0 p0">
                    <li class="breadcrumb-item"><a href="<?php echo base_url() ?>"><?php echo display('home') ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo display('cart_empty') ?></li>
                </ol>
            </div>
        </div>
    </section>
    <!--========== End Page Header Area ==========-->
    <!--========== Empty Cart Area ==========-->
    <section class="shopping_cart_area">
        <div class="container">
            <div class="row db empty_cart">
                <img src="<?php echo base_url() ?>assets/website/image/oops.png" alt="oops image">
                <h2 class="page_title"><?php echo display('oops_your_cart_is_empty') ?></h2>
                <a href="<?php echo base_url() ?>" class="base_button"><?php echo display('got_to_shop_now') ?></a>
            </div>
        </div>
    </section>
    <!--========== End Empty Cart Area ==========-->

    <!--=========== Newsletter Area ===========-->
    <section class="newsletter_area">
        <div class="container">
            <div class="row m0 newsletter_inner bg_gray">
                <div class="col-lg-6 col-xl-5">
                    <div class="row m0 newsletter_left_area">
                        <h4><?php echo display('sign_up_for_news_and') ?> <span><?php echo display('offers') ?></span>
                        </h4>
                        <h6><?php echo display('you_may_unsubscribe_at_any_time') ?></h6>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-7">
                    <div id="sub_msg"></div>
                    <?php echo form_open('', array('class' => 'row m0 newsletter_form'))?>
                        <div class="input-group">
                            <input type="email" class="form-control"
                                   placeholder="<?php echo display('enter_your_email') ?>" required="" id="sub_email">
                            <span class="input-group-btn">
                            <button class="btn btn-default subscribe" type="button" id="smt_btn"><i
                                        class="fa fa-search"></i></button>
                        </span>
                        </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </section>
    <!--========= End Newsletter Area =========-->

    <?php
}
?>
