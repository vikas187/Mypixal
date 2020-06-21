<?php
if (isset($_COOKIE['piconusername']) && !empty($_COOKIE['piconusername'])) ///checking if user has successfully logged in.
{
	include("connect.php");
    $profile_id = $_COOKIE['piconprofile_id'];
    $query      = mysqli_query_or_throw_error($con, "select `status` from `message` where `status`='0' && `to`='$profile_id'"); //checking if user has received any new message.
    $no         = mysqli_num_rows($query);
    $flag       = 0;
    $query      = mysqli_query_or_throw_error($con, "select * from `picweekpp`  order by `likes` desc limit 5"); //checking if you have earned any point in the profile pic category.
	while ($row = mysqli_fetch_assoc($query)) 
	{
        $status      = $row['status'];
        $profile_id1 = $row['profile_id'];
		if ($status == 0 && $profile_id1 == $profile_id) 
		{
            $flag++;
            break;
        }
    }
    $query = mysqli_query_or_throw_error($con, "select * from `picweekfp`  order by `likes` desc limit 5"); //funny pic.
	while ($row = mysqli_fetch_assoc($query)) 
	{
        $status      = $row['status'];
        $profile_id1 = $row['profile_id'];
		if ($status == 0 && $profile_id1 == $profile_id) 
		{
            $flag++;
            break;
        }
    }
    $query = mysqli_query_or_throw_error($con, "select * from `picweekcp`  order by `likes` desc limit 5"); //creative pic.
	while ($row = mysqli_fetch_assoc($query)) 
	{
        $status      = $row['status'];
        $profile_id1 = $row['profile_id'];
		if ($status == 0 && $profile_id1 == $profile_id) 
		{
            $flag++;
            break;
        }
    }
    $query = mysqli_query_or_throw_error($con, "select * from `picweekpp` order by `likes` desc limit 5"); //checking if your any pic in profile pic has earned any new like.
	while ($row = mysqli_fetch_assoc($query)) 
	{
        $name = $row['name'];
        $q    = mysqli_query_or_throw_error($con, "select * from `likes` where `profile_id`='$profile_id' && `name`='$name' && `status`='0'");
		if (mysqli_num_rows($q) != 0) 
		{
            $flag++;
            break;
        }
    }
    $query = mysqli_query_or_throw_error($con, "select * from `picweekfp` order by `likes` desc limit 5") ; //funny pic.
    while ($row = mysqli_fetch_assoc($query)) {
        $name = $row['name'];
        $q = mysqli_query_or_throw_error($con, "select * from `likes` where `profile_id`='$profile_id' && `name`='$name' && `status`='0'") or die(mysql_connect_error());
        if (mysqli_num_rows($q) != 0) {
            $flag++;
            break;
        }
    }
    $query = mysqli_query_or_throw_error($con, "select * from `picweekcp` order by `likes` desc limit 5") or die(mysql_connect_error()); //creative pic.
    while ($row = mysqli_fetch_assoc($query)) {
        $name = $row['name'];
        $q = mysqli_query_or_throw_error($con, "select * from `likes` where `profile_id`='$profile_id' && `name`='$name' && `status`='0'") or die(mysql_connect_error());
        if (mysqli_num_rows($q) != 0) {
            $flag++;
            break;
        }
    }
    $query = mysqli_query_or_throw_error($con, "select * from `popular` where `liked`='$profile_id' && `status`='0'") ; //check if user has gain any popularity.
    if (mysqli_num_rows($query) != 0) {
        $flag++;
    }
    $query = mysqli_query_or_throw_error($con, "select * from `positives` where `for`='$profile_id' && `status`='0'") ; //check if anybody has shared anything new about the user.
    if (mysqli_num_rows($query) != 0) {
        $flag++;
    }
?>
 <div class="navbar navbar-inverse navbar-fixed-top">
 <div class="container">
       <div class="navbar-header">
           <a href="mypixal.php" class="navbar-brand" style="font-family:impact">Mypixal</a>
               <button class = "navbar-toggle" data-toggle = "collapse" data-target = ".navHeaderCollapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span></button>
		</div>
<div class = "collapse navbar-collapse navHeaderCollapse dropdown_custom">
  <ul class = "nav navbar-nav navbar-right">
    <li ><a href="mypixal.php" ><span class='glyphicon glyphicon-home'></span>Home</a></li>
    <li><a href="profiled.php"><span class='glyphicon glyphicon-user'></span>Profile</a></li>
    <!--<li><a href="favourd.php"><span class='glyphicon glyphicon-star'></span>Favourites</a></li>
    <li><a href="peopled.php"><span class='glyphicon glyphicon-globe'></span>People</a></li>-->
	<?php
    if ($no != 0) {
        echo "<li><a href='inboxd.php'><span class='glyphicon glyphicon-inbox'></span> Inbox($no)</a></li>";
    } else {
        echo "<li><a href='inboxd.php'><span class='glyphicon glyphicon-inbox'></span> Inbox</a></li>";
    }
    if ($flag != 0) {
        echo "<li><a href='news.php'><span class='glyphicon glyphicon-alert'></span>Notifications($flag)</a></li>";
    } else {
        echo "<li><a href='news.php'><span class='glyphicon glyphicon-alert'></span>Notifications</a></li>";
    }
?>
	<li class="dropdown">
      <a class="dropdown-toggle" data-toggle="dropdown"><span class='glyphicon glyphicon-list'></span>Rankings<b class="caret"></b> </a>
        <ul class="dropdown-menu">
          <!--<li><a href="gamed.php">Comment me</a></li>-->
          <li><a href="pointtabled.php">Points Table</a></li>
          <li><a href="mostpopulard.php">Popularity</a></li>
        </ul>
    </li>
    <li ><a href="favourd.php" ><span class='glyphicon glyphicon-heart'></span>Favourites</a></li>
	<li class="dropdown">
      <a class="dropdown-toggle" data-toggle="dropdown"><span class='glyphicon glyphicon-upload'></span>Upload<b class="caret"></b> </a>
        <ul class="dropdown-menu">
          <li><a href="selfied.php">Selfie</a></li>
          <li><a href="funnypicd.php">Funny Pic</a></li>
          <li><a href="profilepicd.php">Display Pic</a></li>
        </ul>
    </li>
  </ul>

		<form class="navbar-form navbar-right" action="searchd.php" method="post">
			<div class="form-group">
				<input type="text" class="form-control" placeholder="Search for Users..." name='search_name'>
			</div>
			<button type="submit" class="btn btn-primary">
				<span class="glyphicon glyphicon-search"></span>
			</button>
        </form>
</div>
</div> 
</div>
<?php
    include("header-static.php");
    $query = mysqli_query_or_throw_error($con, "select `popular`,`points` from `profile` where `profile_id`='$profile_id'") ; //extracting popular,points from 'profile'.
    if ((mysqli_num_rows($query)) != 0) {
        $q = mysqli_query_or_throw_error($con, "select * from `profile`") ;
        $total   = mysqli_num_rows($q);
        $popular = mysqli_fetch_assoc($query);
        $popular = $popular['popular'];
        $points  = mysqli_fetch_assoc($query);
        $points  = $points['points'];
        $popular = ($popular / $total) * 100;
        $popular = round($popular, 3);
        echo "<div align='right'><a  href='earnpointsd.php'>Points:$points</a></div>"; //print no of points of user.
    }
} else {
    header("location:mypixalsignup.php"); //if not logged in,redirect to sign-up page.
}
?>
