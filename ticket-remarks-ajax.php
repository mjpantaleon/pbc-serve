<?php
/*
*Author 	: 	Kevin
*Date 		:	2015-05-08
*Description :	Save Staff Remarks
*/
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
define("NO_DATA","Data not provided!");

if(!isset($_POST["cmd"])){
	exit(NO_DATA);
}else{
	if(function_exists($_POST["cmd"])){
		exit($_POST["cmd"]());
	}
}

function save_remark(){
	$ticket_cd = $_POST["ticket_cd"];
	$staff = $_POST["staff"];
	$remarks = mysql_real_escape_string($_POST["remarks"]);
	
	$query = "INSERT INTO ticket_remarks VALUES(null,'$ticket_cd','{$staff['staff_cd']}','$remarks',now())";
	mysql_query($query) or exit(mysql_error());

}