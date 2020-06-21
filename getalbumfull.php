<?php
$name=$_REQUEST['name'];
if(!isset($_REQUEST['name']))
{
header("location:index.php");
}
echo "<img width='50%' src=\"album_or/$name\"/>";
?>