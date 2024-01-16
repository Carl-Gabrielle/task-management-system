<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
</head>
<body>
<?php

session_start();
if (isset($_SESSION['user_name'])) {
    $name = $_SESSION['user_name'];
    echo "<h1>Welcome, $name</h1>";
    echo '<form method="post" action="logout.php"><button type="submit">Logout</button></form>';
} else {
    echo "<p>You are not logged in.</p>";
}
?>
<form action="">
     <?php
     echo "<h4> Welcome, $name </h4>"; 
     ?>
</form>
</body>
</html>
