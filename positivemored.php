 <?php
ob_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width;initial-scale=1.0"/>
<title>Mypixal-comments</title>
<link rel="stylesheet" href="css/bootstrap.min.css"/>
<link rel="stylesheet" href="picsd.css" />
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
	$id=$_SESSION['id'];
	?>
	<div class="container">
		<div class="jumbotron jumbotron-custom1">
			<center>
				<p class="heading">Comment me</p>
	<?php
	$query=mysqli_query_or_throw_error($con, ("select `name`,`photo_name` from `profile` where `profile_id`=$id"));//details from 'profile'.
	$row=mysqli_fetch_assoc($query);
	$name=$row['name'];
	$photo_name=$row['photo_name'];
	echo "<div class='row'>";
	echo "<div class='col-md-6 thumbnail'>";
	echo "<a href='fullprofilepic1.php?name=$photo_name'><img width='90%' class='image' src='profile_th/$photo_name'></a></br>";//image.
	echo "<a href='profile2d.php?profile_id=$id'>";
	echo $name;
	echo "</a>";
	echo "</div>";
	?>
	<div class="col-md-6">
	<form method='post' action='positived.php' name="form" >
	<textarea name="text" text="Enter Your Text Here" class="form-control textarea-custom" placeholder="Enter Your Comment Here" onclick="func_comment()"></textarea>
	<input type="submit" name="submit"  value="Share" class="btn btn-primary"></input>
	</form>
	<?php
	if(isset($_COOKIE['piconusername'])&&!empty($_COOKIE['piconusername']))
	{
	$pid=$_SESSION['id'];
	echo "<p class='heading1'>What people have commented about <a href='profile2d.php?profile_id=$id'>".$name."</a></p>";
	$lastid=addslashes($_REQUEST['lastid']);
	if(!isset($_REQUEST['lastid']))
	{
	header("location:gamed.php");
	}
	$query=mysqli_query_or_throw_error($con, ("select `id` from `positives` where `for`='$pid' order by `id` asc limit 1"));
	$row=mysqli_fetch_assoc($query);
	$firstid=$row['id'];
	$query=mysqli_query_or_throw_error($con, ("select `id` from `positives` where `for`='$pid'&&`id`<='$lastid' order by `id` desc limit 1 offset 3"));
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
	$query=mysqli_query_or_throw_error($con, ("select * from `positives` where `for`='$pid' && `id`>='$id' && `id`<='$lastid'"));
	while($row=mysqli_fetch_assoc($query))
	{
	$id2=$row['id'];
	if($id2>=$id&&$id2<=$lastid)
	{
	$profile_id=$row['by'];
	echo "<tr><td width='60%'>";
	echo $row['positive'];
	echo "</td><td style='vertical-align:bottom'><a href='profile2d.php?profile_id=$profile_id'><span class='pull-right'>-";
	$q=mysqli_query_or_throw_error($con, ("select `name` from `profile` where `profile_id`='$profile_id'"));
	$result=mysqli_fetch_assoc($q);
	echo $result['name'];
	echo "</span></a></td></tr>";
	}
	}
	echo "</table>";
	$query=mysqli_query_or_throw_error($con, ("select `id` from `positives` where `for`='$pid' && `id`<='$lastid' order by `id` desc limit 1 offset 4"));
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
	echo "<a class='btn btn-primary' href='positivemored.php?lastid=$id'>See Previous Comments</a>";
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
	}
	else
	{
	header("location:mypixalsignup.php");
	}
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
