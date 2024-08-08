<?php
session_start(); // Start the session

// Destroy the session to log the user out
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session

// Redirect to the login page or home page
header("Location: ../templates/login.php"); // Change the location as needed
exit();
?>
