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
                            My Pending Ticket <small></small>
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i>  <a href="personnel-main.php">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-ticket"></i> My Pending Ticket
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->


                <div class="row">
                    <article class="col-md-9 col-sm-6">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <h4>List of Tickets</h4>
                            </div>
                            
                            <div class="panel-body">
                                    <table class="table table-bordered table-striped table-hover make-dataTable">
                                        <thead>
                                            <tr>
                                                <th>Ticket code</th>
                                                <th>Subject</th>
                                                <th>Date</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php

                                        #DISPLAY A LIST OF TICKET THAT BELONGS TO THE PERSONNEL LOGGEDIN
                                        $query = "  SELECT t.`ticket_cd`, t.`SUBJ`, t.`ST`, t.`date`, f.`facility_name` 
                                                    FROM ticket_staff tf 
                                                    LEFT JOIN ticket t ON tf.`ticket_cd` = t.`ticket_cd` 
                                                    LEFT JOIN r_facility f ON t.`facility_cd` = f.`facility_cd` 
                                                    WHERE tf.`staff_cd` = '".$staff_cd."' AND `ST` = '0'
                                                    ORDER BY t.`ticket_cd` DESC ";
                                        $result     = mysql_query($query);
                                        while($row  = mysql_fetch_array($result))
                                        {
                                            #POST VARIABLES
                                            $ticket_cd  = $row['ticket_cd'];
                                            $subject    = $row['SUBJ'];
                                            #$facility   = $row['facility_name'];
                                            $date       = $row['date'];
                                            $ST         = $row['ST'];

                                            #RESULT TABLE
                                            $div = "
                                            <tr>
                                                <td class='col-sm-4 col-xm-4'>".$ticket_cd."</td>
                                                <td class='col-sm-5 col-xm-5'>".$subject."</td>
                                                <td class='col-sm-2 col-xm-2'>".date("F d, Y",strtotime($date))."</td>
                                                    <td class='col-sm-1 col-xm-1'> ";
                                                    if($ST != 1){
                                                    $div .=" 
                                                    <a href ='personnel-ticket-details.php?id=".$ticket_cd."' 
                                                    class='has-tooltip btn btn-success btn-xs' data-toggle='tooltip' 
                                                    data-placement='left' title='Click to view details'>
                                                    <span class='glyphicon glyphicon-search'></span></a>
                                                    ";
                                                    } else {
                                                    $div .=" 
                                                    <a href ='personnel-ticket-details.php?id=".$ticket_cd."' 
                                                    class='has-tooltip btn btn-warning btn-xs' data-toggle='tooltip' 
                                                    data-placement='left' title='Click to view details'>
                                                    <span class='glyphicon glyphicon-search'></span></a>
                                                    ";   
                                                    }
                                                   $div .=" 
                                                </td>
                                            </tr>
                                            ";
                                            echo $div;
                                        }
                                        #END WHILE
                                        ?>

                                           
                                        </tbody>
                                    </table>
                                
                            </div>
                            <!-- /.row -->
                    </article>

                    <!-- <aside class="col-md-3 col-sm-6">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <div class="pull-right">
                                </div>
                                <h4>What do you want to do?</h4>
                            </div>
                            
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover" id="dataTables-example">
                                        <tr>
                                            <td class='warning'>
                                                <a href='personnel-create-ticket.php'>
                                                    <i class="fa fa-edit"></i>&nbsp;&nbsp;Create New
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </aside> -->
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
        $('.make-dataTable').dataTable({
            order : [[0,'desc']]
        });             
        $('.has-tooltip').tooltip();                      
    });
    
    </script>
    <!-- JAVASCRIPT -->

<?php include('admin-footer.php'); ?>