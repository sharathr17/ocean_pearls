<?php
require('vendor/setasign/fpdf/fpdf.php'); // Load FPDF
session_start();
include "includes/db_connect.php"; // Database connection

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die("❌ Please login first.");
}

// Validate booking ID
if (!isset($_GET['booking_id']) || !is_numeric($_GET['booking_id'])) {
    die("❌ Invalid request.");
}

$booking_id = intval($_GET['booking_id']);
$user_id = $_SESSION['user_id'];

// Fetch booking details with total price
$sql = "SELECT b.id, u.name, u.email, u.phone, r.location, r.room_type, 
               b.checkin_date, b.checkout_date, b.total_price, b.payment_status
        FROM bookings b
        JOIN users u ON b.user_id = u.id
        JOIN rooms r ON b.room_id = r.id
        WHERE b.id = ? AND b.user_id = ? AND b.payment_status = 'Paid'";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $booking_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("❌ No paid booking found. Please complete your payment first.");
}

$booking = $result->fetch_assoc();

// Create PDF Invoice
$pdf = new FPDF();
$pdf->AddPage();

// Header - Ocean Pearls Title
$pdf->SetFont('Arial', 'B', 24);
$pdf->SetTextColor(0, 102, 204); // Blue color
$pdf->Cell(0, 12, "OCEAN PEARLS", 0, 1, 'C');
$pdf->Ln(3);

// Booking Invoice Title
$pdf->SetFont('Arial', 'B', 16);
$pdf->SetTextColor(0, 0, 0); // Black
$pdf->Cell(0, 10, "BOOKING INVOICE", 0, 1, 'C');
$pdf->Ln(10);

// Booking Details
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(50, 10, "Booking ID:", 0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, $booking['id'], 0, 1);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(50, 10, "Guest Name:", 0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, $booking['name'], 0, 1);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(50, 10, "Email:", 0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, $booking['email'], 0, 1);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(50, 10, "Phone:", 0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, $booking['phone'], 0, 1);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(50, 10, "Location:", 0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, $booking['location'], 0, 1);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(50, 10, "Room Type:", 0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, $booking['room_type'], 0, 1);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(50, 10, "Check-in Date:", 0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, $booking['checkin_date'], 0, 1);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(50, 10, "Check-out Date:", 0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, $booking['checkout_date'], 0, 1);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(50, 10, "Total Price:", 0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, "Rs. " . number_format($booking['total_price'], 2), 0, 1);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(50, 10, "Payment Status:", 0);
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetTextColor(0, 128, 0); // Green for paid status
$pdf->Cell(0, 10, "Paid", 0, 1);
$pdf->SetTextColor(0, 0, 0);

$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, "Thank you for choosing Ocean Pearls!", 0, 1, 'C');
$pdf->Ln(5);

// Footer
$pdf->SetFont('Arial', 'I', 10);
$pdf->SetTextColor(100, 100, 100);
$pdf->Cell(0, 10, "For any queries, contact us at support@oceanpearls.com", 0, 1, 'C');
$pdf->SetTextColor(0, 0, 0);

// Output in browser instead of auto-downloading
$pdf->Output();
?>

