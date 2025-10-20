<?php
    session_start(); // Start the session

    // Unset session variables
    unset($_SESSION["admin_ID"]);

    // Destroy the session
    session_unset();
    session_destroy();

    // Redirect to the login page
    header("Location: login.php");
    exit(); // Ensure no further code is executed
?>