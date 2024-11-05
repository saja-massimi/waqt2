<?php include("../widgets/navbar.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Us</title>
  <link href="image/logo1.png" type="imge/x-icon" rel="icon">
  <link href="../css/style.css" rel="stylesheet">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<style>
  @import url("https://fonts.googleapis.com/css?family=Josefin+Sans:200,300,400,500,600,700|Roboto:100,300,400,500,700&display=swap");


  :root {
    --Color1: #16161a;
    --Color2: #ff2020;
    --Color3: #0b1c39;
    --BgColor1: #ffffff;
    --BgColor2: #f0f0f2;
  }

  .container {
    max-width: 1200px;
    margin: 0 auto;
  }

  .About {

    padding: 78px 15px;
    background-color: var(--Color3);
    height: 70vh;
    position: relative;
    top: -30px;
  }

  .About img {
    max-width: 100%;
    height: auto;
  }

  .About-text {
    color: #ffffff;
  }

  .About-text h1 {
    font-size: 2.5rem;
    text-transform: capitalize;
    margin-bottom: 20px;
    align-items: center;
    text-align: center;
  }

  .About-text p {
    letter-spacing: 1px;
    line-height: 1.7;
    font-size: 1rem;
    margin-bottom: 30px;
  }

  .About-text .btn {
    margin: 0 auto;
    display: block;
    text-align: center;
  }

  #Contact-a {
    background: var(--BgColor1);
    color: #000;
    text-decoration: none;
    border: 2px solid transparent;
    font-weight: bold;
    padding: 10px 20px;
    margin: auto;
    border-radius: 30px;
    transition: 0.5s ease;
    align-items: center;
    justify-content: center;
  }

  #Contact-a:hover {
    background-color: transparent;
    border: 2px solid #dc3545;
    transform: scale(1.1);
    color: #fff;
  }

  #our-accounts .card {
    transition: 0.5s ease;

  }

  #our-accounts .card:hover {
    transform: scale(1.05);
  }

  span {
    color: #dc3545;
    font-size: 1.1rem;
    font-weight: 600;
  }

  .social-icons a {
    color: #0f1115;
    font-size: 1.5rem;
    margin-right: 15px;
    transition: 0.5s ease;
  }

  .social-icons a:hover {
    color: #f60a0a;
    transform: scale(1.1);
  }

  .col-md-2 {
    width: 20%;

  }

  .container {
    width: 100%;
  }

  @media (max-width: 768px) {
    .About-text h1 {
      font-size: 2rem;
    }

    .About-text p {
      font-size: 0.9rem;
    }

    #our-accounts .col-md-2 {
      width: 100%;
    }

    #Contact-a {
      padding: 8px 15px;
      font-size: 0.9rem;
    }
  }

  @media (max-width: 768px) {
    .About-text h1 {
      font-size: 1.75rem;
    }

    .About-text p {
      font-size: 0.95rem;
    }

    #Contact-a {
      padding: 10px 15px;
      font-size: 0.9rem;
    }
  }
</style>
</head>

<body>
  <!-- About Section -->
  <section class="About">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-6 mb-4 mb-md-0">
          <img src="../img/logo1.png" alt="" class="img-fluid">
        </div>
        <div class="col-md-6">
          <div class="About-text">
            <h1>About Us</h1>
            <p><span>Waqt</span> offers a carefully curated selection of watches that combine classic craftsmanship with modern design. We partner with trusted brands and artisans to ensure our watches are elegant, durable, and high-quality. Customer satisfaction is our priority, with personalized service from choosing the perfect watch to after-sale support. At <span>Waqt</span>, we’re dedicated to helping you make the most of your time.
            </p>
            <a href="contact_us.php" id="Contact-a" class="btn d-flex justify-content-center w-25">Contact Us</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Our Accounts -->
  <section id="our-accounts" class="container py-4 w-100 ">
    <div class="row">
      <!-- First Card -->
      <div class="col-md-2 mb-4 ">
        <div class="card h-100">
          <div class="card-body">
            <h5 class="card-title">Sohiub Bataineh</h5>
            <p class="card-text">Software Engineer <br><span>Product Owner</span></p>
            <div class="social-icons">
              <a href="https://github.com/Sohiub-Bataina" target="_blank" class="card-link"><i class="fa-brands fa-square-github"></i></a>
              <a href="https://www.linkedin.com/in/sohiub-bataineh" target="_blank" class="card-link"><i class="fa-brands fa-linkedin"></i></a>
            </div>
          </div>
        </div>
      </div>

      <!-- Second Card -->
      <div class="col-md-2 mb-4">
        <div class="card h-100">
          <div class="card-body">
            <h5 class="card-title">Saja Al-Massimi</h5>
            <p class="card-text">Software Engineer <br><span>Scrum Master</span></p>
            <div class="social-icons">
              <a href="https://github.com/saja-massimi" target="_blank" class="card-link"><i class="fa-brands fa-square-github"></i></a>
              <a href="https://www.linkedin.com/in/saja-al-massimi/" target="_blank" class="card-link"><i class="fa-brands fa-linkedin"></i></a>
            </div>
          </div>
        </div>
      </div>

      <!-- Third Card -->
      <div class="col-md-2 mb-4">
        <div class="card h-100">
          <div class="card-body">
            <h5 class="card-title">Dina Nafez</h5>
            <p class="card-text">Software Engineer <br><span>Full Stack</span></p>
            <div class="social-icons">
              <a href="https://github.com/Dinanafez" class="card-link" target="_blank"><i class="fa-brands fa-square-github"></i></a>
              <a href="https://www.linkedin.com/in/dina-nafez-al-akhras-b477b1246/" class="card-link" target="_blank"><i class="fa-brands fa-linkedin"></i></a>
            </div>
          </div>
        </div>
      </div>

      <!-- Additional Cards -->
      <div class="col-md-2 mb-4">
        <div class="card h-100">
          <div class="card-body">
            <h5 class="card-title">Omar abed</h5>
            <p class="card-text">Software Engineer <br><span>Full Stack</span></p>
            <div class="social-icons">
              <a href="https://github.com/OmarAbed16" target="_blank" class="card-link"><i class="fa-brands fa-square-github"></i></a>
              <a href="https://www.linkedin.com/in/omarabed-/" class="card-link" target="_blank"><i class="fa-brands fa-linkedin"></i></a>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-2 mb-4 ">
        <div class="card h-100">
          <div class="card-body">
            <h5 class="card-title">Asma Hisham</h5>
            <p class="card-text">Software Engineer <br><span>Full Stack</span></p>
            <div class="social-icons">
              <a href="https://github.com/asma-marar" class="card-link" target="_blank"><i class="fa-brands fa-square-github"></i></a>
              <a href="https://www.linkedin.com/in/asma-marar-5a3aba197/" class="card-link" target="_blank"><i class="fa-brands fa-linkedin"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Bootstrap JS -->
  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


  <?php include("../widgets/footer.php"); ?>
</body>


</html>