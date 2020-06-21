<?php
ob_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Mypixal</title>
</head>
<link rel="stylesheet" href="css/bootstrap.min.css"/>
<link rel="stylesheet" href="picsd.css" type="text/css" />
<body>
<?php
include('php_helper.php');
include("headerd.php");
session_start();
try {
	if(!isset($_COOKIE['piconusername'])&&empty($_COOKIE['piconusername']))//if not logged in.
	{
	header("location:mypixalsignup.php");
	}
	include("connect.php");//connect file.
	if(!isset($_SESSION['propic']))//if session is set.
	{
	header("location:mypixal.php");
	}
	$profile_id=$_COOKIE['piconprofile_id'];//profile_id of yours.

	//showing error/success message
	if($_SESSION['propic']==1)//if session value has been set to 1
	{
	$_SESSION['propic']=0;
	echo "<div class='alert alert-success alert-dismissible fade in'>";
    echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Your Photo Has Been Updated </div>";
	}
	else if($_SESSION['propic']==2)
	{
	$_SESSION['propic']=0;
	echo "<div class='alert alert-danger alert-dismissible fade in'>";
    echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>That's Not An Image </div>";
	}
	else if($_SESSION['propic']==3)
	{
	$_SESSION['propic']=0;
	echo "<div class='alert alert-danger alert-dismissible fade in'>";
    echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Please Choose An Image </div>";
	}


	$query=mysqli_query_or_throw_error($con, "select `id`,`photo_name` from `profile` where `profile_id`='$profile_id'");//select id of you.
	if((mysqli_num_rows($query))==0)
	{
	header("location:profiled.php");
	}
	$row=mysqli_fetch_assoc($query);//fetch.
	$id=$row['id'];
	$image=$row['photo_name'];
	?>
	<div class="container">
		<div class="jumbotron jumbotron_custom1">
		<center>
		<p class="heading">Profile Pic</p>
		</center>
		<div class="row">
		<div class="col-md-4"></div>
		<div class="col-md-4">
	<?php
	echo "<div class='thumbnail'><a  href='fullprofilepic.php?name=$image'><img width='100%'  class='image'  src='profile_th/$image'></a></div></div><div class='col-md-4'></div></div>";//profile pic.
	echo "<form action='profilethumbd.php' method='post' enctype='multipart/form-data'>";//form.
	echo "<center><input type='file' name='photo' />";
	echo "<input type='submit' name='upload' class='btn btn-primary' value='Change'/></center>";
	echo "</form>";
	?>
	</div>
	</div>
	<?php
	include("footerd.php"); //footer file.
} catch(Exception $ex) {
	echo $ex.getMessage();
}
?>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
<?php
ob_end_flush();
?>
