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
// $roomID = isset($_GET['roomID']) ? intval($_GET['roomID']) : 0;
// $slotNumber = isset($_GET['slotNumber']) ? intval($_GET['slotNumber']) : 0;

// // Fetch pairing ID associated with the current user
// $sql = "SELECT PairingID FROM PairingMembers WHERE UserID = ?";
// $stmt = $conn->prepare($sql);
// $stmt->bind_param("i", $userID);
// $stmt->execute();
// $result = $stmt->get_result();

// if ($result->num_rows > 0) {
//     $pairing = $result->fetch_assoc();
//     $pairingID = $pairing['PairingID'];

//     // Fetch the other user associated with the same pairing ID
//     $sql = "SELECT UserID FROM PairingMembers WHERE PairingID = ? AND UserID != ?";
//     $stmt = $conn->prepare($sql);
//     $stmt->bind_param("ii", $pairingID, $userID);
//     $stmt->execute();
//     $result = $stmt->get_result();

//     if ($result->num_rows > 0) {
//         $otherUser = $result->fetch_assoc();
//         $otherUserID = $otherUser['UserID'];
//     } else {
//         $otherUserID = null;
//     }
// } else {
//     $pairingID = null;
//     $otherUserID = null;
// }

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
//     // Free the previously booked slot
//     $currentBooking = $result->fetch_assoc();
//     $currentSlotID = $currentBooking['SlotID'];

//     $sql = "DELETE FROM Bookings WHERE UserID = ?";
//     $stmt = $conn->prepare($sql);
//     $stmt->bind_param("i", $userID);
//     $stmt->execute();

//     // Mark the slot as available
//     $sql = "UPDATE Slots SET IsAvailable = TRUE WHERE SlotID = ?";
//     $stmt = $conn->prepare($sql);
//     $stmt->bind_param("i", $currentSlotID);
//     $stmt->execute();
// }

// // Check if the selected slot is available
// $sql = "SELECT SlotID FROM Slots WHERE RoomID = ? AND SlotNumber = ? AND IsAvailable = TRUE";
// $stmt = $conn->prepare($sql);
// $stmt->bind_param("ii", $roomID, $slotNumber);
// $stmt->execute();
// $result = $stmt->get_result();

// if ($result->num_rows > 0) {
//     $slot = $result->fetch_assoc();
//     $slotID = $slot['SlotID'];

//     // Insert the new booking
//     $sql = "INSERT INTO Bookings (UserID, RoomID, SlotID, BookingDate) VALUES (?, ?, ?, CURDATE())";
//     $stmt = $conn->prepare($sql);
//     $stmt->bind_param("iii", $userID, $roomID, $slotID);
//     $stmt->execute();

//     // Mark the slot as unavailable
//     $sql = "UPDATE Slots SET IsAvailable = FALSE WHERE SlotID = ?";
//     $stmt = $conn->prepare($sql);
//     $stmt->bind_param("i", $slotID);
//     $stmt->execute();

//     echo "Success: You have been added to the room.";
//     exit();
// } else {
//     echo "Error: Slot not available or does not exist.";
// }

// $stmt->close();
// $conn->close();

?>



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
// $roomID = isset($_GET['roomID']) ? intval($_GET['roomID']) : 0;
// $slotNumber = isset($_GET['slotNumber']) ? intval($_GET['slotNumber']) : 0;

// // Fetch pairing ID associated with the current user
// $sql = "SELECT PairingID FROM PairingMembers WHERE UserID = ?";
// $stmt = $conn->prepare($sql);
// $stmt->bind_param("i", $userID);
// $stmt->execute();
// $result = $stmt->get_result();

// if ($result->num_rows > 0) {
//     $pairing = $result->fetch_assoc();
//     $pairingID = $pairing['PairingID'];

//     // Fetch the other user associated with the same pairing ID
//     $sql = "SELECT UserID FROM PairingMembers WHERE PairingID = ? AND UserID != ?";
//     $stmt = $conn->prepare($sql);
//     $stmt->bind_param("ii", $pairingID, $userID);
//     $stmt->execute();
//     $result = $stmt->get_result();

