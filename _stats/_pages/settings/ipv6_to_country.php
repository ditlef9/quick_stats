<?php
/**
*
* File: _stats/_pages/settings/ipv6_to_country.php
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

/*- Variables -------------------------------------------------------------------------- */
if(isset($_GET['order_by'])) {
	$order_by = $_GET['order_by'];
	$order_by = strip_tags(stripslashes($order_by));
}
else{
	$order_by = "";
}
if($order_by == ""){
	$order_by = "user_name";
}
if(isset($_GET['order_method'])) {
	$order_method = $_GET['order_method'];
	$order_method = strip_tags(stripslashes($order_method));
	if($order_method != "asc" && $order_method != "desc"){
		echo"Wrong order method";
		die;
	}
}
else{
	$order_method = "asc";
}
/*- Functions -------------------------------------------------------------------------- */
function delete_directory($dirname) {
	if (is_dir($dirname))
		$dir_handle = opendir($dirname);
		if (!$dir_handle)
			return false;
		while($file = readdir($dir_handle)) {
			if ($file != "." && $file != "..") {
				if (!is_dir($dirname."/".$file))
				unlink($dirname."/".$file);
              		else
                    		delete_directory($dirname.'/'.$file);
        	}
     	}
	closedir($dir_handle);
	rmdir($dirname);
	return true;
}



/*- MySQL Tables -------------------------------------------------- */
$t_stats_ip_to_country_lookup_ipv6 	= $dbPrefixSav . "stats_ip_to_country_lookup_ipv6";

if($action == ""){
	echo"
	<h1>IPv6 to Country</h1>


	<!-- Feedback -->
	";
	if($ft != "" && $fm != ""){
		$fm = str_replace("_", " ", $fm);
		$fm = ucfirst($fm);
		echo"<div class=\"$ft\"><p>$fm</p></div>";
	}
	echo"
	<!-- //Feedback -->


	<!-- IPv6 List -->
		<p>
		<a href=\"index.php?open=$open&amp;page=$page&amp;action=export_to_txt_files&amp;editor_language=$editor_language\" class=\"btn_default\">Export to txt files</a>
		</p>

		<table class=\"hor-zebra\">
		 <thead>
		  <tr>
		   <th scope=\"col\">
			<span>Start</span>
		   </th>
		   <th scope=\"col\">
			<span>End</span>
		   </th>
		   <th scope=\"col\">
			<span>Country</span>
		   </th>
		  </tr>
		</thead>
		<tbody>


	";
	$query = "SELECT ip_id, ip_start, ip_end, country FROM $t_stats_ip_to_country_lookup_ipv6";
	$result = mysqli_query($link, $query);
	while($row = mysqli_fetch_row($result)) {
		list($get_ip_id, $get_ip_start, $get_ip_end, $get_country) = $row;

		$get_ip_start = bin2hex($get_ip_start);
		$get_ip_end = bin2hex($get_ip_end);

		echo"
		 <tr>
		  <td>
			<span>$get_ip_start</span>
		  </td>
		  <td>
			<span>$get_ip_end</span>
		  </td>
		  <td>
			<span>$get_country</span>
		  </td>
		 </tr>
		";

	}
	echo"
	
		 </tbody>
		</table>
	<!-- //IPv6 list -->
	";
}
elseif($action == "export_to_txt_files"){
	echo"
	<h1>Export to txt files</h1>

	<!-- Where am I? -->
		<p><b>You are here:</b><br />
		<a href=\"index.php?open=$open&amp;page=$page&amp;editor_language=$editor_language\">IPv6 to Country</a>
		&gt;
		<a href=\"index.php?open=$open&amp;page=$page&amp;action=export_to_txt_files&amp;editor_language=$editor_language\">Export to txt files</a>
		</p>
	<!-- //Where am I? -->
	
	<ul>";
	// Truncate dir
	delete_directory("_cache");
	// Make folder
	if(!(is_dir("_cache"))){
		mkdir("_cache");
	}
	if(!(is_dir("_cache/ipv6_to_country"))){
		mkdir("_cache/ipv6_to_country");
	}
	
	$files_counter = 0;
	$rows_in_file_counter = 0;
	$query = "SELECT ip_id, ip_start, ip_end, country FROM $t_stats_ip_to_country_lookup_ipv6";
	$result = mysqli_query($link, $query);
	while($row = mysqli_fetch_row($result)) {
		list($get_ip_id, $get_ip_start, $get_ip_end, $get_country) = $row;


		$get_ip_start = bin2hex($get_ip_start);
		$get_ip_end = bin2hex($get_ip_end);

		// Array files:
		if($rows_in_file_counter == "0"){
			$input = "<?php
\$ip_index = array(
array('ip_start' => '$get_ip_start','ip_end' => '$get_ip_end','country' => '$get_country')";
		}
		else{
			$input = $input . ",
array('ip_start' => '$get_ip_start','ip_end' => '$get_ip_end','country' => '$get_country')";
		}

		$rows_in_file_counter++;

		// Check if we need to write and start with next file
		if($rows_in_file_counter == "1000"){

			// Write data
			$input = $input . "
);
?>";
			$fh = fopen("_cache/ipv6_to_country/$files_counter.php", "w+") or die("can not open file");
			fwrite($fh, $input);
			fclose($fh);

			// Echo file name
			echo"
				<li><a href=\"_cache/ipv6_to_country/$files_counter.php\">cache/ipv6_to_country/$files_counter.php</a></li>
			";
			
			// Reset counters
			$files_counter++;
			$rows_in_file_counter = 0;
			$input = "";
		}

	} // while ip

	// Write last file
	if($rows_in_file_counter != "0"){
			// Write data
			$input = $input . "
);
?>";
			$fh = fopen("_cache/ipv6_to_country/$files_counter.php", "w+") or die("can not open file");
			fwrite($fh, $input);
			fclose($fh);

			// Echo file name
			echo"
				<li><a href=\"_cache/ipv6_to_country/$files_counter.php\">cache/ipv6_to_country/$files_counter.php</a></li>
			";
	}

	echo"
	</ul>";

} // action == export
?>