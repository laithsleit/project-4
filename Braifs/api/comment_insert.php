<?php
////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
/////////////////use the next json to insert the comment /////////////////////////////////
//////////////////but change the values////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
// {
//     "comment_id": 5,
//     "comment_content": "Average product, could be better.",
//     "rate": 3,
//     "product_id": 9,
//     "user_id": 2
//   }
//////////////////////////////////////////////////////////////////////
include 'include.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

$data = json_decode(file_get_contents('php://input'), true);

if (!empty($data)) {
   
    $requiredFields = ["comment_content","rate", "product_id" , "user_id"];
    $allFieldsPresent = true;

    foreach ($requiredFields as $field) {
        if (!isset($data[$field]) || empty($data[$field])) {
            $allFieldsPresent = false;
            break;
        }
    }

    if ($allFieldsPresent) {
        
        $sql = "INSERT INTO comments (comment_content, rate, product_id , user_id ) VALUES (
            '{$data['comment_content']}', 
            '{$data['rate']}',
            '{$data['product_id']}',
            '{$data['user_id']}'
        )";

        if ($conn->query($sql) === TRUE) {
            echo json_encode(array("message" => "comments record created successfully."));
        } else {
            echo json_encode(array("error" => "Error: " . $conn->error));
        }
    } else {
        echo json_encode(array("error" => "Please provide all required fields."));
    }
} else {
    echo json_encode(array("error" => "No data received."));
}

$conn->close();
?>
