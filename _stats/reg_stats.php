<?php
error_reporting(E_ALL);
session_start();
ini_set('arg_separator.output', '&amp;');
/**
*
* File: _stats/reg_stats.php
* Version 1.0.0
* Date 09:46 15.10.2021
* Copyright (c) 2021 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- MySQL ---------------------------------------------------------------------------- */
$db_config_file = "_stats/_data/db.php";
if(file_exists($db_config_file)){
	include("$db_config_file");
	$link = mysqli_connect($dbHostSav, $dbUserNameSav, $dbPasswordSav, $dbDatabaseNameSav);
	if (mysqli_connect_errno()){
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	/*- MySQL Tables -------------------------------------------------- */
	$t_admin_liquidbase	= $dbPrefixSav . "admin_liquidbase";
	$t_users		= $dbPrefixSav . "users";
}
else{
	echo"No mysql"; die;
}

include("_stats/_data/meta.php");

/*- Functions ------------------------------------------------------------------------ */
include("_stats/_functions/clean.php");
include("_stats/_functions/output_html.php");
include("_stats/_functions/quote_smart.php");


/*- Tables ---------------------------------------------------------------------------------- */
$t_languages_active	      = $dbPrefixSav . "languages_active";
$t_languages_countries	      = $dbPrefixSav . "languages_countries";

$t_stats_accepted_languages_per_month	= $dbPrefixSav . "stats_accepted_languages_per_month";
$t_stats_accepted_languages_per_year	= $dbPrefixSav . "stats_accepted_languages_per_year";

$t_stats_browsers_per_month	= $dbPrefixSav . "stats_browsers_per_month";
$t_stats_browsers_per_year	= $dbPrefixSav . "stats_browsers_per_year";

$t_stats_comments_per_month 	= $dbPrefixSav . "stats_comments_per_month";
$t_stats_comments_per_year 	= $dbPrefixSav . "stats_comments_per_year";

$t_stats_countries_per_year  = $dbPrefixSav . "stats_countries_per_year";
$t_stats_countries_per_month = $dbPrefixSav . "stats_countries_per_month";

$t_stats_ip_to_country_lookup_ipv4 = $dbPrefixSav . "stats_ip_to_country_lookup_ipv4";
$t_stats_ip_to_country_lookup_ipv6 = $dbPrefixSav . "stats_ip_to_country_lookup_ipv6";

$t_stats_languages_per_year	= $dbPrefixSav . "stats_languages_per_year";
$t_stats_languages_per_month	= $dbPrefixSav . "stats_languages_per_month";

$t_stats_os_per_month = $dbPrefixSav . "stats_os_per_month";
$t_stats_os_per_year = $dbPrefixSav . "stats_os_per_year";

$t_stats_referers_per_year  = $dbPrefixSav . "stats_referers_per_year";
$t_stats_referers_per_month = $dbPrefixSav . "stats_referers_per_month";

$t_stats_user_agents_index = $dbPrefixSav . "stats_user_agents_index";

$t_stats_users_registered_per_month = $dbPrefixSav . "stats_users_registered_per_month";
$t_stats_users_registered_per_year = $dbPrefixSav . "stats_users_registered_per_year";

$t_stats_bots_per_month	= $dbPrefixSav . "stats_bots_per_month";
$t_stats_bots_per_year	= $dbPrefixSav . "stats_bots_per_year";

$t_stats_pages_visits_per_year		= $dbPrefixSav . "stats_pages_visits_per_year";
$t_stats_pages_visits_per_year_ips 	= $dbPrefixSav . "stats_pages_visits_per_year_ips";

$t_stats_visists_per_day 	= $dbPrefixSav . "stats_visists_per_day";
$t_stats_visists_per_day_ips 	= $dbPrefixSav . "stats_visists_per_day_ips";
$t_stats_visists_per_week 	= $dbPrefixSav . "stats_visists_per_week";
$t_stats_visists_per_week_ips 	= $dbPrefixSav . "stats_visists_per_week_ips";
$t_stats_visists_per_month 	= $dbPrefixSav . "stats_visists_per_month";
$t_stats_visists_per_month_ips 	= $dbPrefixSav . "stats_visists_per_month_ips";
$t_stats_visists_per_year 	= $dbPrefixSav . "stats_visists_per_year";
$t_stats_visists_per_year_ips 	= $dbPrefixSav . "stats_visists_per_year_ips";

$t_stats_tracker_index = $dbPrefixSav . "stats_tracker_index";
$t_stats_tracker_urls  = $dbPrefixSav . "stats_tracker_urls";

/*- Page URL ------------------------------------------------------------------------------- */
$page_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$page_url = htmlspecialchars($page_url, ENT_QUOTES, 'UTF-8');
$page_url = output_html($page_url);

/*- Find me based on user ------------------------------------------------------------------- */
$my_user_agent = $_SERVER['HTTP_USER_AGENT'];
$my_user_agent = output_html($my_user_agent);
$my_user_agent_mysql = quote_smart($link, $my_user_agent);

$my_ip = $_SERVER['REMOTE_ADDR'];
$my_ip = output_html($my_ip);
$my_ip_mysql = quote_smart($link, $my_ip);

$my_hostname = "$my_ip";
if($configStatsUseGethostbyaddrSav == "1"){
	$my_hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']); // Some servers in local network cant use getostbyaddr because of nameserver missing
}
$my_hostname = output_html($my_hostname);
$my_hostname_mysql = quote_smart($link, $my_hostname);




// Find user agent. By looking for user agent we can know if it is human or bot
$query = "SELECT stats_user_agent_id, stats_user_agent_string, stats_user_agent_type, stats_user_agent_browser, stats_user_agent_browser_version, stats_user_agent_browser_icon, stats_user_agent_os, stats_user_agent_os_version, stats_user_agent_os_icon, stats_user_agent_bot, stats_user_agent_bot_icon, stats_user_agent_bot_website, stats_user_agent_banned FROM $t_stats_user_agents_index WHERE stats_user_agent_string=$my_user_agent_mysql";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_stats_user_agent_id, $get_stats_user_agent_string, $get_stats_user_agent_type, $get_stats_user_agent_browser, $get_stats_user_agent_browser_version, $get_stats_user_agent_browser_icon, $get_stats_user_agent_os, $get_stats_user_agent_os_version, $get_stats_user_agent_os_icon, $get_stats_user_agent_bot, $get_stats_user_agent_bot_icon, $get_stats_user_agent_bot_website, $get_stats_user_agent_banned) = $row;
if($get_stats_user_agent_id == ""){
	$define_in_register_stats = 1;
	include("_stats/reg_stats_autoinsert_new_user_agent.php");

	$query = "SELECT stats_user_agent_id, stats_user_agent_string, stats_user_agent_type, stats_user_agent_browser, stats_user_agent_browser_version, stats_user_agent_browser_icon, stats_user_agent_os, stats_user_agent_os_version, stats_user_agent_os_icon, stats_user_agent_bot, stats_user_agent_bot_icon, stats_user_agent_bot_website, stats_user_agent_banned FROM $t_stats_user_agents_index WHERE stats_user_agent_string=$my_user_agent_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_stats_user_agent_id, $get_stats_user_agent_string, $get_stats_user_agent_type, $get_stats_user_agent_browser, $get_stats_user_agent_browser_version, $get_stats_user_agent_browser_icon, $get_stats_user_agent_os, $get_stats_user_agent_os_version, $get_stats_user_agent_os_icon, $get_stats_user_agent_bot, $get_stats_user_agent_bot_icon, $get_stats_user_agent_bot_website, $get_stats_user_agent_banned) = $row;

}

// Banned
if($get_stats_user_agent_banned == "1"){
	header("HTTP/1.0 403 Forbidden");
	echo"<!DOCTYPE html>\n";
	echo"<html lang=\"en\">\n";
	echo"<head>\n";
	echo"	<title>Server error 403 #2</title>\n";
	echo"	<meta charset=iso-8859-1 />\n";
	echo"	</head>\n";
	echo"<body>\n";
	echo"<h1>Server error 403 #1</h1>\n";
	echo"<p>User agent ";echo $user_agent;echo" is banned.</p>\n";
	echo"</body>\n";
	echo"</html>";
	die;	
}


// Date
$inp_day = date("d");
$inp_day_full = date("l");
$inp_day_short = date("D");
$inp_day_single = substr($inp_day_short, 0, 1);
$inp_date = date("Y-m-d");
$inp_time = date("H:i:s");
$inp_hour_minute = date("H:i");
$inp_month = date("m");
$inp_month_full = date("F");
$inp_month_short = date("M");
$inp_year = date("Y");
$inp_week = date("W");
$inp_unix_time = time();

// Inp from user agent
if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])){
	$inp_accept_language = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
	$inp_accept_language = output_html($inp_accept_language);
	$inp_accept_language = strtolower($inp_accept_language);
}
else{
	$inp_accept_language = "ZZ";
}
$inp_accpeted_language = substr("$inp_accept_language", 0,2);
$inp_accpeted_language_mysql = quote_smart($link, $inp_accpeted_language);

$inp_page = $_SERVER['REQUEST_URI'];
$inp_page = output_html($inp_page);
$inp_page_mysql = quote_smart($link, $inp_page);

$inp_user_agent_bot = output_html($get_stats_user_agent_bot);
$inp_user_agent_bot_mysql = quote_smart($link, $inp_user_agent_bot);

$inp_user_agent_bot_icon = output_html($get_stats_user_agent_bot_icon);
$inp_user_agent_bot_icon_mysql = quote_smart($link, $inp_user_agent_bot_icon);

$inp_user_agent_browser = output_html($get_stats_user_agent_browser);
$inp_user_agent_browser_mysql = quote_smart($link, $inp_user_agent_browser);

$inp_user_agent_os = output_html($get_stats_user_agent_os);
$inp_user_agent_os_mysql = quote_smart($link, $inp_user_agent_os);

$inp_stats_user_agent_type = output_html($get_stats_user_agent_type);
$inp_stats_user_agent_type_mysql = quote_smart($link, $inp_stats_user_agent_type);


// Language from variable "l"
if(isset($_GET['l'])){
	$l = $_GET['l'];
	$l = output_html($l);
	$l = substr($l, 0, 2);
	$l_mysql = quote_smart($link, $l);
	$query = "SELECT language_active_id, language_active_name, language_active_slug, language_active_native_name, language_active_iso_two, language_active_iso_three, language_active_iso_two_alt_a, language_active_iso_two_alt_b, language_active_flag_path_16x16, language_active_flag_16x16, language_active_flag_path_32x32, language_active_flag_32x32, language_active_charset, language_active_default FROM $t_languages_active WHERE language_active_iso_two=$l_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_language_active_id, $get_current_language_active_name, $get_current_language_active_slug, $get_current_language_active_native_name, $get_current_language_active_iso_two, $get_current_language_active_iso_three, $get_current_language_active_iso_two_alt_a, $get_current_language_active_iso_two_alt_b, $get_current_language_active_flag_path_16x16, $get_current_language_active_flag_16x16, $get_current_language_active_flag_path_32x32, $get_current_language_active_flag_32x32, $get_current_language_active_charset, $get_current_language_active_default) = $row;
}
if(!(isset($get_current_language_active_id)) OR $get_current_language_active_id == ""){
	$query = "SELECT language_active_id, language_active_name, language_active_slug, language_active_native_name, language_active_iso_two, language_active_iso_three, language_active_iso_two_alt_a, language_active_iso_two_alt_b, language_active_flag_path_16x16, language_active_flag_16x16, language_active_flag_path_32x32, language_active_flag_32x32, language_active_charset, language_active_default FROM $t_languages_active WHERE language_active_default=1 LIMIT 0,1";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_language_active_id, $get_current_language_active_name, $get_current_language_active_slug, $get_current_language_active_native_name, $get_current_language_active_iso_two, $get_current_language_active_iso_three, $get_current_language_active_iso_two_alt_a, $get_current_language_active_iso_two_alt_b, $get_current_language_active_flag_path_16x16, $get_current_language_active_flag_16x16, $get_current_language_active_flag_path_32x32, $get_current_language_active_flag_32x32, $get_current_language_active_charset, $get_current_language_active_default) = $row;
}


