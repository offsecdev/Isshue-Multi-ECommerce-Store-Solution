<?php 
// session start
ini_set('session.use_trans_sid', false);
ini_set('session.use_cookies', true);
ini_set('session.use_only_cookies', true);
$https = false;
if(isset($_SERVER['HTTPS']) and $_SERVER['HTTPS'] != 'off') $https = true;
$dirname = rtrim(dirname($_SERVER['PHP_SELF']), '/').'/';
session_save_path(dirname(__FILE__).'/sessions/');
session_name('ci_installer');
session_set_cookie_params(0, $dirname, $_SERVER['HTTP_HOST'], $https, true);
session_start();
// Include helper
require_once __DIR__.'/php/Helper.php';
require_once __DIR__.'/vendor/autoload.php';

use Php\Requirements;
use Php\Validation;
use Php\DbImport;
use Php\FileWrite;
use Php\Verification;

// //create object for each class
$Requirements = new Requirements();
$Validation   = new Validation();
$DbImport     = new DbImport();
$FileWrite    = new FileWrite(); 
$Verification = new Verification(); 

//set the path of files
$path = [
'sql_path'      => 'sql/install.sql',
'template_path' => 'php/Database.php',
'output_path'   => '../application/config/database.php',
'config_path'   => '../application/config/config.php',
];

$message      = null; 
$activeClass  = null; 

//Define session key for purchase key used or not
$_SESSION['purchase_key_used'] = false;

//generate token
if (empty($_SESSION['_token'])) {
    $_SESSION['_token'] = gen_csrf_token();
}
$token = $_SESSION['_token']; 

//condition for step 3
if (isset($_GET['launchapp']) && $Validation->checkEnvFileExists() === false) {
// Check Applicatiob Launch
$launch = $Verification->launch_application($_GET); 
//Installation done if all task done
if($launch){
//create a env file in Flag directory
$FileWrite->createEnvFile();
//destroy session data
session_destroy();
// Redirect to application
$Validation->checkEnvFileExists();
}else{
//IF Installation Process failed
$message .= '<li>Failed! Please Check your internet connection and Try again</li>';
} 
} else {
$Validation->checkEnvFileExists();
}
// ends of step 3

// Purchase Key Validation
if (!empty($_GET['user_id']) || !empty($_GET['purchase_key'])) {

    $result = $Validation->validate($_GET);

    if ($result === TRUE) {

        $validdata = $Verification->verify_purchase($_GET);

        if($validdata == 'yes'){
            header('location: index.php?step2=true');
        } else{
           $message .= $validdata;
        }

    } else{
        $message .= $result;
    }
}

//Submit form data 
if ($_SERVER["REQUEST_METHOD"] === "POST") {

// Insert Login Information
if(!empty($_POST['email']) && !empty($_POST['password'])){
    // validate Login data
    $lresult = $Validation->validate_login($_POST);
    // If validation successful
    if ($lresult===TRUE) {
        // Insert login data into table
        if($DbImport->insert_login($_POST)){
            // Redirect to complete app page
            header('location: index.php?complete=true');
        } else{
            $message .= "<li>Failed! Please Try Again</li>";
        }
    }else {
        //Display error message
        $message .= $lresult;
    }
// End of login info insert
} else {

//validate all input
$dbvalid = $Validation->run($_POST);
if ($dbvalid===true) {
    //check install.sql file is exists in sql directory
    if ($Validation->checkFileExists($path['sql_path'])==false) {
        $message .= "<li>install.sql file is not exists in sql/ directory!</li>";
    } else {
        //first create the database, then create tables, then write config and database file
        if ($FileWrite->databaseConfig($path,$_POST) === false) {
            //write database file
            $message .= "<li>The database configuration file could not be written, ";
            $message .= "please chmod application/config/database.php file to 777</li>";
        } elseif ($FileWrite->baseUrl($path['config_path']) === false) {
            //write config file
            $message .= "<li>The config  file could not be written, ";
            $message .= "please chmod application/config/config.php file to 777</li>";
        } elseif ($DbImport->createDatabase($_POST) === false) {
            $message .= "<li>The database could not be created, ";
            $message .= "please verify your settings.</li>";
        } elseif ($DbImport->createTables($_POST) === false) {
            $message .= "<li>The database tables could not be created, ";
            $message .= "please verify your settings.</li>";
        } else { 
            //redirect to complete installation
            header('location: index.php?step4=true');
           
        }   
    }

    } else {
        //Display error message
        $message .= $dbvalid;
    }
}
}
//Ends of submit form data 

