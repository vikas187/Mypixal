<?php
ob_start();
?>
<!DOCTYPE>
<html>
<head>
<title>
Mypixal
</title>
<meta http-equiv="Content-Type" content="text/html;" />
<meta charset="utf-8"/>
 <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
 <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="picsd.css"/>
</head>
<body>
 <div class="navbar navbar-inverse navbar-static-top">
 <div class="container">
       <div class="navbar-header">
           <a href="#" class="navbar-brand" style="font-family:impact">Mypixal</a>
               <button class = "navbar-toggle" data-toggle = "collapse" data-target = ".navHeaderCollapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
		</div>
		<div class = "collapse navbar-collapse navHeaderCollapse dropdown_custom">
				<form class="navbar-form navbar-right" action="mypixalsignup.php" method="post" name="form_login">
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Username" name="user2" required="required">
					</div>
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Password" name="pass2" onClick="document.form_login.pass2.type='password'" required="required">
					</div>
					<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-log-in"></span> Login</button>
				</form>
		</div>
	</div>
 </div>
 <?php
//establishing connection
include("connect.php");
include("php_helper.php");
//check is cookies for the user exists , the log hin in
if (isset($_COOKIE['piconusername']) && !empty($_COOKIE['piconusername'])) {
    
    header("location:mypixal.php");
}
include("mypixallogin.php");
$signuperr1 = "";
$signup     = "";
$signuperr3 = "";
$signuperr4 = "";
$signuperr5 = "";
$flag2      = 0;
$flag3      = 0;
$flag4      = 0;
if (isset($_POST['user1']) && isset($_POST['pass1']) && isset($_POST['email']) && isset($_POST['last']) && isset($_POST['pass_con'])) {
    if (empty($_POST['user1']) || empty($_POST['pass1']) || empty($_POST['email']) || empty($_POST['last']) && empty($_POST['pass_con'])) //checking if users has filled all fields in new users form.
        {
        $signuperr1 = "Please fill all the details";
    } else if ((($_POST['user1']) == "First-name") || (($_POST['pass1']) == 'Password') || (($_POST['email']) == 'E-mail Address') || (($_POST['last']) == 'Last-name') || (($_POST['pass_con']) == 'Confirm Password')) {
        $signuperr1 = "Please fill all the details";
    } else {
        $user     = htmlentities($_POST['user1']); //function htmlentities() ignores any function of html used in the fields for sql injection.
        $pass     = htmlentities(md5(strtolower($_POST['pass1'])));
        $pass_con = htmlentities(md5(strtolower($_POST['pass_con'])));
        $email    = htmlentities($_POST['email']);
        $last     = htmlentities($_POST['last']);
        if ($pass != $pass_con) //matching two passwords.
            {
            $signuperr5 = "Entered passwords does not matched";
            $flag4++;
        }
        $query = mysqli_query_or_throw_error($con, "select * from picweeksf");
        while ($row = mysqli_fetch_assoc($query)) {
            if ($email == $row['email']) //checking if email already exists.
                {
                $signuperr4 = "Id has already been made by this e-mail";
                $flag3++;
            }
        }
        if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $email)) //checking validity of email.
            {
            $signuperr3 = "Invalid e-mail";
            $flag2++;
        }
        if ($flag2 == 0 && $flag4 == 0) {
            if ($flag3 == 0) //checking if no error has occured in the form.
                {
                $query  = mysqli_query_or_throw_error($con, "insert into `picweeksf` values('','$user','$last','$pass','$email','1')"); //inserting fields value into database.
                $query  = mysqli_query_or_throw_error($con, "select `id` from `picweeksf` where `email`='$email'");
                $idcon  = mysqli_fetch_assoc($query);
                $idcon  = $idcon["id"];
                $signup = "Successfully registered,check your e-mail id first for our mail to log in.";
                //$content="Thanks for joining mypixal.Click the given link to confirm your registration http://www.mypixal.com/confirmation.php?id=$idcon&email=$email";
                //mail( "$email", "Confirmation-mail", "$content", "From: sv-enterprises@mypixal.com");//sending confirmation mail to the user.
                //echo "<script type='text/javascript'>alert('Confirmation link has been sent to your e-mail id,check your registered e-mail id.')</script>";
                setcookie('piconpassword', $pass, time() + 3600 * 24 * 30);
                setcookie('piconusername', $user, time() + 3600 * 24 * 30);
                setcookie('piconlastname', $last, time() + 3600 * 24 * 30);
                $query      = mysqli_query_or_throw_error($con, "select `id` from `picweeksf` where `email`='$email'");
                $row        = mysqli_fetch_assoc($query);
                $profile_id = $row['id'];
                setcookie('piconprofile_id', $profile_id, time() + 3600 * 24 * 30);
            }
        }
    }
}
if($signuperr1) {
    echo "<div class='alert alert-danger alert-dismissible fade in'>";
    echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>$signuperr1 </div>";
}
if ($signuperr3) {
    echo "<div class='alert alert-danger alert-dismissible fade in'>";
    echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>$signuperr3 </div>";
}
if($signuperr4) {
    echo "<div class='alert alert-danger alert-dismissible fade in'>";
    echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>$signuperr4 </div>";
}
if($signuperr5) {
    echo "<div class='alert alert-danger alert-dismissible fade in'>";
    echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>$signuperr5 </div>";
}
if($signup) {
    echo "<div class='alert alert-success alert-dismissible fade in'>";
    echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>$signup </div>";
}

