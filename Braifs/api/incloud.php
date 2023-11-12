<?php

$servername = "localhost";
$username = "root"; 
$password = ""; 
$database = "project-4";    


$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>