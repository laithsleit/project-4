<?php
///////////////////////////////////////////////////////////////////////////////////////
///////////////////use GET method ///////////////////////////////////////////////////////
//////////////////send: no data needed//////////////////////////////////////////////////
//////////////to select all the orders in the database///////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
include("incloud.php");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sql = "SELECT * FROM orders";
    $result = $conn->query($sql);

    if (!$result) {
        die("Invalid Query: " . mysqli_connect_error());
    }

    if ($result->num_rows > 0) {
        $data = array();

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        echo json_encode($data, JSON_PRETTY_PRINT);
    } else {
        echo json_encode(array('message'=> 'There are no records found'));
    }
} else {
    echo json_encode(array('error'=> 'Invalid request method'));
}
?>
