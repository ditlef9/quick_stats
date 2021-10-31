<?php
/**
*
* File: _stats/_pages/logout/default.php
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


/*- Log out -------------------------------------------------------------------------- */
// Unset all of the session variables.
$_SESSION = array();
	
// Finally, destroy the session.
session_destroy();

if($process == "1"){
	header("Location: login/index.php?ft=info&fm=good_bye");
	exit;
}


?>