<?php
header("Content-Type: application/json");

include 'conn.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty(file_get_contents("php://input"))) {
    $data = json_decode(file_get_contents("php://input"), true);

    $username = $data['username'] ?? '';
    $email = $data['email'] ?? '';
    $password = $data['password'] ?? '';
    $passwordMatch = $data['passwordMatch'] ?? '';
    $role = $data['role'] ?? '';
    $isDeleted = $data['isDeleted'] ?? '';
    // Validate username
    if (strlen($username) < 3 || strlen($username) > 30) {
        $response = "signupErrorMessage.textContent = 'Username must be between 3 and 20 characters long';";
        echo json_encode($response);
        exit();
    }



    // Validate email
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response = "signupErrorMessage.textContent = 'Please enter a valid email address';";
        echo json_encode($response);
        exit();
    }

    // Validate password
    if (strlen($password) < 8) {
        $response = "signupErrorMessage.textContent = 'Password must be at least 8 characters long';";
        echo json_encode($response);
        exit();
    }

    if ($password !== $passwordMatch) {
        $response = "signupErrorMessage.textContent = 'Passwords do not match';";
        echo json_encode($response);
        exit();
    }

    if (!preg_match('/[A-Z]/', $password)) {
        $response = "signupErrorMessage.textContent = 'Password must contain at least one uppercase letter';";
        echo json_encode($response);
        exit();
    }

    if (!preg_match('/[a-z]/', $password)) {
        $response = "signupErrorMessage.textContent = 'Password must contain at least one lowercase letter';";
        echo json_encode($response);
        exit();
    }

    if (!preg_match('/[0-9]/', $password)) {
        $response = "signupErrorMessage.textContent = 'Password must contain at least one number';";
        echo json_encode($response);
        exit();
    }

    if (!preg_match('/[!@#$%^&*]/', $password)) {
        $response = "signupErrorMessage.textContent = 'Password must contain at least one special character';";
        echo json_encode($response);
        exit();
    }

    if (strpos($password, ' ') !== false) {
        $response = "signupErrorMessage.textContent = 'Password cannot contain spaces';";
        echo json_encode($response);
        exit();
    }

    if (strlen($password) > 20) {
        $response = "signupErrorMessage.textContent = 'Password cannot be more than 20 characters long';";
        echo json_encode($response);
        exit();
    }

    if (!preg_match('/^[a-zA-Z0-9!@#$%^&*]+$/', $password)) {
        $response = "signupErrorMessage.textContent = 'Password contains invalid characters';";
        echo json_encode($response);
        exit();
    }

    // Check if the email already exists in the database
    $stmt = $conn->prepare("SELECT * FROM users WHERE user_email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $response = "signupErrorMessage.textContent = 'User already exists';";
        echo json_encode($response);
    } else {



        // Insert new user into the database
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Hash the password

        $insertStmt = $conn->prepare("INSERT INTO users (user_name, user_email, user_password,role,	isDeleted) VALUES (:username, :email, :password,:role,:isDeleted)");
        $insertStmt->bindParam(':username', $username);
        $insertStmt->bindParam(':email', $email);
        $insertStmt->bindParam(':password', $hashedPassword);
        $insertStmt->bindParam(':role', $role);
        $isDeleted = (int) $isDeleted;
        $insertStmt->bindParam(':isDeleted', $isDeleted, PDO::PARAM_INT);

        if ($insertStmt->execute()) {
            //add a cart for the user
            $user_id = $conn->lastInsertId();
            $cartStmt = $conn->prepare("INSERT INTO carts (user_id) VALUES (:user_id)");
            $cartStmt->bindParam(':user_id', $user_id);
            $cartStmt->execute();
            
            

            $response = "signupErrorMessage.innerHTML = 'Registered successfully!<br> Check your email to activate.';signupErrorMessage.style.color='green';
             
              const templateParams = {
        name:  '$username',
        email: '$email',
        message: '$email',
    };

    emailjs.send('service_d7lit7t', 'template_wzwaxxo', templateParams).then(
        function (response) {
            console.log('Email sent successfully!', response.status, response.text);
        },
        function (error) {
            console.log('Failed to send email...', error);
        }
    );
             
             ";

            echo json_encode($response);
        } else {
            $response = "signupErrorMessage.textContent = 'Error registering user';";
            echo json_encode($response);
        }
    }
} else {
    $response = "signupErrorMessage.textContent = 'Invalid request';";
    echo json_encode($response);
}

$conn = null; // Close the connection
