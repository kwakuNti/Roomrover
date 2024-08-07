<?php
// Starting a session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if UserID is set in the session
if (!isset($_SESSION['UserID'])) {
    // Debugging: Print a message indicating UserID is not set
    echo "Session UserID is not set. Redirecting to login page.<br>";
    header("Location: ../templates/login.php?msg=Please log in first.");
    exit();
} else {
    $user_id = ($_SESSION['UserID']);
    // echo $user_id;
    // Debugging: Print the UserID value from the session
    // $userID = $_SESSION['UserID'];
    // print_r($_SESSION);

    // Debugging: Print the UserID value
    // echo "Session UserID is set: " . $userID . "<br>";
}


