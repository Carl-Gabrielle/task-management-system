<?php
session_start();
require_once('config.php');

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $task_id = $_GET['id'];

   
    $delete_sql = "DELETE FROM task_list WHERE id = '$task_id'";
    if (mysqli_query($connection, $delete_sql)) {
        $_SESSION['task_deleted'] = true;
        header("Location: admin_task_list.php");
        exit();
    } else {
        echo "Error deleting task: " . mysqli_error($connection);
    }
}
?>
