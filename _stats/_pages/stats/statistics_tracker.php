<?php
/**
*
* File: _admin/_inc/media/statistics_trackers.php
* Version 3.0
* Date 13:25 21.10.2020
* Copyright (c) 2008-2020 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Access check ----------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}


/*- Tables ---------------------------------------------------------------------------------- */
$t_stats_accepted_languages_per_month	= $dbPrefixSav . "stats_accepted_languages_per_month";
$t_stats_accepted_languages_per_year	= $dbPrefixSav . "stats_accepted_languages_per_year";

$t_stats_browsers_per_month	= $dbPrefixSav . "stats_browsers_per_month";
$t_stats_browsers_per_year	= $dbPrefixSav . "stats_browsers_per_year";

$t_stats_comments_per_month 	= $dbPrefixSav . "stats_comments_per_month";
$t_stats_comments_per_year 	= $dbPrefixSav . "stats_comments_per_year";

$t_stats_countries_per_year  = $dbPrefixSav . "stats_countries_per_year";
$t_stats_countries_per_month = $dbPrefixSav . "stats_countries_per_month";

$t_stats_ip_to_country_ipv4 		= $dbPrefixSav . "stats_ip_to_country_ipv4";
$t_stats_ip_to_country_ipv6 		= $dbPrefixSav . "stats_ip_to_country_ipv6";
$t_stats_ip_to_country_geonames 	= $dbPrefixSav . "stats_ip_to_country_geonames";

$t_stats_os_per_month = $dbPrefixSav . "stats_os_per_month";
$t_stats_os_per_year = $dbPrefixSav . "stats_os_per_year";

$t_stats_languages_per_year	= $dbPrefixSav . "stats_languages_per_year";
$t_stats_languages_per_month	= $dbPrefixSav . "stats_languages_per_month";

$t_stats_referers_per_year  = $dbPrefixSav . "stats_referers_per_year";
$t_stats_referers_per_month = $dbPrefixSav . "stats_referers_per_month";

$t_stats_pages_visits_per_year = $dbPrefixSav . "stats_pages_visits_per_year";

$t_stats_user_agents_index = $dbPrefixSav . "stats_user_agents_index";

$t_stats_users_registered_per_month = $dbPrefixSav . "stats_users_registered_per_month";
$t_stats_users_registered_per_year = $dbPrefixSav . "stats_users_registered_per_year";

$t_stats_bots_per_month	= $dbPrefixSav . "stats_bots_per_month";
$t_stats_bots_per_year	= $dbPrefixSav . "stats_bots_per_year";

$t_stats_visists_per_day 	= $dbPrefixSav . "stats_visists_per_day";
$t_stats_visists_per_day_ips 	= $dbPrefixSav . "stats_visists_per_day_ips";
$t_stats_visists_per_month 	= $dbPrefixSav . "stats_visists_per_month";
$t_stats_visists_per_month_ips 	= $dbPrefixSav . "stats_visists_per_month_ips";
$t_stats_visists_per_year 	= $dbPrefixSav . "stats_visists_per_year";
$t_stats_visists_per_year_ips 	= $dbPrefixSav . "stats_visists_per_year_ips";

$t_search_engine_searches = $dbPrefixSav . "search_engine_searches";

$t_stats_tracker_index = $dbPrefixSav . "stats_tracker_index";
$t_stats_tracker_urls  = $dbPrefixSav . "stats_tracker_urls";

$t_languages 		= $dbPrefixSav . "languages";
$t_languages_active 	= $dbPrefixSav . "languages_active";


/*- Functions ----------------------------------------------------------------------- */
function get_title($url, $cmsNameSav, $cmsVersionSav, $cmsWebsiteSav) {
	$url = str_replace("&amp;", "&", $url);

	$options = array(
	  'http'=>array(
	    'method'=>"GET",
	    'header'=>"Accept-language: en\r\n" .
	              "Cookie: foo=bar\r\n" .  // check function.stream-context-create on php.net
	              "User-Agent:  Mozilla/5.0 (compatible; $cmsNameSav/$cmsVersionSav; +$cmsWebsiteSav)\r\n"
	  )
	);

	$context = stream_context_create($options);
	$page = file_get_contents($url, false, $context);
	$title = preg_match('/<title[^>]*>(.*?)<\/title>/ims', $page, $match) ? $match[1] : null;
	return $title;
}

