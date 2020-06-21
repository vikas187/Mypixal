<?php
ob_start();
?>
<!DOCTYPE html>
<html >
<head>
<meta http-equiv="Content-Type" content="text/html;" />
<meta charset="utf-8"/>
 <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
 <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<title>Points-Table</title>
<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="picsd.css"/>

</head>
<body>
<?php
try {
	if(!isset($_COOKIE['piconusername'])&&empty($_COOKIE['piconusername']))//logged in.
	{
	header("location:mysignup.php");
	}
	include("php_helper.php");
	include("headerd.php");
	include("connect.php");
	$flag=1;	
	$query=mysqli_query_or_throw_error($con, "select * from `profile` order by `points` desc");//select users from 'profile' by their points.
	if((mysqli_num_rows($query))!=0)
	{
	?>
	<div class="container">
		<div class="jumbotron jumbotron-custom1">
			<center>
			<p class="heading">Points-table</p>
			<div class="row">
	<?php
	while($row=mysqli_fetch_assoc($query))
	{
		echo "<div class='col-md-4'>";
		echo "<div class='margin-image'>";
	$profile_id=$row['profile_id'];//profile id of user.
	$name=$row['name'];//name
	$points=$row['points'];//points.
	$photo_name=$row['photo_name'];
	echo "<div class='thumbnail'><a href='fullprofilepic1.php?name=$photo_name'><img width='90%' class='image' src='profile_th/$photo_name'/></a></br>";//profile pic of user.
	echo $flag.".<a  href='profile2d.php?profile_id=$profile_id'>".$name."</a></br>";//link of name.
	echo "Points:".$points;//points.
	$flag++;
	echo "</div>";
		echo "</div>";
		echo "</div>";
	if($flag==51)//top 50.
	{
	break;
	}
	}
		echo "</div>";
		echo "</center>";
		echo "</div>";
		echo "</div>";
	}
	else
	{
	?>
	<div class="container">
		<div class="jumbotron jumbotron-none"  >
			<center>
			No one has created profile yet
			</center>
		</div>
	</div>
	<?php
	}
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
<?php
ob_end_flush();
?>
