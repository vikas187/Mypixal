<?php
if(!isset($_COOKIE['piconusername'])&&empty($_COOKIE['piconusername']))
{
header("location:logout.php");
}
include("connect.php");
$name=addslashes($_REQUEST['name']);
if(!isset($_REQUEST['name']))
{
header("location:mypixal.php");
}
echo "<img width='50%' src=\"profile_or/$name\"/>";
?>