/*- Variables -------------------------------------------------------------------------- */
if(isset($_GET['tracker_id'])) {
	$tracker_id = $_GET['tracker_id'];
	$tracker_id = strip_tags(stripslashes($tracker_id));
	if(!(is_numeric($tracker_id))){
		echo"Tracker ID not numeric";
		die;
	}
}
else{
	$tracker_id = 0;
}
$tracker_id_mysql = quote_smart($link, $tracker_id);

// Find year
$query = "SELECT tracker_id, tracker_ip, tracker_ip_masked, tracker_hostname, tracker_month, tracker_month_short, tracker_year, tracker_time_start, tracker_hour_minute_start, tracker_time_end, tracker_hour_minute_end, tracker_seconds_spent, tracker_time_spent, tracker_user_agent, tracker_os, tracker_browser, tracker_type, tracker_country_name, tracker_accept_language, tracker_language, tracker_last_url_value, tracker_last_url_title, tracker_last_url_title_fetched, tracker_hits FROM $t_stats_tracker_index WHERE tracker_id=$tracker_id_mysql";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_current_tracker_id, $get_current_tracker_ip, $get_current_tracker_ip_masked, $get_current_tracker_hostname, $get_current_tracker_month, $get_current_tracker_month_short, $get_current_tracker_year, $get_current_tracker_time_start, $get_current_tracker_hour_minute_start, $get_current_tracker_time_end, $get_current_tracker_hour_minute_end, $get_current_tracker_seconds_spent, $get_current_tracker_time_spent, $get_current_tracker_user_agent, $get_current_tracker_os, $get_current_tracker_browser, $get_current_tracker_type, $get_current_tracker_country_name, $get_current_tracker_accept_language, $get_current_tracker_language, $get_current_tracker_last_url_value, $get_current_tracker_last_url_title, $get_current_tracker_last_url_title_fetched, $get_current_tracker_hits) = $row;

