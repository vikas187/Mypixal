<?php
include("connect.php");
include("php_helper.php");
$id=addslashes($_REQUEST['id']);
$query=mysqli_query_or_throw_error($con, "delete from `positives` where `id`='$id'");
if($query)
{
echo "";
}
?>