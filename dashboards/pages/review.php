<?php
include("./DB/conn.php");
include("./functions/getReviews.php"); 
include("./components/header.php");
?>
<body class="g-sidenav-show  bg-gray-100">
<?php
$parm = 'reviews'; 
include("./components/aside.php");
?>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <?php
$nav = 'Reviews';
include("./components/nav.php");
?>
  
    <div class="container-fluid py-4">
    <?php
    $searchTerm = $_POST["search"] ?? "";

   
    echo "<b>Your search: </b>" . $searchTerm . "<br><br>";
    
    
    $reviewTableRenderer = new ReviewTable($pdo, 'reviews', $searchTerm);
    echo $reviewTableRenderer->renderTable();
    ?>
    </div>
  </main>
  <?php
include("./scripts/script_delete_review.php");
include("./scripts/aside_show_hide.php");
include("./scripts/sweetalert.php");
?>
 </body>
</html>
