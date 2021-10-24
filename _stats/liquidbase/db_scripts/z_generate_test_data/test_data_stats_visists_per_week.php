<?php
if(isset($_SESSION['adm_user_id'])){


	$t_stats_visists_per_week  = $dbPrefixSav . "stats_visists_per_week";


	if(isset($configGenerateTestDataSav) && $configGenerateTestDataSav == "1"){
		echo"
		<h2>Generating test data :: stats_visists_per_month</h2>
		";

		$year = date("Y");
		$start = $year-1;
		$stop = $year+1;
		for($x=$start;$x<$stop;$x++){


			$inp_year = "$x";

			for($y=0;$y<52;$y++){
				$inp_week = $y+1;
 

				$inp_month = (new DateTime())->setISODate($inp_year, $inp_week)->format('m');
				$inp_month_short = (new DateTime())->setISODate($inp_year, $inp_week)->format('M');
				$inp_date = (new DateTime())->setISODate($inp_year, $inp_week)->format('Y-m-d');

				$inp_human_unique = rand(0,1000);
				$inp_human_unique_diff_from_last_year = rand(0,1000);
				$inp_human_new_visitor_unique = rand(0,1000);
				$inp_returning_visitor_unique = rand(0,1000);
				$inp_unique_desktop = rand(0,1000);
				$inp_unique_mobile = rand(0,1000);
				$inp_unique_bots = rand(0,1000);
				$inp_hits_total = rand(0,1000);
				$inp_hits_human = rand(0,1000);
				$inp_hits_desktop = rand(0,1000);
				$inp_hits_mobile = rand(0,1000);
				$inp_hits_bots = rand(0,1000);

				mysqli_query($link, "INSERT INTO $t_stats_visists_per_week
				(stats_visit_per_week_id, stats_visit_per_week_week, stats_visit_per_week_month, stats_visit_per_week_month_short, stats_visit_per_week_year, 
				stats_visit_per_week_date, 
				stats_visit_per_week_human_unique, stats_visit_per_week_human_unique_diff_from_last_week, stats_visit_per_week_human_average_duration, stats_visit_per_week_human_new_visitor_unique, stats_visit_per_week_human_returning_visitor_unique, 
				stats_visit_per_week_unique_desktop, stats_visit_per_week_unique_mobile, stats_visit_per_week_unique_bots, stats_visit_per_week_hits_total, stats_visit_per_week_hits_human, 
				stats_visit_per_week_hits_desktop, stats_visit_per_week_hits_mobile, stats_visit_per_week_hits_bots) 
				VALUES
				(NULL, $inp_week, $inp_month, '$inp_month_short', $inp_year,
				'$inp_date',

				$inp_human_unique, $inp_human_unique_diff_from_last_year, '0', $inp_human_new_visitor_unique, $inp_returning_visitor_unique, 
				$inp_unique_desktop, $inp_unique_mobile, $inp_unique_bots, $inp_hits_total, $inp_hits_human, 
				$inp_hits_desktop, $inp_hits_mobile, $inp_hits_bots)")
				   or die(mysqli_error($link));

			} // month loop
		} // year loop

	} // generate test data == 1
} // logged in
?>