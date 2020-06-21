<?php
ob_start();
?>
<!DOCTYPE>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;" />
<meta charset="utf-8"/>
 <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<link type="text/css"  rel="stylesheet" href='css/bootstrap.min.css' />
<link type="text/css" href='picsd.css' rel="stylesheet" />
<title>Change Password</title>
</head>
<body>
<?php
include("connect.php");
include('php_helper.php');
if(!isset($_COOKIE['piconusername'])&&empty($_COOKIE['piconusername']))//if not logged in.
{
header("location:logout.php");
}
$error="";//error 1.
$error1="";//error 2.
$flag1=0; 
$flag=0;

echo "<form method='post' action='changepassword.php' name='form-signin'>";//form for change password.
echo "Current Password:<input type='password' name='pass1' class='form-control input_custom1' required/></br>";//current pass field.
echo "New Password:<input type='password' name='pass2' class='form-control input_custom1' required/></br>";//new pass field.
echo "Confirm password:<input type='password' name='con_pass' class='form-control input_custom1' required/></br>";//confirm field.
echo "<button type='submit'  name='submit' class='btn btn-primary' >Submit</button></br>";//sybmit button.
echo "</form>";
if(isset($_POST['pass1'])&&isset($_POST['pass2'])&&isset($_POST['con_pass']))//if all 3 fields are set.
{
if(!empty($_POST['pass1'])&&!empty($_POST['pass2'])&&!empty($_POST['con_pass']))//if all 3 fields are not empty.
{
$profile_id=$_COOKIE['piconprofile_id'];//profile_id of you.
$pass1=htmlentities(md5($_POST['pass1']));//current password.
$pass2=htmlentities(md5($_POST['pass2']));//new password.
$con_pass=htmlentities(md5($_POST['con_pass']));//confirm password.
if($con_pass!=$pass2)//if confirm pass is not equal to new pass.
{
$error="Entered password Does Not matched";
$flag++;
}
if($flag==0)
{
$query=mysqli_query_or_throw_error($con, "select `password` from `picweeksf` where `id`='$profile_id'");//select password of you from db.
$password=mysqli_fetch_assoc($query);
$password = $password['password'];//pass.
if($password!=$pass1)//if current pass is incorrect.
{
$error1="Current Password is Not Correct";
$flag1++;
}
if($flag1==0)
{
$query=mysqli_query_or_throw_error($con, "update `picweeksf` set `password`='$pass2' where `id`='$profile_id'");//update password.
echo "<span style='color:blue;'>Your password has been Changed Successfully</span>";//password has been changed.
}
}
}
}
echo "<div style='color:red'>$error</div>";//error1.
echo "<div style='color:red'>$error1</div>";//error2.
echo "<a href='mypixal.php' class='link1' >Back to Site</a>";//back to site.
?>
</body>
</html>
<?php
ob_end_flush();
?>
