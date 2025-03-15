<?php
include "includes/db_connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $phone = trim($_POST["phone"]);
    $email = trim($_POST["email"]);
    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    // Validate phone number (only digits)
    if (!preg_match('/^\d{10}$/', $phone)) {
        echo json_encode(["status" => "error", "message" => "❌ Invalid phone number!"]);
        exit();
    }

    // Check if username already exists
    $check_sql = "SELECT * FROM users WHERE username=?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $check_result = $stmt->get_result();

    if ($check_result->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "❌ Username already exists!"]);
    } else {
        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Insert user into database
        $sql = "INSERT INTO users (name, phone, email, username, password) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $name, $phone, $email, $username, $hashedPassword);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "✅ Signup successful!", "redirect" => "login.php"]);
        } else {
            echo json_encode(["status" => "error", "message" => "❌ Error: " . $conn->error]);
        }
    }
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>User Signup - Ocean Pearls</title>
    <link rel="stylesheet" href="styles/signup.css">
    <link rel="icon" href="assets/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="assets/favicon.ico" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        // Check username availability
        $("#username").on("input", function() {
            var username = $(this).val();
            if (username.length > 0) {
                $.post("check_username.php", { username: username }, function(response) {
                    var res = JSON.parse(response);
                    $("#username_message").html(res.message).css("color", res.status === "error" ? "red" : "green");
                });
            } else {
                $("#username_message").html("");
            }
        });

        // Handle form submission
        $("#signupForm").submit(function(event) {
            event.preventDefault(); // Prevent form reload

            $.post("signup.php", $(this).serialize(), function(response) {
                var res = JSON.parse(response);
                $("#signup_message").html(res.message).css("color", res.status === "error" ? "red" : "green");

                if (res.status === "success") {
                    setTimeout(function() {
                        window.location.href = res.redirect; // Redirect to login page
                    }, 1000);
                }
            });
        });
    });
    </script>
    <style>
        .signup-container {
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
            height: 40px; /* Increased height */
            margin-right: 15px; /* Increased margin */
        }

        .logo-title span {
            font-size: 24px; /* Increased font size */
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

        #signup_message {
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
</head>
<body>
    <div class="signup-container">
        <a href="index.php" class="logo-title">
            <img src="assets/logo.png" alt="Ocean Pearls Logo">
            <span>Ocean Pearls</span>
        </a>
        <h2>Signup</h2>
        <form id="signupForm">
            <div>
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div>
                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" required>
            </div>
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
                <span id="username_message"></span>
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Signup</button>
        </form>
        <p id="signup_message"></p>
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
</body>
</html>
