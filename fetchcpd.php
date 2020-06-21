<?php
try {
    if(!isset($_COOKIE['piconusername'])&&empty($_COOKIE['piconusername']))
    {
    header("location:logoutd.php");
    }
    session_start();
    if(isset($_FILES['image1']['name'])&&!empty($_FILES['image1']['name']))
    {
    $name=$_FILES['image1']['name'];
    $name=str_ireplace("#","1",$name);
    $name=str_ireplace("=","1",$name);
    $name=str_ireplace("+","1",$name);
    $image_size=getimagesize($_FILES['image1']['tmp_name']);
    $profile_id=$_COOKIE['piconprofile_id'];
    $name=$profile_id.$name;
    header("content-type:image/jpeg");
    if($image_size==true)
    {
    $image=$_FILES['image1']['tmp_name'];
    $image_file=fopen($image,"r");
    $binary_image=fread($image_file,filesize($image));
    $source_image=imagecreatefromstring($binary_image);
    $width=imagesx($source_image);
    $height=imagesy($source_image);
    list($org_width,$org_height)=getimagesize($image);
    $aspect_ratio=$org_width/$org_height;
    $thumb_width=460;
    $thumb_height=460;
    $thumb_image=imagecreatetruecolor($thumb_width,$thumb_height);
    imagecopyresized($thumb_image,$source_image,0,0,0,0,$thumb_width,$thumb_height,$width,$height);
    ob_start();
    imagejpeg($thumb_image);
    move_uploaded_file($_FILES["image1"]["tmp_name"], "album_or/" . $name);
    $thumb=ob_get_contents();
    imagejpeg($thumb_image,"album_th/" .$name);
    //$thumb=addslashes($thumb);
    //$image=addslashes(file_get_contents($_FILES['image1']['tmp_name']));
    include("connect.php");
    include("php_helper.php");
    $query=mysqli_query_or_throw_error($con, "insert into `picweekcp` values('','$profile_id','$name','0','0')");
    $query=mysqli_query_or_throw_error($con, "insert into `album` values('','$profile_id','$name','0','1')");
    $_SESSION['uploadc']=1;
    }
    else
    {
    $_SESSION['uploadc']=2;
    }
    }
    header("location:selfied.php");
} catch(Exception $ex) {
    echo $ex->getMessage();
}
?>
