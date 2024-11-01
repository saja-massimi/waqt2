<?php 
include("../widgets/navbar.php");
include("../widgets/head.php");
include('dbconnection.php');

if( isset($_POST['watch_id'])){
    $_SESSION['watch_id'] = $_POST['watch_id']; // Store watch_id in session
    $id= $_SESSION['watch_id'];
    echo $id;
}
$query="SELECT  `watch_name`, `watch_description`, `watch_img`, `watch_price`, `watch_brand`,`watch_model`, `watch_gender`, `strap_material`, `quantity` FROM watches WHERE `watch_id`=:id";

$statement=$dbconnection->prepare($query);
$statement->bindParam(':id',$_SESSION['watch_id'],PDO::PARAM_INT);
$statement->execute();
$watches=$statement->fetch(PDO::FETCH_ASSOC);
//print_r($watches);


$query = "SELECT watch_id, watch_name, watch_description, watch_img, watch_price, watch_brand, watch_model, watch_gender FROM watches ORDER BY RAND() LIMIT 4";


$statment=$dbconnection->prepare($query);
$statment->execute();
$items=$statment->fetchAll(PDO::FETCH_ASSOC);
//print_r($items);

if(isset($_POST['review'])){
    $id= $_SESSION['watch_id'];

    $rating=$_POST['rating'];
    $comment=$_POST['comment'];
    $email=$_POST['email'];
    echo "$rating";
    echo "$comment";
    echo "$email";

    $query="INSERT INTO `reviews`( `user_email`,`watch_id`, `rating`, `review_text`) VALUES (:user_email,:watch_id, :rating, :review_text) ";
    $stat=$dbconnection->prepare($query);
            
            $data=[
            'user_email'=> $email,
            'watch_id'=> $id,
            'rating'=> $rating,
            'review_text'=> $comment
            ];
    
            try {
                $stat->execute($data);
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }


    }

$query="SELECT `user_email`,`rating`,`review_text`,`created_at` FROM `reviews` WHERE `watch_id`=:watch_id";
$statement = $dbconnection->prepare($query);
$statement->bindParam(':watch_id', $_SESSION['watch_id'], PDO::PARAM_INT);
$statement->execute();
$data = $statement->fetchAll(PDO::FETCH_ASSOC);

$query = "SELECT COUNT(*) AS total_number FROM `reviews` WHERE `watch_id`=:watch_id";
$statt = $dbconnection->prepare($query);
$statt->bindParam(':watch_id', $_SESSION['watch_id'], PDO::PARAM_INT);
$statt->execute();
$count=$statt->fetch(PDO::FETCH_ASSOC);

$query = "SELECT avg(rating) AS avg_number FROM `reviews` WHERE `watch_id`=:watch_id";
$statt = $dbconnection->prepare($query);
$statt->bindParam(':watch_id', $_SESSION['watch_id'], PDO::PARAM_INT);
$statt->execute();
$avg=$statt->fetch(PDO::FETCH_ASSOC);

?>

<style>
    
.star {
  font-size: 30px;
  cursor: pointer;
  color: #ccc;
}

.star.active {
  color: #FFD700; /* Gold color */
}

