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
$Message    = '';
$fullname   = '';
$username    = '';
$password   = '';


#gets the page name!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
$page = mysql_real_escape_string(basename($_SERVER['SCRIPT_NAME']));


    #IF ISSUE BUTTON HAS BEEN CLICKED OR DETECTED THEN!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    if(isset($_POST['cmdUpdate'])){

        $fullname   = mysql_real_escape_string($_POST['txtFN']);
        $username    = mysql_real_escape_string($_POST['txtUN']);
        $password   = 'pbcuser123';
        $position   = 1;      # IT
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
                <i class="fa fa-check"></i> New account has been successfully added under this section.
            </div> ';
        }


    }
    #IF ISSUE BUTTON HAS BEEN CLICKED OR DETECTED THEN!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
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
                    <article class="col-md-9 col-sm-6">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <!--<span class="pull-right"><a href="">Sign Up</a></span>-->
                                <div class="pull-right">
                                    <!--<input type="text" class="form-control" name="txtSearch" placeholder="Search by Donation ID" autofocus />-->
                                </div>
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