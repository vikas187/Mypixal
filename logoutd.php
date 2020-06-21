<?php
setcookie('piconusername','',time()-3600);
setcookie('piconpassword','',time()-3600);
setcookie('piconprofile_id','',time()-3600);
setcookie('piconlastname','',time()-3600);
header("location:mypixal.php");
?>