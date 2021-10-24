<?php
if(isset($_SESSION['adm_user_id'])){


	$t_languages			= $dbPrefixSav . "languages";
	$t_languages_countries  	= $dbPrefixSav . "languages_countries";
	$t_stats_languages_per_year  	= $dbPrefixSav . "stats_languages_per_year";

	mysqli_query($link, "TRUNCATE TABLE $t_stats_languages_per_year") or die(mysqli_error($link));


	if(isset($configGenerateTestDataSav) && $configGenerateTestDataSav == "1"){
		echo"
		";

		// Pick x random countries
		$year = date("Y");
		$query = "SELECT language_id, language_name, language_slug, language_native_name, language_iso_two, language_iso_three, language_iso_two_alt_a, language_iso_two_alt_b, language_flag_path_16x16, language_flag_16x16, language_flag_path_32x32, language_flag_32x32, language_charset FROM $t_languages ORDER BY RAND() LIMIT 10";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_language_id, $get_language_name, $get_language_slug, $get_language_native_name, $get_language_iso_two, $get_language_iso_three, $get_language_iso_two_alt_a, $get_language_iso_two_alt_b, $get_language_flag_path_16x16, $get_language_flag_16x16, $get_language_flag_path_32x32, $get_language_flag_32x32, $get_language_charset) = $row;


			$inp_name_mysql = quote_smart($link, $get_language_name);
			$inp_iso_mysql = quote_smart($link, $get_language_iso_two);
			$inp_path_mysql = quote_smart($link, $get_language_flag_path_16x16);
			$inp_flag_mysql = quote_smart($link, $get_language_flag_16x16);

			$inp_unique = rand(50,100);
			$inp_hits = $inp_unique *2;

			mysqli_query($link, "INSERT INTO $t_stats_languages_per_year 
			(stats_language_id, stats_language_year, stats_language_name, stats_language_iso_two, stats_language_flag_path_16x16, 
			stats_language_flag_16x16, stats_language_unique, stats_language_hits) 
			VALUES
			(NULL, $year, $inp_name_mysql, $inp_iso_mysql, $inp_path_mysql, 
			$inp_flag_mysql, $inp_unique, $inp_hits)") or die(mysqli_error($link));
		}

	} // generate test data == 1
} // logged in

?>