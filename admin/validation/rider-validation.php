<?php
if (isset($_SESSION['auth']) && ($_SESSION['user_info']['role'] == 3)) {
    // Unset all session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

   
    // Redirect the user to the login page or any other page
    header("Location: ../index.php");
}
