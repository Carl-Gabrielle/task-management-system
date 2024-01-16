<?php

session_start();
if (isset($_SESSION['user_name'])) {
    $name = $_SESSION['user_name'];;
} else {
    echo "<p>You are not logged in.</p>";
}

?>