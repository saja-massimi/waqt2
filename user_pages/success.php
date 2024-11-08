<!DOCTYPE html>
<html lang="en">
<?php
require_once '../widgets/head.php';

require_once './models/Dbh.php';
require_once './models/orderModel.php';

$orderModel = new orderModel();
$order_id = $orderModel->getLastOrderId();


?>


<body>
    <?php include("../widgets/navbar.php"); ?>


    <div class="container d-flex justify-content-center align-items-center  flex-column mb-3 vh-70 pt-3 pb-3">


        <h2 class="text-center mb-4" style="font-size: 2em;">Order Successful</h2>
        <div class="text-center">
            <img src="./uploads/cart.png" alt="Cart" width="200px" class="mb-3">
            <p style="font-size: 1.5em;">Order number:</p>
            <p style="font-size: 1.8em;"><?php echo $order_id; ?></p>
            <p style="font-size: 1.2em;">Thank you for shopping with us. Your order is currently being processed</p>

            <a href="./customer_profile.php#history" class="btn btn-danger mt-3">Order History</a>
            <a href="./index.php" class="btn btn-danger mt-3">Back to Home</a>
        </div>



    </div>


</body>

</html>