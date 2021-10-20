<?php
/**
*
* File: _admin/_liquidbase/db_scripts/webdesign/webdesign_share_buttons.php
* Version 1.0.0
* Date 21:19 28.08.2019
* Copyright (c) 2019 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

// Access check
if(isset($_SESSION['adm_user_id'])){


	$t_languages		= $dbPrefixSav . "languages";
	$t_languages_active	= $dbPrefixSav . "languages_active";


	$result = mysqli_query($link, "DROP TABLE IF EXISTS $t_languages_active") or die(mysqli_error($link)); 

	mysqli_query($link, "CREATE TABLE $t_languages_active(
	   language_active_id INT NOT NULL AUTO_INCREMENT,
	   PRIMARY KEY(language_active_id), 
	   language_active_name VARCHAR(250),
	   language_active_slug VARCHAR(250),
	   language_active_native_name VARCHAR(250),
	   language_active_iso_two VARCHAR(250),
	   language_active_iso_three VARCHAR(250),
	   language_active_iso_two_alt_a VARCHAR(20),
	   language_active_iso_two_alt_b VARCHAR(20),
	   language_active_flag_path_16x16 VARCHAR(250),
	   language_active_flag_16x16 VARCHAR(250),
	   language_active_flag_path_32x32 VARCHAR(250),
	   language_active_flag_32x32 VARCHAR(250),
	   language_active_charset VARCHAR(250),
	   language_active_default INT)")
	   or die(mysqli_error($link));


	// Insert "en"
	$query = "SELECT language_id, language_name, language_slug, language_native_name, language_iso_two, language_iso_three, language_flag_path_16x16, language_flag_16x16, language_flag_path_32x32, language_flag_32x32, language_charset FROM $t_languages WHERE language_iso_two='en'";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_language_id, $get_language_name, $get_language_slug, $get_language_native_name, $get_language_iso_two, $get_language_iso_three, $get_language_flag_path_16x16, $get_language_flag_16x16, $get_language_flag_path_32x32, $get_language_flag_32x32, $get_language_charset) = $row;

	mysqli_query($link, "INSERT INTO $t_languages_active
	(language_active_id, language_active_name, language_active_slug, language_active_native_name, language_active_iso_two, language_active_iso_three, language_active_flag_path_16x16, language_active_flag_16x16, language_active_flag_path_32x32, language_active_flag_32x32, language_active_charset, language_active_default) 
	VALUES
	(NULL, '$get_language_name', '$get_language_slug', '$get_language_native_name', '$get_language_iso_two', '$get_language_iso_three', '$get_language_flag_path_16x16', '$get_language_flag_16x16', '$get_language_flag_path_32x32', '$get_language_flag_32x32', '$get_language_charset', '1')
	") or die(mysqli_error($link));


	// Insert "no"
	$query = "SELECT language_id, language_name, language_slug, language_native_name, language_iso_two, language_iso_three, language_flag_path_16x16, language_flag_16x16, language_flag_path_32x32, language_flag_32x32, language_charset FROM $t_languages WHERE language_iso_two='no'";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_language_id, $get_language_name, $get_language_slug, $get_language_native_name, $get_language_iso_two, $get_language_iso_three, $get_language_flag_path_16x16, $get_language_flag_16x16, $get_language_flag_path_32x32, $get_language_flag_32x32, $get_language_charset) = $row;

	mysqli_query($link, "INSERT INTO $t_languages_active
	(language_active_id, language_active_name, language_active_slug, language_active_native_name, language_active_iso_two, language_active_iso_three, language_active_flag_path_16x16, language_active_flag_16x16, language_active_flag_path_32x32, language_active_flag_32x32, language_active_charset, language_active_default) 
	VALUES
	(NULL, '$get_language_name', '$get_language_slug', '$get_language_native_name', '$get_language_iso_two', '$get_language_iso_three', '$get_language_flag_path_16x16', '$get_language_flag_16x16', '$get_language_flag_path_32x32', '$get_language_flag_32x32', '$get_language_charset', '0')
	") or die(mysqli_error($link));



} // access
?>