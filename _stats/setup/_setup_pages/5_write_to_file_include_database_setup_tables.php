<?php
/*- Check if setup is finished ------------------------------------------------------ */
if(file_exists("../_data/setup_finished.php")){
	echo"<p>Setup is finished.</p>";
	die;
}



// Mysql Setup
$mysql_config_file = "../_data/db.php";
if(!(file_exists("$mysql_config_file"))){
	echo"Missing MySQL info.";
	die;
}

/*- MySQL Tables -------------------------------------------------- */
$t_admin_liquidbase	= $dbPrefixSav . "admin_liquidbase";
$t_users		= $dbPrefixSav . "users";


// Liquidbase
$query = "SELECT * FROM $t_admin_liquidbase LIMIT 1";
$result = mysqli_query($link, $query);

if($result !== FALSE){
}
else{
	mysqli_query($link, "CREATE TABLE $t_admin_liquidbase(
	   liquidbase_id INT NOT NULL AUTO_INCREMENT,
	   PRIMARY KEY(liquidbase_id), 
	   liquidbase_module VARCHAR(200),
	   liquidbase_name VARCHAR(200),
	   liquidbase_run_datetime DATETIME,
	   liquidbase_run_saying VARCHAR(200))")
	  or die(mysqli_error($link));
}



$query = "SELECT * FROM $t_users LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){		
}
else{
	mysqli_query($link, "CREATE TABLE $t_users(
	   user_id INT NOT NULL AUTO_INCREMENT,
	   PRIMARY KEY(user_id), 
	   user_email VARCHAR(70),
	   user_name VARCHAR(70),
	   user_password VARCHAR(70),
	   user_password_replacement VARCHAR(70),
	   user_password_date DATE,
	   user_salt VARCHAR(70),
	   user_security INT,
	   user_rank VARCHAR(70),
	   user_verified_by_moderator INT,
	   user_first_name VARCHAR(70),
           user_middle_name VARCHAR(70),
	   user_last_name VARCHAR(70),
	   user_login_tries VARCHAR(70),
	   user_last_online DATETIME,
	   user_last_online_time VARCHAR(70),
	   user_last_ip VARCHAR(70),
	   user_notes VARCHAR(70),
	   user_marked_as_spammer INT)")
	   or die(mysqli_error($link));
}

?>
