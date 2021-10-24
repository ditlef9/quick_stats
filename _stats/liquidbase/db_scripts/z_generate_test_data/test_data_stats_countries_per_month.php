<?php
if(isset($_SESSION['adm_user_id'])){


	$t_languages_countries  = $dbPrefixSav . "languages_countries";
	$t_stats_countries_per_month  = $dbPrefixSav . "stats_countries_per_month";

	mysqli_query($link, "TRUNCATE TABLE $t_stats_countries_per_month") or die(mysqli_error($link));


	if(isset($configGenerateTestDataSav) && $configGenerateTestDataSav == "1"){
		// Pick x random countries
		$year = date("Y");
		$month = date("m");
		$query = "SELECT country_id, country_name, country_iso_two FROM $t_languages_countries ORDER BY RAND() LIMIT 10";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_country_id, $get_country_name, $get_country_iso_two) = $row;

			$inp_unique = rand(50,100);
			$inp_hits = $inp_unique *2;

			$inp_name_mysql = quote_smart($link, $get_country_name);
			$inp_iso_mysql = quote_smart($link, $get_country_iso_two);

			mysqli_query($link, "INSERT INTO $t_stats_countries_per_month 
			(stats_country_id, stats_country_month, stats_country_year, stats_country_name, stats_country_alpha_2, stats_country_unique, 
			stats_country_hits) 
			VALUES
			(NULL, $month, $year, $inp_name_mysql, $inp_iso_mysql, $inp_unique, 
			$inp_hits)") or die(mysqli_error($link));
		}
	} // generate test data == 1
} // logged in

?>