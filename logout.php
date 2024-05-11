<?php
require_once("Includes/DB.php");
require_once("Includes/Functions2.php");
require_once("Includes/Sessions.php"); ?>

<?php

$_SESSION["User_ID"] = null;
$_SESSION["Username"] = null;
$_SESSION["AdminName"] = null;


session_destroy();
Redirect_to("Login.php");
?>