<?php
include "../includes/db_connect.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin_name = $_POST["admin_name"];
    $password = $_POST["password"];

    if (($admin_name == "sharath" || $admin_name == "ahad" || $admin_name == "sudeep") && $password == "123abc") {
        $_SESSION["admin_name"] = $admin_name;
        header("Location: admin_panel.php");
        exit();
    } else {
        echo "<p class='error'>Invalid login.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Login - Ocean Pearls</title>
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
    </div>
</body>
</html>
