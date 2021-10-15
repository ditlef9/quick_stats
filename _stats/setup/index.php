<?php
error_reporting(E_ALL & ~E_STRICT);
session_start();
ini_set('arg_separator.output', '&amp;');
/**
*
* File: _stats/setup/index.php
* Version 1
* Date 10:14 15.10.2021
* Copyright (c) 2021 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/*- Functions ------------------------------------------------------------------------ */
include("../_functions/clean.php");
include("../_functions/output_html.php");
include("../_functions/quote_smart.php");

/*- Check if setup is finished ------------------------------------------------------ */
if(file_exists("../_data/setup_finished.php")){
	header("Location: ../index.php?ft=warning&fm=setup_is_finished");
	exit;
}



// Config file ------------------------------------------------------------------------ */
// (temporary)
if(file_exists("../_data/setup_data.php")){
	include("../_data/setup_data.php");
}

/*- Variables ------------------------------------------------------------------------ */
if(isset($_GET['page'])) {
	$page = $_GET['page'];
	$page = strip_tags(stripslashes($page));
}
else{
	// Go to start
	$page = "0_start";
}
if(isset($_GET['process'])) {
	$process = $_GET['process'];
	$process = strip_tags(stripslashes($process));
}
else{
	$process = "";
}
if(isset($_GET['ft'])) {
	$ft = $_GET['ft'];
	$ft = strip_tags(stripslashes($ft));
	if($ft != "error" && $ft != "warning" && $ft != "success" && $ft != "info"){
		echo"Server error 403 feedback error";die;
	}
}
else{
	$ft = "";
}
if(isset($_GET['fm'])) {
	$fm = $_GET['fm'];
	$fm = strip_tags(stripslashes($fm));
}


/*- Design ---------------------------------------------------------------------------- */
if($process != "1"){
echo"<!DOCTYPE html>
<html lang=\"en\">
<head>
	<title>";
	if($page != ""){
		$page_saying = ucfirst($page);
		echo"$page_saying - ";
	}
	echo"Quick Stats";
	echo"</title>

	<!-- Favicon -->
		<link rel=\"icon\" href=\"../_layout/favicon/stats_16x16.png\" type=\"image/png\" sizes=\"16x16\" />
		<link rel=\"icon\" href=\"../_layout/favicon/stats_32x32.png\" type=\"image/png\" sizes=\"32x32\" />
		<link rel=\"icon\" href=\"../_layout/favicon/stats_256x256.png\" type=\"image/png\" sizes=\"256x256\" />
	<!-- //Favicon -->

	<meta name=\"viewport\" content=\"width=device-width; initial-scale=1.0;\"/>
	<link rel=\"stylesheet\" href=\"_setup_design/setup.css?date="; echo date("ymdhis"); echo"\" type=\"text/css\" />
	<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UFT-8\" />
</head>
<body>

<!-- Wrapper -->
<div id=\"wrapper\">
	
	<!-- Wrapper -->
	<div id=\"wrapper\">
	

		<!-- Header -->
			<header>
				<p>
				Quick <span>Stats</span> 
				</p>
			</header>
		<!-- //Header -->


		<!-- Main -->
			<div id=\"main\">

			<!-- Navigation -->
				<div id=\"navigation\">
					<ul>
						<li><span"; if($page == "1_license"){ echo" class=\"active\" "; } echo">1. License</span></li>
						<li><span"; if($page == "2_chmod"){ echo" class=\"active\" "; } echo">2. Chmod</span></li>
						<li><span"; if($page == "3_database"){ echo" class=\"active\" "; } echo">3. Database</span></li>
						<li><span"; if($page == "4_administrator"){ echo" class=\"active\" "; } echo">4. Administrator</span></li>
					</ul>
				</div>
			<!-- //Navigation -->

			<!-- Content -->
				<div id=\"content\">
					<!-- Page -->
					";
} // process
					if($page != ""){

						if (preg_match('/(http:\/\/|^\/|\.+?\/)/', $page)){
							echo"Server error 403";
						}
						else{
							if(file_exists("_setup_pages/$page.php")){
								include("_setup_pages/$page.php");
							}
							else{
								echo"Server error 404, page not found";
							}
						}
					}
					else{
						include("_setup_pages/01_select_language.php");
					}
if($process != "1"){
					echo"
					<!-- //Page -->
				</div>
			<!-- //Content -->
		</div>
		<!-- //Main -->

</div> <!--// Wrapper -->
</body>
</html>";

} // process
?>