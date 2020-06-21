<?php
if(!isset($_COOKIE['piconusername'])&&empty($_COOKIE['piconusername']))//if not logged in.
{
header("location:mypixalsignup.php");
}
$id=addslashes($_REQUEST['to']);//request id for receiver.
if(!isset($_REQUEST['to']))
{
header("header:location:favourd.php");
}
session_start();//start session.
$_SESSION['buddy']=$id;
header("location:messagesd.php");//redirect to 'messages.php'.
?>
