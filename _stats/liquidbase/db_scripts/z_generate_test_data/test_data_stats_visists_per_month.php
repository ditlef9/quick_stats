<?php
if(isset($_SESSION['adm_user_id'])){


	$t_stats_visists_per_month  = $dbPrefixSav . "stats_visists_per_month";


	// Months
	$months_short = array(
	  'Jan', 
	  'Feb', 
	  'Mar', 
	  'Apr', 
	  'May', 
	  'Jun', 
	  'Jul', 
	  'Aug', 
	  'Sep', 
	  'Oct', 
	  'Nov', 
	  'Dec'
	);


	$months_long = array(
	  'January', 
	  'February', 
	  'March', 
	  'April', 
	  'May', 
	  'June', 
	  'July', 
	  'August', 
	  'September', 
	  'October', 
	  'November', 
	  'December'
	);

	if(isset($configGenerateTestDataSav) && $configGenerateTestDataSav == "1"){
		echo"
		<h2>Generating test data :: stats_visists_per_month</h2>
		";

		$year = date("Y");
		$start = $year-5;
		$stop = $year+1;
		for($x=$start;$x<$stop;$x++){


			$inp_year = "$x";

			for($y=0;$y<12;$y++){
				$inp_month = $y+1;
				$inp_month_full = $months_long[$y];
				$inp_month_short = $months_short[$y];
 
				$inp_human_unique = rand(50000,60000);
				$inp_human_unique_diff_from_last_year = rand(50000,60000);
				$inp_human_new_visitor_unique = rand(50000,60000);
				$inp_returning_visitor_unique = rand(50000,60000);
				$inp_unique_desktop = rand(50000,60000);
				$inp_unique_mobile = rand(50000,60000);
				$inp_unique_bots = rand(50000,60000);
				$inp_hits_total = rand(50000,60000);
				$inp_hits_human = rand(50000,60000);
				$inp_hits_desktop = rand(50000,60000);
				$inp_hits_mobile = rand(50000,60000);
				$inp_hits_bots = rand(50000,60000);

				mysqli_query($link, "INSERT INTO $t_stats_visists_per_month 
				(`stats_visit_per_month_id`, `stats_visit_per_month_month`, `stats_visit_per_month_month_full`, `stats_visit_per_month_month_short`, `stats_visit_per_month_year`, 
				`stats_visit_per_month_human_unique`, `stats_visit_per_month_human_unique_diff_from_last_month`, `stats_visit_per_month_human_average_duration`, `stats_visit_per_month_human_new_visitor_unique`, `stats_visit_per_month_human_returning_visitor_unique`, 
				`stats_visit_per_month_unique_desktop`, `stats_visit_per_month_unique_mobile`, `stats_visit_per_month_unique_bots`, `stats_visit_per_month_hits_total`, `stats_visit_per_month_hits_human`, 
				`stats_visit_per_month_hits_desktop`, `stats_visit_per_month_hits_mobile`, `stats_visit_per_month_hits_bots`) 
				VALUES
				(NULL, $inp_month, '$inp_month_full', '$inp_month_short', $inp_year,
				$inp_human_unique, $inp_human_unique_diff_from_last_year, '0', $inp_human_new_visitor_unique, $inp_returning_visitor_unique, 
				$inp_unique_desktop, $inp_unique_mobile, $inp_unique_bots, $inp_hits_total, $inp_hits_human, 
				$inp_hits_desktop, $inp_hits_mobile, $inp_hits_bots)")
				   or die(mysqli_error($link));

			} // month loop
		} // year loop

	} // generate test data == 1
} // logged in
?>