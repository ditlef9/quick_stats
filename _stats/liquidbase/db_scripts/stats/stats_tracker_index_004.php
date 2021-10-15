
<?php
if(isset($_SESSION['admin_user_id'])){


	$t_stats_tracker_index = $dbPrefixSav . "stats_tracker_index";



	// Drop table
	mysqli_query($link,"DROP TABLE IF EXISTS $t_stats_tracker_index") or die(mysqli_error());



	$query = "SELECT * FROM $t_stats_tracker_index LIMIT 1";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_stats_tracker_index (
					tracker_id INT NOT NULL AUTO_INCREMENT,
					PRIMARY KEY(tracker_id), 
					tracker_ip VARCHAR(256),
					tracker_ip_masked VARCHAR(20),
					tracker_hostname VARCHAR(256),
					tracker_month INT,
					tracker_month_short VARCHAR(10),
					tracker_year INT,
					tracker_time_start INT,
					tracker_hour_minute_start VARCHAR(5),
					tracker_time_end INT,
					tracker_hour_minute_end VARCHAR(5),
					tracker_seconds_spent INT,
					tracker_time_spent VARCHAR(25),
					tracker_user_agent VARCHAR(256),
					tracker_os VARCHAR(256),
					tracker_browser VARCHAR(256),
					tracker_type VARCHAR(256),
			   		tracker_country_name VARCHAR(200),
					tracker_accept_language VARCHAR(256),
					tracker_language VARCHAR(256),
					tracker_last_url_value VARCHAR(500),
					tracker_last_url_title VARCHAR(500),
					tracker_last_url_title_fetched INT,
					tracker_hits INT)")
					or die(mysqli_error($link));
	}

}
?>