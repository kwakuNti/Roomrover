<?php

// ../INCLUDE/ROOM_SELECTION.PHP

function displayRooms()
{
    include "../config/connection.php"; // Adjust the path if necessary

    // SQL query to get room and occupant details
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
            if ($capacity == 2) {
                $slot1Status = isset($occupants[0]) ? $occupants[0] : 'AVAILABLE';
                $slot2Status = isset($occupants[1]) ? $occupants[1] : 'AVAILABLE';
                echo '
                <div class="info">
                    <a href="../actions/room_selection.php?roomID=' . htmlspecialchars($roomID) . '&slotNumber=1" class="button return no-underline" aria-hidden="true">'
                    . htmlspecialchars($slot1Status) .
                  '</a>
                </div>
                <div class="info">
                    <a href="../actions/room_selection.php?roomID=' . htmlspecialchars($roomID) . '&slotNumber=2" class="button return no-underline" aria-hidden="true">'
                    . htmlspecialchars($slot2Status) .
                  '</a>
                </div>';
            } elseif ($capacity == 4) {
                $slot1Status = isset($occupants[0]) ? $occupants[0] : 'AVAILABLE';
                $slot2Status = isset($occupants[1]) ? $occupants[1] : 'AVAILABLE';
                $slot3Status = isset($occupants[2]) ? $occupants[2] : 'AVAILABLE';
                $slot4Status = isset($occupants[3]) ? $occupants[3] : 'AVAILABLE';
                echo '
                <div class="info">
                    <a href="../actions/room_selection.php?roomID=' . htmlspecialchars($roomID) . '&slotNumber=1" class="button return no-underline" aria-hidden="true">'
                    . htmlspecialchars($slot1Status) .
                  '</a>
                </div>
                <div class="info">
                    <a href="../actions/room_selection.php?roomID=' . htmlspecialchars($roomID) . '&slotNumber=2" class="button return no-underline" aria-hidden="true">'
                    . htmlspecialchars($slot2Status) .
                  '</a>
                </div>
                <div class="info">
                    <a href="../actions/room_selection.php?roomID=' . htmlspecialchars($roomID) . '&slotNumber=3" class="button return no-underline" aria-hidden="true">'
                    . htmlspecialchars($slot3Status) .
                  '</a>
                </div>
                <div class="info">
                    <a href="../actions/room_selection.php?roomID=' . htmlspecialchars($roomID) . '&slotNumber=4" class="button return no-underline" aria-hidden="true">'
                    . htmlspecialchars($slot4Status) .
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

    // Close the database connection
    $conn->close();
}


// function displayRooms()
// {
//     include "../config/connection.php"; // Adjust the path if necessary

//     // SQL query to get room and occupant details
//     $sql = "SELECT Rooms.RoomID, Rooms.RoomNumber, Rooms.Capacity, Rooms.RoomImage, 
//                    Hostels.HostelName,
//                    GROUP_CONCAT(CONCAT(Users.FirstName, ' ', Users.LastName) ORDER BY Users.LastName SEPARATOR ', ') AS Occupants
//             FROM Rooms
//             LEFT JOIN Bookings ON Rooms.RoomID = Bookings.RoomID
//             LEFT JOIN Users ON Bookings.UserID = Users.UserID
//             LEFT JOIN Hostels ON Rooms.HostelID = Hostels.HostelID
//             GROUP BY Rooms.RoomID, Rooms.RoomNumber, Rooms.Capacity, Rooms.RoomImage, Hostels.HostelName";

//     $result = $conn->query($sql);

//     if ($result->num_rows > 0) {

//         while ($row = $result->fetch_assoc()) {
//             $roomID = $row["RoomID"];
//             $roomNumber = $row["RoomNumber"];
//             $roomImage = $row["RoomImage"];
//             $hostelName = $row["HostelName"];
//             $occupants = $row["Occupants"] ? explode(', ', $row["Occupants"]) : [];
//             $capacity = $row["Capacity"];

//             // Display card
//             echo '
//             <div class="card">
//                 <input type="checkbox" id="card' . $roomID . '" class="more" aria-hidden="true">
//                 <div class="content">
//                     <div class="front" style="background-image: url(\'' . htmlspecialchars($roomImage) . '\');">
//                         <div class="inner">
//                             <h2>' . htmlspecialchars($roomNumber) . '</h2>
//                             <div class="reposition">
//                                 <label for="card' . $roomID . '" class="button select-button" aria-hidden="true">
//                                     Open
//                                 </label>
//                             </div>
//                         </div>
//                     </div>
//                     <div class="back">
//                         <div class="inner">
//                             <div class="info">
//                                 <span>OCCUPANTS</span>
//                             </div>';

//             // Display slots based on room capacity
//             for ($i = 1; $i <= $capacity; $i++) {
//                 $slotStatus = isset($occupants[$i-1]) ? $occupants[$i-1] : 'AVAILABLE';
//                 echo '
//                 <div class="info">
//                     <a href="../actions/room_selection.php?roomID=' . htmlspecialchars($roomID) . '&slotNumber=' . $i . '" class="button return no-underline" aria-hidden="true">'
//                     . htmlspecialchars($slotStatus) .
//                   '</a>
//                 </div>';
//             }

//             echo '
//                             <label for="card' . $roomID . '" class="label return" aria-hidden="true">
//                                 <a class="fas fa-arrow-left">Back</a>
//                             </label>
//                         </div>
//                     </div>
//                 </div>
//             </div>';
//         }
//     } else {
//         echo "<p>No rooms available.</p>";
//     }

//     // Close the database connection
//     $conn->close();
// }

?>
