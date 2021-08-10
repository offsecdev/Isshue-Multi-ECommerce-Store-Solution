<?php include_once(dirname(__FILE__).'/functions/functions.php');
$CI =& get_instance();
?>
<?php if(!empty($this->cart->contents())){ ?>
<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="wrap">
                    <h1 class="projTitle text-uppercase font-weight-200 text-center py-3 fs-32"><?php echo display('cart') ?></h1>
                    <?php 
                    $message = $this->session->userdata('message');
                    if (!empty($message)) {
                    ?>
                    <div class="alert alert-info alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <?php echo $message ?>                    
                    </div>
                    <?php 
                    $this->session->unset_userdata('message');
                    }
                    $error_message = $this->session->userdata('error_msg');
                    $validation_errors = validation_errors();
                    if (!empty($error_message) || !empty($validation_errors)) {
                    ?>
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <?php echo $error_message ?>                    
                        <?php echo $validation_errors ?>                    
                    </div>
                    <?php 
                    $this->session->unset_userdata('error_msg');
                     } ?>
             
                    <div class="d-flex align-items-center justify-content-between py-3 border-top border-bottom">
                        <h1 class="fs-24 mb-0"><?php echo display('items_in_your_cart') ?></h1>
                        <div>
                            <a href="<?php echo base_url(); ?>" class="btn btn-primary btn-sm btn-pill px-3 color4 color46"><?php echo display('continue_shopping') ?></a>
                            <a href="<?php echo base_url('web/home/clear_cart'); ?>" class="btn btn-danger btn-sm btn-pill px-3"><?php echo display('clear_cart') ?></a>
                        </div>
                    </div>
                    <?php echo form_open('home/update_cart', array('id' => 'cartform')); ?>
                    <div class="cart">
                        <ul class="cartWrap m-0 p-0">
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

                            <li class="items odd d-block w-100 align-middle border-bottom py-3 px-3">
                                <div class="infoWrap d-flex align-items-center justify-content-between w-100">
                                    <div class="cartSection w-100">
                                        <img src="<?php echo base_url() . $items['options']['image']; ?>" alt="Image" class="itemImg float-left d-block pr-3">
                                        <p class="itemNumber fs-11 text-black-50 mb-1">#<?php echo sprintf("%03d", $i); ?></p>
                                        <h3 class="fs-17 mb-3 font-weight-400"><?php echo html_escape($items['name']); ?> - (
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
                                                echo ", ".html_escape($cvar->variant_name);
                                            }
                                            ?>
                                        )</h3>
                                        <div class="d-flex align-items-center">
                                            <div class="num-block skin-2">
                                                <div class="num-in d-flex bg-white border mr-2">
                                                    <span class="minus position-relative dis"></span>
                                                    <?php echo form_input(array('class' => 'in-num text-center border-0 cart_qnty', 'name' => $i . '[qty]', 'value' => $items['qty'], 'maxlength' => '3', 'size' => '5')); ?>
                                                    <span class="plus position-relative"></span>
                                                </div>
                                            </div>
                                            <span class="fs-14"> x <?php echo(($position == 0) ? $currency . $this->cart->format_number($items['price']*$target_con_rate) : $this->cart->format_number($items['price']*$target_con_rate) . $currency) ?></span>
                                            <span class="stockStatus text-uppercase pl-2 fs-13 font-weight-bold"><?php echo display('in_stock') ?></span>
                                        </div>
                                    </div>
                                    <div class="priceSection d-flex">
                                        <div class="prodTotal cartSection">
                                            <p class="fs-21 mb-0"><?php echo(($position == 0) ? $currency . $this->cart->format_number($items['subtotal']*$target_con_rate) : $this->cart->format_number($items['subtotal']*$target_con_rate) . $currency) ?></p>
                                        </div>
                                        <div class="cartSection removeWrap ml-3">
                                            <a href="<?php echo base_url('web/home/delete_cart_by_click/' . $items['rowid']) ?>" class="remove d-flex align-items-center justify-content-center"  onclick='return confirm("<?php echo display('are_you_sure_want_to_delete') ?>")'><i data-feather="trash-2"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php echo form_close() ?>
                    <div class="row justify-content-between mt-5">
                        <div class="col-md-5 col-lg-5">
                        </div>
                        <div class="col-md-5 col-lg-5 text-right">
                            <ul class="subtotal list-unstyled">
                                <li class="sub-total fs-24 font-weight-200">
                                    <span class="label"><?php echo display('sub_total') ?>:</span>
                                    <span class="value"><?php echo(($position == 0) ? $currency . " " . number_format($this->cart->total()*$target_con_rate, 2, '.', ',') : number_format($this->cart->total()*$target_con_rate, 2, '.', ',') . " " . $currency) ?></span>
                                </li>
                                 <?php
                                $coupon_amnt = $this->session->userdata('coupon_amnt');
                                if ($coupon_amnt > 0) {
                                ?>
                                <li class="tax font-weight-200 fs-19 my-2">
                                    <span class="label"><?php echo display('coupon_discount') ?>:</span>
                                    <span class="value"><?php
                                        if ($coupon_amnt > 0) {
                                            echo(($position == 0) ? $currency . " " . number_format($coupon_amnt*$target_con_rate, 2, '.', ',') : number_format($coupon_amnt*$target_con_rate, 2, '.', ',') . " " . $currency);
                                        }
                                        ?></span>
                                </li>
                                <?php } ?>

                                <?php 
                                $total_tax = $cgst + $sgst + $igst;
                                if ($total_tax > 0) {
                                ?>
                                <li class="tax font-weight-200 fs-19 my-2">
                                    <span class="label"><?php echo display('total_tax') ?> :</span>
                                    <span class="value">
                                        <?php
                                        $total_tax = $cgst + $sgst + $igst;
                                        if ($total_tax > 0) {
                                            $total_tax = $cgst + $sgst + $igst;
                                            $CI->_cart_contents['total_tax'] = $total_tax;
                                            echo(($position == 0) ? $currency . " " . number_format($total_tax*$target_con_rate, 2, '.', ',') : number_format($total_tax*$target_con_rate, 2, '.', ',') . " " . $currency);
                                        }
                                        ?>
                                        </span>
                                </li>
                                <?php } ?>
                                
                            </ul>
                            <hr>
                            <div class="site-footer mt-3">
                                <h1 class="sub-total fs-24 font-weight-200 text-right mb-3"><?php echo display('total') ?> : <span><?php
                                    $cart_total = $this->cart->total() + $total_tax - $this->session->userdata('coupon_amnt');
                                    $this->session->set_userdata('cart_total', $cart_total);
                                    $total_amnt = $CI->_cart_contents['cart_total'] = $cart_total;
                                    echo(($position == 0) ? $currency . " " . number_format($total_amnt*$target_con_rate, 2, '.', ',') : number_format($total_amnt*$target_con_rate, 2, '.', ',') . " " . $currency);
                                    ?></span></h1>
                                <a class="btn w-100 font-weight-200 fs-20 text-white   color4 color46" href="<?php echo base_url('checkout') ?>"><?php
                            echo display('checkout') ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php }else{ ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-7">
            <!--Empty cart-->
            <div class="empty-cart text-center font-weight-200 py-5">
                <svg viewBox="656 573 264 182" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <rect id="bg-line" stroke="none" fill-opacity="0.2" fill="#b5023b" fill-rule="evenodd" x="656" y="624" width="206" height="38" rx="19"></rect>
                <rect id="bg-line" stroke="none" fill-opacity="0.2" fill="#b5023b" fill-rule="evenodd" x="692" y="665" width="192" height="29" rx="14.5"></rect>
                <rect id="bg-line" stroke="none" fill-opacity="0.2" fill="#b5023b" fill-rule="evenodd" x="678" y="696" width="192" height="33" rx="16.5"></rect>
                <g id="shopping-bag" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" transform="translate(721.000000, 630.000000)">
                <polygon id="Fill-10" fill="#d8074a" points="4 29 120 29 120 0 4 0"></polygon>
                <polygon id="Fill-14" fill="#b5023b" points="120 29 120 0 115.75 0 103 12.4285714 115.75 29"></polygon>
                <polygon id="Fill-15" fill="#b5023b" points="4 29 4 0 8.25 0 21 12.4285714 8.25 29"></polygon>
                <polygon id="Fill-33" fill="#d8074a" points="110 112 121.573723 109.059187 122 29 110 29"></polygon>
                <polygon id="Fill-35" fill-opacity="0.5" fill="#FFFFFF" points="2 107.846154 10 112 10 31 2 31"></polygon>
                <path d="M107.709596,112 L15.2883462,112 C11.2635,112 8,108.70905 8,104.648275 L8,29 L115,29 L115,104.648275 C115,108.70905 111.7365,112 107.709596,112" id="Fill-36" fill="#b5023b"></path>
                <path d="M122,97.4615385 L122,104.230231 C122,108.521154 118.534483,112 114.257931,112 L9.74206897,112 C5.46551724,112 2,108.521154 2,104.230231 L2,58" id="Stroke-4916" stroke="#000000" stroke-width="1" stroke-linecap="round"></path>
                <polyline id="Stroke-4917" stroke="#000000" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" points="2 41.5 2 29 122 29 122 79"></polyline>
                <path d="M4,50 C4,51.104 3.104,52 2,52 C0.896,52 0,51.104 0,50 C0,48.896 0.896,48 2,48 C3.104,48 4,48.896 4,50" id="Fill-4918" fill="#000000"></path>
                <path d="M122,87 L122,89" id="Stroke-4919" stroke="#000000" stroke-width="1" stroke-linecap="round"></path>
                <polygon id="Stroke-4922" stroke="#000000" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" points="4 29 120 29 120 0 4 0"></polygon>
                <path d="M87,46 L87,58.3333333 C87,71.9 75.75,83 62,83 L62,83 C48.25,83 37,71.9 37,58.3333333 L37,46" id="Stroke-4923" stroke="#000000" stroke-width="1" stroke-linecap="round"></path>
                <path d="M31,45 C31,41.686 33.686,39 37,39 C40.314,39 43,41.686 43,45" id="Stroke-4924" stroke="#000000" stroke-width="1" stroke-linecap="round"></path>
                <path d="M81,45 C81,41.686 83.686,39 87,39 C90.314,39 93,41.686 93,45" id="Stroke-4925" stroke="#000000" stroke-width="1" stroke-linecap="round"></path>
                <path d="M8,0 L20,12" id="Stroke-4928" stroke="#000000" stroke-width="1" stroke-linecap="round"></path>
                <path d="M20,12 L8,29" id="Stroke-4929" stroke="#000000" stroke-width="1" stroke-linecap="round"></path>
                <path d="M20,12 L20,29" id="Stroke-4930" stroke="#000000" stroke-width="1" stroke-linecap="round"></path>
                <path d="M115,0 L103,12" id="Stroke-4931" stroke="#000000" stroke-width="1" stroke-linecap="round"></path>
                <path d="M103,12 L115,29" id="Stroke-4932" stroke="#000000" stroke-width="1" stroke-linecap="round"></path>
                <path d="M103,12 L103,29" id="Stroke-4933" stroke="#000000" stroke-width="1" stroke-linecap="round"></path>
                </g>
                <g id="glow" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" transform="translate(768.000000, 615.000000)">
                <rect id="Rectangle-2" fill="#000000" x="14" y="0" width="2" height="9" rx="1"></rect>
                <rect fill="#000000" transform="translate(7.601883, 6.142354) rotate(-12.000000) translate(-7.601883, -6.142354) " x="6.60188267" y="3.14235449" width="2" height="6" rx="1"></rect>
                <rect fill="#000000" transform="translate(1.540235, 7.782080) rotate(-25.000000) translate(-1.540235, -7.782080) " x="0.54023518" y="6.28207994" width="2" height="3" rx="1"></rect>
                <rect fill="#000000" transform="translate(29.540235, 7.782080) scale(-1, 1) rotate(-25.000000) translate(-29.540235, -7.782080) " x="28.5402352" y="6.28207994" width="2" height="3" rx="1"></rect>
                <rect fill="#000000" transform="translate(22.601883, 6.142354) scale(-1, 1) rotate(-12.000000) translate(-22.601883, -6.142354) " x="21.6018827" y="3.14235449" width="2" height="6" rx="1"></rect>
                </g>
                <polygon id="plus" stroke="none" fill="#7DBFEB" fill-rule="evenodd" points="689.681239 597.614697 689.681239 596 690.771974 596 690.771974 597.614697 692.408077 597.614697 692.408077 598.691161 690.771974 598.691161 690.771974 600.350404 689.681239 600.350404 689.681239 598.691161 688 598.691161 688 597.614697"></polygon>
                <polygon id="plus" stroke="none" fill="#EEE332" fill-rule="evenodd" points="913.288398 701.226961 913.288398 699 914.773039 699 914.773039 701.226961 917 701.226961 917 702.711602 914.773039 702.711602 914.773039 705 913.288398 705 913.288398 702.711602 911 702.711602 911 701.226961"></polygon>
                <polygon id="plus" stroke="none" fill="#d8074a" fill-rule="evenodd" points="662.288398 736.226961 662.288398 734 663.773039 734 663.773039 736.226961 666 736.226961 666 737.711602 663.773039 737.711602 663.773039 740 662.288398 740 662.288398 737.711602 660 737.711602 660 736.226961"></polygon>
                <circle id="oval" stroke="none" fill="#A5D6D3" fill-rule="evenodd" cx="699.5" cy="579.5" r="1.5"></circle>
                <circle id="oval" stroke="none" fill="#CFC94E" fill-rule="evenodd" cx="712.5" cy="617.5" r="1.5"></circle>
                <circle id="oval" stroke="none" fill="#8CC8C8" fill-rule="evenodd" cx="692.5" cy="738.5" r="1.5"></circle>
                <circle id="oval" stroke="none" fill="#3EC08D" fill-rule="evenodd" cx="884.5" cy="657.5" r="1.5"></circle>
                <circle id="oval" stroke="none" fill="#66739F" fill-rule="evenodd" cx="918.5" cy="681.5" r="1.5"></circle>
                <circle id="oval" stroke="none" fill="#C48C47" fill-rule="evenodd" cx="903.5" cy="723.5" r="1.5"></circle>
                <circle id="oval" stroke="none" fill="#A24C65" fill-rule="evenodd" cx="760.5" cy="587.5" r="1.5"></circle>
                <circle id="oval" stroke="#66739F" stroke-width="1" fill="none" cx="745" cy="603" r="3"></circle>
                <circle id="oval" stroke="#EFB549" stroke-width="1" fill="none" cx="716" cy="597" r="3"></circle>
                <circle id="oval" stroke="#b5023b" stroke-width="1" fill="none" cx="681" cy="751" r="3"></circle>
                <circle id="oval" stroke="#3CBC83" stroke-width="1" fill="none" cx="896" cy="680" r="3"></circle>
                <polygon id="diamond" stroke="#C46F82" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" fill="none" points="886 705 889 708 886 711 883 708"></polygon>
                <path d="M736,577 C737.65825,577 739,578.34175 739,580 C739,578.34175 740.34175,577 742,577 C740.34175,577 739,575.65825 739,574 C739,575.65825 737.65825,577 736,577 Z" id="bubble-rounded" stroke="#3CBC83" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" fill="none"></path>
                </svg>
                <h3 class="font-weight-200 mb-0 fs-32"><?php echo display('oops_your_cart_is_empty') ?></h3>
                <p class="fs-18 text-black-50 mb-0 mt-4"><a href="<?php echo base_url() ?>"
                   class="base_button btn btn-success"><?php echo display('continue_shopping') ?></a></p>

            </div>
        </div>
    </div>
</div>
<?php } ?>
