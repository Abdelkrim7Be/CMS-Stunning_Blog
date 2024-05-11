<?php
//$_SESSION["ErrorMessage"] = null; The importance of that here is that when you refresh the window , if it is not set to null , you will still se the error message because it is not empty and it is displayed in the page(same thing for the success message)

session_start();

function ErrorMessage()
{
    if (isset($_SESSION['ErrorMessage'])) {
        $Output = "<div class=\"alert alert-danger\">";
        $Output .= htmlentities($_SESSION["ErrorMessage"]);
        $Output .= "</div>";
        $_SESSION["ErrorMessage"] = null;
        return $Output;
    }
}
function SuccessMessage()
{
    if (isset($_SESSION['SuccessMessage'])) {
        $Output = "<div class=\"alert alert-success\">";
        $Output .= htmlentities($_SESSION["SuccessMessage"]);
        $Output .= "</div>";
        $_SESSION["SuccessMessage"] = null;
        return $Output;
    }
}



?>