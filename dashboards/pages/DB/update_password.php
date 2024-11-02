<?php
include 'conn.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_email = isset($_POST['user_email']) ? $_POST['user_email'] : '';
    $old_pass = isset($_POST['old_pass']) ? $_POST['old_pass'] : '';
    $new_pass = isset($_POST['new_pass']) ? $_POST['new_pass'] : '';

    if (empty($user_email) || empty($old_pass) || empty($new_pass)) {
        echo "document.getElementById('show_error').innerHTML = 'All fields are required.';document.getElementById('show_error').style.color='red';";
        exit;
    }

    if (strlen($new_pass) < 8) {
        echo "document.getElementById('show_error').innerHTML = 'New password must be at least 8 characters long.';document.getElementById('show_error').style.color='red';";
        exit;
    }

    if ($old_pass === $new_pass) {
        echo "document.getElementById('show_error').innerHTML = 'New password must not match the old password.';document.getElementById('show_error').style.color='red';";
        exit;
    }

    $stmt = $pdo->prepare("SELECT user_password FROM users WHERE user_email = :email");
    $stmt->execute(['email' => $user_email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "document.getElementById('show_error').innerHTML = 'User not found.';document.getElementById('show_error').style.color='red';";
        exit;
    }

    if (!password_verify($old_pass, $user['user_password'])) {
        echo "document.getElementById('show_error').innerHTML = 'Old password is incorrect.';document.getElementById('show_error').style.color='red';";
        exit;
    }

    $new_pass_hashed = password_hash($new_pass, PASSWORD_DEFAULT);

    $update_stmt = $pdo->prepare("UPDATE users SET user_password = :new_pass WHERE user_email = :email");
    if ($update_stmt->execute(['new_pass' => $new_pass_hashed, 'email' => $user_email])) {
        echo "document.getElementById('show_error').innerHTML = 'Success: Password updated.';document.getElementById('show_error').style.color='green';";
    } else {
        echo "document.getElementById('show_error').innerHTML = 'Error: Unable to update password.';document.getElementById('show_error').style.color='red';";
    }
}
?>
