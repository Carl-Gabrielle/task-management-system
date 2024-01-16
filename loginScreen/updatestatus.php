<?php
require('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['task_id']) && isset($_POST['status'])) {
    $task_id = $_POST['task_id'];
    $status = $_POST['status'];

    $update_query = "UPDATE task_list SET status = ? WHERE id = ?";
    $stmt = $connection->prepare($update_query);
    $stmt->bind_param("si", $status, $task_id);

    if ($stmt->execute()) {
        echo "Status updated successfully.";
    } else {
        echo "Error updating status: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Invalid request.";
}
?>
