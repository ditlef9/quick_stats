<?php
if(isset($_SESSION['adm_user_id'])){


	$t_stats_os_per_year  	= $dbPrefixSav . "stats_os_per_year";

	mysqli_query($link, "TRUNCATE TABLE $t_stats_os_per_year") or die(mysqli_error($link));


	$year = date("Y");

	if(isset($configGenerateTestDataSav) && $configGenerateTestDataSav == "1"){
		echo"
		";

		$desktop_os = array('Freebsd', 'Fedora', 'Linux x86_64', 'Linux i686', 'linux-gnu', 'Mac OS X', 'Windows NT', 'Ubuntu', 'X11');
		foreach($desktop_os as $os){

			$inp_name_mysql = quote_smart($link, $os);
			$inp_type_mysql = quote_smart($link, "");

			$inp_unique = rand(50,100);
			$inp_hits = $inp_unique *2;

			mysqli_query($link, "INSERT INTO $t_stats_os_per_year  
			(stats_os_id, stats_os_year, stats_os_name, stats_os_type, stats_os_unique, stats_os_hits) 
			VALUES
			(NULL, $year, $inp_name_mysql, $inp_type_mysql, $inp_unique, $inp_hits)") or die(mysqli_error($link));
		}

	} // generate test data == 1
} // logged in

?>