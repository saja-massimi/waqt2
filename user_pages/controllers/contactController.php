<?php
require '../models/contactModel.php';
require_once '../models/Dbh.php';

// Get JSON input
$inputData = json_decode(file_get_contents("php://input"), true);

if ($inputData) {
    $contact_name = $inputData['name'];
    $contact_email = $inputData['email'];
    $contact_phone = $inputData['phone_number'];
    $contact_subject = $inputData['subject'];
    $contact_message = $inputData['message'];

    $dbconn = new Dbh();
    $conn = $dbconn->connect();

    if ($conn) {
        $data = [
            ':name' => $contact_name,
            ':email' => $contact_email,
            ':phone_number' => $contact_phone,
            ':subject' => $contact_subject,
            ':message' => $contact_message
        ];

        $contactModel = new ContactModel($conn);
        $result = $contactModel->insertContactInfo($data);

        if ($result === "Data inserted successfully!") {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed to insert data."]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Database connection failed."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid input."]);
}
?>
