<?php
include 'conn.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST;

    $watch_name = $data['watch_name'] ?? null;
    $watch_description = $data['watch_description'] ?? null;
    $watch_price = $data['watch_price'] ?? null;
    $watch_category = $data['watch_category'] ?? null;
    $watch_brand = $data['watch_brand'] ?? null;
    $watch_quantity = $data['watchQuantity'] ?? null;
    $watch_model = $data['watch_model'] ?? null;
    $strap_material = $data['strap_material'] ?? null;

    $watch_img = null;
    if (isset($_FILES['watch_image']) && $_FILES['watch_image']['error'] === UPLOAD_ERR_OK) {
        $allowedTypes = ['image/png', 'image/jpeg', 'image/jpg'];
        $fileType = $_FILES['watch_image']['type'];

        if (in_array($fileType, $allowedTypes)) {
            $imageExtension = pathinfo($_FILES['watch_image']['name'], PATHINFO_EXTENSION);
            $newImageName = 'watch_' . date('Ymd_His') . '.' . $imageExtension; 
            $uploadPath = '../../assets/products_img/' . $newImageName;

            if (move_uploaded_file($_FILES['watch_image']['tmp_name'], $uploadPath)) {
                $watch_img = $newImageName;
            } else {
                echo json_encode(['success' => false, 'message' => 'Error moving the uploaded file.']);
                exit;
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid image type.']);
            exit;
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Image upload error.']);
        exit;
    }

    $sql = "INSERT INTO watches (watch_name, watch_description, watch_img, watch_price, watch_category, watch_brand, watch_model, strap_material, quantity) 
            VALUES (:watch_name, :watch_description, :watch_img, :watch_price, :watch_category, :watch_brand, :watch_model, :strap_material, :watch_quantity)";

    try {
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':watch_name', $watch_name);
        $stmt->bindParam(':watch_description', $watch_description);
        $stmt->bindParam(':watch_img', $watch_img);
        $stmt->bindParam(':watch_price', $watch_price);
        $stmt->bindParam(':watch_category', $watch_category);
        $stmt->bindParam(':watch_brand', $watch_brand);
        $stmt->bindParam(':watch_quantity', $watch_quantity);
        $stmt->bindParam(':watch_model', $watch_model);
        $stmt->bindParam(':strap_material', $strap_material);

        $stmt->execute();
        
        echo json_encode(['success' => true, 'message' => 'Watch added successfully!']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
