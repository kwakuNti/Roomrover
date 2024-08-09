<?php
include "../config/core.php";
include "../includes/userfunctions.php";

checkLogin();
$userId = $_SESSION['UserID']; // Or however you store the logged-in user's ID

$roomDetails = getRoomDetails($userId);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link rel="stylesheet" href="../public/css/roomate.css">
    <link rel="stylesheet" href="../public/css/preferences.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div class="main-content">
        <div class="header">
            <h1>Room details</h1>
        </div>
        <div class="student-details">
            <div class="large-header-image">
                <img src="../assets/images/hostel1.jpg" alt="Header Image">
            </div>
            <div class="details">
                <div>
                    <span>Hostel name</span>
                    <span class="i"><?php echo htmlspecialchars($roomDetails['HostelName']); ?></span>
                </div>
               
                <div>
                    <span>Room number</span>
                    <span class="i"><?php echo htmlspecialchars($roomDetails['RoomNumber']); ?></span>
                </div>
                <div>
                    <span>Number of room members</span>
                    <span class="i"><?php echo htmlspecialchars($roomDetails['NumberOfRoommates']); ?></span>
                </div>
                <div>
                    <p>Click <a href="roomate_profiles.php" class="profile-link" style="color:blue">here</a> to see roommate profiles</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
