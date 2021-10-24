<?php
/**
*
* File: _admin/_inc/media/statistics.php
* Version 2.0.0
* Date 18:16 28.04.2019
* Copyright (c) 2008-2019 Sindre Andre Ditlefsen
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

$t_stats_countries_per_year  = $dbPrefixSav . "stats_visits_per_year";
$t_stats_countries_per_month = $dbPrefixSav . "stats_visits_per_month";

$t_stats_ip_to_country_lookup = $dbPrefixSav . "stats_ip_to_country_lookup";
$t_languages_countries	      = $dbPrefixSav . "languages_countries";

$t_stats_os_per_month = $dbPrefixSav . "stats_os_per_month";
$t_stats_os_per_year = $dbPrefixSav . "stats_os_per_year";

$t_stats_referers_per_year  = $dbPrefixSav . "stats_referers_per_year";
$t_stats_referers_per_month = $dbPrefixSav . "stats_referers_per_month";

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

if($action == ""){
	echo"
	<h1>Statistics</h1>



	<!-- Unknown agents -->
		";
		// Unknown type
		$unknown_type = 0;
		$query = "SELECT * FROM $t_stats_user_agents_index WHERE stats_user_agent_type=''";
		if ($result = mysqli_query($link, "$query")) {
			$unknown_type = mysqli_num_rows($result);
			mysqli_free_result($result);
		}

		// Unknown browsers
		$unknown_browser = 0;
		$query = "SELECT * FROM $t_stats_user_agents_index WHERE stats_user_agent_browser='' AND stats_user_agent_bot=''";
		if ($result = mysqli_query($link, "$query")) {
			$unknown_browser = mysqli_num_rows($result);
			mysqli_free_result($result);
		}

		// Unknown os
		$unknown_os = 0;
		$query = "SELECT * FROM $t_stats_user_agents_index WHERE stats_user_agent_os='' AND stats_user_agent_bot=''";
		if ($result = mysqli_query($link, "$query")) {
			$unknown_os = mysqli_num_rows($result);
			mysqli_free_result($result);
		}

		// Unknown flag
		$unknown_flag = 0;
		$query = "SELECT * FROM $t_stats_user_agents_index WHERE stats_user_agent_type='unknown'";
		if ($result = mysqli_query($link, "$query")) {
			$unknown_flag = mysqli_num_rows($result);
			mysqli_free_result($result);
		}



		$unknown_total = $unknown_type+$unknown_browser+$unknown_os+$unknown_flag;
		if($unknown_total != 0){
			echo"
			<div class=\"warning\"><p>$l_unknown_agents_has $unknown_total $l_new_unknown_user_agents:
			$unknown_type $l_unknown_types,
			$unknown_browser $l_unknown_browsers,
			$unknown_os $l_unknown_os,
			$l_and $unknown_flag $l_marked_with_unknown_flag.
			
			</p><p><a href=\"index.php?open=$open&amp;page=unknown_agents&amp;action=fix_agents&amp;editor_language=$editor_language\" class=\"btn\">$l_fix_problems</a></p></div>
			";
		}


		echo"
	<!-- //Unknown agents -->


	<!-- Periode selection -->
		<table class=\"hor-zebra\">
		 <thead>
		  <tr>
		   <th scope=\"col\">
			<span><b>Year</b></span>
		   </td>
		   <th scope=\"col\">
			<span><b>Unique</b></span>
		   </td>
		   <th scope=\"col\">
			<span><b>Unique desktop</b></span>
		   </td>
		   <th scope=\"col\">
			<span><b>Unique mobile</b></span>
		   </td>
		   <th scope=\"col\">
			<span><b>Unique bots</b></span>
		   </td>
		  </tr>
		 </thead>";

		$query = "SELECT stats_visit_per_year_id, stats_visit_per_year_year, stats_visit_per_year_human_unique, stats_visit_per_year_human_unique_diff_from_last_year, stats_visit_per_year_human_average_duration, stats_visit_per_year_human_new_visitor_unique, stats_visit_per_year_human_returning_visitor_unique, stats_visit_per_year_unique_desktop, stats_visit_per_year_unique_mobile, stats_visit_per_year_unique_bots, stats_visit_per_year_hits_total, stats_visit_per_year_hits_human, stats_visit_per_year_hits_desktop, stats_visit_per_year_hits_mobile, stats_visit_per_year_hits_bots FROM $t_stats_visists_per_year ORDER BY stats_visit_per_year_id DESC";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_stats_visit_per_year_id, $get_stats_visit_per_year_year, $get_stats_visit_per_year_human_unique, $get_stats_visit_per_year_human_unique_diff_from_last_year, $get_stats_visit_per_year_human_average_duration, $get_stats_visit_per_year_human_new_visitor_unique, $get_stats_visit_per_year_human_returning_visitor_unique, $get_stats_visit_per_year_unique_desktop, $get_stats_visit_per_year_unique_mobile, $get_stats_visit_per_year_unique_bots, $get_stats_visit_per_year_hits_total, $get_stats_visit_per_year_hits_human, $get_stats_visit_per_year_hits_desktop, $get_stats_visit_per_year_hits_mobile, $get_stats_visit_per_year_hits_bots) = $row;
			
			echo"
			 <tr>
			  <td>
				<a id=\"#year$get_stats_visit_per_year_year\"></a>
				<span>
				<a href=\"index.php?open=$open&amp;page=statistics_year&amp;stats_year=$get_stats_visit_per_year_year&amp;&amp;editor_language=$editor_language\">$get_stats_visit_per_year_year</a>
				</span>
			  </td>
			  <td>
				<span>
				$get_stats_visit_per_year_human_unique
				</span>
			  </td>
			  <td>
				<span>
				$get_stats_visit_per_year_unique_desktop
				</span>
			  </td>
			  <td>
				<span>
				$get_stats_visit_per_year_unique_mobile
				</span>
			  </td>
			  <td>
				<span>
				$get_stats_visit_per_year_unique_bots
				</span>
			  </td>
			 </tr>";

			// Months
			$query_m = "SELECT stats_visit_per_month_id, stats_visit_per_month_month, stats_visit_per_month_month_full, stats_visit_per_month_month_short, stats_visit_per_month_year, stats_visit_per_month_human_unique, stats_visit_per_month_human_unique_diff_from_last_month, stats_visit_per_month_human_average_duration, stats_visit_per_month_human_new_visitor_unique, stats_visit_per_month_human_returning_visitor_unique, stats_visit_per_month_unique_desktop, stats_visit_per_month_unique_mobile, stats_visit_per_month_unique_bots, stats_visit_per_month_hits_total, stats_visit_per_month_hits_human, stats_visit_per_month_hits_desktop, stats_visit_per_month_hits_mobile, stats_visit_per_month_hits_bots FROM $t_stats_visists_per_month WHERE stats_visit_per_month_year=$get_stats_visit_per_year_year";
			$result_m = mysqli_query($link, $query_m);
			while($row_m = mysqli_fetch_row($result_m)) {
				list($get_stats_visit_per_month_id, $get_stats_visit_per_month_month, $get_stats_visit_per_month_month_full, $get_stats_visit_per_month_month_short, $get_stats_visit_per_month_year, $get_stats_visit_per_month_human_unique, $get_stats_visit_per_month_human_unique_diff_from_last_month, $get_stats_visit_per_month_human_average_duration, $get_stats_visit_per_month_human_new_visitor_unique, $get_stats_visit_per_month_human_returning_visitor_unique, $get_stats_visit_per_month_unique_desktop, $get_stats_visit_per_month_unique_mobile, $get_stats_visit_per_month_unique_bots, $get_stats_visit_per_month_hits_total, $get_stats_visit_per_month_hits_human, $get_stats_visit_per_month_hits_desktop, $get_stats_visit_per_month_hits_mobile, $get_stats_visit_per_month_hits_bots) = $row_m;
			
				echo"
				 <tr>
				  <td style=\"padding-left: 10px;\">
					<a id=\"#month$get_stats_visit_per_year_year$get_stats_visit_per_month_month\"></a>
					<span>
					<a href=\"index.php?open=$open&amp;page=statistics_month&amp;stats_year=$get_stats_visit_per_year_year&amp;stats_month=$get_stats_visit_per_month_month&amp;editor_language=$editor_language\">$get_stats_visit_per_month_month_full $get_stats_visit_per_year_year</a>
					</span>
				  </td>
				  <td>
					<span>
					$get_stats_visit_per_month_human_unique
					</span>
				  </td>
				  <td>
					<span>
					$get_stats_visit_per_month_unique_desktop
					</span>
				  </td>
				  <td>
					<span>
					$get_stats_visit_per_month_unique_mobile
					</span>
				  </td>
				  <td>
					<span>
					$get_stats_visit_per_month_unique_bots
					</span>
				  </td>
				 </tr>";
			} // while months
		} // while years
		echo"
			</table>
		  </td>
		 </tr>
		</table>
	<!-- //Periode selection -->

	";
}
?>