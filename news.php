<?php
ob_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
 <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<title>News-Mypixal</title>
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>
<link rel='stylesheet' href="picsd.css" type="text/css" />
</head>
<body>
<?php
try {
	include("php_helper.php");
	include("headerd.php");
	include("connect.php");
	if(!isset($_COOKIE['piconusername'])&&empty($_COOKIE['piconusername']))//logged in.
	{
	header("location:mypixalsignup.php");
	}
	?>
	<div class="container">
		<div class="jumbotron jumbotron-custom1">
			<center>
			<p class="heading">Notifications</p>
			</center>
			<div class="cover-page">
	<?php
	$profile_id=$_COOKIE['piconprofile_id'];//'picweeksf' id.
	$flag=1;
	$flag1=0;
	echo '<table class="table table-striped">';
	$query=mysqli_query_or_throw_error($con, "select * from `picweekpp` order by `likes` desc limit 5");//select top 5 pic from 'picweekpp' sort by likes.
	while($row=mysqli_fetch_assoc($query))//fetching pics.
	{
	$status=$row['status'];//status of extracted pic.
	$profile_id1=$row['profile_id'];//profile_id of uploader.
	if($status==0&&$profile_id1==$profile_id)//if uploader is 'user'.
	{
	$flag1++;
	}
	}
	if($flag1!=0)
	{
	$points=$flag1*3;
	echo "<tr><td><a  href='profilepicd.php'>".$flag.". You have earned \"".$points."\" points  as <b>\"".$flag1."\"</b> of your uploaded pic in Display-pic category got on to the top 5.</a></td></tr>";//print news of earning 3 points in 'profile pic' category.
	$flag++;
	}
	$flag1=0;
	$query=mysqli_query_or_throw_error($con, "select * from `picweekfp` order by `likes` desc limit 5");//extract top 5 pics from 'funny pic ' category.
	while($row=mysqli_fetch_assoc($query))
	{
	$status=$row['status'];//status of extracted pic.
	$profile_id1=$row['profile_id'];
	if($status==0&&$profile_id1==$profile_id)
	{
	$flag1++;
	}
	}
	if($flag1!=0)
	{
	$points=$flag1*3;
	echo "<tr><td><a href='funnypicd.php' >".$flag.". You have earned \"".$points."\" points  as <b>\"".$flag1."\"</b> of your uploaded pic in Funny-pic category got on to the top 5.</a></td></tr>";//print news of earning 3 points in 'funny pic ' category.
	$flag++;
	}
	$flag1=0;
	$query=mysqli_query_or_throw_error($con, "select * from `picweekcp`  order by `likes` desc limit 5");
	while($row=mysqli_fetch_assoc($query))//select top 5 images from 'creative pic ' category.
	{
	$status=$row['status'];
	$profile_id1=$row['profile_id'];
	if($status==0&&$profile_id1==$profile_id)
	{
	$flag1++;
	}
	}
	if($flag1!=0)
	{
	$points=$flag1*3;
	echo "<tr><td><a  href='selfied.php'>".$flag.". You have earned \"".$points."\" points  as <b>\"".$flag1."\"</b> of your uploaded pic in Selfie category got on to the top 5.</a></td></tr>";//print news of earning 3 points in 'creativepic' category.
	$flag++;
	}
	$flag1=0;
	$query=mysqli_query_or_throw_error($con, "select * from `picweekpp` order by `likes` desc limit 5");//extract top 5 of 'picweekpp'.
	while($row=mysqli_fetch_assoc($query))
	{
	$name=$row['name'];
	$q=mysqli_query_or_throw_error($con, "select * from `likes` where `profile_id`='$profile_id' && `name`='$name' && `status`='0'");//checking if user has earned any point in liking any image.
	if(mysqli_num_rows($q)!=0)
	{
	$flag1++;
	}
	}
	if($flag1!=0)
	{
	$points=$flag1*2;
	echo "<tr><td><a  href='profilepicd.php'>".$flag.". You have earned \"".$points."\" points as <b>\"".$flag1."\"</b> of your liked pic in Display-pic category got on to the top 5.</a></td></tr> ";//print news of earning points in liking image.
	$flag++;
	}
	$flag1=0;
	$query=mysqli_query_or_throw_error($con, "select * from `picweekfp` order by `likes` desc limit 5");//extract top 5 of 'picweekfp'.
	while($row=mysqli_fetch_assoc($query))
	{
	$name=$row['name'];
	$q=mysqli_query_or_throw_error($con, "select * from `likes` where `profile_id`='$profile_id' && `name`='$name' && `status`='0'");//checking if user has earned any point in liking 
	if(mysqli_num_rows($q)!=0)
	{
	$flag1++;
	}
	}
	if($flag1!=0)
	{
	$points=$flag1*2;
	echo "<tr><td><a href='funnypicd.php'>".$flag.". You have earned \"".$points."\" points as <b>\"".$flag1."\"</b> of your liked pic in Funny-pic category got on to the top 5.</a></td></tr> ";//print news of earning points.
	$flag++;
	}
	$flag1=0;
	$query=mysqli_query_or_throw_error($con, "select * from `picweekcp` order by `likes` desc limit 5");//extract top 5 of 'picweekcp'.
	while($row=mysqli_fetch_assoc($query))
	{
	$name=$row['name'];
	$q=mysqli_query_or_throw_error($con, "select * from `likes` where `profile_id`='$profile_id' && `name`='$name' && `status`='0'");//checking if user has earned any point.
	if(mysqli_num_rows($q)!=0)
	{
	$flag1++;
	}
	}
	if($flag1!=0)
	{
	$points=$flag1*2;
	echo "<tr><td><a href='selfied.php'>".$flag.". You have earned \"".$points."\" points as <b>\"".$flag1."\"</b> of your liked pic in Selfie category got on to the top 5.</a></td></tr> ";//news of earning points.
	$flag++;
	}
	$query=mysqli_query_or_throw_error($con, "select * from `popular` where `liked`='$profile_id' && `status`='0'");//checking if you have earned any popularity.
	if(mysqli_num_rows($query)!=0)
	{
	$query=mysqli_query_or_throw_error($con, "select * from `profile`");
	$total=mysqli_num_rows($query);
	$query=mysqli_query_or_throw_error($con, "select `popular` from `profile` where `profile_id`='$profile_id'") ;//extract 'popular' of user from 'profile'.
	$pop=mysqli_fetch_assoc($query);
	$pop=$pop['popular'];
	$pop=($pop/$total)*100;
	echo "<tr><td><a  href='mostpopulard.php'>".$flag.". Your popularity is now <b>".round($pop,3)."%</b>.</a></td></tr>";//print news of popularity of user.
	$flag++;
	}
	$query=mysqli_query_or_throw_error($con, "select * from `positives` where `for`='$profile_id' && `status`='0'");//select new 'positives' for user from 'positives' if any.
	if(mysqli_num_rows($query)!=0)
	{
	$total=mysqli_num_rows($query);
	echo "<tr><td><a  href='profiled.php'>".$flag.". <b>".$total."</b> new comments.</a></td></tr>";//print positives.
	$flag++;
	}
	if($flag==1)
	{
	echo '<div class="margin-none">
			<center><p class="heading1">No notifications</p></center>
			</div>';
	}
	?>
	</table>
	</div>
	</div>
	</div>
	<?php
	echo "<center>";
	include("footerd.php");//include footer file.
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