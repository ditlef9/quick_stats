<?php
/**
*
* File: _stats/_pages/stats/statistics_month_generate/unique_visits_per_country.php
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
var chart = root.container.children.push(
  am5map.MapChart.new(root, {
    panX: \"none\",
    wheelY: \"none\",
    projection: am5map.geoNaturalEarth1()

  })
);

// Create polygon series
var polygonSeries = chart.series.push(
  am5map.MapPolygonSeries.new(root, {
	geoJSON: am5geodata_worldLow,
	valueField: \"value\",
	categoryField: \"id\"
  })
);
polygonSeries.useGeodata = true;
polygonSeries.heatRules.push({ property: \"fill\", target: polygonSeries.mapPolygons.template, min: am4core.color(\"#8ab7ff\"), max: am4core.color(\"#25529a\") });

			polygonSeries.exclude = [\"AQ\"];


			// add heat legend
			var heatLegend = chart.chartContainer.createChild(am5maps.HeatLegend);
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




";

/*- Visits per year -------------------------------------------------------------------------- */
$inp_data = "// Set data
var data = [";


$x = 0;
$query = "SELECT stats_country_id, stats_country_name, stats_country_alpha_2, stats_country_unique, stats_country_hits FROM $t_stats_countries_per_month WHERE stats_country_month=$get_current_stats_visit_per_month_month AND stats_country_year=$get_current_stats_visit_per_month_year";
$result = mysqli_query($link, $query);
while($row = mysqli_fetch_row($result)) {
	list($get_stats_country_id, $get_stats_country_name, $get_stats_country_alpha_2, $get_stats_country_unique, $get_stats_country_hits) = $row;


	$get_stats_country_alpha_2 = strtoupper($get_stats_country_alpha_2);
	if($x > 0){
		$inp_data = $inp_data . ",";
	}
	$inp_data = $inp_data . "{
  id: \"$get_stats_country_alpha_2\",
  name: \"$get_stats_country_name\",
  value: $get_stats_country_unique
}";

	// x++
	$x++;
} // while
$inp_data = $inp_data . "]";


/*- Footer ------------------------------------------------------------------------------------ */
$inp_footer = "
polygonSeries.data.setAll(data);

";



/*- Write to file ----------------------------------------------------------------------------- */
$fp = fopen("_cache/month/$cache_file", "w") or die("Unable to open file!");
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


$fp = fopen("_cache/month/$cache_file.html", "w") or die("Unable to open file!");
fwrite($fp, $inp_test);
fclose($fp);

?>