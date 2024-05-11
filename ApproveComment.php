<?php
require_once("Includes/DB.php");
require_once("Includes/Functions2.php");
require_once("Includes/Sessions.php");
$_SESSION['TrackingURL'] = $_SERVER["PHP_SELF"];

Confirm_Login();

if (isset($_GET['id'])) {
    $SearchQueryParameter = $_GET['id'];
    global $connectingDB;
    $Admin = $_SESSION['AdminName'];
    $sql = "UPDATE comments SET status = 'ON' , approvedby = '$Admin' where id = '$SearchQueryParameter'";
    $Execute = $connectingDB->query($sql);
    if ($Execute) {
        $_SESSION['SuccessMessage'] = "Comment Approved Successfully !";
        Redirect_to("Comments.php");
    } else {
        $_SESSION['ErrorMessage'] = "Something went wrong, Try Again !";
        Redirect_to("Comments.php");
    }
}
?>