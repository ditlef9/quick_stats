<?php
/* Stats */
include("_stats/reg_stats.php");


echo"<!DOCTYPE html>
<html lang=\"en\">
<head>
	<title>My website :-)</title>
	<meta name=\"viewport\" content=\"width=device-width; initial-scale=1.0;\"/>
	<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UFT-8\" />";

	// Draw a image
	// Draw a image: the part you already have; creates 538x616 px black image

	$im = @imagecreatetruecolor(120, 20) or die('Cannot Initialize new GD image stream');
	$text_color = imagecolorallocate($im, 233, 14, 91);
	imagestring($im, 1, 5, 5,  'A Simple Text String', $text_color);
	imagepng($im, "_stats/_cache/listing-img-empty.8088d244a$get_tracker_id.png");
	imagedestroy($im);

	echo"
	<link rel=\"image_src\" href=\"_stats/_cache/listing-img-empty.8088d244a$get_tracker_id.png\"/>
</head>
<body>

<h1>My website</h1>
<p>Welcome to my website!</p>

</body>
</html>";
?>