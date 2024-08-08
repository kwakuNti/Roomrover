<?php
include '../config/connection.php';
include '../config/core.php';

$notificationId = isset($_POST['notificationId']) ? intval($_POST['notificationId']) : null;
$senderId = isset($_POST['senderId']) ? intval($_POST['senderId']) : null;
$isAccepted = isset($_POST['isAccepted']) ? intval($_POST['isAccepted']) : null;

if ($notificationId && $senderId && $isAccepted !== null) {
    // Update the Requests table based on user response
    $stmt = $conn->prepare("UPDATE Requests SET Accepted = ? WHERE SenderUserID = ? AND ReceiverUserID = ?");
    $stmt->bind_param("iii", $isAccepted, $senderId, $_SESSION['UserID']);
    $stmt->execute();
    
    // Optionally, you can also mark the notification as read or delete it
    $stmt = $conn->prepare("DELETE FROM Notifications WHERE NotificationID = ?");
    $stmt->bind_param("i", $notificationId);
    $stmt->execute();

    echo "Success";
} else {
    echo "Error: Invalid data.";
}

$conn->close();
exit();
?>
