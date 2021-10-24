<?php
/**
*
* File: _admin/_inc/media/statistics_month.php
* Version 1.0
* Date 16:39 24.10.2021
* Copyright (c) 2021 Sindre Andre Ditlefsen
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
$t_stats_comments_per_week 	= $dbPrefixSav . "stats_comments_per_week";

$t_stats_countries_per_year  = $dbPrefixSav . "stats_countries_per_year";
$t_stats_countries_per_month = $dbPrefixSav . "stats_countries_per_month";

$t_stats_ip_to_country_ipv4 		= $dbPrefixSav . "stats_ip_to_country_ipv4";
$t_stats_ip_to_country_ipv6 		= $dbPrefixSav . "stats_ip_to_country_ipv6";
$t_stats_ip_to_country_geonames 	= $dbPrefixSav . "stats_ip_to_country_geonames";

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

$t_stats_visists_per_day 	= $dbPrefixSav . "stats_visists_per_day";
$t_stats_visists_per_day_ips 	= $dbPrefixSav . "stats_visists_per_day_ips";
$t_stats_visists_per_month 	= $dbPrefixSav . "stats_visists_per_month";
$t_stats_visists_per_month_ips 	= $dbPrefixSav . "stats_visists_per_month_ips";
$t_stats_visists_per_year 	= $dbPrefixSav . "stats_visists_per_year";
$t_stats_visists_per_year_ips 	= $dbPrefixSav . "stats_visists_per_year_ips";

$t_stats_pages_visits_per_year = $dbPrefixSav . "stats_pages_visits_per_year";

$t_search_engine_searches = $dbPrefixSav . "search_engine_searches";

$t_stats_tracker_index = $dbPrefixSav . "stats_tracker_index";

/*- Translation ----------------------------------------------------------------------- */
include("_translations/admin/$l/dashboard/t_default.php");

/*- Variables -------------------------------------------------------------------------- */
if(isset($_GET['stats_year'])) {
	$stats_year = $_GET['stats_year'];
	$stats_year = strip_tags(stripslashes($stats_year));
}
else{
	$stats_year = date("Y");
}
$stats_year_mysql = quote_smart($link, $stats_year);

if(isset($_GET['stats_month'])) {
	$stats_month = $_GET['stats_month'];
	$stats_month = strip_tags(stripslashes($stats_month));
}
else{
	$stats_month = date("m");
}
$stats_month_mysql = quote_smart($link, $stats_month);


/*- Functions ----------------------------------------------------------------------- */
function get_title($url) {
	$url = str_replace("&amp;", "&", $url);

	$options = array(
	  'http'=>array(
	    'method'=>"GET",
	    'header'=>"Accept-language: en\r\n" .
	              "Cookie: foo=bar\r\n" .  // check function.stream-context-create on php.net
	              "User-Agent:  Mozilla/5.0 (compatible; QuickCMS/1; +http://software.frindex.net)\r\n"
	  )
	);

	$context = stream_context_create($options);
	$page = file_get_contents($url, false, $context);
	$title = preg_match('/<title[^>]*>(.*?)<\/title>/ims', $page, $match) ? $match[1] : null;
	return $title;
}


// Find month
$query = "SELECT stats_visit_per_month_id, stats_visit_per_month_month, stats_visit_per_month_month_full, stats_visit_per_month_month_short, stats_visit_per_month_year, stats_visit_per_month_human_unique, stats_visit_per_month_human_unique_diff_from_last_month, stats_visit_per_month_human_average_duration, stats_visit_per_month_human_new_visitor_unique, stats_visit_per_month_human_returning_visitor_unique, stats_visit_per_month_unique_desktop, stats_visit_per_month_unique_mobile, stats_visit_per_month_unique_bots, stats_visit_per_month_hits_total, stats_visit_per_month_hits_human, stats_visit_per_month_hits_desktop, stats_visit_per_month_hits_mobile, stats_visit_per_month_hits_bots FROM $t_stats_visists_per_month WHERE stats_visit_per_month_month=$stats_month_mysql AND stats_visit_per_month_year=$stats_year_mysql";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_current_stats_visit_per_month_id, $get_current_stats_visit_per_month_month, $get_current_stats_visit_per_month_month_full, $get_current_stats_visit_per_month_month_short, $get_current_stats_visit_per_month_year, $get_current_stats_visit_per_month_human_unique, $get_current_stats_visit_per_month_human_unique_diff_from_last_month, $get_current_stats_visit_per_month_human_average_duration, $get_current_stats_visit_per_month_human_new_visitor_unique, $get_current_stats_visit_per_month_human_returning_visitor_unique, $get_current_stats_visit_per_month_unique_desktop, $get_current_stats_visit_per_month_unique_mobile, $get_current_stats_visit_per_month_unique_bots, $get_current_stats_visit_per_month_hits_total, $get_current_stats_visit_per_month_hits_human, $get_current_stats_visit_per_month_hits_desktop, $get_current_stats_visit_per_month_hits_mobile, $get_current_stats_visit_per_month_hits_bots) = $row;

