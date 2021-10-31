<?php
/*- Check if setup is finished ------------------------------------------------------ */
if(file_exists("../_data/setup_finished.php")){
	echo"<p>Setup is finished.</p>";
	die;
}


/*- Variables ----------------------------------------------------------------------- */
if(isset($_GET['action'])) {
	$action = $_GET['action'];
	$action = strip_tags(stripslashes($action));
}
else{
	$action = "";
}


// 1. Connect to MySQL
$link = mysqli_connect($dbHostSav, $dbUserNameSav, $dbPasswordSav, $dbDatabaseNameSav);
if (!$link) {
	echo "
	<div class=\"alert alert-danger\"><span class=\"glyphicon glyphicon-exclamation-sign\" aria-hidden=\"true\"></span><strong>MySQL connection error</strong>"; 
	echo PHP_EOL;
	echo "<br />Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
	echo "<br />Debugging error: " . mysqli_connect_error() . PHP_EOL;
   	echo"
	</div>
	";
}

// 2. Create tables
include("_setup_pages/6_write_to_file_include_database_setup_tables.php");


// 3. Insert user
// 3.1 Salt
$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$charactersLength = strlen($characters);
$salt = '';
for ($i = 0; $i < 6; $i++) {
      	$salt .= $characters[rand(0, $charactersLength - 1)];
}
$inp_user_salt_mysql = quote_smart($link, $salt);

// 3.2 user and assword
$inp_user_email_mysql = quote_smart($link, $adminEmailSav);
$inp_user_password_mysql = quote_smart($link, $adminPasswordSav);
if($adminEmailSav == ""){
	echo"<p>Admin e-mail is blank. We need to wait for flat file to be written. Please hold!</p>
	<meta http-equiv=\"refresh\" content=\"3;url=index.php?page=6_write_to_file&amp;random=$salt\" />";
	die;
}

// 3.3 Security
$year = date("Y");
$pin = rand(0,9999);
$inp_user_security = $year . $pin;

// 3.4 Registered
$datetime = date("Y-m-d H:i:s");
$time = time();
$date = date("Y-m-d");
$date_saying = date("j M Y");


// 3.5 Insert user
mysqli_query($link, "TRUNCATE $t_users") or die(mysqli_error($link));

mysqli_query($link, "INSERT INTO $t_users
(user_id, user_email, user_name, user_password, user_password_replacement, 
user_password_date, user_salt, user_security, user_rank, user_verified_by_moderator, 
user_first_name, user_middle_name, user_last_name, user_login_tries, user_last_online, 
user_last_online_time, user_last_ip, user_notes, user_marked_as_spammer) 
VALUES 
(NULL, $inp_user_email_mysql, 'Admin', $inp_user_password_mysql, '', 
'$date', $inp_user_salt_mysql, '$inp_user_security', 'admin', 1, 
'Admin', '', '', 0, '$datetime',
'$time', '', '', 0)")
or die(mysqli_error($link));


// 3.6 Get user id
$query = "SELECT user_id FROM $t_users WHERE user_email=$inp_user_email_mysql";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_my_user_id) = $row;

// 4. Login user
$_SESSION['adm_user_id']  = "$get_my_user_id";
$_SESSION['adm_security'] = "$inp_user_security";
//echo"Adm_user_id = $get_my_user_id<br />
//adm_security=$inp_user_security";
//die;

// 5. Write setup finished
$fh = fopen("../_data/setup_finished.php", "w+") or die("can not open file");
fwrite($fh, "$datetime");
fclose($fh);



// 6. Move to liquidbase
header("Location: ../liquidbase/liquidbase.php");
exit;
?>
