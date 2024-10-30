<?php
session_start();
header("Content-Type: application/json");
include 'conn.php';

class User {
    private $conn;
    private $email;
    private $password;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function setCredentials($email, $password) {
        $this->email = $email;
        $this->password = $password;
    }

    private function validateEmail() {
        if (empty($this->email) || !filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            return "loginErrorMessage.textContent = 'Please enter a valid email address';";
        }
        return null;
    }

    private function validatePassword() {
        if (strlen($this->password) < 8 || strlen($this->password) > 20 || preg_match('/\s/', $this->password)) {
            return "loginErrorMessage.textContent = 'Password must be 8-20 characters long and cannot contain spaces';";
        }
        return null;
    }

    public function validateCredentials() {
        $emailError = $this->validateEmail();
        if ($emailError) {
            return $emailError;
        }

        $passwordError = $this->validatePassword();
        if ($passwordError) {
            return $passwordError;
        }

        return null;
    }

    public function login() {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE user_email = :email and role !='customer'");
        $stmt->bindParam(':email', $this->email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if (password_verify($this->password, $user['user_password'])) {
                $_SESSION['user'] = $user['user_id']; // Create session
                return "loginErrorMessage.textContent = 'User registered successfully';loginErrorMessage.style.color='green';window.location.href = '../dashboards/pages/dashboard.php';"; // change the path to the user page
            } else {
                return "loginErrorMessage.textContent = 'Invalid email or password';";
            }
        } else {
            return "loginErrorMessage.textContent = 'Invalid email or password';";
        }
    }
}

// Get input data
if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty(file_get_contents("php://input"))) {
    $data = json_decode(file_get_contents("php://input"), true);

    $email = $data['email'] ?? '';
    $password = $data['password'] ?? '';

    // Instantiate User class
    $user = new User($conn);
    $user->setCredentials($email, $password);

    // Validate inputs
    $validationError = $user->validateCredentials();
    if ($validationError) {
        echo json_encode($validationError);
        exit;
    }

    // Attempt to log in
    $loginResult = $user->login();
    echo json_encode($loginResult);
}
?>
