<!DOCTYPE html>
<html lang="en">
<?php
session_start();
require_once '../user_pages/models/Dbh.php';
require_once '../user_pages/models/cartModel.php';
include('../widgets/head.php');
include('dbconnection.php');

if (isset($_SESSION['user'])) {
  $user_id = $_SESSION['user'];

  $query = "SELECT COUNT(*) AS total_number FROM `wishlist` WHERE `user_id`=:user_id";
  $statment = $dbconnection->prepare($query);
  $statment->bindParam(':user_id', $user_id, PDO::PARAM_INT);
  $statment->execute();
  $result = $statment->fetch(PDO::FETCH_ASSOC);
  $cartModel = new cartModel();

  $cartID = $cartModel->getCartId($_SESSION['user']);
  $cartTotal = $cartModel->getCartItemsCount($cartID);
}







?>


<style>
  @import url("https://fonts.googleapis.com/css?family=Josefin+Sans:200,300,400,500,600,700|Roboto:100,300,400,500,700&display=swap");

  * {
    font-family: "Josefin Sans", sans-serif;
  }

  .landing-section {
    position: relative;
    height: 90vh;
    width: 100%;
    overflow: hidden;
    top: -29px;

  }

  #landing-video {
    position: absolute;
    top: 30%;
    left: 50%;
    min-width: 100%;
    min-height: 100%;
    transform: translate(-50%, -50%);
    z-index: 1;
    object-fit: cover;
  }

  .overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.4);
    z-index: 2;
  }

  .landing-content {
    position: relative;
    z-index: 3;
    text-align: center;
    color: white;
    top: 50%;
    transform: translateY(-50%);
    padding: 0 15px;
  }

  .landing-content h1 {
    font-size: 2.5rem;
    font-weight: bold;
    margin-bottom: 20px;
  }

  .landing-content p {
    font-size: 1rem;
    margin-bottom: 30px;
  }


  @media (max-width: 768px) {
    .landing-content h1 {
      font-size: 2.5rem;
    }

    .landing-content p {
      font-size: 1.2rem;
    }
  }
</style>



<body>
  <!-- Navbar Start -->
  <div class="container-fluid bg-white text-dark mb-30">
    <div class="row px-xl-5 text-dark">
      <div class="col-lg-12">
        <nav id="top_page" class="navbar navbar-expand-lg navbar-light bg-light py-3 py-lg-0">
          <a class="navbar-brand" href="../user_pages/index.php">
            <img src="../img/logo1.png" width="50" height="50" class="d-inline" alt="logo">
            WAQT
          </a>

          <!-- Toggler Button for Mobile Menu -->
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
          </button>

          <!-- Navbar Collapse -->
          <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav mx-auto">
              <a href="../user_pages/index.php" class="nav-item nav-link active text-dark">Home</a>
              <a href="../user_pages/products.php" class="nav-item nav-link text-dark">Products</a>
              <a href="../user_pages/index.php#categories" class="nav-item nav-link text-dark">Categories</a>
              <a href="contact_us.php" class="nav-item nav-link text-dark">Contact</a>
              <a href="aboutus.php" class="nav-item nav-link text-dark">About Us</a>
            </div>

            <!-- Right-side Icons -->
            <div class="navbar-nav ms-auto d-flex align-items-center">
              <a href="<?= isset($_SESSION['user']) ? '../user_pages/wishlist.php' : '../auth/index.html' ?>" class="btn">
                <i class="fas fa-heart text-dark"></i>
                <span class="badge bg-secondary rounded-circle"><?= $result['total_number'] ?? 0 ?></span>
              </a>
              <a href="<?= isset($_SESSION['user']) ? 'cart.php' : '../auth/index.html' ?>" class="btn mx-2">
                <i class="fas fa-shopping-cart text-dark"></i>
                <span class="badge bg-secondary rounded-circle"><?= isset($_SESSION['user']) ? $cartTotal['count'] : 0 ?></span>
              </a>
              <?= isset($_SESSION['user']) ?
                '<a href="../user_pages/customer_profile.php" class="btn">
                  <i class="fas fa-user text-dark"></i>
                </a>
                <a href="../user_pages/logout.php" class="btn">
                  <i class="fas fa-sign-out-alt text-dark"></i>
                </a>' :
                '<a href="../auth/index.html" class="nav-item nav-link">Sign In | Log In</a>'
              ?>
            </div>
          </div>
        </nav>
      </div>
    </div>
  </div>
  <!-- Navbar End -->

  <!-- Scripts -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    $(document).ready(function() {
      function toggleNavbarMethod() {
        if ($(window).width() > 992) {
          $('.navbar .dropdown').on('mouseover', function() {
            $(this).find('.dropdown-toggle').dropdown('show');
          }).on('mouseout', function() {
            $(this).find('.dropdown-toggle').dropdown('hide');
          });
        } else {
          $('.navbar .dropdown').off('mouseover').off('mouseout');
        }
      }
      toggleNavbarMethod();
      $(window).resize(toggleNavbarMethod);
    });
  </script>
</body>

</html>