<?php
header("Access-Control-Allow-Origin:*");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
include 'connect.php';

// ----------------------------------------------------------------------------------
// ----------------------------GET METHOD TO SELECT ALL THE PRODUCTS-----------------
// ----------------------------------------------------------------------------------

if($_SERVER["REQUEST_METHOD"] == "GET"){
try {
    $query="SELECT * FROM products;";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header("Content-Type: application/json");
    echo json_encode($result);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
}

// ----------------------------------------------------------------------------------
// ----------------------------POST METHOD TO SELECT BY PRODUCT ID-------------------
// ----------------------------------------------------------------------------------

elseif($_SERVER["REQUEST_METHOD"] == "POST"){
    
    try {
   
    $json_data = file_get_contents("php://input");
    $data = json_decode($json_data,true);

    $query="SELECT * FROM products WHERE product_id = ? ;";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$data['id']]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if($result){
    echo json_encode($result);
    }else {
        echo json_encode(['message' => 'incorrect request method11111']);
    }

    }catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    } 
}
else{
    echo json_encode(['message' => 'incorrect request method']);
}
?>
