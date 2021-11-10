<?php
/**
*
* File: _stats/_pages/settings/menu.php
* Version 1
* Date 12:43 15.10.2021
* Copyright (c) 2021 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Access check ----------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}



if($page == "menu"){
	echo"
	<h1>Settings</h1>
	<div class=\"vertical\">
		<ul>
			<li><a href=\"index.php?open=$open\">Settings</a></li>

	";
}


echo"
			<li><a href=\"index.php?open=settings&amp;page=default&amp;editor_language=$editor_language\"";if($page == "settings"){echo" class=\"selected\"";}echo">Settings</a></li>
			<li><a href=\"index.php?open=settings&amp;page=users&amp;editor_language=$editor_language\"";if($page == "users"){echo" class=\"selected\"";}echo">Users</a></li>
			<li><a href=\"index.php?open=settings&amp;page=languages&amp;editor_language=$editor_language\"";if($page == "languages"){echo" class=\"selected\"";}echo">Languages</a></li>
			<li><a href=\"index.php?open=settings&amp;page=liquidbase&amp;editor_language=$editor_language\"";if($page == "liquidbase"){echo" class=\"selected\"";}echo">Liquidbase</a></li>
			<li><a href=\"index.php?open=settings&amp;page=ipv4_to_country&amp;editor_language=$editor_language\"";if($page == "ipv4_to_country"){echo" class=\"selected\"";}echo">IPv4 to country</a></li>
			<li><a href=\"index.php?open=settings&amp;page=ipv6_to_country&amp;editor_language=$editor_language\"";if($page == "ipv6_to_country"){echo" class=\"selected\"";}echo">IPv6 to country</a></li>


";


if($page == "menu"){
	echo"
		</ul>
	</div>
	";
}
?>