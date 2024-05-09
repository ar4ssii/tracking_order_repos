<?php
if (isset($_SESSION['auth']) && ($_SESSION['user_info']['role'] == 1)) {
   
    // Redirect the user to the login page or any other page
    header("Location: index.php");
}
