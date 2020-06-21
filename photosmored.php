<?php
ob_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Photos-Mypixal</title>
<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css"/>
<link rel="stylesheet" href="picsd.css" type="text/css" />
</head>
<body>
<?php
if(!isset($_COOKIE['piconusername'])&&empty($_COOKIE['piconusername']))//logged in.
{
header("location:mypixalsignup.php");
}
$id=addslashes($_REQUEST['id']);//requested id.
$profile_id=addslashes($_REQUEST['profile_id']);//requested profile_id.
if(!isset($_REQUEST['id'])||!isset($_REQUEST['profile_id']))
{
header("location:photosd.php");
}
include("headerd.php");
$profile_id_real=$_COOKIE['piconprofile_id'];//'picweeksf' id of you.
?>
<div class="container">
	<div class="jumbotron">
	<center>
<?php
if($profile_id==$profile_id_real)//if requested profile_id is yours.
{
echo "<p class='heading'>My Photos</p>";
}
else
{
echo "<p class='heading'>Photos</p>";//else
}
$flag=1;
$query=mysql_query("select `id` from `album` where `profile_id`='$profile_id' order by `id` desc limit 1")or die(mysql_error());//id of last photo.
if((mysql_num_rows($query))!=0)
{
$lastid=mysql_result($query,0,'id');//lastid.
}
$query=mysql_query("select * from `album` where `profile_id`='$profile_id' && `id`>'$id'")or die(mysql_error());//extract remaining photos.
if((mysql_num_rows($query))!=0)
{
echo "<div class='row'>";
while($row=mysql_fetch_assoc($query))//while.
{
echo "<div class='col-md-4'>";
$id=$row['id'];
$status=$row['status'];
$likes=$row['likes'];
$name=$row['name'];
echo "<div class='thumbnail'><a href='getalbumfull.php?name=$name'> <img  class='image' src='album_th/$name'/></a></br>";//print photo.
echo $likes." People liked it</div>";//no of likes.
echo "</div>";
$flag++;
if($flag==21)//if 20 in a page.
{
break;
}
}
echo "</div>";
if($id<$lastid)
{
echo "<a href='photosmored.php?id=$id&profile_id=$profile_id' class='btn btn-primary'>More</a>";//link 'more'.
}
}
?>
<?php
include("footerd.php");
echo "</center>";
?>
	</div>
</div>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
<?php
ob_end_flush();
?>
