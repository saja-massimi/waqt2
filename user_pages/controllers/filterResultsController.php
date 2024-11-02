<!DOCTYPE html>
<html lang="en">

<head>

</head>

<body>


    <?php
    include_once '../models/Dbh.php';
    $db = new Dbh();
    $connection = $db->connect();

    $totalWatches = $connection->query("SELECT COUNT(*) FROM watches")->fetchColumn();
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $itemsPerPage = 6;
    $offset = ($page - 1) * $itemsPerPage;

    $query = "SELECT * FROM watches WHERE watch_price <= ?";
    $params = [isset($_GET['priceRange']) ? (int)$_GET['priceRange'] : 1000];

    // Handle category filtering
    $categories = isset($_GET['categories']) ? explode(',', $_GET['categories']) : [];
    if (!in_array('all', $categories) && !empty($categories)) {
        $query .= " AND watch_gender IN (" . implode(', ', array_fill(0, count($categories), '?')) . ")";
        $params = array_merge($params, $categories);
    }

    // Handle brand filtering
    $brands = isset($_GET['brands']) ? explode(',', $_GET['brands']) : [];
    if (!in_array('all', $brands) && !empty($brands)) {
        $query .= " AND watch_brand IN (" . implode(', ', array_fill(0, count($brands), '?')) . ")";
        $params = array_merge($params, $brands);
    }

    // Handle strap material filtering
    $materials = isset($_GET['materials']) ? explode(',', $_GET['materials']) : [];
    if (!in_array('all', $materials) && !empty($materials)) {
        $query .= " AND strap_material IN (" . implode(', ', array_fill(0, count($materials), '?')) . ")";
        $params = array_merge($params, $materials);
    }
    $search = isset($_GET['search_result']) ? $_GET['search_result'] : "";

    if (!empty($search)) {
        $searchParam = '%' . $search . '%';
        $query .= " AND watch_name LIKE '$searchParam' ";
    }
    $sortType = isset($_GET['sort']) ? $_GET['sort'] : '';
    switch ($sortType) {
        case 'latest':
            $query .= " ORDER BY created_at DESC";
            break;
        case 'oldest':
            $query .= " ORDER BY created_at ASC";
            break;
        case 'high':
            $query .= " ORDER BY watch_price DESC";
            break;
        case 'low':
            $query .= " ORDER BY watch_price ASC";
            break;
        default:
            $query .= " ORDER BY watch_name ASC";
            break;
    }

    $query .= " LIMIT $offset, $itemsPerPage";

    $totalItems = $totalWatches;
    $totalPages = ceil($totalItems / $itemsPerPage);
    
    $stmt = $connection->prepare($query);

    $stmt->execute($params);
    $watches = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $cat = $_GET['category'] ?? null;
    $view = $_GET['view'] ?? null;
    ?>


    <?php foreach ($watches as $watch): ?>
        <div class="col-lg-<?php echo $view == 1 ? '6' : '4'; ?> col-md-6 col-sm-6 pb-1">
            <div class="<?php echo $view == 1 ? 'row' : ''; ?> product-item bg-light mb-4">
                <div class="<?php echo $view == 1 ? 'col-lg-6' : ''; ?> product-img position-relative overflow-hidden">
                    <img class="img-fluid w-80" src="<?= htmlspecialchars($watch['watch_img']); ?>" alt="<?php echo htmlspecialchars($watch['watch_name']); ?>">
                    <div class="product-action">

                        <a onclick="add_cart(<?= htmlspecialchars($watch['watch_id']) ?>);" class="btn btn-outline-dark btn-square add-to-cart" data-id="<?= htmlspecialchars($watch['watch_id']) ?>">
                            <i class="fa fa-shopping-cart"></i>
                        </a>

                        <a class="btn btn-outline-dark btn-square" onclick="addWishlist(<?= htmlspecialchars($watch['watch_id']) ?>);" data-id="<?= htmlspecialchars($watch['watch_id']) ?>"><i class="far fa-heart"></i></a>


                        <form action="detail.php" method="POST" style="display:inline;position:relative">
                            <a href="" class="btn btn-outline-dark btn-square"> <i class="fa fa-search"></i>
                            </a>
                            <input type="hidden" name="watch_id" value="<?= $watch['watch_id'] ?>">
                            <button type="submit" style="border:none; background:none;display:hidden;position:absolute;top:0;left:0;width:100%;height:100%;opacity:0;">
                            </button>
                        </form>



                    </div>
                </div>
                <div class="<?php echo $view == 1 ? 'col-lg-6' : ''; ?> text-center py-4">
                    <a class="h6 text-decoration-none text-truncate" href="#"><?php echo htmlspecialchars($watch['watch_name']); ?></a>
                    <div class="d-flex align-items-center justify-content-center mt-2">
                        <h5><?php echo htmlspecialchars($watch['watch_price']); ?> JOD</h5>
                        <h6 class="text-muted ml-2"><del><?php echo htmlspecialchars($watch['watch_price'] + rand(10, 20)); ?> JOD</del></h6>
                    </div>
                    <?php if ($view == 1): ?>
                        <div class="d-flex align-items-center justify-content-center mt-2">
                            <p><?php echo htmlspecialchars($watch['watch_description']); ?></p>
                        </div>
                        <div class="d-flex align-items-center justify-content-center mt-2">
                            <h6>Material: <?php echo htmlspecialchars($watch['strap_material']); ?></h6>
                        </div>
                        <div class="d-flex align-items-center justify-content-center mt-2">
                            <h6>Gender: <?php echo htmlspecialchars($watch['watch_gender']); ?></h6>
                        </div>

                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>


    <script src="../addToCart.js"></script>

</body>

</html>