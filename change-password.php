<?php  
/** Set flag that this is a parent file */
define( "MAIN", 1 );

//require connection to the database
require('db_con.php');

session_name( 'imu_session_personnel' );
session_start();
$Username = $_SESSION['UN'];
$staff_cd = $_SESSION['staff_cd'];

#local variable
$Message = "";

    /*IF UPDATE BUTTON HAS BEEN CLICKED*/
    if(isset($_POST['cmdUpdate'])){
        $new_password   = $_POST['txtPW'];
        $pw_change      = 1;

        if(!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,15}$/', $new_password)) {
            $Message = '<div class="alert alert-danger">The password('.$new_password.') does not meet the requirements!</div>';
        }
        else{
            #var_dump($staff_cd);
            $query = "UPDATE `staff` SET `PW` = '$new_password', `pw_change` = '$pw_change' WHERE `staff_cd` = '$staff_cd' ";
            mysql_query($query) or die(mysql_error());
            $Message = '<div class="alert alert-success">
                <span class="glyphicon glyphicon-check"></span>&nbsp;&nbsp;Password has been successfully changed.
            </div>';
        }
        
    }
    /*IF UPDATE BUTTON HAS BEEN CLICKED*/

?>
<?php include('index-header.php'); ?>

        <!-- Content wrapper -->
        <div id="page-wrapper">

            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            <small><span class="glyphicon glyphicon-edit"></span>&nbsp;Change password</small>
                        </h1>
                    </div>
                </div>
                <!-- /.row -->

                    <div class="row">
                        <div class="col-lg-12">
                            <form name="form1" role="form" method='POST'>
                                <div class="form-group input-group col-md-4 col-sm-4">
                                    <span class="input-group-addon"><i class="fa fa-fw fa-user"></i></span>
                                    <input type="text" class="form-control" name="txtUN" placeholder="Username" required
                                    value="<?php echo $Username; ?>" disabled>
                                </div>

                                <div class="form-group input-group col-md-4 col-sm-4">
                                    <span class="input-group-addon"><i class="fa fa-fw fa-lock"></i></span>
                                    <input type="password" class="form-control" name="txtPW" placeholder="New Password" required>
                                </div>
                                <p>
                                    <input type="submit" class="btn btn-md btn-warning" name="cmdUpdate"
                                    onclick="checkPassword(document.form1.txtPW)" 
                                    value="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;UPDATE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;">
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


    <!-- script 4 checking password -->
    <script src="check-password-4.js"></script> 

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