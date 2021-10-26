<?php
/**
*
* File: _stats/_pages/stats/statistics_year_generate/unique_visits_per_country.php
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
$inp_header ="
// Create root and chart
var root = am5.Root.new(\"chartdiv_unique_visits_per_country\"); 


 
// Set themes
root.setThemes([
  am5themes_Animated.new(root)
]);

// Create chart
var chart = root.container.children.push(
  am5map.MapChart.new(root, {
    panX: \"none\",
    panY: \"none\"
  })
);

// Create polygon series
var polygonSeries = chart.series.push(
  am5map.MapPolygonSeries.new(root, {
    geoJSON: am5geodata_worldLow,
    valueField: \"value\",
    calculateAggregates: true,
    exclude: [\"AQ\"]
  })
);

polygonSeries.mapPolygons.template.setAll({
  tooltipText: \"{name}: {value}\"
});

polygonSeries.set(\"heatRules\", [{
  target: polygonSeries.mapPolygons.template,
  dataField: \"value\",
  min: am5.color(0xff621f),
  max: am5.color(0x661f00),
  key: \"fill\"
}]);

polygonSeries.mapPolygons.template.states.create(\"hover\", {
  fill: am5.color(0x677935)
});
";

/*- Visits per year -------------------------------------------------------------------------- */
$inp_data = "// Data
polygonSeries.data.setAll([";


$x = 0;
$query = "SELECT stats_country_id, stats_country_name, stats_country_alpha_2, stats_country_unique, stats_country_hits FROM $t_stats_countries_per_year WHERE stats_country_year=$get_current_stats_visit_per_year_year";
$result = mysqli_query($link, $query);
while($row = mysqli_fetch_row($result)) {
	list($get_stats_country_id, $get_stats_country_name, $get_stats_country_alpha_2, $get_stats_country_unique, $get_stats_country_hits) = $row;
	$get_stats_country_alpha_2 = strtoupper($get_stats_country_alpha_2);

	if($x > 0){
		$inp_data = $inp_data . ",";
	}
	$inp_data = $inp_data . "\n  { id: \"$get_stats_country_alpha_2\", value: $get_stats_country_unique }";

	// x++
	$x++;
} // while
$inp_data = $inp_data . "
]);";


/*- Footer ------------------------------------------------------------------------------------ */
$inp_footer = "


";



/*- Write to file ----------------------------------------------------------------------------- */
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
    <title>unique_visits_per_country</title>
    <link rel=\"stylesheet\" href=\"index.css\" />
</head>
<body>
    <div id=\"chartdiv_unique_visits_per_country\" style=\"width: 100%;height: 80vh;\"></div>

<script src=\"../../_libraries/amcharts/index.js\"></script>
<script src=\"../../_libraries/amcharts/themes/Animated.js\"></script>

<script src=\"../../_libraries/amcharts/map.js\"></script>
<script src=\"../../_libraries/amcharts/geodata/worldLow.js\"></script>

<script src=\"../../_libraries/amcharts/geodata/data/countries.js\"></script>
<script src=\"../../_libraries/amcharts/geodata/data/countries2.js\"></script>

<script src=\"$cache_file\"></script>
  </body>
</html>";


$fp = fopen("_cache/year/$cache_file.html", "w") or die("Unable to open file!");
fwrite($fp, $inp_test);
fclose($fp);

?>