<?php
// Starting a session
session_start();

// Check if UserID is set in the session
if (!isset($_SESSION['UserID'])) {
    // Debugging: Print a message indicating UserID is not set
    header("Location: ../templates/login.php?msg=Please log in first.");
    exit();
} else {
    // Debugging: Print the UserID value from the session
    $userID = $_SESSION['UserID'];

    // Debugging: Print the UserID value
}