//     if ($result->num_rows > 0) {
//         $otherUser = $result->fetch_assoc();
//         $otherUserID = $otherUser['UserID'];
//     } else {
//         $otherUserID = null;
//     }
// } else {
//     $pairingID = null;
//     $otherUserID = null;
// }

// // Check if the selected slot is available
// $sql = "SELECT SlotID FROM Slots WHERE RoomID = ? AND SlotNumber = ? AND IsAvailable = TRUE";
// $stmt = $conn->prepare($sql);
// $stmt->bind_param("ii", $roomID, $slotNumber);
// $stmt->execute();
// $result = $stmt->get_result();

// if ($result->num_rows > 0) {
//     $slot = $result->fetch_assoc();
//     $slotID = $slot['SlotID'];

//     if ($otherUserID) {
//         // Check for the next available slot for the other user
//         $sql = "SELECT SlotID FROM Slots WHERE RoomID = ? AND IsAvailable = TRUE AND SlotID != ? LIMIT 1";
//         $stmt = $conn->prepare($sql);
//         $stmt->bind_param("ii", $roomID, $slotID);
//         $stmt->execute();
//         $result = $stmt->get_result();

//         if ($result->num_rows > 0) {
//             $nextSlot = $result->fetch_assoc();
//             $nextSlotID = $nextSlot['SlotID'];

//             // Insert the new booking for the current user
//             $sql = "INSERT INTO Bookings (UserID, RoomID, SlotID, BookingDate) VALUES (?, ?, ?, CURDATE())";
//             $stmt = $conn->prepare($sql);
//             $stmt->bind_param("iii", $userID, $roomID, $slotID);
//             $stmt->execute();

//             // Mark the slot as unavailable
//             $sql = "UPDATE Slots SET IsAvailable = FALSE WHERE SlotID = ?";
//             $stmt = $conn->prepare($sql);
//             $stmt->bind_param("i", $slotID);
//             $stmt->execute();

//             // Insert the new booking for the other user
//             $sql = "INSERT INTO Bookings (UserID, RoomID, SlotID, BookingDate) VALUES (?, ?, ?, CURDATE())";
//             $stmt = $conn->prepare($sql);
//             $stmt->bind_param("iii", $otherUserID, $roomID, $nextSlotID);
//             $stmt->execute();

//             // Mark the next slot as unavailable
//             $sql = "UPDATE Slots SET IsAvailable = FALSE WHERE SlotID = ?";
//             $stmt = $conn->prepare($sql);
//             $stmt->bind_param("i", $nextSlotID);
//             $stmt->execute();

//             echo "Success: You and your paired user have been added to the room.";
//         } else {
//             echo "Error: Cannot put two people in one slot, no other available slot found.";
//         }
//     } else {
//         // Insert the new booking for the current user only
//         $sql = "INSERT INTO Bookings (UserID, RoomID, SlotID, BookingDate) VALUES (?, ?, ?, CURDATE())";
//         $stmt = $conn->prepare($sql);
//         $stmt->bind_param("iii", $userID, $roomID, $slotID);
//         $stmt->execute();

//         // Mark the slot as unavailable
//         $sql = "UPDATE Slots SET IsAvailable = FALSE WHERE SlotID = ?";
//         $stmt->bind_param("i", $slotID);
//         $stmt->execute();

//         echo "Success: You have been added to the room.";
//     }
// } else {
//     echo "Error: Slot not available or does not exist.";
// }

// $stmt->close();
// $conn->close();

?>






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
// $roomID = isset($_GET['roomID']) ? intval($_GET['roomID']) : 0;
// $slotNumber = isset($_GET['slotNumber']) ? intval($_GET['slotNumber']) : 0;

// // Fetch pairing ID associated with the current user
// $sql = "SELECT PairingID FROM PairingMembers WHERE UserID = ?";
// $stmt = $conn->prepare($sql);
// $stmt->bind_param("i", $userID);
// $stmt->execute();
// $result = $stmt->get_result();

