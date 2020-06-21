<!DOCTYPE html>
<html >
<head>
<meta charset="utf-8">
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<title>Earn Points-Mypixal</title>
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>
<link rel="stylesheet"  type="text/css" href="picsd.css" />
</head>
<body>
<?php
try {
	if(!isset($_COOKIE['piconusername'])&&empty($_COOKIE['piconusername']))
	{
	header("location:mypixalsignup.php");
	}
	include("php_helper.php");
	include("headerd.php");
	?>
	<div class="container">
		<div class="jumbotron jumbotron-custom2">
			<center>
			<p class="heading">Instructions</p>
			</center>
			<ul style="font-size:1.2em;">
			<li>If a pic uploaded by you get on to the top 5 you will earn 3 points.</li></br>
			<li>If a pic liked by you get on to the top 5 you will earn 2 points.</li></br>
			<li>Your popularity depends upon the no of people add you as their favourites.</li></br>
			<li>In people's profile you can comment anything about their personality.</li></br>
			</ul>
		</div>
	</div>
	<?php
	echo "<center>";
	include("footerd.php");
	echo "</center>";
} catch(Exception $ex) {
	echo $ex->getMessage();
}
?>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
