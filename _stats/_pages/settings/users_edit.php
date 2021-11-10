<?php
/*- Access check -------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}


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
	// User
	$inp_user_email = $_POST['inp_user_email'];
	$inp_user_email = output_html($inp_user_email);
	$inp_user_email = strtolower($inp_user_email);
	$inp_user_email_mysql = quote_smart($link, $inp_user_email);
	if($inp_user_email != "$get_current_user_email"){
		// Check if new email is taken
			
		$query = "SELECT user_id, user_email, user_name FROM $t_users WHERE user_email=$inp_user_email_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($check_user_id, $check_user_email, $check_user_name) = $row;
		if($check_user_id == ""){
			// Update email
			$result = mysqli_query($link, "UPDATE $t_users SET user_email=$inp_user_email_mysql WHERE user_id=$user_id_mysql") or die(mysqli_error($link));
			$ft = "success";
			$fm = "email_address_updated";
		}
		else{
			$ft = "warning";
			$fm = "email_alreaddy_in_use";
			$url = "index.php?open=settings&page=users_edit&user_id=$get_current_user_id&ft=$ft&fm=$fm";
			header("Location: $url");
			exit;
		}
	}
			
	$inp_user_name = $_POST['inp_user_name'];
	$inp_user_name = output_html($inp_user_name);
	$inp_user_name = strtolower($inp_user_name);
	$inp_user_name_mysql = quote_smart($link, $inp_user_name);
	if($inp_user_name != "$get_current_user_name"){
		// Check if new email is taken
			
		$query = "SELECT user_id, user_email, user_name FROM $t_users WHERE user_name=$inp_user_name_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($check_user_id, $check_user_email, $check_user_name) = $row;
		if($check_user_id == ""){
			// Update email
			$result = mysqli_query($link, "UPDATE $t_users SET user_name=$inp_user_name_mysql WHERE user_id=$user_id_mysql") or die(mysqli_error($link));
			$fm = "user_name_updated";
			$ft = "success";
		}
		else{
			if($check_user_id != "$user_id"){
				$ft = "warning";
				$fm = "user_name_already_in_use";
				$url = "index.php?open=settings&page=users_edit&user_id=$get_current_user_id&ft=$ft&fm=$fm";
				header("Location: $url");
				exit;
			}
		}
	}



	$inp_user_rank = $_POST['inp_user_rank'];
	$inp_user_rank = output_html($inp_user_rank);
	$inp_user_rank_mysql = quote_smart($link, $inp_user_rank);

	$inp_user_verified_by_moderator = $_POST['inp_user_verified_by_moderator'];
	$inp_user_verified_by_moderator = output_html($inp_user_verified_by_moderator);
	$inp_user_verified_by_moderator_mysql = quote_smart($link, $inp_user_verified_by_moderator);

		
	// Name
	$inp_user_first_name = $_POST['inp_user_first_name'];
	$inp_user_first_name = output_html($inp_user_first_name);
	$inp_user_first_name = ucwords($inp_user_first_name);
	$inp_user_first_name_mysql = quote_smart($link, $inp_user_first_name);

	$inp_user_middle_name = $_POST['inp_user_middle_name'];
	$inp_user_middle_name = output_html($inp_user_middle_name);
	$inp_user_middle_name = ucwords($inp_user_middle_name);
	$inp_user_middle_name_mysql = quote_smart($link, $inp_user_middle_name);

	$inp_user_last_name = $_POST['inp_user_last_name'];
	$inp_user_last_name = output_html($inp_user_last_name);
	$inp_user_last_name = ucwords($inp_user_last_name);
	$inp_user_last_name_mysql = quote_smart($link, $inp_user_last_name);


	// Update
	$result = mysqli_query($link, "UPDATE $t_users SET 
					user_rank=$inp_user_rank_mysql, 
					user_first_name=$inp_user_first_name_mysql, 
					user_middle_name=$inp_user_middle_name_mysql, 
					user_last_name=$inp_user_last_name_mysql, 
					user_verified_by_moderator=$inp_user_verified_by_moderator_mysql 
					WHERE user_id=$user_id_mysql") or die(mysqli_error($link));
	

	// Password
	$inp_user_password = $_POST['inp_user_password'];
	$inp_user_password = output_html($inp_user_password);
	if($inp_user_password != ""){
		$inp_user_password_salt = $inp_user_password . $inp_user_salt;
		$inp_user_password_salt_encrypted = sha1($inp_user_password_salt);
		$inp_user_password_mysql = quote_smart($link, $inp_user_password_salt_encrypted);

		// Security
		$inp_user_security = rand(0,9999);

		// Date
		$date = date("Y-m-d");

		// Create salt
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    		$charactersLength = strlen($characters);
    		$salt = '';
    		for ($i = 0; $i < 6; $i++) {
        		$salt .= $characters[rand(0, $charactersLength - 1)];
    		}
		$inp_user_salt = output_html($salt);
		$inp_user_salt_mysql = quote_smart($link, $inp_user_salt);

		$result = mysqli_query($link, "UPDATE $t_users SET 
					user_password=$inp_user_password_mysql, 
					user_password_replacement='', 
					user_password_date='$date', 
					user_salt=$inp_user_salt_mysql, 
					user_security=$inp_user_security
					WHERE user_id=$user_id_mysql") or die(mysqli_error($link));
		
		$ft = "success";
		$fm = "password_changed";
		$url = "index.php?open=settings&page=users_edit&user_id=$get_current_user_id&ft=$ft&fm=$fm";
		header("Location: $url");
		exit;
	}

	$ft = "success";
	$fm = "changes_saved";
	$url = "index.php?open=settings&page=users_edit&user_id=$get_current_user_id&ft=$ft&fm=$fm";
	header("Location: $url");
	exit;

} // process == 1
echo"
<h1>Edit user $get_current_user_name</h1>

<!-- Where am I? -->
	<p><b>You are here:</b><br />
	<a href=\"index.php?open=settings&amp;page=users&amp;editor_language=$editor_language\">Users</a>
	&gt;
	<a href=\"index.php?open=settings&amp;page=users_edit&amp;user_id=$get_current_user_id&amp;editor_language=$editor_language\">Edit user $get_current_user_name</a>
	
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

<!-- Edit user form -->
	<form method=\"POST\" action=\"index.php?open=$open&amp;page=users_edit&amp;user_id=$user_id&amp;process=1\" enctype=\"multipart/form-data\">
	
	<!-- Focus -->
		<script>
		window.onload = function() {
			document.getElementById(\"inp_user_email\").focus();
		}
		</script>
	<!-- //Focus -->

	<!-- User -->
		<h2>User</h2>
		<p>Email_address:<br />
		<input type=\"text\" name=\"inp_user_email\" id=\"inp_user_email\" size=\"25\" style=\"width: 99%;\" value=\"$get_current_user_email\" /><br />
		</p>

		<p>User name:<br />
		<input type=\"text\" name=\"inp_user_name\" size=\"25\" style=\"width: 99%;\" value=\"$get_current_user_name\" /><br />
		</p>


		<p>
		Rank:<br />
		<select name=\"inp_user_rank\">";
		if($get_my_user_rank == "admin"){
			echo"<option value=\"admin\""; if($get_current_user_rank == "admin"){ echo" selected=\"selected\""; } echo">Admin</option>\n";
			echo"<option value=\"moderator\""; if($get_current_user_rank == "moderator"){ echo" selected=\"selected\""; } echo">Moderator</option>\n";
			echo"<option value=\"user\""; if($get_current_user_rank == "user"){ echo" selected=\"selected\""; } echo">User</option>\n";
		}
		elseif($get_my_user_rank == "moderator"){
			echo"<option value=\"moderator\""; if($get_current_user_rank == "moderator"){ echo" selected=\"selected\""; } echo">Moderator</option>\n";
			echo"<option value=\"user\""; if($get_current_user_rank == "user"){ echo" selected=\"selected\""; } echo">User</option>\n";
		}
		echo"
		</select>
		</p>

		<p>
		User verified by moderator:<br />
		<select name=\"inp_user_verified_by_moderator\">
		<option value=\"\""; if($get_current_user_verified_by_moderator == ""){ echo" selected=\"selected\""; } echo">- Please select -</option>
		<option value=\"1\""; if($get_current_user_verified_by_moderator == "1"){ echo" selected=\"selected\""; } echo">Yes</option>
		<option value=\"0\""; if($get_current_user_verified_by_moderator == "0"){ echo" selected=\"selected\""; } echo">No</option>
		</select>
		</p>
	<!-- //User -->

	<!-- Name -->
		<hr />
		<h2>Name</h2>

		<p>First name:<br />
		<input type=\"text\" name=\"inp_user_first_name\" size=\"25\" style=\"width: 99%;\" value=\"$get_current_user_first_name\" />
		</p>

		<p>Middle name:<br />
		<input type=\"text\" name=\"inp_user_middle_name\" size=\"25\" style=\"width: 99%;\" value=\"$get_current_user_middle_name\" />
		</p>

		<p>Last name:<br />
		<input type=\"text\" name=\"inp_user_last_name\" size=\"25\" style=\"width: 99%;\" value=\"$get_current_user_last_name\" />
		</p>
	<!-- //Name -->


	<!-- Password -->
		<hr />
		<h2>Password</h2>

		<p>New password:<br />
		Keep blank to use existing password<br />
		<input type=\"text\" name=\"inp_user_password\" size=\"25\" style=\"width: 99%;\" value=\"\" autocomplete=\"off\" />
		</p>
	<!-- //Password -->

			
	<p>
	<input type=\"submit\" value=\"Save changes\" class=\"btn_default\" />
	</p>
	</form>
	";
?>