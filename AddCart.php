<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: http://127.0.0.1:5500');

include 'include.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    if (!isset($_SESSION['userId'])) {
        $response = array(
            'error' => 'User is not authenticated. Please log in.'
        );
        echo json_encode($response);
        exit;
    }
    $userId = $_SESSION['userId'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    if (isset($data['product_id'])) {
        $productId = $data['product_id'];
        $quantity = $data['quantity'];

     
        $productQuery = "SELECT name, price, image FROM products WHERE product_id = '$productId'";
        $productResult = mysqli_query($con, $productQuery);

        if ($productResult && mysqli_num_rows($productResult) > 0) {
            $product = mysqli_fetch_assoc($productResult);

        
            $insertQuery = "INSERT INTO cart (user_id, product_id, quantity) VALUES ($userId, $productId, $quantity)";
            $insertResult = mysqli_query($con, $insertQuery);

            if ($insertResult) {
                $productData = array(
                    'product_img' => $product['image'],
                    'product_name' => $product['name'],
                    'product_price' => $product['price'],
                );

                echo json_encode($productData);
            } else {
                $response = array(
                    'error' => 'Error in adding the product to the cart'
                );
                echo json_encode($response);
            }
        } else {
            $response = array(
                'error' => 'Product not found'
            );
            echo json_encode($response);
        }
    } else {
        $response = array(
            'error' => 'Product ID not provided'
        );
        echo json_encode($response);
    }
} else {
    $response = array(
        'error' => 'Invalid request method'
    );
    echo json_encode($response);
}
}
?>