<?php
include("php_helper.php");
if(!isset($_COOKIE['piconusername'])&&empty($_COOKIE['piconusername']))
{
header("location:ypixalsignup.php");
}
include("connect.php");
$id=addslashes($_REQUEST['id']);
if(!isset($_REQUEST['id'])||!isset($_SESSION['buddy']))
{
header("location:mypixal.php");
}
$query=mysqli_query_or_throw_error($con, "select `by`,`to` from `message` where `id`='$id'");
$row=mysqli_fetch_assoc($query);
session_start();
if($row['by']==$_COOKIE['piconprofile_id']) {
    $_SESSION['buddy']=$row['to'];
} else {
    $_SESSION['buddy']=$row['by'];
}
header("location:messagesd.php");
?>

