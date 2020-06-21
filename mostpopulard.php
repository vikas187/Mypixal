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
<title>Most popular-Mypixal</title>
<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="picsd.css"/>
</head>
<body>
<?php
try {
	include("php_helper.php");
	include("headerd.php");
	$profile_id=$_COOKIE['piconprofile_id'];//'picweeksf' id of user.
	if(!isset($_COOKIE['piconusername'])&&empty($_COOKIE['piconusername']))//logged in.
	{
	header("location:mypixalsignup.php");
	}
	$query=mysqli_query_or_throw_error($con, "select * from `profile`");//select users from profile.
	$total=mysqli_num_rows($query);//total no of users.
	$query=mysqli_query_or_throw_error($con, "select `popular` from `profile` where `profile_id`='$profile_id'");//select 'popular' of you..
	if(mysqli_num_rows($query)!=0)
	{
	$pop=mysqli_fetch_assoc($query);
	$pop=$pop['popular'];//popularity of selected user.
	}
	else
	{
	$pop=0;//else popularity is 0.
	}
	$pop=($pop/$total)*100;//popularity in %.
	echo "<div align='right' >Your Popularity:".round($pop,3)."%</div>";//print your popularity.
	$query=mysqli_query_or_throw_error($con, "update `popular` set `status`='1' where `liked`='$profile_id'");//update unseen popularity.

	$query=mysqli_query_or_throw_error($con, "select `profile_id`,`photo_name`,`popular`,`name` from `profile` order by `popular` desc");//select all users from profile.
	if(mysqli_num_rows($query)!=0)
	{
		?>
		<div class="container">
			<div class="jumbotron jumbotron-custom1">
				<center>
				<p class="heading">Most popular<p>
				<div class="row">
	<?php
	$total=mysqli_num_rows($query);//total.
	$flag=1;//flag=1.
	while($row=mysqli_fetch_assoc($query))//while.
	{
		echo "<div class='col-md-4'>";
		echo "<div class='margin-image'>";
	$pid=$row['profile_id'];//profile_id of selected user.
	$photo_name=$row['photo_name'];
	if($flag<=50)//top 50.
	{
	$pop=$row['popular']/$total;//popularity of selected.
	$pop=$pop*100;//in percentage.
	echo "<div class='thumbnail'><a href='fullprofilepic1.php?name=$photo_name'><img width='90%' class='image' src='profile_th/$photo_name'></a></img></br>";//profile pic of selected user.
	$q=mysqli_query_or_throw_error($con, "select * from `popular` where `liked`='$pid' && `liker`='$profile_id'");//check if you have added selected user.
	if(mysqli_num_rows($q)==0)
	{
	if($pid==$profile_id)
	{
	echo $flag.". ".$row['name']."</br>Popularity:".round($pop,3)."%";//name with popularity.
	}
	else
	{
	echo $flag.". <a  href='profile2d.php?profile_id=$pid'>".$row['name']."</a></br>Popularity:</span>".round($pop,3)."%";//name with popularity(link).
	}
	}
	else
	{
	echo $flag.". <a class='link1' href='profile2d.php?profile_id=$pid'>".$row['name']."</a></br><span class='bold'>Popularity:</span>".round($pop,3)."%</td>";//name with popularity(link).
	}
	$flag++;
	echo "</div>";
	}
	else
	{
	break;
	}
	echo "</div>";
	echo "</div>";
	}
	?>
				</div>
				</center>
			</div>
		</div>
	<?php
	}
	else
	{
	?>
	<div class="container">
		<div class="jumbotron jumbotron-none"  >
			<center>
			No one is in most-popular list yet
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