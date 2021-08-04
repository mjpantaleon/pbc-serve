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
?>

<?php include('admin-header.php'); ?>
        <!-- Content wrapper -->
        <div id="page-wrapper">

            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Sections <small></small>
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-gear"></i>  <a href="admin-maintenance.php">Admin Maintenance</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-ticket"></i> Section List
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->


                <div class="row">
                    <article class="col-md-9 col-sm-6">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <h4>List of Sections/ Departments</h4>
                            </div>
                            
                            <div class="panel-body">
                                    <table class="table table-bordered table-striped table-hover make-dataTable">
                                        <thead>
                                            <tr>
                                                <th>Section</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $query      = " SELECT * FROM `section`
                                                        WHERE `disable_flag` = '0' ";
                                        $result     = mysql_query($query);
                                        while($row  = mysql_fetch_array($result))
                                        {
                                            #POST VARIABLES
                                            $request_id     = $row['id'];
                                            $request_type   = $row['name'];
                                            $disable_flag   = $row['disable_flag'];

                                            #RESULT TABLE
                                            $div = "
                                            <tr>
                                                <td class='col-sm-11 col-xm-11'>".$request_type."</td>
                                                <td class='col-sm-1 col-xm-1'> ";
                                                    if($disable_flag != 1){
                                                    $div .=" 
                                                    <a href ='admin-section-edit.php?id=".$request_id."' 
                                                    class='has-tooltip btn btn-success btn-xs' data-toggle='tooltip' 
                                                    data-placement='left' title='Click to Edit this item'>
                                                    <span class='glyphicon glyphicon-search'></span></a>
                                                    ";
                                                    } else {
                                                    $div .=" 
                                                    <a href ='admin-section-edit.php?id=".$request_id."' 
                                                    class='has-tooltip btn btn-warning btn-xs' data-toggle='tooltip' 
                                                    data-placement='left' title='Click to Edit this item'>
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

                    <aside class="col-md-3 col-sm-6">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <!--<span class="pull-right"><a href="">Sign Up</a></span>-->
                                <div class="pull-right">
                                    <!--<input type="text" class="form-control" name="txtSearch" placeholder="Search by Donation ID" autofocus />-->
                                </div>
                                <h4>What do you want to do?</h4>
                            </div>
                            
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover" id="dataTables-example">
                                        <tr>
                                            <td class='warning'>
                                                <a href='admin-section-add.php'>
                                                    <i class="fa fa-edit"></i>&nbsp;&nbsp;Create New
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- /.row -->

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