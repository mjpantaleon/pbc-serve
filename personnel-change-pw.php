<?php
/** Set flag that this is a parent file */
define( "MAIN", 1 );

//require connection to the database
require('db_con.php');

#START SESSION
session_name( 'imu_session_personnel' );
session_start();
$staff_cd = $_SESSION['staff_cd'];
$Username = $_SESSION['UN'];
$fullname = $_SESSION['FN'];


//if user dont have access then redirect them to unautorized page
if($staff_cd == ''){
    echo "<script>document.location.href='personnel-login.php';</script>\n";
    exit();
}


#POST VARIABLE FOR MESSAGE PROMPT
$Message = '';

#gets the page name!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
$page = mysql_real_escape_string(basename($_SERVER['SCRIPT_NAME']));


    #IF ISSUE BUTTON HAS BEEN CLICKED OR DETECTED THEN!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    if(isset($_POST['cmdUpdate'])){
        $PW = $_POST['txtPW'];

        if(!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,15}$/', $PW)) {
            $Message = '<div class="alert alert-danger">The password('.$PW.') does not meet the requirements!</div>';
        }

        else{
            #UPDATE PASSWORD OF THIS USER
            $query      = "UPDATE `staff` SET `PW` = '".$PW."' WHERE `staff_cd` = '".$staff_cd."' ";
            mysql_query($query) or die(mysql_error());

            #LOG THIS EVENT
            $time_in = date("H:i:sa");              
            $cur_date = date("Y-m-d");
            $cur_timestamp = $cur_date." ".$time_in;  //concatinate time + current date
            
            $query = "    INSERT INTO `log_trail` SET 
                    `TS`        = '".$cur_timestamp."', 
                    `user_id`   = '".$staff_cd."', 
                    `action`    = '[ ".$fullname." ] updated his password at page [".$page."]'  
            ";
            mysql_query($query) or die(mysql_error());

            $Message = '
            <div class="alert alert-success">
               <i class="fa fa-check"></i> Password has been successfully changed.
            </div> ';
        }
    }
    #IF ISSUE BUTTON HAS BEEN CLICKED OR DETECTED THEN!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
?>
<?php include('personnel-header.php'); ?>

        <!-- Content wrapper -->
        <div id="page-wrapper">

            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Account Details<small>&nbsp;</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i>  <a href="personnel-main.php">Dashboard</a>
                            </li>
                            
                            <li class="active">
                                <i class="fa fa-edit"></i> Account Details
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

                <p><?php echo $Message; ?></p>

                <div class="row">
                    <article class="col-md-9 col-sm-6">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <!--<span class="pull-right"><a href="">Sign Up</a></span>-->
                                <div class="pull-right">
                                    <!--<input type="text" class="form-control" name="txtSearch" placeholder="Search by Donation ID" autofocus />-->
                                </div>
                                <h4>Account Details</h4>
                            </div>
                            
                            
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <tbody>
                                            <tr>
                                                <th class='col-sm-4 col-xm-4'>Full Name</th>
                                                <td class='col-sm-8 col-xm-8'>
                                                    <input class="form-control" type="text" name='txtFN' 
                                                    readonly="readonly" value="<?php echo $fullname; ?>"></input>
                                                </td>
                                            </tr>

                                            <tr>
                                                <th class='col-sm-4 col-xm-4'>User Name</th>
                                                <td class='col-sm-8 col-xm-8'>
                                                    <input class="form-control" type="text" name='txtUN' 
                                                    readonly="readonly" value="<?php echo $Username; ?>"></input>
                                                </td>
                                            </tr>

                                            <form method='post'>
                                            <?php
                                            $query      = "SELECT `PW` FROM `staff` WHERE `staff_cd` = '".$staff_cd."' ";
                                            $result     = mysql_query($query);
                                            $row        = mysql_fetch_assoc($result);
                                            $PW         = $row['PW'];
                                            ?>
                                            <tr>
                                                <th class='col-sm-4 col-xm-4'>Password</th>
                                                    
                                                <td class='col-sm-8 col-xm-8'>
                                                    <input class='form-control' type='password' name='txtPW'
                                                    required placeholder='password' value="<?php echo $PW; ?>">
                                                </td>
                                            </tr>

                                            
                                            
                                            <tr>
                                                <th colspan='2' class='col-sm-12 col-xm-12'>
                                                    <input type='submit' class='btn btn-md btn-warning' name='cmdUpdate' value='Update Account'>
                                                </th>
                                            </tr>
                                            </form>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                            <!-- /.row -->

                    </article>

                    
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

    <!-- for continouos fluid container
    <script src="js/sb-admin-2.js"></script>
    <script src="js/plugins/metisMenu/metisMenu.js"></script> -->

<?php include('admin-footer.php'); ?>