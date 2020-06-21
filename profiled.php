<?php
ob_start();
?>
<!DOCTYPE html>
<html>
<head>
<script type="text/javascript">
function del(lastid)
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
	var elements = document.getElementsByClassName(lastid);
	var names = '';
	for(var i=0; i<elements.length; i++) {
		elements[i].innerHTML = xmlhttp.responseText;
	}
    }
  }
xmlhttp.open("POST","commentdelete.php",true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send("id="+lastid);
}
</script>
<meta charset="utf-8">
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
 <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<title>Profile-Mypixal</title>
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="picsd.css"/>

</head>
<body>
<?php
include("php_helper.php");
include("headerd.php"); //including header file.
try {
	if (isset($_COOKIE['piconusername']) && !empty($_COOKIE['piconusername'])) //if user is logged in or not.
	{
		include("connect.php");
		$profile_id = $_COOKIE['piconprofile_id']; //'picweeksf' id.
		$query = mysqli_query_or_throw_error($con, "select * from `profile` where `profile_id`='$profile_id'"); //extracting details of user from 'profile' table.
		$num    = mysqli_num_rows($query);
		$result = mysqli_fetch_assoc($query);
		echo "<div align='right'><a href='changepassword.php' >Change password</a></div>"; //change password link.
	?>
	<div class="container">
		<div class="jumbotron jumbotron-custom1">
			<center>
			<p class="heading">
			Profile
			</p>
			<div class="row">
	<?php
		if ($num != 0) //if user's details exists in the table 'profile'.
			{
			$id         = $result['id']; //id of user in 'profile' table.
			$photo_name = $result['photo_name'];
			echo "<div class='col-md-4'>";
			echo "<div class='thumbnail'><a  target='blank' href='fullprofilepic.php?name=$photo_name'><img width='90%' class='image'  src='profile_th/$photo_name'/></a></br>"; //print profile pic.
			echo "<span class='caption'><button class='btn btn-primary' onClick=window.location='picchange.php' >Edit Profile Pic</button></span></div>"; //edit profile pic link.
			echo "</div>";
			echo "<div class='col-md-8 push-bottom'>";
			echo "<div class='table-responsive'><table class='table table-striped'>";
			echo "<tr>";
			echo "<td>";
			echo "Name:"; //name
			echo "</td>";
			echo "<td>";
			echo $result['name'];
			echo "</td>";
			echo "</tr>";
			echo "<tr><td>";
			echo "Profession:"; //profession.
			echo "</td>";
			echo "<td>";
			echo $result['course'];
			echo "</td>";
			echo "</tr>";
			echo "<tr><td>";
			echo "Gender:"; //gender.
			echo "</td>";
			echo "<td>";
			echo $result['gender'];
			echo "</td></tr>";
			echo "<tr><td>";
			echo "Lives in:"; //lives in.
			echo "</td><td>";
			echo $result['live'];
			echo "</td></tr>";
			echo "<tr><td>";
			echo "DOB:"; //date of birth.
			echo "</td><td>";
			echo $result['day'] . "-" . $result['month'] . "-" . $result['year'];
			echo "</td></tr>";
			echo "<tr><td>";
			echo "Quote:"; //status.
			echo "</td><td>";
			echo $result['status'];
			echo "</td></tr>";
			echo "<tr><td>";
			echo "Points:"; //points.
			echo "</td><td>";
			echo $result['points'];
			echo "</td></tr>";
			echo "</table></div>";
			echo "</br><a class='btn btn-primary' href='editprofiled.php?id=$id' >Edit Your Profile</a>"; //edit profile details link.
			echo "</div>";
	?>
			</div>
			</center>
		</div>
	</div>
	<div class="container">
		<div class="jumbotron jumbotron-custom1">
			<center>
			<p class="heading">
			What people have commented about your personality
			</p>
	<?php
			$query = mysqli_query_or_throw_error($con, "select * from `positives` where `for`='$profile_id' order by `id` desc"); //extract from 'positives'.
			if ((mysqli_num_rows($query)) != 0) {
				echo "<table class='table table-striped'>";
				while ($row = mysqli_fetch_assoc($query)) {
					
					
					$profile_id1 = $row['by'];
					$positive    = $row['positive'];
					$status      = $row['status'];
					$lastid      = $row['id'];
					echo "<tr><td>";
					echo "<div class='$lastid'>";
					if ($status == 1) {
						echo "<span class='pull-left' >" . $positive . "</span>"; //print positives.
					} else {
						echo "<span class='pull-left'  ><b>" . $positive . "</b></span>"; //print positives.
					}
					echo "<span class='pull-right' ><button class='btn btn-primary' onClick='del($lastid)'>Delete</button></span>";
					echo "</div>";
					echo "</td></tr><tr><td>";
					echo "<div class='$lastid'>";
					$q = mysqli_query_or_throw_error($con, "select * from `profile` where `profile_id`='$profile_id1'");
					$by = mysqli_fetch_assoc($q);
					$by = $by['name'];
					echo "<span class='pull-right'><a  href='profile2d.php?profile_id=$profile_id1'>-" . $by . "</a></span></div></td></tr>"; //print user's name who shared it.
				}
				echo "</table>";
				$query = mysqli_query_or_throw_error($con, "update `positives` set `status`='1' where `for`='$profile_id'"); //set 'positives' status to '1'.
				echo "</center>";
				echo "</div>";
				echo "</div>";
			} else {
	?>
	<div class="container">
		<div class="jumbotron jumbotron-none1"  >
			<center>
			Nobody has commented about you
			</center>
		</div>
	</div>
	</center>
	</div>
	</div>
	<?php
			}
			$flag = 1;
			$query = mysqli_query_or_throw_error($con, "select `id`,`name`,`likes` from `album` where `profile_id`='$profile_id'"); //extract photos uploaded by user.
			if ((mysqli_num_rows($query)) != 0) {
	?>
	<div class="container">
		<div class="jumbotron jumbotron-custom1">
			<center>
			<p class="heading">Photos uploaded by you</p>
			<div class="row">
	<?php
				while ($row = mysqli_fetch_assoc($query)) {
					$id    = $row['id'];
					$likes = $row['likes'];
					$name  = $row['name'];
					echo "<div class='col-lg-4 col-md-6'>";
					echo "<div class='margin-image'>";
					echo "<div class='thumbnail'><a href='getalbumfull.php?name=$name'><img width='90%' class='image' src='album_th/$name'/></a></br>"; //print photo.
					echo $likes . " People Liked It</div>"; //no of likes.
					$flag++;
					if ($flag == 21) {
						break;
					}
					echo "</div>";
					echo "</div>";
				}
	?>
		</div>
			</center>
		<?php
				echo "<center><a href='photosd.php?profile_id=$profile_id&last_id=' class='btn btn-primary'>See All</a></center>";
	?>
	</div>
	</div>
	<?php
			} else {
	?>
	<div class="container">
		<div class="jubotron jumbotron-custom1">
			<center>
			<p class="heading">Photos uploaded by you</p>
			<div class="container">
				<div class="jumbotron jumbotron-none1"  >
					<center>
					No images uploaded yet
					</center>
				</div>
			</div>
			</center>
		</div>
	</div>
	<?php
			}
			echo "<center>";
			include("footerd.php"); //include footer file.
			echo "</center>";
		} else {
			echo "<script>window.location='createprofiled.php'</script>"; //if no prfile is created,redirect to 'createprofiled.php'. 
		}
	} else {
		echo "<script>window.location='mypixal.php'</script>"; //if not logged in.
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
