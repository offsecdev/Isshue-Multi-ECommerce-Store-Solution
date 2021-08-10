<?php
    $currency_new_id = $this->session->userdata('currency_new_id');
    $target_con_rate = $position1 = $currency1 = 0;

    if (empty($currency_new_id)) {
        $result = $cur_info = $this->db->select('*')
            ->from('currency_info')
            ->where('default_status', '1')
            ->get()
            ->row();
        $currency_new_id = $result->currency_id;
    }

    
    if (!empty($currency_new_id)) {
        $cur_info = $this->db->select('*')
            ->from('currency_info')
            ->where('currency_id', $currency_new_id)
            ->get()
            ->row();

        $target_con_rate = $cur_info->convertion_rate;
        $position1 = $cur_info->currency_position;
        $currency1 = $cur_info->currency_icon;
    }

    ?>
<!--Topbar-->
<div class="topbar topbar-bg color5">
    <div class="container">
        <div class="topbar-text text-nowrap d-none d-md-flex align-items-center">
            <i data-feather="headphones" class="mr-2"></i>
            <span class="mr-1"><?php echo display('have_a_question') ?> <?php echo display('call_us') ?></span>
            <a class="topbar-link" href="tel:<?php echo html_escape($company_info[0]['mobile']) ?>"><?php echo html_escape($company_info[0]['mobile']) ?></a>
        </div>
        <div class="d-flex justify-content-between justify-content-md-end w-100">
            <a class="topbar-link d-flex align-items-center" href="#" data-toggle="modal" data-target="#trackingModal">
                <i data-feather="user" class="mr-2"></i><?php echo display('track_my_order') ?></a> &nbsp;
            <?php 
            if ($this->session->userdata('customer_name')) { ?>
            <div class="topbar-text dropdown disable-autohide ml-3">
                <a class="topbar-link dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                    <i data-feather="user" class="mr-2"></i> <?php echo ucwords($this->session->userdata('customer_name')) ?> </a>
                <ul class="dropdown-menu dropdown-menu-right" style="">
                    <li class="dropdown-item">
                        <a href="<?php echo base_url('customer/customer_dashboard') ?>"><?php echo display('dashboard') ?></a>
                    </li>
                    <li class="dropdown-item">
                        <a href="<?php echo base_url('logout') ?>"><?php echo display('logout') ?></a>
                    </li>
                </ul>
            </div>
            <?php }else{ ?>
                <a class="topbar-link d-flex align-items-center" href="#" data-toggle="modal" data-target="#loginModal">
                <i data-feather="user" class="mr-2"></i><?php echo display('signin') ?></a>
            <?php } ?>

            <div class="topbar-text dropdown disable-autohide ml-3">
                <a class="topbar-link dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                    <?php
                    if (!empty($this->session->userdata('language'))) {
                        $language_id = $this->session->userdata('language');
                    } else {
                        $language_id = 'english';
                    }
                    ?>

                    <?php echo ucfirst($language_id); ?> / <?php

                    $currency_new_id = $this->session->userdata('currency_new_id');
                    if ($currency_info) {
                        foreach ($currency_info as $currency) {
                            if (!empty($currency_new_id)) {
                                if ($currency->currency_id == $currency_new_id) {
                                    echo html_escape($currency->currency_name);
                                }
                            } else {
                                if ($currency->currency_id == $selected_cur_id) {
                                    echo html_escape($currency->currency_name);
                                }
                            }
                        }
                    }

                      ?></a>
                <ul class="dropdown-menu dropdown-menu-right" style="">
                    <li class="dropdown-item">
                        <select id="change_currency" name="change_currency" class="custom-select custom-select-sm">

                            <?php
                            
                            if ($currency_info) {
                                foreach ($currency_info as $currency) {
                                    ?>
                                    <option value="<?php echo $currency->currency_id ?>" <?php
                                    if (!empty($currency_new_id)) {
                                        if ($currency->currency_id == $currency_new_id) {
                                            echo "selected";
                                        }
                                    } else {
                                        if ($currency->currency_id == $selected_cur_id) {
                                            echo "selected";
                                        }
                                    }
                                    ?>><?php echo html_escape($currency->currency_name) ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </li>
                     <?php
                        if(!empty($languages)){
                            foreach ($languages as $lkey => $lvalue) {
                        ?>
                            <li><a class="dropdown-item pb-1" id="change_language" href="#" data-lang="<?php echo $lkey; ?>"><?php echo $lvalue; ?></a></li>
                        <?php 
                            }
                        }
                        ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<!--Navbar-->
<div class="navbar-sticky border-bottom">
    <div class="navbar navbar-expand-lg navbar-light color1">
        <div class="container">
            <a class="navbar-brand d-none d-sm-block mr-3 flex-shrink-0" href="<?php echo base_url() ?>">
                <img width="142" src="<?php if (isset($Web_settings[0]['logo'])) {
                        echo base_url().$Web_settings[0]['logo'];
                    } ?>" alt="Cartzilla" />
            </a>
            <a class="navbar-brand d-sm-none mr-2" href="<?php echo base_url() ?>">
                <img width="100" src="<?php if (isset($Web_settings[0]['logo'])) {
                        echo base_url().$Web_settings[0]['logo'];
                    } ?>" alt="" />
            </a>
            <!-- Search-->
            <div class="main-search input-group-overlay d-none d-lg-block mx-4 ui-widget">
                <?php echo form_open('category_product_search', array('method'=>'GET')) ?>
                <div>
                    <div class="input-group-prepend-overlay">
                        <span class="input-group-text"><i data-feather="search"></i></span>
                    </div>
                    <input class="form-control search-input prepended-form-control appended-form-control"  name="product_name" id="search_product_item" type="text" placeholder="Search for products" />
                    <div class="input-group-append-overlay">
                        <button type="submit" class="btn btn-warning search_btn color4 color46 text-white"><span class="lnr
                        lnr-magnifier"></span><?php echo display('search'); ?>
                        </button>
                    </div>
                </div>
                 <?php echo form_close() ?>
            </div>


            <!-- Toolbar-->
            <div class="navbar-toolbar d-flex flex-shrink-0 align-items-center">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse">
                    <i data-feather="menu"></i>
                </button>
                <a class="navbar-tool navbar-stuck-toggler" href="#">
                    <span class="navbar-tool-tooltip">Expand menu</span>
                    <div class="navbar-tool-icon-box"><i data-feather="grid" class="navbar-tool-icon"></i></div>
                </a>

                <div class="dropdown ml-3" id="tab_up_comparison">
                    <div class="navbar-tool dropdown-toggle" data-toggle="dropdown">
                        <a class="navbar-tool-icon-box bg-secondary" href="javascript:void(0)">
                            <span class="navbar-tool-label"><?php if ($this->session->userdata('comparison_ids')) {echo count($this->session->userdata('comparison_ids'));}else{echo 0;}?>
                            </span>  
                            <i class="fas fa-retweet navbar-tool-icon"></i>
                        </a>
                        <a class="navbar-tool-text"  href="javascript:void(0)">
                            <small><?php echo display('product') ?></small> 
                            <?php echo display('compare'); ?>
                        </a>
                    </div>
                    <?php
                        $total_comparison_ids = 0;
                        if ($this->session->userdata('comparison_ids')) {
                            $comparisons = $this->session->userdata('comparison_ids');
                            $total_comparison_ids = count($this->session->userdata('comparison_ids'));

                            $this->db->from('product_information');
                            $this->db->where_in('product_id', $comparisons);
                            $query = $this->db->get();
                            $comparison_products = $query->result();
                    ?>
                    <!-- Comparison dropdown-->
                    <div class="comparison-dropdown dropdown-menu dropdown-menu-right shadow border-0 rounded px-3 pt-2 pb-3">
                        <?php  foreach ($comparison_products as $comparison):  ?>
                        <div class="dropdown-product-item media py-2">
                            <a class="dropdown-product-thumb overflow-hidden bg-gray d-block" href="<?php echo base_url('product/'.remove_space($comparison->product_name).'/'.$comparison->product_id) ?>">
                                <img src="<?php echo base_url().$comparison->image_thumb ?>" alt="Product" />
                            </a>
                            <div class="dropdown-product-info media-body pl-3 pr-2">
                                <a class="dropdown-product-title cart-product-item fs-15" href="<?php echo base_url('product/'.remove_space($comparison->product_name).'/'.$comparison->product_id) ?>">
                                    <?php echo html_escape($comparison->product_name); ?>
                                </a>
                                <span class="dropdown-product-details fs-14 text-muted">
                                    <?php 
                                        $comparison_price = (($position == 0) ? $currency1 . ' ' . number_format($comparison->price, 2, '.', ',') : number_format($comparison->price, 2, '.', ',') . ' ' . $currency1);
                                        echo $comparison_price;
                                    ?>
                                    
                                </span>
                            </div>
                            <span class="dropdown-product-remove align-self-center text-primary remove_cart_product"> <a href="#" class="delete_comparison_item"  name="<?php echo $comparison->product_id ?>"><i class="ti-close"></i></a></span>
                        </div>
                        <?php endforeach; ?>
                        
                        <div class="row no-gutters toolbar-dropdown-group">
                            <div class="col pl-2"><a class="btn btn-block btn-success color4 color46" href="<?php echo base_url('comparison') ?>"><?php echo display('compare') ?></a></div>
                        </div>
                    </div>
                    <?php } ?>
                </div>

                <div class="dropdown ml-3" id="wishlist_area">
                    <?php
                    $total_wishlist = 0;
                    if ($this->session->userdata('customer_name')) {
                        $customer_id = $this->session->userdata('customer_id');
                        $this->db->select('a.*,b.*');
                        $this->db->from('wishlist a');
                        $this->db->join('product_information b', 'a.product_id=b.product_id');
                        $this->db->where('a.user_id', $customer_id);
                        $this->db->where('a.status', 1);
                        $query = $this->db->get();
                        $wishlists = $query->result();
                        $total_wishlist = count($wishlists);
                    }

                    ?>
                    <div class="navbar-tool dropdown-toggle" data-toggle="dropdown">
                        <a class="navbar-tool-icon-box bg-secondary" href="javascript:void(0)">
                             <span class="navbar-tool-label " id="wishlist_counter"><?php echo $total_wishlist; ?></span>
                              <i class="far fa-heart navbar-tool-icon"></i>
                        </a>
                        <a href="javascript:void(0)" class="navbar-tool-text"><small><?php echo display('favorites') ?></small><?php echo display('wishlist') ?></a>
                    </div>
                     
                     <?php   if ($total_wishlist > 0) { ?>
                    <div class="cart-dropdown dropdown-menu dropdown-menu-right shadow border-0 rounded px-3 pt-2 pb-3">
                       
                            <?php foreach ($wishlists as $wishlist): ?>
                        <div class="dropdown-product-item media py-2" id="wishlist_item_<?php echo $wishlist->product_id; ?>">
                            <a class="dropdown-product-thumb overflow-hidden bg-gray d-block" href="<?php echo base_url() . 'product_details/'.remove_space($wishlist->product_name).'/' . $wishlist->product_id ?>"><img src="<?php echo base_url().$wishlist->image_thumb; ?>" alt="Product" /></a>
                            <div class="dropdown-product-info media-body pl-3 pr-2">
                                <a class="dropdown-product-title  cart-product-item fs-15" href="<?php echo base_url() . 'product_details/'.remove_space($wishlist->product_name).'/' . $wishlist->product_id ?>"><?php echo html_escape($wishlist->product_name); ?></a>
                                <span class="dropdown-product-details fs-14 text-muted"><?php echo html_escape($wishlist->price); ?></span>
                            </div>
                            <span class="dropdown-product-remove align-self-center text-primary"> <a href="#" class="remove_wishlist"  name="<?php echo  html_escape($wishlist->product_id); ?>"><i class="ti-close"></i></a></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                        <?php } ?>
                </div>
                <div class="dropdown ml-3" id="tab_up_cart">
                    <div class="navbar-tool dropdown-toggle" data-toggle="dropdown">
                        <a class="navbar-tool-icon-box bg-secondary" href="javascript:void(0)"><span class="navbar-tool-label"><?php echo $this->cart->total_items() ?></span>
                            <i class="fas fa-cart-plus navbar-tool-icon"></i>
                        </a>
                        <a class="navbar-tool-text"  href="javascript:void(0)"><small><?php echo display('my_cart') ?></small> 
                         <?php

                         $cart_total = $this->cart->total()*$target_con_rate;
                        $cart_total_amt = (($position == 0) ? $currency1 . ' ' . number_format($cart_total, 2, '.', ',') : number_format($cart_total, 2, '.', ',') . ' ' . $currency1);
                         echo $cart_total_amt;
                          ?></a>
                    </div>
                    <?php if ($this->cart->contents()) {
                     ?>
                    <!-- Cart dropdown-->
                    <div class="cart-dropdown dropdown-menu dropdown-menu-right shadow border-0 rounded px-3 pt-2 pb-3">
                        <?php foreach ($this->cart->contents() as $items): ?>
                        <div class="dropdown-product-item media py-2">
                            <a class="dropdown-product-thumb overflow-hidden bg-gray d-block" href="<?php echo base_url('product/'.remove_space($items['name']).'/'.$items['product_id']) ?>"><img src="<?php echo base_url().$items['options']['image'] ?>" alt="Product" /></a>
                            <div class="dropdown-product-info media-body pl-3 pr-2">
                                <a class="dropdown-product-title cart-product-item fs-15" href="<?php echo base_url('product/'.remove_space($items['name']).'/'.$items['product_id']) ?>"><?php echo html_escape($items['name']); ?></a>
                                <span class="dropdown-product-details fs-14 text-muted"><?php echo $items['qty'] ?> x <?php echo(($position == 0) ? $currency1 . ' ' . $this->cart->format_number($items['price']*$target_con_rate) : $this->cart->format_number($items['price']*$target_con_rate) . ' ' . $currency1) ?></span>
                            </div>
                            <span class="dropdown-product-remove align-self-center text-primary remove_cart_product"> <a href="#" class="delete_cart_item"  name="<?php echo $items['rowid'] ?>"><i class="ti-close"></i></a></span>
                        </div>
                        <?php endforeach; ?>
                        
    
                        <div class="toolbar-dropdown-group d-flex justify-content-between font-weight-500 mb-2">
                            <div class="column"><span><?php echo display('total') ;?>:</span></div>
                            <div class="column"><span><?php echo $cart_total_amt;?> &nbsp;</span></div>
                        </div>
                        <div class="row no-gutters toolbar-dropdown-group">
                            <div class="col pr-2"><a class="btn btn-block btn-primary color4 color46" href="<?php echo base_url('view_cart') ?>"><?php echo display('view_cart') ?></a></div>
                            <div class="col pl-2"><a class="btn btn-block btn-success color4 color46" href="<?php echo base_url('checkout') ?>"><?php echo display('checkout') ?></a></div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <div class="navbar navbar-expand-lg navbar-light navbar-stuck-menu py-0 color3">
        <div class="container">
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <!--Navbar collapse header-->
                <div class="navbar-collapse-header">
                    <div class="row">
                        <div class="col-8 collapse-brand">
                            <a href="<?php echo base_url(); ?>">
                                <?php if (isset($Web_settings[0]['logo'])) { ?>
                                <img src="<?php echo base_url().$Web_settings[0]['logo'];?>" alt="Logo"><?php } ?>
                </a>
                        </div>
                        <div class="col-4 text-right">
                            <button type="button" class="collapse-close"><span></span><span></span></button>
                        </div>
                    </div>
                </div>
                <!-- Search-->
                <div class="input-group-overlay d-lg-none my-3">
                    <?php echo form_open('category_product_search',array('method'=> 'GET')) ?>
                    <div class="input-group-prepend-overlay">
                        <span class="input-group-text"><i data-feather="search"></i></span>
                    </div>
                    <input class="form-control prepended-form-control"  name="product_name" id="mobile_product_name"type="text" placeholder="Search for products" />
                    <?php echo form_close() ?>
                </div>
                <!-- Departments menu-->
                <ul class="navbar-nav mega-nav departments-nav pr-lg-2 mr-lg-2">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle pl-0" href="#" data-toggle="dropdown"> <i data-feather="grid" class="mr-2"></i><?php echo display('all_categories'); ?> </a>
                        <ul class="dropdown-menu">
                            <?php
                                if ($category_list) {
                                $i = 1;
                                foreach ($category_list as $parent_category) {
                                $sub_parent_cat = $this->db->select('*')
                                    ->from('product_category')
                                    ->where('parent_category_id', $parent_category->category_id)
                                    ->where('status','1')
                                    ->order_by('menu_pos')
                                    ->get()
                                    ->result();
                                if (10 == $i) {
                                break;
                                }
                                ?>

                            <li class="dropdown mega-dropdown">
                                <a class="dropdown-item  d-flex align-items-center" href="<?php echo base_url('category/p/' . remove_space($parent_category->category_name) . '/' . $parent_category->category_id) ?>" >
                                    <span class=""><img src="<?php echo base_url() . $parent_category->cat_favicon ?>" height="15"  width="16">&nbsp; </span> 
                                    <div> <?php echo html_escape($parent_category->category_name) ?></div>
                                </a>
                                <?php if ($sub_parent_cat) { ?>
                                <div class="dropdown-menu p-0">

                                    <div class="d-flex flex-wrap flex-md-nowrap position-relative px-lg-2">
                                        <?php 
                                        $ci=0;
                                        foreach ($sub_parent_cat as $parent_cat) { ?>
                                        <?php if($ci%2==0){ ?>
                                        <div class="mega-dropdown-column py-4 px-lg-3">
                                        <?php } ?>
                                            <div class="widget widget-links">
                                                <h6 class="mb-3"><a href="<?php echo base_url('category/p/' . remove_space($parent_cat->category_name) . '/' . $parent_cat->category_id) ?>"><?php echo html_escape($parent_cat->category_name) ?></a></h6>
                                                <ul class="widget-list">
                                                    <?php
                                                    $sub_cat = $this->db->select('*')
                                                        ->from('product_category')
                                                        ->where('parent_category_id', $parent_cat->category_id)
                                                        ->where('status','1')
                                                        ->order_by('menu_pos')
                                                        ->get()
                                                        ->result();
                                                    if ($sub_cat) {
                                                        foreach ($sub_cat as $s_p_cat) {
                                                            ?>

                                                    <li class="widget-list-item pb-1"><a class="widget-list-link" href="<?php echo base_url('category/p/' . remove_space($s_p_cat->category_name) . '/' . $s_p_cat->category_id) ?>"><?php echo html_escape($s_p_cat->category_name )?></a></li>
                                                     <?php
                                                    }
                                                }
                                                ?>
                                                </ul>
                                            </div>
                                        <?php if($ci%2==1){ ?>
                                        </div>
                                        <?php } ?>
                                        <?php $ci++; } ?>
                                    </div>
                                </div>
                                <?php } ?>
                            </li>
                            <?php
                            $i++;
                            }
                            }
                            ?>

                        </ul>
                    </li>
                </ul>
                <!-- Primary menu-->
                <ul class="navbar-nav">
                    <li class="nav-item <?php echo (($this->uri->segment(1)=='')?'active':'') ?>">
                        <a class="nav-link" href="<?php echo base_url(); ?>"><?php echo display('home') ?> <span class="sr-only">(current)</span></a>
                    </li>
                    <?php 
                    if (!empty($category_list)){
                    foreach ($category_list as $v_category_list){ 
                     if ($v_category_list->top_menu == 1) { ?>
                        <li class="nav-item <?php echo (($this->uri->segment(4)==$v_category_list->category_id)?'active':'') ?>">
                            <a class="nav-link" href="<?php echo base_url('/category/p/'.remove_space($v_category_list->category_name).'/' . $v_category_list->category_id) ?>"><?php echo
                                html_escape($v_category_list->category_name);
                                ?></a>
                        </li>
                    <?php } } } ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="modal register-modal" id="trackingModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0">
            <div class="modal-body">
                <button type="button" class="close position-absolute" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

                <div class="form-title_wrap mb-3">
                    <h4 class="form-title mb-0"><?php echo display('track_my_order') ?></h4>
                </div>
                <!--Login Form-->
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
</div>