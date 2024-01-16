<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Task</title>
</head>
<?php
session_start();
require_once('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_SESSION['task_created'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $due_date = $_POST['due_date'];
    $priority = $_POST['priority'];
    $assigned_to = $_POST['assigned_to']; // Assuming this is the assigned user's ID from the form

    // Check if the task already exists for the user
    $check_sql = "SELECT id FROM task_list WHERE title = '$title' AND description = '$description' AND due_date = '$due_date' AND priority = '$priority' AND assigned_to = '$assigned_to'";
    $check_result = mysqli_query($connection, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        echo "Task already exists for this user.";
    } else {
        $sql = "INSERT INTO task_list (title, description, due_date, priority, assigned_to) VALUES ('$title', '$description', '$due_date', '$priority', '$assigned_to')";

        if (mysqli_query($connection, $sql)) {
            $_SESSION['task_created'] = true;
            echo "Task created successfully";
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($connection);
        }
    }
}
?>
<body>
    <form method="POST" action="#">
        <label for="title">Title</label>
        <input type="text" name="title"><br>
        <label for="description">Description</label>
        <textarea name="description"></textarea><br>
        <label for="due_date">Due Date</label>
        <input type="date" name="due_date"><br>
        <label for="priority">Priority</label>
        <input type="number" name="priority"><br>
        <label for="assigned_to">Assigned To</label>
        <select name="assigned_to">
            <?php
            require_once('config.php'); // Include your database connection

            // Fetch user_list records
            $sql = "SELECT id, name FROM user_list";
            $result = mysqli_query($connection, $sql);

            // Display user options in select dropdown
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
            }
            ?>
        </select><br>
        <input type="submit" value="Create Task">
    </form>
    <?php
    // if (isset($_SESSION['task_created']) && $_SESSION['task_created']) {
    //     echo "<script>alert('Task created successfully');</script>";
    //     unset($_SESSION['task_created']); // Unset the session variable after displaying the alert
    // }
    
    ?>
 
  <?php
    // Display messages based on task creation status
    if (isset($_SESSION['task_created'])) {
        if ($_SESSION['task_created']) {
            unset($_SESSION['task_created']); // Unset the session variable after displaying the alert
        } else {
            echo "<script>alert('Error creating task');</script>";
            unset($_SESSION['task_created']); // Unset the session variable after displaying the alert
        }
    }
    ?>
</body>
</html>
