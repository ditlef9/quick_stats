<?php
/**
*
* File: _stats/_pages/settings/default.php
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

/*- Variables ------------------------------------------------------------------------ */
if (isset($_GET['mode'])) {
	$mode = $_GET['mode'];
	$mode = stripslashes(strip_tags($mode));
}
else{
	$mode = "";
}


if($mode == "save"){

	$inp_title = $_POST['inp_title'];
	$inp_title = output_html($inp_title);

	$inp_title_clean = clean($inp_title);

	$inp_from_email = $_POST['inp_from_email'];
	$inp_from_email = output_html($inp_from_email);

	$inp_from_name = $_POST['inp_from_name'];
	$inp_from_name = output_html($inp_from_name);


	$inp_mail_send_active = $_POST['inp_mail_send_active'];
	$inp_mail_send_active = output_html($inp_mail_send_active);

	$inp_demo_mode = $_POST['inp_demo_mode'];
	$inp_demo_mode = output_html($inp_demo_mode);



	// Control panel URL
	$inp_url = $_POST['inp_url'];
	$inp_url = output_html($inp_url);
	$inp_url_len = strlen($inp_url);

	$url_parsed = parse_url($inp_url);
	$inp_url_scheme = $url_parsed['scheme'];
	$inp_url_host = $url_parsed['host'];
	if(isset($url_parsed['port'])){
		$inp_url_port = $url_parsed['port'];
	}
	else{
		$inp_url_port = "";
	}
	$inp_url_path = $url_parsed['path'];



	// Statisics
	$inp_use_gethostbyaddr = $_POST['inp_use_gethostbyaddr'];
	$inp_use_gethostbyaddr = output_html($inp_use_gethostbyaddr);

	$inp_days_to_keep_page_visits = $_POST['inp_days_to_keep_page_visits'];
	$inp_days_to_keep_page_visits = output_html($inp_days_to_keep_page_visits);
	if(!(is_numeric($inp_days_to_keep_page_visits))){
		echo"inp_days_to_keep_page_visits must be numeric!";
		die;
	}

	$inp_hide_ips = $_POST['inp_hide_ips'];
	$inp_hide_ips = output_html($inp_hide_ips);

	// Security
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$inp_security_code = '';
	for ($i = 0; $i < 20; $i++) {
	      	$inp_security_code .= $characters[rand(0, $charactersLength - 1)];
	}


	$update_file="<?php
// General
\$configStatsTitleSav		 = \"$inp_title\";
\$configStatsTitleCleanSav	 = \"$inp_title_clean\";
\$configFromEmailSav 		 = \"$inp_from_email\";
\$configFromNameSav 		 = \"$inp_from_name\";
 
\$configMailSendActiveSav	= \"$inp_mail_send_active\";
\$configSecurityCodeSav		= \"$inp_security_code\";
\$configDemoModeSav 		= \"$inp_demo_mode\";

// URLs
\$configStatsURLSav 		= \"$inp_url\";
\$configStatsRLLenSav 		= \"$inp_url_len\";
\$configStatsURLSchemeSav	= \"$inp_url_scheme\";
\$configStatsURLHostSav		= \"$inp_url_host\";
\$configStatsURLPortSav		= \"$inp_url_port\";
\$configStatsURLPathSav		= \"$inp_url_path\";

// Statisics
\$configStatsUseGethostbyaddrSav = \"$inp_use_gethostbyaddr\";
\$configStatsDaysToKeepPageVisitsSav = \"$inp_days_to_keep_page_visits\";
\$configStatsHideIPsSav 		= \"$inp_hide_ips\";

?>";

	$fh = fopen("_data/meta.php", "w+") or die("can not open file");
	fwrite($fh, $update_file);
	fclose($fh);


	echo"
	<h1>Settings meta</h1>
	<h2><img src=\"_layout/gfx/loading_22.gif\" alt=\"loading_22.gif\" /> Saving...</h2>
	<meta http-equiv=refresh content=\"3; url=index.php?open=settings&page=default&focus=inp_website_title&ft=success&fm=changes_saved\">
	";
	// header("Location: index.php?open=settings&page=default&ft=success&fm=changes_saved");
	// exit;
}
if($mode == ""){

	$tabindex = 0;
	echo"
	<h1>Settings meta</h1>
	<form method=\"post\" action=\"index.php?open=settings&amp;page=default&amp;mode=save\" enctype=\"multipart/form-data\">
				
	
	<!-- Feedback -->
	";
	if($ft != ""){
		$fm = str_replace("_", " ", $fm);
		$fm = ucfirst($fm);
		echo"<div class=\"$ft\"><span>$fm</span></div>";
	}
	echo"	
	<!-- //Feedback -->

	<!-- Focus -->
		<script>
		window.onload = function() {
			document.getElementById(\"inp_title\").focus();
		}
		</script>
	<!-- //Focus -->


	<h2>General</h2>
	<p>Title:<br />
	<input type=\"text\" name=\"inp_title\" id=\"inp_title\" value=\"$configStatsTitleSav\" size=\"25\" style=\"width: 99%;\" tabindex=\""; $tabindex=0; $tabindex=$tabindex+1;echo"$tabindex\" /></p>

	<p>Website E-mail address (used for sending e-mails):<br />
	<input type=\"text\" name=\"inp_from_email\" value=\"$configFromEmailSav\" size=\"25\" style=\"width: 99%;\" tabindex=\""; $tabindex=$tabindex+1;echo"$tabindex\" /></p>

	<p>Website from name:<br />
	<input type=\"text\" name=\"inp_from_name\" value=\"$configFromNameSav\" size=\"25\" style=\"width: 99%;\" tabindex=\""; $tabindex=$tabindex+1;echo"$tabindex\" /></p>

	<p>Mail send active<br />
	<span class=\"smal\">If turned off then the web site will never send emails. Suitable for testing and server that doesnt have internet connection.</span><br />
	<input type=\"radio\" name=\"inp_mail_send_active\" value=\"1\""; if($configMailSendActiveSav == "1"){ echo" checked=\"checked\""; } echo" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /> Yes
	&nbsp;
	<input type=\"radio\" name=\"inp_mail_send_active\" value=\"0\""; if($configMailSendActiveSav == "0"){ echo" checked=\"checked\""; } echo" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /> No
	</p>

	<p>Demo mode<br />
	<span class=\"smal\">When turned on everyone can access the statistics, but they cannot edit or delete. <br />
	The login is username=admin, password=demo</span><br />
	<input type=\"radio\" name=\"inp_demo_mode\" value=\"1\""; if($configDemoModeSav == "1"){ echo" checked=\"checked\""; } echo" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /> 
	On 
	&nbsp;
	<input type=\"radio\" name=\"inp_demo_mode\" value=\"0\""; if($configDemoModeSav == "0"){ echo" checked=\"checked\""; } echo" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
	Off
	</p>

	<h2>URLs</h2>

	<p>Url:<br />
	<input type=\"text\" name=\"inp_url\" value=\"$configStatsURLSav\" size=\"25\" style=\"width: 99%;\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></p>

	<h2>Statistics</h2>

	<p>Use gethostbyaddr<br />
	<input type=\"radio\" name=\"inp_use_gethostbyaddr\" value=\"1\""; if($configStatsUseGethostbyaddrSav == "1"){ echo" checked=\"checked\""; } echo" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /> Yes
	&nbsp;
	<input type=\"radio\" name=\"inp_use_gethostbyaddr\" value=\"0\""; if($configStatsUseGethostbyaddrSav == "0"){ echo" checked=\"checked\""; } echo" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /> No
	</p>

	<p>Days to keep page visits:<br />
	Every visited page is logged in table <em>stats_pages_visits_per_year</em> for statistical purpose.<br />
	How many days do you want to store at the most?<br />
	Set to 0 to deactivate logging.<br />
	<input type=\"text\" name=\"inp_days_to_keep_page_visits\" value=\"$configStatsDaysToKeepPageVisitsSav\" size=\"5\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /><br />
	</p>

	<p>Hide IPs:<br />
	<select name=\"inp_hide_ips\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\">
		<option value=\"0\""; if($configStatsHideIPsSav == "0"){ echo" selected=\"selected\""; } echo">No</option>
		<option value=\"md5\""; if($configStatsHideIPsSav == "md5"){ echo" selected=\"selected\""; } echo">Yes, as md5</option>
	</select>
	</p>


	<p><input type=\"submit\" value=\"Save changes\" class=\"btn\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></p>

	</form>

	";
} // mode == ""
?>