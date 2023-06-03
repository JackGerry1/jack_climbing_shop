<?php
// Start session
session_start();

// Unset session variables
session_unset();

// Destroy session
session_destroy();

// Redirect to login page
header("location: login.php");
exit();
?>
