<?php
session_start();
include("connect.php");
include('php_helper.php');
header("content-type:image/jpeg");
try {
    if(!isset($_COOKIE['piconusername'])&&empty($_COOKIE['piconusername']))
    {
    header("location:mypixal.php");
    }
    if(isset($_FILES['photo']['name'])&&!empty($_FILES['photo']['name']))
    {
    $name=$_FILES['photo']['name'];
    $name=str_ireplace("#","1",$name);
    $name=str_ireplace("=","1",$name);
    $name=str_ireplace("+","1",$name);
    $profile_id=$_COOKIE['piconprofile_id'];
    $image_size=getimagesize($_FILES['photo']['tmp_name']);
    if($image_size==true)
    {
    $image=$_FILES['photo']['tmp_name'];
    $image_file=fopen($image,"r");
    $binary_image=fread($image_file,filesize($image));
    $source_image=imagecreatefromstring($binary_image);
    $width=imagesx($source_image);
    $height=imagesy($source_image);
    $thumb_width=460;
    $thumb_height=460;
    $thumb_image=imagecreatetruecolor($thumb_width,$thumb_height);
    imagecopyresized($thumb_image,$source_image,0,0,0,0,$thumb_width,$thumb_height,$width,$height);
    ob_start();
    imagejpeg($thumb_image);
    move_uploaded_file($_FILES["photo"]["tmp_name"], "profile_or/" . $name);
    $thumb=ob_get_contents();
    imagejpeg($thumb_image,"profile_th/" .$name);
    $query=mysqli_query_or_throw_error($con, "update `profile` set `photo_name`='$name' where `profile_id`='$profile_id'");
    $_SESSION['propic']=1;
    }
    else
    {
    $_SESSION['propic']=2;
    }
    }
    else
    {
    $_SESSION['propic']=3;
    }
    header("location:picchange.php");
} catch(Exception $ex) {
    echo $ex->getMessage();
}

?>
