<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Content-Type: application/json; charset=UTF-8');
include '../include.php';
if($_SERVER["REQUEST_METHOD"] == "GET"){
    if (isset($_GET['search'])){
    $search=$_GET['search'];
    
    $sql="SELECT * FROM products WHERE name LIKE '%$search%'";
    

$JSON=array();
$result = $conn->query($sql);
$row = mysqli_fetch_all($result, MYSQLI_ASSOC);
$JSON=json_encode($row);
 echo $JSON;}
}else {
    echo 'error method';
}    