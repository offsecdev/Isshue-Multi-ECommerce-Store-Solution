<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!--Account type select start -->
<link rel="stylesheet" type="text/css" href="<?php echo MOD_URL.'dashboard/assets/css/inflow.css'; ?>">
<script src="<?php echo MOD_URL.'dashboard/assets/js/inflow_edit.js'; ?>"></script>

<!-- Add new income start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('edit_received') ?></h1>
            <small><?php echo display('edit_received') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('accounts') ?></a></li>
                <li class="active"><?php echo display('edit_received') ?></li>
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

        <!-- New supplier -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('edit_received') ?> </h4>
                        </div>
                    </div>
                    {edit}

                    <?php echo form_open_multipart("dashboard/caccounts/inflow_edit_receiver/{transection_id}", array('class' => 'form-vertical', 'id' => 'insert_deposit', 'name' => 'insert_deposit')); ?>
                    <div class="panel-body">
                    	<?php $today = date('m-d-Y'); ?>
                        
                        <div class="form-group row">
                            <label for="payment_date" class="col-sm-3 col-form-label"><?php echo display('payment_date') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input type="text" name="transection_date" value="{date}" required id="payment_date"  class="datepicker form-control"/>
                            </div>
                        </div>

						<div class="form-group row" id="payment_from_1">
					        <label for="customer_name" class="col-sm-3 col-form-label"><?php echo display('payment_from') ?> <i class="text-danger">*</i></label>
					        <div class="col-sm-6">
						        <input type="text" value="{name}" name="customer_name" class="form-control customerSelection" placeholder='<?php echo display('customer_name') ?>' id="customer_name" />

						        <input value="{customer_id}" id="SchoolHiddenId" class="customer_hidden_value" type="hidden" name="customer_id">
					        </div>
                            <div class="col-sm-3">
                                <input onClick="active_customer('payment_from_1')" type="button" id="myRadioButton_1" class="btn btn-success color4 checkbox_account" name="customer_confirm" checked="checked" value="<?php echo display('new_customer') ?>">
                            </div>
					    </div>

					    <div class="form-group row" id="payment_from_2">
					        <label for="customer_name_others" class="col-sm-3 col-form-label"><?php echo display('payment_from') ?> <i class="text-danger">*</i></label>
					        <div class="col-sm-6">
						        <input type="text"  name="customer_name_others" class="form-control" placeholder='<?php echo display('payee_name') ?>' id="customer_name_others" />
					        </div>
                            <div class="col-sm-3">
                                <input  onClick="active_customer('payment_from_2')" type="button" id="myRadioButton_2" class="btn btn-success color4 checkbox_account" name="customer_confirm_others" value="<?php echo display('old_customer') ?>"> 
                            </div>
					    </div>

					    <div class="form-group row">
					        <label for="payment_type" class="col-sm-3 col-form-label"><?php echo display('payment_type') ?> <i class="text-danger">*</i></label>
					        <div class="col-sm-6">
						        <select onchange="bank_info_show(this)" name="payment_type" class="form-control">
                                    <option value="{payment_type}"> {payment} </option>
                                    <option value="1"> Cash </option>
                                    <option value="2"> Cheque </option>
                                    <option value="3"> Pay Order </option>
                                </select>
					        </div>
					    </div>

					    <div id="bank_info_hide">
					    	<div class="form-group row">
						        <label for="cheque_or_pay_order_no" class="col-sm-3 col-form-label"><?php echo display('cheque_or_pay_order_no') ?> <i class="text-danger">*</i></label>
						        <div class="col-sm-6">
                                    <input type="text" id="amount" class="form-control" value="{cheque_no}" name="cheque_no" placeholder="<?php echo display('cheque_or_pay_order_no') ?>" />
						        </div>
						    </div>
						    <div class="form-group row">
						        <label for="date" class="col-sm-3 col-form-label"><?php echo display('date') ?> <i class="text-danger">*</i></label>
						        <div class="col-sm-6">
                                     <input type="text" name="cheque_mature_date" data-date-format="yyyy-mm-dd" value="{date}" id="amount"  class="datepicker form-control"/>
						        </div>
						    </div>

						    <div class="form-group row">
						        <label for="bank_name" class="col-sm-3 col-form-label"><?php echo display('bank_name') ?> <i class="text-danger">*</i></label>
						        <div class="col-sm-6">
							        <select name="bank_name"  class="form-control">
                                        <option value="{selected_bank_id}"> {selected_bank}</option>
                                        {bank}
                                        <option value="{bank_id}"> {bank_name}</option>
                                        {/bank}
                                    </select>
						        </div>
						    </div>
					    </div>

                        <div class="form-group row">
                            <label for="account_table" class="col-sm-3 col-form-label"><?php echo display('payment_account') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
								<select name="account_id" class="form-control">
                                    {selected}
                                        <option value="{account_id}"> {account_name} </option>
                                    {/selected}
                                    {accounts}
                                        <option value="{account_id}"> {account_name} </option>
                                    {/accounts}
                                </select>
                                <!-- Keeping table name -->
                                <input type="hidden" value="{selected_table_id}" name="pre_table"/> 
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="store" class="col-sm-3 col-form-label"><?php echo display('store') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <select name="store_id" id="store" class="form-control">
                                    {selected_store}
                                    <option value="{store_id}" selected=""> {store_name} </option>
                                    {/selected_store}
                                    
                                    {store_list}
                                    <option value="{store_id}"> {store_name} </option>
                                    {/store_list}
                                </select>
                            </div>
                        </div>

                       	<div class="form-group row">
                            <label for="amount" class="col-sm-3 col-form-label"><?php echo display('ammount') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
								<input type="number" value="{amount}" id="amount" class="form-control" name="amount" required />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-sm-3 col-form-label"><?php echo display('description') ?></label>
                            <div class="col-sm-6">
                                <textarea  name="description" class="form-control" >{description}</textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
                            	<input type="reset" id="add-deposit" class="btn btn-danger" name="add-deposit" value="<?php echo display('reset') ?>" />

                                <input type="submit" id="add-deposit" class="btn btn-success color4" name="add-deposit" value="<?php echo display('save') ?>" />
                            </div>
                        </div>
                    </div>
                    <?php echo form_close() ?>
                    {/edit}
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Add new income end -->



