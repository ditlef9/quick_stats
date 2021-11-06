<?php
if(isset($_SESSION['adm_user_id'])){


	// Database from https://db-ip.com/db/
	// Updated 2021-05-12	


	/*- Functions -------------------------------------------------------------------------- */
	function delete_directory($dirname) {
		echo"<p>delete_directory($dirname)</p>";
		if (is_dir($dirname))
			$dir_handle = opendir($dirname);
			if (!$dir_handle)
				return false;
			while($file = readdir($dir_handle)) {
				if ($file != "." && $file != "..") {
					if (!is_dir($dirname."/".$file))
					unlink($dirname."/".$file);
               		else
                     		delete_directory($dirname.'/'.$file);
           		}
     		}
     		closedir($dir_handle);
     		rmdir($dirname);
    		return true;
	}


	/*- Tables -------------------------------------------------------------------------- */
	$t_stats_ip_to_country_lookup_ipv4 	= $dbPrefixSav . "stats_ip_to_country_lookup_ipv4";
	mysqli_query($link,"DROP TABLE IF EXISTS $t_stats_ip_to_country_lookup_ipv4") or die(mysqli_error());

	// 

	// Stats
	$query = "SELECT * FROM $t_stats_ip_to_country_lookup_ipv4 LIMIT 1";
	$result = mysqli_query($link, $query);

	if($result !== FALSE){
	}
	else{

		mysqli_query($link, "CREATE TABLE $t_stats_ip_to_country_lookup_ipv4 (
					ip_id INT NOT NULL AUTO_INCREMENT,
					PRIMARY KEY(ip_id), 
					`addr_type` enum('ipv4','ipv6') NOT NULL,
					`ip_start` varbinary(16) NOT NULL,
					`ip_end` varbinary(16) NOT NULL,
					`country` char(2) NOT NULL)") or die(mysqli_error($link));

	} // Create table


	// Truncate cache
	// Delete cache
	if(!(is_dir("../_cache"))){
		mkdir("../_cache");
	}
	delete_directory("../_cache");
	if(!(is_dir("../_cache"))){
		mkdir("../_cache");
	}

	
} // admin
?>