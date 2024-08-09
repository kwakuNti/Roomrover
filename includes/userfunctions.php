<?php
include '../config/connection.php';
$userId = $_SESSION['UserID'];
// user_functions.php
function getUserDetails($userId) {
    global $conn; // Use the existing database connection

    // Prepare and execute the query
    $stmt = $conn->prepare("SELECT FirstName, LastName, Email, DateOfBirth, Country, Bio, ProfileImage FROM Users WHERE UserID = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->bind_result($firstName, $lastName, $email, $dob, $country, $bio, $profileImage );

    // Fetch data
    if ($stmt->fetch()) {
        $userDetails = [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'date_of_birth' => $dob,
            'Country' => $country,
            'bio' => $bio,
            'profile_image' => $profileImage
        ];
    } else {
        $userDetails = null;
    }

    $stmt->close();
    return $userDetails;
}
?>
