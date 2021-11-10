<?php
/**
*
* File: _stats/pages/settings/languages.php
* Version 02:10 28.12.2011
* Copyright (c) 2008-2012 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Access check ----------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}

/*- Functions -------------------------------------------------------------------------- */
include("_functions/get_extension.php");

/*- Tables ---------------------------------------------------------------------------------- */
$t_languages		      = $dbPrefixSav . "languages";
$t_languages_active	      = $dbPrefixSav . "languages_active";
$t_languages_countries	      = $dbPrefixSav . "languages_countries";

$tabindex = 0;

if($action == ""){
	echo"
	<h2>Languages</h2>

	<!-- Feedback -->
	";
	if($ft != ""){
		if($fm == "changes_saved"){
			$fm = "Changes saved";
		}
		elseif($fm == "language_added_to_the_list"){
			$fm = "Language added to the list";
		}
		elseif($fm == "language_is_alreaddy_active"){
			$fm = "Language is alreaddy active";
		}
		elseif($fm == "language_removed"){
			$fm = "Language removed";
		}
		else{
			$fm = ucfirst($ft);
		}
		echo"<div class=\"$ft\"><span>$fm</span></div>";
	}
	echo"	
	<!-- //Feedback -->

	<!-- Menus -->
		<p>
		<a href=\"index.php?open=$open&amp;page=$page&amp;action=edit_languages&amp;editor_language=$editor_language\" class=\"btn_default\">Edit languages</a>
		<a href=\"index.php?open=$open&amp;page=$page&amp;action=edit_countries&amp;editor_language=$editor_language\" class=\"btn_default\">Edit countries</a>
		</p>
	<!-- //Menus -->

	<!-- Predefined language -->
		<form method=\"post\" action=\"?open=settings&amp;page=languages&amp;action=edit_predefined_language&amp;process=1\" enctype=\"multipart/form-data\" name=\"nameform\">
		<table>
		 <tr>
		  <td style=\"padding-right: 4px;\">
			<p>
			Main language:
			</p>
		  </td>
		  <td>
			<p>
			<select name=\"inp_language\">
				<option value=\"\">-</option>\n";

			$query = "SELECT language_active_id, language_active_name, language_active_iso_two, language_active_flag_16x16, language_active_flag_32x32, language_active_default FROM $t_languages_active";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_language_active_id, $get_language_active_name, $get_language_active_iso_two, $get_language_active_flag_16x16, $get_language_active_flag_32x32, $get_language_active_default) = $row;
				echo"	<option value=\"$get_language_active_id\"";if($get_language_active_default == "1"){ echo" selected=\"selected\"";}echo">$get_language_active_name</option>\n";
			}
			echo"
			</select>
			</p>
		  </td>
		  <td style=\"padding-right: 4px;\">
			<p>
			<input type=\"submit\" value=\"Save\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" class=\"submit\" />
			</p>
		  </td>
		 </tr>
		</table>
		</form>
	<!-- //Predefined language -->


	<!-- Languages added and that can be addded -->
		<table>
		  <tr>
		   <td style=\"padding-right: 20px;vertical-align:top;\">

			<!-- Languages that can be added -->
				
				<table class=\"hor-zebra\">
				 <thead>
				  <tr>
				   <th scope=\"col\">
					<span>Inactive</span>
					<span style=\"float: right;\">Click to activate</span>
				   </th>
				  </tr>
			 	 </thead>
				<tbody>
				";
				$query = "SELECT language_id, language_name, language_iso_two, language_flag_path_16x16, language_flag_16x16 FROM $t_languages";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_language_id, $get_language_name, $get_language_iso_two, $get_language_flag_path_16x16, $get_language_flag_16x16) = $row;
	
					if(isset($odd) && $odd == false){
						$odd = true;
					}
					else{
						$odd = false;
					}			


					echo"
					<tr>
					  <td"; if($odd == true){ echo" class=\"odd\""; } echo">
						<table>
						 <tr>
       						  <td style=\"padding-right:4px;\">
							<a href=\"?open=settings&amp;page=languages&amp;action=add_language&amp;process=1&amp;language_id=$get_language_id&amp;editor_language=$editor_language\" style=\"color:#000;\"><img src=\"../$get_language_flag_path_16x16/$get_language_flag_16x16\" alt=\"$get_language_flag_16x16\" /></a>
						  </td>
       						  <td>
          						<span><a href=\"?open=settings&amp;page=languages&amp;action=add_language&amp;process=1&amp;language_id=$get_language_id&amp;editor_language=$editor_language\" style=\"color:#000;\">$get_language_name</a></span>
						  </td>
     						 </tr>
						</table>
					  </td>
     					 </tr>
					";
				}
				echo"
				 </tbody>
				</table>
			<!-- //Languages that can be added -->

		  </td>
		  <td style=\"vertical-align: top;\">

			<!-- Land list -->
				<table class=\"hor-zebra\">
				 <thead>
				  <tr>
				   <th scope=\"col\">
					<span>Active</span>
					<span style=\"float: right;\">Click to deactivate</span>
				   </th>
				  </tr>
			 	 </thead>
				<tbody>";

				$query = "SELECT language_active_id, language_active_name, language_active_iso_two, language_active_flag_path_16x16, language_active_flag_16x16, language_active_default FROM $t_languages_active";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_language_active_id, $get_language_active_name, $get_language_active_iso_two, $get_language_active_flag_path_16x16, $get_language_active_flag_16x16, $get_language_active_default) = $row;


					
					if(isset($odd) && $odd == false){
						$odd = true;
					}
					else{
						$odd = false;
					}			


					echo"
					<tr>
					  <td"; if($odd == true){ echo" class=\"odd\""; } echo">
						<table>
						 <tr>
       						  <td style=\"padding-right:4px;\">
							<span><a href=\"?open=settings&amp;page=languages&amp;action=remove_language&amp;process=1&amp;language_id=$get_language_active_id&amp;editor_language=$editor_language\" style=\"color:#000;\"><img src=\"../$get_language_active_flag_path_16x16/$get_language_active_flag_16x16\" alt=\"$get_language_active_flag_16x16\" /></a></span>
						
						  </td>
       						  <td>
          						<span><a href=\"?open=settings&amp;page=languages&amp;action=remove_language&amp;process=1&amp;language_id=$get_language_active_id&amp;editor_language=$editor_language\" style=\"color:#000;\">$get_language_active_name</a></span>
						  </td>
     						 </tr>
						</table>
					  </td>
     					 </tr>
					";
				}
				echo"
					</table>
				  </td>
     				 </tr>
				</table>
			<!-- //Navigation list -->

		  </td>
		 </tr>
		</table>
	<!-- //Languages added and that can be addded -->
	";
}
elseif($action == "add_language"){
	if($process == "1"){
		if(isset($_GET['language_id'])) {
			$inp_language = $_GET['language_id'];
			$inp_language = strip_tags(stripslashes($inp_language));
		}
		else{
			if(isset($_POST['inp_language'])) {
				$inp_language = $_POST['inp_language'];
				$inp_language = strip_tags(stripslashes($inp_language));
			}
			else{
				$inp_language = "";
				header('Location: ?open=settings&page=languages&ft=warning&fm=Ingen språk oppgitt.&editor_language=$editor_language&l=$l');
				exit;
			}

		}
		


		// Get
		$inp_language_mysql = quote_smart($link, $inp_language);
		$query = "SELECT language_id, language_name, language_slug, language_native_name, language_iso_two, language_iso_three, language_iso_two_alt_a, language_iso_two_alt_b, language_flag_path_16x16, language_flag_16x16, language_flag_path_32x32, language_flag_32x32, language_charset FROM $t_languages WHERE language_id=$inp_language_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_language_id, $get_language_name, $get_language_slug, $get_language_native_name, $get_language_iso_two, $get_language_iso_three, $get_language_iso_two_alt_a, $get_language_iso_two_alt_b, $get_language_flag_path_16x16, $get_language_flag_16x16, $get_language_flag_path_32x32, $get_language_flag_32x32, $get_language_charset) = $row;

		if($get_language_id == ""){
			header("Location: ?open=settings&page=languages&ft=error&fm=language_not_found&editor_language=$editor_language&l=$l");
			exit;
				
		}
		else{
			// Does it alreaddy exsists in active list?
			$inp_iso_two_mysql = quote_smart($link, $get_language_iso_two);
			$query = "SELECT language_active_id FROM $t_languages_active WHERE language_active_iso_two=$inp_iso_two_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_language_active_id) = $row;

			if($get_language_active_id == ""){
				// Insert

				$inp_name_mysql = quote_smart($link, $get_language_name);
				$inp_slug_mysql = quote_smart($link, $get_language_slug);
				$inp_native_name_mysql = quote_smart($link, $get_language_native_name);
				$inp_iso_two_mysql = quote_smart($link, $get_language_iso_two);
				$inp_iso_three_mysql = quote_smart($link, $get_language_iso_three);
				$inp_iso_two_alt_a_mysql = quote_smart($link, $get_language_iso_two_alt_a);
				$inp_iso_two_alt_b_mysql = quote_smart($link, $get_language_iso_two_alt_b);
				$inp_active_flag_path_16x16_mysql = quote_smart($link, $get_language_flag_path_16x16);
				$inp_active_flag_16x16_mysql = quote_smart($link, $get_language_flag_16x16);
				$inp_active_flag_path_32x32_mysql = quote_smart($link, $get_language_flag_path_32x32);
				$inp_active_flag_32x32_mysql = quote_smart($link, $get_language_flag_32x32);
				$inp_active_charset_mysql = quote_smart($link, $get_language_charset);


				mysqli_query($link, "INSERT INTO $t_languages_active
				(language_active_id, language_active_name, language_active_slug, language_active_native_name, language_active_iso_two, 
				language_active_iso_three, language_active_iso_two_alt_a, language_active_iso_two_alt_b, language_active_flag_path_16x16, language_active_flag_16x16, 
				language_active_flag_path_32x32, language_active_flag_32x32, language_active_charset, language_active_default) 
				VALUES 
				(NULL, $inp_name_mysql, $inp_slug_mysql, $inp_native_name_mysql, $inp_iso_two_mysql, 
				$inp_iso_three_mysql, $inp_iso_two_alt_a_mysql, $inp_iso_two_alt_b_mysql, $inp_active_flag_path_16x16_mysql, $inp_active_flag_16x16_mysql, 
				$inp_active_flag_path_32x32_mysql, $inp_active_flag_32x32_mysql, $inp_active_charset_mysql, 0)")
				or die(mysqli_error($link));
				header("Location: ?open=settings&page=languages&ft=success&fm=language_added_to_the_list&editor_language=$editor_language&l=$l");
				exit;
				
			}
			else{
				header("Location: ?open=settings&page=languages&ft=success&fm=language_already_exist&editor_language=$editor_language&l=$l");
				exit;
				
			}
		}
	}

}
elseif($action == "remove_language"){
	if($process == "1"){
		if(isset($_GET['language_id'])) {
			$language_id = $_GET['language_id'];
			$language_id = strip_tags(stripslashes($language_id));
		}
		else{
			header('Location: ?open=settings&page=languages&ft=warning&fm=Ingen språk oppgitt.&editor_language=$editor_language&l=$l');
			exit;

		}
		
		// Locate this language
		$inp_language_id_mysql = quote_smart($link, $language_id);
		$query = "SELECT language_active_id FROM $t_languages_active WHERE language_active_id=$inp_language_id_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_language_active_id) = $row;

		if($get_language_active_id == ""){
			
			header("Location: ?open=settings&page=languages&ft=error&fm=language_not_found&editor_language=$editor_language&l=$l");
			exit;
		}
		else{
			$result = mysqli_query($link, "DELETE FROM $t_languages_active WHERE language_active_id=$inp_language_id_mysql");
			header("Location: ?open=settings&page=languages&ft=success&fm=language_removed&editor_language=$editor_language&l=$l");
			exit;
		}
	}
}
elseif($action == "edit_predefined_language"){
	if($process == "1"){

		
		if(isset($_POST['inp_language'])) {
			$inp_language = $_POST['inp_language'];
			$inp_language = strip_tags(stripslashes($inp_language));
		}
		else{
			header("Location: ?open=settings&page=languages&ft=warning&fm=Ingen språk valgt.");
			exit;
		}
		
		// Locate this language
		$inp_language_id_mysql = quote_smart($link, $inp_language);
		$query = "SELECT language_active_id FROM $t_languages_active WHERE language_active_id=$inp_language_id_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_language_active_id) = $row;


		if($get_language_active_id == ""){
			
			header("Location: ?open=settings&page=languages&ft=error&fm=language_not_found&editor_language=$editor_language&l=$l");
			exit;
		}
		else{
			$result = mysqli_query($link, "UPDATE $t_languages_active SET language_active_default='0'");
			$result = mysqli_query($link, "UPDATE $t_languages_active SET language_active_default='1' WHERE language_active_id=$inp_language_id_mysql");

			
			header("Location: ?open=settings&page=languages&ft=success&fm=changes_saved&editor_language=$editor_language&l=$l");
			exit;
		}
	}
}
elseif($action == "edit_languages"){

	echo"
	<h2>Edit languages</h2>

	<!-- Where am I? -->
		<p><b>You are here:</b><br />
		<a href=\"index.php?open=$open&amp;page=$page&amp;editor_language=$editor_language\">Languages</a>
		&gt;
		<a href=\"index.php?open=$open&amp;page=$page&amp;action=edit_languages&amp;editor_language=$editor_language\">Edit languages</a>
		</p>
	<!-- //Where am I?  -->


	<!-- Feedback -->
	";
	if($ft != ""){
		$fm = str_replace("_", " ", $fm);
		$fm = ucfirst($fm);
		echo"<div class=\"$ft\"><span>$fm</span></div>";
	}
	echo"	
	<!-- //Feedback -->

	


	<!-- Languages -->
		<table class=\"hor-zebra\">
		 <thead>
		  <tr>
		   <th colspan=\"2\">
			<span>Language</span>
		   </th>
		  </tr>
		 </thead>
		 <tbody>
		";
		$query = "SELECT language_id, language_name, language_iso_two, language_flag_path_16x16, language_flag_16x16 FROM $t_languages ORDER BY language_name ASC";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_language_id, $get_language_name, $get_language_iso_two, $get_language_flag_path_16x16, $get_language_flag_16x16) = $row;
	
			echo"
			 <tr>
       			  <td style=\"padding-right:4px;\">
				<a href=\"?open=settings&amp;page=languages&amp;action=edit_language&amp;language_id=$get_language_id&amp;editor_language=$editor_language\" style=\"color:#000;\"><img src=\"../$get_language_flag_path_16x16/$get_language_flag_16x16\" alt=\"$get_language_flag_16x16\" /></a>
			  </td>
       			  <td>
          			<span><a href=\"?open=settings&amp;page=languages&amp;action=edit_language&amp;language_id=$get_language_id&amp;editor_language=$editor_language\" style=\"color:#000;\">$get_language_name</a></span>
			  </td>
     			 </tr>
			";
		}
		echo"
		<!-- //Languages that can be added -->

		 </tbody>
		</table>
	<!-- //Languages -->
	";
} // action == edit_languages
elseif($action == "edit_language"){
	if(isset($_GET['language_id'])) {
		$language_id = $_GET['language_id'];
		$language_id = strip_tags(stripslashes($language_id));
		if(!(is_numeric($language_id))){
			echo"Language not numeric";
			die;
		}
	}
	else{
		echo"Missing language";
		die;
	}
		
	// Locate this language
	$language_id_mysql = quote_smart($link, $language_id);
	$query = "SELECT language_id, language_name, language_slug, language_native_name, language_iso_two, language_iso_three, language_iso_two_alt_a, language_iso_two_alt_b, language_flag_path_16x16, language_flag_16x16, language_flag_path_32x32, language_flag_32x32, language_charset FROM $t_languages WHERE language_id=$language_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_language_id, $get_current_language_name, $get_current_language_slug, $get_current_language_native_name, $get_current_language_iso_two, $get_current_language_iso_three, $get_current_language_iso_two_alt_a, $get_current_language_iso_two_alt_b, $get_current_language_flag_path_16x16, $get_current_language_flag_16x16, $get_current_language_flag_path_32x32, $get_current_language_flag_32x32, $get_current_language_charset) = $row;
	if($get_current_language_id == ""){
		echo"Language not found";
	}
	else{
		if($process == "1"){
			$inp_name = $_POST['inp_name'];
			$inp_name = output_html($inp_name);
			$inp_name_mysql = quote_smart($link, $inp_name);

			$inp_name_clean = clean($inp_name);
			$inp_name_clean_mysql = quote_smart($link, $inp_name_clean);

			$inp_native_name = $_POST['inp_native_name'];
			$inp_native_name = output_html($inp_native_name);
			$inp_native_name_mysql = quote_smart($link, $inp_native_name);

			$inp_iso_two = $_POST['inp_iso_two'];
			$inp_iso_two = output_html($inp_iso_two);
			$inp_iso_two_mysql = quote_smart($link, $inp_iso_two);

			$inp_iso_three = $_POST['inp_iso_three'];
			$inp_iso_three = output_html($inp_iso_three);
			$inp_iso_three_mysql = quote_smart($link, $inp_iso_three);

			$inp_iso_two_alt_a = $_POST['inp_iso_two_alt_a'];
			$inp_iso_two_alt_a = output_html($inp_iso_two_alt_a);
			$inp_iso_two_alt_a_mysql = quote_smart($link, $inp_iso_two_alt_a);

			$inp_iso_two_alt_b = $_POST['inp_iso_two_alt_b'];
			$inp_iso_two_alt_b = output_html($inp_iso_two_alt_b);
			$inp_iso_two_alt_b_mysql = quote_smart($link, $inp_iso_two_alt_b);

			$inp_charset = $_POST['inp_charset'];
			$inp_charset = output_html($inp_charset);
			$inp_charset_mysql = quote_smart($link, $inp_charset);

			$result = mysqli_query($link, "UPDATE $t_languages SET 
							language_name=$inp_name_mysql,
							language_slug=$inp_name_clean_mysql,
							language_native_name=$inp_native_name_mysql,
							language_iso_two=$inp_iso_two_mysql,
							language_iso_three=$inp_iso_three_mysql,
							language_iso_two_alt_a=$inp_iso_two_alt_a_mysql,
							language_iso_two_alt_b=$inp_iso_two_alt_b_mysql,
							language_charset=$inp_charset_mysql
							WHERE language_id=$get_current_language_id") or die(mysqli_error($link));

			// Icon 16x16
			$name = stripslashes($_FILES['inp_flag_16x16']['name']);
			$name = output_html($name);
			$extension = get_extension($name);
			$extension = strtolower($extension);

			$ft_image_a = "";
			$fm_image_a = "";
			if($name){
				if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) {
					$ft_image_a = "warning";
					$fm_image_a = "unknown_file_extension";
				}
				else{
					$new_path = "_design/gfx/flags/16x16/";
					$uploaded_file = $new_path . $name ;

					// Upload file
					if (move_uploaded_file($_FILES['inp_flag_16x16']['tmp_name'], $uploaded_file)) {
	

						// Get image size
						$file_size = filesize($uploaded_file);
						
						// Check with and height
						list($width,$height) = getimagesize($uploaded_file);
	
						if($width == "" OR $height == ""){
							$ft_image_a = "warning";
							$fm_image_a = "getimagesize_failed";
							unlink($uploaded_file);
						}
						else{
							$ft_image_a = "success";
							$fm_image_a = "flag_16x16_uploaded";
							$inp_flag_mysql = quote_smart($link, $name);
							$result = mysqli_query($link, "UPDATE $t_languages SET 
											language_flag_path_16x16='_admin/_design/gfx/flags/16x16',
											language_flag_16x16=$inp_flag_mysql
							WHERE language_id=$get_current_language_id") or die(mysqli_error($link));
							
						}  // if($width == "" OR $height == ""){
					} // move_uploaded_file
					else{
						$ft_image_a = "warning";
						switch ($_FILES['inp_food_image']['error']) {
							case UPLOAD_ERR_OK:
           							$fm_image_a = "There is no error, the file uploaded with success.";
								break;
							case UPLOAD_ERR_NO_FILE:
           							// $fm_image = "no_file_uploaded";
								break;
							case UPLOAD_ERR_INI_SIZE:
           							$fm_image_a = "to_big_size_in_configuration";
								break;
							case UPLOAD_ERR_FORM_SIZE:
           							$fm_image_a = "to_big_size_in_form";
								break;
							default:
           							$fm_image_a = "unknown_error";
								break;
						}	
					}
				} // extension check
			} // if($image){


			// Icon 32x32
			$name = stripslashes($_FILES['inp_flag_32x32']['name']);
			$name = output_html($name);
			$extension = get_extension($name);
			$extension = strtolower($extension);

			$ft_image_b = "";
			$fm_image_b = "";
			if($name){
				if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) {
					$ft_image_b = "warning";
					$fm_image_b = "unknown_file_extension";
				}
				else{
					$new_path = "_design/gfx/flags/32x32/";
					$uploaded_file = $new_path . $name ;

					// Upload file
					if (move_uploaded_file($_FILES['inp_flag_32x32']['tmp_name'], $uploaded_file)) {
	

						// Get image size
						$file_size = filesize($uploaded_file);
						
						// Check with and height
						list($width,$height) = getimagesize($uploaded_file);
	
						if($width == "" OR $height == ""){
							$ft_image_b = "warning";
							$fm_image_b = "getimagesize_failed";
							unlink($uploaded_file);
						}
						else{
							$ft_image_b = "success";
							$fm_image_b = "flag_32x32_uploaded";
							$inp_flag_mysql = quote_smart($link, $name);
							$result = mysqli_query($link, "UPDATE $t_languages SET 
											language_flag_path_32x32='_admin/_design/gfx/flags/32x32',
											language_flag_32x32=$inp_flag_mysql
							WHERE language_id=$get_current_language_id") or die(mysqli_error($link));
							
						}  // if($width == "" OR $height == ""){
					} // move_uploaded_file
					else{
						$ft_image_b = "warning";
						switch ($_FILES['inp_food_image']['error']) {
							case UPLOAD_ERR_OK:
           							$fm_image_b = "There is no error, the file uploaded with success.";
								break;
							case UPLOAD_ERR_NO_FILE:
           							// $fm_image = "no_file_uploaded";
								break;
							case UPLOAD_ERR_INI_SIZE:
           							$fm_image_b = "to_big_size_in_configuration";
								break;
							case UPLOAD_ERR_FORM_SIZE:
           							$fm_image_b = "to_big_size_in_form";
								break;
							default:
           							$fm_image_b = "unknown_error";
								break;
						}	
					}
				} // extension check
			} // if($image){

			$url = "index.php?open=$open&page=$page&action=edit_language&language_id=$get_current_language_id&editor_language=$editor_language&l=$l&ft=success&fm=changes_saved&ft_image_a=$ft_image_a&fm_image_a=$fm_image_a&ft_image_b=$ft_image_b&fm_image_b=$fm_image_b";
			header("Location: $url");
			exit;
		
		}
		echo"
		<h2>Edit language $get_current_language_name</h2>

		<!-- Where am I? -->
			<p><b>You are here:</b><br />
			<a href=\"index.php?open=$open&amp;page=$page&amp;editor_language=$editor_language\">Languages</a>
			&gt;
			<a href=\"index.php?open=$open&amp;page=$page&amp;action=edit_languages&amp;editor_language=$editor_language\">Edit languages</a>
			&gt;
			<a href=\"index.php?open=$open&amp;page=$page&amp;action=edit_language&amp;language_id=$get_current_language_id&amp;editor_language=$editor_language\">Edit language $get_current_language_name</a>
			</p>
		<!-- //Where am I?  -->


		<!-- Feedback -->
		";
		if($ft != ""){
			$fm = str_replace("_", " ", $fm);
			$fm = ucfirst($fm);
			echo"<div class=\"$ft\"><span>$fm</span></div>";
		}
		echo"	
		<!-- //Feedback -->

		<!-- Edit language form -->
			<!-- Focus -->
				<script>
				\$(document).ready(function(){
					\$('[name=\"inp_food_image\"]').focus();
				});
				</script>
			<!-- //Focus -->

			<form method=\"post\" action=\"index.php?open=$open&amp;page=$page&amp;action=edit_language&amp;language_id=$get_current_language_id&amp;editor_language=$editor_language&amp;process=1\" enctype=\"multipart/form-data\">

			<p>Name:<br />
			<input type=\"text\" name=\"inp_name\" value=\"$get_current_language_name\" size=\"25\" />
			</p>

			<p>Native name:<br />
			<input type=\"text\" name=\"inp_native_name\" value=\"$get_current_language_native_name\" size=\"25\" />
			</p>


			<p>ISO two:<br />
			<input type=\"text\" name=\"inp_iso_two\" value=\"$get_current_language_iso_two\" size=\"25\" />
			</p>

			<p>ISO three:<br />
			<input type=\"text\" name=\"inp_iso_three\" value=\"$get_current_language_iso_three\" size=\"25\" />
			</p>

			<p>ISO two alternative a:<br />
			<input type=\"text\" name=\"inp_iso_two_alt_a\" value=\"$get_current_language_iso_two_alt_a\" size=\"25\" />
			</p>

			<p>ISO two alternative b:<br />
			<input type=\"text\" name=\"inp_iso_two_alt_b\" value=\"$get_current_language_iso_two_alt_b\" size=\"25\" />
			</p>

			<p>Charset:<br />
			<input type=\"text\" name=\"inp_charset\" value=\"$get_current_language_charset\" size=\"25\" />
			</p>

			<p>
			<b>Flag 16x16</b><br />\n";
			if(file_exists("../$get_current_language_flag_path_16x16/$get_current_language_flag_16x16")){
				echo"<img src=\"../$get_current_language_flag_path_16x16/$get_current_language_flag_16x16\" alt=\"$get_current_language_flag_16x16\" /><br />\n";
				
			}
			echo"
			<input type=\"file\" name=\"inp_flag_16x16\" />
			</p>

			<p>
			<b>Flag 32x32</b><br />\n";
			if(file_exists("../$get_current_language_flag_path_32x32/$get_current_language_flag_32x32")){
				echo"<img src=\"../$get_current_language_flag_path_32x32/$get_current_language_flag_32x32\" alt=\"$get_current_language_flag_32x32\" /><br />\n";
				
			}
			echo"
			<input type=\"file\" name=\"inp_flag_32x32\" />
			</p>

			<p> 
			<input type=\"submit\" value=\"Save changes\" class=\"btn\" />
			<a href=\"index.php?open=$open&amp;page=$page&amp;action=delete_language&amp;language_id=$get_current_language_id&amp;editor_language=$editor_language\" class=\"btn_warning\">Delete</a>
			</p>
			</form>
					
		<!-- //Edit language form -->
		";
	} // found
} // action == edit_language
elseif($action == "delete_language"){
	if(isset($_GET['language_id'])) {
		$language_id = $_GET['language_id'];
		$language_id = strip_tags(stripslashes($language_id));
		if(!(is_numeric($language_id))){
			echo"Language not numeric";
			die;
		}
	}
	else{
		echo"Missing language";
		die;
	}
		
	// Locate this language
	$language_id_mysql = quote_smart($link, $language_id);
	$query = "SELECT language_id, language_name, language_slug, language_native_name, language_iso_two, language_iso_three, language_flag_path_16x16, language_flag_16x16, language_flag_path_32x32, language_flag_32x32, language_charset FROM $t_languages WHERE language_id=$language_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_language_id, $get_current_language_name, $get_current_language_slug, $get_current_language_native_name, $get_current_language_iso_two, $get_current_language_iso_three, $get_current_language_flag_path_16x16, $get_current_language_flag_16x16, $get_current_language_flag_path_32x32, $get_current_language_flag_32x32, $get_current_language_charset) = $row;
	if($get_current_language_id == ""){
		echo"Language not found";
	}
	else{
		if($process == "1"){
			$result = mysqli_query($link, "DELETE FROM $t_languages WHERE language_id=$get_current_language_id") or die(mysqli_error($link));

			// Icon 16x16
			if(file_exists("../$get_current_language_flag_path_16x16/$get_current_language_flag_16x16") && $get_current_language_flag_16x16 != ""){
				unlink("../$get_current_language_flag_path_16x16/$get_current_language_flag_16x16");
			}
			


			// Icon 32x32
			if(file_exists("../$get_current_language_flag_path_32x32/$get_current_language_flag_32x32") && $get_current_language_flag_32x32 != ""){
				unlink("../$get_current_language_flag_path_16x16/$get_current_language_flag_32x32");
				
			}
			

			$url = "index.php?open=$open&page=$page&editor_language=$editor_language&l=$l&ft=success&fm=language_deleted";
			header("Location: $url");
			exit;
		
		}
		echo"
		<h2>Delete language $get_current_language_name</h2>

		<!-- Where am I? -->
			<p><b>You are here:</b><br />
			<a href=\"index.php?open=$open&amp;page=$page&amp;editor_language=$editor_language\">Languages</a>
			&gt;
			<a href=\"index.php?open=$open&amp;page=$page&amp;action=edit_languages&amp;editor_language=$editor_language\">Edit languages</a>
			&gt;
			<a href=\"index.php?open=$open&amp;page=$page&amp;action=edit_language&amp;language_id=$get_current_language_id&amp;editor_language=$editor_language\">Edit language $get_current_language_name</a>
			&gt;
			<a href=\"index.php?open=$open&amp;page=$page&amp;action=delete_language&amp;language_id=$get_current_language_id&amp;editor_language=$editor_language\">Delete</a>
			</p>
		<!-- //Where am I?  -->


		<!-- Feedback -->
		";
		if($ft != ""){
			$fm = str_replace("_", " ", $fm);
			$fm = ucfirst($fm);
			echo"<div class=\"$ft\"><span>$fm</span></div>";
		}
		echo"	
		<!-- //Feedback -->

		<!-- Delete language form -->
			<p>
			Are you sure you want to delete the language?
			</p>

			<p>
			<a href=\"index.php?open=$open&amp;page=$page&amp;action=delete_language&amp;language_id=$get_current_language_id&amp;editor_language=$editor_language&amp;process=1\" class=\"btn_danger\">Confirm</a>
			</p>

		<!-- //Delete language form -->
		";
	} // found
} // action == edit_language
elseif($action == "edit_countries"){

	echo"
	<h2>Edit countries</h2>

	<!-- Where am I? -->
		<p><b>You are here:</b><br />
		<a href=\"index.php?open=$open&amp;page=$page&amp;editor_language=$editor_language\">Languages</a>
		&gt;
		<a href=\"index.php?open=$open&amp;page=$page&amp;action=edit_countries&amp;editor_language=$editor_language\">Edit countries</a>
		</p>
	<!-- //Where am I?  -->


	<!-- Feedback -->
	";
	if($ft != ""){
		$fm = str_replace("_", " ", $fm);
		$fm = ucfirst($fm);
		echo"<div class=\"$ft\"><span>$fm</span></div>";
	}
	echo"	
	<!-- //Feedback -->

	


	<!-- Countries -->
		<table class=\"hor-zebra\">
		 <thead>
		  <tr>
		   <th colspan=\"2\">
			<span>Countries</span>
		   </th>
		  </tr>
		 </thead>
		 <tbody>
		";
		$query = "SELECT country_id, country_name, country_flag_path_16x16, country_flag_16x16 FROM $t_languages_countries ORDER BY country_name ASC";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_country_id, $get_country_name, $get_country_flag_path_16x16, $get_country_flag_16x16) = $row;
	
			echo"
			 <tr>
       			  <td style=\"padding-right:4px;\">
				<a href=\"index.php?open=settings&amp;page=languages&amp;action=edit_country&amp;country_id=$get_country_id&amp;editor_language=$editor_language\" style=\"color:#000;\"><img src=\"../$get_country_flag_path_16x16/$get_country_flag_16x16\" alt=\"$get_country_flag_16x16\" /></a>
			  </td>
       			  <td>
          			<span><a href=\"index.php?open=settings&amp;page=languages&amp;action=edit_country&amp;country_id=$get_country_id&amp;editor_language=$editor_language\" style=\"color:#000;\">$get_country_name</a></span>
			  </td>
     			 </tr>
			";
		}
		echo"
		 </tbody>
		</table>
	<!-- //Countries -->
	";
} // action == edit_country
elseif($action == "edit_country"){
	if(isset($_GET['country_id'])) {
		$country_id = $_GET['country_id'];
		$country_id = strip_tags(stripslashes($country_id));
		if(!(is_numeric($country_id))){
			echo"Country not numeric";
			die;
		}
	}
	else{
		echo"Missing country";
		die;
	}
		
	// Locate this country
	$country_id_mysql = quote_smart($link, $country_id);
	$query = "SELECT country_id, country_name, country_name_clean, country_native_name, country_iso_two, country_iso_three, country_language_alt_a, country_language_alt_b, country_flag_path_16x16, country_flag_16x16, country_flag_path_32x32, country_flag_32x32 FROM $t_languages_countries WHERE country_id=$country_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_country_id, $get_current_country_name, $get_current_country_name_clean, $get_current_country_native_name, $get_current_country_iso_two, $get_current_country_iso_three, $get_current_country_language_alt_a, $get_current_country_language_alt_b, $get_current_country_flag_path_16x16, $get_current_country_flag_16x16, $get_current_country_flag_path_32x32, $get_current_country_flag_32x32) = $row;
	if($get_current_country_id == ""){
		echo"Country not found";
	}
	else{
		if($process == "1"){
			$inp_name = $_POST['inp_name'];
			$inp_name = output_html($inp_name);
			$inp_name_mysql = quote_smart($link, $inp_name);

			$inp_name_clean = clean($inp_name);
			$inp_name_clean_mysql = quote_smart($link, $inp_name_clean);

			$inp_native_name = $_POST['inp_native_name'];
			$inp_native_name = output_html($inp_native_name);
			$inp_native_name_mysql = quote_smart($link, $inp_native_name);

			$inp_iso_two = $_POST['inp_iso_two'];
			$inp_iso_two = output_html($inp_iso_two);
			$inp_iso_two_mysql = quote_smart($link, $inp_iso_two);

			$inp_iso_three = $_POST['inp_iso_three'];
			$inp_iso_three = output_html($inp_iso_three);
			$inp_iso_three_mysql = quote_smart($link, $inp_iso_three);


			$inp_language_alt_a = $_POST['inp_language_alt_a'];
			$inp_language_alt_a = output_html($inp_language_alt_a);
			$inp_language_alt_a_mysql = quote_smart($link, $inp_language_alt_a);

			$inp_language_alt_b = $_POST['inp_language_alt_b'];
			$inp_language_alt_b = output_html($inp_language_alt_b);
			$inp_language_alt_b_mysql = quote_smart($link, $inp_language_alt_b);


			$result = mysqli_query($link, "UPDATE $t_languages_countries SET 
							country_name=$inp_name_mysql, 
							country_name_clean=$inp_name_clean_mysql, 
							country_native_name=$inp_native_name_mysql, 
							country_iso_two=$inp_iso_two_mysql, 
							country_iso_three=$inp_iso_three_mysql, 
							country_language_alt_a=$inp_language_alt_a_mysql, 
							country_language_alt_b=$inp_language_alt_b_mysql
							WHERE country_id=$get_current_country_id") or die(mysqli_error($link));

			// Icon 16x16
			$name = stripslashes($_FILES['inp_flag_16x16']['name']);
			$name = output_html($name);
			$extension = get_extension($name);
			$extension = strtolower($extension);

			$ft_image_a = "";
			$fm_image_a = "";
			if($name){
				if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) {
					$ft_image_a = "warning";
					$fm_image_a = "unknown_file_extension";
				}
				else{
					$new_path = "_design/gfx/flags/16x16/";
					$uploaded_file = $new_path . $name ;

					// Upload file
					if (move_uploaded_file($_FILES['inp_flag_16x16']['tmp_name'], $uploaded_file)) {
	

						// Get image size
						$file_size = filesize($uploaded_file);
						
						// Check with and height
						list($width,$height) = getimagesize($uploaded_file);
	
						if($width == "" OR $height == ""){
							$ft_image_a = "warning";
							$fm_image_a = "getimagesize_failed";
							unlink($uploaded_file);
						}
						else{
							$ft_image_a = "success";
							$fm_image_a = "flag_16x16_uploaded";
							$inp_flag_mysql = quote_smart($link, $name);
							$result = mysqli_query($link, "UPDATE $t_languages_countries SET 
											country_flag_path_16x16='_admin/_design/gfx/flags/16x16',
											country_flag_16x16=$inp_flag_mysql
							WHERE country_id=$get_current_country_id") or die(mysqli_error($link));
							
						}  // if($width == "" OR $height == ""){
					} // move_uploaded_file
					else{
						$ft_image_a = "warning";
						switch ($_FILES['inp_food_image']['error']) {
							case UPLOAD_ERR_OK:
           							$fm_image_a = "There is no error, the file uploaded with success.";
								break;
							case UPLOAD_ERR_NO_FILE:
           							// $fm_image = "no_file_uploaded";
								break;
							case UPLOAD_ERR_INI_SIZE:
           							$fm_image_a = "to_big_size_in_configuration";
								break;
							case UPLOAD_ERR_FORM_SIZE:
           							$fm_image_a = "to_big_size_in_form";
								break;
							default:
           							$fm_image_a = "unknown_error";
								break;
						}	
					}
				} // extension check
			} // if($image){


			// Icon 32x32
			$name = stripslashes($_FILES['inp_flag_32x32']['name']);
			$name = output_html($name);
			$extension = get_extension($name);
			$extension = strtolower($extension);

			$ft_image_b = "";
			$fm_image_b = "";
			if($name){
				if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) {
					$ft_image_b = "warning";
					$fm_image_b = "unknown_file_extension";
				}
				else{
					$new_path = "_design/gfx/flags/32x32/";
					$uploaded_file = $new_path . $name ;

					// Upload file
					if (move_uploaded_file($_FILES['inp_flag_32x32']['tmp_name'], $uploaded_file)) {
	

						// Get image size
						$file_size = filesize($uploaded_file);
						
						// Check with and height
						list($width,$height) = getimagesize($uploaded_file);
	
						if($width == "" OR $height == ""){
							$ft_image_b = "warning";
							$fm_image_b = "getimagesize_failed";
							unlink($uploaded_file);
						}
						else{
							$ft_image_b = "success";
							$fm_image_b = "flag_32x32_uploaded";
							$inp_flag_mysql = quote_smart($link, $name);
							$result = mysqli_query($link, "UPDATE $t_languages_countries SET 
											country_flag_path_32x32='_admin/_design/gfx/flags/32x32',
											country_flag_32x32=$inp_flag_mysql
							WHERE country_id=$get_current_country_id") or die(mysqli_error($link));
							
						}  // if($width == "" OR $height == ""){
					} // move_uploaded_file
					else{
						$ft_image_b = "warning";
						switch ($_FILES['inp_food_image']['error']) {
							case UPLOAD_ERR_OK:
           							$fm_image_b = "There is no error, the file uploaded with success.";
								break;
							case UPLOAD_ERR_NO_FILE:
           							// $fm_image = "no_file_uploaded";
								break;
							case UPLOAD_ERR_INI_SIZE:
           							$fm_image_b = "to_big_size_in_configuration";
								break;
							case UPLOAD_ERR_FORM_SIZE:
           							$fm_image_b = "to_big_size_in_form";
								break;
							default:
           							$fm_image_b = "unknown_error";
								break;
						}	
					}
				} // extension check
			} // if($image){

			$url = "index.php?open=$open&page=$page&action=edit_country&country_id=$get_current_country_id&editor_language=$editor_language&l=$l&ft=success&fm=changes_saved&ft_image_a=$ft_image_a&fm_image_a=$fm_image_a&ft_image_b=$ft_image_b&fm_image_b=$fm_image_b";
			header("Location: $url");
			exit;
		
		}
		echo"
		<h2>Edit country $get_current_country_name</h2>

		<!-- Where am I? -->
			<p><b>You are here:</b><br />
			<a href=\"index.php?open=$open&amp;page=$page&amp;editor_language=$editor_language\">Languages</a>
			&gt;
			<a href=\"index.php?open=$open&amp;page=$page&amp;action=edit_countries&amp;editor_language=$editor_language\">Edit countries</a>
			&gt;
			<a href=\"index.php?open=$open&amp;page=$page&amp;action=edit_country&amp;country_id=$get_current_country_id&amp;editor_language=$editor_language\">Edit country $get_current_country_name</a>
			</p>
		<!-- //Where am I?  -->


		<!-- Feedback -->
		";
		if($ft != ""){
			$fm = str_replace("_", " ", $fm);
			$fm = ucfirst($fm);
			echo"<div class=\"$ft\"><span>$fm</span></div>";
		}
		echo"	
		<!-- //Feedback -->

		<!-- Edit country form -->
			<!-- Focus -->
				<script>
				\$(document).ready(function(){
					\$('[name=\"inp_food_image\"]').focus();
				});
				</script>
			<!-- //Focus -->

			<form method=\"post\" action=\"index.php?open=$open&amp;page=$page&amp;action=edit_country&amp;country_id=$get_current_country_id&amp;editor_language=$editor_language&amp;process=1\" enctype=\"multipart/form-data\">

			<p>Name:<br />
			<input type=\"text\" name=\"inp_name\" value=\"$get_current_country_name\" size=\"25\" />
			</p>

			<p>Native name:<br />
			<input type=\"text\" name=\"inp_native_name\" value=\"$get_current_country_native_name\" size=\"25\" />
			</p>

			<p>ISO two:<br />
			<input type=\"text\" name=\"inp_iso_two\" value=\"$get_current_country_iso_two\" size=\"25\" />
			</p>

			<p>ISO three:<br />
			<input type=\"text\" name=\"inp_iso_three\" value=\"$get_current_country_iso_three\" size=\"25\" />
			</p>

			<p>Language alternative a:<br />
			<select name=\"inp_language_alt_a\">
				<option value=\"\""; if($get_current_country_language_alt_a == ""){ echo" selected=\"selected\""; } echo">-</option>\n";
			$query = "SELECT language_id, language_name, language_iso_two, language_flag_path_16x16, language_flag_16x16 FROM $t_languages ORDER BY language_name ASC";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_language_id, $get_language_name, $get_language_iso_two, $get_language_flag_path_16x16, $get_language_flag_16x16) = $row;
				echo"				";
				echo"<option value=\"$get_language_iso_two\""; if($get_current_country_language_alt_a == "$get_language_iso_two"){ echo" selected=\"selected\""; } echo">$get_language_name</option>\n";
			}
			echo"
			</select>
			</p>

			<p>Language alternative b:<br />
			<select name=\"inp_language_alt_b\">
				<option value=\"\""; if($get_current_country_language_alt_b == ""){ echo" selected=\"selected\""; } echo">-</option>\n";
			$query = "SELECT language_id, language_name, language_iso_two, language_flag_path_16x16, language_flag_16x16 FROM $t_languages ORDER BY language_name ASC";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_language_id, $get_language_name, $get_language_iso_two, $get_language_flag_path_16x16, $get_language_flag_16x16) = $row;
				echo"				";
				echo"<option value=\"$get_language_iso_two\""; if($get_current_country_language_alt_b == "$get_language_iso_two"){ echo" selected=\"selected\""; } echo">$get_language_name</option>\n";
			}
			echo"
			</select>
			</p>


			<p>
			<b>Flag 16x16</b><br />\n";
			if(file_exists("../$get_current_country_flag_path_16x16/$get_current_country_flag_16x16")){
				echo"<img src=\"../$get_current_country_flag_path_16x16/$get_current_country_flag_16x16\" alt=\"$get_current_country_flag_16x16\" /><br />\n";
				
			}
			echo"
			<input type=\"file\" name=\"inp_flag_16x16\" />
			</p>

			<p>
			<b>Flag 32x32</b><br />\n";
			if(file_exists("../$get_current_country_flag_path_32x32/$get_current_country_flag_32x32")){
				echo"<img src=\"../$get_current_country_flag_path_32x32/$get_current_country_flag_32x32\" alt=\"$get_current_country_flag_32x32\" /><br />\n";
				
			}
			echo"
			<input type=\"file\" name=\"inp_flag_32x32\" />
			</p>

			<p> 
			<input type=\"submit\" value=\"Save changes\" class=\"btn\" />
			<a href=\"index.php?open=$open&amp;page=$page&amp;action=delete_country&amp;country_id=$get_current_country_id&amp;editor_language=$editor_language\" class=\"btn_warning\">Delete</a>
			</p>
			</form>
					
		<!-- //Edit country form -->
		";
	} // found
} // action == edit_country
elseif($action == "delete_country"){
	if(isset($_GET['country_id'])) {
		$country_id = $_GET['country_id'];
		$country_id = strip_tags(stripslashes($country_id));
		if(!(is_numeric($country_id))){
			echo"Country not numeric";
			die;
		}
	}
	else{
		echo"Missing country";
		die;
	}
		
	// Locate this country
	$country_id_mysql = quote_smart($link, $country_id);
	$query = "SELECT country_id, country_name, country_name_clean, country_native_name, country_iso_two, country_iso_three, country_language_alt_a, country_language_alt_b, country_flag_path_16x16, country_flag_16x16, country_flag_path_32x32, country_flag_32x32 FROM $t_languages_countries WHERE country_id=$country_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_country_id, $get_current_country_name, $get_current_country_name_clean, $get_current_country_native_name, $get_current_country_iso_two, $get_current_country_iso_three, $get_current_country_language_alt_a, $get_current_country_language_alt_b, $get_current_country_flag_path_16x16, $get_current_country_flag_16x16, $get_current_country_flag_path_32x32, $get_current_country_flag_32x32) = $row;
	if($get_current_country_id == ""){
		echo"Country not found";
	}
	else{
		if($process == "1"){
			$result = mysqli_query($link, "DELETE FROM $t_languages_countries WHERE country_id=$get_current_country_id") or die(mysqli_error($link));

			// Icon 16x16
			if(file_exists("../$get_current_country_flag_path_16x16/$get_current_country_flag_16x16") && $get_current_country_flag_16x16 != ""){
				unlink("../$get_current_country_flag_path_16x16/$get_current_country_flag_16x16");
			}
			


			// Icon 32x32
			if(file_exists("../$get_current_country_flag_path_32x32/$get_current_country_flag_32x32") && $get_current_country_flag_32x32 != ""){
				unlink("../$get_current_country_flag_path_16x16/$get_current_country_flag_32x32");
				
			}
			

			$url = "index.php?open=$open&page=$page&editor_language=$editor_language&l=$l&ft=success&fm=country_deleted";
			header("Location: $url");
			exit;
		
		}
		echo"
		<h2>Delete country $get_current_country_name</h2>

		<!-- Where am I? -->
			<p><b>You are here:</b><br />
			<a href=\"index.php?open=$open&amp;page=$page&amp;editor_language=$editor_language\">Languages</a>
			&gt;
			<a href=\"index.php?open=$open&amp;page=$page&amp;action=edit_countries&amp;editor_language=$editor_language\">Edit countries</a>
			&gt;
			<a href=\"index.php?open=$open&amp;page=$page&amp;action=edit_country&amp;country_id=$get_current_country_id&amp;editor_language=$editor_language\">Edit country $get_current_country_name</a>
			&gt;
			<a href=\"index.php?open=$open&amp;page=$page&amp;action=delete_country&amp;country_id=$get_current_country_id&amp;editor_language=$editor_language\">Delete country $get_current_country_name</a>
			</p>
		<!-- //Where am I?  -->


		<!-- Feedback -->
		";
		if($ft != ""){
			$fm = str_replace("_", " ", $fm);
			$fm = ucfirst($fm);
			echo"<div class=\"$ft\"><span>$fm</span></div>";
		}
		echo"	
		<!-- //Feedback -->

		<!-- Delete country form -->
			<p>
			Are you sure you want to delete the country?
			</p>

			<p>
			<a href=\"index.php?open=$open&amp;page=$page&amp;action=delete_country&amp;country_id=$get_current_country_id&amp;editor_language=$editor_language&amp;process=1\" class=\"btn_danger\">Confirm</a>
			</p>

		<!-- //Delete country form -->
		";
	} // found
} // action == edit_country
?>