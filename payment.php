<?php
include_once "includes/db_connect.php";
session_start();

if (!isset($_SESSION["user_id"])) {
    die("❌ Please <a href='login.php'>login</a> to proceed with payment.");
}

if (!isset($_GET['booking_id'])) {
    die("❌ Invalid request. Booking ID is missing.");
}

$booking_id = intval($_GET['booking_id']);
$user_id = $_SESSION["user_id"];

// Fetch booking details with total price
$sql = "SELECT b.*, r.location, r.room_type, r.price, b.total_price, b.payment_status 
        FROM bookings b
        JOIN rooms r ON b.room_id = r.id
        WHERE b.id = ? AND b.user_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $booking_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("❌ Booking not found.");
}

$booking = $result->fetch_assoc();

// Prevent duplicate payment
if ($booking['payment_status'] == 'Paid') {
    die("✅ Payment already completed for this booking. <a href='history.php'>Go back</a>");
}

// Generate CSRF token
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Process Payment (Simulation)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("❌ CSRF token validation failed.");
    }

    $update_payment = $conn->prepare("UPDATE bookings SET payment_status = 'Paid' WHERE id = ?");
    $update_payment->bind_param("i", $booking_id);

    if ($update_payment->execute()) {
        // Remove CSRF token after successful transaction
        unset($_SESSION['csrf_token']);

        echo "<script>
                alert('✅ Payment successful! Redirecting...');
                window.location.href='history.php';
              </script>";
        exit;
    } else {
        echo "❌ Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment - Ocean Pearls</title>
    <link rel="icon" href="assets/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="assets/favicon.ico" type="image/x-icon">
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; }
        .container { width: 50%; margin: 50px auto; text-align: center; padding: 20px; background: white; border-radius: 10px; box-shadow: 0px 0px 10px #ccc; }
        .btn { background-color: green; color: white; padding: 10px 20px; border: none; cursor: pointer; font-size: 16px; border-radius: 5px; }
        .btn:hover { background-color: darkgreen; }
        .details { text-align: left; margin: 20px auto; width: 80%; }
        .details p { padding: 5px 0; font-size: 16px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Complete Your Payment</h2>
        <div class="details">
            <p><strong>Location:</strong> <?= htmlspecialchars($booking['location']) ?></p>
            <p><strong> Room Type:</strong> <?= htmlspecialchars($booking['room_type']) ?></p>
            <p><strong> Check-in:</strong> <?= htmlspecialchars($booking['checkin_date']) ?></p>
            <p><strong> Check-out:</strong> <?= htmlspecialchars($booking['checkout_date']) ?></p>
            <p><strong> Total Price:</strong> ₹<?= number_format($booking['total_price'], 2) ?></p>
        </div>

        <form method="POST">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            <button type="submit" class="btn">Pay Now</button>
        </form>
    </div>
</body>
</html>

