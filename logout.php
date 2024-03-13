<?php
    session_start();
    unset($_SESSION["userId"]);
    unset($_SESSION["firstName"]);
    
    header("Location: auth.php");
?>