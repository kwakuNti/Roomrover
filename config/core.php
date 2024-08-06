<?php
// Starting a session
session_start();

// Check if UserID is set in the session
if (!isset($_SESSION['UserID'])) {
    // Debugging: Print a message indicating UserID is not set
    echo "Session UserID is not set. Redirecting to login page.<br>";
    header("Location: ../templates/login.php?msg=Please log in first.");
    exit();
} else {
    // Debugging: Print the UserID value from the session
    $userID = $_SESSION['UserID'];
    print_r($_SESSION);

    // Debugging: Print the UserID value
    echo "Session UserID is set: " . $userID . "<br>";
}