// if ($result->num_rows > 0) {
//     $pairing = $result->fetch_assoc();
//     $pairingID = $pairing['PairingID'];

//     // Fetch the other user associated with the same pairing ID
//     $sql = "SELECT UserID FROM PairingMembers WHERE PairingID = ? AND UserID != ?";
//     $stmt = $conn->prepare($sql);
//     $stmt->bind_param("ii", $pairingID, $userID);
//     $stmt->execute();
//     $result = $stmt->get_result();

//     if ($result->num_rows > 0) {
//         $otherUser = $result->fetch_assoc();
//         $otherUserID = $otherUser['UserID'];
//     } else {
//         $otherUserID = null;
//     }
// } else {
//     $pairingID = null;
//     $otherUserID = null;
// }

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

// // Fetch user details from the database
// $sql = "SELECT FirstName, LastName FROM Users WHERE UserID = ?";
// $stmt = $conn->prepare($sql);
// $stmt->bind_param("i", $otherUserID);
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

// $sql = "SELECT SlotID, RoomID FROM Bookings WHERE UserID = ?";
// $stmt = $conn->prepare($sql);
// $stmt->bind_param("i", $userID);
// $stmt->execute();
// $result = $stmt->get_result();

// $sql = "SELECT SlotID, RoomID FROM Bookings WHERE UserID = ?";
// $stmt = $conn->prepare($sql);
// $stmt->bind_param("i", $otherUserID);
// $stmt->execute();
// $result_1 = $stmt->get_result();

// if ($result->num_rows < 2) {
//     // Free the previously booked slot for current user
//     $currentBooking = $result->fetch_assoc();
//     $currentSlotID = $currentBooking['SlotID'];
//     echo $currentSlotID;

//     $sql = "DELETE FROM Bookings WHERE UserID = ?";
//     $stmt = $conn->prepare($sql);
//     $stmt->bind_param("i", $userID);
//     $stmt->execute();

//     // Mark the slot as available
//     $sql = "UPDATE Slots SET IsAvailable = TRUE WHERE SlotID = ?";
//     $stmt = $conn->prepare($sql);
//     $stmt->bind_param("i", $currentSlotID);
//     $stmt->execute();

//     // Check if the selected slot is available
//     $sql = "SELECT SlotID FROM Slots WHERE RoomID = ? AND SlotNumber = ? AND IsAvailable = TRUE";
//     $stmt = $conn->prepare($sql);
//     $stmt->bind_param("ii", $roomID, $slotNumber);
//     $stmt->execute();
//     $result = $stmt->get_result();

//     if ($result->num_rows > 0) {
//         $slot = $result->fetch_assoc();
//         $slotID = $slot['SlotID'];

//         // Insert the new booking
//         $sql = "INSERT INTO Bookings (UserID, RoomID, SlotID, BookingDate) VALUES (?, ?, ?, CURDATE())";
//         $stmt = $conn->prepare($sql);
//         $stmt->bind_param("iii", $userID, $roomID, $slotID);
//         $stmt->execute();

//         // Mark the slot as unavailable
//         $sql = "UPDATE Slots SET IsAvailable = FALSE WHERE SlotID = ?";
//         $stmt = $conn->prepare($sql);
//         $stmt->bind_param("i", $slotID);
//         $stmt->execute();

//         echo "Success: You have been added to the room.";
//         exit();
//     } else {
//         echo "Error: Slot not available or does not exist.";
//     }
// }

// if ($result->num_rows > 1) {
//     // Free the previously booked slot for current user
//     $currentBooking = $result->fetch_assoc();
//     $currentSlotID = $currentBooking['SlotID'];
//     echo $currentSlotID;

//     // Free the previously booked slot for paired user
//     $otherCurrentBooking = $result_1->fetch_assoc();
//     $otherCurrentSlotID = $otherCurrentBooking['SlotID'];
//     echo $currentSlotID;

//     // Deleting the previous booking for the current user
//     $sql = "DELETE FROM Bookings WHERE UserID = ?";
//     $stmt = $conn->prepare($sql);
//     $stmt->bind_param("i", $userID);
//     $stmt->execute();

