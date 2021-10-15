<?php
if(isset($_SESSION['admin_user_id'])){


	$t_stats_browsers_per_month	= $dbPrefixSav . "stats_browsers_per_month";
	$t_stats_browsers_per_year	= $dbPrefixSav . "stats_browsers_per_year";


	// Drop table
	mysqli_query($link,"DROP TABLE IF EXISTS $t_stats_browsers_per_year") or die(mysqli_error());



	// Stats :: Browser
	$query = "SELECT * FROM $t_stats_browsers_per_year LIMIT 1";
	$result = mysqli_query($link, $query);

	if($result !== FALSE){
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_stats_browsers_per_year(
					stats_browser_id INT NOT NULL AUTO_INCREMENT,
					PRIMARY KEY(stats_browser_id), 
					stats_browser_year INT,
					stats_browser_name VARCHAR(250),
					stats_browser_unique INT,
					stats_browser_hits INT)")
					or die(mysqli_error($link));
	}
}
?>