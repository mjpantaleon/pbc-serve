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
$position = $_SESSION['position']; 


//if user dont have access then redirect them to unautorized page
if($staff_cd == ''){
    echo "<script>document.location.href='personnel-login.php';</script>\n";
    exit();
}


#POST VARIABLE FOR MESSAGE PROMPT
$Message = '';

    #IF TICKET CODE IS MISSING THEN REDIRRECT THIS TO THIS PAGE!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    if(!isset($_GET['id'])) {
        header('location:personnel-ticket-list.php');
    }
    #IF TICKET CODE IS MISSING THEN REDIRRECT THIS TO THIS PAGE!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

    #gets the page name!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    $page = mysql_real_escape_string(basename($_SERVER['SCRIPT_NAME']));


    #Ticket code
    $ticket_cd  = $_GET['id'];

    #IF ACCOMPLISHED BUTTON HAS BEEN CLICKED OR DETECTED||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    if(isset($_POST['cmdUpdate'])){

        #UPDATE STATUS INTO ACCOMPLISHED
        $query = " UPDATE `ticket` SET `ST` = '1' WHERE `ticket_cd` = '".$ticket_cd."' ";
        mysql_query($query) or die(mysql_error());


        #MUST LOG THIS EVENT!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        $time_in = date("H:i:sa");              
        $cur_date = date("Y-m-d");
        $cur_timestamp = $cur_date." ".$time_in;  //concatinate time + current date
        
        $query = "  INSERT INTO `log_trail` SET 
                    `TS`        = '".$cur_timestamp."', 
                    `user_id`   = '".$staff_cd."', 
                    `action`    = '[ ".$fullname." ] flagged ticket [ ".$ticket_cd." ] as Accomplished at page [".$page."]'  
        ";
        mysql_query($query) or die(mysql_error());

        #PROMT MESSAGE!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        $Message ='        
        <div class="alert alert-info">
           <i class="fa fa-ticket"></i> Ticket <strong>[ '.$ticket_cd.' ]</strong> has been flagged as <b>Accomplished</b>.
        </div> 
        ';
    }
    #IF ACCOMPLISHED BUTTON HAS BEEN CLICKED OR DETECTED|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||


    #GET TICKET DETAILS=====================================================================
    $ticket_cd      = $_GET['id'];
    
    $query          = " SELECT t.*, f.`FN`
                        FROM `ticket` t
                        LEFT JOIN `staff` f ON t.`created_by` = f.`staff_cd`
                        WHERE `ticket_cd` = '".$ticket_cd."'
    ";
    $result         = mysql_query($query);
    $row            = mysql_fetch_array($result);
    #LOCAL VARIABLES
    $ticket_cd      = $row['ticket_cd'];
    $request_type   = $row['request_type'];
    $subject        = $row['SUBJ'];
    $requested_by   = $row['FN'];
    $decription     = $row['problem_desc'];
    $urgency        = $row['severity'];
    $date           = $row['date'];
    $st             = $row['ST'];

    $query  = " SELECT name FROM section WHERE id = '$request_type'";
    $result = mysql_query($query);
    $row = mysql_fetch_assoc($result);
    #GET TICKET DETAILS=====================================================================
?>

