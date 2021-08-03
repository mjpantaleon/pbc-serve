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

	session_destroy();
	
	//redirrect user in the index page
	echo "<script>document.location.href='admin-login.php'</script>\n";
	exit();
?>