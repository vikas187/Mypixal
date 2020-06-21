<?php
try {
    if(isset($_COOKIE['piconusername'])&&!empty($_COOKIE['piconusername']))
    {
    include("php_helper.php");
    include("connect.php");
    $id=addslashes($_REQUEST['id']);
    if(!isset($_REQUEST['id']))
    {
    header("location:profilepicd.php");
    }
    $name=addslashes($_REQUEST['name']);
    $profile_id=$_COOKIE['piconprofile_id'];
    $query=mysqli_query_or_throw_error($con, "update picweekpp set likes=likes+1 where id=$id");
    $query=mysqli_query_or_throw_error($con, "update `album` set `likes`=likes+1 where `name`='$name' && `status`='1'");
    $query=mysqli_query_or_throw_error($con, "insert into likes values('','$profile_id','$name','0')");
    $query=mysqli_query_or_throw_error($con, "select `likes` from `picweekpp` where `id`='$id'");
    $row=mysqli_fetch_assoc($query);
    echo "<span><button class='btn btn-primary' style='visibility:hidden;'>Like</button>";
    echo $row['likes']." people including you like this.";
    }
    else
    {
    header("location:mypixal.php");
    }
} catch(Exception $ex) {
    echo $ex->getMessage();
}
?>