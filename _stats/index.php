<?php
error_reporting(E_ALL);
session_start();
ini_set('arg_separator.output', '&amp;');
/**
*
* File: _stats/index.php
* Version 1.0.0
* Date 09:46 15.10.2021
* Copyright (c) 2021 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/*- Functions ------------------------------------------------------------------------ */
include("_functions/clean.php");
include("_functions/output_html.php");
include("_functions/quote_smart.php");

/*- Check if setup is run ------------------------------------------------------------ */
if(!(file_exists("_data/setup_finished.php"))){
	header("Location: setup/");
	exit;
}

/*- Variables ------------------------------------------------------------------------ */
if(isset($_GET['open'])) {
	$open = $_GET['open'];
	$open = strip_tags(stripslashes($open));
}
else{
	$open = "dashboard";
}
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


/*- MySQL ---------------------------------------------------------------------------- */
$db_config_file = "_data/db.php";
if(file_exists($db_config_file)){
	include("$db_config_file");
	$link = mysqli_connect($dbHostSav, $dbUserNameSav, $dbPasswordSav, $dbDatabaseNameSav);
	if (mysqli_connect_errno()){
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	/*- MySQL Tables -------------------------------------------------- */
	$t_admin_liquidbase	= $dbPrefixSav . "admin_liquidbase";
	$t_users		= $dbPrefixSav . "users";
}
else{
	echo"No mysql"; die;
}

include("_data/meta.php");

/*- Include user ---------------------------------------------------------------------- */
$my_user_id = $_SESSION['adm_user_id'];
$my_user_id = output_html($my_user_id);
$my_user_id_mysql = quote_smart($link, $my_user_id);

$my_security = $_SESSION['adm_security'];
$my_security = output_html($my_security);
$my_security_mysql = quote_smart($link, $my_security);

$query = "SELECT user_id, user_email, user_name, user_password, user_password_replacement, user_password_date, user_salt, user_security, user_rank, user_verified_by_moderator, user_first_name, user_middle_name, user_last_name, user_login_tries, user_last_online, user_last_online_time, user_last_ip, user_notes, user_marked_as_spammer FROM $t_users WHERE user_id=$my_user_id_mysql AND user_security=$my_security_mysql";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_my_user_id, $get_my_user_email, $get_my_user_name, $get_my_user_password, $get_my_user_password_replacement, $get_my_user_password_date, $get_my_user_salt, $get_my_user_security, $get_my_user_rank, $get_my_user_verified_by_moderator, $get_my_user_first_name, $get_my_user_middle_name, $get_my_user_last_name, $get_my_user_login_tries, $get_my_user_last_online, $get_my_user_last_online_time, $get_my_user_last_ip, $get_my_user_notes, $get_my_user_marked_as_spammer) = $row;
if($get_my_user_id == ""){
	$url = "login/index.php?ft=info&fm=please_login_to_the_control_panel";
	header("Location: $url");
	exit;
}
else{
	if($get_my_user_rank == "admin" OR $get_my_user_rank == "moderator"){
		// Access OK!
		$define_access_to_control_panel = 1;
	}
	else{
		echo"<h1>Server error 403</h1><p>Access denied!</p><p>Only administrator and moderator can access the control panel.</p>";die;
	}
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
		<link rel=\"icon\" href=\"_layout/favicon/stats_16x16.png\" type=\"image/png\" sizes=\"16x16\" />
		<link rel=\"icon\" href=\"_layout/favicon/stats_32x32.png\" type=\"image/png\" sizes=\"32x32\" />
		<link rel=\"icon\" href=\"_layout/favicon/stats_256x256.png\" type=\"image/png\" sizes=\"256x256\" />
	<!-- //Favicon -->

	<meta name=\"viewport\" content=\"width=device-width; initial-scale=1.0;\"/>
	<link rel=\"stylesheet\" href=\"_layout/layout.css?date="; echo date("ymdhis"); echo"\" type=\"text/css\" />
	<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UFT-8\" />
</head>
<body>

<!-- Header -->
	<header>
		<!-- Logo -->
			<div id=\"logo\">
				<a href=\"index.php\">QuickStats</a>
			</div>
		<!-- //Logo -->

	
		<!-- Header navigation -->
			<nav>
				<ul>

					<li";if($open == "stats"){echo" class=\"main_navigation_has_sub_li_active\"";}echo">
						<a href=\"index.php?open=stats\"";if($open == "stats"){echo" class=\"main_navigation_has_sub_a_active\"";}echo"><img src=\"_pages/stats/_gfx/icons/stats_white_18.png\" alt=\"stats_white_18.png\" /> Stats</a> <img src=\"_layout/gfx/main_navigation/main_navigation_has_sub_grey.png\" alt=\"main_navigation_has_sub.png\"  class=\"main_navigation_has_sub toggle\" data-divid=\"display_main_navigation_sub_stats\" />
						<ul class=\"main_navigation_sub display_main_navigation_sub_dashboard\"";if($open == "stats"){echo" style=\"display:block;\"";}echo">\n";
							include("_pages/stats/menu.php");
							echo"
						</ul>
					</li>

					<li";if($open == "settings"){echo" class=\"main_navigation_has_sub_li_active\"";}echo">
						<a href=\"index.php?open=settings\"";if($open == "settings"){echo" class=\"main_navigation_has_sub_a_active\"";}echo"><img src=\"_pages/settings/_gfx/icons/settings_white_18.png\" alt=\"settings_white_18.png\" /> Settings</a> <img src=\"_layout/gfx/main_navigation/main_navigation_has_sub_grey.png\" alt=\"main_navigation_has_sub.png\"  class=\"main_navigation_has_sub toggle\" data-divid=\"display_main_navigation_sub_settings\" />
						<ul class=\"main_navigation_sub display_main_navigation_sub_dashboard\"";if($open == "settings"){echo" style=\"display:block;\"";}echo">\n";
							include("_pages/settings/menu.php");
							echo"
						</ul>
					</li>
				</ul>
			</nav>

		<!-- //Header navigation -->
	</header>



