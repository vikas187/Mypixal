<?php
ob_start();
?> 
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
 <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<title>Mypixal</title><!--setting title-->
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>
<link rel="stylesheet"  type="text/css" href="picsd.css" />
</head>
<body>
<?php
try {
	include("connect.php");//connecting to database.
	include("php_helper.php");
	session_start();//starting sessions of user,which will be required further.
	$_SESSION['uploadp']=0;
	$_SESSION['uploadf']=0;
	$_SESSION['uploadc']=0;
	$_SESSION['propic']=0;
	if(isset($_COOKIE['piconusername'])&&!empty($_COOKIE['piconusername']))//checking if user has logged in successfully.
	{  
		include("headerd.php");//including header of the site(head style).
		$profile_id=$_COOKIE['piconprofile_id'];//setting user mypixalsignup id.
		$query=mysqli_query_or_throw_error($con, "select `id` from `profile` where `profile_id`='$profile_id'");
		if(mysqli_num_rows($query)==0)
		{
			header("location:profiled.php");//if user has'nt made id,redirect to profile.php.
		}
		$flag=1;
		$query=mysqli_query_or_throw_error($con, "select * from `album` where `status`='1'");//checking if photos exists in the site.
		if((mysqli_num_rows($query))!=0)
		{
			?>
			<div class="container">
					<div class="jumbotron">
						<center>
							<p class='heading'>Top Rated Pics</p>
						<div class="row">
						<?php
							$query=mysqli_query_or_throw_error($con,"select `id`,`profile_id`,`name`,`likes` from `album` order by likes desc limit 0,15");
							while($row=mysqli_fetch_assoc($query))
							{
								$id=$row['id'];
								$profile_id=$row['profile_id'];
								$name=$row['name'];
								$like=$row['likes'];
								?>
								<div class="col-lg-4 col-md-6">
									<div class='margin-image'>
									<?php
										echo "<div class='thumbnail'><a href='getalbumfull.php?name=$name'><img width='90%' class='image' src='album_th/$name' /></a>";
										echo "</br><span class='caption'>$like People like this";
										$q=mysqli_query_or_throw_error($con,"select `name` from `profile` where `profile_id`=$profile_id");
										$result=mysqli_fetch_assoc($q);
										$uploader=$result['name'];
										echo "</br>Image Posted By:<a href='profile2d.php?profile_id=$profile_id'>$uploader</a></span></div>";
									?>
									</div>
								</div>
								<?php
							}
						?>
					</div>
					</center>
				</div>
			<?php
		}
		else
		{
			?>
			<div class="container">
				<div class="jumbotron" style="padding-top:16em;padding-bottom:16em;" >
					<center>
					<p class='heading1'>No images uploaded yet</p>
					</center>
				</div>
			</div>
			<?php
		}
		include("footerd.php");
	} else
	{
		header("location:mypixalsignup.php");
	}
} catch (Exception $ex) {
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
