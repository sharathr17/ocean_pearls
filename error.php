<?php
session_start();
$error_message = isset($_GET['message']) ? urldecode($_GET['message']) : "Unauthorized access.";
$redirect_url = isset($_GET['redirect']) ? urldecode($_GET['redirect']) : "index.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access Denied</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f8d7da;
            padding: 50px;
        }
        .error-box {
            display: inline-block;
            background: white;
            padding: 20px;
            border-radius: 8px;
            border: 2px solid #d9534f;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 500px;
        }
        h2 {
            color: #d9534f;
        }
        p {
            font-size: 18px;
            color: #343a40;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #0275d8;
            color: white;
            font-weight: bold;
            text-decoration: none;
            border-radius: 5px;
            transition: 0.3s;
        }
        .btn:hover {
            background-color: #025aa5;
        }
    </style>
</head>
<body>
    <div class="error-box">
        <h2>⚠ Access Restricted!</h2>
        <p><?= htmlspecialchars($error_message) ?></p>
        <a href="login.php?redirect=<?= urlencode($redirect_url) ?>" class="btn">🔑 Log In</a>
    </div>
</body>
</html>
