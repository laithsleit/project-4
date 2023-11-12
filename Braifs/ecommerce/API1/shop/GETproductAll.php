<?php
include '../include.php';
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: access');
header('Access-Control-Allow-Methods: GET');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');


if($_SERVER["REQUEST_METHOD"] == "GET"){

$JSON=array();
$sql="SELECT name,img,price FROM products";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
$JSON[]=$row;}

echo json_encode($JSON);
}else {
    echo 'error method';
}