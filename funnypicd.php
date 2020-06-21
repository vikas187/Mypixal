<?php
ob_start();
?>
<!DOCTYPE html>
<html>
<head>
<script type="text/javascript">
function like(lastid,name)
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
    document.getElementById(lastid).innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("POST","updatefpd.php",true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send("id="+lastid+"&name="+name);
}
</script>
<meta charset="UTF-8">
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <meta http-equiv="Content-Type" content="text/html" />
 <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<title>Funny pic Context-Mypixal</title>
<link rel="stylesheet" href="css/bootstrap.min.css"/>
<link rel="stylesheet" href="picsd.css"/>
</head>
<body>
<?php
try {
	include("php_helper.php");
	include("connect.php");//connect file.
	include("headerd.php");//header file.
	session_start();
	if(!isset($_SESSION['uploadf']))//if session is not set.
	{
	header("location:mypixal.php");
	}
	if(isset($_COOKIE['piconusername'])&&!empty($_COOKIE['piconusername']))//if logged in.
	{ 
	$profile_id_real=$_COOKIE['piconprofile_id'];//profile_id of you.
	if($_SESSION['uploadf']==1)//if session isset to 2.
	{
		echo "<div class='alert alert-success alert-dismissable fade in'>";
		echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Successfuly Uploaded</div>";
		$_SESSION['uploadf']=0;
	}
	else if($_SESSION['uploadf']==2)//if session is set to 2.
	{
		echo "<div class='alert alert-danger alert-dismissable fade in'>";
		echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>That's Not An Image</div>";
		$_SESSION['uploadf']=0;
	}
	?>
	<div class="container">
		<div class="jumbotron jumbotron-custom1">
			<center>
			<p class="heading">Funny-pic Contest</p>
			<form  class="navbar-form" enctype="multipart/form-data" action="fetchfpd.php" method="post">
					<div class="form-group">
					<input type="file" name="image1">
					</div>
					<button class="btn btn-primary" >Upload</button>
			</form>
			<?php
			echo "</center>";
			$query=mysqli_query_or_throw_error($con,"select `id` from `picweekfp`");
			$no=mysqli_num_rows($query);
			if($no!=0)
			{
			$query=mysqli_query_or_throw_error($con,"select * from `picweekfp` order by `likes` desc limit 0,5");
			?>
			<center>
			<p class="heading">Top 5 Pics</p>
			<div class="row">
				<?php
					while($row=mysqli_fetch_assoc($query))
					{
							$id=$row['id'];//id of pic.
							$profile_id=$row['profile_id'];//profile_ of  uploader.
							$name=$row['name'];
							$likes=$row['likes'];
							$status = $row['status'];
							if($profile_id_real == $profile_id && $status == 0)//if yes.
							{
							$q=mysqli_query_or_throw_error($con,"update `profile` set `points`=points+3 where `profile_id`='$profile_id_real'");//increase points by 3.
							echo "<script type='text/javascript'>alert('Congratulations!.You Have Earned 3 Points Because One of Your uploaded Pic Got On To The Top 5 of This Category');</script>";//alert.
							$q=mysqli_query_or_throw_error($con,"update `picweekfp` set `status`='1' where `id`='$id'");//update status.
							}
							$q=mysqli_query_or_throw_error($con,"select * from `likes` where `name`='$name' && `status`='0' && `profile_id`='$profile_id_real'");//check if you have liked it,status is 0.
							if((mysqli_num_rows($q))!=0)//if yes.
							{
								$q2=mysqli_query_or_throw_error($con,"update `profile` set `points`=points+2 where `profile_id`='$profile_id_real'");//increase points by 2.
								echo "<script type='text/javascript'>alert('Congratulations!.You Have Earned 2 Points Because One of Your Liked Pic Got On To The Top 5 of This Category');</script>";//alert.
								$q=mysqli_query_or_throw_error($con,"update `likes` set `status`='1' where `name`='$name'&&`profile_id`='$profile_id_real'");//update status.
							}
							$name=$row['name'];
							$likes=$row['likes'];
							$id=$row['id'];
							$profile_id=$row['profile_id'];
							echo "<div class='col-md-4'>";
							echo "<div class='margin-image'>";
							echo "<div class='thumbnail'><a href='getalbumfull.php?name=$name'><img src='album_th/$name' width='90%' class='image'/></a></br>";
							echo $likes ." People like this.";
							$q=mysqli_query_or_throw_error($con,"select `name` from `profile` where `profile_id`=$profile_id");
							$uploader=mysqli_fetch_assoc($q);
							$uploader = $uploader["name"];
							echo "</br>Image uploaded by:<a href='profile2d.php?profile_id=$profile_id'>".$uploader."</a></div>";
							echo "</div>";
							echo "</div>";
					}
				?>
			</div>
			</center>
		</div>
	</div>
	<?php
	$flag1=1;
	$query=mysqli_query_or_throw_error($con,"select `id` from `picweekfp` order by `id` asc limit 0,1");
	$firstid=mysqli_fetch_assoc($query);
	$firstid=$firstid["id"];
	$query=mysqli_query_or_throw_error($con,"select * from `picweekfp` order by `id` desc limit 0,54");//select recent 50 images from 'picweekcp'.
	if((mysqli_num_rows($query))!=0)
	{
	?>
	<div class="container">
		<div class="jumbotron jumbotron-custom1">
			<center>
				<p class="heading">Funny pics of this week</p>
			<div class="row">
			<?php
			while($row=mysqli_fetch_assoc($query))//fetch.
			{
					$lastid=$row['id'];
					$name=$row['name'];
			?>
			<div class="col-md-4">
				<div class="margin-image">
			<?php
					echo "<div class='thumbnail'><a href='getalbumfull.php?name=$name'><img class='image' src='album_th/$name' width='90%' /></a></br>";
					$q=mysqli_query_or_throw_error($con,"select * from `likes` where `name`='$name' and `profile_id`='$profile_id_real'");//check if you have liked the image.
					if(mysqli_num_rows($q)!=0)//if yes.
					{
					echo "<span><button class='btn btn-primary' style='visibility:hidden;'>Like</button>";	
					echo $row['likes'];
					echo " People including you like this</span></div>";//likes.
					}
					else
					{
					echo "<span id='$lastid'><button class='btn btn-primary' onClick='like($lastid,\"$name\")'>Like</button> ";
					echo $row['likes']," People like this</span></div>";
					}
					$flag1++;
					if($flag1==55)
					{
					break;
					}
			?>
				</div>
			</div>
			<?php
			}
			echo "</div>";
			echo "</center>";
			if($lastid>$firstid)
			{
				$lastid--;
				echo "<center><a class='btn btn-primary see-all' href='funnypicmored.php?lastid=$lastid'>More</a></center>";//see all link.
			}
			?>
			</div>
		</div>
		<?php
	}
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
	</div>
	<?php
	}
	echo "<center>";
	include("footerd.php");//footer file.
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


