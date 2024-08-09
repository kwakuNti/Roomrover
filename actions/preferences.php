<?php
include '../config/connection.php';
include '../config/core.php'; // Ensure this file contains your session start and user authentication

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_SESSION['user_id']; // Assuming the user ID is stored in session

    // Get selected likes, dislikes, and knows from the form
    $likes = $_POST['likes'] ?? [];
    $dislikes = $_POST['dislikes'] ?? [];
    $knows = $_POST['knows'] ?? [];

    // Validate selections
    if (count($likes) < 2 || count($dislikes) < 2 || count($knows) < 2) {
        header('Location: ../templates/preferences.php?msg=Please select at least two preferences from each category.');
        exit;
    }

    // Delete existing preferences
    $conn->query("DELETE FROM UserLikes WHERE UserID = $userId");
    $conn->query("DELETE FROM UserDislikes WHERE UserID = $userId");
    $conn->query("DELETE FROM UserKnows WHERE UserID = $userId");

    // Insert likes into UserLikes table
    $stmt = $conn->prepare("INSERT INTO UserLikes (UserID, LikeID) VALUES (?, ?)");
    foreach ($likes as $likeId) {
        $stmt->bind_param('ii', $userId, $likeId);
        $stmt->execute();
    }
    $stmt->close();

    // Insert dislikes into UserDislikes table
    $stmt = $conn->prepare("INSERT INTO UserDislikes (UserID, DislikeID) VALUES (?, ?)");
    foreach ($dislikes as $dislikeId) {
        $stmt->bind_param('ii', $userId, $dislikeId);
        $stmt->execute();
    }
    $stmt->close();

    // Insert knows into UserKnows table
    $stmt = $conn->prepare("INSERT INTO UserKnows (UserID, KnowID) VALUES (?, ?)");
    foreach ($knows as $knowId) {
        $stmt->bind_param('ii', $userId, $knowId);
        $stmt->execute();
    }
    $stmt->close();

    // Redirect with success message
    header('Location: ../templates/profile_setup.php?msg=Preferences saved successfully.');
    exit;
}
