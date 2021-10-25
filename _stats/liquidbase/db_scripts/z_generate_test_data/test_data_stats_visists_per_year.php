<?php
if(isset($_SESSION['adm_user_id'])){


	$t_stats_visists_per_year  = $dbPrefixSav . "stats_visists_per_year";
	mysqli_query($link, "TRUNCATE TABLE $t_stats_visists_per_year") or die(mysqli_error($link));


	if(isset($configGenerateTestDataSav) && $configGenerateTestDataSav == "1"){
		echo"
		<h2>Generating test data :: stats_visists_per_year</h2>
		";

		$year = date("Y");
		$start = $year-2;
		$stop = $year+1;
		for($x=$start;$x<$stop;$x++){
			$inp_year = "$x";
			$inp_human_unique = rand(90000,100000);
			$inp_human_unique_diff_from_last_year = rand(90000,100000);
			$inp_human_new_visitor_unique = rand(90000,100000);
			$inp_returning_visitor_unique = rand(90000,100000);
			$inp_unique_desktop = rand(90000,100000);
			$inp_unique_mobile = rand(90000,100000);
			$inp_unique_bots = rand(90000,100000);
			$inp_hits_total = rand(90000,100000);
			$inp_hits_human = rand(90000,100000);
			$inp_hits_desktop = rand(90000,100000);
			$inp_hits_mobile = rand(90000,100000);
			$inp_hits_bots = rand(90000,100000);

			mysqli_query($link, "INSERT INTO $t_stats_visists_per_year 
			(`stats_visit_per_year_id`, `stats_visit_per_year_year`, `stats_visit_per_year_human_unique`, `stats_visit_per_year_human_unique_diff_from_last_year`, `stats_visit_per_year_human_average_duration`, 
			`stats_visit_per_year_human_new_visitor_unique`, `stats_visit_per_year_human_returning_visitor_unique`, `stats_visit_per_year_unique_desktop`, `stats_visit_per_year_unique_mobile`, `stats_visit_per_year_unique_bots`, 
			`stats_visit_per_year_hits_total`, `stats_visit_per_year_hits_human`, `stats_visit_per_year_hits_desktop`, `stats_visit_per_year_hits_mobile`, `stats_visit_per_year_hits_bots`) 
			VALUES
			(NULL, $inp_year, $inp_human_unique, $inp_human_unique_diff_from_last_year, '0', 
			$inp_human_new_visitor_unique, $inp_returning_visitor_unique, $inp_unique_desktop, $inp_unique_mobile, $inp_unique_bots, 
			$inp_hits_total, $inp_hits_human, $inp_hits_desktop, $inp_hits_mobile, $inp_hits_bots)")
			   or die(mysqli_error($link));
		}
	} // generate test data == 1
} // logged in

?>