<?php
// ../ACTIONS/ROOM_SELECTION.PHP
include "../config/connection.php";
include "../config/core.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['UserID'])) {
    header("Location: ../templates/login.php");
    exit();
}

$userID = $_SESSION['UserID'];
$roomID = isset($_GET['roomID']) ? intval($_GET['roomID']) : 0;
$slotNumber = isset($_GET['slotNumber']) ? intval($_GET['slotNumber']) : 0;

// Get pairing ID and the other user in the pairing
$sql = "SELECT PairingID FROM PairingMembers WHERE UserID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $pairing = $result->fetch_assoc();
    $pairingID = $pairing['PairingID'];

    // Get the other user in the pairing
    $sql = "SELECT UserID FROM PairingMembers WHERE PairingID = ? AND UserID != ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $pairingID, $userID);
    $stmt->execute();
    $result = $stmt->get_result();
    $otherUserID = $result->num_rows > 0 ? $result->fetch_assoc()['UserID'] : null;
} else {
    $pairingID = null;
    $otherUserID = null;
}

// Start transaction
$conn->begin_transaction();

try {
    // Fetch the current bookings
    $sql = "SELECT SlotID, RoomID FROM Bookings WHERE UserID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $userBooking = $stmt->get_result()->fetch_assoc();

    $sql = "SELECT SlotID, RoomID FROM Bookings WHERE UserID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $otherUserID);
    $stmt->execute();
    $otherUserBooking = $stmt->get_result()->fetch_assoc();

    // If booking exists, delete old bookings and free slots
    if ($userBooking) {
        $sql = "DELETE FROM Bookings WHERE UserID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $userID);
        $stmt->execute();

        $sql = "UPDATE Slots SET IsAvailable = TRUE WHERE SlotID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $userBooking['SlotID']);
        $stmt->execute();
    }

    if ($otherUserBooking) {
        $sql = "DELETE FROM Bookings WHERE UserID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $otherUserID);
        $stmt->execute();

        $sql = "UPDATE Slots SET IsAvailable = TRUE WHERE SlotID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $otherUserBooking['SlotID']);
        $stmt->execute();
    }

    // Check slot availability for the current room
    $sql = "SELECT SlotID FROM Slots WHERE RoomID = ? AND IsAvailable = TRUE ORDER BY SlotNumber LIMIT ?";
    $stmt = $conn->prepare($sql);
    $slotsRequired = $otherUserID ? 2 : 1;
    $stmt->bind_param("ii", $roomID, $slotsRequired);
    $stmt->execute();
    $availableSlots = $stmt->get_result();

    if ($availableSlots->num_rows >= $slotsRequired) {
        $slots = [];
        while ($row = $availableSlots->fetch_assoc()) {
            $slots[] = $row['SlotID'];
        }

        // Insert new booking for the current user
        $sql = "INSERT INTO Bookings (UserID, RoomID, SlotID, BookingDate) VALUES (?, ?, ?, CURDATE())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $userID, $roomID, $slots[0]);
        $stmt->execute();

        $sql = "UPDATE Slots SET IsAvailable = FALSE WHERE SlotID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $slots[0]);
        $stmt->execute();

        // Commit transaction
        $conn->commit();
        echo "Success: Both you and your pair have been moved to the new room.";
        // header("Location: ../templates/kofi_tawiah.php?msg=Success");
        $previousPage = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '../templates/default.php';
        header("Location: $previousPage?msg=Success");

    } else {
        echo "Error: Not enough available slots in the room.";
        $previousPage = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '../templates/default.php';
        header("Location: $previousPage?msg=Unsuccess");
        $conn->rollback();
    }

    // Commit transaction
    $conn->commit();
} catch (Exception $e) {
    // Rollback transaction if something goes wrong
    $conn->rollback();
    echo "Error: Could not complete the room switch. Please try again.";
    // header("Location: ../templates/kofi_tawiah.php?msg=Unsuccess");

    $previousPage = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '../templates/default.php';
    header("Location: $previousPage?msg=Unsuccess");

}

$stmt->close();
$conn->close();
?>
