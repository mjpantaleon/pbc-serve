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
        
        $UN      = mysql_real_escape_string(trim($_POST['txtUN']));
        $PW      = mysql_real_escape_string(trim($_POST['txtPW']));
        
        
        #IF USER NAME AND PASSWORD HAVE VALUE THEN
        if($UN&&$PW)
        {
            $query  = " SELECT * FROM `staff` WHERE `UN` = '".$UN."' ";
            $result = mysql_query($query) or die(mysql_error());
            while($row  = mysql_fetch_array($result))
            {
                $staff_cd       = $row['staff_cd'];
                $Username       = $row['UN'];
                $password       = $row['PW'];
                $fullname       = $row['FN'];
                $position       = $row['position'];
                $pw_change      = $row['pw_change'];
                
                
                #CHECK PASSWORD INPUTED 
                if($PW == $password)
                    $loginOK = true;
                else
                    $loginOK = false;
                    
                #CHECK IF LOGIN IS OK   
                if($loginOK == true)
                {
                    if($pw_change == !1){
                        session_name( 'imu_session_personnel' );
                        session_start();
                        $_SESSION['UN']         = $Username;
                        $_SESSION['staff_cd']   = $staff_cd;
                        exit("<script>document.location.href='change-password.php';</script>\n"); 
                    }
                    else{
                        #START SESSION
                        session_name( 'imu_session_personnel' );
                        session_start();
                        $_SESSION['staff_cd']           = $staff_cd;
                        $_SESSION['UN']                 = $Username;
                        $_SESSION['FN']                 = $fullname;
                        $_SESSION['position']           = $position;
                        session_write_close();
                        
                        exit("<script>document.location.href='personnel-main.php';</script>\n");   
                    }

                   
                    
                    
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
                            <small>Personnel Login</small>
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
                                    <input type="submit" class="btn btn-md btn-info" name="cmdLogin" 
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