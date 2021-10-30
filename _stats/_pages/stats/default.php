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
		<div class=\"white_bg_box\"><span><b>Security issue:</b> The setup folder exists. Do you want to <a href=\"index.php?open=$open&amp;page=delete_setup_folder\">delete the setup folder</a>?</span></div> 
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

					
					<div class=\"left\">
						<h2>$year visitors</h2>
					</div>
					<div class=\"right\">
						<p><a href=\"index.php?open=stats&amp;page=statistics_year&amp;stats_year=$year&amp;editor_language=$editor_language\">View report</a></p>
					</div>
					<div class=\"clear\"></div>


					<!-- Visititors last 12 months -->";

						$query = "SELECT SUM(stats_visit_per_month_human_unique) FROM $t_stats_visists_per_month ORDER BY stats_visit_per_month_id LIMIT 0,12";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_this_year_human_unique) = $row;

						$get_last_year_human_unique = 0;
						$query = "SELECT stats_visit_per_month_human_unique FROM $t_stats_visists_per_month ORDER BY stats_visit_per_month_id LIMIT 12,12";
						$result = mysqli_query($link, $query);
						while($row = mysqli_fetch_row($result)) {
							list($get_stats_visit_per_month_human_unique) = $row;
			

							$get_last_year_human_unique = $get_last_year_human_unique + $get_stats_visit_per_month_human_unique;
						}

						$diff_human_unique = $get_this_year_human_unique-$get_last_year_human_unique;
						$diff_human_unique_nf = number_format($diff_human_unique);

						// Percentage = ((y2 - y1) / y1)*100 = your percent change. y1 is the original value, and y2 is the value it changed to.
						$percentage_human_unique = "100";
						if($get_last_year_human_unique != "0"){
							$percentage_human_unique = (($get_this_year_human_unique-$get_last_year_human_unique)/$get_last_year_human_unique);
							$percentage_human_unique = $percentage_human_unique * 100;
							$percentage_human_unique = round($percentage_human_unique, 1);
						}


						echo"

						<div class=\"left\">
							<h3 style=\"padding-bottom:0;margin-bottom:0;\">"; echo number_format($get_this_year_human_unique); echo"</h3>

							<p>
							Unique humans last 12 months
							</p>
						</div>
						<div class=\"right\">";
							if($percentage_human_unique > 0){
								echo"
								<p style=\"padding-bottom:0;margin-bottom:0;color:green;text-align:right;\" title=\"$diff_human_unique_nf increase in new visitors\"><img src=\"_layout/gfx/arrow_green_up.png\" alt=\"arrow_green_up.png\" style=\"vertical-align:middle;\" /> $percentage_human_unique %</p>
								";
							}
							elseif($percentage_human_unique < 0){
								echo"
								<p style=\"padding-bottom:0;margin-bottom:0;color:red;text-align:right;\" title=\"$diff_human_unique_nf decrease in new visitors\"><img src=\"_layout/gfx/arrow_red_down.png\" alt=\"arrow_red_down.png\" style=\"vertical-align:middle;\" /> $percentage_human_unique %</p>
								";
							}
							else{
								echo"
								<p style=\"padding-bottom:0;margin-bottom:0;color:orange;text-align:right;\" title=\"$diff_human_unique_nf (same this year and last year)\"><img src=\"_layout/gfx/arrow_yellow_straight.png\" alt=\"arrow_yellow_straight.png\" style=\"vertical-align:middle;\" /> $percentage_human_unique %</p>
								";
							}
							echo"
							<p>
							Since last year
							</p>
						</div>
						<div class=\"clear\"></div>

					<!-- //Visititors this year + Visitor changes this year vs last year -->

					<!-- Javascript years visitor -->
						<div id=\"chartdiv_visits_per_month\" style=\"width: 100%;height: 300px;\"></div>";

						include("_pages/stats/statistics_default_generate/visits_per_month_last_2_years.php");
						echo"
						<script src=\"_cache/visits_per_month_last_2_years_$configSecurityCodeSav.js?rand=$rand\"></script>
					<!-- //Javascript years visitor -->
				</div>
			</div>
		<!-- //Visitors pr year -->
		<!-- Visitors pr month -->
			<div class=\"flex_col_50_white_bg\">
				<div class=\"flex_col_inner\">
					<div class=\"left\">
						<h2>$month_saying visitors</h2>
					</div>
					<div class=\"right\">
						<p><a href=\"index.php?open=stats&amp;page=statistics_month&amp;stats_year=$year&amp;stats_month=$month&amp;editor_language=$editor_language\">View report</a></p>
					</div>
					<div class=\"clear\"></div>

					<!-- Visititors this month + Visitor changes this month vs last month  -->";

						$query = "SELECT SUM(stats_visit_per_day_human_unique) FROM $t_stats_visists_per_day ORDER BY stats_visit_per_day_id LIMIT 0,31";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_this_month_human_unique) = $row;

						$get_last_month_human_unique = 0;
						$query = "SELECT stats_visit_per_day_human_unique FROM $t_stats_visists_per_day ORDER BY stats_visit_per_day_id LIMIT 31,31";
						$result = mysqli_query($link, $query);
						while($row = mysqli_fetch_row($result)) {
							list($get_stats_visit_per_day_human_unique) = $row;
			

							$get_last_month_human_unique = $get_last_month_human_unique + $get_stats_visit_per_day_human_unique;
						}

						$diff_human_unique = $get_this_month_human_unique-$get_last_month_human_unique;
						$diff_human_unique_nf = number_format($diff_human_unique);

						// Percentage = ((y2 - y1) / y1)*100 = your percent change. y1 is the original value, and y2 is the value it changed to.
						$percentage_human_unique = "100";
						if($get_last_month_human_unique != "0"){
							$percentage_human_unique = (($get_this_month_human_unique-$get_last_month_human_unique)/$get_last_month_human_unique);
							$percentage_human_unique = $percentage_human_unique * 100;
							$percentage_human_unique = round($percentage_human_unique, 1);
						}

						echo"

						<div class=\"left\">
							<h3 style=\"padding-bottom:0;margin-bottom:0;\">"; echo number_format($get_this_month_human_unique); echo"</h3>

							<p>
							Unique humans last 31 days
							</p>
						</div>
						<div class=\"right\">";
							if($percentage_human_unique > 0){
								echo"
								<p style=\"padding-bottom:0;margin-bottom:0;color:green;text-align:right;\" title=\"$diff_human_unique_nf increase in new visitors\"><img src=\"_layout/gfx/arrow_green_up.png\" alt=\"arrow_green_up.png\" style=\"vertical-align:middle;\" /> $percentage_human_unique %</p>
								";
							}
							elseif($percentage_human_unique < 0){
								echo"
								<p style=\"padding-bottom:0;margin-bottom:0;color:red;text-align:right;\" title=\"$diff_human_unique_nf decrease in new visitors\"><img src=\"_layout/gfx/arrow_red_down.png\" alt=\"arrow_red_down.png\" style=\"vertical-align:middle;\" /> $percentage_human_unique %</p>
								";
							}
							else{
								echo"
								<p style=\"padding-bottom:0;margin-bottom:0;color:orange;text-align:right;\" title=\"$diff_human_unique_nf (same this month and last month)\"><img src=\"_layout/gfx/arrow_yellow_straight.png\" alt=\"arrow_yellow_straight.png\" style=\"vertical-align:middle;\" /> $percentage_human_unique %</p>
								";
							}
							echo"
							<p>
							Since last month
							</p>
						</div>
						<div class=\"clear\"></div>

					<!-- //Visititors this month + Visitor changes this month vs last month -->

					<!-- Javascript month visitor -->
						<div id=\"chartdiv_visits_per_day\" style=\"width: 100%;height: 300px;\"></div>";

						include("_pages/stats/statistics_default_generate/visits_per_day_last_2_months.php");
						echo"
						<script src=\"_cache/visits_per_day_last_2_months_$configSecurityCodeSav.js?rand=$rand\"></script>
					<!-- //Javascript month visitor -->
				</div>
			</div>
		<!-- //Visitors pr month -->
	</div>

