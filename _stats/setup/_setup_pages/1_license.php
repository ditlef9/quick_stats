<?php
/*- Check if setup is finished ------------------------------------------------------ */
if(file_exists("../_data/setup_finished.php")){
	echo"<p>Setup is finished.</p>";
	die;
}


/*- Read licence -*/
$file = "../../LICENSE";
$fh = fopen($file, "r");
$read_licence = fread($fh, filesize($file));
fclose($fh); 


echo"
<h1>Licence</h1>

<pre>
$read_licence
</pre>

<p>
<a href=\"index.php?page=2_chmod\" class=\"btn_default\">Agree</a>
<a href=\"https://google.com\" class=\"btn_warning\">Decline</a>
</p>

<div style=\"height:10px;\"></div>

";

?>

