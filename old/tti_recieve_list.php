<?php 
	/* Header */
	include('main_header.php'); ?>	
<!-- HEADER -------------------------------------------------------------------------------------------->

	
	<!-- DIV ROW -->
	<div class="row">
	
		<!-- MAIN ARTICLE / RIGHT NAV -->
		<article class="col-lg-8 col-sm-7">
        
			<div class="panel panel-default">
            	<div class="panel-heading">
					<!--<span class="pull-right"><a href="">Sign Up</a></span>-->
            		<div class="pull-right">
                    	<!--<input type="text" class="form-control" name="txtSearch" placeholder="Search by Donation ID" autofocus />-->
                    </div>
					<h4>List of Deferred Blood Units</h4>
				</div>
				
				<div class="panel-body">
					<div class="table-responsive">
					<table class="table table-bordered table-striped table-hover" id="dataTables-example">
						<thead>
							<tr>
								<th>Donation ID</th>
								<th>Facility</th>
								<th>Date</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
						<?php
						$Limit		= 40;
						$query 		= "	SELECT bt.`donation_id`,bt.`created_dt`,f.`facility_name` 
										FROM `bloodtest` bt
										LEFT JOIN `r_facility` f ON bt.`facility_cd` = f.`facility_cd`
										WHERE bt.`result` = 'r' AND (SELECT count(*) FROM confirmatory_result WHERE donation_id = bt.donation_id) = 0 
										ORDER BY bt.`donation_id` ASC ";		
						 /*	"	SELECT bt.`donation_id`,bt.`created_dt`,f.`facility_name` 
										FROM `bloodtest` bt
										LEFT JOIN `r_facility` f ON bt.`facility_cd` = f.`facility_cd`
										WHERE bt.`result` = 'r' AND (SELECT count(*) FROM confirmatory_result 
										WHERE donation_id = bt.donation_id AND referral_dt IS NOT NULL) > 0 
										ORDER BY bt.`donation_id` ASC */ 
						
						$result 	= mysql_query($query) or die (mysql_error());
						while($row	= mysql_fetch_array($result))
						{
							$donation_id 	= $row['donation_id'];
							$facility		= $row['facility_name'];
							$created_dt		= $row['created_dt'];
							
							$div ="
							 <tr>
								<td class='col-md-2 col-xs-6'>".$donation_id."</td>
								<td id='left_align' class='col-md-6 col-xs-6'>".$facility."</td>
								<td class='col-md-3 col-xs-6'>".$created_dt."</td>
								<td class='col-md-1 col-xs-6'>
									<a href ='tti_recieve.php?id=".$donation_id."' class='has-tooltip btn btn-info btn-xs' data-toggle='tooltip' 
									data-placement='left' title='Click to recieve this blood unit'>
									<span class='glyphicon glyphicon-check'></span></a>
								</td>
							 </tr>
							";
							
							echo $div;
						}
						?>
							  
							  
					  	</tbody>
					</table>
					</div>
					
				</div><!-- END PANEL -->
            </div>
		</article>
		<!-- MAIN ARTICLE / RIGHT NAV -->
		
		
		<!-- LEFT NAV -->
		<aside class="col-lg-4 col-sm-5">
			<?php include('left_nav.php'); ?>
		</aside>
		<!-- LEFT NAV -->
		
		
	</div>
	<!-- DIV ROW -->
	
	<!-- JAVASCRIPT -->
	<script src="js/jquery-latest.min.js"></script>
	<script src="js/bootstrap.min.js"></script>	
	
	<script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>
	<script src="js/plugins/dataTables/jquery.dataTables.js"></script>
	<script src="js/plugins/metisMenu/metisMenu.js"></script>
	
	<script>
    $(document).ready(function() {
        $('#dataTables-example').dataTable();
		$('.has-tooltip').tooltip();
    });
	
    </script>
	
	
	
	
<!-- FOOTER -------------------------------------------------------------------------------------------->
<?php include('main_footer.php'); ?>
<!-- FOOTER -------------------------------------------------------------------------------------------->

	
