<?php
include('config.php'); 

// Your database connection setup

// Execute query to get monthly user counts
$sql = "SELECT MONTH(registration_date) AS month, COUNT(*) AS user_count 
        FROM users 
        GROUP BY MONTH(registration_date)";

$result = $connection->query($sql);

$monthlyUserData = [
    'labels' => [],
    'data' => []
];

if ($result === false) {
    echo json_encode(["error" => $connection->error]);
} else {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Format data for Chart.js labels (month names or numbers)
            $monthlyUserData['labels'][] = date("M", mktime(0, 0, 0, $row['month'], 1));
            // Store user count data
            $monthlyUserData['data'][] = (int)$row['user_count'];
        }
        echo json_encode($monthlyUserData);
    }
}
?>
