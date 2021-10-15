<?php
error_reporting(E_ALL);
session_start();
ini_set('arg_separator.output', '&amp;');
/**
*
* File: _stats/liquidbase/liquidbase.php
* Version 1
* Date 11:33 15.10.2021
* Copyright (c) 2021 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/*- Admin? --------------------------------------------------------------------------- */
if(!(isset($_SESSION['admin_user_id']))){
	echo"Not logged in";	
	die;
}

/*- Functions ------------------------------------------------------------------------ */
include("../_functions/output_html.php");
include("../_functions/clean.php");
include("../_functions/quote_smart.php");

/*- Config ------------------------------------------------------------------------ */
include("../_data/meta.php");

/*- Common variables ----------------------------------------------------------------- */
$server_name = $_SERVER['HTTP_HOST'];
$server_name = clean($server_name);


/*- MySQL ---------------------------------------------------------------------------- */
$db_config_file = "../_data/db.php";
if(file_exists($db_config_file)){
	include("$db_config_file");
	$link = mysqli_connect($dbHostSav, $dbUserNameSav, $dbPasswordSav, $dbDatabaseNameSav);
	if (mysqli_connect_errno()){
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	/*- MySQL Tables -------------------------------------------------- */
	$t_admin_liquidbase		  = $dbPrefixSav . "admin_liquidbase";
}
else{
	echo"No mysql"; die;
}


/*- Variables ------------------------------------------------------------------------ */
if(isset($_GET['counter'])) {
	$counter = $_GET['counter'];
	$counter = strip_tags(stripslashes($counter));
}
else{
	$counter = "1";
}

/*- Start --------------------------------------------------------------------------- */
// Loop trough years
$path = "db_scripts";
if(!(is_dir("$path"))){
	echo"$path doesnt exists";
	die;
}
if ($handle = opendir($path)) {
	$modules = array();   
	while (false !== ($module = readdir($handle))) {
		if ($module === '.') continue;
		if ($module === '..') continue;
		array_push($modules, $module);
	}
	sort($modules);
	foreach ($modules as $module){
	
		// Open that year folder
		$path_module = "./db_scripts/$module";
		if ($handle_year = opendir($path_module)) {
			$liquidbase_names = array();   
			while (false !== ($liquidbase_name = readdir($handle_year))) {
				if ($liquidbase_name === '.') continue;
				if ($liquidbase_name === '..') continue;
				array_push($liquidbase_names, $liquidbase_name);
			}
	
			sort($liquidbase_names);
			foreach ($liquidbase_names as $liquidbase_name){


				
				if(!(is_dir("./db_scripts/$module/$liquidbase_name"))){

					// Has it been executed?
					$inp_liquidbase_module_mysql = quote_smart($link, $module);
					$inp_liquidbase_name_mysql = quote_smart($link, $liquidbase_name);
					
					$query = "SELECT liquidbase_id FROM $t_admin_liquidbase WHERE liquidbase_module=$inp_liquidbase_module_mysql AND liquidbase_name=$inp_liquidbase_name_mysql";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_liquidbase_id) = $row;
					if($get_liquidbase_id == ""){
						// Date
						$datetime = date("Y-m-d H:i:s");
						$run_saying = date("j M Y H:i");


						// Design
						echo"<!DOCTYPE html>
<html lang=\"en\">
<head>
	<title>Liquidbase</title>
	<meta name=\"viewport\" content=\"width=device-width; initial-scale=1.0;\"/>
	<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UFT-8\" />
	<link rel=\"stylesheet\" href=\"liquidbase.css\" type=\"text/css\" />
</head>
<body>
<div id=\"wrapper\">
	<div id=\"content\">

	<!-- Header -->
	<header>
		<p class=\"header_right\">$run_saying</p>
		<p>Liquidbase Database Maintenance Tool</p>
	</header>
	<!-- //Header -->

		
	<!-- Main -->
	<div id=\"main\">
		<h1><img src=\"_gfx/loading_22.gif\" alt=\"loading_22.gif\" /> $module &middot; $liquidbase_name</h1>
		<p><a href=\"liquidbase.php?counter=$counter&amp;datetime=$datetime\">Liquidbase is loading</a></p>";


						// Insert
						mysqli_query($link, "INSERT INTO $t_admin_liquidbase
						(liquidbase_id, liquidbase_module, liquidbase_name, liquidbase_run_datetime, liquidbase_run_saying) 
						VALUES 
						(NULL, $inp_liquidbase_module_mysql, $inp_liquidbase_name_mysql, '$datetime', '$run_saying')")
						or die(mysqli_error($link));

						// Run code
						include("db_scripts/$module/$liquidbase_name");

						// Refresh and load again
						$refresh_after = rand(0,1);
						echo"
	<meta http-equiv=refresh content=\"$refresh_after; url=liquidbase.php?counter=$counter&amp;last_module=$module&amp;last_name=$liquidbase_name&amp;last_datetime=$datetime\">
	</div>
	<!-- //Main -->

	<!-- Footer -->
	<footer>
		<p>
		&copy; 2021 Ditlefsen
		</p>
	</footer>
	<!-- //Footer -->

	</div> <!-- //Content -->
</div> <!-- //Wrapper -->";
						die;
					}
				} // module not dir
			} // while liquidbase name
			closedir($handle_year);
		} // handle liquidbase
	} // while years
	closedir($handle);
} // handle years


/*- Control panel - */
if($refererer_open == "" && $refererer_page == ""){
	header("Location: ../index.php");
	exit;
}
else{
	header("Location: ../index.php?open=$refererer_open&page=$refererer_page&ft=success&fm=Liquidbase_run&l=$l");
	exit;
}
?>