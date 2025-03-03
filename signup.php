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
</head>
<body>
    <div class="signup-container">
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
