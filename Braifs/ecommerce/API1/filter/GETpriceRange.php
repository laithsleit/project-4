<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Content-Type: application/json; charset=UTF-8');
include '../include.php';
if($_SERVER["REQUEST_METHOD"] == "GET"){
if (isset($_GET['min_price']) || isset($_GET['max_price'])){
    if(!isset ($_GET['min_price'])){
        $max_price=$_GET['max_price'];
        $sql="SELECT MIN(Price) FROM Products";
        $result = $conn->query($sql);
        $min=$result->fetch_assoc();
        $min_price=$min['MIN(Price)'];
    }elseif(!isset ($_GET['max_price'])){
        $min_price=$_GET['min_price'];
        $sql="SELECT MAX(Price) FROM Products";
        $result = $conn->query($sql);
        $max=$result->fetch_assoc();
        $max_price=$max['MAX(Price)'];
    }else{
        $max_price=$_GET['max_price'];
        $min_price=$_GET['min_price'];

    }
    $sql="SELECT * FROM products WHERE Price BETWEEN '$min_price' AND '$max_price'";
    

$JSON=array();
$result = $conn->query($sql);
$row = mysqli_fetch_all($result, MYSQLI_ASSOC);
$JSON=json_encode($row);
 echo $JSON;}
}else {
    echo 'error method';
}    