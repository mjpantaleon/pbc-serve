<?php 
/** Set flag that this is a parent file */
define( "MAIN", 1 );

//require connection to the database
require('db_con.php');

 ?>
<html lang="en">
 <head>
    <link rel="shortcut icon" href="images/IMU_ICON2.png" />
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>IMU Serve - Client Support Site</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css">

    <!-- data-Tables CSS -->
    <link href="css/plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
<?php
$query 		= "	SELECT `facility_name` FROM `r_facility` WHERE `disable_flg` = 'N' 
				ORDER BY `facility_cd` ASC ";
$result 	= mysql_query($query) or die(mysql_error());

?>

	<div id="wrapper">
		<div class="row">
	        <article class="col-md-9 col-sm-6">
	        	<select class='form-control'>
	        		<option value=''>--- SELECT HERE ---</option>
	        		<?php
	        		while ($row = mysql_fetch_assoc($result)) {
	        		$facility 	= $row['facility_name'];
	        			echo "
	        			<option value='".$facility."'>".$facility."</option>
	        			";
	        		}
	        		?>
	        		
	        	</select>
	        </article>
	        <aside class="col-md-3 col-sm-6">
	        </aside>
		</div>

		<div class="col-md-3">
			<span class="help-block">
				<h4><small>Choose a 2x2 Image</small></h4>
			</span>
			<div class="input-group">
				<span class="input-group-btn">
					<span class="btn btn-primary btn-file">
						Browse&hellip; <input type="file" name="File" id="i_file" accept="image/gif, image/jpeg" >
					</span>
				</span>
				<input type="text" class="form-control" readonly>
			</div>
		</div>

		<div class="col-md-3">
			<div class="form-group">
				<input name="BYear" class="form-control" value="<?php echo $BY; ?>" 
				style="width:80px;"
				onkeypress="return isNumber(event)"
				onKeyUp="if(this.value><?php $Y = date('Y'); echo $Y; ?>){this.value='<?php $Y = date('Y'); echo $Y; ?>';}
				else if(this.value<0){this.value='0';}"
				oninput="maxLengthCheck(this)"
				type = "number"
				maxlength = "4"
				min = "1955"
				max = "2015" 
				placeholder = "YYYY";
				/> 
			</div>
		</div>
	</div>

</body>
</html>