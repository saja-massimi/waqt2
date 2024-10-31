<?php

include("../widgets/navbar.php");
include('dbconnection.php');

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['wishlist_id'])){
    $wishlist_id=$_POST['wishlist_id'];
    //print_r($wishlist_id);

    $query="DELETE FROM `wishlist` WHERE `WishlistItemID`=:wishlist_id";
    $stat=$dbconnection->prepare($query);
    $stat->bindParam(':wishlist_id',$wishlist_id,PDO::PARAM_INT);
    $stat->execute();
}

$user_id= $_SESSION['user'];
$query="SELECT `wishlist`.WishlistItemID,`watches`.watch_name, `watches`.watch_description, `watches`.watch_img, `watches`.watch_price, `watches`.total_number FROM `wishlist` 
JOIN `users` ON `wishlist`.user_id = `users`.user_id 
JOIN `watches` ON `wishlist`.watch_id = `watches`.watch_id
WHERE `users`.user_id=:user_id";

$statment=$dbconnection->prepare($query);
$statment->bindParam(':user_id',$user_id,PDO::PARAM_INT);
$statment->execute();
$products=$statment->fetchAll(PDO::FETCH_ASSOC);
//print_r($products);

if (isset($_POST['delete'])){
    $wishlist_id=$_POST['delete'];

    $query="DELETE FROM `wishlist` WHERE `WishlistItemID`=:wishlist_id";

    $statement=$connection->prepare($query);

    $statement->bindParam(':wishlist_id',$wishlist_id,PDO::PARAM_INT);

    $statement->execute();

}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wish List</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/owl.carousel.min.css">
    <link rel="stylesheet" href="../css/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css">

</head>

<body>
        <!-- wishlist Start -->
        <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12 table-responsive mb-5">
                <table class="table table-light table-borderless table-hover text-center mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th>Products Name</th>
                            <th>Product Image</th>
                            <th>Product Description</th>
                            <th>Price</th>
                            <th>Add to cart</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                    <?php if (count($products) == 0): ?>
                            <p class="text-center w-100">No featured products available.</p>
                        <?php else: ?>
                        <?php foreach ($products as $product): ?>

                        <tr>

                            <td class="align-middle"><?php echo $product['watch_name']; ?></td>

                            <td class="align-middle"><img src="<?php echo $product['watch_img']; ?>" alt="<?php echo $product['watch_name']; ?>" style="width: 50px;"></td>

                            <td class="align-middle"><?php echo $product['watch_name']; ?></td>

                            <td class="align-middle"><?php echo $product['watch_price']; ?></td>

                            <td class="align-middle"><button class="btn btn-sm btn-danger bg-danger text-white btn-delete">Add to Cart</button></td>

                            <td class="align-middle">
                            <form method="POST" action="wishlist.php">

                                <input type="hidden" name="wishlist_id" value="<?php echo $product['WishlistItemID']; ?>">
                                <button type="submit" class="btn btn-sm btn-danger bg-danger text-white btn-delete">Delete</button>

                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>

                    </tbody>
                </table>
            </div>
            
        </div>
    </div>
    <!-- wishlist End -->



    <!-- Footer Start-->
    <?php  include("../widgets/footer.php");?>
</body>

</html>