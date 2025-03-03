<?php
$servername = "localhost";
$username = "root";  // Default XAMPP user
$password = "";      // Default XAMPP password (empty)
$dbname = "ocean_pearls";

// Connect to database
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Hash passwords
$hashedPassword = password_hash("123abc", PASSWORD_BCRYPT);

// Insert admins
$sql = "INSERT INTO admins (admin_name, password) VALUES 
        ('sharath', '$hashedPassword'), 
        ('ahad', '$hashedPassword'), 
        ('sudeep', '$hashedPassword')";

if ($conn->query($sql) === TRUE) {
    echo "Admins inserted successfully with hashed passwords!";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
