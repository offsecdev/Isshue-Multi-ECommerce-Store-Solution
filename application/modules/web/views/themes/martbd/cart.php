<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
if ($this->cart->contents()) {
    ?>
    <!-- /.End of header -->
    <div class="page-breadcrumbs">
        <div class="container">
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url() ?>"><?php echo display('home') ?></a></li>
                <li class="active"><?php echo display('cart') ?></li>
            </ol>
        </div>
    </div>
    <!-- /.End of page breadcrumbs -->

    <?php
    if ($this->session->userdata('error_msg')) {
        ?>
        <!--======== Message alert ========-->
        <section class="coupon_area">
            <div class="container">
                <div class="row db coupon_inner text-center color_red">
                    <div class="alert alert-danger alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>

                        <?php
                        $error_msg = $this->session->userdata('error_msg');
                        if ($error_msg) {
                            echo $error_msg;
                        }
                        ?>
                    </div>
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
                <div class="row db coupon_inner text-center color_green">
                    <div class="alert alert-success alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>

                        <?php
                        $message = $this->session->userdata('message');
                        if ($message) {
                            echo $message;
                        }
                        ?>
                    </div>
                </div>
            </div>
        </section>
        <!--======= Message alert ======-->
        <?php
        $this->session->unset_userdata('message');
    }
    ?>

    <div class="cart-list-content">
        <div class="container">
            <?php echo form_open('home/update_cart'); ?>
            <div class="-row">
                <div class="-col-sm-12">
                    <h1><?php echo display('cart') ?></h1>
                    <div class="shopping-cart-list">
                        <div class="column-labels">
                            <label class="product-image"><?php echo display('image') ?></label>
                            <label class="product-details"><?php echo display('product_name') ?></label>
                            <label class="price-title"><?php echo display('price') ?></label>
                            <label class="product-variant"><?php echo display('variant') ?></label>
                            <label class="product-quantity"><?php echo display('quantity') ?></label>
                            <label class="product-removal"><?php echo display('delete') ?></label>
                            <label class="total-price-title"><?php echo display('total') ?></label>
                        </div>
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

                            <div class="product-cart-list">
                                <div class="product-image">
                                    <img src="<?php echo base_url() . $items['options']['image']; ?>" alt="image">
                                </div>
                                <div class="product-details">
                                    <div class="product-name"><?php echo html_escape($items['name']); ?></div>
                                </div>
                                <div class="cart-product-price"><?php echo(($position == 0) ? $currency . $this->cart->format_number($items['price']) : $this->cart->format_number($items['price']) . $currency) ?></div>
                                <div class="cart-product-variant">
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
                                </div>
                                <div class="product-quantity">
                                    <?php echo form_input(array('class' => 'text-center', 'name' => $i . '[qty]', 'value' => $items['qty'], 'maxlength' => '3', 'size' => '5')); ?>
                                    <button type="submit" title="Update"><i class="fa fa-refresh qnty_refresh"></i>
                                    </button>
                                </div>
                                <div class="product-removal">
                                    <a href="<?php echo base_url('web/home/delete_cart_by_click/' . $items['rowid']) ?>"
                                       onclick='return confirm("<?php echo display('are_you_sure_want_to_delete') ?>")'>
                                        <i class="fa fa-trash fs_1_5e" aria-hidden="true"></i>
                                    </a>
                                </div>
                                <div class="total-price"><?php echo(($position == 0) ? $currency . $this->cart->format_number($items['subtotal']) : $this->cart->format_number($items['subtotal']) . $currency) ?></div>
                            </div>
                            <!-- /.End of product cart list -->
                            <?php $i++; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php echo form_close() ?>
            <div class="row mt-5">
                <div class="col-md-12 text-right">
                    <a href="<?php echo base_url(); ?>" class="btn btn-success"><?php echo display('continue_shopping') ?></a>
                    <a href="<?php echo base_url('web/home/clear_cart'); ?>" class="btn btn-danger"><?php echo display('clear_cart') ?></a>
                </div>
            </div>
        </div>
    </div>
    <div class="calculate-content">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 pull-right">
                    <div class="cart-totals">
                        <h2><?php echo display('cart_total') ?></h2>
                        <div class="cart-totals-border">
                            <div class="totals-item">
                                <label><?php echo display('sub_total') ?></label>
                                <div class="totals-value" id="cart-subtotal">
                                    <?php echo(($position == 0) ? $currency . " " . number_format($this->cart->total(), 2, '.', ',') : number_format($this->cart->total(), 2, '.', ',') . " " . $currency) ?>

                                </div>
                            </div>
                            <?php
                            $coupon_amnt = $this->session->userdata('coupon_amnt');
                            if ($coupon_amnt > 0) {
                                ?>
                                <div class="totals-item">
                                    <label>
                                        <?php echo display('coupon_discount') ?>
                                    </label>
                                    <div class="totals-value">
                                        <?php
                                        if ($coupon_amnt > 0) {
                                            echo(($position == 0) ? $currency . " " . number_format($coupon_amnt, 2, '.', ',') : number_format($coupon_amnt, 2, '.', ',') . " " . $currency);
                                        }
                                        ?>
                                    </div>
                                </div>
                                <?php
                            }
                            $total_tax = $cgst + $sgst + $igst;
                            if ($total_tax > 0) {
                                ?>
                                <div class="totals-item">
                                    <label><?php echo display('total_tax') ?></label>
                                    <div class="totals-value" id="cart-tax"> <?php
                                        $total_tax = $cgst + $sgst + $igst;
                                        if ($total_tax > 0) {
                                            $total_tax = $cgst + $sgst + $igst;
                                            $CI->_cart_contents['total_tax'] = $total_tax;
                                            echo(($position == 0) ? $currency . " " . number_format($total_tax, 2, '.', ',') : number_format($total_tax, 2, '.', ',') . " " . $currency);
                                        }
                                        ?>
                                    </div>
                                </div>
                            <?php } ?>

                            <div class="totals-item totals-item-total">
                                <label><?php echo display('grand_total') ?></label>
                                <div class="totals-value" id="cart-total"><?php
                                    $cart_total = $this->cart->total() + $total_tax - $this->session->userdata('coupon_amnt');
                                    $this->session->set_userdata('cart_total', $cart_total);
                                    $total_amnt = $CI->_cart_contents['cart_total'] = $cart_total;
                                    echo(($position == 0) ? $currency . " " . number_format($total_amnt, 2, '.', ',') : number_format($total_amnt, 2, '.', ',') . " " . $currency);
                                    ?>
                                </div>
                            </div>
                        </div>
                        <a class="btn btn-default color2 text-white checkout"
                           href="<?php echo base_url('checkout') ?>"><?php
                            echo display('checkout') ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
} else {
    ?>
    <div class="page-breadcrumbs">
        <div class="container">
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url() ?>"><?php echo display('home') ?></a></li>
                <li class="active"><?php echo display('cart') ?></li>
            </ol>
        </div>
    </div>

    <!--========== Empty Cart Area ==========-->
    <section class="shopping_cart_area">
        <div class="container">
            <div class="row db empty_cart text-center">
                <img src="<?php echo base_url() ?>assets/website/image/oops.png" alt="oops image">
                <h2 class="page_title"><?php echo display('oops_your_cart_is_empty') ?></h2>
                <a href="<?php echo base_url() ?>"
                   class="base_button btn btn-success"><?php echo display('got_to_shop_now') ?></a>
            </div>
        </div>
    </section>
    <!--========== End Empty Cart Area ==========-->
<?php } ?>
