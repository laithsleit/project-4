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
    if (isset($data['delete']) && isset($data['product_id'])) {
        $productId = $data['product_id'];

        $sql = "DELETE FROM cart WHERE product_id = $productId AND user_id = $userId";
        $result = mysqli_query($con, $sql);

        if ($result) {
            $response = array(
                'message' => 'Product deleted from cart'
            );
            echo json_encode($response);
        } else {
            $response = array(
                'error' => 'Failed to delete the product from the cart'
            );
            echo json_encode($response);
        }
    } else {
        $response = array(
            'error' => 'Invalid request. Please provide the product_id and delete parameter.'
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