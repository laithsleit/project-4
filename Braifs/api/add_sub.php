<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
include 'include.php';

// ----------------------------------------------------------------------------------
// ----------------------------POST METHOD TO ADD A PRODUCT TO CART-------------------
// ------------------------------------FOR A SPECIFIC USER AND PRODUCT-----------------
// ----------------------------------------------------------------------------------


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    try {
        $json_data = file_get_contents("php://input");
        $data = json_decode($json_data, true);

        // Assuming the data structure includes both user_id and product_id
        $user_id = $data['user_id'];
        $product_id = $data['product_id'];
        $AddorSub = $data['AddorSub'];

        // Create a MySQLi object
        

        // Check if the product already exists in the cart for the specified user
        $existingProductQuery = "SELECT * FROM cart WHERE user_id = ? AND product_id = ?";
        $stmtExistingProduct = $conn->prepare($existingProductQuery);
        $stmtExistingProduct->bind_param("ii", $user_id, $product_id);
        $stmtExistingProduct->execute();
        $existingProductResult = $stmtExistingProduct->get_result();
        $existingProduct = $existingProductResult->fetch_assoc();
        
        if ($AddorSub == "add") {
            if ($existingProduct) {
                // If the product already exists, update the quantity
                $updateQuery = "UPDATE cart SET quantity = quantity + 1 WHERE user_id = ? AND product_id = ?";
                $stmtUpdate = $conn->prepare($updateQuery);
                $stmtUpdate->bind_param("ii", $user_id, $product_id);
                $stmtUpdate->execute();

                // Retrieve updated product details
                $productDetailsQuery = "SELECT * FROM products WHERE product_id = ?";
                $stmtProductDetails = $conn->prepare($productDetailsQuery);
                $stmtProductDetails->bind_param("i", $product_id);
                $stmtProductDetails->execute();
                $productResult = $stmtProductDetails->get_result();
                $product = $productResult->fetch_assoc();

                $newQuantity = $existingProduct['quantity'] + 1;

                // Build response array
                $response = array(
                    'product_img' => $product['image'],
                    'product_name' => $product['name'],
                    'product_price' => $product['price'],
                    'price_after_discount' => $product['price_after_discount'],
                    'quantity' => $newQuantity
                );

                echo json_encode([$response]);
            } else {
                // If the product doesn't exist, insert a new record
                $insertQuery = "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, 1)";
                $stmtInsert = $conn->prepare($insertQuery);
                $stmtInsert->bind_param("ii", $user_id, $product_id);
                $stmtInsert->execute();

                // Retrieve product details for the newly inserted product
                $productDetailsQuery = "SELECT * FROM products WHERE product_id = ?";
                $stmtProductDetails = $conn->prepare($productDetailsQuery);
                $stmtProductDetails->bind_param("i", $product_id);
                $stmtProductDetails->execute();
                $productResult = $stmtProductDetails->get_result();
                $product = $productResult->fetch_assoc();

                $newQuantity = 1;

                // Build response array
                $response = array(
                    'product_img' => $product['image'],
                    'product_name' => $product['name'],
                    'product_price' => $product['price'],
                    'price_after_discount' => $product['price_after_discount'],
                    'quantity' => $newQuantity
                );

                echo json_encode([ $response]);

            }
        } else {
            // Subtraction logic
            $quantity = $existingProduct['quantity'];
            if ($existingProduct && $quantity > 1) {
                // If the product exists and quantity is greater than 1, update the quantity
                $updateQuery = "UPDATE cart SET quantity = quantity - 1 WHERE user_id = ? AND product_id = ?";
                $stmtUpdate = $conn->prepare($updateQuery);
                $stmtUpdate->bind_param("ii", $user_id, $product_id);
                $stmtUpdate->execute();

                $newQuantity = $existingProduct['quantity'] - 1;

                // Retrieve updated product details
                $productDetailsQuery = "SELECT * FROM products WHERE product_id = ?";
                $stmtProductDetails = $conn->prepare($productDetailsQuery);
                $stmtProductDetails->bind_param("i", $product_id);
                $stmtProductDetails->execute();
                $productResult = $stmtProductDetails->get_result();
                $product = $productResult->fetch_assoc();

                // Build response array
                $response = array(
                    'product_img' => $product['image'],
                    'product_name' => $product['name'],
                    'product_price' => $product['price'],
                    'price_after_discount' => $product['price_after_discount'],
                    'quantity' => $newQuantity
                );

                echo json_encode([$response]);
            } elseif ($existingProduct && $quantity == 1) {
                // If the product exists and quantity is 1, you may choose to remove the product or handle it as needed
                $deleteQuery = "DELETE FROM cart WHERE user_id = ? AND product_id = ?";
                $stmtDelete = $conn->prepare($deleteQuery);
                $stmtDelete->bind_param("ii", $user_id, $product_id);
                $stmtDelete->execute();

                echo json_encode(['message' => 'the prodect has been deleted']);
            } else {
                // If the product doesn't exist, you may handle it as needed
                echo json_encode(['message' => 'the prodect has been deleted alrady']);
            }


        }

        // Close the MySQLi connection
        $conn->close();
    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }
}

?>
