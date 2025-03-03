<?php
include_once "includes/db_connect.php";
session_start();

if (!isset($_SESSION["user_id"])) {
    die("❌ Please <a href='login.php'>login</a> to cancel your booking.");
}

if (!isset($_GET['id'])) {
    die("❌ Invalid request.");
}

$booking_id = intval($_GET['id']);
$user_id = $_SESSION["user_id"];

// Check if booking exists
$sql = "SELECT * FROM bookings WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $booking_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("❌ Booking not found.");
}

// Cancel booking & reset payment status
$cancel_sql = "UPDATE bookings SET status = 'User Cancelled', payment_status = NULL WHERE id = ?";
$cancel_stmt = $conn->prepare($cancel_sql);
$cancel_stmt->bind_param("i", $booking_id);

if ($cancel_stmt->execute()) {
    echo "<script>alert('✅ Booking cancelled successfully!'); window.location.href='history.php';</script>";
} else {
    echo "❌ Error: " . $conn->error;
}
?>


