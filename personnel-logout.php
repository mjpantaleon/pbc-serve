<?php

	/** Set flag that this is a parent file */
	define( "MAIN", 1 );

	session_name( 'imu_session_personnel' );
	session_start();
	$staff_cd = $_SESSION['staff_cd'];
	$Username = $_SESSION['UN'];
	$fullname = $_SESSION['FN'];

	//require database connection
	require('db_con.php');

	session_destroy();
	
	//redirrect user in the index page
	echo "<script>document.location.href='personnel-login.php'</script>\n";
	exit();
?>