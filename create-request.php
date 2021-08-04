<?php
/** Set flag that this is a parent file */
define( "MAIN", 1 );

//require connection to the database
require('db_con.php');

#POST VARIABLE FOR MESSAGE PROMPT
$Message = '';

#gets the page name!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
$page = mysql_real_escape_string(basename($_SERVER['SCRIPT_NAME']));


#IF ISSUE BUTTON HAS BEEN CLICKED OR DETECTED THEN
if(isset($_POST['cmdIssue'])){

    #POST VARIABLES
    $request_type   = $_POST['cmbRequestType'];
    $subject        = mysql_real_escape_string(trim($_POST['txtSubj']));
    $facility       = $_POST['cmbFacility'];
    $description    = mysql_real_escape_string(trim($_POST['txtDesc']));
    $severity       = $_POST['cmbSeverity'];
    $date           = date("Y-m-d");

    $valid          = true;
    $time_now       = date("H:i:sa");
    $st             = 0;

    $staff_cd       = 'PBC';
    
    #MUST CHECK FIRST FRO EMPTY FIELDS
    if ($request_type == '')
        $valid = false;
    elseif($subject == '')
        $valid = false;
    elseif($facility == '')
        $valid = false;
    elseif($description == '')
        $valid = false;
    elseif($date == '')
        $valid = false;

    #IF ALL FIELDS ARE VALID THEN=========================================================================
    if($valid == true){
        $cur_Y  = date('Y');        //get the current year

        #id format
        $limit  = 7;                                                                //set the limit into 7
        $sql    = "SELECT * FROM `ticket` ORDER BY `ticket_cd` DESC LIMIT 0,1";      //query serves as our counter
        $result = mysql_query($sql);                                                //then its passed down to the varibale $result
        $row    = mysql_fetch_array($result);                                       //so that we could access row 'UID' from the table
        
            $last_id    = $row['ticket_cd'];
            $last_dgt   = substr($last_id, -7);                             
            
            $id         = str_pad((int) $last_dgt,$limit,"0",STR_PAD_LEFT);
            $id         = $id + 1;                                                  //increment by 1
            $id         = str_pad((int) $id,$limit,"0",STR_PAD_LEFT);
            $item_id    = "TCKT".$cur_Y."-".$id;                                    //TCKT2015-0000001
        #id format

        #CHECK IF THERE ARE PERSONNEL SELECTED!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        if (!isset($_POST['staff_cd'])) {
            #PROMT ERROR MESSAGE
            $Message = '
            <div class="alert alert-danger">
                <i class="fa fa-ticket"></i> <strong> ERRRR!!! NO Personnel selected! </strong> 
                Please select personnel before you proceed.
            </div>
            ';
        }
        else{
            #INSERT THIS IN THE DATABASE!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
            $query      = " INSERT INTO `ticket` SET
                            `ticket_cd`     = '".$item_id."',
                            `request_type`  = '".$request_type."',
                            `SUBJ`          = '".$subject."',
                            `facility_cd`   = '".$facility."',
                            `problem_desc`  = '".$description."',
                            `severity`      = '".$severity."',
                            `date`          = '".$date."',
                            `time`          = '".$time_now."',
                            `ST`            = '".$st."',
                            `created_by`    = '".$facility."'
            ";
            mysql_query($query) or die(mysql_error());

            // #MUST LOG THIS EVENT!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
            // $time_in = date("H:i:sa");              
            // $cur_date = date("Y-m-d");
            // $cur_timestamp = $cur_date." ".$time_in;  //concatinate time + current date
            
            // $query = "    INSERT INTO `log_trail` SET 
            //         `TS`        = '".$cur_timestamp."', 
            //         `user_id`   = '".$staff_cd."', 
            //         `action`    = '[ ".$fullname." ] Issue new ticket [ ".$item_id." ] at page [".$page."]'  
            // ";
            // mysql_query($query) or die(mysql_error());


            $query = " DELETE FROM ticket_staff WHERE ticket_cd = '".$item_id."' ";
            mysql_query($query);

             foreach($_POST['staff_cd'] as $staff_cd){
                $staff_cd = mysql_real_escape_string($staff_cd);

                $query = " INSERT INTO `ticket_staff` VALUES(null,'".$item_id."','".$staff_cd."')";
                mysql_query($query) or die(mysql_error());
            }


            #PROMT MESSAGE!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
            $Message ='        
            <div class="alert alert-info">
               <i class="fa fa-ticket"></i> Ticket <strong>[ '.$item_id.' ]</strong> has been Issued.
            </div> 
            ';
        }
        #CHECK IF THERE ARE PERSONNEL SELECTED!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!   

            
    }
    #IF ALL FIELDS ARE VALID THEN=========================================================================
}
#IF ISSUE BUTTON HAS BEEN CLICKED OR DETECTED THEN
    
