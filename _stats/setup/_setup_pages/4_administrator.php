<?php
/*- Check if setup is finished ------------------------------------------------------ */
if(file_exists("../_data/setup_finished.php")){
	echo"<p>Setup is finished.</p>";
	die;
}


if($process == "1"){
	// Administrator
	$inp_user_email = $_POST['inp_user_email'];
	$inp_user_email = output_html($inp_user_email);

	$inp_user_password = $_POST['inp_user_password'];
	$inp_user_password = output_html($inp_user_password);
	$inp_user_password = sha1($inp_user_password);

		
	if(empty($inp_user_email)){
		$ft = "warning";
		$fm = "please_enter_your_email_address";
		$url = "index.php?page=06_administrator&language=$language&ft=$ft&fm=$fm";
		header("Location: $url");
		exit;
	}
	if(empty($inp_user_password)){
		$ft = "warning";
		$fm = "please_enter_your_password";
		$url = "index.php?page=06_administrator&language=$language&ft=$ft&fm=$fm";
		header("Location: $url");
		exit;
	}


	// Write file
	$update_file="<?php
// Database
\$dbHostSav   		= \"$dbHostSav\";
\$dbUserNameSav   	= \"$dbUserNameSav\";
\$dbPasswordSav		= \"$dbPasswordSav\";
\$dbDatabaseNameSav 	= \"$dbDatabaseNameSav\";
\$dbPrefixSav 		= \"$dbPrefixSav\";


// General
\$configStatsTitleSav		 = \"$configStatsTitleSav\";
\$configStatsTitleCleanSav	 = \"$configStatsTitleCleanSav\";
\$configFromEmailSav 		 = \"$configFromEmailSav\";
\$configFromNameSav 		 = \"$configFromNameSav\";

\$configMailSendActiveSav	= \"$configMailSendActiveSav\";

// URLs
\$configStatsURLSav 		= \"$configStatsURLSav\";
\$configStatsRLLenSav 		= \"$configStatsRLLenSav\";
\$configStatsURLSchemeSav	= \"$configStatsURLSchemeSav\";
\$configStatsURLHostSav		= \"$configStatsURLHostSav\";
\$configStatsURLPortSav		= \"$configStatsURLPortSav\";
\$configStatsURLPathSav		= \"$configStatsURLPathSav\";

// Statisics
\$configStatsUseGethostbyaddrSav = \"$configStatsUseGethostbyaddrSav\";
\$configStatsDaysToKeepPageVisitsSav = \"$configStatsDaysToKeepPageVisitsSav\";

// Admin
\$adminEmailSav = \"$inp_user_email\";
\$adminPasswordSav = \"$inp_user_password\";

?>";
	$fh = fopen("../_data/setup_data.php", "w+") or die("can not open file");
	fwrite($fh, $update_file);
	fclose($fh);


	// Move to admin-panel
	header("Location: index.php?page=5_write_to_file");
	exit;

}


echo"
<h1>Administrator</h1>



<!-- Administrator form -->

	<form method=\"post\" action=\"index.php?page=4_administrator&amp;process=1\" enctype=\"multipart/form-data\">

	<!-- Error -->
		";
		if(isset($ft) && isset($fm)){
			if($ft != ""){
				$fm = str_replace("_", " ", $fm);
				$fm = ucfirst($fm);
				echo"<div class=\"$ft\"><span>$fm</span></div>";
			}
		}
		echo"
	<!-- //Error -->

	<!-- Focus -->
		<script>
		window.onload = function() {
			document.getElementById(\"inp_user_email\").focus();
		}
		</script>
	<!-- //Focus -->

	<p><b>Email:</b><br />
	<input type=\"text\" name=\"inp_user_email\" id=\"inp_user_email\" value=\""; if(isset($inp_user_email)){ echo"$inp_user_email"; } echo"\" size=\"35\" tabindex=\"1\" /></p>

	<p><b>Password:</b><br />
	<input type=\"password\" name=\"inp_user_password\" value=\""; if(isset($inp_user_password)){ echo"$inp_user_password"; } echo"\" size=\"35\" tabindex=\"3\" /></p>

	<p>
	<input type=\"submit\" value=\"Next\" class=\"submit\" />
	</p>

	</form>

<!-- //Administrator form -->
";
?>

