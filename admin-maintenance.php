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
if( ($user_id == '') && ($ulevel == '') )
{
    echo "<script>document.location.href='admin-login.php';</script>\n";
    exit();
}


#POST VARIABLE FOR MESSAGE PROMPT
$Message = '';
    
?>

<?php include('admin-header.php'); ?>

        <!-- Content wrapper -->
        <div id="page-wrapper">

            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Admin Maintenance <!-- <small>Statistics Overview</small> -->
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-gear"></i> Admin Maintenance
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->


                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-ticket fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <?php
                                        $query      = " SELECT count(`request_id`) as count FROM `request_type` WHERE `disable_flag` = '0' ";
                                        $result     = mysql_query($query);
                                        $row        = mysql_fetch_assoc($result);
                                        $request_type   = $row['count'];
                                        ?>
                                        <div class="huge"><?php echo $request_type; ?></div>
                                        <div>Request Type</div>
                                    </div>
                                </div>
                            </div>
                            <a href="admin-request-list.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-home fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <?php
                                        $query      = " SELECT count(`id`) as count FROM `section` WHERE `disable_flag` = '0' ";
                                        $result     = mysql_query($query);
                                        $row        = mysql_fetch_assoc($result);
                                        $request_type   = $row['count'];
                                        ?>
                                        <div class="huge"><?php echo $request_type; ?></div>
                                        <div>Sections</div>
                                    </div>
                                </div>
                            </div>
                            <a href="admin-section-list.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    
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