?>

<?php include('index-header.php'); ?>

        <!-- Content wrapper -->
        <div id="page-wrapper">

            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Create New Request
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-list-alt"></i> Create New Request
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

                <p><?php echo $Message; ?></p>

                <div class="row">
                    <article class="col-md-9 col-sm-6">
                        <div class="panel panel-warning">
                            <div class="panel-heading">
                                <div class="pull-right">
                                </div>
                                <h4>Supply all the neccessary fields</h4>
                            </div>
                            
                            <form method="post">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <tbody>
                                            <tr>
                                                <th class='col-sm-4 col-xm-4'>Type of Problem</th>
                                                <td class='col-sm-8 col-xm-8'>
                                                    <select  class='form-control' name='cmbRequestType' required>
                                                        <option value=''>--- Select here ---</option>
                                                        <?php
                                                        $query      = "SELECT * FROM `request_type` WHERE `disable_flag` = 0 ";
                                                        $result     = mysql_query($query);
                                                        while($row  = mysql_fetch_array($result))
                                                        {
                                                            #POST VARIABLES
                                                            $request_type = $row['request'];

                                                            $div = "
                                                            <option value='".$request_type."'>".$request_type."</option>
                                                            ";
                                                            echo $div;
                                                            
                                                        }
                                                        #END WHILE
                                                        ?>
                                                    </select>
                                                </td>
                                            </tr>

                                            <tr>
                                                <th class='col-sm-4 col-xm-4'>Subject</th>
                                                <td class='col-sm-8 col-xm-8'>
                                                    <input type ='text' class="form-control" required name="txtSubj"
                                                    placeholder="Example: Monitor no display">
                                                </td>
                                            </tr>

                                            <tr>
                                                <th class='col-sm-4 col-xm-4'>Description</th>
                                                <td class='col-sm-8 col-xm-8'>
                                                    <textarea class="form-control" required name="txtDesc"
                                                    placeholder="Example: Monitor suddenly stopped working. please help" rows="3"></textarea>
                                                </td>
                                            </tr>

                                            <tr>
                                                <th class='col-sm-4 col-xm-4'>Requesting Section</th>
                                                <td class='col-sm-8 col-xm-8'>
                                                    <select  class='form-control' name='cmbFacility' required>
                                                        <option value=''>--- Select here ---</option>
                                                        <?php
                                                        $query      = "SELECT * FROM `section` ORDER BY `id` ASC";
                                                        $result     = mysql_query($query);
                                                        while($row  = mysql_fetch_array($result))
                                                        {
                                                            #POST VARIABLES
                                                            $facility_cd = $row['id'];
                                                            $facility    = $row['name'];

                                                            $div = "
                                                            <option value='".$facility_cd."'>".$facility."</option>
                                                            ";
                                                            echo $div;
                                                            
                                                        }
                                                        #END WHILE
                                                        ?>
                                                    </select>
                                                </td>
                                            </tr>

                                            <tr>
                                                <th class='col-sm-4 col-xm-4'>Urgency/Severity</th>
                                                <td class='col-sm-8 col-xm-8'>
                                                    <select name='cmbSeverity' class='form-control' required>
                                                        <option value=''>--- Select here ---</option>
                                                        <option value='High'>High</option>
                                                        <option value='Medium'>Medium</option>
                                                        <option value='Low'>Low</option>
                                                    </select>
                                                </td>
                                            </tr>

                                            <tr>
                                                <th colspan='2' class='col-sm-12 col-xm-12'>Select Personnel to deploy</th>
                                            </tr>

                                            <?php
                                            $query = "SELECT * FROM  `staff` WHERE `disable_flag` = 0 ";
                                            $rs = mysql_query($query);
                                            $assigned_staff = [];

                                            while($row = mysql_fetch_assoc($rs)){
                                            $is_checked = array_search($row["staff_cd"], $assigned_staff) !== false ? "CHECKED" : "";
                                            echo "
                                            <tr>
                                                <td class='pull-right'>
                                                    <input type='checkbox' name='staff_cd[]' value='".$row["staff_cd"]."' $is_checked />
                                                </td>
                                                <td>".$row["FN"]." (".$row['position'].")</td>
                                            </tr>";
                                            }
                                            ?>

                                           
                                            <tr>
                                                <th colspan='2' class='col-sm-12 col-xm-12'>
                                                    <input type='submit' class='btn btn-md btn-warning' name='cmdIssue' value='Issue Ticket'>
                                                </th>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>

                            </div>
                            </form>
                            <!-- /.row -->

                    </article>

                    
                </div>

              

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