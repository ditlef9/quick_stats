<?php
if(isset($_SESSION['adm_user_id'])){


	$t_stats_visists_per_day  = $dbPrefixSav . "stats_visists_per_day";


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
		<h2>Generating test data :: stats_visists_per_day</h2>
		<table>
		";

		$year = date("Y");
		$start = $year;
		$stop = $year+1;
		for($x=$start;$x<$stop;$x++){


			$inp_year = "$x";

			for($y=0;$y<12;$y++){
				$inp_month = $y+1;
				if($inp_month < 10){
					$inp_month = "0" . $inp_month;
				}
				$inp_month_full = $months_long[$y];
				$inp_month_short = $months_short[$y];


				for($z=0;$z<31;$z++){
					$inp_day = $z+1;
					if($inp_day < 10){
						$inp_day = "0" . $inp_day;
					}
					
					$date = $inp_year . "-" . $inp_month . "-" . $inp_day;

					$inp_day_full = date('l', strtotime($date));
					$inp_day_three = date('D', strtotime($date));
					$inp_day_single = substr($inp_day_three, 0, 1);

 
					$inp_human_unique = rand(50,100);
					$inp_human_unique_diff_from_last_year = rand(50,100);
					$inp_human_new_visitor_unique = rand(50,100);
					$inp_returning_visitor_unique = rand(50,100);
					$inp_unique_desktop = rand(50,100);
					$inp_unique_mobile = rand(50,100);
					$inp_unique_bots = rand(50,100);
					$inp_hits_total = rand(50,100);
					$inp_hits_human = rand(50,100);
					$inp_hits_desktop = rand(50,100);
					$inp_hits_mobile = rand(50,100);
					$inp_hits_bots = rand(50,100);

					echo"
					 <tr>
					  <td>
						<span>$date</span>
					  </td>
					  <td>
						<span>$inp_day_full</span>
					  </td>
					  <td>
						<span>$inp_day_three</span>
					  </td>
					  <td>
						<span>$inp_day_single</span>
					  </td>
					 </tr>
					";

					mysqli_query($link, "INSERT INTO $t_stats_visists_per_day 
					(`stats_visit_per_day_id`, `stats_visit_per_day_day`, `stats_visit_per_day_day_full`, `stats_visit_per_day_day_three`, `stats_visit_per_day_day_single`, 
					`stats_visit_per_day_month`, `stats_visit_per_day_month_full`, `stats_visit_per_day_month_short`, `stats_visit_per_day_year`, `stats_visit_per_day_human_unique`, 
					`stats_visit_per_day_human_unique_diff_from_yesterday`, `stats_visit_per_day_human_average_duration`, `stats_visit_per_day_human_new_visitor_unique`, `stats_visit_per_day_human_returning_visitor_unique`, `stats_visit_per_day_unique_desktop`, 
					`stats_visit_per_day_unique_mobile`, `stats_visit_per_day_unique_bots`, `stats_visit_per_day_hits_total`, `stats_visit_per_day_hits_human`, `stats_visit_per_day_hits_desktop`, 
					`stats_visit_per_day_hits_mobile`, `stats_visit_per_day_hits_bots`)
					VALUES
					(NULL, $inp_day, '$inp_day_full', '$inp_day_three', '$inp_day_single',
					$inp_month, '$inp_month_full', '$inp_month_short', $inp_year, $inp_human_unique, 
					$inp_human_unique_diff_from_last_year, '0', $inp_human_new_visitor_unique, $inp_returning_visitor_unique, 
					$inp_unique_desktop, $inp_unique_mobile, $inp_unique_bots, $inp_hits_total, $inp_hits_human, 
					$inp_hits_desktop, $inp_hits_mobile, $inp_hits_bots)")
					   or die(mysqli_error($link));
				} // days loop
			} // month loop
		} // year loop

		echo"
		</table>
		";
	} // generate test data == 1
} // logged in
?>