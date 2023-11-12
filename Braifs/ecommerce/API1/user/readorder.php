






    
<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
include '../include.php';
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $sql = "SELECT orders.*, users.username
    FROM orders
    JOIN users ON orders.user_id = users.id;";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $events = array();
        while ($row = $result->fetch_assoc()) {
            $events[] = $row;
        }
        echo json_encode($events);
    } else {
        echo json_encode(array("message" => "No user records found."));
    }
} 



?>
