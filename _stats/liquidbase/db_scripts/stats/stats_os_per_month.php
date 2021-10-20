<?php
if(isset($_SESSION['adm_user_id'])){

	$t_stats_os_per_month = $dbPrefixSav . "stats_os_per_month";

	// Drop table
	mysqli_query($link,"DROP TABLE IF EXISTS $t_stats_os_per_month") or die(mysqli_error());




	// Stats :: OS
	$query = "SELECT * FROM $t_stats_os_per_month LIMIT 1";
	$result = mysqli_query($link, $query);

	if($result !== FALSE){
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_stats_os_per_month(
					stats_os_id INT NOT NULL AUTO_INCREMENT,
					PRIMARY KEY(stats_os_id), 
		   			stats_os_month INT,
		   			stats_os_year YEAR,
		   			stats_os_name VARCHAR(250),
		   			stats_os_type VARCHAR(250),
		   			stats_os_unique INT,
		   			stats_os_hits INT)")
	   			or die(mysqli_error($link));
	}

}
?>