// Visits per year
$query = "SELECT stats_visit_per_year_id, stats_visit_per_year_year, stats_visit_per_year_human_unique, stats_visit_per_year_human_unique_diff_from_last_year, stats_visit_per_year_human_average_duration, stats_visit_per_year_human_new_visitor_unique, stats_visit_per_year_human_returning_visitor_unique, stats_visit_per_year_unique_desktop, stats_visit_per_year_unique_mobile, stats_visit_per_year_unique_bots, stats_visit_per_year_hits_total, stats_visit_per_year_hits_human, stats_visit_per_year_hits_desktop, stats_visit_per_year_hits_mobile, stats_visit_per_year_hits_bots FROM $t_stats_visists_per_year WHERE stats_visit_per_year_year='$inp_year'";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_stats_visit_per_year_id, $get_stats_visit_per_year_year, $get_stats_visit_per_year_human_unique, $get_stats_visit_per_year_human_unique_diff_from_last_year, $get_stats_visit_per_year_human_average_duration, $get_stats_visit_per_year_human_new_visitor_unique, $get_stats_visit_per_year_human_returning_visitor_unique, $get_stats_visit_per_year_unique_desktop, $get_stats_visit_per_year_unique_mobile, $get_stats_visit_per_year_unique_bots, $get_stats_visit_per_year_hits_total, $get_stats_visit_per_year_hits_human, $get_stats_visit_per_year_hits_desktop, $get_stats_visit_per_year_hits_mobile, $get_stats_visit_per_year_hits_bots) = $row;
if($get_stats_visit_per_year_id == ""){
	// Create new year
	mysqli_query($link, "INSERT INTO $t_stats_visists_per_year
	(stats_visit_per_year_id, stats_visit_per_year_year, stats_visit_per_year_human_unique, stats_visit_per_year_human_unique_diff_from_last_year, stats_visit_per_year_human_average_duration, 
	stats_visit_per_year_human_new_visitor_unique, stats_visit_per_year_human_returning_visitor_unique, stats_visit_per_year_unique_desktop, stats_visit_per_year_unique_mobile, stats_visit_per_year_unique_bots, 
	stats_visit_per_year_hits_total, stats_visit_per_year_hits_human, stats_visit_per_year_hits_desktop, stats_visit_per_year_hits_mobile, stats_visit_per_year_hits_bots) 
	VALUES
	(NULL, '$inp_year', '0', '0', '0',
	'0', '0', '0', '0', '0',
	'0', '0', '0', '0', '0')") or die(mysqli_error($link));

	// Get new ID
	$query = "SELECT stats_visit_per_year_id, stats_visit_per_year_year, stats_visit_per_year_human_unique, stats_visit_per_year_human_unique_diff_from_last_year, stats_visit_per_year_human_average_duration, stats_visit_per_year_human_new_visitor_unique, stats_visit_per_year_human_returning_visitor_unique, stats_visit_per_year_unique_desktop, stats_visit_per_year_unique_mobile, stats_visit_per_year_unique_bots, stats_visit_per_year_hits_total, stats_visit_per_year_hits_human, stats_visit_per_year_hits_desktop, stats_visit_per_year_hits_mobile, stats_visit_per_year_hits_bots FROM $t_stats_visists_per_year WHERE stats_visit_per_year_year='$inp_year'";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_stats_visit_per_year_id, $get_stats_visit_per_year_year, $get_stats_visit_per_year_human_unique, $get_stats_visit_per_year_human_unique_diff_from_last_year, $get_stats_visit_per_year_human_average_duration, $get_stats_visit_per_year_human_new_visitor_unique, $get_stats_visit_per_year_human_returning_visitor_unique, $get_stats_visit_per_year_unique_desktop, $get_stats_visit_per_year_unique_mobile, $get_stats_visit_per_year_unique_bots, $get_stats_visit_per_year_hits_total, $get_stats_visit_per_year_hits_human, $get_stats_visit_per_year_hits_desktop, $get_stats_visit_per_year_hits_mobile, $get_stats_visit_per_year_hits_bots) = $row;
	
	// Truncate temp data
	mysqli_query($link, "TRUNCATE TABLE $t_stats_visists_per_year_ips") or die(mysqli_error());
	mysqli_query($link, "TRUNCATE TABLE $t_stats_pages_visits_per_year_ips") or die(mysqli_error());
}


// Visits per month
$query = "SELECT stats_visit_per_month_id, stats_visit_per_month_human_unique, stats_visit_per_month_human_unique_diff_from_last_month, stats_visit_per_month_human_average_duration, stats_visit_per_month_human_new_visitor_unique, stats_visit_per_month_human_returning_visitor_unique, stats_visit_per_month_unique_desktop, stats_visit_per_month_unique_mobile, stats_visit_per_month_unique_bots, stats_visit_per_month_hits_total, stats_visit_per_month_hits_human, stats_visit_per_month_hits_desktop, stats_visit_per_month_hits_mobile, stats_visit_per_month_hits_bots FROM $t_stats_visists_per_month WHERE stats_visit_per_month_month='$inp_month' AND stats_visit_per_month_year='$inp_year'";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_stats_visit_per_month_id, $get_stats_visit_per_month_human_unique, $get_stats_visit_per_month_human_unique_diff_from_last_month, $get_stats_visit_per_month_human_average_duration, $get_stats_visit_per_month_human_new_visitor_unique, $get_stats_visit_per_month_human_returning_visitor_unique, $get_stats_visit_per_month_unique_desktop, $get_stats_visit_per_month_unique_mobile, $get_stats_visit_per_month_unique_bots, $get_stats_visit_per_month_hits_total, $get_stats_visit_per_month_hits_human, $get_stats_visit_per_month_hits_desktop, $get_stats_visit_per_month_hits_mobile, $get_stats_visit_per_month_hits_bots) = $row;
if($get_stats_visit_per_month_id == ""){
	// Create new month
	mysqli_query($link, "INSERT INTO $t_stats_visists_per_month
	(stats_visit_per_month_id, stats_visit_per_month_month, stats_visit_per_month_month_full, stats_visit_per_month_month_short, stats_visit_per_month_year,
	stats_visit_per_month_human_unique, stats_visit_per_month_human_unique_diff_from_last_month, stats_visit_per_month_human_average_duration, stats_visit_per_month_human_new_visitor_unique, stats_visit_per_month_human_returning_visitor_unique, 
	stats_visit_per_month_unique_desktop, stats_visit_per_month_unique_mobile, stats_visit_per_month_unique_bots, stats_visit_per_month_hits_total, stats_visit_per_month_hits_human, 
	stats_visit_per_month_hits_desktop, stats_visit_per_month_hits_mobile, stats_visit_per_month_hits_bots) 
	VALUES
	(NULL, '$inp_month', '$inp_month_full', '$inp_month_short',  $inp_year,
	0, 0, 0, 0, 0,
	0, 0, 0, 0, 0,
	0, 0, 0)") or die(mysqli_error($link));

	// Get new ID
	$query = "SELECT stats_visit_per_month_id, stats_visit_per_month_human_unique, stats_visit_per_month_human_unique_diff_from_last_month, stats_visit_per_month_human_average_duration, stats_visit_per_month_human_new_visitor_unique, stats_visit_per_month_human_returning_visitor_unique, stats_visit_per_month_unique_desktop, stats_visit_per_month_unique_mobile, stats_visit_per_month_unique_bots, stats_visit_per_month_hits_total, stats_visit_per_month_hits_human, stats_visit_per_month_hits_desktop, stats_visit_per_month_hits_mobile, stats_visit_per_month_hits_bots FROM $t_stats_visists_per_month WHERE stats_visit_per_month_month='$inp_month' AND stats_visit_per_month_year='$inp_year'";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_stats_visit_per_month_id, $get_stats_visit_per_month_human_unique, $get_stats_visit_per_month_human_unique_diff_from_last_month, $get_stats_visit_per_month_human_average_duration, $get_stats_visit_per_month_human_new_visitor_unique, $get_stats_visit_per_month_human_returning_visitor_unique, $get_stats_visit_per_month_unique_desktop, $get_stats_visit_per_month_unique_mobile, $get_stats_visit_per_month_unique_bots, $get_stats_visit_per_month_hits_total, $get_stats_visit_per_month_hits_human, $get_stats_visit_per_month_hits_desktop, $get_stats_visit_per_month_hits_mobile, $get_stats_visit_per_month_hits_bots) = $row;

	// Truncate temp data
	mysqli_query($link,"TRUNCATE TABLE $t_stats_visists_per_month_ips") or die(mysqli_error());
	// mysqli_query($link,"TRUNCATE TABLE $t_stats_tracker_index") or die(mysqli_error());
	// mysqli_query($link,"TRUNCATE TABLE $t_stats_tracker_urls") or die(mysqli_error());
}

// Visits per week
$query = "SELECT stats_visit_per_week_id, stats_visit_per_week_human_unique, stats_visit_per_week_human_unique_diff_from_last_week, stats_visit_per_week_human_average_duration, stats_visit_per_week_human_new_visitor_unique, stats_visit_per_week_human_returning_visitor_unique, stats_visit_per_week_unique_desktop, stats_visit_per_week_unique_mobile, stats_visit_per_week_unique_bots, stats_visit_per_week_hits_total, stats_visit_per_week_hits_human, stats_visit_per_week_hits_desktop, stats_visit_per_week_hits_mobile, stats_visit_per_week_hits_bots FROM $t_stats_visists_per_week WHERE stats_visit_per_week_week='$inp_week' AND stats_visit_per_week_year='$inp_year'";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_stats_visit_per_week_id, $get_stats_visit_per_week_human_unique, $get_stats_visit_per_week_human_unique_diff_from_last_week, $get_stats_visit_per_week_human_average_duration, $get_stats_visit_per_week_human_new_visitor_unique, $get_stats_visit_per_week_human_returning_visitor_unique, $get_stats_visit_per_week_unique_desktop, $get_stats_visit_per_week_unique_mobile, $get_stats_visit_per_week_unique_bots, $get_stats_visit_per_week_hits_total, $get_stats_visit_per_week_hits_human, $get_stats_visit_per_week_hits_desktop, $get_stats_visit_per_week_hits_mobile, $get_stats_visit_per_week_hits_bots) = $row;
if($get_stats_visit_per_week_id == ""){
	// Create new week
	mysqli_query($link, "INSERT INTO $t_stats_visists_per_week
	(stats_visit_per_week_id, stats_visit_per_week_week, stats_visit_per_week_month, stats_visit_per_week_month_short, stats_visit_per_week_year, 
	stats_visit_per_week_human_unique, stats_visit_per_week_human_unique_diff_from_last_week, stats_visit_per_week_human_average_duration, stats_visit_per_week_human_new_visitor_unique, stats_visit_per_week_human_returning_visitor_unique, 
	stats_visit_per_week_unique_desktop, stats_visit_per_week_unique_mobile, stats_visit_per_week_unique_bots, stats_visit_per_week_hits_total, stats_visit_per_week_hits_human, 
	stats_visit_per_week_hits_desktop, stats_visit_per_week_hits_mobile, stats_visit_per_week_hits_bots) 
	VALUES
	(NULL, '$inp_week', '$inp_month', '$inp_month_short',  $inp_year,
	0, 0, 0, 0, 0,
	0, 0, 0, 0, 0,
	0, 0, 0)") or die(mysqli_error($link));

	// Get new ID
	$query = "SELECT stats_visit_per_week_id, stats_visit_per_week_human_unique, stats_visit_per_week_human_unique_diff_from_last_week, stats_visit_per_week_human_average_duration, stats_visit_per_week_human_new_visitor_unique, stats_visit_per_week_human_returning_visitor_unique, stats_visit_per_week_unique_desktop, stats_visit_per_week_unique_mobile, stats_visit_per_week_unique_bots, stats_visit_per_week_hits_total, stats_visit_per_week_hits_human, stats_visit_per_week_hits_desktop, stats_visit_per_week_hits_mobile, stats_visit_per_week_hits_bots FROM $t_stats_visists_per_week WHERE stats_visit_per_week_week='$inp_week' AND stats_visit_per_week_year='$inp_year'";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_stats_visit_per_week_id, $get_stats_visit_per_week_human_unique, $get_stats_visit_per_week_human_unique_diff_from_last_week, $get_stats_visit_per_week_human_average_duration, $get_stats_visit_per_week_human_new_visitor_unique, $get_stats_visit_per_week_human_returning_visitor_unique, $get_stats_visit_per_week_unique_desktop, $get_stats_visit_per_week_unique_mobile, $get_stats_visit_per_week_unique_bots, $get_stats_visit_per_week_hits_total, $get_stats_visit_per_week_hits_human, $get_stats_visit_per_week_hits_desktop, $get_stats_visit_per_week_hits_mobile, $get_stats_visit_per_week_hits_bots) = $row;

	// Truncate temp data
	mysqli_query($link,"TRUNCATE TABLE $t_stats_visists_per_week_ips") or die(mysqli_error());
}

