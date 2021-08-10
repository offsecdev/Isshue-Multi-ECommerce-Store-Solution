<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Admin Home Start -->
<div class="content-wrapper color3">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-world"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('dashboard') ?></h1>
            <small><?php echo display('home') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li class="active"><?php echo display('dashboard') ?></li>
            </ol>
        </div>
    </section>
    <!-- Main content -->
    <section class="content">
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
        <!-- First Counter -->
        <div class="row">

            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                <a href="<?php echo base_url('dashboard/Ccustomer/manage_customer') ?>">
                    <div class="small-box dashbox dashbox-blue bg-white">
                        <div class="inner">
                            <h3><span class="count-number"><?php echo html_escape($total_customer); ?></span></h3>
                            <p><?php echo display('total_customer') ?></p>
                        </div>
                        <div class="icon">
                            <img src="<?php echo base_url('my-assets/image/dashboard/user.png') ?>" class="img img-responsive" >
                        </div> 
                    </div>
                </a>
            </div>
            
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                <a href="<?php echo base_url('dashboard/Cproduct/manage_product') ?>">
                <div class="small-box dashbox dashbox-info  bg-white">
                    <div class="inner">
                        <h3><span class="count-number"><?php echo html_escape($total_product); ?></span></h3>
                        <p><?php echo display('total_product') ?></p>
                    </div>
                    <div class="icon">
                        <img src="<?php echo base_url('my-assets/image/dashboard/products.png') ?>" class="img img-responsive" >
                    </div>
                </div>
                </a>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                <a href="<?php echo base_url('dashboard/Csupplier/manage_supplier') ?>">
                <div class="small-box dashbox dashbox-red bg-white">
                    <div class="inner">
                        <h3><span class="count-number"><?php echo html_escape($total_suppliers); ?></span></h3>
                        <p><?php echo display('total_supplier') ?></p>
                    </div>
                    <div class="icon">
                        <img src="<?php echo base_url('my-assets/image/dashboard/supplier.png') ?>" class="img img-responsive" >
                    </div>
                </div>
                </a>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                <a href="<?php echo base_url('dashboard/Cinvoice/manage_invoice') ?>">
                <div class="small-box dashbox dashbox-green bg-white">
                    <div class="inner">
                        <h3><span class="count-number"><?php echo html_escape($total_sales); ?></span></h3>
                        <p><?php echo display('total_invoice') ?></p>
                    </div>
                    <div class="icon">
                        <img src="<?php echo base_url('my-assets/image/dashboard/invoice.png') ?>" class="img img-responsive" >
                    </div>
                </div>
                </a>
            </div>
        <?php if ($this->session->userdata('user_type') == '4') { ?>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                <a href="<?php echo base_url('dashboard/Cinvoice/manage_invoice') ?>">
                <div class="small-box dashbox dashbox-green bg-white">
                    <div class="inner">
                        <h3><span class="count-number"><?php echo html_escape($total_store_invoice); ?></span></h3>
                        <p><?php echo display('total_invoice') ?></p>
                    </div>
                    <div class="icon">
                        <img src="<?php echo base_url('my-assets/image/dashboard/invoice.png') ?>" class="img img-responsive" >
                    </div>
                </div>
                </a>
            </div>
        <?php } ?>
        </div>
        <hr>
        <!-- Second Counter -->
        <div class="row">
            <?php if ($this->session->userdata('isAdmin')) { ?>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                <div class="panel panel-bd bg-1">
                    <div class="panel-body">
                        <div class="statistic-box">
                            <h2><span class="slight">
                                <img src="<?php echo base_url('my-assets/image/dashboard/pos_invoice.png'); ?>" height="70"
                                     width="70">
                             </span></h2>
                            <div class="small admin_dashbox">

                                <?php if ($this->session->userdata('isAdmin')) { ?>
                                    <a class="whitecolor" href="<?php echo base_url('dashboard/Cinvoice/pos_invoice') ?>"><?php echo display('create_pos_invoice') ?></a>
                                <?php } ?>

                                <?php if ($this->session->userdata('user_type') == '4') { ?>
                                    <a class="whitecolor" href="<?php echo base_url('dashboard/Store_invoice/pos_invoice') ?>"><?php echo display('create_pos_invoice') ?></a>
                                <?php } ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                <div class="panel panel-bd bg-5">
                    <div class="panel-body">
                        <div class="statistic-box">
                            <h2><span class="slight">
                                <img src="<?php echo base_url('my-assets/image/dashboard/create_invoice.png'); ?>" height="70" width="70"> 
                            </span></h2>
                            <div class="small admin_dashbox">
                                <?php if ($this->session->userdata('isAdmin')) { ?>
                                    <a class="whitecolor" href="<?php echo base_url('dashboard/Cinvoice/new_invoice') ?>"><?php echo display('create_new_invoice') ?></a>
                                <?php } ?>

                                <?php if ($this->session->userdata('user_type') == '4') { ?>
                                    <a class="whitecolor" href="<?php echo base_url('dashboard/Store_invoice/new_invoice') ?>"><?php echo display('create_new_invoice') ?></a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                <div class="panel panel-bd bg-7">
                    <div class="panel-body">
                        <div class="statistic-box">
                            <h2><span class="slight"><img src="<?php echo base_url('my-assets/image/dashboard/add-product.png'); ?>" height="70" width="70"> </span></h2>
                            <div class="small admin_dashbox"><a class="whitecolor" href="<?php echo base_url('dashboard/Cproduct') ?>"><?php echo display('add_product') ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                <div class="panel panel-bd bg-4">
                    <div class="panel-body">
                        <div class="statistic-box">
                            <h2><span class="slight"><img src="<?php echo base_url('my-assets/image/dashboard/add-customer.png'); ?>" height="70" width="70"> </span></h2>
                            <div class="small admin_dashbox"><a class="whitecolor" href="<?php echo base_url('dashboard/Ccustomer') ?>"><?php echo display('add_customer') ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
         <?php if ($this->session->userdata('user_type') == 1) { ?>
            <!-- Third Counter -->
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd bg-8">
                        <div class="panel-body">
                            <div class="statistic-box">
                                <h2><span class="slight"><img src="<?php echo base_url('my-assets/image/dashboard/sales-report.png'); ?>" width="70" height="70"> </span>
                                </h2>
                                <div class="small admin_dashbox"><a class="whitecolor"  href="<?php echo base_url('dashboard/Admin_dashboard/todays_sales_report') ?>"><?php echo display('sales_report') ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd bg-6">
                        <div class="panel-body">
                            <div class="statistic-box">
                                <h2><span class="slight"><img src="<?php echo base_url('my-assets/image/dashboard/purchase-report.png'); ?>" width="70" height="70"> </span></h2>
                                <div class="small admin_dashbox"><a class="whitecolor"  href="<?php echo base_url('dashboard/Admin_dashboard/todays_purchase_report') ?>"><?php echo display('purchase_report') ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd bg-2">
                        <div class="panel-body">
                            <div class="statistic-box">
                                <h2><span class="slight"><img src="<?php echo base_url('my-assets/image/dashboard/Stock-Report.png'); ?>" width="70" height="70"> </span>
                                </h2>
                                <div class="small admin_dashbox"><a class="whitecolor" href="<?php echo base_url('dashboard/Creport') ?>"><?php echo display('stock_report') ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd bg-9">
                        <div class="panel-body">
                            <div class="statistic-box">
                                <h2><span class="slight"><img src="<?php echo base_url('my-assets/image/dashboard/accounting.png'); ?>" width="70" height="70"></span></h2>
                                <div class="small admin_dashbox"><a class="whitecolor"  href="<?php echo base_url('dashboard/Caccounts/summary') ?>"><?php echo display('account_summary') ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <!-- This month progress -->
                <div class="col-sm-12 col-md-6">
                    <div class="panel panel-bd">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h4> <?php echo display('monthly_progress_report') ?></h4>
                            </div>
                        </div>
                        <div class="panel-body">
                            <canvas id="lineChart" height="142"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="panel panel-bd">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h4> <?php echo display('customer_activities') ?></h4>
                            </div>
                        </div>
                        <div class="panel-body">
                            <canvas id="barChart" height="142"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                

                <!-- Search Keywords -->
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                    <div class="panel panel-bd lobidisable">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h4><?php echo display('latest_search_keywords'); ?></h4>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="message_inner">
                                <div class="message_widgets">
                                    <table class="table  table-striped table-bordered table-hover">
                                        <thead>
                                            <th><?php echo display('keywords'); ?></th>
                                            <th><?php echo display('results'); ?></th>
                                            <th><?php echo display('hits'); ?></th>
                                        </thead>
                                        <tbody>
                                        <?php if(!empty($search_histories)) {  
                                            foreach($search_histories as $search_history){?>
                                                <tr>
                                                    <td><?php echo html_escape($search_history['keyword']) ?></td>
                                                    <td><?php echo html_escape($search_history['results']) ?></td>
                                                    <td><?php echo html_escape($search_history['hits']) ?></td>
                                                </tr>
                                            <?php } 
                                        }else{ ?>
                                            <tr>
                                                <td colspan="3"><?php echo display('no_data_found'); ?></td>
                                            </tr> 
                                        <?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="3"><a href="<?php echo base_url('dashboard/Admin_dashboard/latest_search_keywords')?>" class="btn btn-success align-right"><i class="fa fa-eye"></i>View All</a></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Latest Reviews -->
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                    <div class="panel panel-bd lobidisable">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h4><?php echo display('latest_product_reviews'); ?></h4>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="message_inner scroll-y">
                                <div class="message_widgets">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <th><?php echo display('products'); ?></th>
                                            <th><?php echo display('Customer'); ?></th>
                                            <th><?php echo display('Rating'); ?></th>
                                        </thead>
                                        <tbody>
                                        <?php if(!empty($product_reviews)) {  
                                            foreach($product_reviews as $product_review){?>
                                                <tr>
                                                    <td><?php echo html_escape($product_review['product_name']) ?></td>
                                                    <td><?php echo html_escape($product_review['customer_name']) ?></td>
                                                    <td><?php echo html_escape($product_review['rate']) ?></td>
                                                </tr>
                                            <?php } 
                                        }else{ ?>
                                            <tr>
                                                <td colspan="3"><?php echo display('no_data_found'); ?></td>
                                            </tr> 
                                        <?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="3"><a href="<?php echo base_url('dashboard/Cproduct_review')?>" class="btn btn-success align-right"><i class="fa fa-eye"></i>View All</a></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Category Wise Product Count -->
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                    <div class="panel panel-bd lobidisable">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h4><?php echo display('category_products'); ?></h4>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="message_inner">
                                <div class="message_widgets">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <th><?php echo display('categories'); ?></th>
                                            <th><?php echo display('products_count'); ?></th>
                                        </thead>
                                        <tbody>
                                            <?php if(!empty($category_products)) { 
                                            foreach($category_products as $category_product){?>
                                                <tr>
                                                    <td><?php echo html_escape($category_product['category_name']) ?></td>
                                                    <td><?php echo html_escape($category_product['product_count']) ?></td>
                                                </tr>
                                            <?php } 
                                        }else{ ?>
                                            <tr>
                                                <td colspan="3"><?php echo display('no_data_found'); ?></td>
                                            </tr> 
                                        <?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="3"><a href="<?php echo base_url('dashboard/Admin_dashboard/all_category_products')?>" class="btn btn-success align-right"><i class="fa fa-eye"></i>View All</a></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Best selling Product -->
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                    <div class="panel panel-bd lobidisable">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h4><?php echo display('best_sale_product'); ?></h4>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="message_inner">
                                <div class="message_widgets">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <th><?php echo display('product'); ?></th>
                                            <th><?php echo display('orders_count'); ?></th>
                                        </thead>
                                        <tbody>

                                            <?php if(!empty($best_sale_products)) {
                                                foreach($best_sale_products as $best_sale_product){?>
                                                <tr>
                                                    <td><?php echo html_escape($best_sale_product['product_name']) ?></td>
                                                    <td><?php echo html_escape($best_sale_product['order_count']) ?></td>
                                                </tr>
                                            <?php }
                                            }else{ ?>
                                                <tr>
                                                    <td colspan="3"><?php echo display('no_data_found'); ?></td>
                                                </tr> 
                                            <?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="3"><a href="<?php echo base_url('dashboard/Admin_dashboard/best_sale_products')?>" class="btn btn-success align-right"><i class="fa fa-eye"></i>View All</a></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Customer Activities -->
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                    <div class="panel panel-bd lobidisable">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h4><?php echo display('customer_activities'); ?></h4>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="message_inner">
                                <div class="message_widgets sidebar">
                                    <div class="list-group">
                                        <p class="list-group-item">
                                            <?php echo display('new_customers'); ?> <span class="badge"><?php echo html_escape($new_customers); ?></span> 
                                        </p>
                                        <p class="list-group-item">
                                            <?php echo display('returning_customers'); ?> <span class="badge"><?php echo html_escape($returning_customers); ?></span> 
                                        </p>
                                        <p class="list-group-item">
                                            <?php echo display('average_spending_per_visit'); ?> <span class="badge">
                                                <?php echo(($position == 0) ? "$currency ".number_format($average_spending_per_visit, 2, '.', '') : number_format($average_spending_per_visit, 2, '.', '')." $currency") ?>
                                                </span> 
                                        </p>
                                        <p class="list-group-item">
                                            <?php echo display('average_visits_per_customer'); ?> <span class="badge"><?php echo html_escape(ceil($average_visits_per_customer)); ?></span> 
                                        </p>
                                        <p class="list-group-item">
                                            <?php echo display('positive_review'); ?> <span class="badge"><?php echo html_escape($positive_review_count); ?></span> 
                                        </p>
                                    </div>        
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Report -->
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                    <div class="panel panel-bd lobidisable">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h4><?php echo display('todays_report') ?></h4>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="message_inner">
                                <div class="message_widgets">
                                    <table class="table table-bordered table-striped table-hover">
                                        <tr>
                                            <th><?php echo display('todays_report') ?></th>
                                            <th><?php echo display('money') ?></th>
                                        </tr>
                                        <tr>
                                            <th><?php echo display('total_sales') ?></th>
                                            <td><?php echo(($position == 0) ? "$currency $sales_amount" : "$sales_amount $currency") ?></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo display('total_purchase') ?></th>
                                            <td><?php echo(($position == 0) ? "$currency $purchase_amount" : "$purchase_amount $currency") ?></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo display('total_discount') ?></th>
                                            <td><?php echo(($position == 0) ? "$currency $discount_amount" : "$discount_amount $currency") ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
         <?php } ?>
    </section> 
</div> 
<!-- Admin Home end -->

<!-- ChartJs JavaScript -->
<script src="<?php echo base_url() ?>assets/plugins/chartJs/Chart.min.js" type="text/javascript"></script>
<?php $this->load->view('../../../dashboard/assets/js/home.php');?>
