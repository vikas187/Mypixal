<?php
ob_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
 <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<title>Mypixal-comments</title>
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="picsd.css"/>
<script type="text/javascript">
var a=1;
function func_comment()
{
if(a==1)
{
document.form.text.value='';
document.form.text.style.color='black';
a++;
}
else
{
return;
}
}
</script>
</head>
<body>
<?php
try {
	include("php_helper.php");
	include("headerd.php");
	include("connect.php");
	session_start();
	/*
	if(isset($_SESSION['id']))
	{
	$id=$_SESSION['id'];
	}*/
	if(isset($_REQUEST['id']))
	{
	$_SESSION['id']=$_REQUEST['id'];
	$id=$_REQUEST['id'];
	}//profile_id of random added user.
	if(!isset($_SESSION['id']))//if session is not set.
	{
	header("location:mypixal.php");
	}
	if(isset($_SESSION['id']))
	{
		$id=$_SESSION['id'];
	}
	?>
	<div class="container">
		<div class="jumbotron jumbotron-custom1">
			<center>
			<p class="heading">Comment anything about this person's personality</p>
			<div class="row">
	<?php
	$query=mysqli_query_or_throw_error($con,"select `name`,`photo_name` from `profile` where `profile_id`=$id");//details from 'profile'.
	$row=mysqli_fetch_assoc($query);
	$name=$row['name'];
	$photo_name=$row['photo_name'];
	echo "<div class='col-md-6 thumbnail'>";
	echo "<a href='fullprofilepic1.php?name=$photo_name'><img width='90%' class='image' src='profile_th/$photo_name'/></a></br>";//profile pic.
	echo "<a href='profile2d.php?profile_id=$id'>";
	echo $name;//name.
	echo "</a>";
	echo "</div>";
	?>
	<div class="col-md-6">
	<form method='post' action='positived.php' name="form" class="form-signin">
	<textarea name="text" text="Enter Your Text Here" class="form-control textarea-custom" placeholder="Enter Your Comment Here" onclick="func_comment()"></textarea>
	<input type="submit" name="submit"  value="Share" class="btn btn-primary"></input>
	</form>
	<?php
	if(!isset($_COOKIE['piconusername'])&&empty($_COOKIE['piconusername']))//if not logged in.
	{
	header("location:mypixalsignup.php");
	}
	if(isset($_POST['text'])&&!empty($_POST['text'])&&$_POST['text']!="Enter your Text Here")//if form is filled.
	{
	$profile_id=$_COOKIE['piconprofile_id'];//your 'picweeksf' id.
	$pid=$_SESSION['id'];//random user.
	$positive=addslashes($_POST['text']);//positive.
	$query=mysqli_query_or_throw_error($con,"insert into `positives` values('','$pid','$profile_id','$positive','0')");//insert into table 'positives'.
	}
	$pid=$_SESSION['id'];
	$query=mysqli_query_or_throw_error($con,"select `id` from `positives` where `for`='$pid' order by `id` asc limit 1");//first id.
	if((mysqli_num_rows($query))!=0)
	{
	echo "<p class='heading1'>What Others Have Commented About <a href='profile2d.php?profile_id=$id'>".$name."</a></p>";
	$row=mysqli_fetch_assoc($query);
	$firstid=$row['id'];
	$query=mysqli_query_or_throw_error($con,"select `id` from `positives` where `for`='$pid' order by `id` desc limit 1 offset 3");//id of positive(about random user) which is 29th last.
	if((mysqli_num_rows($query))!=0)
	{
	$row=mysqli_fetch_assoc($query);
	$id=$row['id'];
	}
	else
	{
	$id=0;
	}
	?>
	<table class="table table-striped">
	<?php
	$query=mysqli_query_or_throw_error($con,"select * from `positives` where `for`='$pid' && `id`>='$id'");//positives about random user.
	while($row=mysqli_fetch_assoc($query))
	{
		echo "<tr><td width='60%'>";
	$id1=$row['id'];
	if($id1>=$id)
	{
	$profile_id=$row['by'];
	echo $row['positive'];//print positive.
	echo "</td>";
	$q=mysqli_query_or_throw_error($con,"select `name` from `profile` where `profile_id`='$profile_id'");//name of one who has shared.
	$result=mysqli_fetch_assoc($q);
	echo "<td style='vertical-align:bottom'>";
	echo "<span class='pull-right'>-<a  href='profile2d.php?profile_id=$profile_id' >".$result['name']."</a></span>";//name.
	echo "</td></tr>";
	}
	}
	?>
	</table>
	<?php
	$query=mysqli_query_or_throw_error($con,"select `id` from `positives` where `for`='$pid' order by `id` desc limit 1 offset 4");//id of positive which is 30th from last.
	if((mysqli_num_rows($query))!=0)
	{
	$row=mysqli_fetch_assoc($query);
	$id=$row['id'];
	}
	else
	{
	$id=0;
	}
	if($id>=$firstid)
	{
	echo "<a class='btn btn-primary' href='positivemored.php?lastid=$id'>See Previous Comments</a>";//previous positives link.
	}
	}
	?>
	</div>
	</div>
	</center>
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
<?php
ob_end_flush();
?>
