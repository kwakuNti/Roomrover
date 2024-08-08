<?php

// // ../ACTIONS/ROOM_SELECTION.PHP

// include "../config/connection.php";
// include "../config/core.php";

// // Start session if not already started
// if (session_status() === PHP_SESSION_NONE) {
//     session_start();
// }

// // Check if user is logged in
// if (!isset($_SESSION['UserID'])) {
//     // Redirect to login if user is not logged in
//     header("Location: ../templates/login.php");
//     exit();
// }

// $userID = $_SESSION['UserID'];
// $roomID = isset($_GET['roomID']) ? intval($_GET['roomID']) : 0; // Retrieve roomID from URL using GET
// $slotNumber = isset($_GET['slotNumber']) ? intval($_GET['slotNumber']) : 0; // Retrieve slotNumber from URL using GET

// // Fetch user details from the database
// $sql = "SELECT FirstName, LastName FROM Users WHERE UserID = ?";
// $stmt = $conn->prepare($sql);
// $stmt->bind_param("i", $userID);
// $stmt->execute();
// $result = $stmt->get_result();

// if ($result->num_rows > 0) {
//     $row = $result->fetch_assoc();
//     $firstName = $row['FirstName'];
//     $lastName = $row['LastName'];
//     $fullName = $firstName . ' ' . $lastName;
// } else {
//     echo "Error: User not found.";
//     exit();
// }

// // Check if the user already has a slot booked
// $sql = "SELECT SlotID, RoomID FROM Bookings WHERE UserID = ?";
// $stmt = $conn->prepare($sql);
// $stmt->bind_param("i", $userID);
// $stmt->execute();
// $result = $stmt->get_result();

// if ($result->num_rows > 0) {
//     // If user has a slot booked, free the slot
//     $currentBooking = $result->fetch_assoc();
//     $currentSlotID = $currentBooking['SlotID'];
//     $currentRoomID = $currentBooking['RoomID'];

//     // Delete the current booking
//     $sql = "DELETE FROM Bookings WHERE UserID = ?";
//     $stmt = $conn->prepare($sql);
//     $stmt->bind_param("i", $userID);
//     $stmt->execute();

//     // Mark the slot as available again
//     $sql = "UPDATE Slots SET IsAvailable = TRUE WHERE SlotID = ?";
//     $stmt = $conn->prepare($sql);
//     $stmt->bind_param("i", $currentSlotID);
//     $stmt->execute();
// }

// // Check if the new slot is available
// $sql = "SELECT * FROM Slots WHERE RoomID = ? AND SlotNumber = ? AND IsAvailable = TRUE";
// $stmt = $conn->prepare($sql);
// $stmt->bind_param("ii", $roomID, $slotNumber);
// $stmt->execute();
// $result = $stmt->get_result();

// if ($result->num_rows > 0) {
//     $slot = $result->fetch_assoc();
//     $slotID = $slot['SlotID'];

//     // Add the user to the new room slot
//     $sql = "INSERT INTO Bookings (UserID, RoomID, SlotID, BookingDate) VALUES (?, ?, ?, CURDATE())";
//     $stmt = $conn->prepare($sql);
//     $stmt->bind_param("iii", $userID, $roomID, $slotID);
//     $stmt->execute();

//     // Update the slot to mark it as unavailable
//     $sql = "UPDATE Slots SET IsAvailable = FALSE WHERE SlotID = ?";
//     $stmt = $conn->prepare($sql);
//     $stmt->bind_param("i", $slotID);
//     $stmt->execute();

//     echo "Success: You have been added to the room.";
//     header("Location: ../templates/kofi_tawiah.php");
//     exit();

// } else {
//     echo "Error: Slot not available or does not exist.";
// }

// $stmt->close();
// $conn->close();



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
$roomID = isset($_GET['roomID']) ? intval($_GET['roomID']) : 0; // Retrieve roomID from URL using GET
$slotNumber = isset($_GET['slotNumber']) ? intval($_GET['slotNumber']) : 0; // Retrieve slotNumber from URL using GET

// Fetch user details from the database
$sql = "SELECT FirstName, LastName FROM Users WHERE UserID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $firstName = $row['FirstName'];
    $lastName = $row['LastName'];
    $fullName = $firstName . ' ' . $lastName;
} else {
    echo "Error: User not found.";
    exit();
}

// Check if the user already has a slot booked
$sql = "SELECT SlotID, RoomID FROM Bookings WHERE UserID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // If user has a slot booked, get the details of the current booking
    $currentBooking = $result->fetch_assoc();
    $currentSlotID = $currentBooking['SlotID'];
    $currentRoomID = $currentBooking['RoomID'];

    // Check if the new slot is available
    $sql = "SELECT * FROM Slots WHERE RoomID = ? AND SlotNumber = ? AND IsAvailable = TRUE";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $roomID, $slotNumber);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // If the new slot is available, free the current slot and book the new slot
        $slot = $result->fetch_assoc();
        $slotID = $slot['SlotID'];

        // Delete the current booking
        $sql = "DELETE FROM Bookings WHERE UserID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $userID);
        $stmt->execute();

        // Mark the current slot as available again
        $sql = "UPDATE Slots SET IsAvailable = TRUE WHERE SlotID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $currentSlotID);
        $stmt->execute();

        // Add the user to the new room slot
        $sql = "INSERT INTO Bookings (UserID, RoomID, SlotID, BookingDate) VALUES (?, ?, ?, CURDATE())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $userID, $roomID, $slotID);
        $stmt->execute();

        // Update the new slot to mark it as unavailable
        $sql = "UPDATE Slots SET IsAvailable = FALSE WHERE SlotID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $slotID);
        $stmt->execute();

        echo "Success: You have been added to the room.";
        header("Location: ../templates/kofi_tawiah.php");
        exit();
    } else {
        echo "Error: Slot not available or does not exist.";
    }
} else {
    // If the user doesn't have a slot booked, check if the new slot is available
    $sql = "SELECT * FROM Slots WHERE RoomID = ? AND SlotNumber = ? AND IsAvailable = TRUE";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $roomID, $slotNumber);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $slot = $result->fetch_assoc();
        $slotID = $slot['SlotID'];

        // Add the user to the new room slot
        $sql = "INSERT INTO Bookings (UserID, RoomID, SlotID, BookingDate) VALUES (?, ?, ?, CURDATE())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $userID, $roomID, $slotID);
        $stmt->execute();

        // Update the slot to mark it as unavailable
        $sql = "UPDATE Slots SET IsAvailable = FALSE WHERE SlotID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $slotID);
        $stmt->execute();

        echo "Success: You have been added to the room.";
        header("Location: ../templates/kofi_tawiah.php");
        exit();
    } else {
        echo "Error: Slot not available or does not exist.";
    }
}

$stmt->close();
$conn->close();
?>
