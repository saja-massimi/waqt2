<?php
include 'conn.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST;

    // Get the watch_id to update
    $watch_id = $data['watch_id'] ?? null;
    if ($watch_id) {
        // Extract the data to be updated
        $watch_name = $data['watch_name'] ?? null;
        $watch_description = $data['watch_description'] ?? null;
        $watch_price = $data['watch_price'] ?? null;
        $watch_category = $data['watch_category'] ?? null;
        $watch_brand = $data['watch_brand'] ?? null;
        $watch_quantity = $data['watch_quantity'] ?? null;
        $watch_model = $data['watch_model'] ?? null;
        $strap_material = $data['strap_material'] ?? null;

        // Handle file upload for watch image
        $watch_img = null;
        if (isset($_FILES['watch_image']) && $_FILES['watch_image']['error'] === UPLOAD_ERR_OK) {
            $allowedTypes = ['image/png', 'image/jpeg', 'image/jpg'];
            $fileType = $_FILES['watch_image']['type'];

            if (in_array($fileType, $allowedTypes)) {
                $imageExtension = pathinfo($_FILES['watch_image']['name'], PATHINFO_EXTENSION);
                $newImageName = 'watch_' . date('Ymd_His') . '.' . $imageExtension; 
                $uploadPath = '../../assets/products_img/' . $newImageName;

                // Move the file to the desired directory
                if (move_uploaded_file($_FILES['watch_image']['tmp_name'], $uploadPath)) {
                    $watch_img = $newImageName; // Store the new image file name for database update
                } else {
                    echo json_encode(['success' => false, 'message' => 'Error moving the uploaded file.']);
                    exit;
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Invalid image type.']);
                exit;
            }
        }

        // Prepare the SQL query
        $sql = "UPDATE watches 
                SET watch_name = :watch_name, 
                    watch_description = :watch_description, 
                    watch_price = :watch_price, 
                    watch_category = :watch_category, 
                    watch_brand = :watch_brand, 
                    quantity = :watch_quantity, 
                    watch_model = :watch_model, 
                    strap_material = :strap_material" . 
                    ($watch_img ? ", watch_img = :watch_img" : "") . 
                " WHERE watch_id = :watch_id";

        try {
            $stmt = $pdo->prepare($sql);
            
            // Bind parameters to the SQL query
            $stmt->bindParam(':watch_name', $watch_name);
            $stmt->bindParam(':watch_description', $watch_description);
            $stmt->bindParam(':watch_price', $watch_price);
            $stmt->bindParam(':watch_category', $watch_category);
            $stmt->bindParam(':watch_brand', $watch_brand);
            $stmt->bindParam(':watch_quantity', $watch_quantity);
            $stmt->bindParam(':watch_model', $watch_model);
            $stmt->bindParam(':strap_material', $strap_material);
            $stmt->bindParam(':watch_id', $watch_id, PDO::PARAM_INT);
            
            // Bind watch_img only if it's provided
            if ($watch_img) {
                $stmt->bindParam(':watch_img', $watch_img);
            }

            // Execute the statement
            $stmt->execute();
            
            // Respond with success
            echo json_encode(['success' => true, 'message' => 'Watch updated successfully!']);
        } catch (PDOException $e) {
            // Handle error
            echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'watch_id is required for updating the record.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
