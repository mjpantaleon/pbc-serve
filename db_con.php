<?php

//set that this location cant be access directly
defined( 'MAIN' ) or die( 'Direct access to this location is not allowed!' );
require ('db_conf.php');

//IF NOT SAME CONFIGURATION THEN FORCE THE PAGE TO BE OFFLINE
if(!($con = @mysql_connect( $host, $user, $password)))
{
	//require('header.php');
	require('offline.php');
	exit();
}

//IF NOT SAME DATABASE NAME THEN FORCE THE PAGE TO BE OFFLINE
if(!(@mysql_select_db($dbname)))
{
	//require('header.php');
	require('offline.php');
	exit();
}


/***********************DONT UPDATE*******************************/

/*require 'inc/vendor/autoload.php';  
 
use Illuminate\Database\Capsule\Manager as Capsule;  
 
$capsule = new Capsule; 
 
$capsule->addConnection(array(
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'database'  => 'n0923',
    'username'  => 'root',
    'password'  => '',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => ''
));
 
$capsule->bootEloquent();*/
/***********************DONT UPDATE******************************/

?>

