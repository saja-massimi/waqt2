<?php
include 'conn.php';

if (isset($_POST['role_status']) && isset($_POST['email'])) {
    $role_status = $_POST['role_status'];
    $email = $_POST['email'];
  
    $stmt = $pdo->prepare("UPDATE users SET role = :role WHERE user_email = :user_email");

    
    $stmt->execute(['role' => $role_status, 'user_email' => $email]);

    if ($stmt->rowCount()) {
        echo "Role updated successfully.";
    } else {
        echo "Failed to update user role or user not found.";
    }
}
?>
