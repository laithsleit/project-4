<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
class UserAuthentication {
    private $pdo;

    public function __construct($db) {
        $this->pdo = $db;
    }

    public function authenticateUser($json_data) {
        $data = json_decode($json_data, true);

        if ($data && isset($data["username"]) && isset($data["password"])) {
            $username = $data["username"];
            $password = $data["password"];

            $query = "SELECT id , role_id FROM users WHERE (username = :username OR email = :username) AND password = :password";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':password', $password, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($result) > 0) {  // Use count to check the number of rows
                session_start();
                $user = $result[0];
                $response = array('STATUS' => true, 'ROLE' => $user['role_id'], 'USER_ID' => $user['id']);
                $_SESSION['userId'] = $user['id'];
            } else {
                $response = array('STATUS' => false);
            }
        } else {
            $response = array('error' => 'Invalid JSON data');
        }

        return $response;
    }
}

include '../connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $json_data = file_get_contents('php://input');
    $authenticator = new UserAuthentication($pdo);
    $response = $authenticator->authenticateUser($json_data);
} else {
    $response = array('error' => 'Invalid request method');
}

header("Content-Type: application/json");
echo json_encode($response);

$pdo = null;
?>
