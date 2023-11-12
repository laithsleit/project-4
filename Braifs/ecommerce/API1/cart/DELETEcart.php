<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: access');
header('Access-Control-Allow-Methods: DELETE');
header('Content-Type: application/json; charset=UTF-8');

include '../include.php';
if($_SERVER["REQUEST_METHOD"] == "DELETE"){
    $data = json_decode(file_get_contents('php://input'));
    $email= $data->email;
    $product_id = $data->product_id;
    $sql1 = "SELECT id FROM users WHERE users.email='$email'";
    $result = $conn->query($sql1);
    $nresult=$result->fetch_assoc();
    $user_id=$nresult['id'];
    $sql="SELECT * FROM cart WHERE user_id = $user_id AND  product_id = $product_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $d="DELETE FROM cart WHERE user_id = '$user_id' AND  product_id = '$product_id'";
    $conn->query($d);
    }
    
else{
    echo'connect proudct_id &email';
}}else{
    
    echo 'error method';
}

