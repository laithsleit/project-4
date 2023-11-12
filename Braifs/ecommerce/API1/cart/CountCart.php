<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Content-Type: application/json; charset=UTF-8');
include '../include.php';
if($_SERVER["REQUEST_METHOD"] == "GET"){

    if (isset($_GET['email'])){
    $email=$_GET['email'];
    $sql = "SELECT id FROM users WHERE email='$email'";
    $result = $conn->query($sql);
    $nresult=$result->fetch_assoc();
    $user_id=$nresult['id'];
    
    $sql2="SELECT * FROM cart WHERE user_id = $user_id ";
    $result2 = $conn->query($sql2);
    $count=0;
    if ($result2->num_rows > 0) {
        while ($row = $result2->fetch_assoc()) {
        $count+=$row['quantity'];
        }
    }
    $JSON=json_encode($count);
    echo $JSON;
    }
}else {
    echo 'error method';
}  