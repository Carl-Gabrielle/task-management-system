<?php
$connection = new mysqli("localhost", "root", "", "user_db");
if ($connection === false) {
    die("ERROR: Could not connect. " . $mysqli->connect_error);
}
// echo "Connect Successfully. Host info: " .$mysqli->host_info;
?>