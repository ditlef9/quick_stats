<?php
/**
*
* File: _stats/_pages/stats/statistics_year_generate/languages_per_year.php
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


/*- Header ----------------------------------------------------------------------------- */
$inp_header ="// Create root element
// https://www.amcharts.com/docs/v5/getting-started/#Root_element
var root = am5.Root.new(\"chartdiv_languages_per_year\");

// Set themes
// https://www.amcharts.com/docs/v5/concepts/themes/
root.setThemes([
  am5themes_Animated.new(root)
]);


// Create chart
// https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/
var chart = root.container.children.push(am5percent.PieChart.new(root, {
  layout: root.verticalLayout
}));


// Create series
// https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Series
var series = chart.series.push(am5percent.PieSeries.new(root, {
  valueField: \"value\",
  categoryField: \"category\"
}));

";

/*- Visits per year -------------------------------------------------------------------------- */
$inp_data = "// Set data
// https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Setting_data
series.data.setAll([";


$x = 0;
$query = "SELECT stats_language_id, stats_language_year, stats_language_name, stats_language_iso_two, stats_language_flag_path_16x16, stats_language_flag_16x16, stats_language_unique, stats_language_hits FROM $t_stats_languages_per_year WHERE stats_language_year=$get_current_stats_visit_per_year_year ORDER BY stats_language_unique ASC LIMIT 0,12";
$result = mysqli_query($link, $query);
while($row = mysqli_fetch_row($result)) {
	list($get_stats_language_id, $get_stats_language_year, $get_stats_language_name, $get_stats_language_iso_two, $get_stats_language_flag_path_16x16, $get_stats_language_flag_16x16, $get_stats_language_unique, $get_stats_language_hits) = $row;
						
	$inp_data = $inp_data  . "{ value: $get_stats_language_unique, category: \"$get_stats_language_name\" },
";

	// x++
	$x++;
} // while



$inp_data = $inp_data . "]);
";

/*- Footer ------------------------------------------------------------------------------------ */
$inp_footer = "

legend.data.setAll(series.dataItems);


// Play initial series animation
// https://www.amcharts.com/docs/v5/concepts/animations/#Animation_of_series
series.appear(1000, 100);";



/*- Write to file ----------------------------------------------------------------------------- */
if(!(is_dir("_cache"))){
	mkdir("_cache");

	$fp = fopen("_cache/index.html", "w") or die("Unable to open file!");
	fwrite($fp, "Server error 403");
	fclose($fp);

}
if(!(is_dir("_cache/year"))){
	mkdir("_cache/year");

	$fp = fopen("_cache/year/index.html", "w") or die("Unable to open file!");
	fwrite($fp, "Server error 403");
	fclose($fp);
	$fp = fopen("_cache/year/index.css", "w") or die("Unable to open file!");
	fwrite($fp, "");
	fclose($fp);

}
$fp = fopen("_cache/year/$cache_file", "w") or die("Unable to open file!");
fwrite($fp, $inp_header);
fwrite($fp, $inp_data);
fwrite($fp, $inp_footer);
fclose($fp);





/*- Test ------------------------------------------------------------------------------------- */
$inp_test="<!DOCTYPE html>
<html>
  <head>
    <meta charset=\"UTF-8\" />
    <title>languages_per_year</title>
    <link rel=\"stylesheet\" href=\"index.css\" />
</head>
<body>
    <div id=\"chartdiv_languages_per_year\" style=\"width: 100%;height: 80vh;\"></div>

<script src=\"../../_libraries/amcharts/index.js\"></script>
<script src=\"../../_libraries/amcharts/percent.js\"></script>
<script src=\"../../_libraries/amcharts/themes/Animated.js\"></script>
<script src=\"$cache_file\"></script>
  </body>
</html>";


$fp = fopen("_cache/year/$cache_file.html", "w") or die("Unable to open file!");
fwrite($fp, $inp_test);
fclose($fp);

?>