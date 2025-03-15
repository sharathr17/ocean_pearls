<?php
include 'includes/db_connect.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access!");
}

date_default_timezone_set('Asia/Kolkata');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = intval($_SESSION['user_id']);
    $room_id = intval($_POST['room_id']);
    $checkin_date = trim($_POST['checkin_date']);
    $checkout_date = trim($_POST['checkout_date']);
    $total_price = floatval($_POST['total_price']);
    $nationality = ($_POST['nationality'] == "Other") ? trim($_POST['other_nationality']) : "India";
    $payment_status = ""; 
    $booking_time = date("Y-m-d H:i:s"); // Current timestamp

    if (!isset($_POST['terms'])) {
        die("You must agree to the terms and conditions.");
    }

    // Insert booking details into the database using prepared statements
    $stmt = $conn->prepare("INSERT INTO bookings (user_id, room_id, checkin_date, checkout_date, total_price, nationality, agreed_terms, payment_status, booking_time) 
                            VALUES (?, ?, ?, ?, ?, ?, 1, ?, ?)");
    $stmt->bind_param("iissdsss", $user_id, $room_id, $checkin_date, $checkout_date, $total_price, $nationality, $payment_status, $booking_time);

    if ($stmt->execute()) {
        echo "<div class='success'>Booking successful! Redirecting to booking history...</div>";
        echo "<script>
                setTimeout(function() {
                    window.location.href = 'history.php';
                }, 3000);
              </script>";
    } else {
        echo "<div class='error'>Error: " . htmlspecialchars($stmt->error) . "</div>";
        echo "<script>
                setTimeout(function() {
                    window.location.href = 'history.php';
                }, 5000);
              </script>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Process Booking - Ocean Pearls</title>
    <link rel="icon" href="assets/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="assets/favicon.ico" type="image/x-icon">
    <style>
        .success, .error {
            font-size: 18px;
            font-weight: bold;
            padding: 15px;
            text-align: center;
            margin-top: 20px;
            border-radius: 5px;
            width: 50%;
            margin: auto;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
</body>
</html>



