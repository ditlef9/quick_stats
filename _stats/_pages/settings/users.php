<?php
/**
*
* File: _stats/_pages/settings/users.php
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




/*- MySQL Tables -------------------------------------------------- */
$t_users = $dbPrefixSav . "users";




echo"
<h1>Users</h1>


<!-- Feedback -->
	";
	if($ft != "" && $fm != ""){
		$fm = str_replace("_", " ", $fm);
		$fm = ucfirst($fm);
		echo"<div class=\"$ft\"><p>$fm</p></div>";
	}
	echo"
<!-- //Feedback -->


	<!-- Users list -->
	<p>
	<a href=\"index.php?open=$open&amp;page=users_new\" class=\"btn_default\">New user</a>
	</p>

		<table class=\"hor-zebra\">
		 <thead>
		  <tr>
		   <th scope=\"col\">";
			if($order_by == "user_id" && $order_method == "asc"){
				$order_method_link = "desc";
			}
			else{
				$order_method_link = "asc";
			}

			echo"
			<span><a href=\"index.php?open=$open&amp;page=$page&amp;order_by=user_id&amp;order_method=$order_method_link\" style=\"color:black;\"><b>ID</b></a>";
			if($order_by == "user_id" && $order_method == "asc"){
				echo"<img src=\"_layout/gfx/arrow_down.png\" alt=\"arrow_down.png\" />";
			}
			if($order_by == "user_id" && $order_method == "desc"){
				echo"<img src=\"_layout/gfx/arrow_up.png\" alt=\"arrow_up.png\" />";
			}
			echo"</span>
		   </th>
		   <th scope=\"col\">";
			if($order_by == "user_name" && $order_method == "asc"){
				$order_method_link = "desc";
			}
			else{
				$order_method_link = "asc";
			}

			echo"
			<span><a href=\"index.php?open=$open&amp;page=$page&amp;order_by=user_name&amp;order_method=$order_method_link\" style=\"color:black;\"><b>User name</b></a>";
			if($order_by == "user_name" && $order_method == "asc"){
				echo"<img src=\"_layout/gfx/arrow_down.png\" alt=\"arrow_down.png\" />";
			}
			if($order_by == "user_name" && $order_method == "desc"){
				echo"<img src=\"_layout/gfx/arrow_up.png\" alt=\"arrow_up.png\" />";
			}
			echo"</span>
		   </th>
		   <th scope=\"col\">";
			if($order_by == "user_email" && $order_method == "asc"){
				$order_method_link = "desc";
			}
			else{
				$order_method_link = "asc";
			}

			echo"
			<span><a href=\"index.php?open=$open&amp;page=$page&amp;order_by=user_email&amp;order_method=$order_method_link\" style=\"color:black;\"><b>E-mail</b></a>";
			if($order_by == "user_email" && $order_method == "asc"){
				echo"<img src=\"_layout/gfx/arrow_down.png\" alt=\"arrow_down.png\" />";
			}
			if($order_by == "user_email" && $order_method == "desc"){
				echo"<img src=\"_layout/gfx/arrow_up.png\" alt=\"arrow_up.png\" />";
			}
			echo"</span>
		   </th>
		   <th scope=\"col\">";
			if($order_by == "user_rank" && $order_method == "asc"){
				$order_method_link = "desc";
			}
			else{
				$order_method_link = "asc";
			}

			echo"
			<span><a href=\"index.php?open=$open&amp;page=$page&amp;order_by=user_rank&amp;order_method=$order_method_link\" style=\"color:black;\"><b>Rank</b></a>";
			if($order_by == "user_rank" && $order_method == "asc"){
				echo"<img src=\"_layout/gfx/arrow_down.png\" alt=\"arrow_down.png\" />";
			}
			if($order_by == "user_rank" && $order_method == "desc"){
				echo"<img src=\"_layout/gfx/arrow_up.png\" alt=\"arrow_up.png\" />";
			}
			echo"</span>
		   </th>
		   <th scope=\"col\">
			<span>Actions</span>
		   </th>
		  </tr>
		</thead>
		<tbody>


	";
	$query = "SELECT user_id, user_email, user_name, user_rank FROM $t_users";
	if($order_by == "user_id" OR $order_by == "user_email" OR $order_by == "user_name" OR $order_by == "user_rank"){
		if($order_method == "asc"){
			$query = $query . " ORDER BY $order_by ASC";
		}
		else{
			$query = $query . " ORDER BY $order_by DESC";
		}
	}

	$result = mysqli_query($link, $query);
	while($row = mysqli_fetch_row($result)) {
		list($get_user_id, $get_user_email, $get_user_name, $get_user_rank) = $row;

		echo"
		 <tr>
		  <td>
			<span><a href=\"index.php?open=$open&amp;page=users_edit&amp;user_id=$get_user_id\">$get_user_id</a></span>
		  </td>
		  <td>
			<span><a href=\"index.php?open=$open&amp;page=users_edit&amp;user_id=$get_user_id\">$get_user_name</a></span>
		  </td>
		  <td>
			<span>$get_user_email</span>
		  </td>
		  <td>
			<span>$get_user_rank</span>
		  </td>
		  <td>
			<span>
			<span><a href=\"index.php?open=$open&amp;page=users_edit&amp;user_id=$get_user_id\">Edit</a>
			| 
			<span><a href=\"index.php?open=$open&amp;page=users_delete&amp;user_id=$get_user_id\">Delete</a>
			</span>
		  </td>
		 </tr>
		";

	}
	echo"
	
		 </tbody>
		</table>
	<!-- //Users list -->
	";
?>