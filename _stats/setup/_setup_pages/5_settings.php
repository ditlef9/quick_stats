<?php
/*- Check if setup is finished ------------------------------------------------------ */
if(file_exists("../_data/setup_finished.php")){
	echo"<p>Setup is finished.</p>";
	die;
}


/*- Variables ------------------------------------------------------------------------ */
if(isset($_GET['action'])) {
	$action = $_GET['action'];
	$action = strip_tags(stripslashes($action));
}
else{
	$action = "";
}


if($action == "check"){
	// Administrator
	$inp_generate_test_data = $_POST['inp_generate_test_data'];
	$inp_generate_test_data = output_html($inp_generate_test_data);


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

\$configSecurityCodeSav	= \"$configSecurityCodeSav\";

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
\$adminEmailSav = \"$adminEmailSav\";
\$adminPasswordSav = \"$adminPasswordSav\";

// Test
\$configGenerateTestDataSav = \"$inp_generate_test_data\";

?>";
	$fh = fopen("../_data/setup_data.php", "w+") or die("can not open file");
	fwrite($fh, $update_file);
	fclose($fh);


	// Move to admin-panel
	// We need to use refresh because header is to fast...
	echo"
	<h1>Settings</h1>
	
	<table>
	 <tr>
	  <td>
		<img src=\"../_layout/gfx/loading_22.gif\" alt=\"loading_22.gif\" />
	  </td>
	  <td>
		<p>Loading...</p>
	  </td>
	 </tr>
	</table>
	
	<p>The installation will now start. Please wait.</p>

	<meta http-equiv=\"refresh\" content=\"3;url=index.php?page=6_write_to_file\" />
	";
}

if($action == ""){
	echo"
	<h1>Settings</h1>



	<!-- Settings form -->

	<form method=\"post\" action=\"index.php?page=5_settings&amp;action=check\" enctype=\"multipart/form-data\">

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
			document.getElementById(\"inp_generate_test_data\").focus();
		}
		</script>
	<!-- //Focus -->

	<p>Do you want to generate test data?<br />
	
	<input type=\"radio\" name=\"inp_generate_test_data\" id=\"inp_generate_test_data\" value=\"1\" "; if($configGenerateTestDataSav == "1"){ echo" checked=\"checked\""; } echo" /> Yes
	<input type=\"radio\" name=\"inp_generate_test_data\" value=\"0\" "; if($configGenerateTestDataSav == "0"){ echo" checked=\"checked\""; } echo"/> No
	</p>

	<p>
	<input type=\"submit\" value=\"Next\" class=\"submit\" />
	</p>

	</form>

	<!-- //Settingsform -->
	";
}
?>

