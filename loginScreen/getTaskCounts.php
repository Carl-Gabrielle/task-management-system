<?php
include('config.php'); 

// Your database connection setup

// Execute query to get task counts
$sql = "SELECT 
            SUM(CASE WHEN status = 'not started' THEN 1 ELSE 0 END) AS not_started_count,
            SUM(CASE WHEN status = 'in progress' THEN 1 ELSE 0 END) AS in_progress_count,
            SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) AS completed_count
        FROM task_list";

$result = $connection->query($sql);

$taskCounts = [
    'not_started' => 0,
    'in_progress' => 0,
    'completed' => 0
];

if ($result === false) {
    echo json_encode(["error" => $connection->error]);
} else {
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $taskCounts['not_started'] = $row['not_started_count'];
        $taskCounts['in_progress'] = $row['in_progress_count'];
        $taskCounts['completed'] = $row['completed_count'];
        echo json_encode($taskCounts);
    }
}
?>
