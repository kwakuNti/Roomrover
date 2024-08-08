<?php

// // ../INCLUDE/ROOM_SELECTION.PHP

// function displayRooms()
// {
//     include "../config/connection.php"; 

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

//             echo '
//             <div class="card">
//                 <input type="checkbox" id="card' . $roomID . '" class="more" aria-hidden="true">
//                 <div class="content">
//                     <div class="front" style="background-image: url(\'' . htmlspecialchars($roomImage) . '\');">
//                         <div class="inner">
//                             <h2>' . htmlspecialchars($roomNumber) . '</h2>
//                             <div class="reposition">
//                                 <label for="card' . $roomID . '" class="button select-button" data-room-id="' . $roomID . '" aria-hidden="true">
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


//             $slotStatus = isset($occupants[0]) ? $occupants[0] : 'AVAILABLE';
            
//             echo '
//             <div class="info">
//                 <a href="../actions/room_selection.php?roomID=' . htmlspecialchars($roomID) . '&slotNumber=' . 1 . '" class="button return no-underline" aria-hidden="true">'
//                 . htmlspecialchars($slotStatus."1") .
//               '</a>
//             </div>';
//             $slotStatus = isset($occupants[1]) ? $occupants[1] : 'AVAILABLE';
            
//             echo '
//             <div class="info">
//                 <a href="../actions/room_selection.php?roomID=' . htmlspecialchars($roomID) . '&slotNumber=' . 2 . '" class="button return no-underline" aria-hidden="true">'
//                 . htmlspecialchars($slotStatus."2") .
//               '</a>
//             </div>';
//             $slotStatus = isset($occupants[2]) ? $occupants[2] : 'AVAILABLE';
            
//             echo '
//             <div class="info">
//                 <a href="../actions/room_selection.php?roomID=' . htmlspecialchars($roomID) . '&slotNumber=' . 3 . '" class="button return no-underline" aria-hidden="true">'
//                 . htmlspecialchars($slotStatus."3") .
//               '</a>
//             </div>';
//             $slotStatus = isset($occupants[3]) ? $occupants[3] : 'AVAILABLE';
            
//             echo '
//             <div class="info">
//                 <a href="../actions/room_selection.php?roomID=' . htmlspecialchars($roomID) . '&slotNumber=' . 4 . '" class="button return no-underline" aria-hidden="true">'
//                 . htmlspecialchars($slotStatus ."4") .
//               '</a>
//             </div>';
 




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

//     $conn->close();
// }


function displayRooms()
{
    include "../config/connection.php"; 

    $sql = "SELECT Rooms.RoomID, Rooms.RoomNumber, Rooms.Capacity, Rooms.RoomImage, 
                   Hostels.HostelName
            FROM Rooms
            LEFT JOIN Hostels ON Rooms.HostelID = Hostels.HostelID";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $roomID = $row["RoomID"];
            $roomNumber = $row["RoomNumber"];
            $roomImage = $row["RoomImage"];
            $hostelName = $row["HostelName"];
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

            // Loop through each slot in the room
            for ($slotNumber = 1; $slotNumber <= $capacity; $slotNumber++) {
                $occupantSql = "SELECT CONCAT(Users.FirstName, ' ', Users.LastName) AS OccupantName 
                                FROM Bookings 
                                LEFT JOIN Users ON Bookings.UserID = Users.UserID 
                                WHERE Bookings.RoomID = ? AND Bookings.SlotID = (SELECT SlotID FROM Slots WHERE RoomID = ? AND SlotNumber = ?)";

                $stmt = $conn->prepare($occupantSql);
                $stmt->bind_param("iii", $roomID, $roomID, $slotNumber);
                $stmt->execute();
                $occupantResult = $stmt->get_result();

                $occupantName = ($occupantResult->num_rows > 0) ? $occupantResult->fetch_assoc()["OccupantName"] : 'AVAILABLE';

                echo '
                <div class="info">
                    <a href="../actions/room_selection.php?roomID=' . htmlspecialchars($roomID) . '&slotNumber=' . htmlspecialchars($slotNumber) . '" class="button return no-underline" aria-hidden="true">'
                    . htmlspecialchars($occupantName) .
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
