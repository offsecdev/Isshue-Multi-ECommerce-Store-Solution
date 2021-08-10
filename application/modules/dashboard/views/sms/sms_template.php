    <!--Update email setting start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('sms_template') ?></h1>
            <small><?php echo display('sms_template') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('sms_settings') ?></a></li>
                <li class="active"><?php echo display('sms_template') ?></li>
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
    <div class="row">
        <div class="col-md-12">
            <div  class="panel panel-default panel-form">
                <div class="row">
                    <div class="col-md-8">
                        <div class="panel-body">
                            <div class="portlet-body form">
                            <?php  
                                echo form_open_multipart('dashboard/Csms_setting/save_sms_template', array('class' => 'form-horizontal','method'=>'post','id' => 'MyForm','role'=>'form'));  
                            ?>
                                
                            <div class="form-body">
                               <input type="hidden" name="id" id="id" value=""/>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label"><?php echo display('template_name');?> : </label>
                                        <div class="col-md-8">
                                            <input type="text" id="template_name" class="form-control" value="" required="1" name="template_name" placeholder="<?php echo display('template_name');?>">
                                        </div>
                                    </div> 

                                    <div class="form-group">
                                        <label class="col-md-4 control-label"><?php echo display('type');?> : </label>
                                        <div class="col-md-8">
                                            <?php echo form_dropdown('type', array('' => 'Select Option','Registration' => 'Registration', 'Order' =>'Order',  'Processing' => 'Processing','Shipped'=>'Shipped'), null, array('class'=>'form-control dont-select-me', 'id'=>'type', 'required'=>'required')) ?> 
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4 control-label"><?php echo display('sms_template');?> : </label>
                                        <div class="col-md-8">
                                             <textarea name="message" id="message" value="" class="form-control" required="1" rows="6"></textarea>
                                        </div>
                                    </div> 
                                </div>

                                   <div class="form-group row">
                                        <div class="col-sm-offset-4 col-sm-8">
                                            <button type="reset" class="btn btn-danger"><?php echo display('reset');?></button>
                                            <button type="submit" class="btn btn-success sav_btn"><?php echo display('submit');?></button>
                                        </div>
                                    </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="panel-body">
                           <p class="smstemp_warning">
                               <?php echo display('sms_template_warning');?>
                           </p>
                        </div>
                    </div>
                </div>
            </div>  
         </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="breadcrumbs ng-scope">
                <h2> <?php echo display('sms_template_list');?></h2>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            
            <div class="panel panel-default">
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr class="center">
                                <th class="all"> <?php echo display('set_default');?> </th>
                                <th class="all"><?php echo display('template_name');?></th>
                                <th class="all"><?php echo display('type');?></th>
                                <th class="all"><?php echo display('sms_template');?> </th>
                                <th class="all"><?php echo display('action');?> </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($template as $value) {?>
                            <tr>
                                <td> 
                                    <a class="btn btn-info" href="<?php echo base_url(); ?>dashboard/Csms_setting/set_default_template/<?php echo html_escape($value->id) . '/' . html_escape($value->default_status); ?>"><span class="glyphicon glyphicon-<?php echo $value->default_status==1?'ok':'remove';?>"></span></a>
                                </td>
                                <td id="t_<?php echo html_escape($value->id);?>"><?php echo html_escape($value->template_name); ?></td>
                                <td id="ts_<?php echo html_escape($value->type); ?>"><?php echo html_escape($value->type); ?></td>
                                <td id="td_<?php echo html_escape($value->id);?>"><?php echo html_escape($value->message); ?></td>
                                <td width="70">
                                    <a data-id="<?php echo html_escape($value->id);?>" class="edit btn btn-xs btn-info">
                                    <i class="fa fa-edit"></i> </a>
                                    <?php if($this->permission->check_label('sms_template')->delete()->access()){ ?>
                                    <a  class="btn btn-xs btn-danger" href="<?php echo base_url();?>dashboard/Csms_setting/delete_template/<?php echo html_escape($value->id) ;?>" onclick="return confirm('Are you want to delete?');">
                                        <i class="fa fa-trash"></i> 
                                    </a>
                                    <?php } ?>
                                </td>
                            </tr>
                            <?php }?>
                        </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
    </div>
<script src="<?php echo MOD_URL.'dashboard/assets/js/sms_template.js'; ?>"></script>
