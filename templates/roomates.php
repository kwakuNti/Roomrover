<?php
include "../config/core.php";

checkLogin();
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
                    <span class="i">Kofi Tawiah</span>
                </div>
                <div>
                    <span>Block name</span>
                    <span class="i">K-block</span>
                </div>
                <div>
                    <span>Room number</span>
                    <span class="i">K6</span>
                </div>
                <div>
                    <span>Number of roommates</span>
                    <span class="i">1</span>
                </div>
                <div>
                    <p>Click <a href="roomate_profiles.php" class="profile-link" style="color:blue">here</a> to see roommate profiles</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
