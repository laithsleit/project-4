<?php
///////////////////////////////////////////////////////////////////////////
////////////////////use the method PUT/////////////////////////////////////
/////////////////use the next json to update the user /////////////////////////////////
//////////////////but change the values////////////////////////////////////////////
//////////////////and u can send from 1 to all the column/////////////////////////////////////////
///////////////////////////////////////////////////////////////////
    // {
    //     "image": "path/to/userimage1.jpg",
    //     "username": "johndoe",
    //     "password": "password123",
    //     "role_id": 2,
    //     "email": "johndoe@example.com",
    //     "created_at": datetime.now().strftime("%Y-%m-%d %H:%M:%S")
    // }
//////////////////////////////////////////////////////////////////////
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
include 'include.php';


if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['id'])) {
        $userId = $data['id'];

        // Check if the user exists
        $checkUserQuery = "SELECT * FROM users WHERE id = $userId";
        $checkUserResult = $conn->query($checkUserQuery);

        if ($checkUserResult->num_rows > 0) {
            $existingData = $checkUserResult->fetch_assoc();

            $updateFields = array();

            // Loop through all columns in the 'users' table and construct the update query
            foreach ($existingData as $key => $value) {
                if (isset($data[$key]) && $key !== 'Id') {
                    $updateFields[] = "$key = '" . ($data[$key] !== null ? $data[$key] : $value) . "'";
                }
            }

            if (!empty($updateFields)) {
                $updateQuery = "UPDATE users SET " . implode(', ', $updateFields) . " WHERE id = $userId";

                if ($conn->query($updateQuery) === TRUE) {
                    echo json_encode(array("message" => "User details updated successfully."));
                } else {
                    echo json_encode(array("error" => "Error updating user details: " . $conn->error));
                }
            } else {
                echo json_encode(array("message" => "No fields to update provided."));
            }
        } else {
            echo json_encode(array("error" => "User not found."));
        }
    } else {
        echo json_encode(array("error" => "Please provide the user ID."));
    }
} else {
    echo json_encode(array("error" => "Invalid request method. Please use PUT method."));
}

$conn->close();
?>



