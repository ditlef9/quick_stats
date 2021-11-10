<?php
/*- Access check -------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}

/*- MySQL Tables -------------------------------------------------- */
$t_users		= $dbPrefixSav . "users";
$t_users_known_devices 	= $dbPrefixSav . "users_known_devices";
$t_users_logins 	= $dbPrefixSav . "users_logins";

/*- Varialbes  ---------------------------------------------------- */
if(isset($_GET['user_id'])) {
	$user_id = $_GET['user_id'];
	$user_id = strip_tags(stripslashes($user_id));
	if(!(is_numeric($user_id))){
		echo"User id not numeric";
		die;
	}
}
else{
	echo"Missing user id";
	die;
}
// Get user
$user_id_mysql = quote_smart($link, $user_id);
$query = "SELECT user_id, user_email, user_name, user_password, user_password_replacement, user_password_date, user_salt, user_security, user_rank, user_verified_by_moderator, user_first_name, user_middle_name, user_last_name, user_login_tries, user_last_online, user_last_online_time, user_last_ip, user_notes, user_marked_as_spammer FROM $t_users WHERE user_id=$user_id_mysql";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_current_user_id, $get_current_user_email, $get_current_user_name, $get_current_user_password, $get_current_user_password_replacement, $get_current_user_password_date, $get_current_user_salt, $get_current_user_security, $get_current_user_rank, $get_current_user_verified_by_moderator, $get_current_user_first_name, $get_current_user_middle_name, $get_current_user_last_name, $get_current_user_login_tries, $get_current_user_last_online, $get_current_user_last_online_time, $get_current_user_last_ip, $get_current_user_notes, $get_current_user_marked_as_spammer) = $row;

if($get_current_user_id == ""){
	echo"<h1>Error</h1><p>Error with user id.</p>"; 
	die;
}



// Can I edit?
if($get_my_user_rank != "moderator" && $get_my_user_rank != "admin"){
	echo"
	<h1>Server error 403</h1>
	<p>Your rank is $get_my_user_rank. You can not edit.</p>
	";
	die;
}
if($process == "1"){
	
	$result = mysqli_query($link, "DELETE FROM $t_users WHERE user_id=$user_id_mysql") or die(mysqli_error($link));
	$result = mysqli_query($link, "DELETE FROM $t_users_known_devices WHERE known_device_user_id=$user_id_mysql") or die(mysqli_error($link));
	$result = mysqli_query($link, "DELETE FROM $t_users_logins WHERE login_user_id=$user_id_mysql") or die(mysqli_error($link));
	

	$ft = "success";
	$fm = "user_deleted";
	$url = "index.php?open=settings&page=users&ft=$ft&fm=$fm";
	header("Location: $url");
	exit;

} // process == 1
echo"
<h1>Delete user $get_current_user_name</h1>

<!-- Where am I? -->
	<p><b>You are here:</b><br />
	<a href=\"index.php?open=settings&amp;page=users&amp;editor_language=$editor_language\">Users</a>
	&gt;
	<a href=\"index.php?open=settings&amp;page=users_delete&amp;user_id=$get_current_user_id&amp;editor_language=$editor_language\">Delete user $get_current_user_name</a>
	
	</p>
<!-- //Where am I? -->
<!-- Feedback -->
	";
	if($ft != "" && $fm != ""){
		$fm = str_replace("_", " ", $fm);
		$fm = ucfirst($fm);
		echo"<div class=\"$ft\"><p>$fm</p></div>";
	}
	echo"
<!-- //Feedback -->

<!-- Delete user form -->
	<p>
	Are you sure you want to delete the user?
	</p>

	<p>
	<a href=\"index.php?open=$open&amp;page=users_delete&amp;user_id=$user_id&amp;editor_language=$editor_language&amp;process=1\" class=\"btn_danger\">Confirm</a>
	</p>
<!-- //Delete user form -->
";
?>