if($get_current_stats_visit_per_month_id == ""){
	echo"<p>Server error 404</p>";
}
else{	
	echo"
	<!-- Headline -->
		<h1>Statistics $get_current_stats_visit_per_month_month_full $get_current_stats_visit_per_month_year</h1>
	<!-- //Headline -->
	
	<!-- Where am I? -->
		<p><b>You are here:</b><br />
		<a href=\"index.php?open=$open&amp;page=statistics\">Statistics</a>
		&gt;
		<a href=\"index.php?open=$open&amp;page=statistics_year&amp;stats_year=$get_current_stats_visit_per_month_year\">$get_current_stats_visit_per_month_year</a>
		&gt;
		<a href=\"index.php?open=$open&amp;page=$page&amp;stats_year=$get_current_stats_visit_per_month_year&amp;stats_month=$get_current_stats_visit_per_month_month\">$get_current_stats_visit_per_month_month_full $get_current_stats_visit_per_month_year</a>
		</p>
	<!-- //Where am I? -->

	

	<!-- Charts javascript -->
		<script src=\"_libraries/amcharts/index.js\"></script>
		<script src=\"_libraries/amcharts/xy.js\"></script>
		<script src=\"_libraries/amcharts/themes/Animated.js\"></script>
		<script src=\"_libraries/amcharts/percent.js\"></script>
		<script src=\"_libraries/amcharts/map.js\"></script>
		<script src=\"_libraries/amcharts/geodata/worldLow.js\"></script>
	<!-- //Charts javascript -->


	<!-- Visits per day -->
		<h2 style=\"padding-bottom:0;margin-bottom:0;\">Visits per day</h2>

		<div id=\"chartdiv_visits_per_day\" style=\"height: 400px;\"></div>
		";
		$cache_file = "visits_per_day_" . $stats_year . "_" . $configSecurityCodeSav . ".js";
		include("_pages/stats/statistics_month_generate/visits_per_month.php");
		echo"
		<script src=\"_cache/$cache_file?rand=$rand\"></script>



		<script>
		am4core.ready(function() {
			var chart = am4core.create(\"chartdiv_visits_per_month\", am4charts.XYChart);
			chart.data = [";

			$x = 0;
			$query = "SELECT stats_visit_per_day_id, stats_visit_per_day_day, stats_visit_per_day_day_full, stats_visit_per_day_day_three, stats_visit_per_day_day_single, stats_visit_per_day_month, stats_visit_per_day_month_full, stats_visit_per_day_month_short, stats_visit_per_day_year, stats_visit_per_day_human_unique, stats_visit_per_day_human_unique_diff_from_yesterday, stats_visit_per_day_human_average_duration, stats_visit_per_day_human_new_visitor_unique, stats_visit_per_day_human_returning_visitor_unique, stats_visit_per_day_unique_desktop, stats_visit_per_day_unique_mobile, stats_visit_per_day_unique_bots, stats_visit_per_day_hits_total, stats_visit_per_day_hits_human, stats_visit_per_day_hits_desktop, stats_visit_per_day_hits_mobile, stats_visit_per_day_hits_bots FROM $t_stats_visists_per_day WHERE stats_visit_per_day_month=$get_current_stats_visit_per_month_month AND stats_visit_per_day_year=$get_current_stats_visit_per_month_year ORDER BY stats_visit_per_day_id";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_stats_visit_per_day_id, $get_stats_visit_per_day_day, $get_stats_visit_per_day_day_full, $get_stats_visit_per_day_day_three, $get_stats_visit_per_day_day_single, $get_stats_visit_per_day_month, $get_stats_visit_per_day_month_full, $get_stats_visit_per_day_month_short, $get_stats_visit_per_day_year, $get_stats_visit_per_day_human_unique, $get_stats_visit_per_day_human_unique_diff_from_yesterday, $get_stats_visit_per_day_human_average_duration, $get_stats_visit_per_day_human_new_visitor_unique, $get_stats_visit_per_day_human_returning_visitor_unique, $get_stats_visit_per_day_unique_desktop, $get_stats_visit_per_day_unique_mobile, $get_stats_visit_per_day_unique_bots, $get_stats_visit_per_day_hits_total, $get_stats_visit_per_day_hits_human, $get_stats_visit_per_day_hits_desktop, $get_stats_visit_per_day_hits_mobile, $get_stats_visit_per_day_hits_bots) = $row;
						
				if($x > 0){
					echo",";
				}
				echo"
				{
					\"x\": \"$get_stats_visit_per_day_day_three $get_stats_visit_per_day_day\",
					\"value\": $get_stats_visit_per_day_human_unique
				}";
				$x++;
			} // while

			echo"
			];
			// Create axes
			var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
			categoryAxis.dataFields.category = \"x\";
			var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
							
			// Create series
			var series1 = chart.series.push(new am4charts.LineSeries());
			series1.dataFields.valueY = \"value\";
			series1.dataFields.categoryX = \"x\";
			series1.name = \"Unique visits\";
			series1.tooltipText = \"Unique visits: {valueY}\";
			series1.fill = am4core.color(\"#99e4dc\");
			series1.stroke = am4core.color(\"#66d5c9\");
			series1.strokeWidth = 1;

			// Tooltips
			chart.cursor = new am4charts.XYCursor();
			chart.cursor.snapToSeries = series;
			chart.cursor.xAxis = valueAxis;
		}); // end am4core.ready()
		</script>
	<!-- //Visits per day -->


	<!-- Countries -->
		<h2 style=\"margin-top:20px;padding-bottom:0;margin-bottom:0;\">Unique Visits per Country for $get_current_stats_visit_per_month_month_full</h2>

		<script>
		am4core.ready(function() {
			am4core.useTheme(am4themes_animated);
			var chart = am4core.create(\"chartdiv_unique_visits_per_country\", am4maps.MapChart);
			chart.geodata = am4geodata_worldLow;


			chart.projection = new am4maps.projections.Miller();

			var polygonSeries = chart.series.push(new am4maps.MapPolygonSeries());
			var polygonTemplate = polygonSeries.mapPolygons.template;
			polygonTemplate.tooltipText = \"{name}: {value.value}\";
			polygonSeries.useGeodata = true;
			polygonSeries.heatRules.push({ property: \"fill\", target: polygonSeries.mapPolygons.template, min: am4core.color(\"#8ab7ff\"), max: am4core.color(\"#25529a\") });


			// add heat legend
			var heatLegend = chart.chartContainer.createChild(am4maps.HeatLegend);
			heatLegend.align = \"center\";
			heatLegend.valign = \"bottom\";
			heatLegend.series = polygonSeries;
			heatLegend.width = am4core.percent(50);
			heatLegend.orientation = \"horizontal\";
			heatLegend.padding(30, 30, 30, 30);
			heatLegend.valueAxis.renderer.labels.template.fontSize = 10;
			heatLegend.valueAxis.renderer.minGridDistance = 40;

			polygonSeries.mapPolygons.template.events.on(\"over\", function (event) {
			  handleHover(event.target);
			})

			polygonSeries.mapPolygons.template.events.on(\"hit\", function (event) {
			  handleHover(event.target);
			})

			function handleHover(mapPolygon) {
			  if (!isNaN(mapPolygon.dataItem.value)) {
			    heatLegend.valueAxis.showTooltipAt(mapPolygon.dataItem.value)
			  }
			  else {
			    heatLegend.valueAxis.hideTooltip();
			  }
			}

			polygonSeries.mapPolygons.template.events.on(\"out\", function (event) {
			  heatLegend.valueAxis.hideTooltip();
			})


			// data
			polygonSeries.data = [";
				$x = 0;
				$query = "SELECT stats_country_id, stats_country_name, stats_country_alpha_2, stats_country_unique, stats_country_hits FROM $t_stats_countries_per_month WHERE stats_country_month=$get_current_stats_visit_per_month_month AND stats_country_year=$get_current_stats_visit_per_month_year";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_stats_country_id, $get_stats_country_name, $get_stats_country_alpha_2, $get_stats_country_unique, $get_stats_country_hits) = $row;

					if($x > 0){
						echo",";
					}
					echo"
					{ \"id\": \"$get_stats_country_alpha_2\", \"value\": $get_stats_country_unique }";

					// x++
					$x++;
				} // while
			echo"];

			// excludes Antarctica
			polygonSeries.exclude = [\"AQ\"];

			chart.seriesContainer.draggable = false;
			chart.seriesContainer.resizable = false;
			chart.maxZoomLevel = 1;
			chart.chartContainer.wheelable = false;
		}); // end am4core.ready()
		</script>
		<div id=\"chartdiv_unique_visits_per_country\" style=\"width: 100%;max-height: 600px;height: 100vh;\"></div>
		
	<!-- //Countries -->


	<!-- Accepted languages -->
		<div class=\"left_right_left\">
			<h2 style=\"margin-top: 20px;\">$l_accepted_languages</h2>


			<script>
			am4core.ready(function() {
				var chart = am4core.create(\"chartdiv_accepted_language_year\", am4charts.PieChart);
				chart.data = [";
				$x = 0;
				$query = "SELECT stats_accepted_language_id, stats_accepted_language_year, stats_accepted_language_name, stats_accepted_language_unique, stats_accepted_language_hits FROM $t_stats_accepted_languages_per_month WHERE stats_accepted_language_month=$get_current_stats_visit_per_month_month AND stats_accepted_language_year=$get_current_stats_visit_per_month_year";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_stats_accepted_language_id, $get_stats_accepted_language_year, $get_stats_accepted_language_name, $get_stats_accepted_language_unique, $get_stats_accepted_language_hits) = $row;

					if($x > 0){
						echo",";
					}
					echo"
					{
					\"x\": \"$get_stats_accepted_language_name\",
					\"value\": $get_stats_accepted_language_unique
					}";

					// x++
					$x++;
				} // while
				echo"
            			];
				var series = chart.series.push(new am4charts.PieSeries());
				series.dataFields.value = \"value\";
				series.dataFields.category = \"x\";
			}); // end am4core.ready()
       			</script>
       			<div id=\"chartdiv_accepted_language_year\" style=\"max-height: 250px;margin-top:10px;\"></div>
		</div>
	<!-- //Accepted languages -->


	<!-- Language used -->
		<div class=\"left_right_right\">
			<h2 style=\"margin-top: 20px;\">Language used</h2>

			<script>
			am4core.ready(function() {
				var chart = am4core.create(\"chartdiv_languages_per_month\", am4charts.PieChart);
				chart.data = [";
				$x = 0;
				$query = "SELECT stats_language_id, stats_language_name, stats_language_iso_two, stats_language_flag_path_16x16, stats_language_flag_16x16, stats_language_unique, stats_language_hits FROM $t_stats_languages_per_month WHERE stats_language_month=$get_current_stats_visit_per_month_month AND stats_language_year=$get_current_stats_visit_per_month_year ORDER BY stats_language_unique ASC LIMIT 0,12";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_stats_language_id, $get_stats_language_name, $get_stats_language_iso_two, $get_stats_language_flag_path_16x16, $get_stats_language_flag_16x16, $get_stats_language_unique, $get_stats_language_hits) = $row;
						
					if($x > 0){
						echo",";
					}
					echo"
					{
						\"x\": \"$get_stats_language_name\",
						\"value\": $get_stats_language_unique
					}";
					$x++;
				} // while

				echo"];
				var series = chart.series.push(new am4charts.PieSeries());
				series.dataFields.value = \"value\";
				series.dataFields.category = \"x\";
			}); // end am4core.ready()
       			</script>
       			<div id=\"chartdiv_languages_per_month\" style=\"max-height: 250px;margin-top:10px;\"></div>
		</div>
		<div class=\"clear\"></div>
	<!-- //Language used -->


	<!-- Os -->
		<div class=\"left_right_left\">
			<h2 style=\"margin-top: 20px;\">$l_os</h2>

			<script>
			am4core.ready(function() {
				var chart = am4core.create(\"chartdiv_os_year\", am4charts.PieChart);
				chart.data = [";
				$x = 0;
				$query = "SELECT stats_os_id, stats_os_year, stats_os_name, stats_os_type, stats_os_unique, stats_os_hits FROM $t_stats_os_per_month WHERE stats_os_month=$get_current_stats_visit_per_month_month AND stats_os_year=$get_current_stats_visit_per_month_year";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_stats_os_id, $get_stats_os_year, $get_stats_os_name, $get_stats_os_type, $get_stats_os_unique, $get_stats_os_hits) = $row;

					if($x > 0){
						echo",";
					}
					echo"
					{
					\"x\": \"$get_stats_os_name\",
					\"value\": $get_stats_os_unique
					}";

					// x++
					$x++;
				} // while
				echo"
            			];
				var series = chart.series.push(new am4charts.PieSeries());
				series.dataFields.value = \"value\";
				series.dataFields.category = \"x\";
			}); // end am4core.ready()
       			</script>
       			<div id=\"chartdiv_os_year\" style=\"max-height: 250px;margin-top:10px;\"></div>

		</div>
	<!-- //Os -->


	<!-- Mobile vs desktop -->
		<div class=\"left_right_right\">
			<h2 style=\"margin-top: 20px;\">Mobile vs desktop</h2>

			<script>
			am4core.ready(function() {
				var chart = am4core.create(\"chartdiv_mobile_vs_desktop\", am4charts.PieChart);
				chart.data = [
					{
					\"x\": \"Desktop\",
					\"value\": $get_current_stats_visit_per_month_unique_desktop
					},
					{
					\"x\": \"Mobile\",
					\"value\": $get_current_stats_visit_per_month_unique_mobile
					}

            			];
				var series = chart.series.push(new am4charts.PieSeries());
				series.dataFields.value = \"value\";
				series.dataFields.category = \"x\";
			}); // end am4core.ready()
       			</script>
       			<div id=\"chartdiv_mobile_vs_desktop\" style=\"max-height: 250px;margin-top:10px;\"></div>
		</div>
		<div class=\"clear\"></div>
	<!-- //Mobile vs desktop -->




	<!-- Browsers -->
		<div class=\"left_right_left\">
			<h2 style=\"margin-top: 20px;\">$l_browsers</h2>

			<script>
			am4core.ready(function() {
				var chart = am4core.create(\"chartdiv_browsers_year\", am4charts.PieChart);
				chart.data = [";
				$x = 0;
				$query = "SELECT stats_browser_id, stats_browser_year, stats_browser_name, stats_browser_unique, stats_browser_hits FROM $t_stats_browsers_per_month WHERE stats_browser_month=$get_current_stats_visit_per_month_month AND stats_browser_year=$get_current_stats_visit_per_month_year";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_stats_browser_id, $get_stats_browser_year, $get_stats_browser_name, $get_stats_browser_unique, $get_stats_browser_hits) = $row;

					if($x > 0){
						echo",";
					}
					echo"
					{
					\"x\": \"$get_stats_browser_name\",
					\"value\": $get_stats_browser_unique
					}";

					// x++
					$x++;
				} // while
				echo"
            			];
				var series = chart.series.push(new am4charts.PieSeries());
				series.dataFields.value = \"value\";
				series.dataFields.category = \"x\";
			}); // end am4core.ready()
       			</script>
       			<div id=\"chartdiv_browsers_year\" style=\"max-height: 250px;margin-top:10px;\"></div>

		</div>
	<!-- //Browsers -->




	<!-- Humans vs bots unique -->
		<div class=\"left_right_right\">
			<h2 style=\"margin-top: 20px;\">Human vs bots unique</h2>

			<script>
			am4core.ready(function() {
				var chart = am4core.create(\"chartdiv_humans_vs_bots_unique\", am4charts.PieChart);
				chart.data = [
					{
					\"x\": \"Humans\",
					\"value\": $get_current_stats_visit_per_month_human_unique
					},
					{
					\"x\": \"Bots\",
					\"value\": $get_current_stats_visit_per_month_unique_bots
					}

            			];
				var series = chart.series.push(new am4charts.PieSeries());
				series.dataFields.value = \"value\";
				series.dataFields.category = \"x\";
			}); // end am4core.ready()
       			</script>
       			<div id=\"chartdiv_humans_vs_bots_unique\" style=\"max-height: 250px;margin-top:10px;\"></div>
		</div>
		<div class=\"clear\"></div>
	<!-- //Humans vs bots unique -->

		
	<!-- Comments this month -->
		<a id=\"comments_this_month\"></a>
		<h2 style=\"margin-top: 20px;\">Comments per week <a href=\"#comments_this_month\" class=\"toggle\" data-divid=\"comments_per_month_information\"><img src=\"_design/gfx/icons/16x16/information.png\" alt=\"information.png\" /></a></h2>
		<div class=\"comments_per_month_information\">
			<p>
			Comments are from the following modules: blog, courses, downloads, exercises, food, recipes and references
			</p>
		</div>


		<script>
		am4core.ready(function() {
			var chart = am4core.create(\"chartdiv_comments_this_month\", am4charts.XYChart);
			chart.data = [";

			$x = 0;
			$query = "SELECT stats_comments_id, stats_comments_week, stats_comments_month, stats_comments_comments_written, stats_comments_comments_written_diff_from_last_week FROM $t_stats_comments_per_week WHERE stats_comments_year=$get_current_stats_visit_per_month_year ORDER BY stats_comments_id LIMIT 0,30";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_stats_comments_id, $get_stats_comments_week, $get_stats_comments_month, $get_stats_comments_comments_written, $get_stats_comments_comments_written_diff_from_last_week) = $row;
						
				if($x > 0){
					echo",";
				}
				echo"
				{
					\"x\": \"$get_stats_comments_week\",
					\"value\": $get_stats_comments_comments_written
				}";
				$x++;
			} // while

			echo"
			];
			// Create axes
			var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
			categoryAxis.dataFields.category = \"x\";
			var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
							
			// Create series
			var series1 = chart.series.push(new am4charts.LineSeries());
			series1.dataFields.valueY = \"value\";
			series1.dataFields.categoryX = \"x\";
			series1.name = \"Comments\";
			series1.tooltipText = \"Comments: {valueY}\";
			series1.fill = am4core.color(\"#99e4dc\");
			series1.stroke = am4core.color(\"#66d5c9\");
			series1.strokeWidth = 1;

			// Tooltips
			chart.cursor = new am4charts.XYCursor();
			chart.cursor.snapToSeries = series;
			chart.cursor.xAxis = valueAxis;
		}); // end am4core.ready()
		</script>
		<div id=\"chartdiv_comments_this_month\" style=\"height: 400px;\"></div>
	<!-- //Comments this month -->


	<!-- Bots -->
		<h2>$l_bots</h2>
		<table class=\"hor-zebra\">
		 <thead>
		  <tr>
		   <th scope=\"col\" style=\"width: 40%;\">
			<span>$l_bot</span>
		   </th>
		   <th scope=\"col\" style=\"width: 30%;\">
			<span>$l_unique</span>
		   </th>
		   <th scope=\"col\" style=\"width: 30%;\">
			<span>$l_hits</span>
		   </th>
		  </tr>
		 </thead>
		 <tbody>
		";

		$query = "SELECT stats_bot_id, stats_bot_year, stats_bot_name, stats_bot_unique, stats_bot_hits FROM $t_stats_bots_per_month WHERE stats_bot_month=$get_current_stats_visit_per_month_month AND stats_bot_year=$get_current_stats_visit_per_month_year  ORDER BY stats_bot_unique DESC LIMIT 0,5";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_stats_bot_id, $get_stats_bot_year, $get_stats_bot_name, $get_stats_bot_unique, $get_stats_bot_hits) = $row;
			

			$percent = round(($get_stats_bot_unique/$get_current_stats_visit_per_month_unique_bots)*100);
			if($percent > 90){
				$width = 90;
			}
			elseif($percent == 0){
				$width = 1;
			}
			else{
				$width = $percent;
			}
			$div_width = $width . "px";

			echo"
			 <tr>
			  <td>
				<span>$get_stats_bot_name</span>
			  </td>
			  <td>
				<span style=\"float:left;margin-right:10px;\">$get_stats_bot_unique</span>
				<div class=\"stats_bar\" style=\"float:left;margin-right:10px;width: $div_width\">
					<div class=\"stats_bar_inner\"><span>&nbsp;</span></div>
				</div>
			  </td>
			  <td>
				<span>$get_stats_bot_hits</span>
			  </td>
			 </tr>
			";
		}
		echo"
		 </tbody>
		</table>
	<!-- //Bots -->



	<!-- Pages -->
		<h2>Page Visits</h2>


		<table class=\"hor-zebra\">
		 <thead>
		  <tr>
		   <th scope=\"col\" style=\"width: 40%;\">
			<span>$l_bot</span>
		   </th>
		   <th scope=\"col\" style=\"width: 30%;\">
			<span>Human unique</span>
		   </th>
		   <th scope=\"col\" style=\"width: 30%;\">
			<span>Bots unique</span>
		   </th>
		  </tr>
		 </thead>
		 <tbody>
		";
		if($get_current_stats_visit_per_month_month < 10){
			$get_current_stats_visit_per_month_month = 0 . $get_current_stats_visit_per_month_month;
		}
		$first_day_time = strtotime("$get_current_stats_visit_per_month_year-$get_current_stats_visit_per_month_month-01");
		$query = "SELECT stats_pages_per_year_id, stats_pages_per_year_url, stats_pages_per_year_title, stats_pages_per_year_title_fetched, stats_pages_per_year_human_unique, stats_pages_per_year_unique_desktop, stats_pages_per_year_unique_mobile, stats_pages_per_year_unique_bots FROM $t_stats_pages_visits_per_year WHERE stats_pages_per_year_year=$get_current_stats_visit_per_month_year AND stats_pages_per_year_updated_time > $first_day_time ORDER BY stats_pages_per_year_human_unique DESC LIMIT 0,50";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_stats_pages_per_year_id, $get_stats_pages_per_year_url, $get_stats_pages_per_year_title, $get_stats_pages_per_year_title_fetched, $get_stats_pages_per_year_human_unique, $get_stats_pages_per_year_unique_desktop, $get_stats_pages_per_year_unique_mobile, $get_stats_pages_per_year_unique_bots) = $row;
			

			// We need to visit the site in order to get the correct page title
			if($get_stats_pages_per_year_title_fetched == "0"){
				$get_stats_pages_per_year_title = get_title($get_stats_pages_per_year_url);
				$get_stats_pages_per_year_title = output_html($get_stats_pages_per_year_title);
				$inp_title_mysql = quote_smart($link, $get_stats_pages_per_year_title);
				mysqli_query($link, "UPDATE $t_stats_pages_visits_per_year SET stats_pages_per_year_title=$inp_title_mysql, stats_pages_per_year_title_fetched=1 WHERE stats_pages_per_year_id=$get_stats_pages_per_year_id") or die(mysqli_error($link));
				
			}

			// Delete empty
			if($get_stats_pages_per_year_title == ""){
				mysqli_query($link, "DELETE FROM $t_stats_pages_visits_per_year WHERE stats_pages_per_year_id=$get_stats_pages_per_year_id") or die(mysqli_error($link));
				$get_stats_pages_per_year_title = "[Deleted]";
			}

			echo"
			 <tr>
			  <td>
				<span><a href=\"$get_stats_pages_per_year_url\">$get_stats_pages_per_year_title</a></span>
			  </td>
			  <td>
				<span>$get_stats_pages_per_year_human_unique</span>
			  </td>
			  <td>
				<span>$get_stats_pages_per_year_unique_bots</span>
			  </td>
			 </tr>
			";
		}
		echo"
		 </tbody>
		</table>
	<!-- //Pages -->

	<!-- Searches -->
		<h2>Searches</h2>
		<table class=\"hor-zebra\">
		 <thead>
		  <tr>
		   <th scope=\"col\">
			<span>Query</span>
		   </th>
		   <th scope=\"col\">
			<span>Search counter</span>
		   </th>
		   <th scope=\"col\">
			<span>Results</span>
		   </th>
		   <th scope=\"col\">
			<span>Created</span>
		   </th>
		   <th scope=\"col\">
			<span>Updated</span>
		   </th>
		  </tr>
		 </thead>
		 <tbody>
		";

		// Calendar
		$between_from = "$get_current_stats_visit_per_month_year-$get_current_stats_visit_per_month_month-01 00:00:00";
		if($get_current_stats_visit_per_month_month < "10"){
			$between_from = "$get_current_stats_visit_per_month_year-0$get_current_stats_visit_per_month_month-01 00:00:00";
		}
		$between_from_mysql = quote_smart($link, $between_from);

		$between_to = "$get_current_stats_visit_per_month_year-$get_current_stats_visit_per_month_month-31 00:00:00";
		if($get_current_stats_visit_per_month_month == "2"){
			$between_to = "$get_current_stats_visit_per_month_year-$get_current_stats_visit_per_month_month-28 00:00:00";
		}
		elseif($get_current_stats_visit_per_month_month == "4" OR $get_current_stats_visit_per_month_month == "6" OR $get_current_stats_visit_per_month_month == "9" OR $get_current_stats_visit_per_month_month == "11"){
			$between_to = "$get_current_stats_visit_per_month_year-$get_current_stats_visit_per_month_month-30 00:00:00";
		}
		else{
			$between_to = "$get_current_stats_visit_per_month_year-$get_current_stats_visit_per_month_month-31 00:00:00";
		}
		$between_to_mysql = quote_smart($link, $between_to);

		$query = "SELECT search_id, search_query, search_unique_counter, search_language_used, search_unique_ip_block, search_number_of_results, search_created_datetime, search_created_datetime_print, search_updated_datetime, search_updated_datetime_print FROM $t_search_engine_searches WHERE search_updated_datetime > $between_from_mysql AND search_updated_datetime < $between_to_mysql ORDER BY search_updated_datetime DESC";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_search_id, $get_search_query, $get_search_unique_counter, $get_search_language_used, $get_search_unique_ip_block, $get_search_number_of_results, $get_search_created_datetime, $get_search_created_datetime_print, $get_search_updated_datetime, $get_search_updated_datetime_print) = $row;
			
			// Style
			if(isset($style) && $style == ""){
				$style = "odd";
			}
			else{
				$style = "";
			}


		
			echo"
			 <tr>
			  <td class=\"$style\">
				<span>
				<a href=\"../search/search.php?inp_search_query=$get_search_query&amp;l=$get_search_language_used\">$get_search_query</a>
				</span>
			  </td>
			  <td class=\"$style\">
				<span>
				$get_search_unique_counter
				</span>
			  </td>
			  <td class=\"$style\">
				<span>
				$get_search_number_of_results
				</span>
			  </td>
			  <td class=\"$style\">
				<span>
				$get_search_created_datetime_print
				</span>
			  </td>
			  <td class=\"$style\">
				<span>
				$get_search_updated_datetime_print
				</span>
			  </td>
			 </tr>";
		}
		


		echo"
		 </tbody>
		</table>
	<!-- //Searches -->

	<!-- Referers-->
		<h2>Referrers</h2>
		<table class=\"hor-zebra\">
		 <thead>
		  <tr>
		   <th scope=\"col\" style=\"width: 40%;\">
			<span>From URL</span>
		   </th>
		   <th scope=\"col\" style=\"width: 30%;\">
			<span>To URL</span>
		   </th>
		   <th scope=\"col\" style=\"width: 30%;\">
			<span>Unique</span>
		   </th>
		   <th scope=\"col\" style=\"width: 30%;\">
			<span>Hits</span>
		   </th>
		  </tr>
		 </thead>
		 <tbody>
		";

		$query = "SELECT stats_referer_id, stats_referer_year, stats_referer_from_url, stats_referer_to_url, stats_referer_unique, stats_referer_hits FROM $t_stats_referers_per_month WHERE stats_referer_month=$get_current_stats_visit_per_month_month AND stats_referer_year=$get_current_stats_visit_per_month_year ORDER BY stats_referer_unique DESC LIMIT 0,30";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_stats_referer_id, $get_stats_referer_year, $get_stats_referer_from_url, $get_stats_referer_to_url, $get_stats_referer_unique, $get_stats_referer_hits) = $row;
			


			echo"
			 <tr>
			  <td>
				<span><a href=\"$get_stats_referer_from_url\">$get_stats_referer_from_url</a></span>
			  </td>
			  <td>
				<span><a href=\"$get_stats_referer_to_url\">$get_stats_referer_to_url</a></span>
			  </td>
			  <td>
				<span>$get_stats_referer_unique</span>
			  </td>
			  <td>
				<span>$get_stats_referer_hits</span>
			  </td>
			 </tr>
			";
		}
		echo"
		 </tbody>
		</table>
	<!-- //Referers-->


	<!-- Trackers -->
		<a id=\"trackers\"></a>
		<h2>Trackers</h2>
		<p>Trackers log the last visitors and how they use your site.</p>
		<!-- Select language -->
			<script>
			\$(function(){
				// bind change event to select
				\$('#inp_l').on('change', function () {
					var url = \$(this).val(); // get selected value
					if (url) { // require a URL
 						window.location = url; // redirect
					}
					return false;
				});
			});
			</script>

			<select id=\"inp_l\">
				<option value=\"index.php?open=dashboard&amp;page=statistics_month&amp;stats_year=$stats_year&amp;stats_month=$stats_month&amp;editor_language=$editor_language\">$l_editor_language</option>
				<option value=\"index.php?open=dashboard&amp;page=statistics_month&amp;stats_year=$stats_year&amp;stats_month=$stats_month&amp;editor_language=$editor_language\">-</option>\n";

				$query = "SELECT language_active_id, language_active_name, language_active_iso_two, language_active_default FROM $t_languages_active";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_language_active_id, $get_language_active_name, $get_language_active_iso_two, $get_language_active_default) = $row;

					// No language selected?
					if($editor_language == ""){
							$editor_language = "$get_language_active_iso_two";
					}
					echo"	<option value=\"index.php?open=dashboard&amp;page=statistics_year&amp;stats_year=$stats_year&amp;stats_month=$stats_month&amp;editor_language=$get_language_active_iso_two#trackers\"";if($editor_language == "$get_language_active_iso_two"){ echo" selected=\"selected\"";}echo">$get_language_active_name</option>\n";
				}
			echo"
			</select>
			</p>
			</form>
		<!-- //Select language -->

		<table class=\"hor-zebra\">
		 <thead>
		  <tr>
		   <th scope=\"col\">
			<span>ID</span>
		   </th>
		   <th scope=\"col\">
			<span>Type</span>
		   </th>
		   <th scope=\"col\">
			<span>IP</span>
		   </th>
		   <th scope=\"col\">
			<span>Last URL</span>
		   </th>
		   <th scope=\"col\">
			<span>OS</span>
		   </th>
		   <th scope=\"col\">
			<span>Browser</span>
		   </th>
		   <th scope=\"col\">
			<span>Country</span>
		   </th>
		   <th scope=\"col\">
			<span>Accepted language</span>
		   </th>
		   <th scope=\"col\">
			<span>Language</span>
		   </th>
		   <th scope=\"col\">
			<span>Time spent</span>
		   </th>
		   <th scope=\"col\">
			<span>Hits</span>
		   </th>
		  </tr>
		 </thead>
		 <tbody>
		";
		$editor_language_mysql = quote_smart($link, $editor_language);
		$query = "SELECT tracker_id, tracker_ip, tracker_ip_masked, tracker_month, tracker_month_short, tracker_year, tracker_time_start, tracker_hour_minute_start, tracker_time_end, tracker_hour_minute_end, tracker_seconds_spent, tracker_time_spent, tracker_os, tracker_browser, tracker_type, tracker_country_name, tracker_accept_language, tracker_language, tracker_last_url_value, tracker_last_url_title, tracker_last_url_title_fetched, tracker_hits FROM $t_stats_tracker_index WHERE tracker_language=$editor_language_mysql ORDER BY tracker_id DESC LIMIT 0,300";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_tracker_id, $get_tracker_ip, $get_tracker_ip_masked, $get_tracker_month, $get_tracker_month_short, $get_tracker_year, $get_tracker_time_start, $get_tracker_hour_minute_start, $get_tracker_time_end, $get_tracker_hour_minute_end, $get_tracker_seconds_spent, $get_tracker_time_spent, $get_tracker_os, $get_tracker_browser, $get_tracker_type, $get_tracker_country_name, $get_tracker_accept_language, $get_tracker_language, $get_tracker_last_url_value, $get_tracker_last_url_title, $get_tracker_last_url_title_fetched, $get_tracker_hits) = $row;
			
			if($get_tracker_last_url_title_fetched == "0"){
				$inp_url_title = get_title($get_tracker_last_url_value);
				$inp_url_title = output_html($inp_url_title);
				if($inp_url_title == ""){
					$inp_url_title = "$get_tracker_last_url_title";
				}
				$inp_url_title_mysql = quote_smart($link, $inp_url_title);
				
				mysqli_query($link, "UPDATE $t_stats_tracker_index SET tracker_last_url_title=$inp_url_title_mysql, tracker_last_url_title_fetched=1 WHERE tracker_id=$get_tracker_id") or die(mysqli_error());

				$get_tracker_last_url_title = "$inp_url_title";
			}

			echo"
			 <tr>
			  <td>
				<span><a href=\"index.php?open=dashboard&amp;page=statistics_tracker&amp;tracker_id=$get_tracker_id&amp;editor_language=$editor_language\">$get_tracker_id</a></span>
			  </td>
			  <td>
				<span>$get_tracker_type</span>
			  </td>
			  <td>
				<span>$get_tracker_ip_masked</span>
			  </td>
			  <td>
				<span><a href=\"$get_tracker_last_url_value\">$get_tracker_last_url_title</a></span>
			  </td>
			  <td>
				<span>$get_tracker_os</span>
			  </td>
			  <td>
				<span>$get_tracker_browser</span>
			  </td>
			  <td>
				<span>$get_tracker_country_name</span>
			  </td>
			  <td>
				<span>$get_tracker_accept_language</span>
			  </td>
			  <td>
				<span>$get_tracker_language</span>
			  </td>
			  <td>
				<span>$get_tracker_time_spent</span>
			  </td>
			  <td>
				<span>$get_tracker_hits</span>
			  </td>
			 </tr>
			";

		}
		echo"
		 </tbody>
		</table>
	<!-- //Trackers -->
	";
	
} // year found

?>