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

#gets the page name!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
$page = mysql_real_escape_string(basename($_SERVER['SCRIPT_NAME']));


//if user dont have access then redirect them to unautorized page
if( ($user_id == '') && ($ulevel =='') )
{
    echo "<script>document.location.href='admin-login.php';</script>\n";
    exit();
}


#POST VARIABLE FOR MESSAGE PROMPT
$Message = '';

    #IF ADD BUTTON HAS BEEN CLICK/ DETECTED THEN
    if (isset($_POST['cmdAdd'])) {

        #POST VARIABLES
        $request    = mysql_real_escape_string(trim($_POST['txtRequest']));
        $valid      = true;

        if ($request == '') {
            $valid = false;
        }


        if ($valid == true) {
            # code...
            $query  = "INSERT INTO `section` SET `name` = '".$request."' ";
            mysql_query($query) or die(mysql_error());


            #MUST LOG THIS EVENT
            $time_in = date("H:i:sa");              
            $cur_date = date("Y-m-d");
            $cur_timestamp = $cur_date." ".$time_in;  //concatinate time + current date
            
            $query = "    INSERT INTO `log_trail` SET 
                    `TS`        = '".$cur_timestamp."', 
                    `user_id`   = '".$user_id."', 
                    `action`    = '[ ".$FN." ] Added a new Section at page [".$page."]'  
            ";
            mysql_query($query) or die(mysql_error());


            #PROMPT MESSAGE
            $Message = '
            <div class="alert alert-info">
               <i class="fa fa-ticket"></i> New Section <strong>[ '.$request.' ]</strong> 
               has been successfully added.
            </div>
            ';
            # code...
        }

        
    }
    #IF ADD BUTTON HAS BEEN CLICK/ DETECTED THEN

?>

<?php include('admin-header.php'); ?>
        <!-- Content wrapper -->
        <div id="page-wrapper">

            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Add Section <small></small>
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-gear"></i>  <a href="admin-maintenance.php">Admin Maintenance</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-ticket"></i> <a href="admin-section-list.php">Section List</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-edit"></i> Add Section
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
                                <h4>Type of Request List</h4>
                            </div>
                            
                            <form method="post">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <tbody>
                                            <tr>
                                                <th class='col-sm-4 col-xm-4'>Section</th>
                                                
                                                <td class='col-sm-8 col-xm-8'>
                                                    <input type='text' class='form-control' name='txtRequest' required
                                                    placeholder='Please Enter Section here...' value='' >
                                                </td>
                                            </tr>

                                            <tr>
                                                <th colspan='2' class='col-sm-12 col-xm-12'>
                                                    <input type='submit' class='btn btn-md btn-warning' name='cmdAdd' value='Add Request'>
                                                </th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                            </form>
                        <!-- /.row -->
                    </article>

                    <aside class="col-md-3 col-sm-6">
                        <!-- NO CONTENT-     -->
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

    <script type="text/javascript">
    $(document).ready(function() {  
        $('.make-dataTable').dataTable();             
        $('.has-tooltip').tooltip();                      
    });
    
    </script>
    <!-- JAVASCRIPT -->

<?php include('admin-footer.php'); ?>