<?php
ob_start();
?>
<?php
$id=$_REQUEST['id'];
$email=$_REQUEST['email'];
include("connect.php");
include("php_helper.php");
$query=mysqli_query_or_throw_error($con, "update `picweeksf` set `status`='1' where `id`='$id' && `email`='$email'");
echo "<script type='text/javascript'>alert('Your Registration Has Been Confirmed Successfully');</script>";
header("location:index.php");
?>
<?php
ob_end_flush();
?>
