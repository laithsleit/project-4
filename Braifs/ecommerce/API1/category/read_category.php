<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include '../include.php';
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $sql = "SELECT * FROM categories";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $categories = array();
        while ($row = $result->fetch_assoc()) {
            $categories[] = $row;
        }
        echo json_encode($categories);
    } else {
        echo json_encode(array("message" => "No category records found."));
    }
} elseif ($_SERVER['REQUEST_METHOD'] == "POST") {
    
    $data = json_decode(file_get_contents('php://input'), true);
    if (isset($data['category_id'])) {

        $categoryid = $data['category_id'];

        $sql = "SELECT * FROM categories WHERE category_id = $categoryid";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {

            $category = $result->fetch_assoc();
            echo json_encode($category);
            
        } else {
            echo json_encode(array("message" => "category with the provided ID not found."));
        }
    } else {
        echo json_encode(array("error" => "Please provide the category ID."));
    }
} else {
    echo json_encode(array("error" => "Invalid request method."));
}
// $conn->close();
?>
