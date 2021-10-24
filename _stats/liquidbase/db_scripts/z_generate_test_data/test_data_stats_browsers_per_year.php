<?php
if(isset($_SESSION['adm_user_id'])){


	$t_stats_browsers_per_year	= $dbPrefixSav . "stats_browsers_per_year";

	mysqli_query($link, "TRUNCATE TABLE $t_stats_browsers_per_year") or die(mysqli_error($link));


	$year = date("Y");

	if(isset($configGenerateTestDataSav) && $configGenerateTestDataSav == "1"){
		echo"
		";
		$mobile_browsers = array('AppleWebKit', 'Dalvik', 'Mobile Safari', 'Minefield', 'Safari', 'Chrome', 'Firefox', 'Opera', 'OPR', 'SamsungBrowser', 'UCBrowser');
		$mobile_browsers_size = sizeof($mobile_browsers);

		$desktop_browsers = array('AppleWebKit', 'Safari', 'Chrome', 'Edge', 'Edg', 'Firefox', 'Galeon', 'Minefield', 'MSIE', 'Opera', 'SkypeUriPreview', 'Trident', 
							  'Thunderbird', 'Qt', 'Wget');
		$desktop_browsers_size = sizeof($desktop_browsers);
	
	
		for($x=0;$x<5;$x++){

			$mobile_or_desktop = rand(0,1);
			if($mobile_or_desktop == "1"){
				$rand_browser = rand(0, $mobile_browsers_size-1);
				$browser = $mobile_browsers[$rand_browser];
			}
			else{
				$rand_browser = rand(0, $desktop_browsers_size-1);
				$browser = $desktop_browsers[$rand_browser];
			}

			$inp_name_mysql = quote_smart($link, $browser);

			$inp_unique = rand(50,100);
			$inp_hits = $inp_unique *2;

			mysqli_query($link, "INSERT INTO $t_stats_browsers_per_year
			(stats_browser_id, stats_browser_year, stats_browser_name, stats_browser_unique, stats_browser_hits) 
			VALUES
			(NULL, $year, $inp_name_mysql, $inp_unique, $inp_hits)") or die(mysqli_error($link));
		}

	} // generate test data == 1
} // logged in

?>