<?php
/** Set flag that this is a parent file */
define( "MAIN", 1 );

//require connection to the database
require('db_con.php');


    #IF BUTTON LOGIN HAS BEEN CLICKED THEN||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    $Message = '';
    if(isset($_POST['cmdLogin']))
    {
        #POST FIELDS
        
        $UN      = trim($_POST['txtUN']);
        $PW      = md5(trim($_POST['txtPW']));
        
        
        #IF USER NAME AND PASSWORD HAVE VALUE THEN
        if($UN&&$PW)
        {
            $query  = "SELECT * FROM `r_user` WHERE `user_id` = '$UN'";
            $result = mysql_query($query)
            or die(mysql_error());
            while($row  = mysql_fetch_array($result))
            {
                $user_id        = $row['user_id'];
                $password       = $row['password'];
                $lname          = $row['user_lname'];
                $fname          = $row['user_fname'];
                $mname          = $row['user_mname'];
                $fullname       = $fname." ".$mname." ".$lname;
                $organization   = $row['organization'];
                $ulevel         = $row['ulevel'];
                
                
                #CHECK PASSWORD INPUTED 
                if($PW == $password)
                    $loginOK = true;
                else
                    $loginOK = false;
                    
                #CHECK IF LOGIN IS OK   
                if($loginOK == true)
                {
                    
                    #START SESSION
                    session_name( 'imu_session' );
                    session_start();
                    $_SESSION['user_id']            = $user_id;
                    $_SESSION['ulevel']             = $ulevel;
                    $_SESSION['password']           = $PW;
                    $_SESSION['fullname']           = $fullname;
                    $_SESSION['organization']       = $organization;
                    session_write_close();
                    
                    exit("<script>document.location.href='admin-main.php';</script>\n");
                    
                    /*#SWITCH USER BY LEVEL
                    switch($ulevel){
                        case 6:
                            exit("<script>document.location.href='tti_recieve_list.php';</script>\n");  
                        break;
                        default:
                            exit("<script>document.location.href='tti_reffer_list.php';</script>\n");   
                        
                    }

                    $Message = '
                    <div class="alert alert-success">
                        <strong>Welcome Administrator!</strong> Your session will now start.
                    </div>
                    ';
                    */
                    
                }#CHECK IF LOGIN IS OK 
                else
                    $Message = '
                    <div class="alert alert-danger">
                        <strong>Invalid Login!</strong> Either the Username/Password is incorrect.
                    </div>
                    '; 
            }
            #END WHILE
        }#IF USER NAME AND PASSWORD HAVE VALUE THEN
        
        else
            die();
        #IF USER NAME AND PASSWORD HAVE VALUE THEN
    }
    #IF BUTTON LOGIN HAS BEEN CLICKED THEN||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
?>

<?php include('index-header.php'); ?>

        <!-- Content wrapper -->
        <div id="page-wrapper">

            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            <small>Administrator Login</small>
                        </h1>
                        <!--<ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i> Dashboard
                            </li>
                        </ol>-->
                    </div>
                </div>
                <!-- /.row -->

                    <div class="row">
                        <div class="col-lg-12">
                            <form role="form" method='POST'>
                                <div class="form-group input-group col-md-4 col-sm-4">
                                    <span class="input-group-addon"><i class="fa fa-fw fa-user"></i></span>
                                    <input type="text" class="form-control" name="txtUN" placeholder="Username" required>
                                </div>

                                <div class="form-group input-group col-md-4 col-sm-4">
                                    <span class="input-group-addon"><i class="fa fa-fw fa-lock"></i></span>
                                    <input type="password" class="form-control" name="txtPW" placeholder="Password" required>
                                </div>
                                <p>
                                    <input type="submit" class="btn btn-md btn-warning" name="cmdLogin" 
                                    value="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;LOGIN&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;">
                                </p>
                                <p>
                                    <?php echo $Message;  ?>
                                </p>    
                            </form>
                        </div>
                    </div>
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