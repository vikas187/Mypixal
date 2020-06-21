<?php
ob_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width,initial-scale=1.0"/>

<title>Profile-mypixal</title>
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="picsd.css"/>
</head>
<body>
<?php
include("php_helper.php");
include("headerd.php");
$profile_id=$_COOKIE['piconprofile_id'];
$query=mysqli_query_or_throw_error($con, "select * from `profile` where `profile_id`='$profile_id'");
if((mysqli_num_rows($query))!=0)
{
header("location:profiled.php");
}
if(isset($_POST['name'])&&isset($_POST['course'])&&isset($_POST['live'])&&isset($_POST['status'])&&isset($_POST['gender']))
{
if(!empty($_POST['name'])&&!empty($_POST['course'])&&!empty($_POST['live'])&&!empty($_POST['status'])&&!empty($_POST['gender']))
{
$name=$_POST['name'];
$course=$_POST['course'];
$gender=$_POST['gender'];
$d=$_POST['day'];
$m=$_POST['month'];
$y=$_POST['year'];
$image="images/ppic.jpg";
$live=$_POST['live'];
$status=$_POST['status'];
$profile_id=$_COOKIE['piconprofile_id'];
$query=mysqli_query_or_throw_error($con,"select `id` from `profile` where `profile_id`='$profile_id'");
if(mysqli_num_rows($query)==0)
{
$query=mysqli_query_or_throw_error($con,"insert into `profile` values('','$name','$course','$gender','$live','$d','$m','$y','$image','$status','$profile_id','1','0','0')");
$query=mysqli_query_or_throw_error($con,"insert into rate values('$profile_id','0','0')");
}
header("location:profiled.php");
}
else
{
	echo "<div class='alert alert-danger alert-dismissible fade in'>";
    echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Please Fill All The Details </div>";
}
}
include("footerd.php");
if(isset($_COOKIE['piconusername'])&&!empty($_COOKIE['piconusername']))
{
echo "</center>";
}
else
{
header("location:mypixal.php");
}
?>
<div class='container'>
	<div class="jumbotron jumbotron_custom1">
		<center>
			<p class="heading">Create Profile</p>
			<div class="row">
		<div class="col-md-4">
		<img width="100%" class='thumbnail' src="images/ppic.jpg"/>
		</div>
