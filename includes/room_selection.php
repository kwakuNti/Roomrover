<?php

// ../INCLUDE/ROOM_SELECTION.PHP

function displayRooms()
{
    include "../config/connection.php"; 

    $sql = "SELECT Rooms.RoomID, Rooms.RoomNumber, Rooms.Capacity, Rooms.RoomImage, 
                   Hostels.HostelName,
                   GROUP_CONCAT(CONCAT(Users.FirstName, ' ', Users.LastName) ORDER BY Users.LastName SEPARATOR ', ') AS Occupants
            FROM Rooms
            LEFT JOIN Bookings ON Rooms.RoomID = Bookings.RoomID
            LEFT JOIN Users ON Bookings.UserID = Users.UserID
            LEFT JOIN Hostels ON Rooms.HostelID = Hostels.HostelID
            GROUP BY Rooms.RoomID, Rooms.RoomNumber, Rooms.Capacity, Rooms.RoomImage, Hostels.HostelName";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $roomID = $row["RoomID"];
            $roomNumber = $row["RoomNumber"];
            $roomImage = $row["RoomImage"];
            $hostelName = $row["HostelName"];
            $occupants = $row["Occupants"] ? explode(', ', $row["Occupants"]) : [];
            $capacity = $row["Capacity"];

            echo '
            <div class="card">
                <input type="checkbox" id="card' . $roomID . '" class="more" aria-hidden="true">
                <div class="content">
                    <div class="front" style="background-image: url(\'' . htmlspecialchars($roomImage) . '\');">
                        <div class="inner">
                            <h2>' . htmlspecialchars($roomNumber) . '</h2>
                            <div class="reposition">
                                <label for="card' . $roomID . '" class="button select-button" data-room-id="' . $roomID . '" aria-hidden="true">
                                    Open
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="back">
                        <div class="inner">
                            <div class="info">
                                <span>OCCUPANTS</span>
                            </div>';

            // Display slots based on room capacity
            for ($i = 1; $i <= $capacity; $i++) {
                $slotStatus = isset($occupants[$i-1]) ? $occupants[$i-1] : 'AVAILABLE';
                echo '
                <div class="info">
                    <a href="../actions/room_selection.php?roomID=' . htmlspecialchars($roomID) . '&slotNumber=' . $i . '" class="button return no-underline" aria-hidden="true">'
                    . htmlspecialchars($slotStatus) .
                  '</a>
                </div>';
            }

            echo '
                            <label for="card' . $roomID . '" class="label return" aria-hidden="true">
                                <a class="fas fa-arrow-left">Back</a>
                            </label>
                        </div>
                    </div>
                </div>
            </div>';
        }
    } else {
        echo "<p>No rooms available.</p>";
    }

    $conn->close();
}

?>
