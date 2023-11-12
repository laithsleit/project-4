<?php
include("incloud.php");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");


 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $user_id = $data["user_id"];
$sql="SELECT username,email,order_id,order_date,total_price FROM orders
        INNER JOIN users ON orders.user_id = users.id
        WHERE users.id = $user_id";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data for each order
    while ($row = $result->fetch_assoc()) {
        $order[] = $row;
    }
    echo json_encode($order);

echo json_encode($result, JSON_PRETTY_PRINT);
            } else {
                echo json_encode(array('message'=> 'there is no records founds'));
            }    
}else {
    echo json_encode(array('message'=> "Invalid request method."));
}
?>




