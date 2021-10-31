<?php
/**
*
* File: _stats/setup/_setup_pages/0_start.php
* Version 1
* Date 10:14 15.10.2021
* Copyright (c) 2021 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/


/*- Check if setup is finished ------------------------------------------------------ */
if(file_exists("../_data/setup_finished.php")){
	echo"<p>Setup is finished.</p>";
	die;
}

/*- Check if setup data exists ------------------------------------------------------- */
// Make setup data
if(!(is_dir("../_data/"))){
	mkdir("../_data/");
}

$year = date("Y");
$server_name = $_SERVER['SERVER_NAME'];
$server_name_ucfirst = ucfirst($server_name);

// Email
$host = $_SERVER['HTTP_HOST'];
$inp_from_email = "post@" . $_SERVER['HTTP_HOST'];

// Page URL
$page_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$page_url = htmlspecialchars($page_url, ENT_QUOTES, 'UTF-8');

// Stats URL
$inp_stats_url = str_replace("/setup/", "", $page_url);
$inp_stats_url = str_replace("index.php?page=0_start&amp;process=1", "", $inp_stats_url);
$inp_stats_url = str_replace("index.php?page=2_chmod", "", $inp_stats_url);
$inp_stats_url_len = strlen($inp_stats_url);


$stats_url_parsed = parse_url($inp_stats_url);
$inp_stats_url_scheme = $stats_url_parsed['scheme'];
$inp_stats_url_host = $stats_url_parsed['host'];
if(isset($stats_url_parsed['port'])){
	$inp_stats_url_port = $stats_url_parsed['port'];
}
else{
	$inp_stats_url_port = "";
}
$inp_stats_url_path = $stats_url_parsed['path'];


// Database
$inp_mysql_host = "$server_name";
$inp_mysql_user_name = "root";
$inp_mysql_password = "";
$inp_mysql_database_name = "stats";
$inp_mysql_prefix = "s_";

// General
$inp_site_title = "$server_name_ucfirst";
$inp_site_title_clean = clean($inp_site_title);

$datetime = date("Y-m-d H:i:s");

// Security
$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$charactersLength = strlen($characters);
$inp_security_code = '';
for ($i = 0; $i < 20; $i++) {
      	$inp_security_code .= $characters[rand(0, $charactersLength - 1)];
}



// 1. Create meta
$input_meta="<?php
/* Updated by: 0_start.php
*  Date: $datetime */

// General
\$configStatsTitleSav		 = \"$inp_site_title\";
\$configStatsTitleCleanSav	 = \"$inp_site_title_clean\";
\$configFromEmailSav 		 = \"$inp_from_email\";
\$configFromNameSav 		 = \"$inp_site_title\";

\$configMailSendActiveSav	= \"1\";
\$configSecurityCodeSav		= \"$inp_security_code\";
\$configDemoModeSav 		= \"0\";

// URLs
\$configStatsURLSav 		= \"$inp_stats_url\";
\$configStatsRLLenSav 		= \"$inp_stats_url_len\";
\$configStatsURLSchemeSav	= \"$inp_stats_url_scheme\";
\$configStatsURLHostSav		= \"$inp_stats_url_host\";
\$configStatsURLPortSav		= \"$inp_stats_url_port\";
\$configStatsURLPathSav		= \"$inp_stats_url_path\";

// Statisics
\$configStatsUseGethostbyaddrSav 	= \"1\";
\$configStatsDaysToKeepPageVisitsSav 	= \"730\";
\$configStatsHideIPsSav 		= \"md5\";

// Test
\$configGenerateTestDataSav = \"0\";
?>";

$fh = fopen("../_data/meta.php", "w+") or die("can not open file");
fwrite($fh, $input_meta);
fclose($fh);

// 2. DB
$mysql_config_file = "../_data/db.php";

$update_file="<?php
/* Updated by: 0_start.php
*  Date: $datetime */

\$dbHostSav   		= \"$inp_mysql_host\";
\$dbUserNameSav   	= \"$inp_mysql_user_name\";
\$dbPasswordSav		= \"$inp_mysql_password\";
\$dbDatabaseNameSav 	= \"$inp_mysql_database_name\";
\$dbPrefixSav 		= \"$inp_mysql_prefix\";
?>";

$fh = fopen("$mysql_config_file", "w+") or die("can not open file");
fwrite($fh, $update_file);
fclose($fh);


// 3. Admin
$update_file="<?php
/* Updated by: 0_start.php
*  Date: $datetime */
\$adminEmailSav = \"\";
\$adminPasswordSav = \"\";
\$adminPasswordIsEncryptedSav = \"0\";
?>";

$fh = fopen("../_data/admin.php", "w+") or die("can not open file");
fwrite($fh, $update_file);
fclose($fh);




// Header
header("Location: index.php?page=1_license");
exit;

?>