<!-- //Visitors per year and per month -->



<!-- Periode selection -->
	<div class=\"white_bg\">

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
				<a href=\"index.php?open=$open&amp;page=statistics_year&amp;stats_year=$get_stats_visit_per_year_year\">$get_stats_visit_per_year_year</a>
				</span>
			  </td>
			  <td>
				<span>
				";
				echo number_format($get_stats_visit_per_year_human_unique);
				echo"
				</span>
			  </td>
			  <td>
				<span>
				";
				echo number_format($get_stats_visit_per_year_unique_desktop);
				echo"
				</span>
			  </td>
			  <td>
				<span>
				";
				echo number_format($get_stats_visit_per_year_unique_mobile);
				echo"
				</span>
			  </td>
			  <td>
				<span>
				";
				echo number_format($get_stats_visit_per_year_unique_bots);
				echo"
				</span>
			  </td>
			 </tr>";

			// Months
			$stats_visit_per_month_human_unique_total = 0;
			$stats_visit_per_month_unique_desktop     = 0;
			$stats_visit_per_month_unique_mobile      = 0;	
			$stats_visit_per_month_unique_bots        = 0;
			$query_m = "SELECT stats_visit_per_month_id, stats_visit_per_month_month, stats_visit_per_month_month_full, stats_visit_per_month_month_short, stats_visit_per_month_year, stats_visit_per_month_human_unique, stats_visit_per_month_human_unique_diff_from_last_month, stats_visit_per_month_human_average_duration, stats_visit_per_month_human_new_visitor_unique, stats_visit_per_month_human_returning_visitor_unique, stats_visit_per_month_unique_desktop, stats_visit_per_month_unique_mobile, stats_visit_per_month_unique_bots, stats_visit_per_month_hits_total, stats_visit_per_month_hits_human, stats_visit_per_month_hits_desktop, stats_visit_per_month_hits_mobile, stats_visit_per_month_hits_bots FROM $t_stats_visists_per_month WHERE stats_visit_per_month_year=$get_stats_visit_per_year_year";
			$result_m = mysqli_query($link, $query_m);
			while($row_m = mysqli_fetch_row($result_m)) {
				list($get_stats_visit_per_month_id, $get_stats_visit_per_month_month, $get_stats_visit_per_month_month_full, $get_stats_visit_per_month_month_short, $get_stats_visit_per_month_year, $get_stats_visit_per_month_human_unique, $get_stats_visit_per_month_human_unique_diff_from_last_month, $get_stats_visit_per_month_human_average_duration, $get_stats_visit_per_month_human_new_visitor_unique, $get_stats_visit_per_month_human_returning_visitor_unique, $get_stats_visit_per_month_unique_desktop, $get_stats_visit_per_month_unique_mobile, $get_stats_visit_per_month_unique_bots, $get_stats_visit_per_month_hits_total, $get_stats_visit_per_month_hits_human, $get_stats_visit_per_month_hits_desktop, $get_stats_visit_per_month_hits_mobile, $get_stats_visit_per_month_hits_bots) = $row_m;
			
				echo"
				 <tr>
				  <td style=\"padding-left: 10px;\">
					<a id=\"#month$get_stats_visit_per_year_year$get_stats_visit_per_month_month\"></a>
					<span>
					<a href=\"index.php?open=$open&amp;page=statistics_month&amp;stats_year=$get_stats_visit_per_year_year&amp;stats_month=$get_stats_visit_per_month_month\">$get_stats_visit_per_month_month_full $get_stats_visit_per_year_year</a>
					</span>
				  </td>
				  <td>
					<span>
					";
					echo number_format($get_stats_visit_per_month_human_unique);
					echo"
					</span>
				  </td>
				  <td>
					<span>
					";
					echo number_format($get_stats_visit_per_month_unique_desktop);
					echo"
					</span>
				  </td>
				  <td>
					<span>
					";
					echo number_format($get_stats_visit_per_month_unique_mobile);
					echo"
					</span>
				  </td>
				  <td>
					<span>
					";
					echo number_format($get_stats_visit_per_month_unique_bots);
					echo"
					</span>
				  </td>
				 </tr>";

				// Control calculate this year
				$stats_visit_per_month_human_unique_total = $stats_visit_per_month_human_unique_total + $get_stats_visit_per_month_human_unique;
				$stats_visit_per_month_unique_desktop     = $stats_visit_per_month_unique_desktop + $get_stats_visit_per_month_unique_desktop;
				$stats_visit_per_month_unique_mobile      = $stats_visit_per_month_unique_mobile + $get_stats_visit_per_month_unique_mobile;
				$stats_visit_per_month_unique_bots        = $stats_visit_per_month_unique_bots + $get_stats_visit_per_month_unique_bots;
			} // while months
			 
			// Control check this year
			if($stats_visit_per_month_human_unique_total != "$get_stats_visit_per_year_human_unique" OR $stats_visit_per_month_unique_desktop != "$get_stats_visit_per_year_unique_desktop" OR $stats_visit_per_month_unique_mobile != "$get_stats_visit_per_year_unique_mobile" OR $stats_visit_per_month_unique_bots != "$get_stats_visit_per_year_unique_bots"){
				mysqli_query($link, "UPDATE $t_stats_visists_per_year SET 
							stats_visit_per_year_human_unique=$stats_visit_per_month_human_unique_total,
							stats_visit_per_year_unique_desktop=$stats_visit_per_month_unique_desktop,
							stats_visit_per_year_unique_mobile=$stats_visit_per_month_unique_mobile,
							stats_visit_per_year_unique_bots=$stats_visit_per_month_unique_bots
							WHERE stats_visit_per_year_id=$get_stats_visit_per_year_id") or die(mysqli_error($link));
			
				echo"
				 <tr>
				  <td style=\"padding-left: 10px;\">
				  </td>
				  <td>
					<span><em>
					";
					echo number_format($stats_visit_per_month_human_unique_total);
					echo"
					</em></span>
				  </td>
				  <td>
					<span><em>
					";
					echo number_format($stats_visit_per_month_unique_desktop);
					echo"
					</em></span>
				  </td>
				  <td>
					<span><em>
					";
					echo number_format($stats_visit_per_month_unique_mobile);
					echo"
					</em></span>
				  </td>
				  <td>
					<span><em>
					";
					echo number_format($stats_visit_per_month_unique_bots);
					echo"
					</em></span>
				  </td>
				 </tr>";
			} // Check that year is corrected calculated
			echo"
			 <tr>
			  <td colspan=\"5\">
				<p></p>
			  </td>
			 </tr>
			";
		} // while years
		echo"
			</table>
		  </td>
		 </tr>
		</table>

	</div> <!-- //White bg -->
<!-- //Periode selection -->


";


?>