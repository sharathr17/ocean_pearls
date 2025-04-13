<?php
session_start();
include "includes/db_connect.php";

// Enable error reporting for debugging (Remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_POST["username"]) || !isset($_POST["password"])) {
        echo json_encode(["status" => "error", "message" => "Invalid request"]);
        exit();
    }

    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        echo json_encode(["status" => "error", "message" => "Database error"]);
        exit();
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row["password"])) {
            $_SESSION["user_id"] = $row["id"];
            $_SESSION["username"] = $row["username"];

            echo json_encode(["status" => "success", "message" => "✅ Login successful!", "redirect" => "index.php"]);
        } else {
            echo json_encode(["status" => "error", "message" => "❌ Incorrect password!"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "❌ User not found!"]);
    }
    
    $stmt->close();
    $conn->close();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>User Login - Ocean Pearls</title>
    <link rel="stylesheet" href="styles/login.css">
    <link rel="icon" href="assets/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="assets/favicon.ico" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="login-container">
        <a href="index.php" class="logo-title">
            <img src="assets/logo.png" alt="Ocean Pearls Logo">
            <span>Ocean Pearls</span>
        </a>
        <h2>Login</h2>
        <form id="loginForm">
            <div>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required autocomplete="username">
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required autocomplete="current-password">
            </div>
            <p class="forgot-password"><a href="forgot_password.php">Forgot Password?</a></p>
            <button type="submit">Login</button>
        </form>
        <p id="login_message"></p>
        <p>Don't have an account? <a href="signup.php">Signup here</a></p>
    </div>

    <script>
        $(document).ready(function() {
            $("#loginForm").submit(function(event) {
                event.preventDefault(); // Prevent page reload

                $.post("login.php", $(this).serialize(), function(response) {
                    var res = JSON.parse(response);
                    $("#login_message").html(res.message).css("color", res.status === "error" ? "red" : "green");

                    if (res.status === "success") {
                        setTimeout(function() {
                            window.location.href = res.redirect; // Redirect to home page
                        }, 1000); // Delay 1.0 seconds before redirect
                    }
                });
            });
        });
    </script>
    <style>
        .login-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .logo-title {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            text-decoration: none;
            color: #2c3e50;
        }

        .logo-title img {
            height: 40px;
            margin-right: 15px;
        }

        .logo-title span {
            font-size: 24px;
            font-weight: bold;
        }

        h2 {
            margin-bottom: 20px;
            color: #2c3e50;
        }

        form div {
            margin-bottom: 15px;
            text-align: left;
        }

        label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #555;
            margin-bottom: 5px;
        }

        input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none;
            transition: border-color 0.3s ease;
        }

        input:focus {
            border-color: #2c3e50;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #2c3e50;
            color: white;
            font-size: 16px;
            font-weight: 600;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background: #1a252f;
        }

        #login_message {
            margin-top: 10px;
            font-size: 14px;
        }

        p {
            margin-top: 15px;
            font-size: 14px;
        }

        p a {
            color: #2c3e50;
            text-decoration: none;
            font-weight: 600;
        }

        p a:hover {
            text-decoration: underline;
        }
    </style>
</body>
</html>
