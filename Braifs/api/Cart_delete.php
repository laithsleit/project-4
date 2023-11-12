<?php
////////////////////////////////////////////////////////////////////////////////
////////////////////use DELETE method /////////////////////////////////////////
////////////////////send: id + product_id /////////////////////////////////////
// {
//     "product_id":6,
//     "id":7
// }
////////////////////////////////////////////////////////////////////////////////////////////

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include 'include.php';

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['product_id']) && isset($data['id'])) {
        $productId = $data['product_id'];
        $userId = $data['id'];

        $sql = "DELETE FROM cart WHERE product_id = $productId AND user_id = $userId";
        $result = mysqli_query($conn, $sql);

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
            'error' => 'Invalid request. Please provide the product_id, id, and delete parameter.'
        );
        echo json_encode($response);
    }
} else {
    $response = array(
        'error' => 'Invalid request method'
    );
    echo json_encode($response);
}
?>
