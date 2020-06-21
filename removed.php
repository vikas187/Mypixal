<?php
try{
    if(!isset($_COOKIE['piconusername'])&&empty($_COOKIE['piconusername']))
    {
    header("location:mypixalsignup.php");
    }
    include("php_helper.php");
    include("connect.php");
    $pid=addslashes($_REQUEST['pid']);
    $profile_id=$_COOKIE['piconprofile_id'];
    $query=mysqli_query_or_throw_error($con, "delete from `favour` where `liked`='$pid'&&`liker`='$profile_id'");
    $query=mysqli_query_or_throw_error($con, "delete from `popular` where `liker`='$profile_id'&& `liked`='$pid'");
    $query=mysqli_query_or_throw_error($con, "update `profile` set `popular`=popular-1 where `profile_id`='$pid'") ;
    echo "<button class='btn btn-primary' onClick='favour($pid)'>Add To Favourites</button>";
} catch(Exception $ex) {
    echo $ex->getMessage();
}
?>
