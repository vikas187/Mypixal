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
<script type="text/javascript">
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
function rem(pid)
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
</script>
<title>Profile-Mypixal</title>
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="picsd.css"/>
</head>
<body>
<?php 
try {
	include("php_helper.php");
	include("headerd.php");//header file.
	if(isset($_COOKIE['piconusername'])&&!empty($_COOKIE['piconusername']))//if logged in.
	{
	include("connect.php");
	$profile_id=$_REQUEST['profile_id'];//profile_id of requested user.
	$query=mysqli_query_or_throw_error($con, "select * from `profile`");//select users from 'profile'.
	$total=mysqli_num_rows($query);//total.
	if($profile_id==$_COOKIE['piconprofile_id'])//if requested user is you.
	{
	header("location:profiled.php");
	}
	if(!isset($_REQUEST['profile_id']))
	{
	header("location:mypixal.php");
	}
	$query=mysqli_query_or_throw_error($con, "select * from `profile` where `profile_id`='$profile_id'");//select details of user.
	$num=mysqli_num_rows($query);
	$result=mysqli_fetch_assoc($query);//fetch.
	if($num!=0)
	{
	?>
	<div class="container">
		<div class="jumbotron jumbotron-custom1">
			<center>
			<p class="heading">Profile</p>
			<div class="row">
	<?php
	$id=$result['id'];
	$photo_name=$result['photo_name'];
	setcookie('piconid',$id,time()+3600*24*30);
	echo "<div class='col-md-4'>";
	echo "<div class='thumbnail'><a href='fullprofilepic.php?name=$photo_name'><img width='90%' class='image' src='profile_th/$photo_name'></a></div>";//profile pic of user.
	echo "</div>";
	echo "<div class='col-md-8'>";
	echo "<table class='table table-striped'>";
	echo "<tr><td>";
	echo "Name:";
	echo "</td>";
	echo "<td>";
	echo $result['name'];
	echo "</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td>";
	echo "Profession:";
	echo "</td>";
	echo "<td>";
	echo $result['course'];
	echo "</td>";
	echo "</tr><tr>";
	echo "<td>";
	echo "Gender:";
	echo "</td>";
	echo "<td>";
	echo $result['gender'];
	echo "</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td>";
	echo "Lives in:";
	echo "</td>";
	echo "<td>";
	echo $result['live'];
	echo "</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td>";
	echo "DOB:";
	echo "</td>";
	echo "<td>";
	echo $result['day']."-".$result['month']."-".$result['year'];
	echo "</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td>";
	echo "Quote:";
	echo "</td>";
	echo "<td>";
	echo $result['status'];
	echo "</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td>";
	echo "Points:";
	echo "</td>";
	echo "<td>";
	echo $result['points'];
	echo "</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td>";
	$popular=($result['popular']/$total)*100;//popularity of user.
	$popular=round($popular,3);//popularity in %.
	echo "Popularity:";
	echo "</td>";
	echo "<td>";
	echo $popular;
	echo "</td>";
	echo "</tr>";
	echo "</table>";
	$pid=$_COOKIE['piconprofile_id'];//profile_id of you.
	$query=mysqli_query_or_throw_error($con, "select * from `favour` where `liker`='$pid' && `liked`='$profile_id'");//check if user added to your favourites.
	echo "<span id='$profile_id'>";
	if((mysqli_num_rows($query))==0)
	{
	echo "<button class='btn btn-primary' onClick='favour($profile_id)'>Add To Favourites</button>";
	}
	else
	{
	echo "<button class='btn btn-danger' onClick='rem($profile_id)'>Remove</button>";
	}
	echo "</span>";
	echo "</div>";
	echo "</div>";
	echo "</div>";
	echo "</div>";
	?>
		<div class="container">
			<div class="jumbotron jumbotron-custom1">
				<center>
				<p class="heading">What people have commented about this person</p>
	<?php
	$query=mysqli_query_or_throw_error($con, "select * from `positives` where `for`='$profile_id' order by `id` desc");
	if((mysqli_num_rows($query))!=0)
	{
	echo "<table class='table table-striped'>";
	while($row=mysqli_fetch_assoc($query))
	{
	$profile_id1=$row['by'];
	$positive=$row['positive'];
	$status=$row['status'];
	echo "<tr><td>";
	if($status==1)
	{

	echo "<span class='pull-left' >".$positive."</span>";
	}
	else
	{
	echo "<span class='pull-left'><b>$positive</b></span>";
	}
	echo "</td></tr><tr><td>";
	$q=mysqli_query_or_throw_error($con, "select * from `profile` where `profile_id`='$profile_id1'");
	$by=mysqli_fetch_assoc($q);
	$by = $by['name'];
	echo "<span class='pull-right' ><a  href='profile2d.php?profile_id=$profile_id1'>-".$by."</a></span>";
	echo "</td></tr>";
	}
	echo "</table>";
	echo "<a style='margin-bottom:1em;' href='positived.php?id=$profile_id' class='btn btn-primary'>Comment</a>";
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
		<div class="jumbotron jumbotron-none1"  >
			<center>
			Nobody has commented about this person
			</center>
		</div>
	</div>
	<?php
	echo "<a style='margin-bottom:1em;' href='positived.php?id=$profile_id' class='btn btn-primary'>Comment</a>";
	?>
	</center>
	</div>
	</div>
	<?php
	}
	$flag=1;
	$query=mysqli_query_or_throw_error($con, "select * from `album` where `profile_id`='$profile_id'");
	?>
	<div class="container">
		<div class="jumbotron jumbotron-custom1">
			<center>
			<p class="heading">
			Phtotos uploaded by this person
			</p>
			<div class="row">
	<?php
	if((mysqli_num_rows($query))!=0)
	{
	while($row=mysqli_fetch_assoc($query))
	{
	$id=$row['id'];
	$likes=$row['likes'];
	$photo_name=$row['name'];
	echo "<div class='col-md-4'>";
	echo "<div class='margin-image'>";
	echo "<div class='thumbnail'><a href='getalbumfull.php?name=$photo_name'> <img width='90%' class='image' src='album_th/$photo_name'/></a></br>";
	echo $likes." People like this</div>";
	$flag++;
	if($flag==13)
	{
	break;
	}
	echo "</div>";
	echo "</div>";
	}
	echo '</div>
			</center>';
	echo "<center><a href='photosd.php?profile_id=$profile_id&last_id=' class='btn btn-primary'>See All</a></center>";
	?>
			
		</div>
	</div>
	<?php
	}
	else
	{
	?>
		<div class="container">
				<div class="jumbotron jumbotron-none1"  >
					<center>
					No images uploaded yet
					</center>
				</div>
			</div>
			</div>
			</center>
			</div>
			</div>
	<?php
	}
	}
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
