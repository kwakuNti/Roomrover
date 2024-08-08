<?php
include "../config/core.php";

if (isset($_SESSION['UserID'])) {
    $userId = $_SESSION['UserID'];


} else {
    echo "No user ID provided.";
}
?>
