<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    try {
        $json_data = file_get_contents("php://input");
        $data = json_decode($json_data, true);

        $user_id = $data['user_id'];
        $product_id = $data['product_id'];

        $existingProductQuery = "SELECT * FROM cart WHERE user_id = ? AND product_id = ?";
        $stmtExistingProduct = $pdo->prepare($existingProductQuery);
        $stmtExistingProduct->execute([$user_id, $product_id]);
        $existingProduct = $stmtExistingProduct->fetch(PDO::FETCH_ASSOC);
        
        if ($existingProduct) {
            // If the product already exists, update the quantity
            $updateQuery = "UPDATE cart SET quantity = quantity + 1 WHERE user_id = ? AND product_id = ?";
            $stmtUpdate = $pdo->prepare($updateQuery);
            $stmtUpdate->execute([$user_id, $product_id]);
            echo json_encode(['message' => 'Product quantity updated in the cart.']);
        } else {
            // If the product doesn't exist, insert a new record
            $insertQuery = "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, 1)";
            $stmtInsert = $pdo->prepare($insertQuery);
            $stmtInsert->execute([$user_id, $product_id]);
            echo json_encode(['message' => 'Product added to the cart successfully.']);
        }

    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>
