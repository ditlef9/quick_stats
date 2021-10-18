<?php
/**
*
* File: _stats/_pages/stats/default.php
* Version 1
* Date 12:04 18.10.2021
* Copyright (c) 2021 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Access check ----------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}

/*- Functions ----------------------------------------------------------------------- */
include("_functions/decode_national_letters.php");

/*- Tables ---------------------------------------------------------------------------- */

$t_stats_visists_per_year 	   	= $dbPrefixSav . "stats_visists_per_year";
$t_stats_visists_per_month 	   	= $dbPrefixSav . "stats_visists_per_month";
$t_stats_visists_per_week 	   	= $dbPrefixSav . "stats_visists_per_week";
$t_stats_visists_per_day 	   	= $dbPrefixSav . "stats_visists_per_day";
$t_stats_users_registered_per_year 	= $dbPrefixSav . "stats_users_registered_per_year";
$t_stats_users_registered_per_week 	= $dbPrefixSav . "stats_users_registered_per_week";
$t_stats_comments_per_year 		= $dbPrefixSav . "stats_comments_per_year";
$t_stats_comments_per_week		= $dbPrefixSav . "stats_comments_per_week";


/*- Variables -------------------------------------------------------------------------- */
if(isset($_GET['week'])) {
	$week = $_GET['week'];
	$week = strip_tags(stripslashes($week));
}
else{
	$week = date("W");
}
$week_mysql = quote_smart($link, $week);

if(isset($_GET['month'])) {
	$month = $_GET['month'];
	$month = strip_tags(stripslashes($month));
}
else{
	$month = date("m");
}
$month_mysql = quote_smart($link, $month);

if(isset($_GET['year'])) {
	$year = $_GET['year'];
	$year = strip_tags(stripslashes($year));
}
else{
	$year = date("Y");
}
$year_mysql = quote_smart($link, $year);

echo"
<!-- Charts javascript -->
	<script src=\"_libraries/amcharts/xy.js\"></script>
<!-- //Charts javascript -->


<!-- Feedback -->
	";
	if($ft != ""){
		if($fm == "changes_saved"){
			$fm = "$l_changes_saved";
		}
		else{
			$fm = ucfirst($fm);
			$fm = str_replace("_", " ", $fm);
		}
		echo"
		<div class=\"$ft\" style=\"margin: 0px 20px 20px 20px;\"><span>$fm</span></div>";
	}
	echo"	
<!-- //Feedback -->

<!-- Check if setup folder exists -->
	";
	if(file_exists("setup/index.php")){
		echo"
		<div class=\"white_bg_box\"><span><b>Security issue:</b> The setup folder exists. Do you want to <a href=\"index.php?open=dashboard&amp;page=delete_setup_folder\">delete the setup folder</a>?</span></div> 
		";
	}
	echo"
<!-- //Check if setup folder exists -->
";


?>