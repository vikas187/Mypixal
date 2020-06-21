<?php
ob_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
 <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
 <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<title>Inbox-Mypixal</title>
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="picsd.css"/>
</head>
<body>
<?php
try {
	include("php_helper.php");
	include("connect.php");
	include("headerd.php");
	if(!isset($_COOKIE['piconusername'])&&empty($_COOKIE['piconusername']))//logged in.
	{
	header("location:mypixalsignup.php");
	}
	$to=$_COOKIE['piconprofile_id'];//'picweeksf' id of you. 
	$flag=1;
	$query1=mysqli_query_or_throw_error($con, "select `id` from `picweeksf` where `id`!='$to'");//select all user except you.
	if((mysqli_num_rows($query1))!=0)
	{
	$q=mysqli_query_or_throw_error($con, "select * from `message` where `to`='$to' || `by`='$to' ");//select msg from 'message' for you.
	if((mysqli_num_rows($q))!=0)
	{
	?>
	<div class="container">
		<div class="jumbotron jumbotron-custom1">
			<center>
			<p class="heading">Conversations</p>
			<div class="cover-page">
	<?php
	echo "<table class='table table-striped'>";
	while($result=mysqli_fetch_assoc($query1))
	{
	$by=$result['id'];
	$query=mysqli_query_or_throw_error($con, "select * from `message` where ((`to` ='$to' && `by`='$by') ||(`to` ='$by' && `by`='$to')) && `status`='0' order by `id` desc limit 1");//unseeen msgs archives.
	if((mysqli_num_rows($query))!=0)
	{
	$row=mysqli_fetch_assoc($query);
	$q=mysqli_query_or_throw_error($con, "select `name` from `profile` where `profile_id`='$by'");//name of sender.
	$r=mysqli_fetch_assoc($q);
	$id=$row['id'];
	echo "<tr><td class='valign-middle'><b><a href='fullprofilepic1.php?profile_id=$by' class='pull-left '>".$r['name']."</a></b>";//profilepic of sender.
	echo "<a class='btn btn-primary pull-right' href='statusreadd.php?id=$id'>Read</a></td></tr>";//read link.
	$flag++;
	}
	else
	{
	$query=mysqli_query_or_throw_error($con, "select * from `message` where ((`to`='$to'&&`by`='$by') || (`to` ='$by' && `by`='$to')) order by `id` desc limit 1");//seen  msg archives.
	$row=mysqli_fetch_assoc($query);
	$id=$row['id'];
	if((mysqli_num_rows($query))!=0)
	{
	$q=mysqli_query_or_throw_error($con, "select `name` from `profile` where `profile_id`='$by'");//name of sender.
	$r=mysqli_fetch_assoc($q);
	echo "<tr><td class='valign-middle'><a href='profile2d.php?profile_id=$by' class='pull-left'>".$r['name']."</a>";//profilepic of sender.
	echo "<a class='btn btn-primary pull-right' href='statusreadd.php?id=$id'>Read</a></td></tr>";//read link.
	$flag++;
	}
	}
	}
	echo "</table>";
	?>
			</div>
			</center>
		</div>
	</div>
	<?php
	}
	}
	$query=mysqli_query_or_throw_error($con, "select * from `message` where `to`='$to' || `by`='$to' ");//checking if no msgs archives.
	if((mysqli_num_rows($query))==0)
	{
		?>
		<div class="container">
			<div class="jumbotron jumbotron-none"  >
				<center>
				<p class='heading1'>No coversation</p>
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
