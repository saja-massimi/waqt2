<?php  
include("../widgets/navbar.php");
include("dbconnection.php"); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../img/logo1.php" type="image/x-icon" rel="icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="../css/style.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <title>Contact Us</title>

    <style>
@import url("https://fonts.googleapis.com/css?family=Josefin+Sans:200,300,400,500,600,700|Roboto:100,300,400,500,700&display=swap");

*{ 
  font-family:"Josefin Sans",sans-serif;
}
 
:root {
--Color1: #16161a;
--Color2:#ff2020;
--Color3:#0b1c39;
--BgColor1: #ffffff;
--BgColor2: #f0f0f2;
}

        
    
        body {
        background: white;
         
        }
    
        .content h2 {
          color: red;
          font-size: 40px;
          text-align: center;
          margin-bottom: 20px;
        }
    
        .content form {
          width: 100%;
          max-width: 700px;
          text-align: center;
          margin: 0 auto;
        }
    
        .field .item {
          width: 100%;
          padding: 18px;
          background: transparent;
          border: 2px solid #dc3545;
          outline: none;
          border-radius: 6px;
          font-size: 16px;
          color: black;
          margin: 12px 0;
        }
    
        .field .item::placeholder {
          color: black;
        }
    
        .field .error-txt {
          font-size: 14.5px;
          color: #dc3545;
          text-align: left;
          margin: -5px 0 10px;
          display: none;
        }
    
        .textarea-field .item {
          resize: none;
        }
    
        form .submit {
          padding: 12px 32px;
          background: #dc3545;
          border: none;
          outline: none;
          border-radius: 6px;
          box-shadow: 0 0 10px #5a94ff;
          font-size: 16px;
          color: #1f242d;
          letter-spacing: 1px;
          font-weight: 600;
          cursor: pointer;
          margin-top: 20px;
          transition: 0.3s;
        }
    
        form button:hover {
          box-shadow: none;
        }
      </style>
</head>
<body>
<?php
if (isset($_POST['submit_contact'])) {
    $contact_name = $_POST['name'];
    $contact_email = $_POST['email'];
    $contact_phone = $_POST['phone_number'];
    $contact_subject = $_POST['subject'];
    $contact_message = $_POST['message'];

    try {
        // Prepare the SQL statement
        $sql = "INSERT INTO `contact_us`(`name`, `email`, `phone_number`, `subject`, `message`) 
                VALUES (:name, :email, :phone_number, :subject, :message)";
        $stmt = $dbconnection->prepare($sql);

        // Bind parameters and execute the statement
        $stmt->execute([
            'name' => $contact_name,
            'email' => $contact_email,
            'phone_number' => $contact_phone,
            'subject' => $contact_subject,
            'message' => $contact_message
        ]);

        echo "<script>alert('Data inserted successfully!');</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    }
}
?>

<section class="content container">
    <h2>Contact Waqt Team</h2>
    <form action="contact_us.php" method="post">
        <div class="row mb-3">
            <div class="col-md-6 mb-3 mb-md-0">
                <input type="text" required placeholder="Full Name" id="name" class="form-control item" name="name">
            </div>
            <div class="col-md-6">
                <input type="email" required placeholder="Email Address" id="email" name="email" class="form-control item">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6 mb-3 mb-md-0">
                <input type="text" minlength="9" required placeholder="Phone Number" id="phone" name="phone_number" class="form-control item">
            </div>
            <div class="col-md-6">
                <input type="text" required placeholder="Subject" id="subject" name="subject" class="form-control item">
            </div>
        </div>
        <div class="textarea-field field mb-3">
            <textarea name="message" required id="Message" cols="30" rows="5" placeholder="Your Message" class="form-control item" minlength="20"></textarea>
        </div>
        <button type="submit" class="btn btn-danger submit" name="submit_contact">Send message</button>
    </form>
</section>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://smtpjs.com/v3/smtp.js"></script>

</body>
</html>
<?php include("../widgets/footer.php"); ?>
