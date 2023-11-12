<?php
header("Access-Control-Allow-Origin:*");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

$servername = "localhost"; 
$username = "root"; 
$password = "";
$dbname = "project-4"; // Define the database name here

$conn = new mysqli($servername, $username, $password, $dbname); // Corrected database selection

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}




