<?php
include "../config/core.php";

if (!isset($_SESSION['UserID'])) {
    // If UserID is not set, redirect to login page
    header("Location: ../templates/login.php?msg=Please log in first.");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> -->
    <link href="https://fonts.googleapis.com/css2?family=Times New Roman:wght@400;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="../public/css/roomates.css">
	<title>AdminSite</title>
</head>
<body>
<div class="wrapper">
    <div class="band">
        <h1>WALTER SISULU'S ROOMS</h1>
    </div>
        <div class="card">
            <input type="checkbox" id="card1" class="more" aria-hidden="true">
            <div class="content">
            <div class="front" style="background-image: url('../templates/img/banner/banner.png');">
                    <div class="inner">
                        <h2>S1</h2>
                        <label for="card1" class="button" aria-hidden="true">
                            Details
                        </label>
                    </div>
                </div>
                <div class="back">
                    <div class="inner">
                        <div class="info">
                            <span>OCCUPANTS</span>
                        </div>
                        <div class="info">
                            <label for="card1" class="button return" aria-hidden="true">
                                HENRY BAIDEN
                            </label>
                        </div>
                        <div class="info">
                            <label for="card1" class="button return" aria-hidden="true">
                                JOSEPH LARTEY
                            </label>
                        </div>
                        <div class="description">
                            <p> S1 is a two-in-a-room that shares a corridor and a bathroom with S2.
                            The rooms available take either 2 or 4 occupants.
                            All rooms that take 2 occupants are two times smaller than rooms that take 4 occupants.</p>
                        </div>
                        <label for="card1" class="button return" aria-hidden="true">
                            <a class="fas fa-arrow-left">Back</a>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <input type="checkbox" id="card2" class="more" aria-hidden="true">
            <div class="content">
            <div class="front" style="background-image: url('../templates/img/banner/banner.png');">
                    <div class="inner">
                        <h2>S2</h2>
                        <label for="card2" class="button" aria-hidden="true">
                            Details
                        </label>
                    </div>
                </div>
                <div class="back">
                    <div class="inner">
                        <div class="info">
                            <span>OCCUPANTS</span>
                        </div>
                        <div class="info">
                            <label for="card1" class="button return" aria-hidden="true">
                                HENRY BAIDEN
                            </label>
                        </div>
                        <div class="info">
                            <label for="card1" class="button return" aria-hidden="true">
                                JOSEPH LARTEY
                            </label>
                        </div>
                        <div class="description">
                            <p> S2 is a two-in-a-room that shares a corridor and a bathroom with S1.
                            The rooms available take either 2 or 4 occupants.
                            All rooms that take 2 occupants are two times smaller than rooms that take 4 occupants.</p>
                        </div>
                        <label for="card2" class="button return" aria-hidden="true">
                            <a class="fas fa-arrow-left">Back</a>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <input type="checkbox" id="card3" class="more" aria-hidden="true">
            <div class="content">
            <div class="front" style="background-image: url('../templates/img/banner/banner.png');">
                    <div class="inner">
                        <h2>S3</h2>
                        <label for="card3" class="button" aria-hidden="true">
                            Details
                        </label>
                    </div>
                </div>
                <div class="back">
                    <div class="inner">
                        <div class="info">
                            <span>OCCUPANTS</span>
                        </div>
                        <div class="info">
                            <label for="card3" class="button return" aria-hidden="true">
                                HENRY BAIDEN
                            </label>
                        </div>
                        <div class="info">
                            <label for="card3" class="button return" aria-hidden="true">
                                JOSEPH LARTEY
                            </label>
                        </div>
                        <div class="description">
                            <p> S3 is a two-in-a-room that shares a corridor and a bathroom with S4.
                            The rooms available take either 2 or 4 occupants.
                            All rooms that take 2 occupants are two times smaller than rooms that take 4 occupants.</p>
                        </div>
                        <label for="card3" class="button return" aria-hidden="true">
                            <a class="fas fa-arrow-left">Back</a>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <input type="checkbox" id="card4" class="more" aria-hidden="true">
            <div class="content">
            <div class="front" style="background-image: url('../templates/img/banner/banner.png');">
                    <div class="inner">
                        <h2>S4</h2>
                        <label for="card4" class="button" aria-hidden="true">
                            Details
                        </label>
                    </div>
                </div>
                <div class="back">
                    <div class="inner">
                        <div class="info">
                            <span>OCCUPANTS</span>
                        </div>
                        <div class="info">
                            <label for="card4" class="button return" aria-hidden="true">
                                HENRY BAIDEN
                            </label>
                        </div>
                        <div class="info">
                            <label for="card4" class="button return" aria-hidden="true">
                                JOSEPH LARTEY
                            </label>
                        </div>
                        <div class="description">
                            <p> S4 is a two-in-a-room that shares a corridor and a bathroom with S3.
                            The rooms available take either 2 or 4 occupants.
                            All rooms that take 2 occupants are two times smaller than rooms that take 4 occupants.</p>
                        </div>
                        <label for="card4" class="button return" aria-hidden="true">
                            <a class="fas fa-arrow-left">Back</a>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <input type="checkbox" id="card5" class="more" aria-hidden="true">
            <div class="content">
            <div class="front" style="background-image: url('../templates/img/banner/banner.png');">
                    <div class="inner">
                        <h2>S5</h2>
                        <label for="card5" class="button" aria-hidden="true">
                            Details
                        </label>
                    </div>
                </div>
                <div class="back">
                    <div class="inner">
                        <div class="info">
                            <span>OCCUPANTS</span>
                        </div>
                        <div class="info">
                            <label for="card5" class="button return" aria-hidden="true">
                                HENRY BAIDEN
                            </label>
                        </div>
                        <div class="info">
                            <label for="card5" class="button return" aria-hidden="true">
                                JOSEPH LARTEY
                            </label>
                        </div>
                        <div class="description">
                            <p> S5 is a two-in-a-room that shares a corridor and a bathroom with S6.
                            The rooms available take either 2 or 4 occupants.
                            All rooms that take 2 occupants are two times smaller than rooms that take 4 occupants.</p>
                        </div>
                        <label for="card5" class="button return" aria-hidden="true">
                            <a class="fas fa-arrow-left">Back</a>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <input type="checkbox" id="card6" class="more" aria-hidden="true">
            <div class="content">
            <div class="front" style="background-image: url('../templates/img/banner/banner.png');">
                    <div class="inner">
                        <h2>S6</h2>
                        <label for="card6" class="button" aria-hidden="true">
                            Details
                        </label>
                    </div>
                </div>
                <div class="back">
                    <div class="inner">
                        <div class="info">
                            <span>OCCUPANTS</span>
                        </div>
                        <div class="info">
                            <label for="card6" class="button return" aria-hidden="true">
                                HENRY BAIDEN
                            </label>
                        </div>
                        <div class="info">
                            <label for="card6" class="button return" aria-hidden="true">
                                JOSEPH LARTEY
                            </label>
                        </div>
                        <div class="description">
                            <p> S6 is a two-in-a-room that shares a corridor and a bathroom with S5.
                            The rooms available take either 2 or 4 occupants.
                            All rooms that take 2 occupants are two times smaller than rooms that take 4 occupants.</p>
                        </div>
                        <label for="card6" class="button return" aria-hidden="true">
                            <a class="fas fa-arrow-left">Back</a>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <input type="checkbox" id="card7" class="more" aria-hidden="true">
            <div class="content">
            <div class="front" style="background-image: url('../templates/img/banner/banner.png');">
                    <div class="inner">
                        <h2>S7</h2>
                        <label for="card7" class="button" aria-hidden="true">
                            Details
                        </label>
                    </div>
                </div>
                <div class="back">
                    <div class="inner">
                        <div class="info">
                            <span>OCCUPANTS</span>
                        </div>
                        <div class="info">
                            <label for="card7" class="button return" aria-hidden="true">
                                HENRY BAIDEN
                            </label>
                        </div>
                        <div class="info">
                            <label for="card7" class="button return" aria-hidden="true">
                                JOSEPH LARTEY
                            </label>
                        </div>
                        <div class="description">
                            <p> S7 is a two-in-a-room that shares a corridor and a bathroom with S8.
                            The rooms available take either 2 or 4 occupants.
                            All rooms that take 2 occupants are two times smaller than rooms that take 4 occupants.</p>
                        </div>
                        <label for="card7" class="button return" aria-hidden="true">
                            <a class="fas fa-arrow-left">Back</a>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <input type="checkbox" id="card8" class="more" aria-hidden="true">
            <div class="content">
            <div class="front" style="background-image: url('../templates/img/banner/banner.png');">
                    <div class="inner">
                        <h2>S8</h2>
                        <label for="card8" class="button" aria-hidden="true">
                            Details
                        </label>
                    </div>
                </div>
                <div class="back">
                    <div class="inner">
                        <div class="info">
                            <span>OCCUPANTS</span>
                        </div>
                        <div class="info">
                            <label for="card8" class="button return" aria-hidden="true">
                                HENRY BAIDEN
                            </label>
                        </div>
                        <div class="info">
                            <label for="card8" class="button return" aria-hidden="true">
                                JOSEPH LARTEY
                            </label>
                        </div>
                        <div class="description">
                            <p> S8 is a two-in-a-room that shares a corridor and a bathroom with S7.
                            The rooms available take either 2 or 4 occupants.
                            All rooms that take 2 occupants are two times smaller than rooms that take 4 occupants.</p>
                        </div>
                        <label for="card8" class="button return" aria-hidden="true">
                            <a class="fas fa-arrow-left">Back</a>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <input type="checkbox" id="card9" class="more" aria-hidden="true">
            <div class="content">
            <div class="front" style="background-image: url('../templates/img/banner/banner.png');">
                    <div class="inner">
                        <h2>S9</h2>
                        <label for="card9" class="button" aria-hidden="true">
                            Details
                        </label>
                    </div>
                </div>
                <div class="back">
                    <div class="inner">
                        <div class="info">
                            <span>OCCUPANTS</span>
                        </div>
                        <div class="info">
                            <label for="card9" class="button return" aria-hidden="true">
                                HENRY BAIDEN
                            </label>
                        </div>
                        <div class="info">
                            <label for="card9" class="button return" aria-hidden="true">
                                JOSEPH LARTEY
                            </label>
                        </div>
                        <div class="description">
                            <p> S9 is a two-in-a-room that shares a corridor and a bathroom with S10.
                            The rooms available take either 2 or 4 occupants.
                            All rooms that take 2 occupants are two times smaller than rooms that take 4 occupants.</p>
                        </div>
                        <label for="card9" class="button return" aria-hidden="true">
                            <a class="fas fa-arrow-left">Back</a>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <input type="checkbox" id="card10" class="more" aria-hidden="true">
            <div class="content">
            <div class="front" style="background-image: url('../templates/img/banner/banner.png');">
                    <div class="inner">
                        <h2>S10</h2>
                        <label for="card10" class="button" aria-hidden="true">
                            Details
                        </label>
                    </div>
                </div>
                <div class="back">
                    <div class="inner">
                        <div class="info">
                            <span>OCCUPANTS</span>
                        </div>
                        <div class="info">
                            <label for="card10" class="button return" aria-hidden="true">
                                HENRY BAIDEN
                            </label>
                        </div>
                        <div class="info">
                            <label for="card10" class="button return" aria-hidden="true">
                                JOSEPH LARTEY
                            </label>
                        </div>
                        <div class="description">
                            <p> S10 is a two-in-a-room that shares a corridor and a bathroom with S9.
                            The rooms available take either 2 or 4 occupants.
                            All rooms that take 2 occupants are two times smaller than rooms that take 4 occupants.</p>
                        </div>
                        <label for="card10" class="button return" aria-hidden="true">
                            <a class="fas fa-arrow-left">Back</a>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <input type="checkbox" id="card11" class="more" aria-hidden="true">
            <div class="content">
            <div class="front" style="background-image: url('../templates/img/banner/banner.png');">
                    <div class="inner">
                        <h2>S11</h2>
                        <label for="card11" class="button" aria-hidden="true">
                            Details
                        </label>
                    </div>
                </div>
                <div class="back">
                    <div class="inner">
                        <div class="info">
                            <span>OCCUPANTS</span>
                        </div>
                        <div class="info">
                            <label for="card11" class="button return" aria-hidden="true">
                                HENRY BAIDEN
                            </label>
                        </div>
                        <div class="info">
                            <label for="card11" class="button return" aria-hidden="true">
                                JOSEPH LARTEY
                            </label>
                        </div>
                        <div class="description">
                            <p> S11 is a two-in-a-room that shares a corridor and a bathroom with S12.
                            The rooms available take either 2 or 4 occupants.
                            All rooms that take 2 occupants are two times smaller than rooms that take 4 occupants.</p>
                        </div>
                        <label for="card11" class="button return" aria-hidden="true">
                            <a class="fas fa-arrow-left">Back</a>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <input type="checkbox" id="card12" class="more" aria-hidden="true">
            <div class="content">
            <div class="front" style="background-image: url('../templates/img/banner/banner.png');">
                    <div class="inner">
                        <h2>S12</h2>
                        <label for="card12" class="button" aria-hidden="true">
                            Details
                        </label>
                    </div>
                </div>
                <div class="back">
                    <div class="inner">
                        <div class="info">
                            <span>OCCUPANTS</span>
                        </div>
                        <div class="info">
                            <label for="card12" class="button return" aria-hidden="true">
                                HENRY BAIDEN
                            </label>
                        </div>
                        <div class="info">
                            <label for="card12" class="button return" aria-hidden="true">
                                JOSEPH LARTEY
                            </label>
                        </div>
                        <div class="description">
                            <p> S12 is a two-in-a-room that shares a corridor and a bathroom with S11.
                            The rooms available take either 2 or 4 occupants.
                            All rooms that take 2 occupants are two times smaller than rooms that take 4 occupants.</p>
                        </div>
                        <label for="card12" class="button return" aria-hidden="true">
                            <a class="fas fa-arrow-left">Back</a>
                        </label>
                    </div>
                </div>
            </div>
        </div>


    </div>
	
	<script src="../public/js/roomates.js"></script>
</body>
</html>