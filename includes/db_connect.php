<?php
$servername = "localhost";
$username = "root";
$password = ""; // Ensure this is correct
$dbname = "ocean_pearls";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>