?>
		<div class="jumbotron jumbotron_custom">
		<div class="row">
		<div class="col-md-6">
		<center>
		
		<h2>Top Rated Pics</h2>
			<div id="myCarousel" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
				<ol class="carousel-indicators">
				<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
				<?php
$flag  = 1;
$query = mysqli_query_or_throw_error($con, "select `id` from `album` where `status`='1' order by `likes` desc limit 0,5");
if (mysqli_num_rows($query) > 0) {
    while ($row = mysqli_fetch_assoc($query)) {
        echo "<li data-target='#myCarousel' data-slide-to='$flag'></li>";
        $flag++;
    }
}
?>
</ol>
<div class="carousel-inner" role="listbox">
    <div class="item active">
        <?php
$id    = null;
$query = mysqli_query_or_throw_error($con, "select `id`,`name` from `album` where `status`='1' order by `likes` desc limit 0,1");
if (mysqli_num_rows($query) == 0) {
    echo "<img src='album_th/selena.jpg' alt='First slide' width='60%'>";
} else {
    $result   = mysqli_fetch_assoc($query);
    $id = $result["id"];
    $name = $result["name"];
    echo "<img src='album_th/$name' alt='First Slide' width='60%'>";
}
?>
					</div>
					<?php
if ($id != null) {
    $query = mysqli_query_or_throw_error($con, "select `name` from `album` where `id`!='$id' order by `likes` desc limit 0,5");
    while ($row = mysqli_fetch_assoc($query)) {
        $name = $row['name'];
        echo "<div class='item'>";
        echo "<img src='album_th/$name' alt='Slide' width='60%'>";
        echo "</div>";
    }
}
?>
				</div>
				<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
					<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				</a>
				<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
					<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				</a>
			</div>
			</center>
			</div>
			<div class="col-md-6">
			<center>
			<form class="form-signin form-signin_custom" name="form_signup" method="post" action="mypixalsignup.php">
				<h2 class="form-signin-heading">Sign-up</h2>
				<input type="text" class="form-control input_custom" placeholder="First-name" name="user1" required="required"/>
				<input type="text" class="form-control input_custom" placeholder="Last-name" name="last" required="required"/>
				<input type="text" class="form-control input_custom" placeholder="Password" name="pass1" onClick="document.form_signup.pass1.type='password' "required="required"/>
				<input type="text" class="form-control input_custom" placeholder="Confirm Password" name="pass_con" onClick="document.form_signup.pass_con.type='password' " required="required"/>
				<input type="email" class="form-control input_custom" placeholder="Email Address" name="email" required="required"/>
				<button type="submit" class="btn btn-primary btn-signup_custom" required="required">Sign up</button>
			</form>
			</center>
			</div>
			</div>
		</div>
 <div class="navbar navbar-inverse navbar-fixed-bottom">
		<div class="container footer_custom" >
			<p class='navbar-text pull-center' >&copyMypixal-2020</p>
		</div>
 </div>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
