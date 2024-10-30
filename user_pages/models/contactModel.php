<?php
require "Dbh.php";

class ContactModel
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function insertContactInfo($data)
    {
        try {
            $sql = "INSERT INTO `contact_us`(`name`, `email`, `phone_number`, `subject`, `message`) 
                    VALUES (:name, :email, :phone_number, :subject, :message)";
            $stmt = $this->conn->prepare($sql);

            // Execute the statement with the provided data
            if ($stmt->execute($data)) {
                return "Data inserted successfully!";

            } else {
                return "Failed to insert data.";
              
            }
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }
}
?>
