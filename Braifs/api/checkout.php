<?php
include 'include.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    // recieve 
    // 1. 'id'
    // the id represent user id

        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);
        if ($data === null) {
            echo "Invalid JSON data.";
        }
        $u_id =$data['id'];





        //get total price for cart items based on user id
        $sql = "SELECT SUM(IF(products.price_after_discount>0, products.price_after_discount, products.price)* cart.quantity)as total FROM products 
                JOIN cart ON cart.product_id = products.product_id
                WHERE cart.user_id = $u_id
                ";       
        $result = $conn->query($sql);
        $total = 0;
        $cart = array();





        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $total = $row["total"];
            }

            $sql = "SELECT * FROM products 
            JOIN cart ON products.product_id = cart.product_id
            WHERE cart.user_id = $u_id";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $cart[] = $row;
                }
            }
            $sql = "DELETE FROM cart WHERE user_id = $u_id ";
            $result = $conn->query($sql);

        }else{
            die("Script terminated due to EMPTY CART.");
        }



        $orders = array();

            try {

            $sql = "INSERT INTO `orders`(`user_id`, `total_price`) VALUES ($u_id, $total)";
            $result = $conn->query($sql);


            $sql = "SELECT MAX(order_date),order_id FROM `orders` WHERE user_id = $u_id";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $orders= $row;
                }
                $order_id = $orders['order_id'];

            
            // $sql = "INSERT INTO `order_details`(`order_id`, `quantity`, `price`, `product_id`) VALUES ($order_id,x,x,x)";
            // $result = $conn->query($sql);
        } catch (Exception $e) {
            // Handle the exception here, for example, log the error, display an error message, or take appropriate action.
            echo "Error: " . $e->getMessage();
        }


















        // $data = array();

        // try {
        //     $sql = "INSERT INTO `orders`(`user_id`, `total_price`) VALUES ($u_id, $total)";
        //     $result = $conn->query($sql);
        
        //     if ($result === false) {
        //         $data['Transaction'] = 'failed';
        //         throw new Exception("Error executing the SQL query: " . $conn->error);
        //     }else{
        //         $data['Transaction'] = 'successful';
        //     }
            
        //     // Continue with your code after a successful query execution
        //     // For example, you can check the affected rows, close the connection, etc.
        // } catch (Exception $e) {
        //     // Handle the exception here, for example, log the error, display an error message, or take appropriate action.
        //     echo "Error: " . $e->getMessage();
        // }

        // echo json_encode($data);
        }else {
        // // This is not a POST request
        echo "This endpoint only accepts POST requests.";
        }
?>