<div class="col-md-8">
<form action="createprofiled.php" method="post">
<table class='table table-striped'>
<td>
Name:</td>
<td >
<?php
echo "<input class='form-control input_custom' type='text' name='name' value='" .$_COOKIE['piconusername']. "'/>";
?>
</td>
</tr>
<tr>
<td > 
Profession:
</td>
<td >
<input type='text' name='course' class='form-control input_custom'/>
</td>
</tr>
<tr>
<td>
Gender:
</td>
<td>
<select name="gender" class='form-control input_custom' style="width:50%">
<option value="male">Male</option>
<option value="female">Female</option>
</select>
</td>
</tr>
<tr>
<td>
DOB:
</td>
<td >
<select name="day" class='input input_custom'>
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
<option value="6">6</option>
<option value="7">7</option>
<option value="8">8</option>
<option value="9">9</option>
<option value="10">10</option>
<option value="11">11</option>
<option value="12">12</option>
<option value="12">12</option>
<option value="13">13</option>
<option value="14">14</option>
<option value="15">15</option>
<option value="16">16</option>
<option value="17">17</option>
<option value="18">18</option>
<option value="19">19</option>
<option value="20">20</option>
<option value="21">21</option>
<option value="22">22</option>
<option value="23">23</option>
<option value="24">24</option>
<option value="25">25</option>
<option value="26">26</option>
<option value="27">27</option>
<option value="28">28</option>
<option value="29">29</option>
<option value="30">30</option>
<option value="31">31</option>
</select>
-
<select name="month" class='input'>
<option value="Jan">Jan</option>
<option value="Feb">Feb</option>
<option value="Mar">Mar</option>
<option value="Apr">Apr</option>
<option value="May">May</option>
<option value="June">June</option>
<option value="July">July</option>
<option value="Aug">Aug</option>
<option value="Sep">Sep</option>
<option value="Oct">Oct</option>
<option value="Nov">Nov</option>
<option value="Dec">Dec</option>
</select>
-
<select name="year" class='input'>
<option value="2009">2009</option>
<option value="2008">2008</option>
<option value="2007">2007</option>
<option value="2006">2006</option>
<option value="2005">2005</option>
<option value="2004">2004</option>
<option value="2003">2003</option>
<option value="2002">2002</option>
<option value="2001">2001</option>
<option value="2000">2000</option>
<option value="1999">1999</option>
<option value="1998">1998</option>
<option value="1997">1997</option>
<option value="1996">1996</option>
<option value="1995">1995</option>
<option value="1994">1994</option>
<option value="1993">1993</option>
<option value="1992">1992</option>
<option value="1991">1991</option>
<option value="1990">1990</option>
<option value="1989">1989</option>
<option value="1988">1988</option>
<option value="1987">1987</option>
<option value="1986">1986</option>
<option value="1985">1985</option>
<option value="1984">1984</option>
<option value="1983">1983</option>
<option value="1982">1982</option>
<option value="1981">1981</option>
<option value="1980">1980</option>
<option value="1979">1979</option>
<option value="1978">1978</option>
<option value="1977">1977</option>
<option value="1976">1976</option>
<option value="1975">1975</option>
<option value="1974">1974</option>
<option value="1973">1973</option>
<option value="1972">1972</option>
<option value="1971">1971</option>
<option value="1970">1970</option>
<option value="1969">1969</option>
<option value="1968">1968</option>
<option value="1967">1967</option>
<option value="1966">1966</option>
<option value="1965">1965</option>
<option value="1964">1964</option>
<option value="1963">1963</option>
<option value="1962">1962</option>
<option value="1961">1961</option>
<option value="1960">1960</option>
<option value="1959">1959</option>
<option value="1958">1958</option>
<option value="1957">1957</option>
<option value="1956">1956</option>
<option value="1955">1955</option>
<option value="1954">1954</option>
<option value="1953">1953</option>
<option value="1952">1952</option>
<option value="1951">1951</option>
<option value="1950">1950</option>
<option value="1949">1949</option>
<option value="1948">1948</option>
<option value="1947">1947</option>
<option value="1946">1946</option>
<option value="1945">1945</option>
<option value="1944">1944</option>
<option value="1943">1943</option>
<option value="1942">1942</option>
<option value="1941">1941</option>
<option value="1940">1940</option>
<option value="1939">1939</option>
<option value="1938">1938</option>
<option value="1937">1937</option>
<option value="1936">1936</option>
<option value="1935">1935</option>
<option value="1934">1934</option>
<option value="1933">1933</option>
<option value="1932">1932</option>
<option value="1931">1931</option>
<option value="1930">1930</option>
<option value="1929">1929</option>
<option value="1928">1928</option>
<option value="1927">1927</option>
<option value="1926">1926</option>
<option value="1925">1925</option>
<option value="1924">1924</option>
<option value="1923">1923</option>
<option value="1922">1922</option>
<option value="1921">1921</option>
<option value="1920">1920</option>
<option value="1919">1919</option>
<option value="1918">1918</option>
<option value="1917">1917</option>
<option value="1916">1916</option>
<option value="1915">1915</option>
<option value="1914">1914</option>
<option value="1913">1913</option>
<option value="1912">1912</option>
<option value="1911">1911</option>
<option value="1910">1910</option>
<option value="1909">1909</option>
</select>
</td>
</tr>
<tr>
<td >
Lives in:
</td>
<td>
<input type="text" name="live" class="form-control input_custom" />
</td>
</tr>
<tr>
<td >
Quote:
</td>
<td>
<textarea name="status"  class='form-control input_custom'></textarea>
</td>
</tr>
</table>
<input type="submit" class="btn btn-primary input_custom" value="Create" name="create" />
</form>
</div>
</div>
</div>
</div>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
<?php
ob_end_flush();
?>