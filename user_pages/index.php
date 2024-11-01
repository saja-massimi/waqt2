<?php
include('dbconnection.php');

//get all watches
$query = "SELECT watch_id, watch_name, watch_description, watch_img, watch_price, watch_brand, watch_model, watch_gender FROM watches LIMIT 4";
$statment = $dbconnection->prepare($query);
$statment->execute();
$items = $statment->fetchAll(PDO::FETCH_ASSOC);


//get all watches
$query = "SELECT * FROM watches WHERE is_deleted = 0 ORDER BY created_at DESC LIMIT 4";
$statment = $dbconnection->prepare($query);
$statment->execute();
$products = $statment->fetchAll(PDO::FETCH_ASSOC);

// if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['watch_id'])) {
//     $user_id = $_SESSION['user'];
//     $watch_id = $_POST['watch_id'];
//     $action = $_POST['action'];



//     if ($action === 'add') {

//         $query = "INSERT INTO `wishlist`( `user_id`, `watch_id`) VALUES (:user_id,:watch_id)";
//         $stat = $dbconnection->prepare($query);

//         $data = [
//             'user_id' => $user_id,
//             'watch_id' => $watch_id

//         ];
//         $stat->execute($data);
//         $result = $stat->fetchAll(PDO::FETCH_ASSOC);

//     } else if ($action === 'remove') {
//         $query = "DELETE FROM `wishlist` WHERE `user_id`=:user_id AND `watch_id`=:watch_id";
//         $stmt = $dbconnection->prepare($query);
//         $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
//         $stmt->bindParam(':watch_id', $watch_id, PDO::PARAM_INT);
//         $stmt->execute();
//     };
// }

$query = "SELECT `brand_name`, `brand_image` FROM `brandname` LIMIT 5";
$statement = $dbconnection->prepare($query);
$statement->execute();
$brands = $statement->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<?php include("../widgets/head.php"); ?>