.star.filled {
    color: #FFD700;  /* Color for filled stars (e.g., gold) */
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
                            <img class='m-auto' src='{$watches['watch_img']}' alt='{$watches['watch_name']}' style='max-width: 100%; height: auto;'>
                            "; ?>
                        
                    </div>
                </div>
            </div>

            <div class="col-lg-7 h-auto mb-30">
                <div class="h-100 bg-light p-30">
                    <h3 style="font-size: 30px;"><?= $watches['watch_name']?></h3>
                    <div class="d-flex mb-3">
                    <?php
                        $rating =  $avg['avg_number']; // Replace with your actual database query to get the rating

                        echo '<div class="rating-stars">';
                        for ($i = 1; $i <= 5; $i++) {
                            // Add a class if the star rating is less than or equal to the actual rating
                            $class = ($i <= $rating) ? 'filled' : '';
                            echo '<span class="star ' . $class . '" data-rating="' . $i . '">★</span>';
                        }
                        echo '</div>';
                        ?>

                    <small class="pt-2 pl-2" style="font-size: 20px;">(<?= $count['total_number']?> Reviews)</small>
                    </div>
                    <h3 class="font-weight-semi-bold mb-4" style="font-size: 30px;"><?= $watches['watch_price']?></h3>
                    <p class="mb-4" style="font-size: 24px;"><b>Description: </b><?= $watches['watch_description'] ?>
                        </p>
                        <p class="mb-4" style="font-size: 24px;"><b>Brand:</b> <?= $watches['watch_brand'] ?></p>
                    <p class="mb-4" style="font-size: 24px;"><b>Model:</b> <?= $watches['watch_model'] ?></p>
                    <p class="mb-4" style="font-size: 24px;"><b>Gender:</b> <?= $watches['watch_gender'] ?></p>
                    <p class="mb-4" style="font-size: 24px;"><b>Material: </b><?= $watches['strap_material'] ?></p>

                    <div class="d-flex align-items-center mb-4 pt-2">
                        <div class="input-group quantity mr-3" style="width: 130px;">
                            <div class="input-group-btn">
                                <button class="btn btn-primary bg-danger text-white btn-minus">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>
                            <input type="text" class="form-control bg-secondary border-0 text-center" value="1">
                            <div class="input-group-btn">
                                <button class="btn btn-primary bg-danger text-white btn-plus">
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
        <div class="row px-xl-5">
            <div class="col">
                <div class="bg-light p-30">
                    <div class="nav nav-tabs mb-4">
                        <a class="nav-item nav-link text-dark active" data-toggle="tab" href="#tab-pane-1">Description</a>
                        <a class="nav-item nav-link text-dark" data-toggle="tab" href="#tab-pane-2">Information</a>
                        <a class="nav-item nav-link text-dark" data-toggle="tab" href="#tab-pane-3">Reviews (<?= $count['total_number']?>)</a>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="tab-pane-1">
                            <h4 class="mb-3">Product Description</h4>
                            <p style="font-size: 24px;"><?= $watches['watch_description'] ?></p>
                            
                        </div>
                        <div class="tab-pane fade" id="tab-pane-2">
                            <h4 class="mb-3">Additional Information</h4>
                            <p>Eos no lorem eirmod diam diam, eos elitr et gubergren diam sea. Consetetur vero aliquyam invidunt duo dolores et duo sit. Vero diam ea vero et dolore rebum, dolor rebum eirmod consetetur invidunt sed sed et, lorem duo et eos elitr, sadipscing kasd ipsum rebum diam. Dolore diam stet rebum sed tempor kasd eirmod. Takimata kasd ipsum accusam sadipscing, eos dolores sit no ut diam consetetur duo justo est, sit sanctus diam tempor aliquyam eirmod nonumy rebum dolor accusam, ipsum kasd eos consetetur at sit rebum, diam kasd invidunt tempor lorem, ipsum lorem elitr sanctus eirmod takimata dolor ea invidunt.</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item px-0">
                                            Sit erat duo lorem duo ea consetetur, et eirmod takimata.
                                        </li>
                                        <li class="list-group-item px-0">
                                            Amet kasd gubergren sit sanctus et lorem eos sadipscing at.
                                        </li>
                                        <li class="list-group-item px-0">
                                            Duo amet accusam eirmod nonumy stet et et stet eirmod.
                                        </li>
                                        <li class="list-group-item px-0">
                                            Takimata ea clita labore amet ipsum erat justo voluptua. Nonumy.
                                        </li>
                                      </ul> 
                                </div>
                                <div class="col-md-6">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item px-0">
                                            Sit erat duo lorem duo ea consetetur, et eirmod takimata.
                                        </li>
                                        <li class="list-group-item px-0">
                                            Amet kasd gubergren sit sanctus et lorem eos sadipscing at.
                                        </li>
                                        <li class="list-group-item px-0">
                                            Duo amet accusam eirmod nonumy stet et et stet eirmod.
                                        </li>
                                        <li class="list-group-item px-0">
                                            Takimata ea clita labore amet ipsum erat justo voluptua. Nonumy.
                                        </li>
                                      </ul> 
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab-pane-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="mb-4"><?= $count['total_number']?> review for "Product Name"</h4>
                                    <?php if (count($data) == 0): ?>
                                            <p class="text-center w-100">No featured products available.</p>
                                            <?php else: ?>
                                            <?php foreach ($data as $all): ?>
                                    <div class="media mb-4">
                                        <img src="uploads/download.png" alt="Image" class="img-fluid mr-3 mt-1" style="width: 45px;">
                                        <div class="media-body">
                                        
                                            <h6><?= $all['user_email']?> <small> - <i><?= $all['created_at']?></i></small></h6>
                                            <?php
                                                $rating =  $all['rating']; // Replace with your actual database query to get the rating

                                                echo '<div class="rating-stars">';
                                                for ($i = 1; $i <= 5; $i++) {
                                                    // Add a class if the star rating is less than or equal to the actual rating
                                                    $class = ($i <= $rating) ? 'filled' : '';
                                                    echo '<span class="star ' . $class . '" data-rating="' . $i . '">★</span>';
                                                }
                                                echo '</div>';
                                                ?>
                                            <p><?= $all['review_text']?></p>
                                            </div>
                                    </div>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-6">
                                    <h4 class="mb-4">Leave a review</h4>
                                    <small style="font-size: 20px;">Your email address will not be published. Required fields are marked *</small>
                                    <div class="d-flex my-3">

                                    <form action="detail.php" method="POST">

                                    <small class="pt-2" style="font-size: 20px;">Your Rating *  </small>
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
                                        <div class="form-group">
                                            <label for="email" style="font-size: 20px;">Your Email *</label>
                                            <input type="email" class="form-control" id="email" name="email">
                                        </div>
                                        <div class="form-group mb-0">
                                            <input type="submit" value="Leave Your Review" name="review" class="btn btn-primary px-3">
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

<script>
const stars = document.querySelectorAll('.star');
const ratingInput = document.getElementById('rating');

stars.forEach(star => {
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
</body>

</html>