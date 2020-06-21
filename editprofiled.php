<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-UTF-8" />
<title>profile</title>
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="picsd.css"/>
</head>
<body>
<?php 
try {
	include("php_helper.php");
	include("headerd.php");//include header file.
	if(isset($_COOKIE['piconusername'])&&!empty($_COOKIE['piconusername']))//if user is logged in.
	{
	$profile_id=$_COOKIE['piconprofile_id'];//PROFILE_ID OF YOU.
	$query=mysqli_query_or_throw_error($con, "select `id`,`photo_name` from `profile` where `profile_id`='$profile_id'");//getting 'id' of  user from 'profile'.
	$result=mysqli_fetch_assoc($query);
	$id = $result['id'];
	$image = $result['photo_name'];
	if(mysqli_num_rows($query)==0)
	{
	header("location:createprofiled.php");
	}
	}
	else
	{
	header("location:mypixalsignup.php");//if user is not logged in.
	}
	if(isset($_POST['name'])&&isset($_POST['course'])&&isset($_POST['live'])&&isset($_POST['gender'])&&isset($_POST['status']))//checking if all fields are set and not empty.
	{
		if(!empty($_POST['name'])&&!empty($_POST['course'])&!empty($_POST['live'])&&!empty($_POST['gender'])&&!empty($_POST['status']))
		{
			$name=$_POST['name'];
			$course=$_POST['course'];
			$live=$_POST['live'];
			$gender=$_POST['gender'];
			$status=$_POST['status'];
			$query=mysqli_query_or_throw_error($con, "update `profile` set `name`='$name',`course`='$course',`gender`='$gender',`live`='$live',`status`=\"$status\" where `id`='$id'");//update table 'profile' with new information.
			if($query)
			{
				echo "<div class='alert alert-success alert-dismissible fade in'>";
				echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Information Updated.</div>";
			}
		}
		else
		{
			echo "<div class='alert alert-danger alert-dismissible fade in'>";
			echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Please fill all the details.</div>";
		}
	}
	?>
	<div class="container">
	<div class="jumbotron jumbotron_custom1">
	<center>
		<p class="heading">Edit Profile</p>
	</center>
	<div class="row">
	<?php
	echo "<div class='col-md-4'><div class='thumbnail'><a  href='fullprofilepic.php?name=$image'><img width='100%'  class='image'  src='profile_th/$image' /></a></div>";//profile pic of user.
	echo "<center><button class='btn btn-primary input_custom' onClick=window.location='picchange.php' >Edit Profile Pic</button></center></div>";//edit profile pic link.
	$query=mysqli_query_or_throw_error($con, "select * from `profile` where `id`='$id'");//extracting details of user.
	$row=mysqli_fetch_assoc($query);
	$name=$row['name'];
	$live=$row['live'];
	$course=$row['course'];
	$day=$row['day'];
	$month=$row['month'];
	$year=$row['year'];
	$gender=$row['gender'];
	$status=$row['status'];
	echo "<div class='col-md-8'>";
	echo "<form name='profile' method='post'>";
	echo "<table  class='table table-striped'>";//table for details of user's profile.
	echo "<td align='right' >";
	echo "Name:</td>";//name.
	echo "<td align='left'  >";
	echo "<input type='text' name='name'  class='form-control' value='$name' />";//edit name.
	echo "</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td align='right'  >Profession:</td>";//profession.
	echo "<td align='left' >";
	echo "<input type='text' name='course' class='form-control' value='$course' />"; 
	echo "</td></tr>";
	echo "<tr>";
	echo "<td align='right' value=".$row['gender']." >";
	echo "Gender:";//gender.
	echo "</td>";
	echo "<td align='left' >";
	echo "<select name='gender' class='input'>";
	echo "<option value='Female'>Female</option>";
	echo "<option selected='selected'>$gender</option>";
	echo "<option value='Male'>Male</option>";
	echo "</select>";
	echo "</td>";
	echo "</tr><tr><td align='right'  >Lives in:</td><td align='left' >";//address.
	echo "<input type='text' name='live' class='form-control'  value='$live'/></td></tr><tr>";
	echo "<td align='right'  >Quote:</td><td align='left'>";//quote
	echo "<textarea name='status'  class='form-control'>$status</textarea></td></tr></table>";
	echo "<center><input type='submit' class='btn btn-primary' value='Update' name='update'></center>";
	echo "</td></tr></table></form></div>";
	?>
	</div>
	</div>
	</div>
	<?php
	include("footerd.php");//include footer.
} catch(Exception $ex) {
	echo $ex.getMessage();
}
?>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>