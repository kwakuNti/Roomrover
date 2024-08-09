<?php
// ../ACTIONS/ROOM_SELECTION.PHP
include "../config/connection.php";
include "../config/core.php";

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['UserID'])) {
    // Redirect to login if user is not logged in
    header("Location: ../templates/login.php");
    exit();
}

$userID = $_SESSION['UserID'];
$roomID = isset($_GET['roomID']) ? intval($_GET['roomID']) : 0;
$slotNumber = isset($_GET['slotNumber']) ? intval($_GET['slotNumber']) : 0;

// Fetch pairing ID associated with the current user
$sql = "SELECT PairingID FROM PairingMembers WHERE UserID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $pairing = $result->fetch_assoc();
    $pairingID = $pairing['PairingID'];

    // Fetch the other user associated with the same pairing ID
    $sql = "SELECT UserID FROM PairingMembers WHERE PairingID = ? AND UserID != ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $pairingID, $userID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $otherUser = $result->fetch_assoc();
        $otherUserID = $otherUser['UserID'];
    } else {
        $otherUserID = null;
    }
} else {
    $pairingID = null;
    $otherUserID = null;
}

// Fetch current slot for the user
$sql = "SELECT SlotID FROM Bookings WHERE UserID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();
$currentBooking = $result->fetch_assoc();
$currentSlotID = $currentBooking['SlotID'];

// Fetch current slot for the paired user
$sql = "SELECT SlotID FROM Bookings WHERE UserID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $otherUserID);
$stmt->execute();
$result = $stmt->get_result();
$otherCurrentBooking = $result->fetch_assoc();
$otherCurrentSlotID = $otherCurrentBooking['SlotID'];

// Begin transaction
$conn->begin_transaction();

try {
    // Free the previously booked slot for current user
    $sql = "DELETE FROM Bookings WHERE UserID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userID);
    $stmt->execute();

    // Free the previously booked slot for paired user
    $sql = "DELETE FROM Bookings WHERE UserID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $otherUserID);
    $stmt->execute();

    // Mark both slots as available
    $sql = "UPDATE Slots SET IsAvailable = TRUE WHERE SlotID = ? OR SlotID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $currentSlotID, $otherCurrentSlotID);
    $stmt->execute();

    // Check if there are two available slots in the selected room
    $sql = "SELECT SlotID FROM Slots WHERE RoomID = ? AND IsAvailable = TRUE LIMIT 2";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $roomID);
    $stmt->execute();
    $result = $stmt->get_result();

    $availableSlots = array();
    while ($row = $result->fetch_assoc()) {
        $availableSlots[] = $row['SlotID'];
    }

    // Check if two distinct slots are available
    if (count($availableSlots) >= 2) {
        $selectedSlotID = $availableSlots[0];
        $additionalSlotID = $availableSlots[1];

        // Insert the new booking for the current user
        $sql = "INSERT INTO Bookings (UserID, RoomID, SlotID, BookingDate) VALUES (?, ?, ?, CURDATE())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $userID, $roomID, $selectedSlotID);
        $stmt->execute();

        // Insert the new booking for the paired user
        $sql = "INSERT INTO Bookings (UserID, RoomID, SlotID, BookingDate) VALUES (?, ?, ?, CURDATE())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $otherUserID, $roomID, $additionalSlotID);
        $stmt->execute();

        // Mark both new slots as unavailable
        $sql = "UPDATE Slots SET IsAvailable = FALSE WHERE SlotID = ? OR SlotID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $selectedSlotID, $additionalSlotID);
        $stmt->execute();

        // Commit transaction
        $conn->commit();
        echo "Success: Both you and your pair have been moved to the new room.";
    } else {
        echo "Error: Not enough available slots in the room.";
        $conn->rollback();
    }
} catch (Exception $e) {
    // Rollback transaction on error
    $conn->rollback();
    echo "Error: Could not complete the room switch. Please try again.";
}

$stmt->close();
$conn->close();
?>
