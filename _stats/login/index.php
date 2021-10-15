<?php
session_start();
ini_set('arg_separator.output', '&amp;');
/**
*
* File: _stats/login/index.php
* Version 1.0
* Date 13:42 15.10.2021
* Copyright (c) 2021 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/*- Functions ------------------------------------------------------------------------ */
include("../_functions/output_html.php");
include("../_functions/clean.php");
include("../_functions/quote_smart.php");


/*- Website config --------------------------------------------------------------------------- */
if(file_exists("../_data/meta.php")){
	include("../_data/meta.php");
}

/*- Check if setup is run ------------------------------------------------------------ */
$server_name = $_SERVER['HTTP_HOST'];
$server_name = clean($server_name);
$setup_finished_file = "setup_finished.php";
if(!(file_exists("../_data/$setup_finished_file"))){
	header("Location: ../setup/");
	exit;
}

/*- MySQL ---------------------------------------------------------------------------- */
$db_config_file = "../_data/db.php";
if(file_exists($db_config_file)){
	include("$db_config_file");
	$link = mysqli_connect($dbHostSav, $dbUserNameSav, $dbPasswordSav, $dbDatabaseNameSav);
	if (mysqli_connect_errno()){
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	/*- MySQL Tables -------------------------------------------------- */
	$t_admin_liquidbase	= $dbPrefixSav . "admin_liquidbase";

	$t_users		= $dbPrefixSav . "users";
	$t_users_known_devices 	= $dbPrefixSav . "users_known_devices";
	$t_users_logins 	= $dbPrefixSav . "users_logins";

	$t_stats_ip_to_country_lookup = $dbPrefixSav . "stats_ip_to_country_lookup";
}
else{
	echo"No mysql"; die;
}

/*- Variables ------------------------------------------------------------------------ */
if(isset($_GET['page'])) {
	$page = $_GET['page'];
	$page = strip_tags(stripslashes($page));
}
else{
	$page = "";
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
if(isset($_GET['action'])) {
	$action = $_GET['action'];
	$action = strip_tags(stripslashes($action));
}
else{
	$action = "";
}


/*- My variables ------------------------------------------------------------------------------- */

// Me
$my_user_agent = $_SERVER['HTTP_USER_AGENT'];
$my_user_agent = output_html($my_user_agent);
$my_user_agent_mysql = quote_smart($link, $my_user_agent);

$my_ip = $_SERVER['REMOTE_ADDR'];
$my_ip = output_html($my_ip);
$my_ip_mysql = quote_smart($link, $my_ip);

$my_hostname = "$my_ip";
if($configStatsUseGethostbyaddrSav == "1"){
	$my_hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']); // Some servers in local network cant use getostbyaddr because of nameserver missing
}
$my_hostname = output_html($my_hostname);
$my_hostname_mysql = quote_smart($link, $my_hostname);

/*- Design ---------------------------------------------------------------------------- */
if($process != "1"){
echo"<!DOCTYPE html>
<html lang=\"en\">
<head>
	<title>";
	if($page != ""){
		$page_saying = ucfirst($page);
		$page_saying = str_replace("_", " ", $page_saying);
		echo"$page_saying - ";
	}
	echo"Quick Stats</title>

	<!-- Favicon -->
		<link rel=\"icon\" href=\"../_layout/favicon/stats_16x16.png\" type=\"image/png\" sizes=\"16x16\" />
		<link rel=\"icon\" href=\"../_layout/favicon/stats_32x32.png\" type=\"image/png\" sizes=\"32x32\" />
		<link rel=\"icon\" href=\"../_layout/favicon/stats_256x256.png\" type=\"image/png\" sizes=\"256x256\" />
	<!-- //Favicon -->

	<meta name=\"viewport\" content=\"width=device-width; initial-scale=1.0;\"/>
	<link rel=\"stylesheet\" href=\"_login_design/login.css?datetime="; $datetime = date("Y-m-d His"); echo"$datetime\" type=\"text/css\" />
	<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UFT-8\" />


</head>
<body>
<div class=\"body_bg\">
	<div class=\"wrapper\">
		<!-- Header -->
			<header>
				<p>Quick <span>Stats</span></p>
			</header>
		<!-- //Header -->

		
		<!-- Main -->
			<div id=\"main\">
			<!-- Page -->
			";
} // process
			if($page != ""){
				if (preg_match('/(http:\/\/|^\/|\.+?\/)/', $page)){
					echo"Server error 403";
				}
				else{
					if(file_exists("_login_pages/$page.php")){
						include("_login_pages/$page.php");
					}
					else{
						echo"Server error 404";
					}
				}
			}
			else{
				include("_login_pages/login.php");
			}
if($process != "1"){
			echo"
			<!-- //Page -->
			</div>
		<!-- //Main -->

		<!-- Footer -->
			<footer>
				<p>
				&copy; 2021 Ditlefsen
				</p>
			</footer>
		<!-- //Footer -->

	</div> <!-- //wrapper-->
</div> <!-- //body_bg -->

</body>
</html>";

} // process
?>