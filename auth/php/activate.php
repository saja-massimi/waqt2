<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error Handling</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #e9ecef;
        }

        .error-message {
            background-color: #ffffff;
            color: #333333;
            border: 2px solid #007bff;
            padding: 30px;
            margin: 20px;
            border-radius: 10px;
            text-align: center;
            font-size: 1.5rem;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            max-width: 90%;
            width: 400px;
        }

        .error-message a {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 12px 28px;
            border-radius: 25px;
            text-decoration: none;
            transition: background-color 0.3s, transform 0.3s;
            font-size: 1rem;
            margin-top: 15px;
        }

        .error-message a:hover {
            background-color: #0056b3;
            transform: translateY(-3px);
        }

        .error-message p {
            margin: 15px 0;
            line-height: 1.6;
        }

        @media (max-width: 768px) {
            .error-message {
                font-size: 4vw;
            }

            .error-message a {
                font-size: 3vw;
                padding: 10px 20px;
            }
        }
    </style>
</head>
<body>

<?php
include 'conn.php';

if (isset($_GET['email'])) {
    $email = filter_var($_GET['email'], FILTER_SANITIZE_EMAIL);
    
    $sql = "UPDATE users SET isDeleted = 0 WHERE user_email = :email";
    
    try {
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        
        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                echo "Update successful.";
                header("location:../");
            } else {
                echo "<div class='error-message'>
                        <p>Something went wrong. Please try again.</p>
                        <a href='../'>Back to login page</a>
                      </div>";
            }
        } else {
            echo "Execution failed.";
        }
    } catch (PDOException $e) {
        echo "<div class='error-message'>
                <p>Error: " . htmlspecialchars($e->getMessage()) . "</p>
                <a href='../'>Back to login page</a>
              </div>";
    }
}

$conn = null;
?>

</body>
</html>
