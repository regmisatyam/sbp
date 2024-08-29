<?php
// Initialize session
session_start();

// Unset all of the session variables
$_SESSION = array();

// Destroy the session
session_destroy();
include '../../sbp-contents/globalVar.php';
// Redirect to the login page or any other page after logout
header("location: $website/sbp-admin/dashboard/");
exit();
?>
