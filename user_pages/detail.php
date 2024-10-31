<?php  
session_start();
include("../widgets/navbar.php");
include('dbconnection.php');

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['watch_id'])){
    $id=$_POST['watch_id'];
//echo $id;

$query="SELECT  `watch_name`, `watch_description`, `watch_img`, `watch_price`, `watch_brand`,`watch_model`, `watch_gender`, `strap_material`, `total_number` FROM watches WHERE `watch_id`=:id";

$statement=$dbconnection->prepare($query);
$statement->bindParam(':id',$id,PDO::PARAM_INT);
$statement->execute();
$watches=$statement->fetch(PDO::FETCH_ASSOC);
//print_r($watches);
}

$query = "SELECT watch_id, watch_name, watch_description, watch_img, watch_price, watch_brand, watch_model, watch_gender FROM watches ORDER BY RAND() LIMIT 4";


$statment=$dbconnection->prepare($query);
$statment->execute();
$items=$statment->fetchAll(PDO::FETCH_ASSOC);
//print_r($items);
?>

<body>
    <!-- Shop Detail Start -->
    <div class="container-fluid pb-5">
        <div class="row px-xl-5">
            <div class="col-lg-5 mb-30">
                <div id="product-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner bg-light w-100 h-100">
                        <div class="carousel-item active w-100 h-100 d-flex justify-content-center align-items-center">
                        <?php echo "
                            <img class='m-auto' src='{$watches['watch_img']}' alt='{$watches['watch_name']}' style='max-width: 100%; height: auto;'>
                            "; ?>


                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-7 h-auto mb-30">
                <div class="h-100 bg-light p-30">
                    <br>
                    <br>
                    <h3 style="font-size: 30px;"><?= $watches['watch_name']?></h3>
                    <br>
                    <h3 class="font-weight-semi-bold mb-4" style="font-size: 30px;"><?= $watches['watch_price']?> JD</h3>
                    <p class="mb-4" style="font-size: 24px;"><b>Description: </b><?= $watches['watch_description'] ?></p>
                    <p class="mb-4" style="font-size: 24px;"><b>Brand:</b> <?= $watches['watch_brand'] ?></p>
                    <p class="mb-4" style="font-size: 24px;"><b>Model:</b> <?= $watches['watch_model'] ?></p>
                    <p class="mb-4" style="font-size: 24px;"><b>Gender:</b> <?= $watches['watch_gender'] ?></p>
                    <p class="mb-4" style="font-size: 24px;"><b>Material: </b><?= $watches['strap_material'] ?></p>


                    <div class="d-flex align-items-center mb-4 pt-2">
                        <div class="input-group quantity mr-3" style="width: 130px;">
                            <div class="input-group-btn">
                                <button id="btn-minus" class="btn btn-primary bg-danger text-white btn-minus">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>
                            <input id="quantity" type="text" class="form-control bg-secondary border-0 text-center" value="1">
                            <div class="input-group-btn">
                                <button id="btn-plus" class="btn btn-primary bg-danger text-white btn-plus">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>

                        <button class="btn btn-primary  bg-danger text-white px-3"><i class="fa fa-shopping-cart mr-1"></i> Add To
                            Cart</button>
                    </div>
                   
                </div>
            </div>
        </div>
 
    <!-- Shop Detail End -->


    <!-- Products Start -->
    <div class="container-fluid py-5">
    <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">You May Also Like</span></h2>
    <div class="row px-xl-5">
        <?php if (count($items) == 0): ?>
            <p class="text-center w-100">No featured products available.</p>
        <?php else: ?>
            <?php foreach ($items as $item): ?>
                <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                    <div class="product-item bg-light mb-4">
                        <div class="product-img position-relative overflow-hidden">
                            <img class="img-fluid w-100 h-100" src="<?php echo $item['watch_img']; ?>" alt="<?php echo $item['watch_name']; ?>">
                            <div class="product-action">
                                <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>


                                <?php                                           
                                    // User ID from session
                                    $user_id = $_SESSION['user'];

                                    // Product ID you are checking for, assuming $product['watch_id'] is the current product ID
                                    $watch_id = $item['watch_id'];

                                    // Query to check if this item is already in the wishlist
                                    $query = "SELECT * FROM wishlist WHERE user_id =:user_id AND watch_id =:watch_id";
                                    $stmt = $dbconnection->prepare($query);
                                    $stmt->bindParam(':user_id', $user_id,PDO::PARAM_INT);
                                    $stmt->bindParam(':watch_id', $watch_id,PDO::PARAM_INT);
                                    $stmt->execute();
                                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                    //print_r($result);

                                    // Check if the item is in the wishlist
                                    $isFavorite = $result !== false;
                                    ?>
                                    <form action="index.php" method="POST" style="display:inline;" class="btn btn-outline-dark btn-square">
                                        <input type="hidden" name="watch_id" value="<?= $item['watch_id'] ?>">
                                        <input type="hidden" name="action" value="<?= $isFavorite ? 'remove' : 'add' ?>">
                                        <button type="submit" class="btn btn-outline-dark btn-square" style="border:none; background:none;">
                                            <i class="<?= $isFavorite ? 'fas fa-heart' : 'far fa-heart' ?>"></i>
                                        </button>
                                    </form>


                                <form action="detail.php" method="POST" style="display:inline;" class="btn btn-outline-dark btn-square">
                                                <input type="hidden" name="watch_id" value="<?= $item['watch_id'] ?>">
                                                <button type="submit" class="btn btn-outline-dark btn-square" style="border:none; background:none;">
                                                    <i class="fa fa-search"></i>
                                                </button>
                                    </form>

                            </div>
                        </div>
                        <div class="text-center py-4">
                            <a class="h6 text-decoration-none text-truncate" href=""><?php echo $item['watch_name']; ?></a>
                            <div class="d-flex align-items-center justify-content-center mt-2">
                                <h5><?php echo $item['watch_price']; ?></h5><h6 class="text-muted ml-2"><del>$123.00</del></h6>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

    <!-- Products End -->


    <?php  include("../widgets/footer.php");?>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Contact Javascript File -->
    <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>