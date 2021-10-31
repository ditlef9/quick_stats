<?php
/*- Variables ------------------------------------------------------------------------ */
if(isset($_GET['process'])) {
	$process = $_GET['process'];
	$process = strip_tags(stripslashes($process));
}
else{
	$process = "";
}
if($process == "1"){
	// Variables
	if(isset($_POST['inp_user_email'])) {
		$inp_user_email = $_POST['inp_user_email'];
		$inp_user_email = output_html($inp_user_email);
		$inp_user_email = strtolower($inp_user_email);
		$inp_user_email_mysql = quote_smart($link, $inp_user_email);
		if(empty($inp_user_email)){
			header("Location: index.php?page=forgot_password&ft=error&fm=please_enter_your_email");
			exit;
		}
		// Validate email
		if (!filter_var($inp_user_email, FILTER_VALIDATE_EMAIL)) {
			header("Location: index.php?page=forgot_password&ft=error&fm=invalid_email_format");
			exit;
		}
	}
	else{
		header("Location: index.php?page=forgot_password&ft=error&fm=please_enter_your_email");
		exit;
	}


	// Does that e-mail exists?
	$query = "SELECT user_id, user_email, user_name, user_password, user_salt, user_security, user_language, user_registered, user_last_online, user_rank, user_points, user_likes, user_dislikes, user_status, user_login_tries, user_last_ip FROM $t_users WHERE user_email=$inp_user_email_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_user_id, $get_user_email, $get_user_name, $get_user_password, $get_user_salt, $get_user_security, $get_user_language, $get_user_registered, $get_user_last_online, $get_user_rank, $get_user_points, $get_user_likes, $get_user_dislikes, $get_user_status, $get_user_login_tries, $get_user_last_ip) = $row;

	if($get_user_id == ""){
		$ft = "warning";
		$fm = "email_not_found";
		$url ="login.php?go=forgot_password&ft=$ft&fm=$fm&l=$l"; 
		header("Location: $url");
		exit;
	}


	// Send new password
	$key = $get_user_id . $get_user_last_online . $get_user_last_ip;
	$key = md5($key);

	
	// Mail from
	$host = $_SERVER['HTTP_HOST'];
	//$from = "post@" . $_SERVER['HTTP_HOST'];
	//$reply = "post@" . $_SERVER['HTTP_HOST'];

	// Link
	$link = $configControlPanelURLSav . "/login/index.php?page=reset_password&user_id=$get_user_id&key=$key&l=en&process=1";

	// IP
	$ip = $_SERVER['REMOTE_ADDR'];
	$ip = output_html($ip);

	$to      = "$get_user_email";
	$subject = "New password for $host";
	$message = "Hello $get_user_name\n\nThis is a link where you can change your password to the control panel: $link\nIP: $ip\n\n--\n$configWebsiteWebmasterSav\n$configWebsiteTitleSav\n$configSiteURLServerNameSav";
		
	$headers = "From: $configFromEmailSav" . "\r\n" .
	    "Reply-To: $configFromEmailSav" . "\r\n" .
	    'X-Mailer: PHP/' . phpversion();
	mail($to, $subject, $message, $headers);

	$ft = "success";
	$fm = "check_your_email";
	$url ="index.php?&ft=$ft&fm=$fm"; 
	header("Location: $url");
	exit;
}

if($process == ""){
	if(isset($_GET['inp_user_email'])) {
		$inp_user_email = $_GET['inp_user_email'];
		$inp_user_email = strip_tags(stripslashes($inp_user_email));
	}
	else{
		$inp_user_email = "";
	}

	echo"
	<h1>Forgot password</h1>


	";

	if($ft != ""){
		if($fm == "please_enter_your_email"){
			$fm = "Please enter your email";
		}
		elseif($fm == "invalid_email_format"){
			$fm = "Invalid email format";
		}
		elseif($fm == "unknown_email_address"){
			$fm = "Unknown email address";
		}
		elseif($fm == "please_check_your_inbox_to_complete_the_password_change"){
			$fm = "Please check your inbox to complete the password change";
		}
		elseif($fm == "mail_command_failed"){
			$fm = "Mail command failed.";
		}
		elseif($fm == "access_denied_this_site_is_only_for_administrator_and_editors"){
			$fm = "Access_denied<br />this form is for adminstrator and moderator only";
		}
		elseif($fm == "email_not_found"){
			$fm = "Email not found";
		}
		else{
			$fm = ucfirst($ft);
		}
		echo"<div class=\"$ft\"><span>$fm</span></div>";
	}

	if($ft != "success"){
		echo"
		<!-- Focus -->
			<script>
			\$(document).ready(function(){
				\$('[name=\"inp_user_email\"]').focus();
			});
			</script>
		<!-- //Focus -->

		<form method=\"post\" action=\"index.php?page=forgot_password&amp;process=1\" enctype=\"multipart/form-data\">

		<p>Email:<br />
		<input type=\"text\" name=\"inp_user_email\" value=\"$inp_user_email\" size=\"30\" tabindex=\"1\" class=\"inp_email\" />
		</p>

		<p>
		<input type=\"submit\" value=\"Send\" class=\"inp_submit\" tabindex=\"2\" />
		</p>
		
		</form>

		<p>
		<a href=\"index.php\">Back</a>
		</p>
		";
	}
}

?>