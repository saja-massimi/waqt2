<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 " id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href="#" >
        <img src="../assets/logo/logo.png" class="navbar-brand-img h-100" alt="main_logo">
        <span class="ms-1 font-weight-bold">WAQT</span>
      </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main" style="height:auto;">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link <?php echo ($parm == 'dashboard') ? 'active' : ''; ?>" href="../pages/dashboard.php">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
               <i  class="aside_li fas fa-gauge"></i>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
        <a class="nav-link <?php echo ($parm == 'users') ? 'active' : ''; ?>" href="../pages/users.php">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <i  class="aside_li fas fa-users"></i>
            </div>
            <span class="nav-link-text ms-1">Users</span>
          </a>
        </li>

        <li class="nav-item">
        <a class="nav-link <?php echo ($parm == 'products') ? 'active' : ''; ?>" href="../pages/products.php">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <i  class="aside_li fas fa-box"></i>
            </div>
            <span class="nav-link-text ms-1">Products</span>
          </a>
        </li>

        <li class="nav-item">
        <a class="nav-link <?php echo ($parm == 'orders') ? 'active' : ''; ?>" href="../pages/orders.php">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <i  class="aside_li fas fa-clipboard-list"></i>
            </div>
            <span class="nav-link-text ms-1">Orders</span>
          </a>
        </li>
        <li class="nav-item">
        <a class="nav-link <?php echo ($parm == 'coupons') ? 'active' : ''; ?>" href="../pages/coupon.php">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <i  class="aside_li fas fa-tags"></i>
            </div>
            <span class="nav-link-text ms-1">Coupons</span>
          </a>
        </li>



        <li class="nav-item">
        <a class="nav-link <?php echo ($parm == 'brands') ? 'active' : ''; ?>" href="../pages/brands.php">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <i  class="aside_li fas fa-tags"></i>
            </div>
            <span class="nav-link-text ms-1">Brands</span>
          </a>
        </li>
   

        <li class="nav-item">
        <a class="nav-link <?php echo ($parm == 'reviews') ? 'active' : ''; ?>" href="../pages/review.php">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <i  class="aside_li fas fa-tags"></i>
            </div>
            <span class="nav-link-text ms-1">Reviews</span>
          </a>
        </li>
   
     
    
        
        
    
      </ul>
    </div>
    <div class="sidenav-footer mx-3 ">
      <div class="card card-background shadow-none card-background-mask-secondary" id="sidenavCard">
        <div class="full-background" style="background-image: url('../assets/img/curved-images/white-curved.jpg')"></div>
        <div class="card-body text-start p-3 w-100">
          
          <div class="docs-info">
            <h6 class="text-white up mb-0"><?= $user_name ?></h6>
            <p class="text-xs font-weight-bold"><?= $user_role ?></p>
            <a href="../pages/profile.php" target="_blank" class="btn btn-white btn-sm w-100 mb-0">Profile</a>
          </div>
        </div>
      </div>
      <a class="btn bg-gradient-primary mt-3 w-100" href="./functions/logout.php">Log out</a>

    </div>
  </aside>