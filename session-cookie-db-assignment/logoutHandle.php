<?php
session_start();
session_destroy();
setcookie('session_id','',time()-777);
header('Location:http://127.0.0.1/session-cookie-db-assignment/index.php');
?>