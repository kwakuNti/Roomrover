<?php
session_start(); // Ensure session is started

// Include the database connection file
include "../config/connection.php";
include "../config/core.php";

// Check if the user is logged in
if (isset($_SESSION['UserID'])) {
    $user_id = $_SESSION['UserID'];
    
    // Prepare the SQL query to fetch the user data
    $query = $conn->prepare("SELECT * FROM users WHERE UserID = ?");
    $query->bind_param("i", $user_id);
    $query->execute();
    $result = $query->get_result();

    // Check if a user was found
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Output user data for debugging (you can customize this)
        echo "User ID: " . htmlspecialchars($user['UserID']) . "<br>";
        echo "Email: " . htmlspecialchars($user['Email']) . "<br>";
        echo "First Name: " . htmlspecialchars($user['FirstName']) . "<br>";
        echo "Last Name: " . htmlspecialchars($user['LastName']) . "<br>";
        echo "Date of Birth: " . htmlspecialchars($user['DateOfBirth']) . "<br>";
    } else {
        echo "No user found with the ID: " . htmlspecialchars($user_id);
    }
} else {
    echo "User not logged in.";
}

// Close the database connection
$conn->close();
?>