<body>
    <?php include("../widgets/navbar.php"); ?>


    <section class="landing-section">
        <video autoplay muted loop id="landing-video">
            <source src="../img/video/landing_page.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>

        <div class="overlay"></div>

        <div class="landing-content">
            <h1>Welcome to WAQT</h1>
            <p>Waqt offers elegant, <br>high-quality watches blending classic craftsmanship with modern design, <br>prioritizing customer satisfaction and personalized service.</p>
            <a href="products.php" class="btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp">Shop Now</a>
        </div>
    </section>

    <!-- Carousel Start -->
    <div class="container-fluid mb-3">
        <div class="row px-xl-5">
            <div class="col-lg-8">
                <div id="header-carousel" class="carousel slide carousel-fade mb-30 mb-lg-0" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#header-carousel" data-slide-to="0" class="active"></li>
                        <li data-target="#header-carousel" data-slide-to="1"></li>

                    </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item position-relative active" style="height: 430px;">
                            <img class="position-absolute w-100 h-100" src="../img/gallery/gallery01.png" style="object-fit: cover;">
                            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                <div class="p-3" style="max-width: 700px;">
                                    <h1 class="display-4 text-white mb-3 animate__animated animate__fadeInDown">Men Watches</h1>
                                    <p class="mx-md-5 px-5 animate__animated animate__bounceIn">Timepieces that Define You: Precision, Power, and Style in Every Tick</p>
                                    <a class="btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp" href="#">Shop Now</a>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item position-relative" style="height: 430px;">
                            <img class="position-absolute w-100 h-100" src="../img/gallery/weman.jpg" style="object-fit: cover;">
                            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                <div class="p-3" style="max-width: 700px;">
                                    <h1 class="display-4 text-white mb-3 animate__animated animate__fadeInDown">Women Watches</h1>
                                    <p class="mx-md-5 px-5 animate__animated animate__bounceIn">Elegant Time, Timeless Style: Watches that Reflect Your Grace and Strength</p>
                                    <a class="btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp" href="#">Shop Now</a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="product-offer mb-30" style="height: 200px;">
                    <img class="img-fluid" src="../img/gallery/new_product3.png" alt="">
                    <div class="offer-text">
                        <h6 class="text-white text-uppercase">Save 20%</h6>
                        <h3 class="text-white mb-3">Special Offer</h3>
                        <a href="" class="btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp">Shop Now</a>
                    </div>
                </div>
                <div class="product-offer mb-30" style="height: 200px;">
                    <img class="img-fluid" src="../img/gallery/new_product2.png" alt="">
                    <div class="offer-text">
                        <h6 class="text-white text-uppercase">Save 20%</h6>
                        <h3 class="text-white mb-3">Special Offer</h3>
                        <a href="" class="btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp">Shop Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Carousel End -->


    <!-- Featured Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5 pb-3">
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <h1 class="fa fa-check  m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">Quality Product</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <h1 class="fa fa-shipping-fast  m-0 mr-2"></h1>
                    <h5 class="font-weight-semi-bold m-0">Free Shipping</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <h1 class="fas fa-exchange-alt m-0 mr-3 "></h1>
                    <h5 class="font-weight-semi-bold m-0">14-Day Return</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <h1 class="fa fa-phone-volume  m-0 mr-3 beta"></h1>
                    <h5 class="font-weight-semi-bold m-0">24/7 Support</h5>
                </div>
            </div>
        </div>
    </div>
    <!-- Featured End -->


    <!-- Categories Start -->
    <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class=" pr-3">Our Categories</span></h2>
    <div class="container-fluid pt-5 pb-3" id="categories">
        <div class="row px-xl-5">
            <div class="col-md-6">
                <div class="product-offer mb-30" style="height: 300px;">
                    <img class="img-fluid" src="../img/gallery/new_product1.png" alt="">
                    <div class="offer-text">
                        <h6 class="text-white text-uppercase"></h6>
                        <h3 class="text-white mb-3">Men's luxury always shines</h3>
                        <a href="./products.php?category=men" class="btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp">Shop Now</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="product-offer mb-30" style="height: 300px;">
                    <img class="img-fluid" src="../img/gallery/new_product3.png" alt="">
                    <div class="offer-text">
                        <h3 class="text-white mb-3">Women's luxury always shines</h3>
                        <a href="./products.php?category=women" class="btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp">Shop Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Categories End -->


    <!-- Products Start -->
    <div class="container-fluid pt-5 pb-3">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class=" pr-3">Featured Products</span></h2>
        <div class="row px-xl-5">
            <?php if (count($items) == 0): ?>
                <p class="text-center w-100">No featured products available.</p>
            <?php else: ?>
                <?php foreach ($items as $item): ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                        <div class="product-item bg-light mb-4">
                            <div class="product-img position-relative overflow-hidden">
                                <img class="img-fluid w-100" src="<?php echo $item['watch_img']; ?>" alt="<?php echo $item['watch_description']; ?>">
                                <div class="product-action">
                                    <a class="btn btn-outline-dark btn-square" href="#"><i class="fa fa-shopping-cart"></i></a>

                                    <?php
                                    // User ID from session
                                    if (isset($_SESSION['user'])) {
                                        $user_id = $_SESSION['user'];

                                        // Product ID you are checking for, assuming $product['watch_id'] is the current product ID
                                        $watch_id = $item['watch_id'];

                                        // Query to check if this item is already in the wishlist
                                        $query = "SELECT * FROM wishlist WHERE user_id =:user_id AND watch_id =:watch_id";
                                        $stmt = $dbconnection->prepare($query);
                                        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                                        $stmt->bindParam(':watch_id', $watch_id, PDO::PARAM_INT);
                                        $stmt->execute();
                                        $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                        //print_r($result);

                                        // Check if the item is in the wishlist
                                        $isFavorite = $result !== false;
                                    } else {
                                        $isFavorite = false;
                                    }
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
                                <a class="h6 text-decoration-none text-truncate" href="#"><?php echo $item['watch_name']; ?></a>
                                <div class="d-flex align-items-center justify-content-center mt-2">
                                    <h5>$<?php echo $item['watch_price']; ?></h5>
                                    <h6 class="text-muted ml-2"><del>$132</del></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    <!-- Products End -->


    <!-- Products Start -->
    <div class="container-fluid pt-5 pb-3">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="pr-3">Recent Products</span></h2>
        <div class="row px-xl-5">

            <?php if (count($products) == 0): ?>
                <p class="text-center w-100">No featured products available.</p>
            <?php else: ?>
                <?php foreach ($products as $product): ?>

                    <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                        <div class="product-item bg-light mb-4">
                            <div class="product-img position-relative overflow-hidden">
                                <img class="img-fluid w-100" src="<?php echo $product['watch_img']; ?>" alt="<?php echo $product['watch_name']; ?>">
                                <div class="product-action">
                                    <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>

                                    <?php
                                    if (isset($_SESSION['user'])) {
                                        $user_id = $_SESSION['user'];

                                        // Product ID you are checking for, assuming $product['watch_id'] is the current product ID
                                        $watch_id = $item['watch_id'];

                                        // Query to check if this item is already in the wishlist
                                        $query = "SELECT * FROM wishlist WHERE user_id =:user_id AND watch_id =:watch_id";
                                        $stmt = $dbconnection->prepare($query);
                                        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                                        $stmt->bindParam(':watch_id', $watch_id, PDO::PARAM_INT);
                                        $stmt->execute();
                                        $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                        //print_r($result);

                                        // Check if the item is in the wishlist
                                        $isFavorite = $result !== false;
                                    } else {
                                        $isFavorite = false;
                                    }

                                    ?>
                                    <form action="index.php" method="POST" style="display:inline;" class="btn btn-outline-dark btn-square">
                                        <input type="hidden" name="watch_id" value="<?= $item['watch_id'] ?>">
                                        <input type="hidden" name="action" value="<?= $isFavorite ? 'remove' : 'add' ?>">
                                        <button type="submit" class="btn btn-outline-dark btn-square" style="border:none; background:none;">
                                            <i class="<?= $isFavorite ? 'fas fa-heart' : 'far fa-heart' ?>"></i>
                                        </button>
                                    </form>

                                    <form action="detail.php" method="POST" style="display:inline;" class="btn btn-outline-dark btn-square">
                                        <input type="hidden" name="watch_id" value="<?= $product['watch_id'] ?>">
                                        <button type="submit" class="btn btn-outline-dark btn-square" style="border:none; background:none;">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </form>

                                </div>
                            </div>
                            <div class="text-center py-4">
                                <a class="h6 text-decoration-none text-truncate" href="">"<?php echo $product['watch_name']; ?>"</a>
                                <div class="d-flex align-items-center justify-content-center mt-2">
                                    <h5>"<?php echo $product['watch_price']; ?>"</h5>
                                    <h6 class="text-muted ml-2"><del>$123.00</del></h6>
                                </div>

                            </div>


                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

        </div>
    </div>
    <!-- Products End -->


    <!-- Vendor Start -->

    <!-- <div class="container-fluid py-5 ">
    <div class="row px-xl-5 ">
        <div class="col">
            <div class="row owl-carousel vendor-carousel d-flex justify-content-center">

            <?php if (count($brands) == 0): ?>
            <p class="text-center w-100">No featured products available.</p>
            <?php else: ?>
            <?php foreach ($brands as $brand): ?>
                <div class="img-fluid bg-light p-4">
                    <img style="width: 200px; height:200px; gap:30px" src="<?php echo $brand['brand_image']; ?>" alt="<?php echo $brand['brand_name']; ?>">
                </div>

                <?php endforeach; ?>
                <?php endif; ?>
                    <!-- <div class=" col bg-light p-4 d-flex justify-content-between w-auto">
                        <img src="../img/vendor-2.jpg" alt="Vendor 2">
                    </div>
                    <div class=" col bg-light p-4 d-flex justify-content-between w-auto">
                        <img src="../img/vendor-3.jpg" alt="Vendor 3">
                    </div>
                    <div class=" colbg-light p-4 d-flex justify-content-between w-auto">
                        <img src="../img/vendor-4.jpg" alt="Vendor 4">
                    </div>
                    <div class=" col bg-light p-4 d-flex justify-content-between w-auto">
                        <img src="../img/vendor-5.jpg" alt="Vendor 5">
                    </div>
                    <div class=" col bg-light p-4 d-flex justify-content-between w-auto">
                        <img src="../img/vendor-6.jpg" alt="Vendor 6">
                    </div> -->

    </div>
    </div>
    </div>
    </div>



    <!-- Vendor End -->


    <?php include("../widgets/footer.php"); ?>


    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top bg-danger "><i class="fa fa-angle-double-up text-dark "></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.vendor-carousel').owlCarousel({
                loop: true,
                margin: 0,
                nav: false,
                responsive: {
                    0: {
                        items: 1
                    },
                    576: {
                        items: 3
                    },
                    768: {
                        items: 4
                    },
                    992: {
                        items: 5
                    },
                    1200: {
                        items: 7
                    }
                }
            });
        });
    </script>


    <!-- Template Javascript -->
    <script src="../js/main.js"></script>
</body>

</html>