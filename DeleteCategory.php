<?php
require_once("Includes/DB.php");
require_once("Includes/Functions2.php");
require_once("Includes/Sessions.php");
$_SESSION['TrackingURL'] = $_SERVER["PHP_SELF"];

Confirm_Login();

if (isset($_GET['id'])) {
    $SearchQueryParameter = $_GET['id'];
    global $connectingDB;
    $sql = "DELETE FROM category WHERE id = '$SearchQueryParameter'";
    $Execute = $connectingDB->query($sql);
    if ($Execute) {
        $_SESSION['SuccessMessage'] = "Category Deleted Successfully !";
        Redirect_to("Categories.php");
    } else {
        $_SESSION['ErrorMessage'] = "Something went wrong, Try Again !";
        Redirect_to("Categories.php");
    }
}
?>