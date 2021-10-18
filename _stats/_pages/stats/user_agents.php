<?php
/**
*
* File: _admin/_inc/user_agents.php
* Version 2
* Date 20:54 27.04.2019
* Copyright (c) 2021 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Access check ----------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}

/*- Language -------------------------------------------------------------------------- */
include("_translations/admin/$l/dashboard/t_unknown_agents.php");


/*- Tables ------------------------------------------------------------------------ */
$t_stats_user_agents_index = $mysqlPrefixSav . "stats_user_agents_index";

/*- Variables -------------------------------------------------------------------------- */
if(isset($_GET['user_agent_id'])) {
	$user_agent_id = $_GET['user_agent_id'];
	$user_agent_id = strip_tags(stripslashes($user_agent_id));
}
else{
	$user_agent_id = "";
}

/*- Variables -------------------------------------------------------------------------- */
if($action == ""){
	echo"

	<h1>User Agents</h1>
	
	<!-- Feedback -->
		";
		if($ft != ""){
			if($fm == "changes_saved"){
				$fm = "$l_changes_saved";
			}
			else{
				$fm = ucfirst($fm);
			}
			echo"<div class=\"$ft\"><span>$fm</span></div>";
		}
		echo"	
	<!-- //Feedback -->

	<!-- Buttons -->
		<p>
		<a href=\"index.php?open=dashboard&amp;page=user_agents_export&amp;editor_language=$editor_language&amp;l=$l\" class=\"btn_default\">Export</a>
		</p>
	<!-- //Buttons -->

	<!-- User agents -->

		<table class=\"hor-zebra\">
		 <thead>
		  <tr>
		   <th scope=\"col\">
			<span><b>Agent</b></span>
		   </td>
		   <th scope=\"col\">
			<span><b>Browser</b></span>
		   </td>
		   <th scope=\"col\">
			<span><b>OS</b></span>
		   </td>
		   <th scope=\"col\">
			<span><b>Bot</b></span>
		   </td>
		   <th scope=\"col\">
			<span><b>Action</b></span>
		   </td>
		  </tr>
		 </thead>";
		$query = "SELECT stats_user_agent_id, stats_user_agent_string, stats_user_agent_type, stats_user_agent_browser, stats_user_agent_browser_version, stats_user_agent_browser_icon, stats_user_agent_os, stats_user_agent_os_version, stats_user_agent_os_icon, stats_user_agent_bot, stats_user_agent_bot_icon, stats_user_agent_bot_website, stats_user_agent_banned FROM $t_stats_user_agents_index ORDER BY stats_user_agent_string ASC";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_stats_user_agent_id, $get_stats_user_agent_string, $get_stats_user_agent_type, $get_stats_user_agent_browser, $get_stats_user_agent_browser_version, $get_stats_user_agent_browser_icon, $get_stats_user_agent_os, $get_stats_user_agent_os_version, $get_stats_user_agent_os_icon, $get_stats_user_agent_bot, $get_stats_user_agent_bot_icon, $get_stats_user_agent_bot_website, $get_stats_user_agent_banned) = $row;

			// Style
			if(isset($style) && $style == ""){
				$style = "odd";
			}
			else{
				$style = "";
			}
			
			// Look for problems
			if($get_stats_user_agent_type == "desktop" OR $get_stats_user_agent_type == "mobile"){
				if($get_stats_user_agent_browser_version == "" OR $get_stats_user_agent_os_version == ""){
					$style = "danger";
				}
			}
				
		
			echo"
			 <tr>
			  <td class=\"$style\">
				<a id=\"#user_agent$get_stats_user_agent_id\"></a>
				<span>$get_stats_user_agent_string</span>
			  </td>
			  <td class=\"$style\">
				<span>$get_stats_user_agent_browser $get_stats_user_agent_browser_version</span>
			  </td>
			  <td class=\"$style\">
				<span>$get_stats_user_agent_os $get_stats_user_agent_os_version</span>
			  </td>
			  <td class=\"$style\">
				<span>$get_stats_user_agent_bot</span>
			  </td>
			  <td class=\"$style\">
				<span>
				<a href=\"index.php?open=$open&amp;page=$page&amp;action=edit_user_agent&amp;user_agent_id=$get_stats_user_agent_id&amp;l=$l&amp;editor_language=$editor_language\">Edit</a>
				</span>
			  </td>
			 </tr>";

		}

			echo"
			</table>
		  </td>
		 </tr>
		</table>
	<!-- //IPs -->
	";
}
elseif($action == "edit_user_agent"){
	// Find user agent
	$user_agent_id_mysql = quote_smart($link, $user_agent_id);
	$query = "SELECT stats_user_agent_id, stats_user_agent_string, stats_user_agent_type, stats_user_agent_browser, stats_user_agent_browser_version, stats_user_agent_browser_icon, stats_user_agent_os, stats_user_agent_os_version, stats_user_agent_os_icon, stats_user_agent_bot, stats_user_agent_bot_version, stats_user_agent_bot_icon, stats_user_agent_bot_website, stats_user_agent_banned FROM $t_stats_user_agents_index WHERE stats_user_agent_id=$user_agent_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_stats_user_agent_id, $get_current_stats_user_agent_string, $get_current_stats_user_agent_type, $get_current_stats_user_agent_browser, $get_current_stats_user_agent_browser_version, $get_current_stats_user_agent_browser_icon, $get_current_stats_user_agent_os, $get_current_stats_user_agent_os_version, $get_current_stats_user_agent_os_icon, $get_current_stats_user_agent_bot, $get_current_stats_user_agent_bot_version, $get_current_stats_user_agent_bot_icon, $get_current_stats_user_agent_bot_website, $get_current_stats_user_agent_banned) = $row;

	if($get_current_stats_user_agent_id == ""){
		echo"
		<h1>User agent not found</h1>
		";
	}
	else{
		if($process == "1"){
					$inp_browser = $_POST['inp_browser'];
		$inp_browser = output_html($inp_browser);
		$inp_browser_mysql = quote_smart($link, $inp_browser);
		
		$inp_browser_icon = "";
		if($inp_browser != ""){
			$inp_browser_icon = strtolower($inp_browser);
			$inp_browser_icon = clean($inp_browser_icon);
			$inp_browser_icon = $inp_browser_icon . ".png";
		}
		$inp_browser_icon_mysql = quote_smart($link, $inp_browser_icon);
		
		$inp_browser_version = $_POST['inp_browser_version'];
		$inp_browser_version = output_html($inp_browser_version);
		$inp_browser_version_mysql = quote_smart($link, $inp_browser_version);

		$inp_os = $_POST['inp_os'];
		$inp_os = output_html($inp_os);
		$inp_os_mysql = quote_smart($link, $inp_os);
		
		$inp_os_icon = "";
		if($inp_os != ""){
			$inp_os_icon = strtolower($inp_os);
			$inp_os_icon = clean($inp_os_icon);
			$inp_os_icon = $inp_os_icon . ".png";
		}
		$inp_os_icon_mysql = quote_smart($link, $inp_os_icon);

		$inp_os_version = $_POST['inp_os_version'];
		$inp_os_version = output_html($inp_os_version);
		$inp_os_version_mysql = quote_smart($link, $inp_os_version);
		
		
		$inp_bot = $_POST['inp_bot'];
		$inp_bot = output_html($inp_bot);
		$inp_bot_mysql = quote_smart($link, $inp_bot);
		
		$inp_bot_icon = "";
		if($inp_bot != ""){
			$inp_bot_icon = strtolower($inp_bot);
			$inp_bot_icon = clean($inp_bot_icon);
			$inp_bot_icon = $inp_bot_icon . ".png";
		}
		$inp_bot_icon_mysql = quote_smart($link, $inp_bot_icon);
		
		$inp_bot_version = $_POST['inp_bot_version'];
		$inp_bot_version = output_html($inp_bot_version);
		$inp_bot_version_mysql = quote_smart($link, $inp_bot_version);

		$inp_type = $_POST['inp_type'];
		$inp_type = output_html($inp_type);
		$inp_type_mysql = quote_smart($link, $inp_type);
		
		if(isset($_POST['inp_banned'])){
			$inp_banned = $_POST['inp_banned'];
			
		}
		else{
			$inp_banned = 0;
		}
		$inp_banned = output_html($inp_banned);
		$inp_banned_mysql = quote_smart($link, $inp_banned);
		
		
		$result = mysqli_query($link, "UPDATE $t_stats_user_agents_index SET 
						stats_user_agent_browser=$inp_browser_mysql, 
						stats_user_agent_browser_version=$inp_browser_version_mysql, 
						stats_user_agent_os=$inp_os_mysql, 
						stats_user_agent_os_version=$inp_os_version_mysql, 
						stats_user_agent_bot=$inp_bot_mysql, 
						stats_user_agent_bot_version=$inp_bot_version_mysql, 
				stats_user_agent_browser_icon=$inp_browser_icon_mysql, stats_user_agent_os_icon=$inp_os_icon_mysql, 
				stats_user_agent_bot_icon=$inp_bot_icon_mysql, stats_user_agent_type=$inp_type_mysql, stats_user_agent_banned=$inp_banned_mysql 
				WHERE stats_user_agent_id=$get_current_stats_user_agent_id") or die(mysqli_error($link));

		// echo"UPDATE $t_stats_user_agents SET stats_user_agent_browser=$inp_browser_mysql, stats_user_agent_os=$inp_os_mysql, stats_user_agent_bot=$inp_bot_mysql, 
		// stats_user_agent_url=$inp_url_mysql, stats_user_agent_browser_icon=$inp_browser_icon_mysql, stats_user_agent_os_icon=$inp_os_icon_mysql, 
		// stats_user_agent_bot_icon=$inp_bot_icon_mysql, stats_user_agent_type=$inp_type_mysql, stats_user_agent_banned=$inp_banned_mysql WHERE stats_user_agent_id=$stats_user_agent_id_mysql";
		
		
			header("Location: index.php?open=dashboard&page=$page&editor_language=$editor_language&l=$l&ft=success&fm=changes_saved#user_agent$get_current_stats_user_agent_id");
			exit;
		}
		echo"
		<h1>$get_current_stats_user_agent_string</h1>

		<!-- Focus -->
			<script>
			\$(document).ready(function(){
				\$('[name=\"inp_browser\"]').focus();
			});
			</script>
		<!-- //Focus -->
	
		<form method=\"post\" action=\"index.php?open=$open&amp;page=$page&amp;action=edit_user_agent&amp;editor_language=$editor_language&amp;user_agent_id=$get_current_stats_user_agent_id&amp;process=1\" enctype=\"multipart/form-data\">

		<p>
		<b>$l_id</b><br />
		$get_current_stats_user_agent_id</p>

		<p>
		<b>$l_agent</b><br />
		<a href=\"https://www.google.com/search?q=$get_current_stats_user_agent_string\">$get_current_stats_user_agent_string</a></p>
		
		<p><b>$l_browser</b><br />
		<input type=\"text\" name=\"inp_browser\" size=\"20\" value=\"$get_current_stats_user_agent_browser\" /></p>
		
		<p><b>$l_browser version</b><br />
		<input type=\"text\" name=\"inp_browser_version\" size=\"20\" value=\"$get_current_stats_user_agent_browser_version\" /></p>
		
		<p><b>$l_os</b><br />
		<input type=\"text\" name=\"inp_os\" size=\"20\" value=\"$get_current_stats_user_agent_os\" /></p>
		
		<p><b>$l_os version</b><br />
		<input type=\"text\" name=\"inp_os_version\" size=\"20\" value=\"$get_current_stats_user_agent_os_version\" /></p>
		<p><b>$l_bot</b><br />
		<input type=\"text\" name=\"inp_bot\" size=\"20\" value=\"$get_current_stats_user_agent_bot\" /></p>
		<p><b>$l_bot version</b><br />
		<input type=\"text\" name=\"inp_bot_version\" size=\"20\" value=\"$get_current_stats_user_agent_bot_version\" /></p>
		
		<p><b>$l_type</b><br />
		<select name=\"inp_type\">
			<option value=\"bot\""; if($get_current_stats_user_agent_type == "bot"){ echo" selected=\"selected\""; } echo">bot</option>
			<option value=\"desktop\""; if($get_current_stats_user_agent_type == "desktop"){ echo" selected=\"selected\""; } echo">desktop</option>
			<option value=\"mobile\""; if($get_current_stats_user_agent_type == "mobile"){ echo" selected=\"selected\""; } echo">mobile</option>
			<option value=\"unknown\""; if($get_current_stats_user_agent_type == "unknown"){ echo" selected=\"selected\""; } echo">unknown</option>
		</select>
		</p>
		
		<p><b>$l_banned</b><br />
		<input type=\"checkbox\" name=\"inp_banned\""; if($get_current_stats_user_agent_banned == "1"){ echo" checked=\"checked\""; } echo" value=\"1\" />
		</p>
		
		<p><input type=\"submit\" value=\"$l_save\" class=\"submit\" /></p>

		";

	} // found
} // edit_user_agent
?>