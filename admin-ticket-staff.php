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
$Message = '';

#IF TICKET CODE IS MISSING THEN REDIRRECT THIS TO THIS PAGE!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
if(!isset($_GET['id'])) {
    header('location:admin-ticket-list.php');
}
#IF TICKET CODE IS MISSING THEN REDIRRECT THIS TO THIS PAGE!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

if(isset($_POST['staff_cd'])){
    $query = "DELETE FROM ticket_staff WHERE ticket_cd = '".$_GET['id']."' ";
    mysql_query($query);

    foreach($_POST['staff_cd'] as $staff_cd){
        $staff_cd = mysql_real_escape_string($staff_cd);

        $query = "INSERT INTO ticket_staff VALUES(null,'".$_GET['id']."','".$staff_cd."')";
        mysql_query($query);
    }

    #MUST LOG THIS EVENT!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    $time_in = date("H:i:sa");              
    $cur_date = date("Y-m-d");
    $cur_timestamp = $cur_date." ".$time_in;  //concatinate time + current date

    $query = "    INSERT INTO `log_trail` SET 
            `TS`        = '".$cur_timestamp."', 
            `user_id`   = '".$user_id."', 
            `action`    = '[ ".$FN." ] Deploy staff/s under ticket [ ".$_GET['id']." ] at page [".$page."]'  
    ";
    mysql_query($query) or die(mysql_error());
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
                            Assign Staff<small>&nbsp;</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="admin-main.php">Dashboard</a>
                            </li>
                            <li>
                                <i class="fa fa-ticket"></i>  <a href="admin-ticket-list.php">Tickets</a>
                            </li>
                            <li>
                                <i class="fa fa-th-list"></i> <a href="admin-ticket-details.php?id=<?php echo $_GET['id'] ?>">Ticket Details</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-th-list"></i> Assign Staff
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

                <p><?php echo $Message; ?></p>

                <div class="row">
                    <article class="col-lg-8 col-sm-6">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <!--<span class="pull-right"><a href="">Sign Up</a></span>-->
                                <div class="pull-right">
                                    <!--<input type="text" class="form-control" name="txtSearch" placeholder="Search by Donation ID" autofocus />-->
                                </div>
                                <h4>Assign Staff</h4>
                            </div>
                            
                            <form method="post">
                            <div class="panel-body">
                            <?php
                            #GET TICKET DETAILS=====================================================================
                            $ticket_cd      = $_GET['id'];

                            $query          = " SELECT t.*, f.`facility_name` 
                                                FROM `ticket` t
                                                LEFT JOIN `r_facility` f ON t.`facility_cd` = f.`facility_cd`
                                                WHERE `ticket_cd` = '".$ticket_cd."'
                            ";
                            $result         = mysql_query($query);
                            $row            = mysql_fetch_array($result);
                            #LOCAL VARIABLES
                            $ticket_cd      = $row['ticket_cd'];
                            $request_type   = $row['request_type'];
                            $facility       = $row['facility_name'];
                            $decription     = $row['problem_desc'];
                            $date           = $row['date'];
                            $remarks        = $row['remarks'];


                            $query2         = " SELECT stf.`FN`, ts.`ticket_cd`
                                                FROM `staff` stf
                                                LEFT JOIN `ticket_staff` ts ON stf.`staff_cd` = ts.`staff_cd`
                                                WHERE `ticket_cd` = '".$ticket_cd."'
                            ";
                            $rs             = mysql_query($query2);
                            $staff          = [];
                            ?>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <tbody>

                                            <tr>
                                                <th class='col-sm-4 col-xm-4'>Ticket code</th>
                                                <td class='col-sm-8 col-xm-8'><?php echo $ticket_cd; ?></td>
                                            </tr>

                                            <tr>
                                                <th class='col-sm-4 col-xm-4'>Request Type</th>
                                                <td class='col-sm-8 col-xm-8'><?php echo $request_type; ?></td>
                                            </tr>

                                            <tr>
                                                <th class='col-sm-4 col-xm-4'>Facility</th>
                                                <td class='col-sm-8 col-xm-8'><?php echo $facility; ?></td>
                                            </tr>

                                            <tr>
                                                <th class='col-sm-4 col-xm-4'>Description</th>
                                                <td class='col-sm-8 col-xm-8'><?php echo $decription; ?></td>
                                            </tr>

                                            <tr>
                                                <th class='col-sm-4 col-xm-4'>Date</th>
                                                <td class='col-sm-8 col-xm-8'><?php echo date("F d, Y",strtotime($date)); ?></td>
                                            </tr>

                                            <tr>
                                                <th class='col-sm-4 col-xm-4'>Remarks</th>
                                                <td class='col-sm-8 col-xm-8'><?php echo $remarks; ?></td>
                                            </tr>

                                            <tr>
                                                <th class='col-sm-4 col-xm-4'>Staff/s</th>
                                                <td class='col-sm-8 col-xm-8'>
                                                    <?php 
                                                        while($row2     = mysql_fetch_assoc($rs)){
                                                        $staff      = $row2['FN']; 

                                                        echo ' [ '.$staff.' ] ';  
                                                    } 
                                                    ?> <span style='font-size: 10px; color: #666; '>* read only</span>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>

                            </div>
                            </form>
                            <!-- /.row -->
                                   
                    </article>

                    <aside class="col-lg-4 col-sm-6">
                        


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

    <!-- for continouos fluid container
    <script src="js/sb-admin-2.js"></script>
    <script src="js/plugins/metisMenu/metisMenu.js"></script> -->

<?php include('admin-footer.php'); ?>