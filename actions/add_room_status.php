<?php
// Include database connection
include '../config/connection.php';

// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $roomID = $_POST['room-select'];
    $roomStatus = $_POST['room-status'] === 'available' ? true : false; // true or false

    // Update the room availability in the database
    $query = "UPDATE Rooms SET Available = ? WHERE RoomID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('bi', $roomStatus, $roomID); // 'b' for boolean
    
    if ($stmt->execute()) {
        echo "Room status updated successfully.";
    } else {
        echo "Error updating room status: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
