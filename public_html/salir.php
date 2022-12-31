<?php
include("/db.php");
setcookie("U", '', '/', time()-1);
setcookie("P", '', '/', time()-1);
session_destroy();
unset($_COOKIE['U']);
unset($_COOKIE['P']);
header("location: /index.php");
exit();
?>