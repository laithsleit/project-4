<?php
header("Access-Control-Allow-Origin:* ");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// ----------------------------------------------------------
// ------------------DELETE FROM PRODUCTS -------------------
// --------------------BY SENDING ID : JSON -----------------
// ----------------------------------------------------------
// {
//   "id": 1
// }
// ----------------------------------------------------------
// ----------------------------------------------------------
// ----------------------------------------------------------


include '../include.php';

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $data =$_GET['id'];

    if (!empty($data)) {
       
        $sql = "DELETE FROM `products` WHERE product_id= $data";

        if ($conn->query($sql) === TRUE) {
            echo json_encode(array("message" => "Event record deleted successfully."));
        } else {
            echo json_encode(array("error" => "Error: " . $conn->error));
        }
    } else {
        echo json_encode(array("message" => "No data provided for deletion."));
    }
} else {
    echo json_encode(array("error" => "Invalid request method. Please use POST method."));
    
}
header("location:http://127.0.0.1:5500/index.html");

$conn->close();