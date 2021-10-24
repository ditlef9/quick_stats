<?php
if(isset($_SESSION['adm_user_id'])){


	$t_stats_bots_per_year 	= $dbPrefixSav . "stats_bots_per_year";

	mysqli_query($link, "TRUNCATE TABLE $t_stats_bots_per_year") or die(mysqli_error($link));


	$year = date("Y");

	if(isset($configGenerateTestDataSav) && $configGenerateTestDataSav == "1"){
		echo"
		";

		
		$robots = array(
		'Apache-HttpClient', 'archive.org_bot', 'AhrefsBot', 'AlphaBot', 'aboundex', 'altavista', 'appengine-google',
		'Baiduspider', 'browsershot', 'botje.com', 'bing', 'bingbot', 
		'CheckMarkNetwork', 'Cliqzbot', 'curl', 
		'Dataprovider.com', 'discobot', 'Dispatch', 'edisterbot', 'DuckDuckGo-Favicons-Bot', 
		'exabot', 'ExtLinksBot', 'evc-batch', 'facebook', 'dotbot', 
		'gigabot', 'G-i-g-a-b-o-t', 'Grammarly', 'googlebot-mobile', 'gigabot', 'gidbot', 'googlebot', 'mediapartners-google', 'google-site-verification', 'googlebot-image', 
		'Go-http-client', 'GuzzleHttp', 'Google-Youtube-Links', 
		'ia_archiver', 'ics', 
		'jyxobot',  'lycos', 
		'HTTrack', 'Hstpnetwork.com', 
		'linkdexbot', 
		'MJ12bot', 'mail.ru_bot', 'meanpathbo', 'mlbot', 'msnbot', 'MSIECrawler',
		 'openbot', 
		'Qwantify', 
		'proximic', 'PocketParser', 'python-requests', 'Python-urllib', 
		'SeznamBot', 'semrushbot', 'SEOkicks-Robot', 'SMTBot','slurp', 'scooter', 'SiteExplorer', 
		'startsite.com', 'synapse', 'Snapchat', 'Sogou web spider', 'spbot', 'Scrapy', 
		'teoma', 'openacoon', 'twitter', 'temnos', 
		'unikstart', 'Uptimebot',
		'vbseo', 
		'Yandexnot', 'yammybot', 'YandexMobileBot', 'YandexBot', 'yahoo', 
		'zgrab',
		'Wappalyzer', 'w3c_validator', 'windows-live', 'WhatsApp', 'WordPress');

		$robots_size = sizeof($robots);

		for($x=0;$x<5;$x++){
			$random = rand(0, $robots_size-1);
			$bot = $robots[$random];


			$inp_name_mysql = quote_smart($link, $bot);
			

			$inp_unique = rand(50,100);
			$inp_hits = $inp_unique *2;

			mysqli_query($link, "INSERT INTO $t_stats_bots_per_year 
			(stats_bot_id, stats_bot_year, stats_bot_name, stats_bot_unique, stats_bot_hits) 
			VALUES
			(NULL, $year, $inp_name_mysql, $inp_unique, $inp_hits)") or die(mysqli_error($link));
		}

	} // generate test data == 1
} // logged in

?>