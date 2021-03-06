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
                            All Ticket <small></small>
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i>  <a href="personnel-main.php">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-ticket"></i> All Ticket
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
                                                <th>Job Request</th>
                                                <th>Subject</th>
                                                <th>Date</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $query      = " SELECT t.`ticket_cd` , t.`SUBJ`, f.`name` , t.`date` , t.`ST`, t.`disable_flag` , f.`name`
                                                        FROM  `ticket` t
                                                        LEFT JOIN  `section` f ON t.`request_type` = f.`id` 
                                                        WHERE t.`disable_flag` = '0' AND t.`date` LIKE '%2021%'
                                                        ORDER BY  `date` DESC ";
                                        $result     = mysql_query($query);
                                        while($row  = mysql_fetch_array($result))
                                        {
                                            #POST VARIABLES
                                            $ticket_cd      = $row['ticket_cd'];
                                            $subject        = $row['SUBJ'];
                                            $request_type   = $row['name'];
                                            $date           = $row['date'];
                                            // $by         = $row['UN'];
                                            // $to         = $row['staff_cd'];
                                            $ST             = $row['ST'];

                                            #RESULT TABLE
                                            $div = "
                                            <tr>
                                                <td class='col-sm-3 col-xm-3'>".$ticket_cd."</td>
                                                <td class='col-sm-4 col-xm-4'>".$request_type."</td>
                                                <td class='col-sm-5 col-xm-5'>".$subject."</td>
                                                
                                                <td class='col-sm-2 col-xm-2'>".date("F d, Y",strtotime($date))."</td>";

                                                // $query = "SELECT * FROM ticket_staff INNER JOIN staff ON ticket_staff.staff_cd =  staff.staff_cd WHERE ticket_cd = '".$ticket_cd."'";
                                                // $rs = mysql_query($query) or exit(mysql_error());
                                                // while($staff = mysql_fetch_object($rs)){
                                                //     $div .= $staff->UN."<br/>";
                                                // }

                                            $div .= "
                                                <td class='col-sm-1 col-xm-1'> ";
                                                
                                                $btn =" 
                                                <a href ='personnel-ticket-details2.php?id=".$ticket_cd."' 
                                                class='has-tooltip btn ?BTN? btn-xs' data-toggle='tooltip' 
                                                data-placement='left' title='Click to view details'>
                                                <span class='glyphicon glyphicon-search'></span></a>
                                                ";

                                                if($ST != 1){
                                                    $btn = str_replace("?BTN?", "btn-success", $btn);
                                                } else {
                                                    $btn = str_replace("?BTN?", "btn-warning", $btn);
                                                }
                                                $div .= $btn;

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
                        <!-- /.row -->
                        <!-- <div id="plot"></div> -->
                    </aside>
                </div>
                <!-- /.row -->
            </div>
        </div>
        <!-- Content wrapper -->



    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- jqplot -->
    <script type="text/javascript" src="js/plugins/jqplot/jquery.jqplot.min.js"></script>
    <link rel="stylesheet" type="text/css" href="js/plugins/jqplot/jquery.jqplot.min.css">
    <script type="text/javascript" src="js/plugins/jqplot/plugins/jqplot.barRenderer.min.js"></script>
    <script type="text/javascript" src="js/plugins/jqplot/plugins/jqplot.donutRenderer.min.js"></script>
    <script type="text/javascript" src="js/plugins/jqplot/plugins/jqplot.categoryAxisRenderer.min.js"></script>
    <?php
        $staff_rs = mysql_query("SELECT * FROM staff");
        $s1 = [];
        $s2 = [];
        $staffs = [];
        while($staff = mysql_fetch_object($staff_rs)){
            $fn = explode(" ",$staff->FN);
            $staffs[] = $fn[0];
            $pending = mysql_query("SELECT ts.staff_cd ,count(*) as cnt,t.ST FROM ticket_staff ts 
                                    INNER JOIN ticket t ON ts.ticket_cd = t.ticket_cd 
                                    WHERE ts.staff_cd = '$staff->staff_cd' AND t.ST = 0
                                    GROUP BY ts.staff_cd,ST") or exit(mysql_error());

            if(mysql_num_rows($pending)){
                $s1[] = mysql_fetch_object($pending)->cnt *1; 
            }else{
                $s1[] = 0;
            }
            
            $accomplished = mysql_query("SELECT ts.staff_cd ,count(*) as cnt,t.ST FROM ticket_staff ts 
                                         INNER JOIN ticket t ON ts.ticket_cd = t.ticket_cd 
                                         WHERE ts.staff_cd = '$staff->staff_cd' AND t.ST = 1
                                         GROUP BY ts.staff_cd,ST");

            if(mysql_num_rows($accomplished)){
                $s2[] = mysql_fetch_object($accomplished)->cnt *1;
            }else{
                $s2[] = 0;
            }
        }
        $cnt = max($s2);
    ?>
    <script type="text/javascript">
        $(function(){
            $.jqplot('plot',<?php echo json_encode([$s1,$s2]) ?>,{
                animate : true,
                title : 'Tickets per Staff',
                series : [
                    {
                        label : 'Pending',
                        color : '#5cb85c'
                    },
                    {
                        label : 'Accomplished',
                        color : '#ec971f'
                    }
                ],
                seriesDefaults:{
                    renderer : $.jqplot.BarRenderer,
                    rendererOptions : {
                        barDirection : 'horizontal',
                        barWidth : 3
                    }
                },
                legend : {
                    show : true
                },
                axes : {
                    yaxis : {
                        renderer : $.jqplot.CategoryAxisRenderer,
                        ticks : <?php echo json_encode($staffs) ?>
                    },
                    xaxis :{
                        min :0,
                        max : <?php echo $cnt ?>+1,
                        tickOptions : {
                            formatString : '%d',
                            tickInterval : 1
                        }
                    }
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

    <!-- FOR BOOTSTAP ADMIN -->
    <script src="js/plugins/dataTables/jquery.dataTables.js"></script>
    <!--<script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>-->

    <!-- for continouos fluid container
    <script src="js/sb-admin-2.js"></script>
    <script src="js/plugins/metisMenu/metisMenu.js"></script> -->

    <script type="text/javascript">
    $(document).ready(function() {  
        $('.make-dataTable').dataTable({
            order : [[2,'desc'],[0,'desc']]
        });             
        $('.has-tooltip').tooltip();                      
    });
    
    </script>
    <!-- JAVASCRIPT -->

<?php include('admin-footer.php'); ?>