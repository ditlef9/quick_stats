<?php
/**
*
* File: _stats/_pages/stats/menu.php
* Version 1
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
	<h1>Stats</h1>
	<div class=\"vertical\">
		<ul>
			<li><a href=\"index.php?open=$open\">Stats</a></li>

	";
}


echo"
			<li><a href=\"index.php?open=dashboard&amp;page=default\"";if($page == "stats"){echo" class=\"selected\"";}echo">Stats</a></li>
			<li><a href=\"index.php?open=dashboard&amp;page=user_agents\"";if($page == "user_agents"){echo" class=\"selected\"";}echo">User agents</a></li>

";


if($page == "menu"){
	echo"
		</ul>
	</div>
	";
}
?>