<?php
$db_server = "16.171.150.101";
$db_user = "root";
$db_password = "Vcnm1H&w";
$db_name = "room_rover";



$conn = mysqli_connect($db_server, $db_user, $db_password, $db_name);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

echo "";