<?php
//////////////////////////////////////////////////////////////////////
///////////////////send :id  ///////////////////////////////////////// 
/////////////////to delete the user /////////////////////////////////
//////////////////////////////////////////////////////////////////////

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
include 'include.php';


if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $data = json_decode(file_get_contents('php://input'), true);
    $id =$data['id'];

    if (!empty($id)) {
        
        $sql = "DELETE FROM users WHERE id = $id"; 

        if ($conn->query($sql) === TRUE) {
            echo json_encode(array("message" => "User record deleted successfully."));
        } else {
            echo json_encode(array("error" => "Error: " . $conn->error));
        }
    } else {
        echo json_encode(array("message" => "No ID provided for deletion."));
    }
} else {
    echo json_encode(array("error" => "Invalid request method. Please use POST method."));
}



$conn->close();
?>
