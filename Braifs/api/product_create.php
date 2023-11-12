<?php
header("Access-Control-Allow-Origin: ");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
include 'connect.php';

// {
//     "image": "product3.jpg",
//     "name": "Product hiiii",
//     "description": "hellooo inserrttt testt 1",
//     "price": 19.99,
//     "price_after_discount": 16.49,
//     "category_id": 2,
//     "section": "men"
// }



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $json_data = file_get_contents('php://input');
    $data = json_decode($json_data, true);
 
    if (!empty($data)) {
        $query = 'INSERT INTO products (image, name, description, price, price_after_discount, category_id, section, created_at) VALUES (?,?,?,?,?,?,?,NOW());';

        $stmt = $pdo->prepare($query);

        $stmt->execute([$data['image'], $data['name'], $data['description'], $data['price'], $data['price_after_discount'], $data['category_id'], $data['section']]);

        if ($stmt) {
            echo json_encode(['message' => 'Product inserted successfully']);
        } else {
            echo json_encode(['message' => 'Failed to insert the product']);
        }
    } else {
        echo json_encode(['message' => 'No data provided for insertion']);
    }
} else {
    echo json_encode(['message' => 'Incorrect request method']);
}









?>