//     // Deleting the previous booking for the paired user
//     $sql = "DELETE FROM Bookings WHERE UserID = ?";
//     $stmt = $conn->prepare($sql);
//     $stmt->bind_param("i", $otherUserID);
//     $stmt->execute();

//     // Mark the deleted slot for current user as available
//     $sql = "UPDATE Slots SET IsAvailable = TRUE WHERE SlotID = ?";
//     $stmt = $conn->prepare($sql);
//     $stmt->bind_param("i", $currentSlotID);
//     $stmt->execute();

//     // Mark the deleted slot for paired user as available
//     $sql = "UPDATE Slots SET IsAvailable = TRUE WHERE SlotID = ?";
//     $stmt = $conn->prepare($sql);
//     $stmt->bind_param("i", $otherCurrentSlotID);
//     $stmt->execute();

//     // Check if there are two available slots in the selected room
//     $sql = "SELECT SlotID FROM Slots WHERE RoomID = ? AND (SlotNumber = ? OR IsAvailable = TRUE) LIMIT 2";
//     $stmt = $conn->prepare($sql);
//     $stmt->bind_param("ii", $roomID, $slotNumber);
//     $stmt->execute();
//     $result = $stmt->get_result();

//     $availableSlots = array();
//     while ($row = $result->fetch_assoc()) {
//         $availableSlots[] = $row['SlotID'];
//     }

//     // Check if two distinct slots are available
//     if (count($availableSlots) >= 2) {
//         $selectedSlotID = $availableSlots[0];
//         $additionalSlotID = $availableSlots[1];

//         // Insert the new booking for the current user
//         $sql = "INSERT INTO Bookings (UserID, RoomID, SlotID, BookingDate) VALUES (?, ?, ?, CURDATE())";
//         $stmt = $conn->prepare($sql);
//         $stmt->bind_param("iii", $userID, $roomID, $slotID);
//         $stmt->execute();

//         // Insert the new booking for the paired user
//         $sql = "INSERT INTO Bookings (UserID, RoomID, SlotID, BookingDate) VALUES (?, ?, ?, CURDATE())";
//         $stmt = $conn->prepare($sql);
//         $stmt->bind_param("iii", $otherUserID, $roomID, $otherCurrentSlotID);
//         $stmt->execute();

//         // Mark the slot for the current user as unavailable
//         $sql = "UPDATE Slots SET IsAvailable = FALSE WHERE SlotID = ?";
//         $stmt = $conn->prepare($sql);
//         $stmt->bind_param("i", $curerntSlotID);
//         $stmt->execute();

//         // Mark the slot for the other user as unavailable
//         $sql = "UPDATE Slots SET IsAvailable = FALSE WHERE SlotID = ?";
//         $stmt = $conn->prepare($sql);
//         $stmt->bind_param("i", $otherCurrentslotID);
//         $stmt->execute();
//     } else {
//         echo "There isn't enough space for two or more of you at a time";
//     }
// } else {
//     echo "You can't book a slot that is already booked";
// }

// $stmt->close();
// $conn->close();

?>





<?php
// ../ACTIONS/ROOM_SELECTION.PHP

// Enable error reporting

error_reporting(E_ALL);
ini_set('display_errors', 1);

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
        // header("Location: ../templates/kofi_tawiah.php?msg=Success");
        $previousPage = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '../templates/default.php';
        header("Location: $previousPage?msg=Success");

    } else {
        echo "Error: Not enough available slots in the room.";
        $previousPage = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '../templates/default.php';
        header("Location: $previousPage?msg=Unsuccess");
        $conn->rollback();
    }
} catch (Exception $e) {
    // Rollback transaction on error
    $conn->rollback();
    echo "Error: Could not complete the room switch. Please try again.";
    // header("Location: ../templates/kofi_tawiah.php?msg=Unsuccess");

    $previousPage = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '../templates/default.php';
    header("Location: $previousPage?msg=Unsuccess");

}

$stmt->close();
$conn->close();
?>
