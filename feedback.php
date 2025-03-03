<?php
include "includes/db_connect.php";
session_start();

if (!isset($_SESSION["user_id"])) {
    echo "<div style='
            text-align: center;
            margin: 100px auto;
            font-size: 20px;
            color: #0056b3;
            font-family: Arial, sans-serif;
            padding: 20px;
            border: 2px solid #0056b3;
            border-radius: 8px;
            background-color: #d0e8ff;
            width: 50%;
            max-width: 500px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        '>
            <strong>⚠ Access Denied!</strong><br>
            ❌ Please <a href='login.php' style='
                color: #004085;
                font-weight: bold;
                text-decoration: none;
            '>login</a> to submit feedback.<br><br>

            <a href='login.php' style='
                display: inline-block;
                padding: 10px 15px;
                background-color: #0056b3;
                color: white;
                font-weight: bold;
                text-decoration: none;
                border-radius: 5px;
                transition: 0.3s;
            ' onmouseover='this.style.backgroundColor=\"#004085\"' 
              onmouseout='this.style.backgroundColor=\"#0056b3\"'>
                🔑 Log In
            </a>
        </div>";
    exit;
}

$user_id = $_SESSION["user_id"];

// Fetch user details
$stmt = $conn->prepare("SELECT username, email FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Handle feedback submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $message = trim($_POST["message"]);

    if (empty($message)) {
        $error = "⚠️ Feedback cannot be empty.";
    } else {
        $stmt = $conn->prepare("INSERT INTO feedback (user_id, username, email, message) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $user_id, $user["username"], $user["email"], $message);
        if ($stmt->execute()) {
            $success = "✅ Feedback submitted successfully!";
        } else {
            $error = "❌ Error submitting feedback.";
        }
        $stmt->close();
    }
}

$conn->close();

include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback - Ocean Pearls</title>
    <link rel="stylesheet" href="styles/feedback.css">
</head>
<body>
    <br>
    <h2 style="text-align: center;">Submit Your Feedback</h2>

    <?php if (isset($error)) echo "<p class='center-msg'>$error</p>"; ?>
    <?php if (isset($success)) echo "<p class='success-msg'>$success</p>"; ?>

    <form method="post" style="text-align: center;">
        <p><strong>Username:</strong> <?= htmlspecialchars($user["username"]) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($user["email"]) ?></p>
        <textarea name="message" rows="5" cols="50" placeholder="Enter your feedback..." required></textarea><br>
        <button type="submit">Submit Feedback</button>
    </form>
</body>
</html>
