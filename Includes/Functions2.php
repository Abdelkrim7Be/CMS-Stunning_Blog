<?php
require_once("Includes/DB.php");
function Redirect_to($New_Location)
{
    header("Location: " . $New_Location);
    exit;
}
function CheckUserNameExistsOrNot($Username)
{
    global $connectingDB;
    $sql = "SELECT username from admins where username = :userName";
    $stmt = $connectingDB->prepare($sql);
    $stmt->bindValue(':userName', $Username);
    $stmt->execute();
    $Result = $stmt->rowCount();
    if ($Result == 1) {
        return true;
    } else {
        return false;
    }
}

function Login_Attempt($Username, $Password)
{
    global $connectingDB;
    $sql = "SELECT * FROM admins WHERE username = :userName AND password = :passWord LIMIT 1";
    $stmt = $connectingDB->prepare($sql);
    $stmt->bindValue(':userName', $Username);
    $stmt->bindValue(':passWord', $Password);
    $stmt->execute();
    $Result = $stmt->rowCount();
    if ($Result == 1) {
        return $Found_Account = $stmt->fetch();
    } else {
        return null;
    }
}

function Confirm_Login()
{
    if (isset($_SESSION["User_ID"])) {
        return true;
    } else {
        $_SESSION["ErrorMessage"] = "Login Required !";
        Redirect_to("Login.php");
    }
}
// if the user_ID is set in the session return true, otherwise, make my pages password protected
// i will add this function to every page that i want it to be password protected

function TotalPosts()
{
    global $connectingDB;
    $sql = "SELECT COUNT(*) FROM posts";
    $stmt = $connectingDB->query($sql);
    $TotalRows = $stmt->fetch();
    $TotalPosts = array_shift($TotalRows);
    echo $TotalPosts;
}

function TotalCategories()
{
    global $connectingDB;
    $sql = "SELECT COUNT(*) FROM category";
    $stmt = $connectingDB->query($sql);
    $TotalRows = $stmt->fetch();
    $TotalCategories = array_shift($TotalRows);
    echo $TotalCategories;
}

function TotalAdmins()
{
    global $connectingDB;
    $sql = "SELECT COUNT(*) FROM admins";
    $stmt = $connectingDB->query($sql);
    $TotalRows = $stmt->fetch();
    $TotalAdmins = array_shift($TotalRows);
    echo $TotalAdmins;
}

function TotalComments()
{
    global $connectingDB;
    $sql = "SELECT COUNT(*) FROM comments";
    $stmt = $connectingDB->query($sql);
    $TotalRows = $stmt->fetch();
    $TotalComments = array_shift($TotalRows);
    echo $TotalComments;
}

function ApproveCommentsAccordingToPosts($postId) {
    global $connectingDB;
    $sql_approve = "SELECT COUNT(*) FROM comments WHERE post_id='$postId' AND status='ON'";
    $stmt_approve = $connectingDB->query($sql_approve);
    $RowsTotal = $stmt_approve->fetch();
    $TotalRows = array_shift($RowsTotal);
    return $TotalRows;
}
function DisApproveCommentsAccordingToPosts($postId) {
    global $connectingDB;
    $sql_approve = "SELECT COUNT(*) FROM comments WHERE post_id='$postId' AND status='OFF'";
    $stmt_approve = $connectingDB->query($sql_approve);
    $RowsTotal = $stmt_approve->fetch();
    $TotalRows = array_shift($RowsTotal);
    return $TotalRows;
}
?>