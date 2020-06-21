<?php
ob_start();
?>
<?php
try {
    if(isset($_COOKIE['piconusername'])&&!empty($_COOKIE['piconusername']))//if logged in.
    {
    include("php_helper.php");
    include("connect.php");
    $profile_id=$_COOKIE['piconprofile_id'];//'profile_id' of user.
    if(!isset($_REQUEST['pid']))//if requested id not set.
    {
    header("location:mypixal.php");
    }
    $pid=addslashes($_REQUEST['pid']);
    $query=mysqli_query_or_throw_error($con, "select `gender`,`rate` from `profile` where `profile_id`='$pid'");//gender of user to be added.
    $q=mysqli_fetch_assoc($query);
    $gender = $q['gender'];//gender.
    $rate=$q['rate'];//rating game status.
    $query=mysqli_query_or_throw_error($con, "select * from `favour` where `liker`='$profile_id'&&`liked`='$pid'");//check if user is not already added to favourite.
    if(mysqli_num_rows($query)==0)
    {
    $query=mysqli_query_or_throw_error($con, "insert into `favour` values('','$profile_id','$pid','$gender','$rate')");//insert into favour.
    $query=mysqli_query_or_throw_error($con, "insert into `popular` values('','$pid','$profile_id','0')");//insert into popular.
    $query=mysqli_query_or_throw_error($con, "update `profile` set `popular`=popular+1 where `profile_id`='$pid'") ;//insert into profile.
    }
    echo "<button class='btn btn-danger' onClick='rem($pid)'>Remove</button>";
    }
    else
    {
    header("location:mypixalsignup.php");//if not logged in.
    }
} catch(Exception $ex) {
    echo $ex->getMessage();
}
?>
<?php
ob_end_flush();
?>

