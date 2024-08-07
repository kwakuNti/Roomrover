
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link rel="stylesheet" href="../public/css/profile.css">
    <link rel="stylesheet" href="../public/css/snackbar.css">
    <link rel="stylesheet" href="../public/css/notification.css">
    <link rel="stylesheet" href="../public/css/preferences.css">
    <link rel="stylesheet" href="../public/css/feedback.css">
    <!-- <link rel="stylesheet" href="../public/css/roomates.css"> -->

    <script src="../public/js/snackbar.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<div id="snackbar">Please confirm your room details</div>

    <div class="sidebar">
        <nav>
            <a href="#" class="back"><i class="fas fa-arrow-left"></i></a>
            <a href="#"><i class="fas fa-home"></i> Roomates</a>
            <a href="../templates/bio.php"><i class="fas fa-bed"></i>Bio</a>
            <a href="#" id="feedback-button"><i class="fas fa-comment"></i> Feedback</a>
            <a href="../templates/preferences.php"><i class="fas fa-cogs"></i> Preferences</a>
            <a href="#" id="notification-link"><i class="fas fa-bell"></i> Notifications</a>
        </nav>
        <div class="logout">
            <a href="#"><i class="fas fa-sign-out-alt"></i> Log out</a>
        </div>
    </div>
    <div class="main-content">
        <div class="header">
            <h1>Room details</h1>
            <div class="profile-pic">
                <img src="../assets/images/hostel1.jpg" alt="Profile Picture">
            </div>
        </div>
        <div class="student-details">
            <div class="profile-pic">
                <img src="../assets/images/hostel1.jpg" alt="Profile Picture">
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
                    <span>Number of roomates</span>
                    <span class="i">1</span>
                </div>
                <div>
                    <p>Click <a href="roomate_profiles.php" class="profile-link" style= "color:blue">here</a> to see roommate profiles</p>
                </div>
                                
                
            </div>
        </div>
    </div>
    

      <!-- Notification Popup -->
      <div class="popup" id="notification-popup">
        <div class="popup-content">
            <span class="close" id="close-popup">&times;</span>
            <div class="wrapper">
                <div class="top-bar">
                    <div class="title">
                        <p class="title-text">Notifications</p>
                        <p class="num">5</p>
                    </div>
                    <a href="#" class="read">Mark all as read</a>
                </div>
                <div class="notifications">
                    <!-- Example notifications -->
                    <div class="single-box unseen">
                        <div class="avatar"><img src="../assets/images/hostel1.jpg" alt="Avatar"></div>
                        <div class="message">Hey can i be your roomate</div>
                    </div>
                    <div class="single-box unseen">
                        <div class="avatar"><img src="../assets/images/hostel1.jpg" alt="Avatar"></div>
                        <div class="message">You suck as a roomate andaodsndvklpodkdvd djfd ldfld dfhjdfjdf df dfldfjlkdf df dfldfldf d</div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Feedback Popup -->
<div class="popup" id="feedback-popup">
    <div class="popup-content">
        <span class="close" id="close-feedback-popup">&times;</span>
        <div class="feedback-form">
            <form id="feedbackForm">
                <label for="message">Message</label>
                <textarea id="message" name="message" rows="4" required></textarea>

                <button type="submit">Submit</button>
            </form>
        </div>
    </div>
</div>

    <script src="../public/js/notification.js"></script>
    <script src="../public/js/feedback.js"></script>

</body>
</html>
