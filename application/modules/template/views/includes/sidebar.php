<div class="sidebar color1">
<!-- Sidebar user panel -->
<div class="user-panel text-center">
<div class="image">
    <?php $image = $this->session->userdata('logo') ?>
    <img src="<?php echo base_url((!empty($image) ? $image : 'assets/img/icons/default.jpg')) ?>"
         class="img-circle" alt="User Image">
</div>
<div class="info">
    <p><?php echo $this->session->userdata('user_name') ?></p>
    <a href="#"><i class="fa fa-circle text-success"></i> <?php echo $this->session->userdata('user_level') ?>
    </a>
</div>
</div>


<!-- sidebar menu -->
<ul class="sidebar-menu">

<li class="treeview <?php echo(($this->uri->segment(3) == "home" || $this->uri->segment(3) == "home") ? "active" : null) ?>">
    <a href="<?php echo base_url('Admin_dashboard') ?>"><i class="ti-home"></i>
        <span><?php echo display('dashboard') ?></span>
    </a>
</li>


<?php if ($this->session->userdata('user_type') == 1 || $this->session->userdata('user_type') == 2) { ?>


    <!-- Invoice menu start -->
    <?php if ($this->permission->module('sales')->access()) { ?>
    <li class="treeview <?php if (in_array($this->uri->segment('3'),['new_invoice','manage_invoice','invoice_update_form','invoice_inserted_data','pos_invoice'])) { echo 'active';}?>">
        <a href="#">
            <i class="ti-layout-accordion-list"></i><span><?php echo display('sales') ?></span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <?php if ($this->permission->check_label('new_sale')->access()) { ?>
            <li class="<?php echo(($this->uri->segment(3) == 'new_invoice' ? 'active' : '')) ?>">
                <a href="<?php echo base_url('dashboard/Cinvoice/new_invoice') ?>"><?php echo display('new_sale') ?></a>
            </li>
            <?php } if ($this->permission->check_label('manage_sale')->access()) { ?>
            <li class="<?php echo(($this->uri->segment(3) == 'manage_invoice' || ($this->uri->segment(3) == 'invoice_inserted_data') ? 'active' : '')) ?>">
                <a href="<?php echo base_url('dashboard/Cinvoice/manage_invoice') ?>"><?php echo display('manage_sale') ?></a>
            </li>
            <?php } if ($this->permission->check_label('pos_sale')->access()) { ?>
            <li class="<?php echo(($this->uri->segment(3) == 'pos_invoice') ? 'active' : '') ?>">
                <a href="<?php echo base_url('dashboard/Cinvoice/pos_invoice') ?>"><?php echo display('pos_sale') ?></a>
            </li>
            <?php } ?>
        </ul>
    </li>
    <?php } ?>
    <!-- Invoice menu end -->

    <!-- Order menu start -->
    <?php if ($this->permission->module('order')->access()) { ?>
    <li class="treeview <?php echo (($this->uri->segment(2) == "Corder")?"active":'')?>">
        <a href="#">
            <i class="ti-truck"></i><span><?php echo display('order') ?></span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <?php if ($this->permission->check_label('new_order')->access()) { ?>
            <li class="<?php echo(($this->uri->segment(3) == 'new_order' ? 'active' : '')) ?>"><a href="<?php echo base_url('dashboard/Corder/new_order') ?>"><?php echo display('new_order') ?></a>
            </li>
            <?php } if ($this->permission->check_label('manage_order')->access()) { ?>
            <li class="<?php echo(($this->uri->segment(3) == 'manage_order' ? 'active' : '')) ?>">
                <a href="<?php echo base_url('dashboard/Corder/manage_order') ?>"><?php echo display('manage_order') ?></a>
            </li>
            <?php } ?>
        </ul>
    </li>
    <?php } ?>
    <!-- Order menu end -->

    <!-- Product menu start -->
    <?php if ($this->permission->module('product')->access()) { ?>
    <li class="treeview <?php if ($this->uri->segment(2) == ("Cproduct")) {
        echo "active";
    } else {
        echo " ";
    } ?>">
        <a href="#">
            <i class="ti-bag"></i><span><?php echo display('product')?></span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <?php if ($this->permission->check_label('add_product')->access()) { ?>
            <li class="<?php echo(($this->uri->segment(2) == 'Cproduct' && ($this->uri->segment(3) == '') ? 'active' : '')) ?>">
                <a href="<?php echo base_url('dashboard/Cproduct') ?>"><?php echo display('add_product') ?></a>
            </li>
            <?php } if ($this->permission->check_label('import_product_csv')->access()) { ?>
            <li class="<?php echo(($this->uri->segment(3) == 'add_product_csv' ? 'active' : '')) ?>">
                <a href="<?php echo base_url('dashboard/Cproduct/add_product_csv') ?>"><?php echo display('import_product_csv') ?></a>
            </li>
            <?php } if ($this->permission->check_label('manage_product')->access()) { ?>
            <li class="<?php echo(($this->uri->segment(3) == 'manage_product' ? 'active' : '')) ?>">
                <a href="<?php echo base_url('dashboard/Cproduct/manage_product') ?>"><?php echo display('manage_product') ?></a>
            </li>
            <?php } if ($this->permission->check_label('product_ledger')->access()) { ?>
            <li class="<?php echo(($this->uri->segment(3) == 'product_details_single' ? 'active' : '')) ?>">
                <a href="<?php echo base_url('dashboard/Cproduct/product_details_single') ?>"><?php echo display('product_ledger') ?></a>
            </li>
            <?php } ?>
        </ul>
    </li>
    <?php } ?>
    <!-- Product menu end -->

    <!-- Customer menu start -->
    <?php if ($this->permission->module('customer')->access()) { ?>
    <li class="treeview <?php if ($this->uri->segment(2) == ("Ccustomer")) {
        echo "active";
    } else {
        echo " ";
    } ?>">
        <a href="#">
            <i class="fa fa-handshake-o"></i><span><?php echo display('customer') ?></span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <?php if ($this->permission->check_label('add_customer')->access()) { ?>
            <li class="<?php echo(($this->uri->segment(2) == 'Ccustomer' && ($this->uri->segment(3) == '') ? 'active' : '')) ?>">
                <a href="<?php echo base_url('dashboard/Ccustomer') ?>"><?php echo display('add_customer') ?></a>
            </li>
            <?php } if ($this->permission->check_label('manage_customer')->access()) { ?>
            <li class="<?php echo(($this->uri->segment(3) == 'manage_customer' ? 'active' : '')) ?>">
                <a href="<?php echo base_url('dashboard/Ccustomer/manage_customer') ?>"><?php echo display('manage_customer') ?></a>
            </li>
            <?php } if ($this->permission->check_label('customer_ledger')->access()) { ?>
            <li class="<?php echo(($this->uri->segment(3) == 'customer_ledger_report' ? 'active' : '')) ?>">
                <a href="<?php echo base_url('dashboard/Ccustomer/customer_ledger_report') ?>"><?php echo display('customer_ledger') ?></a>
            </li>
            <?php } ?>
        </ul>
    </li>
    <?php } ?>
    <!-- Customer menu end -->

    <!-- Supplier menu start -->
    <?php if ($this->permission->module('supplier')->access()) { ?>
    <li class="treeview <?php if ($this->uri->segment(2) == ("Csupplier")) {
        echo "active";
    } else {
        echo " ";
    } ?>">
        <a href="#">
            <i class="ti-user"></i><span><?php echo display('supplier') ?></span>
            <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
        </a>
        <ul class="treeview-menu">
            <?php if ($this->permission->check_label('add_supplier')->access()) { ?>
            <li class="<?php echo(($this->uri->segment(2) == 'Csupplier' && ($this->uri->segment(3) == '') ? 'active' : '')) ?>">
                <a href="<?php echo base_url('dashboard/Csupplier') ?>"><?php echo display('add_supplier') ?></a>
            </li>
            <?php } if ($this->permission->check_label('manage_supplier')->access()) { ?>
            <li class="<?php echo(($this->uri->segment(3) == 'manage_supplier' ? 'active' : '')) ?>">
                <a href="<?php echo base_url('dashboard/Csupplier/manage_supplier') ?>"><?php echo display('manage_supplier') ?></a>
            </li>
            <?php } if ($this->permission->check_label('supplier_ledger')->access()) { ?>
            <li class="<?php echo(($this->uri->segment(3) == 'supplier_ledger_report' ? 'active' : '')) ?>">
                <a href="<?php echo base_url('dashboard/Csupplier/supplier_ledger_report') ?>"><?php echo display('supplier_ledger') ?></a>
            </li>
            <?php } ?>
        </ul>
    </li>
    <?php } ?>
    <!-- Supplier menu end -->

    <!-- Purchase menu start -->
    <?php if ($this->permission->module('purchase')->access()) { ?>
    <li class="treeview <?php if ($this->uri->segment(2) == ("Cpurchase")) {
        echo "active";
    } else {
        echo " ";
    } ?>">
        <a href="#">
            <i class="ti-shopping-cart"></i><span><?php echo display('purchase') ?></span>
            <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
        </a>
        <ul class="treeview-menu">
            <?php if ($this->permission->check_label('add_purchase')->access()) { ?>
            <li class="<?php echo(($this->uri->segment(2) == 'Cpurchase' && ($this->uri->segment(3) == '') ? 'active' : '')) ?>">
                <a href="<?php echo base_url('dashboard/Cpurchase') ?>"><?php echo display('add_purchase') ?></a>
            </li>
            <?php } if ($this->permission->check_label('manage_purchase')->access()) { ?>
            <li class="<?php echo(($this->uri->segment(3) == 'manage_purchase' ? 'active' : '')) ?>">
                <a href="<?php echo base_url('dashboard/Cpurchase/manage_purchase') ?>"><?php echo display('manage_purchase') ?></a>
            </li>
            <?php } ?>
        </ul>
    </li>
    <?php } ?>
    <!-- Purchase menu end -->

    <!-- Category menu start -->
    <?php if ($this->permission->module('category')->access()) { ?>
    <li class="treeview <?php if ($this->uri->segment(2) == ("Ccategory")) {
        echo "active";
    } else {
        echo " ";
    } ?>">
        <a href="#">
            <i class="ti-tag"></i><span><?php echo display('category') ?></span>
            <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
        </a>
        <ul class="treeview-menu">
            <?php if ($this->permission->check_label('add_category')->access()) { ?>
            <li class="<?php echo(($this->uri->segment(2) == 'Ccategory' && ($this->uri->segment(3) == '') ? 'active' : '')) ?>">
                <a href="<?php echo base_url('dashboard/Ccategory') ?>"><?php echo display('add_category') ?></a>
            </li>
            <?php } if ($this->permission->check_label('import_category_csv')->access()) { ?>
            <li class="<?php echo(($this->uri->segment(3) == 'add_category_csv' ? 'active' : '')) ?>">
                <a href="<?php echo base_url('dashboard/Ccategory/add_category_csv') ?>"><?php echo display('import_category_csv') ?></a>
            </li>
            <?php } if ($this->permission->check_label('manage_category')->access()) { ?>
            <li class="<?php echo(($this->uri->segment(3) == 'manage_category' ? 'active' : '')) ?>">
                <a href="<?php echo base_url('dashboard/Ccategory/manage_category') ?>"><?php echo display('manage_category') ?></a>
            </li>
            <?php } ?>
        </ul>
    </li>
    <?php } ?>
    <!-- Category menu end -->

    <!-- Brand menu start -->
    <?php if ($this->permission->module('brand')->access()) { ?>
    <li class="treeview <?php if ($this->uri->segment(2) == ("Cbrand")) {
        echo "active";
    } else {
        echo " ";
    } ?>">
        <a href="#">
            <i class="ti-apple"></i><span><?php echo display('brand') ?></span>
            <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
        </a>
        <ul class="treeview-menu">
            <?php if ($this->permission->check_label('add_brand')->access()) { ?>
            <li class="<?php echo(($this->uri->segment(2) == 'Cbrand' && ($this->uri->segment(3) == '') ? 'active' : '')) ?>">
                <a href="<?php echo base_url('dashboard/Cbrand') ?>"><?php echo display('add_brand') ?></a></li>
            <?php } if ($this->permission->check_label('manage_brand')->access()) { ?>
            <li class="<?php echo(($this->uri->segment(3) == 'manage_brand' ? 'active' : '')) ?>">
                <a href="<?php echo base_url('dashboard/Cbrand/manage_brand') ?>"><?php echo display('manage_brand') ?></a>
            </li>
            <?php } ?>
        </ul>
    </li>
    <?php } ?>
    <!-- Brand menu end -->


    <!-- Variant menu start -->
    <?php if ($this->permission->module('variant')->access()) { ?>
    <li class="treeview <?php if ($this->uri->segment(2) == ("Cvariant")) {
        echo "active";
    } else {
        echo " ";
    } ?>">
        <a href="#">
            <i class="ti-wand"></i><span><?php echo display('variant') ?></span>
            <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
        </a>
        <ul class="treeview-menu">
            <?php if ($this->permission->check_label('add_variant')->access()) { ?>
            <li class="<?php echo(($this->uri->segment(2) == 'Cvariant' && ($this->uri->segment(3) == '') ? 'active' : '')) ?>">
                <a href="<?php echo base_url('dashboard/Cvariant') ?>"><?php echo display('add_variant') ?></a>
            </li>
            <?php } if ($this->permission->check_label('manage_variant')->access()) { ?>
            <li class="<?php echo(($this->uri->segment(3) == 'manage_variant' ? 'active' : '')) ?>">
                <a href="<?php echo base_url('dashboard/Cvariant/manage_variant') ?>"><?php echo display('manage_variant') ?></a>
            </li>
            <?php } ?>
        </ul>
    </li>
    <?php } ?>
    <!-- Variant menu end -->

    <!-- Unit menu start -->
    <?php if ($this->permission->module('unit')->access()) { ?>
    <li class="treeview <?php if ($this->uri->segment(2) == ("Cunit")) {
        echo "active";
    } else {
        echo " ";
    } ?>">
        <a href="#">
            <i class="ti-ruler-pencil"></i><span><?php echo display('Unit') ?></span>
            <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
        </a>
        <ul class="treeview-menu">
            <?php if ($this->permission->check_label('add_unit')->access()) { ?>
            <li class="<?php echo(($this->uri->segment(2) == 'Cunit' && ($this->uri->segment(3) == '') ? 'active' : '')) ?>">
                <a href="<?php echo base_url('dashboard/Cunit') ?>"><?php echo display('add_unit') ?></a></li>
            <?php } if ($this->permission->check_label('manage_unit')->access()) { ?>
            <li class="<?php echo(($this->uri->segment(3) == 'manage_unit' ? 'active' : '')) ?>">
                <a href="<?php echo base_url('dashboard/Cunit/manage_unit') ?>"><?php echo display('manage_unit') ?></a>
            </li>
            <?php } ?>
        </ul>
    </li>
    <?php } ?>
    <!-- Unit menu end -->

    <!-- Gallery menu start -->
    <?php if ($this->permission->module('product_image_gallery')->access()) { ?>
    <li class="treeview <?php if ($this->uri->segment(2) == ("Cgallery")) {
        echo "active";
    } else {
        echo " ";
    } ?>">
        <a href="#">
            <i class="ti-gallery"></i><span><?php echo display('product_image_gallery') ?></span>
            <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
        </a>
        <ul class="treeview-menu">
            <?php if ($this->permission->check_label('add_product_image')->access()) { ?>
            <li class="<?php echo(($this->uri->segment(2) == 'Cgallery' && ($this->uri->segment(3) == '') ? 'active' : '')) ?>">
                <a href="<?php echo base_url('dashboard/Cgallery') ?>"><?php echo display('add_product_image') ?></a>
            </li>
            <?php } if ($this->permission->check_label('manage_product_image')->access()) { ?>
            <li class="<?php echo(($this->uri->segment(3) == 'manage_image' ? 'active' : '')) ?>">
                <a href="<?php echo base_url('dashboard/Cgallery/manage_image') ?>"><?php echo display('manage_product_image') ?></a>
            </li>
            <?php } ?>
        </ul>
    </li>
    <?php } ?>
    <!-- Gallery menu end -->
    <!-- Tax menu start -->
    <?php if ($this->permission->module('tax')->access()) { ?>
    <li class="treeview <?php if ($this->uri->segment(2) == ("Ctax")) {
        echo "active";
    } else {
        echo " ";
    } ?>">
        <a href="#">
            <i class="ti-target"></i><span><?php echo display('tax') ?></span>
            <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
        </a>
        <ul class="treeview-menu">
            <?php  if ($this->permission->check_label('tax_product_service')->access()) { ?>
            <li class="<?php echo(($this->uri->segment(3) == 'tax_product_service' ? 'active' : '')) ?>">
                <a href="<?php echo base_url('dashboard/Ctax/tax_product_service') ?>"><?php echo display('tax_product_service') ?></a>
            </li>
            <?php } if ($this->permission->check_label('manage_product_tax')->access()) { ?>
            <li class="<?php echo(($this->uri->segment(3) == 'manage_tax' ? 'active' : '')) ?>">
                <a href="<?php echo base_url('dashboard/Ctax/manage_tax') ?>"><?php echo display('manage_product_tax') ?></a>
            </li>
            <?php } if ($this->permission->check_label('tax_setting')->access()) { ?>
            <li class="<?php echo(($this->uri->segment(3) == 'tax_setting' ? 'active' : '')) ?>">
                <a href="<?php echo base_url('dashboard/Ctax/tax_setting') ?>"><?php echo display('tax_setting') ?></a>
            </li>
            <?php } ?>
        </ul>
    </li>
    <?php } ?>
    <!-- Tax menu end -->

    <!-- Currency menu start -->
    <?php if ($this->permission->module('currency')->access()) { ?>
    <li class="treeview <?php if ($this->uri->segment(2) == ("Ccurrency")) {
        echo "active";
    } else {
        echo " ";
    } ?>">
        <a href="#">
            <i class="ti-money"></i><span><?php echo display('currency') ?></span>
            <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
        </a>
        <ul class="treeview-menu">
            <?php  if ($this->permission->check_label('add_currency')->access()) { ?>
            <li class="<?php echo(($this->uri->segment(2) == 'Ccurrency' && ($this->uri->segment(3) == '') ? 'active' : '')) ?>">
                <a href="<?php echo base_url('dashboard/Ccurrency') ?>"><?php echo display('add_currency') ?></a>
            </li>
            <?php } if ($this->permission->check_label('manage_currency')->access()) { ?>
            <li class="<?php echo(($this->uri->segment(3) == 'manage_currency' ? 'active' : '')) ?>">
                <a href="<?php echo base_url('dashboard/Ccurrency/manage_currency') ?>"><?php echo display('manage_currency') ?></a>
            </li>
            <?php } ?>
        </ul>
    </li>
    <?php } ?>
    <!-- Currency menu end -->

    <!-- Store set menu start -->
    <?php if ($this->permission->module('store')->access()) { ?>
    <li class="treeview <?php if ($this->uri->segment(2) == ("Cstore")) {
        echo "active";
    } else {
        echo " ";
    } ?>">
        <a href="#">
            <i class="ti-truck"></i><span><?php echo display('store') ?></span>
            <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
        </a>
        <ul class="treeview-menu">
            <?php if ($this->permission->check_label('store_add')->access()) { ?>
            <li class="<?php echo(($this->uri->segment(2) == 'Cstore' && ($this->uri->segment(3) == '') ? 'active' : '')) ?>">
                <a href="<?php echo base_url('dashboard/Cstore') ?>"><?php echo display('store_add') ?></a></li>
            <?php } if ($this->permission->check_label('import_store_csv')->access()) { ?>
            <li class="<?php echo(($this->uri->segment(3) == 'add_store_csv' ? 'active' : '')) ?>">
                <a href="<?php echo base_url('dashboard/Cstore/add_store_csv') ?>"><?php echo display('import_store_csv') ?></a>
            </li>
            <?php } if ($this->permission->check_label('manage_store')->access()) { ?>
            <li class="<?php echo(($this->uri->segment(3) == 'manage_store' ? 'active' : '')) ?>">
                <a href="<?php echo base_url('dashboard/Cstore/manage_store') ?>"><?php echo display('manage_store') ?></a>
            </li>
            <?php } if ($this->permission->check_label('store_transfer')->access()) { ?>
            <li class="<?php echo(($this->uri->segment(3) == 'store_transfer' ? 'active' : '')) ?>">
                <a href="<?php echo base_url('dashboard/Cstore/store_transfer') ?>"><?php echo display('store_transfer') ?></a>
            </li>
            <?php } if ($this->permission->check_label('manage_store_product')->access()) { ?>
            <li class="<?php echo(($this->uri->segment(3) == 'manage_store_product' ? 'active' : '')) ?>">
                <a href="<?php echo base_url('dashboard/Cstore/manage_store_product') ?>"><?php echo display('manage_store_product') ?></a>
            </li>
            <?php } ?>
        </ul>
    </li>
    <?php } ?>
    <!-- Store set menu end -->


    <!-- *************************************
    **********STATS OF CUSTOM MODULES*********
    ************************************* -->
    <?php
    $path = 'application/modules/';
    $map = directory_map($path);
    $HmvcMenu = array();
    if (is_array($map) && sizeof($map) > 0){
        foreach ($map as $key => $value) {
            $menu = str_replace("\\", '/', $path . $key . 'config/menu.php');
            if (file_exists($menu)) {
                @include($menu);
            }
        }
    }

    if (isset($HmvcMenu) && $HmvcMenu != null && sizeof($HmvcMenu) > 0){
        foreach ($HmvcMenu as $moduleName => $moduleData) {

            // check module permission
            if (file_exists(APPPATH . 'modules/' . $moduleName . '/assets/data/env')){
                    ?>
                    <li class="treeview <?php echo(($this->uri->segment(2) == $moduleName) ? "active" : null) ?>">
                        <a href="#">
                            <?php echo(($moduleData['icon'] != null) ? $moduleData['icon'] : null) ?>
                            <span><?php echo display($moduleName) ?></span>
                            <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                        </a>

                        <ul class="treeview-menu">
                            <?php foreach ($moduleData as $groupLabel => $label) { ?>
                                <?php
                                if ($groupLabel != 'icon')
                                    if ((isset($label['controller']) && $label['controller'] != null) && ($label['method'] != null)) {
                                        if ($this->permission->method($moduleName, $label['permission'])->access()) {
                                            ?>

                                            <!-- single level menu/link -->
                                            <li class="<?php echo(($this->uri->segment(2) == $moduleName && $this->uri->segment(3) == $label['controller']) ? "active" : null) ?>">
                                                <a href="<?php echo base_url($moduleName . "/" . $label['controller'] . "/" . $label['method']) ?>"><?php echo display($groupLabel) ?></a>
                                            </li>

                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <!-- extract $label to compare with segment -->
                                        <?php foreach ($label as $url) ?>
                                            <li class="<?php echo(($this->uri->segment(3) == $url['controller']) ? "active" : null) ?>">
                                        <a href="#"><?php echo display($groupLabel) ?>
                                            <span class="pull-right-container"><i
                                                        class="fa fa-angle-left pull-right"></i></span>
                                        </a>
                                        <ul class="treeview-menu <?php echo(($this->uri->segment(3) == $url['controller']) ? "menu-open" : null) ?>">
                                            <?php
                                            foreach ($label as $name => $value) {
                                                if ($this->permission->method($moduleName, $value['permission'])->access()) {
                                                    ?>
                                                    <li class="<?php echo(($this->uri->segment(4) == $value['method']) ? "active" : null) ?>">
                                                        <a href="<?php echo base_url($moduleName . "/" . $value['controller'] . "/" . $value['method']) ?>"><?php echo display($name) ?></a>
                                                    </li>
                                                    <?php
                                                } //endif
                                            } //endforeach
                                            ?>
                                        </ul>
                                        </li>

                                        <!-- endif -->
                                    <?php } ?>
                                <!-- endforeach -->
                            <?php } ?>
                        </ul>
                    </li>
                    <!-- end if -->
            <!-- end foreach -->
        <?php } } } ?>

    <!-- *************************************
    **********ENDS OF CUSTOM MODULES*********
    ************************************* -->


    <!-- Stock menu start -->
    <?php if ($this->permission->module('stock')->access()) { ?>
    <li class="treeview <?php if ($this->uri->segment(2) == ("Creport")) {
        echo "active";
    } else {
        echo " ";
    } ?>">
        <a href="#">
            <i class="ti-bar-chart"></i><span><?php echo display('stock') ?></span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <?php if ($this->permission->check_label('stock_report')->access()) { ?>
            <li class="<?php echo(($this->uri->segment(2) == 'Creport' && ($this->uri->segment(3) == '') ? 'active' : '')) ?>">
                <a href="<?php echo base_url('dashboard/Creport') ?>"><?php echo display('stock_report') ?></a>
            </li>
            <?php } if ($this->permission->check_label('stock_report_supplier_wise')->access()) { ?>
            <li class="<?php echo(($this->uri->segment(3) == 'stock_report_supplier_wise' ? 'active' : '')) ?>">
                <a href="<?php echo base_url('dashboard/Creport/stock_report_supplier_wise') ?>"><?php echo display('stock_report_supplier_wise') ?></a>
            </li>
            <?php } if ($this->permission->check_label('stock_report_product_wise')->access()) { ?>
            <li class="<?php echo(($this->uri->segment(3) == 'stock_report_product_wise' ? 'active' : '')) ?>">
                <a href="<?php echo base_url('dashboard/Creport/stock_report_product_wise') ?>"><?php echo display('stock_report_product_wise') ?></a>
            </li>
            <?php } if ($this->permission->check_label('stock_report_store_wise')->access()) { ?>
            <li class="<?php echo(($this->uri->segment(3) == 'stock_report_store_wise' ? 'active' : '')) ?>">
                <a href="<?php echo base_url('dashboard/Creport/stock_report_store_wise') ?>"><?php echo display('stock_report_store_wise') ?></a>
            </li>
            <?php } ?>
        </ul>
    </li>
    <?php } ?>
    <!-- Stock menu end -->

        <!-- Bank menu start -->
        <?php if ($this->permission->module('bank')->access()) { ?>
        <li class="treeview <?php if ($this->uri->segment(2) == ("Csettings")) {
            echo "active";
        } else {
            echo " ";
        } ?>">
            <a href="#">
                <i class="ti-briefcase"></i><span><?php echo display('bank') ?></span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <?php if ($this->permission->check_label('add_new_bank')->access()) { ?>
                <li class="<?php echo(($this->uri->segment(2) == 'Csettings' && ($this->uri->segment(3) == '') ? 'active' : '')) ?>">
                    <a href="<?php echo base_url('dashboard/Csettings') ?>"><?php echo display('add_new_bank') ?></a>
                </li>
                <?php } if ($this->permission->check_label('manage_bank')->access()) { ?>
                <li class="<?php echo(($this->uri->segment(3) == 'bank_list' ? 'active' : '')) ?>">
                    <a href="<?php echo base_url('dashboard/Csettings/bank_list') ?>"><?php echo display('manage_bank') ?></a>
                </li>
                <?php } ?>
            </ul>
        </li>
        <?php } ?>
        <!-- Bank menu end -->


        <!-- Accounts menu start -->
        <?php if ($this->permission->module('accounts')->access()) { ?>
        <li class="treeview <?php if ($this->uri->segment(2) == ("Caccounts")) {
            echo "active";
        } else {
            echo " ";
        } ?>">
            <a href="#">
                <i class="ti-pencil-alt"></i><span><?php echo display('accounts') ?></span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <?php if ($this->permission->check_label('create_accounts')->access()) { ?>
                <li class="<?php echo(($this->uri->segment(3) == 'create_account' ? 'active' : '')) ?>">
                    <a href="<?php echo base_url('dashboard/Caccounts/create_account') ?>"><?php echo display('create_accounts') ?> </a>
                </li>
                <?php } if ($this->permission->check_label('manage_accounts')->access()) { ?>
                <li class="<?php echo(($this->uri->segment(3) == 'manage_account' ? 'active' : '')) ?>">
                    <a href="<?php echo base_url('dashboard/Caccounts/manage_account') ?>"><?php echo display('manage_accounts') ?> </a>
                </li>
                <?php } if ($this->permission->check_label('received')->access()) { ?>
                <li class="<?php echo(($this->uri->segment(2) == 'Caccounts' && ($this->uri->segment(3) == '') ? 'active' : '')) ?>">
                    <a href="<?php echo base_url('dashboard/Caccounts') ?>"><?php echo display('received') ?></a>
                </li>
                <?php } if ($this->permission->check_label('payment')->access()) { ?>
                <li class="<?php echo(($this->uri->segment(3) == 'outflow' ? 'active' : '')) ?>">
                    <a href="<?php echo base_url('dashboard/Caccounts/outflow') ?>"><?php echo display('payment') ?></a>
                </li>
                <?php } if ($this->permission->check_label('accounts_summary')->access()) { ?>
                <li class="<?php echo(($this->uri->segment(3) == 'summary' ? 'active' : '')) ?>">
                    <a href="<?php echo base_url('dashboard/Caccounts/summary') ?>"><?php echo display('accounts_summary') ?></a>
                </li>
                <?php } if ($this->permission->check_label('cheque_manager')->access()) { ?>
                <li class="<?php echo(($this->uri->segment(3) == 'cheque_manager' ? 'active' : '')) ?>">
                    <a href="<?php echo base_url('dashboard/Caccounts/cheque_manager') ?>"><?php echo display('cheque_manager') ?></a>
                </li>
                <?php } if ($this->permission->check_label('closing')->access()) { ?>
                <li class="<?php echo(($this->uri->segment(3) == 'closing' ? 'active' : '')) ?>">
                    <a href="<?php echo base_url('dashboard/Caccounts/closing') ?>"><?php echo display('closing') ?></a>
                </li>
                <?php } if ($this->permission->check_label('closing_report')->access()) { ?>
                <li class="<?php echo(($this->uri->segment(3) == 'closing_report' ? 'active' : '')) ?>">
                    <a href="<?php echo base_url('dashboard/Caccounts/closing_report') ?>"><?php echo display('closing_report') ?></a>
                </li>
                <?php } ?>
            </ul>
        </li>
        <?php } ?>
        <!-- Accounts menu end -->

        <!-- Report menu start -->
        <?php if ($this->permission->module('report')->access()) { ?>
        <li class="treeview <?php if ($this->uri->segment(3) == ("retrieve_dateWise_SalesReports") || $this->uri->segment(3) == ("todays_sales_report") || $this->uri->segment(3) == ("todays_purchase_report") || $this->uri->segment(3) == ("sales_report_store_wise") || $this->uri->segment(3) == ("retrieve_sales_report_store_wise") || $this->uri->segment(3) == ("transfer_report") || $this->uri->segment(3) == ("product_sales_reports_date_wise") || $this->uri->segment(3) == ("total_profit_report") || $this->uri->segment(3) == ("retrieve_dateWise_profit_report") || $this->uri->segment(3) == ("tax_report_product_wise") || $this->uri->segment(3) == ("tax_report_invoice_wise") || $this->uri->segment(3) == ("store_to_store_transfer") || $this->uri->segment(3) == ('retrieve_dateWise_PurchaseReports')) {
            echo "active";
        } else {
            echo " ";
        } ?>">
            <a href="#">
                <i class="ti-book"></i><span><?php echo display('report') ?></span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <?php if ($this->permission->check_label('sales_report')->access()) { ?>
                <li class="<?php echo(($this->uri->segment(3) == 'todays_sales_report' || ($this->uri->segment(3) == 'retrieve_dateWise_SalesReports') ? 'active' : '')) ?>">
                    <a href="<?php echo base_url('dashboard/Admin_dashboard/todays_sales_report') ?>"><?php echo display('sales_report') ?></a>
                </li>
                <?php } if ($this->permission->check_label('sales_report_store_wise')->access()) { ?>
                <li class="<?php echo(($this->uri->segment(3) == 'sales_report_store_wise' || ($this->uri->segment(3) == 'retrieve_sales_report_store_wise') ? 'active' : '')) ?>">
                    <a href="<?php echo base_url('dashboard/Admin_dashboard/sales_report_store_wise') ?>"><?php echo display('sales_report_store_wise') ?></a>
                </li>
                <?php } if ($this->permission->check_label('purchase_report')->access()) { ?>
                <li class="<?php echo(($this->uri->segment(3) == 'todays_purchase_report' || $this->uri->segment(3) == ('retrieve_dateWise_PurchaseReports') ? 'active' : '')) ?>">
                    <a href="<?php echo base_url('dashboard/Admin_dashboard/todays_purchase_report') ?>"><?php echo display('purchase_report') ?></a>
                </li>
                <?php } if ($this->permission->check_label('transfer_report')->access()) { ?>
                <li class="<?php if ($this->uri->segment(3) == ("store_to_store_transfer") || $this->uri->segment(3) == ("store_to_warehouse_transfer") || $this->uri->segment(3) == ("warehouse_to_warehouse_transfer") || $this->uri->segment(3) == ("warehouse_to_store_transfer")) {
                    echo "active";
                } else {
                    echo " ";
                } ?>">
                    <a href="javascript:void(0)"><?php echo display('transfer_report') ?>
                        <span class="pull-right-container"><i
                                    class="fa fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="<?php echo(($this->uri->segment(3) == 'store_to_store_transfer' ? 'active' : '')) ?>">
                            <a href="<?php echo base_url('dashboard/Admin_dashboard/store_to_store_transfer') ?>"><?php echo display('store_to_store_transfer') ?></a>
                        </li>

                    </ul>
                </li>
                <?php } if ($this->permission->check_label('tax_report_product_wise')->access()) { ?>
                <li class="<?php echo(($this->uri->segment(3) == 'tax_report_product_wise' ? 'active' : '')) ?>">
                    <a href="<?php echo base_url('dashboard/Admin_dashboard/tax_report_product_wise') ?>"><?php echo display('tax_report_product_wise') ?></a>
                </li>
                <?php } if ($this->permission->check_label('tax_report_invoice_wise')->access()) { ?>
                <li class="<?php echo(($this->uri->segment(3) == 'tax_report_invoice_wise' ? 'active' : '')) ?>">
                    <a href="<?php echo base_url('dashboard/Admin_dashboard/tax_report_invoice_wise') ?>"><?php echo display('tax_report_invoice_wise') ?></a>
                </li>
                <?php } ?>
            </ul>
        </li>
        <?php } ?>
        <!-- Report menu end -->
       
        <!-- pay with method menu start -->
        <?php if ($this->permission->module('pay_with')->access()) { ?>
        <li class="treeview <?php if ($this->uri->segment(2) == ("Cpay_with")) {
            echo "active";
        } else {
            echo " ";
        } ?>">
            <a href="#">
                <i class="ti-settings"></i><span><?php echo display('pay_with') ?></span>
                <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu">
                <?php if ($this->permission->check_label('manage_pay_with')->access()) { ?>
                <li class="<?php echo(($this->uri->segment(2) == 'Cpay_with' && ($this->uri->segment(3) == '') ? 'active' : '')) ?>">
                    <a href="<?php echo base_url('dashboard/Cpay_with') ?>"><?php echo display('manage_pay_with') ?> </a>
                </li>
                <?php } ?>
            </ul>
        </li>
        <?php } ?>

        <!-- States menu start -->
        <?php if ($this->permission->module('states')->access()) { ?>
        <li class="treeview <?php if ($this->uri->segment(2) == ("cstate")) {
            echo "active";
            } else {
                echo " ";
            } ?>">
            <a href="#">
                <i class="ti-location-pin"></i><span><?php echo display('states') ?></span>
                <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu">
                <?php if ($this->permission->check_label('add_state')->access()) { ?>
                <li class="<?php echo(($this->uri->segment(3) == 'state_add') ? 'active' : '') ?>">
                    <a href="<?php echo base_url('dashboard/cstate/state_add') ?>"><?php echo display('add_state') ?> </a>
                </li>
                <?php } if ($this->permission->check_label('manage_states')->access()) { ?>
                <li class="<?php echo ((($this->uri->segment(2) == 'cstate') &&($this->uri->segment(3) == '')) ? 'active' : '') ?>">
                    <a href="<?php echo base_url('dashboard/cstate') ?>"><?php echo display('manage_states') ?> </a>
                </li>
                <?php } ?>
            </ul>
        </li>
        <?php } ?>
        <!-- End of menu state -->

        <!-- Delivery system menu start -->
        <?php if ($this->permission->module('delivery_system')->access()) { ?>
        <li class="treeview <?php echo (($this->uri->segment(2) == 'cdelivery_system') ? 'active' : '') ?>">
            <a href="#">
                <i class="fa fa-truck"></i><span><?php echo display('delivery_system') ?></span>
                <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu">
                <?php if ($this->permission->check_label('delivery_boy')->access()) { ?>
                <li class="treeview <?php echo (in_array($this->uri->segment(3), ['add_delivery_boy','index']) ? 'active' : '') ?>">
                    <a href="#">
                        <span><?php echo display('delivery_boy') ?></span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <?php if ($this->permission->check_label('add_delivery_boy')->create()->access()) { ?>
                        <li class="<?php echo (($this->uri->segment(3) == 'add_delivery_boy') ? 'active' : '') ?>">
                            <a href="<?php echo base_url('dashboard/cdelivery_system/add_delivery_boy') ?>"><?php echo display('add_delivery_boy') ?></a>
                        </li>
                        <?php } if ($this->permission->check_label('manage_delivery_boy')->access()) { ?>
                        <li class="<?php echo (($this->uri->segment(3) == 'index') ? 'active' : '') ?>">
                            <a href="<?php echo base_url('dashboard/cdelivery_system/index') ?>"><?php echo display('manage_delivery_boy') ?></a>
                        </li>
                        <?php }  ?>
                    </ul>
                </li>
                <?php } ?>

                <?php if ($this->permission->check_label('delivery_slot')->access()) { ?>
                <li class="treeview <?php echo (in_array($this->uri->segment(3), ['add_time_slot','manage_time_slot']) ? 'active' : '') ?>">
                    <a href="#">
                        <span><?php echo display('delivery_slot') ?></span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <?php if ($this->permission->check_label('add_time_slot')->create()->access()) { ?>
                        <li class="<?php echo (($this->uri->segment(3) == 'add_time_slot') ? 'active' : '') ?>">
                            <a href="<?php echo base_url('dashboard/cdelivery_system/add_time_slot') ?>"><?php echo display('add_time_slot') ?></a>
                        </li>
                        <?php } if ($this->permission->check_label('manage_time_slot')->access()) { ?>
                        <li class="<?php echo (($this->uri->segment(3) == 'manage_time_slot') ? 'active' : '') ?>">
                            <a href="<?php echo base_url('dashboard/cdelivery_system/manage_time_slot') ?>"><?php echo display('manage_time_slot') ?> </a>
                        </li>
                        <?php }  ?>
                    </ul>
                </li>
                <?php } ?>

                <?php if ($this->permission->check_label('delivery_zone')->access()) { ?>
                <li class="treeview <?php echo (in_array($this->uri->segment(3), ['add_delivery_zone','manage_delivery_zone']) ? 'active' : '') ?>">
                    <a href="#">
                        <span><?php echo display('delivery_zone') ?></span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <?php if ($this->permission->check_label('add_delivery_zone')->access()) { ?>
                        <li class="<?php echo (($this->uri->segment(3) == 'add_delivery_zone') ? 'active' : '') ?>">
                            <a href="<?php echo base_url('dashboard/cdelivery_system/add_delivery_zone') ?>"><?php echo display('add_delivery_zone') ?></a>
                        </li>
                        <?php } if ($this->permission->check_label('manage_delivery_zone')->access()) { ?>
                        <li class="<?php echo (($this->uri->segment(3) == 'manage_delivery_zone') ? 'active' : '') ?>">
                            <a href="<?php echo base_url('dashboard/cdelivery_system/manage_delivery_zone') ?>"><?php echo display('manage_delivery_zone') ?></a>
                        </li>
                        <?php }  ?>
                    </ul>
                </li>
                <?php } ?>
                <?php if ($this->permission->check_label('delivery_assigns')->access()) { ?>
                <li class="treeview <?php echo (in_array($this->uri->segment(3), ['assign_delivery','manage_assigned_delivery']) ? 'active' : '') ?>">
                    <a href="#">
                        <span><?php echo display('assigns') ?></span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <?php if ($this->permission->check_label('assign_delivery')->access()) { ?>
                        <li class="<?php echo (($this->uri->segment(3) == 'assign_delivery') ? 'active' : '') ?>">
                            <a href="<?php echo base_url('dashboard/cdelivery_system/assign_delivery') ?>"><?php echo display('assign_delivery') ?></a>
                        </li>
                        <?php } if ($this->permission->check_label('manage_assigned_delivery')->access()) { ?>
                        <li class="<?php echo (($this->uri->segment(3) == 'manage_assigned_delivery') ? 'active' : '') ?>">
                            <a href="<?php echo base_url('dashboard/cdelivery_system/manage_assigned_delivery') ?>"><?php echo display('manage_assigned_delivery') ?></a>
                        </li>
                        <?php }  ?>
                    </ul>
                </li>
                <?php } ?>
            </ul>
        </li>
        <?php } ?>
        <!-- End of menu delivery system -->

        <!-- Modules menu start -->
        <?php if ($this->permission->module('modules')->access()) { ?>
         <li class="treeview <?php echo(($this->uri->segment(2) == 'module' ? 'active' : '')) ?>">
            <a href="<?php echo base_url('addon/module')?>"><i class="ti-package"></i><span><?php echo display('modules') ?> </span></a>
            </a>
        </li>
        <?php } ?>
        <!-- theme menu start -->
        <?php if ($this->permission->module('themes')->access()) { ?>
        <li class="treeview <?php echo(($this->uri->segment(2) == 'theme' ? 'active' : '')) ?>">
            <a href="<?php echo base_url('addon/theme') ?>"><i class="fa fa-tint"></i><span><?php echo display('themes') ?></span>
            </a>
        </li>
        <?php } ?>
        <!-- theme menu end -->

        <!-- sms Settings menu start -->
        <?php if ($this->permission->module('sms_settings')->access()) { ?>
        <li class="treeview <?php if ($this->uri->segment(3) == ("sms_configuration") || $this->uri->segment(3) == ("sms_template")) {
            echo "active";
        } else {
            echo " ";
        } ?>">
            <a href="#">
                <i class="ti-settings"></i><span><?php echo display('sms_settings') ?></span>
                <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu">
                <?php if ($this->permission->check_label('sms_configuration')->access()) { ?>
                <li class="<?php echo(($this->uri->segment(3) == 'sms_configuration' ? 'active' : '')) ?>">
                    <a href="<?php echo base_url('dashboard/Csms_setting/sms_configuration') ?>"><?php echo display('sms_configuration') ?> </a>
                </li>
                <?php } if ($this->permission->check_label('sms_template')->access()) { ?>
                <li class="<?php echo(($this->uri->segment(3) == 'sms_template' ? 'active' : '')) ?>">
                    <a href="<?php echo base_url('dashboard/Csms_setting/sms_template') ?>"><?php echo display('sms_template') ?> </a>
                </li>
                <?php } ?>
            </ul>
        </li>
        <?php } ?>
        <!-- sms Settings menu end -->

        <!-- Website Settings menu start -->
        <?php if ($this->permission->module('web_settings')->access()) { ?>
        <?php $websettlist = array('Cblock','Cweb_setting','Cproduct_review','Csubscriber','Cwishlist','Cweb_footer','Clink_page','Ccoupon','Cabout_us','Cour_location','manage_contact_form','Cshipping_method','manage_slider','manage_add','seo_tools');
         ?>
        <li class="treeview  <?php if(in_array($this->uri->segment(2), $websettlist) || in_array($this->uri->segment(3), $websettlist)){ echo 'active'; } ?>">
            <a href="#">
                <i class="ti-settings"></i><span><?php echo display('web_settings') ?></span>
                <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu">
                <?php if ($this->permission->check_label('slider')->access()) { ?>
                <li class="<?php echo(($this->uri->segment(3) == 'manage_slider' ? 'active' : '')) ?>">
                    <a href="<?php echo base_url('dashboard/Cweb_setting/manage_slider') ?>"><?php echo display('slider') ?></a>
                </li>
                <?php } if ($this->permission->check_label('advertisement')->access()) { ?>
                <li class="<?php echo(($this->uri->segment(3) == 'manage_add' ? 'active' : '')) ?>">
                    <a href="<?php echo base_url('dashboard/Cweb_setting/manage_add') ?>"><?php echo display('advertisement') ?> </a>
                </li>
                <?php } if ($this->permission->check_label('block')->access()) { ?>
                <li class="<?php echo(($this->uri->segment(2) == 'Cblock' ? 'active' : '')) ?>"><a href="<?php echo base_url('dashboard/Cblock') ?>"><?php echo display('block') ?> </a>
                </li>
                <?php } if ($this->permission->check_label('product_review')->access()) { ?>
                <li class="<?php echo(($this->uri->segment(2) == 'Cproduct_review' ? 'active' : '')) ?>">
                    <a href="<?php echo base_url('dashboard/Cproduct_review') ?>"><?php echo display('product_review') ?> </a>
                </li>
                <?php } if ($this->permission->check_label('subscriber')->access()) { ?>
                <li class="<?php echo (($this->uri->segment(2) == 'Csubscriber' ? 'active' : '')) ?>"><a href="<?php echo base_url('dashboard/Csubscriber') ?>"><?php echo display('subscriber') ?> </a>
                </li>
                <?php } if ($this->permission->check_label('wishlist')->access()) { ?>
                <li class="<?php echo (($this->uri->segment(2) == 'Cwishlist' ? 'active' : '')) ?>"><a href="<?php echo base_url('dashboard/Cwishlist/manage_wishlist') ?>"><?php echo display('wishlist') ?> </a>
                </li>
                <?php } if ($this->permission->check_label('web_footer')->access()) { ?>
                <li class="<?php echo (($this->uri->segment(2) == 'Cweb_footer' ? 'active' : '')) ?>"><a href="<?php echo base_url('dashboard/Cweb_footer/manage_web_footer') ?>"><?php echo display('web_footer') ?> </a>
                </li>
                <?php } if ($this->permission->check_label('link_page')->access()) { ?>
                <li class="<?php echo (($this->uri->segment(2) == 'Clink_page' ? 'active' : '')) ?>"><a href="<?php echo base_url('dashboard/Clink_page/manage_link_page') ?>"><?php echo display('link_page') ?> </a>
                </li>
                <?php } if ($this->permission->check_label('coupon')->access()) { ?>
                <li class="<?php echo (($this->uri->segment(2) == 'Ccoupon' ? 'active' : '')) ?>"><a href="<?php echo base_url('dashboard/Ccoupon/manage_coupon') ?>"><?php echo display('coupon') ?> </a>
                </li>
                <?php } if ($this->permission->check_label('contact_form')->access()) { ?>
                <li class="<?php echo (($this->uri->segment(3) == 'manage_contact_form' ? 'active' : '')) ?>">
                    <a href="<?php echo base_url('dashboard/Cweb_setting/manage_contact_form') ?>"><?php echo display('contact_form') ?> </a>
                </li>
                <?php } if ($this->permission->check_label('why_choose_us')->access()) { ?>
                <li class="<?php echo (($this->uri->segment(2) == 'Cabout_us' ? 'active' : '')) ?>"><a href="<?php echo base_url('dashboard/Cabout_us/manage_about_us') ?>"><?php echo display('why_choose_us') ?> </a>
                </li>
                <?php } if ($this->permission->check_label('our_location')->access()) { ?>
                <li class="<?php echo (($this->uri->segment(2) == 'Cour_location' ? 'active' : '')) ?>">
                    <a href="<?php echo base_url('dashboard/Cour_location/manage_our_location') ?>"><?php echo display('our_location') ?> </a>
                </li>
                <?php } if ($this->permission->check_label('shipping_method')->access()) { ?>
                <li class="<?php echo (($this->uri->segment(2) == 'Cshipping_method' ? 'active' : '')) ?>">
                    <a href="<?php echo base_url('dashboard/Cshipping_method/manage_shipping_method') ?>"><?php echo display('shipping_method') ?> </a>
                </li>
                <?php } if ($this->permission->check_label('setting')->access()) { ?>
                <li class="<?php echo (($this->uri->segment(3) == 'setting' ? 'active' : '')) ?>">
                    <a href="<?php echo base_url('dashboard/Cweb_setting/setting') ?>"><?php echo display('setting') ?> </a>
                </li>
                <?php } if ($this->permission->check_label('seo_tools')->access()) { ?>
                <li class="<?php echo (($this->uri->segment('2') == 'seo_tools') ? 'active' : '') ?>">
                    <a href="#">
                        <span><?php echo display('seo_tools')?></span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <?php if ($this->permission->check_label('popular_products')->read()->access()) { ?>
                        <li class="<?php echo (($this->uri->segment('3') == 'popular_products') ? 'active' : '') ?>">
                            <a href="<?php echo base_url('dashboard/seo_tools/popular_products') ?>"><?php echo display('popular_products')?></a>
                        </li>
                        <?php } if ($this->permission->check_label('google_analytics')->read()->access()) { ?>
                        <li class="<?php echo (($this->uri->segment('3') == 'google_analytics') ? 'active' : '') ?>">
                            <a href="<?php echo base_url('dashboard/seo_tools/google_analytics') ?>"><?php echo display('google_analytics')?></a>
                        </li>
                        <?php } if ($this->permission->check_label('website_meta_keywords')->read()->access()) { ?>
                        <li class="<?php echo (($this->uri->segment('3') == 'website_meta_keywords') ? 'active' : '') ?>">
                            <a href="<?php echo base_url('dashboard/seo_tools/website_meta_keywords') ?>"><?php echo display('website_meta_keywords')?></a>
                        </li>
                        <?php } ?>
                    </ul>
                </li>
                <?php } ?>
            </ul>
        </li>
        <?php } ?>
        <!-- Website Settings menu end -->

        <!-- Software Settings menu start -->
        <?php if ($this->permission->module('software_settings')->access()) { ?>
        <?php $softsetts = array('Company_setup', 'User','Csoft_setting','Language','role')  ?>
        <li class="treeview <?php echo  (in_array($this->uri->segment(2), $softsetts)?"active":"");  ?>">
            <a href="#">
                <i class="ti-settings"></i><span><?php echo display('software_settings') ?></span>
                <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu">
                <?php if ($this->permission->check_label('manage_company')->access()) { ?>
                <li class="<?php echo(($this->uri->segment(3) == 'manage_company' ? 'active' : '')) ?>">
                    <a href="<?php echo base_url('dashboard/Company_setup/manage_company') ?>"><?php echo display('manage_company') ?></a>
                </li>
                <?php } if ($this->permission->check_label('add_user')->access()) { ?>
                <li class="<?php echo(($this->uri->segment(2) == 'User' && ($this->uri->segment(3) == '') ? 'active' : '')) ?>">
                    <a href="<?php echo base_url('dashboard/User') ?>"><?php echo display('add_user') ?></a>
                </li>
                <?php } if ($this->permission->check_label('manage_users')->access()) { ?>
                <li class="<?php echo(($this->uri->segment(3) == 'manage_user' ? 'active' : '')) ?>">
                    <a href="<?php echo base_url('dashboard/User/manage_user') ?>"><?php echo display('manage_users') ?> </a>
                </li>

                <!-- User role assign here start-->
                <?php } if ($this->permission->check_label('role')->access()) { ?>
                <li class=" <?php if(($this->uri->segment(2)=="role")){echo "active";}?>">
                    <a href="#">
                        <span><?php echo display('role')?></span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <?php if ($this->permission->check_label('role')->create()->access()) { ?>
                        <li><a href="<?php echo base_url('dashboard/role/role_add') ?>"><?php echo display('add_role')?></a></li>
                        <?php } if ($this->permission->check_label('role')->read()->access()) { ?>
                        <li><a href="<?php echo base_url('dashboard/role/role_list') ?>"><?php echo display('manage_roles')?></a></li>
                        <?php } if ($this->permission->check_label('role')->read()->access()) { ?>
                        <li><a href="<?php echo base_url('dashboard/role/user_access_role') ?>"><?php echo display('manage_user_roles')?></a></li>
                        <?php } ?>
                    </ul>
                </li> 
                <!-- User role assign here end-->

                <?php } if ($this->permission->check_label('language')->access()) { ?>
                <li class="<?php echo(($this->uri->segment(2) == 'Language' && ($this->uri->segment(3) == '') ? 'active' : '')) ?>">
                    <a href="<?php echo base_url('dashboard/Language') ?>"><?php echo display('language') ?> </a>
                </li>
                <?php } if ($this->permission->check_label('color_setting_frontend')->access()) { ?>
                <li class="<?php echo(($this->uri->segment(3) == 'color_setting_frontend' ? 'active' : '')) ?>">
                    <a href="<?php echo base_url('dashboard/Csoft_setting/color_setting_frontend') ?>"><?php echo display('color_setting_frontend') ?> </a>
                </li>
                <?php } if ($this->permission->check_label('color_setting_backend')->access()) { ?>
                <li class="<?php echo(($this->uri->segment(3) == 'color_setting_backend' ? 'active' : '')) ?>">
                    <a href="<?php echo base_url('dashboard/Csoft_setting/color_setting_backend') ?>"><?php echo display('color_setting_backend') ?> </a>
                </li>
                <?php } if ($this->permission->check_label('email_configuration')->access()) { ?>
                <li class="<?php echo(($this->uri->segment(3) == 'email_configuration' ? 'active' : '')) ?>">
                    <a href="<?php echo base_url('dashboard/Csoft_setting/email_configuration') ?>"><?php echo display('email_configuration') ?> </a>
                </li>
                <?php } if ($this->permission->check_label('payment_gateway_setting')->access()) { ?>
                <li class="<?php echo(($this->uri->segment(3) == 'payment_gateway_setting' ? 'active' : '')) ?>">
                    <a href="<?php echo base_url('dashboard/Csoft_setting/payment_gateway_setting') ?>"><?php echo display('payment_gateway_setting') ?> </a>
                </li>
                <?php } if ($this->permission->check_label('software_settings')->access()) { ?>
                <li class="<?php echo(($this->uri->segment(2) == 'Csoft_setting' && ($this->uri->segment(3) == '') ? 'active' : '')) ?>">
                    <a href="<?php echo base_url('dashboard/Csoft_setting') ?>"><?php echo display('setting') ?> </a>
                </li>
                <?php } ?>
            </ul>
        </li>
        <?php } ?>

        <!-- Software Settings menu end -->
        <?php if ($this->permission->module('update')->access()) { ?>
        <li class="treeview <?php echo (($this->uri->segment(2) == 'autoupdate' && ($this->uri->segment(3) == '') ? 'active':''))?>">
            <a href="<?php echo base_url('autoupdate') ?>"><i class="fa fa-cloud-download" aria-hidden="true"></i><span><?php echo display('update') ?></span>
            </a>
        </li>
        <?php } ?>
        <?php if ($this->permission->module('backup_and_restore')->access()) { ?>
        <li class="treeview <?php echo(($this->uri->segment(3) == "backup_restore") ? "active" : null) ?>">
            <a href="<?php echo base_url('dashboard/backup_restore/index') ?>"><i class="fa fa-database"></i>
                <span><?php echo display('backup_and_restore') ?></span>
            </a>
        </li>
        <?php } ?>

    <?php }
    ?>


