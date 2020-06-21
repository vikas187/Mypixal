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
<title>Funny pic Contest-Mypixal</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
 <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="picsd.css"/>
</head>
<body>
<?php
try {
  include("php_helper.php");
  include("headerd.php");
  include("connect.php");
  if(isset($_COOKIE['piconusername'])&&!empty($_COOKIE['piconusername']))//if logged in.
  {
  session_start();
  $profile_id=$_COOKIE['piconprofile_id'];//profile_id of you.
  $lastid=addslashes($_REQUEST['lastid']);//requested last id.
  if(!isset($_REQUEST['lastid']))
  {
  header("location:funnypicd.php");
  }
  $indent=$lastid;
  $query=mysqli_query_or_throw_error($con,("select * from `picweekfp` order by `id` asc"));//select first image.
  $firstid=mysqli_fetch_assoc($query);
  $firstid = $firstid['id'];
  $query=mysqli_query_or_throw_error($con,("select * from `picweekfp` where `id`<='$lastid' order by `id` desc limit 0,54"));//select images with id less than equal to last id.
  ?>
  <div class="container">
    <div class="jumbotron jumbotron-custom1">
      <center><p class="heading">Funny pics of this week</p>
      <div class="row">
  <?php
  $flag=1;
  while($row=mysqli_fetch_assoc($query))
  {
  $lastid=$row['id'];//update last_id.
  $name=$row['name'];
  echo "<div class='col-md-4'>";
  echo "<div class='margin-image'>";
    echo "<div class='thumbnail'><a href='getalbumfull.php?name=$name'><img src='mixed_th/$name' width='90%' class='image'/></a></br>";
  $q=mysqli_query_or_throw_error($con,("select * from `likes` where `name`='$name' and `profile_id`='$profile_id'"));//if you have liked it.
  if(mysqli_num_rows($q)!=0)
  {
  echo "<span><button class='btn btn-primary' style='visibility:hidden;'>Like</button>";
  echo $row['likes'];
  echo " People including you like this</span>";
  }
  else
  {
  echo "<span id='$lastid'><button class='btn btn-primary' onClick='like($lastid,\"$name\")'>Like</button>";
  echo $row['likes']," People like this</span>";
  }
    echo "</div>";
    echo "</div>";
    echo "</div>";
  if($flag==55)//if 51 in a page.
  {
  break;
  }
  }
    echo "</div>";
    echo "</center>";
  if($lastid!=$firstid)
  {
  $lastid--;
  echo "<center><button  class='btn btn-primary' onclick=window.location='funnypicmored.php?lastid=$lastid'>More</button></center>";//more link.
  }
  echo "</div>";
  echo "</div>";
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
