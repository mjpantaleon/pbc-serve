<?php
#START SESSION
session_name( 'cts_session' );
session_start();
$FN = $_SESSION['fullname'];
$user_id = $_SESSION['user_id'];
$ulevel = $_SESSION['ulevel'];
$organization = $_SESSION['organization'];


/** Set flag that this is a parent file */
define( "MAIN", 1 );

//require connection to the database
require('db_con.php');


//if user dont have access then redirect them to unautorized page
if( ($user_id == '') && ($ulevel =='') )
{
	echo "<script>document.location.href='index.php';</script>\n";
	exit();
}

include('Helper.php');
include('FlashMessage.php');

?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>National Blood Bank Network System</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/custom.css" rel="stylesheet">
	<link href="css/sb-admin-2.css" rel="stylesheet">
	<link href="css/plugins/plugins/dataTables.bootstrap.css" rel="stylesheet">
	<link href="font-awesome-4.1.0/css/font-awesome.css" rel="stylesheet" type="text/css">
	<script src="js/respond.js"></script>
</head>

<body>

<!-- START CONTAINER -->
<div class="container">

	<!-- TOP NAVIGATION -------------------------------------------------------------------------------------------->
	<div class="row">
    	<nav class="navbar navbar-default navbar-inverse navbar-fixed-top" role="navigation">
		
        	<div class="navbar-header">
            	<button type="button" class=" navbar-toggle" data-toggle="collapse" data-target="#collapse">
                	<span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>

            <div class="collapse navbar-collapse" id="collapse">
				
            	<ul class="nav navbar-nav">
					<li><a href="tti_recieve_list.php">Deferred Blood Units</a></li>
					<li><a href="tti_submit_result.php">Confirmatory Test Result</a></li>
					
                    <li class="dropdown"><a href="#" data-toggle="dropdown">Partners <span class="caret"></span></a>
                    	<ul class="dropdown-menu">
                        	<li><a href="http://nvbsp.com" target="_blank">NVBSP</a></li>
                            <li><a href="http://nbbnets.net" target="_blank">NBBNetS</a></li>
                        </ul>
                    </li>
					
					<li class="pull-right"><a href="logout.php">Logout</a></li>
                </ul>
				
			</div>
			
        </nav>
	</div>
	<!-- TOP NAVIGATION -------------------------------------------------------------------------------------------->
	<?php echo FlashMessage::get() ?>
	
	<br/> 