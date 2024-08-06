<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../config/core.php';
include '../config/connection.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Check if the email exists in the database
    $query = $conn->prepare("SELECT * FROM users WHERE Email = ?");
    $query->bind_param("s", $email);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        // User exists
        $user = $result->fetch_assoc();
        $generated_password = bin2hex(random_bytes(4));
        $hashed_password = password_hash($generated_password, PASSWORD_BCRYPT);

        // Update the user's password in the database
        $update = $conn->prepare("UPDATE Users SET Password = ?, UserType = ? WHERE Email = ?");
        $update->bind_param("sis", $hashed_password, $usertype, $email);
        $usertype = 2; // Set usertype to 2
        $update->execute();
    } else {
        // User doesn't exist, generate password and insert user
        $generated_password = bin2hex(random_bytes(4));
        $hashed_password = password_hash($generated_password, PASSWORD_BCRYPT);

        // Insert new user with generated password
        $insert = $conn->prepare("INSERT INTO Users (Email, Password, UserType) VALUES (?, ?, ?)");
        $insert->bind_param("ssi", $email, $hashed_password, $usertype);
        $usertype = 2; // Set usertype to 2
        $insert->execute();
    }

    // Send the email with the new password
    try {
        // Load Composer's autoloader
        require '../vendor/autoload.php';

        // Create a new PHPMailer instance
        $mail = new PHPMailer(true);

        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'cliffco24@gmail.com';
        $mail->Password = 'nzqo jtlf kuau xtus';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('cliffco24@gmail.com', 'RoomRover');
        $mail->addAddress($email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Your new password';
        $mail->Body = 'Dear user,<br><br>Your new password is: ' . $generated_password . '<br><br>Thank you for using our services.<br>Best regards,<br>RoomRover';

        // Send the email
        $mail->send();
        header("Location: ../templates/forgotpassword.php?msg=An email with your new password has been sent.");
    } catch (Exception $e) {
        error_log("Email sending failed: " . $mail->ErrorInfo);
        header("Location: ../templates/forgotpassword.php?msg=Failed to send email.");
    }
    exit();
}
