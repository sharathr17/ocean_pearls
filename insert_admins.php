<?php
include "includes/db_connect.php";

// Define the password
$password = "123abc";

// Hash the password
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

// Insert admins
$sql = "INSERT INTO admins (admin_name, password) VALUES 
        ('sharath', ?), 
        ('ahad', ?), 
        ('sudeep', ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $hashedPassword, $hashedPassword, $hashedPassword);

if ($stmt->execute()) {
    echo "Admins inserted successfully with hashed passwords!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
