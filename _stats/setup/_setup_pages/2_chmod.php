<?php
/*- Check if setup is finished ------------------------------------------------------ */
if(file_exists("../_data/setup_finished.php")){
	echo"<p>Setup is finished.</p>";
	die;
}


/*- Functions  ------------------------------------------------------------ */
function chmod_r($path) {
    $dir = new DirectoryIterator($path);
    foreach ($dir as $item) {
        chmod($item->getPathname(), 0777);
        if ($item->isDir() && !$item->isDot()) {
            chmod_r($item->getPathname());
        }
    }
}


/*- Scriptstart ---------------------------------------------------------------------------- */
$directories = array(
			"../_data",
);



echo"
<h1>Chmod</h1>

<p>
The server will now try to give write permissions to the directories
</p>

	<table class=\"hor-zebra\">
	 <thead>
	  <tr>
	   <th scope=\"col\">
		<span>Directory</span>
	   </th>
	   <th scope=\"col\">
		<span>Status</span>
	   </th>
	  </tr>
	</thead>
	<tbody>
";

for($x=0;$x<sizeof($directories);$x++){
	echo"
	 <tr>
	  <td>
		<span><a href=\"$directories[$x]\">$directories[$x]</a></span>
	  </td>
	  <td>
		";
		// Does folder exist?
		if(!(is_dir("$directories[$x]"))){
			mkdir("$directories[$x]");
		}
		// Try to write
		$fh = fopen("$directories[$x]/index.html", "w") or die("can not open file");
		fwrite($fh, "Server error 403");
		fclose($fh);

		// Chmod the directory
		if(!(file_exists("$directories[$x]/index.html"))){
			chmod_r("$directories[$x]");

			// Try to rewrite now
			$fh = fopen("$directories[$x]/index.html", "w") or die("can not open file");
			fwrite($fh, "Server error 403");
			fclose($fh);

		}	

		if(file_exists("$directories[$x]/index.html")){
			echo"<span style=\"color: green;\">Writable</span>\n";
		}
		else{
			echo"<span style=\"color: red;\">Not writable</span>\n";
		}
		echo"
	  </td>
	 </tr>
	";
} // for
echo"
	 </tbody>
	</table>
	<div style=\"height:20px;\"></div>
<p>
<a href=\"index.php?page=3_database\" class=\"btn_default\">Continue</a>
</p>
";

?>

