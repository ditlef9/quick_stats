<?php
/* Stats */
include("_stats/reg_stats.php");


echo"<!DOCTYPE html>
<html lang=\"en\">
<head>
	<title>Quick Stats</title>
	<meta name=\"viewport\" content=\"width=device-width; initial-scale=1.0;\"/>
	<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UFT-8\" />

	<!-- Favicon -->
		<link rel=\"icon\" href=\"_stats/_layout/favicon/stats_16x16.png\" type=\"image/png\" sizes=\"16x16\" />
		<link rel=\"icon\" href=\"_stats/_layout/favicon/stats_32x32.png\" type=\"image/png\" sizes=\"32x32\" />
		<link rel=\"icon\" href=\"_stats/_layout/favicon/stats_256x256.png\" type=\"image/png\" sizes=\"256x256\" />
	<!-- //Favicon -->


	<meta name=\"viewport\" content=\"width=device-width; initial-scale=1.0;\"/>
	<link rel=\"stylesheet\" href=\"_stats/login/_login_design/login.css?datetime="; echo date("ymdhis"); echo"\" type=\"text/css\" />
	<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UFT-8\" />


</head>
<body>
<div class=\"body_bg\">
	<div class=\"wrapper\">
		<!-- Header -->
			<header>
				<p>Quick Stats <span>Website</span></p>
			</header>
		<!-- //Header -->

		
		<!-- Main -->
			<div id=\"main\">
				<h1>Quick Stats</h1>
	
				<h2>What is Quick Stats?</h2>

				<p>
				Quick Stats is a self hosted statistics script written
				in PHP and MySQL. 
				It allows you to collects visitor data from your website guests and presents them in diffrent graphs.
				</p>
							
				<p>Use Quick stats on your website to track your visitors. The script is self hosted, so you dont have to rely on external suppliers in order to have beutiful statistics.
				</p>

				<p>
				The statstics that are collected are
				</p>

				<ul>
					<li><span>Visititors per year, month, week and day</span></li>
					<li><span>Humans vs bots</span></li>
					<li><span>Desktop vs mobile</span></li>
					<li><span>OS</span></li>
					<li><span>Browsers</span></li>
					<li><span>Bots</span></li>
					<li><span>Visitor per country</span></li>
					<li><span>Accepted languages and languages used</span></li>
					<li><span>Comments written on your website</span></li>
					<li><span>Referrers</span></li>
					<li><span>+++</span></li>
				</ul>

				<hr />
	
				<h2>Installing Quick Stats</h2>
				<p>
				After downloading Quick Stats you can go to <a href=\"_stats\">_stats</a> and follow the instructions.
				</p>


				<hr />
	
				<h2>Download Quick Stats</h2>
				<p>
				Quick Stats is release under the GNU General Public License. 
				</p>

				<p>
				<a href=\"https://github.com/ditlef9/quick_stats/archive/refs/heads/main.zip\">Download Quick Stats</a>
				</p>

			</div>
		<!-- //Main -->

		<!-- Footer -->
			<footer>
				<p>
				<a href=\"example_3.php\">Example 3</a>
				&nbsp;
				<a href=\"https://ditlef.net\">Quick Stats Copyright &copy; 2021 Ditlefsen</a>
				</p>
			</footer>
		<!-- //Footer -->

	</div> <!-- //wrapper-->
</div> <!-- //body_bg -->


</body>
</html>";
?>