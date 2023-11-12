<?php
header("Access-Control-Allow-Origin: ");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// ----------------------------------------------------------
// ------------------DELETE FROM PRODUCTS -------------------
// --------------------BY SENDING id : JSON -----------------
// ----------------------------------------------------------
// {
//   "id": 1
// }
// ----------------------------------------------------------
// ----------------------------------------------------------
// ----------------------------------------------------------


include 'connect.php';
if($_SERVER['REQUEST_METHOD'] == 'DELETE'){
$json_data=file_get_contents('php://input');
$data=json_decode($json_data,true);
if(!empty($data)){
    $query='DELETE FROM `products` WHERE product_id=?;';
$stmt =$pdo->prepare($query);
$stmt->execute([$data['id']]);
}
}else{
    echo json_encode(['message' => 'incorrect request method']);
}