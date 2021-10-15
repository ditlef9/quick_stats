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
			<li><a href=\"index.php?open=settings&amp;page=default\"";if($page == "settings"){echo" class=\"selected\"";}echo">Settings</a></li>
			<li><a href=\"index.php?open=settings&amp;page=users\"";if($page == "users"){echo" class=\"selected\"";}echo">Users</a></li>

";


if($page == "menu"){
	echo"
		</ul>
	</div>
	";
}
?>