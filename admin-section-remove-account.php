<?php

	/** Set flag that this is a parent file */
	define( "MAIN", 1 );

	session_name( 'imu_session' );
	session_start();
	$FN = $_SESSION['fullname'];
	$user_id = $_SESSION['user_id'];
	$ulevel = $_SESSION['ulevel'];
	$organization = $_SESSION['organization'];

	//require database connection
	require('db_con.php');

    $staff_id   = $_REQUEST['id'];

    $query  = " UPDATE `staff` SET `disable_flag` = 1 WHERE `staff_id` = '$staff_id' ";
    mysql_query($query) or die(mysql_error());
    
	
	//redirrect user in the admin section add account page
	echo "<script>document.location.href='admin-section-list.php'</script>\n";
	exit();
?>