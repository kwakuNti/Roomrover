<?php
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
