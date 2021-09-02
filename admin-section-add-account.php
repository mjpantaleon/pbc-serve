<?php
/** Set flag that this is a parent file */
define( "MAIN", 1 );

//require connection to the database
require('db_con.php');

#START SESSION
session_name( 'imu_session' );
session_start();
$FN             = $_SESSION['fullname'];
$user_id        = $_SESSION['user_id'];
$ulevel         = $_SESSION['ulevel'];
$organization   = $_SESSION['organization'];

//if user dont have access then redirect them to unautorized page
if( ($user_id == '') && ($ulevel =='') )
{
    echo "<script>document.location.href='admin-login.php';</script>\n";
    exit();
}

#POST VARIABLE FOR MESSAGE PROMPT
$section    = $_REQUEST['id'];

$query  = " SELECT name FROM `section` WHERE id = '$section'";
$result = mysql_query($query);
$row    = mysql_fetch_array($result);  

$Message    = '';
$fullname   = '';
$username    = '';
$password   = '';


#gets the page name!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
$page = mysql_real_escape_string(basename($_SERVER['SCRIPT_NAME']));


    #IF ISSUE BUTTON HAS BEEN CLICKED OR DETECTED THEN!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    if(isset($_POST['cmdUpdate'])){

        $fullname   = mysql_real_escape_string($_POST['txtFN']);
        $username   = mysql_real_escape_string($_POST['txtUN']);
        $password   = 'pbcuser123';
        $position   = $section;      # IT
        $pw_change  = 1;
        $valid      = true;

        #checking
        if($fullname == ''){
            $valid = false;
        } elseif ($username == ''){
            $valid = false;
        }

        if($valid == true){
            #INSERT THIS IN THE DATABASE!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
            $query      = " INSERT INTO `staff` SET
                            `UN`     = '".$username."',
                            `PW`     = '".$password."',
                            `FN`     = '".$fullname."',
                            `position`     = '".$position."',
                            `pw_change`     = '".$pw_change."'

            ";
            mysql_query($query) or die(mysql_error());

            $fullname   = '';
            $username    = '';

            $Message = '
            <div class="alert alert-success">
                <i class="fa fa-check"></i> New account has been successfully added under '.$row['name'].' section.
            </div> ';
        }


    }
    #IF ISSUE BUTTON HAS BEEN CLICKED OR DETECTED THEN!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!


    if(isset($_POST['cmdDisable'])){

        $staff_id = $_POST['txtStaffCD'];



        $Message = '
        <div class="alert alert-success">
            <i class="fa fa-check"></i> Account has been disabled.'.$staff_id.'
        </div>
        ';
    }
?>
<?php include('admin-header.php'); ?>

        <!-- Content wrapper -->
        <div id="page-wrapper">

            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Sections & Accounts<small></small>
                    </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-gear"></i>  <a href="admin-maintenance.php">Admin Maintenance</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-home"></i> <a href="admin-section-list.php">Section List</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-user"></i> Add Account
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

                <p><?php echo $Message; ?></p>

                <div class="row">
                    <article class="col-md-5 col-sm-5">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="pull-right">&nbsp;</div>
                                <h4>Account Details</h4>
                            </div>
                            
                            <form method="post" action="">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <tbody>
                                            <tr>
                                                <th class='col-sm-4 col-xm-4'>Full Name</th>
                                                <td class='col-sm-8 col-xm-8'>
                                                    <input class="form-control" type="text" name='txtFN'
                                                    required placeholder='Example: Juan dela Cruz III' value="<?php echo $fullname; ?>"></input>
                                                </td>
                                            </tr>

                                            <tr>
                                                <th class='col-sm-4 col-xm-4'>User Name</th>
                                                <td class='col-sm-8 col-xm-8'>
                                                    <input class="form-control" type="text" name='txtUN'
                                                    required placeholder='jdcIII' value="<?php echo $username; ?>"></input>
                                                </td>
                                            </tr>

                                            <!-- <tr>
                                                <th class='col-sm-4 col-xm-4'>Password</th>
                                                    
                                                <td class='col-sm-8 col-xm-8'>
                                                    <input class='form-control' type='password' name='txtPW'
                                                    required placeholder='password' value="<?php #echo $password; ?>">
                                                </td>
                                            </tr> -->

                                            <tr>
                                                <th colspan='2' class='col-sm-12 col-xm-12'>
                                                    <input type='submit' class='btn btn-md btn-danger' name='cmdUpdate' value='ADD ACCOUNT'>
                                                </th>
                                            </tr>
                                            </form>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                            </form> 
                            <!-- /.row -->

                    </article>

                    <aside class="col-md-7 col-sm-7">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="pull-right">&nbsp;</div>
                                <h4><?php echo $row['name'] ?> Accounts</h4>
                            </div>
                            
                            <form method="post" action="">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <th>Fullname</th>
                                        <th>Username</th>
                                        <th>Status</th>
                                        <!-- <th>Action</th> -->
                                    </thead>
                                    <tbody>
                                    <?php

                                    $query  = " SELECT staff_id,FN, UN, disable_flag FROM `staff` WHERE position = '$section' ORDER BY staff_id DESC ";
                                    $result = mysql_query($query);
                                    while($row = mysql_fetch_array($result)){

                                        #POST VAR
                                        $staff_id   = $row['staff_id'];
                                        $FN         = $row['FN'];
                                        $UN         = $row['UN'];
                                        $disable_flag     = $row['disable_flag'];

                                        if($disable_flag == 0){
                                            $disable_flag = "Active";
                                        } else{
                                            $disable_flag = "In-active";
                                        }

                                        $div = "
                                        <tr>
                                            <td>".$FN."</td>
                                            <td>".$UN."</td>
                                            <td>".$disable_flag."</td>  
                                        </tr>
                                        ";

                                        echo $div;
                                    }
                                    // <button class='btn btn-danger btn-sm' title='remove account'>X</button>
                                    // <td>
                                    //     <a href ='admin-section-remove-account.php?id=".$staff_id."' 
                                    //     class='has-tooltip btn btn-info btn-xs' data-toggle='tooltip' 
                                    //     data-placement='left' title='disable account'>
                                    //     <span class='glyphicon glyphicon-lock'></span></a>
                                    // </td>
                                    ?>
                                        
                                    </tbody>
                                </table>
                            </div>
                            </form>
                            
                        </div>
                    </aside>

                    
                </div>
                <!-- /.row -->
            </div>
        </div>
        <!-- Content wrapper -->



    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="js/plugins/morris/raphael.min.js"></script>
    <!--<script src="js/plugins/morris/morris.min.js"></script>
    <script src="js/plugins/morris/morris-data.js"></script> -->

    <!-- FOR BOOTSTAP ADMIN -->
    <script src="js/plugins/dataTables/jquery.dataTables.js"></script>
    <!--<script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>-->

    <!-- for continouos fluid container
    <script src="js/sb-admin-2.js"></script>
    <script src="js/plugins/metisMenu/metisMenu.js"></script> -->

    <!-- JAVASCRIPT -->

<?php include('admin-footer.php'); ?>