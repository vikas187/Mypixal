<?php
ob_start();
?>
<!DOCTYPE html>
<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Mypixal</title>
<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css"/>
<link rel='stylesheet' href='picsd.css' type='text/css' />
</head>
<body>
<?php
try {
	include("php_helper.php");
	include("connect.php");
	include("headerd.php");
	if(!isset($_COOKIE['piconusername'])&&empty($_COOKIE['piconusername']))
	{
	header("location:mypixalsignup.php");
	}
	if(isset($_POST['search_name'])&&!empty($_POST['search_name']))
	{
	$name=addslashes($_POST['search_name']);
	if(strlen($name)>25) {
		echo "<div class='alert alert-danger alert-dismissable fade in'>";
		echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>You have exceeded the character limit of search box, please try to search something short.</div>";
	} else {
		$profile_id1=0;
		$flag=1;
		$name_array=explode(' ',$name);
		?>
		<div class="container">
			<div class="jumbotron jumbotron-custom">
				<center>
				<p class="heading">Results Found</p>
				<div class="row">
		<?php
		foreach($name_array as $name)
		{
		$query=mysqli_query_or_throw_error($con, "select id,name,photo_name,profile_id from `profile` where `name` like '%".mysqli_real_escape_string($con, $name)."%'");
		while($row=mysqli_fetch_assoc($query))
		{
		$id=$row['id'];
		$name_f=$row['name'];
		$photo_name=$row['photo_name'];
		$profile_id=$row['profile_id'];
		if($profile_id1!=$profile_id)
		{
		echo "<div class='col-md-4'>";
		echo "<div class='thumbnail'><a style='text-decoration:none;' href='fullprofilepic.php?name=$photo_name'><img width='90%' class='image' src='profile_th/$photo_name'/></a></br>";
		echo "<a class='link1' href='profile2d.php?profile_id=$profile_id'>".$name_f."</a></div>";
		echo "</div>";
		$flag++;
		$profile_id1=$profile_id;
		}
		}
		}
		?>
		</div>
		<?php
		if($flag==1)
		{
			?>
		<div class="container">
			<div class="jumbotron jumbotron-none2" >
				<center>
				<p class='heading1'>No Results</p>
				</center>
			</div>
		</div>
		<?php
		}
		echo "</div>";

		echo "</center>";
		echo "</div>";
		echo "</div>";
	}
	include("footerd.php");
	}
	else
	{
	header("location:mypixal.php");
	}
} catch(Exception $ex) {
	echo $ex->getMessage();
}
?>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
