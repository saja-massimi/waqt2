<?php
include 'conn.php';

if (isset($_POST['user_email'])) {
      $email = urldecode($_POST['user_email']);
    
    // Prepare the statement
    $stmt = $pdo->prepare("UPDATE users SET isDeleted = 1 WHERE user_email = :email");
    
    // Execute the statement with the email parameter
    $stmt->execute(['email' => $email]);

    // Optionally check if the update was successful
    if ($stmt->rowCount()) {
        echo "User marked as deleted successfully.";
    } else {
        echo "Failed to mark user as deleted or user not found.";
    }
}
?>
