<?php
session_name("mySession");
session_start();
setcookie(session_name(), '', time() - 2592000, '/');
session_unset();
session_destroy();
$location = $_COOKIE["page"];
header("Location:$location");
exit();
