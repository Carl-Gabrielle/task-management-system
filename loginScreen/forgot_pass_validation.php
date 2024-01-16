<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . "/mailer.php";
$email = $_POST["email"];

$token = bin2hex(random_bytes(16));
$token_hash = hash("sha256", $token);
$expiry = date('Y-m-d H:i:s', time() + 60 * 20);
require __DIR__ . "/config.php";

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$sql = "UPDATE user_list SET reset_token_hash = ?, reset_token_expires_at = ? WHERE email = ?";
$stmt = $connection->prepare($sql);

if (!$stmt) {
    die("Prepare failed: " . $connection->error);
}

$stmt->bind_param("sss", $token_hash, $expiry, $email);

if (!$stmt->execute()) {
    die("Execute failed: " . $stmt->error);
}

if ($connection->affected_rows) {
    $mail->setFrom("noreply@example.com");
    $mail->addAddress($email);
    $mail->Subject = "Password Reset";
    $resetLink = "<a href='http://localhost/task-management-system/loginScreen/reset-password.php?token=$token'>Reset Password</a>";
$mail->setFrom("carlgab59@gmail.com");
$mail->addAddress($email);
$mail->Subject = "Password Reset";
$mail->Body = <<<END
    Click $resetLink to reset your password.
END;

    try {
        $mail->send();
        echo "Message sent. Please check your inbox.";
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer error: {$mail->ErrorInfo}";
    }
}
?>
