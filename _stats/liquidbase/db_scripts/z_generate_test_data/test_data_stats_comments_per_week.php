<?php
if(isset($_SESSION['adm_user_id'])){


	$t_stats_comments_per_week = $dbPrefixSav . "stats_comments_per_week";

	mysqli_query($link, "TRUNCATE TABLE $t_stats_comments_per_week") or die(mysqli_error($link));



	if(isset($configGenerateTestDataSav) && $configGenerateTestDataSav == "1"){
		echo"
		";

		$current_week = date("W");
		$current_month = date("m");
		$current_year = date("Y");

			
		$inp_comments_written = rand(1,60);

		
		mysqli_query($link, "INSERT INTO $t_stats_comments_per_week
		(stats_comments_id, stats_comments_week, stats_comments_month, stats_comments_year, stats_comments_comments_written, stats_comments_comments_written_diff_from_last_week) 
		VALUES
		(NULL, $current_week, $current_month, $current_year, $inp_comments_written, 0 )") or die(mysqli_error($link));

	} // generate test data == 1
} // logged in
?>