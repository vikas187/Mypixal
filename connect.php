<?php
$dbhost="localhost";
$dbuser="root";
$dbpass="";
$con=mysqli_connect($dbhost,$dbuser,$dbpass, 'mypixal');
if(!$con)
{
    die("Error description: " . mysqli_connect_error());
}
?>
