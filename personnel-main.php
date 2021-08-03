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
?>
<?php include('personnel-header.php'); ?>

        <!-- Content wrapper -->
        <div id="page-wrapper">

            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Dashboard <small>Statistics Overview</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i> Dashboard
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->


                <div class="row">
                   <div class="col-lg-3 col-md-6">
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-ticket fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <?php
                                        #FIND HOW MANY TICKET DOES THIS USER HAVE
                                       /* $query      = " SELECT count(`ticket_cd`) as count 
                                                        FROM `ticket` 
                                                        WHERE `created_by` = '".$staff_cd."'
                                                        AND `ST` = '0' ";*/
                                        $query      = " SELECT count('t.ticket_cd') AS count, ts.staff_cd 
                                                        FROM `ticket` t
                                                        LEFT JOIN `ticket_staff` ts ON (t.ticket_cd = ts.ticket_cd) 
                                                        WHERE `staff_cd` = '".$staff_cd."'
                                                        AND `ST` = '0' ";
                                        $result     = mysql_query($query);
                                        $row        = mysql_fetch_assoc($result);
                                        $Tickets    = $row['count'];
                                        $pending_tikets = $Tickets;
                                        ?>
                                        <div class="huge"><?php echo $Tickets; ?></div>
                                        <div>Pending Tickets!</div>
                                    </div>
                                </div>
                            </div>
                            <a href="personnel-ticket-list.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>


                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-warning">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-ticket fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <?php
                                        #FIND HOW MANY TICKET DOES THIS USER HAVE
                                        $query      = " SELECT count(`ticket_cd`) as count 
                                                        FROM `ticket` 
                                                        WHERE `created_by` = '".$staff_cd."'
                                                        AND `ST` = '1' ";
                                        $result     = mysql_query($query);
                                        $row        = mysql_fetch_assoc($result);
                                        $Tickets    = $row['count'];
                                        $accomplished_tikets = $Tickets;
                                        ?>
                                        <div class="huge"><?php echo $Tickets; ?></div>
                                        <div>Accomplished Tickets!</div>
                                    </div>
                                </div>
                            </div>
                            <a href="#">
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

                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div id="plot">
                            
                        </div>
                    </div>
                </div><!-- /.row -->

            </div>
        </div>
        <!-- Content wrapper -->


    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- jqplot -->
    <script type="text/javascript" src="js/plugins/jqplot/jquery.jqplot.min.js"></script>
    <link rel="stylesheet" type="text/css" href="js/plugins/jqplot/jquery.jqplot.min.css">
    <script type="text/javascript" src="js/plugins/jqplot/plugins/jqplot.pieRenderer.min.js"></script>
    <script type="text/javascript" src="js/plugins/jqplot/plugins/jqplot.donutRenderer.min.js"></script>
    <script type="text/javascript">
        $(function(){
            $.jqplot("plot",[[['&nbsp;&nbsp;&nbsp;Accomplished Tickets',<?php echo $accomplished_tikets ?>],['&nbsp;&nbsp;&nbsp;Pending Tickets',<?php echo $pending_tikets ?>]]],{
                animate : true,
                seriesDefaults: {
                    renderer : $.jqplot.DonutRenderer,
                    rendererOptions : {
                        sliceMargin : 5,
                        showDataLabels : true
                    }
                },
                legend : {
                    show : true,
                    location : 'e',
                    xoffset : 50
                }
            });

        });
    </script>
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