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

// Month saying
$month_saying = "?";
if($month == "1" OR $month == "1"){
	$month_saying = "January";
}
elseif($month == "2" OR $month == "02"){
	$month_saying = "February";
}
elseif($month == "3" OR $month == "03"){
	$month_saying = "March";
}
elseif($month == "4" OR $month == "04"){
	$month_saying = "April";
}
elseif($month == "5" OR $month == "05"){
	$month_saying = "May";
}
elseif($month == "6" OR $month == "06"){
	$month_saying = "Jane";
}
elseif($month == "7" OR $month == "07"){
	$month_saying = "July";
}
elseif($month == "8" OR $month == "08"){
	$month_saying = "August";
}
elseif($month == "9" OR $month == "09"){
	$month_saying = "September";
}
elseif($month == "10"){
	$month_saying = "October";
}
elseif($month == "11"){
	$month_saying = "November";
}
elseif($month == "12"){
	$month_saying = "January";
}

echo"


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


<h1>Statistics</h1>


<!-- Javascripts -->
	<script src=\"_libraries/amcharts/index.js\"></script>
	<script src=\"_libraries/amcharts/xy.js\"></script>
	<script src=\"_libraries/amcharts/themes/Animated.js\"></script>
<!-- //Javascripts -->

<!-- Visitors per year and per month -->
	<div class=\"flex_row\">
		<!-- Visitors pr year -->
			<div class=\"flex_col_50_white_bg\">
				<div class=\"flex_col_inner\">
					<h2>$year visitors</h2>

					<!-- Javascript years visitor -->
						<div id=\"chartdiv_visits_per_month\" style=\"width: 100%;height: 270px;\"></div>";

						include("_pages/stats/default_generate_visits_per_month_last_2_years.php");
						echo"
						<script src=\"_cache/default_generate_visits_per_month_last_2_years_$configSecurityCodeSav.js?rand=$rand\"></script>
					<!-- //Javascript years visitor -->
				</div>
			</div>
		<!-- //Visitors pr year -->
		<!-- Visitors pr month -->
			<div class=\"flex_col_50_white_bg\">
				<div class=\"flex_col_inner\">
					<h1>$month_saying visitors</h1>

					<!-- Javascript month visitor -->
						<div id=\"chartdiv_visits_per_day\" style=\"width: 100%;height: 270px;\"></div>";

						include("_pages/stats/default_generate_visits_per_day_last_2_months.php");
						echo"
						<script src=\"_cache/default_generate_visits_per_day_last_2_months_$configSecurityCodeSav.js?rand=$rand\"></script>
					<!-- //Javascript month visitor -->
				</div>
			</div>
		<!-- //Visitors pr month -->
	</div>

<!-- //Visitors per year and per month -->


Every month overview click

";


?>