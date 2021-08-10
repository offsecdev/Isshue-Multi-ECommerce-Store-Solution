<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('themes') ?></h1>
            <small><?php echo display('manage_themes') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>

                <li class="active"><?php echo display('manage_themes') ?></li>

            </ol>
        </div>
    </section>

    <section class="content">

        <div class="row">
            <div class="col-sm-12">
                <div class="column">
                
                  <a href="<?php echo base_url('addon/theme/add_theme')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-plus"> </i> <?php echo display('add')?></a>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('manage_themes') ?></h4>
                        </div>
                    </div>
                    <div class="panel-body">

                        <?php
                        if ($this->session->userdata('message')) {
                            ?>
                            <div class="alert alert-success">
                                <button class="close" data-dismiss="alert">&times;</button>
                                <?php
                                echo "<b>" . $this->session->userdata('message') . "</b>";
                                $this->session->unset_userdata('message')
                                ?>
                            </div>
                            <?php
                        }
                        ?>
                        <?php
                        if ($this->session->userdata('exception')) {
                            ?>
                            <div class="alert alert-danger">
                                <button class="close" data-dismiss="alert">&times;</button>
                                <?php
                                echo "<b>" . $this->session->userdata('exception') . "</b>";
                                echo $this->session->unset_userdata('exception');
                                ?>
                            </div>
                            <?php
                        }
                        ?>


                        <!--preview-->
                        <div class="row">
                            <?php

                            foreach ($themes as $single_theme) {
                                ?>
                                <div class="col-sm-6 col-md-3">
                                    <div class="thumbnail theme_img">
                                        <img src="<?php echo base_url() . 'application/modules/web/views/themes/' .
                                            html_escape($single_theme->name) . '/preview.png'; ?>"
                                             alt="<?php echo html_escape($single_theme->name); ?>">
                                    </div>
                                    <div class="caption">
                                        <h3><?php echo ucwords(str_replace('_', ' ', $single_theme->name));
                                            echo display('theme')
                                            ?> </h3>
                                        <p>
                                            <?php

                                            if (@$theme !== $single_theme->name) {
                                                echo '<a href="' . base_url() . 'dashboard/Ctheme/active_theme/' . html_escape($single_theme->name) . '" class="btn btn-danger" role="button">' . display('in_active') . '</a>';
                                            }else{
                                              ?>
                                                <button type="button" class="btn btn-success" disabled><?php echo display('active')?></button>
                                            <?php
                                            }
                                            ?>

                                        </p>
                                    </div>
                                </div>
                                <?php
                            }
?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>