<?php include('personnel-header.php'); ?>


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
                                <i class="fa fa-dashboard"></i>  <a href="personnel-main.php">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-ticket"></i>  <a href="personnel-ticket-list.php">My Ticket</a>
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
                           


                            // $query2         = " SELECT stf.`FN`, stf.`position`, ts.`ticket_cd`
                            //                     FROM `staff` stf
                            //                     LEFT JOIN `ticket_staff` ts ON stf.`staff_cd` = ts.`staff_cd`
                            //                     WHERE `ticket_cd` = '".$ticket_cd."'
                            // ";
                            // $rs             = mysql_query($query2);
            

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
                                                <th class='col-sm-4 col-xm-4'>Job Request</th>
                                                <td class='col-sm-6 col-xm-6'>
                                                    <?php echo $row['name']; ?>
                                                </td>
                                                <!--<td class='cols-sm-2 col-xm-2'>
                                                    <a href='' class='btn btn-sm btn-info' title='Change request type'
                                                    data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">
                                                        <span class='glyphicon glyphicon-list-alt'></span>
                                                    </a>
                                                </td>-->
                                            </tr>

                                            <tr>
                                                <th class='col-sm-4 col-xm-4'>Subject</th>
                                                <td class='col-sm-6 col-xm-6'>
                                                    <?php echo $subject; ?>
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
                                                    <?php echo $decription; ?>
                                                </td>
                                            </tr>

                                            <tr>
                                                <th class='col-sm-4 col-xm-4'>Section</th>
                                                <td class='col-sm-8 col-xm-8'>
                                                    <?php echo $requested_by; ?>
                                                </td>
                                                <!--<td class='cols-sm-2 col-xm-2'>
                                                    <a href='' class='btn btn-sm btn-info' title='Change facility'
                                                    data-toggle="modal" data-target="#exampleModal2" data-whatever="@mdo">
                                                        <span class='glyphicon glyphicon-home'></span>
                                                    </a>
                                                </td>-->
                                            </tr>

                                            <tr>
                                                <th class='col-sm-4 col-xm-4'>Urgency</th>
                                                <td colspan='3' class='col-sm-8 col-xm-8'>
                                                    <?php echo $urgency ; ?>
                                                </td>
                                            </tr>

                                            <tr>
                                                <th class='col-sm-4 col-xm-4'>Date</th>
                                                <td colspan='3' class='col-sm-8 col-xm-8'>
                                                    <?php echo date("F d, Y",strtotime($date)); ?>
                                                </td>
                                            </tr>

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

                                            <tr>
                                                <td colspan='3' colspan='2' class='col-sm-12 col-xm-12'>
                                                    <!-- 
                                                    Author : Kevin 
                                                    Date   : 2015-05-08
                                                    -->
                                                    <?php include "ticket-popup.php"; ?>
                                                    <?php
                                                    $query = "SELECT r.staff_cd,r.remarks,st.FN,r.created_dt 
                                                    FROM ticket_remarks r 
                                                    LEFT JOIN staff st ON (r.staff_cd = st.staff_cd) 
                                                    WHERE r.ticket_cd = '$ticket_cd'
                                                    ORDER BY `created_dt` DESC ";
                                                    $rs = mysql_query($query);
                                                    ?>
                                                    <table class="table table-bordered table-striped">
                                                        <tr>
                                                            <th width="150">Staff</th><th>Remarks</th><th width="200">Date</th>
                                                        </tr>
                                                        <?php if(mysql_num_rows($rs) == 0): ?>
                                                        <tr>
                                                            <td colspan="3" align="center">No Remarks Yet</td>
                                                        </tr>
                                                        <?php else: ?>
                                                            <?php while($r = mysql_fetch_object($rs)): ?>
                                                            <tr>
                                                                <td><?=$r->FN?></td><td><?=nl2br($r->remarks)?></td><td><?=date("F d, Y h:i:s A",strtotime($r->created_dt))?></td>
                                                            </tr>    
                                                            <?php endwhile; ?>
                                                        <?php endif; ?>
                                                        <tr>

                                                            <?php 
                                                            if($position != 3){
                                                            $div    = '
                                                            <td colspan="3">
                                                                <a class="btn btn-xs btn-primary" href="#" data-toggle="modal" data-target="#addTicketRemarks" >Add Remarks</a>
                                                            </td>
                                                            ';
                                                            echo $div;
                                                            }
                                                            ?>
                                                            
                                                        </tr>
                                                    </table>

                                                    <!-- End -->
                                                </td>
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

                                        </tbody>
                                    </table>
                                </div>
                                </form>

                            </div>
                            
                            <!-- /.row -->

                    </article>

                    <?php 
                    if($position != 3){
                            
                        $div    = "
                        <aside class='col-md-3 col-sm-6'>
                            <div class='panel-body'>
                                <form method='post'>
                                
                                    <input type='submit' class='btn btn-md btn-warning' name='cmdUpdate' 
                                    value='FLAG AS ACCOMPLISHED'>
                                
                                </form>
                            </div>
                        </aside>
                        ";
                        echo $div;
                        
                        
                    }
                    
                    ?>
                   

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

    <!-- 
    Author  :   Kevin
    Date    :   2015-05-08
    -->
    <?php
        $rs = mysql_query("SELECT * FROM staff WHERE staff_cd = '$staff_cd'");
        $staff = mysql_fetch_object($rs);
    ?>
    <script type="text/javascript">
     $('#addTicketRemarks').on('show.bs.modal', function (event) {
      var staff = <?php echo json_encode($staff) ?>;
      var modal = $(this);
      modal.find("#remark_staff_name").val(staff.FN);
      
      modal.find("#remark_save").click(function(){
        if(modal.find("#remark_text").val().length == 0){
            return;
        }
        modal.find("#remark_form").hide();
        modal.find("#remark_loading").show();
        $.post("ticket-remarks-ajax.php",{
            cmd : "save_remark",
            ticket_cd : "<?php echo $ticket_cd ?>",
            staff : staff,
            remarks : modal.find("#remark_text").val()
        },function(data){
            //console.log(data);
            window.location.reload();
        });
      });
    });
    </script>
<?php include('admin-footer.php'); ?>