<?php if ($this->session->userdata('user_type') == '4') { ?>

    <!-- Invoice menu start -->
    <li class="treeview <?php if ($this->uri->segment(3) == ("new_invoice") || $this->uri->segment(3) == ("manage_invoice") || $this->uri->segment(3) == ("invoice_update_form")) {
        echo "active";
    } else {
        echo " ";
    } ?>">
        <a href="#">
            <i class="ti-layout-accordion-list"></i><span><?php echo display('sales') ?></span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class="<?php echo (($this->uri->segment(3) == 'new_invoice' ? 'active':''))?>">
                <a href="<?php echo base_url('dashboard/Store_invoice/new_invoice') ?>"><?php echo display('new_sale') ?></a>
            </li>
            <li class="<?php echo (($this->uri->segment(3) == 'manage_invoice' ? 'active':''))?>">
                <a href="<?php echo base_url('dashboard/Store_invoice/manage_invoice') ?>"><?php echo display('manage_sale') ?></a>
            </li>
        </ul>
    </li>
    <!-- Invoice menu end -->

    <!-- POS invoice menu start -->
    <li class="treeview <?php if ($this->uri->segment(3) == ("pos_invoice")) {
        echo "active";
    } else {
        echo " ";
    } ?>">
        <a href="<?php echo base_url('dashboard/Store_invoice/pos_invoice') ?>" target="_blank">
            <i class="ti-layout-tab-window"></i><span><?php echo display('pos_sale') ?></span>
            
        </a>
    </li>
    <!-- POS invoice menu end -->

    <!-- Customer menu start -->
    <li class="treeview <?php if ($this->uri->segment(2) == ("Ccustomer")) {
        echo "active";
    } else {
        echo " ";
    } ?>">
        <a href="#">
            <i class="fa fa-handshake-o"></i><span><?php echo display('customer') ?></span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class="<?php echo (($this->uri->segment(2) == 'Ccustomer' && ($this->uri->segment(3) == '')  ? 'active':''))?>"><a href="<?php echo base_url('dashboard/Ccustomer') ?>"><?php echo display('add_customer') ?></a></li>
            <li class="<?php echo (($this->uri->segment(3) == 'manage_customer' ? 'active':''))?>">
                <a href="<?php echo base_url('dashboard/Ccustomer/manage_customer') ?>"><?php echo display('manage_customer') ?></a>
            </li>
        </ul>
    </li>
    <!-- Customer menu end -->

    <!-- Store Stock -->
    <li class="treeview <?php if ($this->uri->segment(3) == ("stock_report")) {
        echo "active";
    } else {
        echo " ";
    } ?>">
        <a href="<?php echo base_url('dashboard/Store_invoice/stock_report') ?>">
            <i class="ti-layout-tab-window"></i><span><?php echo display('stock') ?></span>
            
        </a>
    </li>
    <!-- Store stock end -->
<?php } ?>


<!-- ends of admin area -->
<?php if ($this->permission->module('android_apps')->access()) { ?>
<li class="<?php if ($this->uri->segment(3) == ("android_apps_view")) {
    echo "active";
} else {
    echo " ";
} ?>">
    <a href="<?php  echo base_url().'dashboard/Cweb_setting/android_apps_view' ?>"><i class="fa fa-android" aria-hidden="true"></i>
        <span><?php echo display('android_apps') ?></span>
        <span class="pull-right-container">
           <span class="label label-success pull-right"></span>
       </span>
    </a>
</li>
<?php } ?>
<?php if ($this->permission->module('support')->access()) { ?>
<li>
    <a href="https://forum.bdtask.com" target="_blank"><i class="ti-themify-favicon"></i>
        <span><?php echo display('support') ?></span>
        <span class="pull-right-container">
               <span class="label label-success pull-right"></span>
           </span>
    </a>
</li>
<?php } ?>
</ul>
</div> <!-- /.sidebar -->