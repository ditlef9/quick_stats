<?php
if(isset($_SESSION['adm_user_id'])){


	$t_stats_comments_per_month  = $dbPrefixSav . "stats_comments_per_month";

	mysqli_query($link, "TRUNCATE TABLE $t_stats_comments_per_month") or die(mysqli_error($link));


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
		";

		$current_month = date("m");
		$current_year = date("Y");

			
		for($y=0;$y<12;$y++){
			$inp_month = $y+1;
			$inp_month_full = $months_long[$y];
			$inp_month_short = $months_short[$y];
			$inp_comments_written = rand(1,60);

			// Check that we are in range
			if($inp_month > $current_month){
				// Out of range
			}
			else{
				mysqli_query($link, "INSERT INTO $t_stats_comments_per_month
				(stats_comments_id, stats_comments_month, stats_comments_month_full, stats_comments_month_short, stats_comments_year, 
				stats_comments_comments_written, stats_comments_comments_written_diff_from_last_month) 
				VALUES
				(NULL, $inp_month, '$inp_month_full', '$inp_month_short', $current_year,
				$inp_comments_written, 0 )") or die(mysqli_error($link));
			}
		} // month loop
	} // generate test data == 1
} // logged in
?>