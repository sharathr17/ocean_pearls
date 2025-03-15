<?php
include_once "includes/db_connect.php";
session_start();
include 'header.php';

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
            '>login</a> to view your booking history.<br><br>

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
date_default_timezone_set('Asia/Kolkata');

// Sorting parameters
$allowed_sort_columns = ['location', 'checkin_date', 'checkout_date', 'total_price', 'status', 'payment_status'];
$sort_column = isset($_GET['sort']) && in_array($_GET['sort'], $allowed_sort_columns) ? $_GET['sort'] : 'checkin_date';
$order = isset($_GET['order']) && $_GET['order'] === 'desc' ? 'DESC' : 'ASC';
$next_order = ($order === 'ASC') ? 'desc' : 'asc';

// Special sorting for Status and Payment Status
if ($sort_column == 'status') {
    $sort_column = "FIELD(b.status, 'Accepted', 'Pending', 'Rejected', 'Cancelled')";
} elseif ($sort_column == 'payment_status') {
    $sort_column = "FIELD(b.payment_status, 'Paid', 'Not Paid', '-')";
}

// Fetch sorted booking details
$sql = "SELECT b.*, r.location, r.room_type, r.price, u.name AS user_name, b.status, b.payment_status
        FROM bookings b
        JOIN rooms r ON b.room_id = r.id
        JOIN users u ON b.user_id = u.id
        WHERE b.user_id = ?
        ORDER BY $sort_column $order";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking History - Ocean Pearls</title>
    <link rel="stylesheet" href="styles/history.css">
</head>
<body>

<div id="history">
    <h2>Your Booking History</h2>

    <?php
    // Sorting Logic
    $allowed_sort_columns = ['location', 'checkin_date', 'checkout_date', 'total_price', 'status', 'payment_status'];
    $sort_column = isset($_GET['sort']) && in_array($_GET['sort'], $allowed_sort_columns) ? $_GET['sort'] : 'checkin_date';
    $order = isset($_GET['order']) && $_GET['order'] === 'desc' ? 'DESC' : 'ASC';
    $next_order = ($order === 'ASC') ? 'desc' : 'asc';

    // Define sorting icons
    $sort_icons = [
        'ASC' => '▲', 
        'DESC' => '▼'
    ];
    $current_icon = isset($_GET['sort']) && isset($sort_icons[$order]) ? $sort_icons[$order] : '';

    // Column Headers with Sorting Links
    function sort_link($column, $label, $current_sort, $current_order, $next_order) {
        $icon = ($current_sort == $column) ? ($current_order === 'ASC' ? '▲' : '▼') : '';
        return "<a href='?sort=$column&order=$next_order'>$label <span class='sort-icon'>$icon</span></a>";
    }
    ?>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <tr>
                <th><?= sort_link('user_name', 'Name', $sort_column, $order, $next_order) ?></th>
                <th><?= sort_link('location', 'Location', $sort_column, $order, $next_order) ?></th>
                <th>Room Type</th>
                <th><?= sort_link('checkin_date', 'Check-in', $sort_column, $order, $next_order) ?></th>
                <th><?= sort_link('checkout_date', 'Check-out', $sort_column, $order, $next_order) ?></th>
                <th><?= sort_link('booking_time', 'Booking Time', $sort_column, $order, $next_order) ?></th>
                <th><?= sort_link('total_price', 'Total Price', $sort_column, $order, $next_order) ?></th>
                <th><?= sort_link('status', 'Status', $sort_column, $order, $next_order) ?></th>
                <th><?= sort_link('payment_status', 'Payment Status', $sort_column, $order, $next_order) ?></th>
                <th>Action</th>
            </tr>

            <?php while ($row = $result->fetch_assoc()) { 
                $status = $row['status'] ?? 'Pending';
                $payment_status = $row['payment_status'] ?? '-';

                // Adjust payment status display
                if ($status == 'Accepted' && $payment_status != 'Paid') {
                    $payment_status = 'Not Paid';
                } elseif ($status == 'Paid') {
                    $payment_status = 'Paid';
                } elseif (in_array($status, ['Pending', 'User Cancelled', 'Rejected'])) {
                    $payment_status = '-';
                }
            ?>
                <tr>
                    <td><?= htmlspecialchars($row['user_name']) ?></td>
                    <td><?= htmlspecialchars($row['location']) ?></td>
                    <td><?= htmlspecialchars($row['room_type']) ?></td>
                    <td><?= htmlspecialchars($row['checkin_date']) ?></td>
                    <td><?= htmlspecialchars($row['checkout_date']) ?></td>
                    <td><?= htmlspecialchars($row['booking_time']) ?></td>
                    <td>₹<?= htmlspecialchars($row['total_price']) ?></td>
                    <td class="<?= strtolower(str_replace(' ', '-', $status)) ?>">
                        <?= htmlspecialchars($status) ?>
                    </td>
                    <td class="<?= strtolower(str_replace(' ', '-', $payment_status)) ?>">
                        <?= htmlspecialchars($payment_status) ?>
                    </td>
                    <td>
                        <?php if ($status == 'Pending') { ?>
                            <a href="cancel_booking.php?id=<?= $row['id'] ?>" onclick="return confirm('Cancel this booking?')">Cancel</a>
                        <?php } elseif ($status == 'Accepted' && $payment_status == 'Not Paid') { ?>
                            <a href="payment.php?booking_id=<?= $row['id'] ?>">Proceed to Payment</a>
                        <?php } elseif ($payment_status == 'Paid') { ?>
                            <a href="generate_invoice.php?booking_id=<?= $row['id'] ?>" target="_blank">Download Invoice</a>
                        <?php } else { ?>
                            -
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
    <?php else: ?>
        <div style="text-align: center; margin: 50px auto; padding: 20px; border: 2px solid #ccc; border-radius: 10px; background-color: #f9f9f9; max-width: 600px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);">
            <p style="font-size: 18px; color:rgb(255, 0, 0);">No booking history found.</p>
            <a href="book_room.php" style="display: inline-block; padding: 10px 20px; background-color: #0056b3; color: white; font-weight: bold; text-decoration: none; border-radius: 5px; transition: 0.3s;" onmouseover="this.style.backgroundColor='#004085'" onmouseout="this.style.backgroundColor='#0056b3'">Book a Room</a>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
