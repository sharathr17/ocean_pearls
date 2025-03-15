<?php
include "../includes/db_connect.php";
session_start();

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin_name = $_POST["admin_name"];
    $password = $_POST["password"];

    // Fetch admin details from the database
    $stmt = $conn->prepare("SELECT * FROM admins WHERE admin_name = ?");
    $stmt->bind_param("s", $admin_name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        // Verify the password
        if (password_verify($password, $row['password'])) {
            $_SESSION["admin_name"] = $admin_name;
            header("Location: admin_panel.php");
            exit();
        } else {
            $error = "Invalid login.";
        }
    } else {
        $error = "Invalid login.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Login - Ocean Pearls</title>
    <link rel="icon" href="../assets/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="../assets/favicon.ico" type="image/x-icon">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: #f4f4f9;
            font-family: "Lato", sans-serif;
        }

        .login-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);
            width: 300px;
            text-align: center;
        }

        .login-container h2 {
            margin-bottom: 20px;
            color: rgb(2, 64, 130);
        }

        .login-container input {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .login-container button {
            width: 100%;
            padding: 10px;
            background: rgb(2, 64, 130);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .login-container button:hover {
            background: rgb(1, 50, 100);
        }

        .error {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Admin Login</h2>
        <form method="post">
            <input type="text" name="admin_name" placeholder="Admin Name" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <button type="submit">Login</button>
        </form>
        <?php if ($error): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
