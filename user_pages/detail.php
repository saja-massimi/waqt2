<?php
include("../widgets/navbar.php");
include("../widgets/head.php");
include('dbconnection.php');

if (isset($_POST['watch_id'])) {
    $_SESSION['watch_id'] = $_POST['watch_id'];
    $id = $_SESSION['watch_id'];
}
$query = "SELECT  `watch_name`, `watch_description`, `watch_img`, `watch_price`, `watch_brand`,`watch_model`, `watch_gender`, `strap_material`, `quantity` FROM watches WHERE `watch_id`=:id";

$statement = $dbconnection->prepare($query);
$statement->bindParam(':id', $_SESSION['watch_id'], PDO::PARAM_INT);
$statement->execute();
$watches = $statement->fetch(PDO::FETCH_ASSOC);


$query = "SELECT watch_id, watch_name, watch_description, watch_img, watch_price, watch_brand, watch_model, watch_gender FROM watches ORDER BY RAND() LIMIT 4";


$statment = $dbconnection->prepare($query);
$statment->execute();
$items = $statment->fetchAll(PDO::FETCH_ASSOC);

$isLoggedIn = isset($_SESSION['user']);
$updateMessage = "";
if (isset($_POST['review'])) {

    if ($isLoggedIn) {

        $id = $_SESSION['watch_id'];
        $rating = $_POST['rating'];
        $comment = $_POST['comment'];
        

        $query = "INSERT INTO `reviews` (`user_email`, `watch_id`, `rating`, `review_text`)
          SELECT `user_email`, :watch_id, :rating, :review_text 
          FROM `users` WHERE `user_id` = :user_id";
        $stat = $dbconnection->prepare($query);

        $data = [
            'watch_id' => $id,
            'rating' => $rating,
            'review_text' => $comment,
            'user_id' => $user_id,

        ];

        try {
            $stat->execute($data);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        $updateMessage = "error";
    }
}


$query = "SELECT `user_email`,`rating`,`review_text`,`created_at` FROM `reviews` WHERE `watch_id`=:watch_id";
$statement = $dbconnection->prepare($query);
$statement->bindParam(':watch_id', $_SESSION['watch_id'], PDO::PARAM_INT);
$statement->execute();
$data = $statement->fetchAll(PDO::FETCH_ASSOC);

$query = "SELECT COUNT(*) AS total_number FROM `reviews` WHERE `watch_id`=:watch_id";
$statt = $dbconnection->prepare($query);
$statt->bindParam(':watch_id', $_SESSION['watch_id'], PDO::PARAM_INT);
$statt->execute();
$count = $statt->fetch(PDO::FETCH_ASSOC);

$query = "SELECT avg(rating) AS avg_number FROM `reviews` WHERE `watch_id`=:watch_id";
$statt = $dbconnection->prepare($query);
$statt->bindParam(':watch_id', $_SESSION['watch_id'], PDO::PARAM_INT);
$statt->execute();
$avg = $statt->fetch(PDO::FETCH_ASSOC);

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">

<style>
    .star {
        font-size: 30px;
        cursor: pointer;
        color: #ccc;

    }

    .star2 {
        font-size: 30px;
        cursor: pointer;
        color: #ccc;
        pointer-events: none;
        /* Disable click events */


    }

    .star2.active {
        color: #FFD700;
        /* Gold color */
    }

    .star2.filled {
        color: #FFD700;
        /* Color for filled stars (e.g., gold) */
    }

    .star.active {
        color: #FFD700;
        /* Gold color */
    }

    .star.filled {
        color: #FFD700;
        /* Color for filled stars (e.g., gold) */
    }

    .review-section {
        max-height: 300px;
        /* Set your desired max height */
        overflow-y: auto;
        /* Enable vertical scrolling */
        padding-right: 15px;
        /* Optional: Add padding to avoid content cutoff by scrollbar */
    }

    .rating-stars {
        display: inline-block;
    }
</style>

<body>




    <!-- Shop Detail Start -->
    <div class="container-fluid pb-5">
        <div class="row px-xl-5">
            <div class="col-lg-5 mb-30">
                <div id="product-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner bg-light">
                        <?php echo "
                            <img class='m-auto' src='../../Project/dashboards/assets/products_img/{$watches['watch_img']}' alt='{$watches['watch_name']}' style='max-width: 100%; height: auto;'>
                            "; ?>

                    </div>
                </div>
            </div>

            <div class="col-lg-7 h-auto mb-30">
                <div class="h-100 bg-light p-30">
                    <h3 style="font-size: 30px;"><?= $watches['watch_name'] ?></h3>
                    <div class="d-flex mb-3">
                        <?php
                        $rating =  $avg['avg_number']; // Replace with your actual database query to get the rating

                        echo '<div class="rating-stars">';
                        for ($i = 1; $i <= 5; $i++) {
                            // Add a class if the star rating is less than or equal to the actual rating
                            $class = ($i <= $rating) ? 'filled' : '';
                            echo '<span class="star2 ' . $class . '" data-rating="' . $i . '">★</span>';
                        }
                        echo '</div>';
                        ?>

                        <small class="pt-2 pl-2" style="font-size: 20px;">(<?= $count['total_number'] ?> Reviews)</small>
                    </div>
                    <h3 class="font-weight-semi-bold mb-4" style="font-size: 30px;"><?= $watches['watch_price'] ?> JOD</h3>
                    <p class="mb-4" style="font-size: 24px;"><b>Description: </b><?= $watches['watch_description'] ?>
                    </p>
                    <p class="mb-4" style="font-size: 24px;"><b>Brand:</b> <?= $watches['watch_brand'] ?></p>
                    <p class="mb-4" style="font-size: 24px;"><b>Model:</b> <?= $watches['watch_model'] ?></p>
                    <p class="mb-4" style="font-size: 24px;"><b>Gender:</b> <?= $watches['watch_gender'] ?></p>
                    <p class="mb-4" style="font-size: 24px;"><b>Material: </b><?= $watches['strap_material'] ?></p>

                    <div class="d-flex align-items-center mb-4 pt-2">
                        <div class="d-flex align-items-center mb-4 pt-2">

                            <div class="input-group quantity mr-3" style="width: 130px;">
                                <div class="input-group-btn">
                                    <button class="btn btn-primary bg-danger text-white btn-minus">
                                        <i class="fa fa-minus"></i>
                                    </button>


                                </div>
                                <input type="text" class="form-control  border-0 text-center" value="1" id="quantity-input">
                                <div class="input-group-btn">
                                    <button class="btn btn-primary bg-danger text-white btn-plus">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>


                            <a onclick="add_cartWithQuantity(<?= htmlspecialchars($_SESSION['watch_id']) ?>);" class="btn btn-outline-dark btn-square add-to-cart" data-id="<?= htmlspecialchars($_SESSION['watch_id']) ?>">
                                <i class="fa fa-shopping-cart"></i>
                            </a>
                        </div>


                    </div>

                </div>
            </div>
        </div>
        <div class="row px-xl-5">
            <div class="col">
                <div class="bg-light p-30">
                    <div class="nav nav-tabs mb-4">
                        <a class="nav-item nav-link text-dark active" data-toggle="tab" href="#tab-pane-1">Description</a>
                        <a class="nav-item nav-link text-dark" data-toggle="tab" href="#tab-pane-3">Reviews (<?= $count['total_number'] ?>)</a>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="tab-pane-1">
                            <h4 class="mb-3">Product Description</h4>
                            <p style="font-size: 24px;"><?= $watches['watch_description'] ?></p>

                        </div>

                        <div class="tab-pane fade" id="tab-pane-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="mb-4"><?= $count['total_number'] ?> review for <?= $watches['watch_name'] ?></h4>
                                    <div class="review-section">
                                        <?php if (count($data) == 0): ?>
                                            <p class="text-center w-100">No comments available.</p>
                                        <?php else: ?>
                                            <?php foreach ($data as $all): ?>
                                                <div class="media mb-4 ">
                                                    <img src="uploads/download.png" alt="Image" class="img-fluid mr-3 mt-1" style="width: 45px;">
                                                    <div class="media-body">

                                                        <?php
                                                        // Example email from database
                                                        $email = $all['user_email'];

                                                        // Masking the email: show the first 3 characters, then 4 asterisks, and keep the domain part
                                                        $maskedEmail = preg_replace('/(?<=.{3}).(?=.*@)/', '*', $email);
                                                        ?>

                                                        <h6><?= $maskedEmail ?> <small> - <i><?= $all['created_at'] ?></i></small></h6>
                                                        <?php
                                                        $rating =  $all['rating']; // Replace with your actual database query to get the rating

                                                        echo '<div class="rating-stars">';
                                                        for ($i = 1; $i <= 5; $i++) {
                                                            // Add a class if the star rating is less than or equal to the actual rating
                                                            $class = ($i <= $rating) ? 'filled' : '';
                                                            echo '<span class="star2 ' . $class . '" data-rating="' . $i . '">★</span>';
                                                        }
                                                        echo '</div>';
                                                        ?>
                                                        <p><?= $all['review_text'] ?></p>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h4 class="mb-4">Leave a review</h4>
                                    <small style="font-size: 20px;">Your email address will not be published. Required fields are marked *</small>
                                    <div class="d-flex my-3">

                                        <form action="detail.php" method="POST">

                                            <small class="pt-2" style="font-size: 20px;">Your Rating * </small>
                                            <div class="star-rating">
                                                <span class="star" data-rating="1">★</span>
                                                <span class="star" data-rating="2">★</span>
                                                <span class="star" data-rating="3">★</span>
                                                <span class="star" data-rating="4">★</span>
                                                <span class="star" data-rating="5">★</span>
                                                <input type="hidden" name="rating" id="rating" value="0">
                                            </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="message" style="font-size: 20px;">Your Review *</label>
                                        <textarea id="message" cols="30" rows="5" class="form-control" name="comment"></textarea>
                                    </div>
                                    <div class="form-group mb-0">
                                        <input type="submit" value="Leave Your Review" name="review" class="btn btn-primary px-3 bg-danger">
                                    </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Shop Detail End -->


    <!-- Products Start -->
    <div class="container-fluid py-5">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class=" pr-3">You May Also Like</span></h2>
        <div class="row px-xl-5">
            <?php if (count($items) == 0): ?>
                <p class="text-center w-100">No featured products available.</p>
            <?php else: ?>
                <?php foreach ($items as $item): ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                        <div class="product-item bg-light mb-4">
                            <div class="product-img position-relative overflow-hidden">
                                <img class="img-fluid w-100 h-100" src="../../Project/dashboards/assets/products_img/<?php echo $item['watch_img']; ?>" alt="<?php echo $item['watch_name']; ?>">
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
                                <a class="h6 text-decoration-none text-truncate" href=""><?php echo $item['watch_name']; ?></a>
                                <div class="d-flex align-items-center justify-content-center mt-2">
                                    <h5><?php echo $item['watch_price']; ?></h5>
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


    <?php include("../widgets/footer.php"); ?>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-primary bg-danger text-white btn-minus back-to-top"><i class="fa fa-angle-double-up"></i></a>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="../lib/easing/easing.min.js"></script>
    <script src="../lib/owlcarousel/owl.carousel.min.js"></script>


    <!-- Contact Javascript File -->
    <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script>

    <!-- Template Javascript -->
    <script src="../js/main.js"></script>

    <script>
        const stars = document.querySelectorAll('.star');
        const ratingInput = document.getElementById('rating');

        // Set default rating to 5
        const defaultRating = 5;
        ratingInput.value = defaultRating;

        // Apply 'active' class to stars for the default rating
        stars.forEach(star => {
            if (star.getAttribute('data-rating') <= defaultRating) {
                star.classList.add('active');
            }

            // Add click event listener to update rating based on user click
            star.addEventListener('click', () => {
                const rating = star.getAttribute('data-rating');
                ratingInput.value = rating;

                // Set active class for clicked star and all previous ones
                stars.forEach(s => {
                    s.classList.remove('active');
                    if (s.getAttribute('data-rating') <= rating) {
                        s.classList.add('active');
                    }
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const maxQuantity = <?php echo $watches['quantity']; ?>; // Value from PHP
            const quantityInput = document.getElementById('quantity-input');
            const btnPlus = document.querySelector('.btn-plus');
            const btnMinus = document.querySelector('.btn-minus');

            btnPlus.addEventListener('click', function() {
                let currentValue = parseInt(quantityInput.value);
                if (currentValue < maxQuantity) {
                    quantityInput.value = currentValue + 1;
                } else {
                    quantityInput.value = maxQuantity;
                }
            });

            btnMinus.addEventListener('click', function() {
                let currentValue = parseInt(quantityInput.value);
                if (currentValue > 1) {
                    quantityInput.value = currentValue - 1;
                }
            });
        });
    </script>

    <?php if ($updateMessage == "error"): ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'You must login first',
                text: 'Please try again.',
                timer: 2000,
                showConfirmButton: false
            });
        </script>
    <?php endif; ?>
    <script src="./addToCart.js"> </script>

</body>

</html>