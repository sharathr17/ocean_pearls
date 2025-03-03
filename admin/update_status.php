<?php
include "../includes/db_connect.php";
session_start();

if (!isset($_SESSION["admin_name"])) {
    die("<p class='error'>Unauthorized.</p>");
}

if (!isset($_GET['id']) || !isset($_GET['status'])) {
    die("<p class='error'>Invalid request.</p>");
}

$booking_id = intval($_GET['id']);
$status = $_GET['status'];

// Allowed statuses
$allowed_statuses = ['Pending', 'Accepted', 'Rejected', 'User Cancelled'];

if (!in_array($status, $allowed_statuses)) {
    die("❌ Invalid status.");
}

// If status is Rejected or User Cancelled, reset payment_status
if ($status === 'Rejected' || $status === 'User Cancelled') {
    $sql = "UPDATE bookings SET status = ?, payment_status = NULL WHERE id = ?";
} else {
    $sql = "UPDATE bookings SET status = ? WHERE id = ?";
}

$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $status, $booking_id);

if ($stmt->execute()) {
    echo "<script>alert('✅ Booking updated!'); window.location.href='admin_panel.php';</script>";
} else {
    echo "❌ Error: " . $conn->error;
}
?>

 