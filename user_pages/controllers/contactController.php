<?php
require "../models/contactModel.php";
require_once "../models/Dbh.php";

if (isset($_POST['submit_contact'])) {
    $contact_name = $_POST['name'];
    $contact_email = $_POST['email'];
    $contact_phone = $_POST['phone_number'];
    $contact_subject = $_POST['subject'];
    $contact_message = $_POST['message'];

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
            header("Location: ../contact_us.php?status=success");
        } 
        
    else {
        header("Location: ../contact_us.php?status=connection_failed");
    }
    exit();
    }}
?>