// Visits per day
$query = "SELECT stats_visit_per_day_id, stats_visit_per_day_human_unique, stats_visit_per_day_human_unique_diff_from_yesterday, stats_visit_per_day_human_average_duration, stats_visit_per_day_human_new_visitor_unique, stats_visit_per_day_human_returning_visitor_unique, stats_visit_per_day_unique_desktop, stats_visit_per_day_unique_mobile, stats_visit_per_day_unique_bots, stats_visit_per_day_hits_total, stats_visit_per_day_hits_human, stats_visit_per_day_hits_desktop, stats_visit_per_day_hits_mobile, stats_visit_per_day_hits_bots FROM $t_stats_visists_per_day WHERE stats_visit_per_day_day='$inp_day' AND stats_visit_per_day_month='$inp_month' AND stats_visit_per_day_year='$inp_year'";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_stats_visit_per_day_id, $get_stats_visit_per_day_human_unique, $get_stats_visit_per_day_human_unique_diff_from_yesterday, $get_stats_visit_per_day_human_average_duration, $get_stats_visit_per_day_human_new_visitor_unique, $get_stats_visit_per_day_human_returning_visitor_unique, $get_stats_visit_per_day_unique_desktop, $get_stats_visit_per_day_unique_mobile, $get_stats_visit_per_day_unique_bots, $get_stats_visit_per_day_hits_total, $get_stats_visit_per_day_hits_human, $get_stats_visit_per_day_hits_desktop, $get_stats_visit_per_day_hits_mobile, $get_stats_visit_per_day_hits_bots) = $row;
if($get_stats_visit_per_day_id == ""){
	// Create
	mysqli_query($link, "INSERT INTO $t_stats_visists_per_day
	(stats_visit_per_day_id, stats_visit_per_day_day, stats_visit_per_day_day_full, stats_visit_per_day_day_three, stats_visit_per_day_day_single, 
	stats_visit_per_day_month, stats_visit_per_day_month_full, stats_visit_per_day_month_short, 
	stats_visit_per_day_year, stats_visit_per_day_human_unique, stats_visit_per_day_human_unique_diff_from_yesterday, stats_visit_per_day_human_average_duration, stats_visit_per_day_human_new_visitor_unique, 
	stats_visit_per_day_human_returning_visitor_unique, stats_visit_per_day_unique_desktop, stats_visit_per_day_unique_mobile, stats_visit_per_day_unique_bots, stats_visit_per_day_hits_total, 
	stats_visit_per_day_hits_human, stats_visit_per_day_hits_desktop, stats_visit_per_day_hits_mobile, stats_visit_per_day_hits_bots) 
	VALUES
	(NULL, '$inp_day', '$inp_day_full', '$inp_day_short', '$inp_day_single', '$inp_month', '$inp_month_full', '$inp_month_short',
	'$inp_year', '0', '0','0','0', 
	'0', '0', '0', '0', '0', 
	'0', '0', '0', '0')") or die(mysqli_error($link));

	$query = "SELECT stats_visit_per_day_id, stats_visit_per_day_human_unique, stats_visit_per_day_human_unique_diff_from_yesterday, stats_visit_per_day_human_average_duration, stats_visit_per_day_human_new_visitor_unique, stats_visit_per_day_human_returning_visitor_unique, stats_visit_per_day_unique_desktop, stats_visit_per_day_unique_mobile, stats_visit_per_day_unique_bots, stats_visit_per_day_hits_total, stats_visit_per_day_hits_human, stats_visit_per_day_hits_desktop, stats_visit_per_day_hits_mobile, stats_visit_per_day_hits_bots FROM $t_stats_visists_per_day WHERE stats_visit_per_day_day='$inp_day' AND stats_visit_per_day_month='$inp_month' AND stats_visit_per_day_year='$inp_year'";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_stats_visit_per_day_id, $get_stats_visit_per_day_human_unique, $get_stats_visit_per_day_human_unique_diff_from_yesterday, $get_stats_visit_per_day_human_average_duration, $get_stats_visit_per_day_human_new_visitor_unique, $get_stats_visit_per_day_human_returning_visitor_unique, $get_stats_visit_per_day_unique_desktop, $get_stats_visit_per_day_unique_mobile, $get_stats_visit_per_day_unique_bots, $get_stats_visit_per_day_hits_total, $get_stats_visit_per_day_hits_human, $get_stats_visit_per_day_hits_desktop, $get_stats_visit_per_day_hits_mobile, $get_stats_visit_per_day_hits_bots) = $row;
}

