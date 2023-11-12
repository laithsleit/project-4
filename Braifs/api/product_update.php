<?php
header("Access-Control-Allow-Origin: ");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
include 'connect.php';


// ------------------------------------------------------------------------------------
// ------------------------------------------------------------------------------------
// -------------PUT METHOD TO UPDATE SPACIFIC ATTRIPUTES IN THE PRODUCTS---------------
// -------IT TAKES ( id ) to select the row + the attributes that needs modify --------
// ------------------------------------------------------------------------------------
// ------------------------------------------------------------------------------------
//   {
//     "product_id": 3,  
//     "name": "Updated Product Name",
//     "price": 60.00,
//     "price_after_discount": 55.00
//   }
  
if ($_SERVER["REQUEST_METHOD"] == "PUT") {
    try {
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);

        // Check if the data is not empty
        if (!empty($data)) {
            // Build the SQL query dynamically based on the provided data
            $query = "UPDATE products SET ";
            $params = [];

            // Iterate through the provided attributes and construct the query
            foreach ($data as $key => $value) {

                // ------------------------------------------------------------------------------------
                // ------------------------------------------------------------------------------------
                // -----------provid your products table attributes in $valid_columns array------------
                $valid_columns = ['image', 'name', 'description', 'price', 'price_after_discount', 'category_id', 'created_at','section'];
                // ------------------------------------------------------------------------------------
                // ------------------------------------------------------------------------------------
              

                if (in_array($key, $valid_columns)) {
                    $query .= "$key = ?, ";
                    $params[] = $value;
                }
            }


            // Remove the trailing comma and space

            $query = rtrim($query, ', ');

            $query .= " WHERE product_id = ?;";
            $params[] = $data['product_id'];

            $stmt = $pdo->prepare($query);
            $stmt->execute($params);

            // Check the affected rows to see if the update was successful
            $affectedRows = $stmt->rowCount();

            if ($affectedRows > 0) {
                echo json_encode(['message' => 'Update successful']);
            } else {
                echo json_encode(['message' => 'No matching records found for the provided product_id']);
            }
        } else {
            echo json_encode(['message' => 'No data provided for updating']);
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
} else {
    echo json_encode(['message' => 'Incorrect request method']);
}


?>
