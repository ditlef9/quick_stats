<?php
/**
*
* File: _stats/_pages/stats/default_generate_visits_per_month.php
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
var root = am5.Root.new(\"chartdiv_visits_per_day\");


// Set themes
// https://www.amcharts.com/docs/v5/concepts/themes/
root.setThemes([
  am5themes_Animated.new(root)
]);


// Create chart
// https://www.amcharts.com/docs/v5/charts/xy-chart/
var chart = root.container.children.push(am5xy.XYChart.new(root, {
  panX: true,
  panY: true,
  wheelX: \"panX\",
  wheelY: \"zoomX\"
}));

chart.get(\"colors\").set(\"step\", 3);


// Add cursor
// https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
var cursor = chart.set(\"cursor\", am5xy.XYCursor.new(root, {}));
cursor.lineY.set(\"visible\", false);


// Create axes
// https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
var xAxis = chart.xAxes.push(am5xy.DateAxis.new(root, {
  maxDeviation: 0.3,
  baseInterval: {
    timeUnit: \"day\",
    count: 1
  },
  renderer: am5xy.AxisRendererX.new(root, {}),
  tooltip: am5.Tooltip.new(root, {})
}));

var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
  maxDeviation: 0.3,
  renderer: am5xy.AxisRendererY.new(root, {})
}));


// Add series
// https://www.amcharts.com/docs/v5/charts/xy-chart/series/
var series = chart.series.push(am5xy.LineSeries.new(root, {
  name: \"Series 1\",
  xAxis: xAxis,
  yAxis: yAxis,
  valueYField: \"value1\",
  valueXField: \"date\"
}));
series.strokes.template.setAll({
  strokeWidth: 2
});

var tooltip = series.set(\"tooltip\", am5.Tooltip.new(root, {}));
tooltip.get(\"background\").set(\"fillOpacity\", 0.5);
tooltip.label.set(\"text\", \"{valueX}: {valueY}\\n{previousDate}: {value2}\");

var series2 = chart.series.push(am5xy.LineSeries.new(root, {
  name: \"Series 2\",
  xAxis: xAxis,
  yAxis: yAxis,
  valueYField: \"value2\",
  valueXField: \"date\"
}));
series2.strokes.template.setAll({
  strokeDasharray: [2, 2],
  strokeWidth: 2
});



// Set date fields
// https://www.amcharts.com/docs/v5/concepts/data/#Parsing_dates
root.dateFormatter.setAll({
  dateFormat: \"yyyy-MM-dd\",
  dateFields: [\"valueX\"]
});

";

/*- Visits per day -------------------------------------------------------------------------- */
$inp_data = "// Set data
var data = [";



$datetime_class = new DateTime();
// echo $datetime_class->format('Y-m-d'); // 2021-10-19


for($x=0;$x<31;$x++){
	// This day
	$this_year_lookup  = $datetime_class->format('Y');
	$this_month_lookup = $datetime_class->format('n');
	$this_day_lookup   = $datetime_class->format('j');

	// 30 days ago
	$datetime_class->modify('-1 month');
	$last_year_lookup  = $datetime_class->format('Y');
	$last_month_lookup = $datetime_class->format('m');
	$last_day_lookup   = $datetime_class->format('d');

	// Yesterday
	$datetime_class->modify('+1 month');
	$datetime_class->modify('-1 day');
	
	// Fetch day this month
	$query = "SELECT stats_visit_per_day_id, stats_visit_per_day_day, stats_visit_per_day_day_single, stats_visit_per_day_month_short, stats_visit_per_day_human_unique FROM $t_stats_visists_per_day WHERE stats_visit_per_day_day=$this_day_lookup AND stats_visit_per_day_month=$this_month_lookup AND stats_visit_per_day_year=$this_year_lookup";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_this_stats_visit_per_day_id, $get_this_stats_visit_per_day_day, $get_this_stats_visit_per_day_day_single, $get_this_stats_visit_per_day_month_short, $get_this_stats_visit_per_day_human_unique) = $row;
	if($get_this_stats_visit_per_day_id == ""){
		$get_this_stats_visit_per_day_human_unique = 0;
	}

	// Fetch day last month
	$query = "SELECT stats_visit_per_day_id, stats_visit_per_day_day, stats_visit_per_day_day_single, stats_visit_per_day_month_short, stats_visit_per_day_human_unique FROM $t_stats_visists_per_day WHERE stats_visit_per_day_day=$last_day_lookup AND stats_visit_per_day_month=$last_month_lookup AND stats_visit_per_day_year=$last_year_lookup";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_last_stats_visit_per_day_id, $get_last_stats_visit_per_day_day, $get_last_stats_visit_per_day_day_single, $get_last_stats_visit_per_day_month_short, $get_last_stats_visit_per_day_human_unique) = $row;
	if($get_last_stats_visit_per_day_id == ""){
		$get_last_stats_visit_per_day_human_unique = 0;
	}

	if($x > 0){
		$inp_data = $inp_data . ",";
	}
	$inp_data = $inp_data . "{
			  date: new Date($this_year_lookup, $this_month_lookup, $this_day_lookup).getTime(),
			  value1: $get_this_stats_visit_per_day_human_unique,
			  value2: $get_last_stats_visit_per_day_human_unique,
			  previousDate: \"$last_year_lookup-$last_month_lookup-$last_day_lookup\"
		}";
} // for


$inp_data = $inp_data . "]";

/*- Footer ------------------------------------------------------------------------------------ */
$inp_footer = "


series.data.setAll(data);
series2.data.setAll(data);


// Make stuff animate on load
// https://www.amcharts.com/docs/v5/concepts/animations/#Forcing_appearance_animation
series.appear(1000);
series2.appear(1000);
chart.appear(1000, 100);";



/*- Write to file ----------------------------------------------------------------------------- */
if(!(is_dir("_cache"))){
	mkdir("_cache");

	$fp = fopen("_cache/index.html", "w") or die("Unable to open file!");
	fwrite($fp, "Server error 403");
	fclose($fp);

}
$fp = fopen("_cache/default_generate_visits_per_day_last_2_months_$configSecurityCodeSav.js", "w") or die("Unable to open file!");
fwrite($fp, $inp_header);
fwrite($fp, $inp_data);
fwrite($fp, $inp_footer);
fclose($fp);


?>