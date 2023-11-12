<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Content-Type: application/json; charset=UTF-8');
include '../include.php';
if($_SERVER["REQUEST_METHOD"] == "GET"){
    if (isset($_GET['email'])){
    $email=$_GET['email'];
    $sql = "SELECT products.product_id,products.name,products.img,products.price,products.price_after_discount,products.color,products.Dimensions,cart.quantity FROM products 
    INNER JOIN cart ON cart.product_id = products.product_id
    JOIN users ON cart.user_id=users.id 
    WHERE users.email='$email' AND cart.quantity>0";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {

$JSON=array();
$result = $conn->query($sql);
$row = mysqli_fetch_all($result, MYSQLI_ASSOC);
$JSON=json_encode($row);
 echo $JSON;}}
}else {
    echo 'error method';
}  