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

    #gets the page name!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    $page = mysql_real_escape_string(basename($_SERVER['SCRIPT_NAME']));
?>

<?php include('admin-header.php'); ?>

    <!-- Content wrapper -->
        <div id="page-wrapper">

            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Ticket Details<small>&nbsp;</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i>  <a href="admin-main.php">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-ticket"></i>  <a href="admin-ticket-list.php">My Tickets</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-th-list"></i> Ticket Details
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
                                <h4>Ticket Details</h4>
                            </div>
                            
                            
                            <div class="panel-body">
                            <?php
                            #GET TICKET DETAILS=====================================================================
                            $ticket_cd      = $_GET['id'];

                            $query          = " SELECT t.*, f.`name`
                                                FROM `ticket` t
                                                LEFT JOIN `section` f ON t.`facility_cd` = f.`id`
                                                WHERE `ticket_cd` = '".$ticket_cd."'
                            ";
                            $result         = mysql_query($query);
                            $row            = mysql_fetch_array($result);
                            #LOCAL VARIABLES
                            $ticket_cd      = $row['ticket_cd'];
                            $request_type   = $row['request_type'];
                            $facility       = $row['name'];
                            $decription     = $row['problem_desc'];
                            $date           = $row['date'];
                            $st             = $row['ST'];


                            $query2         = " SELECT stf.`FN`, stf.`position`, ts.`ticket_cd`
                                                FROM `staff` stf
                                                LEFT JOIN `ticket_staff` ts ON stf.`staff_cd` = ts.`staff_cd`
                                                WHERE `ticket_cd` = '".$ticket_cd."'
                            ";
                            $rs             = mysql_query($query2);
                            $staff          = [];
                            


                            ?>
                                <form method="post">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <tbody>

                                            <tr>
                                                <th class='col-sm-4 col-xm-4'>Ticket code</th>
                                                <td colspan='3' class='col-sm-8 col-xm-8'>
                                                    <?php echo $ticket_cd; ?>
                                                    <!--<span style='font-size: 10px; color: #666; '>* read only</span>-->
                                                </td>
                                            </tr>

                                            <tr>
                                                <th class='col-sm-4 col-xm-4'>Request Type</th>
                                                <td class='col-sm-6 col-xm-6'>
                                                    <?php echo $request_type; ?>
                                                </td>
                                                <!--<td class='cols-sm-2 col-xm-2'>
                                                    <a href='' class='btn btn-sm btn-info' title='Change request type'
                                                    data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">
                                                        <span class='glyphicon glyphicon-list-alt'></span>
                                                    </a>
                                                </td>-->
                                            </tr>

                                            <tr>
                                                <th class='col-sm-4 col-xm-4'>Description</th>
                                                <td colspan='3' class='col-sm-8 col-xm-8'>
                                                    <?php echo nl2br($decription); ?>
                                                </td>
                                            </tr>

                                            <tr>
                                                <th class='col-sm-4 col-xm-4'>Section</th>
                                                <td class='col-sm-8 col-xm-8'>
                                                    <?php echo $facility; ?>
                                                </td>
                                                <!--<td class='cols-sm-2 col-xm-2'>
                                                    <a href='' class='btn btn-sm btn-info' title='Change facility'
                                                    data-toggle="modal" data-target="#exampleModal2" data-whatever="@mdo">
                                                        <span class='glyphicon glyphicon-home'></span>
                                                    </a>
                                                </td>-->
                                            </tr>

                                            <tr>
                                                <th class='col-sm-4 col-xm-4'>Date</th>
                                                <td colspan='3' class='col-sm-8 col-xm-8'>
                                                    <?php echo date("F d, Y",strtotime($date)); ?>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan='3' colspan='2' class='col-sm-12 col-xm-12'>&nbsp;</td>
                                            </tr>

                                              
                                            <?php 
                                            while($row2     = mysql_fetch_assoc($rs)){
                                            $staff      = $row2['FN'];
                                            $position   = $row2['position']; 

                                            echo "
                                            <tr> 
                                                <th class='col-sm-4 col-xm-4'>Assigned Staff</th>
                                                <td colspan='3' class='col-sm-8 col-xm-8'>
                                                    ".$staff." (".$position.")
                                                </td>
                                            </tr>
                                            ";  
                                            } 
                                            ?>


                                            <tr>
                                                <th class='col-sm-4 col-xm-4'>Status Update</th>
                                                <td colspan='3' class='col-sm-8 col-xm-8'>
                                                    <?php 
                                                    if($st == 0){
                                                        $st = '<span class="label label-success">In progress</span>';
                                                    }
                                                    elseif ($st == 1) {
                                                        $st = '<span class="label label-warning">Accomplished</span>';
                                                    }

                                                    echo $st; ?>
                                                </td>
                                            </tr>
                                                
                                            <!--<tr>
                                                <th colspan='3' colspan='2' class='col-sm-12 col-xm-12'>
                                                    <input type='submit' class='btn btn-md btn-warning' name='cmdUpdate' value='UPDATE'>
                                                </th>
                                            </tr>-->

                                        </tbody>
                                    </table>
                                </div>
                                </form>

                            </div>
                            
                            <!-- /.row -->

                    </article>

                    <aside class="col-md-3 col-sm-6">
                        <?php include('admin-cticket-aside.php') ?>
                    </aside>

                    <!-- MODAL POPUP DIV -->
                    <?php include('request-popup.php'); ?>
                    <?php include('facility-popup.php'); ?>
                    <!-- MODAL POPUP DIV -->


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

    <!-- MODAL POPUP -->
    <script type="text/javascript">
     $('#exampleModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var recipient = button.data('whatever') // Extract info from data-* attributes
      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      var modal = $(this)
      //modal.find('.modal-title').text('Add New Item under Mens Perfume ')
    
    });


      $('#exampleModal2').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var recipient = button.data('whatever') // Extract info from data-* attributes
      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      var modal = $(this)
      //modal.find('.modal-title').text('Add New Item under Mens Perfume ')
    
    });
    </script>
    <!-- MODAL POPUP -->


<?php include('admin-footer.php'); ?>