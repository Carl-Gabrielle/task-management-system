<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once('config.php');

    $userId = $_POST['userId'];
    $newRole = $_POST['newRole'];

    $updateQuery = "UPDATE user_list SET is_admin = ? WHERE id = ?";
    $statement = mysqli_prepare($connection, $updateQuery);
    
    mysqli_stmt_bind_param($statement, 'ii', $newRole, $userId);
    $success = mysqli_stmt_execute($statement);

    if ($success) {
        echo "User role updated successfully.";
    } else {
        echo "Error updating user role.";
    }
    mysqli_stmt_close($statement);
    mysqli_close($connection);
} else {
    echo "Invalid request method.";
}
?>
