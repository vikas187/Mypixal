<?php
ob_start();
?>
<!DOCTYPE html>
<html>
<head>
<script type="text/javascript">
function like(pid)
{
if (window.XMLHttpRequest)
  {
  xmlhttp=new XMLHttpRequest();
  }
else
  {
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
   xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById(pid).innerHTML=xmlhttp.responseText;
    }
  }

xmlhttp.open("POST","removed.php",true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send("pid="+pid);
}
function favour(pid)
{
if (window.XMLHttpRequest)
  {
  xmlhttp=new XMLHttpRequest();
  }
else
  {
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
   xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById(pid).innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("POST","updatefavd.php",true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send("pid="+pid);
}
</script>
<meta charset="utf-8">
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
 <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<title>Favourites</title>
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="picsd.css" />
</head>
<body>
<?php
try {
	include("php_helper.php");
	include("headerd.php");
	include("connect.php");
	if(isset($_COOKIE['piconusername'])&&!empty($_COOKIE['piconusername']))//logged in.
	{
	$profile_id=$_COOKIE['piconprofile_id'];//'picweeksf' id of user.
	$query=mysqli_query_or_throw_error($con, "select `id` from `favour` where `liker`='$profile_id' order by `id` desc limit 1");//getting id last favourite of user in 'favour'.
	$row=mysqli_fetch_assoc($query);
	$lastid=$row['id'];//lastid.
	$query=mysqli_query_or_throw_error($con, "select `id`,`liked` from `favour` where `liker`='$profile_id' order by `id` asc");//select all fovourites of user.
	if(mysqli_num_rows($query)!=0)
	{
	$flag=1;
	?>
	<div class="container">
		<div class="jumbotron jumbotron-custom1">
			<center>
				<p class="heading">My favourite people</p>
				<div class="row">
	<?php
	while($row=mysqli_fetch_assoc($query))
	{
	if($flag<=20)//if less than 20 in a page.
	{
	$id2=$row['id'];
	$pid=$row['liked'];
	$q=mysqli_query_or_throw_error($con, "select `photo_name`,`profile_id`,`name` from `profile` where `profile_id`='$pid'");//getting details of 'user' which is added to favourites by the user.
	$result=mysqli_fetch_assoc($q);//result of above query.
	$photo_name=$result['photo_name'];//'id' of added user.
	$profile_id1=$result['profile_id'];//'profile_id' of added user.
		echo "<div class='col-lg-4'>";
		echo "<div class='margin-image'>";
		echo "<div class='thumbnail'><img width='90%' src='profile_th/$photo_name' /></br>";//profile pic of added user.
		echo "<a href='profile2d.php?profile_id=$profile_id1'>".$result['name']."</a></br>";//name of added user.
		echo "<span id='$pid'><a class='btn btn-primary' href='messaged.php?to=$profile_id1'>Message</a>   <button class='btn btn-primary' onClick='like($pid)' >Remove</a></span>";//'message' and 'remove' link of added user.
		$flag++;
	echo "</div>";
	echo "</div>";
	echo "</div>";
	}
	}
	echo "</div>";
	if($id2<$lastid)//if more user are left to be shown.
	{
	echo "<a class='btn btn-primary' href='favourmored.php?idr=$id2'>More</a>";//link to next page as 'more'.
	}
	?>
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
			<p class='heading1'>No favourites</p>
			</center>
		</div>
	</div>
	<?php
	} 
	echo "<center>";
	include("footerd.php");//include footer file.
	echo "</center>";
	}
	else
	{
	header("location:mypixalsignup.php");//if not logged in.
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
