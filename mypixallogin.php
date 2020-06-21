<?php
$loginerr1 = "";
$loginerr2 = "";
$login     = "";
$flag      = 0;
if (isset($_POST['user2']) && isset($_POST['pass2'])) {
    if (empty($_POST['user2']) || empty($_POST['pass2'])) //checking if user has filled all the fields of the registered users form.
        {
        $loginerr1 = "Please Fill All The Details";
    } else if ($_POST['user2'] == 'E-mail' || $_POST['pass2'] == 'Password') //checking if user has pressed login without entering value.
        {
        $loginerr1 = "Please Fill All The Details";
    } else {
        $user  = htmlentities($_POST['user2']); //setting 'user' to entered e-mail.
        $pass  = htmlentities(md5(strtolower($_POST['pass2'])));
        $query = mysqli_query_or_throw_error($con, "select * from picweeksf");
        while ($row = mysqli_fetch_assoc($query)) {
            if (strtolower($user) == strtolower($row['email']) && $pass == $row['password']) //checking existence of user in the database.
                {
                $flag++;
                setcookie('piconpassword', $row["password"], time() + 3600 * 24 * 30);
                setcookie('piconusername', $row["firstname"], time() + 3600 * 24 * 30);
                setcookie('piconlastname', $row["lastname"], time() + 3600 * 24 * 30); //if user exist,setting cookies.
                $query = mysqli_query_or_throw_error($con, "select `id` from `picweeksf` where `email`='$user'"); //selecting id from row where entered emil matches.
                $row        = mysqli_fetch_assoc($query);
                $profile_id = $row['id'];
                setcookie('piconprofile_id', $profile_id, time() + 3600 * 24 * 30);
                header("location:mypixal.php"); //redirecting to mypixal.php.
            }
        }
        if ($flag == 0) {
            $loginerr2 = "This E-mail And Password Combination Does'nt Exists";
        }
    }
}
?>
<?php
if($loginerr1) {
    echo "<div class='alert alert-danger alert-dismissible fade in'>";
    echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>$loginerr1 </div>";
}
if($loginerr2) {
    echo "<div class='alert alert-danger alert-dismissible fade in'>";
    echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>$loginerr2 </div>";
}

?>

