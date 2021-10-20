<?php
if(isset($_SESSION['adm_user_id'])){

	/*- Tables -------------------------------------------------------------------------- */
	$t_stats_ip_to_country_lookup 	= $dbPrefixSav . "stats_ip_to_country_lookup";

	$query = "SELECT ip_id, country FROM $t_stats_ip_to_country_lookup";
	$result = mysqli_query($link, $query);
	while($row = mysqli_fetch_row($result)) {
		list($get_ip_id, $get_country) = $row;
	
		$inp_country = strtolower($get_country);

		mysqli_query($link, "UPDATE $t_stats_ip_to_country_lookup SET country='$inp_country' WHERE ip_id=$get_ip_id") or die(mysqli_error($link));
	}

	
} // admin
?>