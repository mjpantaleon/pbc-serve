<?php
/** Set flag that this is a parent file */
define( "MAIN", 1 );

//require connection to the database
require('db_con.php');

#POST VARIABLE FOR MESSAGE PROMPT
$Message = '';
    
?>

<?php include('index-header.php'); ?>

        <!-- Content wrapper -->
        <div id="page-wrapper">
        

            <div class="container-fluid">
                <div class="jumbotron">
                    <h1 class="display-4">Terms of Service Agreement</h1>
                    <hr class="my-4">
                    <p class="lead">Welcome to PBC-Serve Client Support Site! IMPORTANT – PLEASE READ CAREFULLY:</p>
                    <p>By accessing or using our sites and our services, you hereby agree to be bound by the terms and all terms incorporated herein by reference. 
                    <br><br>It is the responsibility of you, the requestor, the user, customer or prospective customer to be accountable of what the situation may occur. 
                    If you do not expressly agree to all of the terms and conditions, then please do no access or use our sites or our services. 
                    <br><br>These terms of service agreement is effective as of Month/Day/Year.</p>

                    <p><img src="images/pbc_logo.jpg" width="190px" height="150px"></p>
                </div>

                <!-- Page Heading -->
                <!-- <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Terms of Service Agreement
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i> Dashboard
                            </li>
                        </ol>
                    </div>
                </div> -->
                <!-- /.row -->


                <!-- <div class="row">
                    <div class="col-lg-12">
                   
                    </div>
                </div> -->

                    <!-- <div class="col-lg-3 col-md-6">
                        <div class="panel panel-warning">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-list-alt fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">&nbsp;</div>
                                        <div>&nbsp;</div>
                                    </div>
                                </div>
                            </div>
                            <a href="create-request.php">
                                <div class="panel-footer">
                                    <span class="pull-left">CREATE NEW REQUEST</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div> -->

                    <!-- 
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-warning">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-tasks fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <?php
                                        $query      = " SELECT count(`staff_cd`) as count FROM `staff` WHERE `disable_flag` = 0 ";
                                        $result     = mysql_query($query);
                                        $row        = mysql_fetch_assoc($result);
                                        $Staffs     = $row['count'];
                                        ?>
                                        <div class="huge"><?php echo $Staffs; ?></div>
                                        <div>IMU Staffs</div>
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
                    </div> -->
                    
                    <!-- <div class="col-lg-3 col-md-6">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-support fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <?php
                                        $query      = " SELECT count(`ticket_cd`) as count FROM `ticket` WHERE `disable_flag` = 0 ";
                                        $result     = mysql_query($query);
                                        $row        = mysql_fetch_assoc($result);
                                        $Tickets    = $row['count'];
                                        ?>
                                        <div class="huge"><?php echo $Tickets; ?></div>
                                        <div>Ticket Count</div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-footer">
                                <span class="pull-left">&nbsp;</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div> -->
                <!-- </div> -->
                <!-- /.row -->


            </div>
        </div>
        <!-- Content wrapper -->

    </div>
    <!-- div wrapper -->




    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="js/plugins/morris/raphael.min.js"></script>
    <script src="js/plugins/morris/morris.min.js"></script>
    <script src="js/plugins/morris/morris-data.js"></script>


</body>

</html>