<?php
if(isset($_SESSION['adm_user_id'])){

	$t_stats_users_registered_per_month = $dbPrefixSav . "stats_users_registered_per_month";
	$t_stats_users_registered_per_year = $dbPrefixSav . "stats_users_registered_per_year";



	// Drop table
	mysqli_query($link,"DROP TABLE IF EXISTS $t_stats_users_registered_per_year") or die(mysqli_error());



	$query = "SELECT * FROM $t_stats_users_registered_per_year LIMIT 1";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_stats_users_registered_per_year (
					stats_registered_id INT NOT NULL AUTO_INCREMENT,
					PRIMARY KEY(stats_registered_id), 
					stats_registered_year INT,
					stats_registered_users_registed INT,
					stats_registered_users_registed_diff_from_last_year INT,
					stats_registered_last_updated DATETIME,
					stats_registered_last_updated_day INT,
					stats_registered_last_updated_month INT,
					stats_registered_last_updated_year INT)")
					or die(mysqli_error($link));
	}

}
?>