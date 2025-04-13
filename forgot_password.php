<?php
session_start();
include "includes/db_connect.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $step = $_POST["step"];

    if ($step === "verify") {
        $name = trim($_POST["name"]);
        $phone = trim($_POST["phone"]);
        $email = trim($_POST["email"]);

        $sql = "SELECT id FROM users WHERE name = ? AND phone = ? AND email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $name, $phone, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            echo json_encode(["status" => "verified", "user_id" => $row["id"]]);
        } else {
            echo json_encode(["status" => "error", "message" => "❌ No matching user found."]);
        }
        $stmt->close();
    }

    if ($step === "reset") {
        $user_id = $_POST["user_id"];
        $new_password = trim($_POST["new_password"]);
        $confirm_password = trim($_POST["confirm_password"]);

        if ($new_password !== $confirm_password) {
            echo json_encode(["status" => "error", "message" => "❌ Passwords do not match."]);
            exit();
        }

        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET password = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $hashed_password, $user_id);
        $stmt->execute();

        if ($stmt->affected_rows === 1) {
            echo json_encode(["status" => "success", "message" => "✅ Password updated successfully!", "redirect" => "login.php"]);
        } else {
            echo json_encode(["status" => "error", "message" => "⚠️ Failed to update password."]);
        }
        $stmt->close();
    }

    $conn->close();
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password - Ocean Pearls</title>
    <link rel="stylesheet" href="styles/forgot_password.css">
    <link rel="icon" href="assets/favicon.ico" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="login-container">
    <a href="index.php" class="logo-title">
        <img src="assets/logo.png" alt="Ocean Pearls Logo">
        <span>Ocean Pearls</span>
    </a>
    <h2>Forgot Password</h2>

    <form id="verifyForm">
        <div>
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" required>
        </div>
        <div>
            <label for="phone">Phone:</label>
            <input type="text" name="phone" id="phone" required>
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
        </div>
        <button type="submit">Verify</button>
    </form>

    <form id="resetForm" style="display:none;">
        <input type="hidden" name="user_id" id="user_id">
        <div>
            <label for="new_password">New Password:</label>
            <input type="password" name="new_password" id="new_password" required>
        </div>
        <div>
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" name="confirm_password" id="confirm_password" required>
        </div>
        <button type="submit">Reset Password</button>
    </form>

    <p id="login_message"></p>
    <p><a href="login.php">Back to Login</a></p>
</div>

<script>
    $(document).ready(function () {
        $("#verifyForm").submit(function (e) {
            e.preventDefault();
            $.post("forgot_password.php", {
                step: "verify",
                name: $("#name").val(),
                phone: $("#phone").val(),
                email: $("#email").val()
            }, function (response) {
                let res = JSON.parse(response);
                if (res.status === "verified") {
                    $("#user_id").val(res.user_id);
                    $("#verifyForm").hide();
                    $("#resetForm").show();
                    $("#login_message").html("✅ Verified. Please set a new password.").css("color", "green");
                } else {
                    $("#login_message").html(res.message).css("color", "red");
                }
            });
        });

        $("#resetForm").submit(function (e) {
            e.preventDefault();
            $.post("forgot_password.php", {
                step: "reset",
                user_id: $("#user_id").val(),
                new_password: $("#new_password").val(),
                confirm_password: $("#confirm_password").val()
            }, function (response) {
                let res = JSON.parse(response);
                $("#login_message").html(res.message).css("color", res.status === "success" ? "green" : "red");

                if (res.status === "success") {
                    setTimeout(function () {
                        window.location.href = res.redirect;
                    }, 2000);
                }
            });
        });
    });
</script>
</body>
</html>
