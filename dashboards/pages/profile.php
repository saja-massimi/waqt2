<?php
include("./DB/conn.php");
include("./functions/getContactUs.php");
include("./components/header.php");
?>
<body class="g-sidenav-show  bg-gray-100">
<?php
$parm = 'profile';
include("./components/aside.php");

?>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <?php
$nav = 'Profile';
include("./components/nav.php");
?>
    <!-- End Navbar -->
    <div class="container-fluid">
      <div class="page-header min-height-300 border-radius-xl mt-4" style="background-image: url('../assets/img/curved-images/curved0.jpg'); background-position-y: 50%;">
        <span class="mask bg-gradient-primary opacity-6"></span>
      </div>
      <div class="card card-body blur shadow-blur mx-4 mt-n6 overflow-hidden">
        <div class="row gx-4">
          <div class="col-auto">
            <div class="avatar avatar-xl position-relative">
            
              <i style="font-size:2rem;"class="fas fa-user text-dark" ></i>
            </div>
          </div>
          <div class="col-auto my-auto">
            <div class="h-100">
              <h5 class="mb-1">
                <?=$user_name?>
              </h5>
              <p class="mb-0 font-weight-bold text-sm">
              <?=$user_role?>
              </p>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
          
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid py-4">
      <div class="row">
      <div class="col-12 col-xl-6 mt-3">
          <div class="card h-100">
            <div class="card-header pb-0 p-3">
              <div class="row">
                <div class="col-md-8 d-flex align-items-center">
                  <h6 class="mb-0">Profile Information</h6>
                </div>
                <div class="col-md-4 text-end">
                  <a>
                    <i class="fas fa-user-edit text-secondary text-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Profile"></i>
                  </a>
                </div>
              </div>
            </div>
            <div class="card-body p-3">
              
              
              <ul class="list-group">
                <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">Full Name:</strong> &nbsp; <?=  $user_name?></li>
                <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Email:</strong> &nbsp; <?=  $user_email?></li>
                <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Mobile:</strong> &nbsp; <?=  $user_phoneNum?></li>
                <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">governorate:</strong> &nbsp; <?=  $user_address ?></li>
                <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Date Create:</strong> &nbsp; <?=  $user_createdDate ?></li>
              <hr style="background:#344747;">

              <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">Old Password:</strong> &nbsp; <input id="old_pass" type='password' placeholder="Old Password"></li>
              <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">New Password:</strong> &nbsp; <input id="new_pass" type='password' placeholder="New Password"></li>
              <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">Re- Password:</strong> &nbsp; <input id="match_pass" type='password' placeholder=" Confirm Password"></li>
              <li class="list-group-item border-0 ps-0 pt-0 text-sm" id="show_error" style="color:red;"></li>
              <li class="list-group-item border-0 ps-0 pt-0 text-sm">
                


              <div class="nav-wrapper position-relative end-0">
              <ul class="nav nav-pills nav-fill p-1 bg-transparent" role="tablist">
               
                <li class="nav-item">
                  <button onclick="update_password('<?= $user_email?>');" class="nav-link mb-0 px-0 py-1 " data-bs-toggle="tab"  role="tab" aria-selected="false">
                  <li style="cursor:pointer;"><i class="fas fa-cloud-arrow-up"></i><span class="ms-1">Save Changes</span></li>
                  
                  </button>
                </li>
              </ul>
            </div>



              </li>

              </ul>
            </div>
          </div>
        </div>


        <?php
$search=$_POST["search"] ?? "";
$tableRenderer = new contactTable($pdo, 'contact_us', $search);
echo $tableRenderer->renderTable();
?>
     
      
    </div>
  </div>
  
  <?php
 include("./scripts/aside_show_hide.php");
 include("./scripts/script_password.php");
 ?>
 </body>

</html>