<!-- //Header -->

<!-- Main -->
	<main>
		<div class=\"main_inner\">
		<!-- Includes -->
		";
} // process != 1
			if($open == "" && $page == ""){
				include("_pages/stats/default.php");
			}
			else{
				if($open != "" && $page == ""){
					if (preg_match('/(http:\/\/|^\/|\.+?\/)/', $open)){
						echo"
						<h1>Advarsel</h1>
						<p>Adressen du oppga er ikke gyldig.</p>
						";
					}
					else{
						if(file_exists("_pages/$open/default.php")){
							include("_pages/$open/default.php");
						}
						else{
							echo"
							<h1>Server error 404</h1>
							<p>Flatfilen _pages/$open/default.php finnes ikke på serveren.</p>
							";
						}
					}
				} // end if
				elseif($open != "" && $page != ""){
					if (preg_match('/(http:\/\/|^\/|\.+?\/)/', $open)){
						echo"
						<h1>Advarsel</h1>
						<p>Adressen du oppga er ikke gyldig.</p>
						";
					}
					else{
						if (preg_match('/(http:\/\/|^\/|\.+?\/)/', $page)){
							echo"
							<h1>Advarsel</h1>
							<p>Adressen du oppga er ikke gyldig.</p>
							";
						}
						else{
							if(file_exists("_pages/$open/$page.php")){
								include("_pages/$open/$page.php");
							}
							else{
								echo"
								<h1>Server error 404</h1>
								<p>Flatfilen _pages/$open/$page.php finnes ikke på serveren.</p>
								";
							}
						}
					}
				} // end elseif
				elseif($open == "" && $page != ""){
					echo"
					<h1>Advarsel</h1>
					<p>Mangler variabel open.</p>
					";
				} // end elseif

			} // end else
			if($process != ""){
			echo"
			<!-- //Includes -->
		</div>
	</main>
<!-- //Main -->


</body>
</html>";

} // process
?>