<?php
include('dbconnection.php');

// featured products
$query = "SELECT * FROM watches WHERE is_deleted = 0 LIMIT 4 ";
$statment = $dbconnection->prepare($query);
$statment->execute();
$items = $statment->fetchAll(PDO::FETCH_ASSOC);


//get recent products
$query = "SELECT * FROM watches WHERE is_deleted = 0 ORDER BY created_at DESC LIMIT 4";
$statment = $dbconnection->prepare($query);
$statment->execute();
$products = $statment->fetchAll(PDO::FETCH_ASSOC);

// get brands
$query = "SELECT `brand_name`, `brand_image` FROM `brandname`";
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
            <a href="./products.php" class="btn btn-light py-2 px-4 mt-3 animate__animated animate__fadeInUp">Shop Now</a>
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
                                    <a class="btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp" href="./products.php">Shop Now</a>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item position-relative" style="height: 430px;">
                            <img class="position-absolute w-100 h-100" src="../img/gallery/weman.jpg" style="object-fit: cover;">
                            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                <div class="p-3" style="max-width: 700px;">
                                    <h1 class="display-4 text-white mb-3 animate__animated animate__fadeInDown">Women Watches</h1>
                                    <p class="mx-md-5 px-5 animate__animated animate__bounceIn">Elegant Time, Timeless Style: Watches that Reflect Your Grace and Strength</p>
                                    <a class="btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp" href="./products.php">Shop Now</a>
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
                        <a href="./products.php" class="btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp">Shop Now</a>
                    </div>
                </div>
                <div class="product-offer mb-30" style="height: 200px;">
                    <img class="img-fluid" src="../img/gallery/new_product2.png" alt="">
                    <div class="offer-text">
                        <h6 class="text-white text-uppercase">Save 20%</h6>
                        <h3 class="text-white mb-3">Special Offer</h3>
                        <a href="./products.php" class="btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp">Shop Now</a>
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
                    <h1 class="fa fa-check  m-0 mr-5" style="color:black"></h1>
                    <h5 class="font-weight-semi-bold m-0">Quality Product</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <h1 class="fa fa-shipping-fast  m-0 mr-5" style="color:black"></h1>
                    <h5 class="font-weight-semi-bold m-0"> Free Shipping</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <h1 class="fas fa-exchange-alt m-0 mr-5 " style="color:black"></h1>
                    <h5 class="font-weight-semi-bold m-0"> 14-Day Return</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <h1 class="fa fa-phone-volume  m-0 mr-5 beta" style="color:black"></h1>
                    <h5 class="font-weight-semi-bold m-0"> 24/7 Support</h5>
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
                <p class="text-center w-100">No products available.</p>
            <?php else: ?>
                <?php foreach ($items as $item): ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                        <div class="product-item bg-light mb-4">
                            <div class="product-img position-relative overflow-hidden">
                                <img class="img-fluid w-100" src="../../Project/dashboards/assets/products_img/<?php echo $item['watch_img']; ?>" alt="<?php echo $item['watch_description']; ?>">
                                <div class="product-action">


                                    <a onclick="add_cart(<?= htmlspecialchars($item['watch_id']) ?>);" class="btn btn-outline-dark btn-square add-to-cart" data-id="<?= htmlspecialchars($item['watch_id']) ?>">
                                        <i class="fa fa-shopping-cart"></i>
                                    </a>

                                    <a class="btn btn-outline-dark btn-square" onclick="addWishlist(<?= htmlspecialchars($item['watch_id']) ?>);" data-id="<?= htmlspecialchars($item['watch_id']) ?>"><i class="far fa-heart"></i></a>


                                    <form action="detail.php" method="POST" style="display:inline;position:relative">
                                        <a href="" class="btn btn-outline-dark btn-square"> <i class="fa fa-search"></i>
                                        </a>
                                        <input type="hidden" name="watch_id" value="<?= $item['watch_id'] ?>">
                                        <button type="submit" style="border:none; background:none;display:hidden;position:absolute;top:0;left:0;width:100%;height:100%;opacity:0;">
                                        </button>
                                    </form>

                                </div>
                            </div>
                            <div class="text-center py-4">
                                <a class="h6 text-decoration-none text-truncate" href="#"><?php echo $item['watch_name']; ?></a>
                                <div class="d-flex align-items-center justify-content-center mt-2">
                                    <h5><?php echo $item['watch_price']; ?> JOD</h5>
                                    <h6 class="text-muted ml-2"><del>132</del> JOD</h6>
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
                                <img style="min-height:500px;object-fit: cover;" class="img-fluid w-100" src="../../Project/dashboards/assets/products_img/<?php echo $product['watch_img']; ?>" alt="<?php echo $product['watch_name']; ?>">
                                <div class="product-action">


                                    <a onclick="add_cart(<?= htmlspecialchars($product['watch_id']) ?>);" class="btn btn-outline-dark btn-square add-to-cart" data-id="<?= htmlspecialchars($product['watch_id']) ?>">
                                        <i class="fa fa-shopping-cart"></i>
                                    </a>

                                    <a class="btn btn-outline-dark btn-square" onclick="addWishlist(<?= htmlspecialchars($product['watch_id']) ?>);" data-id="<?= htmlspecialchars($product['watch_id']) ?>"><i class="far fa-heart"></i></a>


                                    <form action="detail.php" method="POST" style="display:inline;position:relative">
                                        <a href="" class="btn btn-outline-dark btn-square"> <i class="fa fa-search"></i>
                                        </a>
                                        <input type="hidden" name="watch_id" value="<?= $product['watch_id'] ?>">
                                        <button type="submit" style="border:none; background:none;display:hidden;position:absolute;top:0;left:0;width:100%;height:100%;opacity:0;">
                                        </button>
                                    </form>

                                </div>
                            </div>
                            <div class="text-center py-4">
                                <a class="h6 text-decoration-none text-truncate" href=""><?php echo $product['watch_name']; ?></a>
                                <div class="d-flex align-items-center justify-content-center mt-2">
                                    <h5><?php echo $product['watch_price']; ?> JOD</h5>
                                    <h6 class="text-muted ml-2"><del>123.00</del> JOD</h6>
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
    <?php include("../widgets/carousel.php"); ?>
    <!-- Vendor End -->


    <?php include("../widgets/footer.php"); ?>


    <!-- Back to Top -->
    <a href="#top_page" class="btn btn-primary back-to-top bg-danger "><i class="fa fa-angle-double-up text-dark "></i></a>


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

    <script src="./addToCart.js"></script>
    <!-- Template Javascript -->
    <script src="../js/main.js"></script>
</body>

</html>