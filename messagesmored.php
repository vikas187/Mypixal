<?php
ob_start();
?>
<!DOCTYPE html>
<html >
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
 <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<title>Mypixal</title>
<link rel="stylesheet" href="css/bootstrap.min.css"/>
<link rel="stylesheet" href="picsd.css" />
<script type="text/javascript">
var a=1;
function func_message()
{
if(a==1)
{
document.form.text.style.color="black";
document.form.text.value="";
a++;
}
else
{
}
}
</script>
</head>
<body>
<?php
try {
	session_start();
	if(!isset($_COOKIE['piconusername'])&&empty($_COOKIE['piconusername']))//if logged in.
	{
	header("location:mypixalsignup.php");
	}
	include("php_helper.php");
	include("headerd.php");
	include("connect.php");
	$to=$_SESSION['buddy'];
	$by=$_COOKIE['piconprofile_id'];//'picweeksf' id.
	$lastid=addslashes($_REQUEST['lastid']);//requested last id.
	if(!isset($_REQUEST['lastid']))
	{
	header("location:inboxd.php");
	}
	?>
	<div class="container">
		<div class="jumbotron jumbotron-custom1">
	<?php
	$query=mysqli_query_or_throw_error($con, "select `id` from `message` where `to`='$to'&&`by`='$by' || `to`='$by' && `by`='$to' order by `id` asc limit 1");//first id.
	$row=mysqli_fetch_assoc($query);
	$firstid=$row['id'];
	$query=mysqli_query_or_throw_error($con, "select `id` from `message` where (`to`='$to'&&`by`='$by' || `to`='$by' && `by`='$to') &&`id`<='$lastid' order by `id` desc limit 1 offset 19");//10th last id from requested last id.
	if((mysqli_num_rows($query))!=0)
	{
	$row=mysqli_fetch_assoc($query);
	$id1=$row['id'];
	}
	else
	{
	$id1=0;
	}
		?>
		<center>
			<p class="heading">Messages</p>
			<table class="table table-striped">
	<?php
	$query1=mysqli_query_or_throw_error($con, "select * from `message` where `to`='$to'&&`by`='$by' || `to`='$by' && `by`='$to' && `id`>='$id1' && `id`<='$lastid'");//extract msg.
	while($row=mysqli_fetch_assoc($query1))
	{
	$id2=$row['id'];
	if($id2>=$id1&&$id2<=$lastid)
	{
	if(($row['status'])==1)
	{
	echo "<tr><td ><span class='pull-left'>".$row['msg']."</span></td></tr>";//print msg.
	}
	else
	{
	echo "<tr><td ><span class='pull-left'>".$row['msg']."</span></td></tr>";//if not seen.
	}
	$id=$row['by'];
	$q=mysqli_query_or_throw_error($con, "select `name` from `profile` where `profile_id`='$id'");//name of sender.
	$r=mysqli_fetch_assoc($q);
	if($id==$profile_id)
	{
	echo "<tr><td >";
	echo "<span class='pull-right'><a  href='profile2d.php?profile_id=$by' >-".$r['name']."</a></span></td></tr>";//name of sender.
	}
	else
	{
	echo "<tr><td >";
	echo "<span class='pull-left'><a href='profile2d.php?profile_id=$to'>".$r['name']."-</a></span></td></tr>";//name of sender.
	}
	}
	}
	$query=mysqli_query_or_throw_error($con, "select `id` from `message` where (`to`='$to'&&`by`='$by' || `to`='$by' && `by`='$to') && `id`<=$lastid order by `id` desc limit 1 offset 20");//id of 11th last msg from requested last id.
	$row=mysqli_fetch_assoc($query);
	$id1=$row['id'];
	echo "</table>";
	if($id1>=$firstid)
	{
	echo "<center><a class='btn btn-primary' href='messagesmored.php?lastid=$id1'>Previous Messages</a></center>";//link to previous msg.
	}
	if(mysqli_num_rows($query1)==0)
	{
	?>
	<div class="container">
			<div class="jumbotron jumbotron-none2"  >
				<center>
				<p class='heading1'>No messages</p>
				</center>
			</div>
	</div>
	<?php
	}
	$query=mysqli_query_or_throw_error($con, "update `message` set `status`='1' where `by`='$to'&&`to`='$by'");//update status of unseen msgs.
	?>
	<center>
	<form method='post' action='messagesd.php' name="form" class="form-signin"><!--form for new msg-->
	<textarea name="text" text="Enter Your Message Here" class="form-control textarea-custom" placeholder="Enter Your Message Here"  onClick='func_message();'></textarea>
	<input type="submit" name="submit"  value="Send" class="btn btn-primary"></input>
	</form>
	</center>
	</center>
	</div>
	</div>
	<?php
	if(isset($_POST['text'])&&!empty($_POST['text']))
	{
	$to=$_SESSION['buddy'];
	$msg=$_POST['text'];
	$by=$_COOKIE['piconprofile_id'];
	$query=mysqli_query_or_throw_error($con, "insert into `message` values('','$by','$to','$msg','0')");//insert msg into table 'msg'.
	header("location:messagesd.php");
	}
	echo "<center>";
	include("footerd.php");
	echo "</center>";
}catch(Exception $ex) {
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

