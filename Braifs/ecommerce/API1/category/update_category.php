<?php
include '../include.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $data = json_decode(file_get_contents('php://input'), true);
         

      

    if (!empty($data['category_id'])) {
        $categoryid = $data['category_id'];

        // Check if the category exists
        $sql = "SELECT * FROM categories WHERE category_id = $categoryid";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            $categoryname =$data['category_name'];
            $id = $row['category_id'];
                
            if (!empty($categoryname)) {
                $sql = "UPDATE categories SET category_name = '$categoryname' WHERE category_id = $id";
                $conn->query($sql);

                echo json_encode(array("success" => "Category updated successfully."));
            } else {
                echo json_encode(array("error" => "Category name is empty."));
            }
        } else {
            echo json_encode(array("error" => "Category not found."));
        }
    } else {
        echo json_encode(array("error" => "Please provide the category ID."));
    }
} else {
    echo json_encode(array("error" => "Invalid request method. Please use PUT method."));
}
$conn->close();
?>
