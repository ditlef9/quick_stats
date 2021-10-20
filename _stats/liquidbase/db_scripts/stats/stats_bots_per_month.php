<?php
if(isset($_SESSION['adm_user_id'])){


	$t_stats_bots_per_month	= $dbPrefixSav . "stats_bots_per_month";
	$t_stats_bots_per_year	= $dbPrefixSav . "stats_bots_per_year";


	// Drop table
	mysqli_query($link,"DROP TABLE IF EXISTS $t_stats_bots_per_month") or die(mysqli_error());



	// Stats :: Browser
	$query = "SELECT * FROM $t_stats_bots_per_month LIMIT 1";
	$result = mysqli_query($link, $query);

	if($result !== FALSE){
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_stats_bots_per_month(
					stats_bot_id INT NOT NULL AUTO_INCREMENT,
					PRIMARY KEY(stats_bot_id), 
					stats_bot_month INT,
					stats_bot_year YEAR,
					stats_bot_name VARCHAR(250),
					stats_bot_unique INT,
					stats_bot_hits INT)")
					or die(mysqli_error($link));
	}
}
?>