<?php
include 'conn.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $brand_name = $_POST['brand_name'] ?? null;
    $brand_img = null;

    // Validate brand name
    if (!$brand_name) {
        echo json_encode(['success' => false, 'message' => 'Brand name is required.']);
        exit;
    }

    // Handle image upload
    if (isset($_FILES['brand_image']) && $_FILES['brand_image']['error'] === UPLOAD_ERR_OK) {
        $allowedTypes = ['image/png', 'image/jpeg', 'image/jpg'];
        $fileType = $_FILES['brand_image']['type'];

        if (in_array($fileType, $allowedTypes)) {
            $imageExtension = pathinfo($_FILES['brand_image']['name'], PATHINFO_EXTENSION);
            $newImageName = 'brand_' . date('Ymd_His') . '.' . $imageExtension; 
            $uploadPath = '../../assets/Products_img/' . $newImageName;

            if (move_uploaded_file($_FILES['brand_image']['tmp_name'], $uploadPath)) {
                $brand_img = $newImageName;
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

    // Insert brand into the database
    $sql = "INSERT INTO brandname (brand_name,brand_image) VALUES (:brand_name,:brand_img)";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':brand_name', $brand_name);
        $stmt->bindParam(':brand_img', $brand_img);
        $stmt->execute();
        
        echo json_encode(['success' => true, 'message' => 'Brand added successfully!']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
