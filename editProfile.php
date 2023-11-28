<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: http://127.0.0.1:5500');

include 'include.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    if (!isset($_SESSION['userId'])) {
        $response = array(
            'error' => 'User is not authenticated. Please log in.'
        );
        echo json_encode($response);
        exit;
    }
    $userId = $_SESSION['userId'];


    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['image']['tmp_name'];
        $imagePath = $_FILES['image']['name'];
        move_uploaded_file($image, $imagePath);
        $sql = "UPDATE users SET image = '$imagePath' WHERE id = $userId";
        mysqli_query($con, $sql);
    }
    $image = $_POST['image'] ??'';
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $update_profile_query = "UPDATE users SET ";
    $setClauses = [];

    if (!empty($username)) {
        $setClauses[] = "username = '$username'";
    }
    if (!empty($image)) {
        $setClauses[] = "image = '$image'";
    }

    if (!empty($email)) {
        $setClauses[] = "email = '$email'";
    }

    if (!empty($password)) {
        $setClauses[] = "password = '$password'";

    }

    $update_profile_query .= implode(", ", $setClauses);
    $update_profile_query .= " WHERE id = $userId";

    mysqli_query($con, $update_profile_query);

    $response = array(
        'success' => 'Profile updated successfully.'
    );
    echo json_encode($response);
} else {
    $response = array(
        'error' => 'Please use post'
    );
    echo json_encode($response);
}

mysqli_close($con);
?>