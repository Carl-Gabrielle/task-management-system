<?php
    @include('config.php');
    session_start();
    $error = [];
    if (isset($_SESSION['user_name'])) {
        $name = $_SESSION['user_name'];
    } else {
        echo "<p>You are not logged in.</p>";
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $title = mysqli_real_escape_string($connection, $_POST['title']);
        $description = $_POST['description'];
        $due_date = mysqli_real_escape_string($connection, $_POST['due_date']);
        $priority = mysqli_real_escape_string($connection, $_POST['priority']);
        $assigned_to = mysqli_real_escape_string($connection, $_POST['assigned_to']);
        
            $check_sql = "SELECT id FROM task_list WHERE title = '$title' AND description = '$description' AND due_date = '$due_date' AND priority = '$priority' AND assigned_to = '$assigned_to'";
            $check_result = mysqli_query($connection, $check_sql);

            if ($check_result && mysqli_num_rows($check_result) > 0) {
                $error[] = "Task already exists for this user.";
            } else {
                $insert_sql = "INSERT INTO task_list (title, description, due_date, priority, assigned_to) VALUES (?, ?, ?, ?, ?)";
                $stmt = mysqli_prepare($connection, $insert_sql);
                mysqli_stmt_bind_param($stmt, "sssss", $title, $description, $due_date, $priority, $assigned_to);
                $success = mysqli_stmt_execute($stmt);
            }

    }

if (isset($_SESSION['user_name'])) {
    $name = $_SESSION['user_name'];
    $nameArray = explode(' ', $name);
    $firstName = $nameArray[0];
} else {
    echo "<p>You are not logged in.</p>";
}
    ?>