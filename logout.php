<?php

// hapus session
session_start();
$_SESSION = [];
session_unset();
session_destroy();

// hapus cookie
setcookie('kepo', '', time()-3600);
setcookie('haha', '', time()-3600);

header("Location: login.php");
exit;
?>