// Bot
if($get_stats_user_agent_type == "bot"){
	// Visists :: Year :: IPs
	$query = "SELECT stats_visit_per_year_ip_id, stats_visit_per_year_ip_year, stats_visit_per_year_type, stats_visit_per_year_ip FROM $t_stats_visists_per_year_ips WHERE stats_visit_per_year_ip_year='$inp_year' AND stats_visit_per_year_ip=$my_ip_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_stats_visit_per_year_ip_id, $get_stats_visit_per_year_ip_year, $get_stats_visit_per_year_type, $get_stats_visit_per_year_ip) = $row;
	if($get_stats_visit_per_year_ip_id == ""){
		// New visitor this year
		mysqli_query($link, "INSERT INTO $t_stats_visists_per_year_ips 
		(stats_visit_per_year_ip_id, stats_visit_per_year_ip_year, stats_visit_per_year_type, stats_visit_per_year_ip) 
		VALUES
		(NULL, '$inp_year', '$get_stats_user_agent_type', $my_ip_mysql)") or die(mysqli_error($link));
			
		// Update unique
		$inp_visit_per_year_bots_unique = $get_stats_visit_per_year_unique_bots+1;
		$inp_visit_per_year_hits_bots = $get_stats_visit_per_year_hits_bots+1;
		$inp_visit_per_year_hits_total = $get_stats_visit_per_year_hits_total+1;
		
		// Update
		$result = mysqli_query($link, "UPDATE $t_stats_visists_per_year SET 
						stats_visit_per_year_unique_bots=$inp_visit_per_year_bots_unique,
						stats_visit_per_year_hits_total=$inp_visit_per_year_hits_total,
						stats_visit_per_year_hits_bots=$inp_visit_per_year_hits_bots
						WHERE stats_visit_per_year_id=$get_stats_visit_per_year_id") or die(mysqli_error($link));
	}
	else{
		// Update hits
		$inp_visit_per_year_hits_total = $get_stats_visit_per_year_hits_total+1;
		$inp_visit_per_year_hits_bots = $get_stats_visit_per_year_hits_bots+1;
		$result = mysqli_query($link, "UPDATE $t_stats_visists_per_year SET 
						stats_visit_per_year_hits_total=$inp_visit_per_year_hits_total,
						stats_visit_per_year_hits_bots=$inp_visit_per_year_hits_bots
						WHERE stats_visit_per_year_id=$get_stats_visit_per_year_id") or die(mysqli_error($link));
	} // Visits :: Year

	// Visists :: Month :: IPs
	$query = "SELECT stats_visit_per_month_ip_id, stats_visit_per_month_ip_month, stats_visit_per_month_ip_year, stats_visit_per_month_type, stats_visit_per_month_ip FROM $t_stats_visists_per_month_ips WHERE stats_visit_per_month_ip_month='$inp_month' AND stats_visit_per_month_ip_year='$inp_year' AND stats_visit_per_month_ip=$my_ip_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_stats_visit_per_month_ip_id, $get_stats_visit_per_month_ip_month, $get_stats_visit_per_month_ip_year, $get_stats_visit_per_month_type, $get_stats_visit_per_month_ip) = $row;
	if($get_stats_visit_per_month_ip_id == ""){
		// New visitor this month
		mysqli_query($link, "INSERT INTO $t_stats_visists_per_month_ips 
			(stats_visit_per_month_ip_id, stats_visit_per_month_ip_month, stats_visit_per_month_ip_year, stats_visit_per_month_type, stats_visit_per_month_ip) 
			VALUES
			(NULL, '$inp_month', '$inp_year', '$get_stats_user_agent_type', $my_ip_mysql)") or die(mysqli_error($link));
			
		// Update unique
		$inp_visit_per_month_bots_unique = $get_stats_visit_per_month_unique_bots+1;
		$inp_visit_per_month_hits_bots = $get_stats_visit_per_month_hits_bots+1;
		$inp_visit_per_month_hits_total = $get_stats_visit_per_month_hits_total+1;
		
		// Update
		$result = mysqli_query($link, "UPDATE $t_stats_visists_per_month SET 
							stats_visit_per_month_unique_bots=$inp_visit_per_month_bots_unique,
							stats_visit_per_month_hits_total=$inp_visit_per_month_hits_total,
							stats_visit_per_month_hits_bots=$inp_visit_per_month_hits_bots
							WHERE stats_visit_per_month_id=$get_stats_visit_per_month_id") or die(mysqli_error($link));

	}
	else{
		// Update hits for bots
		$inp_visit_per_month_hits_total = $get_stats_visit_per_month_hits_total+1;
		$inp_visit_per_month_hits_bots = $get_stats_visit_per_month_hits_bots+1;
		$result = mysqli_query($link, "UPDATE $t_stats_visists_per_month SET 
							stats_visit_per_month_hits_total=$inp_visit_per_month_hits_total,
							stats_visit_per_month_hits_bots=$inp_visit_per_month_hits_bots
							WHERE stats_visit_per_month_id=$get_stats_visit_per_month_id") or die(mysqli_error($link));
			
	} // Visits :: Month

	// Visists :: Week :: IPs
	$query = "SELECT stats_visit_per_week_ip_id, stats_visit_per_week_ip_week, stats_visit_per_week_ip_year, stats_visit_per_week_type, stats_visit_per_week_ip FROM $t_stats_visists_per_week_ips WHERE stats_visit_per_week_ip_week='$inp_week' AND stats_visit_per_week_ip_year='$inp_year' AND stats_visit_per_week_ip=$my_ip_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_stats_visit_per_week_ip_id, $get_stats_visit_per_week_ip_week, $get_stats_visit_per_week_ip_year, $get_stats_visit_per_week_type, $get_stats_visit_per_week_ip) = $row;
	if($get_stats_visit_per_week_ip_id == ""){
		// New visitor this day
		mysqli_query($link, "INSERT INTO $t_stats_visists_per_week_ips 
		(stats_visit_per_week_ip_id, stats_visit_per_week_ip_week, stats_visit_per_week_ip_year, stats_visit_per_week_type, stats_visit_per_week_ip) 
		VALUES
		(NULL, '$inp_week', '$inp_year', '$get_stats_user_agent_type', $my_ip_mysql)") or die(mysqli_error($link));

		// Update unique
		$inp_visit_per_week_bots_unique = $get_stats_visit_per_week_unique_bots+1;
		$inp_visit_per_week_hits_bots   = $get_stats_visit_per_week_hits_bots+1;
		$inp_visit_per_week_hits_total  = $get_stats_visit_per_week_hits_total+1;
			
		// Update
		$result = mysqli_query($link, "UPDATE $t_stats_visists_per_week SET 
							stats_visit_per_week_unique_bots=$inp_visit_per_week_bots_unique,
							stats_visit_per_week_hits_total=$inp_visit_per_week_hits_total,
							stats_visit_per_week_hits_bots=$inp_visit_per_week_hits_bots
							WHERE stats_visit_per_week_id=$get_stats_visit_per_week_id") or die(mysqli_error($link));

	}
	else{
		// Update hits
		$inp_visit_per_week_hits_bots   = $get_stats_visit_per_week_hits_bots+1;
		$inp_visit_per_week_hits_total  = $get_stats_visit_per_week_hits_total+1;
		$result = mysqli_query($link, "UPDATE $t_stats_visists_per_week SET 
							stats_visit_per_week_hits_total=$inp_visit_per_week_hits_total,
							stats_visit_per_week_hits_bots=$inp_visit_per_week_hits_bots
							WHERE stats_visit_per_week_id=$get_stats_visit_per_week_id") or die(mysqli_error($link));
	} // Visits :: Week



	// Visists :: Day :: IPs
	$query = "SELECT stats_visit_per_day_ip_id, stats_visit_per_day_ip_day, stats_visit_per_day_ip_month, stats_visit_per_day_ip_year, stats_visit_per_day_type, stats_visit_per_day_ip FROM $t_stats_visists_per_day_ips WHERE stats_visit_per_day_ip_day='$inp_day' AND stats_visit_per_day_ip_month='$inp_month' AND stats_visit_per_day_ip_year='$inp_year' AND stats_visit_per_day_ip=$my_ip_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_stats_visit_per_day_ip_id, $get_stats_visit_per_day_ip_day, $get_stats_visit_per_day_ip_month, $get_stats_visit_per_day_ip_year, $get_stats_visit_per_day_type, $get_stats_visit_per_day_ip) = $row;
	if($get_stats_visit_per_day_ip_id == ""){
		// New visitor this day
		mysqli_query($link, "INSERT INTO $t_stats_visists_per_day_ips 
		(stats_visit_per_day_ip_id, stats_visit_per_day_ip_day, stats_visit_per_day_ip_month, stats_visit_per_day_ip_year, stats_visit_per_day_type, stats_visit_per_day_ip) 
		VALUES
		(NULL, '$inp_day', '$inp_month', '$inp_year', '$get_stats_user_agent_type', $my_ip_mysql)") or die(mysqli_error($link));
		
		// Update unique
		$inp_visit_per_day_bots_unique = $get_stats_visit_per_day_unique_bots+1;
		$inp_visit_per_day_hits_bots = $get_stats_visit_per_day_hits_bots+1;
		$inp_visit_per_day_hits_total = $get_stats_visit_per_day_hits_total+1;
		
		// Update
		$result = mysqli_query($link, "UPDATE $t_stats_visists_per_day SET 
						stats_visit_per_day_unique_bots=$inp_visit_per_day_bots_unique,
						stats_visit_per_day_hits_total=$inp_visit_per_day_hits_total,
						stats_visit_per_day_hits_bots=$inp_visit_per_day_hits_bots
						WHERE stats_visit_per_day_id=$get_stats_visit_per_day_id") or die(mysqli_error($link));
	}
	else{
		// Update hits
		$inp_visit_per_day_hits_total = $get_stats_visit_per_day_hits_total+1;
		$inp_visit_per_day_hits_bots = $get_stats_visit_per_day_hits_bots+1;
		$result = mysqli_query($link, "UPDATE $t_stats_visists_per_day SET 
							stats_visit_per_day_hits_total=$inp_visit_per_day_hits_total,
							stats_visit_per_day_hits_bots=$inp_visit_per_day_hits_bots
							WHERE stats_visit_per_day_id=$get_stats_visit_per_day_id") or die(mysqli_error($link));
	} // Visits :: Day

	// Bots :: Year
	$query = "SELECT stats_bot_id, stats_bot_unique, stats_bot_hits FROM $t_stats_bots_per_year WHERE stats_bot_year='$inp_year' AND stats_bot_name=$inp_user_agent_bot_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_stats_bot_id, $get_stats_bot_unique, $get_stats_bot_hits) = $row;
	if($get_stats_bot_id == ""){
		mysqli_query($link, "INSERT INTO $t_stats_bots_per_year
		(stats_bot_id, stats_bot_year, stats_bot_name, stats_bot_unique, stats_bot_hits) 
		VALUES
		(NULL, '$inp_year', $inp_user_agent_bot_mysql, '1', '1')") or die(mysqli_error($link));
	}
	else{
		$inp_stats_bot_hits = $get_stats_bot_hits+1;
		$result = mysqli_query($link, "UPDATE $t_stats_bots_per_year SET stats_bot_hits='$inp_stats_bot_hits' WHERE stats_bot_id='$get_stats_bot_id'") or die(mysqli_error($link));
	}

	// Bots :: Month
	$query = "SELECT stats_bot_id, stats_bot_unique, stats_bot_hits FROM $t_stats_bots_per_month WHERE stats_bot_month='$inp_month' AND stats_bot_year='$inp_year' AND stats_bot_name=$inp_user_agent_bot_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_stats_bot_id, $get_stats_bot_unique, $get_stats_bot_hits) = $row;
	if($get_stats_bot_id == ""){
		mysqli_query($link, "INSERT INTO $t_stats_bots_per_month
		(stats_bot_id, stats_bot_month, stats_bot_year, stats_bot_name, stats_bot_unique, stats_bot_hits) 
		VALUES
		(NULL, '$inp_month', '$inp_year', $inp_user_agent_bot_mysql, '1', '1')") or die(mysqli_error($link));
	}
	else{
		$inp_stats_bot_unique = $get_stats_bot_unique+1;
		$inp_stats_bot_hits = $get_stats_bot_hits+1;
		$result = mysqli_query($link, "UPDATE $t_stats_bots_per_month SET stats_bot_unique='$inp_stats_bot_unique', stats_bot_hits='$inp_stats_bot_hits' WHERE stats_bot_id='$get_stats_bot_id'");
	}

	// Pages :: Year (Bots)
	if($configSiteDaysToKeepPageVisitsSav != "0"){
		$page_url_len = strlen($page_url);
		if($page_url_len > 190){
			$page_url = substr($page_url, 0, 190);
			$page_url = $page_url . "...";
		}
		$inp_stats_page_url_mysql = quote_smart($link, $page_url);
		$inp_stats_page_title_mysql = quote_smart($link, $website_title);
		$query = "SELECT stats_pages_per_year_id, stats_pages_per_year_unique_bots FROM $t_stats_pages_visits_per_year WHERE stats_pages_per_year_year='$inp_year' AND stats_pages_per_year_url=$inp_stats_page_url_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_stats_pages_per_year_id, $get_stats_pages_per_year_unique_bots) = $row;
		if($get_stats_pages_per_year_id == ""){
			// This is a new page
			mysqli_query($link, "INSERT INTO $t_stats_pages_visits_per_year 
			(stats_pages_per_year_id, stats_pages_per_year_year, stats_pages_per_year_url, stats_pages_per_year_title, stats_pages_per_year_title_fetched, 
			stats_pages_per_year_human_unique,  stats_pages_per_year_unique_desktop, stats_pages_per_year_unique_mobile, stats_pages_per_year_unique_bots, stats_pages_per_year_updated_time) 
			VALUES
			(NULL, '$inp_year', $inp_stats_page_url_mysql, $inp_stats_page_title_mysql, 0, 
			0, 0, 0, 1, '$inp_unix_time')") or die(mysqli_error($link));

			// Get page ID
			$query = "SELECT stats_pages_per_year_id, stats_pages_per_year_human_unique, stats_pages_per_year_unique_desktop, stats_pages_per_year_unique_mobile FROM $t_stats_pages_visits_per_year WHERE stats_pages_per_year_year='$inp_year' AND stats_pages_per_year_url=$inp_stats_page_url_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_stats_pages_per_year_id, $get_stats_pages_per_year_human_unique, $get_stats_pages_per_year_unique_desktop, $get_stats_pages_per_year_unique_mobile) = $row;

			// IPBlock
			mysqli_query($link, "INSERT INTO $t_stats_pages_visits_per_year_ips 
			(stats_pages_per_year_ip_id, stats_pages_per_year_ip_year, stats_pages_per_year_ip_page_id, stats_pages_per_year_ip_ip) 
			VALUES
			(NULL, '$inp_year', $get_stats_pages_per_year_id, $my_ip_mysql)") or die(mysqli_error($link));
		}
		else{
			// We have record, if unique
			$query = "SELECT stats_pages_per_year_ip_id FROM $t_stats_pages_visits_per_year_ips WHERE stats_pages_per_year_ip_year='$inp_year' AND stats_pages_per_year_ip_page_id=$get_stats_pages_per_year_id AND stats_pages_per_year_ip_ip=$my_ip_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_stats_pages_per_year_ip_id) = $row;
			if($get_stats_pages_per_year_ip_id == ""){
				// New visitor for this page this year
				mysqli_query($link, "INSERT INTO $t_stats_pages_visits_per_year_ips 
				(stats_pages_per_year_ip_id, stats_pages_per_year_ip_year, stats_pages_per_year_ip_page_id, stats_pages_per_year_ip_ip) 
				VALUES
				(NULL, '$inp_year', $get_stats_pages_per_year_id, $my_ip_mysql)") or die(mysqli_error($link));
	
				// Unique
				$inp_count = $get_stats_pages_per_year_unique_bots+1;
				mysqli_query($link, "UPDATE $t_stats_pages_visits_per_year SET stats_pages_per_year_unique_bots=$inp_count, stats_pages_per_year_updated_time='$inp_unix_time' WHERE stats_pages_per_year_id=$get_stats_pages_per_year_id") or die(mysqli_error($link));
			}
		}
	}
} // End Bot
elseif($get_stats_user_agent_type == "desktop" OR $get_stats_user_agent_type == "mobile"){
	// Visists :: Year :: IPs
	$query = "SELECT stats_visit_per_year_ip_id, stats_visit_per_year_ip_year, stats_visit_per_year_type, stats_visit_per_year_ip FROM $t_stats_visists_per_year_ips WHERE stats_visit_per_year_ip_year='$inp_year' AND stats_visit_per_year_ip=$my_ip_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_stats_visit_per_year_ip_id, $get_stats_visit_per_year_ip_year, $get_stats_visit_per_year_type, $get_stats_visit_per_year_ip) = $row;
	if($get_stats_visit_per_year_ip_id == ""){
		// New visitor this year
		mysqli_query($link, "INSERT INTO $t_stats_visists_per_year_ips 
		(stats_visit_per_year_ip_id, stats_visit_per_year_ip_year, stats_visit_per_year_type, stats_visit_per_year_ip) 
		VALUES
		(NULL, '$inp_year', '$get_stats_user_agent_type', $my_ip_mysql)") or die(mysqli_error($link));
		
		// Update unique
		$inp_visit_per_year_human_unique = $get_stats_visit_per_year_human_unique+1;
		if($get_stats_user_agent_type == "desktop"){
			$inp_visit_per_year_unique_desktop = $get_stats_visit_per_year_unique_desktop+1;
			if($get_stats_visit_per_year_unique_mobile == ""){ $get_stats_visit_per_year_unique_mobile = "0"; }
			$inp_visit_per_year_unique_mobile = $get_stats_visit_per_year_unique_mobile;
		}
		else{
			$inp_visit_per_year_unique_desktop = $get_stats_visit_per_year_unique_desktop;
			$inp_visit_per_year_unique_mobile = $get_stats_visit_per_year_unique_mobile+1;
		}
		$inp_visit_per_year_hits_total = $get_stats_visit_per_year_hits_total+1;
		$inp_visit_per_year_hits_human = $get_stats_visit_per_year_hits_human+1;
		
		// Update new human visitor this year
		$result = mysqli_query($link, "UPDATE $t_stats_visists_per_year SET 
							stats_visit_per_year_human_unique=$inp_visit_per_year_human_unique,
							stats_visit_per_year_unique_desktop=$inp_visit_per_year_unique_desktop, 
							stats_visit_per_year_unique_mobile=$inp_visit_per_year_unique_mobile,
							stats_visit_per_year_hits_total=$inp_visit_per_year_hits_total,
							stats_visit_per_year_hits_human=$inp_visit_per_year_hits_human
							WHERE stats_visit_per_year_id=$get_stats_visit_per_year_id") or die(mysqli_error($link));

	}
	else{
		// Update hits
		$inp_visit_per_year_hits_total = $get_stats_visit_per_year_hits_total+1;
		$inp_visit_per_year_hits_human = $get_stats_visit_per_year_hits_human+1;
		$result = mysqli_query($link, "UPDATE $t_stats_visists_per_year SET 
							stats_visit_per_year_hits_total=$inp_visit_per_year_hits_total,
							stats_visit_per_year_hits_human=$inp_visit_per_year_hits_human
							WHERE stats_visit_per_year_id=$get_stats_visit_per_year_id") or die(mysqli_error($link));
			
	} // Visits :: Year

	// Visists :: Month :: IPs
	$query = "SELECT stats_visit_per_month_ip_id, stats_visit_per_month_ip_month, stats_visit_per_month_ip_year, stats_visit_per_month_type, stats_visit_per_month_ip FROM $t_stats_visists_per_month_ips WHERE stats_visit_per_month_ip_month='$inp_month' AND stats_visit_per_month_ip_year='$inp_year' AND stats_visit_per_month_ip=$my_ip_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_stats_visit_per_month_ip_id, $get_stats_visit_per_month_ip_month, $get_stats_visit_per_month_ip_year, $get_stats_visit_per_month_type, $get_stats_visit_per_month_ip) = $row;
	if($get_stats_visit_per_month_ip_id == ""){
		// New visitor this month
		mysqli_query($link, "INSERT INTO $t_stats_visists_per_month_ips 
		(stats_visit_per_month_ip_id, stats_visit_per_month_ip_month, stats_visit_per_month_ip_year, stats_visit_per_month_type, stats_visit_per_month_ip) 
		VALUES
		(NULL, '$inp_month', '$inp_year', '$get_stats_user_agent_type', $my_ip_mysql)") or die(mysqli_error($link));
			
		// Update unique
		$inp_visit_per_month_human_unique = $get_stats_visit_per_month_human_unique+1;
		if($get_stats_user_agent_type == "desktop"){
			$inp_visit_per_month_unique_desktop = $get_stats_visit_per_month_unique_desktop+1;
			$inp_visit_per_month_unique_mobile = $get_stats_visit_per_month_unique_mobile;
		}
		else{
			$inp_visit_per_month_unique_desktop = $get_stats_visit_per_month_unique_desktop;
			$inp_visit_per_month_unique_mobile = $get_stats_visit_per_month_unique_mobile+1;
		}
		$inp_visit_per_month_hits_total = $get_stats_visit_per_month_hits_total+1;
		$inp_visit_per_month_hits_human = $get_stats_visit_per_month_hits_human+1;
		
		// Update
		$result = mysqli_query($link, "UPDATE $t_stats_visists_per_month SET 
							stats_visit_per_month_human_unique=$inp_visit_per_month_human_unique,
							stats_visit_per_month_unique_desktop=$inp_visit_per_month_unique_desktop, 
							stats_visit_per_month_unique_mobile=$inp_visit_per_month_unique_mobile,
							stats_visit_per_month_hits_total=$inp_visit_per_month_hits_total,
							stats_visit_per_month_hits_human=$inp_visit_per_month_hits_human
							WHERE stats_visit_per_month_id=$get_stats_visit_per_month_id") or die(mysqli_error($link));

	}
	else{
		// Update hits
		$inp_visit_per_month_hits_total = $get_stats_visit_per_month_hits_total+1;
		$inp_visit_per_month_hits_human = $get_stats_visit_per_month_hits_human+1;
		$result = mysqli_query($link, "UPDATE $t_stats_visists_per_month SET 
							stats_visit_per_month_hits_total=$inp_visit_per_month_hits_total,
							stats_visit_per_month_hits_human=$inp_visit_per_month_hits_human
							WHERE stats_visit_per_month_id=$get_stats_visit_per_month_id") or die(mysqli_error($link));
			
	} // Visits :: Month

	// Visists :: Week :: IPs
	$query = "SELECT stats_visit_per_week_ip_id, stats_visit_per_week_ip_week, stats_visit_per_week_ip_month, stats_visit_per_week_ip_year, stats_visit_per_week_type, stats_visit_per_week_ip FROM $t_stats_visists_per_week_ips WHERE stats_visit_per_week_ip_week='$inp_week' AND stats_visit_per_week_ip_year='$inp_year' AND stats_visit_per_week_ip=$my_ip_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_stats_visit_per_week_ip_id, $get_stats_visit_per_week_ip_week, $get_stats_visit_per_week_ip_month, $get_stats_visit_per_week_ip_year, $get_stats_visit_per_week_type, $get_stats_visit_per_week_ip) = $row;
	if($get_stats_visit_per_week_ip_id == ""){
		// New visitor this day
		mysqli_query($link, "INSERT INTO $t_stats_visists_per_week_ips 
		(stats_visit_per_week_ip_id, stats_visit_per_week_ip_week, stats_visit_per_week_ip_month, stats_visit_per_week_ip_year, stats_visit_per_week_type, stats_visit_per_week_ip) 
		VALUES
		(NULL, '$inp_week', '$inp_month', '$inp_year', '$get_stats_user_agent_type', $my_ip_mysql)") or die(mysqli_error($link));
			
		// Update unique
		$inp_visit_per_week_human_unique = $get_stats_visit_per_week_human_unique+1;
		if($get_stats_user_agent_type == "desktop"){
			$inp_visit_per_week_unique_desktop = $get_stats_visit_per_week_unique_desktop+1;
			$inp_visit_per_week_unique_mobile  = $get_stats_visit_per_week_unique_mobile;
		}
		else{
			$inp_visit_per_week_unique_desktop = $get_stats_visit_per_week_unique_desktop;
			$inp_visit_per_week_unique_mobile  = $get_stats_visit_per_week_unique_mobile+1;
		}
		$inp_visit_per_week_hits_total = $get_stats_visit_per_week_hits_total+1;
		$inp_visit_per_week_hits_human = $get_stats_visit_per_week_hits_human+1;
		
		// Update
		$result = mysqli_query($link, "UPDATE $t_stats_visists_per_week SET 
							stats_visit_per_week_human_unique=$inp_visit_per_week_human_unique,
							stats_visit_per_week_unique_desktop=$inp_visit_per_week_unique_desktop, 
							stats_visit_per_week_unique_mobile=$inp_visit_per_week_unique_mobile,
							stats_visit_per_week_hits_total=$inp_visit_per_week_hits_total,
							stats_visit_per_week_hits_human=$inp_visit_per_week_hits_human
							WHERE stats_visit_per_week_id=$get_stats_visit_per_week_id") or die(mysqli_error($link));

	}
	else{
		// Update hits
		$inp_visit_per_week_hits_total = $get_stats_visit_per_week_hits_total+1;
		$inp_visit_per_week_hits_human = $get_stats_visit_per_week_hits_human+1;
		$result = mysqli_query($link, "UPDATE $t_stats_visists_per_week SET 
							stats_visit_per_week_hits_total=$inp_visit_per_week_hits_total,
							stats_visit_per_week_hits_human=$inp_visit_per_week_hits_human
							WHERE stats_visit_per_week_id=$get_stats_visit_per_week_id") or die(mysqli_error($link));
		
	} // Visits :: Day

	// Visists :: Day :: IPs
	$query = "SELECT stats_visit_per_day_ip_id, stats_visit_per_day_ip_day, stats_visit_per_day_ip_month, stats_visit_per_day_ip_year, stats_visit_per_day_type, stats_visit_per_day_ip FROM $t_stats_visists_per_day_ips WHERE stats_visit_per_day_ip_day='$inp_day' AND stats_visit_per_day_ip_month='$inp_month' AND stats_visit_per_day_ip_year='$inp_year' AND stats_visit_per_day_ip=$my_ip_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_stats_visit_per_day_ip_id, $get_stats_visit_per_day_ip_day, $get_stats_visit_per_day_ip_month, $get_stats_visit_per_day_ip_year, $get_stats_visit_per_day_type, $get_stats_visit_per_day_ip) = $row;
	if($get_stats_visit_per_day_ip_id == ""){
		// New visitor this day
		mysqli_query($link, "INSERT INTO $t_stats_visists_per_day_ips 
		(stats_visit_per_day_ip_id, stats_visit_per_day_ip_day, stats_visit_per_day_ip_month, stats_visit_per_day_ip_year, stats_visit_per_day_type, stats_visit_per_day_ip) 
		VALUES
		(NULL, '$inp_day', '$inp_month', '$inp_year', '$get_stats_user_agent_type', $my_ip_mysql)") or die(mysqli_error($link));
			
		// Update unique
		$inp_visit_per_day_human_unique = $get_stats_visit_per_day_human_unique+1;
		if($get_stats_user_agent_type == "desktop"){
			$inp_visit_per_day_unique_desktop = $get_stats_visit_per_day_unique_desktop+1;
			$inp_visit_per_day_unique_mobile = $get_stats_visit_per_day_unique_mobile;
		}
		else{
			$inp_visit_per_day_unique_desktop = $get_stats_visit_per_day_unique_desktop;
			$inp_visit_per_day_unique_mobile = $get_stats_visit_per_day_unique_mobile+1;
		}
		$inp_visit_per_day_hits_total = $get_stats_visit_per_day_hits_total+1;
		$inp_visit_per_day_hits_human = $get_stats_visit_per_day_hits_human+1;
		
		// Update
		$result = mysqli_query($link, "UPDATE $t_stats_visists_per_day SET 
							stats_visit_per_day_human_unique=$inp_visit_per_day_human_unique,
							stats_visit_per_day_unique_desktop=$inp_visit_per_day_unique_desktop, 
							stats_visit_per_day_unique_mobile=$inp_visit_per_day_unique_mobile,
							stats_visit_per_day_hits_total=$inp_visit_per_day_hits_total,
							stats_visit_per_day_hits_human=$inp_visit_per_day_hits_human
							WHERE stats_visit_per_day_id=$get_stats_visit_per_day_id") or die(mysqli_error($link));

	}
	else{
		// Update hits
		$inp_visit_per_day_hits_total = $get_stats_visit_per_day_hits_total+1;
		$inp_visit_per_day_hits_human = $get_stats_visit_per_day_hits_human+1;
		$result = mysqli_query($link, "UPDATE $t_stats_visists_per_day SET 
						stats_visit_per_day_hits_total=$inp_visit_per_day_hits_total,
						stats_visit_per_day_hits_human=$inp_visit_per_day_hits_human
						WHERE stats_visit_per_day_id=$get_stats_visit_per_day_id") or die(mysqli_error($link));
			
	} // Visits :: Day


	// Browsers :: Year
	$query = "SELECT stats_browser_id, stats_browser_year, stats_browser_name, stats_browser_unique, stats_browser_hits FROM $t_stats_browsers_per_year WHERE stats_browser_year='$inp_year' AND stats_browser_name=$inp_user_agent_browser_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_stats_browser_id, $get_stats_browser_year, $get_stats_browser_name, $get_stats_browser_unique, $get_stats_browser_hits) = $row;
	if($get_stats_browser_id == ""){
		mysqli_query($link, "INSERT INTO $t_stats_browsers_per_year
		(stats_browser_id, stats_browser_year, stats_browser_name, stats_browser_unique, stats_browser_hits) 
		VALUES
		(NULL, '$inp_year', $inp_user_agent_browser_mysql, '1', '1')") or die(mysqli_error($link));
	}
	else{
		// We have record, if unique
		if($get_stats_visit_per_year_ip_id == ""){
			// Unique + hits
			$inp_unique = $get_stats_browser_unique+1;
			$inp_hits   = $get_stats_browser_hits+1;
			mysqli_query($link, "UPDATE $t_stats_browsers_per_year SET stats_browser_unique=$inp_unique, stats_browser_hits=$inp_hits WHERE stats_browser_id=$get_stats_browser_id") or die(mysqli_error($link));
		}
		else{
			// Hits
			$inp_hits = $get_stats_browser_hits+1;
			mysqli_query($link, "UPDATE $t_stats_browsers_per_year SET stats_browser_hits=$inp_hits WHERE stats_browser_id=$get_stats_browser_id") or die(mysqli_error($link));
		}
	}


	// Browsers :: Month
	$query = "SELECT stats_browser_id, stats_browser_month, stats_browser_year, stats_browser_name, stats_browser_unique, stats_browser_hits FROM $t_stats_browsers_per_month WHERE stats_browser_month='$inp_month' AND stats_browser_year='$inp_year' AND stats_browser_name=$inp_user_agent_browser_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_stats_browser_id, $get_stats_browser_month, $get_stats_browser_year, $get_stats_browser_name, $get_stats_browser_unique, $get_stats_browser_hits) = $row;
	if($get_stats_browser_id == ""){
		mysqli_query($link, "INSERT INTO $t_stats_browsers_per_month
		(stats_browser_id, stats_browser_month, stats_browser_year, stats_browser_name, stats_browser_unique, stats_browser_hits) 
		VALUES
		(NULL, '$inp_month', '$inp_year', $inp_user_agent_browser_mysql, '1', '1')") or die(mysqli_error($link));
	}
	else{
		// We have record, if unique
		if($get_stats_visit_per_month_ip_id == ""){
			// Unique + hits
			$inp_unique = $get_stats_browser_unique+1;
			$inp_hits   = $get_stats_browser_hits+1;
			mysqli_query($link, "UPDATE $t_stats_browsers_per_month SET stats_browser_unique=$inp_unique, stats_browser_hits=$inp_hits WHERE stats_browser_id=$get_stats_browser_id") or die(mysqli_error($link));
		}
		else{
			// Hits
			$inp_hits = $get_stats_browser_hits+1;
			mysqli_query($link, "UPDATE $t_stats_browsers_per_month SET stats_browser_hits=$inp_hits WHERE stats_browser_id=$get_stats_browser_id") or die(mysqli_error($link));
		}
	}

	// OS :: Year
	$query = "SELECT stats_os_id, stats_os_year, stats_os_name, stats_os_type, stats_os_unique, stats_os_hits FROM $t_stats_os_per_year WHERE stats_os_year='$inp_year' AND stats_os_name=$inp_user_agent_os_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_stats_os_id, $get_stats_os_year, $get_stats_os_name, $get_stats_os_type, $get_stats_os_unique, $get_stats_os_hits) = $row;

	if($get_stats_os_id == ""){
		mysqli_query($link, "INSERT INTO $t_stats_os_per_year
		(stats_os_id, stats_os_year, stats_os_name, stats_os_type, stats_os_unique, stats_os_hits) 
		VALUES
		(NULL, '$inp_year', $inp_user_agent_os_mysql, $inp_stats_user_agent_type_mysql, '1', '1')") or die(mysqli_error($link));
	}
	else{
		// We have record, if unique
		if($get_stats_visit_per_year_ip_id == ""){
			// Unique + hits
			$inp_unique = $get_stats_os_unique+1;
			$inp_hits   = $get_stats_os_hits+1;
			mysqli_query($link, "UPDATE $t_stats_os_per_year SET stats_os_unique=$inp_unique, stats_os_hits=$inp_hits WHERE stats_os_id=$get_stats_os_id") or die(mysqli_error($link));
		}
		else{
			// Hits
			$inp_hits = $get_stats_os_unique+1;
			mysqli_query($link, "UPDATE $t_stats_os_per_year SET stats_os_hits=$inp_hits WHERE stats_os_id=$get_stats_os_id") or die(mysqli_error($link));
		}
	}


	// OS :: Month
	$query = "SELECT stats_os_id, stats_os_month, stats_os_year, stats_os_name, stats_os_type, stats_os_unique, stats_os_hits FROM $t_stats_os_per_month WHERE stats_os_month='$inp_month' AND stats_os_year='$inp_year' AND stats_os_name=$inp_user_agent_os_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_stats_os_id, $get_stats_os_month, $get_stats_os_year, $get_stats_os_name, $get_stats_os_type, $get_stats_os_unique, $get_stats_os_hits) = $row;

	if($get_stats_os_id == ""){
		mysqli_query($link, "INSERT INTO $t_stats_os_per_month 
		(stats_os_id, stats_os_month, stats_os_year, stats_os_name, stats_os_type, stats_os_unique, stats_os_hits) 
		VALUES
		(NULL, '$inp_month', '$inp_year', $inp_user_agent_os_mysql, $inp_stats_user_agent_type_mysql, '1', '1')") or die(mysqli_error($link));
	}
	else{
		// We have record, if unique
		if($get_stats_visit_per_month_ip_id == ""){
			// Unique + hits
			$inp_unique = $get_stats_os_unique+1;
			$inp_hits   = $get_stats_os_hits+1;
			mysqli_query($link, "UPDATE $t_stats_os_per_month SET stats_os_unique=$inp_unique, stats_os_hits=$inp_hits WHERE stats_os_id=$get_stats_os_id") or die(mysqli_error($link));
		}
		else{
			// Hits
			$inp_hits = $get_stats_os_unique+1;
			mysqli_query($link, "UPDATE $t_stats_os_per_month SET stats_os_hits=$inp_hits WHERE stats_os_id=$get_stats_os_id") or die(mysqli_error($link));
		}
	}


	// Accepted languages :: Year
	$query = "SELECT stats_accepted_language_id, stats_accepted_language_year, stats_accepted_language_name, stats_accepted_language_unique, stats_accepted_language_hits FROM $t_stats_accepted_languages_per_year WHERE stats_accepted_language_year='$inp_year' AND stats_accepted_language_name=$inp_accpeted_language_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_stats_accepted_language_id, $get_stats_accepted_language_year, $get_stats_accepted_language_name, $get_stats_accepted_language_unique, $get_stats_accepted_language_hits) = $row;
	if($get_stats_accepted_language_id == ""){
		mysqli_query($link, "INSERT INTO $t_stats_accepted_languages_per_year
		(stats_accepted_language_id, stats_accepted_language_year, stats_accepted_language_name, stats_accepted_language_unique, stats_accepted_language_hits) 
		VALUES
		(NULL, '$inp_year', $inp_accpeted_language_mysql, '1', '1')") or die(mysqli_error($link));
	}
	else{
		// We have record, if unique
		if($get_stats_visit_per_year_ip_id == ""){
			// Unique + hits
			$inp_unique = $get_stats_accepted_language_unique+1;
			$inp_hits   = $get_stats_accepted_language_hits+1;
			mysqli_query($link, "UPDATE $t_stats_accepted_languages_per_year SET stats_accepted_language_unique=$inp_unique, stats_accepted_language_hits=$inp_hits WHERE stats_accepted_language_id=$get_stats_accepted_language_id") or die(mysqli_error($link));
		}
		else{
			// Hits
			$inp_hits = $get_stats_accepted_language_unique+1;
			mysqli_query($link, "UPDATE $t_stats_accepted_languages_per_year SET stats_accepted_language_hits=$inp_hits WHERE stats_accepted_language_id=$get_stats_accepted_language_id") or die(mysqli_error($link));
		}
	}

	// Accepted languages :: Month
	$query = "SELECT stats_accepted_language_id, stats_accepted_language_month, stats_accepted_language_year, stats_accepted_language_name, stats_accepted_language_unique, stats_accepted_language_hits FROM $t_stats_accepted_languages_per_month WHERE stats_accepted_language_month='$inp_month' AND stats_accepted_language_year='$inp_year' AND stats_accepted_language_name=$inp_accpeted_language_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_stats_accepted_language_id, $get_stats_accepted_language_month, $get_stats_accepted_language_year, $get_stats_accepted_language_name, $get_stats_accepted_language_unique, $get_stats_accepted_language_hits) = $row;
	if($get_stats_accepted_language_id == ""){
		mysqli_query($link, "INSERT INTO $t_stats_accepted_languages_per_month
		(stats_accepted_language_id, stats_accepted_language_month, stats_accepted_language_year, stats_accepted_language_name, stats_accepted_language_unique, stats_accepted_language_hits) 
		VALUES
		(NULL, '$inp_month', '$inp_year', $inp_accpeted_language_mysql, '1', '1')") or die(mysqli_error($link));
	}
	else{
		// We have record, if unique
		if($get_stats_visit_per_month_ip_id == ""){
			// Unique + hits
			$inp_unique = $get_stats_accepted_language_unique+1;
			$inp_hits   = $get_stats_accepted_language_hits+1;
			mysqli_query($link, "UPDATE $t_stats_accepted_languages_per_month SET stats_accepted_language_unique=$inp_unique, stats_accepted_language_hits=$inp_hits WHERE stats_accepted_language_id=$get_stats_accepted_language_id") or die(mysqli_error($link));
		}
		else{
			// Hits
			$inp_hits = $get_stats_accepted_language_unique+1;
			mysqli_query($link, "UPDATE $t_stats_accepted_languages_per_month SET stats_accepted_language_hits=$inp_hits WHERE stats_accepted_language_id=$get_stats_accepted_language_id") or die(mysqli_error($link));
		}
	}

	// Referer
	if(isset($_SERVER['HTTP_REFERER']) ){
		$inp_stats_referer_from_url  = $_SERVER['HTTP_REFERER'];
		$inp_stats_referer_from_url  = output_html($inp_stats_referer_from_url);
		$inp_stats_referer_from_url_mysql = quote_smart($link, $inp_stats_referer_from_url);
		if($inp_stats_referer_from_url != "" && $configStatsURLSav != ""){
			if (strpos($inp_stats_referer_from_url, $configStatsURLSav) !== false) {
			
			}
			else{
				// Referer :: Year
				$query = "SELECT stats_referer_id, stats_referer_year, stats_referer_from_url, stats_referer_to_url, stats_referer_unique, stats_referer_hits FROM $t_stats_referers_per_year WHERE stats_referer_year='$inp_year' AND stats_referer_from_url=$inp_stats_referer_from_url_mysql AND stats_referer_to_url=$inp_page_mysql";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_stats_referer_id, $get_stats_referer_year, $get_stats_referer_from_url, $get_stats_referer_to_url, $get_stats_referer_unique, $get_stats_referer_hits) = $row;
				if($get_stats_referer_id == ""){
					mysqli_query($link, "INSERT INTO $t_stats_referers_per_year 
					(stats_referer_id, stats_referer_year, stats_referer_from_url, stats_referer_to_url, stats_referer_unique, stats_referer_hits) 
					VALUES
					(NULL,'$inp_year', $inp_stats_referer_from_url_mysql, $inp_page_mysql, '1', '1')") or die(mysqli_error($link));
				}
				else{
					// We have record, if unique
					if($get_stats_visit_per_year_ip_id == ""){
						// Unique + hits
						$inp_unique = $get_stats_referer_unique+1;
						$inp_hits   = $get_stats_referer_hits+1;
						mysqli_query($link, "UPDATE $t_stats_referers_per_year SET stats_referer_unique=$inp_unique, stats_referer_hits=$inp_hits WHERE stats_referer_id=$get_stats_referer_id") or die(mysqli_error($link));
					}
					else{
						// Hits
						$inp_hits = $get_stats_referer_unique+1;
						mysqli_query($link, "UPDATE $t_stats_referers_per_year SET stats_referer_hits=$inp_hits WHERE stats_referer_id=$get_stats_referer_id") or die(mysqli_error($link));
					}
				}

				// Referer :: Month
				$query = "SELECT stats_referer_id, stats_referer_month, stats_referer_year, stats_referer_from_url, stats_referer_to_url, stats_referer_unique, stats_referer_hits FROM $t_stats_referers_per_month WHERE stats_referer_month='$inp_month' AND stats_referer_year='$inp_year' AND stats_referer_from_url=$inp_stats_referer_from_url_mysql AND stats_referer_to_url=$inp_page_mysql";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_stats_referer_id, $get_stats_referer_month, $get_stats_referer_year, $get_stats_referer_from_url, $get_stats_referer_to_url, $get_stats_referer_unique, $get_stats_referer_hits) = $row;
				if($get_stats_referer_id == ""){
					mysqli_query($link, "INSERT INTO $t_stats_referers_per_month 
					(stats_referer_id, stats_referer_month, stats_referer_year, stats_referer_from_url, stats_referer_to_url, stats_referer_unique, stats_referer_hits) 
					VALUES
					(NULL, '$inp_month', '$inp_year', $inp_stats_referer_from_url_mysql, $inp_page_mysql, '1', '1')") or die(mysqli_error($link));
				}
				else{
					// We have record, if unique
					if($get_stats_visit_per_month_ip_id == ""){
						// Unique + hits
						$inp_unique = $get_stats_referer_unique+1;
						$inp_hits   = $get_stats_referer_hits+1;
						mysqli_query($link, "UPDATE $t_stats_referers_per_month SET stats_referer_unique=$inp_unique, stats_referer_hits=$inp_hits WHERE stats_referer_id=$get_stats_referer_id") or die(mysqli_error($link));
					}
					else{
						// Hits
						$inp_hits = $get_stats_referer_unique+1;
						mysqli_query($link, "UPDATE $t_stats_referers_per_year month SET stats_referer_hits=$inp_hits WHERE stats_referer_id=$get_stats_referer_id") or die(mysqli_error($link));
					}
				}
			}
		}
	}

	// Country :: Find my country based on IP
	// Country :: IP Type
	$ip_type = "";
	$get_ip_id = "";
	if (ip2long($my_ip) !== false) {
		$ip_type = "ipv4";
		$in_addr = inet_pton($my_ip);
		$in_addr_mysql = quote_smart($link, $in_addr);


		$query = "select * from $t_stats_ip_to_country_lookup_ipv4 where addr_type = '$ip_type' and ip_start <= $in_addr_mysql order by ip_start desc limit 1";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_ip_id, $get_ip_start, $get_ip_end, $get_country) = $row;
	} else if (preg_match('/^[0-9a-fA-F:]+$/', $my_ip) && @inet_pton($my_ip)) {
		$ip_type = "ipv6";
		$in_addr = inet_pton($my_ip);
		$in_addr_mysql = quote_smart($link, $in_addr);


		$query = "select * from $t_stats_ip_to_country_lookup_ipv6 where addr_type = '$ip_type' and ip_start <= $in_addr_mysql order by ip_start desc limit 1";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_ip_id, $get_ip_start, $get_ip_end, $get_country) = $row;
	}
	// echo"Type=$ip_type<br />";
	// echo"in_addr=$in_addr<br />";

		
	$get_my_country_name = "";
	$get_my_country_iso_two = "";
	if($get_ip_id != ""){
		$country_iso_two_mysql = quote_smart($link, $get_country);
		$query = "SELECT country_id, country_name, country_iso_two FROM $t_languages_countries WHERE country_iso_two=$country_iso_two_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_country_id, $get_my_country_name, $get_my_country_iso_two) = $row;
	}
	

	// Country :: Year
	$inp_geoname_country_iso_code_mysql = quote_smart($link, $get_my_country_iso_two);
	$inp_geoname_country_name_mysql = quote_smart($link, $get_my_country_name);
	$query = "SELECT stats_country_id, stats_country_unique, stats_country_hits FROM $t_stats_countries_per_year WHERE stats_country_year='$inp_year' AND stats_country_name=$inp_geoname_country_name_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_stats_country_id, $get_stats_country_unique, $get_stats_country_hits) = $row;
	if($get_stats_country_id == ""){
		mysqli_query($link, "INSERT INTO $t_stats_countries_per_year
		(stats_country_id, stats_country_year, stats_country_name, stats_country_alpha_2, stats_country_unique, stats_country_hits) 
		VALUES
		(NULL, '$inp_year', $inp_geoname_country_name_mysql, $inp_geoname_country_iso_code_mysql, 1, 1)") or die(mysqli_error($link));
	}
	else{
		// We have record, if unique
		if($get_stats_visit_per_year_ip_id == ""){
			// Unique + hits
			$inp_unique = $get_stats_country_unique+1;
			$inp_hits   = $get_stats_country_hits+1;
			mysqli_query($link, "UPDATE $t_stats_countries_per_year SET stats_country_unique=$inp_unique, stats_country_hits=$inp_hits WHERE stats_country_id=$get_stats_country_id") or die(mysqli_error($link));
		}
		else{
			// Hits
			$inp_hits = $get_stats_country_hits+1;
			mysqli_query($link, "UPDATE $t_stats_countries_per_year SET stats_country_hits=$inp_hits WHERE stats_country_id=$get_stats_country_id") or die(mysqli_error($link));
		}
	}

	// Country :: Month
	$query = "SELECT stats_country_id, stats_country_unique, stats_country_hits FROM $t_stats_countries_per_month WHERE stats_country_month='$inp_month' AND stats_country_year='$inp_year' AND stats_country_name=$inp_geoname_country_name_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_stats_country_id, $get_stats_country_unique, $get_stats_country_hits) = $row;
	if($get_stats_country_id == ""){
		mysqli_query($link, "INSERT INTO $t_stats_countries_per_month
		(stats_country_id, stats_country_month, stats_country_year, stats_country_name, stats_country_alpha_2, stats_country_unique, stats_country_hits) 
		VALUES
		(NULL, '$inp_month', '$inp_year', $inp_geoname_country_name_mysql, $inp_geoname_country_iso_code_mysql, 1, 1)") or die(mysqli_error($link));
	}
	else{
		// We have record, if unique
		if($get_stats_visit_per_year_ip_id == ""){
			// Unique + hits
			$inp_unique = $get_stats_country_unique+1;
			$inp_hits   = $get_stats_country_hits+1;
			mysqli_query($link, "UPDATE $t_stats_countries_per_month SET stats_country_unique=$inp_unique, stats_country_hits=$inp_hits WHERE stats_country_id=$get_stats_country_id") or die(mysqli_error($link));
		}
		else{
			// Hits
			$inp_hits = $get_stats_country_hits+1;
			mysqli_query($link, "UPDATE $t_stats_countries_per_month SET stats_country_hits=$inp_hits WHERE stats_country_id=$get_stats_country_id") or die(mysqli_error($link));
		}
	}

	// Pages :: Year (Humans)
	if($configStatsDaysToKeepPageVisitsSav != "0"){
		$page_url_len = strlen($page_url);
		if($page_url_len > 190){
			$page_url = substr($page_url, 0, 190);
			$page_url = $page_url . "...";
		}
		$inp_stats_page_url_mysql = quote_smart($link, $page_url);
		$inp_stats_page_title_mysql = quote_smart($link, ""); // We dont know website title
		$query = "SELECT stats_pages_per_year_id, stats_pages_per_year_human_unique, stats_pages_per_year_unique_desktop, stats_pages_per_year_unique_mobile FROM $t_stats_pages_visits_per_year WHERE stats_pages_per_year_year='$inp_year' AND stats_pages_per_year_url=$inp_stats_page_url_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_stats_pages_per_year_id, $get_stats_pages_per_year_human_unique, $get_stats_pages_per_year_unique_desktop, $get_stats_pages_per_year_unique_mobile) = $row;
		if($get_stats_pages_per_year_id == ""){
			// This is a new page
			$inp_unique_desktop = 0;
			$inp_unique_mobile = 0;
			if($get_stats_user_agent_type == "desktop"){
				$inp_unique_desktop = 1;
			}
			elseif($get_stats_user_agent_type == "mobile"){
				$inp_unique_mobile = 1;
			}
		
			mysqli_query($link, "INSERT INTO $t_stats_pages_visits_per_year 
			(stats_pages_per_year_id, stats_pages_per_year_year, stats_pages_per_year_url, stats_pages_per_year_title, stats_pages_per_year_title_fetched, 
			stats_pages_per_year_human_unique,  stats_pages_per_year_unique_desktop, stats_pages_per_year_unique_mobile, stats_pages_per_year_unique_bots, stats_pages_per_year_updated_time) 
			VALUES
			(NULL, '$inp_year', $inp_stats_page_url_mysql, $inp_stats_page_title_mysql, 0, 
			1, $inp_unique_desktop, $inp_unique_mobile, 0, '$inp_unix_time')") or die(mysqli_error($link));
			
			// Get page ID
			$query = "SELECT stats_pages_per_year_id, stats_pages_per_year_human_unique, stats_pages_per_year_unique_desktop, stats_pages_per_year_unique_mobile FROM $t_stats_pages_visits_per_year WHERE stats_pages_per_year_year='$inp_year' AND stats_pages_per_year_url=$inp_stats_page_url_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_stats_pages_per_year_id, $get_stats_pages_per_year_human_unique, $get_stats_pages_per_year_unique_desktop, $get_stats_pages_per_year_unique_mobile) = $row;
	
			// IPBlock
			mysqli_query($link, "INSERT INTO $t_stats_pages_visits_per_year_ips 
			(stats_pages_per_year_ip_id, stats_pages_per_year_ip_year, stats_pages_per_year_ip_page_id, stats_pages_per_year_ip_ip) 
			VALUES
			(NULL, '$inp_year', $get_stats_pages_per_year_id, $my_ip_mysql)") or die(mysqli_error($link));
		}
		else{
			// We have record, if unique
			$query = "SELECT stats_pages_per_year_ip_id FROM $t_stats_pages_visits_per_year_ips WHERE stats_pages_per_year_ip_year='$inp_year' AND stats_pages_per_year_ip_page_id=$get_stats_pages_per_year_id AND stats_pages_per_year_ip_ip=$my_ip_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_stats_pages_per_year_ip_id) = $row;
			if($get_stats_pages_per_year_ip_id == ""){
				// New visitor for this page this year
				// echo"We have record, if unique: New visitor for this page this year<br />";
				mysqli_query($link, "INSERT INTO $t_stats_pages_visits_per_year_ips 
				(stats_pages_per_year_ip_id, stats_pages_per_year_ip_year, stats_pages_per_year_ip_page_id, stats_pages_per_year_ip_ip) 
				VALUES
				(NULL, '$inp_year', $get_stats_pages_per_year_id, $my_ip_mysql)") or die(mysqli_error($link));
	
				// Unique
				$inp_unique_desktop = $get_stats_pages_per_year_unique_desktop;
				$inp_unique_mobile = $get_stats_pages_per_year_unique_mobile;
				if($get_stats_user_agent_type == "desktop"){
					$inp_unique_desktop = $inp_unique_desktop+1;
				}
				elseif($get_stats_user_agent_type == "mobile"){
					$inp_unique_mobile = $inp_unique_mobile+1;
				}
				$inp_human_unique = $inp_unique_desktop+$inp_unique_mobile;
				mysqli_query($link, "UPDATE $t_stats_pages_visits_per_year SET stats_pages_per_year_human_unique=$inp_human_unique, stats_pages_per_year_unique_desktop=$inp_unique_desktop, stats_pages_per_year_unique_mobile=$inp_unique_mobile, stats_pages_per_year_updated_time='$inp_unix_time' WHERE stats_pages_per_year_id=$get_stats_pages_per_year_id") or die(mysqli_error($link));
				// echo"UPDATE $t_stats_pages_visits_per_year SET stats_pages_per_year_unique_desktop=$inp_unique_desktop, stats_pages_per_year_unique_mobile=$inp_unique_mobile, stats_pages_per_year_updated_time='$inp_unix_time' WHERE stats_pages_per_year_id=$get_stats_pages_per_year_id<br />";
			}
			else{
				// Delete old entries
				// echo"We have record, if unique: Delete old entries, increase hits<br />";
				// $configSiteDaysToKeepPageVisitsSav
				mysqli_query($link, "DELETE FROM $t_stats_pages_visits_per_year WHERE stats_pages_per_year_updated_time < UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL $configStatsDaysToKeepPageVisitsSav DAY))") or die(mysqli_error($link));
			}
		}
	}

	// Language :: Year
	$query = "SELECT stats_language_id, stats_language_unique, stats_language_hits FROM $t_stats_languages_per_year WHERE stats_language_year='$inp_year' AND stats_language_iso_two='$get_current_language_active_iso_two'";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_stats_language_id, $get_stats_language_unique, $get_stats_language_hits) = $row;
	if($get_stats_language_id == ""){
		mysqli_query($link, "INSERT INTO $t_stats_languages_per_year 
		(stats_language_id, stats_language_year, stats_language_name, stats_language_iso_two, stats_language_flag_path_16x16, stats_language_flag_16x16, stats_language_unique, stats_language_hits) 
		VALUES
		(NULL, '$inp_year', '$get_current_language_active_name', '$get_current_language_active_iso_two', '$get_current_language_active_flag_path_16x16', '$get_current_language_active_flag_16x16', 1, 1)") or die(mysqli_error($link));
	}
	else{
		// We have record, if unique
		if($get_stats_visit_per_year_ip_id == ""){
			// Unique + hits
			$inp_unique = $get_stats_language_unique+1;
			$inp_hits   = $get_stats_language_hits+1;
			mysqli_query($link, "UPDATE $t_stats_languages_per_year SET stats_language_unique=$inp_unique, stats_language_hits=$inp_hits WHERE stats_language_id=$get_stats_language_id") or die(mysqli_error($link));
		}
		else{
			// Hits
			$inp_hits = $get_stats_language_hits+1;
			mysqli_query($link, "UPDATE $t_stats_languages_per_year SET stats_language_hits=$inp_hits WHERE stats_language_id=$get_stats_language_id") or die(mysqli_error($link));
		}
	}

	// Language :: Month
	$query = "SELECT stats_language_id, stats_language_unique, stats_language_hits FROM $t_stats_languages_per_month WHERE stats_language_month='$inp_month' AND stats_language_year='$inp_year' AND stats_language_year='$inp_year' AND stats_language_iso_two='$get_current_language_active_iso_two'";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_stats_language_id, $get_stats_language_unique, $get_stats_language_hits) = $row;
	if($get_stats_language_id == ""){
		mysqli_query($link, "INSERT INTO $t_stats_languages_per_month 
		(stats_language_id, stats_language_month, stats_language_year, stats_language_name, stats_language_iso_two, stats_language_flag_path_16x16, stats_language_flag_16x16, stats_language_unique, stats_language_hits) 
		VALUES
		(NULL, '$inp_month', '$inp_year', '$get_current_language_active_name', '$get_current_language_active_iso_two', '$get_current_language_active_flag_path_16x16', '$get_current_language_active_flag_16x16', 1, 1)") or die(mysqli_error($link));
	}
	else{
		// We have record, if unique
		if($get_stats_visit_per_month_ip_id == ""){
			// Unique + hits
			$inp_unique = $get_stats_language_unique+1;
			$inp_hits   = $get_stats_language_hits+1;
			mysqli_query($link, "UPDATE $t_stats_languages_per_month SET stats_language_unique=$inp_unique, stats_language_hits=$inp_hits WHERE stats_language_id=$get_stats_language_id") or die(mysqli_error($link));
		}
		else{
			// Hits
			$inp_hits = $get_stats_language_hits+1;
			mysqli_query($link, "UPDATE $t_stats_languages_per_month SET stats_language_hits=$inp_hits WHERE stats_language_id=$get_stats_language_id") or die(mysqli_error($link));
		}
	}
} // End Human



// Tracker :: Index
$inp_url_mysql = quote_smart($link, $page_url);
$inp_title_mysql = quote_smart($link, "");
$query = "SELECT tracker_id, tracker_time_start, tracker_hits FROM $t_stats_tracker_index WHERE tracker_ip=$my_ip_mysql AND tracker_month='$inp_month' AND tracker_year='$inp_year' AND tracker_os=$inp_user_agent_os_mysql AND tracker_browser=$inp_user_agent_browser_mysql AND tracker_language='$get_current_language_active_iso_two'";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_tracker_id, $get_tracker_time_start, $get_tracker_hits) = $row;
if($get_tracker_id == ""){
	$inp_tracker_ip_masked = substr($my_ip, -12);
	$inp_tracker_ip_masked = "..." . $inp_tracker_ip_masked;
	$inp_tracker_ip_masked_mysql = quote_smart($link, $inp_tracker_ip_masked);
	mysqli_query($link, "INSERT INTO $t_stats_tracker_index 
	(tracker_id, tracker_ip, tracker_ip_masked, tracker_hostname, tracker_month, 
	tracker_month_short, tracker_year, tracker_time_start, tracker_hour_minute_start, tracker_time_end, 
	tracker_hour_minute_end, tracker_seconds_spent, tracker_time_spent, tracker_user_agent, tracker_os, 
	tracker_browser, tracker_type, tracker_accept_language, tracker_language, tracker_country_name, 
	tracker_hits, tracker_last_url_value, tracker_last_url_title, tracker_last_url_title_fetched) 
	VALUES
	(NULL, $my_ip_mysql, $inp_tracker_ip_masked_mysql, $my_hostname_mysql, '$inp_month', '$inp_month_short', 
	'$inp_year', '$inp_unix_time', '$inp_hour_minute', '$inp_unix_time', '$inp_hour_minute',
	 0, 0, $my_user_agent_mysql, $inp_user_agent_os_mysql, $inp_user_agent_browser_mysql, '$get_stats_user_agent_type', 
	$inp_accpeted_language_mysql, '$get_current_language_active_iso_two', $inp_geoname_country_name_mysql, 1, $inp_url_mysql, 
	$inp_title_mysql, 0)") or die(mysqli_error($link));

	$query = "SELECT tracker_id, tracker_hits FROM $t_stats_tracker_index WHERE tracker_ip=$my_ip_mysql AND tracker_month='$inp_month' AND tracker_year='$inp_year'";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_tracker_id, $get_tracker_hits) = $row;

}
else{
	// Hits, dates
	$inp_hits = $get_tracker_hits+1;
	$inp_seconds_spent = $inp_unix_time-$get_tracker_time_start;
	$inp_tracker_time_spent = "";
	if($inp_seconds_spent > 60){
		$hours = floor($inp_seconds_spent / 3600);

		$minutes = floor(($inp_seconds_spent / 60) % 60);
		$minutes_len = strlen($minutes);
		if($minutes_len == "1"){
			$minutes = "0" . $minutes;
		}

		$seconds = $inp_seconds_spent % 60;
		$seconds_len = strlen($seconds);
		if($seconds_len == "1"){
			$seconds = "0" . $seconds;
		}
		if($hours == "0"){
			$inp_tracker_time_spent= "$minutes:$seconds";
		}
		else{
			$inp_tracker_time_spent= "$hours:$minutes:$seconds";
		}
	}
	else{
		$inp_tracker_time_spent = "$inp_seconds_spent s";
	}
	$inp_tracker_time_spent_mysql = quote_smart($link, $inp_tracker_time_spent);

	mysqli_query($link, "UPDATE $t_stats_tracker_index SET 
						tracker_time_end='$inp_unix_time', 
						tracker_hour_minute_end='$inp_hour_minute', 
						tracker_seconds_spent='$inp_seconds_spent',
						tracker_time_spent=$inp_tracker_time_spent_mysql,
						tracker_hits=$inp_hits, 
						tracker_last_url_value=$inp_url_mysql,
						tracker_last_url_title=$inp_title_mysql, 
						tracker_last_url_title_fetched=0
						WHERE tracker_id=$get_tracker_id") or die(mysqli_error($link));
}

// Tracker :: URL
mysqli_query($link, "INSERT INTO $t_stats_tracker_urls
			(url_id, url_tracker_id, url_value, url_title, url_title_fetched, url_year, 
			url_month, url_month_short, url_day, url_time_start, url_hour_minute_start, url_time_end, 
			url_hour_minute_end, url_seconds_spent, url_time_spent) 
			VALUES
			(NULL, $get_tracker_id, $inp_url_mysql, $inp_title_mysql, 0, '$inp_year', 
			'$inp_month', '$inp_month_short', '$inp_day',  '$inp_unix_time', '$inp_hour_minute', '$inp_unix_time', 
			'$inp_hour_minute', 0, 0)") or die(mysqli_error($link));
?>