<?php
//////////////////////////////////////////////////////////////////////////////////////
/////////////// use POST method ///////////////////////////////////////////////////////
/////////////// send: category_name ///////////////////////////////////////////////////
// {
//     "category_name": "tokyo"
// }
////////////use it to insert new category/////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////


header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
include 'include.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!empty($data) && isset($data['category_name']) && !empty($data['category_name'])) {
        $categoryName = $data['category_name'];

        $sql = "INSERT INTO categories (category_name) VALUES ('$categoryName')";
        
        if ($conn->query($sql) === TRUE) {
            echo json_encode(array("message" => "Record created successfully."));
        } else {
            echo json_encode(array("error" => "Error: " . $conn->error));
        }
    } else {
        echo json_encode(array("error" => "Please provide a non-empty category_name."));
    }
} else {
    echo json_encode(array("error" => "Invalid request method."));
}
?>
