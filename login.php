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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="login-container">
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
</body>
</html>
