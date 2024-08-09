<?php
include '../config/connection.php';
$userId = $_SESSION['UserID'];
// user_functions.php
function getUserDetails($userId) {
    global $conn; // Use the existing database connection

    // Prepare and execute the query
    $stmt = $conn->prepare("SELECT FirstName, LastName, Email, DateOfBirth, Country, Bio, PhoneNumber, ProfileImage FROM Users WHERE UserID = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->bind_result($firstName, $lastName, $email, $dob, $country, $bio, $PhoneNumber, $profileImage );

    // Fetch data
    if ($stmt->fetch()) {
        $userDetails = [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'date_of_birth' => $dob,
            'Country' => $country,
            'bio' => $bio,
            'PhoneNumber' => $PhoneNumber,
            'profile_image' => $profileImage
        ];
    } else {
        $userDetails = null;
    }

    $stmt->close();
    return $userDetails;
}



function getUserPreferences($userId) {
    global $conn;

    // Fetch likes
    $result = $conn->query("SELECT LikeText FROM Likes WHERE LikeID IN (SELECT LikeID FROM UserLikes WHERE UserID = $userId)");
    $likes = $result->fetch_all(MYSQLI_ASSOC);

    // Fetch dislikes
    $result = $conn->query("SELECT DislikeText FROM Dislikes WHERE DislikeID IN (SELECT DislikeID FROM UserDislikes WHERE UserID = $userId)");
    $dislikes = $result->fetch_all(MYSQLI_ASSOC);

    // Fetch knows
    $result = $conn->query("SELECT KnowText FROM Knows WHERE KnowID IN (SELECT KnowID FROM UserKnows WHERE UserID = $userId)");
    $knows = $result->fetch_all(MYSQLI_ASSOC);

    return [
        'likes' => $likes,
        'dislikes' => $dislikes,
        'knows' => $knows,
    ];
}

?>
