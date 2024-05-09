<?php
if(isset($_SESSION['auth']) && $_SESSION['user_info']['role'] != 4){
    header("Location: login.php");
    exit();
}
if(!isset($_SESSION['auth']))
{
    header("Location: login.php");
    exit();
}