<?php
include 'conn.php';

if (isset($_POST['phone_num']) && isset($_POST['governorate'])&& isset($_POST['email'])) {
    $phone_num = urldecode($_POST['phone_num']);
    $governorate = urldecode($_POST['governorate']);
    $userEmail = urldecode($_POST['email']);
    $stmt = $pdo->prepare("UPDATE users SET user_address = :governorate, user_phoneNum = :phone_num WHERE user_email = :user_email");

    
    $stmt->execute(['governorate' => $governorate, 'phone_num' => $phone_num, 'user_email' => $userEmail]);

    if ($stmt->rowCount()) {
        echo "User information updated successfully.";
    } else {
        echo "Failed to update user information or user not found.";
    }
}
?>
