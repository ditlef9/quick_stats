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



if($action == "test_connection"){

	// MySQL
	$inp_mysql_host = $_POST['inp_mysql_host'];
	$inp_mysql_host = output_html($inp_mysql_host);

	$inp_mysql_user_name = $_POST['inp_mysql_user_name'];
	$inp_mysql_user_name = output_html($inp_mysql_user_name);

	$inp_mysql_password = $_POST['inp_mysql_password'];
	$inp_mysql_password = output_html($inp_mysql_password);
	$inp_mysql_password = str_replace("&amp;", "&", $inp_mysql_password);
	$inp_mysql_password = str_replace("&lt;", "<", $inp_mysql_password);
	$inp_mysql_password = str_replace("&gt;", ">", $inp_mysql_password);

	$inp_mysql_database_name = $_POST['inp_mysql_database_name'];
	$inp_mysql_database_name = output_html($inp_mysql_database_name);

	$inp_mysql_prefix = $_POST['inp_mysql_prefix'];
	$inp_mysql_prefix = output_html($inp_mysql_prefix);
		
	// Try connection
	$link = @mysqli_connect($inp_mysql_host, $inp_mysql_user_name, $inp_mysql_password, $inp_mysql_database_name);
	if (!$link) {
		$error = mysqli_connect_error();
		$error_no = mysqli_connect_error() . PHP_EOL;
		$error_or = mysqli_connect_error() . PHP_EOL;

		$ft = "error";
		$fm = "$error_or";
		$action = "";

		// Parameter transfer
		$dbHostSav		= "$inp_mysql_host";
		$dbUserNameSav   	= "$inp_mysql_user_name";
		$dbPasswordSav		= "$inp_mysql_password";
		$dbDatabaseNameSav 	= "$inp_mysql_database_name";
		$dbPrefixSav 		= "$inp_mysql_prefix";
	}
	else{
		// Write DB file
		$update_file="<?php
// Database
\$dbHostSav   		= \"$inp_mysql_host\";
\$dbUserNameSav   	= \"$inp_mysql_user_name\";
\$dbPasswordSav		= \"$inp_mysql_password\";
\$dbDatabaseNameSav 	= \"$inp_mysql_database_name\";
\$dbPrefixSav 		= \"$inp_mysql_prefix\";
?>";
		$fh = fopen("../_data/db.php", "w+") or die("can not open file");
		fwrite($fh, $update_file);
		fclose($fh);
	

		// Move to admin-panel
		// We need to use refresh because header is to fast...
		echo"
		<h1>Database</h1>
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
	
		<p>Waiting on local disk.</p>
	
		<meta http-equiv=\"refresh\" content=\"0;url=index.php?page=4_administrator\" />
		";
	}
} // test_connection
if($action == ""){
	echo"
	<h1>Database</h1>



	<!-- Database form -->
	<form method=\"post\" action=\"index.php?page=3_database&amp;action=test_connection\" enctype=\"multipart/form-data\">

	<!-- Error -->
		";
		if(isset($ft) && isset($fm)){
			echo"<div class=\"error\"><p>$fm</p>";
			if(isset($_GET['error_no'])){
				$error_no = $_GET['error_no'];
				$error_no = output_html($error_no);
				echo"<p>$error_no</p>";
			}
			if(isset($_GET['error_or'])){
				$error_or = $_GET['error_or'];
				$error_or = output_html($error_or);
				echo"<p>$error_or</p>";
			}
			echo"</div>";
		}
		echo"
	<!-- //Error -->

	<!-- Focus -->
		<script>
		window.onload = function() {
			document.getElementById(\"inp_mysql_host\").focus();
		}
		</script>
	<!-- //Focus -->

	<p><b>Host:</b><br />
	<input type=\"text\" name=\"inp_mysql_host\" id=\"inp_mysql_host\" value=\"$dbHostSav\" size=\"35\" tabindex=\"1\" /></p>

	<p><b>Username:</b><br />
	<input type=\"text\" name=\"inp_mysql_user_name\" value=\"$dbUserNameSav\" size=\"35\" tabindex=\"2\" /></p>

	<p><b>Password:</b><br />
	<input type=\"text\" name=\"inp_mysql_password\" value=\"$dbPasswordSav\" size=\"35\" tabindex=\"3\" /></p>

	<p><b>Database name:</b><br />
	<input type=\"text\" name=\"inp_mysql_database_name\" value=\"$dbDatabaseNameSav\" size=\"35\" tabindex=\"4\" /></p>

	<p><b>Prefix:</b><br />
	<input type=\"text\" name=\"inp_mysql_prefix\" value=\"$dbPrefixSav\" size=\"35\" tabindex=\"5\" /></p>

	
	<p>
	<input type=\"submit\" value=\"Test connection\" class=\"submit\" />
	</p>

	</form>
	<!-- //Database form -->

	";
}

?>