if($get_current_tracker_id == ""){
	echo"<p>Server error 404</p>";
}
else{
	$year = date("Y");
	$user_agent_sum = md5($get_current_tracker_user_agent);

	echo"
	<!-- Headline -->
		<h1>Tracker $get_current_tracker_id</h1>
	<!-- //Headline -->
	
	<!-- Where am I? -->
		<p><b>You are here:</b><br />
		<a href=\"index.php?open=$open&amp;page=statistics&amp;editor_language=$editor_language\">Statistics</a>
		&gt;
		<a href=\"index.php?open=$open&amp;page=statistics_year&amp;stats_year=$year&amp;editor_language=$editor_language\">Stats $year</a>
		&gt;
		<a href=\"index.php?open=$open&amp;page=statistics_year&amp;stats_year=$year&amp;editor_language=$editor_language#trackers\">Trackers</a>
		&gt;
		<a href=\"index.php?open=$open&amp;page=statistics_tracker&amp;tracker_id=$get_current_tracker_id&amp;editor_language=$editor_language\">Tracker $get_current_tracker_id</a>
		</p>
	<!-- //Where am I? -->

	<!-- About -->
		<table>
		 <tr>
		  <td style=\"padding-right: 6px;vertical-align: top;\">
			<span>
			IP:<br />
			Hostname:<br />
			User agent:<br />
			OS:<br />
			Browser:<br />
			Type:
			</span>
		  </td>
		  <td style=\"padding-right: 10px;vertical-align: top;\">
			<span>
			$get_current_tracker_ip [<a href=\"index.php?open=$open&amp;page=banned&amp;action=add_new_banned_ip&amp;editor_language=$editor_language\">Ban</a>]<br />
			$get_current_tracker_hostname [<a href=\"index.php?open=$open&amp;page=banned&amp;action=add_new_banned_hostname&amp;editor_language=$editor_language\">Ban</a>]<br />
			$get_current_tracker_user_agent [<a href=\"$configStatsURLSav/index.php?open=$open&amp;page=user_agents&amp;mode=ban_hostname&amp;user_agent_sum=$user_agent_sum&amp;editor_language=$editor_language\">Ban</a>]<br />
			$get_current_tracker_os<br />
			$get_current_tracker_browser<br />
			$get_current_tracker_type
			</span>
		  </td>
		  <td style=\"padding-right: 6px;vertical-align: top;\">
			<span>
			Country:<br />
			Accept language:<br />
			Language:<br />
			Hits:
			</span>
		  </td>
		  <td style=\"vertical-align: top;\">
			<span>
			$get_current_tracker_country_name<br />
			$get_current_tracker_accept_language<br />
			$get_current_tracker_language<br />
			$get_current_tracker_hits
			</span>
		  </td>
		 </tr>

		</table>
	<!-- //About -->

	<!-- URLS -->
		<h2>URLS</h2>

		<table class=\"hor-zebra\">
		 <thead>
		  <tr>
		   <th scope=\"col\">
			<span>Time</span>
		   </th>
		   <th scope=\"col\">
			<span>Title</span>
		   </th>
		   <th scope=\"col\">
			<span>Time spent</span>
		   </th>
		  </tr>
		 </thead>
		 <tbody>
		";
		$last_url_id 		= 0;
		$last_time_start 	= 0;
		$last_seconds_spent 	= 0;
		$last_time_spent 	= 0;
		$prev_day 		= 0;
		$query = "SELECT url_id, url_tracker_id, url_value, url_title, url_title_fetched, url_day, url_month, url_month_short, url_year, url_time_start, url_hour_minute_start, url_time_end, url_hour_minute_end, url_seconds_spent, url_time_spent FROM $t_stats_tracker_urls WHERE url_tracker_id=$get_current_tracker_id ORDER BY url_id ASC";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_url_id, $get_url_tracker_id, $get_url_value, $get_url_title, $get_url_title_fetched, $get_url_day, $get_url_month, $get_url_month_short, $get_url_year, $get_url_time_start, $get_url_hour_minute_start, $get_url_time_end, $get_url_hour_minute_end, $get_url_seconds_spent, $get_url_time_spent) = $row;
			
			// Time spent
			if($last_time_start == "0"){
				$calculate_time_spent_on_last = 0;
			}
			else{
			
				$calculate_seconds = $get_url_time_start-$last_time_start;
				$hours = floor($calculate_seconds / 3600);

				$minutes = floor(($calculate_seconds / 60) % 60);
				$minutes_len = strlen($minutes);
				if($minutes_len == "1"){
					$minutes = "0" . $minutes;
				}

				$seconds = $calculate_seconds % 60;
				$seconds_len = strlen($seconds);
				if($seconds_len == "1"){
					$seconds = "0" . $seconds;
				}
				if($hours == "0"){
					$calculate_time_spent_on_last = "$minutes:$seconds";
				}
				else{
					$calculate_time_spent_on_last = "$hours:$minutes:$seconds";
				}
			}
			if($last_url_id != "0" && $last_time_spent != "$calculate_time_spent_on_last"){
				mysqli_query($link, "UPDATE $t_stats_tracker_urls SET 
							url_seconds_spent=$calculate_seconds, 
							url_time_spent='$calculate_time_spent_on_last' 
							WHERE url_id=$last_url_id") or die(mysqli_error($link));

				echo"<div class=\"info\"><p>Calculating ID $last_url_id from $last_time_spent to $calculate_time_spent_on_last</p></div>
				<meta http-equiv=refresh content=\"1; URL=index.php?open=$open&amp;page=statistics_tracker&amp;tracker_id=$get_current_tracker_id&amp;editor_language=$editor_language\">
				";
			}

			// We need to visit the site in order to get the correct page title
			if($get_url_title_fetched == "0"){
				$inp_title = get_title($get_url_value, $cmsNameSav, $cmsVersionSav, $cmsWebsiteSav);

				if($inp_title  == ""){
					$inp_title = "$get_url_value";
				}
				$inp_title = output_html($inp_title);
				$inp_title_mysql = quote_smart($link, $inp_title);
				$inp_url_value_mysql = quote_smart($link, $get_url_value);
				mysqli_query($link, "UPDATE $t_stats_tracker_urls SET url_title=$inp_title_mysql, url_title_fetched=1 WHERE url_value=$inp_url_value_mysql") or die(mysqli_error($link));
				$get_url_title = "$inp_title";
			}

			// Headline
			if($prev_day != "$get_url_day"){
				echo"
				 <tr>
				  <td colspan=\"3\">
					<span><b>$get_url_day $get_url_month_short $get_url_year</b></span>
				  </td>
				 </tr>
				";
			}

			echo"
			 <tr>
			  <td>
				<span>$get_url_hour_minute_start</span>
			  </td>
			  <td>
				<span><a href=\"$get_url_value\">$get_url_title</a></span>
			  </td>
			  <td>
				<span>$get_url_time_spent</span>
			  </td>
			 </tr>
			";

			// Transfer
			$last_url_id 	 = $get_url_id;
			$last_time_start = $get_url_time_start;
			$last_seconds_spent = $get_url_seconds_spent;
			$last_time_spent = $get_url_time_spent;

			$prev_day = $get_url_day;
		}
		echo"
		 </tbody>
		</table>
	<!-- //Trackers -->

	";
	
} // year found

?>