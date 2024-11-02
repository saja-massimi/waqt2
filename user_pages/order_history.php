<!DOCTYPE html>
<html lang="en">

<?php include("../widgets/head.php"); ?>

<body>



    <?php include("../widgets/navbar.php"); ?>
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col table-responsive  w-100 p-3">
                <table class="table table-light table-borderless table-hover text-center mb-0  w-100 p-3">
                    <thead class="thead-dark">
                        <tr>
                            <th>Order number</th>
                            <th> Price</th>
                            <th>Status</th>
                            <th>Order Adrress</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <?php
                    require "dbconnection.php";
                    $query = "SELECT `order_id`,`order_total`, `order_status`, `order_address`, `created_at` FROM `orders`";
                    $orders = $dbconnection->query($query);


                    if ($orders->rowCount() == 0) {
                        echo "<tr><td colspan='5'>No orders found Yet</td></tr>";
                    } else {
                        foreach ($orders as $order) {
                            echo "  <tr>
                    <td>$order[order_id] </td>
                    <td>$order[order_total] </td>
                    <td>$order[order_status] </td>
                    <td>$order[order_address] </td>
                    <td>$order[created_at] </td>
                   
                   </tr> ";
                        }
                    }

                    ?>
                    <tbody class="align-middle">
                        <tr>
                            <td class="align-middle"><img src="img/product-1.jpg" alt="" style="width: 50px;"> Product Name</td>
                            <td class="align-middle"></td>
                            <td class="align-middle"></td>
                            <td class="align-middle"></td>
                            <td class="align-middle"></td>
                            <td class="align-middle"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <?php include("../widgets/footer.php"); ?>

</body>

</html>