?> 

<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<base href="<?php echo base_url(); ?>">
<link rel="icon" type="image/png" href="assets/img/favicon.png" sizes="32x32">
<title>Codeigniter Application Installer</title>

<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
<!-- Bootstrap -->
<link href="assets/css/bootstrap.min.css" rel="stylesheet">
<link href="assets/css/style.min.css" rel="stylesheet">
</head>
<body>
<div class="page-wrapper">
    <div class="container"> 
        <!-- begin of row -->
        <div class="row"> 
            <div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1"> 
                <header class="header">
                    <h1 class="header-title">Bdtask software installer</h1>
                </header>
                <div class="page-content">
                    <div class="outer-container">
                        <div id="wizard" class="aiia-wizard">
                            <?php 
                            if (isset($_GET['step1']) || (!isset($_GET['step1']) && !isset($_GET['step2']) && !isset($_GET['step3']) && !isset($_GET['step4']) && !isset($_GET['complete']))) {
                                    $activeClass = 'active';
                                } 

                            ?>
                            <div class="aiia-wizard-step <?php echo $activeClass ?>">
                                <h1>Verification</h1>

                                <div class="row">
                                    <div class="col-md-12">
                                        <!-- if purchases key used then will appear update button -->
                                        <?php if($_SESSION['purchase_key_used']){ ?>

                                        <a target="_blank" class="btn btn-warning pull-right" href="https://www.bdtask.com/license-update.php?<?php echo 'product_key=21576648&'.'purchase_key='.base64_encode(filterInput($_GET['purchase_key']));?>" role="button">Update Purchase Key</a>

                                        <?php }?>
                                    </div>
                                </div>

                                <form method="GET" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="form-horizontal">
                                <?php
                                if (!empty($message)) {
                                    echo "<div class=\"alert alert-danger\"><ul>$message</ul></div>";
                                }
                                ?>  
                                <div class="step-content step-one">
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <input type="hidden" name="_token" value="<?php echo  (!empty($token)?$token:null) ?>"/>

                                            <div class="form-group">
                                                <label for="userid" class="col-sm-4 col-form-label">Envato User ID <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="bottom" title="Enter Envato User ID or Enter 'bdtask' as non Envato User">
                                                </span> </label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="userid" name="userid" value="<?php echo @$_GET['userid'] ?>" placeholder="User ID" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="purchase_key" class="col-sm-4 col-form-label">Purchase Key <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="bottom" title="Enter Purchase Key which you got by envato purchase or bdtask support.">
                                                </span></label>
                                                <div class="col-sm-8">
                                                    <input type="password" class="form-control" id="purchase_key" value="<?php echo @$_GET['purchase_key'] ?>"  name="purchase_key"  placeholder="Purchase Key" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.End of step one -->
                                <div class="row action_btns">
                                   <button class='btn btn-success pull-right  verify_btn'>Next</button> 
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <!-- if purchases key used then will show -->
                                        <?php if($_SESSION['purchase_key_used']){ ?>

                                            <p class="text-info"><b> N.B:</b> After updating the purchase key , please <b>refresh</b> this page or click <b>next</b> button.</p>
                                            
                                        <?php }?>
                                    </div>
                                </div>

                                </form>
                                
                            </div>
                            <div class="aiia-wizard-step <?php echo (isset($_GET['step2'])?'active':'') ?>">
                                <h1>Configurations</h1>
                                <div class="step-content step-two">
                                    <div class="app_content">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <h3 class="title text-center"><strong>Directory permissions & requirements</strong></h3>
                                                <!-- display requirements -->
                                                <?php echo  $Requirements->directoriesAndPermission(); ?>
                                                <!-- Server Requirement -->
                                                <div class="height"></div>
                                                <?php echo  $Requirements->server();  ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.End of step two -->
                                <div class="row action_btns">
                                    <button class='btn btn-success pull-left aiia-wizard-button-previous prev_action'>Previous</button>
                                   <a href="index.php?step3=true" class='btn btn-success pull-right'>Next</a> 
                                </div>
                            </div>

                            <div class="aiia-wizard-step <?php echo (isset($_GET['step3'])?'active':'') ?>">
                                <h1>Database</h1>
                                <?php
                                if (!empty($message)) {
                                    echo "<div class=\"alert alert-danger\"><ul>$message</ul></div>";
                                }
                                ?> 
                                <form action="index.php?step3=true" method="post">

                                <div class="step-content step-three">

                                        <input type="hidden" name="_token" value="<?php echo  (!empty($token)?$token:null) ?>"/>
                                        <div class="form-group">
                                            <label for="database">Database Name </label>
                                            <input type="text" name="database" class="form-control" id="database" placeholder="Database Name" value="">
                                        </div> 
                                        <div class="form-group">
                                            <label for="username">Username </label>
                                            <input type="text" name="username" class="form-control" id="username" placeholder="Username" value="">
                                        </div> 
                                        <div class="form-group">
                                            <label for="password">Password </label>
                                            <input type="text" name="password" class="form-control" id="password" placeholder="Password" value="">
                                        </div>  
                                        <div class="form-group">
                                            <label for="hostname">Host Name <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="bottom" title="Please keep localhost by default, but if need you can add your own domain name or ip address"></span></label>
                                            <input type="text" name="hostname" class="form-control" id="hostname" placeholder="Host Name"  value="localhost">
                                        </div> 
                                    
                                </div>
                                <div class="row action_btns">
                                    <button class='btn btn-success pull-left aiia-wizard-button-previous prev_action'>Previous</button>
                                    <button type="submit" class='btn btn-success pull-right'>Next</button> 
                                </div>
                                </form>
                            </div>
                            <div class="aiia-wizard-step <?php echo (isset($_GET['step4'])?'active':'') ?>">
                                <h1>Credential</h1>
                                    <p class="text-center">Please add your own initial Email and Password. Please change that after login</p>
                                    <?php
                                    if (!empty($message)) {
                                        echo "<div class=\"alert alert-danger\"><ul>$message</ul></div>";
                                    }
                                    ?> 
                                    <form action="index.php?step4=true" method="post" class="form-horizontal">
                                        <div class="step-content step-four">
                                <div class="row" >
                                    <div class="col-sm-7">
                                        <input type="hidden" name="_token" value="<?php echo  (!empty($token)?$token:null) ?>"/>
                                        <div class="form-group">
                                            <label for="email" class="col-sm-4 col-form-label">Email</label>
                                            <div class="col-sm-8">
                                                <input type="email" name="email" class="form-control" id="email" placeholder="Email" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="pass" class="col-sm-4 col-form-label">Password</label>
                                            <div class="col-sm-8">
                                                <input type="password" name="password" class="form-control" placeholder="Password" id="pass" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                        </div>
                                        <!-- /.End of step four -->
                                         <div class="row action_btns">
                                            <div class="text-center" id="wait_div">
                                                <h3 id="wait_msg">&nbsp;</h3>
                                            </div>
                                            <button class='btn btn-success pull-left aiia-wizard-button-previous prev_action logininfo hide'>Previous</button>
                                            <button type="submit" class='btn btn-success pull-right logininfo hide'>Next</button> 
                                        </div>
                                    </form>
                            </div>
                            <div class="aiia-wizard-step <?php echo (isset($_GET['complete'])?'active':'') ?>">
                                <h1>Complete</h1>
                                <div class="step-content step-five">

                                    <div class="col-sm-12">
                                        <?php
                                        if (!empty($message)) {
                                            echo "<div class=\"alert alert-danger\"><ul>$message</ul></div>";
                                        }else{
                                        ?> 
                                        <h3 class="title text-center margin">Installation complete</h3> 
                                        
                                        <div class="alert alert-success">
                                            <strong>Your application installed successfully !!!</strong>
                                        </div>
                                        <?php } ?>

                                        <div class="divider"></div>

                                        <h3 class="text-center" id="btn-before">&nbsp;</h3>
                                        <div class="text-center hide" id="btn-complete">
                                            <a href="index.php?complete=true&launchapp=true" class="btn btn-block cbtn">Finish Installation Process</a>
                                        </div>

                                    </div>

                                </div>
                                <!-- /.End of step five -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</div>
<!-- /.End of page wrapper -->
<footer class="footer text-center">
    <div class="container fText">
        <div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1">
            <div class="row">
                <div class="col-sm-6 text-left">Developed by <a  target="_blank" href="https://www.bdtask.com/">bdtask</a></div>
                <div class="col-sm-6  text-right"><a target="_blank" href="https://forum.bdtask.com/"><span class="glyphicon glyphicon-user"></span> Installation Support</a></div>
            </div>
        </div>
    </div>
</footer>
<!-- /.End of footer -->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="assets/js/jquery-3.5.1.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="assets/js/bootstrap.min.js"></script>
<!-- Wizard Script -->
<script src="assets/js/script.js"></script>
<script src="assets/js/ajax.js"></script>

</body>
</html>