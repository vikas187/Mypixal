<?php
ob_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Mypixal</title>
<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css"/>
<link rel="stylesheet" href="picsd.css" type="text/css"/>
</head>
<body>
<?php
try {
	include("php_helper.php");
	include("headerd.php");
	if(!isset($_COOKIE['piconusername'])&&empty($_COOKIE['piconusername']))
	{
	header("location:mypixalsignup.php");
	}
	$profile_id_real=$_COOKIE['piconprofile_id'];//your 'picweeksf' id.
	$profile_id=addslashes($_REQUEST['profile_id']);//requested profile_id.
	if(!isset($_REQUEST['profile_id']))
	{
	header("location:mypixal.php");
	}
	echo "<div class='container'>";
		echo "<div class='jumbotron'>";
		echo "<center>";
	if($profile_id==$profile_id_real)//if requested user is you.
	{

	echo "<p class='heading'>My Photos</p>";
	}
	else
	{
	echo "<p class='heading'>Photos</p>";
	}
	$flag=1;
	$last_page_id = addslashes($_REQUEST['last_id']);
	$query=mysqli_query_or_throw_error($con, "select `id` from `album` where `profile_id`='$profile_id' order by `id` desc limit 1");//extract id of last photo uploaded by user.
	if((mysqli_num_rows($query))!=0)
	{
	$lastid=mysqli_fetch_assoc($query);
	$lastid=$lastid['id'];//lsatid.
	}
	if($last_page_id) {
		$query=mysqli_query_or_throw_error($con, "select * from `album` where `profile_id`='$profile_id' && `id`>'$last_page_id' order by `id` asc limit 0,20");//extract photos uploaded by user.
	} else {
		$query=mysqli_query_or_throw_error($con, "select * from `album` where `profile_id`='$profile_id' order by `id` asc limit 0,20");//extract photos uploaded by user.
	}
	if((mysqli_num_rows($query))!=0)
	{
		echo "<div class='row'>";
		while($row=mysqli_fetch_assoc($query))
		{
		echo "<div class='col-md-4'>";
		$id=$row['id'];//id of photo.
		$status=$row['status'];//status of photo.
		$likes=$row['likes'];//no of likes.
		$name=$row['name'];//name.
		echo "<div class='thumbnail'><a href='getalbumfull.php?name=$name'> <img class='image' src='album_th/$name'/></a></br>";//print pic.
		echo $likes." People Liked It";//no of like.
		echo "</div>";
		$flag++;
		echo "</div>";
		if($flag==21)
		{
		break;
		}
		}
		echo "</div>";
		if($id<$lastid)
		{
		echo "<a href='photosd.php?last_id=$id&profile_id=$profile_id' class='btn btn-primary'>More</a>";//link named 'more' to next page.
		}
	}
	else
	{
		if($profile_id==$profile_id_real)
		{
		echo "You have not uploaded any photo yet.";//if no photos uploaded by you.
		}
		else
		{
		echo "No photos uploaded yet by this person.";//if no photos uploaded by requested user.
		}
	}
} catch(Exception $ex) {
	echo $ex->getMessage();
}


?>
</center>
</div>
</div>
<?php
include("footerd.php");
?>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
<?php
ob_end_flush();
?>
