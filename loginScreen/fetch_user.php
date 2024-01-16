<?php
$connection = new mysqli("localhost", "root", "", "user_db");

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$guests = array();

$sql = "SELECT  id, name  FROM user_list";
$result = $connection->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $guest = array(
            'id' => $row['id'], 
            'name' => $row['name'],
            'icon' => 'user', // Define a default icon for every user
        );
        $guests[] = $guest;
    }
}

echo json_encode($guests);

$connection->close();
?>
