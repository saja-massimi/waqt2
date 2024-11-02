<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/logo/logo.png">
  <title>
    WAQT - Dashboard
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />

  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css/soft-ui-dashboard.css?v=1.0.7" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">


  <link rel="stylesheet" href="//cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">
  

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
  .active .aside_li{
    font-size:1rem !important;color:#fff !important;
  }
  .aside_li{
    font-size:1rem !important;color:#3A416F !important;
  }
</style>
 </head>

 <?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ../../auth-login');
    exit();
} else {
  $account_user = $_SESSION['user'];


  // Fetch user role from the database
  $start_page = $pdo->prepare("SELECT * FROM users WHERE user_id = :email");
  $start_page->bindParam(':email', $account_user);
  $start_page->execute();

  $start_user = $start_page->fetch(PDO::FETCH_ASSOC);

  // Check if the user exists and fetch the role

      $user_role = $start_user['role'] ?? "";
      $user_name = $start_user['user_name'] ?? "";
      $user_email = $start_user['user_email'] ?? "";
      $user_phoneNum = $start_user['user_phoneNum'] ?? "";
      $user_address = $start_user['user_address'] ?? "";
      $user_createdDate = $start_user['user_createdDate'] ?? "";

   
}

?>