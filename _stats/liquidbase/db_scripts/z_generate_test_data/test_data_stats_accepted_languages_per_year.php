<?php
if(isset($_SESSION['adm_user_id'])){


	$t_languages_countries  		= $dbPrefixSav . "languages_countries";
	$t_stats_accepted_languages_per_year  	= $dbPrefixSav . "stats_accepted_languages_per_year";

	mysqli_query($link, "TRUNCATE TABLE $t_stats_accepted_languages_per_year") or die(mysqli_error($link));


	if(isset($configGenerateTestDataSav) && $configGenerateTestDataSav == "1"){
		echo"
		<h2>Generating test data :: stats_countries_per_year</h2>
		";

		// Pick x random countries
		$year = date("Y");
		$query = "SELECT country_id, country_name, country_iso_two FROM $t_languages_countries ORDER BY RAND() LIMIT 10";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_country_id, $get_country_name, $get_country_iso_two) = $row;

			$inp_unique = rand(50,100);
			$inp_hits = $inp_unique *2;

			$inp_name_mysql = quote_smart($link, $get_country_name);
			$inp_iso_mysql = quote_smart($link, $get_country_iso_two);

			mysqli_query($link, "INSERT INTO $t_stats_accepted_languages_per_year  
			(stats_accepted_language_id, stats_accepted_language_year, stats_accepted_language_name, stats_accepted_language_unique, stats_accepted_language_hits) 
			VALUES
			(NULL, $year, $inp_iso_mysql, $inp_unique, $inp_hits)") or die(mysqli_error($link));
		}
	} // generate test data == 1
} // logged in

?>